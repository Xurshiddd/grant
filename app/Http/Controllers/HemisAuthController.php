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
    public function redirectToHemis()
    {
        $provider = new GenericProvider([
            'clientId' => config('services.hemis.client_id'),
            'clientSecret'            => config('services.hemis.client_secret'),
            'redirectUri'             => config('services.hemis.redirect'),
            'urlAuthorize'            => config('services.hemis.authorize_url'),
            'urlAccessToken'          => config('services.hemis.token_url'),
            'urlResourceOwnerDetails' => config('services.hemis.resource_url'),
        ]);
        
        $authorizationUrl = $provider->getAuthorizationUrl();
        session(['oauth2state' => $provider->getState()]);
        
        return redirect()->away($authorizationUrl);
    }
    
    public function handleHemisCallback(Request $request)
    {
        // dd($request->all());
        $provider = new GenericProvider([
            'clientId'                => config('services.hemis.client_id'),
            'clientSecret'            => config('services.hemis.client_secret'),
            'redirectUri'             => config('services.hemis.redirect'),
            'urlAuthorize'            => config('services.hemis.authorize_url'),
            'urlAccessToken'          => config('services.hemis.token_url'),
            'urlResourceOwnerDetails' => config('services.hemis.resource_url'),
        ]);
        
        if ($request->state !== session('oauth2state')) {
            return abort(403, 'Invalid state');
        }
        
        try {
            $accessToken = $provider->getAccessToken('authorization_code', [
                'code' => $request->code
            ]);
            
            $resourceOwner = $provider->getResourceOwner($accessToken);
            $userData = $resourceOwner->toArray();
            dd($userData);
            Log::info('Hemis user data:', $userData);
            // 2. Student ma'lumotlarini yaratish yoki yangilash
            $user = User::updateOrCreate([
                'student_id_number' => $userData['student_id_number'],
                'email' => $userData['email'] ?: $userData['login'] . '@student.hemis.uz',
                'uuid' => $userData['uuid'],
                'firstname' => $userData['firstname'],
                'surname' => $userData['surname'],
                'patronymic' => $userData['patronymic'],
                'full_name' => $userData['data']['full_name'],
                'short_name' => $userData['data']['short_name'] ?? null,
                'email' => $userData['email'] ?? $userData['data']['email'],
                'phone' => $userData['phone'] ?? $userData['data']['phone'],
                'passport_pin' => $userData['passport_pin'],
                'passport_number' => $userData['passport_number'],
                'birth_date' => $userData['birth_date'],
                'university' => $userData['data']['university'],
                'group_name' => $userData['groups'][0]['name'],
                'faculty_name' => $userData['data']['faculty']['name'] ?? null,
                'specialty_name' => $userData['data']['specialty']['name'] ?? null,
                'education_form' => $userData['groups'][0]['education_form']['name'],
                'education_type' => $userData['groups'][0]['education_type']['name'],
                'education_lang' => $userData['groups'][0]['education_lang']['name'],
                'picture' => $userData['data']['image'] ?? $userData['picture'],
                'address' => $userData['data']['address'] ?? null,
                ]
            );
            
            // 3. Login qilish
            Auth::login($user);
            
            // 4. Profil sahifasiga yo'naltirish
            Session::flash('success', 'Hemis tizimiga muvaffaqiyatli kirildi.');
            return view('profile', compact('user')); // 'profile' nomli marshrutga yo'naltirish
            
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors(['error' => 'Hemis tizimiga kirishda xatolik yuz berdi: ' . $e->getMessage()]);
        }
    }
}
