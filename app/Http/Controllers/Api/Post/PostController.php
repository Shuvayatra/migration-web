<?php
namespace App\Http\Controllers\Api\Post;

use App\Nrna\Services\Api\PostService;
use Chrisbjr\ApiGuard\Http\Controllers\ApiGuardController;
use Illuminate\Http\Request;
use EllipseSynergie\ApiResponse\Laravel\Response;

class PostController extends ApiGuardController
{
    /**
     * @var
     */
    protected $postService;
    protected $apiMethods = [
        'index'  => [
            'keyAuthentication' => false,
        ],
        'detail' => [
            'keyAuthentication' => false,
        ],
    ];

    /**
     * PostController constructor.
     *
     * @param PostService $postService
     * @param Response    $response
     */
    public function __construct(PostService $postService, Response $response)
    {
        parent::__construct();
        $this->postService = $postService;
    }

    /**
     * get all posts
     * @return \Illuminate\Contracts\Routing\ResponseFactory|mixed
     */
    public function index()
    {
        $response = $this->postService->all(request()->all());
        if ($response) {
            return $this->response->withArray($response);
        }

        return $this->response->errorInternalError();
    }

    /**
     * post detail
     *
     * @param $id
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|mixed
     */
    public function detail($id)
    {
        $response = $this->postService->find($id);
        if ($response) {
            return $this->response->withArray($response);
        }

        return $this->response->errorInternalError();

    }

    /**
     * updates likes,views and share count
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|mixed
     */
    public function sync(Request $request)
    {
        $response = $this->postService->sync($request->all());
        if ($response) {
            return $this->response->withArray($response);
        }

        return $this->response->errorInternalError();
    }

    /**
     * detail for post
     *
     * @param $id
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory
     *
     */
    public function show($id)
    {
        if ($post = $this->postService->find($id)) {
            $data = $this->postService->buildPost($post, true);

            return $this->response->withArray($data);
        }

        return $this->response->errorNotFound();
    }
}