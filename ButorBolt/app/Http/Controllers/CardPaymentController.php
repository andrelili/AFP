<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function showPaymentForm()
    {
        return view('payment.payment_form');
    }

    public function processPayment(Request $request)
    {
        $request->validate([
            'cardholder_name' => 'required|string|max:255',
            'card_number' => 'required|digits:16',
            'expiry' => 'required|regex:/^(0[1-9]|1[0-2])\/(\d{2})$/',
            'cvv' => 'required|digits:3',
        ], [
            'cardholder_name.required' => 'A kártyatulajdonos neve kötelező.',
            'card_number.required' => 'A kártyaszám kötelező.',
            'card_number.digits' => 'A kártyaszámnak 16 számjegyűnek kell lennie.',
            'expiry.required' => 'A lejárati dátum kötelező.',
            'expiry.regex' => 'A lejárati dátum formátuma: HH/ÉÉ.',
            'cvv.required' => 'A CVV kód kötelező.',
            'cvv.digits' => 'A CVV kódnak 3 számjegyűnek kell lennie.',
        ]);

        return redirect()->route('successful.order');
    }
}
