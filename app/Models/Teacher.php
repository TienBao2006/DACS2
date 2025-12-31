<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $table = 'teacher';
    protected $primaryKey = 'ma_giao_vien';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'login_id',
        'ma_giao_vien',
        'ho_ten',
        'gioi_tinh',
        'ngay_sinh',
        'anh_dai_dien',
        'cccd',
        'so_dien_thoai',
        'email',
        'dia_chi',
        'bang_cap',
        'trinh_do_chuyen_mon',
        'to_chuyen_mon',
        'mon_day',
        'mon_kiem_nhiem',
        'nam_cong_tac',
        'kinh_nghiem',
        'chuc_vu',
        'lop_chu_nhiem',
        'mo_ta',
    ];

    // Relationships
    public function login()
    {
        return $this->belongsTo(Login::class, 'login_id');
    }

    public function classAssignments()
    {
        return $this->hasMany(TeacherClassSubject::class, 'ma_giao_vien', 'ma_giao_vien');
    }

    public function currentAssignments($academicYear = '2024-2025')
    {
        return $this->classAssignments()->where('nam_hoc', $academicYear);
    }

    /**
     * Kiểm tra giáo viên có tài khoản đăng nhập không
     */
    public function hasLoginAccount()
    {
        return !is_null($this->login_id) && $this->login()->exists();
    }

    /**
     * Lấy thông tin tài khoản đăng nhập
     */
    public function getLoginAccount()
    {
        return $this->login;
    }

    // Accessor để tính kinh nghiệm tự động
    public function getKinhNghiemAttribute($value)
    {
        // Nếu có giá trị kinh nghiệm được nhập thủ công, sử dụng giá trị đó
        if ($value !== null && $value > 0) {
            return $value;
        }

        // Nếu không có, tính dựa trên năm công tác
        if ($this->nam_cong_tac) {
            return max(0, date('Y') - $this->nam_cong_tac);
        }

        return 0;
    }

    // Accessor để format hiển thị kinh nghiệm
    public function getKinhNghiemTextAttribute()
    {
        $years = $this->kinh_nghiem;
        if ($years <= 0) {
            return 'Mới tham gia';
        }
        return $years . ' năm kinh nghiệm';
    }

    /**
     * Lấy danh sách môn học và lớp được phân công từ timetable
     */
    public function getAssignedSubjectsAndClasses($namHoc = '2024-2025', $hocKy = 1)
    {
        return \DB::table('timetable')
            ->where('ma_giao_vien', $this->ma_giao_vien)
            ->where('nam_hoc', $namHoc)
            ->where('hoc_ky', $hocKy)
            ->where('is_active', true)
            ->select('mon_hoc', 'lop', 'khoi')
            ->distinct()
            ->get()
            ->groupBy('lop')
            ->map(function($items) {
                return $items->pluck('mon_hoc')->unique()->values();
            });
    }

    /**
     * Kiểm tra giáo viên có được phân công dạy môn này cho lớp này không
     */
    public function canTeachSubject($monHoc, $lop, $namHoc = '2024-2025')
    {
        return \DB::table('timetable')
            ->where('ma_giao_vien', $this->ma_giao_vien)
            ->where('mon_hoc', $monHoc)
            ->where('lop', $lop)
            ->where('nam_hoc', $namHoc)
            ->where('is_active', true)
            ->exists();
    }

    /**
     * Lấy danh sách lớp được phân công dạy
     */
    public function getAssignedClasses($namHoc = '2024-2025', $hocKy = 1)
    {
        return \DB::table('timetable')
            ->where('ma_giao_vien', $this->ma_giao_vien)
            ->where('nam_hoc', $namHoc)
            ->where('hoc_ky', $hocKy)
            ->where('is_active', true)
            ->select('lop', 'khoi')
            ->distinct()
            ->get();
    }

    /**
     * Lấy danh sách môn học được phân công dạy
     */
    public function getAssignedSubjects($namHoc = '2024-2025', $hocKy = 1)
    {
        return \DB::table('timetable')
            ->where('ma_giao_vien', $this->ma_giao_vien)
            ->where('nam_hoc', $namHoc)
            ->where('hoc_ky', $hocKy)
            ->where('is_active', true)
            ->select('mon_hoc')
            ->distinct()
            ->pluck('mon_hoc');
    }

    /**
     * Lấy danh sách học sinh trong các lớp được phân công
     */
    public function getAssignedStudents($namHoc = '2024-2025')
    {
        $classes = $this->getAssignedClasses($namHoc);
        $classNames = $classes->pluck('lop')->toArray();
        
        return Student::whereIn('lop', $classNames)
            ->where('nam_hoc', $namHoc)
            ->get();
    }
}
