<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" href="{{ asset('images/logo-kel.ico') }}">
    <title>Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="w-full max-w-md bg-white rounded-lg shadow-2xl p-8">
        {{-- <h2 class="text-2xl font-semibold text-center text-gray-800 mb-6">Login</h2> --}}
        <div class="text-center mb-6">
            <img class="h-[130px] w-[128px] mx-auto block" src="{{ asset('images/logo-kel.jpg') }}" alt="Logo Kelurahan">
        </div>

        @if ($errors->any())
            <div class="mb-4 bg-red-100 text-red-700 px-4 py-3 rounded-md">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ url('/login') }}" class="space-y-4">
            @csrf

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none" />
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" id="password" name="password" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none" />
                <div class="text-right mt-1">
                    <a href="{{ route('auth.passwords.email') }}" class="text-sm text-blue-600 hover:underline">Lupa
                        password?</a>
                </div>
            </div>

            <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 rounded-md transition-colors">
                Masuk
            </button>

            <p class="text-center text-sm text-gray-600">
                Belum punya akun?
                <a href="{{ route('register') }}" class="text-blue-600 hover:underline">Daftar</a>
            </p>
        </form>
    </div>

</body>

</html>
