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
            $now = Carbon::now();
            $deadline = Carbon::create($now->year, 7, 25);
            if ($now->greaterThan($deadline)) {
                return redirect()->route('welcome')->withErrors([
                    'error' => "Ariza qabul qilish muddati tugagan."
                ]);
            }
            $code = $userData['data']['educationType']['code'];
            if (!in_array($code, ['11', '12'])) {
                return redirect()->route('welcome')->withErrors([
                    'error' => "Faqat bakalavr yoki magistr roʻyxatdan oʻtishi mumkin"
                ]);
            }
            if ($userData['data']['level']['code'] != '11' || $userData['data']['educationForm']['code'] != '11') {
                return redirect()->route('welcome')->withErrors([
                    'error' => "Siz 1-kurs talabasi bo'lmaganingiz uchun ariza topshira olmaysiz."
                ]);
            }
            if ((float) $userData['data']['avg_gpa'] < 3.5) {
                return redirect()->route('welcome')->withErrors([
                    'error' => "Sizning o'rtacha baholaringiz 3.50 dan past bo'lgani uchun ariza topshira olmaysiz."
                ]);
            }
            
            $user = User::where('student_id_number', $userData['student_id_number'])->first();
            if (!empty($user) && $userData['student_id_number'] == $user->student_id_number) {
                Auth::login($user);
                Session::flash('success', 'Hemis tizimiga muvaffaqiyatli kirildi.');
                // 4. Profil sahifasiga yo'naltirish
                return redirect()->route('profile')->with('success', 'Hemis tizimiga muvaffaqiyatli kirildi.'); // 'profile' nomli marshrutga yo'naltirish
            }
            // dd($userData);
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
            
            // 3. Login qilish
            Auth::login($user);
            
            // 4. Profil sahifasiga yo'naltirish
            return redirect()->route('profile')->with('success', 'Hemis tizimiga muvaffaqiyatli kirildi.'); // 'profile' nomli marshrutga yo'naltirish
        } catch (\Exception $e) {
            return redirect()->route('welcome')->withErrors(['error' => 'Hemis tizimiga kirishda xatolik yuz berdi: ' . $e->getMessage()]);
        }
    }
}
