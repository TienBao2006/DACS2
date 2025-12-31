<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\TeacherClassSubject;
use App\Models\Score;
use App\Models\Timetable;


class PageTeacher extends Controller
{
    public function Page(Request $request)
    {
        $user = Auth::user();
        $teacher = $user->teacher;
        
        if (!$teacher) {
            return redirect()->route('login.form')->with('error', 'Không tìm thấy thông tin giáo viên');
        }

        $academicYear = $request->get('nam_hoc', '2024-2025');
        
        // Lấy thống kê từ cơ sở dữ liệu
        $statistics = $this->getDashboardStatistics($teacher, $academicYear);
        
        // Lấy hoạt động gần đây
        $recentActivities = $this->getRecentActivities($teacher, $academicYear);
        
        // Lấy thông tin lớp học được phân công
        $assignedClasses = $this->getAssignedClasses($teacher, $academicYear);
        
        // Lấy thời khóa biểu hôm nay
        $todaySchedule = $this->getTodaySchedule($teacher, $academicYear);
        
        return view('TeacherPage.dashboard', compact(
            'teacher', 
            'statistics', 
            'recentActivities', 
            'assignedClasses', 
            'todaySchedule',
            'academicYear'
        ));
    }

    private function getDashboardStatistics($teacher, $academicYear)
    {
        // Lấy danh sách lớp được phân công
        $assignments = TeacherClassSubject::where('ma_giao_vien', $teacher->ma_giao_vien)
            ->where('nam_hoc', $academicYear)
            ->get();

        // Tính tổng số học sinh
        $totalStudents = 0;
        $classNames = [];
        
        foreach ($assignments as $assignment) {
            $className = $assignment->khoi . $assignment->lop;
            if (!in_array($className, $classNames)) {
                $classNames[] = $className;
                $studentCount = Student::where('lop', $className)->count();
                $totalStudents += $studentCount;
            }
        }

        // Tính số môn học
        $totalSubjects = $assignments->pluck('mon_hoc')->unique()->count();
        
        // Tính số lớp học
        $totalClasses = count($classNames);
        
        // Tính tỷ lệ đạt (dựa trên điểm số đã nhập)
        $passRate = $this->calculatePassRate($teacher, $academicYear);
        
        // Đánh giá trung bình (giả lập - có thể tính từ feedback)
        $averageRating = 4.8;

        return [
            'total_students' => $totalStudents,
            'total_classes' => $totalClasses,
            'total_subjects' => $totalSubjects,
            'pass_rate' => $passRate,
            'average_rating' => $averageRating
        ];
    }

    private function calculatePassRate($teacher, $academicYear)
    {
        // Lấy tất cả điểm do giáo viên này nhập
        $scores = Score::where('ma_giao_vien', $teacher->ma_giao_vien)
            ->where('nam_hoc', $academicYear)
            ->whereNotNull('diem_tong_ket')
            ->get();

        if ($scores->count() == 0) {
            return 0;
        }

        $passedCount = $scores->where('diem_tong_ket', '>=', 5.0)->count();
        return round(($passedCount / $scores->count()) * 100, 1);
    }

    private function getRecentActivities($teacher, $academicYear)
    {
        $activities = [];

        // Hoạt động nhập điểm gần đây
        $recentScores = Score::where('ma_giao_vien', $teacher->ma_giao_vien)
            ->where('nam_hoc', $academicYear)
            ->orderBy('updated_at', 'desc')
            ->limit(3)
            ->get();

        foreach ($recentScores as $score) {
            $student = Student::find($score->student_id);
            if ($student) {
                $activities[] = [
                    'type' => 'score',
                    'icon' => 'fas fa-plus',
                    'color' => '#28a745',
                    'title' => 'Đã nhập điểm ' . $score->mon_hoc . ' cho ' . $student->ho_va_ten,
                    'time' => $score->updated_at->diffForHumans(),
                    'date' => $score->updated_at
                ];
            }
        }

        // Hoạt động cập nhật thông tin
        $activities[] = [
            'type' => 'profile',
            'icon' => 'fas fa-edit',
            'color' => '#007bff',
            'title' => 'Cập nhật thông tin cá nhân',
            'time' => $teacher->updated_at->diffForHumans(),
            'date' => $teacher->updated_at
        ];

        // Sắp xếp theo thời gian
        usort($activities, function($a, $b) {
            return $b['date'] <=> $a['date'];
        });

        return array_slice($activities, 0, 5);
    }

    private function getAssignedClasses($teacher, $academicYear)
    {
        $assignments = TeacherClassSubject::where('ma_giao_vien', $teacher->ma_giao_vien)
            ->where('nam_hoc', $academicYear)
            ->get();

        $classes = [];
        foreach ($assignments as $assignment) {
            $className = $assignment->khoi . $assignment->lop;
            if (!isset($classes[$className])) {
                $studentCount = Student::where('lop', $className)->count();
                $classes[$className] = [
                    'name' => $className,
                    'khoi' => $assignment->khoi,
                    'lop' => $assignment->lop,
                    'student_count' => $studentCount,
                    'subjects' => []
                ];
            }
            $classes[$className]['subjects'][] = $assignment->mon_hoc;
        }

        return array_values($classes);
    }

    private function getTodaySchedule($teacher, $academicYear)
    {
        $today = date('N') + 1; // Chuyển đổi từ ISO (1=Monday) sang format database (2=Monday)
        
        $schedule = \App\Models\Timetable::where('ma_giao_vien', $teacher->ma_giao_vien)
            ->where('nam_hoc', $academicYear)
            ->where('thu', $today)
            ->orderBy('tiet')
            ->get();

        return $schedule;
    }
    public function profile(Request $require)
    {
        $user = Auth::user();
        $teacher = $user->teacher;

        if (!$teacher) {
            return redirect()->route('teacher.dashboard')->with('error', 'Không tìm thấy thông tin giáo viên');
        }

        $account = $user; // Login account
        return view('TeacherPage.Thongtincanhan', compact('teacher', 'account'));
    }
    public function update(Request $request, $ma_giao_vien)
    {
        // 1. Validate dữ liệu
        $request->validate([
            'username'               => 'required|string|max:255',
            'ho_ten'                 => 'required|string|max:255',
            'gioi_tinh'              => 'required|string',
            'ngay_sinh'              => 'required|date',
            'cccd'                   => 'nullable|string|max:20',
            'so_dien_thoai'          => 'required|string|max:15',
            'email'                  => 'required|email',
            'dia_chi'                => 'nullable|string',
            'bang_cap'               => 'nullable|string',
            'trinh_do_chuyen_mon'    => 'nullable|string',
            'to_chuyen_mon'          => 'nullable|string',
            'mon_day'                => 'nullable|string',
            'mon_kiem_nhiem'         => 'nullable|string',
            'nam_cong_tac'           => 'nullable|numeric',
            'kinh_nghiem'            => 'nullable|string',
            'chuc_vu'                => 'nullable|string',
            'lop_chu_nhiem'          => 'nullable|string',
            'mo_ta'                  => 'nullable|string',

            // ảnh
            'anh_dai_dien' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // 2. Lấy teacher theo mã giáo viên
        $teacher = Teacher::findOrFail($ma_giao_vien);

        // 3. Update tất cả field
        $teacher->ho_ten                 = $request->ho_ten;
        $teacher->gioi_tinh              = $request->gioi_tinh;
        $teacher->ngay_sinh              = $request->ngay_sinh;
        $teacher->cccd                   = $request->cccd;
        $teacher->so_dien_thoai          = $request->so_dien_thoai;
        $teacher->email                  = $request->email;
        $teacher->dia_chi                = $request->dia_chi;
        $teacher->bang_cap               = $request->bang_cap;
        $teacher->trinh_do_chuyen_mon    = $request->trinh_do_chuyen_mon;
        $teacher->to_chuyen_mon          = $request->to_chuyen_mon;
        $teacher->mon_day                = $request->mon_day;
        $teacher->mon_kiem_nhiem         = $request->mon_kiem_nhiem;
        $teacher->nam_cong_tac           = $request->nam_cong_tac;
        $teacher->kinh_nghiem            = $request->kinh_nghiem;
        $teacher->chuc_vu                = $request->chuc_vu;
        $teacher->lop_chu_nhiem          = $request->lop_chu_nhiem;
        $teacher->mo_ta                  = $request->mo_ta;

        // 4. Xử lý ảnh đại diện
        if ($request->hasFile('anh_dai_dien')) {
            $file = $request->file('anh_dai_dien');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/teacher'), $fileName);

            $teacher->anh_dai_dien = $fileName;
        }

        // 5. Lưu vào database
        $teacher->save();

        return redirect()->back()->with('success', 'Cập nhật thông tin giáo viên thành công!');
    }

    public function listPoint(Request $request)
    {
        $user = Auth::user();
        $teacher = $user->teacher;
        
        if (!$teacher) {
            return redirect()->route('teacher.dashboard')->with('error', 'Không tìm thấy thông tin giáo viên');
        }

        $academicYear = $request->get('nam_hoc', '2024-2025');
        
        // Lấy danh sách lớp và môn mà giáo viên được phân công dạy
        $assignments = TeacherClassSubject::where('ma_giao_vien', $teacher->ma_giao_vien)
            ->where('nam_hoc', $academicYear)
            ->orderBy('khoi')
            ->orderBy('lop')
            ->orderBy('mon_hoc')
            ->get();

        // Nhóm theo lớp
        $classesBySubject = [];
        foreach ($assignments as $assignment) {
            $classKey = $assignment->khoi . $assignment->lop;
            if (!isset($classesBySubject[$classKey])) {
                $classesBySubject[$classKey] = [
                    'class_name' => $classKey,
                    'khoi' => $assignment->khoi,
                    'lop' => $assignment->lop,
                    'subjects' => [],
                    'students' => []
                ];
            }
            $classesBySubject[$classKey]['subjects'][] = $assignment->mon_hoc;
        }

        // Lấy danh sách học sinh cho từng lớp
        foreach ($classesBySubject as $classKey => &$classData) {
            $classData['students'] = Student::where('lop', $classKey)
                ->orderBy('ho_va_ten')
                ->get();
        }

        return view('TeacherPage.listPoint', compact('teacher', 'classesBySubject', 'academicYear', 'assignments'));
    }

    public function viewStudentScores(Request $request, $studentId)
    {
        // Kiểm tra authentication
        if (!Auth::check()) {
            return redirect()->route('login.form')->with('error', 'Vui lòng đăng nhập để tiếp tục');
        }
        
        $user = Auth::user();
        $teacher = $user->teacher;
        
        if (!$teacher) {
            return redirect()->route('teacher.dashboard')->with('error', 'Không tìm thấy thông tin giáo viên');
        }

        $student = Student::findOrFail($studentId);
        $academicYear = $request->get('nam_hoc', '2024-2025');
        $semester = $request->get('hoc_ky', 'HK1');
        
        // Kiểm tra quyền xem điểm - giáo viên có thể xem điểm của học sinh trong các lớp được phân công
        $hasPermission = false;
        
        // Kiểm tra nếu là lớp chủ nhiệm
        if ($student->lop === $teacher->lop_chu_nhiem) {
            $hasPermission = true;
        } else {
            // Kiểm tra nếu giáo viên được phân công dạy lớp này
            $assignment = TeacherClassSubject::where('ma_giao_vien', $teacher->ma_giao_vien)
                ->where('nam_hoc', $academicYear)
                ->get()
                ->filter(function($assignment) use ($student) {
                    $assignmentClass = $assignment->khoi . $assignment->lop;
                    return $assignmentClass == $student->lop;
                });
            
            if ($assignment->count() > 0) {
                $hasPermission = true;
            }
        }
        
        if (!$hasPermission) {
            return redirect()->back()->with('error', 'Bạn không có quyền xem điểm của học sinh này.');
        }

        // Lấy danh sách môn học mà giáo viên có thể xem
        $teacherSubjects = TeacherClassSubject::where('ma_giao_vien', $teacher->ma_giao_vien)
            ->where('nam_hoc', $academicYear)
            ->get()
            ->filter(function($assignment) use ($student) {
                $assignmentClass = $assignment->khoi . $assignment->lop;
                return $assignmentClass == $student->lop;
            })
            ->pluck('mon_hoc')
            ->unique()
            ->toArray();

        // Nếu là chủ nhiệm, có thể xem tất cả môn
        if ($student->lop === $teacher->lop_chu_nhiem) {
            $subjects = [
                'Toán', 'Ngữ văn', 'Tiếng Anh', 'Vật lý', 'Hóa học', 'Sinh học',
                'Lịch sử', 'Địa lý', 'GDCD', 'Thể dục', 'Tin học', 'Công nghệ'
            ];
        } else {
            // Chỉ xem các môn được phân công dạy
            $subjects = $teacherSubjects;
        }

        // Lấy điểm của học sinh từ database
        $studentScores = Score::where('student_id', $student->id)
            ->where('nam_hoc', $academicYear)
            ->where('hoc_ky', $semester)
            ->get()
            ->keyBy('mon_hoc');

        // Tính toán thống kê
        $statistics = [
            'total_subjects' => count($subjects),
            'subjects_with_scores' => $studentScores->count(),
            'average_score' => 0,
            'passed_subjects' => 0,
            'classification' => 'Chưa xếp loại'
        ];

        if ($studentScores->count() > 0) {
            $totalScore = 0;
            $passedCount = 0;
            
            foreach ($studentScores as $score) {
                if ($score->diem_tong_ket) {
                    $totalScore += $score->diem_tong_ket;
                    if ($score->diem_tong_ket >= 5.0) {
                        $passedCount++;
                    }
                }
            }
            
            $statistics['average_score'] = $studentScores->count() > 0 ? round($totalScore / $studentScores->count(), 2) : 0;
            $statistics['passed_subjects'] = $passedCount;
            
            // Xếp loại học lực
            $avgScore = $statistics['average_score'];
            if ($avgScore >= 8.0) {
                $statistics['classification'] = 'Giỏi';
            } elseif ($avgScore >= 6.5) {
                $statistics['classification'] = 'Khá';
            } elseif ($avgScore >= 5.0) {
                $statistics['classification'] = 'Trung bình';
            } else {
                $statistics['classification'] = 'Yếu';
            }
        }

        return view('TeacherPage.viewStudentScores', compact('teacher', 'student', 'subjects', 'studentScores', 'academicYear', 'semester', 'statistics'));
    }

    public function inputScores(Request $request, $studentId)
    {
        // Kiểm tra authentication
        if (!Auth::check()) {
            return redirect()->route('login.form')->with('error', 'Vui lòng đăng nhập để tiếp tục');
        }
        
        $user = Auth::user();
        $teacher = $user->teacher;
        
        if (!$teacher) {
            return redirect()->route('teacher.dashboard')->with('error', 'Không tìm thấy thông tin giáo viên');
        }

        $student = Student::findOrFail($studentId);
        $academicYear = $request->get('nam_hoc', '2024-2025');
        
        // Debug: Log thông tin để kiểm tra
        \Log::info('Input scores debug:', [
            'teacher_id' => $teacher->ma_giao_vien,
            'student_lop' => $student->lop,
            'academic_year' => $academicYear
        ]);

        // Kiểm tra xem giáo viên có được phân công dạy lớp này không
        $assignments = TeacherClassSubject::where('ma_giao_vien', $teacher->ma_giao_vien)
            ->where('nam_hoc', $academicYear)
            ->get(); // Lấy tất cả phân công trước

        \Log::info('All assignments:', $assignments->toArray());

        // Lọc theo lớp - sử dụng logic nhất quán
        $classAssignments = $assignments->filter(function($assignment) use ($student) {
            // Tạo tên lớp từ assignment
            $assignmentClass = $assignment->khoi . $assignment->lop;
            
            // So sánh với lớp của học sinh
            return $assignmentClass == $student->lop;
        });

        if ($classAssignments->isEmpty()) {
            $debugInfo = [
                'student_lop' => $student->lop,
                'total_assignments' => $assignments->count(),
                'assignments_detail' => $assignments->map(function($a) {
                    return [
                        'khoi' => $a->khoi,
                        'lop' => $a->lop,
                        'combined' => $a->khoi . $a->lop,
                        'mon_hoc' => $a->mon_hoc
                    ];
                })->toArray()
            ];
            
            Log::info('Class assignment debug:', $debugInfo);
            
            return redirect()->back()->with('error', 'Bạn không được phân công dạy lớp ' . $student->lop . '. Debug: ' . json_encode($debugInfo));
        }

        // Lấy danh sách môn mà giáo viên dạy cho lớp này
        $teacherSubjects = $classAssignments->pluck('mon_hoc')->toArray();

        // Lấy điểm đã có của học sinh (nếu có)
        $existingScores = Score::where('student_id', $student->id)
            ->where('ma_giao_vien', $teacher->ma_giao_vien)
            ->where('nam_hoc', $academicYear)
            ->get()
            ->keyBy('mon_hoc');

        return view('TeacherPage.inputScores', compact('teacher', 'student', 'teacherSubjects', 'academicYear', 'existingScores', 'classAssignments'));
    }

    public function saveScores(Request $request, $studentId)
    {
        // Kiểm tra authentication
        if (!Auth::check()) {
            return redirect()->route('login.form')->with('error', 'Vui lòng đăng nhập để tiếp tục');
        }
        
        $user = Auth::user();
        $teacher = $user->teacher;
        
        if (!$teacher) {
            return redirect()->route('teacher.dashboard')->with('error', 'Không tìm thấy thông tin giáo viên');
        }

        $student = Student::findOrFail($studentId);
        
        // Debug: Log request data
        \Log::info('Save scores request data:', $request->all());

        // Validate dữ liệu
        $request->validate([
            'subject_name' => 'required|string',
            'semester' => 'required|string',
            'academic_year' => 'required|string',
            'diem_15phut_1' => 'nullable|numeric|min:0|max:10',
            'diem_15phut_2' => 'nullable|numeric|min:0|max:10',
            'diem_15phut_3' => 'nullable|numeric|min:0|max:10',
            'diem_15phut_4' => 'nullable|numeric|min:0|max:10',
            'diem_mieng_1' => 'nullable|numeric|min:0|max:10',
            'diem_mieng_2' => 'nullable|numeric|min:0|max:10',
            'diem_mieng_3' => 'nullable|numeric|min:0|max:10',
            'diem_mieng_4' => 'nullable|numeric|min:0|max:10',
            'diem_giua_ky' => 'nullable|numeric|min:0|max:10',
            'diem_cuoi_ky' => 'nullable|numeric|min:0|max:10',
            'diem_tong_ket' => 'nullable|numeric|min:0|max:10',
            'ghi_chu' => 'nullable|string|max:1000',
        ]);

        // Kiểm tra quyền giáo viên dạy môn này cho lớp này
        // Tách khối và lớp từ student->lop (ví dụ: "10A1" -> khoi="10", lop="A1")
        preg_match('/^(\d+)([A-Z]\d*)$/', $student->lop, $matches);
        $studentKhoi = $matches[1] ?? '';
        $studentLop = $matches[2] ?? $student->lop;
        
        $assignment = TeacherClassSubject::where('ma_giao_vien', $teacher->ma_giao_vien)
            ->where('nam_hoc', $request->academic_year)
            ->where('khoi', $studentKhoi)
            ->where('lop', $studentLop)
            ->where('mon_hoc', $request->subject_name)
            ->first();

        if (!$assignment) {
            Log::info('Assignment not found:', [
                'teacher_id' => $teacher->ma_giao_vien,
                'academic_year' => $request->academic_year,
                'student_khoi' => $studentKhoi,
                'student_lop' => $studentLop,
                'subject_name' => $request->subject_name,
                'student_full_lop' => $student->lop
            ]);
            
            return redirect()->back()->with('error', 'Bạn không có quyền nhập điểm môn ' . $request->subject_name . ' cho lớp ' . $student->lop . '. Debug: khoi=' . $studentKhoi . ', lop=' . $studentLop);
        }

        try {
            // Tìm hoặc tạo bản ghi điểm
            $score = Score::updateOrCreate(
                [
                    'student_id' => $student->id,
                    'ma_giao_vien' => $teacher->ma_giao_vien,
                    'mon_hoc' => $request->subject_name,
                    'nam_hoc' => $request->academic_year,
                    'hoc_ky' => $request->semester,
                ],
                [
                    'khoi' => $assignment->khoi,
                    'lop' => $assignment->lop,
                    'diem_15phut_1' => $request->diem_15phut_1,
                    'diem_15phut_2' => $request->diem_15phut_2,
                    'diem_15phut_3' => $request->diem_15phut_3,
                    'diem_15phut_4' => $request->diem_15phut_4,
                    'diem_mieng_1' => $request->diem_mieng_1,
                    'diem_mieng_2' => $request->diem_mieng_2,
                    'diem_mieng_3' => $request->diem_mieng_3,
                    'diem_mieng_4' => $request->diem_mieng_4,
                    'diem_giua_ky' => $request->diem_giua_ky,
                    'diem_cuoi_ky' => $request->diem_cuoi_ky,
                    'diem_tong_ket' => $request->diem_tong_ket,
                    'ghi_chu' => $request->ghi_chu,
                ]
            );

            // Tính điểm tổng kết tự động nếu chưa có
            if (!$request->diem_tong_ket && $score) {
                $calculatedAverage = $score->calculateAverage();
                if ($calculatedAverage) {
                    $score->update(['diem_tong_ket' => $calculatedAverage]);
                }
            }

            return redirect()->back()->with('success', 'Lưu điểm môn ' . $request->subject_name . ' cho học sinh ' . $student->ho_va_ten . ' thành công!');
            
        } catch (\Exception $e) {
            \Log::error('Error saving scores: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi lưu điểm: ' . $e->getMessage());
        }
    }

    public function timetable(Request $request)
    {
        $user = Auth::user();
        $teacher = $user->teacher;
        
        if (!$teacher) {
            return redirect()->route('teacher.dashboard')->with('error', 'Không tìm thấy thông tin giáo viên');
        }

        $academicYear = $request->get('nam_hoc', '2024-2025');
        $semester = $request->get('hoc_ky', 'HK1');

        // Lấy thời khóa biểu của giáo viên
        // Xử lý cả hai định dạng học kỳ: "HK1" và "1"
        $semesterValue = $semester;
        if ($semester == 'HK1') {
            $semesterValue = '1';
        } elseif ($semester == 'HK2') {
            $semesterValue = '2';
        }
        
        $timetable = \App\Models\Timetable::where('ma_giao_vien', $teacher->ma_giao_vien)
            ->where('nam_hoc', $academicYear)
            ->where(function($query) use ($semester, $semesterValue) {
                $query->where('hoc_ky', $semester)
                      ->orWhere('hoc_ky', $semesterValue);
            })
            ->orderBy('thu')
            ->orderBy('tiet')
            ->get();
            


        // Tạo ma trận thời khóa biểu
        $schedule = [];
        $days = ['2' => 'Thứ Hai', '3' => 'Thứ Ba', '4' => 'Thứ Tư', '5' => 'Thứ Năm', '6' => 'Thứ Sáu', '7' => 'Thứ Bảy'];
        $periods = range(1, 10);

        foreach ($days as $dayNum => $dayName) {
            $schedule[$dayNum] = [];
            foreach ($periods as $period) {
                $schedule[$dayNum][$period] = null;
            }
        }

        // Điền dữ liệu vào ma trận
        foreach ($timetable as $item) {
            $schedule[$item->thu][$item->tiet] = $item;
        }

        // Thống kê
        $statistics = [
            'total_periods' => $timetable->count(),
            'subjects' => $timetable->pluck('mon_hoc')->unique()->count(),
            'classes' => $timetable->pluck('lop')->unique()->count(),
            'days_teaching' => $timetable->pluck('thu')->unique()->count(),
        ];

        return view('TeacherPage.timetable', compact('teacher', 'schedule', 'days', 'periods', 'academicYear', 'semester', 'statistics', 'timetable'));
    }

    /**
     * Hiển thị trang nhập điểm
     */
    public function showInputScoresForm(Request $request)
    {
        $user = Auth::user();
        $teacher = $user->teacher;
        
        if (!$teacher) {
            return redirect()->route('login.form')->with('error', 'Không tìm thấy thông tin giáo viên');
        }

        $namHoc = $request->get('nam_hoc', '2024-2025');
        $lop = $request->get('lop');
        $monHoc = $request->get('mon_hoc');

        // Lấy danh sách lớp được phân công
        $assignedClasses = $teacher->getAssignedClasses($namHoc);

        // Lấy danh sách môn học được phân công cho lớp đã chọn
        $assignedSubjects = [];
        if ($lop) {
            $assignedSubjects = \DB::table('timetable')
                ->where('ma_giao_vien', $teacher->ma_giao_vien)
                ->where('lop', $lop)
                ->where('nam_hoc', $namHoc)
                ->where('is_active', true)
                ->pluck('mon_hoc')
                ->unique();
        }

        // Lấy danh sách học sinh nếu đã chọn lớp và môn
        $students = collect();
        if ($lop && $monHoc) {
            // Kiểm tra quyền
            if (!$teacher->canTeachSubject($monHoc, $lop, $namHoc)) {
                return redirect()->back()->with('error', 
                    'Bạn không có quyền nhập điểm cho môn học này. Bạn chỉ được nhập điểm cho các môn được phân công.');
            }

            $students = Student::where('lop', $lop)
                ->where('nam_hoc', $namHoc)
                ->orderBy('ho_va_ten')
                ->get();
        }

        $subjectNames = [
            'TOAN' => 'Toán', 'VAN' => 'Ngữ Văn', 'ANH' => 'Tiếng Anh',
            'LY' => 'Vật Lý', 'HOA' => 'Hóa Học', 'SINH' => 'Sinh Học',
            'SU' => 'Lịch Sử', 'DIA' => 'Địa Lý', 'GDCD' => 'GDCD', 'TD' => 'Thể Dục'
        ];

        return view('TeacherPage.input-scores', compact(
            'teacher', 
            'assignedClasses', 
            'assignedSubjects', 
            'students',
            'subjectNames'
        ));
    }

    /**
     * Lưu điểm học sinh
     */
    public function saveScoresForm(Request $request)
    {
        $user = Auth::user();
        $teacher = $user->teacher;
        
        if (!$teacher) {
            return redirect()->route('login.form')->with('error', 'Không tìm thấy thông tin giáo viên');
        }

        $lop = $request->input('lop');
        $monHoc = $request->input('mon_hoc');
        $namHoc = $request->input('nam_hoc', '2024-2025');
        $scores = $request->input('scores', []);

        // Kiểm tra quyền
        if (!$teacher->canTeachSubject($monHoc, $lop, $namHoc)) {
            return redirect()->back()->with('error', 
                'Bạn không có quyền nhập điểm cho môn học này.');
        }

        $savedCount = 0;
        $updatedCount = 0;

        foreach ($scores as $studentId => $scoreData) {
            // Bỏ qua nếu không có dữ liệu
            if (empty(array_filter($scoreData))) {
                continue;
            }

            $student = Student::find($studentId);
            if (!$student) {
                continue;
            }

            // Tìm hoặc tạo bản ghi điểm
            $score = \App\Models\Scores::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'mon_hoc' => $monHoc,
                    'nam_hoc' => $namHoc,
                ],
                [
                    'ma_giao_vien' => $teacher->ma_giao_vien,
                    'khoi' => $student->khoi,
                    'lop' => $student->lop,
                    'hoc_ky' => 'HK1',
                    'diem_mieng_1' => $scoreData['diem_mieng_1'] ?? null,
                    'diem_mieng_2' => $scoreData['diem_mieng_2'] ?? null,
                    'diem_mieng_3' => $scoreData['diem_mieng_3'] ?? null,
                    'diem_15phut_1' => $scoreData['diem_15phut_1'] ?? null,
                    'diem_15phut_2' => $scoreData['diem_15phut_2'] ?? null,
                    'diem_giua_ky' => $scoreData['diem_giua_ky'] ?? null,
                    'diem_cuoi_ky' => $scoreData['diem_cuoi_ky'] ?? null,
                    'diem_tong_ket' => $scoreData['diem_tong_ket'] ?? null,
                ]
            );

            if ($score->wasRecentlyCreated) {
                $savedCount++;
            } else {
                $updatedCount++;
            }
        }

        $message = "Đã lưu điểm thành công! ";
        if ($savedCount > 0) {
            $message .= "Tạo mới: {$savedCount} bản ghi. ";
        }
        if ($updatedCount > 0) {
            $message .= "Cập nhật: {$updatedCount} bản ghi.";
        }

        return redirect()->back()->with('success', $message);
    }
}
