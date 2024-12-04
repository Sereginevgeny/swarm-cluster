<?php
declare(strict_types=1);

namespace App\Service;

use App\Model\Option;
use App\Model\PollResultsVo;
use App\Model\Vote;
use App\Model\VoteVo;

/**
 * Class VotingService
 *
 * @package App\Service
 */
class VotingService
{
    /**
     * @var PollManageService
     */
    private $crud;

    /**
     * VotingService constructor.
     *
     * @param PollManageService $crud
     */
    public function __construct(PollManageService $crud)
    {
        $this->crud = $crud;
    }

    public function vote($id, VoteVo $vote): PollResultsVo
    {
        $poll = $this->crud->find($id);

        /** @var Option $option */
        $option = $poll->options()->findOrFail($vote->getOption());

        $voteModel = new Vote(['username' => $vote->getUsername()]);
        $voteModel->poll()->associate($poll);
        $voteModel->option()->associate($option);
        $voteModel->save();

        return new PollResultsVo($this->crud->find($id));
    }
}
