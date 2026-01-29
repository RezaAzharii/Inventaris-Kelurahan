<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Peminjam;
use App\Models\Aset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\PeminjamanExport;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class PeminjamanController extends Controller
{
    public function export(Request $request)
    {
        return Excel::download(
            new PeminjamanExport($request->search),
            'data-peminjaman.xlsx'
        );
    }


    public function index(Request $request)
    {
        $query = Peminjaman::with(['peminjam', 'aset']);

        $user = Auth::user();
        if ($user->role === 'isPeminjam') {
            $query->whereHas('peminjam', function ($q) {
                $q->where('user_id', Auth::id());
            });
        }

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('tanggal_pinjam', 'like', "%{$search}%")
                    ->orWhere('tanggal_kembali', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%")
                    ->orWhereHas('peminjam', function ($p) use ($search) {
                        $p->where('nama_peminjam', 'like', "%{$search}%");
                    })
                    ->orWhereHas('aset', function ($a) use ($search) {
                        $a->where('identitas_barang', 'like', "%{$search}%");
                    });
            });
        }

        $peminjaman = $query->paginate(10);
        $peminjaman->appends($request->only('search'));

        $peminjam = $user->role === 'isAdmin'
            ? Peminjam::all()
            : collect();

        $asets = Aset::all();

        return view('peminjaman.index', compact('peminjaman', 'peminjam', 'asets'));
    }


    public function create()
    {
        $peminjam = Peminjam::all();
        $asets = Aset::all();

        return view('peminjaman.create', compact('peminjam', 'asets'));
    }

    public function store(Request $request)
    {
        DB::transaction(function () use ($request) {

            $user = Auth::user();

            if (!$user) {
                abort(403);
            }

            $aset = Aset::lockForUpdate()->findOrFail($request->id_aset);

            $dipinjam = Peminjaman::where('id_aset', $aset->id_aset)
                ->where('status', 'dipinjam')
                ->sum('jumlah');

            $tersedia = $aset->jumlah - $dipinjam;

            if ($tersedia <= 0) {
                abort(400, 'Aset tidak tersedia');
            }

            $jumlah = min((int) $request->jumlah, $tersedia);

            if ($user->role === 'isAdmin') {
                $status = 'dipinjam';
                $createdBy = 'admin';
                $idPeminjam = $request->id_peminjam;
            } else {

                if (!$user->peminjam) {
                    abort(403, 'Profil peminjam belum lengkap. Silakan lengkapi profil terlebih dahulu.');
                }

                $status = 'pending';
                $createdBy = 'peminjam';
                $idPeminjam = $user->peminjam->id_peminjam;
            }

            Peminjaman::create([
                'id_peminjam'      => $idPeminjam,
                'id_aset'          => $request->id_aset,
                'tanggal_pinjam'   => $request->tanggal_pinjam,
                'tanggal_kembali'  => $request->tanggal_kembali,
                'status'           => $status,
                'created_by_role'  => $createdBy,
                'jumlah'           => $jumlah,
            ]);
        });

        return redirect()
            ->route('peminjaman.index')
            ->with('success', 'Data peminjaman berhasil ditambahkan.');
    }


    public function show($id)
    {
        $peminjaman = Peminjaman::with(['peminjam', 'aset'])->findOrFail($id);
        return view('peminjaman.show', compact('peminjaman'));
    }

    public function edit($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjam = Peminjam::all();
        $asets = Aset::all();

        return view('peminjaman.edit', compact('peminjaman', 'peminjam', 'asets'));
    }

    public function update(Request $request, $id)
    {
        DB::transaction(function () use ($request, $id) {

            $peminjaman = Peminjaman::findOrFail($id);
            $aset = Aset::findOrFail($peminjaman->id_aset);

            // Total dipinjam selain data ini
            $dipinjamLain = Peminjaman::where('id_aset', $aset->id_aset)
                ->where('status', 'Dipinjam')
                ->where('id_peminjaman', '!=', $peminjaman->id_peminjaman)
                ->sum('jumlah');

            $tersedia = $aset->jumlah - $dipinjamLain;

            $jumlahBaru = min((int) $request->jumlah, $tersedia);

            $peminjaman->update([
                'tanggal_kembali' => $request->tanggal_kembali,
                'status'          => $request->status,
                'jumlah'          => $jumlahBaru,
            ]);
        });

        return redirect()
            ->route('peminjaman.index')
            ->with('success', 'Data peminjaman berhasil diperbarui.');
    }


    public function destroy($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if (strtolower($peminjaman->status) !== 'dikembalikan') {
            return redirect()
                ->route('peminjaman.index')
                ->with('error', 'Peminjaman belum dikembalikan, tidak dapat dihapus.');
        }

        $peminjaman->delete();

        return redirect()
            ->route('peminjaman.index')
            ->with('success', 'Data peminjaman berhasil dihapus.');
    }
}