<?php

namespace App\Nrna\Services;

use App\Nrna\Repositories\RssNewsFeeds\RssNewsFeedsRepositoryInterface;
use SimplePie;

class RssNewsFeedsService
{
    /**
     * @var RssService
     */
    protected $rssService;

    /**
     * RssNewsFeedsService constructor.
     *
     * @param RssNewsFeedsRepositoryInterface $rssNewsFeeds
     */
    function __construct(RssNewsFeedsRepositoryInterface $rssNewsFeeds)
    {
        $this->rssNewsFeeds = $rssNewsFeeds;
    }

    /**
     * @param     $url
     * @param int $limit
     *
     * @return array|null
     */
    public function getRssItems($url, $limit = 0)
    {
        $feedData = [];
        $feed     = new SimplePie();
        $feed->set_feed_url($url);
        $feed->enable_cache(true);
        $feed->set_cache_location(storage_path().'/cache');
        $feed->set_cache_duration(60 * 60 * 12);
        $feed->set_output_encoding('utf-8');
        $feed->init();

        if (!is_null($feed->error)) {
            return null;
        }
        foreach ($feed->get_items(0, $limit) as $item) {
            $feedData[] = [
                'title'       => $item->get_title(),
                'description' => $item->get_description(),
                'permalink'   => $item->get_permalink(),
                'post_date'   => $item->get_date('Y:m:d h:i:s'),

            ];
        }

        return $feedData;
    }

    /**
     * @param $all
     *
     * @return mixed
     */
    public function save($all)
    {
        return $this->rssNewsFeeds->save($all);
    }

    /**
     * @param $rssId
     * @param $rssFeeds
     *
     * @return mixed
     */
    public function insertFeeds($rssId, $rssFeeds)
    {
        foreach ($rssFeeds as $feed) {
            $feed['rss_id'] = $rssId;
            $this->rssNewsFeeds->insertFeeds($feed);
        }

        return null;
    }

    /**
     * @return mixed
     */
    public function getAll()
    {
        return $this->rssNewsFeeds->getAll();
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function find($id)
    {
        return $this->rssNewsFeeds->find($id);
    }

    /**
     * @param $rss
     */
    public function fetch($rss)
    {
        $rssFeeds = $this->getRssItems($rss->url);
        $maxDate  = strtotime($this->rssNewsFeeds->getMaxDate($rss->id));

        foreach ($rssFeeds as $feed) {
            if (strtotime($feed['post_date']) > $maxDate) {
                $feed['rss_id'] = $rss->id;
                $this->rssNewsFeeds->insertFeeds($feed);
            }

        }
    }

    /**
     * @param $rssId
     * @param $feed
     *
     * @return mixed
     */
    protected function checkIfFeedExists($rssId, $feed)
    {
        return $this->rssNewsFeeds->checkIfFeedExists($rssId, $feed);
    }


}