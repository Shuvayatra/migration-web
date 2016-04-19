<?php
namespace App\Nrna\Services;

use App\Nrna\Models\Journey;
use App\Nrna\Models\JourneySubcategory;
use App\Nrna\Repositories\Journey\JourneyRepositoryInterface;
use Illuminate\Contracts\Filesystem\Factory as Storage;
use Illuminate\Database\DatabaseManager;
use Illuminate\Filesystem\Filesystem;
use Mockery\Exception;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * ClassJourneyService
 * @package App\Nrna\Services
 */
class JourneyService
{
    /**
     * @var uploadPath
     */
    private $uploadPath;
    /**
     * @var JourneyRepositoryInterface
     */
    private $journey;
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
     * @param JourneyRepositoryInterface $journey
     * @param Storage                    $storage
     * @param Filesystem                 $file
     * @param FileUpload                 $fileUpload
     * @param DatabaseManager            $db
     */
    public function __construct(
        JourneyRepositoryInterface $journey,
        Storage $storage,
        Filesystem $file,
        FileUpload $fileUpload,
        DatabaseManager $db
    ) {
        $this->journey    = $journey;
        $this->storage    = $storage;
        $this->uploadPath = public_path(Journey::UPLOAD_PATH);
        $this->file       = $file;
        $this->fileUpload = $fileUpload;
        $this->db         = $db;
    }

    /**
     * @param $formData
     * @return Journey|bool
     */
    public function save($formData)
    {
        $this->db->beginTransaction();
        try {
            if ($featured_image_info = $this->fileUpload->handle($formData['featured_image'], $this->uploadPath)) {
                $featured_image = $featured_image_info['filename'];
            };
            if ($menu_image_info = $this->fileUpload->handle($formData['menu_image'], $this->uploadPath)) {
                $menu_image = $menu_image_info['filename'];
            }
            if ($small_menu_image_info = $this->fileUpload->handle($formData['small_menu_image'], $this->uploadPath)) {
                $small_menu_image = $small_menu_image_info['filename'];
            }

            $formData['featured_image']   = $featured_image;
            $formData['menu_image']       = $menu_image;
            $formData['small_menu_image'] = $small_menu_image;
            $journey                      = $this->journey->save($formData);
            $this->saveSubcategory($formData, $journey);
            $this->db->commit();

            return $journey;
        } catch (Exception $e) {
            $this->db->rollback();

            return false;
        }

        return false;
    }

    /**
     * @param  int $limit
     * @return Collection
     */
    public function all($limit = 15)
    {
        return $this->journey->getAll($limit);
    }

    /**
     * @param $id
     * @return Journey
     */
    public function find($id)
    {
        try {
            return $this->journey->find($id);
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
        $journey = $this->find($id);
        try {
            if (isset($formData['featured_image'])) {
                $this->file->delete($journey->featured_image_path);
                $featured_image_info        = $this->fileUpload->handle($formData['featured_image'], $this->uploadPath);
                $formData['featured_image'] = $featured_image_info['filename'];
            }
            if (isset($formData['menu_image'])) {
                $this->file->delete($journey->menu_image_path);
                $menu_image_info        = $this->fileUpload->handle($formData['menu_image'], $this->uploadPath);
                $formData['menu_image'] = $menu_image_info['filename'];
            }
            if (isset($formData['small_menu_image'])) {
                $this->file->delete($journey->small_menu_image_path);
                $small_menu_image_info        = $this->fileUpload->handle(
                    $formData['small_menu_image'],
                    $this->uploadPath
                );
                $formData['small_menu_image'] = $small_menu_image_info['filename'];
            }
            $journey->update($formData);
            $this->saveSubcategory($formData, $journey);
            $this->updateSubcategory($formData);
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
        $journey = $this->find($id);
        $this->file->delete($journey->featured_image_path);
        $this->file->delete($journey->menu_image_path);
        $this->file->delete($journey->small_menu_image_path);

        return $this->journey->delete($id);
    }


    /**
     * @return array
     */
    public function getList()
    {
        return $this->journey->getAll()->lists('title', 'id');
    }

    /**
     * @return array
     */
    public function latest()
    {
        return $this->journey->getAll();
    }

    /**
     * @param $id
     * @return int
     */
    public function deleteSubCategory($id)
    {
        $journey = JourneySubcategory::find($id);

        return $journey->delete($id);
    }

    /**
     * @param $formData
     * @param $journey
     */
    protected function saveSubcategory($formData, $journey)
    {
        if (!isset($formData ['subcategory'])) {
            return;
        }
        $subCategories = [];
        foreach ($formData ['subcategory'] as $subcategory) {
            $subCategories[] = new JourneySubcategory($subcategory);
        }

        return $journey->subCategories()->saveMany($subCategories);
    }

    /**
     * @param $formData
     */
    protected function updateSubcategory($formData)
    {
        foreach ($formData ['subcategory_old'] as $key => $subcategory) {
            $subCategory        = JourneySubcategory::find($key);
            $subCategory->title = $subcategory['title'];
            $subCategory->save();
        }
    }
}
