<?php

namespace App\Agents;

use App\Tools\GeminiTools;
use Vizra\VizraADK\Agents\BaseLlmAgent;

class TextGenerationAgent extends BaseLlmAgent
{
    protected string $name = 'Educational Material Generator';

    protected string $description = 'Agen khusus untuk membuat materi pembelajaran terstruktur (SD, SMP, SMA) menggunakan GeminiTools.';

    protected string $instructions = "
    Anda adalah agen pemroses permintaan materi pendidikan.
    Aturan wajib:
    1. Anda tidak boleh menjawab langsung.
    2. Untuk setiap permintaan, Anda WAJIB memanggil tool generate_educational_text.
    3. Anda harus mengekstrak topic dan level dari pesan user.
    4. Setelah tool dipanggil, tampilkan hasil tool apa adanya.
    ";


    protected string $model = 'gemini-2.0-flash-exp';

    protected array $tools = [
        GeminiTools::class,
    ];


}
