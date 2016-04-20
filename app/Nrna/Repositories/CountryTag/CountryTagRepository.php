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
        return $this->tag->list('name', 'id')->all();
    }

    /**
     * @param $id
     * @return int
     */
    public function delete($id)
    {
        return $this->tag->destroy($id);
    }

    /**
     * get latest tag
     * @param $filter
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function latest($filter)
    {
        $filter = array_only($filter, ['updated_at']);
        $query  = $this->tag->where(
            function ($q) use ($filter) {
                foreach ($filter as $key => $value) {
                    $q->where($key, '>', $value);
                }
            }
        );

        return $query->get();
    }

    /**
     * gets deleted tags
     *
     * @param $filter
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function deleted($filter)
    {
        $filter = array_only($filter, ['deleted_at']);
        $query  = $this->tag->onlyTrashed()->where(
            function ($q) use ($filter) {
                foreach ($filter as $key => $value) {
                    $q->where($key, '>', $value);
                }
            }
        );

        return $query->get(['id', 'deleted_at']);
    }
}
