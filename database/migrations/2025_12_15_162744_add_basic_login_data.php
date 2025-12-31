<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Thêm teacher mẫu
        DB::table('teacher')->insertOrIgnore([
            'ma_giao_vien' => 'GV001',
            'username' => 'teacher1',
            'ho_ten' => 'Nguyễn Văn An',
            'gioi_tinh' => 'Nam',
            'ngay_sinh' => '1980-01-15',
            'so_dien_thoai' => '0987654321',
            'email' => 'teacher1@school.edu.vn',
            'dia_chi' => 'Hà Nội',
            'bang_cap' => 'Thạc sĩ Toán học',
            'trinh_do_chuyen_mon' => 'Thạc sĩ',
            'to_chuyen_mon' => 'Tổ Toán',
            'mon_day' => 'Toán',
            'nam_cong_tac' => 2005,
            'chuc_vu' => 'Giáo viên',
            'lop_chu_nhiem' => '10A1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Thêm login cho admin
        DB::table('login')->insertOrIgnore([
            'username' => 'admin',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Thêm login cho teacher
        DB::table('login')->insertOrIgnore([
            'username' => 'teacher1',
            'password' => bcrypt('123456'),
            'role' => 'Teacher',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('login')->whereIn('username', ['admin', 'teacher1'])->delete();
        DB::table('teacher')->where('ma_giao_vien', 'GV001')->delete();
    }
};
