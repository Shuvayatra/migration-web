<?php
namespace App\Http\Controllers\Api\Post;

use App\Nrna\Services\Api\PostRssService;
use App\Nrna\Services\Api\PostService;
use App\Nrna\Services\BlockService;
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
     * @var BlockService
     */
    private $blockService;

    /**
     * PostController constructor.
     *
     * @param PostService  $postService
     * @param Response     $response
     * @param Post         $post
     * @param BlockService $blockService
     */
    public function __construct(PostService $postService, Response $response, Post $post, BlockService $blockService)
    {
        parent::__construct();
        $this->postService  = $postService;
        $this->post         = $post;
        $this->blockService = $blockService;
    }

    /**
     * get all posts
     *
     * @param PostRssService $rssService
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|mixed
     */
    public function index(PostRssService $rssService)
    {
        if (request()->has('block_id')) {
            return $this->blockService->getBlockPosts(request()->get('block_id'));
        }
        $response = $this->postService->all(request()->all());
        if (request()->has('type') && request()->get('type') == "xml") {
            $rss = $rssService->buildRssData($response);

            return response($rss)
                ->header('Content-type', 'application/rss+xml; charset=utf-8');
        }

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

            $this->post->increaseViewCount($id, 1);

            return $this->response->withArray($data);
        }

        return $this->response->errorNotFound();
    }

    /**
     * increase/decrease favorite count
     *
     * @param         $postId
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|mixed
     */
    public function favorite($postId, Request $request)
    {
        if (!$request->has('type')) {
            return $this->response->errorWrongArgs();
        }

        if (!$this->post->find($postId)) {
            return $this->response->errorNotFound();
        }
        if ($request->get('type') == "up") {
            $this->post->modifyLikes($postId, 'increment');

            return $this->response->withArray(['status' => 'success']);
        }
        if ($request->get('type') == "down") {
            $this->post->modifyLikes($postId, 'decrement');

            return $this->response->withArray(['status' => 'success']);
        }

        return $this->response->errorWrongArgs();
    }

    /**
     * increase share count
     *
     * @param $postId
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|mixed
     */
    public function share($postId)
    {
        if (!$this->post->find($postId)) {
            return $this->response->errorWrongArgs();
        }
        if ($post = $this->post->increaseShareCount($postId, 1)) {
            return $this->response->withArray(['status' => 'success']);
        }

        return $this->response->errorInternalError();
    }
}