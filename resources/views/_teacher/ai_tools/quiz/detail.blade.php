@extends('_admin._layout.app')

@section('title', 'Detail Quiz')

@section('content')
<div class="grid gap-3 md:flex md:justify-between md:items-center py-4">
    <x-page-title title="Detail Quiz" description="Lihat detail kuis yang telah dibuat" />
    <div>
        <a navigate href="{{ route('teacher.ai.quiz_generator.index') }}"
            class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 dark:bg-neutral-800 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-700">
            <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="m12 19-7-7 7-7" />
                <path d="M19 12H5" />
            </svg>
            Kembali
        </a>
    </div>
</div>

<div class="bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-neutral-800 dark:border-neutral-700 mb-6">
    <div class="p-6 sm:p-8">
        <h2 class="text-xl font-bold text-gray-800 dark:text-neutral-200 mb-6">{{ $quiz->quiz_name }}</h2>

        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-600 dark:text-neutral-400 mb-2">Kode Kuis</label>
                <p class="text-gray-800 dark:text-neutral-200 font-semibold">
                    <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-800/30 dark:text-blue-500">
                        {{ $quiz->quiz_code }}
                    </span>
                </p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-600 dark:text-neutral-400 mb-2">Jumlah Soal</label>
                <p class="text-gray-800 dark:text-neutral-200 font-semibold">
                    <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-800/30 dark:text-green-500">
                        {{ count($questions) }} Soal
                    </span>
                </p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-600 dark:text-neutral-400 mb-2">Durasi Kerja</label>
                <p class="text-gray-800 dark:text-neutral-200 font-semibold">
                    <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-800/30 dark:text-purple-500">
                        {{ $quiz->quiz_time }} Menit
                    </span>
                </p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-600 dark:text-neutral-400 mb-2">Tanggal Dibuat</label>
                <p class="text-gray-800 dark:text-neutral-200 text-sm">
                    {{ \Carbon\Carbon::parse($quiz->created_at)->format('d M Y, H:i') }}
                </p>
            </div>
        </div>
    </div>
</div>

<div class="bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-neutral-800 dark:border-neutral-700">
    <div class="p-6 sm:p-8">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-neutral-200 mb-6">Daftar Pertanyaan</h3>

        <div class="space-y-8">
            @foreach($questions as $index => $q)
            <div class="p-4 border border-gray-100 dark:border-neutral-700 rounded-lg">
                <p class="font-medium text-gray-800 dark:text-neutral-200 mb-4">
                    {{ $index + 1 }}. {{ $q->question }}
                </p>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 ml-6">
                    @foreach($q->options as $opt)
                    <div class="p-2 text-sm rounded-md border {{ $opt->is_correct ? 'bg-green-50 border-green-200 text-green-800 dark:bg-green-900/20 dark:border-green-800 dark:text-green-400 font-bold' : 'bg-gray-50 border-gray-100 text-gray-600 dark:bg-neutral-900 dark:border-neutral-800 dark:text-neutral-400' }}">
                        {{ $opt->option_text }}
                        @if($opt->is_correct) (Kunci Jawaban) @endif
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection