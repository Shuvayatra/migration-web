<?php

namespace App\Console\Commands;

use App\Nrna\Services\PushNotificationService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class SendPushNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pushnotification:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send push notification to users';

    /**
     * @var PushNotificationService
     */
    protected $pushNotificationService;

    /**
     * Create a new command instance.
     *
     * @param $pushNotificationService
     * @return void
     */
    public function __construct(PushNotificationService $pushNotificationService)
    {
        parent::__construct();
        $this->pushNotificationService = $pushNotificationService;
    }

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        $this->comment($this->sendNotifications());
    }

    public function sendNotifications()
    {
        $pushnotifications = $this->pushNotificationService->getNotificationsFromNow();
        Log::info("There are " . count($pushnotifications) . " notifications to send");
        foreach ($pushnotifications as $pushnotification)
        {
            if(count($pushnotification->groups()->get()) > 0)
                $pushnotification->response = $this->pushNotificationService->sendScheduledNotificationToGroups($pushnotification, $pushnotification->groups()->get());
            else
                $pushnotification->response = $this->pushNotificationService->sendScheduledNotificationToSingleTopic($pushnotification, Config::get('constants.topic.all'));
            $pushnotification->save();
        }
    }
}
