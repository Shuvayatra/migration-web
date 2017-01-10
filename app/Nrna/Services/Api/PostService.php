<?php
namespace App\Nrna\Services\Api;

use App\Nrna\Models\Post;
use App\Nrna\Repositories\Post\PostRepository;
use App\Nrna\Services\CategoryService;
use App\Nrna\Services\GoogleTranslator;
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
     * @var CategoryService
     */
    private $category;

    /**
     * MainPostService constructor.
     *
     * @param PostService|MainPostService $post
     * @param PostRepository              $postRepo
     * @param Post                        $postModel
     * @param CategoryService             $category
     */
    public function __construct(
        MainPostService $post,
        PostRepository $postRepo,
        Post $postModel,
        CategoryService $category
    ) {
        $this->post      = $post;
        $this->postRepo  = $postRepo;
        $this->postModel = $postModel;
        $this->category  = $category;
    }

    /**
     * list of post
     *
     * @param array $filter
     *
     * @return array
     */
    public function all($filter = [])
    {
        if (array_has($filter, "category")) {
            $category_ids = [];
            $categories   = explode(',', $filter['category']);
            foreach ($categories as $category_id) {
                $category       = $this->category->find($category_id);
                $category_ids[] = $category->getDescendantsAndSelf()->lists('id')->toArray();
            }
            $category_ids = array_unique(array_flatten($category_ids));
            $posts        = $this->postRepo->getByCategoryId($category_ids, true);
        } elseif (array_has($filter, "tag")) {
            $posts = $this->postRepo->getByTags($filter['tag'], true);
        } elseif (array_has($filter, "query")) {
            $query = $this->processSearchQuery($filter['query']);
            $posts = $this->postRepo->search($query, true, 0.5);
        } else {
            $posts = $this->postRepo->all($filter);
        }
        $postArray = [];
        foreach ($posts as $post) {
            $postArray[] = $this->formatPost($post);
        }
        $posts    = $posts->toArray();
        $response = array_except($posts, 'data');

        $response['data'] = $postArray;

        return $response;
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

    /**
     * post detail with similar post
     *
     * @param Post $post
     *
     * @return array
     */
    public function formatPostWithSimilar(Post $post)
    {
        $postArray        = $this->formatPost($post);
        $similarPostArray = [];
        foreach ($post->similar as $post_model) {
            $similarPostArray[] = $this->formatPost($post_model);
        }
        $similarPostsArray = [];
        foreach ($post->similar_posts as $post) {
            $similarPostsArray[] = $this->formatPost($post);
        }
        $postArray['similar']       = $similarPostArray;
        $postArray['similar_posts'] = $similarPostsArray;

        return $postArray;
    }

    /**
     * post detail
     *
     * @param $id
     *
     * @return array
     */
    public function find($id)
    {
        $post = $this->postModel->find($id);

        return $this->formatPost($post);
    }

    /**
     * change search String to nepali
     *
     * @param $string
     *
     * @return null
     */
    private function processSearchQuery($string)
    {
        if (strlen($string) == mb_strlen($string, 'utf-8')) {
            $googleService = new GoogleTranslator;

            return $googleService->setSourceLang('en')->setTargetLang('ne')->translate($string);
        }

        return $string;
    }

    public function news()
    {
        $posts     = $this->postModel->category(144)->orderBy('created_at', 'desc')->paginate();
        $postArray = [];
        foreach ($posts as $post) {
            $postArray[] = $this->formatPost($post);
        }
        $posts         = $posts->toArray();
        $posts['data'] = $postArray;

        return $posts;
    }
}