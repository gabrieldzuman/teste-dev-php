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

    'postmark' => [
        'token' => env(key: 'POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env(key: 'AWS_ACCESS_KEY_ID'),
        'secret' => env(key: 'AWS_SECRET_ACCESS_KEY'),
        'region' => env(key: 'AWS_DEFAULT_REGION', default: 'us-east-1'),
    ],

    'resend' => [
        'key' => env(key: 'RESEND_KEY'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env(key: 'SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env(key: 'SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

];
