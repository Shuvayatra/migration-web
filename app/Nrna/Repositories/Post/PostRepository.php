<?php
namespace App\Nrna\Repositories\Post;

use App\Nrna\Models\Post;

/**
 * Class PostRepository
 * @package App\Nrna\Repository\Post
 */
class PostRepository implements PostRepositoryInterface
{
    /**
     * @var Post
     */
    private $post;

    /**
     * constructor
     * @param Post $post
     */
    function __construct(Post $post)
    {
        $this->post = $post;
    }


    /**
     * Save Post
     * @param $data
     * @return Post
     */
    public function save($data)
    {
        return $this->post->create($data);
    }

    /**
     * @param null $limit
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAll($limit = null)
    {
        if (is_null($limit)) {
            return $this->post->all();
        }

        return $this->post->paginate();
    }

    /**
     * @param $id
     * @return Post
     */
    public function find($id)
    {
        return $this->post->findOrFail($id);
    }

    /**
     * @param $data
     * @return bool|int
     */
    public function update($data)
    {
        return $this->post->update($data);
    }

    /**
     * @param $id
     * @return int
     */
    public function delete($id)
    {
        return $this->post->destroy($id);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function latest()
    {
        return $this->post->with('tags', 'questions', 'countries')->get();
    }
}