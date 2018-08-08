<?php


return [
    'default_sms_provider'=>env('SMS_PROVIDER', 'dialog'),//dialog,shoutout,log
    'fallback_sms_provider'=>env('SMS_PROVIDER_FALLBACK', ''), //alternative sms provider for an emergency

    'shoutout'=>[
        'api_key'=>env('SHOUTOUT_API_KEY', 'XXXXXXXXX.XXXXXXXXX.XXXXXXXXX'),
        'from'=>env('SHOUTOUT_FROM_NUMBER', 'YOUR_NUMBER_MASK_HERE'),
    ],
    'dialog'=>[
        'username'=>env('DIALOG_USERNAME', ''),
        'password'=>env('DIALOG_PASSWORD', ''),
        'from'=>env('DIALOG_FROM_NUMBER', 'YOUR_NUMBER_MASK_HERE'),
    ],
];
