<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class authController extends Controller
{
    public function index()
    {
        return view('Auth.index');
    }
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            if (auth()->user()->is_activated == 1) {
                return redirect()->intended('dashboard');
            } else {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect('/login')->with('loginError', 'User belum diaktivasi !');
            }
        }
        return back()->with('loginError', 'Login gagal !');
    }
}
