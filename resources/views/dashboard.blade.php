@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="p-6 space-y-6">

    {{-- BARIS ATAS: TOTAL --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        {{-- TOTAL ASET --}}
        <div class="bg-white p-4 rounded-xl shadow flex flex-col justify-center h-32">
            <h3 class="text-xs text-gray-500 uppercase tracking-wide">
                Total Aset
            </h3>
            <p class="text-3xl font-bold text-blue-700 mt-1">
                {{ $totalAset }}
            </p>
            <p class="text-xs text-gray-400 mt-1">
                Seluruh aset terdaftar
            </p>
        </div>

        {{-- TOTAL DIPINJAM --}}
        <div class="bg-white p-4 rounded-xl shadow flex flex-col justify-center h-32">
            <h3 class="text-xs text-gray-500 uppercase tracking-wide">
                Total Aset Dipinjam
            </h3>
            <p class="text-3xl font-bold text-red-600 mt-1">
                {{ $totalDipinjam }}
            </p>
            <p class="text-xs text-gray-400 mt-1">
                Aset sedang digunakan
            </p>
        </div>

    </div>

    {{-- BARIS BAWAH: PIE CHART --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        {{-- PIE CHART ASET --}}
        <div class="bg-white p-6 rounded-xl shadow">
            <h3 class="text-lg font-semibold text-gray-700 mb-1">
                Distribusi Aset
            </h3>
            <p class="text-sm text-gray-500 mb-3">
                Berdasarkan jenis barang
            </p>

            <div class="relative h-48">
                <canvas id="asetChart"></canvas>
            </div>
        </div>

        {{-- PIE CHART PEMINJAMAN --}}
        <div class="bg-white p-6 rounded-xl shadow">
            <h3 class="text-lg font-semibold text-gray-700 mb-1">
                Aset Sedang Dipinjam
            </h3>
            <p class="text-sm text-gray-500 mb-3">
                Berdasarkan jenis barang
            </p>

            <div class="relative h-48">
                <canvas id="peminjamanChart"></canvas>
            </div>
        </div>

    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // =======================
    // PIE CHART ASET
    // =======================
    const asetLabels = @json($asetPerJenis->pluck('jenis_barang'));
    const asetData   = @json($asetPerJenis->pluck('total'));

    new Chart(document.getElementById('asetChart'), {
        type: 'pie',
        data: {
            labels: asetLabels,
            datasets: [{
                data: asetData,
            }]
        },
        options: {
            maintainAspectRatio: false,
            plugins: {
                title: {
                    display: true,
                    text: 'Jumlah Aset per Jenis'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.label + ': ' + context.parsed + ' unit';
                        }
                    }
                }
            }
        }
    });

    // =======================
    // PIE CHART PEMINJAMAN
    // =======================
    const pinjamLabels = @json($peminjamanPerJenis->pluck('jenis_barang'));
    const pinjamData   = @json($peminjamanPerJenis->pluck('total'));

    new Chart(document.getElementById('peminjamanChart'), {
        type: 'pie',
        data: {
            labels: pinjamLabels,
            datasets: [{
                data: pinjamData,
            }]
        },
        options: {
            maintainAspectRatio: false,
            plugins: {
                title: {
                    display: true,
                    text: 'Aset Dipinjam per Jenis'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.label + ': ' + context.parsed + ' unit';
                        }
                    }
                }
            }
        }
    });
</script>
@endpush
