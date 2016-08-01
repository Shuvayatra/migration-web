<?php
namespace App\Http\Controllers\Api\Post;

use App\Nrna\Services\Api\PostService;
use App\Nrna\Services\PostService as Post;
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
     * @var Post
     */
    private $post;

    /**
     * PostController constructor.
     *
     * @param PostService $postService
     * @param Response    $response
     * @param Post        $post
     */
    public function __construct(PostService $postService, Response $response, Post $post)
    {
        parent::__construct();
        $this->postService = $postService;
        $this->post        = $post;
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
     * updates likes,views and share count
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|mixed
     */
    public function sync(Request $request)
    {
        $response = $this->post->sync($request->all());
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
        if ($post = $this->post->find($id)) {
            $data = $this->post->buildPost($post);

            return $this->response->withArray($data);
        }

        return $this->response->errorNotFound();
    }

    /**
     * detail for post
     *
     * @param $id
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory
     *
     */
    public function detail($id)
    {
        if ($post = $this->post->find($id)) {
            $data = $this->postService->formatPostWithSimilar($post);

            return $this->response->withArray($data);
        }

        return $this->response->errorNotFound();
    }
}