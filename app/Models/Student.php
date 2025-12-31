<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Login;
use App\Models\Scores;
use App\Models\AssignmentSubmission;
use App\Models\Assignment;
use App\Models\Timetable;

class Student extends Model
{
    protected $table = 'student';
    protected $primaryKey = 'id';

    // Nếu cần bảo vệ cột id, Laravel tự xử lý nên KHÔNG cho vào fillable
    protected $fillable = [
        'login_id',
        'ma_hoc_sinh',
        'ho_va_ten',
        'ngay_sinh',
        'gioi_tinh',
        'dia_chi',
        'so_dien_thoai',
        'email',
        'khoi',
        'lop',
        'nam_hoc',
        'ten_cha',
        'ten_me',
        'sdt_phu_huynh',
        'trang_thai',
        'ghi_chu',
        'anh_dai_dien'
    ];

    // Laravel mặc định có created_at, updated_at
    public $timestamps = true;

    /**
     * Quan hệ với bảng Login
     */
    public function login()
    {
        return $this->belongsTo(Login::class, 'login_id');
    }

    /**
     * Kiểm tra học sinh có tài khoản đăng nhập không
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

    /**
     * Quan hệ với bảng Scores
     */
    public function scores()
    {
        return $this->hasMany(Scores::class, 'student_id');
    }

    /**
     * Quan hệ với bảng Assignment Submissions
     */
    public function assignmentSubmissions()
    {
        return $this->hasMany(AssignmentSubmission::class, 'student_id');
    }

    /**
     * Quan hệ với bảng Payments
     */
    public function payments()
    {
        return $this->hasMany(Payment::class, 'student_id');
    }

    /**
     * Lấy điểm theo môn học
     */
    public function getScoresBySubject($monHoc, $namHoc = '2024-2025')
    {
        return $this->scores()
            ->where('mon_hoc', $monHoc)
            ->where('nam_hoc', $namHoc)
            ->first();
    }

    /**
     * Lấy tất cả điểm của năm học
     */
    public function getYearScores($namHoc = '2024-2025')
    {
        return $this->scores()
            ->where('nam_hoc', $namHoc)
            ->get();
    }

    /**
     * Lấy thời khóa biểu của học sinh
     */
    public function getTimetable($namHoc = '2024-2025', $hocKy = 1)
    {
        return \DB::table('timetable')
            ->where('lop', $this->lop)
            ->where('nam_hoc', $namHoc)
            ->where('hoc_ky', $hocKy)
            ->where('is_active', true)
            ->orderBy('thu')
            ->orderBy('tiet')
            ->get();
    }

    /**
     * Lấy thời khóa biểu theo ngày
     */
    public function getTimetableByDay($thu, $namHoc = '2024-2025', $hocKy = 1)
    {
        return \DB::table('timetable')
            ->where('lop', $this->lop)
            ->where('thu', $thu)
            ->where('nam_hoc', $namHoc)
            ->where('hoc_ky', $hocKy)
            ->where('is_active', true)
            ->orderBy('tiet')
            ->get();
    }

    /**
     * Kiểm tra có tiết học vào thời gian cụ thể không
     */
    public function hasClassAt($thu, $tiet, $namHoc = '2024-2025', $hocKy = 1)
    {
        return \DB::table('timetable')
            ->where('lop', $this->lop)
            ->where('thu', $thu)
            ->where('tiet', $tiet)
            ->where('nam_hoc', $namHoc)
            ->where('hoc_ky', $hocKy)
            ->where('is_active', true)
            ->exists();
    }

    /**
     * Lấy thống kê môn học trong thời khóa biểu
     */
    public function getTimetableStats($namHoc = '2024-2025', $hocKy = 1)
    {
        $timetable = $this->getTimetable($namHoc, $hocKy);
        $stats = [];
        
        foreach ($timetable as $item) {
            $subjectName = $this->getSubjectDisplayName($item->mon_hoc);
            if (!isset($stats[$subjectName])) {
                $stats[$subjectName] = [
                    'count' => 0,
                    'code' => $item->mon_hoc,
                    'teacher' => $item->ten_giao_vien
                ];
            }
            $stats[$subjectName]['count']++;
        }
        
        // Sắp xếp theo số tiết giảm dần
        uasort($stats, function($a, $b) {
            return $b['count'] - $a['count'];
        });
        
        return $stats;
    }

    /**
     * Lấy tên hiển thị của môn học
     */
    public function getSubjectDisplayName($subjectCode)
    {
        $subjectNames = [
            'TOAN' => 'Toán',
            'VAN' => 'Ngữ Văn',
            'ANH' => 'Tiếng Anh',
            'LY' => 'Vật Lý',
            'HOA' => 'Hóa Học',
            'SINH' => 'Sinh Học',
            'SU' => 'Lịch Sử',
            'DIA' => 'Địa Lý',
            'GDCD' => 'GDCD',
            'TD' => 'Thể Dục'
        ];

        return $subjectNames[$subjectCode] ?? $subjectCode;
    }

    /**
     * Tính điểm trung bình năm học
     */
    public function getAverageScore($namHoc = '2024-2025')
    {
        $scores = $this->getYearScores($namHoc);
        
        if ($scores->isEmpty()) {
            return 0;
        }

        $totalScore = 0;
        $totalCredits = 0;

        foreach ($scores as $score) {
            $avgScore = $score->diem_tong_ket ?? $score->calculateAverage();
            if ($avgScore) {
                // Lấy hệ số môn học (mặc định là 1)
                $hesoMonHoc = $this->getSubjectCredits($score->mon_hoc);
                $totalScore += $avgScore * $hesoMonHoc;
                $totalCredits += $hesoMonHoc;
            }
        }

        return $totalCredits > 0 ? round($totalScore / $totalCredits, 1) : 0;
    }

    /**
     * Tính điểm trung bình chung (alias for getAverageScore)
     */
    public function calculateOverallAverage($namHoc = '2024-2025')
    {
        return $this->getAverageScore($namHoc);
    }

    /**
     * Lấy hệ số môn học
     */
    private function getSubjectCredits($monHoc)
    {
        $credits = [
            'TOAN' => 2, 'VAN' => 2, 'ANH' => 2,
            'LY' => 1, 'HOA' => 1, 'SINH' => 1,
            'SU' => 1, 'DIA' => 1, 'GDCD' => 1, 'TD' => 1
        ];

        return $credits[$monHoc] ?? 1;
    }

    /**
     * Lấy bài tập theo lớp
     */
    public function getAssignments()
    {
        return Assignment::where('lop', $this->lop)
            ->with(['teacher', 'submissions' => function($query) {
                $query->where('student_id', $this->id);
            }])
            ->orderBy('han_nop', 'asc')
            ->get();
    }



    /**
     * Tạo điểm mẫu cho học sinh nếu chưa có
     */
    public function createSampleScores($namHoc = '2024-2025')
    {
        // Kiểm tra xem đã có điểm chưa
        $existingScores = $this->scores()->where('nam_hoc', $namHoc)->count();
        
        if ($existingScores > 0) {
            return false; // Đã có điểm rồi
        }

        // Danh sách môn học
        $subjects = [
            'TOAN' => 'Toán',
            'VAN' => 'Ngữ Văn', 
            'ANH' => 'Tiếng Anh',
            'LY' => 'Vật Lý',
            'HOA' => 'Hóa Học',
            'SINH' => 'Sinh Học',
            'SU' => 'Lịch Sử',
            'DIA' => 'Địa Lý',
            'GDCD' => 'GDCD',
            'TD' => 'Thể Dục'
        ];

        foreach ($subjects as $subjectCode => $subjectName) {
            // Tạo điểm ngẫu nhiên
            $diemMieng1 = round(rand(70, 100) / 10, 1);
            $diemMieng2 = round(rand(70, 100) / 10, 1);
            $diemMieng3 = round(rand(70, 100) / 10, 1);
            $diem15p1 = round(rand(70, 100) / 10, 1);
            $diem15p2 = round(rand(70, 100) / 10, 1);
            $diemGk = round(rand(70, 100) / 10, 1);
            $diemCk = round(rand(70, 100) / 10, 1);
            
            // Tính điểm tổng kết
            $avgMieng = ($diemMieng1 + $diemMieng2 + $diemMieng3) / 3;
            $avg15p = ($diem15p1 + $diem15p2) / 2;
            $diemTongKet = round(($avgMieng * 2 + $avg15p + $diemGk * 2 + $diemCk * 3) / 8, 1);

            // Tạo bản ghi điểm (ma_giao_vien sẽ được set tự động trong model)
            Scores::create([
                'student_id' => $this->id,
                'mon_hoc' => $subjectCode,
                'khoi' => $this->khoi,
                'lop' => $this->lop,
                'nam_hoc' => $namHoc,
                'hoc_ky' => 'HK1',
                'diem_mieng_1' => $diemMieng1,
                'diem_mieng_2' => $diemMieng2,
                'diem_mieng_3' => $diemMieng3,
                'diem_15phut_1' => $diem15p1,
                'diem_15phut_2' => $diem15p2,
                'diem_giua_ky' => $diemGk,
                'diem_cuoi_ky' => $diemCk,
                'diem_tong_ket' => $diemTongKet,
            ]);
        }

        return true; // Đã tạo điểm mẫu
    }

    /**
     * Get profile image URL.
     */
    public function getProfileImageUrlAttribute()
    {
        if ($this->anh_dai_dien && file_exists(public_path('uploads/student/' . $this->anh_dai_dien))) {
            return asset('uploads/student/' . $this->anh_dai_dien);
        }
        
        return asset('images/default-avatar.png');
    }

    /**
     * Get avatar URL (alias for profile image)
     */
    public function getAvatarUrlAttribute()
    {
        return $this->getProfileImageUrlAttribute();
    }
}
