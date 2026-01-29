<nav class="bg-[#1E293B] text-white sticky top-0 w-full z-50 shadow-md" x-data="{ open: false }">
    <div class="flex items-center justify-between px-3 py-3">
        <div class="flex items-center space-x-3">
            <button 
                @click="sidebarOpen = !sidebarOpen" 
                class="text-gray-300 hover:text-white focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

            <span class="font-semibold text-lg">Inventaris Kelurahan Balecatur</span>
        </div>

        <div class="relative mr-6" x-data="{ userMenu: false }">
            <button @click="userMenu = !userMenu"
                class="flex items-center space-x-2 focus:outline-none hover:text-gray-300">
                <span>{{ auth()->user()->name ?? 'User' }}</span>
                <svg :class="userMenu ? 'rotate-180' : ''" class="w-4 h-4 transition-transform duration-200"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>

            <div x-show="userMenu" @click.away="userMenu = false" x-transition
                class="absolute right-0 mt-2 w-40 bg-white text-gray-800 rounded-md shadow-lg py-1 z-50">
                <a href="{{ route("profile.index") }}" class="block px-4 py-2 hover:bg-gray-100">Profile</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2 hover:bg-gray-100">Logout</button>
                </form>
            </div>
        </div>
    </div>
</nav>
