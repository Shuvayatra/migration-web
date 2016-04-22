<?php namespace App\Nrna\Repositories\Rss;

use App\Nrna\Models\Rss;

class RssRepository implements RssRepositoryInterface
{
    /**
     * @var Rss
     */
    protected $rss;

    /**
     * RssRepository constructor.
     * @param Rss $rss
     */
    public function __construct(Rss $rss)
    {
        $this->rss = $rss;
    }

    /**
     * @param $all
     * @return static
     */
    public function save($all)
    {
        return $this->rss->create($all);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        return $this->rss->findOrFail($id);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getRssList()
    {
        return $this->rss->all();
    }
}