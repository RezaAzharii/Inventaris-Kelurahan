<?php

namespace App\Http\Controllers;

use App\Models\Aset;
use Illuminate\Http\Request;
use App\Exports\AsetExport;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class AsetController extends Controller
{
    public function export()
    {
        return Excel::download(
            new AsetExport,
            'data-aset.xlsx'
        );
    }

    public function index(Request $request)
    {
        $query = Aset::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('kode_barang', 'like', "%{$search}%")
                    ->orWhere('jenis_barang', 'like', "%{$search}%")
                    ->orWhere('identitas_barang', 'like', "%{$search}%")
                    ->orWhere('pengelola_barang', 'like', "%{$search}%");
            });
        }
        $asets = $query->paginate(10);
        $asets->appends(['search' => $request->search]);

        return view('aset.index', compact('asets'));
    }

    public function showPublic($id)
    {
        $aset = Aset::findOrFail($id);
        return view('aset.show_public', compact('aset'));
    }

    public function create()
    {
        return view('aset.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_barang'      => 'required|string|max:100',
            'kode_barang'       => 'required|string|max:50|unique:asets,kode_barang',
            'identitas_barang'  => 'required|string|max:100',
            'pengelola_barang'  => 'required|string|max:100',
            'tahun_perolehan',
            'jumlah'            => 'required|integer|min:1',
            'nilai_perolehan',
            'nilai_saat_ini',
            'keterangan'        => 'nullable|string',
            'foto'              => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->except('foto');

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('aset', 'public');
        }

        Aset::create($data);

        return redirect()
            ->route('aset.index')
            ->with('success', 'Data aset berhasil ditambahkan.');
    }


    public function show($id)
    {
        $aset = Aset::findOrFail($id);
        return view('aset.show', compact('aset'));
    }

    public function edit($id)
    {
        $aset = Aset::findOrFail($id);
        return view('aset.edit', compact('aset'));
    }

    public function update(Request $request, $id)
    {
        $aset = Aset::findOrFail($id);

        $request->validate([
            'jenis_barang'      => 'required|string|max:100',
            'kode_barang'       => 'required|string|max:50|unique:asets,kode_barang,' . $aset->id_aset . ',id_aset',
            'identitas_barang'  => 'required|string|max:100',
            'pengelola_barang'  => 'required|string|max:100',
            'tahun_perolehan'   => 'required|date',
            'jumlah'            => 'required|integer|min:1',
            'nilai_perolehan'   => 'nullable|numeric',
            'nilai_saat_ini'    => 'nullable|numeric',
            'keterangan'        => 'nullable|string',
            'foto'              => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->except('foto');

        if ($request->hasFile('foto')) {
            if ($aset->foto && Storage::disk('public')->exists($aset->foto)) {
                Storage::disk('public')->delete($aset->foto);
            }

            $data['foto'] = $request->file('foto')->store('aset', 'public');
        }

        $aset->update($data);

        return redirect()
            ->route('aset.index')
            ->with('success', 'Data aset berhasil diperbarui.');
    }


    public function destroy($id)
    {
        $aset = Aset::findOrFail($id);

        if ($aset->foto && Storage::disk('public')->exists($aset->foto)) {
            Storage::disk('public')->delete($aset->foto);
        }

        $aset->delete();

        return redirect()
            ->route('aset.index')
            ->with('success', 'Data berhasil dihapus.');
    }
}