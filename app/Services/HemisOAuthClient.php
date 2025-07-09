<?php

namespace App\Services;

use League\OAuth2\Client\Provider\GenericProvider;

class HemisOAuthClient
{
    public static function provider()
    {
        return new GenericProvider([
            'clientId'                => config('services.hemis.client_id'),
            'clientSecret'            => config('services.hemis.client_secret'),
            'redirectUri'             => config('services.hemis.redirect'),
            'urlAuthorize'            => config('services.hemis.url_authorize'),
            'urlAccessToken'          => config('services.hemis.url_token'),
            'urlResourceOwnerDetails' => config('services.hemis.url_resource'),
        ]);
    }
}
