<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Profil oldal megjelenítése
     */
    public function show()
    {
        // fontos: a view neve pontosan a resources/views/profil.blade.php fájlhoz igazodjon
        return view('profil');
    }

    /**
     * Felhasználói adatok frissítése
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // validálás
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'address' => 'nullable|string|max:255',
        ]);

        // adatok mentése
        $user->update($validated);

        return back()->with('success', 'Profil adatai frissítve.');
    }

    /**
     * Profilkép frissítése
     */
    public function updatePicture(Request $request)
    {
        $user = Auth::user();

        if ($request->hasFile('profile_picture')) {

            $file = $request->file('profile_picture');

            // Új kép mentése a "public" diszken (storage/app/public/profile_pics)
            $path = $file->store('profile_pics', 'public');

            // Régi kép törlése, ha létezik
            if ($user->profile_picture && Storage::disk('public')->exists($user->profile_picture)) {
                Storage::disk('public')->delete($user->profile_picture);
            }

            // Csak a relatív útvonalat mentjük, pl. "profile_pics/valami.jpg"
            $user->profile_picture = $path;
            $user->save();
        }

        return back()->with('success', 'Profilkép frissítve.');
    }
}
