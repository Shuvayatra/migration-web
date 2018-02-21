<?php

namespace App\Nrna\Services;

use App\Nrna\Models\PushNotificationGroup;
use App\Nrna\Repositories\PushNotification\PushNotificationRepositoryInterface;
use Illuminate\Support\Facades\Log;
use Psr\Log\InvalidArgumentException;

class PushNotificationService
{
    /**
     * @var
     */
    protected $pushNotification;

    /**
     * PushNotificationService constructor.
     *
     * @param PushNotificationRepositoryInterface $pushNotification
     */
    public function __construct(PushNotificationRepositoryInterface $pushNotification)
    {
        $this->pushNotification = $pushNotification;
    }

    const GCM_URL = "https://fcm.googleapis.com/fcm/send";

    /**
     * Notification Service
     *
     * @param $data
     *
     * @return mixed
     */
    protected function send($topics, $data)
    {
        $no_of_topics = count($topics);
        if($no_of_topics > 1)
            $condition = "'" . join("' in topics && '", $topics) . "' in topics";
        else if($no_of_topics == 1)
            $condition = "'$topics[0]' in topics";
        else
            throw new InvalidArgumentException();

        $fields = [
            "condition"   => $condition,
            "data" => $data,
        ];

        $headers = [
            'Authorization: key='.env('GCM_API_ACCESS_KEY'),
            'Content-Type: application/json',
        ];


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
     *
     * @param $data
     *
     * @return bool
     */
    public function sendNotification($data)
    {
        $group_ids = $data['groups'];

        $message = [
            'hash'       => md5($data['title'] . $data['description'] . $data['deeplink']),
            'title'       => $data['title'],
            'description' => $data['description'],
            'deeplink'    => $data['deeplink']
        ];

        foreach($group_ids as $group_id){

            $group = PushNotificationGroup::find(1 * $group_id);
            $properties = json_decode($group->properties, true);
            Log::debug($properties['age']);
            $topics = array();
            if(!empty($properties['age']))
                array_push($topics, $properties['age']);
            if(!empty($properties['gender']))
                array_push($topics, $properties['gender']);
            if(!empty($properties['destination']))
                array_push($topics, $properties['destination']);
            if(!empty($properties['country']))
                array_push($topics, $properties['country']);

            Log::info($this->send($topics, $message));
        }

        return true;
    }

    /**
     * Send push notification
     *
     * @param $data
     *
     * @return bool
     */
    public function sendScheduledNotification($pushNotification, $groups)
    {
        $message = [
            'hash'       => md5($pushNotification->title . $pushNotification->description),
            'title'       => $pushNotification->title,
            'description' => $pushNotification->description,
            'deeplink'    => $pushNotification->deeplink
        ];

        foreach($groups as $group){

            $properties = json_decode($group->properties, true);
            Log::debug($properties['age']);
            $topics = array();
            if(!empty($properties['age']))
                array_push($topics, $properties['age']);
            if(!empty($properties['gender']))
                array_push($topics, $properties['gender']);
            if(!empty($properties['destination']))
                array_push($topics, $properties['destination']);
            if(!empty($properties['country']))
                array_push($topics, $properties['country']);

            $pushNotification->response .= $this->send($topics, $message);
            $pushNotification->save();
        }

        return true;
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function find($id)
    {
        return $this->pushNotification->find($id);
    }

    /**
     * @param $id
     *
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
     *
     * @return mixed
     */
    public function create($data)
    {
        $pushNotification = $this->pushNotification->create($data);
        $pushNotification->groups()->attach($data['groups']);
    }

    /**
     * @return mixed
     */
    public function getNotificationsFromNow()
    {
        return $this->pushNotification->getNotificationsFromNow();
    }
}