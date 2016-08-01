<?php
namespace App\Http\Controllers\Api\Category;

use App\Http\Controllers\Controller;
use App\Nrna\Services\CategoryService;
use EllipseSynergie\ApiResponse\Laravel\Response;

class CategoryController extends Controller
{
    /**
     * @var
     */
    protected $categoryService;
    /**
     * @var Response
     */
    private $response;

    /**
     * CategoryController constructor.
     *
     * @param CategoryService $categoryService
     * @param Response        $response
     */
    public function __construct(CategoryService $categoryService, Response $response)
    {
        $this->categoryService = $categoryService;
        $this->response        = $response;
    }

    public function index(){
        $categories = $this->categoryService->category();
        if ($categories) {
            return $this->response->withArray($categories);
        }

        return $this->response->errorInternalError();
    }

    /**
     * list of country
     * @return \Illuminate\Contracts\Routing\ResponseFactory|mixed
     */
    public function destination()
    {
        $categories = $this->categoryService->subCategory('country');
        if ($categories) {
            return $this->response->withArray($categories);
        }

        return $this->response->errorInternalError();
    }

    /**
     * list of journey
     * @return \Illuminate\Contracts\Routing\ResponseFactory|mixed
     */
    public function journey()
    {
        $categories = $this->categoryService->subCategory('journey');
        if ($categories) {
            return $this->response->withArray($categories);
        }

        return $this->response->errorInternalError();
    }

    /**
     * Category detail
     *
     * @param $id
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|mixed
     */
    public function show($id)
    {
        $category = $this->categoryService->detail($id);
        if ($category) {
            return $this->response->withArray($category);
        }

        return $this->response->errorInternalError();
    }
}