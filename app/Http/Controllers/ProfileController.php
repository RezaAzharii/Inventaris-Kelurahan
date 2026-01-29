<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $peminjam = null;
        if ($user->role === 'isPeminjam') {
            $peminjam = $user->peminjam;
        }

        return view('profile.index', compact('user', 'peminjam'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $user->update([
            'name' => $request->name,
        ]);
        if ($user->role === 'isPeminjam') {
            $validated = $request->validate([
                'nik'     => 'required|digits:16',
                'no_telp' => 'required|max:20',
                'alamat'  => 'required|max:255',
            ]);

            $user->peminjam()->updateOrCreate(
                ['user_id' => $user->id_user],
                $validated
            );
        }

        return back()->with('success', 'Profil berhasil diperbarui');
    }
}