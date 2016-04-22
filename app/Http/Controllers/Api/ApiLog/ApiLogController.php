<?php

namespace App\Http\Controllers\Api\ApiLog;

use App\Nrna\Services\ApiLogService;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ApiLogController extends Controller
{
    /**
     * @var ApiLogService
     */
    protected $apiLogService;

    /**
     * ApiLogController constructor.
     * @param ApiLogService $apiLogService
     */
    public function __construct(ApiLogService $apiLogService)
    {
        $this->apiLogService = $apiLogService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $apiLogs = $this->apiLogService->getList();

        return view('apilog.index', compact('apiLogs'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $log = $this->apiLogService->find($id);

        return view('apilog.show', compact('log'));
    }


}
