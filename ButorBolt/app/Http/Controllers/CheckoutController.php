<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;

class CheckoutController extends Controller
{
    public function show(Request $request)
    {
        $cart = $request->session()->get('cart', []);
        $stockMap = [];
        foreach ($cart as $id => $item) {
            $product = Product::find($id);
            $stockMap[$id] = $product->stock ?? 0;
        }

        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['qty']);

        return view('checkout', compact('cart', 'total', 'stockMap'));
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

        $cart = $request->session()->get('cart', []);
        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['qty']);

        // Ellenőrzés: van-e elegendő készlet
        foreach ($cart as $id => $item) {
            $product = Product::find($id);
            if (!$product) {
                return back()->withErrors(['cart' => 'Egy termék nem található.']);
            }

            if ($item['qty'] > $product->stock) {
                return back()->withErrors([
                    'stock' => "A(z) {$product->name} termékből csak {$product->stock} van raktáron."
                ]);
            }
        }

        // Megrendelés mentése adatbázisba
        $cartItems = array_map(fn($i) => [
            'id' => $i['id'],
            'name' => $i['name'],
            'price' => $i['price'],
            'qty' => $i['qty']
        ], $cart);

        Order::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            'billing_address' => $data['billing_address'],
            'payment_method' => $data['payment_method'],
            'cart_items' => json_encode($cartItems, JSON_UNESCAPED_UNICODE),
            'total' => $total,
        ]);

        // Készlet frissítése - csak egyszer
        foreach ($cart as $id => $item) {
            $product = Product::find($id);
            if ($product) {
                $product->decrement('stock', $item['qty']);
            }
        }

        // Kosár ürítése
        $request->session()->forget(['cart', 'cart_count']);

        return redirect()->route('successful.order')->with('success', 'Rendelés sikeresen leadva!');
    }

    public function showPaymentForm(Request $request)
    {
        if ($request->payment_method !== 'card') {
            return redirect()->route('bag.checkout')->with('error', 'Kérlek válassz bankkártyás fizetést!');
        }

        return view('payment.payment_form');
    }
}
