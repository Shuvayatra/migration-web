<?php
namespace App\Nrna\Services;

use App\Nrna\Models\Post;
use App\Nrna\Models\Screen;
use App\Nrna\Repositories\Screen\ScreenRepositoryInterface;
use App\Nrna\Services\Api\PostService;
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
     * @var BlockService
     */
    private $blockService;
    /**
     * @var Post
     */
    private $post;
    /**
     * @var PostService
     */
    private $postService;

    /**
     * ScreenService constructor.
     *
     * @param ScreenRepositoryInterface $screen
     * @param FileUpload                $fileUpload
     * @param CategoryService           $categoryService
     * @param BlockService              $blockService
     * @param Post                      $post
     * @param PostService               $postService
     */
    public function __construct(
        ScreenRepositoryInterface $screen,
        FileUpload $fileUpload,
        CategoryService $categoryService,
        BlockService $blockService,
        Post $post,
        PostService $postService
    ) {
        $this->screen          = $screen;
        $this->fileUpload      = $fileUpload;
        $this->categoryService = $categoryService;
        $this->blockService    = $blockService;
        $this->post            = $post;
        $this->postService     = $postService;
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
            if (isset($updateData['icon_image'])) {
                $file_info                = $this->fileUpload->handle($updateData['icon_image']);
                $updateData['icon_image'] = $file_info['filename'];
            }

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
        $screens = $this->screen->getFilteredScreens($applicableFilters);

        foreach ($screens as $screen) {
            $screen->icon = ($screen->icon == '') ? '' : url('uploads/'.$screen->icon);
        }

        return $screens;
    }

    public function find($id)
    {
        return $this->screen->find($id);
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
        $screen = $this->screen->find($screenId);
        if (!$screen) {
            abort(404);
        }
        $response = (array) $screen->api_metadata;
        if ($screen->type == "block") {
            $response['blocks'] = $this->getBlocks($screen->id);
        }
        if ($screen->type == "feed") {
            $response['feeds'] = $this->getFeeds($screen->id);
        }

        return $response;
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
            if (isset($inputs['category']['category'])) {
                $categories = $this->categoryService->find($inputs['category']['category']);
                $categories->map(
                    function ($category) use ($screen) {
                        return $screen->categories()->save($category, ['category_type' => 'category']);
                    }
                );
            }
            if (isset($inputs['category']['country']) && in_array('all', $inputs['category']['country'])) {
                $screen->feed_country = 'all';
                $screen->save();

                return true;
            }
            if (isset($inputs['category']['country']) && !in_array('all', $inputs['category']['country'])) {
                $categories = $this->categoryService->find($inputs['category']['country']);
                $categories->map(
                    function ($category) use ($screen) {
                        return $screen->categories()->save($category, ['category_type' => 'country']);
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
                    if ($id != 0) {
                        $data[$id] = ['category_type' => $type];
                    }
                };

            }
            if (isset($inputs['category']['country']) && in_array('all', $inputs['category']['country'])) {
                $screen->feed_country = 'all';
                $screen->save();
            }
            if (isset($inputs['category']['country']) && !in_array('all', $inputs['category']['country'])) {
                $screen->feed_country = '';

                $screen->save();
            }
            $screen->categories()->sync($data);

            return true;
        } catch (\Exception $exception) {
            return false;
        }

    }

    private function getBlocks($id)
    {
        $blocks = $this->blockService->getScreenBlocks($id);

        return $blocks->pluck('api_metadata');
    }

    private function getFeeds($id)
    {
        $screen     = $this->screen->find($id);
        $categories = $screen->categories->groupBy('pivot.category_type');
        $query      = $this->post->select("*");
        if (isset($categories['category'])) {
            $query->category($categories['category']->lists('id')->toArray());
        }
        if ($screen->feed_country != 'all' && isset($categories['country'])) {
            $query->category($categories['country']->lists('id')->toArray());
        }
        $posts     = $query->paginate();
        $postArray = [];
        foreach ($posts as $post) {
            $postArray[] = $this->postService->formatPost($post);
        }
        $posts    = $posts->toArray();
        $response = array_except($posts, 'data');

        $response['data'] = $postArray;

        return $response;
    }
}
