<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Request\VoteRequest;
use App\Service\VotingService;

/**
 * Class VoteController
 *
 * @package App\Http\Controllers
 */
class VoteController extends Controller
{
    /**
     * @var VotingService
     */
    private $handler;

    /**
     * VoteController constructor.
     *
     * @param VotingService $handler
     */
    public function __construct(VotingService $handler)
    {
        $this->handler = $handler;
    }

    public function vote($id, VoteRequest $request)
    {
        return $this->handler->vote($id, $request->values());
    }
}
