<?php namespace App\Nrna\Repositories\Rss;

interface RssRepositoryInterface
{
    /**
     * @param $all
     * @return mixed
     */
    public function save($all);

    /**
     * @param $id
     * @return mixed
     */
    public function find($id);

    /**
     * @return mixed
     */
    public function getRssList();
}