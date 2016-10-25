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
     * write brief description
     * @return array
     */
    public function getHomeBlocks()
    {
        $blocks = $this->block->getHomeBlocks();

        return $blocks->pluck('api_metadata');
    }
}
