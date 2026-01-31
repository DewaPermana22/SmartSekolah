@extends('_admin._layout.app')

@section('title', 'Detail Kuis')

@section('content')
    <div class="grid gap-3 md:flex md:justify-between md:items-center py-4">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-800 dark:text-neutral-200 mb-1">
                Detail Kuis
            </h1>
            <p class="text-md text-gray-400 dark:text-neutral-400">
                Informasi lengkap tentang kuis
            </p>
        </div>
        <div>
            <a navigate href="{{ route('teacher.quiz.index') }}"
                class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 dark:bg-neutral-800 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-700">
                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path d="m12 19-7-7 7-7" />
                    <path d="M19 12H5" />
                </svg>
                Kembali
            </a>
        </div>
    </div>

    <!-- Info Card -->
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-neutral-800 dark:border-neutral-700 mb-6">
        <div class="p-6 sm:p-8">
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-600 dark:text-neutral-400 mb-2">
                        Nama Kuis
                    </label>
                    <p class="text-gray-800 dark:text-neutral-200 font-semibold">
                        {{ $data->name ?? 'N/A' }}
                    </p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 dark:text-neutral-400 mb-2">
                        Topik
                    </label>
                    <p class="text-gray-800 dark:text-neutral-200">
                        {{ $data->topic ?? '-' }}
                    </p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 dark:text-neutral-400 mb-2">
                        Jenjang & Kelas
                    </label>
                    <p class="text-gray-800 dark:text-neutral-200">
                        <span class="inline-flex items-center gap-x-1.5 py-1 px-2 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-800/30 dark:text-blue-500">
                            {{ $data->grade ?? 'N/A' }} - Kelas {{ $data->class ?? 'N/A' }}
                        </span>
                    </p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 dark:text-neutral-400 mb-2">
                        Durasi
                    </label>
                    <p class="text-gray-800 dark:text-neutral-200">
                        {{ $data->duration ?? 60 }} Menit
                    </p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 dark:text-neutral-400 mb-2">
                        Jumlah Soal
                    </label>
                    <p class="text-gray-800 dark:text-neutral-200 font-semibold">
                        {{ $data->question_count ?? 0 }} Soal
                    </p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 dark:text-neutral-400 mb-2">
                        Tanggal Dibuat
                    </label>
                    <p class="text-gray-800 dark:text-neutral-200">
                        {{ \Carbon\Carbon::parse($data->created_at)->format('d M Y') }}
                    </p>
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-600 dark:text-neutral-400 mb-2">
                        Deskripsi
                    </label>
                    <p class="text-gray-800 dark:text-neutral-200">
                        {{ $data->description ?? '-' }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Questions List -->
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-neutral-800 dark:border-neutral-700">
        <div class="p-6 sm:p-8">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-neutral-200 mb-6">Daftar Soal</h3>

            @if(isset($data->questions) && count($data->questions) > 0)
                <div class="space-y-6">
                    @foreach($data->questions as $index => $question)
                        <div class="border border-gray-200 dark:border-neutral-700 rounded-lg p-5">
                            <div class="flex items-start gap-4">
                                <div class="flex-shrink-0 w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-800/30 text-blue-800 dark:text-blue-400 flex items-center justify-center font-semibold text-sm">
                                    {{ $index + 1 }}
                                </div>
                                <div class="flex-1">
                                    <p class="text-gray-800 dark:text-neutral-200 font-medium mb-4">
                                        {{ $question->question ?? 'N/A' }}
                                    </p>

                                    <div class="grid sm:grid-cols-2 gap-3">
                                        @if(!empty($question->option_a))
                                            <div class="flex items-start gap-2 p-3 rounded-lg border {{ $question->correct_answer === 'A' ? 'border-green-500 bg-green-50 dark:bg-green-900/20' : 'border-gray-200 dark:border-neutral-700' }}">
                                                <span class="flex-shrink-0 w-6 h-6 rounded-full {{ $question->correct_answer === 'A' ? 'bg-green-500 text-white' : 'bg-gray-200 dark:bg-neutral-700 text-gray-800 dark:text-neutral-200' }} flex items-center justify-center text-xs font-semibold">A</span>
                                                <span class="text-sm text-gray-700 dark:text-neutral-300">{{ $question->option_a }}</span>
                                            </div>
                                        @endif

                                        @if(!empty($question->option_b))
                                            <div class="flex items-start gap-2 p-3 rounded-lg border {{ $question->correct_answer === 'B' ? 'border-green-500 bg-green-50 dark:bg-green-900/20' : 'border-gray-200 dark:border-neutral-700' }}">
                                                <span class="flex-shrink-0 w-6 h-6 rounded-full {{ $question->correct_answer === 'B' ? 'bg-green-500 text-white' : 'bg-gray-200 dark:bg-neutral-700 text-gray-800 dark:text-neutral-200' }} flex items-center justify-center text-xs font-semibold">B</span>
                                                <span class="text-sm text-gray-700 dark:text-neutral-300">{{ $question->option_b }}</span>
                                            </div>
                                        @endif

                                        @if(!empty($question->option_c))
                                            <div class="flex items-start gap-2 p-3 rounded-lg border {{ $question->correct_answer === 'C' ? 'border-green-500 bg-green-50 dark:bg-green-900/20' : 'border-gray-200 dark:border-neutral-700' }}">
                                                <span class="flex-shrink-0 w-6 h-6 rounded-full {{ $question->correct_answer === 'C' ? 'bg-green-500 text-white' : 'bg-gray-200 dark:bg-neutral-700 text-gray-800 dark:text-neutral-200' }} flex items-center justify-center text-xs font-semibold">C</span>
                                                <span class="text-sm text-gray-700 dark:text-neutral-300">{{ $question->option_c }}</span>
                                            </div>
                                        @endif

                                        @if(!empty($question->option_d))
                                            <div class="flex items-start gap-2 p-3 rounded-lg border {{ $question->correct_answer === 'D' ? 'border-green-500 bg-green-50 dark:bg-green-900/20' : 'border-gray-200 dark:border-neutral-700' }}">
                                                <span class="flex-shrink-0 w-6 h-6 rounded-full {{ $question->correct_answer === 'D' ? 'bg-green-500 text-white' : 'bg-gray-200 dark:bg-neutral-700 text-gray-800 dark:text-neutral-200' }} flex items-center justify-center text-xs font-semibold">D</span>
                                                <span class="text-sm text-gray-700 dark:text-neutral-300">{{ $question->option_d }}</span>
                                            </div>
                                        @endif

                                        @if(!empty($question->option_e))
                                            <div class="flex items-start gap-2 p-3 rounded-lg border {{ $question->correct_answer === 'E' ? 'border-green-500 bg-green-50 dark:bg-green-900/20' : 'border-gray-200 dark:border-neutral-700' }}">
                                                <span class="flex-shrink-0 w-6 h-6 rounded-full {{ $question->correct_answer === 'E' ? 'bg-green-500 text-white' : 'bg-gray-200 dark:bg-neutral-700 text-gray-800 dark:text-neutral-200' }} flex items-center justify-center text-xs font-semibold">E</span>
                                                <span class="text-sm text-gray-700 dark:text-neutral-300">{{ $question->option_e }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <p class="mt-2 text-sm text-gray-500 dark:text-neutral-400">Belum ada soal</p>
                </div>
            @endif
        </div>
    </div>
@endsection
