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
        'token' => env('POSTMARK_TOKEN'),
    ],
    'hemis' => [
        'client_id'     => env('HEMIS_CLIENT_ID'),
        'client_secret' => env('HEMIS_CLIENT_SECRET'),
        'redirect'      => env('HEMIS_REDIRECT_URI'),
        'authorize_url' => env('HEMIS_AUTHORIZE_URL'),
        'token_url'     => env('HEMIS_TOKEN_URL'),
        'resource_url'  => env('HEMIS_RESOURCE_URL'),
    ],
    
    
    
    'resend' => [
        'key' => env('RESEND_KEY'),
    ],
    
    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    
    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],
    
];
