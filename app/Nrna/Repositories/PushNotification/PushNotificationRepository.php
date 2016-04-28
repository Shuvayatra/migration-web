<?php
namespace App\Nrna\Repositories\PushNotification;

use App\Nrna\Models\PushNotification;

class PushNotificationRepository implements PushNotificationRepositoryInterface
{
    /**
     * @var PushNotification
     */
    protected $pushNotification;

    /**
     * PushNotificationRepository constructor.
     * @param PushNotification $pushNotification
     */
    public function __construct(PushNotification $pushNotification)
    {
        $this->pushNotification = $pushNotification;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        return $this->pushNotification->findOrFail($id);
    }

    /**
     * @param $id
     * @return int
     */
    public function destroy($id)
    {
        return $this->pushNotification->destroy($id);
    }

    /**
     * @return mixed
     */
    public function getAll()
    {
        return $this->pushNotification->paginate(15);
    }

    /**
     * @param $data
     * @return static
     */
    public function create($data)
    {
        return $this->pushNotification->create($data);
    }
}