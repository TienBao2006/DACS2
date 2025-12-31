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
        Schema::create('teacher', function (Blueprint $table) {
            $table->string('ma_giao_vien', 10)->primary();
            $table->string('username', 50)->unique();

            // Thông tin cá nhân
            $table->string('ho_ten', 100)->nullable();
            $table->enum('gioi_tinh', ['Nam', 'Nu'])->nullable();
            $table->date('ngay_sinh')->nullable();
            $table->string('anh_dai_dien', 255)->nullable();
            $table->string('cccd', 12)->nullable();
            $table->string('so_dien_thoai', 15)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('dia_chi', 200)->nullable();
            $table->string('bang_cap', 200)->nullable();     // Đại học, Thạc sĩ...
            $table->string('trinh_do_chuyen_mon', 200)->nullable();

            // Thông tin nghề nghiệp
            $table->string('to_chuyen_mon', 100)->nullable();       // Tổ Toán, Tổ Văn,...
            $table->string('mon_day', 200)->nullable();             // Môn chính
            $table->string('mon_kiem_nhiem', 200)->nullable();      // Môn phụ
            $table->year('nam_cong_tac')->nullable();               // Năm bắt đầu làm việc
            $table->integer('kinh_nghiem')->nullable();             // số năm dạy
            $table->string('chuc_vu', 100)->nullable();             // Tổ trưởng, giáo viên...
            $table->string('lop_chu_nhiem', 50)->nullable();        // Ví dụ: 10A1

            // Mô tả thêm
            $table->text('mo_ta')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teacher');
    }
};
