<?php
namespace Isurindu\LaravelSms\Gateways;

use Swagger\Client\ShoutoutClient;
use Isurindu\LaravelSms\Interfaces\SmsInterface;
use Isurindu\LaravelSms\Exceptions\LaravelSmsGatewayException;

class ShoutoutGateway implements SmsInterface
{
    public function sendSms($to, $msg, $from)
    {
        $apiKey = config('sms.shoutout.api_key');

        $client = new ShoutoutClient($apiKey, false, false);

        if ($from == null) {
            $from = config('sms.shoutout.from');
        }

        $message = array(
            'source' => $from,
            'destinations' => [$to],
            'content' => array(
                'sms' => $msg
            ),
            'transports' => ['SMS']
        );

        try {
            $result = $client->sendMessage($message);
            return true;
            // print_r($result);
        } catch (Exception $e) {
            throw new LaravelSmsGatewayException($e->getMessage(), 1);
        }
    }
}
