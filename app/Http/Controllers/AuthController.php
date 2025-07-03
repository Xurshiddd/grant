<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $data = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $remember = $request->boolean('remember');
// Auth::attempt(['username' => $data['username'], 'password' => $data['password']], $remember)
        if (!empty($data['password'])) {
            // Login successful
            return response()->json(['message' => 'Login successful'], 200);
        } else {
            // Login failed
            return response()->json(['message' => 'Username or password is incorrect'], 401);
        }
    }
}
