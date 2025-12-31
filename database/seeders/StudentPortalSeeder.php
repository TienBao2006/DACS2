<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Scores;
use App\Models\Timetable;

class StudentPortalSeeder extends Seeder
{
    public function run()
    {
        // Tạo dữ liệu điểm mẫu cho học sinh
        $students = Student::all();
        $subjects = ['TOAN', 'VAN', 'ANH', 'LY', 'HOA', 'SINH', 'SU', 'DIA', 'GDCD', 'TD'];
        
        foreach ($students as $student) {
            foreach ($subjects as $subject) {
                // Kiểm tra xem đã có điểm chưa
                $existingScore = Scores::where('student_id', $student->id)
                    ->where('mon_hoc', $subject)
                    ->where('hoc_ky', 1)
                    ->where('nam_hoc', '2024-2025')
                    ->first();
                
                if (!$existingScore) {
                    Scores::create([
                        'student_id' => $student->id,
                        'teacher_id' => null, // Sẽ cập nhật sau
                        'mon_hoc' => $subject,
                        'hoc_ky' => 1,
                        'nam_hoc' => '2024-2025',
                        'diem_mieng_1' => rand(70, 100) / 10,
                        'diem_mieng_2' => rand(70, 100) / 10,
                        'diem_mieng_3' => rand(70, 100) / 10,
                        'diem_15p_1' => rand(70, 100) / 10,
                        'diem_15p_2' => rand(70, 100) / 10,
                        'diem_1tiet' => rand(70, 100) / 10,
                        'diem_gk' => rand(70, 100) / 10,
                        'diem_ck' => rand(70, 100) / 10,
                    ]);
                }
            }
        }

        // Tạo thời khóa biểu mẫu
        $classes = ['10A1', '10A2', '11A1', '12A1'];
        $days = [2, 3, 4, 5, 6, 7]; // Thứ 2 đến thứ 7
        $periods = [1, 2, 3, 4, 5];
        
        $subjectTeachers = [
            'TOAN' => 'Nguyễn Văn A',
            'VAN' => 'Trần Thị B', 
            'ANH' => 'Lê Văn C',
            'LY' => 'Phạm Văn D',
            'HOA' => 'Hoàng Thị E',
            'SINH' => 'Vũ Văn F',
            'SU' => 'Đỗ Thị G',
            'DIA' => 'Bùi Văn H',
            'GDCD' => 'Lý Thị I',
            'TD' => 'Trương Văn J'
        ];

        foreach ($classes as $class) {
            $khoi = substr($class, 0, 2);
            
            foreach ($days as $day) {
                foreach ($periods as $period) {
                    // Random môn học cho mỗi tiết
                    $subject = $subjects[array_rand($subjects)];
                    
                    // Kiểm tra xem đã có lịch chưa
                    $existingSchedule = Timetable::where('lop', $class)
                        ->where('thu', $day)
                        ->where('tiet', $period)
                        ->where('nam_hoc', '2024-2025')
                        ->where('hoc_ky', 1)
                        ->first();
                    
                    if (!$existingSchedule) {
                        Timetable::create([
                            'lop' => $class,
                            'khoi' => $khoi,
                            'thu' => $day,
                            'tiet' => $period,
                            'mon_hoc' => $subject,
                            'ma_giao_vien' => null, // Sẽ cập nhật sau
                            'ten_giao_vien' => $subjectTeachers[$subject],
                            'phong_hoc' => 'A' . rand(101, 110),
                            'nam_hoc' => '2024-2025',
                            'hoc_ky' => 1,
                            'is_active' => true
                        ]);
                    }
                }
            }
        }

        echo "Student Portal data seeded successfully!\n";
    }
}