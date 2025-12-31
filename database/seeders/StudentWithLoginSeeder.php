<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\Login;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class StudentWithLoginSeeder extends Seeder
{
    public function run()
    {
        echo "Bắt đầu tạo tài khoản login cho các học sinh hiện có...\n";
        
        // Lấy tất cả học sinh chưa có login_id
        $studentsWithoutLogin = Student::whereNull('login_id')->get();
        
        if ($studentsWithoutLogin->count() == 0) {
            echo "Tất cả học sinh đã có tài khoản login.\n";
            return;
        }
        
        echo "Tìm thấy {$studentsWithoutLogin->count()} học sinh chưa có tài khoản login.\n";
        
        $createdCount = 0;
        
        foreach ($studentsWithoutLogin as $student) {
            try {
                // Tạo username từ mã học sinh hoặc tên
                $username = $student->ma_hoc_sinh ? strtolower($student->ma_hoc_sinh) : 'hs' . $student->id;
                
                // Kiểm tra username đã tồn tại chưa
                $counter = 1;
                $originalUsername = $username;
                while (Login::where('username', $username)->exists()) {
                    $username = $originalUsername . $counter;
                    $counter++;
                }
                
                // Tạo tài khoản login
                $login = Login::create([
                    'username' => $username,
                    'password' => Hash::make('123456'), // Mật khẩu mặc định
                    'role' => 'Student',
                    'is_active' => true,
                ]);
                
                // Cập nhật login_id cho học sinh
                $student->update(['login_id' => $login->id]);
                
                $createdCount++;
                
                if ($createdCount % 50 == 0) {
                    echo "Đã tạo {$createdCount} tài khoản...\n";
                }
                
            } catch (\Exception $e) {
                echo "Lỗi khi tạo tài khoản cho học sinh {$student->ho_va_ten}: " . $e->getMessage() . "\n";
            }
        }
        
        echo "✅ Hoàn thành! Đã tạo {$createdCount} tài khoản login cho học sinh.\n";
        echo "📊 Thống kê:\n";
        echo "- Tổng học sinh: " . Student::count() . "\n";
        echo "- Học sinh có tài khoản: " . Student::whereNotNull('login_id')->count() . "\n";
        echo "- Tổng tài khoản Student: " . Login::where('role', 'Student')->count() . "\n";
    }
    
    private function generateBirthDate($khoi)
    {
        $currentYear = date('Y');
        $birthYear = $currentYear - (15 + (12 - $khoi)); // Khối 10: ~16 tuổi, Khối 12: ~18 tuổi
        $month = rand(1, 12);
        $day = rand(1, 28);
        
        return sprintf('%04d-%02d-%02d', $birthYear, $month, $day);
    }
    
    private function generateAddress()
    {
        $streets = ['Lê Lợi', 'Nguyễn Huệ', 'Trần Hưng Đạo', 'Hai Bà Trưng', 'Lý Thường Kiệt', 'Điện Biên Phủ', 'Cách Mạng Tháng 8', 'Võ Văn Tần'];
        $districts = ['Quận 1', 'Quận 3', 'Quận 5', 'Quận 7', 'Quận 10', 'Quận Bình Thạnh', 'Quận Tân Bình', 'Quận Phú Nhuận'];
        
        $number = rand(1, 999);
        $street = $streets[array_rand($streets)];
        $district = $districts[array_rand($districts)];
        
        return "{$number} {$street}, {$district}, TP.HCM";
    }
    
    private function generatePhoneNumber()
    {
        $prefixes = ['090', '091', '094', '083', '084', '085', '081', '082'];
        $prefix = $prefixes[array_rand($prefixes)];
        $number = rand(1000000, 9999999);
        
        return $prefix . $number;
    }
    
    private function generateParentName($gender)
    {
        $firstNames = [
            'Nam' => ['Văn', 'Đình', 'Quang', 'Minh', 'Hữu', 'Thanh', 'Công', 'Duy'],
            'Nữ' => ['Thị', 'Minh', 'Thu', 'Hương', 'Lan', 'Mai', 'Nga', 'Linh']
        ];
        
        $lastNames = ['Nguyễn', 'Trần', 'Lê', 'Phạm', 'Hoàng', 'Huỳnh', 'Phan', 'Vũ'];
        
        $lastName = $lastNames[array_rand($lastNames)];
        $firstName = $firstNames[$gender][array_rand($firstNames[$gender])];
        
        return $lastName . ' ' . $firstName;
    }
}