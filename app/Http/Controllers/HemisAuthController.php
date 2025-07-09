<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Services\HemisOAuthClient;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use League\OAuth2\Client\Provider\GenericProvider;

class HemisAuthController extends Controller
{
    protected function getProvider(): GenericProvider
    {
        return new GenericProvider([
            'clientId'                => config('services.hemis.client_id'),
            'clientSecret'            => config('services.hemis.client_secret'),
            'redirectUri'             => config('services.hemis.redirect'),
            'urlAuthorize'            => config('services.hemis.authorize_url'),
            'urlAccessToken'          => config('services.hemis.token_url'),
            'urlResourceOwnerDetails' => config('services.hemis.resource_url'),
        ]);
    }

    public function redirectToHemis()
    {
        $provider = $this->getProvider();
        $authorizationUrl = $provider->getAuthorizationUrl();

        // state ni saqlaymiz (CSRF himoya)
        Session::put('oauth2state', $provider->getState());

        return redirect($authorizationUrl);
    }

    public function handleHemisCallback(Request $request)
    {
        $provider = $this->getProvider();

        // 1. CSRF himoya (state tekshiruvi)
        $sessionState = Session::pull('oauth2state');
        if (!$request->has('state') || $request->state !== $sessionState) {
            abort(403, 'Invalid state value');
        }

        try {
            // 2. access token olish
            $accessToken = $provider->getAccessToken('authorization_code', [
                'code' => $request->get('code'),
            ]);

            // 3. foydalanuvchi ma'lumotlarini olish
            $resourceOwner = $provider->getResourceOwner($accessToken);
            $hemisUser = $resourceOwner->toArray();

            if (empty($hemisUser['email'])) {
                throw new \Exception('Foydalanuvchining emaili yo‘q');
            }

            // 4. Bazaga yozish (yoki yangilash)
            $user = User::updateOrCreate(
                ['email' => $hemisUser['email']],
                [
                    'name' => $hemisUser['name'] ?? $hemisUser['login'] ?? 'HEMIS user',
                    'password' => bcrypt('hemis_default'), // Parol ishlatilmaydi
                    'email_verified_at' => now(),           // Agar kerak bo‘lsa
                ]
            );

            // 5. Autentifikatsiya qilish
            Auth::login($user);

            return redirect()->intended('/profile');

        } catch (\Exception $e) {
            Log::error('HEMIS Auth error: '.$e->getMessage());
            return redirect('/login')->with('error', 'HEMIS login muvaffaqiyatsiz: '.$e->getMessage());
        }
    }
}
