<?php
namespace App\Nrna\Repositories\Country;

/**
 * Class CountryRepositoryInterface
 * @package App\Nrna\Repository\Country
 */
interface CountryRepositoryInterface
{
    /**
     * Save Country
     * @param $data
     * @return Country
     */
    public function save($data);

    /**
     * @param $limit
     * @return Collection
     */
    public function getAll($limit = null);

    /**
     * @param $id
     * @return Country
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
}
