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
        Schema::create('scores', function (Blueprint $table) {
            $table->id();

            $table->foreignId('student_id')
                ->constrained('student')
                ->cascadeOnDelete();

            $table->string('ma_giao_vien', 10);
            $table->string('mon_hoc');
            $table->string('khoi');
            $table->string('lop');
            $table->string('nam_hoc');

            $table->float('diem_mieng_1')->nullable();
            $table->float('diem_mieng_2')->nullable();
            $table->float('diem_15p')->nullable();
            $table->float('diem_Gk')->nullable();
            $table->float('diem_Ck')->nullable();
            $table->float('diem_hk')->nullable();

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
        Schema::dropIfExists('scores');
    }
};
