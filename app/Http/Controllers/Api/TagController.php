<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Nrna\Services\TagService;
use EllipseSynergie\ApiResponse\Laravel\Response;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * @var TagService
     */
    private $tag;

    private $response;

    /**
     * @param TagService $tag
     * @param Response   $response
     *
     */
    public function __construct(TagService $tag, Response $response)
    {
        $this->response = $response;
        $this->tag      = $tag;
    }

    /**
     * latest context pull api.
     *
     * @param  Request $request
     *
     * @return json
     */
    public function index(Request $request)
    {
        $data = $this->tag->getList()->toArray();

        if (!$data) {
            return $this->response->errorInternalError();
        }

        return $this->response->withArray(array_values($data));
    }
}
