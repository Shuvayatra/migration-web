<?php
namespace App\Nrna\Repositories\CountryUpdate;

/**
 * Class UpdateRepositoryInterface
 * @package App\Nrna\Repository\Update
 */
interface UpdateRepositoryInterface
{
    /**
     * Save Update
     * @param $data
     * @return Update
     */
    public function save($data);

    /**
     * @param $limit
     * @return Collection
     */
    public function getAll($limit = null);

    /**
     * @param $id
     * @return Update
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
     * get latest answer
     * @param $filter
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function latest($filter);

    /**
     * gets deleted questions
     *
     * @param $filter
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function deleted($filter);
}
