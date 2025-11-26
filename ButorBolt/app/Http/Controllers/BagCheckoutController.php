<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Collection;

class BagCheckoutController extends Controller
{
    public function index(Request $request)
    {
        $cart = $request->session()->get('cart', []);
        $total = collect($cart)->sum(fn($row) => $row['price'] * $row['qty']);

        foreach ($cart as $id => &$row) {
            $product = Product::find($id);
            $row['stock'] = $product ? $product->stock : 0;
        }

        return view('bag', compact('cart', 'total'));
    }

    public function add(Request $request, $id)
    {
        $product = Product::find($id);
        if (!$product) {
            return back()->with('error', 'A termék nem található.');
        }

        $qty = max(1, (int)$request->input('qty', 1));

        $cart = $request->session()->get('cart', []);
        $currentQty = $cart[$id]['qty'] ?? 0;

        if ($qty + $currentQty > $product->stock) {
            return back()->with('error', 'Nincs ennyi raktáron. Elérhető: ' . $product->stock . ' db.');
        }

        if (isset($cart[$id])) {
            $cart[$id]['qty'] += $qty;
        } else {
            $cart[$id] = [
                'id'    => $product->id,
                'name'  => $product->name,
                'price' => $product->price,
                'img'   => $product->img,
                'qty'   => $qty,
            ];
        }

        $request->session()->put('cart', $cart);
        $request->session()->put('cart_count', collect($cart)->sum('qty'));

        return back()->with('success', 'Hozzáadva a kosárhoz.');
    }

    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        if (!$product) {
            return back()->with('error', 'A termék nem található.');
        }

        $qty = max(1, (int)$request->input('qty', 1));

        if ($qty > $product->stock) {
            return back()->with('error', 'Nincs ennyi raktáron. Elérhető: ' . $product->stock . ' db.');
        }

        $cart = $request->session()->get('cart', []);
        if (isset($cart[$id])) {
            $cart[$id]['qty'] = $qty;
            $request->session()->put('cart', $cart);
            $request->session()->put('cart_count', collect($cart)->sum('qty'));
        }

        return back()->with('success', 'Kosár frissítve.');
    }

    public function remove(Request $request, $id)
    {
        $cart = $request->session()->get('cart', []);
        unset($cart[$id]);

        $request->session()->put('cart', $cart);
        $request->session()->put('cart_count', collect($cart)->sum('qty'));

        return back()->with('success', 'Tétel törölve.');
    }

    public function clear(Request $request)
    {
        $request->session()->forget(['cart', 'cart_count']);
        return back()->with('success', 'Kosár ürítve.');
    }

    public function order(Request $request)
    {
        $cart = $request->session()->get('cart', []);

        foreach ($cart as $id => $item) {
            $product = Product::find($id);
            if ($product) {
                $product->stock = max(0, $product->stock - $item['qty']);
                $product->save();
            }
        }

        $request->session()->forget(['cart', 'cart_count']);
        return redirect()->route('checkout')->with('success', 'Rendelés leadva!');
    }
}
