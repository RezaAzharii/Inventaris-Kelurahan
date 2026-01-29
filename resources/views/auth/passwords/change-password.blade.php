<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" href="{{ asset('images/logo-kel.ico') }}">
    <title>Ubah Password</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="container mx-auto p-4">
        <div class="max-w-lg bg-white rounded-xl shadow-2xl p-8 mx-auto">

            <h2 class="text-3xl font-bold text-gray-800 mb-6">Ubah Password</h2>
            <p class="text-gray-600 mb-6">Demi keamanan, Anda akan diminta login ulang setelah mengubah password.</p>

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative mb-4"
                    role="alert">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any() && !($errors->has('current_password') || $errors->has('password')))
                <div class="mb-4 bg-red-100 text-red-700 px-4 py-3 rounded-md">
                    <ul class="list-disc pl-5 space-y-1 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif


            <form method="POST" action="{{ route('password.update.profile') }}">
                @csrf
                <div class="mb-4" x-data="{ show: false }">
                    <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">Password Saat Ini</label>
                    <div class="relative">
                        <input id="current_password" :type="show ? 'text' : 'password'" name="current_password" required
                            autocomplete="current-password"
                            class="w-full px-4 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('current_password') border-red-500 @enderror pr-10">
                        
                        <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5 text-gray-600 focus:outline-none">
                            <i class="bi" :class="show ? 'bi-eye-slash-fill' : 'bi-eye-fill'"></i>
                        </button>
                    </div>
                    @error('current_password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4" x-data="{ show: false }">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
                    <div class="relative">
                        <input id="password" :type="show ? 'text' : 'password'" name="new_password" required
                            autocomplete="new-password"
                            class="w-full px-4 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('password') border-red-500 @enderror pr-10">
                        
                        <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5 text-gray-600 focus:outline-none">
                            <i class="bi" :class="show ? 'bi-eye-slash-fill' : 'bi-eye-fill'"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-6" x-data="{ show: false }">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password Baru</label>
                    <div class="relative">
                        <input id="password_confirmation" :type="show ? 'text' : 'password'" name="new_password_confirmation" required
                            autocomplete="new-password"
                            class="w-full px-4 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500 pr-10">
                        
                        <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5 text-gray-600 focus:outline-none">
                            <i class="bi" :class="show ? 'bi-eye-slash-fill' : 'bi-eye-fill'"></i>
                        </button>
                    </div>
                </div>

                <button type="submit"
                    class="w-full bg-red-600 text-white font-semibold py-2 rounded-lg hover:bg-red-700 transition duration-200 shadow-md">
                    Ubah Password
                </button>
            </form>
        </div>
    </div>
</body>
</html>