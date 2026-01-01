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

    protected string $instructions = 'Agen WAJIB menggunakan GeminiTextGeneration sebagai satu-satunya tool untuk menghasilkan teks materi. Agen hanya mengekstrak topic dan level dari input pengguna, lalu memanggil Gemini tanpa membuat konten sendiri.';

    protected string $model = 'gemini-2.0-flash-exp';

    protected array $tools = [
        GeminiTextGeneration::class,
    ];
}
