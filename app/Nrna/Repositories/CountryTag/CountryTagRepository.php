<?php
namespace App\Nrna\Repositories\CountryTag;

use App\Nrna\Models\CountryTag;

/**
 * Class CountryTagRepository
 * @package App\Nrna\Repository\CountryTag
 */
class CountryTagRepository implements CountryTagRepositoryInterface
{
    /**
     * @var CountryTag
     */
    private $tag;

    /**
     * constructor
     * @param CountryTag $tag
     */
    public function __construct(CountryTag $tag)
    {
        $this->tag = $tag;
    }

    /**
     * Save CountryTag
     * @param $data
     * @return CountryTag
     */
    public function save($data)
    {
        return $this->tag->create($data);
    }

    /**
     * @param  null $limit
     * @return Collection
     */
    public function getAll($limit = null)
    {
        if (is_null($limit)) {
            return $this->tag->all();
        }

        return $this->tag->paginate();
    }

    /**
     * @param $id
     * @return CountryTag
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
