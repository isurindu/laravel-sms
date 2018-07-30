# Laravel SMS - simple sms package for laravel

### Support Gateways

- shoutout
- mobitel (coming soon)
- dialog (coming soon)

### Installation

You can install the package via composer:

```bash
composer require isurindu/laravel-sms
```

In Laravel 5.5 the service provider will automatically get registered. In older versions of the framework just add the service provider in `config/app.php` file:

```php
'providers' => [
    // ...
    Isurindu\LaravelSms\LaravelSmsServiceProvider::class,
];
```

You can publish config

```bash
php artisan vendor:publish --provider="Isurindu\LaravelSms\LaravelSmsServiceProvider::class"
```

configaration in `config/sms.php`

```php
return [
    'default_sms_provider'=>env('SMS_PROVIDER', 'shoutout'),//shoutout,log
    'fallback_sms_provider'=>env('SMS_PROVIDER_FALLBACK', 'log'), //alternative sms provider for an emergency

    'shoutout'=>[
        'api_key'=>env('SHOUTOUT_API_KEY', 'XXXXXXXXX.XXXXXXXXX.XXXXXXXXX'),
        'from'=>'GIFTUP',
    ]
];
```

## Usage

```php
<?php

use Isurindu\LaravelSms\Facades\Sms;

Sms::to('94702125238')
    ->send('hello world');
```

## Add New SMS Gateway

```php
Sms::provider('mobitel')
    ->to('94702125238')
    ->send('hello world');
```

if provider is _mobitel_ class name must be located at _Gateways\MobitelGateway_

```php
<?php
namespace Isurindu\LaravelSms\Gateways;

use Isurindu\LaravelSms\Interfaces\SmsInterface;
use Isurindu\LaravelSms\Exceptions\LaravelSmsGatewayException;

class MobitelGateway implements SmsInterface
{
    public function sendSms($to, $msg, $from)
    {
        //send sms logic here
        //if something went wrong  throw new LaravelSmsGatewayException('something went wrong');

    }
}
```
