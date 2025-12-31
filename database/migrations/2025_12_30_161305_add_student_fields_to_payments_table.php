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
        Schema::table('payments', function (Blueprint $table) {
            // Chỉ thêm student_id vì các cột khác đã có trong migration trước
            if (!Schema::hasColumn('payments', 'student_id')) {
                $table->unsignedBigInteger('student_id')->nullable()->after('id');
                
                // Thêm foreign key
                $table->foreign('student_id')->references('id')->on('student')->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            if (Schema::hasColumn('payments', 'student_id')) {
                $table->dropForeign(['student_id']);
                $table->dropColumn(['student_id']);
            }
        });
    }
};
