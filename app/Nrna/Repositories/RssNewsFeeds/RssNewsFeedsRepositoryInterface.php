<?php namespace App\Nrna\Repositories\RssNewsFeeds;
interface RssNewsFeedsRepositoryInterface
{

    /**
     * @param $all
     * @return mixed
     */
    public function save($all);

    /**
     * @param $rssFeeds
     * @return mixed
     */
    public function insertFeeds($rssFeeds);

    /**
     * @return mixed
     */
    public function getAll();

    /**
     * @param $id
     * @return mixed
     */
    public function find($id);


    /**
     * @param $rssId
     * @return mixed
     */
    public function getMaxDate($rssId);
}