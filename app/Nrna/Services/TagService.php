<?php
namespace App\Nrna\Services;

use App\Nrna\Repositories\Tag\TagRepositoryInterface;

/**
 * Class TagService
 * @package App\Nrna\Services
 */
class TagService
{
    /**
     * @var TagRepositoryInterface
     */
    private $tag;

    /**
     * constructor
     * @param TagRepositoryInterface $tag
     */
    function __construct(TagRepositoryInterface $tag)
    {
        $this->tag = $tag;
    }

    /**
     * @param $data
     * @return Tag
     */
    public function save($data)
    {
        return $this->tag->save($data);
    }

    /**
     * @param int $limit
     * @return \App\Nrna\Repositories\Tag\Collection
     */
    public function all($limit = 15)
    {
        return $this->tag->getAll($limit);
    }

    /**
     * @param $id
     * @return Tag
     */
    public function find($id)
    {
        try {
            return $this->tag->find($id);
        } catch (\Exception $e) {
            return null;
        }

        return null;
    }

    /**
     * @param $data
     * @return bool
     */
    public function update($id, $data)
    {
        return $this->tag->update($data);
    }

    /**
     * @param $id
     * @return int
     */
    public function delete($id)
    {
        return $this->tag->delete($id);
    }

    /**
     * @return array
     */
    public function getList()
    {
        return $this->tag->getAll()->lists('title', 'id');
    }

    /**
     * creates tag id doesn't exists in database
     *
     * @return array
     * param $tags
     */
    public function createOrGet($tags)
    {
        foreach ($tags as $index => $tag) {
            if (is_null($this->find($tag))) {
                $tagObj       = $this->save(['title' => $tag]);
                $tags[$index] = $tagObj->id;
            }
        }

        return $tags;
    }
}