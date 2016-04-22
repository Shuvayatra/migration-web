<?php

namespace App\Console\Commands;

use App\Nrna\Services\RssNewsFeedsService;
use App\Nrna\Services\RssService;
use Illuminate\Console\Command;

class FetchRssFeeds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'nrna:fetchrss';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch rss feeds';
    /**
     * @var RssNewsFeedsService
     */
    protected $rssNewsFeedsService;
    /**
     * @var RssService
     */
    protected $rssService;

    /**
     * Create a new command instance.
     *
     * @param RssNewsFeedsService $rssNewsFeedsService
     * @param RssService          $rssService
     */
    public function __construct(RssNewsFeedsService $rssNewsFeedsService, RssService $rssService)
    {
        parent::__construct();
        $this->rssNewsFeedsService = $rssNewsFeedsService;
        $this->rssService          = $rssService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->comment($this->fetchRssFeeds());
    }

    public function fetchRssFeeds()
    {
        $rssList = $this->rssService->getRssList();
        foreach ($rssList as $rss) {
            $this->rssNewsFeedsService->fetch($rss);
        }

        return true;
    }
}
