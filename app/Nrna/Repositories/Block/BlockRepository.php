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
     * home page blocks
     * @return mixed
     */
    public function getHomeBlocks()
    {
        $query = $this->block->sorted()->wherePage('home')->where('show_country_id', null);
        if (request()->has('country_id')) {
            $query->orWhere('show_country_id', request()->get('country_id'));
        }

        return $query->get();
    }

    /**
     * write brief description
     *
     * @param $id
     * @param $page
     */
    public function getCategoryBlocks($id, $page)
    {
        $query = $this->block->sorted()->wherePage($page);
        if ($page == 'destination') {
            $query->whereRaw("metadata->>'country_id'=?", [$id]);
        }
        if ($page == 'journey') {
            $query->whereRaw("metadata->>'journey_id'=?", [$id]);
        }

        return $query->get();
    }

    public function getJourneyBlocks()
    {
        return $this->block->sorted()->wherePage('journey')->get();
    }
}
