@extends('_admin._layout.app')

@section('title', 'Dashboard')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-extrabold text-gray-800 dark:text-neutral-200 mb-1">Beranda Guru</h1>
        <p class="text-md text-gray-400 dark:text-neutral-400">Selamat datang di dashboard SmartSekolah</p>
    </div>

    @if (Auth::user()->school_id)
        <!-- Teacher Account Information Section -->
        <div class="grid sm:grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6 mb-6">
            <!-- Profile Card -->
            <div class="lg:col-span-2 flex flex-col bg-white border border-gray-200 shadow-sm rounded-xl dark:bg-neutral-900 dark:border-neutral-700">
                <div class="p-6">
                    <div class="flex items-start gap-5">
                        <!-- Avatar -->
                        <div class="shrink-0">
                            <div class="size-20 flex items-center justify-center bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-full font-bold text-2xl shadow-lg">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                        </div>

                        <!-- Profile Info -->
                        <div class="flex-1">
                            <div class="mb-3">
                                <h2 class="text-xl font-bold text-gray-800 dark:text-neutral-200">
                                    {{ Auth::user()->name }}
                                </h2>
                                <p class="text-sm text-gray-500 dark:text-neutral-400">Guru</p>
                            </div>

                            <div class="space-y-2">
                                <div class="flex items-center gap-2 text-sm">
                                    <svg class="shrink-0 size-4 text-gray-500 dark:text-neutral-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    <span class="text-gray-700 dark:text-neutral-300">{{ Auth::user()->email }}</span>
                                </div>

                                <div class="flex items-center gap-2 text-sm">
                                    <svg class="shrink-0 size-4 text-gray-500 dark:text-neutral-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                    <span class="text-gray-700 dark:text-neutral-300">ID Sekolah: {{ Auth::user()->school_id }}</span>
                                </div>

                                <div class="flex items-center gap-2 text-sm">
                                    <svg class="shrink-0 size-4 text-gray-500 dark:text-neutral-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span class="inline-flex items-center gap-1.5 py-1 px-2 rounded-full text-xs font-medium {{ Auth::user()->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
                                        {{ Auth::user()->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Account Status Card -->
            <div class="flex flex-col bg-gradient-to-br from-blue-500 to-blue-600 border border-blue-600 shadow-lg rounded-xl text-white">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold">Status Akun</h3>
                        <svg class="size-8 opacity-80" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>

                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-sm opacity-90">Tipe Akses</span>
                            <span class="text-sm font-semibold">Guru ({{ Auth::user()->access_type }})</span>
                        </div>

                        <div class="flex justify-between items-center">
                            <span class="text-sm opacity-90">Terdaftar Sejak</span>
                            <span class="text-sm font-semibold">{{ Auth::user()->created_at->format('d M Y') }}</span>
                        </div>

                        @if (Auth::user()->email_verified_at)
                        <div class="flex justify-between items-center">
                            <span class="text-sm opacity-90">Email Terverifikasi</span>
                            <svg class="size-5 text-green-200" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Stats Cards -->
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
            <!-- Welcome Message Card -->
            <div class="lg:col-span-2 flex flex-col bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-neutral-900 dark:border-neutral-700">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-neutral-200 mb-2">
                        Selamat Datang, {{ explode(' ', Auth::user()->name)[0] }}! 👋
                    </h3>
                    <p class="text-sm text-gray-600 dark:text-neutral-400 leading-relaxed">
                        Anda masuk sebagai guru di SmartSekolah. Gunakan menu navigasi di sebelah kiri untuk mengakses berbagai fitur yang tersedia untuk mengelola pembelajaran.
                    </p>
                </div>
            </div>

            <!-- Last Login Card -->
            <div class="flex flex-col bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition dark:bg-neutral-900 dark:border-neutral-700">
                <div class="p-6">
                    <div class="flex items-center gap-3">
                        <div class="shrink-0 size-12 flex items-center justify-center bg-purple-100 dark:bg-purple-900/30 rounded-lg">
                            <svg class="size-6 text-purple-600 dark:text-purple-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 dark:text-neutral-400">Login Terakhir</p>
                            <h4 class="text-sm font-semibold text-gray-800 dark:text-neutral-200">
                                {{ optional(Auth::user()->updated_at)->diffForHumans() }}
                            </h4>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Account Age Card -->
            <div class="flex flex-col bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition dark:bg-neutral-900 dark:border-neutral-700">
                <div class="p-6">
                    <div class="flex items-center gap-3">
                        <div class="shrink-0 size-12 flex items-center justify-center bg-emerald-100 dark:bg-emerald-900/30 rounded-lg">
                            <svg class="size-6 text-emerald-600 dark:text-emerald-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 dark:text-neutral-400">Akun Terdaftar</p>
                            <h4 class="text-sm font-semibold text-gray-800 dark:text-neutral-200">
                                {{ Auth::user()->created_at->diffForHumans() }}
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="flex flex-col bg-yellow-50 border border-yellow-200 rounded-xl p-6 dark:bg-yellow-900/10 dark:border-yellow-900/30">
            <div class="flex items-start gap-3">
                <svg class="shrink-0 size-6 text-yellow-600 dark:text-yellow-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                <div>
                    <h3 class="text-sm font-semibold text-yellow-800 dark:text-yellow-200">Akun Belum Terkonfigurasi</h3>
                    <p class="text-sm text-yellow-700 dark:text-yellow-300 mt-1">
                        Akun Anda belum terhubung dengan sekolah. Silakan hubungi administrator untuk konfigurasi lebih lanjut.
                    </p>
                </div>
            </div>
        </div>
    @endif
@endsection
