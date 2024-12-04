<?php
declare(strict_types=1);

namespace App\Service;

use App\Model\Poll;
use App\Model\PollVo;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Class PollManageService
 *
 * @package App\Service
 */
class PollManageService
{
    /**
     * @param PollVo $data
     *
     * @return Poll
     */
    public function create(PollVo $data): Poll
    {
        $pool = new Poll(['question' => $data->getQuestion()]);
        $pool->save();

        foreach ($data->getOptions() as $option) {
            $pool->options()->create(['option' => $option]);
        }

        return $pool;
    }

    /**
     * @param        $id
     * @param PollVo $data
     *
     * @return Poll
     */
    public function update($id, PollVo $data): Poll
    {
        /** @var Poll $pool */
        $pool = $this->find($id);
        $pool->options()->delete();

        foreach ($data->getOptions() as $option) {
            $pool->options()->create(['option' => $option]);
        }

        $pool->question = $data->getQuestion();
        $pool->save();

        return $pool;
    }

    /**
     * @param $id
     *
     * @throws \Exception
     */
    public function remove($id): void
    {
        /** @var Poll $pool */
        $pool = $this->find($id);
        $pool->delete();
    }

    /**
     * @param $id
     *
     * @return Poll
     */
    public function find($id): Poll
    {
        return Poll::query()->findOrFail($id);
    }

    /**
     * @param int $perPage
     *
     * @return Poll[]|LengthAwarePaginator
     */
    public function fetch($perPage = 15): LengthAwarePaginator
    {
        return Poll::query()->paginate($perPage);
    }
}
