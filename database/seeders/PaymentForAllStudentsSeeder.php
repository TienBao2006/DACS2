<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\Payment;

class PaymentForAllStudentsSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Tạo khoản thu học phí học kỳ II cho tất cả học sinh
        $students = Student::all();
        
        echo "Tạo khoản thu cho " . $students->count() . " học sinh...\n";
        
        foreach ($students as $student) {
            Payment::create([
                'student_id' => $student->id,
                'order_id' => rand(100000, 999999),
                'title' => 'Học phí học kỳ II',
                'description' => 'Học phí học kỳ II năm học 2024-2025',
                'amount' => 2500000,
                'due_date' => '2025-02-15',
                'payment_type' => 'tuition',
                'status' => 'PENDING'
            ]);
        }
        
        echo "Hoàn thành tạo khoản thu cho tất cả học sinh!\n";
    }
}