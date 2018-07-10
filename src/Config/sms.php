<?php


return [
    'default_sms_provider'=>'shoutout',
    'fallback_sms_provider'=>'', //alternative sms provider for an emergency

    'shoutout'=>[
        'api_key'=>env('SHOUTOUT_API_KEY', 'XXXXXXXXX.XXXXXXXXX.XXXXXXXXX'),
        'from'=>'ShoutDEMO',
    ]
];
