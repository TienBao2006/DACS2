<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Student;
use App\Models\Teacher;

class ScoresSeeder extends Seeder
{
    public function run()
    {
        // Lấy danh sách học sinh
        $students = Student::all();
        
        // Lấy danh sách giáo viên
        $teachers = Teacher::all();
        
        if ($students->isEmpty()) {
            echo "Không có học sinh nào trong database. Vui lòng tạo học sinh trước.\n";
            return;
        }

        // Danh sách môn học
        $subjects = [
            'TOAN' => 'Toán',
            'VAN' => 'Ngữ Văn', 
            'ANH' => 'Tiếng Anh',
            'LY' => 'Vật Lý',
            'HOA' => 'Hóa Học',
            'SINH' => 'Sinh Học',
            'SU' => 'Lịch Sử',
            'DIA' => 'Địa Lý',
            'GDCD' => 'GDCD',
            'TD' => 'Thể Dục'
        ];

        // Tạo điểm cho từng học sinh
        foreach ($students as $student) {
            foreach ($subjects as $subjectCode => $subjectName) {
                // Kiểm tra xem đã có điểm chưa
                $existingScore = DB::table('scores')
                    ->where('student_id', $student->id)
                    ->where('mon_hoc', $subjectCode)
                    ->where('nam_hoc', '2024-2025')
                    ->first();

                if (!$existingScore) {
                    // Tạo điểm ngẫu nhiên trong khoảng hợp lý
                    $diemMieng1 = rand(70, 100) / 10; // 7.0 - 10.0
                    $diemMieng2 = rand(70, 100) / 10;
                    $diemMieng3 = rand(70, 100) / 10;
                    $diem15p1 = rand(70, 100) / 10;
                    $diem15p2 = rand(70, 100) / 10;
                    $diemGk = rand(70, 100) / 10;
                    $diemCk = rand(70, 100) / 10;
                    
                    // Tính điểm tổng kết theo công thức: (miệng*2 + 15p + GK*2 + CK*3) / 8
                    $diemTongKet = round((($diemMieng1 + $diemMieng2 + $diemMieng3) / 3 * 2 + ($diem15p1 + $diem15p2) / 2 + ($diemGk * 2) + ($diemCk * 3)) / 8, 1);

                    // Sử dụng Scores model để tự động lấy giáo viên từ timetable
                    \App\Models\Scores::create([
                        'student_id' => $student->id,
                        'mon_hoc' => $subjectCode,
                        'khoi' => $student->khoi,
                        'lop' => $student->lop,
                        'nam_hoc' => '2024-2025',
                        'hoc_ky' => 'HK1',
                        'diem_mieng_1' => $diemMieng1,
                        'diem_mieng_2' => $diemMieng2,
                        'diem_mieng_3' => $diemMieng3,
                        'diem_15phut_1' => $diem15p1,
                        'diem_15phut_2' => $diem15p2,
                        'diem_giua_ky' => $diemGk,
                        'diem_cuoi_ky' => $diemCk,
                        'diem_tong_ket' => $diemTongKet,
                    ]);
                }
            }
        }

        echo "Đã tạo điểm mẫu cho " . $students->count() . " học sinh với " . count($subjects) . " môn học.\n";
    }
}