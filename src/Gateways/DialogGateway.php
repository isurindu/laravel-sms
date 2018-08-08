<?php
namespace Isurindu\LaravelSms\Gateways;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Isurindu\LaravelSms\Interfaces\SmsInterface;
use Isurindu\LaravelSms\Exceptions\LaravelSmsGatewayException;

class DialogGateway implements SmsInterface
{
    protected function _getAccessToken()
    {
        $data =  [
            'json'=>[
                'u_name'=>config('sms.dialog.username'),
                'passwd'=>config('sms.dialog.password'),
            ]
        ];
        $response = $this->_processRequest('https://digitalreachapi.dialog.lk/refresh_token.php', $data);
        try {
            return $response['access_token'];
        } catch (\Exception $e) {
            throw new LaravelSmsGatewayException("Can not get access token");
        }
    }
    public function sendSms($to, $msg, $from)
    {
        $data =  [
            'headers' => [
                'Accept'     => 'application/json',
                'Authorization'     => $this->_getAccessToken(),
            ],
            'json'=>[
                'msisdn'=>$to,
                'mt_port'=>$from,
                'channel'=>"1",
                's_time'=>date('Y-m-d H:i:s'),
                'e_time'=>date('Y-m-d H:i:s', strtotime('+15 hours')),
                'msg'=>$msg,
                'callback_url'=>'http://test.com',
            ]
        ];

        // dd($data);


        $response = $this->_processRequest('https://digitalreachapi.dialog.lk/camp_req.php', $data);
        return $response;
     

        ///https://digitalreachapi.dialog.lk/camp_req.php
    }
    protected function _processRequest($url, $data, $method="POST")
    {
        $header = [
            'headers' => [
                'Accept'     => 'application/json',
                'Content-Type'     => 'application/json',
            ],
        ];
        $data = array_merge($header, $data);
        $client = new Client();

        $response = $client->request($method, $url, $data);

        if ($response->getStatusCode()!= 200 && $response->getStatusCode()!= 201) {
            throw new LaravelSmsGatewayException("Something went wrong from dialog");
        }
        $content = json_decode($response->getBody()->getContents(), true);

        if (isset($content['error']) && $content['error']!=0) {
            throw new LaravelSmsGatewayException(trans('sms::dialog.'.$content['error']));
        }
        return $content;
    }
}
