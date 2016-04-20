<?php
namespace App\Nrna\Repositories\Place;

/**
 * Class PlaceRepositoryInterface
 * @package App\Nrna\Repository\Place
 */
interface PlaceRepositoryInterface
{
    /**
     * Save Place
     * @param $data
     * @return Place
     */
    public function save($data);

    /**
     * @param $limit
     * @return Collection
     */
    public function getAll($limit = null);

    /**
     * @param $id
     * @return Place
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
