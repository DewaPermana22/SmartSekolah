@extends('_admin._layout.app');

@section('title', 'Modul Belajar')

@section('content')
<div class="grid gap-3 md:flex md:justify-between md:items-center py-4">
    <x-page-title
        title="Data {{ $page['title'] }}"
        description="Kelola modul belajar untuk mendukung proses pembelajaran siswa" />
    <x-add-button :href="route('teacher.learning_modules.add')" label="Tambah Modul"></x-add-button>
</div>

<div class="flex flex-col">
    <div class="overflow-x-auto">
        <div class="min-w-full inline-block align-middle">
            <div class="overflow-hidden">

                <div class="px-2 py-2 pt-0 pb-4">
                    <form action="{{ route('teacher.learning_modules.index') }}" method="GET" navigate
                        class="flex flex-col sm:flex-row gap-3">
                        <div class="sm:w-64">
                            <label for="keywords" class="sr-only">Search</label>
                            <div class="relative">
                                <input type="text" name="keywords" id="keywords" value="{{ $keywords ?? '' }}"
                                    class="py-1 px-3 block w-full border-gray-200 rounded-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900
                                        placeholder-neutral-300 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                                    placeholder="Cari Judul Modul">
                            </div>
                        </div>
                        <div>
                            <button type="submit"
                                class="py-1 px-3 inline-flex items-center gap-x-1 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600 cursor-pointer">
                                <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="11" cy="11" r="8" />
                                    <path d="m21 21-4.3-4.3" />
                                </svg>
                                Cari
                            </button>
                            @if (!empty($keywords))
                            <a class="py-1 px-3 inline-flex items-center gap-x-1 text-sm font-semibold rounded-lg border border-blue-600 text-blue-600 hover:border-blue-500 hover:text-blue-500 hover:bg-blue-50 disabled:opacity-50 disabled:pointer-events-none dark:border-blue-500 dark:text-blue-500 dark:hover:bg-blue-500/10 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600 cursor-pointer"
                                href="{{ route('teacher.learning_modules.index') }}">
                                <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M3 6h18" />
                                    <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6" />
                                    <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2" />
                                    <line x1="10" x2="10" y1="11" y2="17" />
                                    <line x1="14" x2="14" y1="11" y2="17" />
                                </svg>
                                Reset
                            </a>
                            @endif
                        </div>
                    </form>
                </div>

                @if (session('success'))
                <div class="mb-4">
                    <div class="bg-teal-50 border border-teal-200 rounded-xl p-4 dark:bg-teal-800/10 dark:border-teal-900"
                        role="alert">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="flex-shrink-0 size-4 text-teal-600 mt-0.5 dark:text-teal-500"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z" />
                                    <path d="m9 12 2 2 4-4" />
                                </svg>
                            </div>
                            <div class="ms-3">
                                <p class="text-sm text-teal-800 dark:text-teal-200">
                                    {{ session('success') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                @if (session('error'))
                <div class="mb-4">
                    <div class="bg-red-50 border border-red-200 rounded-xl p-4 dark:bg-red-800/10 dark:border-red-900"
                        role="alert">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="flex-shrink-0 size-4 text-red-600 mt-0.5 dark:text-red-500"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z" />
                                    <path d="m15 9-6 6" />
                                    <path d="m9 9 6 6" />
                                </svg>
                            </div>
                            <div class="ms-3">
                                <p class="text-sm text-red-800 dark:text-red-200">
                                    {{ session('error') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
                    @forelse ($data as $item)
                    @php
                    $ext = strtolower(pathinfo($item->file_path, PATHINFO_EXTENSION));
                    $icon = match ($ext) {
                    'pdf' => 'text-red-500',
                    'doc', 'docx' => 'text-blue-500',
                    'ppt', 'pptx' => 'text-orange-500',
                    default => 'text-gray-400'
                    };
                    @endphp

        <div class="flex flex-col bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition dark:bg-neutral-900 dark:border-neutral-700">
            <!-- Header -->
            <div class="p-4 flex items-start gap-3">
                <div class="text-red-500">
                    @if ($ext === 'pdf')
                        @include('_admin._layout.icons.filetype.pdf')
                    @elseif (in_array($ext, ['doc', 'docx']))
                        @include('_admin._layout.icons.filetype.' . $ext)
                    @elseif (in_array($ext, ['ppt', 'pptx']))
                        @include('_admin._layout.icons.filetype.' . $ext)
                    @else
                        <svg class="size-8 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                            <path d="M14 2v6h6" />
                        </svg>
                    @endif
                </div>

                            <div class="flex-1">
                                <h3 class="text-sm font-semibold text-gray-800 dark:text-neutral-200 line-clamp-2">
                                    {{ $item->title }}
                                </h3>
                                <p class="mt-1 text-xs text-gray-500 dark:text-neutral-400">
                                    Kelas {{ $item->classroom }}
                                </p>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="mt-auto flex border-t border-gray-200 dark:border-neutral-700 divide-x divide-gray-200 dark:divide-neutral-700">
                            <a href="{{ route('teacher.learning_modules.update', $item->id) }}"
                                class="flex-1 py-2 text-xs font-medium text-center text-gray-600 hover:bg-gray-50 dark:text-neutral-300 dark:hover:bg-neutral-800">
                                Edit
                            </a>
                            <a href="{{ asset('storage/' . $item->file_path) }}" target="_blank"
                                class="flex-1 py-2 text-xs font-medium text-center text-gray-600 hover:bg-gray-50 dark:text-neutral-300 dark:hover:bg-neutral-800">
                                Preview
                            </a>
                            <a href="{{ asset('storage/' . $item->file_path) }}" download
                                class="flex-1 py-2 text-xs font-medium text-center text-blue-600 hover:bg-blue-50 dark:text-blue-400 dark:hover:bg-blue-900/20">
                                Download
                            </a>
                            <button type="button"
                                onclick="setDeleteData('{{ $item->id }}', '{{ $item->title }}')"
                                data-hs-overlay="#delete-modal"
                                class="flex-1 py-2 text-xs font-medium text-center text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20">
                                Hapus
                            </button>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-full text-center py-16 text-sm text-gray-500 dark:text-neutral-400">
                        Belum ada modul belajar 🌱
                    </div>
                    @endforelse
                </div>


                <!-- Delete Confirmation Modal -->
                <div id="delete-modal" class="hs-overlay hidden size-full fixed top-0 start-0 z-[80] overflow-x-hidden overflow-y-auto pointer-events-none" role="dialog" tabindex="-1" aria-labelledby="delete-modal-label">
                    <div class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all sm:max-w-lg sm:w-full m-3 sm:mx-auto">
                        <div class="flex flex-col bg-white border shadow-lg rounded-xl pointer-events-auto dark:bg-neutral-900 dark:border-neutral-700">

                            <!-- Header -->
                            <div class="flex justify-between items-center py-4 px-5 border-b dark:border-neutral-700">
                                <h3 id="delete-modal-label" class="font-semibold text-lg text-gray-800 dark:text-white">
                                    Hapus Modul Belajar
                                </h3>
                                <button type="button" class="size-8 inline-flex justify-center items-center rounded-lg border border-transparent text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700" aria-label="Close" data-hs-overlay="#delete-modal">
                                    <span class="sr-only">Close</span>
                                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M18 6 6 18"></path>
                                        <path d="m6 6 12 12"></path>
                                    </svg>
                                </button>
                            </div>

                            <!-- Body -->
                            <div class="p-5 text-center">
                                <!-- Icon Warning -->
                                <div class="mb-4 inline-flex justify-center items-center size-16 rounded-full bg-red-100 dark:bg-red-900/20">
                                    <svg class="shrink-0 size-7 text-red-600 dark:text-red-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"></path>
                                        <path d="M12 9v4"></path>
                                        <path d="M12 17h.01"></path>
                                    </svg>
                                </div>

                                <!-- Text Content -->
                                <div>
                                    <p class="text-gray-600 dark:text-neutral-400">
                                        Apakah Anda yakin ingin menghapus
                                        <span id="delete-item-name" class="font-semibold text-gray-900 dark:text-white"></span>?
                                    </p>
                                    <p class="mt-3 text-sm text-gray-500 dark:text-neutral-500">
                                        Tindakan ini <span class="text-red-600 dark:text-red-500 font-semibold">tidak dapat dibatalkan</span>.
                                    </p>
                                </div>
                            </div>

                            <!-- Footer -->
                            <div class="flex justify-end items-center gap-x-3 py-4 px-5 border-t dark:border-neutral-700">
                                <button type="button" class="py-2.5 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700" data-hs-overlay="#delete-modal">
                                    Batal
                                </button>

                                <form id="delete-form" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="py-2.5 px-4 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-red-600 text-white hover:bg-red-700 focus:outline-none focus:bg-red-700">
                                        Ya, Hapus
                                    </button>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>

                <script>
                    function setDeleteData(id, name) {
                        document.getElementById('delete-item-name').textContent = name;
                        document.getElementById('delete-form').action = '{{ url('
                        teacher / learning - modules / delete ') }}/' + id;
                    }
                </script>
                @endsection
