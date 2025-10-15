<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SuccessfulOrderController extends Controller
{
    public function show()
    {
        $message = request()->session()->get('successfulOrder', 'A megrendelésed sikeres volt.');
        return view('successful_order', compact('message'));
    }

}
