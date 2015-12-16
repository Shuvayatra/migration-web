<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiBaseController;
use App\Http\Requests;
use App\Nrna\Services\ApiService;
use Illuminate\Http\Request;

class LatestController extends ApiBaseController
{
    /**
     * @var ApiService
     */
    private $api;

    /**
     * @param ApiService $api
     */
    function __construct(ApiService $api)
    {
        $this->api = $api;
    }


    /**
     * latest context pull api.
     *
     * @param Request $request
     * @return json
     */
    public function index(Request $request)
    {
        $data = $this->api->latest($request->all());

        return $this->respond($data);
    }
}