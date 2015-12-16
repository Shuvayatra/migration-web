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
        return $this->post->with('tags', 'questions', 'countries')->findOrFail($id);
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
     * @param $filter
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function latest($filter)
    {
        $filter = array_only($filter, ['updated_at']);
        $query  = $this->post->with('tags', 'questions', 'countries')->where(
            function ($q) use ($filter) {
                foreach ($filter as $key => $value) {
                    $q->where($key, '>', $value);
                }
            }
        );

        return $query->get();
    }
}