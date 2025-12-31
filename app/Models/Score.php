<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    protected $table = 'scores';

    protected $fillable = [
        'student_id',
        'ma_giao_vien',
        'mon_hoc',
        'khoi',
        'lop',
        'nam_hoc',
        'hoc_ky',
        'diem_15phut_1',
        'diem_15phut_2',
        'diem_15phut_3',
        'diem_15phut_4',
        'diem_mieng_1',
        'diem_mieng_2',
        'diem_mieng_3',
        'diem_mieng_4',
        'diem_giua_ky',
        'diem_cuoi_ky',
        'diem_tong_ket',
        'ghi_chu'
    ];

    protected $casts = [
        'diem_15phut_1' => 'float',
        'diem_15phut_2' => 'float',
        'diem_15phut_3' => 'float',
        'diem_15phut_4' => 'float',
        'diem_mieng_1' => 'float',
        'diem_mieng_2' => 'float',
        'diem_mieng_3' => 'float',
        'diem_mieng_4' => 'float',
        'diem_giua_ky' => 'float',
        'diem_cuoi_ky' => 'float',
        'diem_tong_ket' => 'float'
    ];

    // Relationships
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'ma_giao_vien', 'ma_giao_vien');
    }

    // Scopes
    public function scopeByStudent($query, $studentId)
    {
        return $query->where('student_id', $studentId);
    }

    public function scopeByTeacher($query, $teacherId)
    {
        return $query->where('ma_giao_vien', $teacherId);
    }

    public function scopeBySubject($query, $subject)
    {
        return $query->where('mon_hoc', $subject);
    }

    public function scopeByAcademicYear($query, $year, $semester = null)
    {
        $query->where('nam_hoc', $year);
        if ($semester) {
            $query->where('hoc_ky', $semester);
        }
        return $query;
    }

    // Helper methods
    public function calculateAverage()
    {
        $scores = [];
        
        // Điểm 15 phút (hệ số 1)
        if ($this->diem_15phut_1) $scores[] = $this->diem_15phut_1;
        if ($this->diem_15phut_2) $scores[] = $this->diem_15phut_2;
        if ($this->diem_15phut_3) $scores[] = $this->diem_15phut_3;
        if ($this->diem_15phut_4) $scores[] = $this->diem_15phut_4;
        
        // Điểm miệng (hệ số 1)
        if ($this->diem_mieng_1) $scores[] = $this->diem_mieng_1;
        if ($this->diem_mieng_2) $scores[] = $this->diem_mieng_2;
        if ($this->diem_mieng_3) $scores[] = $this->diem_mieng_3;
        if ($this->diem_mieng_4) $scores[] = $this->diem_mieng_4;
        
        $totalScore = array_sum($scores);
        $count = count($scores);
        
        // Điểm giữa kỳ (hệ số 2)
        if ($this->diem_giua_ky) {
            $totalScore += $this->diem_giua_ky * 2;
            $count += 2;
        }
        
        // Điểm cuối kỳ (hệ số 3)
        if ($this->diem_cuoi_ky) {
            $totalScore += $this->diem_cuoi_ky * 3;
            $count += 3;
        }
        
        return $count > 0 ? round($totalScore / $count, 2) : null;
    }
}