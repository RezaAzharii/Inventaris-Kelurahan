@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-6">

        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
            <h1 class="text-2xl font-semibold text-gray-700">
                Daftar Peminjam
            </h1>

            @if (session('success'))
                <div class="bg-blue-100 text-blue-700 px-4 py-2 rounded-md text-sm">
                    {{ session('success') }}
                </div>
            @endif
        </div>

        <!-- Search + Tombol Tambah -->
        <div class="flex flex-col md:flex-row gap-2 items-center mb-6 w-full">

            <!-- Search -->
            <form action="{{ route('peminjam.index') }}" method="GET" class="relative flex-1">
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M21 21l-4.35-4.35M10 18a8 8 0 100-16 8 8 0 000 16z" />
                        </svg>
                    </span>

                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari peminjam (NIK, nama, atau no. telp)..."
                        class="w-full border border-gray-300 rounded-md pl-10 pr-10 py-2 text-sm
                               focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500">

                    @if (request('search'))
                        <a href="{{ route('peminjam.index') }}"
                           class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600"
                           title="Reset pencarian">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </a>
                    @endif
                </div>
            </form>

            <!-- Tombol Tambah -->
            <button
                @click="$dispatch('open-modal', { id: 'tambahPeminjamModal' })"
                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm font-medium shadow-sm transition">
                Tambah Peminjam
            </button>

            <a href="{{ route('peminjam.export') }}"
            class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700
                    text-sm font-medium shadow-sm transition">
                Export Peminjam
            </a>

        </div>

        <!-- TABLE -->
        <div class="bg-white rounded-lg shadow-md border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-blue-100 text-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-center font-semibold">ID</th>
                            <th class="px-6 py-3 text-center font-semibold">NIK</th>
                            <th class="px-6 py-3 text-center font-semibold">Nama Peminjam</th>
                            <th class="px-6 py-3 text-center font-semibold">No. Telepon</th>
                            <th class="px-6 py-3 text-center font-semibold">Alamat</th>
                            <th class="px-6 py-3 text-center font-semibold">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">
                        @forelse ($peminjams as $pm)
                            <tr class="hover:bg-blue-50 transition-colors cursor-pointer"
                                onclick="window.location='{{ route('peminjam.show', $pm->id_peminjam) }}'">

                                <td class="px-6 py-3 text-center">{{ $pm->id_peminjam }}</td>
                                <td class="px-6 py-3 text-center">{{ $pm->nik }}</td>
                                <td class="px-6 py-3 text-center">{{ $pm->nama_peminjam }}</td>
                                <td class="px-6 py-3 text-center">{{ $pm->no_telp }}</td>
                                <td class="px-6 py-3 text-center">{{ $pm->alamat }}</td>

                                <td class="px-6 py-3">
                                    <div class="flex flex-row items-center gap-2 justify-center" onclick="event.stopPropagation()">
                                        {{-- Tombol Edit --}}
                                        <button 
                                            @click="$dispatch('open-modal', { id: 'editPeminjamModal-{{ $pm->id_peminjam }}' })"
                                            class="text-blue-600 hover:text-blue-800"
                                            title="Edit Peminjam">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-square-pen-icon lucide-square-pen">
                                                <path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                                <path
                                                    d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z" />
                                            </svg>
                                        </button>

                                        {{-- Modal Edit --}}
                                        <x-custom-modal
                                            :id="'editPeminjamModal-' . $pm->id_peminjam"
                                            title="Ubah Peminjam"
                                            :action="route('peminjam.update', $pm->id_peminjam)"
                                            method="PUT"
                                            buttonText="Simpan Perubahan"
                                            maxWidth="sm:max-w-lg"
                                            :is_edit_modal="$errors->any() && (request('id_peminjam') == $pm->id_peminjam)"
                                        >
                                            @include('peminjam.form-peminjam', ['peminjam' => $pm])
                                        </x-custom-modal>

                                        {{-- Tombol Hapus --}}
                                        <x-alert-dialog 
                                            :action="route('peminjam.destroy', $pm->id_peminjam)" 
                                            title="Hapus Data Peminjam?"
                                            message="Data ini akan dihapus permanen dan tidak dapat dikembalikan. Lanjutkan?"
                                            confirmText="Hapus" cancelText="Batal">

                                            <x-slot:trigger>
                                                <a class="text-red-600 hover:text-red-800"
                                                    title="Hapus Peminjam">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
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
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-6 text-gray-500">
                                    Tidak ada peminjam ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if ($peminjams->lastPage() > 1)
            <div class="mt-2 flex justify-between items-center text-sm text-gray-700">
                <div>
                    Menampilkan {{ $peminjams->firstItem() }}
                    hingga {{ $peminjams->lastItem() }}
                    dari {{ $peminjams->total() }} peminjam
                </div>

                <div class="flex items-center space-x-2">
                    {{ $peminjams->links() }}
                </div>
            </div>
        @endif
        <!-- Modal Tambah -->
        <x-custom-modal
            id="tambahPeminjamModal"
            title="Tambah Peminjam Baru"
            :action="route('peminjam.store')"
            method="POST"
            buttonText="Simpan"
            maxWidth="sm:max-w-lg">
            @include('peminjam.form-peminjam', ['peminjam' => null])
        </x-custom-modal>

    </div>
@endsection
