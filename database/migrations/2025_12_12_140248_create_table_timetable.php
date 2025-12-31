<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('timetable', function (Blueprint $table) {
            $table->id();
            $table->string('lop', 10); // Lớp học (VD: 10A1, 11B2)
            $table->string('khoi', 5); // Khối (VD: 10, 11, 12)
            $table->enum('thu', ['2', '3', '4', '5', '6', '7']); // Thứ trong tuần (2-7)
            $table->integer('tiet'); // Tiết học (1-10)
            $table->string('mon_hoc', 100); // Tên môn học
            $table->string('ma_giao_vien', 20)->nullable(); // Mã giáo viên
            $table->string('ten_giao_vien', 100)->nullable(); // Tên giáo viên
            $table->string('phong_hoc', 20)->nullable(); // Phòng học
            $table->string('nam_hoc', 20); // Năm học (VD: 2024-2025)
            $table->enum('hoc_ky', ['1', '2'])->default('1'); // Học kỳ
            $table->text('ghi_chu')->nullable(); // Ghi chú
            $table->boolean('is_active')->default(true); // Trạng thái hoạt động
            $table->timestamps();
            
            // Indexes để tối ưu truy vấn
            $table->index(['lop', 'thu', 'tiet']);
            $table->index(['ma_giao_vien', 'thu', 'tiet']);
            $table->index(['nam_hoc', 'hoc_ky']);
            
            // Unique constraint để tránh trùng lặp
            $table->unique(['lop', 'thu', 'tiet', 'nam_hoc', 'hoc_ky'], 'unique_schedule');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('timetable');
    }
};
