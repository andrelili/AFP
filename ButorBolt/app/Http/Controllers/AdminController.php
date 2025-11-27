<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function index()
    {
        $products = Product::all(); 
        return view('admin', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer|min:0',
            'category' => 'nullable|string|max:255',
            'img' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
        ]);


        if ($request->hasFile('img')) {
            $path = $request->file('img')->store('products', 'public');
            $validated['img'] = '/storage/' . $path;
        }

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
            'img' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'stock' => 'required|integer|min:0',
        ]);

        if ($request->hasFile('img')) {
            $file = $request->file('img');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/products'), $filename);
            $validated['img'] = '/uploads/products/' . $filename;
        } else {
            unset($validated['img']);
        }

        $product->update($validated);

        return redirect()->route('admin.index')->with('success', 'Termék frissítve!');
    }


    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if ($product->img && Storage::disk('public')->exists(str_replace('/storage/', '', $product->img))) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $product->img));
        }

        $product->delete();

        return redirect()->route('admin.index')->with('success', 'Termék törölve!');
    }
}
