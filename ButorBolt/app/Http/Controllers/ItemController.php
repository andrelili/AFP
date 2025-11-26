<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    public function show($id)
    {
        $item = Product::findOrFail((int)$id);

        $stock = $item->stock ?? 0;

        $reviews = Review::where('item_id', $item->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $userHasReviewed = Auth::check() 
            ? Review::where('item_id', $item->id)->where('user_id', Auth::id())->exists() 
            : false;

        return view('item', compact('item','stock','reviews', 'userHasReviewed'));
    }

    public function addReview(Request $request, $id)
    {
        if (!$request->user()) {
            return redirect()->back()->with('login_required', 'Értékelés írásához jelentkezz be.');
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:500',
        ]);

        $user = $request->user();

        $already = Review::where('item_id', (int)$id)
            ->where('user_id', $user->id)
            ->exists();

        if ($already) {
            return redirect()->back()->with('info', 'Már értékelted ezt a terméket.');
        }

        $item = Product::findOrFail($id);

        $userName = $user->username ?? $user->name ?? trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? ''));

        Review::create([
            'item_id' => $item->id,
            'item_name' => $item->name,
            'user_id' => $user->id,
            'user_name' => $userName,
            'rating' => (int)$request->input('rating'),
            'comment' => $request->input('comment'),
        ]);

        return redirect()->back()->with('success', 'Köszönjük az értékelést!');
    }
}