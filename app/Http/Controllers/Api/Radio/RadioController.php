<?php
namespace App\Http\Controllers\Api\Radio;

use App\Nrna\Models\RssNewsFeeds;
use App\Nrna\Services\RssNewsFeedsService;
use Chrisbjr\ApiGuard\Http\Controllers\ApiGuardController;
use EllipseSynergie\ApiResponse\Laravel\Response;

/**
 * Class HomeController
 * @package App\Http\Controllers\Api\Screen
 */
class RadioController extends ApiGuardController
{
    protected $apiMethods = [
        'index' => [
            'keyAuthentication' => false,
        ],
    ];
    /**
     * @var RssNewsFeedsService
     */
    private $news;

    /**
     *
     * @param RssNewsFeedsService $news
     *
     * @param Response            $response
     */
    public function __construct(RssNewsFeedsService $news, Response $response)
    {
        $this->news     = $news;
        $this->response = $response;
    }

    /**
     * write brief description
     * @return array
     */
    public function index()
    {
        $data     = [];
        $podcasts = RssNewsFeeds::orderBy('created_at', 'desc')->get();
        if (count($podcasts) > 0) {
            $data = $podcasts->pluck('radio_item')->toArray();
        }

        return $this->response
            ->withArray($data);
    }
}