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
        // Thêm nhiều học sinh cho mỗi lớp (30 học sinh/lớp)
        $students = [];
        $studentNames = [
            'Nguyễn Văn An', 'Trần Thị Bình', 'Lê Văn Cường', 'Phạm Thị Dung', 'Hoàng Văn Em',
            'Vũ Thị Phương', 'Đặng Văn Giang', 'Bùi Thị Hoa', 'Ngô Văn Inh', 'Lý Thị Kim',
            'Đinh Văn Long', 'Tạ Thị Mai', 'Đỗ Văn Nam', 'Chu Thị Oanh', 'Võ Văn Phúc',
            'Phan Thị Quỳnh', 'Lưu Văn Rồng', 'Trịnh Thị Sương', 'Dương Văn Tài', 'Lê Thị Uyên',
            'Nguyễn Văn Vinh', 'Trần Thị Xuân', 'Phạm Văn Yên', 'Hoàng Thị Zung', 'Vũ Văn Anh',
            'Đặng Thị Bảo', 'Bùi Văn Cảnh', 'Ngô Thị Diệu', 'Lý Văn Đức', 'Đinh Thị Hạnh'
        ];
        
        // Khối 10: A1 đến A8
        for ($class = 1; $class <= 8; $class++) {
            for ($student = 1; $student <= 30; $student++) {
                $students[] = [
                    'ma_hoc_sinh' => 'HS10A' . $class . str_pad($student, 3, '0', STR_PAD_LEFT),
                    'ho_va_ten' => $studentNames[($student - 1) % count($studentNames)],
                    'gioi_tinh' => $student % 2 == 0 ? 'Nữ' : 'Nam',
                    'ngay_sinh' => '2007-' . str_pad(rand(1, 12), 2, '0', STR_PAD_LEFT) . '-' . str_pad(rand(1, 28), 2, '0', STR_PAD_LEFT),
                    'dia_chi' => 'Hà Tĩnh',
                    'so_dien_thoai' => '097743' . str_pad(rand(100000, 999999), 6, '0', STR_PAD_LEFT),
                    'email' => 'hs10a' . $class . '_' . $student . '@gmail.com',
                    'lop' => 'A' . $class,
                    'khoi' => '10',
                    'nam_hoc' => '2024-2025',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }
        
        // Khối 11: A1 đến A8
        for ($class = 1; $class <= 8; $class++) {
            for ($student = 1; $student <= 30; $student++) {
                $students[] = [
                    'ma_hoc_sinh' => 'HS11A' . $class . str_pad($student, 3, '0', STR_PAD_LEFT),
                    'ho_va_ten' => $studentNames[($student - 1) % count($studentNames)],
                    'gioi_tinh' => $student % 2 == 0 ? 'Nữ' : 'Nam',
                    'ngay_sinh' => '2006-' . str_pad(rand(1, 12), 2, '0', STR_PAD_LEFT) . '-' . str_pad(rand(1, 28), 2, '0', STR_PAD_LEFT),
                    'dia_chi' => 'Hà Tĩnh',
                    'so_dien_thoai' => '097744' . str_pad(rand(100000, 999999), 6, '0', STR_PAD_LEFT),
                    'email' => 'hs11a' . $class . '_' . $student . '@gmail.com',
                    'lop' => 'A' . $class,
                    'khoi' => '11',
                    'nam_hoc' => '2024-2025',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }
        
        // Khối 12: A1 đến A8
        for ($class = 1; $class <= 8; $class++) {
            for ($student = 1; $student <= 30; $student++) {
                $students[] = [
                    'ma_hoc_sinh' => 'HS12A' . $class . str_pad($student, 3, '0', STR_PAD_LEFT),
                    'ho_va_ten' => $studentNames[($student - 1) % count($studentNames)],
                    'gioi_tinh' => $student % 2 == 0 ? 'Nữ' : 'Nam',
                    'ngay_sinh' => '2005-' . str_pad(rand(1, 12), 2, '0', STR_PAD_LEFT) . '-' . str_pad(rand(1, 28), 2, '0', STR_PAD_LEFT),
                    'dia_chi' => 'Hà Tĩnh',
                    'so_dien_thoai' => '097745' . str_pad(rand(100000, 999999), 6, '0', STR_PAD_LEFT),
                    'email' => 'hs12a' . $class . '_' . $student . '@gmail.com',
                    'lop' => 'A' . $class,
                    'khoi' => '12',
                    'nam_hoc' => '2024-2025',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }
        
        // Thêm dữ liệu theo batch để tránh quá tải
        $chunks = array_chunk($students, 100);
        foreach ($chunks as $chunk) {
            DB::table('student')->insertOrIgnore($chunk);
        }
        
        // Đã thêm học sinh cho 24 lớp, mỗi lớp có 30 học sinh
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Xóa dữ liệu đã thêm
        DB::table('student')->where('ma_hoc_sinh', 'like', 'HS10A%')->delete();
        DB::table('student')->where('ma_hoc_sinh', 'like', 'HS11A%')->delete();
        DB::table('student')->where('ma_hoc_sinh', 'like', 'HS12A%')->delete();
    }
};