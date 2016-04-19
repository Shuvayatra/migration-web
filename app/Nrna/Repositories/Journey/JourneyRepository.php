<?php
namespace App\Nrna\Repositories\Journey;

use App\Nrna\Models\Journey;

/**
 * Class JourneyRepository
 * @package App\Nrna\Repository\Journey
 */
class JourneyRepository implements JourneyRepositoryInterface
{
    /**
     * @var Journey
     */
    private $journey;

    /**
     * constructor
     * @param Journey $journey
     */
    public function __construct(Journey $journey)
    {
        $this->journey = $journey;
    }

    /**
     * Save Journey
     * @param $data
     * @return Journey
     */
    public function save($data)
    {
        return $this->journey->create($data);
    }

    /**
     * @param  null $limit
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAll($limit = null)
    {
        if (is_null($limit)) {
            return $this->journey->sorted()->all();
        }

        return $this->journey->sorted()->paginate();
    }

    /**
     * @param $id
     * @return Journey
     */
    public function find($id)
    {
        return $this->journey->findOrFail($id);
    }

    /**
     * @param $data
     * @return bool|int
     */
    public function update($data)
    {
        return $this->journey->update($data);
    }

    /**
     * @param $id
     * @return int
     */
    public function delete($id)
    {
        return $this->journey->destroy($id);
    }

    /**
     * get list of journey with title and id
     *
     * @return array
     */

    public function lists()
    {
        return $this->journey->lists('title', 'id');
    }

    /**
     * get latest journey
     * @param $filter
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function latest($filter)
    {
        $filter = array_only($filter, ['updated_at']);
        $query  = $this->journey->where(
            function ($q) use ($filter) {
                foreach ($filter as $key => $value) {
                    $q->where($key, '>', $value);
                }
            }
        );

        return $query->get();
    }

    /**
     * gets deleted journeys
     *
     * @param $filter
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function deleted($filter)
    {
        $filter = array_only($filter, ['deleted_at']);
        $query  = $this->journey->onlyTrashed()->where(
            function ($q) use ($filter) {
                foreach ($filter as $key => $value) {
                    $q->where($key, '>', $value);
                }
            }
        );

        return $query->get(['id', 'deleted_at']);
    }
}
