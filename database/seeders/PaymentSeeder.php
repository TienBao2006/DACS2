<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Payment;
use App\Models\Student;

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        // Lấy một vài học sinh để tạo thanh toán mẫu
        $students = Student::take(5)->get();

        foreach ($students as $student) {
            // Tạo 2-3 khoản thanh toán cho mỗi học sinh
            Payment::create([
                'student_id' => $student->id,
                'order_id' => rand(1000, 9999),
                'title' => 'Học phí học kỳ I',
                'description' => 'Học phí học kỳ I năm học 2024-2025',
                'amount' => 2500000,
                'due_date' => '2025-01-15',
                'payment_type' => 'tuition',
                'status' => 'PENDING'
            ]);

            Payment::create([
                'student_id' => $student->id,
                'order_id' => rand(1000, 9999),
                'title' => 'Phí hoạt động ngoại khóa',
                'description' => 'Phí tham gia các hoạt động ngoại khóa',
                'amount' => 500000,
                'due_date' => '2025-01-20',
                'payment_type' => 'activity',
                'status' => 'PENDING'
            ]);

            // Một khoản đã thanh toán
            Payment::create([
                'student_id' => $student->id,
                'order_id' => rand(1000, 9999),
                'title' => 'Học phí học kỳ II năm trước',
                'description' => 'Học phí học kỳ II năm học 2023-2024',
                'amount' => 2500000,
                'due_date' => '2024-06-15',
                'payment_type' => 'tuition',
                'status' => 'COMPLETED'
            ]);
        }
    }
}