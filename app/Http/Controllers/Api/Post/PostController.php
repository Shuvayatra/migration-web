<?php
namespace App\Http\Controllers\Api\Post;

use App\Nrna\Services\PostService;
use Chrisbjr\ApiGuard\Http\Controllers\ApiGuardController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PostController extends ApiGuardController
{
    /**
     * @var
     */
    protected $postService;

    /**
     * PostController constructor.
     * @param PostService $postService
     */
    public function __construct(PostService $postService, Response $response)
    {
        parent::__construct();
        $this->postService = $postService;
    }

    public function likes(Request $request)
    {
        $likes = $this->postService->likes($request->all());
        if ($likes) {
            return $this->response->withArray($likes);
        }

        return $this->response->errorInternalError();

    }
}