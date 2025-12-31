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
        // Cập nhật môn kiêm nhiệm cho các giáo viên đã có
        $teacherConcurrentSubjects = [
            // Giáo viên Toán có thể kiêm nhiệm Tin học
            'GV001' => 'Tin học',
            'GV002' => 'Tin học', 
            'GV021' => 'Tin học',
            
            // Giáo viên Ngữ văn có thể kiêm nhiệm Lịch sử, GDCD
            'GV003' => 'Lịch sử',
            'GV004' => 'GDCD',
            'GV022' => 'Lịch sử',
            
            // Giáo viên Tiếng Anh có thể kiêm nhiệm môn khác
            'GV005' => 'GDCD',
            'GV006' => 'Hoạt động trải nghiệm',
            'GV023' => 'GDCD',
            
            // Giáo viên Vật lý có thể kiêm nhiệm Toán, Tin học
            'GV007' => 'Toán',
            'GV024' => 'Tin học',
            
            // Giáo viên Hóa học có thể kiêm nhiệm Sinh học
            'GV008' => 'Sinh học',
            'GV025' => 'Sinh học',
            
            // Giáo viên Sinh học có thể kiêm nhiệm Hóa học
            'GV009' => 'Hóa học',
            
            // Giáo viên Lịch sử có thể kiêm nhiệm Địa lý, GDCD
            'GV010' => 'Địa lý',
            
            // Giáo viên Địa lý có thể kiêm nhiệm Lịch sử
            'GV011' => 'Lịch sử',
            
            // Giáo viên GDCD có thể kiêm nhiệm Giáo dục kinh tế và pháp luật
            'GV012' => 'Giáo dục kinh tế và pháp luật',
            
            // Giáo viên Tin học có thể kiêm nhiệm Toán
            'GV013' => 'Toán',
            
            // Giáo viên Thể dục có thể kiêm nhiệm Giáo dục quốc phòng
            'GV014' => 'Giáo dục quốc phòng',
            
            // Giáo viên Công nghệ có thể kiêm nhiệm Tin học
            'GV015' => 'Tin học',
            
            // Giáo viên Âm nhạc có thể kiêm nhiệm Mỹ thuật
            'GV016' => 'Mỹ thuật',
            
            // Giáo viên Mỹ thuật có thể kiêm nhiệm Âm nhạc
            'GV017' => 'Âm nhạc',
            
            // Giáo viên Hoạt động trải nghiệm có thể kiêm nhiệm GDCD
            'GV018' => 'GDCD',
            
            // Giáo viên GDQP có thể kiêm nhiệm Thể dục
            'GV019' => 'Thể dục',
            
            // Giáo viên Giáo dục kinh tế và pháp luật có thể kiêm nhiệm GDCD
            'GV020' => 'GDCD',
        ];

        // Cập nhật môn kiêm nhiệm cho từng giáo viên
        foreach ($teacherConcurrentSubjects as $maGiaoVien => $monKiemNhiem) {
            DB::table('teacher')
                ->where('ma_giao_vien', $maGiaoVien)
                ->update([
                    'mon_kiem_nhiem' => $monKiemNhiem,
                    'updated_at' => now()
                ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Xóa môn kiêm nhiệm của tất cả giáo viên
        DB::table('teacher')->update([
            'mon_kiem_nhiem' => null,
            'updated_at' => now()
        ]);
    }
};