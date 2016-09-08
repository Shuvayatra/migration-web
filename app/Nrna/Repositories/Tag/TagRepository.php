<?php
namespace App\Nrna\Repositories\Tag;

use App\Nrna\Models\Tag;

/**
 * Class TagRepository
 * @package App\Nrna\Repository\Tag
 */
class TagRepository implements TagRepositoryInterface
{
    /**
     * @var Tag
     */
    private $tag;

    /**
     * constructor
     * @param Tag $tag
     */
    public function __construct(Tag $tag)
    {
        $this->tag = $tag;
    }

    /**
     * Save Tag
     * @param $data
     * @return Tag
     */
    public function save($data)
    {
        return $this->tag->create($data);
    }

    /**
     * @param  null       $limit
     * @return Collection
     */
    public function getAll($limit = null)
    {
        if (is_null($limit)) {
            return $this->tag->sorted();
        }

        return $this->tag->sorted()->paginate();
    }

    /**
     * @param $id
     * @return Tag
     */
    public function find($id)
    {
        return $this->tag->findOrFail($id);
    }

    /**
     * @param $data
     * @return bool|int
     */
    public function update($data)
    {
        return $this->tag->update($data);
    }

    /**
     * @return Collection
     */
    public function getList()
    {
        return $this->tag->list('title', 'id')->all();
    }

    /**
     * @param $id
     * @return int
     */
    public function delete($id)
    {
        return $this->tag->destroy($id);
    }
}
