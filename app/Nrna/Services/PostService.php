<?php
namespace App\Nrna\Services;

use App\Nrna\Repositories\Post\PostRepositoryInterface;

/**
 * Class PostService
 * @package App\Nrna\Services
 */
class PostService
{
    /**
     * @var PostRepositoryInterface
     */
    private $post;

    /**
     * constructor
     * @param PostRepositoryInterface $post
     */
    function __construct(PostRepositoryInterface $post)
    {
        $this->post = $post;
    }

    /**
     * @param $formData
     * @return Post|bool
     */
    public function save($formData)
    {
        if ($post = $this->post->save($formData)) {
            $post->tags()->sync($formData['tag']);
            $post->countries()->sync($formData['country']);
            $post->questions()->sync($formData['question']);

            return $post;
        }

        return false;
    }


    /**
     * @param int $limit
     * @return Collection
     */
    public function all($limit = 15)
    {
        return $this->post->getAll($limit);
    }

    /**
     * @param $id
     * @return Post
     */
    public function find($id)
    {
        try {
            return $this->post->find($id);
        } catch (\Exception $e) {
            return null;
        }

        return null;
    }

    /**
     * @param $id
     * @param $formData
     * @return bool
     */
    public function update($id, $formData)
    {
        $post = $this->find($id);

        if ($post->update($formData)) {
            $post->tags()->sync($formData['tag']);
            $post->countries()->sync($formData['country']);
            $post->questions()->sync($formData['question']);

            return $post;
        }

        return false;
    }

    /**
     * @param $id
     * @return int
     */
    public function delete($id)
    {
        return $this->post->delete($id);
    }

}