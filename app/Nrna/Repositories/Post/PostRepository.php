<?php
namespace App\Nrna\Repositories\Post;

use App\Nrna\Models\Category;
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
     *
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
     *
     * @param $data
     *
     * @return Post
     */
    public function save($data)
    {
        return $this->post->create($data);
    }

    /**
     * @param       $filters
     * @param  null $limit
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAll($filters, $limit = null)
    {
        $query = $this->post->select('*');
        if (!\Entrust::can('manage-all-content')) {
            $query->where('created_by', auth()->user()->id);
        }
        $from = "posts ";
        if (isset($filters['status']) && $filters['status'] != '') {
            $status = $filters['status'];
            $query->whereRaw("posts.metadata->>'status' = ?", [$status]);
        }
        if (isset($filters['user']) && $filters['user'] != '') {
            $user = $filters['user'];
            $query->where("created_by", [$user]);
        }
        if (isset($filters['date_from']) && $filters['date_from'] != '') {
            $query->whereRaw("date(created_at) >= ?", [str_replace('/', '-', $filters['date_from'])]);
        }
        if (isset($filters['date_to']) && $filters['date_to'] != '') {
            $query->whereRaw("date(created_at) <= ?", [str_replace('/', '-', $filters['date_to'])]);
        }

        if (isset($filters['post_type']) && $filters['post_type'] != '') {
            $post_type = $filters['post_type'];
            $query->whereRaw("posts.metadata->>'type' = ?", [$post_type]);
        }

        if (array_has($filters, "sub_category1")) {
            $ids = $filters['sub_category1'];
            $query->category($ids);
        }
        if (array_has($filters, "sub_category")) {
            $category     = Category::find($filters['sub_category']);
            $category_ids = $category->getDescendantsAndSelf()->lists('id')->toArray();

            $query->category($category_ids);
        }
        if (array_has($filters, "category")) {
            $category     = Category::find($filters['category']);
            $category_ids = $category->getDescendantsAndSelf()->lists('id')->toArray();

            $query->category($category_ids);
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
     *
     * @return Post
     */
    public function find($id)
    {
        return $this->post->with('tags')->find($id);
    }

    /**
     * @param $data
     *
     * @return bool|int
     */
    public function update($data)
    {
        return $this->post->update($data);
    }

    /**
     * @param $id
     *
     * @return int
     */
    public function delete($id)
    {
        return $this->post->destroy($id);
    }

    /**
     * @param $filter
     *
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
     *
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
     *
     * @return mixed
     */
    public function getLikes($postId)
    {
        return $this->post->where('id', $postId)->first();
    }

    /**
     * @param $postId
     *
     * @return mixed
     */
    public function incrementLikes($postId)
    {
        return $this->post->where('id', $postId)->increment('likes');
    }

    /**
     * @param $postId
     *
     * @return mixed
     */
    public function decrementLikes($postId)
    {
        return $this->post->where('id', $postId)->decrement('likes');
    }

    /**
     * @param $ids
     *
     * @return mixed
     */
    public function postExistsCheck($ids)
    {
        return $this->post->whereIn('id', $ids)->get(['id']);
    }

    /**
     * @param      $ids
     *
     * @param bool $paginate
     *
     * @return mixed
     */
    public function getByCategoryId($ids, $paginate = false)
    {
        $ids = (array) $ids;

        $query = $this->post->whereHas(
            'categories',
            function ($q) use ($ids) {
                $q->whereIn('id', $ids);
            }
        )->orderBy('id', 'asc');
        if (request()->has('post_type') && request()->get('post_type') != '') {
            $post_type = request()->get('post_type');
            $query->whereRaw("posts.metadata->>'type' = ?", [$post_type]);
        }
        if ($paginate) {
            return $query->paginate();
        }

        return $query->get();
    }

    /**
     * @param       $q
     *
     * @param bool  $paginate
     *
     *
     * @param float $rank_limit
     *
     * @return mixed
     */
    public function search($q, $paginate = false, $rank_limit = 0.0)
    {
        $q                = implode('|', explode(' ', trim($q)));
        $document_columns = "setweight(to_tsvector(posts.metadata->>'description'), 'B') 
        || setweight(to_tsvector(posts.metadata->>'title'),'A') 
        || setweight(to_tsvector(CASE WHEN count(tags.title)=0 THEN ' ' ELSE coalesce(string_agg(tags.title, ' ')) END), 'A') 
        || setweight(to_tsvector(coalesce(string_agg(categories.title, ' '))), 'A')";
        $sub_query        = $this->post->selectRaw(
            "posts.*,($document_columns) as document,ts_rank({$document_columns}, to_tsquery('{$q}'))
         as rank"
        );
        $sub_query->leftJoin('post_tag', 'post_tag.post_id', '=', 'posts.id');
        $sub_query->leftJoin('tags', 'tags.id', '=', 'post_tag.tag_id');
        $sub_query->leftJoin('category_post', 'category_post.post_id', '=', 'posts.id');
        $sub_query->leftJoin('categories', 'categories.id', '=', 'category_post.category_id');
        $sub_query->groupBy('posts.id');
        $query = $this->post->from(\DB::raw('('.$sub_query->toSql().')  as posts'));
        $query->whereRaw("posts.document @@ to_tsquery('{$q}')");
        if (request()->has('post_type') && request()->get('post_type') != '') {
            $post_type = request()->get('post_type');
            $query->whereRaw("posts.metadata->>'type' = ?", [$post_type]);
        }
        if ($rank_limit) {
            $query->whereRaw("rank > ?", [$rank_limit]);
        }
        $query->orderBy("rank", 'desc');
        if ($paginate) {
            return $query->paginate();
        }

        return $query->get();
    }

    /**
     * @param $postId
     * @param $count
     *
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
     *
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


    /**
     * @param       $filters
     * @param  null $limit
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all($filters, $limit = null)
    {
        $query = $this->post->select('*');
        $from  = "posts ";

        if (isset($filters['post_type']) && $filters['post_type'] != '') {
            $post_type = $filters['post_type'];
            $query->whereRaw("posts.metadata->>'type' = ?", [$post_type]);
        }

        $query->from($this->db->raw($from));
        $query->orderBy('updated_at', 'DESC');
        $query->published();

        return $query->paginate();
    }

    /**
     * get post by tag/tags
     *
     * @param      $tags string|array
     *
     * @param bool $paginate
     *
     * @return mixed
     */
    public function getByTags($tags, $paginate = false)
    {
        $query = $this->post->whereHas(
            'tags',
            function ($q) use ($tags) {
                if (is_string($tags)) {
                    $q->where('title', $tags);
                } else {
                    $q->whereIn('id', $tags);
                }
            }
        );
        $query->orderBy('updated_at', 'DESC');
        $query->published();
        if ($paginate) {
            return $query->paginate();
        }

        return $query->get();
    }

    /**
     * full text search for post
     *
     * @param      $q
     * @param bool $paginate
     *
     * @return mixed
     */
    public function fullTextSearch($q, $paginate = false)
    {
        $query = $this->post->whereRaw("to_tsvector(metadata->>'description') @@ plainto_tsquery('{$q}')")
                            ->OrWhereRaw("to_tsvector(metadata->>'title') @@ plainto_tsquery('{$q}')");
        $query->selectRaw("posts.*,ts_rank(to_tsvector(metadata->>'description') ,to_tsquery('{$q}')) as rank");
        if ($paginate) {
            return $query->paginate();
        }
        $query->orderBy('rank');

        return $query->get();
    }
}
