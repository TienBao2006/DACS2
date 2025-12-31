<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;

class ManageStudent extends Controller
{
    public function index(Request $request)
    {
        $query = Student::query();

        // Tìm kiếm theo tên, mã học sinh, lớp
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('ho_va_ten', 'LIKE', "%{$search}%")
                  ->orWhere('ma_hoc_sinh', 'LIKE', "%{$search}%")
                  ->orWhere('lop', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        // Lọc theo khối
        if ($request->filled('khoi_filter')) {
            $query->where('khoi', $request->khoi_filter);
        }

        // Lọc theo lớp
        if ($request->filled('lop_filter')) {
            $query->where('lop', $request->lop_filter);
        }

        // Lọc theo trạng thái
        if ($request->filled('trang_thai_filter')) {
            $query->where('trang_thai', $request->trang_thai_filter);
        }

        // Sắp xếp
        $sortBy = $request->get('sort_by', 'ho_va_ten');
        $sortOrder = $request->get('sort_order', 'asc');
        $query->orderBy($sortBy, $sortOrder);

        $students = $query->paginate(20)->appends($request->query());

        // Lấy danh sách lớp để hiển thị trong filter
        $classes = Student::select('lop')->distinct()->orderBy('lop')->pluck('lop');

        return redirect()->route('admin.student-accounts.index');
    }

    // Tạo mã học sinh tự động theo lớp
    private function generateStudentCode($khoi, $lop)
    {
        // Lấy số thứ tự học sinh trong lớp
        $countInClass = Student::where('lop', $lop)->count() + 1;
        
        // Tạo mã theo format: [Khối][Lớp][STT]
        // VD: 10A101, 11B205, 12C310
        $lopCode = str_replace($khoi, '', $lop); // Loại bỏ số khối khỏi tên lớp
        $stt = str_pad($countInClass, 2, '0', STR_PAD_LEFT);
        
        return $khoi . $lopCode . $stt;
    }

    //ADD học sinh
    public function store(Request $request)
    {
        $request->validate([
            'ho_va_ten' => 'required|string|max:255',
            'ngay_sinh' => 'required|date',
            'gioi_tinh' => 'required',
            'khoi' => 'required',
            'lop' => 'required',
            'dia_chi' => 'nullable|string',
            'so_dien_thoai' => 'nullable',
            'email' => 'nullable|email',

        ]);

        // Tự động tạo mã học sinh theo lớp
        $maHocSinh = $this->generateStudentCode($request->khoi, $request->lop);
        
        // Kiểm tra trùng lặp và tạo mã mới nếu cần
        while (Student::where('ma_hoc_sinh', $maHocSinh)->exists()) {
            $countInClass = Student::where('lop', $request->lop)->count() + 1;
            $lopCode = str_replace($request->khoi, '', $request->lop);
            $stt = str_pad($countInClass, 2, '0', STR_PAD_LEFT);
            $maHocSinh = $request->khoi . $lopCode . $stt;
            $countInClass++;
        }

        Student::create([
            'ma_hoc_sinh' => $maHocSinh,
            'ho_va_ten'   => $request->ho_va_ten,
            'ngay_sinh'   => $request->ngay_sinh,
            'gioi_tinh'   => $request->gioi_tinh,
            'dia_chi'     => $request->dia_chi,
            'so_dien_thoai' => $request->so_dien_thoai,
            'email'         => $request->email,
            'khoi'          => $request->khoi,
            'lop'           => $request->lop,
            'nam_hoc'       => $request->nam_hoc,
            'ten_cha'       => $request->ten_cha,
            'ten_me'        => $request->ten_me,
            'sdt_phu_huynh' => $request->sdt_phu_huynh,
            'trang_thai'    => $request->trang_thai ?? 'Đang học',
            'ghi_chu'       => $request->ghi_chu,
        ]);

        return redirect()->route('admin.students')->with('success', 'Thêm học sinh thành công!');
    }
    // Hiển thị form sửa học sinh
    public function edit($id)
    {
        $student = Student::findOrFail($id);
        return redirect()->route('admin.student-accounts.edit', $id);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'ho_va_ten' => 'required|string|max:255',
            'ngay_sinh' => 'required|date',
            'gioi_tinh' => 'required',
            'lop'       => 'required',
            'khoi'      => 'required',
            'dia_chi'   => 'nullable|string',

        ]);
        $students = Student::findOrFail($id);
        $students->update($request->all());

        return redirect()->route('admin.students')->with('success', 'Cập nhật thành công!');
    }

    // Xóa học sinh
    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();

        return redirect()->route('admin.students')->with('success', 'Xóa học sinh thành công!');
    }

    // Preview mã học sinh khi chọn lớp
    public function previewStudentCode($khoi, $lop)
    {
        $maHocSinh = $this->generateStudentCode($khoi, $lop);
        
        return response()->json([
            'ma_hoc_sinh' => $maHocSinh,
            'so_hoc_sinh_trong_lop' => Student::where('lop', $lop)->count()
        ]);
    }
}
