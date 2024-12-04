<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Service\PollSummaryService;
use Illuminate\Support\Facades\Log;

/**
 * Class PollSummaryController
 *
 * @package App\Http\Controllers
 */
class PollSummaryController
{
    /**
     * @var PollSummaryService
     */
    private $summary;

    /**
     * PoolSummaryController constructor.
     *
     * @param PollSummaryService $summary
     */
    public function __construct(PollSummaryService $summary)
    {
        $this->summary = $summary;
    }

    public function results($id)
    {
        return $this->summary->results($id);
    }

    public function summary()
    {
        try {
            $status = $this->summary->status();
        } catch (\Throwable $exception) {
            Log::emergency($exception->getMessage());
            throw $exception;
        }

        return $status;
    }
}
