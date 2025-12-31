<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            $table->string('ma_giao_vien', 10);
            $table->string('lop', 10);
            $table->string('mon_hoc', 10);
            $table->string('tieu_de', 255);
            $table->text('mo_ta')->nullable();
            $table->enum('loai_bai_tap', ['homework', 'test', 'essay', 'project', 'lab'])->default('homework');
            $table->date('ngay_giao');
            $table->date('han_nop');
            $table->enum('trang_thai', ['active', 'closed', 'draft'])->default('active');
            $table->string('file_dinh_kem')->nullable();
            $table->text('ghi_chu')->nullable();
            $table->timestamps();

            $table->foreign('ma_giao_vien')->references('ma_giao_vien')->on('teacher')->onDelete('cascade');
        });

        // Sample assignments sẽ được thêm sau khi có giáo viên
    }

    public function down()
    {
        Schema::dropIfExists('assignments');
    }
};