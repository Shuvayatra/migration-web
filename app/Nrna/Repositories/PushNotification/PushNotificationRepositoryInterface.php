<?php
namespace App\Nrna\Repositories\PushNotification;


interface PushNotificationRepositoryInterface
{
    /**
     * @param $id
     * @return mixed
     */
    public function find($id);

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id);

    /**
     * @return mixed
     */
    public function getAll();

    /**
     * @param $data
     * @return mixed
     */
    public function create($data);
}