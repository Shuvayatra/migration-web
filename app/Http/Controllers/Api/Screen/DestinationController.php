<?php
namespace App\Http\Controllers\Api\Screen;

use App\Nrna\Services\BlockService;
use Chrisbjr\ApiGuard\Http\Controllers\ApiGuardController;

/**
 * Class DestinationController
 * @package App\Http\Controllers\Api\Screen
 */
class DestinationController extends ApiGuardController
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
     * DestinationController constructor.
     *
     * @param BlockService $blockService
     */
    public function __construct(BlockService $blockService)
    {
        $this->blockService = $blockService;
    }

    /**
     * write brief description
     *
     * @param $id
     *
     * @return array
     */
    public function destination($id)
    {
        return $this->blockService->getCategoryBlocks($id, 'destination');
    }

    /**
     * write brief description
     *
     * @param $id
     *
     * @return array
     */
    public function journey($id)
    {
        return $this->blockService->getCategoryBlocks($id, 'journey');
    }
}