<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjam;
use App\Exports\PeminjamExport;
use Maatwebsite\Excel\Facades\Excel;

class PeminjamController extends Controller
{
    public function export()
    {
        return Excel::download(
            new PeminjamExport,
            'data-peminjam.xlsx'
        );
    }

    public function index(Request $request)
    {
        $query = Peminjam::query();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('id_peminjam', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%")
                  ->orWhere('nama_peminjam', 'like', "%{$search}%")
                  ->orWhere('no_telp', 'like', "%{$search}%");
            });
        }
        $peminjams = $query->paginate(10);
        $peminjams->appends(['search' => $request->search]);

        return view('peminjam.index', compact('peminjams'));
    }

    public function create()
    {
        return view('peminjam.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nik' => 'required',
            'nama_peminjam' => 'required',
            'no_telp' => 'nullable|string|max:20',
        ]);

        Peminjam::create($request->all());

        return redirect()->route('peminjam.index')
            ->with('success', 'Data peminjam berhasil ditambahkan.');
    }

    public function show($id)
    {
        $peminjam = Peminjam::findOrFail($id);
        return view('peminjam.show', compact('peminjam'));
    }

    public function edit($id)
{
    $peminjam = Peminjam::findOrFail($id);
    return view('peminjam.edit', compact('peminjam'));
}


    public function update(Request $request, $id)
    {
        $request->validate([
            'nik' => 'required',
            'nama_peminjam' => 'required',
            'no_telp' => 'nullable|string|max:20',
        ]);

        $peminjam = Peminjam::findOrFail($id);
        $peminjam->update($request->all());

        return redirect()->route('peminjam.index')
            ->with('success', 'Data peminjam berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Peminjam::findOrFail($id)->delete();

        return redirect()->route('peminjam.index')
            ->with('success', 'Data peminjam berhasil dihapus.');
    }
}
