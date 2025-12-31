<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssignmentSubmission extends Model
{
    protected $table = 'assignment_submissions';

    protected $fillable = [
        'assignment_id',
        'student_id',
        'noi_dung',
        'file_nop',
        'ngay_nop',
        'trang_thai',
        'diem_so',
        'nhan_xet',
        'ngay_cham'
    ];

    protected $casts = [
        'ngay_nop' => 'datetime',
        'ngay_cham' => 'datetime',
        'diem_so' => 'float'
    ];

    // Relationships
    public function assignment()
    {
        return $this->belongsTo(Assignment::class, 'assignment_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    // Scopes
    public function scopeByStudent($query, $studentId)
    {
        return $query->where('student_id', $studentId);
    }

    public function scopeSubmitted($query)
    {
        return $query->where('trang_thai', 'submitted');
    }

    public function scopeGraded($query)
    {
        return $query->where('trang_thai', 'graded');
    }

    // Accessors
    public function getStatusTextAttribute()
    {
        $statuses = [
            'draft' => 'Nháp',
            'submitted' => 'Đã nộp',
            'graded' => 'Đã chấm điểm',
            'returned' => 'Trả lại'
        ];
        
        return $statuses[$this->trang_thai] ?? 'Không xác định';
    }

    public function getIsLateAttribute()
    {
        return $this->ngay_nop > $this->assignment->han_nop;
    }
}