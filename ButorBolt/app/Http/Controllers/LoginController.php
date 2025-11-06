<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class LoginController extends Controller
{
    public function show()
    {
        return view('auth.login');
    }
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = [
            'username' => $request->input('username'),
            'password' => $request->input('password'),
        ];

        if(Auth::attempt($credentials)){
            $request->session()->regenerate();

        if ($request->has('admin_login')) {
            if (Auth::user()->is_admin) {
                return redirect()->route('admin.index');
        } else {
            Auth::logout();
            return back()->withErrors(['username' => 'Nincs admin jogosultságod.'])->withInput();
        }
    }
        return redirect()->intended(route('home'));
        }
        return back()->withErrors(['username' => 'Hibás név vagy jelszó.'])->withInput();
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }
}
