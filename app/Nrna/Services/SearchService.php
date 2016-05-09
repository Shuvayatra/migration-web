<?php
namespace App\Nrna\Services;

/**
 * Class SearchService
 * @package App\Nrna\Services
 */
class SearchService
{
    /**
     * @var PostService
     */
    protected $post;
    /**
     * @var CategoryService
     */
    protected $category;

    /**
     * @param PostService     $post
     * @param CategoryService $category
     */
    public function __construct(PostService $post, CategoryService $category)
    {
        $this->post     = $post;
        $this->category = $category;
    }

    /**
     * @param $query
     * @return Search
     */
    public function search($query)
    {
        $categoryResults = $this->category->search($query);
        $postResults     = $this->post->search($query);

        return $this->post->search($query);
    }

}
