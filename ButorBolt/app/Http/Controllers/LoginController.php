<?php

namespace App\Http\Controllers;

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

    $credentials = $request->only('username', 'password');

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();

            if ($request->has('admin_login')) {
                if (Auth::user()->is_admin) {
                    session(['admin_mode' => true]);
                    return redirect()->route('admin.index');
                }else{
                    Auth::logout();
                    return back()->withErrors([
                        'username' => 'Nincs admin jogosultságod.'
                    ])->withInput($request->only('username'));
                }
            }

            if ($request->filled('return_to')) {
                return redirect($request->input('return_to'));
            }

            session()->forget('admin_mode');
            return redirect()->intended(route('home'));
        }

        return back()->withErrors([
            'username' => 'Hibás név vagy jelszó.'
        ])->withInput($request->only('username'));
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        session()->forget('admin_mode');

        return redirect()->route('home');
    }
}