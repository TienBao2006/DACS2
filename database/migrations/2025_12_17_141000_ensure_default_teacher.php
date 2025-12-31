<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Models\Teacher;
use App\Models\Login;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Kiểm tra xem có giáo viên nào không
        $teacherCount = Teacher::count();
        
        if ($teacherCount === 0) {
            echo "Không có giáo viên nào. Tạo giáo viên mặc định...\n";
            
            try {
                // Tạo tài khoản login cho giáo viên mặc định
                $login = Login::create([
                    'username' => 'giaovien001',
                    'password' => bcrypt('123456'),
                    'role' => 'Teacher',
                    'is_active' => true,
                ]);

                // Tạo giáo viên mặc định
                Teacher::create([
                    'login_id' => $login->id,
                    'ma_giao_vien' => 'GV001',
                    'ho_va_ten' => 'Giáo viên mặc định',
                    'gioi_tinh' => 'Nam',
                    'ngay_sinh' => '1980-01-01',
                    'dia_chi' => 'Hà Nội',
                    'so_dien_thoai' => '0123456789',
                    'email' => 'giaovien001@school.edu.vn',
                    'mon_day' => 'Toán',
                    'trinh_do' => 'Thạc sĩ',
                    'nam_cong_tac' => 2010,
                    'trang_thai' => 'Đang làm việc',
                ]);
                
                echo "Đã tạo giáo viên mặc định với mã GV001\n";
            } catch (\Exception $e) {
                echo "Lỗi khi tạo giáo viên mặc định: " . $e->getMessage() . "\n";
            }
        } else {
            echo "Đã có {$teacherCount} giáo viên trong database\n";
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Xóa giáo viên mặc định nếu có
        $defaultTeacher = Teacher::where('ma_giao_vien', 'GV001')->first();
        if ($defaultTeacher) {
            $defaultTeacher->login()->delete(); // Xóa tài khoản login
            $defaultTeacher->delete(); // Xóa giáo viên
        }
    }
};