@extends('layouts.app')

@section('title', 'Inventaris Aset - Profil')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">

            @if (session('success'))
                <div
                    class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-center shadow-sm">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="px-6 pb-6">
                    <div class="flex flex-col pt-20 sm:flex-row justify-between items-center sm:items-end -mt-16 mb-6">
                        <div class="flex items-center sm:items-end">
                            <div
                                class="w-32 h-32 rounded-full bg-white border-4 border-white shadow-lg flex items-center justify-center text-4xl font-bold text-gray-600 mb-4 sm:mb-0 z-10">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>

                            <div class="sm:ml-6 text-center sm:text-left pb-5">
                                <h1 class="text-3xl font-bold text-gray-800">{{ $user->name }}</h1>
                                <p class="text-gray-600 mt-1">{{ $user->email }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 my-6"></div>

                    <div class="space-y-4">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-xl font-semibold text-gray-800">Informasi Profil</h2>
                            <button @click="$dispatch('open-modal', { id: 'editProfileModal' })"
                                class="flex items-center text-sm font-medium text-blue-600 hover:text-blue-800 p-2 rounded-lg bg-blue-50 hover:bg-blue-100 shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </button>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-sm font-medium text-gray-500 mb-1">Nama</p>
                                <p class="text-base font-semibold text-gray-800">{{ $user->name }}</p>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-sm font-medium text-gray-500 mb-1">Email</p>
                                <p class="text-base font-semibold text-gray-800">{{ $user->email }}</p>
                            </div>
                            @if (auth()->user()->role === 'isPeminjam')
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <p class="text-sm text-gray-500">No. HP</p>
                                    <p class="font-semibold">{{ $peminjam->no_telp ?? '-' }}</p>
                                </div>

                                <div class="bg-gray-50 rounded-lg p-4">
                                    <p class="text-sm text-gray-500">NIK</p>
                                    <p class="font-semibold">{{ $peminjam->nik ?? '-' }}</p>
                                </div>

                                <div class="bg-gray-50 rounded-lg p-4 md:col-span-2">
                                    <p class="text-sm text-gray-500">Alamat</p>
                                    <p class="font-semibold">{{ $peminjam->alamat ?? '-' }}</p>
                                </div>
                            @endif
                        </div>

                        <div class="flex justify-end">
                            <a href="{{ route('password.change') }}"
                                class="w-auto bg-gray-600 hover:bg-gray-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-200 text-center shadow-md hover:shadow-lg">
                                <svg class="w-5 h-5 inline-block mr-2 -mt-1" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                                </svg>
                                Ganti Password
                            </a>
                        </div>
                    </div>
                </div>



            </div>
        </div>

        <x-custom-modal id="editProfileModal" title="Edit Profil" :action="route('profile.update')" method="PUT" buttonText="Simpan">
            <div>
                <label class="text-sm font-medium">Nama</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}"
                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm 
                                  focus:border-blue-500 focus:ring-blue-500 
                                  @error('name') border-red-500 @enderror
                                  transition duration-150 p-2.5 text-gray-900 placeholder-gray-400">
            </div>
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="email" value="{{ $user->email }}" disabled
                    class="mt-1 block w-full rounded-lg border-gray-300 bg-gray-100 shadow-inner 
                                  cursor-not-allowed transition duration-150 p-2.5 text-gray-500">
                <p class="mt-1 text-xs text-gray-500">Email tidak dapat diubah di sini. Silakan hubungi
                    administrator jika perlu diperbarui.</p>
            </div>

            {{-- KHUSUS PEMINJAM --}}
            @if (auth()->user()->role === 'isPeminjam')
                <div>
                    <label class="text-sm font-medium">NIK</label>
                    <input type="text" name="nik" value="{{ old('nik', $peminjam->nik ?? '') }}"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm 
                                  focus:border-blue-500 focus:ring-blue-500 
                                  @error('name') border-red-500 @enderror
                                  transition duration-150 p-2.5 text-gray-900 placeholder-gray-400">
                </div>

                <div>
                    <label class="text-sm font-medium">No HP</label>
                    <input type="text" name="no_telp" value="{{ old('no_telp', $peminjam->no_telp ?? '') }}"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm 
                                  focus:border-blue-500 focus:ring-blue-500 
                                  @error('name') border-red-500 @enderror
                                  transition duration-150 p-2.5 text-gray-900 placeholder-gray-400">
                </div>

                <div>
                    <label class="text-sm font-medium">Alamat</label>
                    <textarea name="alamat"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm 
                                  focus:border-blue-500 focus:ring-blue-500 
                                  @error('name') border-red-500 @enderror
                                  transition duration-150 p-2.5 text-gray-900 placeholder-gray-400">{{ old('alamat', $peminjam->alamat ?? '') }}</textarea>
                </div>
            @endif
        </x-custom-modal>
    @endsection
