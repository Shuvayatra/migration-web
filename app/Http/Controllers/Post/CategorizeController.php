<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Nrna\Services\PostService;
use App\Http\Requests\PostRequest;
use App\Nrna\Services\RssService;
use Illuminate\Http\Request;

class CategorizeController extends Controller
{
    /**
     * @var PostService
     */
    private $post;
    /**
     * @var RssService
     */
    private $rss;

    /**
     * constructor
     *
     * @param PostService $post
     * @param RssService  $rss
     */
    public function __construct(PostService $post)
    {
        $this->middleware('auth');
        $this->post = $post;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $posts = $this->post->all($request->all());

        return view('post.categorize', compact('posts'));
    }

    public function update(Request $request)
    {
        $data = $request->all();
        $post = $this->post->find($data['post_id']);
        $post->categories()->sync($data['data']);

        return ['success' => true];
    }
}
