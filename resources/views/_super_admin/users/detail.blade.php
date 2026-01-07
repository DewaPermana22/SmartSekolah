@extends('_super_admin._layout.app')

@section('title', 'Detail Pengguna')

@php
    use App\Constants\UserConst;
@endphp

@section('content')
    <div class="max-w-4xl mx-auto">
        <!-- Breadcrumb & Title -->
        <div class="mb-6">
            <div class="flex items-center gap-x-3 mb-2">
                <a navigate href="{{ route('superadmin.users.index') }}"
                    class="size-10 flex items-center justify-center rounded-full bg-white border border-gray-200 text-gray-600 hover:bg-gray-50 transition-colors shadow-sm dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400">
                    <svg class="size-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m15 18-6-6 6-6" />
                    </svg>
                </a>
                <h1 class="text-2xl font-extrabold text-gray-800 dark:text-neutral-200">
                    Detail Pengguna
                </h1>
            </div>
            <p class="text-sm text-gray-500 dark:text-neutral-500 ml-13">
                Informasi detail akun pengguna sistem.
            </p>
        </div>

        <div
            class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8 dark:bg-neutral-800 dark:border-neutral-700">
            <div class="flex flex-col md:flex-row gap-8 items-center md:items-start">
                <div class="shrink-0">
                    <div
                        class="size-32 rounded-full bg-blue-50 flex items-center justify-center text-blue-600 text-4xl font-bold border-4 border-white shadow-lg dark:bg-blue-900/30 dark:text-blue-400 dark:border-neutral-700">
                        {{ strtoupper(substr($data->name, 0, 1)) }}
                    </div>
                </div>

                <!-- Info Section -->
                <div class="grow w-full space-y-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="space-y-1">
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider dark:text-neutral-500">
                                Nama Lengkap
                            </p>
                            <p class="text-sm font-bold text-gray-800 dark:text-neutral-200">
                                {{ $data->name }}
                            </p>
                        </div>

                        <div class="space-y-1">
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider dark:text-neutral-500">
                                Email
                            </p>
                            <p class="text-sm font-bold text-gray-800 dark:text-neutral-200">
                                {{ $data->email }}
                            </p>
                        </div>

                        <div class="space-y-1">
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider dark:text-neutral-500">
                                Hak Akses
                            </p>
                            <span
                                class="inline-flex items-center gap-x-1.5 py-1 px-2.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">
                                {{ UserConst::getAccessTypes()[$data->access_type] ?? '-' }}
                            </span>
                        </div>

                        <div class="space-y-1">
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider dark:text-neutral-500">
                                Sekolah
                            </p>
                            <p class="text-sm font-bold text-gray-800 dark:text-neutral-200">
                                @php
                                    $school = DB::table('schools')->where('id', $data->school_id)->first();
                                @endphp
                                {{ $school->school_name ?? 'Super Admin' }}
                            </p>
                        </div>

                        <div class="space-y-1">
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider dark:text-neutral-500">
                                Status Akun
                            </p>
                            @if($data->is_active)
                                <span
                                    class="inline-flex items-center gap-x-1.5 py-1 px-2.5 rounded-full text-xs font-medium bg-teal-100 text-teal-800 dark:bg-teal-900/30 dark:text-teal-400">
                                    <span class="size-1.5 rounded-full bg-teal-500"></span>
                                    Aktif
                                </span>
                            @else
                                <span
                                    class="inline-flex items-center gap-x-1.5 py-1 px-2.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">
                                    <span class="size-1.5 rounded-full bg-red-500"></span>
                                    Non-Aktif
                                </span>
                            @endif
                        </div>

                        <div class="space-y-1">
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider dark:text-neutral-500">
                                Terdaftar Pada
                            </p>
                            <p class="text-sm font-bold text-gray-800 dark:text-neutral-200">
                                {{ \Carbon\Carbon::parse($data->created_at)->translatedFormat('d F Y, H:i') }}
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    
@endsection