<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TimeTableController extends Controller
{
    /**
     * Hiển thị trang quản lý thời khóa biểu
     */
    public function index(Request $request)
    {
        try {
            // Lấy danh sách lớp
            $classes = DB::table('student')
                ->select('lop', 'khoi')
                ->distinct()
                ->orderBy('khoi')
                ->orderBy('lop')
                ->get();

            // Lấy tham số từ request
            $selectedClass = $request->get('lop');
            $selectedYear = $request->get('nam_hoc', '2024-2025');
            $selectedSemester = $request->get('hoc_ky', '1');

            $timetable = [];
            $scheduleCount = 0;
            
            if ($selectedClass) {
                // Lấy thời khóa biểu của lớp được chọn
                $schedules = DB::table('timetable')
                    ->where('lop', $selectedClass)
                    ->where('nam_hoc', $selectedYear)
                    ->where('hoc_ky', $selectedSemester)
                    ->where('is_active', true)
                    ->orderBy('thu')
                    ->orderBy('tiet')
                    ->get();

                $scheduleCount = $schedules->count();

                // Tổ chức dữ liệu theo thứ và tiết
                foreach ($schedules as $schedule) {
                    $thu = $schedule->thu; // Giữ nguyên string ('2', '3', etc.)
                    $tiet = (int)$schedule->tiet;
                    $timetable[$thu][$tiet] = $schedule;
                }
            }

            return view('Admin.timetables.timetable', compact(
                'classes',
                'selectedClass',
                'selectedYear', 
                'selectedSemester',
                'timetable',
                'scheduleCount'
            ));

        } catch (\Exception $e) {
            Log::error('Lỗi trang thời khóa biểu: ' . $e->getMessage());
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    /**
     * Hiển thị form tạo thời khóa biểu theo tuần
     */
    public function createWeekly()
    {
        try {
            // Lấy danh sách lớp
            $classes = DB::table('student')
                ->select('lop', 'khoi')
                ->distinct()
                ->orderBy('khoi')
                ->orderBy('lop')
                ->get();

            // Lấy danh sách giáo viên
            $teachers = Teacher::orderBy('ho_ten')->get();

            return view('Admin.timetables.createWeeklyTimetable', compact('classes', 'teachers'));

        } catch (\Exception $e) {
            Log::error('Lỗi trang tạo thời khóa biểu: ' . $e->getMessage());
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    /**
     * Lưu thời khóa biểu theo tuần
     */
    public function saveWeekly(Request $request)
    {
        try {
            $schedules = $request->input('schedules', []);
            
            if (empty($schedules)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không có dữ liệu để lưu'
                ]);
            }
            
            $firstSchedule = $schedules[0];
            $lop = $firstSchedule['lop'];
            $namHoc = $firstSchedule['nam_hoc'];
            $hocKy = $firstSchedule['hoc_ky'];

            // Xóa dữ liệu cũ của lớp này
            DB::table('timetable')
                ->where('lop', $lop)
                ->where('nam_hoc', $namHoc)
                ->where('hoc_ky', $hocKy)
                ->delete();

            $savedCount = 0;

            // Lưu dữ liệu mới
            foreach ($schedules as $schedule) {
                if (!empty($schedule['mon_hoc'])) {
                    DB::table('timetable')->insert([
                        'lop' => $schedule['lop'],
                        'khoi' => $schedule['khoi'],
                        'thu' => (string)$schedule['thu'], // Đảm bảo là string
                        'tiet' => (int)$schedule['tiet'],
                        'mon_hoc' => $schedule['mon_hoc'],
                        'ma_giao_vien' => $schedule['ma_giao_vien'] ?? null,
                        'ten_giao_vien' => $schedule['ten_giao_vien'] ?? null,
                        'phong_hoc' => $schedule['phong_hoc'] ?? null,
                        'nam_hoc' => $schedule['nam_hoc'],
                        'hoc_ky' => $schedule['hoc_ky'],
                        'is_active' => true,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                    $savedCount++;
                }
            }

            return response()->json([
                'success' => true,
                'message' => "Đã lưu thành công {$savedCount} tiết học cho lớp {$lop}!",
                'saved_count' => $savedCount
            ]);

        } catch (\Exception $e) {
            Log::error('Lỗi lưu thời khóa biểu: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Hiển thị form chỉnh sửa tiết học
     */
    public function edit($id)
    {
        try {
            $schedule = DB::table('timetable')->where('id', $id)->first();
            
            if (!$schedule) {
                return back()->with('error', 'Không tìm thấy tiết học');
            }

            $teachers = Teacher::orderBy('ho_ten')->get();

            return view('Admin.timetables.editTimetable', compact('schedule', 'teachers'));

        } catch (\Exception $e) {
            Log::error('Lỗi trang chỉnh sửa thời khóa biểu: ' . $e->getMessage());
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    /**
     * Cập nhật tiết học
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'mon_hoc' => 'required|string|max:100',
                'ma_giao_vien' => 'nullable|string|max:20',
                'ten_giao_vien' => 'nullable|string|max:100',
                'phong_hoc' => 'nullable|string|max:20'
            ]);

            DB::table('timetable')
                ->where('id', $id)
                ->update([
                    'mon_hoc' => $request->mon_hoc,
                    'ma_giao_vien' => $request->ma_giao_vien,
                    'ten_giao_vien' => $request->ten_giao_vien,
                    'phong_hoc' => $request->phong_hoc,
                    'updated_at' => now()
                ]);

            return redirect()->route('admin.timetable.index')
                ->with('success', 'Đã cập nhật tiết học thành công!');

        } catch (\Exception $e) {
            Log::error('Lỗi cập nhật thời khóa biểu: ' . $e->getMessage());
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    /**
     * Xóa tiết học
     */
    public function destroy($id)
    {
        try {
            $schedule = DB::table('timetable')->where('id', $id)->first();
            
            if (!$schedule) {
                return back()->with('error', 'Không tìm thấy tiết học');
            }

            DB::table('timetable')->where('id', $id)->delete();
            
            return redirect()->route('admin.timetable.index')
                ->with('success', 'Đã xóa tiết học thành công!');

        } catch (\Exception $e) {
            Log::error('Lỗi xóa thời khóa biểu: ' . $e->getMessage());
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    /**
     * API: Lấy giáo viên theo môn học
     */
    public function getTeachersBySubject($subject)
    {
        try {
            Log::info("Getting teachers for subject: {$subject}");
            
            $teachers = Teacher::where('mon_day', 'LIKE', "%{$subject}%")
                ->orWhere('mon_kiem_nhiem', 'LIKE', "%{$subject}%")
                ->orderBy('ho_ten')
                ->get()
                ->map(function($teacher) {
                    return [
                        'ma_giao_vien' => $teacher->ma_giao_vien,
                        'ho_ten' => $teacher->ho_ten,
                        'mon_day' => $teacher->mon_day,
                        'mon_kiem_nhiem' => $teacher->mon_kiem_nhiem
                    ];
                });

            Log::info("Found {$teachers->count()} teachers for subject: {$subject}");
            
            return response()->json($teachers);

        } catch (\Exception $e) {
            Log::error('Lỗi API lấy giáo viên: ' . $e->getMessage());
            return response()->json([
                'error' => 'Có lỗi xảy ra',
                'message' => $e->getMessage(),
                'subject' => $subject
            ], 500);
        }
    }

    /**
     * API: Lấy thời khóa biểu hiện có
     */
    public function getExistingSchedules(Request $request)
    {
        try {
            $lop = $request->get('lop');
            $namHoc = $request->get('nam_hoc', '2024-2025');
            $hocKy = $request->get('hoc_ky', '1');

            if (!$lop) {
                return response()->json(['error' => 'Thiếu thông tin lớp học'], 400);
            }

            $schedules = DB::table('timetable')
                ->where('lop', $lop)
                ->where('nam_hoc', $namHoc)
                ->where('hoc_ky', $hocKy)
                ->where('is_active', true)
                ->orderBy('thu')
                ->orderBy('tiet')
                ->get();

            return response()->json($schedules);

        } catch (\Exception $e) {
            Log::error('Lỗi API lấy thời khóa biểu: ' . $e->getMessage());
            return response()->json(['error' => 'Có lỗi xảy ra'], 500);
        }
    }

    /**
     * API: Alias methods for backward compatibility
     */
    public function getWeeklySchedules(Request $request)
    {
        return $this->getExistingSchedules($request);
    }

    public function getBysubject($subject)
    {
        return $this->getTeachersBySubject($subject);
    }

    /**
     * Debug: Test teacher data retrieval
     */
    public function testTeacherData()
    {
        try {
            $allTeachers = Teacher::select('ma_giao_vien', 'ho_ten', 'mon_day', 'mon_kiem_nhiem')
                ->orderBy('ho_ten')
                ->take(10)
                ->get();

            $testSubject = 'Toán';
            $teachersForMath = Teacher::where('mon_day', 'LIKE', "%{$testSubject}%")
                ->orWhere('mon_kiem_nhiem', 'LIKE', "%{$testSubject}%")
                ->select('ma_giao_vien', 'ho_ten', 'mon_day', 'mon_kiem_nhiem')
                ->get();

            return response()->json([
                'total_teachers' => Teacher::count(),
                'sample_teachers' => $allTeachers,
                'math_teachers' => $teachersForMath,
                'test_subject' => $testSubject
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Fix missing teacher names in existing timetable records
     */
    public function fixMissingTeacherNames()
    {
        try {
            // Find records with ma_giao_vien but missing ten_giao_vien
            $recordsToFix = DB::table('timetable')
                ->whereNotNull('ma_giao_vien')
                ->where('ma_giao_vien', '!=', '')
                ->where(function($query) {
                    $query->whereNull('ten_giao_vien')
                          ->orWhere('ten_giao_vien', '')
                          ->orWhere('ten_giao_vien', 'undefined');
                })
                ->get();

            $fixedCount = 0;
            $errors = [];

            foreach ($recordsToFix as $record) {
                $teacher = Teacher::where('ma_giao_vien', $record->ma_giao_vien)->first();
                
                if ($teacher) {
                    DB::table('timetable')
                        ->where('id', $record->id)
                        ->update([
                            'ten_giao_vien' => $teacher->ho_ten,
                            'updated_at' => now()
                        ]);
                    $fixedCount++;
                } else {
                    $errors[] = "Teacher not found for ma_giao_vien: {$record->ma_giao_vien} (record ID: {$record->id})";
                }
            }

            return response()->json([
                'success' => true,
                'message' => "Fixed {$fixedCount} records",
                'total_records_found' => $recordsToFix->count(),
                'fixed_count' => $fixedCount,
                'errors' => $errors
            ]);

        } catch (\Exception $e) {
            Log::error('Error fixing teacher names: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Xóa tất cả dữ liệu thời khóa biểu (chỉ dùng để debug)
     */
    public function clearAllData()
    {
        try {
            $deletedCount = DB::table('timetable')->delete();
            
            return response()->json([
                'success' => true,
                'message' => "Đã xóa {$deletedCount} bản ghi thành công!",
                'deleted_count' => $deletedCount
            ]);

        } catch (\Exception $e) {
            Log::error('Lỗi xóa tất cả dữ liệu: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Debug thông tin mapping
     */
    public function debugMapping()
    {
        try {
            $sampleData = DB::table('timetable')
                ->select('thu', 'tiet', 'mon_hoc', 'lop')
                ->take(20)
                ->get();

            $debugInfo = [
                'database_structure' => DB::select('DESCRIBE timetable'),
                'sample_data' => $sampleData,
                'day_mapping' => [
                    '2' => 'Thứ Hai (Monday)',
                    '3' => 'Thứ Ba (Tuesday)', 
                    '4' => 'Thứ Tư (Wednesday)',
                    '5' => 'Thứ Năm (Thursday)',
                    '6' => 'Thứ Sáu (Friday)',
                    '7' => 'Thứ Bảy (Saturday)'
                ],
                'total_records' => DB::table('timetable')->count(),
                'active_records' => DB::table('timetable')->where('is_active', true)->count()
            ];

            return response()->json($debugInfo);

        } catch (\Exception $e) {
            Log::error('Lỗi debug mapping: ' . $e->getMessage());
            return response()->json(['error' => 'Có lỗi xảy ra'], 500);
        }
    }
}