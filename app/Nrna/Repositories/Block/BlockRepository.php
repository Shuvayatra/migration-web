<?php
namespace App\Nrna\Repositories\Block;

use App\Nrna\Models\Block;


/**
 * Class BlockRepository
 * @package App\Nrna\Repository\Block
 */
class BlockRepository implements BlockRepositoryInterface
{
    /**
     * @var Block
     */
    private $block;

    /**
     * constructor
     *
     * @param Block $block
     */
    public function __construct(Block $block)
    {
        $this->block = $block;
    }

    /**
     * write brief description
     * @return mixed
     */
    public function getHomeBlocks()
    {
        return $this->block->sorted()->wherePage('home')->get();
    }
}
