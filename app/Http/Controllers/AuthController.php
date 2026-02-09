<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin() {
        return view('auth.login');
    }

    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // Redirect Admin ke Dashboard Admin
            if(Auth::user()->role == 'admin'){
                return redirect()->route('admin.dashboard');
            }
            // Redirect User ke Home
            return redirect()->intended('/');
        }

        return back()->withErrors(['email' => 'Email atau password salah.']);
    }

    public function showRegister() {
        return view('auth.register');
    }

    public function register(Request $request) {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed'
        ]);

        // Create User (Default username diambil dari nama depan lowercase)
        User::create([
            'name' => $request->name,
            'username' => strtolower(str_replace(' ', '', $request->name)) . rand(1,100), // Generate username otomatis
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user'
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil, silakan login.');
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}