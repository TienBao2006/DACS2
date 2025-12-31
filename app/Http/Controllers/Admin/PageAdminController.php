<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Student;
use App\Models\TeacherClassSubject;
use App\Models\News;
use App\Models\Document;
use App\Models\Banner;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PageAdminController extends Controller
{
    public function showAdminPage()
    {
        return view('Admin.pageAdmin');
    }

    public function dashboard()
    {
        try {
            // Get statistics for dashboard with error handling
            $stats = [];
            
            // Safe count queries with individual try-catch
            try {
                $stats['total_users'] = User::count();
            } catch (\Exception $e) {
                $stats['total_users'] = 0;
            }
            
            try {
                $stats['total_students'] = Student::count();
            } catch (\Exception $e) {
                $stats['total_students'] = 0;
            }
            
            try {
                $stats['total_teachers'] = DB::table('teacher')->count();
            } catch (\Exception $e) {
                $stats['total_teachers'] = 0;
            }
            
            try {
                $stats['total_classes'] = Student::select('khoi', 'lop')->distinct()->count();
            } catch (\Exception $e) {
                $stats['total_classes'] = 0;
            }
            
            try {
                $stats['total_assignments'] = TeacherClassSubject::count();
            } catch (\Exception $e) {
                $stats['total_assignments'] = 0;
            }
            
            try {
                $stats['total_news'] = News::count();
            } catch (\Exception $e) {
                $stats['total_news'] = 0;
            }
            
            try {
                $stats['total_documents'] = Document::count();
            } catch (\Exception $e) {
                $stats['total_documents'] = 0;
            }
            
            try {
                $stats['total_banners'] = Banner::count();
            } catch (\Exception $e) {
                $stats['total_banners'] = 0;
            }

            // Get recent activities with error handling
            try {
                $recent_news = News::orderBy('created_at', 'desc')->take(5)->get();
            } catch (\Exception $e) {
                $recent_news = collect();
            }
            
            try {
                $recent_documents = Document::orderBy('created_at', 'desc')->take(5)->get();
            } catch (\Exception $e) {
                $recent_documents = collect();
            }
            
            // Get class distribution
            try {
                $class_distribution = Student::select('khoi', DB::raw('count(*) as total'))
                    ->groupBy('khoi')
                    ->orderBy('khoi')
                    ->get();
            } catch (\Exception $e) {
                $class_distribution = collect();
            }

            // Get teacher assignments by subject
            try {
                $subject_assignments = TeacherClassSubject::select('mon_hoc as subject', DB::raw('count(*) as total'))
                    ->groupBy('mon_hoc')
                    ->orderBy('total', 'desc')
                    ->take(10)
                    ->get();
            } catch (\Exception $e) {
                $subject_assignments = collect();
            }

            return view('Admin.user', compact('stats', 'recent_news', 'recent_documents', 'class_distribution', 'subject_assignments'));
        } catch (\Exception $e) {
            // Fallback data in case of errors
            $stats = [
                'total_users' => 0,
                'total_students' => 0,
                'total_teachers' => 0,
                'total_classes' => 0,
                'total_assignments' => 0,
                'total_news' => 0,
                'total_documents' => 0,
                'total_banners' => 0,
            ];

            $recent_news = collect();
            $recent_documents = collect();
            $class_distribution = collect();
            $subject_assignments = collect();

            return view('Admin.user', compact('stats', 'recent_news', 'recent_documents', 'class_distribution', 'subject_assignments'))
                ->with('error', 'Có lỗi khi tải dữ liệu: ' . $e->getMessage());
        }
    }
}
