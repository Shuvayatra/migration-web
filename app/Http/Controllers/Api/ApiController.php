<?php

namespace App\Http\Controllers\Api;

use App\Nrna\Services\ApiService;
use Chrisbjr\ApiGuard\Http\Controllers\ApiGuardController;
use EllipseSynergie\ApiResponse\Laravel\Response;
use Illuminate\Http\Request;

class ApiController extends ApiGuardController
{
    /**
     * @var ApiService
     */
    private $api;

    protected $apiMethods = [
        'getDeleted' => [
            'keyAuthentication' => false,
        ],
    ];

    /**
     * @param ApiService $api
     * @param Response   $response
     */
    public function __construct(ApiService $api, Response $response)
    {
        parent::__construct();
        $this->api      = $api;
        $this->response = $response;
    }

    /**
     * latest context pull api.
     *
     * @param  Request $request
     * @return json
     */
    public function getDeleted(Request $request)
    {
        $data = $this->api->deleted($request->all());
        if (!$data) {
            return $this->response->errorInternalError();
        }

        return $this->response->withArray($data);
    }
}
