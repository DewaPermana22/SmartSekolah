@extends('_admin._layout.app')

@section('title', 'Detail Quiz')

@section('content')
    <div class="grid gap-3 md:flex md:justify-between md:items-center py-4">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-800 dark:text-neutral-200 mb-1">
                Detail Quiz
            </h1>
            <p class="text-md text-gray-400 dark:text-neutral-400">
                Lihat detail quiz yang telah dibuat
            </p>
        </div>
        <div>
            <a navigate href="{{ route('teacher.ai.quiz.index') }}"
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
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-600 dark:text-neutral-400 mb-2">
                        Jenjang & Kelas
                    </label>
                    <p class="text-gray-800 dark:text-neutral-200 font-semibold">
                        <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-800/30 dark:text-blue-500">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                            </svg>
                            {{ $data->grade ?? 'N/A' }} - Kelas {{ $data->class ?? 'N/A' }}
                        </span>
                    </p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 dark:text-neutral-400 mb-2">
                        Jumlah Soal
                    </label>
                    <p class="text-gray-800 dark:text-neutral-200 font-semibold">
                        <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-800/30 dark:text-green-500">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V8z" clip-rule="evenodd"/>
                            </svg>
                            {{ $data->question_count ?? 0 }} Soal
                        </span>
                    </p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 dark:text-neutral-400 mb-2">
                        Opsi Pilihan Ganda
                    </label>
                    <p class="text-gray-800 dark:text-neutral-200 font-semibold">
                        <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-800/30 dark:text-purple-500">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            {{ $data->options_count ?? 4 }} Opsi (A-{{ chr(64 + ($data->options_count ?? 4)) }})
                        </span>
                    </p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 dark:text-neutral-400 mb-2">
                        Dibuat Oleh
                    </label>
                    <p class="text-gray-800 dark:text-neutral-200 font-semibold">
                        {{ $data->created_by_name ?? 'N/A' }}
                    </p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 dark:text-neutral-400 mb-2">
                        Tanggal Dibuat
                    </label>
                    <p class="text-gray-800 dark:text-neutral-200">
                        {{ \Carbon\Carbon::parse($data->created_at)->format('d F Y, H:i') }} WIB
                    </p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 dark:text-neutral-400 mb-2">
                        Terakhir Update
                    </label>
                    <p class="text-gray-800 dark:text-neutral-200">
                        {{ \Carbon\Carbon::parse($data->updated_at)->format('d F Y, H:i') }} WIB
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Topic Card -->
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-neutral-800 dark:border-neutral-700 mb-6">
        <div class="p-6 sm:p-8">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-neutral-200 mb-4">
                Topik / Materi
            </h3>
            <div class="bg-gray-50 dark:bg-neutral-900 rounded-lg p-4 border border-gray-200 dark:border-neutral-700">
                <p class="text-gray-700 dark:text-neutral-300 whitespace-pre-wrap">{{ $data->topic ?? 'N/A' }}</p>
            </div>
        </div>
    </div>

    <!-- Result Card -->
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-neutral-800 dark:border-neutral-700">
        <div class="p-6 sm:p-8">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-neutral-200">Hasil Quiz</h3>
                <div class="flex gap-2">
                    <button type="button" id="downloadBtn"
                        class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        Download
                    </button>
                    <button type="button" id="copyBtn"
                        class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-300 bg-white text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                        Salin
                    </button>
                </div>
            </div>
            <div id="resultContent" class="prose prose-sm dark:prose-invert max-w-none text-gray-800 dark:text-neutral-200">
                <!-- Content akan di-render di sini oleh JavaScript -->
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>

    <script>
        $(document).ready(function() {
            const rawMarkdownContent = @json($data->output_text ?? '');

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
                        '<th class="px-6 py-4 text-left text-xs font-bold text-gray-700 dark:text-neutral-200 uppercase tracking-wider">');
                    
                    html = html.replace(/<tbody>/g, 
                        '<tbody class="bg-white dark:bg-neutral-900 divide-y divide-gray-100 dark:divide-neutral-800">');
                    html = html.replace(/<td>/g, 
                        '<td class="px-6 py-4 text-sm text-gray-800 dark:text-neutral-200">');
                    
                    html = html.replace(/<h1>/g, 
                        '<h1 class="text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600 dark:from-blue-400 dark:to-indigo-400 mt-8 mb-6 pb-3 border-b-4 border-blue-500/20">');
                    
                    html = html.replace(/<h2>/g, 
                        '<h2 class="text-3xl font-bold text-gray-900 dark:text-neutral-100 mt-10 mb-5 flex items-center">' +
                        '<span class="inline-block w-1.5 h-8 bg-gradient-to-b from-blue-500 to-indigo-500 rounded-full mr-3"></span>');
                    html = html.replace(/<\/h2>/g, '</h2>');
                    
                    html = html.replace(/<h3>/g, 
                        '<h3 class="text-2xl font-semibold text-gray-800 dark:text-neutral-200 mt-8 mb-4 flex items-center">' +
                        '<svg class="w-6 h-6 mr-2 text-blue-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg><span>');
                    html = html.replace(/<\/h3>/g, '</span></h3>');
                    
                    html = html.replace(/<h4>/g, 
                        '<h4 class="text-xl font-semibold text-gray-700 dark:text-neutral-300 mt-6 mb-3">');
                    
                    html = html.replace(/<ul>/g, 
                        '<ul class="space-y-2 my-4 ml-6 list-none pl-2">');
                    
                    html = html.replace(/(<ul[^>]*>)([\s\S]*?)(<\/ul>)/g, function(match, ulOpen, content, ulClose) {
                        let styledContent = content.replace(/<li>/g, 
                            '<li class="flex items-start text-gray-700 dark:text-neutral-300 leading-relaxed">' +
                            '<svg class="w-5 h-5 mr-2 mt-0.5 text-blue-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg><span>');
                        styledContent = styledContent.replace(/<\/li>/g, '</span></li>');
                        return ulOpen + styledContent + ulClose;
                    });
                    
                    html = html.replace(/<ol>/g, 
                        '<ol class="space-y-2 my-4 ml-6 list-decimal list-outside pl-2">');
                    html = html.replace(/(<ol[^>]*>)([\s\S]*?)(<\/ol>)/g, function(match, olOpen, content, olClose) {
                        let styledContent = content.replace(/<li>/g, '<li class="text-gray-700 dark:text-neutral-300 leading-relaxed pl-2">');
                        return olOpen + styledContent + olClose;
                    });
                    
                    html = html.replace(/<pre><code([^>]*)>/g, 
                        '<pre class="bg-gray-900 dark:bg-black rounded-lg p-5 overflow-x-auto my-5 border border-gray-700 shadow-lg"><code$1 class="text-sm text-gray-100 font-mono leading-relaxed">');
                    
                    html = html.replace(/<code>/g, 
                        '<code class="px-2 py-1 bg-gray-100 dark:bg-neutral-800 text-red-600 dark:text-red-400 rounded text-sm font-mono border border-gray-200 dark:border-neutral-700">');
                    
                    html = html.replace(/<p>/g, 
                        '<p class="text-gray-700 dark:text-neutral-300 leading-relaxed my-4">');
                    
                    html = html.replace(/<blockquote>/g, 
                        '<blockquote class="border-l-4 border-blue-500 bg-blue-50 dark:bg-blue-900/20 pl-4 py-3 my-4 italic text-gray-700 dark:text-neutral-300 rounded-r">');
                    
                    html = html.replace(/<strong>/g, 
                        '<strong class="font-bold text-gray-900 dark:text-neutral-100">');
                    
                    html = html.replace(/<em>/g, 
                        '<em class="italic text-gray-600 dark:text-neutral-400">');
                    
                    html = html.replace(/<hr>/g, 
                        '<hr class="my-8 border-t-2 border-gray-200 dark:border-neutral-700">');
                    
                    html = html.replace(/<a href="/g, 
                        '<a target="_blank" rel="noopener noreferrer" href="');
                    html = html.replace(/<a /g, 
                        '<a class="text-blue-600 dark:text-blue-400 hover:underline font-medium" ');
                    
                    return html;
                } catch (e) {
                    console.error('Error parsing markdown:', e);
                    return `<div class="text-gray-700 dark:text-neutral-300 whitespace-pre-wrap font-mono text-sm bg-gray-50 dark:bg-neutral-900 p-4 rounded border border-gray-200 dark:border-neutral-700">${markdownContent}</div>`;
                }
            }

            // Render content on page load
            const htmlContent = formatMarkdownToHTML(rawMarkdownContent);
            $('#resultContent').html(htmlContent);

            // Download button handler
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

            // Copy button handler
            $('#copyBtn').on('click', function() {
                if (!rawMarkdownContent) {
                    alert('Tidak ada konten untuk disalin.');
                    return;
                }

                navigator.clipboard.writeText(rawMarkdownContent).then(function() {
                    const originalHtml = $('#copyBtn').html();
                    $('#copyBtn').html(
                        '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Tersalin!'
                    );

                    setTimeout(function() {
                        $('#copyBtn').html(originalHtml);
                    }, 2000);
                }).catch(function(err) {
                    alert('Gagal menyalin. Browser Anda mungkin tidak mendukung fitur ini.');
                    console.error('Copy failed:', err);
                });
            });

            function showSuccessNotification(message) {
                const notification = $(`
                    <div class="fixed top-4 right-4 z-50 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4 shadow-lg animate-slide-in">
                        <div class="flex items-center gap-3">
                            <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="text-sm font-medium text-green-800 dark:text-green-200">${message}</span>
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
        });
    </script>
@endpush
