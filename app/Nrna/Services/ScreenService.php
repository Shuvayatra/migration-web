<?php
namespace App\Nrna\Services;

use App\Nrna\Models\Screen;
use App\Nrna\Repositories\Screen\ScreenRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ScreenService
 * @package App\Nrna\Services
 */
class ScreenService
{
    /**
     * @var ScreenRepositoryInterface
     */
    protected $screen;
    /**
     * @var FileUpload
     */
    private $fileUpload;
    /**
     * @var CategoryService
     */
    private $categoryService;

    /**
     * ScreenService constructor.
     *
     * @param ScreenRepositoryInterface $screen
     * @param FileUpload                $fileUpload
     * @param CategoryService           $categoryService
     */
    public function __construct(
        ScreenRepositoryInterface $screen,
        FileUpload $fileUpload,
        CategoryService $categoryService
    ) {
        $this->screen          = $screen;
        $this->fileUpload      = $fileUpload;
        $this->categoryService = $categoryService;
    }

    public function getAll()
    {
        return $this->screen->getAll();
    }

    /**
     * @param array $saveData
     *
     * @return Screen|bool
     */
    public function save(array $saveData)
    {
        if (isset($saveData['icon_image'])) {
            $file_info              = $this->fileUpload->handle($saveData['icon_image']);
            $saveData['icon_image'] = $file_info['filename'];
        }

        return $this->screen->save($saveData);
    }

    /**
     * @param int   $screenId
     * @param array $updateData
     *
     * @return bool
     */
    public function update($screenId, array $updateData)
    {
        if ($screen = $this->screen->find($screenId)) {
            return $screen->update($updateData);
        }
    }

    /**
     * Get filtered list of available screens
     *
     * @param array $applicableFilters
     *
     * @return Collection
     */
    public function getScreens(array $applicableFilters = [])
    {
        return $this->screen->getFilteredScreens($applicableFilters);
    }

    /**
     * Get screen detail
     *
     * @param int $screenId
     *
     * @return Model
     */
    public function getDetail($screenId)
    {
        return $this->screen->find($screenId);
    }

    /**
     * Delete screen record for given screen id
     *
     * @param $screenId
     *
     * @return int
     */
    public function delete($screenId)
    {
        return $this->screen->delete($screenId);
    }

    public function saveCategories($screenId, $inputs)
    {
        try {
            $screen = $this->screen->find($screenId);

            foreach ($inputs['category'] as $type => $id) {
                $categories = $this->categoryService->find($id);
                $categories->map(
                    function ($category) use ($screen, $type) {
                        return $screen->categories()->save($category, ['category_type' => $type]);
                    }
                );

            }

            return true;
        } catch (\Exception $exception) {
            return false;
        }

    }

    public function updateCategories($screenId, $inputs)
    {
        try {
            $data   = [];
            $screen = $this->screen->find($screenId);

            foreach ($inputs['category'] as $type => $ids) {
                foreach ($ids as $id) {
                    $data[$id] = ['category_type' => $type];
                };

            }
            $screen->categories()->sync($data);

            return true;
        } catch (\Exception $exception) {
            return false;
        }

    }
}
