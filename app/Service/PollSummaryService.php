<?php
declare(strict_types=1);

namespace App\Service;

use App\Exceptions\RuntimeException;
use App\Model\Poll;
use App\Model\PollResultsVo;
use App\Model\SummaryStatusVo;
use App\Model\Vote;
use Illuminate\Redis\Connections\Connection;
use Illuminate\Redis\Connections\PhpRedisConnection;
use Illuminate\Support\Facades\DB;
use Psr\Log\LoggerInterface;

/**
 * Class PollSummaryService
 *
 * @package App\Service
 */
class PollSummaryService
{
    private const CACHE_NS         = 'poll:summary';
    private const RANDOM_FACTOR    = 'poll:summary:random:factor';
    private const FACTOR_THRESHOLD = 15;

    /**
     * @var PollManageService
     */
    private $crud;

    /**
     * @var Connection|PhpRedisConnection
     */
    private $redis;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * PollSummaryService constructor.
     *
     * @param PollManageService             $crud
     * @param Connection|PhpRedisConnection $redis
     * @param LoggerInterface               $logger
     */
    public function __construct(PollManageService $crud, $redis, LoggerInterface $logger)
    {
        $this->crud   = $crud;
        $this->redis  = $redis;
        $this->logger = $logger;
    }

    /**
     * @param $id
     *
     * @return PollResultsVo
     */
    public function results($id): PollResultsVo
    {
        return new PollResultsVo($this->crud->find($id));
    }

    /**
     * @throws RuntimeException
     */
    public function collect(): void
    {
        $this->redis->del(static::CACHE_NS);

        $status = [
            'polls'     => Poll::query()->count(),
            'votes'     => Vote::query()->count(),
            'users'     => Vote::query()->distinct()->count(['username']),
            'top_rated' => $this->topRatedPoll()->id,
        ];

        $this->redis->hmset(static::CACHE_NS, $status);
    }

    /**
     * @return SummaryStatusVo
     * @throws RuntimeException
     */
    public function status(): SummaryStatusVo
    {
        $values = $this->getSummaryCache();

        if (empty($values)) {
            $values = [
                'polls'     => 0,
                'votes'     => 0,
                'users'     => 0,
                'top_rated' => null,
            ];
        }

        return new SummaryStatusVo(...array_map(function ($value, $key) {
            if ($key !== 'top_rated') {
                return (int) $value;
            }

            try {
                return new PollResultsVo($this->crud->find($value));
            } catch (\Throwable $exception) {
                return null;
            }
        }, $values, array_keys($values)));
    }

    /**
     * @return \stdClass [.id] as poll ID
     * @throws RuntimeException
     */
    private function topRatedPoll(): \stdClass
    {
        $topRatedQuery = <<<SQL
SELECT p.id, COUNT(DISTINCT v.id) as votes FROM polls p 
JOIN votes v ON p.id = v.poll_id
GROUP BY p.id
ORDER BY votes DESC 
LIMIT 1
SQL;

        return DB::selectOne($topRatedQuery);
    }

    /**
     * @return array
     */
    private function getSummaryCache(): array
    {
        $factor = $this->redis->incr(static::RANDOM_FACTOR);
        $values = $this->redis->hGetAll(static::CACHE_NS);

        if ($factor >= static::FACTOR_THRESHOLD) {
            $this->redis->del(static::RANDOM_FACTOR);
        }

        return $values;
    }
}
