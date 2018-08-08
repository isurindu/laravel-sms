<?php
namespace Isurindu\LaravelSms\Gateways;

use Isurindu\LaravelSms\Interfaces\SmsInterface;
use Isurindu\LaravelSms\Exceptions\LaravelSmsException;
use Isurindu\LaravelSms\Exceptions\LaravelSmsGatewayException;

class GatewayManager
{
    protected $provider;
    protected $to;
    protected $from;

    public function __construct()
    {
        $this->provider(config('sms.default_sms_provider'));
    }
    public function __autoload($class_name)
    {
        include_once($class_name.".php");
    }

    /**
     * Load SMS Gateway Provider
     *
     * @param String $provider
     * @return void
     */
    public function provider($provider)
    {
        $this->from  = config('sms.'.$provider.'.from');
        $class_name =studly_case($provider.'Gateway');
        $file = dirname(__FILE__).'/'.$class_name.".php";
        if (!file_exists($file)) {
            throw new LaravelSmsException("We could not found Gateway Provider  : {$file}");
        }
        $provider = resolve("Isurindu\\LaravelSms\\Gateways\\".$class_name);
        $this->provider = $provider;

        if (!$this->provider instanceof SmsInterface) {
            throw new LaravelSmsException("Provider must implement on LaravelSmsInterface");
        }
        return $this;
    }

    public function to($to)
    {
        $this->to = $to;
        return $this;
    }
    public function from($from)
    {
        $this->from = $from;
        return $this;
    }
    public function send($msg)
    {
        try {
            $this
            ->provider

            ->sendSms($this->to, $msg, $this->from);
        } catch (LaravelSmsGatewayException $e) {
            if (!$this->_isEnableFallback()) {
                throw new LaravelSmsException($e->getMessage(), 1);
            }
            $this
            ->provider(config('sms.fallback_sms_provider'))
            ->send($msg);
        }
    }
    protected function _isEnableFallback()
    {
        return (config('sms.fallback_sms_provider') == null?false:true);
    }
}
