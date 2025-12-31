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
        Schema::table('timetable', function (Blueprint $table) {
            // Thay đổi cột thu từ có thể là CHAR(1) thành INT
            $table->integer('thu')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('timetable', function (Blueprint $table) {
            $table->string('thu', 1)->change();
        });
    }
};