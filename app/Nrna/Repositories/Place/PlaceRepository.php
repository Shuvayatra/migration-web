<?php
namespace App\Nrna\Repositories\Place;

use App\Nrna\Models\Place;

/**
 * Class PlaceRepository
 * @package App\Nrna\Repository\Place
 */
class PlaceRepository implements PlaceRepositoryInterface
{
    /**
     * @var Place
     */
    private $place;

    /**
     * constructor
     * @param Place $place
     */
    public function __construct(Place $place)
    {
        $this->place = $place;
    }

    /**
     * Save Place
     * @param $data
     * @return Place
     */
    public function save($data)
    {
        return $this->place->create($data);
    }

    /**
     * @param  null $limit
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAll($limit = null)
    {
        if (is_null($limit)) {
            return $this->place->all();
        }

        return $this->place->paginate();
    }

    /**
     * @param $id
     * @return Place
     */
    public function find($id)
    {
        return $this->place->findOrFail($id);
    }

    /**
     * @param $data
     * @return bool|int
     */
    public function update($data)
    {
        return $this->place->update($data);
    }

    /**
     * @param $id
     * @return int
     */
    public function delete($id)
    {
        return $this->place->destroy($id);
    }

    /**
     * get list of place with title and id
     *
     * @return array
     */

    public function lists()
    {
        return $this->place->lists('title', 'id');
    }

    /**
     * get latest place
     * @param $filter
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function latest($filter)
    {
        $filter = array_only($filter, ['updated_at']);
        $query  = $this->place->where(
            function ($q) use ($filter) {
                foreach ($filter as $key => $value) {
                    $q->where($key, '>', $value);
                }
            }
        );

        return $query->get();
    }

    /**
     * gets deleted places
     *
     * @param $filter
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function deleted($filter)
    {
        $filter = array_only($filter, ['deleted_at']);
        $query  = $this->place->onlyTrashed()->where(
            function ($q) use ($filter) {
                foreach ($filter as $key => $value) {
                    $q->where($key, '>', $value);
                }
            }
        );

        return $query->get(['id', 'deleted_at']);
    }
}
