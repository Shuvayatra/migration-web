<?php
namespace App\Nrna\Services;

use App\Nrna\Models\Journey;
use App\Nrna\Repositories\Journey\JourneyRepositoryInterface;
use Illuminate\Contracts\Filesystem\Factory as Storage;
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
     * constructor
     * @param JourneyRepositoryInterface $journey
     * @param Storage                    $storage
     * @param Filesystem                 $file
     * @param FileUpload                 $fileUpload
     */
    public function __construct(
        JourneyRepositoryInterface $journey,
        Storage $storage,
        Filesystem $file,
        FileUpload $fileUpload
    ) {
        $this->journey    = $journey;
        $this->storage    = $storage;
        $this->uploadPath = public_path(Journey::UPLOAD_PATH);
        $this->file       = $file;
        $this->fileUpload = $fileUpload;
    }

    /**
     * @param $formData
     * @return Journey|bool
     */
    public function save($formData)
    {
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
        } catch (Exception $e) {
            return false;
        }

        $formData['featured_image']   = $featured_image;
        $formData['menu_image']       = $menu_image;
        $formData['small_menu_image'] = $small_menu_image;

        return $this->journey->save($formData);
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
        } catch (Exception $e) {
            return false;
        }

        return $journey->update($formData);
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
}
