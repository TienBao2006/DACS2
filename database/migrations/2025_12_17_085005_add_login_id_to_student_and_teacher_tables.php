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
        // Kiểm tra và thêm login_id vào bảng student nếu chưa có
        if (!Schema::hasColumn('student', 'login_id')) {
            Schema::table('student', function (Blueprint $table) {
                $table->unsignedBigInteger('login_id')->nullable()->after('id');
                $table->foreign('login_id')->references('id')->on('login')->onDelete('cascade');
                $table->index('login_id');
            });
        }

        // Thêm login_id vào bảng teacher (sau ma_giao_vien vì không có id)
        Schema::table('teacher', function (Blueprint $table) {
            $table->unsignedBigInteger('login_id')->nullable()->after('ma_giao_vien');
            $table->foreign('login_id')->references('id')->on('login')->onDelete('cascade');
            $table->index('login_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Chỉ xóa login_id khỏi student nếu nó được tạo bởi migration này
        if (Schema::hasColumn('student', 'login_id')) {
            Schema::table('student', function (Blueprint $table) {
                $table->dropForeign(['login_id']);
                $table->dropIndex(['login_id']);
                $table->dropColumn('login_id');
            });
        }

        Schema::table('teacher', function (Blueprint $table) {
            $table->dropForeign(['login_id']);
            $table->dropIndex(['login_id']);
            $table->dropColumn('login_id');
        });
    }
};