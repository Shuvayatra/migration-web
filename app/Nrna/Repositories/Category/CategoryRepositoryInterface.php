<?php
namespace App\Nrna\Repositories\Category;

use App\Nrna\Models\Category;

/**
 * Class CategoryRepositoryInterface
 * @package App\Nrna\Repository\Category
 */
interface CategoryRepositoryInterface
{
    /**
     * Save Category
     * @param $data
     * @return Category
     */
    public function save($data);

    /**
     * @param array $filter
     * @param       $limit
     * @return Collection
     */
    public function getAll($filter = [], $limit = null);

    /**
     * @param $id
     * @return Category
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

    public function findBySection($category);

}
