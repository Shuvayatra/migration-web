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
     * @param array $filters
     *
     * @return mixed
     */
    public function getHomeBlocks(array $filters = []);

    public function getCategoryBlocks($id, $page);

    public function getJourneyBlocks();

    /**
     * write brief description
     *
     * @param $data
     *
     * @return mixed
     */
    public function create($data);

    public function getScreenBlocks($screenId, $filters = []);

    public function find($id);
}
