<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validasi untuk login
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);

        // Handle login logic
        // Cek apakah user ada di database
        $user = User::where('email', $request->email)->first();
        
        if (!$user || !Hash::check($request->password, $user->password)) {
            return redirect()->back()->withErrors(['email' => 'Invalid credentials'])
                ->withInput($request->only('email'));
        }
        
        // Cek status user
        if ($user->status !== 'active') {
            return redirect()->back()->withErrors(['email' => 'Your account is inactive.'])
                ->withInput($request->only('email'));
        }
        
        // Set session atau token untuk user menggunakan Laravel
        Auth::login($user);
        
        // Redirect ke halaman dashboard atau halaman yang diinginkan
        return redirect()->route('dashboard')->with('success', 'Login successful');
    }
    
    public function logout(Request $request)
    {
        Auth::logout();
    
        // Invalidate the session
        $request->session()->invalidate();
    
        // Regenerate CSRF token
        $request->session()->regenerateToken();
    
        // Redirect ke halaman login (atau halaman lain sesuai kebutuhan)
        return redirect('/login');
    }

    public function register(Request $request)
    {
        //buatkan validasi untuk register
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:Pharmacist,Technician',
        ]);
        // Handle registration logic
        // Simpan user ke database
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'status' => 'inactive',
        ]);
        return redirect()->route('login')->with('success', 'Registration successful. Please wait for admin approval.');
    }
    public function showLoginForm()
    {
        return view('auth.login');
    }
    public function showRegisterForm()
    {
        return view('auth.register');
    }
}
