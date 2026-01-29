@extends('layouts.app')

@section('title', 'Detail Peminjaman')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-5xl mx-auto">

        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">
                    Detail Peminjaman
                </h2>
            </div>

            <a href="{{ route('peminjaman.index') }}"
                class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 transition-all duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Daftar
            </a>
        </div>

        <!-- Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- Detail Peminjaman -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">

                    <!-- Card Header -->
                    <div class="bg-[#1E293B] px-6 py-4">
                        <h3 class="text-lg font-semibold text-white">
                            Informasi Peminjaman
                        </h3>
                    </div>

                    <!-- Card Body -->
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-6">

                            <!-- Kolom Kiri -->
                            <div class="space-y-4">
                                <div>
                                    <label class="text-xs font-bold text-gray-400 uppercase tracking-wider">
                                        NIK
                                    </label>
                                    <p class="mt-1 text-gray-800 font-medium">
                                        {{ $peminjaman->peminjam->nik ?? '-' }}
                                    </p>
                                </div>
                                
                                <div>
                                    <label class="text-xs font-bold text-gray-400 uppercase tracking-wider">
                                        Nama Peminjam
                                    </label>
                                    <p class="mt-1 text-gray-800 font-medium">
                                        {{ $peminjaman->peminjam->nama_peminjam ?? '-' }}
                                    </p>
                                </div>

                                <div>
                                    <label class="text-xs font-bold text-gray-400 uppercase tracking-wider">
                                        Aset Dipinjam
                                    </label>
                                    <p class="mt-1 text-gray-800 font-medium">
                                        {{ $peminjaman->Aset->identitas_barang ?? '-' }}
                                    </p>
                                </div>

                                <div>
                                    <label class="text-xs font-bold text-gray-400 uppercase tracking-wider">
                                        Jumlah
                                    </label>
                                    <p class="mt-1 text-gray-800 font-medium">
                                        {{ $peminjaman->jumlah }}
                                    </p>
                                </div>
                            </div>

                            <!-- Kolom Kanan -->
                            <div class="space-y-4">
                                <div>
                                    <label class="text-xs font-bold text-gray-400 uppercase tracking-wider">
                                        Tanggal Pinjam
                                    </label>
                                    <p class="mt-1 text-gray-800 font-medium">
                                        {{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d-m-Y') }}
                                    </p>
                                </div>

                                <div>
                                    <label class="text-xs font-bold text-gray-400 uppercase tracking-wider">
                                        Tanggal Kembali
                                    </label>
                                    <p class="mt-1 text-gray-800 font-medium">
                                        {{ $peminjaman->tanggal_kembali
                                            ? \Carbon\Carbon::parse($peminjaman->tanggal_kembali)->format('d-m-Y')
                                            : '-' }}
                                    </p>
                                </div>

                                <div>
                                    <label class="text-xs font-bold text-gray-400 uppercase tracking-wider">
                                        Keterangan Aset
                                    </label>
                                    <div class="mt-2 p-3 bg-gray-100 rounded-lg italic text-gray-600 text-sm">
                                        "{{ $peminjaman->Aset->keterangan ?? 'Tidak ada keterangan.' }}"
                                    </div>
                                </div>

                                <div>
                                    <label class="text-xs font-bold text-gray-400 uppercase tracking-wider">
                                        Status
                                    </label>
                                    @php $status = strtolower($peminjaman->status); @endphp
                                    <div class="mt-2">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold text-white
                                            @if($status === 'dipinjam') bg-yellow-500
                                            @elseif($status === 'dikembalikan') bg-green-600
                                            @else bg-gray-500 @endif">
                                            {{ ucfirst($status) }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>

            <!-- Sidebar Ringkasan -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 sticky top-8">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 text-center">
                        Ringkasan
                    </h3>

                    <div class="space-y-4 text-sm text-gray-700">
                        <div class="flex justify-between">
                            <span class="text-gray-500">ID Peminjaman</span>
                            <span class="font-semibold">#{{ $peminjaman->id_peminjaman }}</span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-gray-500">ID Peminjaman</span>
                            <span class="font-semibold">#{{ $peminjaman->id_peminjaman }}</span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-gray-500">Jumlah</span>
                            <span class="font-semibold">{{ $peminjaman->jumlah }}</span>
                        </div>

                        <div class="flex justify-between items-center">
                            <span class="text-gray-500">Status</span>
                            @php $status = strtolower($peminjaman->status); @endphp
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold text-white
                                @if($status === 'dipinjam') bg-yellow-500
                                @elseif($status === 'dikembalikan') bg-green-600
                                @else bg-gray-500 @endif">
                                {{ ucfirst($status) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
