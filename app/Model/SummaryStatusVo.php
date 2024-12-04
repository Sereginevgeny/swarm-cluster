<?php
declare(strict_types=1);

namespace App\Model;

use Illuminate\Contracts\Support\Arrayable;

/**
 * Class SummaryStatusVo
 *
 * @package App\Model
 */
class SummaryStatusVo implements Arrayable
{
    /**
     * @var int
     */
    private $polls;

    /**
     * @var int
     */
    private $votes;

    /**
     * @var int
     */
    private $users;

    /**
     * @var PollResultsVo
     */
    private $topRated;

    /**
     * SummaryStatusVo constructor.
     *
     * @param int                $polls
     * @param int                $votes
     * @param int                $users
     * @param PollResultsVo|null $topRated
     */
    public function __construct(int $polls, int $votes, int $users, ?PollResultsVo $topRated)
    {
        $this->polls    = $polls;
        $this->votes    = $votes;
        $this->users    = $users;
        $this->topRated = $topRated;
    }


    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'polls'          => $this->polls,
            'votes'          => $this->votes,
            'users'          => $this->users,
            'top_rated_poll' => isset($this->topRated) ? $this->topRated->toArray() : null,
        ];
    }
}
