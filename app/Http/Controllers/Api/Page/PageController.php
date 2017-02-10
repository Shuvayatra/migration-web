<?php

namespace App\Http\Controllers\Api\Page;

use App\Http\Controllers\Controller;
use App\Nrna\Models\Page;
use EllipseSynergie\ApiResponse\Laravel\Response;

class PageController extends Controller
{
    /**
     * @var Response
     */
    private $response;

    /**
     * PageController constructor.
     *
     * @param Response $response
     */
    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    /**
     * Display a listing of the resource.
     *
     * @param $slug
     */
    public function index($slug)
    {
        $page = Page::whereSlug($slug)->selectRaw('slug as title,content')->first();
        if (!$page) {
            return $this->response->errorNotFound();
        }

        return $page;
    }
}
