<?php
namespace App\Nrna\Repositories\Screen;

use App\Nrna\Models\Screen;
use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

/**
 * Class ScreenRepository
 * @package App\Nrna\Repository\Screen
 */
class ScreenRepository implements ScreenRepositoryInterface
{
    /**
     * @var DatabaseManager
     */
    protected $db;
    /**
     * @var Screen
     */
    protected $screen;

    /**
     * constructor
     *
     * @param Screen          $screen
     * @param DatabaseManager $db
     */
    public function __construct(Screen $screen, DatabaseManager $db)
    {
        $this->db     = $db;
        $this->screen = $screen;
    }

    /**
     * Save new Screen
     *
     * @param array $data
     *
     * @return Screen
     */
    public function save(array $data)
    {
        return $this->screen->create($data);
    }

    /**
     * Update existing Screen
     *
     * @param array $data
     *
     * @return bool|int
     */
    public function update(array $data)
    {
        return $this->screen->update($data);
    }

    /**
     * Get all Screens
     *
     * @param  array $filters
     * @param  null  $limit
     *
     * @return Collection
     */
    public function getAll(array $filters = [], $limit = null)
    {
        return $this->screen->ordered()->get();
    }

    /**
     * Find an existing Screen by its id
     *
     * @param int $screenId
     *
     * @return Screen
     */
    public function find($screenId)
    {
        return $this->screen->find($screenId);
    }

    /**
     * Delete existing Screen
     *
     * @param int $screenId
     *
     * @return int
     */
    public function delete($screenId)
    {
        return $this->screen->destroy($screenId);
    }

    /**
     * @param array    $applicableFilters
     * @param null|int $limit
     *
     * @return Collection
     */
    public function getFilteredScreens(array $applicableFilters = [], $limit = null)
    {
        $rawQuery = "SELECT screens.ID, MAX(screens.title) AS title, MAX(screens.TYPE) AS TYPE, MAX(screens.POSITION)
         AS order, MAX(screens.icon_image) AS icon FROM screens, json_array_elements(visibility->'country_id') AS 
         country_id WHERE 1 = 1 ";
        $rawQuery .= $this->applyWhere($applicableFilters);
        $rawQuery .= " GROUP BY screens.ID ORDER BY screens.ID";

        $query = DB::select($rawQuery);

        return $query;
    }

    /**
     * Prepare where criteria as given filters
     *
     * @param array $applicableFilters
     *
     * @return string
     */
    private function applyWhere(array $applicableFilters)
    {
        $customWhere = "";

        if (!empty($applicableFilters['gender'])) {
            $customWhere .= sprintf(" AND screens.visibility->>'gender' IN ('%s')", $applicableFilters['gender']);

            if (!empty($applicableFilters['country_id'])) {
                $customWhere .= sprintf(" AND trim(both '\"' from (country_id)::TEXT) IN ('%s')",
                                        $applicableFilters['country_id']);
            }
        } else {
            $customWhere .= " AND trim(both '\"' from (country_id)::TEXT) IN ('all') AND screens.visibility->>'gender' 
            IN ('all')";
        }

        return $customWhere;
    }

}
