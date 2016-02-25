<?php
namespace App\Nrna\Repositories\Post;

use App\Nrna\Models\Post;
use Illuminate\Database\DatabaseManager;

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
     * @var DatabaseManager
     */
    private $db;

    /**
     * constructor
     * @param Post            $post
     * @param DatabaseManager $db
     */
    public function __construct(Post $post ,  DatabaseManager $db)
    {
        $this->post = $post;
        $this->db = $db;
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
     * @param       $filters
     * @param  null $limit
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAll($filters, $limit = null)
    {
        $query         = $this->post->select('*');
        $from          = "posts ";
        if(isset($filters['stage']) && $filters['stage'] != ''){
            $stages =  $filters['stage'];
            $from .= ",json_array_elements(posts.metadata->'stage') stage";
            $query->whereRaw("trim(both '\"' from stage::text) = ?", [$stages]);
        }

        if(isset($filters['post_type']) && $filters['post_type'] != ''){
            $post_type =  $filters['post_type'];
            $query->whereRaw("posts.metadata->>'type' = ?", [$post_type]);
        }

        $query->from($this->db->raw($from));
        $query->orderBy('id', 'DESC');
        if (is_null($limit)) {
            return $query->all();
        }

        return $query->paginate();
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

    /**
     * @param $filter
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function deleted($filter)
    {
        $filter = array_only($filter, ['deleted_at']);
        $query  = $this->post->onlyTrashed()->where(
            function ($q) use ($filter) {
                foreach ($filter as $key => $value) {
                    $q->where($key, '>', $value);
                }
            }
        );

        return $query->get(['id', 'deleted_at']);
    }
}
