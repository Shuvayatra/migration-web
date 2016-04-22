<?php namespace App\Nrna\Services;

use App\Nrna\Repositories\Rss\RssRepositoryInterface;

class RssService
{
    /**
     * @var RssRepositoryInterface
     */
    protected $rss;
    /**
     * @var RssNewsFeedsService
     */
    protected $rssNewsFeedsService;

    /**
     * RssService constructor.
     * @param RssRepositoryInterface $rss
     * @param RssNewsFeedsService    $rssNewsFeedsService
     */
    public function __construct(RssRepositoryInterface $rss, RssNewsFeedsService $rssNewsFeedsService)
    {
        $this->rss                 = $rss;
        $this->rssNewsFeedsService = $rssNewsFeedsService;
    }


    /**
     * @param $all
     * @return mixed
     */
    public function save($all)
    {
        $rss = $this->rss->save($all);
        $this->rssNewsFeedsService->insertFeeds($rss->id, $this->rssNewsFeedsService->getRssItems($all['url'], 10));

        return $rss;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        return $this->rss->find($id);
    }

    /**
     * @return mixed
     */
    public function getRssList()
    {
        return $this->rss->getRssList();
    }
}