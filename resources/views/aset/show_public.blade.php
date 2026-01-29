<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('images/logo-kel.ico') }}">
    <title>Aset - {{ $aset->kode_barang }}</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>body { font-family: 'Poppins', sans-serif; }</style>
</head>
<body class="bg-gray-100 antialiased">

    <header class="bg-[#1E293B] text-white py-8 px-6 text-center">
        <h1 class="text-lg font-bold tracking-widest uppercase">Inventaris Kelurahan Bale Catur</h1>
        <p class="text-blue-300 text-xs mt-1">Sistem Informasi Aset</p>
    </header>

    <main class="max-w-md mx-auto px-4 -mt-8 pb-10">
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200">
            
            <div class="p-6 border-b border-gray-100 text-center">
                <h2 class="text-xl font-bold text-gray-800 leading-tight">
                    {{ $aset->identitas_barang }}
                </h2>
                <p class="text-gray-500 text-sm mt-1">{{ $aset->jenis_barang }}</p>
            </div>

            <div class="p-6 space-y-3">
                <div class="flex justify-between items-center text-sm">
                    <span class="text-gray-400 font-medium">Kode Aset</span>
                    <span class="text-gray-800 font-bold bg-gray-100 px-2 py-1 rounded">{{ $aset->kode_barang }}</span>
                </div>
                
                <div class="flex flex-col text-sm border-t border-gray-50 pt-2">
                    <span class="text-gray-400 font-medium">Penanggung Jawab</span>
                    <span class="text-gray-800 font-semibold text-left">{{ $aset->pengelola_barang }}</span>
                </div>

                <div class="flex flex-col text-sm border-t border-gray-50 pt-2">
                    <span class="text-gray-400 font-medium">Tahun Perolehan</span>
                    <span class="text-gray-800 font-semibold">{{ $aset->tahun_perolehan }}</span>
                </div>

                <div class="flex flex-col text-sm border-t border-gray-50 pt-2">
                    <span class="text-gray-400 font-medium">Jumlah</span>
                    <span class="text-gray-800 font-semibold">{{ $aset->jumlah }}</span>
                </div>
                
                <div class="border-t border-gray-50 pt-2">
                    <span class="text-gray-400 text-xs font-medium uppercase tracking-wider">Keterangan:</span>
                    <p class="mt-2 text-sm text-gray-600 leading-relaxed italic">
                        "{{ $aset->keterangan ?: 'tidak ada keterangan' }}"
                    </p>
                </div>
            </div>

            <div class="bg-gray-50 p-4 rounded-b-2xl text-center border-t border-gray-100">
                <p class="text-[10px] text-gray-400 font-medium">Diperbarui pada: {{ now()->format('d/m/Y') }}</p>
            </div>
        </div>

        <div class="mt-8 text-center px-6">
            <p class="text-[10px] text-gray-400 leading-relaxed uppercase tracking-widest">
                Informasi ini merupakan data resmi inventaris kelurahan.
            </p>
        </div>
    </main>

</body>
</html>