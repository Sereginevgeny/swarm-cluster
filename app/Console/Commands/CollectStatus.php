<?php
declare(strict_types=1);

namespace App\Console\Commands;

use App\Service\PollSummaryService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

/**
 * Class CollectStatus
 *
 * @package App\Console\Commands
 */
class CollectStatus extends Command
{
    protected $signature = 'polls:collect:status';

    public function handle(PollSummaryService $summaryService)
    {
        try {
            $summaryService->collect();
        } catch (\Throwable $exception) {
            Log::alert(sprintf('Failed to collect polls summary: [%s]', $exception->getMessage()));

            return 1;
        }

        $this->output->success('Summary updated');
    }
}
