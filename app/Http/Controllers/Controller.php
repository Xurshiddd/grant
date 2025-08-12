<?php

namespace App\Http\Controllers;
use Carbon\Carbon;

abstract class Controller
{
    protected function check($userData){
        $groups = [
            '29-24', '22-24', '22a-24', '3-24', '3a-24', '31-24', '24-24', '24a-24', '2-24', '1-24', 'M22-24', 'M3-24', 'M27-24', 'M1-24', 'M24-24', 'M2-24',
            '4-24','5-24','6-24','7-24','8-24','8r-24','9-24','16-24','16r-24','28-24','M23-24','M9-24','M7-24','M4-24','M5-24','M8-24','M16-24', 'M17-24',
            '10-24', '10r-24', '12-20-24', '18-24', '25-24', '25a-24', '25b-24', '25r-24', '27-24', '30-24', '35-24', 'M25-24', 'M10-11-24', 'M12-20-24', 'M30-24',
            '13-24','13a-24','13b-24','13v-24','13r-24','14-24','14a-24','14b-24','14v-24','14r-24','19-24','19a-24','19b-24','19v-24','19r-24','32-24','33-24','34-24','M13-24','M14-24'
        ];
        $code = $userData['data']['educationType']['code'];
            if (!in_array($code, ['11', '12'])) {
                return response()->json(['message' => "Faqat bakalavr yoki magistr roʻyxatdan oʻtishi mumkin", 'error' => true]);
            }
            if ($userData['data']['educationForm']['code'] != '11' && !in_array($userData['data']['group']['name'], $groups)) {
                return response()->json(['message' => "Siz 1-kurs talabasi bo'lmaganingiz uchun ariza topshira olmaysiz.", 'error' => true]);
            }
            if ((float) $userData['data']['avg_gpa'] < 3.5) {
                return response()->json(['message' => "Sizning o'rtacha baholaringiz 3.50 dan past bo'lgani uchun ariza topshira olmaysiz.", 'error' => true]);
            }
        
        return response()->json(['message' => "Grantga ariza topshirish platformasiga xush kelibsiz!", 'error' => false]);
    }
}
