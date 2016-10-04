<?php namespace App\Nrna\Services;

use App\Nrna\Repositories\Rss\RssRepositoryInterface;

class RssService
{
    protected $adapterData = [
        'title'       => 'printText',
        'description' => 'printText',
        'image'       => 'printImage',
    ];
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
     *
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
     *
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
     *
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

    /**
     * scrape data from url
     *
     * @param $url
     *
     * @return array|null
     */
    public function fetchData($url)
    {
        try {
            $info = \Embed\Embed::create($url);
            $data = [];
            foreach ($this->adapterData as $name => $fn) {
                $data[$name] = $info->$name;
            }

            return $data;

        } catch (\Exception $exception) {
            \Log::error('error getting data form url.'.$url, $exception);

            return null;
        }
    }
}