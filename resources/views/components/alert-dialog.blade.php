@props([
    'title' => 'Konfirmasi',
    'message' => 'Apakah Anda yakin ingin menghapus data ini?',
    'confirmText' => 'Ya, Hapus',
    'cancelText' => 'Batal',
    'action' => '#',
])

<div 
    x-data="{ show: false }" 
    role="dialog" 
    aria-modal="true"
    class="relative"
>
    <span @click="show = true">
        {{ $trigger ?? '' }}
    </span>

    <div 
        x-show="show" 
        x-transition.opacity 
        class="fixed inset-0 z-50 bg-black/50"
    ></div>

    <div 
        x-show="show" 
        class="fixed inset-0 z-50 flex items-center justify-center p-4"
        @click.away="show = false"
    >
        <div 
            x-show="show" 
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-6 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-6 sm:scale-95"
            @keydown.escape.window="show = false"
            
            class="relative bg-white rounded-xl p-6 w-full max-w-md shadow-2xl transform transition-all"
        >
            <h3 class="text-xl font-bold text-gray-800 mb-2">
                {{ $title }}
            </h3>
            
            <p class="text-gray-600 mb-6">
                {{ $message }}
            </p>
            
            <div class="flex justify-end gap-3">
                <button @click="show = false" type="button"
                    class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100 shadow-sm transition">
                    {{ $cancelText }}
                </button>

                <form method="POST" action="{{ $action }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 shadow-sm transition">
                        {{ $confirmText }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>