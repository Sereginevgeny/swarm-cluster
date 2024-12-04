<?php
declare(strict_types=1);

namespace App\Service;

use Illuminate\Http\Request;
use Psr\Log\LoggerInterface;
use UnexpectedValueException;

/**
 * Class PingService
 *
 * @package App\Service
 */
class PingService
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * PingService constructor.
     *
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function ping(Request $request): bool
    {
        try {
            $this->logger->info('Healthcheck request registered', ['request' => (string)$request]);
        } catch (UnexpectedValueException $exception) {
            error_log(sprintf('Unexpected error: (%s)', $exception->getMessage()), E_USER_NOTICE);

            return false;
        }

        return true;
    }
}
