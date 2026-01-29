@extends('layouts.app')
@section('title', 'Invenataris Aset - Daftar Aset')
@section('content')
    <div class="container mx-auto px-4 pt-3">

        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
            <h1 class="text-2xl font-semibold text-gray-700">
                Daftar Aset Perusahaan
            </h1>

            @if (session('success'))
                <div class="bg-blue-100 text-blue-700 px-4 py-2 rounded-md text-sm">
                    {{ session('success') }}
                </div>
            @endif
        </div>

        <div class="flex flex-col md:flex-row gap-2 items-center mb-3 w-full">
            <form action="{{ route('aset.index') }}" method="GET" class="relative flex-1">
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 21l-4.35-4.35M10 18a8 8 0 100-16 8 8 0 000 16z" />
                        </svg>
                    </span>

                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari aset (kode, jenis, identitas)..."
                        class="w-full bg-white border border-gray-300 rounded-md pl-10 pr-10 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#334155]">
                    @if (request('search'))
                        <a href="{{ route('aset.index') }}"
                            class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600"
                            title="Reset pencarian">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </a>
                    @endif
                </div>
            </form>

            @auth
                @if (auth()->user()->role === 'isAdmin')
                    <button @click="$dispatch('open-modal', { id: 'tambahAsetModal' })"
                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm font-medium shadow-sm transition">
                        Tambah Aset
                    </button>

                    <a href="{{ route('aset.export') }}"
                        class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 text-sm">
                        Export Excel
                    </a>
                @endif
            @endauth

        </div>

        <div class="bg-white rounded-lg shadow-md border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-blue-100 text-gray-700">
                        <tr>
                            <th class="px-4 py-3 text-left font-semibold">No</th>
                            <th class="px-4 py-3">Foto</th>
                            <th class="px-2 py-3 w-[100px] text-left font-semibold">Jenis Barang</th>
                            <th class="px-4 py-3 text-center font-semibold">Identitas</th>
                            <th class="px-2 py-3 text-center font-semibold">Kode</th>
                            <th class="px-4 py-3 text-center font-semibold">Pengelola</th>
                            <th class="px-4 py-3 text-center font-semibold">Tahun</th>
                            <th class="px-4 py-3 text-center font-semibold">Nilai Saat Ini</th>
                            <th class="px-4 py-3 text-left font-semibold">Jumlah</th>
                            @if (auth()->user()->role === 'isAdmin')
                                <th class="px-2 py-3 text-center font-semibold">Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($asets as $index => $aset)
                            <tr class="hover:bg-gray-100 transition-colors cursor-pointer"
                                onclick="window.location='{{ route('aset.show', $aset->id_aset) }}'">
                                <td class="px-4 py-3 text-center">{{ $asets->firstItem() + $loop->index }}</td>
                                <td class="px-4 py-3">
                                    @if ($aset->foto)
                                        <img src="{{ asset('storage/' . $aset->foto) }}"
                                            class="w-14 h-14 object-cover rounded-lg border">
                                    @else
                                        <span class="text-xs text-gray-400 italic">Tidak ada</span>
                                    @endif
                                </td>
                                <td class="px-2 py-3 w-[100px] text-center font-medium text-gray-800">
                                    {{ $aset->jenis_barang }}</td>
                                <td class="px-4 py-3 text-gray-600">{{ $aset->identitas_barang }}</td>
                                <td class="px-4 py-3 text-center text-gray-600">{{ $aset->kode_barang }}</td>
                                <td class="px-4 py-3 text-gray-600">{{ $aset->pengelola_barang }}</td>
                                <td class="px-4 py-3 text-gray-600">
                                    {{ \Carbon\Carbon::parse($aset->tahun_perolehan)->translatedFormat('d-m-Y') }}</td>
                                <td class="px-4 py-3 font-semibold text-gray-700">
                                    Rp. {{ number_format($aset->nilai_saat_ini, 0, ',', '.') }}
                                </td>
                                <td class="px-4 py-3 text-center text-gray-600">{{ $aset->jumlah }}</td>
                                @if (auth()->user()->role === 'isAdmin')
                                    <td class="px-2 py-3">
                                        <div class="flex items-center gap-1 justify-center"
                                            onclick="event.stopPropagation()">

                                            <button
                                                @click="$dispatch('open-modal', { id: 'editAsetModal-{{ $aset->id_aset }}' })"
                                                class="text-blue-600 hover:text-blue-800" title="Edit Aset">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="lucide lucide-square-pen-icon lucide-square-pen">
                                                    <path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                                    <path
                                                        d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z" />
                                                </svg>
                                            </button>

                                            <x-custom-modal :id="'editAsetModal-' . $aset->id_aset" title="Ubah Aset: {{ $aset->kode_barang }}"
                                                :action="route('aset.update', $aset->id_aset)" method="PUT" enctype="multipart/form-data"
                                                buttonText="Simpan Perubahan" maxWidth="sm:max-w-xl" :is_edit_modal="$errors->any() && request('id_aset') == $aset->id_aset">
                                                @include('aset.components.forms-asset', ['aset' => $aset])
                                            </x-custom-modal>

                                            <x-alert-dialog :action="route('aset.destroy', $aset->id_aset)" title="Hapus Data Aset?"
                                                message="Aset ini akan dihapus secara permanen dan tidak dapat dikembalikan. Lanjutkan?"
                                                confirmText="Hapus" cancelText="Batal">
                                                <x-slot:trigger>
                                                    <a class="text-red-600 hover:text-red-800" title="Hapus Aset">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                            height="20" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            class="lucide lucide-trash2-icon lucide-trash-2">
                                                            <path d="M10 11v6" />
                                                            <path d="M14 11v6" />
                                                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6" />
                                                            <path d="M3 6h18" />
                                                            <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                                        </svg>
                                                    </a>
                                                </x-slot:trigger>
                                            </x-alert-dialog>

                                        </div>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-6 text-gray-500">
                                    Data aset tidak ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if ($asets->lastPage() > 1)
            <div class="mt-2 flex justify-between items-center text-sm text-gray-700">
                <div>
                    Menampilkan {{ $asets->firstItem() }} hingga {{ $asets->lastItem() }} dari {{ $asets->total() }} aset
                </div>

                <div class="flex items-center space-x-2">
                    {{ $asets->links() }}
                </div>
            </div>
        @endif
        <x-custom-modal id="tambahAsetModal" title="Tambah Aset Baru" :action="route('aset.store')" method="POST"
            enctype="multipart/form-data" buttonText="Simpan Aset" maxWidth="sm:max-w-xl" :is_edit_modal="$errors->any() && request('action') == 'create'">
            @include('aset.components.forms-asset', ['aset' => null])
        </x-custom-modal>
    </div>
@endsection
