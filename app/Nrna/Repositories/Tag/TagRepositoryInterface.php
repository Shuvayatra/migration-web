<?php
namespace App\Nrna\Repositories\Tag;


/**
 * Class TagRepositoryInterface
 * @package App\Nrna\Repository\Tag
 */
interface TagRepositoryInterface
{

    /**
     * Save Tag
     * @param $data
     * @return Tag
     */
    public function save($data);

    /**
     * @param $limit
     * @return Collection
     */
    public function getAll($limit = null);

    /**
     * @param $id
     * @return Tag
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