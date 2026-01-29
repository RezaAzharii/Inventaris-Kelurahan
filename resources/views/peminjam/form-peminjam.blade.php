@php
    if (!isset($peminjam)) {
        $peminjam = null;
    }

    $is_create = is_null($peminjam) || !isset($peminjam->id_peminjam);

    $peminjam = $peminjam ?? (object) [
        'nik' => '',
        'nama_peminjam' => '',
        'no_telp' => '', 
    ];

    $getPeminjamValue = function ($fieldName, $peminjamValue, $isCreate, $currentPeminjam) {

        $oldId = session()->get('id_peminjam');
        $oldAction = session()->get('action');

        // Saat CREATE dan ada input old()
        if ($isCreate && $oldAction === 'create' && old($fieldName) !== null) {
            return old($fieldName);
        }

        // Saat EDIT, jika id_peminjam sama & ada old()
        if (
            !$isCreate &&
            isset($currentPeminjam->id_peminjam) &&
            $oldId == $currentPeminjam->id_peminjam &&
            old($fieldName) !== null
        ) {
            return old($fieldName);
        }

        return $peminjamValue;
    };
@endphp

<div class="space-y-4">

    {{-- NIK --}}
    <div>
        <label for="nik" class="block text-sm font-medium text-gray-700">
            NIK
        </label>

        <input
            type="text"
            name="nik"
            id="nik"
            required
            inputmode="numeric"
            pattern="[0-9]{16}"
            minlength="16"
            maxlength="16"
            placeholder="16 digit NIK"
            value="{{ $getPeminjamValue('nik', $peminjam->nik, $is_create, $peminjam) }}"
            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm
                focus:border-blue-500 focus:ring-blue-500 transition duration-150 p-2.5 text-gray-900
                @error('nik') border-red-500 @enderror"
            oninput="this.value = this.value.replace(/[^0-9]/g, '')"
        >

        @error('nik')
            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
        @enderror
    </div>

    {{-- NAMA PEMINJAM --}}
    <div>
        <label for="nama_peminjam" class="block text-sm font-medium text-gray-700">Nama Peminjam</label>
        <input type="text" name="nama_peminjam" id="nama_peminjam" required
            value="{{ $getPeminjamValue('nama_peminjam', $peminjam->nama_peminjam, $is_create, $peminjam) }}"
            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm 
                   focus:border-blue-500 focus:ring-blue-500 transition duration-150 p-2.5 text-gray-900
                   @error('nama_peminjam') border-red-500 @enderror">
        @error('nama_peminjam')
            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
        @enderror
    </div>

    {{-- NOMOR TELEPON --}}
<div>
    <label for="no_telp" class="block text-sm font-medium text-gray-700">
        No. Telepon
    </label>

    <input
        type="text"
        name="no_telp"
        id="no_telp"
        required
        inputmode="numeric"
        pattern="[0-9]{10,13}"
        minlength="10"
        maxlength="13"
        placeholder="Contoh: 081234567890"
        value="{{ $getPeminjamValue('no_telp', $peminjam->no_telp, $is_create, $peminjam) }}"
        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm
               focus:border-blue-500 focus:ring-blue-500 transition duration-150 p-2.5 text-gray-900
               @error('no_telp') border-red-500 @enderror"
        oninput="this.value = this.value.replace(/[^0-9]/g, '')"
    >

    @error('no_telp')
        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
    @enderror
</div>

</div>
