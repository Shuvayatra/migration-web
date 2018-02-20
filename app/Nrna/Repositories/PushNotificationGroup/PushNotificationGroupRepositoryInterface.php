<?php

namespace App\Nrna\Repositories\PushNotificationGroup;


use App\Nrna\Models\PushNotificationGroup;
use Illuminate\Database\Eloquent\Collection;

interface PushNotificationGroupRepositoryInterface
{
    /**
     * Save Answer
     * @param $data
     * @return PushNotificationGroup
     */
    public function save($data);

    /**
     * @param $limit
     * @return Collection
     */
    public function getAll($limit = null);

    /**
     * @param $id
     * @return PushNotificationGroup
     */
    public function find($id);

    /**
     * @param $data
     * @return bool|int
     */
    public function update($data);

    /**
     * @param $id
     * @return int
     */
    public function delete($id);
}