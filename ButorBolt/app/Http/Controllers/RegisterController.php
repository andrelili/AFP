<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        if ($request->isMethod('post')) {
            // ADATBÁZIS HELYE
            return redirect()->route('home')->with('success', 'Sikeres regisztráció!');
        }

        return view('register');
    }
}
