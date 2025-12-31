<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Scores extends Model
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
        'diem_mieng_1',
        'diem_mieng_2',
        'diem_mieng_3',
        'diem_mieng_4',
        'diem_15phut_1',
        'diem_15phut_2',
        'diem_15phut_3',
        'diem_15phut_4',
        'diem_giua_ky',
        'diem_cuoi_ky',
        'diem_tong_ket',
        'ghi_chu',
    ];

    protected $casts = [
        'diem_mieng_1' => 'float',
        'diem_mieng_2' => 'float',
        'diem_mieng_3' => 'float',
        'diem_mieng_4' => 'float',
        'diem_15phut_1' => 'float',
        'diem_15phut_2' => 'float',
        'diem_15phut_3' => 'float',
        'diem_15phut_4' => 'float',
        'diem_giua_ky' => 'float',
        'diem_cuoi_ky' => 'float',
        'diem_tong_ket' => 'float',
    ];

    // Relationships
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
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

    public function scopeBySubject($query, $monHoc)
    {
        return $query->where('mon_hoc', $monHoc);
    }

    public function scopeByYear($query, $namHoc)
    {
        return $query->where('nam_hoc', $namHoc);
    }

    public function scopeByClass($query, $lop)
    {
        return $query->where('lop', $lop);
    }

    // Accessors
    public function getDiemMiengAttribute()
    {
        return array_filter([
            $this->diem_mieng_1,
            $this->diem_mieng_2,
            $this->diem_mieng_3,
            $this->diem_mieng_4
        ]);
    }

    public function getDiem15pAttribute()
    {
        return array_filter([
            $this->diem_15phut_1,
            $this->diem_15phut_2,
            $this->diem_15phut_3,
            $this->diem_15phut_4
        ]);
    }

    public function getDiem1tietAttribute()
    {
        return []; // Không có cột này trong bảng hiện tại
    }

    public function getDiemHocKyAttribute()
    {
        return array_filter([
            $this->diem_giua_ky,
            $this->diem_cuoi_ky
        ]);
    }

    // Tính điểm trung bình tự động
    public function calculateAverage()
    {
        // Sử dụng điểm đã tính sẵn trong database
        if ($this->diem_tong_ket) {
            return $this->diem_tong_ket;
        }

        $diemMieng = collect($this->diem_mieng)->avg();
        $diem15p = collect($this->diem_15p)->avg();
        $diemGK = $this->diem_giua_ky;
        $diemCK = $this->diem_cuoi_ky;

        if (!$diemMieng || !$diem15p || !$diemGK || !$diemCK) {
            return null;
        }

        // Công thức tính điểm TB: (Miệng*2 + 15p + GK*2 + CK*3) / 8
        return round(($diemMieng * 2 + $diem15p + $diemGK * 2 + $diemCK * 3) / 8, 1);
    }

    // Xếp loại
    public function getClassificationAttribute()
    {
        $avg = $this->diem_tong_ket ?? $this->calculateAverage();
        
        if (!$avg) return 'Chưa có điểm';
        
        if ($avg >= 9.0) return 'Xuất sắc';
        if ($avg >= 8.0) return 'Giỏi';
        if ($avg >= 6.5) return 'Khá';
        if ($avg >= 5.0) return 'Trung bình';
        return 'Yếu';
    }

    /**
     * Boot method để set giá trị mặc định
     */
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($score) {
            // Nếu ma_giao_vien không được set, tìm từ timetable
            if (empty($score->ma_giao_vien)) {
                $score->ma_giao_vien = $score->getTeacherFromTimetable();
            }
        });
    }

    /**
     * Lấy mã giáo viên từ bảng timetable dựa trên lớp và môn học
     */
    public function getTeacherFromTimetable()
    {
        try {
            // Tìm giáo viên được phân công dạy môn này cho lớp này
            $timetable = \DB::table('timetable')
                ->where('lop', $this->lop)
                ->where('mon_hoc', $this->mon_hoc)
                ->where('nam_hoc', $this->nam_hoc ?? '2024-2025')
                ->where('is_active', true)
                ->first();

            if ($timetable && $timetable->ma_giao_vien) {
                return $timetable->ma_giao_vien;
            }

            // Nếu không tìm thấy, thử tìm theo tên môn học tương tự
            $subjectMapping = [
                'TOAN' => ['Toán', 'Toan', 'TOAN'],
                'VAN' => ['Văn', 'Van', 'Ngữ Văn', 'Ngu Van', 'VAN'],
                'ANH' => ['Anh', 'Tiếng Anh', 'Tieng Anh', 'ANH', 'English'],
                'LY' => ['Lý', 'Ly', 'Vật Lý', 'Vat Ly', 'LY', 'Physics'],
                'HOA' => ['Hóa', 'Hoa', 'Hóa Học', 'Hoa Hoc', 'HOA', 'Chemistry'],
                'SINH' => ['Sinh', 'Sinh Học', 'Sinh Hoc', 'SINH', 'Biology'],
                'SU' => ['Sử', 'Su', 'Lịch Sử', 'Lich Su', 'SU', 'History'],
                'DIA' => ['Địa', 'Dia', 'Địa Lý', 'Dia Ly', 'DIA', 'Geography'],
                'GDCD' => ['GDCD', 'Giáo dục công dân', 'Giao duc cong dan'],
                'TD' => ['TD', 'Thể Dục', 'The Duc', 'Physical Education']
            ];

            if (isset($subjectMapping[$this->mon_hoc])) {
                foreach ($subjectMapping[$this->mon_hoc] as $subjectName) {
                    $timetable = \DB::table('timetable')
                        ->where('lop', $this->lop)
                        ->where('mon_hoc', 'LIKE', "%{$subjectName}%")
                        ->where('nam_hoc', $this->nam_hoc ?? '2024-2025')
                        ->where('is_active', true)
                        ->first();

                    if ($timetable && $timetable->ma_giao_vien) {
                        return $timetable->ma_giao_vien;
                    }
                }
            }

            // Nếu vẫn không tìm thấy, sử dụng giá trị mặc định
            return 'GV001';
            
        } catch (\Exception $e) {
            // Nếu có lỗi, sử dụng giá trị mặc định
            return 'GV001';
        }
    }
}
