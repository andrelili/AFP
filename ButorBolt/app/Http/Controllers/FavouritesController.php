<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavouritesController extends Controller
{
    public function index(Request $request)
    {
        $favourites = $request->session()->get('favourites', []);
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

        $id = (int) $id;
        $favourites = $request->session()->get('favourites', []);

        $product = [
            'id'       => $id,
            'name'     => $request->input('name', ''),
            'price'    => (float) $request->input('price', 0),
            'img'      => $request->input('img', ''),
            'category' => $request->input('category', ''),
        ];

        $favourites[$id] = $product;
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
