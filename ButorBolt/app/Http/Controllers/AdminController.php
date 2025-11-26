<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class AdminController extends Controller
{
    
    protected function loadStock()
    {
        $stockFile = resource_path('data/stock.json');
        if (!file_exists($stockFile)) {
            return [];
        }

        return json_decode(file_get_contents($stockFile), true);
    }

    protected function saveStock($stockData)
    {
        $stockFile = resource_path('data/stock.json');
        file_put_contents($stockFile, json_encode($stockData, JSON_PRETTY_PRINT));
    }

    public function index()
    {
        $stockData = $this->loadStock();

        $products = Product::all();

        foreach ($products as &$p) {
            $stockItem = collect($stockData)->firstWhere('id', $p['id']);
            $p['stock'] = $stockItem['stock'] ?? 0;
        }
        $products = collect($products);
        return view('admin', compact('products'));
    }

    public function store(Request $request)
    {
            $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'category' => 'nullable|string|max:255',
            'img' => 'nullable|url',
        ]);

        Product::create($validated);

        return redirect()->route('admin.index')->with('success', 'Termék hozzáadva!');
    }

    public function update(Request $request, $id)
    {
         $product = Product::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'category' => 'nullable|string|max:255',
            'img' => 'nullable|url',
        ]);

        $product->update($validated);

        return redirect()->route('admin.index')->with('success', 'Termék frissítve!');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('admin.index')->with('success', 'Termék törölve!');
    }

}
