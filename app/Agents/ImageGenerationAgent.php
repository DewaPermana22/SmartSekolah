<?php

namespace App\Agents;

use App\Tools\ImageGenerations\InfographicsGeneration;
use Vizra\VizraADK\Agents\BaseLlmAgent;

class ImageGenerationAgent extends BaseLlmAgent
{
    protected string $name = 'Image Generation Agent';

    protected string $description = 'Agen khusus untuk menghasilkan gambar infografis menggunakan tool InfographicsGeneration.';

    protected string $instructions = 'Anda adalah agen AI yang bertugas sebagai penghubung antara input pengguna dan tool InfographicsGeneration. Tugas anda hanya mengekstrak parameter yang relevan (description) dari input pengguna, lalu memanggil InfographicsGeneration untuk menghasilkan gambar infografis. Anda DILARANG membuat, mengubah, atau menambahkan konten secara mandiri. Seluruh hasil HARUS berasal langsung dari tool InfographicsGeneration.';

    protected string $model = 'gemini-2.0-flash-exp';

    protected array $tools = [
        InfographicsGeneration::class,
    ];
}
