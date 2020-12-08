<?php namespace Isurindu\LaravelSms\Mobitel\MobitelSDK;

/**
* Mobites SMS gateway
*/
class MobitelSDK
{
    private $client;

    
    public function __construct()
    {
        $this->client = $this->getClient();
    }

    public function login()
    {
        return $this->createSession(
            config('sms.mobitel.id'),
            config('sms.mobitel.username'),
            config('sms.mobitel.password'),
            config('sms.mobitel.customer')
        );
    }

    public function send($to, $msg)
    {
        $gateway = new MobitelSDK;
        $session = $gateway->login();
        // dd($session);
        return $gateway->sendMessages($session, config('sms.mobitel.alias'), $msg, $to);
    }

    ////////////////////////////////////////////////////////////////////
    
    public function getClient()
    {
        ini_set("soap.wsdl_cache_enabled", "0");
        $client = new \SoapClient("http://smeapps.mobitel.lk:8585/EnterpriseSMS/EnterpriseSMSWS.wsdl");
        return $client;
    }

    
    //create session
    public function createSession($id, $username, $password, $customer)
    {
        $client=$this->client;

        $user=new \stdClass();
        $user->id=$id;
        $user->username=$username;
        $user->password=$password;
        $user->customer=$customer;

        $createSession=new \stdClass();
        $createSession->arg0=$user;

        $createSessionResponse=new \stdClass();
        $createSessionResponse= $client->createSession($createSession);


        return $createSessionResponse->return;
    }

    //check if session is valid
    public function isSession($session)
    {
        $client=$this->client;

        $isSession= new \stdClass();
        $isSession->arg0=$session;

        $isSessionResponse=new \stdClass();
        $isSessionResponse= $client->isSession($isSession);

        return $isSessionResponse->return;
    }

    //send SMS to recipients
    public function sendMessages($session, $alias, $message, $recipients)
    {
        $client=$this->client;

        $aliasObj=new \stdClass();
        $aliasObj->alias=$alias;
        $aliasObj->customer="";
        $aliasObj->id="";


        $smsMessage= new \stdClass();
        $smsMessage->message=$message;
        $smsMessage->messageId="";
        $smsMessage->recipients=$recipients;
        $smsMessage->retries="";
        $smsMessage->sender=$aliasObj;
        $smsMessage->sequenceNum="";
        $smsMessage->status="";
        $smsMessage->time="";
        $smsMessage->type="";
        $smsMessage->user="";

        $sendMessages=new \stdClass();
        $sendMessages->arg0=$session;
        $sendMessages->arg1=$smsMessage;

        $sendMessagesResponse=new \stdClass();
        $sendMessagesResponse=$client->sendMessages($sendMessages);

        // dd($sendMessagesResponse->return);

        return $sendMessagesResponse->return;
    }

    //renew session
    public function renewSession($session)
    {
        $client=$this->client;

        $renewSession=new \stdClass();
        $renewSession->arg0=$session;

        $renewSessionResponse=new \stdClass();
        $renewSessionResponse=$client->renewSession($renewSession);

        return $renewSessionResponse->return;
    }


    //close session
    public function closeSession($session)
    {
        $client=$this->client;

        $closeSession=new \stdClass();
        $closeSession->arg0=$session;

        $client->closeSession($closeSession);
    }

    //retrieve messages from shortcode
    public function getMessagesFromShortCode($session, $shortCode)
    {
        $client=$this->client;

        $shortCodeObj=new \stdClass();
        $shortCodeObj->shortcode=$shortCode;

        $getMessagesFromShortCode=new \stdClass();
        $getMessagesFromShortCode->arg0=$session;
        $getMessagesFromShortCode->arg1=$shortCodeObj;

        $getMessagesFromShortcodeResponse=new \stdClass();
        $getMessagesFromShortcodeResponse->return="";
        $getMessagesFromShortcodeResponse=$client->getMessagesFromShortcode($getMessagesFromShortCode);
    
        if (property_exists($getMessagesFromShortcodeResponse, 'return')) {
            return $getMessagesFromShortcodeResponse->return;
        } else {
            return null;
        }
    }

    //retrieve delivery report
    public function getDeliveryReports($session, $alias)
    {
        $client=$this->client;

        $aliasObj=new \stdClass();
        $aliasObj->alias=$alias;

        $getDeliveryReports=new \stdClass();
        $getDeliveryReports->arg0=$session;
        $getDeliveryReports->arg1=$aliasObj;

        $getDeliveryReportsResponse=new \stdClass();
        $getDeliveryReportsResponse->return="";
        $getDeliveryReportsResponse=$client->getDeliveryReports($getDeliveryReports);
    
        if (property_exists($getDeliveryReportsResponse, 'return')) {
            return $getDeliveryReportsResponse->return;
        } else {
            return null;
        }
    }

    //retrieve messages from longnumber
    public function getMessagesFromLongNumber($session, $longNumber)
    {
        $client=$this->client;

        $longNumberObj=new \stdClass();
        $longNumberObj->longNumber=$longNumber;

        $getMessagesFromLongNUmber=new \stdClass();
        $getMessagesFromLongNUmber->arg0=$session;
        $getMessagesFromLongNUmber->arg1=$longNumberObj;

        $getMessagesFromLongNUmberResponse=new \stdClass();
        $getmessagesFromLongNUmberResponse->return="";
        $getMessagesFromLongNUmberResponse=$client->getMessagesFromLongNUmber($getMessagesFromLongNUmber);
    
        return $getMessagesFromLongNUmberResponse->return;
    }
}
