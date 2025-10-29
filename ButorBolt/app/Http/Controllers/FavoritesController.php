<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FavoritesController extends Controller
{
    public function index(Request $request)
    {
        $favourites = $request->session()->get('favourites', []);
        $categories = collect($favourites)->pluck('category')->unique()->values()->all();
        return view('favourite', ['favourites' => array_values($favourites), 'categories' => $categories]);
    }

    public function add(Request $request, $id)
    {
        $id = (int) $id;
        $favourites = $request->session()->get('favourites', []);

        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'price'    => 'nullable|numeric|min:0',
            'img'      => 'nullable|string',
            'category' => 'nullable|string|max:100',
        ]);

        $product = [
            'id'       => $id,
            'name'     => $data['name'],
            'price'    => isset($data['price']) ? (float)$data['price'] : 0,
            'img'      => $data['img'] ?? '',
            'category' => $data['category'] ?? '',
        ];

        $favourites[$id] = $product;
        $request->session()->put('favourites', $favourites);

        return back()->with('success', 'Hozzáadva a kedvencekhez.');
    }

    public function remove(Request $request, $id)
    {
        $id = (int) $id;
        $favourites = $request->session()->get('favourites', []);
        if (isset($favourites[$id])) {
            unset($favourites[$id]);
            $request->session()->put('favourites', $favourites);
        }
        return back()->with('success', 'Eltávolítva a kedvencek közül.');
    }
}
