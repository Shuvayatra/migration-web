<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiBaseController;
use App\Http\Requests;
use App\Nrna\Services\ApiService;

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
     * @return json
     */
    public function index()
    {
        $data = $this->api->latest();

        return $this->respond($data);
    }
}