<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" href="{{ asset('images/logo-kel.ico') }}">
    <title>Register</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="w-full max-w-lg bg-white rounded-lg shadow-2xl p-6">
        <div class="text-center mb-4">
            <img class="h-[130px] w-[128px] mx-auto block" src="{{ asset('images/logo-kel.jpg') }}" alt="Logo Kelurahan">
            <h2 class="text-lg font-semibold text-gray-800 mt-2">
                Registrasi
            </h2>
        </div>

        {{-- ERROR --}}
        @if ($errors->any())
            <div class="mb-3 bg-red-100 text-red-700 px-3 py-2 rounded text-sm">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}" class="space-y-3">
            @csrf

            {{-- GRID --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">

                <div>
                    <label class="text-sm font-medium text-gray-700">Nama</label>
                    <input type="text" name="nama" value="{{ old('nama') }}" required
                        class="w-full px-3 py-2 border rounded-md focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                        class="w-full px-3 py-2 border rounded-md focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-700">No HP</label>
                    <input type="text" name="no_hp" value="{{ old('no_hp') }}" required
                        class="w-full px-3 py-2 border rounded-md focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-700">Password</label>
                    <input type="password" name="password" required
                        class="w-full px-3 py-2 border rounded-md focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-700">Konfirmasi</label>
                    <input type="password" name="password_confirmation" required
                        class="w-full px-3 py-2 border rounded-md focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>

            {{-- ALAMAT --}}
            <div>
                <label class="text-sm font-medium text-gray-700">Alamat</label>
                <textarea name="alamat" rows="2" required
                    class="w-full px-3 py-2 border rounded-md focus:ring-blue-500 focus:border-blue-500">{{ old('alamat') }}</textarea>
            </div>

            <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 rounded-md">
                Daftar
            </button>

            <p class="text-center text-sm text-gray-600">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Login</a>
            </p>
        </form>
    </div>

</body>
</html>
