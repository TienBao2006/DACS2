<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Banner;

class BannerSeeder extends Seeder
{
    public function run()
    {
        $banners = [
            [
                'title' => 'Chào mừng năm học mới 2024-2025',
                'description' => 'Trường THPT Bách Khoa Lịch Sử chào đón năm học mới với nhiều hoạt động bổ ích',
                'image_path' => 'banner-1.jpg',
                'link_url' => '/news',
                'is_active' => true,
                'sort_order' => 1
            ],
            [
                'title' => 'Tuyển sinh lớp 10 năm học 2024-2025',
                'description' => 'Thông tin tuyển sinh và hướng dẫn đăng ký dự thi vào lớp 10',
                'image_path' => 'banner-2.jpg',
                'link_url' => '/admissions',
                'is_active' => true,
                'sort_order' => 2
            ],
            [
                'title' => 'Hội thi Giáo viên dạy giỏi',
                'description' => 'Nâng cao chất lượng giảng dạy và chia sẻ kinh nghiệm',
                'image_path' => 'banner-3.jpg',
                'link_url' => '/teachers',
                'is_active' => true,
                'sort_order' => 3
            ]
        ];

        foreach ($banners as $bannerData) {
            Banner::create($bannerData);
        }

        $this->command->info('Created ' . count($banners) . ' sample banners');
    }
}