<?php
namespace App\Nrna\Repositories\Block;

use App\Nrna\Models\Block;
use Illuminate\Support\Facades\DB;


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
     *
     * @param array $filters
     *
     * @return mixed
     * @internal param array $applicableFilters
     *
     */
    public function getHomeBlocks(array $filters = [])
    {
        $query = $this->getFilteredBlocks($filters);

        $query->page('home');

        return $query->sorted()->get();
    }

    /**
     * @param array    $applicableFilters
     * @param null|int $limit
     *
     * @return array
     */
    public function getFilteredBlocks(array $applicableFilters = [], $limit = null)
    {
        $query = $this->block->select('*');
        $from  = "blocks ";
        $this->applyWhere($query, $applicableFilters, $from);
        $query->from(\DB::raw($from));

        return $query;
    }

    /**
     * Prepare where criteria as given filters
     *
     * @param       $query
     * @param array $applicableFilters
     *
     * @return string
     */
    private function applyWhere($query, array $applicableFilters, &$from)
    {
        if (!empty($applicableFilters['gender'])) {
            $query->whereRaw("blocks.visibility->>'gender' IN (?,'all')", [strtolower($applicableFilters['gender'])]);
        } else {
            $query->whereRaw("blocks.visibility->>'gender' IN ('all')");
        }
        if (!empty($applicableFilters['country_id'])) {
            $from .= ",json_array_elements(blocks.visibility->'country_id') as country_id";
            $query->whereRaw(
                "trim(both '\"' from (country_id)::TEXT) IN (?,'0')",
                [$applicableFilters['country_id']]
            );
        } else {
            $from .= ",json_array_elements(blocks.visibility->'country_id') as country_id";
            $query->whereRaw(
                "trim(both '\"' from (country_id)::TEXT) IN ('0')"
            );
        }
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
        $query = $this->block->sorted()->wherePage('journey')->where('show_country_id', null);
        if (request()->has('country_id')) {
            $query->orWhere(
                function ($q) {
                    $q->where('show_country_id', request()->get('country_id'))
                      ->where('page', 'journey');
                }
            );
        }

        return $query->get();
    }

    /**
     * creates block
     *
     * @param $data
     *
     * @return mixed
     */
    public function create($data)
    {
        return $this->block->create($data);
    }

    /**
     * block for screen
     *
     * @param       $screenId
     * @param array $filters
     *
     * @return mixed
     */
    public function getScreenBlocks($screenId, $filters = [])
    {
        $query = $this->getFilteredBlocks($filters);
        $query->whereRaw("metadata->>'screen_id'=?", [$screenId]);
        $query->page('dynamic');

        return $query->get();
    }

    public function find($id)
    {
        return $this->block->find($id);
    }
}
