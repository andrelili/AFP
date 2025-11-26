<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;

class HomeController extends Controller
{
   public function show() {
        $products = Product::with('reviews')->get();

        $products->map(function ($p) {
            $p->rating = $p->reviews->avg('rating') ?? 0;
            return $p;
        });

        $categories = $products->pluck('category')->unique()->sort()->values();

        return view('home', compact('products', 'categories'));
    }
}
