<?php

namespace App\Nrna\Services;

use App\Nrna\Repositories\PushNotification\PushNotificationRepositoryInterface;

class PushNotificationService
{
    /**
     * @var
     */
    protected $pushNotification;

    /**
     * PushNotificationService constructor.
     * @param PushNotificationRepositoryInterface $pushNotification
     */
    public function __construct(PushNotificationRepositoryInterface $pushNotification)
    {
        $this->pushNotification = $pushNotification;
    }
    const GCM_URL = "https://fcm.googleapis.com/fcm/send";

    /**
     * Notification Service
     * @param $data
     * @return mixed
     */
    protected function send($data)
    {
        $fields = array
        (
            "to"   => "/topics/global",
            'data' => $data
        );

        $headers = array
        (
            'Authorization: key=' . env('GCM_API_ACCESS_KEY'),
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, self::GCM_URL);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }

    /**
     * Send push notification
     * @param $data
     * @return mixed
     */
    public function sendNotification($data)
    {
        $message = [
            'title'       => $data['title'],
            'description' => $data['description']
        ];

        return $this->send($message);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        return $this->pushNotification->find($id);
    }

    /**
     * @param $id
     * @return mixed
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
        return $this->pushNotification->getAll();
    }

    /**
     * @param $data
     * @return mixed
     */
    public function create($data)
    {
        return $this->pushNotification->create($data);
    }
}