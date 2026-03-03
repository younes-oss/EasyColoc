<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function showLoginForm()
    {
        return view('auth.login');
    }


    // Traiter le login
public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        
        if (Auth::user()->is_banned) {
            Auth::logout();
            return back()->withErrors([
                'email' => 'Votre compte est banni.',
            ]);
        }
        
        $request->session()->regenerate();
        
        if (Auth::user()->is_admin) {
            return redirect('/dashboardAdmin');
        } else {
            return redirect('/dashboard');
        }
    }

    return back()->withErrors([
        'email' => 'Identifiants incorrects.',
    ]);
}

    public function showRegisterForm()
    {
        return view('auth.register');
    }


    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if (User::count() === 1) {
            $user->is_admin = true;
            $user->save();
        }

        Auth::login($user);

        return redirect('/dashboard');
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
