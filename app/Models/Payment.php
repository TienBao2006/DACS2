<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'student_id', 'order_id', 'title', 'description', 'amount', 
        'due_date', 'payment_type', 'status'
    ];

    protected $casts = [
        'due_date' => 'date',
        'amount' => 'integer'
    ];

    /**
     * Relationship với Student
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Scope để lấy payments của học sinh
     */
    public function scopeForStudent($query, $studentId)
    {
        return $query->where('student_id', $studentId);
    }

    /**
     * Scope để lấy payments chưa thanh toán
     */
    public function scopePending($query)
    {
        return $query->where('status', 'PENDING');
    }

    /**
     * Scope để lấy payments đã thanh toán
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'COMPLETED');
    }

    /**
     * Kiểm tra payment đã quá hạn chưa
     */
    public function isOverdue()
    {
        return $this->due_date && $this->due_date->isPast() && $this->status === 'PENDING';
    }

    /**
     * Kiểm tra payment sắp hết hạn (trong 7 ngày)
     */
    public function isDueSoon()
    {
        return $this->due_date && 
               $this->due_date->isFuture() && 
               $this->due_date->diffInDays() <= 7 && 
               $this->status === 'PENDING';
    }

    /**
     * Format số tiền
     */
    public function getFormattedAmountAttribute()
    {
        return number_format($this->amount) . ' VNĐ';
    }
}
