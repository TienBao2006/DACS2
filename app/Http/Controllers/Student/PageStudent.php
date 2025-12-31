<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Grade;
use App\Models\Timetable;
use App\Models\Assignment;
use App\Models\Document;
use App\Models\Notification;
use App\Models\Teacher;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PageStudent extends Controller
{
    private function getCurrentStudent()
    {
        $user = Auth::user();
        
        if ($user && $user->role === 'Student') {
            return $user->student;
        }
        
        // Fallback: lấy student đầu tiên để test (chỉ dùng khi chưa login)
        return Student::first();
    }

    public function index()
    {
        $student = $this->getCurrentStudent();
        
        if (!$student) {
            return redirect()->route('login')->with('error', 'Không tìm thấy thông tin học sinh');
        }

        // Thống kê dashboard từ database
        $currentYear = '2024-2025';
        $currentSemester = 1;
        
        // Tổng số môn học theo khối
        $totalSubjects = Subject::where('khoi', $student->khoi)->where('is_active', true)->count();
        
        // Bài tập đã hoàn thành và chưa hoàn thành (tạm thời dùng dữ liệu mẫu)
        $completedAssignments = 15;
        $pendingAssignments = 3;
        
        // Điểm trung bình
        $averageGrade = $student->calculateOverallAverage($currentYear);
        
        // Thông báo mới
        try {
            $notificationsCount = Notification::active()
                ->forHomepage()
                ->currentlyValid()
                ->count();
        } catch (\Exception $e) {
            $notificationsCount = 5; // Fallback
        }

        // Thống kê thanh toán
        $pendingPaymentsCount = $student->payments()->pending()->count();
        if ($pendingPaymentsCount === 0) {
            // Tạo dữ liệu mẫu nếu chưa có
            $this->createSamplePayments($student);
            $pendingPaymentsCount = $student->payments()->pending()->count();
        }

        $stats = [
            'total_subjects' => $totalSubjects,
            'completed_assignments' => $completedAssignments,
            'pending_assignments' => $pendingAssignments,
            'average_grade' => $averageGrade ?: 0,
            'attendance_rate' => 95, // Tạm thời hardcode, cần bảng attendance
            'notifications_count' => $notificationsCount,
            'pending_payments_count' => $pendingPaymentsCount,
        ];

        // Lịch học hôm nay từ database
        try {
            $today = date('N') + 1; // Chuyển từ 1-7 thành 2-8 (Thứ 2-CN)
            if ($today > 7) $today = 2; // Chủ nhật = 2 (Thứ 2)
            
            $todaySchedule = $student->getTimetable($currentYear, $currentSemester)
                ->where('thu', $today)
                ->map(function($schedule) {
                    return [
                        'time' => $schedule->tiet_time,
                        'subject' => $schedule->mon_hoc,
                        'teacher' => $schedule->ten_giao_vien,
                        'room' => $schedule->phong_hoc
                    ];
                })->toArray();
        } catch (\Exception $e) {
            // Fallback data
            $todaySchedule = [
                ['time' => '07:00 - 07:45', 'subject' => 'Toán', 'teacher' => 'Nguyễn Văn A', 'room' => 'A101'],
                ['time' => '07:50 - 08:35', 'subject' => 'Văn', 'teacher' => 'Trần Thị B', 'room' => 'A102'],
                ['time' => '08:40 - 09:25', 'subject' => 'Anh', 'teacher' => 'Lê Văn C', 'room' => 'A103'],
            ];
        }

        // Bài tập sắp hết hạn (tạm thời dùng dữ liệu mẫu)
        $upcomingAssignments = [
            ['subject' => 'Toán', 'title' => 'Bài tập chương 3', 'due_date' => '2025-12-20', 'status' => 'pending'],
            ['subject' => 'Văn', 'title' => 'Phân tích tác phẩm', 'due_date' => '2025-12-22', 'status' => 'pending'],
            ['subject' => 'Hóa', 'title' => 'Thí nghiệm số 5', 'due_date' => '2025-12-25', 'status' => 'completed'],
        ];

        // Thông báo mới từ database
        try {
            $recentNotifications = Notification::active()
                ->forHomepage()
                ->currentlyValid()
                ->byPriority()
                ->take(3)
                ->get()
                ->map(function($notification) {
                    return [
                        'title' => $notification->title,
                        'content' => \Str::limit($notification->content, 100),
                        'time' => $notification->created_at->diffForHumans(),
                        'type' => $notification->type
                    ];
                })->toArray();
        } catch (\Exception $e) {
            // Fallback data
            $recentNotifications = [
                ['title' => 'Kiểm tra giữa kỳ môn Toán', 'content' => 'Ngày 20/12/2025 - Phòng 101', 'time' => '2 giờ trước', 'type' => 'warning'],
                ['title' => 'Nộp bài tập Văn học', 'content' => 'Hạn cuối: 18/12/2025', 'time' => '1 ngày trước', 'type' => 'info'],
                ['title' => 'Điểm kiểm tra Tiếng Anh đã có', 'content' => 'Điểm: 9.0/10', 'time' => '2 ngày trước', 'type' => 'success'],
            ];
        }

        return view('Student.dashboard', compact('student', 'stats', 'todaySchedule', 'upcomingAssignments', 'recentNotifications'));
    }

    public function profile()
    {
        $student = $this->getCurrentStudent();
        
        if (!$student) {
            return redirect()->route('login')->with('error', 'Không tìm thấy thông tin học sinh');
        }
        
        return view('Student.Thongtincanhan', compact('student'));
    }

    public function profileById($id)
    {
        try {
            // Kiểm tra quyền truy cập - chỉ cho phép xem profile của chính mình
            $currentStudent = $this->getCurrentStudent();
            
            if (!$currentStudent) {
                \Log::info('ProfileById: Không tìm thấy current student');
                return redirect()->route('login')->with('error', 'Không tìm thấy thông tin học sinh');
            }
            
            \Log::info('ProfileById: Current student ID = ' . $currentStudent->id . ', Requested ID = ' . $id);
            
            // Nếu ID khác với ID của học sinh hiện tại, chuyển hướng về profile của mình
            if ($currentStudent->id != $id) {
                \Log::info('ProfileById: ID không khớp, chuyển hướng');
                return redirect()->route('student.profile')->with('warning', 'Bạn chỉ có thể xem thông tin của chính mình');
            }
            
            $student = Student::findOrFail($id);
            \Log::info('ProfileById: Tìm thấy student: ' . $student->ho_va_ten);
            
            return view('Student.Thongtincanhan', compact('student'));
            
        } catch (\Exception $e) {
            \Log::error('ProfileById Error: ' . $e->getMessage());
            return redirect()->route('student.dashboard')->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function subjects()
    {
        $student = $this->getCurrentStudent();
        
        if (!$student) {
            return redirect()->route('login')->with('error', 'Không tìm thấy thông tin học sinh');
        }

        // Lấy danh sách môn học từ database hoặc fallback
        try {
            $subjectsFromDB = Subject::where('khoi', $student->khoi)
                ->where('is_active', true)
                ->get();

            if ($subjectsFromDB->count() > 0) {
                // Lấy thời khóa biểu để biết giáo viên và phòng học
                $timetable = $student->getTimetable();
                
                // Kết hợp thông tin môn học với thời khóa biểu
                $subjects = $subjectsFromDB->map(function($subject) use ($timetable) {
                    // Tìm thông tin từ thời khóa biểu
                    $scheduleInfo = $timetable->where('mon_hoc', $subject->ma_mon_hoc)->first();
                    
                    // Tạo lịch học từ thời khóa biểu
                    $scheduleText = $timetable->where('mon_hoc', $subject->ma_mon_hoc)
                        ->groupBy('thu')
                        ->map(function($items, $thu) {
                            $dayNames = [
                                '2' => 'T2', '3' => 'T3', '4' => 'T4', 
                                '5' => 'T5', '6' => 'T6', '7' => 'T7'
                            ];
                            return $dayNames[$thu] ?? '';
                        })
                        ->filter()
                        ->implode(', ');

                    return [
                        'name' => $subject->ten_mon_hoc,
                        'teacher' => $scheduleInfo->ten_giao_vien ?? 'Chưa phân công',
                        'credits' => $subject->so_tiet,
                        'room' => $scheduleInfo->phong_hoc ?? 'Chưa xếp',
                        'schedule' => $scheduleText ?: 'Chưa có lịch',
                        'ma_mon_hoc' => $subject->ma_mon_hoc
                    ];
                })->toArray();
            } else {
                throw new \Exception('No subjects found');
            }
        } catch (\Exception $e) {
            // Fallback data
            $subjects = [
                ['name' => 'Toán', 'teacher' => 'Nguyễn Văn A', 'credits' => 4, 'room' => 'A101', 'schedule' => 'T2, T4, T6'],
                ['name' => 'Ngữ Văn', 'teacher' => 'Trần Thị B', 'credits' => 4, 'room' => 'A102', 'schedule' => 'T3, T5, T7'],
                ['name' => 'Tiếng Anh', 'teacher' => 'Lê Văn C', 'credits' => 3, 'room' => 'A103', 'schedule' => 'T2, T5'],
                ['name' => 'Vật Lý', 'teacher' => 'Phạm Văn D', 'credits' => 2, 'room' => 'B201', 'schedule' => 'T3, T6'],
                ['name' => 'Hóa Học', 'teacher' => 'Hoàng Thị E', 'credits' => 2, 'room' => 'B202', 'schedule' => 'T4, T7'],
                ['name' => 'Sinh Học', 'teacher' => 'Vũ Văn F', 'credits' => 2, 'room' => 'B203', 'schedule' => 'T2, T6'],
                ['name' => 'Lịch Sử', 'teacher' => 'Đỗ Thị G', 'credits' => 1, 'room' => 'C301', 'schedule' => 'T4'],
                ['name' => 'Địa Lý', 'teacher' => 'Bùi Văn H', 'credits' => 1, 'room' => 'C302', 'schedule' => 'T5'],
                ['name' => 'GDCD', 'teacher' => 'Lý Thị I', 'credits' => 1, 'room' => 'C303', 'schedule' => 'T7'],
                ['name' => 'Thể Dục', 'teacher' => 'Trương Văn J', 'credits' => 1, 'room' => 'Sân thể thao', 'schedule' => 'T3'],
            ];
        }

        return view('Student.subjects', compact('student', 'subjects'));
    }

    public function grades()
    {
        $student = $this->getCurrentStudent();
        
        if (!$student) {
            return redirect()->route('login')->with('error', 'Không tìm thấy thông tin học sinh');
        }

        $currentYear = '2024-2025';
        $currentSemester = 1;

        // Lấy điểm từ database, tạo mẫu nếu chưa có
        $scoresFromDB = $student->getYearScores($currentYear);
        
        // Nếu chưa có điểm, tạo điểm mẫu
        if ($scoresFromDB->count() === 0) {
            $student->createSampleScores($currentYear);
            $scoresFromDB = $student->getYearScores($currentYear);
        }
        
        if ($scoresFromDB->count() > 0) {
            // Tạo cấu trúc điểm từ database thực
            $grades = [];
            $subjectNames = [
                'TOAN' => 'Toán', 'VAN' => 'Ngữ Văn', 'ANH' => 'Tiếng Anh',
                'LY' => 'Vật Lý', 'HOA' => 'Hóa Học', 'SINH' => 'Sinh Học',
                'SU' => 'Lịch Sử', 'DIA' => 'Địa Lý', 'GDCD' => 'GDCD', 'TD' => 'Thể Dục'
            ];
            
            foreach ($scoresFromDB as $score) {
                $subjectName = $subjectNames[$score->mon_hoc] ?? $score->mon_hoc;
                $grades[$subjectName] = [
                    'mieng' => $score->diem_mieng,
                    '15phut' => $score->diem_15p,
                    '1tiet' => [], // Không có trong bảng hiện tại
                    'hocky' => $score->diem_hoc_ky,
                    'trungbinh' => $score->diem_tong_ket ?: $score->calculateAverage(),
                    'classification' => $score->classification
                ];
            }

            // Tính điểm trung bình chung từ database
            $overallAverage = $student->calculateOverallAverage($currentYear);
            
            // Tính xếp hạng trong lớp
            $classmates = Student::where('lop', $student->lop)->get();
            $classAverages = $classmates->map(function($classmate) use ($currentYear) {
                return [
                    'student_id' => $classmate->id,
                    'average' => $classmate->calculateOverallAverage($currentYear)
                ];
            })->filter(function($item) {
                return $item['average'] > 0; // Chỉ tính học sinh có điểm
            })->sortByDesc('average')->values();
            
            $ranking = $classAverages->search(function($item) use ($student) {
                return $item['student_id'] === $student->id;
            });
            $ranking = $ranking !== false ? $ranking + 1 : 0;
            
            $totalStudents = $classAverages->count();
            
            // Thông báo sử dụng dữ liệu thực
            $dataSource = 'database';
        } else {
            // Fallback data khi không có điểm trong database
            $grades = [
                'Toán' => [
                    'mieng' => [9.0, 8.5, 9.5], 
                    '15phut' => [8.0, 9.0], 
                    '1tiet' => [], 
                    'hocky' => [8.8, 8.9],
                    'trungbinh' => 8.7,
                    'classification' => 'Giỏi'
                ],
                'Ngữ Văn' => [
                    'mieng' => [8.5, 9.0, 8.0], 
                    '15phut' => [8.5, 8.0], 
                    '1tiet' => [], 
                    'hocky' => [8.5, 8.6],
                    'trungbinh' => 8.5,
                    'classification' => 'Giỏi'
                ],
                'Tiếng Anh' => [
                    'mieng' => [9.5, 9.0, 9.5], 
                    '15phut' => [9.0, 9.5], 
                    '1tiet' => [], 
                    'hocky' => [9.2, 9.1],
                    'trungbinh' => 9.2,
                    'classification' => 'Xuất sắc'
                ],
                'Vật Lý' => [
                    'mieng' => [8.0, 8.5, 7.5], 
                    '15phut' => [8.0, 8.5], 
                    '1tiet' => [], 
                    'hocky' => [8.1, 8.0],
                    'trungbinh' => 8.1,
                    'classification' => 'Giỏi'
                ],
                'Hóa Học' => [
                    'mieng' => [8.5, 9.0, 8.0], 
                    '15phut' => [8.5, 9.0], 
                    '1tiet' => [], 
                    'hocky' => [8.6, 8.7],
                    'trungbinh' => 8.6,
                    'classification' => 'Giỏi'
                ],
                'Sinh Học' => [
                    'mieng' => [8.2, 8.8, 8.5], 
                    '15phut' => [8.3, 8.7], 
                    '1tiet' => [], 
                    'hocky' => [8.4, 8.6],
                    'trungbinh' => 8.5,
                    'classification' => 'Giỏi'
                ],
                'Lịch Sử' => [
                    'mieng' => [8.0, 8.3, 8.1], 
                    '15phut' => [8.2, 8.4], 
                    '1tiet' => [], 
                    'hocky' => [8.1, 8.3],
                    'trungbinh' => 8.2,
                    'classification' => 'Giỏi'
                ],
                'Địa Lý' => [
                    'mieng' => [8.4, 8.6, 8.2], 
                    '15phut' => [8.5, 8.3], 
                    '1tiet' => [], 
                    'hocky' => [8.3, 8.5],
                    'trungbinh' => 8.4,
                    'classification' => 'Giỏi'
                ],
            ];

            $overallAverage = 8.6;
            $ranking = 5;
            $totalStudents = 45;
            $dataSource = 'fallback';
        }

        return view('Student.grades', compact('student', 'grades', 'overallAverage', 'ranking', 'totalStudents', 'dataSource'));
    }

    public function schedule()
    {
        $student = $this->getCurrentStudent();
        
        if (!$student) {
            return redirect()->route('login')->with('error', 'Không tìm thấy thông tin học sinh');
        }

        $currentYear = '2024-2025';
        $currentSemester = 1;

        try {
            // Lấy thời khóa biểu từ model Student
            $timetableData = $student->getTimetable($currentYear, $currentSemester);

            // Tổ chức dữ liệu theo cấu trúc mới
            $schedule = [];
            
            // Khởi tạo schedule cho 7 ngày, 10 tiết
            for ($thu = 2; $thu <= 7; $thu++) {
                for ($tiet = 1; $tiet <= 10; $tiet++) {
                    $schedule[$thu][$tiet] = null;
                }
            }

            // Điền dữ liệu từ database
            foreach ($timetableData as $item) {
                $schedule[$item->thu][$item->tiet] = [
                    'id' => $item->id,
                    'mon_hoc' => $item->mon_hoc,
                    'ten_giao_vien' => $item->ten_giao_vien,
                    'phong_hoc' => $item->phong_hoc,
                    'ma_giao_vien' => $item->ma_giao_vien
                ];
            }

            // Lấy thống kê môn học từ model
            $subjectStats = $student->getTimetableStats($currentYear, $currentSemester);

            $dataSource = 'database';
            
        } catch (\Exception $e) {
            \Log::error('Schedule Error: ' . $e->getMessage());
            
            // Fallback data nếu có lỗi
            $schedule = $this->getFallbackSchedule();
            $subjectStats = [
                'Toán' => ['count' => 4, 'code' => 'TOAN'],
                'Ngữ Văn' => ['count' => 4, 'code' => 'VAN'],
                'Tiếng Anh' => ['count' => 3, 'code' => 'ANH'],
                'Vật Lý' => ['count' => 2, 'code' => 'LY'],
                'Hóa Học' => ['count' => 2, 'code' => 'HOA'],
                'Sinh Học' => ['count' => 2, 'code' => 'SINH'],
            ];
            $dataSource = 'fallback';
        }

        // Thông tin tuần hiện tại
        $currentWeek = [
            'week_number' => date('W'),
            'start_date' => date('d/m', strtotime('monday this week')),
            'end_date' => date('d/m/Y', strtotime('sunday this week'))
        ];

        return view('Student.schedule', compact(
            'student', 
            'schedule', 
            'subjectStats', 
            'currentWeek',
            'dataSource'
        ));
    }

    /**
     * Lấy tên hiển thị của môn học
     */
    private function getSubjectDisplayName($subjectCode)
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
     * Lấy class CSS cho môn học
     */
    private function getSubjectCssClass($subjectCode)
    {
        $subjectClasses = [
            'TOAN' => 'math',
            'VAN' => 'literature',
            'ANH' => 'english',
            'LY' => 'physics',
            'HOA' => 'chemistry',
            'SINH' => 'biology',
            'SU' => 'history',
            'DIA' => 'geography',
            'GDCD' => 'civics',
            'TD' => 'pe'
        ];

        return $subjectClasses[$subjectCode] ?? 'default';
    }

    /**
     * Lấy thời gian của tiết học
     */
    private function getPeriodTime($period)
    {
        $times = [
            1 => '07:00-07:45',
            2 => '07:50-08:35',
            3 => '08:40-09:25',
            4 => '09:40-10:25',
            5 => '10:30-11:15',
            6 => '13:00-13:45',
            7 => '13:45-14:30',
            8 => '14:30-15:15',
            9 => '15:30-16:15',
            10 => '16:15-17:00'
        ];

        return $times[$period] ?? '';
    }

    /**
     * Fallback schedule data
     */
    private function getFallbackSchedule()
    {
        return [
            2 => [
                1 => ['mon_hoc' => 'TOAN', 'ten_giao_vien' => 'Nguyễn Văn A', 'phong_hoc' => 'A101'],
                2 => ['mon_hoc' => 'ANH', 'ten_giao_vien' => 'Lê Văn C', 'phong_hoc' => 'A103'],
                3 => ['mon_hoc' => 'SINH', 'ten_giao_vien' => 'Vũ Văn F', 'phong_hoc' => 'B203'],
                4 => ['mon_hoc' => 'VAN', 'ten_giao_vien' => 'Trần Thị B', 'phong_hoc' => 'A102'],
                5 => ['mon_hoc' => 'SU', 'ten_giao_vien' => 'Đỗ Thị G', 'phong_hoc' => 'C301'],
            ],
            3 => [
                1 => ['mon_hoc' => 'VAN', 'ten_giao_vien' => 'Trần Thị B', 'phong_hoc' => 'A102'],
                2 => ['mon_hoc' => 'LY', 'ten_giao_vien' => 'Phạm Văn D', 'phong_hoc' => 'B201'],
                3 => ['mon_hoc' => 'TD', 'ten_giao_vien' => 'Trương Văn J', 'phong_hoc' => 'Sân TD'],
                4 => ['mon_hoc' => 'TOAN', 'ten_giao_vien' => 'Nguyễn Văn A', 'phong_hoc' => 'A101'],
                5 => ['mon_hoc' => 'HOA', 'ten_giao_vien' => 'Hoàng Thị E', 'phong_hoc' => 'B202'],
            ],
            // Thêm các ngày khác tương tự...
        ];
    }

    public function assignments()
    {
        $student = $this->getCurrentStudent();
        
        // Danh sách bài tập và kiểm tra
        $assignments = [
            [
                'subject' => 'Toán',
                'title' => 'Bài tập chương 3: Hàm số',
                'description' => 'Làm bài tập từ 1 đến 20 trang 45',
                'assigned_date' => '2025-12-15',
                'due_date' => '2025-12-20',
                'status' => 'pending',
                'type' => 'homework'
            ],
            [
                'subject' => 'Văn',
                'title' => 'Phân tích tác phẩm "Chí Phèo"',
                'description' => 'Viết bài phân tích 500 từ về nhân vật Chí Phèo',
                'assigned_date' => '2025-12-16',
                'due_date' => '2025-12-22',
                'status' => 'pending',
                'type' => 'essay'
            ],
            [
                'subject' => 'Hóa',
                'title' => 'Thí nghiệm: Phản ứng axit-bazơ',
                'description' => 'Hoàn thành báo cáo thí nghiệm số 5',
                'assigned_date' => '2025-12-10',
                'due_date' => '2025-12-18',
                'status' => 'completed',
                'type' => 'lab'
            ],
            [
                'subject' => 'Tiếng Anh',
                'title' => 'Kiểm tra 15 phút - Unit 6',
                'description' => 'Kiểm tra từ vựng và ngữ pháp Unit 6',
                'assigned_date' => '2025-12-18',
                'due_date' => '2025-12-18',
                'status' => 'upcoming',
                'type' => 'test'
            ],
        ];

        return view('Student.assignments', compact('student', 'assignments'));
    }

    public function documents()
    {
        $student = $this->getCurrentStudent();
        
        // Tài liệu học tập
        $documents = [
            [
                'title' => 'Giáo trình Toán 10 - Chương 3',
                'subject' => 'Toán',
                'type' => 'PDF',
                'size' => '2.5 MB',
                'uploaded_date' => '2025-12-15',
                'downloads' => 45,
                'category' => 'Giáo trình'
            ],
            [
                'title' => 'Đề thi mẫu Văn học kỳ I',
                'subject' => 'Văn',
                'type' => 'DOC',
                'size' => '1.2 MB',
                'uploaded_date' => '2025-12-14',
                'downloads' => 32,
                'category' => 'Đề thi'
            ],
            [
                'title' => 'Bài tập Vật Lý - Chuyển động',
                'subject' => 'Vật Lý',
                'type' => 'PDF',
                'size' => '3.1 MB',
                'uploaded_date' => '2025-12-13',
                'downloads' => 28,
                'category' => 'Bài tập'
            ],
        ];

        return view('Student.documents', compact('student', 'documents'));
    }

    public function notifications()
    {
        $student = $this->getCurrentStudent();
        
        // Thông báo từ nhà trường
        $notifications = [
            [
                'title' => 'Thông báo lịch thi học kỳ I',
                'content' => 'Lịch thi học kỳ I năm học 2024-2025 đã được công bố. Học sinh vui lòng xem chi tiết...',
                'date' => '2025-12-17 08:00',
                'type' => 'important',
                'read' => false
            ],
            [
                'title' => 'Nghỉ học do thời tiết xấu',
                'content' => 'Do ảnh hưởng của bão số 10, trường thông báo nghỉ học ngày 18/12/2025...',
                'date' => '2025-12-16 15:30',
                'type' => 'urgent',
                'read' => true
            ],
            [
                'title' => 'Cuộc thi Olympic Toán học',
                'content' => 'Thông báo tổ chức cuộc thi Olympic Toán học cấp trường. Thời gian đăng ký...',
                'date' => '2025-12-15 10:00',
                'type' => 'info',
                'read' => true
            ],
        ];

        return view('Student.notifications', compact('student', 'notifications'));
    }

    public function contact()
    {
        $student = $this->getCurrentStudent();
        
        // Danh sách giáo viên
        $teachers = [
            ['name' => 'Nguyễn Văn A', 'subject' => 'Toán', 'email' => 'nguyenvana@school.edu.vn', 'phone' => '0123456789'],
            ['name' => 'Trần Thị B', 'subject' => 'Văn', 'email' => 'tranthib@school.edu.vn', 'phone' => '0123456790'],
            ['name' => 'Lê Văn C', 'subject' => 'Tiếng Anh', 'email' => 'levanc@school.edu.vn', 'phone' => '0123456791'],
        ];

        return view('Student.contact', compact('student', 'teachers'));
    }

    public function results()
    {
        $student = $this->getCurrentStudent();
        
        // Kết quả học tập tổng hợp
        $semesterResults = [
            'semester1' => [
                'average' => 8.6,
                'ranking' => 5,
                'conduct' => 'Tốt',
                'subjects' => [
                    'Toán' => 8.7,
                    'Văn' => 8.5,
                    'Anh' => 9.2,
                    'Lý' => 8.1,
                    'Hóa' => 8.6,
                ]
            ],
            'semester2' => [
                'average' => null,
                'ranking' => null,
                'conduct' => null,
                'subjects' => []
            ]
        ];

        return view('Student.results', compact('student', 'semesterResults'));
    }

    public function payments()
    {
        $student = $this->getCurrentStudent();
        
        if (!$student) {
            return redirect()->route('login')->with('error', 'Không tìm thấy thông tin học sinh');
        }

        // Lấy danh sách thanh toán từ database
        $paymentsFromDB = $student->payments()->orderBy('due_date', 'asc')->get();
        
        // Nếu chưa có dữ liệu, tạo dữ liệu mẫu
        if ($paymentsFromDB->isEmpty()) {
            $this->createSamplePayments($student);
            $paymentsFromDB = $student->payments()->orderBy('due_date', 'asc')->get();
        }

        // Chuyển đổi sang format phù hợp với view
        $payments = $paymentsFromDB->map(function($payment) {
            return [
                'id' => $payment->id,
                'title' => $payment->title,
                'amount' => $payment->amount,
                'due_date' => $payment->due_date->format('Y-m-d'),
                'status' => strtolower($payment->status),
                'description' => $payment->description
            ];
        })->toArray();

        return view('Student.payments', compact('student', 'payments'));
    }

    /**
     * Tạo dữ liệu thanh toán mẫu cho học sinh
     */
    private function createSamplePayments($student)
    {
        $samplePayments = [
            [
                'title' => 'Học phí học kỳ I',
                'description' => 'Học phí học kỳ I năm học 2024-2025',
                'amount' => 2500000,
                'due_date' => '2025-01-15',
                'payment_type' => 'tuition',
                'status' => 'PENDING'
            ],
            [
                'title' => 'Phí hoạt động ngoại khóa',
                'description' => 'Phí tham gia các hoạt động ngoại khóa',
                'amount' => 500000,
                'due_date' => '2025-01-20',
                'payment_type' => 'activity',
                'status' => 'PENDING'
            ],
            [
                'title' => 'Học phí học kỳ II năm trước',
                'description' => 'Học phí học kỳ II năm học 2023-2024',
                'amount' => 2500000,
                'due_date' => '2024-06-15',
                'payment_type' => 'tuition',
                'status' => 'COMPLETED'
            ]
        ];

        foreach ($samplePayments as $paymentData) {
            $student->payments()->create([
                'order_id' => rand(1000, 9999),
                'title' => $paymentData['title'],
                'description' => $paymentData['description'],
                'amount' => $paymentData['amount'],
                'due_date' => $paymentData['due_date'],
                'payment_type' => $paymentData['payment_type'],
                'status' => $paymentData['status']
            ]);
        }
    }
    public function update(Request $request, $id)
    {
        try {
            // Kiểm tra quyền cập nhật
            $currentStudent = $this->getCurrentStudent();
            
            if (!$currentStudent) {
                return redirect()->route('login')->with('error', 'Không tìm thấy thông tin học sinh');
            }
            
            // Chỉ cho phép cập nhật thông tin của chính mình
            if ($currentStudent->id != $id) {
                return redirect()->route('student.profile')->with('error', 'Bạn chỉ có thể cập nhật thông tin của chính mình');
            }

            $request->validate([
                'ho_va_ten' => 'required|string|max:200',
                'ngay_sinh' => 'required|date',
                'gioi_tinh' => 'required|in:Nam,Nữ',
                'dia_chi' => 'nullable|string|max:500',
                'so_dien_thoai' => 'nullable|string|max:15',
                'email' => 'nullable|email|max:100',
                'khoi' => 'required|in:10,11,12',
                'lop' => 'required|string|max:10',
                'nam_hoc' => 'nullable|string|max:20',
                'ten_cha' => 'nullable|string|max:200',
                'ten_me' => 'nullable|string|max:200',
                'sdt_phu_huynh' => 'nullable|string|max:15',
                'anh_dai_dien' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            ]);

            $student = Student::findOrFail($id);
            
            // Cập nhật thông tin cơ bản
            $student->ho_va_ten = $request->ho_va_ten;
            $student->ngay_sinh = $request->ngay_sinh;
            $student->gioi_tinh = $request->gioi_tinh;
            $student->dia_chi = $request->dia_chi;
            $student->so_dien_thoai = $request->so_dien_thoai;
            $student->email = $request->email;
            $student->khoi = $request->khoi;
            $student->lop = $request->lop;
            $student->nam_hoc = $request->nam_hoc ?? '2024-2025';
            $student->ten_cha = $request->ten_cha;
            $student->ten_me = $request->ten_me;
            $student->sdt_phu_huynh = $request->sdt_phu_huynh;

            // Xử lý upload ảnh
            if ($request->hasFile('anh_dai_dien')) {
                // Tạo thư mục nếu chưa có
                $uploadPath = public_path('uploads/student');
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }

                // Xóa ảnh cũ nếu có
                if ($student->anh_dai_dien && file_exists($uploadPath . '/' . $student->anh_dai_dien)) {
                    unlink($uploadPath . '/' . $student->anh_dai_dien);
                }

                // Upload ảnh mới
                $file = $request->file('anh_dai_dien');
                $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move($uploadPath, $fileName);
                $student->anh_dai_dien = $fileName;
            }

            $student->save();

            return redirect()->route('student.profile')->with('success', 'Cập nhật thông tin thành công!');
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            \Log::error('Student Update Error: ' . $e->getMessage());
            return back()->with('error', 'Có lỗi xảy ra khi cập nhật thông tin: ' . $e->getMessage())->withInput();
        }
    }
}
