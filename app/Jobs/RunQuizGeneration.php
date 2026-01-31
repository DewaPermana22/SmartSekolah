<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Queue\Queueable;
use App\Constants\DatabaseConst;
use App\Usecase\superAdmin\TextGenerationtUsecase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use RuntimeException;
use Throwable;

class RunQuizGeneration implements ShouldQueue
{
    use Queueable, InteractsWithQueue, SerializesModels;

    public $tries = 3;
    public $timeout = 180;
    public $backoff = 30;

    public function __construct(
        public string $topic,
        public int $totalQuestions,
        public string $educationLevel,
        public string $class,
        public int $optionsCount,
        public string $categories,
        public string $referenceId,
    ) {}


    public function handle(): void
    {
        DB::beginTransaction();

        try {
            $usecase = app(TextGenerationtUsecase::class);

            // Ambil template prompt dari DB
            $promptTemplate = DB::table('prompt_text_generation')
                ->where('categories', $this->categories)
                ->value('text_prompt');

            if (!$promptTemplate) {
                throw new RuntimeException('Prompt template not found');
            }

            // Replace parameter di prompt
            $finalPrompt = str_replace(
                [
                    '{{TOPIC}}',
                    '{{TOTAL_QUESTIONS}}',
                    '{{EDUCATION_LEVEL}}',
                    '{{CLASS}}',
                    '{{OPTIONS_COUNT}}',
                ],
                [
                    $this->topic,
                    $this->totalQuestions,
                    $this->educationLevel,
                    $this->class,
                    $this->optionsCount,
                ],
                $promptTemplate
            );

            // Panggil Gemini
            $result = $usecase->generateTextGemini(
                description: $finalPrompt,
                categories: $this->categories
            );

            if (!($result['success'] ?? false)) {
                throw new RuntimeException(
                    $result['message'] ?? 'Text generation failed'
                );
            }

            $data = $result['data'];

            // Bersihkan kemungkinan ```json
            $cleanJson = trim($data['content']);
            $cleanJson = preg_replace('/```json|```/', '', $cleanJson);

            $questions = json_decode($cleanJson, true);

            if (!is_array($questions)) {
                throw new RuntimeException('Invalid JSON format from AI');
            }

            // INSERT QUIZ
            $quizId = DB::table('quizses')->insertGetId([
                'quiz_name'   => 'Quiz ' . $this->topic,
                'description' => 'Quiz tentang ' . $this->topic,
                'quiz_code'   => $this->referenceId,
                'quiz_time'   => 0,
                'created_at'  => now(),
                'created_by'  => 1,
            ]);

            // LOOP QUESTIONS
            foreach ($questions as $q) {
                if (!isset($q['question'], $q['options'], $q['correct_answer'])) {
                    throw new RuntimeException('Invalid question structure');
                }

                $questionId = DB::table('quiz_questions')->insertGetId([
                    'quiz_id'    => $quizId,
                    'question'   => $q['question'],
                    'created_at' => now(),
                    'created_by' => 1,
                ]);

                // LOOP OPTIONS
                foreach ($q['options'] as $option) {
                    DB::table('quiz_options')->insert([
                        'question_id' => $questionId,
                        'option_text' => $option,
                        'is_correct'  => $option === $q['correct_answer'],
                        'created_at'  => now(),
                        'created_by'  => 1,
                    ]);
                }
            }

            DB::commit();

            Log::info('Quiz generation completed', [
                'reference_id' => $this->referenceId,
                'quiz_id' => $quizId,
            ]);
        } catch (Throwable $e) {
            DB::rollBack();

            Log::error('RunQuizGeneration FAILED', [
                'reference_id' => $this->referenceId,
                'error' => $e->getMessage()
            ]);

            throw $e;
        }
    }



    public function failed(Throwable $exception): void
    {
        Storage::disk('local')->put(
            "failed-text-generations/{$this->referenceId}.json",
            json_encode([
                'reference_id' => $this->referenceId,
                'categories' => $this->categories,
                'error' => $exception->getMessage(),
                'timestamp' => now()->toDateTimeString(),
            ], JSON_PRETTY_PRINT)
        );

        Log::error('Job definitively FAILED after all retries', [
            'reference_id' => $this->referenceId,
            'tries' => $this->attempts(),
            'error' => $exception->getMessage()
        ]);
    }
}
