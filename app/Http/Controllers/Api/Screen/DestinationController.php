<?php
namespace App\Http\Controllers\Api\Screen;

use App\Nrna\Services\BlockService;
use Chrisbjr\ApiGuard\Http\Controllers\ApiGuardController;
use EllipseSynergie\ApiResponse\Laravel\Response;

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
     * @param $id
     *
     * @return array
     */
    public function destination($id)
    {
        return $this->response->withArray($this->blockService->getCategoryBlocks($id, 'destination')->toArray());
    }

    /**
     * write brief description
     *
     * @param $id
     *
     * @return array
     */
    public function journey()
    {
        return $this->response->withArray($this->blockService->getJourneyBlocks()->toArray());
    }
}