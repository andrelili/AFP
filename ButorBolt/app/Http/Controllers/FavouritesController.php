<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;

class FavouritesController extends Controller
{
    public function index(Request $request)
    {
        $favourites = $request->session()->get('favourites', []);

        // 🔥 Itt számoljuk bele az átlag ratinget
        foreach ($favourites as &$p) {
            $p['rating'] = \App\Models\Review::where('item_id', $p['id'])->avg('rating') ?? 0;
        }

        $categories = collect($favourites)->pluck('category')->unique()->values()->all();

        return view('favourites', [
            'favourites' => array_values($favourites),
            'categories' => $categories
        ]);
    }

    public function add(Request $request, $id)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Bejelentkezés szükséges.'], 401);
        }

        $product = Product::find($id);
        if (!$product) {
            return response()->json(['error' => 'Termék nem található.'], 404);
        }

        $favourites = $request->session()->get('favourites', []);

        $favourites[$product->id] = [
            'id'       => $product->id,
            'name'     => $product->name,
            'price'    => (float) $product->price,
            'img'      => $product->img,
            'category' => $product->category,
        ];

        $request->session()->put('favourites', $favourites);

        return response()->json(['success' => true]);
    }

    public function remove(Request $request, $id)
    {
        $id = (int) $id;
        $favourites = $request->session()->get('favourites', []);

        if (isset($favourites[$id])) {
            unset($favourites[$id]);
            $request->session()->put('favourites', $favourites);
        }

        if ($request->expectsJson()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Eltávolítva a kedvencek közül.');
    }
}
