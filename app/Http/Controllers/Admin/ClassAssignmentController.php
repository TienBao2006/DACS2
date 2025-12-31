<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TeacherClassSubject;
use App\Models\Teacher;
use App\Models\Student;
use Illuminate\Support\Facades\DB;

class ClassAssignmentController extends Controller
{
    public function index(Request $request)
    {
        $academicYear = $request->get('nam_hoc', '2024-2025');
        $selectedClass = $request->get('lop', '');
        $selectedSubject = $request->get('mon_hoc', '');

        $assignments = TeacherClassSubject::with('teacher')
            ->byAcademicYear($academicYear)
            ->when($selectedClass, function($query) use ($selectedClass) {
                return $query->where('lop', $selectedClass);
            })
            ->when($selectedSubject, function($query) use ($selectedSubject) {
                return $query->where('mon_hoc', $selectedSubject);
            })
            ->orderBy('khoi')
            ->orderBy('lop')
            ->orderBy('mon_hoc')
            ->get();

        foreach ($assignments as $assignment) {
            $className = $assignment->khoi . $assignment->lop;
            
            $assignment->timetable_count = \App\Models\Timetable::where('lop', $className)
                ->where('mon_hoc', $assignment->mon_hoc)
                ->where('ma_giao_vien', $assignment->ma_giao_vien)
                ->where('nam_hoc', $academicYear)
                ->count();
        }

        $classes = Student::select('khoi', 'lop')
            ->distinct()
            ->orderBy('khoi')
            ->orderBy('lop')
            ->get()
            ->map(function($item) {
                return $item->khoi . $item->lop;
            })
            ->unique()
            ->values();

        $subjects = [
            'Toán', 'Ngữ văn', 'Tiếng Anh', 'Vật lý', 'Hóa học', 
            'Sinh học', 'Lịch sử', 'Địa lý', 'GDCD', 'Thể dục', 
            'Tin học', 'Công nghệ', 'Âm nhạc', 'Mỹ thuật'
        ];

        $teachers = Teacher::select('ma_giao_vien', 'ho_ten', 'mon_day')
            ->orderBy('ho_ten')
            ->get();

        return view('Admin.classAssignment', compact(
            'assignments', 
            'classes', 
            'subjects', 
            'teachers', 
            'academicYear', 
            'selectedClass', 
            'selectedSubject'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ma_giao_vien' => 'required|exists:teacher,ma_giao_vien',
            'khoi' => 'required|string',
            'lop' => 'required|string',
            'mon_hoc' => 'required|string',
            'nam_hoc' => 'required|string'
        ]);

        $existing = TeacherClassSubject::where([
            'khoi' => $request->khoi,
            'lop' => $request->lop,
            'mon_hoc' => $request->mon_hoc,
            'nam_hoc' => $request->nam_hoc
        ])->first();

        if ($existing) {
            return redirect()->back()->with('error', 'Môn học này đã được phân công cho lớp ' . $request->khoi . $request->lop);
        }

        TeacherClassSubject::create([
            'ma_giao_vien' => $request->ma_giao_vien,
            'khoi' => $request->khoi,
            'lop' => $request->lop,
            'mon_hoc' => $request->mon_hoc,
            'nam_hoc' => $request->nam_hoc
        ]);

        return redirect()->back()->with('success', 'Phân công giảng dạy thành công!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'ma_giao_vien' => 'required|exists:teacher,ma_giao_vien',
            'khoi' => 'required|string',
            'lop' => 'required|string',
            'mon_hoc' => 'required|string',
            'nam_hoc' => 'required|string'
        ]);

        $assignment = TeacherClassSubject::findOrFail($id);

        $existing = TeacherClassSubject::where([
            'khoi' => $request->khoi,
            'lop' => $request->lop,
            'mon_hoc' => $request->mon_hoc,
            'nam_hoc' => $request->nam_hoc
        ])->where('id', '!=', $id)->first();

        if ($existing) {
            return redirect()->back()->with('error', 'Môn học này đã được phân công cho lớp ' . $request->khoi . $request->lop);
        }

        $assignment->update([
            'ma_giao_vien' => $request->ma_giao_vien,
            'khoi' => $request->khoi,
            'lop' => $request->lop,
            'mon_hoc' => $request->mon_hoc,
            'nam_hoc' => $request->nam_hoc
        ]);

        return redirect()->back()->with('success', 'Cập nhật phân công thành công!');
    }

    public function destroy($id)
    {
        $assignment = TeacherClassSubject::findOrFail($id);
        $assignment->delete();

        return redirect()->back()->with('success', 'Xóa phân công thành công!');
    }

    public function getTeachersBySubject($subject)
    {
        $subjectMapping = [
            'Toán' => ['Toán', 'Toan'],
            'Ngữ văn' => ['Ngữ văn', 'Van'],
            'Tiếng Anh' => ['Tiếng Anh', 'TiengAnh'],
            'Vật lý' => ['Vật lý', 'Ly'],
            'Hóa học' => ['Hóa học', 'Hoa'],
            'Sinh học' => ['Sinh học', 'Sinh'],
            'Lịch sử' => ['Lịch sử', 'Su'],
            'Địa lý' => ['Địa lý', 'Dia'],
            'GDCD' => ['GDCD'],
            'Thể dục' => ['Thể dục', 'TheDuc'],
            'Tin học' => ['Tin học', 'Tin'],
            'Công nghệ' => ['Công nghệ', 'CongNghe'],
            'Âm nhạc' => ['Âm nhạc', 'AmNhac'],
            'Mỹ thuật' => ['Mỹ thuật', 'MyThuat']
        ];

        $searchTerms = $subjectMapping[$subject] ?? [$subject];
        
        $teachers = Teacher::where(function($query) use ($searchTerms) {
            foreach ($searchTerms as $term) {
                $query->orWhere('mon_day', 'LIKE', '%' . $term . '%')
                      ->orWhere('mon_kiem_nhiem', 'LIKE', '%' . $term . '%');
            }
        })
        ->select('ma_giao_vien', 'ho_ten', 'mon_day')
        ->get();

        return response()->json($teachers);
    }

    public function bulkAssign(Request $request)
    {
        $request->validate([
            'assignments' => 'required|array',
            'assignments.*.ma_giao_vien' => 'required|exists:teacher,ma_giao_vien',
            'assignments.*.khoi' => 'required|string',
            'assignments.*.lop' => 'required|string',
            'assignments.*.mon_hoc' => 'required|string',
            'assignments.*.nam_hoc' => 'required|string'
        ]);

        DB::beginTransaction();
        try {
            $successCount = 0;
            $errorCount = 0;

            foreach ($request->assignments as $assignmentData) {
                $existing = TeacherClassSubject::where([
                    'khoi' => $assignmentData['khoi'],
                    'lop' => $assignmentData['lop'],
                    'mon_hoc' => $assignmentData['mon_hoc'],
                    'nam_hoc' => $assignmentData['nam_hoc']
                ])->first();

                if (!$existing) {
                    TeacherClassSubject::create($assignmentData);
                    $successCount++;
                } else {
                    $errorCount++;
                }
            }

            DB::commit();
            
            $message = "Phân công thành công: {$successCount} bản ghi";
            if ($errorCount > 0) {
                $message .= ", Bỏ qua {$errorCount} bản ghi trùng lặp";
            }

            return redirect()->back()->with('success', $message);

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function exportTemplate()
    {
        return redirect()->back()->with('info', 'Chức năng xuất template đang được phát triển');
    }

    public function getClassStatistics($academicYear = '2024-2025')
    {
        $statistics = DB::table('teacher_class_subject as tcs')
            ->join('teacher as t', 'tcs.ma_giao_vien', '=', 't.ma_giao_vien')
            ->where('tcs.nam_hoc', $academicYear)
            ->select(
                'tcs.khoi',
                'tcs.lop',
                DB::raw('COUNT(DISTINCT tcs.mon_hoc) as total_subjects'),
                DB::raw('COUNT(DISTINCT tcs.ma_giao_vien) as total_teachers')
            )
            ->groupBy('tcs.khoi', 'tcs.lop')
            ->orderBy('tcs.khoi')
            ->orderBy('tcs.lop')
            ->get();

        foreach ($statistics as $stat) {
            $className = $stat->khoi . $stat->lop;
            
            $stat->timetable_periods = \App\Models\Timetable::where('lop', $className)
                ->where('nam_hoc', $academicYear)
                ->count();
            
            $stat->timetable_subjects = \App\Models\Timetable::where('lop', $className)
                ->where('nam_hoc', $academicYear)
                ->distinct('mon_hoc')
                ->count();
            
            $assignedSubjects = TeacherClassSubject::where('khoi', $stat->khoi)
                ->where('lop', $stat->lop)
                ->where('nam_hoc', $academicYear)
                ->pluck('mon_hoc')
                ->unique()
                ->count();
            
            $stat->sync_status = ($stat->timetable_subjects == $assignedSubjects) ? 'synced' : 'not_synced';
        }

        return response()->json($statistics);
    }

    public function integrationGuide()
    {
        return redirect()->route('admin.user')->with('info', 'Hướng dẫn tích hợp đang được phát triển');
    }

    public function debugClassData()
    {
        $assignments = TeacherClassSubject::with('teacher')->take(10)->get();
        $timetables = \App\Models\Timetable::take(10)->get();
        
        $debug = [
            'assignments' => $assignments->map(function($a) {
                return [
                    'id' => $a->id,
                    'khoi' => $a->khoi,
                    'lop' => $a->lop,
                    'combined' => $a->khoi . $a->lop,
                    'mon_hoc' => $a->mon_hoc,
                    'ma_giao_vien' => $a->ma_giao_vien
                ];
            }),
            'timetables' => $timetables->map(function($t) {
                return [
                    'id' => $t->id,
                    'lop' => $t->lop,
                    'khoi' => $t->khoi,
                    'mon_hoc' => $t->mon_hoc,
                    'ma_giao_vien' => $t->ma_giao_vien
                ];
            })
        ];
        
        return response()->json($debug);
    }
}