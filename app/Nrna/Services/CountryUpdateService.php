<?php
namespace App\Nrna\Services;

use App\Nrna\Models\Update;
use App\Nrna\Repositories\CountryUpdate\UpdateRepositoryInterface;

/**
 * Class CountryUpdateService
 * @package App\Nrna\Services
 */
class CountryUpdateService
{
    /**
     * @var UpdateRepositoryInterface
     */
    private $update;

    /**
     * constructor
     * @param UpdateRepositoryInterface $update
     */
    public function __construct(UpdateRepositoryInterface $update)
    {
        $this->update = $update;
    }

    /**
     * @param $data
     * @return Update
     */
    public function save($data)
    {
        return $this->update->save($data);
    }

    /**
     * @param  int $limit
     * @return \App\Nrna\Repositories\Update\Collection
     */
    public function all($limit = 15)
    {
        return $this->update->getAll($limit);
    }

    /**
     * @param $id
     * @return Update
     */
    public function find($id)
    {
        try {
            return $this->update->find($id);
        } catch (\Exception $e) {
            return null;
        }

        return null;
    }

    /**
     * @param $id
     * @return int
     */
    public function delete($id)
    {
        return $this->update->delete($id);
    }

    /**
     * @param $filter
     * @return array
     */
    public function latest($filter)
    {
        $updateArray = [];
        $updates     = $this->update->latest($filter);
        foreach ($updates as $update) {
            $updateArray[] = $this->buildUpdate($update);
        }

        return $updateArray;
    }

    /**
     * answer response format for api
     * @param  Update $update
     * @return array
     */
    public function buildUpdate(Update $update)
    {
        $updateArray['id']          = $update->id;
        $updateArray['title']       = $update->title;
        $updateArray['description'] = $update->description;
        $updateArray['country_id']  = $update->country_id;
        $updateArray['created_at']  = $update->created_at->timestamp;
        $updateArray['updated_at']  = $update->updated_at->timestamp;

        return $updateArray;
    }

    /**
     * gets deleted answers
     * @param $filter
     * @return array
     */
    public function deleted($filter)
    {
        $posts = $this->update->deleted($filter);

        return $posts;
    }
}
