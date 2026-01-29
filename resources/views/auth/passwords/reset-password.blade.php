<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" href="{{ asset('images/logo-kel.ico') }}">
    <title>Reset Password</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="flex min-h-screen items-center justify-center bg-gray-100 p-4">
        <div class="w-full max-w-md bg-white rounded-xl shadow-2xl p-8">

            <h2 class="text-3xl font-bold text-gray-800 text-center mb-6">Atur Ulang Password</h2>
            <p class="text-gray-600 text-center mb-6">Masukkan password baru Anda.</p>
            @if (session('status'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative mb-4"
                    role="alert">
                    {{ session('status') }}
                </div>
            @endif
            
            <form method="POST" action="{{ route('password.update') }}" x-data="{ showPass1: false, showPass2: false }">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Alamat Email</label>
                    <input id="email" type="email" name="email" value="{{ $email ?? old('email') }}" required
                        autocomplete="email"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-500 @enderror">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
                    <div class="relative">
                        <input id="password" :type="showPass1 ? 'text' : 'password'" name="password" required
                            autocomplete="new-password"
                            class="w-full px-4 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('password') border-red-500 @enderror pr-10">
                        
                        <button type="button" @click="showPass1 = !showPass1" class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5 text-gray-600 focus:outline-none">
                            <i class="bi" :class="showPass1 ? 'bi-eye-slash-fill' : 'bi-eye-fill'"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-6">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password Baru</label>
                    <div class="relative">
                        <input id="password_confirmation" :type="showPass2 ? 'text' : 'password'" name="password_confirmation" required
                            autocomplete="new-password"
                            class="w-full px-4 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        
                        <button type="button" @click="showPass2 = !showPass2" class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5 text-gray-600 focus:outline-none">
                            <i class="bi" :class="showPass2 ? 'bi-eye-slash-fill' : 'bi-eye-fill'"></i>
                        </button>
                    </div>
                </div>

                <div class="flex flex-col items-center">
                    <button type="submit"
                        class="w-full bg-red-600 text-white font-semibold py-2 rounded-lg hover:bg-red-700 transition duration-200 shadow-md">
                        Reset Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>