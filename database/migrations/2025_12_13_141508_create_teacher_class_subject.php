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
        Schema::create('teacher_class_subject', function (Blueprint $table) {
            $table->id();
            $table->string('ma_giao_vien', 10);
            $table->string('khoi');      // 6,7,8,9
            $table->string('lop');       // 6A1, 7B2
            $table->string('mon_hoc');   // Toán, Văn
            $table->string('nam_hoc');   // 2024-2025

            $table->timestamps();

            $table->foreign('ma_giao_vien')
                ->references('ma_giao_vien')
                ->on('teacher')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teacher_class_subject');
    }
};
