<?php
namespace App\Http\Controllers\Api\Screen;

use App\Nrna\Services\BlockService;
use Chrisbjr\ApiGuard\Http\Controllers\ApiGuardController;

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
     */
    public function __construct(BlockService $blockService)
    {
        $this->blockService = $blockService;
    }

    /**
     * write brief description
     * @return array
     */
    public function index()
    {
        return $this->blockService->getHomeBlocks();
    }
}