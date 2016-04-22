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
     * @param $data
     * @return Post
     */
    public function save($data);

    /**
     * @param $limit
     * @return Collection
     */
    public function getAll($filter,$limit = null);

    /**
     * @param $id
     * @return Post
     */
    public function find($id);

    /**
     * @param $data
     * @return bool|int
     */
    public function update($data);

    /**
     *
     * @param $filter
     * @return Collection
     */
    public function latest($filter);

    /**
     * @param $id
     * @return int
     */
    public function delete($id);

    /**
     * @param $filter
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function deleted($filter);

    /**
     * @param $postId
     * @return mixed
     */
    public function getLikes($postId);
    /**
     * @param $postId
     * @return mixed
     */
    public function incrementLikes($postId);

    /**
     * @param $postId
     * @return mixed
     */
    public function decrementLikes($postId);

    public function postExistsCheck($ids);
}
