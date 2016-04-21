<?php
namespace App\Nrna\Repositories\Section;

/**
 * Class SectionRepositoryInterface
 * @package App\Nrna\Repository\Section
 */
interface SectionRepositoryInterface
{
    /**
     * Save Section
     * @param $data
     * @return Section
     */
    public function save($data);

    /**
     * @param $limit
     * @return Collection
     */
    public function getAll($limit = null);

    /**
     * @param $id
     * @return Section
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
