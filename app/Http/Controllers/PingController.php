<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Service\PingService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class PingController
 *
 * @package App\Http\Controllers
 */
class PingController extends Controller
{
    /**
     * @var PingService
     */
    private $service;

    /**
     * PingController constructor.
     *
     * @param PingService $service
     */
    public function __construct(PingService $service)
    {
        $this->service = $service;
    }

    public function ping(Request $request)
    {
        if (!$pong = $this->service->ping($request)) {
            return new Response('', 503);
        }

        return new Response('pong', 200);
    }
}
