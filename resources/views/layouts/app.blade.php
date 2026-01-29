<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" href="{{ asset('images/logo-kel.ico') }}">
    <title>@yield('title', 'Inventaris Aset')</title>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body x-data="{ sidebarOpen: true }" class="bg-gray-100 overflow-x-hidden">

    @include('partials.sidebar')

    <div class="transition-all duration-300 z-10" :class="sidebarOpen ? 'ml-64' : 'ml-0'">

        @include('partials.navbar')

        <main class="px-4">
            @yield('content')
        </main>

    </div>

    @stack('scripts')

</body>


</html>
