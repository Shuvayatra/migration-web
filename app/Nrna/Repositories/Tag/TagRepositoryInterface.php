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
    public function getAll($limit);
}