<?php
namespace App\Http\Controllers\Api\Screen;

use App\Nrna\Services\ScreenService;
use App\Nrna\Transformer\ScreenDetailTransformer;
use App\Nrna\Transformer\ScreenListTransformer;
use Chrisbjr\ApiGuard\Http\Controllers\ApiGuardController;
use EllipseSynergie\ApiResponse\Laravel\Response;
use Illuminate\Http\Request;

/**
 * Class ScreenController
 * @package App\Http\Controllers\Api\Screen
 */
class ScreenController extends ApiGuardController
{
    /**
     * @var ScreenService
     */
    protected $screen;

    /**
     * ScreenController constructor.
     *
     * @param Response      $response
     * @param ScreenService $screen
     */
    public function __construct(Response $response, ScreenService $screen)
    {
        $this->response = $response;
        $this->screen   = $screen;
    }

    /**
     * Api to fetch available screen list
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $filters        = $request->only(['gender', 'country_id']);
        $dynamicScreens = $this->screen->getScreens($filters);

        return $this->response->withArray($dynamicScreens);
    }

    /**
     * Fetch screen detail
     *
     * @param int $screenId
     *
     * @return Response
     */
    public function show($screenId)
    {
        $screenDetail = $this->screen->getDetail($screenId);

        return $this->response->withArray((array)$screenDetail);
    }
}
