<?php
namespace App\Nrna\Services\Api;

use App\Nrna\Models\Post;
use App\Nrna\Repositories\Post\PostRepository;
use App\Nrna\Services\PostService as MainPostService;

class PostService
{
    /**
     * @var PostService
     */
    private $post;
    /**
     * @var PostRepository
     */
    private $postRepo;
    /**
     * @var Post
     */
    private $postModel;

    /**
     * MainPostService constructor.
     *
     * @param PostService|MainPostService $post
     * @param PostRepository              $postRepo
     * @param Post                        $postModel
     */
    public function __construct(MainPostService $post, PostRepository $postRepo, Post $postModel)
    {
        $this->post      = $post;
        $this->postRepo  = $postRepo;
        $this->postModel = $postModel;
    }

    /**
     * write brief description
     *
     * @param array $filter
     *
     * @return array
     */
    public function all($filter = [])
    {
        $postArray = [];
        $posts     = $this->postRepo->latest($filter);
        foreach ($posts as $post) {
            $postArray[] = $this->formatPost($post);
        }

        return $postArray;
    }

    /**
     * write brief description
     *
     * @param Post $post
     *
     * @return array
     */
    public function formatPost(Post $post)
    {
        $post->load('categories');
        $postArray['id']          = $post->id;
        $postArray                = array_merge($postArray, (array) $post->apiMetadata);
        $postArray['like_count']  = $post->likes;
        $postArray['view_count']  = (int) $post->view_count;
        $postArray['share_count'] = (int) $post->share_count;
        $postArray['tags']        = $post->tags->lists('title')->toArray();
        $postArray['categories']  = $post->categories->lists('title')->toArray();
        $postArray['category']    = $post->main_category;
        $postArray['created_at']  = $post->created_at->timestamp;
        $postArray['updated_at']  = $post->updated_at->timestamp;

        return $postArray;
    }

    public function find($id)
    {
        $post = $this->postModel->find($id);

        return $this->formatPost($post);
    }
}