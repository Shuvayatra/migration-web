<?php
namespace App\Nrna\Repositories\CategoryAttribute;

/**
 * Class CategoryAttributeRepositoryInterface
 * @package App\Nrna\Repository\CategoryAttribute
 */
interface CategoryAttributeRepositoryInterface
{
    /**
     * Save CategoryAttribute
     * @param $data
     * @return CategoryAttribute
     */
    public function save($data);

    /**
     * @param       $section_id
     * @param array $filter
     * @param       $limit
     * @return Collection
     */
    public function getAll($section_id, $filter = [], $limit = null);

    /**
     * @param $id
     * @return CategoryAttribute
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
