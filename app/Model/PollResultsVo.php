<?php
declare(strict_types=1);

namespace App\Model;

use Illuminate\Contracts\Support\Arrayable;

/**
 * Class PollResultsVo
 *
 * @package App\Model
 */
class PollResultsVo implements Arrayable
{
    /**
     * @var Poll
     */
    private $poll;

    /**
     * PollResultsVo constructor.
     *
     * @param Poll $poll
     */
    public function __construct(Poll $poll)
    {
        $this->poll = $poll;
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return array_merge(
            $this->poll->attributesToArray(),
            [
                'options'     => $this->poll->options()->get()->map(function (Option $option) {
                    return array_merge(
                        $option->attributesToArray(),
                        [
                            'votes' => $option->votes()->count(),
                        ]
                    );
                }),
                'total_votes' => $this->poll->votes()->count(),
            ]
        );
    }
}
