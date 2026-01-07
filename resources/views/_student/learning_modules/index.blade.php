@extends('_student._layout.app');

@section('title', 'Modul Belajar')

@section('content')
    <div class="grid gap-3 md:flex md:justify-between md:items-center py-4">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl font-extrabold text-gray-800 dark:text-neutral-200 mb-1">Modul Belajar</h1>
            <p class="text-md text-gray-400 dark:text-neutral-400">Modul belajar yang disediakan oleh guru</p>
        </div>
       
    </div>

    <div class="flex flex-col">
        <div class="overflow-x-auto">
            <div class="min-w-full inline-block align-middle">
                <div class="overflow-hidden">

                    <div class="px-2 py-2 pt-0 pb-4">
                        <form action="{{ route('student.learning_modules.index') }}" method="GET" navigate
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
                                        href="{{ route('student.learning_modules.index') }}">
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
                <svg class="size-8 {{ $icon }}" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                    <path d="M14 2v6h6" />
                </svg>

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
                
                <a href="{{ asset('storage/' . $item->file_path) }}" target="_blank"
                    class="flex-1 py-2 text-xs font-medium text-center text-gray-600 hover:bg-gray-50 dark:text-neutral-300 dark:hover:bg-neutral-800">
                    Preview
                </a>
                <a href="{{ asset('storage/' . $item->file_path) }}" download
                    class="flex-1 py-2 text-xs font-medium text-center text-blue-600 hover:bg-blue-50 dark:text-blue-400 dark:hover:bg-blue-900/20">
                    Download
                </a>
            </div>
        </div>
    @empty
        <div class="col-span-full text-center py-16 text-sm text-gray-500 dark:text-neutral-400">
            Belum ada modul belajar 🌱
        </div>
    @endforelse
</div>


   
@endsection
