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
    public function __construct(Post $post, DatabaseManager $db)
    {
        $this->post = $post;
        $this->db   = $db;
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

        $query = $this->post->select('*');
        if (!\Entrust::can('manage-all-content')) {
            $query->where('created_by', auth()->user()->id);
        }
        $from = "posts ";
        if (isset($filters['stage']) && $filters['stage'] != '') {
            $stages = $filters['stage'];
            $from .= ",json_array_elements(posts.metadata->'stage') stage";
            $query->whereRaw("trim(both '\"' from stage::text) = ?", [$stages]);
        }

        if (isset($filters['post_type']) && $filters['post_type'] != '') {
            $post_type = $filters['post_type'];
            $query->whereRaw("posts.metadata->>'type' = ?", [$post_type]);
        }

        $query->from($this->db->raw($from));
        $query->orderBy('updated_at', 'DESC');
        if (is_null($limit)) {
            return $query->get();
        }


        return $query->paginate();
    }

    /**
     * @param $id
     * @return Post
     */
    public function find($id)
    {
        return $this->post->with('tags')->find($id);
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
        $query  = $this->post->with('tags')->where(
            function ($q) use ($filter) {
                foreach ($filter as $key => $value) {
                    $q->where($key, '>', $value);
                }
            }
        );

        $query->published();

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

    /**
     * @param $postId
     * @return mixed
     */
    public function getLikes($postId)
    {
        return $this->post->where('id', $postId)->first();
    }

    /**
     * @param $postId
     * @return mixed
     */
    public function incrementLikes($postId)
    {
        return $this->post->where('id', $postId)->increment('likes');
    }

    /**
     * @param $postId
     * @return mixed
     */
    public function decrementLikes($postId)
    {
        return $this->post->where('id', $postId)->decrement('likes');
    }

    /**
     * @param $ids
     * @return mixed
     */
    public function postExistsCheck($ids)
    {
        return $this->post->whereIn('id', $ids)->get(['id']);
    }

    /**
     * @param $ids
     * @return mixed
     */
    public function getByCategoryId($ids)
    {
        $ids = (array) $ids;

        return $this->post->whereHas(
            'categories',
            function ($q) use ($ids) {
                $q->whereIn('id', $ids);
            }
        )->orderBy('id', 'asc')->get();
    }

    /**
     * @param $query
     * @return mixed
     */
    public function search($query)
    {
        return $this->post->whereRaw("to_tsvector(metadata->>'description') @@ plainto_tsquery('" . $query . "')")
                          ->OrWhereRaw("to_tsvector(metadata->>'title') @@ plainto_tsquery('" . $query . "')")
                          ->get();
    }

    /**
     * @param $postId
     * @param $count
     * @return mixed
     */
    public function increaseView($postId, $count)
    {
        $post             = $this->post->find($postId);
        $post->view_count = $post->view_count + $count;
        $post->save();

        return $post;
    }

    /**
     * @param $postId
     * @param $count
     * @return mixed
     */
    public function increaseShare($postId, $count)
    {
        $post              = $this->post->find($postId);
        $post->share_count = $post->share_count + $count;
        $post->save();

        return $post;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAllPosts()
    {
        return $this->post->all();
    }
}
