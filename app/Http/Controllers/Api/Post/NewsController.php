<?php
namespace App\Http\Controllers\Api\Post;

use App\Nrna\Services\Api\PostRssService;
use App\Nrna\Services\Api\PostService;
use App\Nrna\Services\PostService as Post;
use Chrisbjr\ApiGuard\Http\Controllers\ApiGuardController;
use Illuminate\Http\Request;
use EllipseSynergie\ApiResponse\Laravel\Response;

class NewsController extends ApiGuardController
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
     *
     * @param PostRssService $rssService
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|mixed
     */
    public function index(PostRssService $rssService)
    {
        $response = $this->postService->news();

        if ($response) {
            return $this->response->withArray($response);
        }

        return $this->response->errorInternalError();
    }
}