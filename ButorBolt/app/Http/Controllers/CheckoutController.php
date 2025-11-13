<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class CheckoutController extends Controller
{
    public function show()
    {
        return view('checkout');
    }

    public function process(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'billing_address' => 'required|string|max:255',
            'payment_method' => 'required|string|in:card,cod,paypal',
        ]);

        $cart = session()->get('cart', []);
        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['qty']);

        $stockFile = resource_path('data/stock.json');
        $stockList = file_exists($stockFile) ? json_decode(file_get_contents($stockFile), true) : [];

        foreach ($cart as $item) {
            $id = (int)($item['id'] ?? 0);
            $qty = (int)($item['qty'] ?? 0);
            $stockItem = collect($stockList)->firstWhere('id', $id);
            $available = $stockItem['stock'] ?? 0;
            if ($qty > $available) {
                return back()->withErrors([
                    'stock' => "A(z) {$item['name']} termékből csak {$available} van raktáron."
                ])->withInput();
            }
        }

        Order::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            'billing_address' => $data['billing_address'],
            'payment_method' => $data['payment_method'],
            'cart_items' => json_encode($cart),
            'total' => $total,
        ]);

        foreach ($cart as $item) {
            $id = (int)($item['id'] ?? 0);
            $qty = (int)($item['qty'] ?? 0);
            foreach ($stockList as &$s) {
                if (($s['id'] ?? null) === $id) {
                    $s['stock'] = max(0, (int)($s['stock'] ?? 0) - $qty);
                    break;
                }
            }
            unset($s);
        }
        file_put_contents($stockFile, json_encode($stockList, JSON_PRETTY_PRINT));


        session()->forget(['cart', 'cart_count']);

        return redirect()->route('successful.order');
    }

    public function showPaymentForm(Request $request)
    {
        if ($request->payment_method !== 'card') {
        return redirect()->route('bag.checkout')->with('error', 'Kérlek válassz bankkártyás fizetést!');
    }

    return view('payment.payment_form');
    }

}
