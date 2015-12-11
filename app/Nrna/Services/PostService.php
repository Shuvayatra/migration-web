<?php
namespace App\Nrna\Services;

use App\Nrna\Models\Post;
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

    /**
     * @return array
     */
    public function latest()
    {
        $postArray = [];
        $posts     = $this->post->latest();
        foreach ($posts as $post) {
            $postArray[] = $this->buildPost($post);
        }

        return $postArray;
    }

    /**
     * @param Post $post
     * @return array
     */
    public function buildPost(Post $post)
    {
        $postArray['id']         = $post->id;
        $postArray['created_at'] = $post->created_at->timestamp;
        $postArray['updated_at'] = $post->updated_at->timestamp;
        $tags                    = [];
        foreach ($post->tags as $tag) {
            $tags[] = $tag->title;
        }
        $postArray['tags'] = $tags;

        $questions = [];
        foreach ($post->questions as $question) {
            $questions[] = $question->id;
        }
        $postArray['question_ids'] = $questions;

        return array_merge($postArray, (array) $post->metadata);
    }

}