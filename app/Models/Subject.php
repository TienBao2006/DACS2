<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $table = 'subjects';

    protected $fillable = [
        'ma_mon_hoc',
        'ten_mon_hoc',
        'khoi',
        'so_tiet',
        'he_so',
        'mo_ta',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'so_tiet' => 'integer',
        'he_so' => 'float'
    ];

    // Relationship với TeacherClassSubject
    public function teacherAssignments()
    {
        return $this->hasMany(TeacherClassSubject::class, 'mon_hoc', 'ma_mon_hoc');
    }

    // Relationship với Scores
    public function scores()
    {
        return $this->hasMany(Score::class, 'mon_hoc', 'ma_mon_hoc');
    }

    // Scope để lọc theo khối
    public function scopeByGrade($query, $khoi)
    {
        return $query->where('khoi', $khoi);
    }

    // Scope để lọc môn học đang hoạt động
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}