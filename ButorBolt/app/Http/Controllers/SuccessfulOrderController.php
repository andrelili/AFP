<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SuccessfulOrderController extends Controller
{
    public function show()
    {
        return view('successful_order');
    }

}
