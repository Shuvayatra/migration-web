<?php
namespace App\Nrna\Repositories\CountryTag;

/**
 * Class CountryTagRepositoryInterface
 * @package App\Nrna\Repository\CountryTag
 */
interface CountryTagRepositoryInterface
{
    /**
     * Save CountryTag
     * @param $data
     * @return CountryTag
     */
    public function save($data);

    /**
     * @param $limit
     * @return Collection
     */
    public function getAll($limit = null);

    /**
     * @param $id
     * @return CountryTag
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
