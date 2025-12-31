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
        Schema::table('scores', function (Blueprint $table) {
            // Xóa các cột cũ nếu tồn tại
            if (Schema::hasColumn('scores', 'diem_mieng_2')) {
                $table->dropColumn('diem_mieng_2');
            }
            if (Schema::hasColumn('scores', 'diem_15p')) {
                $table->dropColumn('diem_15p');
            }
            if (Schema::hasColumn('scores', 'diem_Gk')) {
                $table->dropColumn('diem_Gk');
            }
            if (Schema::hasColumn('scores', 'diem_Ck')) {
                $table->dropColumn('diem_Ck');
            }
            if (Schema::hasColumn('scores', 'diem_hk')) {
                $table->dropColumn('diem_hk');
            }
            
            // Thêm các cột mới theo hệ thống điểm Việt Nam
            if (!Schema::hasColumn('scores', 'hoc_ky')) {
                $table->string('hoc_ky')->default('1');
            }
            
            // Điểm 15 phút (4 cột)
            if (!Schema::hasColumn('scores', 'diem_15phut_1')) {
                $table->float('diem_15phut_1')->nullable();
            }
            if (!Schema::hasColumn('scores', 'diem_15phut_2')) {
                $table->float('diem_15phut_2')->nullable();
            }
            if (!Schema::hasColumn('scores', 'diem_15phut_3')) {
                $table->float('diem_15phut_3')->nullable();
            }
            if (!Schema::hasColumn('scores', 'diem_15phut_4')) {
                $table->float('diem_15phut_4')->nullable();
            }
            
            // Cập nhật tên cột điểm miệng 1 nếu cần
            if (!Schema::hasColumn('scores', 'diem_mieng_2')) {
                $table->float('diem_mieng_2')->nullable();
            }
            if (!Schema::hasColumn('scores', 'diem_mieng_3')) {
                $table->float('diem_mieng_3')->nullable();
            }
            if (!Schema::hasColumn('scores', 'diem_mieng_4')) {
                $table->float('diem_mieng_4')->nullable();
            }
            
            // Điểm giữa kỳ và cuối kỳ
            if (!Schema::hasColumn('scores', 'diem_giua_ky')) {
                $table->float('diem_giua_ky')->nullable();
            }
            if (!Schema::hasColumn('scores', 'diem_cuoi_ky')) {
                $table->float('diem_cuoi_ky')->nullable();
            }
            if (!Schema::hasColumn('scores', 'diem_tong_ket')) {
                $table->float('diem_tong_ket')->nullable();
            }
            
            // Ghi chú
            if (!Schema::hasColumn('scores', 'ghi_chu')) {
                $table->text('ghi_chu')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('scores', function (Blueprint $table) {
            // Khôi phục cấu trúc cũ nếu cần
            $table->dropColumn([
                'hoc_ky',
                'diem_15phut_1', 'diem_15phut_2', 'diem_15phut_3', 'diem_15phut_4',
                'diem_mieng_2', 'diem_mieng_3', 'diem_mieng_4',
                'diem_giua_ky', 'diem_cuoi_ky', 'diem_tong_ket', 'ghi_chu'
            ]);
            
            // Thêm lại cột cũ
            $table->float('diem_15p')->nullable();
            $table->float('diem_Gk')->nullable();
            $table->float('diem_Ck')->nullable();
            $table->float('diem_hk')->nullable();
        });
    }
};