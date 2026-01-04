@extends('_teacher._layout.app')

@section('title', 'AI Materi Ajar')

@section('content')
    <div class="grid gap-3 md:flex md:justify-between md:items-center py-4">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-800 dark:text-neutral-200 mb-1">
                Generator Materi Ajar
            </h1>
            <p class="text-md text-gray-400 dark:text-neutral-400">
                Buat materi pembelajaran dengan AI untuk siswa Anda
            </p>
        </div>
    </div>

    <div class="bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-neutral-800 dark:border-neutral-700">
        <div class="p-6 sm:p-8">
            <form id="materiForm">
                @csrf

                <div class="mb-6">
                    <label class="block text-sm font-medium mb-3 text-gray-800 dark:text-neutral-200">
                        Tipe Materi
                    </label>
                    <div class="grid sm:grid-cols-2 gap-4">
                        <label
                            class="flex p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 dark:border-neutral-700 dark:hover:bg-neutral-700 transition-colors">
                            <input type="radio" name="material_type" value="ppt"
                                class="shrink-0 mt-0.5 border-gray-200 rounded-full text-blue-600 focus:ring-blue-500 dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-neutral-800"
                                checked>
                            <span class="ml-3">
                                <span class="block text-sm font-semibold text-gray-800 dark:text-neutral-200">
                                    <svg class="w-5 h-5 inline-block mr-1 text-orange-500" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    Materi PPT
                                </span>
                                <span class="block text-sm text-gray-500 dark:text-neutral-400 mt-1">
                                    Presentasi PowerPoint untuk kelas
                                </span>
                            </span>
                        </label>

                        <label
                            class="flex p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 dark:border-neutral-700 dark:hover:bg-neutral-700 transition-colors">
                            <input type="radio" name="material_type" value="modul"
                                class="shrink-0 mt-0.5 border-gray-200 rounded-full text-blue-600 focus:ring-blue-500 dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-neutral-800">
                            <span class="ml-3">
                                <span class="block text-sm font-semibold text-gray-800 dark:text-neutral-200">
                                    <svg class="w-5 h-5 inline-block mr-1 text-blue-500" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                        </path>
                                    </svg>
                                    Modul Belajar
                                </span>
                                <span class="block text-sm text-gray-500 dark:text-neutral-400 mt-1">
                                    Modul lengkap untuk pembelajaran mandiri
                                </span>
                            </span>
                        </label>
                    </div>
                </div>
                

                <div class="mb-6">
                    <label for="material_description" class="block text-sm font-medium mb-2 text-gray-800 dark:text-neutral-200">
                        Deskripsi Materi
                    </label>
                    <textarea id="material_description" name="description" rows="6"
                        class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                        placeholder="Jelaskan topik, sub-topik, tingkat kelas, dan detail materi yang ingin Anda buat. Contoh: Materi tentang fotosintesis untuk kelas 5 SD, mencakup pengertian, proses, dan faktor-faktor yang mempengaruhi fotosintesis..."
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
                        Generate Materi
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
            <span class="ml-3 text-gray-600 dark:text-neutral-400">Sedang membuat materi...</span>
        </div>
    </div>

    <div id="resultArea"
        class="hidden mt-6 bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-neutral-800 dark:border-neutral-700">
        <div class="p-6 sm:p-8">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-neutral-200">Hasil Generate</h3>
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
            <div id="resultContent" class="text-gray-800 dark:text-neutral-200">
            </div>
            
        </div>
    </div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        const sampleResponses = {
            ppt: `<div class="space-y-4">
                <div class="border-l-4 border-blue-500 bg-gray-50 dark:bg-neutral-900 p-4 rounded-r-lg">
                    <h4 class="font-semibold text-gray-800 dark:text-neutral-200 mb-2">Slide 1: Judul</h4>
                    <p class="text-gray-700 dark:text-neutral-300 font-bold text-lg">FOTOSINTESIS</p>
                    <p class="text-sm text-gray-600 dark:text-neutral-400">Proses Pembentukan Makanan pada Tumbuhan</p>
                </div>
                
                <div class="border-l-4 border-blue-500 bg-gray-50 dark:bg-neutral-900 p-4 rounded-r-lg">
                    <h4 class="font-semibold text-gray-800 dark:text-neutral-200 mb-2">Slide 2: Pengertian</h4>
                    <p class="text-gray-700 dark:text-neutral-300 mb-2">Fotosintesis adalah proses pembuatan makanan oleh tumbuhan hijau dengan bantuan sinar matahari.</p>
                    <ul class="list-disc list-inside text-gray-600 dark:text-neutral-400 space-y-1">
                        <li>Terjadi di daun</li>
                        <li>Menggunakan CO₂ dan H₂O</li>
                        <li>Menghasilkan glukosa dan O₂</li>
                    </ul>
                </div>
                
                <div class="border-l-4 border-blue-500 bg-gray-50 dark:bg-neutral-900 p-4 rounded-r-lg">
                    <h4 class="font-semibold text-gray-800 dark:text-neutral-200 mb-2">Slide 3: Proses Fotosintesis</h4>
                    <p class="text-gray-700 dark:text-neutral-300 font-mono text-sm mb-2">6CO₂ + 6H₂O + Cahaya → C₆H₁₂O₆ + 6O₂</p>
                    <p class="text-sm text-gray-600 dark:text-neutral-400">Karbondioksida + Air + Cahaya → Glukosa + Oksigen</p>
                </div>
                
                <div class="border-l-4 border-blue-500 bg-gray-50 dark:bg-neutral-900 p-4 rounded-r-lg">
                    <h4 class="font-semibold text-gray-800 dark:text-neutral-200 mb-2">Slide 4: Faktor yang Mempengaruhi</h4>
                    <ul class="list-disc list-inside text-gray-700 dark:text-neutral-300 space-y-1">
                        <li>Intensitas cahaya matahari</li>
                        <li>Jumlah klorofil</li>
                        <li>Suhu lingkungan</li>
                        <li>Ketersediaan air</li>
                        <li>Kandungan CO₂ di udara</li>
                    </ul>
                </div>
                
                <div class="border-l-4 border-blue-500 bg-gray-50 dark:bg-neutral-900 p-4 rounded-r-lg">
                    <h4 class="font-semibold text-gray-800 dark:text-neutral-200 mb-2">Slide 5: Manfaat Fotosintesis</h4>
                    <ul class="list-disc list-inside text-gray-700 dark:text-neutral-300 space-y-1">
                        <li>Menghasilkan makanan untuk tumbuhan</li>
                        <li>Menghasilkan oksigen untuk makhluk hidup</li>
                        <li>Mengurangi CO₂ di atmosfer</li>
                        <li>Menjaga keseimbangan ekosistem</li>
                    </ul>
                </div>
            </div>`,

            modul: `<div class="space-y-6">
                <div>
                    <h4 class="text-xl font-bold text-gray-800 dark:text-neutral-200 mb-4">BAB 1: FOTOSINTESIS</h4>
                    
                    <div class="mb-5">
                        <h5 class="font-semibold text-gray-800 dark:text-neutral-200 mb-2">A. Kompetensi Dasar</h5>
                        <p class="text-gray-700 dark:text-neutral-300">Siswa mampu memahami dan menjelaskan proses fotosintesis pada tumbuhan hijau.</p>
                    </div>
                    
                    <div class="mb-5">
                        <h5 class="font-semibold text-gray-800 dark:text-neutral-200 mb-2">B. Tujuan Pembelajaran</h5>
                        <ol class="list-decimal list-inside text-gray-700 dark:text-neutral-300 space-y-1">
                            <li>Siswa dapat menjelaskan pengertian fotosintesis</li>
                            <li>Siswa dapat menyebutkan bagian-bagian daun yang berperan dalam fotosintesis</li>
                            <li>Siswa dapat menjelaskan proses fotosintesis</li>
                            <li>Siswa dapat menyebutkan faktor-faktor yang mempengaruhi fotosintesis</li>
                        </ol>
                    </div>
                </div>
                
                <div class="border-t border-gray-200 dark:border-neutral-700 pt-5">
                    <h5 class="font-semibold text-gray-800 dark:text-neutral-200 mb-4">C. Materi Pembelajaran</h5>
                    
                    <div class="mb-5">
                        <h6 class="font-medium text-gray-800 dark:text-neutral-200 mb-2">1. Pengertian Fotosintesis</h6>
                        <p class="text-gray-700 dark:text-neutral-300 mb-2">Fotosintesis berasal dari kata "<strong>foto</strong>" yang berarti cahaya dan "<strong>sintesis</strong>" yang berarti penyusunan. Jadi, fotosintesis adalah proses penyusunan atau pembuatan makanan oleh tumbuhan hijau dengan bantuan cahaya matahari.</p>
                        <p class="text-gray-700 dark:text-neutral-300">Proses ini hanya dapat dilakukan oleh tumbuhan yang memiliki klorofil (zat hijau daun).</p>
                    </div>
                    
                    <div class="mb-5">
                        <h6 class="font-medium text-gray-800 dark:text-neutral-200 mb-2">2. Tempat Terjadinya Fotosintesis</h6>
                        <p class="text-gray-700 dark:text-neutral-300 mb-2">Fotosintesis terjadi di daun, tepatnya di dalam kloroplas yang mengandung klorofil.</p>
                        <p class="text-gray-700 dark:text-neutral-300 mb-2"><strong>Bagian-bagian daun yang berperan:</strong></p>
                        <ul class="list-disc list-inside text-gray-700 dark:text-neutral-300 ml-4 space-y-1">
                            <li><strong>Epidermis:</strong> lapisan pelindung</li>
                            <li><strong>Mesofil:</strong> tempat fotosintesis terjadi</li>
                            <li><strong>Stomata:</strong> tempat pertukaran gas</li>
                            <li><strong>Pembuluh:</strong> mengangkut air dan hasil fotosintesis</li>
                        </ul>
                    </div>
                    
                    <div class="mb-5">
                        <h6 class="font-medium text-gray-800 dark:text-neutral-200 mb-2">3. Bahan-Bahan Fotosintesis</h6>
                        <ul class="list-disc list-inside text-gray-700 dark:text-neutral-300 ml-4 space-y-1">
                            <li>Karbon dioksida (CO₂) dari udara</li>
                            <li>Air (H₂O) dari tanah</li>
                            <li>Cahaya matahari sebagai sumber energi</li>
                            <li>Klorofil sebagai zat penangkap cahaya</li>
                        </ul>
                    </div>
                    
                    <div class="mb-5">
                        <h6 class="font-medium text-gray-800 dark:text-neutral-200 mb-2">4. Proses Fotosintesis</h6>
                        <p class="text-gray-700 dark:text-neutral-300 mb-2">Persamaan reaksi fotosintesis:</p>
                        <div class="bg-gray-50 dark:bg-neutral-900 p-3 rounded-lg mb-2">
                            <p class="font-mono text-gray-800 dark:text-neutral-200 text-center">6CO₂ + 6H₂O + Cahaya → C₆H₁₂O₆ + 6O₂</p>
                        </div>
                        <p class="text-gray-700 dark:text-neutral-300 mb-2"><strong>Penjelasan proses:</strong></p>
                        <ol class="list-decimal list-inside text-gray-700 dark:text-neutral-300 ml-4 space-y-1">
                            <li>Daun menyerap cahaya matahari melalui klorofil</li>
                            <li>Akar menyerap air dari tanah</li>
                            <li>Daun menyerap karbon dioksida dari udara melalui stomata</li>
                            <li>Dengan bantuan klorofil dan cahaya, air dan CO₂ bereaksi membentuk glukosa</li>
                            <li>Oksigen dilepaskan ke udara sebagai hasil sampingan</li>
                        </ol>
                    </div>
                    
                    <div class="mb-5">
                        <h6 class="font-medium text-gray-800 dark:text-neutral-200 mb-2">5. Hasil Fotosintesis</h6>
                        <ul class="list-disc list-inside text-gray-700 dark:text-neutral-300 ml-4 space-y-1">
                            <li><strong>Glukosa (C₆H₁₂O₆):</strong> sebagai makanan untuk tumbuhan</li>
                            <li><strong>Oksigen (O₂):</strong> dilepas ke udara untuk kehidupan makhluk lain</li>
                        </ul>
                    </div>
                    
                    <div class="mb-5">
                        <h6 class="font-medium text-gray-800 dark:text-neutral-200 mb-2">6. Faktor yang Mempengaruhi Fotosintesis</h6>
                        <ol class="list-decimal list-inside text-gray-700 dark:text-neutral-300 ml-4 space-y-1">
                            <li><strong>Intensitas cahaya:</strong> Semakin banyak cahaya, semakin cepat fotosintesis</li>
                            <li><strong>Kadar CO₂:</strong> Lebih banyak CO₂ mempercepat proses</li>
                            <li><strong>Suhu:</strong> Suhu optimal 25-30°C</li>
                            <li><strong>Ketersediaan air:</strong> Air diperlukan sebagai bahan baku</li>
                            <li><strong>Jumlah klorofil:</strong> Lebih banyak klorofil, lebih efektif fotosintesis</li>
                        </ol>
                    </div>
                </div>
                
                <div class="border-t border-gray-200 dark:border-neutral-700 pt-5">
                    <h5 class="font-semibold text-gray-800 dark:text-neutral-200 mb-3">D. Rangkuman</h5>
                    <ul class="list-disc list-inside text-gray-700 dark:text-neutral-300 space-y-1">
                        <li>Fotosintesis adalah proses pembuatan makanan pada tumbuhan menggunakan cahaya</li>
                        <li>Terjadi di kloroplas yang ada di daun</li>
                        <li>Memerlukan CO₂, air, dan cahaya matahari</li>
                        <li>Menghasilkan glukosa dan oksigen</li>
                        <li>Sangat penting untuk kehidupan di Bumi</li>
                    </ul>
                </div>
                
                <div class="border-t border-gray-200 dark:border-neutral-700 pt-5">
                    <h5 class="font-semibold text-gray-800 dark:text-neutral-200 mb-3">E. Latihan Soal</h5>
                    <ol class="list-decimal list-inside text-gray-700 dark:text-neutral-300 space-y-2">
                        <li>Apa yang dimaksud dengan fotosintesis?</li>
                        <li>Sebutkan 3 bahan yang diperlukan dalam proses fotosintesis!</li>
                        <li>Di mana tempat terjadinya fotosintesis?</li>
                        <li>Sebutkan hasil dari proses fotosintesis!</li>
                        <li>Mengapa fotosintesis sangat penting bagi kehidupan?</li>
                        <li>Jelaskan bagian-bagian daun yang berperan dalam fotosintesis!</li>
                        <li>Apa yang dimaksud dengan klorofil?</li>
                        <li>Sebutkan 4 faktor yang mempengaruhi kecepatan fotosintesis!</li>
                        <li>Tuliskan persamaan reaksi fotosintesis!</li>
                        <li>Mengapa tumbuhan disebut sebagai produsen dalam ekosistem?</li>
                    </ol>
                </div>
                
                <div class="border-t border-gray-200 dark:border-neutral-700 pt-5">
                    <h5 class="font-semibold text-gray-800 dark:text-neutral-200 mb-3">F. Tugas</h5>
                    <div class="bg-gray-50 dark:bg-neutral-900 p-4 rounded-lg">
                        <p class="text-gray-700 dark:text-neutral-300">Buatlah percobaan sederhana untuk membuktikan bahwa tumbuhan menghasilkan oksigen saat fotosintesis. Catat bahan, langkah-langkah, dan hasil pengamatan dalam laporan!</p>
                    </div>
                </div>
            </div>`
        };

        $('#materiForm').on('submit', function(e) {
            e.preventDefault();

            const materialType = $('input[name="material_type"]:checked').val();
            const description = $('#material_description').val();

            $('#loadingState').removeClass('hidden');
            $('#resultArea').addClass('hidden');

            $('#generateBtn').prop('disabled', true);

            setTimeout(function() {
                $('#loadingState').addClass('hidden');
                $('#resultArea').removeClass('hidden');
                $('#generateBtn').prop('disabled', false);

                $('#resultContent').html(sampleResponses[materialType]);
            }, 2000);
        });

        $('#copyBtn').on('click', function() {
            const content = $('#resultContent').text();

            navigator.clipboard.writeText(content).then(function() {
                const originalHtml = $('#copyBtn').html();
                $('#copyBtn').html(
                    '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Copied!'
                );

                setTimeout(function() {
                    $('#copyBtn').html(originalHtml);
                }, 2000);
            });
        });
    });
</script>
@endpush