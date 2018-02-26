<?php

namespace App\Console\Commands;

use App\Nrna\Services\PushNotificationService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SendForexPushNotifications extends Command
{
    protected $countriesCharCodes = ['MYR'=>'d_MY', 'SAR'=>'d_SA', 'QAR'=>'d_QA', 'AED'=>'d_AE', 'KWD'=>'d_KW', 'KRW'=>'d_KR', 'BHD'=>'d_BH', 'LBN'=>'d_LB', 'OMN'=>'d_OM'];

    protected $changePercentage = 0.1;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'forexpushnotification:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send forex update push notification to users';

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
        $responseJson = json_decode($this->curl_get_contents("http://hamropatro-android.appspot.com/kv/get/market_segment_forex_ne::-1"), true);
        $forexJson = json_decode($responseJson['list'][0]['value'], true);
        $countries = $forexJson['items'];
        $message = [
            'title'       => "आजको बिदेशी विनिमय दर",
            'description' => ""
        ];

        foreach($countries as $countryForex){

            if(!array_key_exists($countryForex['symbol'], $this->countriesCharCodes)){
                continue;
            }
            $buying_today_price = $countryForex['prices'][0]['price']['price'];
            $price_history = $countryForex['prices'][0]['history'];
            $buying_yesterday_price = $price_history[count($price_history) - 1]['price'];

            $selling_today_price = $countryForex['prices'][1]['price']['price'];
            $price_history = $countryForex['prices'][1]['history'];
            $selling_yesterday_price = $price_history[count($price_history) - 1]['price'];

            $message['deeplink'] = "shuvayatra://forex";
            $message['hash'] = md5($message['title'] . $message['description'] . $message['deeplink']);

            if($this->percentageIncrease($buying_yesterday_price, $buying_today_price) > $this->changePercentage){
                Log::info($this->pushNotificationService->sendToTopic($this->countriesCharCodes[$countryForex['symbol']], $message));
            }else if($this->percentageIncrease($selling_yesterday_price, $selling_today_price) > $this->changePercentage){
                Log::info($this->pushNotificationService->sendToTopic($this->countriesCharCodes[$countryForex['symbol']], $message));
            }
        }
    }

    private function percentageIncrease($fromValue, $toValue)
    {
        return ( abs( $toValue - $fromValue ) / $fromValue ) * 100;
    }

    private function curl_get_contents($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }
}
