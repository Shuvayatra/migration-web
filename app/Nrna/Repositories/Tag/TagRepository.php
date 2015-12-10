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
    function __construct(Tag $tag)
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
     * @param $limit
     * @return Collection
     */
    public function getAll($limit)
    {
        if (is_null($limit)) {
            return $this->tag->all();
        }

        return $this->tag->paginate();
    }
}