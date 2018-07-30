<?php
namespace Isurindu\LaravelSms\Gateways;

use Illuminate\Support\Facades\Log;
use Isurindu\LaravelSms\Interfaces\SmsInterface;
use Isurindu\LaravelSms\Exceptions\LaravelSmsGatewayException;

class LogGateway implements SmsInterface
{
    public function sendSms($to, $msg, $from)
    {
        $apiKey = config('sms.shoutout.api_key');


        if ($from == null) {
            $from = config('sms.shoutout.from');
        }

        $log = array(
            'from' => $from,
            'msg' => $msg,
            'to' => [$to],
        );

        Log::info($log);
    }
}
