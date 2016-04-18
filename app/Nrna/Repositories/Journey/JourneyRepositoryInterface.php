<?php
namespace App\Nrna\Repositories\Journey;

/**
 * Class JourneyRepositoryInterface
 * @package App\Nrna\Repository\Journey
 */
interface JourneyRepositoryInterface
{
    /**
     * Save Journey
     * @param $data
     * @return Journey
     */
    public function save($data);

    /**
     * @param $limit
     * @return Collection
     */
    public function getAll($limit = null);

    /**
     * @param $id
     * @return Journey
     */
    public function find($id);

    /**
     * @param $data
     * @return bool|int
     */
    public function update($data);

    /**
     * @param $id
     * @return int
     */
    public function delete($id);

    /**
     * @return array
     */
    public function lists();

    /**
     * @param $filter
     * @return Collection
     */
    public function latest($filter);

}
