<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherClassSubject extends Model
{
    protected $table = 'teacher_class_subject';
    protected $primaryKey = 'id';

    protected $fillable = [
        'ma_giao_vien',
        'khoi',
        'lop',
        'mon_hoc',
        'nam_hoc'
    ];

    public $timestamps = true;

    // Relationships
    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'ma_giao_vien', 'ma_giao_vien');
    }

    // Scopes
    public function scopeByAcademicYear($query, $year)
    {
        return $query->where('nam_hoc', $year);
    }

    public function scopeByClass($query, $khoi, $lop)
    {
        return $query->where('khoi', $khoi)->where('lop', $lop);
    }

    public function scopeBySubject($query, $subject)
    {
        return $query->where('mon_hoc', $subject);
    }

    public function scopeByTeacher($query, $teacherId)
    {
        return $query->where('ma_giao_vien', $teacherId);
    }

    // Helper method để hiển thị tên lớp đúng cách
    public function getDisplayClassAttribute()
    {
        // Kiểm tra nếu lop đã chứa khối ở đầu
        if (preg_match('/^\d+[A-Z]/', $this->lop)) {
            // lop đã chứa khối (ví dụ: 10A1), chỉ hiển thị lop
            return $this->lop;
        } else {
            // lop chỉ chứa phần lớp (ví dụ: A1), ghép với khối
            return $this->khoi . $this->lop;
        }
    }
}