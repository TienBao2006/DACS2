<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Login;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentAccountController extends Controller
{
    public function index()
    {
        // Lấy tất cả học sinh, bao gồm cả những học sinh chưa có tài khoản login
        $students = Student::with('login')->orderBy('created_at', 'desc')->get();
        
        // Tạo collection giả lập để hiển thị như tài khoản
        $studentAccounts = $students->map(function($student) {
            return (object)[
                'id' => $student->id,
                'username' => $student->login ? $student->login->username : ($student->ma_hoc_sinh ?? 'Chưa có'),
                'is_active' => $student->login ? $student->login->is_active : false,
                'created_at' => $student->created_at,
                'student' => $student,
                'has_login' => $student->login ? true : false
            ];
        });
        
        return view('Admin.accounts.student-accounts', compact('studentAccounts'));
    }

    public function create()
    {
        return view('Admin.accounts.create-student-account');
    }

    // Tạo mã học sinh tự động theo lớp
    private function generateStudentCode($khoi, $lop)
    {
        $countInClass = Student::where('khoi', $khoi)->where('lop', $lop)->count() + 1;
        $lopCode = str_replace($khoi, '', $lop);
        $stt = str_pad($countInClass, 3, '0', STR_PAD_LEFT);
        
        return 'HS' . $khoi . $lopCode . $stt;
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255|unique:login,username',
            'password' => 'required|string|min:6',
            'ho_va_ten' => 'required|string|max:200',
            'gioi_tinh' => 'required|in:Nam,Nữ',
            'ngay_sinh' => 'required|date',
            'khoi' => 'required|in:10,11,12',
            'lop' => 'required|string|max:10',
            'nam_hoc' => 'nullable|string|max:20',
            'dia_chi' => 'nullable|string|max:500',
            'so_dien_thoai' => 'nullable|string|max:15',
            'email' => 'nullable|email|max:100',
            'ten_cha' => 'nullable|string|max:200',
            'ten_me' => 'nullable|string|max:200',
            'sdt_phu_huynh' => 'nullable|string|max:15',
            'is_active' => 'nullable|boolean',
        ]);

        // Tạo mã học sinh tự động
        $maHocSinh = $this->generateStudentCode($request->khoi, $request->lop);
        
        // Kiểm tra trùng lặp mã học sinh
        while (Student::where('ma_hoc_sinh', $maHocSinh)->exists()) {
            $countInClass = Student::where('khoi', $request->khoi)->where('lop', $request->lop)->count() + 1;
            $lopCode = str_replace($request->khoi, '', $request->lop);
            $stt = str_pad($countInClass, 3, '0', STR_PAD_LEFT);
            $maHocSinh = 'HS' . $request->khoi . $lopCode . $stt;
            $countInClass++;
        }

        // Tạo tài khoản login trước
        $login = Login::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => 'Student',
            'is_active' => $request->has('is_active') ? true : false,
        ]);

        // Tạo hồ sơ học sinh với liên kết login_id
        Student::create([
            'login_id' => $login->id,
            'ma_hoc_sinh' => $maHocSinh,
            'ho_va_ten' => $request->ho_va_ten,
            'gioi_tinh' => $request->gioi_tinh,
            'ngay_sinh' => $request->ngay_sinh,
            'khoi' => $request->khoi,
            'lop' => $request->lop,
            'nam_hoc' => $request->nam_hoc ?? date('Y') . '-' . (date('Y') + 1),
            'dia_chi' => $request->dia_chi,
            'so_dien_thoai' => $request->so_dien_thoai,
            'email' => $request->email,
            'ten_cha' => $request->ten_cha,
            'ten_me' => $request->ten_me,
            'sdt_phu_huynh' => $request->sdt_phu_huynh,
            'trang_thai' => 'Đang học',
        ]);

        return redirect()->route('admin.student-accounts.index')
            ->with('success', "Tài khoản học sinh {$maHocSinh} đã được tạo thành công!");
    }

    public function edit($id)
    {
        $account = Login::where('role', 'Student')->with('student')->findOrFail($id);
        $student = $account->student;
        
        return view('Admin.accounts.edit-student-account', compact('account', 'student'));
    }

    public function update(Request $request, $id)
    {
        $account = Login::where('role', 'Student')->with('student')->findOrFail($id);
        $student = $account->student;

        $request->validate([
            'username' => 'required|string|max:255|unique:login,username,' . $account->id,
            'password' => 'nullable|string|min:6',
            'ho_va_ten' => 'required|string|max:200',
            'gioi_tinh' => 'required|in:Nam,Nữ',
            'ngay_sinh' => 'required|date',
            'khoi' => 'required|in:10,11,12',
            'lop' => 'required|string|max:10',
            'nam_hoc' => 'nullable|string|max:20',
            'dia_chi' => 'nullable|string|max:500',
            'so_dien_thoai' => 'nullable|string|max:15',
            'email' => 'nullable|email|max:100',
            'ten_cha' => 'nullable|string|max:200',
            'ten_me' => 'nullable|string|max:200',
            'sdt_phu_huynh' => 'nullable|string|max:15',
            'is_active' => 'nullable|boolean',
        ]);

        // Cập nhật tài khoản login
        $account->username = $request->username;
        if ($request->filled('password')) {
            $account->password = Hash::make($request->password);
        }
        $account->is_active = $request->has('is_active') ? true : false;
        $account->save();

        // Cập nhật thông tin học sinh
        if ($student) {
            $student->update([
                'ho_va_ten' => $request->ho_va_ten,
                'gioi_tinh' => $request->gioi_tinh,
                'ngay_sinh' => $request->ngay_sinh,
                'khoi' => $request->khoi,
                'lop' => $request->lop,
                'nam_hoc' => $request->nam_hoc ?? date('Y') . '-' . (date('Y') + 1),
                'dia_chi' => $request->dia_chi,
                'so_dien_thoai' => $request->so_dien_thoai,
                'email' => $request->email,
                'ten_cha' => $request->ten_cha,
                'ten_me' => $request->ten_me,
                'sdt_phu_huynh' => $request->sdt_phu_huynh,
            ]);
        }

        return redirect()->route('admin.student-accounts.index')
            ->with('success', 'Tài khoản học sinh đã được cập nhật thành công!');
    }

    public function destroy($id)
    {
        $account = Login::where('role', 'Student')->with('student')->findOrFail($id);
        
        // Xóa tài khoản login (cascade sẽ tự động xóa student)
        $account->delete();

        return redirect()->route('admin.student-accounts.index')
            ->with('success', 'Tài khoản học sinh đã được xóa thành công!');
    }

    public function toggleStatus($id)
    {
        $account = Login::where('role', 'Student')->findOrFail($id);
        $account->is_active = !$account->is_active;
        $account->save();

        $status = $account->is_active ? 'kích hoạt' : 'vô hiệu hóa';
        return redirect()->back()
            ->with('success', "Tài khoản học sinh đã được {$status} thành công!");
    }

    /**
     * Tạo tài khoản login cho học sinh
     */
    public function createLoginAccount($studentId)
    {
        $student = Student::findOrFail($studentId);
        
        if ($student->login_id) {
            return redirect()->back()->with('error', 'Học sinh này đã có tài khoản login!');
        }
        
        // Tạo username từ mã học sinh
        $username = $student->ma_hoc_sinh ? strtolower($student->ma_hoc_sinh) : 'hs' . $student->id;
        
        // Kiểm tra username đã tồn tại chưa
        $counter = 1;
        $originalUsername = $username;
        while (Login::where('username', $username)->exists()) {
            $username = $originalUsername . $counter;
            $counter++;
        }
        
        // Tạo tài khoản login
        $login = Login::create([
            'username' => $username,
            'password' => Hash::make('123456'), // Mật khẩu mặc định
            'role' => 'Student',
            'is_active' => true,
        ]);
        
        // Cập nhật login_id cho học sinh
        $student->update(['login_id' => $login->id]);
        
        return redirect()->back()->with('success', "Đã tạo tài khoản login '{$username}' cho học sinh {$student->ho_va_ten}. Mật khẩu mặc định: 123456");
    }

    // API để preview mã học sinh
    public function previewStudentCode($khoi, $lop)
    {
        $maHocSinh = $this->generateStudentCode($khoi, $lop);
        return response()->json(['ma_hoc_sinh' => $maHocSinh]);
    }

    /**
     * Hiển thị trang quản lý điểm số
     */
    public function scoresIndex()
    {
        $students = Student::with('scores')->paginate(20);
        
        // Thống kê
        $totalStudents = Student::count();
        $studentsWithScores = Student::whereHas('scores')->count();
        $studentsWithoutScores = $totalStudents - $studentsWithScores;
        $totalScores = \App\Models\Scores::count();
        
        $stats = [
            'total_students' => $totalStudents,
            'students_with_scores' => $studentsWithScores,
            'students_without_scores' => $studentsWithoutScores,
            'total_scores' => $totalScores
        ];
        
        return view('Admin.scores.student-scores', compact('students', 'stats'));
    }

    /**
     * Tạo điểm mẫu cho tất cả học sinh
     */
    public function createSampleScores(Request $request)
    {
        $year = $request->input('year', '2024-2025');
        
        $students = Student::all();
        $createdCount = 0;
        $skippedCount = 0;
        
        foreach ($students as $student) {
            if ($student->createSampleScores($year)) {
                $createdCount++;
            } else {
                $skippedCount++;
            }
        }
        
        return redirect()->back()->with('success', 
            "Đã tạo điểm mẫu cho {$createdCount} học sinh. Bỏ qua {$skippedCount} học sinh đã có điểm.");
    }

    /**
     * Xem điểm của một học sinh
     */
    public function viewScores(Student $student)
    {
        $scores = $student->scores()->where('nam_hoc', '2024-2025')->get();
        
        return view('Admin.scores.student-scores-detail', compact('student', 'scores'));
    }

    /**
     * Tạo tài khoản login cho học sinh đã có
     */
    public function createForStudent($studentId)
    {
        $student = Student::findOrFail($studentId);
        
        // Kiểm tra xem học sinh đã có tài khoản chưa
        if ($student->login_id) {
            return redirect()->back()->with('error', 'Học sinh này đã có tài khoản login!');
        }
        
        return view('Admin.accounts.create-login-for-student', compact('student'));
    }

    /**
     * Lưu tài khoản login cho học sinh đã có
     */
    public function storeForStudent(Request $request, $studentId)
    {
        $student = Student::findOrFail($studentId);
        
        // Kiểm tra xem học sinh đã có tài khoản chưa
        if ($student->login_id) {
            return redirect()->back()->with('error', 'Học sinh này đã có tài khoản login!');
        }
        
        $request->validate([
            'username' => 'required|string|max:255|unique:login,username',
            'password' => 'required|string|min:6',
            'is_active' => 'nullable|boolean',
        ]);

        // Tạo tài khoản login
        $login = Login::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => 'Student',
            'is_active' => $request->has('is_active') ? true : false,
        ]);

        // Cập nhật login_id cho học sinh
        $student->update(['login_id' => $login->id]);

        return redirect()->route('admin.student-accounts.index')
            ->with('success', "Tài khoản login cho học sinh {$student->ho_va_ten} đã được tạo thành công!");
    }

    /**
     * Test tạo điểm cho một học sinh
     */
    public function testCreateScores()
    {
        $student = Student::first();
        
        if (!$student) {
            return response()->json(['error' => 'Không có học sinh nào trong database']);
        }

        try {
            $result = $student->createSampleScores('2024-2025');
            
            if ($result) {
                return response()->json([
                    'success' => true,
                    'message' => "Đã tạo điểm mẫu cho học sinh {$student->ho_va_ten}",
                    'student' => $student->ho_va_ten,
                    'scores_count' => $student->scores()->count()
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => "Học sinh {$student->ho_va_ten} đã có điểm rồi",
                    'student' => $student->ho_va_ten,
                    'scores_count' => $student->scores()->count()
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Lỗi khi tạo điểm: ' . $e->getMessage()
            ]);
        }
    }
}
