<?php
namespace App\Nrna\Repositories\Block;

/**
 * Class BlockRepositoryInterface
 * @package App\Nrna\Repository\Block
 */
interface BlockRepositoryInterface
{
    /**
     * get home screen blocks
     *
     * @return mixed
     */
    public function getHomeBlocks();

    public function getCategoryBlocks($id, $page);

    public function getJourneyBlocks();
}
