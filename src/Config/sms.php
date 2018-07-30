<?php


return [
    'default_sms_provider'=>env('SMS_PROVIDER', 'shoutout'),//shoutout,log
    'fallback_sms_provider'=>env('SMS_PROVIDER_FALLBACK', 'log'), //alternative sms provider for an emergency

    'shoutout'=>[
        'api_key'=>env('SHOUTOUT_API_KEY', 'XXXXXXXXX.XXXXXXXXX.XXXXXXXXX'),
        'from'=>'GIFTUP',
    ]
];
