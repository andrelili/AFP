<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BagCheckoutController extends Controller
{
    public function show()
    {
        return view('bag_checkout');
    }
}
