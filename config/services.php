<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    'facebook' => [
        'client_id' => '411088043579093',  //client face của bạn
        'client_secret' => '228f8516c51810ef90d3c55c4bff1198',  //client app service face của bạn
        'redirect' => 'http://localhost:8080/webbanhang/admin/callback' //callback trả về
    ],
    'google' => [
        'client_id' => '1052732598720-fclv5n0itc8njp2pukb0drcfqkqpja59.apps.googleusercontent.com',
        'client_secret' => 'ywR_OjK969foDowCQVTyQP1V',
        'redirect' => 'http://localhost:8080/webbanhang/google/callback' 
    ],

];
