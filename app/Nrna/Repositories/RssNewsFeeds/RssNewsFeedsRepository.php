<?php namespace App\Nrna\Repositories\RssNewsFeeds;

use App\Nrna\Models\RssNewsFeeds;
use Illuminate\Database\Eloquent\Collection;

class RssNewsFeedsRepository implements RssNewsFeedsRepositoryInterface
{
    /**
     * @var RssNewsFeeds
     */
    protected $rssNewsFeeds;

    /**
     * RssNewsFeedsRepository constructor.
     * @param RssNewsFeeds $rssNewsFeeds
     */
    public function __construct(RssNewsFeeds $rssNewsFeeds)
    {
        $this->rssNewsFeeds = $rssNewsFeeds;
    }

    /**
     * @param $all
     * @return static
     */
    public function save($all)
    {
        return $this->rssNewsFeeds->create($all);
    }

    /**
     * @param $rssFeeds
     * @return bool
     */
    public function insertFeeds($rssFeeds)
    {
        return $this->rssNewsFeeds->create($rssFeeds);
    }

    /**
     * @return Collection|static[]
     */
    public function getAll()
    {
        return $this->rssNewsFeeds->with(['rss'])->orderBy('post_date','desc')->paginate(15);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        return $this->rssNewsFeeds->findOrFail($id);
    }


    /**
     * @param $rssId
     * @return mixed
     */
    public function getMaxDate($rssId)
    {
        return $this->rssNewsFeeds->where('rss_id', $rssId)->max('post_date');
    }
}