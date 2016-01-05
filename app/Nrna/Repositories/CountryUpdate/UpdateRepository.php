<?php
namespace App\Nrna\Repositories\CountryUpdate;

use App\Nrna\Models\Update;

/**
 * Class UpdateRepository
 * @package App\Nrna\Repository\Update
 */
class UpdateRepository implements UpdateRepositoryInterface
{
    /**
     * @var Update
     */
    private $update;

    /**
     * constructor
     * @param Update $update
     */
    public function __construct(Update $update)
    {
        $this->update = $update;
    }

    /**
     * Save Update
     * @param $data
     * @return Update
     */
    public function save($data)
    {
        return $this->update->create($data);
    }

    /**
     * @param  null $limit
     * @return Collection
     */
    public function getAll($limit = null)
    {
        if (is_null($limit)) {
            return $this->update->with('country')->all();
        }

        return $this->update->with('country')->paginate();
    }

    /**
     * @param $id
     * @return Update
     */
    public function find($id)
    {
        return $this->update->findOrFail($id);
    }

    /**
     * @param $data
     * @return bool|int
     */
    public function update($data)
    {
        return $this->update->update($data);
    }

    /**
     * @param $id
     * @return int
     */
    public function delete($id)
    {
        return $this->update->destroy($id);
    }

    /**
     * get latest answer
     * @param $filter
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function latest($filter)
    {
        $filter = array_only($filter, ['updated_at']);
        $query  = $this->update->where(
            function ($q) use ($filter) {
                foreach ($filter as $key => $value) {
                    $q->where($key, '>', $value);
                }
            }
        );

        return $query->get();
    }

    /**
     * gets deleted answers
     *
     * @param $filter
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function deleted($filter)
    {
        $filter = array_only($filter, ['deleted_at']);
        $query  = $this->update->onlyTrashed()->where(
            function ($q) use ($filter) {
                foreach ($filter as $key => $value) {
                    $q->where($key, '>', $value);
                }
            }
        );

        return $query->get(['id', 'deleted_at']);
    }
}
