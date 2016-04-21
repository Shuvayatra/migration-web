<?php
namespace App\Nrna\Services;

use App\Nrna\Models\CategoryAttribute;
use App\Nrna\Repositories\CategoryAttribute\CategoryAttributeRepositoryInterface;
use Illuminate\Contracts\Filesystem\Factory as Storage;
use Illuminate\Database\DatabaseManager;
use Illuminate\Filesystem\Filesystem;
use Mockery\Exception;

/**
 * Class CategoryAttributeService
 * @package App\Nrna\Services
 */
class CategoryAttributeService
{
    /**
     * @var uploadPath
     */
    private $uploadPath;
    /**
     * @var CategoryAttributeRepositoryInterface
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
     * @param CategoryAttributeRepositoryInterface $category
     * @param Storage                              $storage
     * @param Filesystem                           $file
     * @param FileUpload                           $fileUpload
     * @param DatabaseManager                      $db
     */
    public function __construct(
        CategoryAttributeRepositoryInterface $category,
        Storage $storage,
        Filesystem $file,
        FileUpload $fileUpload,
        DatabaseManager $db
    ) {
        $this->category   = $category;
        $this->storage    = $storage;
        $this->uploadPath = public_path(CategoryAttribute::UPLOAD_PATH);
        $this->file       = $file;
        $this->fileUpload = $fileUpload;
        $this->db         = $db;
    }

    /**
     * @param $formData
     * @return CategoryAttribute|bool
     */
    public function save($section_id, $formData)
    {
        $formData['section_id'] = $section_id;
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
     * @param       $section_id
     * @param array $filter
     * @param  int  $limit
     * @return Collection
     */
    public function all($section_id, $filter = [], $limit = 15)
    {
        return $this->category->getAll($section_id, $filter, $limit);
    }

    /**
     * @param $id
     * @return CategoryAttribute
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
        $this->db->beginTransaction();
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
            $this->db->commit();

            return true;
        } catch (Exception $e) {
            $this->db->rollback();

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
        return $this->category->latest($filter);
    }
}
