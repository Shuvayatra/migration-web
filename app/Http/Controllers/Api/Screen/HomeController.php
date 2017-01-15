<?php
namespace App\Http\Controllers\Api\Screen;

use Illuminate\Http\Request;
use App\Nrna\Services\BlockService;
use Chrisbjr\ApiGuard\Http\Controllers\ApiGuardController;
use EllipseSynergie\ApiResponse\Laravel\Response;

/**
 * Class HomeController
 * @package App\Http\Controllers\Api\Screen
 */
class HomeController extends ApiGuardController
{
    protected $apiMethods = [
        'index' => [
            'keyAuthentication' => false,
        ],
    ];
    /**
     * @var BlockService
     */
    private $blockService;

    /**
     * HomeController constructor.
     *
     * @param BlockService $blockService
     * @param Response     $response
     */
    public function __construct(BlockService $blockService, Response $response)
    {
        $this->blockService = $blockService;
        $this->response     = $response;
    }

    /**
     * write brief description
     *
     * @param Request $request
     *
     * @return array
     */
    public function index(Request $request)
    {
        $data = $this->blockService->getHomeBlocks($request->all());
        return $this->response->withArray($data->toArray());
    }
}