<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Services\HemisOAuthClient;
use Illuminate\Support\Facades\Auth;

class HemisAuthController extends Controller
{
    public function redirectToHemis()
    {
        $provider = HemisOAuthClient::provider();
        $authorizationUrl = $provider->getAuthorizationUrl();
        session(['oauth2state' => $provider->getState()]);
        return redirect($authorizationUrl);
    }

    public function handleHemisCallback()
    {
        $provider = HemisOAuthClient::provider();

        if (request('state') !== session('oauth2state')) {
            abort(403, 'Invalid state');
        }

        try {
            $accessToken = $provider->getAccessToken('authorization_code', [
                'code' => request('code'),
            ]);

            $resourceOwner = $provider->getResourceOwner($accessToken);
            $hemisUser = $resourceOwner->toArray();

            // User yaratish yoki topish
            $user = User::updateOrCreate(
                ['email' => $hemisUser['email']],
                [
                    'name' => $hemisUser['name'] ?? $hemisUser['login'],
                    'password' => bcrypt('hemis_default'), // optional, chunki oAuth
                ]
            );

            Auth::login($user);
            return redirect()->intended('/home');

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
