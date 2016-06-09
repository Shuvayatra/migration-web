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