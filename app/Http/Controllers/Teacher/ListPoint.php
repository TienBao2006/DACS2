<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Score;
use App\Models\Scores;
use Illuminate\Http\Request;

class ListPoint extends Controller
{
    public function index()
    {
        
    }

    public function store(Request $request)
    {
        $maGiaoVien = auth()->user()->teacher->ma_giao_vien;

        foreach ($request->scores as $score) {
            Scores::updateOrCreate(
                [
                    'student_id' => $score['student_id'],
                    'ma_giao_vien' => $maGiaoVien,
                ],
                [
                    'diem_mieng_1' => $score['diem_mieng_1'] ?? null,
                    'diem_mieng_2' => $score['diem_mieng_2'] ?? null,
                    'diem_mieng_3' => $score['diem_mieng_3'] ?? null,
                    'diem_mieng_4' => $score['diem_mieng_4'] ?? null,
                    'diem_15p'     => $score['diem_15p'] ?? null,
                    'diem_Gk'      => $score['diem_Gk'] ?? null,
                    'diem_Ck'      => $score['diem_Ck'] ?? null,
                    'diem_hk'      => $score['diem_hk'] ?? null,
                ]
            );
        }

        return back()->with('success', 'Lưu điểm thành công');
    }
}
