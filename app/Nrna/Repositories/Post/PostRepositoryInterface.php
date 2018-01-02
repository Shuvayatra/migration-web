<?php
namespace App\Nrna\Repositories\Post;

/**
 * Class PostRepositoryInterface
 * @package App\Nrna\Repository\Post
 */
interface PostRepositoryInterface
{
    /**
     * Save Post
     *
     * @param $data
     *
     * @return Post
     */
    public function save($data);

    /**
     * @param $filter
     * @param $limit
     *
     * @return Collection
     */
    public function getAll($filter, $limit = null);

    /**
     * @param $id
     *
     * @return Post
     */
    public function find($id);

    /**
     * @param $data
     *
     * @return bool|int
     */
    public function update($data);

    /**
     *
     * @param $filter
     *
     * @return Collection
     */
    public function latest($filter);

    /**
     * @param $id
     *
     * @return int
     */
    public function delete($id);

    /**
     * @param $filter
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function deleted($filter);

    /**
     * @param $postId
     *
     * @return mixed
     */
    public function getLikes($postId);

    /**
     * @param $postId
     *
     * @return mixed
     */
    public function incrementLikes($postId);

    /**
     * @param $postId
     * @param $count
     *
     * @return mixed
     */
    public function increaseView($postId, $count);

    /**
     * @param $postId
     * @param $count
     *
     * @return mixed
     */
    public function increaseShare($postId, $count);

    /**
     * @param $post
     * @param $userId
     *
     * @return mixed
     */
    public function changeAuthor($post, $userId);

    /**
     * @param $postId
     *
     * @return mixed
     */
    public function decrementLikes($postId);

    /**
     * @param $ids
     *
     * @return mixed
     */
    public function postExistsCheck($ids);

    /**
     * @return mixed
     */
    public function getAllPosts();

    /**
     * get post by category id
     *
     * @param $category_ids
     *
     * @return mixed
     */
    public function getByCategoryId($category_ids);

    public function search($query);

    public function fullTextSearch($q);
}
