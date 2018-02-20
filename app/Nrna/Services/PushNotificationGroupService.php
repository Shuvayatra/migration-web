<?php

namespace App\Nrna\Services;


use App\Nrna\Models\PushNotificationGroup;
use App\Nrna\Repositories\PushNotificationGroup\PushNotificationGroupRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class PushNotificationGroupService
{
    /**
     * @var PushNotificationGroupRepositoryInterface
     */
    private $pushNotificationGroup;

    /**
     * constructor
     * @param PushNotificationGroupRepositoryInterface $pushNotificationGroup
     */
    public function __construct(PushNotificationGroupRepositoryInterface $pushNotificationGroup)
    {
        $this->pushNotificationGroup = $pushNotificationGroup;
    }

    /**
     * @param $data
     * @return PushNotificationGroup
     */
    public function create($data)
    {
        $data['properties'] = json_encode($data['properties']);
        return $this->pushNotificationGroup->save($data);
    }

    /**
     * @param  int $limit
     * @return Collection
     */
    public function getAll($limit = 15)
    {
        return $this->pushNotificationGroup->getAll($limit);
    }

    /**
     * @param $id
     * @return PushNotificationGroup
     */
    public function find($id)
    {
        try {
            return $this->pushNotificationGroup->find($id);
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * @param $id
     * @return int
     */
    public function delete($id)
    {
        return $this->pushNotificationGroup->delete($id);
    }
}