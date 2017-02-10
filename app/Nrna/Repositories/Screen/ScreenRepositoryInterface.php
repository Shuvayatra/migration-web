<?php
namespace App\Nrna\Repositories\Screen;

use App\Nrna\Models\Screen;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class ScreenRepositoryInterface
 * @package App\Nrna\Repository\Screen
 */
interface ScreenRepositoryInterface
{
    /**
     * Save new Screen
     *
     * @param array $data
     *
     * @return Screen
     */
    public function save(array $data);

    /**
     * @param array $data
     *
     * @return bool|int
     */
    public function update(array $data);

    /**
     * @param array    $filter
     * @param int|null $limit
     *
     * @return Collection
     */
    public function getAll(array $filter = [], $limit = null);

    /**
     * @param int $screenId
     *
     * @return Screen
     */
    public function find($screenId);

    /**
     * @param int $screenId
     *
     * @return int
     */
    public function delete($screenId);

    /**
     * @param array $applicableFilters
     *
     * @param int   $limit
     *
     * @return Collection
     */
    public function getFilteredScreens(array $applicableFilters = [], $limit = null);

    /**
     * @param $slug
     *
     * @return Screen
     *
     */
    public function getBySlug($slug);
}
