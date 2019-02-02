<?php

return[
    'timeout' => 5.0,

    'default' => [
        'strategy' => \Overtrue\EasySms\Strategies\OrderStrategy::class,

        'gateways' => [
            'yunpian',
        ],

    ],

    'gateways' => [
        'errorlog' => [
            'file' => '/tmp/easy-sms.log',
        ],

        'yunpian' => [
            'api_key' => env('YUNPIAN_API_KEY'),
        ],

        'qcloud' => [
            'sdk_app_id' => env('QCLOUD_SMS_APP_ID'),
            'app_key' => env('QCLOUD_SMS_APP_KEY'),
        ],

    ],


];