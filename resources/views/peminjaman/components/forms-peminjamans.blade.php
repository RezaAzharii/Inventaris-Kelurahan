@php
    $peminjam = $peminjam ?? [];
    $asets = $asets ?? [];

    $peminjaman =
        $peminjaman ??
        (object) [
            'id_peminjaman' => null,
            'id_peminjam' => '',
            'id_aset' => '',
            'jumlah' => 1,
            'tanggal_pinjam' => now(),
            'tanggal_kembali' => '',
            'status' => 'pending',
        ];

    $is_create = is_null($peminjaman->id_peminjaman);
    $user = auth()->user();
@endphp


<div class="space-y-4">
    {{-- @dd(auth()->user(), auth()->user()->peminjam) --}}

    @if ($user->role === 'isAdmin')
        <div>
            <label class="block text-sm font-medium text-gray-700">Peminjam</label>
            <select name="id_peminjam" required
                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm
                   focus:border-blue-500 focus:ring-blue-500 p-2.5">
                <option value="">-- Pilih Peminjam --</option>
                @foreach ($peminjam as $p)
                    <option value="{{ $p->id_peminjam }}"
                        {{ $peminjaman->id_peminjam == $p->id_peminjam ? 'selected' : '' }}>
                        {{ $p->nama_peminjam }}
                    </option>
                @endforeach
            </select>
        </div>
    @endif


    <!-- ASET -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Aset</label>
        <select name="id_aset"
            class="id_aset mt-1 block w-full rounded-lg border-gray-300 shadow-sm
               focus:border-blue-500 focus:ring-blue-500 p-2.5"
            required>
            <option value="">-- Pilih Aset --</option>

            @foreach ($asets as $aset)
                @php
                    $dipinjam = \App\Models\Peminjaman::where('id_aset', $aset->id_aset)
                        ->where('status', 'dipinjam')
                        ->sum('jumlah');

                    $jumlahLama = !$is_create && $peminjaman->id_aset == $aset->id_aset ? $peminjaman->jumlah : 0;

                    $tersedia = max(0, $aset->jumlah - $dipinjam);
                    $maxInput = $tersedia + $jumlahLama;
                @endphp

                <option value="{{ $aset->id_aset }}" data-max="{{ $maxInput }}"
                    {{ $peminjaman->id_aset == $aset->id_aset ? 'selected' : '' }}>
                    {{ $aset->identitas_barang }} (tersedia {{ $maxInput }})
                </option>
            @endforeach
        </select>
    </div>


    <!-- JUMLAH -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Jumlah</label>
        <input type="number" name="jumlah" min="1" inputmode="numeric" value="{{ $peminjaman->jumlah }}"
            required
            class="jumlah mt-1 block w-full rounded-lg border-gray-300 shadow-sm
                   focus:border-blue-500 focus:ring-blue-500 transition duration-150
                   p-2.5 text-gray-900 @error('jumlah') border-red-500 @enderror"
            required>
        @error('jumlah')
            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <!-- TANGGAL PINJAM -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Tanggal Pinjam</label>
        <input type="datetime-local" name="tanggal_pinjam"
            value="{{ old(
                'tanggal_pinjam',
                $peminjaman->tanggal_pinjam ? \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('Y-m-d\TH:i') : '',
            ) }}"
            required
            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm
                   focus:border-blue-500 focus:ring-blue-500 transition duration-150
                   p-2.5 text-gray-900 @error('tanggal_pinjam') border-red-500 @enderror"
            required>
        @error('tanggal_pinjam')
            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <!-- TANGGAL KEMBALI -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Tanggal Kembali</label>
        <input type="datetime-local" name="tanggal_kembali"
            value="{{ old(
                'tanggal_kembali',
                $peminjaman->tanggal_kembali ? \Carbon\Carbon::parse($peminjaman->tanggal_kembali)->format('Y-m-d\TH:i') : '',
            ) }}"
            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm
                   focus:border-blue-500 focus:ring-blue-500 transition duration-150
                   p-2.5 text-gray-900 @error('tanggal_kembali') border-red-500 @enderror"
            required>
        @error('tanggal_kembali')
            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
        @enderror
    </div>

    {{-- STATUS (ADMIN ONLY) --}}
    @if ($user->role === 'isAdmin')
        <div>
            <label class="block text-sm font-medium text-gray-700">Status Peminjaman</label>
            <select name="status"
                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm
                   focus:border-blue-500 focus:ring-blue-500 p-2.5"
                required>
                <option value="pending" {{ $peminjaman->status === 'pending' ? 'selected' : '' }}>
                    Pending
                </option>
                <option value="dipinjam" {{ $peminjaman->status === 'dipinjam' ? 'selected' : '' }}>
                    Dipinjam
                </option>
                <option value="dikembalikan" {{ $peminjaman->status === 'dikembalikan' ? 'selected' : '' }}>
                    Dikembalikan
                </option>
            </select>
        </div>
    @endif


</div>


<script>
    document.addEventListener('DOMContentLoaded', () => {

        document.querySelectorAll('.id_aset').forEach((asetSelect, index) => {
            const jumlahInput = document.querySelectorAll('.jumlah')[index];
            let alerted = false;

            function getMax() {
                const opt = asetSelect.options[asetSelect.selectedIndex];
                return opt && opt.dataset.max ?
                    Number(opt.dataset.max) :
                    null;
            }

            function forceJumlah() {
                const max = getMax();
                if (max === null) return;

                let val = Number(jumlahInput.value);

                if (!val || val < 1) {
                    jumlahInput.value = 0;
                    alerted = false;
                    return;
                }

                if (val > max) {
                    jumlahInput.value = max;

                    if (!alerted) {
                        alert('⚠️ Jumlah melebihi stok. Maksimal peminjaman ' + max + ' unit.');
                        alerted = true;
                    }
                } else {
                    alerted = false;
                }
            }

            asetSelect.addEventListener('change', () => {
                alerted = false;
                forceJumlah();
            });

            jumlahInput.addEventListener('input', forceJumlah);

            // validasi awal (EDIT MODE)
            setTimeout(forceJumlah, 50);
        });

    });
</script>
