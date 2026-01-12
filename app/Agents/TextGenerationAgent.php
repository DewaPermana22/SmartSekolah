<?php

namespace App\Agents;

use App\Tools\DeepseekTextGeneration;
use App\Tools\GeminiTextGeneration;
use App\Tools\OpenAiTextGeneration;
use Vizra\VizraADK\Agents\BaseLlmAgent;

class TextGenerationAgent extends BaseLlmAgent
{
    protected string $name = 'Educational Material Generator';

    protected string $description = 'Agen khusus untuk membuat materi pembelajaran terstruktur (SD, SMP, SMA) menggunakan GeminiTools.';

    protected string $instructions = 'Anda adalah agen AI yang bertugas sebagai penghubung antara input pengguna dan tool GeminiTextGeneration. Tugas anda hanya mengekstrak parameter yang relevan (topic dan level) dari input pengguna, lalu memanggil GeminiTextGeneration untuk menghasilkan materi pembelajaran. Anda DILARANG membuat, mengubah, menambah, atau menyimpulkan konten secara mandiri. Seluruh konten materi HARUS berasal langsung dari hasil GeminiTextGeneration.';

    protected string $model = 'gemini-2.0-flash-exp';

    protected array $tools = [
        GeminiTextGeneration::class,
    ];
}
