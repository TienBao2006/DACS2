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
        // Thêm dữ liệu lớp học đầy đủ cho khối 10, 11, 12
        $classes = [];
        
        // Khối 10: 10A1 đến 10A8
        for ($i = 1; $i <= 8; $i++) {
            $classes[] = [
                'ma_hoc_sinh' => 'HS10A' . $i . '001',
                'ho_va_ten' => 'Học sinh mẫu ' . $i,
                'gioi_tinh' => $i % 2 == 0 ? 'Nữ' : 'Nam',
                'ngay_sinh' => '2007-01-' . str_pad($i, 2, '0', STR_PAD_LEFT),
                'dia_chi' => 'Địa chỉ mẫu ' . $i,
                'so_dien_thoai' => '097743056' . $i,
                'email' => 'hocsinh10a' . $i . '@gmail.com',
                'lop' => 'A' . $i,
                'khoi' => '10',
                'nam_hoc' => '2024-2025',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        
        // Khối 11: 11A1 đến 11A8
        for ($i = 1; $i <= 8; $i++) {
            $classes[] = [
                'ma_hoc_sinh' => 'HS11A' . $i . '001',
                'ho_va_ten' => 'Học sinh mẫu ' . $i,
                'gioi_tinh' => $i % 2 == 0 ? 'Nữ' : 'Nam',
                'ngay_sinh' => '2006-01-' . str_pad($i, 2, '0', STR_PAD_LEFT),
                'dia_chi' => 'Địa chỉ mẫu ' . $i,
                'so_dien_thoai' => '097743057' . $i,
                'email' => 'hocsinh11a' . $i . '@gmail.com',
                'lop' => 'A' . $i,
                'khoi' => '11',
                'nam_hoc' => '2024-2025',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        
        // Khối 12: 12A1 đến 12A8
        for ($i = 1; $i <= 8; $i++) {
            $classes[] = [
                'ma_hoc_sinh' => 'HS12A' . $i . '001',
                'ho_va_ten' => 'Học sinh mẫu ' . $i,
                'gioi_tinh' => $i % 2 == 0 ? 'Nữ' : 'Nam',
                'ngay_sinh' => '2005-01-' . str_pad($i, 2, '0', STR_PAD_LEFT),
                'dia_chi' => 'Địa chỉ mẫu ' . $i,
                'so_dien_thoai' => '097743058' . $i,
                'email' => 'hocsinh12a' . $i . '@gmail.com',
                'lop' => 'A' . $i,
                'khoi' => '12',
                'nam_hoc' => '2024-2025',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        
        // Thêm dữ liệu vào bảng student
        DB::table('student')->insertOrIgnore($classes);
        
        // Đã thêm dữ liệu học sinh mẫu
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Xóa dữ liệu mẫu đã thêm
        DB::table('student')->where('ma_hoc_sinh', 'like', 'HS10A%')->delete();
        DB::table('student')->where('ma_hoc_sinh', 'like', 'HS11A%')->delete();
        DB::table('student')->where('ma_hoc_sinh', 'like', 'HS12A%')->delete();
    }
};