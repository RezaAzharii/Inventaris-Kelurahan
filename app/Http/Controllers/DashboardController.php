<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1️⃣ Pie chart aset berdasarkan jenis_barang
        $asetPerJenis = DB::table('asets')
            ->select('jenis_barang', DB::raw('SUM(jumlah) as total'))
            ->groupBy('jenis_barang')
            ->get();

        // 2️⃣ Total semua aset
        $totalAset = DB::table('asets')->sum('jumlah');

        // 3️⃣ Pie chart peminjaman aktif berdasarkan jenis_barang
        $peminjamanPerJenis = DB::table('peminjamans')
            ->join('asets', 'peminjamans.id_aset', '=', 'asets.id_aset')
            ->where('peminjamans.status', 'dipinjam')
            ->select('asets.jenis_barang', DB::raw('SUM(peminjamans.jumlah) as total'))
            ->groupBy('asets.jenis_barang')
            ->get();

        // 4️⃣ Total aset sedang dipinjam
        $totalDipinjam = DB::table('peminjamans')
            ->where('status', 'dipinjam')
            ->sum('jumlah');

        return view('dashboard', compact(
            'asetPerJenis',
            'totalAset',
            'peminjamanPerJenis',
            'totalDipinjam'
        ));
    }
}
