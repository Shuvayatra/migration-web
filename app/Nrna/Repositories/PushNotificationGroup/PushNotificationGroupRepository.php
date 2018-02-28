<?php

namespace App\Nrna\Repositories\PushNotificationGroup;


use App\Nrna\Models\PushNotificationGroup;
use Illuminate\Database\Eloquent\Collection;

class PushNotificationGroupRepository implements PushNotificationGroupRepositoryInterface
{
    /**
     * @var PushNotificationGroup
     */
    private $pushNotificationGroup;

    /**
     * constructor
     * @param PushNotificationGroup $pushNotificationGroup
     */
    public function __construct(PushNotificationGroup $pushNotificationGroup)
    {
        $this->pushNotificationGroup = $pushNotificationGroup;
    }

    /**
     * Save PushNotificationGroup
     * @param $data
     * @return PushNotificationGroup
     */
    public function save($data)
    {
        return $this->pushNotificationGroup->create($data);
    }

    /**
     * @param  null       $limit
     * @return Collection
     */
    public function getAll($limit = null)
    {
        if (is_null($limit)) {
            return $this->pushNotificationGroup->orderBy('id','desc');
        }

        return $this->pushNotificationGroup->orderBy('id','desc')->paginate($limit);
    }

    /**
     * @param $id
     * @return PushNotificationGroup
     */
    public function find($id)
    {
        return $this->pushNotificationGroup->findOrFail($id);
    }

    /**
     * @param $data
     * @return bool|int
     */
    public function update($data)
    {
        return $this->pushNotificationGroup->update($data);
    }

    /**
     * @param $id
     * @return int
     */
    public function delete($id)
    {
        return $this->pushNotificationGroup->destroy($id);
    }
}