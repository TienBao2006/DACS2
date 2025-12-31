<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Liên kết teacher với login accounts (dựa trên username hiện có)
        $teachers = DB::table('teacher')->get();
        foreach ($teachers as $teacher) {
            // Tìm login account tương ứng dựa trên username pattern
            $loginAccount = DB::table('login')
                ->where('role', 'Teacher')
                ->where('username', $teacher->username)
                ->first();
            
            if ($loginAccount) {
                DB::table('teacher')
                    ->where('ma_giao_vien', $teacher->ma_giao_vien)
                    ->update(['login_id' => $loginAccount->id]);
            }
        }

        // Liên kết student với login accounts
        $students = DB::table('student')->get();
        foreach ($students as $student) {
            // Tìm login account tương ứng dựa trên pattern
            $loginAccount = DB::table('login')
                ->where('role', 'Student')
                ->where(function($query) use ($student) {
                    $query->where('username', 'like', '%' . $student->ma_hoc_sinh . '%')
                          ->orWhere('username', 'like', '%' . substr($student->ma_hoc_sinh, -6) . '%');
                })
                ->first();
            
            if ($loginAccount) {
                DB::table('student')
                    ->where('id', $student->id)
                    ->update(['login_id' => $loginAccount->id]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Xóa liên kết
        DB::table('teacher')->update(['login_id' => null]);
        DB::table('student')->update(['login_id' => null]);
    }
};