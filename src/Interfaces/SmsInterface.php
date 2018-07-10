<?php
namespace Isurindu\LaravelSms\Interfaces;

interface SmsInterface
{
    public function sendSms($to, $msg, $from);
}
