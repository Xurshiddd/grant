<?php

namespace App\Http\Controllers;

use App\Models\Audit;
use App\Models\Message;
use App\Models\StudentData;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use League\OAuth2\Client\Provider\GenericProvider;
use Carbon\Carbon;
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
            $now = Carbon::now();
            $deadline = Carbon::create($now->year, 8, 11);
            if ($now->greaterThan($deadline)) {
                return redirect()-route('welcome')->with('error','Ariza qabul qilish muddati tugagan!');
            }
            Log::info('Hemis user data:', $userData);
            // 2. Student ma'lumotlarini yaratish yoki yangilash
            DB::beginTransaction();
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
                'education_direction_code' => $userData['data']['specialty']['code'] ?? null,
                'is_rus' => $userData['groups']['education_lang']['name'] == 'Rus' ? true : false,
                ]
            );
            $gpa = round($userData['data']['avg_gpa'],1);
            Audit::create([
                'user_id' => $user->id,
                'event' => 'Baholash',
                'comment' => 'Talabaning GPA ko‘rsatkichi:'. $gpa,
                'category_id' => 13,
                'auditable_id' => 1,
                'old_values' => '0',
                'new_values' => $this->gpaToScore((string)$gpa),
            ]);
            Message::create([
                'user_id' => $user->id,
                'subject' => 'Avtomatik baholash',
                'body' => "Sizga Talabaning akademik oʻzlashtirishi mezoni bo'yicha {$this->gpaToScore((string)$gpa)} ball berildi.",
                'is_read' => false,
            ]);
            try {
                StudentData::create([
                    'user_id' => $user->id,
                    'data' => json_encode($userData)
                ]);
            } catch (\Exception $e) {
                \Log::error('data saved error', [$e]);
            }
            DB::commit();
            Auth::login($user);
            
            // 4. Profil sahifasiga yo'naltirish
            return redirect()->route('profile')->with('success', $data['message']); // 'profile' nomli marshrutga yo'naltirish
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('welcome')->withErrors(['error' => 'Hemis tizimiga kirishda xatolik yuz berdi: ' . $e->getMessage()]);
        }
    }
    private function gpaToScore($gpa)
    {
        $map = [
            '5' => 10.0,
            '4.9' => 9.7,
            '4.8' => 9.3,
            '4.7' => 9.0,
            '4.6' => 8.7,
            '4.5' => 8.3,
            '4.4' => 8.0,
            '4.3' => 7.7,
            '4.2' => 7.3,
            '4.1' => 7.0,
            '4' => 6.7,
            '3.9' => 6.3,
            '3.8' => 6.0,
            '3.7' => 5.7,
            '3.6' => 5.3,
            '3.5' => 5.0,
        ];
        
        return $map[$gpa] ?? 0;
    }
}
