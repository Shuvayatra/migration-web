<?php
namespace App\Http\Controllers\Api\Radio;

use App\Nrna\Models\RssCategory;
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
        $data = [];
        if (request()->has('category')) {
            $category = RssCategory::find(request()->get('category'));
            $data     = array_only($category->toArray(), ['id', 'title']);
            if ($category->feeds->count() > 0) {
                $feeds = $category->feeds()->paginate();
                $feeds->appends(request()->except('page'));
                $data ['feeds']        = $feeds->toArray();
                $data['feeds']['data'] = $feeds->pluck('radio_item')->toArray();
            }

            return $this->response->withArray($data);
        }
        $query    = RssNewsFeeds::orderBy('created_at', 'desc');
        $podcasts = $query->paginate();
        if (count($podcasts) > 0) {
            $data         = $podcasts->toArray();
            $data['data'] = $podcasts->pluck('radio_item')->toArray();
        }

        return $this->response->withArray($data);
    }

    public function categories()
    {
        $data = RssCategory::orderBy('created_at', 'desc')->get(['id', 'title']);

        return $this->response->withArray($data->toArray());
    }
}