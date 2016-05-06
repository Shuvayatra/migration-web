<?php
namespace App\Nrna\Services;

use App\Nrna\Models\Category;
use App\Nrna\Repositories\Category\CategoryRepositoryInterface;
use Illuminate\Contracts\Filesystem\Factory as Storage;
use Illuminate\Database\DatabaseManager;
use Illuminate\Filesystem\Filesystem;
use Mockery\Exception;

/**
 * Class CategoryService
 * @package App\Nrna\Services
 */
class CategoryService
{
    /**
     * @var uploadPath
     */
    private $uploadPath;
    /**
     * @var CategoryRepositoryInterface
     */
    private $category;
    /**
     * @var Storage
     */
    private $storage;
    /**
     * @var Filesystem
     */
    private $file;
    /**
     * @var FileUpload
     */
    private $fileUpload;
    /**
     * @var DatabaseManager
     */
    private $db;

    /**
     * constructor
     * @param CategoryRepositoryInterface $category
     * @param Storage                     $storage
     * @param Filesystem                  $file
     * @param FileUpload                  $fileUpload
     * @param DatabaseManager             $db
     */
    public function __construct(
        CategoryRepositoryInterface $category,
        Storage $storage,
        Filesystem $file,
        FileUpload $fileUpload,
        DatabaseManager $db
    ) {
        $this->category   = $category;
        $this->storage    = $storage;
        $this->uploadPath = public_path(Category::UPLOAD_PATH);
        $this->file       = $file;
        $this->fileUpload = $fileUpload;
        $this->db         = $db;
    }

    /**
     * @param $formData
     * @param $parent_id
     * @return Category|bool
     */
    public function save($formData, $parent_id)
    {
        $formData['parent_id'] = $parent_id;
        $formData['position']  = 0;
        try {
            if (isset($formData['main_image'])) {
                $main_image_info        = $this->fileUpload->handle($formData['main_image'], $this->uploadPath);
                $main_image             = $main_image_info['filename'];
                $formData['main_image'] = $main_image;
            };
            if (isset($formData['icon'])) {
                $icon_info        = $this->fileUpload->handle($formData['icon'], $this->uploadPath);
                $icon             = $icon_info['filename'];
                $formData['icon'] = $icon;

            }
            if (isset($formData['small_icon'])) {
                $small_icon_info        = $this->fileUpload->handle($formData['small_icon'], $this->uploadPath);
                $small_icon             = $small_icon_info['filename'];
                $formData['small_icon'] = $small_icon;
            }

            $category = $this->category->save($formData);

            return $category;
        } catch (Exception $e) {
            $this->db->rollback();

            return false;
        }

        return false;
    }

    /**
     * @param array $filter
     * @param  int  $limit
     * @return Collection
     */
    public function all($filter = [], $limit = 15)
    {
        return $this->category->getAll($filter, $limit);
    }

    /**
     * @param $id
     * @return Category
     */
    public function find($id)
    {
        try {
            return $this->category->find($id);
        } catch (\Exception $e) {
            return null;
        }

        return null;
    }

    /**
     * @param $id
     * @param $formData
     * @return bool
     */
    public function update($id, $formData)
    {
        $category = $this->find($id);
        try {
            if (isset($formData['main_image'])) {
                $this->file->delete($category->main_image_path);
                $main_image_info        = $this->fileUpload->handle($formData['main_image'], $this->uploadPath);
                $formData['main_image'] = $main_image_info['filename'];
            }
            if (isset($formData['icon'])) {
                $this->file->delete($category->icon_path);
                $icon_info        = $this->fileUpload->handle($formData['icon'], $this->uploadPath);
                $formData['icon'] = $icon_info['filename'];
            }
            if (isset($formData['small_icon'])) {
                $this->file->delete($category->small_icon_path);
                $small_icon_info        = $this->fileUpload->handle(
                    $formData['small_icon'],
                    $this->uploadPath
                );
                $formData['small_icon'] = $small_icon_info['filename'];
            }
            $category->update($formData);

            return true;
        } catch (Exception $e) {

            return false;
        }

        return;
    }

    /**
     * @param $id
     * @return int
     */
    public function delete($id)
    {
        $category = $this->find($id);
        $this->file->delete($category->main_image_path);
        $this->file->delete($category->icon_path);
        $this->file->delete($category->small_icon_path);

        return $this->category->delete($id);
    }


    /**
     * @return array
     */
    public function getList()
    {
        return $this->category->getAll()->lists('title', 'id');
    }

    /**
     * @param $filter
     * @return array
     */
    public function latest($filter)
    {
        $categoryArray = [];
        $categories    = $this->category->latest($filter);
        foreach ($categories as $category) {
            $categoryArray[] = $this->buildCategory($category);
        }

        return $categoryArray;
    }

    /**
     * @param Category $category
     * @return mixed
     */
    public function buildCategory(Category $category)
    {
        $categoryArray['id']             = $category->id;
        $categoryArray['title']          = $category->title;
        $categoryArray['description']    = $category->description;
        $categoryArray['featured_image'] = $category->main_image_link;
        $categoryArray['icon']           = $category->icon_link;
        $categoryArray['small_icon']     = $category->small_icon_link;
        $categoryArray['position']       = $category->position;
        $categoryArray['small_icon']     = $category->small_icon_link;
        $categoryArray['parent_id']      = $category->parent_id;
        $categoryArray['lft']            = $category->lft;
        $categoryArray['rgt']            = $category->rgt;
        $categoryArray['depth']          = $category->depth;

        $categoryArray['created_at'] = $category->created_at->timestamp;
        $categoryArray['updated_at'] = $category->updated_at->timestamp;

        return $categoryArray;
    }

}
