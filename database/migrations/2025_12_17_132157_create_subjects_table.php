<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->string('ma_mon_hoc', 10)->unique();
            $table->string('ten_mon_hoc', 100);
            $table->string('khoi', 5); // 10, 11, 12
            $table->integer('so_tiet')->default(0);
            $table->decimal('he_so', 3, 1)->default(1.0);
            $table->text('mo_ta')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Insert default subjects
        DB::table('subjects')->insert([
            ['ma_mon_hoc' => 'TOAN', 'ten_mon_hoc' => 'Toán', 'khoi' => '10', 'so_tiet' => 4, 'he_so' => 2.0],
            ['ma_mon_hoc' => 'VAN', 'ten_mon_hoc' => 'Ngữ Văn', 'khoi' => '10', 'so_tiet' => 4, 'he_so' => 2.0],
            ['ma_mon_hoc' => 'ANH', 'ten_mon_hoc' => 'Tiếng Anh', 'khoi' => '10', 'so_tiet' => 3, 'he_so' => 2.0],
            ['ma_mon_hoc' => 'LY', 'ten_mon_hoc' => 'Vật Lý', 'khoi' => '10', 'so_tiet' => 2, 'he_so' => 1.0],
            ['ma_mon_hoc' => 'HOA', 'ten_mon_hoc' => 'Hóa Học', 'khoi' => '10', 'so_tiet' => 2, 'he_so' => 1.0],
            ['ma_mon_hoc' => 'SINH', 'ten_mon_hoc' => 'Sinh Học', 'khoi' => '10', 'so_tiet' => 2, 'he_so' => 1.0],
            ['ma_mon_hoc' => 'SU', 'ten_mon_hoc' => 'Lịch Sử', 'khoi' => '10', 'so_tiet' => 1, 'he_so' => 1.0],
            ['ma_mon_hoc' => 'DIA', 'ten_mon_hoc' => 'Địa Lý', 'khoi' => '10', 'so_tiet' => 1, 'he_so' => 1.0],
            ['ma_mon_hoc' => 'GDCD', 'ten_mon_hoc' => 'GDCD', 'khoi' => '10', 'so_tiet' => 1, 'he_so' => 1.0],
            ['ma_mon_hoc' => 'TD', 'ten_mon_hoc' => 'Thể Dục', 'khoi' => '10', 'so_tiet' => 1, 'he_so' => 1.0],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('subjects');
    }
};