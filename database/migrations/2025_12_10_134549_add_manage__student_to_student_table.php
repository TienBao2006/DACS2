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
        Schema::create('student', function (Blueprint $table) {
            $table->bigIncrements('id');
            // Thông tin học sinh
            $table->string('ma_hoc_sinh')->unique();   // Mã HS tự sinh hoặc nhập
            $table->string('ho_va_ten');
            $table->date('ngay_sinh');
            $table->string('gioi_tinh');
            $table->string('dia_chi')->nullable();

            // Liên hệ
            $table->string('so_dien_thoai')->nullable();
            $table->string('email')->nullable();

            // Lớp học
            $table->string('khoi');      // 6,7,8,9
            $table->string('lop');       // 6A, 6B...
            $table->string('nam_hoc');   // 2024–2025

            // Phụ huynh
            $table->string('ten_cha')->nullable();
            $table->string('ten_me')->nullable();
            $table->string('sdt_phu_huynh')->nullable();

            // Thông tin khác
            $table->string('trang_thai')->default('Đang học'); // Đang học / Nghỉ học / Bảo lưu
            $table->text('ghi_chu')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student', function (Blueprint $table) {
            //
        });
    }
};
