<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Timetable extends Model
{
    protected $table = 'timetable';

    protected $fillable = [
        'lop',
        'khoi',
        'thu',
        'tiet',
        'mon_hoc',
        'ma_giao_vien',
        'ten_giao_vien',
        'phong_hoc',
        'nam_hoc',
        'hoc_ky',
        'ghi_chu',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'tiet' => 'integer'
    ];

    // Relationship với Teacher
    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'ma_giao_vien', 'ma_giao_vien');
    }

    // Scope để lọc theo lớp
    public function scopeByClass($query, $lop)
    {
        return $query->where('lop', $lop);
    }

    // Scope để lọc theo giáo viên
    public function scopeByTeacher($query, $maGiaoVien)
    {
        return $query->where('ma_giao_vien', $maGiaoVien);
    }

    // Scope để lọc theo năm học và học kỳ
    public function scopeByAcademicYear($query, $namHoc, $hocKy = null)
    {
        $query->where('nam_hoc', $namHoc);
        if ($hocKy) {
            $query->where('hoc_ky', $hocKy);
        }
        return $query;
    }

    // Lấy tên thứ
    public function getThuNameAttribute()
    {
        $days = [
            '2' => 'Thứ Hai',
            '3' => 'Thứ Ba', 
            '4' => 'Thứ Tư',
            '5' => 'Thứ Năm',
            '6' => 'Thứ Sáu',
            '7' => 'Thứ Bảy'
        ];
        
        return $days[$this->thu] ?? '';
    }

    // Lấy giờ học
    public function getTietTimeAttribute()
    {
        $times = [
            1 => '7:00 - 7:45',
            2 => '7:45 - 8:30',
            3 => '8:30 - 9:15',
            4 => '9:30 - 10:15',
            5 => '10:15 - 11:00',
            6 => '13:00 - 13:45',
            7 => '13:45 - 14:30',
            8 => '14:30 - 15:15',
            9 => '15:30 - 16:15',
            10 => '16:15 - 17:00'
        ];
        
        return $times[$this->tiet] ?? '';
    }
}
