@extends('layouts.app')

@section('title', 'Detail Peminjam - ' . $peminjam->nama_peminjam)

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-5xl mx-auto">

            <!-- Header -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900">
                        {{ $peminjam->nama_peminjam }}
                    </h2>
                    <p class="text-sm text-gray-500 mt-1">
                        Detail informasi peminjam
                    </p>
                </div>

                <a href="{{ route('peminjam.index') }}"
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

                <!-- Detail Peminjam -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">

                        <!-- Card Header -->
                        <div class="bg-[#1E293B] px-6 py-4">
                            <h3 class="text-lg font-semibold text-white">
                                Detail Peminjam
                            </h3>
                        </div>

                        <!-- Card Body -->
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-6">
                                
                                <div class="space-y-4">
                                    <div>
                                        <label class="text-xs font-bold text-gray-400 uppercase tracking-wider">
                                            Nama Peminjam
                                        </label>
                                        <p class="mt-1 text-gray-800 font-medium">
                                            {{ $peminjam->nama_peminjam }}
                                        </p>
                                    </div>
                                    <div>
                                        <label class="text-xs font-bold text-gray-400 uppercase tracking-wider">
                                            No. Telepon
                                        </label>
                                        <p class="mt-1 text-gray-800 font-medium">
                                            {{ $peminjam->no_telp }}
                                        </p>
                                    </div>
                                </div>

                                <div class="space-y-4">
                                    <div>
                                        <label class="text-xs font-bold text-gray-400 uppercase tracking-wider">
                                            NIK
                                        </label>
                                        <p class="mt-1 text-gray-800 font-medium">
                                            {{ $peminjam->nik }}
                                        </p>
                                    </div>
                                    <div>
                                        <label class="text-xs font-bold text-gray-400 uppercase tracking-wider">
                                            Alamat
                                        </label>
                                        <p class="mt-1 text-gray-800 font-medium">
                                            {{ $peminjam->alamat }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar (Opsional / Info Tambahan) -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 sticky top-8">
                        <h3 class="text-lg font-bold text-gray-800 mb-2 text-center">
                            Informasi
                        </h3>
                        <p class="text-sm text-gray-500 text-center">
                            Data peminjam digunakan untuk proses peminjaman aset dan pelacakan histori transaksi.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
