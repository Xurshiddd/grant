<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    
    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
        
        $remember = $request->has('remember');
        
        // Foydalanuvchini topamiz
        $user = User::where('email', $data['email'])->first();
        
        // Agar user topilsa, parolni tekshiramiz
        if ($user && Hash::check($data['password'], $user->password)) {
            Auth::login($user, $remember);
            return redirect('/categories')->with('success', 'Login successful!');
        }
        
        // Agar user topilmasa, uni yaratamiz
        // if (!$user) {
        //     $user = User::create([
        //         'uuid' => uniqid(), // yoki Str::uuid()->toString()
        //         'student_id_number' => rand(100000, 999999),
        //         'email' => $data['email'],
        //         'password' => bcrypt($data['password']),
        //     ]);
        //     Auth::login($user, $remember);
        //     return redirect('/categories')->with('success', 'Login successful!');
        // }
        
        // Parol noto‘g‘ri bo‘lsa
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }
    public function logout()
    {
        Auth::logout();
        return redirect()->route('welcome');
    }
}
