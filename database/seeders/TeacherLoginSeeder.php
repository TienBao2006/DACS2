<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Teacher;
use App\Models\Login;
use Illuminate\Support\Facades\Hash;

class TeacherLoginSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        echo "Creating login accounts for teachers...\n";
        
        // Lấy tất cả giáo viên chưa có tài khoản login
        $teachers = Teacher::whereNull('login_id')->get();
        
        $createdCount = 0;
        
        foreach ($teachers as $teacher) {
            // Tạo username từ mã giáo viên
            $username = $teacher->ma_giao_vien;
            
            // Kiểm tra xem username đã tồn tại chưa
            if (Login::where('username', $username)->exists()) {
                $username = $teacher->ma_giao_vien . '_teacher';
            }
            
            // Tạo tài khoản login
            $login = Login::create([
                'username' => $username,
                'password' => Hash::make('123456'), // Mật khẩu mặc định
                'role' => 'Teacher',
                'is_active' => true,
            ]);
            
            // Cập nhật login_id cho giáo viên
            $teacher->update(['login_id' => $login->id]);
            
            echo "Created login for teacher: {$teacher->ho_ten} (Username: {$username})\n";
            $createdCount++;
        }
        
        echo "Created login accounts for $createdCount teachers\n";
        
        // Thống kê
        $totalTeachers = Teacher::count();
        $teachersWithLogin = Teacher::whereNotNull('login_id')->count();
        $teachersWithoutLogin = $totalTeachers - $teachersWithLogin;
        
        echo "Total teachers: $totalTeachers\n";
        echo "Teachers with login: $teachersWithLogin\n";
        echo "Teachers without login: $teachersWithoutLogin\n";
    }
}