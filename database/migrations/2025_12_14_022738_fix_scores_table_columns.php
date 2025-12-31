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
            // Thêm các cột còn thiếu nếu chưa có
            $columnsToAdd = [
                'hoc_ky' => 'string',
                'diem_15phut_1' => 'float',
                'diem_15phut_2' => 'float', 
                'diem_15phut_3' => 'float',
                'diem_15phut_4' => 'float',
                'diem_mieng_2' => 'float',
                'diem_mieng_3' => 'float',
                'diem_mieng_4' => 'float',
                'diem_giua_ky' => 'float',
                'diem_cuoi_ky' => 'float',
                'diem_tong_ket' => 'float',
                'ghi_chu' => 'text'
            ];

            foreach ($columnsToAdd as $columnName => $columnType) {
                if (!Schema::hasColumn('scores', $columnName)) {
                    if ($columnType === 'string') {
                        $table->string($columnName)->nullable()->default('HK1');
                    } elseif ($columnType === 'float') {
                        $table->float($columnName)->nullable();
                    } elseif ($columnType === 'text') {
                        $table->text($columnName)->nullable();
                    }
                }
            }

            // Đảm bảo cột diem_mieng_1 tồn tại (có thể đã có từ migration cũ)
            if (!Schema::hasColumn('scores', 'diem_mieng_1')) {
                $table->float('diem_mieng_1')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('scores', function (Blueprint $table) {
            $columnsToRemove = [
                'hoc_ky',
                'diem_15phut_1', 'diem_15phut_2', 'diem_15phut_3', 'diem_15phut_4',
                'diem_mieng_2', 'diem_mieng_3', 'diem_mieng_4',
                'diem_giua_ky', 'diem_cuoi_ky', 'diem_tong_ket', 'ghi_chu'
            ];

            foreach ($columnsToRemove as $column) {
                if (Schema::hasColumn('scores', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};