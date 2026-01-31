@extends('_admin._layout.app')

@section('title', 'Buat Kuis')

@section('content')
    <div class="grid gap-3 md:flex md:justify-between md:items-center py-4">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-800 dark:text-neutral-200 mb-1">
                Buat Kuis Baru
            </h1>
            <p class="text-md text-gray-400 dark:text-neutral-400">
                Tambahkan kuis dengan upload Excel atau input manual
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

    <!-- Method Selection -->
    <div class="mb-6">
        <div class="grid sm:grid-cols-2 gap-4">
            <label class="flex p-6 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-blue-500 dark:border-neutral-700 dark:hover:border-blue-500 transition-all has-[:checked]:border-blue-500 has-[:checked]:ring-2 has-[:checked]:ring-blue-500">
                <input type="radio" name="input_method" value="excel" class="peer sr-only" checked>
                <div class="w-full">
                    <div class="flex items-center gap-4 mb-2">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                        <div>
                            <span class="block text-lg font-semibold text-gray-800 dark:text-neutral-200">Upload Excel</span>
                            <span class="block text-sm text-gray-500 dark:text-neutral-400">Import soal dari file Excel</span>
                        </div>
                    </div>
                </div>
            </label>

            <label class="flex p-6 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-blue-500 dark:border-neutral-700 dark:hover:border-blue-500 transition-all has-[:checked]:border-blue-500 has-[:checked]:ring-2 has-[:checked]:ring-blue-500">
                <input type="radio" name="input_method" value="manual" class="peer sr-only">
                <div class="w-full">
                    <div class="flex items-center gap-4 mb-2">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        <div>
                            <span class="block text-lg font-semibold text-gray-800 dark:text-neutral-200">Input Manual</span>
                            <span class="block text-sm text-gray-500 dark:text-neutral-400">Tulis soal secara manual</span>
                        </div>
                    </div>
                </div>
            </label>
        </div>
    </div>

    <!-- Excel Upload Form -->
    <div id="excel-form" class="bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-neutral-800 dark:border-neutral-700">
        <div class="p-6 sm:p-8">
            <form action="{{ route('teacher.quiz.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="grid sm:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="quiz_name" class="block text-sm font-medium mb-2 text-gray-800 dark:text-neutral-200">
                            Nama Kuis <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="quiz_name" name="name"
                            class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                            placeholder="Contoh: Kuis Matematika Bab 1" required>
                    </div>

                    <div>
                        <label for="topic" class="block text-sm font-medium mb-2 text-gray-800 dark:text-neutral-200">
                            Topik
                        </label>
                        <input type="text" id="topic" name="topic"
                            class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                            placeholder="Contoh: Aljabar">
                    </div>
                </div>

                <div class="grid sm:grid-cols-3 gap-6 mb-6">
                    <div>
                        <label for="grade" class="block text-sm font-medium mb-2 text-gray-800 dark:text-neutral-200">
                            Jenjang <span class="text-red-500">*</span>
                        </label>
                        <select id="grade" name="grade"
                            class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                            required>
                            <option value="">Pilih Jenjang</option>
                            <option value="SD">SD</option>
                            <option value="SMP">SMP</option>
                            <option value="SMA">SMA</option>
                            <option value="SMK">SMK</option>
                        </select>
                    </div>

                    <div>
                        <label for="class" class="block text-sm font-medium mb-2 text-gray-800 dark:text-neutral-200">
                            Kelas <span class="text-red-500">*</span>
                        </label>
                        <select id="class" name="class"
                            class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                            required disabled>
                            <option value="">Pilih Kelas</option>
                        </select>
                    </div>

                    <div>
                        <label for="duration" class="block text-sm font-medium mb-2 text-gray-800 dark:text-neutral-200">
                            Durasi (Menit)
                        </label>
                        <input type="number" id="duration" name="duration" min="1" value="60"
                            class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                    </div>
                </div>

                <div class="mb-6">
                    <label for="description" class="block text-sm font-medium mb-2 text-gray-800 dark:text-neutral-200">
                        Deskripsi
                    </label>
                    <textarea id="description" name="description" rows="3"
                        class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                        placeholder="Deskripsi singkat tentang kuis ini..."></textarea>
                </div>

                <div class="mb-6">
                    <label for="excel_file" class="block text-sm font-medium mb-2 text-gray-800 dark:text-neutral-200">
                        Upload File Excel <span class="text-red-500">*</span>
                    </label>
                    <div class="border-2 border-dashed border-gray-300 dark:border-neutral-700 rounded-lg p-8 text-center hover:border-blue-500 transition-colors">
                        <input type="file" id="excel_file" name="excel_file" accept=".xlsx,.xls" class="hidden" required>
                        <label for="excel_file" class="cursor-pointer">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                            </svg>
                            <p class="mt-2 text-sm text-gray-600 dark:text-neutral-400">
                                Klik untuk upload file Excel atau drag & drop
                            </p>
                            <p class="mt-1 text-xs text-gray-500 dark:text-neutral-500">
                                Format: .xlsx atau .xls (Maks. 5MB)
                            </p>
                            <p id="file-name" class="mt-2 text-sm font-semibold text-blue-600"></p>
                        </label>
                    </div>
                    <div class="mt-3 flex items-start gap-2 text-sm text-gray-600 dark:text-neutral-400">
                        <svg class="w-5 h-5 text-blue-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div>
                            <p class="font-medium mb-1">Format Excel yang benar:</p>
                            <ul class="list-disc list-inside space-y-1 text-xs">
                                <li>Kolom A: Nomor Soal</li>
                                <li>Kolom B: Pertanyaan</li>
                                <li>Kolom C: Opsi A</li>
                                <li>Kolom D: Opsi B</li>
                                <li>Kolom E: Opsi C</li>
                                <li>Kolom F: Opsi D</li>
                                <li>Kolom G: Opsi E (opsional)</li>
                                <li>Kolom H: Jawaban Benar (A/B/C/D/E)</li>
                            </ul>
                            <a href="#" class="text-blue-600 hover:underline mt-2 inline-block">Download Template Excel</a>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-3">
                    <button type="reset"
                        class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-200 dark:hover:bg-neutral-800">
                        Reset
                    </button>
                    <button type="submit"
                        class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-neutral-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Simpan Kuis
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Manual Input Form -->
    <div id="manual-form" class="hidden bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-neutral-800 dark:border-neutral-700">
        <div class="p-6 sm:p-8">
            <form action="{{ route('teacher.quiz.store') }}" method="POST">
                @csrf
                <input type="hidden" name="input_type" value="manual">

                <div class="grid sm:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="manual_quiz_name" class="block text-sm font-medium mb-2 text-gray-800 dark:text-neutral-200">
                            Nama Kuis <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="manual_quiz_name" name="name"
                            class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                            placeholder="Contoh: Kuis Matematika Bab 1" required>
                    </div>

                    <div>
                        <label for="manual_topic" class="block text-sm font-medium mb-2 text-gray-800 dark:text-neutral-200">
                            Topik
                        </label>
                        <input type="text" id="manual_topic" name="topic"
                            class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                            placeholder="Contoh: Aljabar">
                    </div>
                </div>

                <div class="grid sm:grid-cols-3 gap-6 mb-6">
                    <div>
                        <label for="manual_grade" class="block text-sm font-medium mb-2 text-gray-800 dark:text-neutral-200">
                            Jenjang <span class="text-red-500">*</span>
                        </label>
                        <select id="manual_grade" name="grade"
                            class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                            required>
                            <option value="">Pilih Jenjang</option>
                            <option value="SD">SD</option>
                            <option value="SMP">SMP</option>
                            <option value="SMA">SMA</option>
                            <option value="SMK">SMK</option>
                        </select>
                    </div>

                    <div>
                        <label for="manual_class" class="block text-sm font-medium mb-2 text-gray-800 dark:text-neutral-200">
                            Kelas <span class="text-red-500">*</span>
                        </label>
                        <select id="manual_class" name="class"
                            class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                            required disabled>
                            <option value="">Pilih Kelas</option>
                        </select>
                    </div>

                    <div>
                        <label for="manual_duration" class="block text-sm font-medium mb-2 text-gray-800 dark:text-neutral-200">
                            Durasi (Menit)
                        </label>
                        <input type="number" id="manual_duration" name="duration" min="1" value="60"
                            class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                    </div>
                </div>

                <div class="mb-6">
                    <label for="manual_description" class="block text-sm font-medium mb-2 text-gray-800 dark:text-neutral-200">
                        Deskripsi
                    </label>
                    <textarea id="manual_description" name="description" rows="3"
                        class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                        placeholder="Deskripsi singkat tentang kuis ini..."></textarea>
                </div>

                <!-- Questions Container -->
                <div class="mb-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-neutral-200">Soal-soal</h3>
                        <button type="button" id="add-question"
                            class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-green-600 text-white hover:bg-green-700 disabled:opacity-50 disabled:pointer-events-none">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                            Tambah Soal
                        </button>
                    </div>

                    <div id="questions-container" class="space-y-6">
                        <!-- Questions will be added here dynamically -->
                    </div>
                </div>

                <div class="flex justify-end gap-3">
                    <button type="reset"
                        class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-200 dark:hover:bg-neutral-800">
                        Reset
                    </button>
                    <button type="submit"
                        class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-neutral-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Simpan Kuis
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        const classOptions = {
            'SD': ['1', '2', '3', '4', '5', '6'],
            'SMP': ['7', '8', '9'],
            'SMA': ['10', '11', '12'],
            'SMK': ['10', '11', '12']
        };

        let questionCount = 0;

        // Handle input method switching
        $('input[name="input_method"]').on('change', function() {
            if ($(this).val() === 'excel') {
                $('#excel-form').removeClass('hidden');
                $('#manual-form').addClass('hidden');
            } else {
                $('#excel-form').addClass('hidden');
                $('#manual-form').removeClass('hidden');
            }
        });

        // Handle grade change for both forms
        $('#grade, #manual_grade').on('change', function() {
            const selectedGrade = $(this).val();
            const classSelect = $(this).attr('id') === 'grade' ? $('#class') : $('#manual_class');
            
            classSelect.empty().append('<option value="">Pilih Kelas</option>');
            
            if (selectedGrade && classOptions[selectedGrade]) {
                classSelect.prop('disabled', false);
                classOptions[selectedGrade].forEach(function(classNum) {
                    classSelect.append(`<option value="${classNum}">Kelas ${classNum}</option>`);
                });
            } else {
                classSelect.prop('disabled', true);
            }
        });

        // Handle file input
        $('#excel_file').on('change', function() {
            const fileName = $(this).val().split('\\').pop();
            if (fileName) {
                $('#file-name').text('File terpilih: ' + fileName);
            }
        });

        // Add question function
        $('#add-question').on('click', function() {
            questionCount++;
            const questionHtml = `
                <div class="question-item border border-gray-200 dark:border-neutral-700 rounded-lg p-6" data-question="${questionCount}">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="text-md font-semibold text-gray-800 dark:text-neutral-200">Soal ${questionCount}</h4>
                        <button type="button" class="remove-question text-red-600 hover:text-red-800">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2 text-gray-800 dark:text-neutral-200">
                            Pertanyaan <span class="text-red-500">*</span>
                        </label>
                        <textarea name="questions[${questionCount}][question]" rows="3"
                            class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400"
                            placeholder="Tulis pertanyaan..." required></textarea>
                    </div>

                    <div class="grid sm:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium mb-2 text-gray-800 dark:text-neutral-200">Opsi A <span class="text-red-500">*</span></label>
                            <input type="text" name="questions[${questionCount}][option_a]"
                                class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400"
                                placeholder="Opsi A" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-2 text-gray-800 dark:text-neutral-200">Opsi B <span class="text-red-500">*</span></label>
                            <input type="text" name="questions[${questionCount}][option_b]"
                                class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400"
                                placeholder="Opsi B" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-2 text-gray-800 dark:text-neutral-200">Opsi C</label>
                            <input type="text" name="questions[${questionCount}][option_c]"
                                class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400"
                                placeholder="Opsi C">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-2 text-gray-800 dark:text-neutral-200">Opsi D</label>
                            <input type="text" name="questions[${questionCount}][option_d]"
                                class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400"
                                placeholder="Opsi D">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-2 text-gray-800 dark:text-neutral-200">Opsi E</label>
                            <input type="text" name="questions[${questionCount}][option_e]"
                                class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400"
                                placeholder="Opsi E">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-2 text-gray-800 dark:text-neutral-200">Jawaban Benar <span class="text-red-500">*</span></label>
                            <select name="questions[${questionCount}][correct_answer]"
                                class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400"
                                required>
                                <option value="">Pilih Jawaban</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                                <option value="D">D</option>
                                <option value="E">E</option>
                            </select>
                        </div>
                    </div>
                </div>
            `;

            $('#questions-container').append(questionHtml);
        });

        // Remove question
        $(document).on('click', '.remove-question', function() {
            $(this).closest('.question-item').remove();
        });

        // Add first question automatically
        $('#add-question').trigger('click');
    });
</script>
@endpush
