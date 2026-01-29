<div class="fixed top-0 left-0 h-screen w-64 bg-[#1E293B] text-white p-4 flex flex-col z-20 transition-transform duration-300"
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-64'">

    <div class="text-center mb-6">
        <img class="h-[130px] w-[128px] mx-auto block" src="{{ asset('images/logo-kel.jpg') }}" alt="Logo Kelurahan">
    </div>

    <ul class="space-y-1">
        @foreach ($menuItems as $item)
            @php
                $isActive =
                    request()->routeIs($item['route'] ?? '') ||
                    collect($item['children'] ?? [])
                        ->pluck('route')
                        ->contains(fn($r) => request()->routeIs($r));
            @endphp

            @if (!empty($item['children']))
                <li>
                    <button
                        @click="openMenu === '{{ $item['label'] }}' ? openMenu = '' : openMenu = '{{ $item['label'] }}'"
                        class="w-full flex justify-between items-center px-3 py-2 rounded-md hover:bg-[#334155] transition-colors duration-200 {{ $isActive ? 'bg-[#334155]' : '' }}">
                        <span class="flex items-center gap-2">
                            <i class="{{ $item['icon'] }}"></i>
                            <span>{{ $item['label'] }}</span>
                        </span>
                        <i class="bi bi-chevron-down text-sm transition-transform duration-200"
                            :class="openMenu === '{{ $item['label'] }}' ? 'rotate-180' : ''"></i>
                    </button>

                    <ul x-show="openMenu === '{{ $item['label'] }}'" x-collapse class="pl-6 mt-1 space-y-1">
                        @foreach ($item['children'] as $child)
                            <li>
                                <a href="{{ route($child['route']) }}"
                                    class="block px-3 py-2 rounded-md text-sm hover:bg-[#334155] transition-colors duration-200 {{ request()->routeIs($child['route']) ? 'bg-[#334155] font-semibold' : '' }}">
                                    {{ $child['label'] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            @else
                <li>
                    <a href="{{ route($item['route']) }}"
                        class="flex items-center gap-2 px-3 py-2 rounded-md hover:bg-[#334155] transition-colors duration-200 {{ $isActive ? 'bg-[#334155] font-semibold' : '' }}">
                        <i class="{{ $item['icon'] }}"></i>
                        <span>{{ $item['label'] }}</span>
                    </a>
                </li>
            @endif
        @endforeach
    </ul>
</div>
