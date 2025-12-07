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
            $table->string('ho_ten', 100)->nullable();
            $table->enum('gioi_tinh', ['Nam', 'Nu'])->nullable();
            $table->date('ngay_sinh')->nullable();
            $table->string('cccd', 12)->nullable();
            $table->string('so_dien_thoai', 15)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('dia_chi', 200)->nullable();
            $table->text('mo_ta')->nullable();
            $table->timestamps(); // tạo created_at và updated_at
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
