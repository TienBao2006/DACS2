<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Student;

class CreateSampleScores extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scores:create-sample {--year=2024-2025 : Năm học}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tạo điểm mẫu cho tất cả học sinh';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $year = $this->option('year');
        
        $this->info("Bắt đầu tạo điểm mẫu cho năm học: {$year}");
        
        $students = Student::all();
        
        if ($students->isEmpty()) {
            $this->error('Không có học sinh nào trong database!');
            return 1;
        }

        $this->info("Tìm thấy {$students->count()} học sinh");
        
        $createdCount = 0;
        $skippedCount = 0;
        
        $progressBar = $this->output->createProgressBar($students->count());
        $progressBar->start();
        
        foreach ($students as $student) {
            if ($student->createSampleScores($year)) {
                $createdCount++;
            } else {
                $skippedCount++;
            }
            $progressBar->advance();
        }
        
        $progressBar->finish();
        $this->newLine();
        
        $this->info("Hoàn thành!");
        $this->info("- Đã tạo điểm cho: {$createdCount} học sinh");
        $this->info("- Bỏ qua (đã có điểm): {$skippedCount} học sinh");
        
        return 0;
    }
}