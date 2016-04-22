<?php

namespace App\Http\Middleware;

use App\Nrna\Services\ApiLogService;
use Closure;

class StoreApiLog
{
    /**
     * @var ApiLogService
     */
    protected $apiLogService;

    /**
     * StoreApiLog constructor.
     * @param ApiLogService $apiLogService
     */
    public function __construct(ApiLogService $apiLogService)
    {

        $this->apiLogService = $apiLogService;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        $this->storeApiLog($request, $response);

        return $response;
    }

    protected function storeApiLog($request, $response)
    {
        $logDetails = [
            'request_url'  => $request->fullUrl(),
            'request_data' => json_encode($request->all(), true),
            'response'     => $response->content(),
            'status'       => $response->status(),
            'method'       => $request->method(),
            'host'         => $request->ip(),
            'header'       => json_encode($request->header())
        ];
        $this->apiLogService->saveLog($logDetails);
    }
}
