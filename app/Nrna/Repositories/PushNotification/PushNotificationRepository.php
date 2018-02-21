<?php
namespace App\Nrna\Repositories\PushNotification;

use App\Nrna\Models\PushNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
        return $this->pushNotification->orderBy('id','desc')->paginate(15);
    }

    /**
     * @param $data
     * @return static
     */
    public function create($data)
    {
        return $this->pushNotification->create($data);
    }

    /**
     * returns all notifications scheduled for 5 minutes from current time
     */
    public function getNotificationsFromNow()
    {
        $now = time();
        $five_minutes = $now + (60 * 5);
        return \App\Nrna\Models\PushNotification::where('scheduled_date', '>=', date('m-d-Y\TH:i'))
                                             ->where('scheduled_date', '<=', date('m-d-Y\TH:i', $five_minutes))
                                             ->where('response', '=', '')
                                             ->get();
    }
}