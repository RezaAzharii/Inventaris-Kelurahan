@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-6">

        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
            <h1 class="text-2xl font-semibold text-gray-700">
                Daftar Peminjaman Aset
            </h1>

            @if (session('success'))
                <div class="bg-blue-100 text-blue-700 px-4 py-2 rounded-md text-sm">
                    {{ session('success') }}
                </div>
            @endif
        </div>

        <!-- Search + Tombol Modal -->
        <div class="flex flex-col md:flex-row gap-2 items-center mb-6 w-full">
            <form action="{{ route('peminjaman.index') }}" method="GET" class="relative flex-1">
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 21l-4.35-4.35M10 18a8 8 0 100-16 8 8 0 000 16z" />
                        </svg>
                    </span>

                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari peminjaman (nama, aset, status)..."
                        class="w-full border border-gray-300 rounded-md pl-10 pr-10 py-2 text-sm
                    focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500">

                    @if (request('search'))
                        <a href="{{ route('peminjaman.index') }}"
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

            <button @click="$dispatch('open-modal', { id: 'tambahPeminjamanModal' })"
                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm font-medium shadow-sm transition">
                Tambah Peminjaman
            </button>
            @if (auth()->user()->role === 'isAdmin')
                <a href="{{ route('peminjaman.export', ['search' => request('search')]) }}"
                    class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700
                text-sm font-medium shadow-sm transition">
                    Export Excel
                </a>
            @endif

        </div>

        <!-- Tabel -->
        <div class="bg-white rounded-lg shadow-md border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-blue-100 text-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left font-semibold">No</th>
                            <th class="px-6 py-3 text-left font-semibold">Nama Peminjam</th>
                            <th class="px-6 py-3 text-left font-semibold">Aset Dipinjam</th>
                            <th class="px-6 py-3 text-left font-semibold">Jumlah</th>
                            <th class="px-6 py-3 text-left font-semibold">Tanggal Pinjam</th>
                            <th class="px-6 py-3 text-left font-semibold">Tanggal Kembali</th>
                            <th class="px-6 py-3 text-left font-semibold">Status</th>
                            @if (auth()->user()->role === 'isAdmin')
                                <th class="px-2 py-3 text-center font-semibold">Aksi</th>
                            @endif
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">
                        @forelse ($peminjaman as $index => $p)
                            <tr class="hover:bg-blue-50 transition-colors cursor-pointer"
                                onclick="window.location='{{ route('peminjaman.show', $p->id_peminjaman) }}'">

                                <td class="px-6 py-3">
                                    {{ $peminjaman->firstItem() + $loop->index }}
                                </td>
                                <td class="px-6 py-3 font-medium text-gray-800">{{ $p->peminjam->nama_peminjam ?? '-' }}
                                </td>
                                <td class="px-6 py-3 text-gray-600">{{ $p->aset->identitas_barang ?? '-' }}</td>
                                <td class="px-6 py-3 text-gray-600">{{ $p->jumlah }}</td>
                                <td class="px-6 py-3 text-gray-600">{{ $p->tanggal_pinjam }}</td>
                                <td class="px-6 py-3 text-gray-600">{{ $p->tanggal_kembali ?? '-' }}</td>
                                <td class="px-6 py-3">
                                    @php
                                        // Ambil status dari database, hapus spasi, ubah ke huruf kecil untuk pengecekan warna
                                        $statusLower = strtolower(trim($p->status));

                                        // Tentukan kelas warna
                                        $statusColor =
                                            $statusLower == 'dipinjam'
                                                ? 'bg-yellow-100 text-yellow-700'
                                                : ($statusLower == 'dikembalikan'
                                                    ? 'bg-green-100 text-green-700'
                                                    : 'bg-gray-100 text-gray-700');

                                        // Format status agar huruf awal kapital
                                        $statusFormatted = ucfirst($statusLower);
                                    @endphp

                                    <span class="px-2 py-1 text-xs rounded {{ $statusColor }}">
                                        {{ $statusFormatted }}
                                    </span>
                                </td>


                                <!-- Aksi -->
                                @if (auth()->user()->role === 'isAdmin')
                                    <td class="px-6 py-3">
                                        <div class="flex items-center justify-center gap-3"
                                            onclick="event.stopPropagation()">

                                            <!-- Tombol Edit -->
                                            <button
                                                @click="$dispatch('open-modal', { id: 'editPeminjamanModal-{{ $p->id_peminjaman }}' })"
                                                class="text-blue-600 hover:text-blue-800 cursor-pointer"
                                                title="Edit Peminjaman">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                                    <path
                                                        d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z" />
                                                </svg>
                                            </button>


                                            <!-- Modal Edit -->
                                            <x-custom-modal :id="'editPeminjamanModal-' . $p->id_peminjaman" title="Ubah Peminjaman" :action="route('peminjaman.update', $p->id_peminjaman)"
                                                method="PUT" buttonText="Simpan Perubahan" maxWidth="sm:max-w-xl">
                                                @include('peminjaman.components.forms-peminjamans', [
                                                    'peminjaman' => $p,
                                                ])
                                            </x-custom-modal>


                                            @php
                                                $statusLower = strtolower(trim($p->status));
                                                $bolehHapus = $statusLower === 'dikembalikan';
                                            @endphp

                                            @if ($bolehHapus)
                                                <!-- Delete aktif -->
                                                <x-alert-dialog :action="route('peminjaman.destroy', $p->id_peminjaman)" title="Hapus Data Peminjaman?"
                                                    message="Data peminjaman ini akan dihapus secara permanen. Lanjutkan?"
                                                    confirmText="Hapus" cancelText="Batal">

                                                    <x-slot:trigger>
                                                        <a class="text-red-600 hover:text-red-800" title="Hapus Peminjaman">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                                height="20" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round">
                                                                <path d="M10 11v6" />
                                                                <path d="M14 11v6" />
                                                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6" />
                                                                <path d="M3 6h18" />
                                                                <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                                            </svg>
                                                        </a>
                                                    </x-slot:trigger>

                                                </x-alert-dialog>
                                            @else
                                                <!-- Delete non-aktif -->
                                                <span class="text-gray-400 cursor-not-allowed"
                                                    title="Tidak dapat dihapus sebelum aset dikembalikan">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                        <path d="M10 11v6" />
                                                        <path d="M14 11v6" />
                                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6" />
                                                        <path d="M3 6h18" />
                                                        <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                                    </svg>
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                @endif
                            </tr>

                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-6 text-gray-500">
                                    Tidak ada data peminjaman ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if ($peminjaman->lastPage() > 1)
            <div class="mt-4 flex justify-between items-center text-sm text-gray-700">
                <div>
                    Menampilkan {{ $peminjaman->firstItem() }}
                    hingga {{ $peminjaman->lastItem() }}
                    dari {{ $peminjaman->total() }} peminjaman
                </div>

                <div>
                    {{ $peminjaman->links() }}
                </div>
            </div>
        @endif

        <!-- Modal Tambah -->
        <x-custom-modal id="tambahPeminjamanModal" title="Tambah Peminjaman Baru" :action="route('peminjaman.store')" method="POST"
            buttonText="Simpan Peminjaman" maxWidth="sm:max-w-xl" :is_edit_modal="$errors->any() && request('action') == 'create'">
            @include('peminjaman.components.forms-peminjamans', ['peminjaman' => null])
        </x-custom-modal>

    </div>
@endsection
