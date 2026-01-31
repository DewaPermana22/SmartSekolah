@extends('_admin._layout.app')

@section('title', 'AI Quiz Generator')

@section('content')
    <div class="grid gap-3 md:flex md:justify-between md:items-center py-4">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-800 dark:text-neutral-200 mb-1">
                Generator Quiz
            </h1>
            <p class="text-md text-gray-400 dark:text-neutral-400">
                Buat soal quiz pilihan ganda dengan AI untuk siswa Anda
            </p>
        </div>
    </div>

    <div class="bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-neutral-800 dark:border-neutral-700">
        <div class="p-6 sm:p-8">
            <form id="quizForm">
                @csrf

                <div class="grid sm:grid-cols-2 gap-6 mb-6">
                    <!-- Jumlah Soal -->
                    <div>
                        <label for="question_count"
                            class="block text-sm font-medium mb-2 text-gray-800 dark:text-neutral-200">
                            Jumlah Soal
                        </label>
                        <input type="number" id="question_count" name="question_count" min="1" max="50" value="10"
                            class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                            placeholder="Masukkan jumlah soal" required>
                        <p class="mt-2 text-xs text-gray-500 dark:text-neutral-400">
                            Maksimal 50 soal per quiz
                        </p>
                    </div>

                    <!-- Jumlah Opsi Pilihan Ganda -->
                    <div>
                        <label for="options_count"
                            class="block text-sm font-medium mb-2 text-gray-800 dark:text-neutral-200">
                            Jumlah Opsi Pilihan Ganda
                        </label>
                        <select id="options_count" name="options_count"
                            class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                            required>
                            <option value="2">2 Opsi (A-B)</option>
                            <option value="3">3 Opsi (A-C)</option>
                            <option value="4" selected>4 Opsi (A-D)</option>
                            <option value="5">5 Opsi (A-E)</option>
                        </select>
                        <p class="mt-2 text-xs text-gray-500 dark:text-neutral-400">
                            Pilih jumlah opsi jawaban untuk setiap soal
                        </p>
                    </div>
                </div>

                <div class="grid sm:grid-cols-2 gap-6 mb-6">
                    <!-- Jenjang -->
                    <div>
                        <label for="grade"
                            class="block text-sm font-medium mb-2 text-gray-800 dark:text-neutral-200">
                            Jenjang
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

                    <!-- Kelas -->
                    <div>
                        <label for="class"
                            class="block text-sm font-medium mb-2 text-gray-800 dark:text-neutral-200">
                            Kelas
                        </label>
                        <select id="class" name="class"
                            class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                            required disabled>
                            <option value="">Pilih Kelas</option>
                        </select>
                        <p class="mt-2 text-xs text-gray-500 dark:text-neutral-400">
                            Pilih jenjang terlebih dahulu
                        </p>
                    </div>
                </div>

                <!-- Topik -->
                <div class="mb-6">
                    <label for="topic"
                        class="block text-sm font-medium mb-2 text-gray-800 dark:text-neutral-200">
                        Topik / Materi
                    </label>
                    <textarea id="topic" name="topic" rows="4"
                        class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                        placeholder="Jelaskan topik atau materi yang akan diujikan. Contoh: Sistem Pernapasan Manusia, mencakup organ pernapasan, proses respirasi, dan gangguan sistem pernapasan..."
                        required></textarea>
                    <p class="mt-2 text-xs text-gray-500 dark:text-neutral-400">
                        Berikan deskripsi yang jelas dan detail untuk hasil yang lebih baik
                    </p>
                </div>

                <div class="flex justify-end gap-3">
                    <button type="reset"
                        class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-200 dark:hover:bg-neutral-800">
                        Reset
                    </button>
                    <button type="submit" id="generateBtn"
                        class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-neutral-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        Generate Quiz
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div id="loadingState"
        class="hidden mt-6 bg-white border border-gray-200 rounded-xl shadow-sm p-6 dark:bg-neutral-800 dark:border-neutral-700">
        <div class="flex items-center justify-center">
            <div class="animate-spin inline-block w-6 h-6 border-[3px] border-current border-t-transparent text-blue-600 rounded-full dark:text-blue-500"
                role="status" aria-label="loading">
                <span class="sr-only">Loading...</span>
            </div>
            <span class="ml-3 text-gray-600 dark:text-neutral-400">Sedang membuat quiz...</span>
        </div>
    </div>

    <div id="resultArea"
        class="hidden mt-6 bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-neutral-800 dark:border-neutral-700">
        <div class="p-6 sm:p-8">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-neutral-200">Hasil Generate</h3>
                <div class="flex gap-2">
                    <button type="button" id="downloadBtn"
                        class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-200 dark:hover:bg-neutral-800">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                        Download
                    </button>
                    <button type="button" id="copyBtn"
                        class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-200 dark:hover:bg-neutral-800">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z">
                            </path>
                        </svg>
                        Copy
                    </button>
                </div>
            </div>
            <div id="resultContent" class="prose prose-sm dark:prose-invert max-w-none text-gray-800 dark:text-neutral-200">
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>

    <script>
        $(document).ready(function() {
            let pollingInterval = null;
            let pollingAttempts = 0;
            let rawMarkdownContent = '';
            let historySaved = false;
            let currentReferenceId = null;
            const MAX_POLLING_ATTEMPTS = 120;

            // Class options based on grade
            const classOptions = {
                'SD': ['1', '2', '3', '4', '5', '6'],
                'SMP': ['7', '8', '9'],
                'SMA': ['10', '11', '12'],
                'SMK': ['10', '11', '12']
            };

            // Handle grade change to populate class options
            $('#grade').on('change', function() {
                const selectedGrade = $(this).val();
                const classSelect = $('#class');
                
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

            marked.setOptions({
                breaks: true,
                gfm: true,
                headerIds: true,
                mangle: false,
                pedantic: false,
                smartLists: true,
                smartypants: true
            });

            function formatMarkdownToHTML(markdownContent) {
                try {
                    let html = marked.parse(markdownContent);
                    
                    // Apply consistent styling from materi template
                    html = html.replace(/<table>/g, 
                        '<div class="overflow-x-auto my-6 rounded-lg border border-gray-200 dark:border-neutral-700 shadow-sm">' +
                        '<table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">');
                    html = html.replace(/<\/table>/g, '</table></div>');
                    
                    html = html.replace(/<thead>/g, 
                        '<thead class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-neutral-800 dark:to-neutral-900">');
                    html = html.replace(/<th>/g, 
                        '<th class="px-6 py-4 text-left text-xs font-bold text-gray-700 dark:text-neutral-300 uppercase tracking-wider border-b-2 border-gray-300 dark:border-neutral-600">');
                    
                    html = html.replace(/<tbody>/g, 
                        '<tbody class="bg-white dark:bg-neutral-900 divide-y divide-gray-100 dark:divide-neutral-800">');
                    html = html.replace(/<td>/g, 
                        '<td class="px-6 py-4 text-sm text-gray-700 dark:text-neutral-300 border-b border-gray-100 dark:border-neutral-800">');
                    
                    html = html.replace(/<h1>/g, 
                        '<h1 class="text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600 dark:from-blue-400 dark:to-indigo-400 mb-6 mt-8 pb-2 border-b-4 border-blue-500 dark:border-blue-600">');
                    
                    html = html.replace(/<h2>/g, 
                        '<h2 class="text-3xl font-bold text-gray-800 dark:text-neutral-100 mb-5 mt-8 pb-3 border-b-2 border-gray-300 dark:border-neutral-700 flex items-center">' +
                        '<span class="inline-block w-1.5 h-8 bg-gradient-to-b from-blue-500 to-indigo-500 rounded-full mr-3"></span>');
                    html = html.replace(/<\/h2>/g, '</h2>');
                    
                    html = html.replace(/<h3>/g, 
                        '<h3 class="text-2xl font-semibold text-gray-700 dark:text-neutral-200 mb-4 mt-6 flex items-center">' +
                        '<svg class="w-6 h-6 mr-2 text-blue-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg><span>');
                    html = html.replace(/<\/h3>/g, '</span></h3>');
                    
                    html = html.replace(/<h4>/g, 
                        '<h4 class="text-xl font-semibold text-gray-600 dark:text-neutral-300 mb-3 mt-4">');
                    
                    html = html.replace(/<ul>/g, 
                        '<ul class="space-y-2 my-4 ml-1">');
                    
                    html = html.replace(/(<ul[^>]*>)([\s\S]*?)(<\/ul>)/g, function(match, ulOpen, content, ulClose) {
                        let styledContent = content.replace(/<li>/g, 
                            '<li class="flex items-start pl-0">' +
                            '<svg class="w-5 h-5 text-blue-500 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="3"/></svg>' +
                            '<span class="text-gray-700 dark:text-neutral-300">');
                        styledContent = styledContent.replace(/<\/li>/g, '</span></li>');
                        return ulOpen + styledContent + ulClose;
                    });
                    
                    html = html.replace(/<ol>/g, 
                        '<ol class="space-y-2 my-4 ml-6 list-decimal list-outside pl-2">');
                    html = html.replace(/(<ol[^>]*>)([\s\S]*?)(<\/ol>)/g, function(match, olOpen, content, olClose) {
                        let styledContent = content.replace(/<li>/g, 
                            '<li class="text-gray-700 dark:text-neutral-300 pl-2 ml-0">');
                        return olOpen + styledContent + olClose;
                    });
                    
                    html = html.replace(/<pre><code([^>]*)>/g, 
                        '<pre class="bg-gradient-to-br from-gray-900 to-gray-800 dark:from-neutral-950 dark:to-neutral-900 p-5 rounded-xl overflow-x-auto my-5 shadow-lg border border-gray-700">' +
                        '<code$1 class="text-sm font-mono text-green-400 dark:text-green-300 leading-relaxed">');
                    
                    html = html.replace(/<code>/g, 
                        '<code class="px-2 py-1 bg-gray-100 dark:bg-neutral-800 text-red-600 dark:text-red-400 rounded font-mono text-sm border border-gray-200 dark:border-neutral-700">');
                    
                    html = html.replace(/<p>/g, 
                        '<p class="text-gray-700 dark:text-neutral-300 leading-relaxed my-4 text-base">');
                    
                    html = html.replace(/<blockquote>/g, 
                        '<blockquote class="border-l-4 border-blue-500 bg-blue-50 dark:bg-blue-900/20 pl-5 py-3 my-5 italic text-gray-700 dark:text-neutral-300 rounded-r">');
                    
                    html = html.replace(/<strong>/g, 
                        '<strong class="font-bold text-gray-900 dark:text-neutral-100">');
                    
                    html = html.replace(/<em>/g, 
                        '<em class="italic text-gray-600 dark:text-neutral-400">');
                    
                    html = html.replace(/<hr>/g, 
                        '<hr class="my-8 border-t-2 border-gray-300 dark:border-neutral-700">');
                    
                    html = html.replace(/<a href="/g, 
                        '<a target="_blank" rel="noopener noreferrer" href="');
                    html = html.replace(/<a /g, 
                        '<a class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 underline font-medium transition-colors" ');
                    
                    return html;
                } catch (e) {
                    console.error('Error parsing markdown:', e);
                    return `<div class="text-gray-700 dark:text-neutral-300 whitespace-pre-wrap font-mono text-sm bg-gray-50 dark:bg-neutral-900 p-4 rounded border border-gray-200 dark:border-neutral-700">${markdownContent}</div>`;
                }
            }

            function pollStatus(statusUrl) {
                pollingAttempts++;

                const dots = '.'.repeat((pollingAttempts % 4) + 1);
                const loadingTexts = [
                    'Sedang menyusun soal',
                    'AI sedang berpikir',
                    'Membuat pertanyaan berkualitas',
                    'Hampir selesai'
                ];
                const loadingText = loadingTexts[Math.floor(pollingAttempts / 10) % loadingTexts.length];
                
                $('#loadingState span').html(
                    `${loadingText}${dots} <span class="text-xs text-gray-500">(${pollingAttempts}s)</span>`
                );

                if (pollingAttempts >= MAX_POLLING_ATTEMPTS) {
                    clearInterval(pollingInterval);
                    showError('⏱️ Request timeout. Server mungkin sedang sibuk. Silakan coba lagi nanti.');
                    return;
                }

                $.ajax({
                    url: statusUrl,
                    type: 'GET',
                    success: function(response) {
                        if (response.data.status === 'completed') {
                            clearInterval(pollingInterval);

                            $('#loadingState').addClass('hidden');
                            $('#resultArea').removeClass('hidden');

                            rawMarkdownContent = response.data.content;

                            const formattedContent = formatMarkdownToHTML(response.data.content);
                            $('#resultContent').html(formattedContent);

                            if (!historySaved && currentReferenceId) {
                                historySaved = true;
                                saveQuizHistory(currentReferenceId);
                            }

                            showSuccessNotification(
                                `Quiz berhasil dibuat dalam ${pollingAttempts} detik`
                            );

                            $('#generateBtn').prop('disabled', false);

                        } else if (response.data.status === 'failed') {
                            clearInterval(pollingInterval);
                            showError('❌ Pembuatan quiz gagal. Silakan coba lagi.');

                        } else if (response.data.status === 'queued' || response.data.status === 'processing') {
                            console.log('🔄 Status:', response.data.status, '| Attempt:', pollingAttempts);
                        }
                    },
                    error: function(xhr, status, error) {
                        clearInterval(pollingInterval);
                        showError('⚠️ Terjadi kesalahan saat mengecek status. Silakan coba lagi.');
                        console.error('❌ Polling error:', error);
                    }
                });
            }

            function showError(message) {
                $('#loadingState').addClass('hidden');
                $('#resultArea').removeClass('hidden');
                $('#generateBtn').prop('disabled', false);

                $('#resultContent').html(`
                    <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4 shadow-sm">
                        <div class="flex">
                            <svg class="w-5 h-5 text-red-600 dark:text-red-400 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800 dark:text-red-300">${message}</h3>
                            </div>
                        </div>
                    </div>
                `);
            }

            function showSuccessNotification(message) {
                const notification = $(`
                    <div class="fixed top-4 right-4 z-50 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4 shadow-lg animate-slide-in">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-green-600 dark:text-green-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span class="ml-3 text-sm font-medium text-green-800 dark:text-green-300">${message}</span>
                        </div>
                    </div>
                `);

                $('body').append(notification);

                setTimeout(() => {
                    notification.fadeOut(300, function() {
                        $(this).remove();
                    });
                }, 3000);
            }

            function saveQuizHistory(referenceId) {
                const formData = {
                    reference_id: referenceId,
                    question_count: $('#question_count').val(),
                    options_count: $('#options_count').val(),
                    grade: $('#grade').val(),
                    class: $('#class').val(),
                    topic: $('#topic').val()
                };

                $.ajax({
                    url: '/teacher/api/quiz/save-history',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    data: JSON.stringify(formData),
                    success: function(response) {
                        console.log('✅ Riwayat quiz berhasil disimpan!', response);
                    },
                    error: function(xhr) {
                        console.error('❌ Failed to save quiz history:', xhr.responseJSON || xhr);
                    }
                });
            }

            $('#quizForm').on('submit', function(e) {
                e.preventDefault();

                const questionCount = $('#question_count').val();
                const optionsCount = $('#options_count').val();
                const grade = $('#grade').val();
                const classValue = $('#class').val();
                const topic = $('#topic').val();

                if (!grade || !classValue || !topic.trim()) {
                    alert('Mohon lengkapi semua field terlebih dahulu.');
                    return;
                }

                pollingAttempts = 0;
                historySaved = false;
                currentReferenceId = null;
                if (pollingInterval) {
                    clearInterval(pollingInterval);
                }

                $('#loadingState').removeClass('hidden');
                $('#resultArea').addClass('hidden');
                $('#generateBtn').prop('disabled', true);

                const requestData = {
                    question_count: parseInt(questionCount),
                    options_count: parseInt(optionsCount),
                    grade: grade,
                    class: classValue,
                    topic: topic
                };

                $.ajax({
                    url: '/api/tools/quiz',
                    type: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify(requestData),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success && response.data.status_url) {
                            currentReferenceId = response.data.reference_id;
                            console.log('✅ Job queued! Reference ID:', currentReferenceId);

                            pollingInterval = setInterval(function() {
                                pollStatus(response.data.status_url);
                            }, 1000);

                        } else {
                            showError('⚠️ Response dari API tidak sesuai format. Mohon periksa backend.');
                            $('#generateBtn').prop('disabled', false);
                        }
                    },
                    error: function(xhr, status, error) {
                        let errorMessage = '❌ Terjadi kesalahan. ';

                        if (xhr.status === 401) {
                            errorMessage += 'Anda belum login. Silakan login terlebih dahulu.';
                        } else if (xhr.status === 422) {
                            errorMessage += 'Data yang dikirim tidak valid. Mohon periksa kembali.';
                        } else if (xhr.status === 500) {
                            errorMessage += 'Terjadi kesalahan pada server. Silakan coba lagi nanti.';
                        } else if (xhr.status === 0) {
                            errorMessage += 'Tidak dapat terhubung ke server. Periksa koneksi internet Anda.';
                        } else {
                            errorMessage += `Error: ${error}`;
                        }

                        showError(errorMessage);

                        console.error('Error details:', {
                            status: xhr.status,
                            response: xhr.responseJSON,
                            error: error
                        });
                    }
                });
            });

            $('#downloadBtn').on('click', function() {
                if (!rawMarkdownContent) {
                    alert('⚠️ Tidak ada konten untuk diunduh.');
                    return;
                }

                const timestamp = new Date().toISOString().slice(0, 19).replace(/:/g, '-');
                const filename = `quiz-${timestamp}.md`;

                const blob = new Blob([rawMarkdownContent], { type: 'text/markdown;charset=utf-8' });
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = filename;
                document.body.appendChild(a);
                a.click();
                window.URL.revokeObjectURL(url);
                document.body.removeChild(a);

                showSuccessNotification('📥 File berhasil diunduh!');
            });

            $('#copyBtn').on('click', function() {
                const content = rawMarkdownContent || $('#resultContent').text();

                if (!content) {
                    alert('Tidak ada konten untuk disalin.');
                    return;
                }

                navigator.clipboard.writeText(content).then(function() {
                    const originalHtml = $('#copyBtn').html();
                    $('#copyBtn').html(
                        '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Tersalin!'
                    );

                    setTimeout(function() {
                        $('#copyBtn').html(originalHtml);
                    }, 2000);
                }).catch(function(err) {
                    alert('Gagal menyalin. Browser Anda mungkin tidak mendukung fitur ini.');
                    console.error('Copy failed:', err);
                });
            });

            $('button[type="reset"]').on('click', function() {
                $('#resultArea').addClass('hidden');
                $('#topic').val('');
                $('#question_count').val('10');
                $('#options_count').val('4');
                $('#grade').val('');
                $('#class').empty().append('<option value="">Pilih Kelas</option>').prop('disabled', true);
                rawMarkdownContent = '';

                if (pollingInterval) {
                    clearInterval(pollingInterval);
                    pollingInterval = null;
                }

                $('#generateBtn').prop('disabled', false);
            });

            $(window).on('beforeunload', function() {
                if (pollingInterval) {
                    clearInterval(pollingInterval);
                }
            });
        });
    </script>
@endpush
