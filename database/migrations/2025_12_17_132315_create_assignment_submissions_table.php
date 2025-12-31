<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('assignment_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assignment_id')->constrained('assignments')->onDelete('cascade');
            $table->foreignId('student_id')->constrained('student')->onDelete('cascade');
            $table->text('noi_dung')->nullable();
            $table->string('file_nop')->nullable();
            $table->datetime('ngay_nop')->nullable();
            $table->enum('trang_thai', ['draft', 'submitted', 'graded', 'returned'])->default('draft');
            $table->decimal('diem_so', 4, 2)->nullable();
            $table->text('nhan_xet')->nullable();
            $table->datetime('ngay_cham')->nullable();
            $table->timestamps();

            $table->unique(['assignment_id', 'student_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('assignment_submissions');
    }
};