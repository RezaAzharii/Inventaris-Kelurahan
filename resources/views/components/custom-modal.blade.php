@props([
    'id',
    'title' => 'Modal',
    'action',
    'method' => 'POST',
    'maxWidth' => 'sm:max-w-lg',
    'closeOnBackdrop' => true,
    'buttonText' => 'Simpan',
    'cancelText' => 'Batal',
    'enctype' => null, // penting untuk upload file
])

<div x-data="{ open: false }" x-init="@if ($errors->any() && ($is_edit_modal ?? false)) open = true @endif"
    @open-modal.window="
        if ($event.detail.id === '{{ $id }}') open = true
    "
    @close-modal.window="
        if ($event.detail.id === '{{ $id }}') open = false
    " class="relative z-50"
    role="dialog" aria-modal="true">
    <!-- BACKDROP -->
    <div x-show="open" x-transition.opacity class="fixed inset-0 bg-black/50"
        @if ($closeOnBackdrop) @click="open = false" @endif></div>

    <!-- MODAL WRAPPER -->
    <div x-show="open" class="fixed inset-0 z-50 flex items-center justify-center p-4 overflow-y-auto">
        <div x-show="open" x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-6 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-6 sm:scale-95"
            class="relative w-full bg-white rounded-xl shadow-2xl overflow-hidden
                   {{ $maxWidth }} max-h-[90vh]"
            @keydown.escape.window="open = false">

            <!-- HEADER -->
            <div class="bg-slate-800 px-6 py-4 flex justify-between items-center">
                <h3 class="text-lg font-bold text-white">
                    {{ $title }}
                </h3>

                <button type="button" @click="open = false" class="text-white/70 hover:text-white transition">
                    ✕
                </button>
            </div>

            <!-- FORM -->
            <form action="{{ $action }}" method="POST"
                @if ($enctype) enctype="{{ $enctype }}" @endif
                class="flex flex-col max-h-[calc(90vh-64px)]">
                @csrf

                @if (in_array(strtolower($method), ['put', 'patch', 'delete']))
                    @method($method)
                @endif

                <!-- BODY -->
                <div class="px-6 py-6 overflow-y-auto flex-1">
                    {{ $slot }}
                </div>

                <!-- FOOTER -->
                <div class="bg-gray-50 px-6 py-4 flex justify-end gap-3">
                    <button type="button" @click="open = false"
                        class="px-4 py-2 rounded-lg border border-gray-300 bg-white
                               text-sm font-semibold text-gray-700 hover:bg-gray-100">
                        {{ $cancelText }}
                    </button>

                    <button type="submit"
                        class="px-4 py-2 rounded-lg bg-blue-600 text-white
                               text-sm font-semibold hover:bg-blue-700">
                        {{ $buttonText }}
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>
