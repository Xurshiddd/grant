<?php

namespace App\Http\Controllers;

use App\Models\StudentData;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use League\OAuth2\Client\Provider\GenericProvider;
use Carbon\Carbon;

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
            
            $response = $this->check($userData);
            $data = $response->getData(true);
            if ($data['error']) {
                return redirect()->route('welcome')->withErrors([
                    'error' => $data['message']
                ]);
            }
            $user = User::where('student_id_number', $userData['student_id_number'])->first();
            if (!empty($user) && $userData['student_id_number'] == $user->student_id_number) {
                Auth::login($user);
                Session::flash('success', 'Grantga ariza berish tizimiga muvaffaqiyatli kirildi.');
                // 4. Profil sahifasiga yo'naltirish
                return redirect()->route('profile')->with('success', 'Grantga ariza berish tizimiga muvaffaqiyatli kirildi.'); // 'profile' nomli marshrutga yo'naltirish
            }
            Log::info('Hemis user data:', $userData);
            // 2. Student ma'lumotlarini yaratish yoki yangilash
            $user = User::create([
                'student_id_number' => $userData['student_id_number'],
                'email' => $userData['email'] ?: $userData['login'] . '@student.hemis.uz',
                'uuid' => $userData['uuid'],
                'type' => $userData['type'] ?? 'student',
                'firstname' => $userData['firstname'] ?? '',
                'surname' => $userData['surname'] ?? '',
                'father_name' => $userData['patronymic'] ?? '',
                'image' => $userData['picture'] ?? null,
                'full_name' => $userData['data']['full_name'] ?? null,
                'birth_date' => $userData['birth_date'] ?? null,
                'passport_pnfl' => $userData['passport_pin'] ?? null,
                'passport_number' => $userData['passport_number'] ?? null,
                'education_form' => $userData['data']['educationForm']['name'] ?? null,
                'education_type' => $userData['data']['educationType']['name'] ?? null,
                'livel' => $userData['data']['level']['name'] ?? null,
                'group_name' => $userData['data']['group']['name'] ?? null,
                'avg_gpa' => $userData['data']['avg_gpa'] ?? null,
                'address' => $userData['data']['address'] ?? null,
                'country' => $userData['data']['country']['name'] ?? null,
                'phone' => $userData['data']['phone'] ?? null,
                'faculty' => $userData['data']['faculty']['code'] ?? null,
                ]
            );
            try {
                StudentData::create([
                    'user_id' => $user->id,
                    'data' => json_encode($userData)
                ]);
            } catch (\Exception $e) {
                \Log::error('data saved error', [$e]);
            }
            Auth::login($user);
            
            // 4. Profil sahifasiga yo'naltirish
            return redirect()->route('profile')->with('success', $data['message']); // 'profile' nomli marshrutga yo'naltirish
        } catch (\Exception $e) {
            return redirect()->route('welcome')->withErrors(['error' => 'Hemis tizimiga kirishda xatolik yuz berdi: ' . $e->getMessage()]);
        }
    }
}
