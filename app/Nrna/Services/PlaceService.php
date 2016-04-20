<?php
namespace App\Nrna\Services;

use App\Nrna\Models\Place;
use App\Nrna\Models\PlaceSubcategory;
use App\Nrna\Repositories\Place\PlaceRepositoryInterface;
use Illuminate\Contracts\Filesystem\Factory as Storage;
use Illuminate\Database\DatabaseManager;
use Illuminate\Filesystem\Filesystem;
use Mockery\Exception;

/**
 * Class PlaceService
 * @package App\Nrna\Services
 */
class PlaceService
{
    /**
     * @var uploadPath
     */
    private $uploadPath;
    /**
     * @var PlaceRepositoryInterface
     */
    private $place;
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
     * @param PlaceRepositoryInterface $place
     * @param Filesystem               $file
     * @param FileUpload               $fileUpload
     * @param DatabaseManager          $db
     */
    public function __construct(
        PlaceRepositoryInterface $place,
        Filesystem $file,
        FileUpload $fileUpload,
        DatabaseManager $db
    ) {
        $this->place      = $place;
        $this->uploadPath = public_path(Place::UPLOAD_PATH);
        $this->file       = $file;
        $this->fileUpload = $fileUpload;
        $this->db         = $db;
    }

    /**
     * @param $formData
     * @return Place|bool
     */
    public function save($formData)
    {
        try {
            if ($image_info = $this->fileUpload->handle($formData['image'], $this->uploadPath)) {
                $formData['image'] = $image_info['filename'];
            };

            $place = $this->place->save($formData);

            return $place;
        } catch (Exception $e) {

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
        return $this->place->getAll($limit);
    }

    /**
     * @param $id
     * @return Place
     */
    public function find($id)
    {
        try {
            return $this->place->find($id);
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
        $place = $this->find($id);
        try {
            if (isset($formData['image'])) {
                $this->file->delete($place->image_path);
                $image_info        = $this->fileUpload->handle($formData['image'], $this->uploadPath);
                $formData['image'] = $image_info['filename'];
            }

            $place->update($formData);

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
        $place = $this->find($id);
        $this->file->delete($place->image_path);

        return $this->place->delete($id);
    }


    /**
     * @return array
     */
    public function getList()
    {
        return $this->place->getAll()->lists('title', 'id');
    }

    /**
     * @param $filter
     * @return array
     */
    public function latest($filter)
    {
        $placeArray = [];
        $places     = $this->place->latest($filter);
        foreach ($places as $place) {
            $placeArray[] = $this->buildPlace($place);
        }

        return $placeArray;
    }

    /**
     * @param  Place $place
     * @return array
     */
    public function buildPlace(Place $place)
    {
        $placeArray['id']         = $place->id;
        $placeArray               = array_merge($placeArray, (array) $place->metadata);
        $placeArray['country_id'] = $place->country_id;
        $placeArray['image']      = $place->image_link;
        $placeArray['created_at'] = $place->created_at->timestamp;
        $placeArray['updated_at'] = $place->updated_at->timestamp;

        return $placeArray;
    }
}
