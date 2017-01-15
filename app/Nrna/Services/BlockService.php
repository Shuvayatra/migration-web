<?php
namespace App\Nrna\Services;

use App\Nrna\Repositories\Block\BlockRepositoryInterface;

class BlockService
{
    /**
     * @var BlockRepositoryInterface
     */
    private $block;

    /**
     * BlockService constructor.
     *
     * @param BlockRepositoryInterface $block
     */
    public function __construct(BlockRepositoryInterface $block)
    {
        $this->block = $block;
    }

    /**
     * home page blocks
     *
     * @param array $filters
     *
     * @return array
     */
    public function getHomeBlocks($filters = [])
    {
        $blocks = $this->block->getHomeBlocks($filters);

        return $blocks->pluck('api_metadata');
    }

    /**
     * Categories destination/journey page blocks
     *
     * @param $id
     *
     * @return array
     */
    public function getCategoryBlocks($id, $page)
    {
        $blocks = $this->block->getCategoryBlocks($id, $page);

        return $blocks->pluck('api_metadata');
    }

    /**
     * home page blocks
     * @return array
     */
    public function getJourneyBlocks()
    {
        $blocks = $this->block->getJourneyBlocks();

        return $blocks->pluck('api_metadata');
    }
}
