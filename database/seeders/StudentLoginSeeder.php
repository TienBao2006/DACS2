<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\Login;
use Illuminate\Support\Facades\Hash;

class StudentLoginSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        echo "Creating login accounts for students...\n";
        
        // Lấy 50 học sinh đầu tiên để tạo tài khoản login
        $students = Student::whereNull('login_id')->take(50)->get();
        
        $createdCount = 0;
        
        foreach ($students as $student) {
            // Tạo tài khoản login
            $login = Login::create([
                'username' => $student->ma_hoc_sinh, // Dùng mã học sinh làm username
                'password' => Hash::make('123456'), // Mật khẩu mặc định
                'role' => 'Student',
                'is_active' => true,
            ]);
            
            // Cập nhật login_id cho học sinh
            $student->update(['login_id' => $login->id]);
            
            $createdCount++;
        }
        
        echo "Created login accounts for $createdCount students\n";
        
        // Thống kê
        $totalStudents = Student::count();
        $studentsWithLogin = Student::whereNotNull('login_id')->count();
        $studentsWithoutLogin = $totalStudents - $studentsWithLogin;
        
        echo "Total students: $totalStudents\n";
        echo "Students with login: $studentsWithLogin\n";
        echo "Students without login: $studentsWithoutLogin\n";
    }
}