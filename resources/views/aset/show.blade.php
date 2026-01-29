@extends('layouts.app')

@section('title', 'Detail Aset - ' . $aset->identitas_barang)

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-5xl mx-auto">

            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
                        {{ $aset->identitas_barang }}
                    </h2>
                </div>

                <a href="{{ route('aset.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 transition-all duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali ke Daftar
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="bg-[#1E293B] px-6 py-4">
                            <h3 class="text-lg font-semibold text-white">Detail Aset</h3>
                        </div>

                        <div class="p-6">
                            @if ($aset->foto)
                                <img src="{{ asset('storage/' . $aset->foto) }}" alt="Foto Aset"
                                    class="w-full h-64 object-cover rounded-xl border mb-6">
                            @else
                                <div
                                    class="w-full h-64 flex items-center justify-center 
                bg-gray-100 rounded-xl text-gray-400">
                                    Tidak ada foto
                                </div>
                            @endif

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-6">
                                <div class="space-y-4">
                                    <div>
                                        <label class="text-xs font-bold text-gray-400 uppercase tracking-wider">Kode
                                            Barang</label>
                                        <p class="mt-1 text-sm font-semibold text-gray-800">{{ $aset->kode_barang }}</p>
                                    </div>
                                    <div>
                                        <label class="text-xs font-bold text-gray-400 uppercase tracking-wider">Jenis
                                            Barang</label>
                                        <p class="mt-1 text-gray-800 font-medium">{{ $aset->jenis_barang }}</p>
                                    </div>
                                    <div>
                                        <label class="text-xs font-bold text-gray-400 uppercase tracking-wider">Tahun
                                            Perolehan</label>
                                        <p class="mt-1 text-gray-800 font-medium">{{ $aset->tahun_perolehan }}</p>
                                    </div>
                                    <div>
                                        <label class="text-xs font-bold text-gray-400 uppercase tracking-wider">Jumlah
                                            Unit</label>
                                        <p class="mt-1 text-gray-800 font-medium">{{ $aset->jumlah }}</p>
                                    </div>
                                </div>

                                <div class="space-y-4">
                                    <div>
                                        <label class="text-xs font-bold text-gray-400 uppercase tracking-wider">pengelola
                                            Barang</label>
                                        <p class="mt-1 text-gray-800 font-medium">{{ $aset->pengelola_barang }}</p>
                                    </div>
                                    <div>
                                        <label class="text-xs font-bold text-gray-400 uppercase tracking-wider">Nilai
                                            Perolehan</label>
                                        <p class="mt-1 text-sm font-semibold text-green-700">
                                            Rp{{ number_format($aset->nilai_perolehan, 0, ',', '.') }}</p>
                                    </div>
                                    <div>
                                        <label class="text-xs font-bold text-gray-400 uppercase tracking-wider">Nilai Saat
                                            Ini</label>
                                        <p class="mt-1 text-sm font-bold text-orange-600">
                                            Rp{{ number_format($aset->nilai_saat_ini, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="">
                                <label class="text-xs font-bold text-gray-400 uppercase tracking-wider">Keterangan</label>
                                <div class="mt-2 p-4 bg-gray-100 rounded-lg italic text-gray-600">
                                    "{{ $aset->keterangan ?: 'Tidak ada keterangan.' }}"
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 sticky top-8">
                        <div class="text-center mb-6">
                            <h3 class="text-lg font-bold text-gray-800">Label Aset (QR Code)</h3>
                            <p class="text-xs text-gray-400 mt-1">Download QR untuk cetak label</p>
                        </div>

                        <div class="flex flex-col items-center">
                            <div class="p-6 bg-white border-2 border-dashed border-gray-200 rounded-2xl shadow-inner mb-6">
                                <div id="qrcode-container" class="bg-white p-2">
                                    {!! QrCode::size(200)->margin(2)->generate(route('aset.showPublic', $aset->id_aset)) !!}
                                </div>
                            </div>

                            <button onclick="downloadQRCode()"
                                class="w-full inline-flex justify-center items-center px-6 py-3 bg-gray-600 text-white font-bold rounded-xl hover:bg-gray-700 shadow-lg shadow-gray-200 transition-all active:scale-95">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                Export Label
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        function downloadQRCode() {
            const container = document.getElementById('qrcode-container');
            const svg = container.querySelector('svg');
            const padding = 40; // Menambah padding putih saat export
            const canvas = document.createElement('canvas');

            // Mengatur skala export agar lebih tajam
            const scale = 2;
            const baseWidth = svg.width.baseVal.value || 200;
            const baseHeight = svg.height.baseVal.value || 200;

            canvas.width = (baseWidth + padding * 2) * scale;
            canvas.height = (baseHeight + padding * 2) * scale;

            const ctx = canvas.getContext('2d');
            ctx.scale(scale, scale);

            // Latar belakang putih
            ctx.fillStyle = '#ffffff';
            ctx.fillRect(0, 0, canvas.width, canvas.height);

            const img = new Image();
            const svgData = new XMLSerializer().serializeToString(svg);
            const url = URL.createObjectURL(new Blob([svgData], {
                type: 'image/svg+xml'
            }));

            img.onload = function() {
                ctx.drawImage(img, padding, padding, baseWidth, baseHeight);
                URL.revokeObjectURL(url);

                canvas.toBlob(function(blob) {
                    const link = document.createElement('a');
                    link.download = 'QR-Aset-{{ $aset->kode_barang }}.png';
                    link.href = URL.createObjectURL(blob);
                    link.click();
                }, 'image/png', 1.0);
            };
            img.src = url;
        }
    </script>
@endsection
