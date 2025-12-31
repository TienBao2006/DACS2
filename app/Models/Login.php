<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Login extends Authenticatable
{
    protected $table = 'login';

    protected $fillable = [
        'username',
        'password',
        'role',
        'is_active'
    ];

    protected $hidden = [
        'password'
    ];
    
    /**
     * Quan hệ với Teacher (dựa trên login_id)
     */
    public function teacher()
    {
        return $this->hasOne(Teacher::class, 'login_id');
    }

    /**
     * Quan hệ với Student (dựa trên login_id)
     */
    public function student()
    {
        return $this->hasOne(Student::class, 'login_id');
    }

    /**
     * Lấy thông tin profile dựa trên role
     */
    public function getProfile()
    {
        switch ($this->role) {
            case 'Teacher':
                return $this->teacher;
            case 'Student':
                return $this->student;
            default:
                return null;
        }
    }

    /**
     * Kiểm tra có profile không
     */
    public function hasProfile()
    {
        return $this->getProfile() !== null;
    }
}
