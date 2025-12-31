<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Assignment extends Model
{
    protected $table = 'assignments';

    protected $fillable = [
        'ma_giao_vien',
        'lop',
        'mon_hoc',
        'tieu_de',
        'mo_ta',
        'loai_bai_tap',
        'ngay_giao',
        'han_nop',
        'trang_thai',
        'file_dinh_kem',
        'ghi_chu'
    ];

    protected $casts = [
        'ngay_giao' => 'date',
        'han_nop' => 'date'
    ];

    // Relationships
    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'ma_giao_vien', 'ma_giao_vien');
    }

    public function submissions()
    {
        return $this->hasMany(AssignmentSubmission::class, 'assignment_id');
    }

    // Scopes
    public function scopeByClass($query, $lop)
    {
        return $query->where('lop', $lop);
    }

    public function scopeBySubject($query, $monHoc)
    {
        return $query->where('mon_hoc', $monHoc);
    }

    public function scopeActive($query)
    {
        return $query->where('trang_thai', 'active');
    }

    public function scopeUpcoming($query)
    {
        return $query->where('han_nop', '>=', Carbon::now());
    }

    public function scopeOverdue($query)
    {
        return $query->where('han_nop', '<', Carbon::now())
                    ->where('trang_thai', 'active');
    }

    // Accessors
    public function getStatusTextAttribute()
    {
        $statuses = [
            'active' => 'Đang mở',
            'closed' => 'Đã đóng',
            'draft' => 'Nháp'
        ];
        
        return $statuses[$this->trang_thai] ?? 'Không xác định';
    }

    public function getTypeTextAttribute()
    {
        $types = [
            'homework' => 'Bài tập về nhà',
            'test' => 'Kiểm tra',
            'essay' => 'Tiểu luận',
            'project' => 'Dự án',
            'lab' => 'Thí nghiệm'
        ];
        
        return $types[$this->loai_bai_tap] ?? 'Khác';
    }

    public function getIsOverdueAttribute()
    {
        return $this->han_nop < Carbon::now() && $this->trang_thai === 'active';
    }

    public function getDaysRemainingAttribute()
    {
        if ($this->han_nop < Carbon::now()) {
            return 0;
        }
        
        return Carbon::now()->diffInDays($this->han_nop);
    }
}