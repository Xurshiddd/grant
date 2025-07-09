<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Services\HemisOAuthClient;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use League\OAuth2\Client\Provider\GenericProvider;
use Illuminate\Support\Facades\DB;

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
            if ((float) $userData['data']['avg_gpa'] < 3.5) {
                return redirect()->route('welcome')->withErrors([
                    'error' => "Sizning o'rtacha baholaringiz 3.50 dan past bo'lgani uchun ariza topshira olmaysiz."
                ]);
            }
            
            $user = User::where('uuid', $userData['uuid'])->first();
            if (!empty($user) && $userData['uuid'] == $user->uuid) {
                Auth::login($user);
                Session::flash('success', 'Hemis tizimiga muvaffaqiyatli kirildi.');
                // 4. Profil sahifasiga yo'naltirish
                return redirect()->route('profile')->with('success', 'Hemis tizimiga muvaffaqiyatli kirildi.'); // 'profile' nomli marshrutga yo'naltirish
            }
            Log::info('Hemis user data:', $userData);
            // 2. Student ma'lumotlarini yaratish yoki yangilash
            $user = User::updateOrCreate([
                'student_id_number' => $userData['student_id_number'],
                'email' => $userData['email'] ?: $userData['login'] . '@student.hemis.uz',
                'uuid' => $userData['uuid'],
                'type' => $userData['type'],
                'firstname' => $userData['firstname'],
                'surname' => $userData['surname'],
                'father_name' => $userData['patronymic'],
                'image' => $userData['picture'] ?? null,
                'full_name' => $userData['data']['full_name'],
                'birth_date' => $userData['birth_date'],
                'passport_pnfl' => $userData['passport_pin'],
                'passport_number' => $userData['passport_number'],
                'education_form' => $userData['educationForm']['name'] ?? null,
                'education_type' => $userData['educationType']['name'] ?? null,
                'livel' => $userData['livel']['name'] ?? null,
                'group_name' => $userData['group']['name'] ?? null,
                'avg_gpa' => $userData['data']['avg_gpa'] ?? null,
                'address' => $userData['data']['address'] ?? null,
                'country' => $userData['country']['name'] ?? null,
                'phone' => $userData['phone'] ?? null,
                ]
            );
            
            // 3. Login qilish
            Auth::login($user);
            
            // 4. Profil sahifasiga yo'naltirish
            return redirect()->route('profile')->with('success', 'Hemis tizimiga muvaffaqiyatli kirildi.'); // 'profile' nomli marshrutga yo'naltirish
        } catch (\Exception $e) {
            return redirect()->route('welcome')->withErrors(['error' => 'Hemis tizimiga kirishda xatolik yuz berdi: ' . $e->getMessage()]);
        }
    }
}
