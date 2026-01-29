@php
    $aset = $aset ?? null;
    $is_create = is_null($aset) || !isset($aset->id_aset);

    $aset =
        $aset ??
        (object) [
            'jenis_barang' => '',
            'kode_barang' => '',
            'identitas_barang' => '',
            'pengelola_barang' => '',
            'tahun_perolehan' => '',
            'nilai_perolehan' => '',
            'nilai_saat_ini' => '',
            'jumlah' => 1,
            'keterangan' => '',
            'foto' => null,
        ];

    $getAsetValue = function ($fieldName, $asetValue, $isCreate, $currentAset) {
        $oldId = session()->get('id_aset');
        $oldAction = session()->get('action');

        if ($isCreate && $oldAction === 'create' && old($fieldName) !== null) {
            return old($fieldName);
        }

        if (!$isCreate && isset($currentAset->id_aset) && $oldId == $currentAset->id_aset && old($fieldName) !== null) {
            return old($fieldName);
        }

        return $asetValue;
    };
@endphp


<div class="space-y-4">
    <div>
        <label for="jenis_barang" class="block text-sm font-medium text-gray-700">Jenis Barang</label>
        <input type="text" name="jenis_barang" id="jenis_barang" required
            value="{{ $getAsetValue('jenis_barang', $aset->jenis_barang, $is_create, $aset) }}"
            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-150 p-2.5 text-gray-900 @error('jenis_barang') border-red-500 @enderror"
            required>
        @error('jenis_barang')
            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="kode_barang" class="block text-sm font-medium text-gray-700">Kode Barang</label>
        <input type="text" name="kode_barang" id="kode_barang" required
            value="{{ $getAsetValue('kode_barang', $aset->kode_barang, $is_create, $aset) }}"
            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-150 p-2.5 text-gray-900 @error('kode_barang') border-red-500 @enderror"
            required>
        @error('kode_barang')
            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="identitas_barang" class="block text-sm font-medium text-gray-700">Identitas</label>
        <input type="text" name="identitas_barang" id="identitas_barang"
            value="{{ $getAsetValue('identitas_barang', $aset->identitas_barang, $is_create, $aset) }}"
            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-150 p-2.5 text-gray-900 @error('identitas_barang') border-red-500 @enderror"
            required>
        @error('identitas_barang')
            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="foto" class="block text-sm font-medium text-gray-700">
            Foto Aset
        </label>

        <input type="file" name="foto" id="foto" accept="image/*"
            class="mt-1 block w-full text-sm text-gray-700
        file:mr-4 file:py-2 file:px-4
        file:rounded-md file:border-0
        file:text-sm file:font-semibold
        file:bg-blue-50 file:text-blue-700
        hover:file:bg-blue-100
        @error('foto') border-red-500 @enderror">

        @error('foto')
            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
        @enderror

        @if (!$is_create && !empty($aset->foto))
            <div class="mt-2">
                <p class="text-xs text-gray-500 mb-1">Foto saat ini:</p>
                <img src="{{ asset('storage/' . $aset->foto) }}" class="h-32 rounded-md border object-cover">
            </div>
        @endif
    </div>


    <div>
        <label for="jumlah" class="block text-sm font-medium text-gray-700">Jumlah</label>
        <input type="number" name="jumlah" id="jumlah" min="1"
            value="{{ $getAsetValue('jumlah', $aset->jumlah ?: 1, $is_create, $aset) }}"
            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-150 p-2.5 text-gray-900 @error('jumlah') border-red-500 @enderror"
            required>
        @error('jumlah')
            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="pengelola_barang" class="block text-sm font-medium text-gray-700">Pengelola</label>
        <input type="text" name="pengelola_barang" id="pengelola_barang"
            value="{{ $getAsetValue('pengelola_barang', $aset->pengelola_barang, $is_create, $aset) }}"
            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-150 p-2.5 text-gray-900 @error('pengelola_barang') border-red-500 @enderror"
            required>
        @error('pengelola_barang')
            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="tahun_perolehan" class="block text-sm font-medium text-gray-700">Tahun Perolehan</label>
        <input type="date" name="tahun_perolehan" id="tahun_perolehan"
            value="{{ $getAsetValue('tahun_perolehan', $aset->tahun_perolehan, $is_create, $aset) }}"
            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-150 p-2.5 text-gray-900 @error('tahun_perolehan') border-red-500 @enderror"
            required>
        @error('tahun_perolehan')
            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="nilai_perolehan" class="block text-sm font-medium text-gray-700">Nilai Perolehan</label>
        <input type="number" name="nilai_perolehan" id="nilai_perolehan"
            value="{{ $getAsetValue('nilai_perolehan', $aset->nilai_perolehan, $is_create, $aset) }}"
            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-150 p-2.5 text-gray-900 @error('nilai_perolehan') border-red-500 @enderror">
        @error('nilai_perolehan')
            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="nilai_saat_ini" class="block text-sm font-medium text-gray-700">Nilai Saat ini</label>
        <input type="number" name="nilai_saat_ini" id="nilai_saat_ini"
            value="{{ $getAsetValue('nilai_saat_ini', $aset->nilai_saat_ini, $is_create, $aset) }}"
            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-150 p-2.5 text-gray-900 @error('nilai_saat_ini') border-red-500 @enderror">
        @error('nilai_saat_ini')
            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="keterangan" class="block text-sm font-medium text-gray-700">Keterangan</label>
        <input name="keterangan" id="keterangan"
            value="{{ $getAsetValue('keterangan', $aset->keterangan, $is_create, $aset) }}"
            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-150 p-2.5 text-gray-900 @error('keterangan') border-red-500 @enderror">
        @error('keterangan')
            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
        @enderror
    </div>

</div>
