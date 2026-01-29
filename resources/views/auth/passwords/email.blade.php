<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" href="{{ asset('images/logo-kel.ico') }}">
    <title>Lupa Password</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="flex min-h-screen items-center justify-center bg-gray-100 p-4">
        <div class="w-full max-w-md bg-white rounded-xl shadow-2xl p-8">

            <h2 class="text-3xl font-bold text-gray-800 text-center mb-6">Lupa Password</h2>
            <p class="text-gray-600 text-center mb-6">Masukkan alamat email Anda untuk menerima tautan reset password.</p>
            @if (session('status'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative mb-4"
                    role="alert">
                    <p class="font-bold">Tautan Terkirim!</p>
                    <p class="text-sm mt-1">
                        {{ session('status') }}
                        <br>
                        **Cek kotak masuk atau folder spam/junk email Anda.**
                    </p>
                </div>
            @else
                <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-4 text-sm text-blue-700" role="alert">
                    <p class="font-bold mb-1">Setelah Kirim Tautan:</p>
                    <ul class="list-disc ml-5 space-y-1">
                        <li>Cek email Anda (alamat yang Anda masukkan di bawah).</li>
                        <li>Pastikan untuk memeriksa folder Spam atau Junk jika email tidak muncul dalam 5 menit.</li>
                        <li>Tautan reset password hanya berlaku selama 60 menit.</li>
                    </ul>
                </div>
            @endif
            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Alamat Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required
                        autocomplete="email" autofocus
                        class="w-full px-4 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-500 @enderror">

                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-col items-center">
                    <button type="submit"
                        class="w-full bg-blue-600 text-white font-semibold py-2 rounded-lg hover:bg-blue-700 transition duration-200 shadow-md">
                        Kirim Tautan Reset Password
                    </button>

                    <a href="{{ route('login') }}" class="mt-4 text-sm text-blue-600 hover:text-blue-800">
                        Kembali ke halaman login
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>