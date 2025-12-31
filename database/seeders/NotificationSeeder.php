<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Notification;
use Carbon\Carbon;

class NotificationSeeder extends Seeder
{
    public function run()
    {
        $notifications = [
            [
                'title' => 'Thông báo về lịch thi học kỳ 2 năm học 2024-2025',
                'content' => 'Phòng Đào tạo thông báo lịch thi học kỳ 2 năm học 2024-2025. Các em học sinh lưu ý thời gian và địa điểm thi được công bố trên website nhà trường.',
                'type' => 'info',
                'priority' => 'high',
                'is_active' => true,
                'show_on_homepage' => true,
                'show_popup' => false,
                'start_date' => Carbon::now()->subDays(2),
                'end_date' => Carbon::now()->addDays(30),
                'created_by' => 1,
                'view_count' => 245
            ],
            [
                'title' => 'Kế hoạch tổ chức Lễ bế giảng và Tri ân cho khối 12',
                'content' => 'Đoàn Thanh niên thông báo kế hoạch tổ chức Lễ bế giảng và Tri ân cho khối 12. Chương trình dự kiến diễn ra vào ngày 25/05/2024.',
                'type' => 'success',
                'priority' => 'medium',
                'is_active' => true,
                'show_on_homepage' => true,
                'show_popup' => false,
                'start_date' => Carbon::now()->subDays(5),
                'end_date' => Carbon::now()->addDays(20),
                'created_by' => 1,
                'view_count' => 189
            ],
            [
                'title' => 'Thông báo nghỉ lễ Chiến thắng 30/4 và Quốc tế Lao động 1/5',
                'content' => 'Ban Giám hiệu thông báo lịch nghỉ lễ Chiến thắng 30/4 và Quốc tế Lao động 1/5. Học sinh sẽ nghỉ từ ngày 29/4 đến hết ngày 1/5.',
                'type' => 'warning',
                'priority' => 'medium',
                'is_active' => true,
                'show_on_homepage' => true,
                'show_popup' => false,
                'start_date' => Carbon::now()->subDays(10),
                'end_date' => Carbon::now()->addDays(15),
                'created_by' => 1,
                'view_count' => 156
            ],
            [
                'title' => 'Thông báo về việc đóng học phí học kỳ 2',
                'content' => 'Phòng Tài chính - Kế toán thông báo về việc đóng học phí học kỳ 2. Hạn chót đóng học phí là ngày 15/02/2024.',
                'type' => 'danger',
                'priority' => 'urgent',
                'is_active' => true,
                'show_on_homepage' => true,
                'show_popup' => true,
                'start_date' => Carbon::now()->subDays(15),
                'end_date' => Carbon::now()->addDays(10),
                'created_by' => 1,
                'view_count' => 312
            ],
            [
                'title' => 'Cuộc thi "Học sinh với An toàn giao thông"',
                'content' => 'Đoàn trường tổ chức cuộc thi "Học sinh với An toàn giao thông" dành cho toàn thể học sinh. Hạn nộp bài dự thi: 20/05/2024.',
                'type' => 'info',
                'priority' => 'low',
                'is_active' => true,
                'show_on_homepage' => true,
                'show_popup' => false,
                'start_date' => Carbon::now()->subDays(7),
                'end_date' => Carbon::now()->addDays(25),
                'created_by' => 1,
                'view_count' => 98
            ],
            [
                'title' => 'Thông báo tuyển sinh lớp 10 năm học 2024-2025',
                'content' => 'Nhà trường thông báo về việc tuyển sinh lớp 10 năm học 2024-2025. Hồ sơ đăng ký dự thi từ ngày 15/05 đến 30/05/2024.',
                'type' => 'success',
                'priority' => 'high',
                'is_active' => true,
                'show_on_homepage' => true,
                'show_popup' => true,
                'start_date' => Carbon::now()->subDays(3),
                'end_date' => Carbon::now()->addDays(45),
                'created_by' => 1,
                'view_count' => 567
            ],
            [
                'title' => 'Lịch họp phụ huynh cuối năm học',
                'content' => 'Ban Giám hiệu mời các bậc phụ huynh tham dự buổi họp cuối năm học để trao đổi về kết quả học tập của các em.',
                'type' => 'info',
                'priority' => 'medium',
                'is_active' => true,
                'show_on_homepage' => true,
                'show_popup' => false,
                'start_date' => Carbon::now()->subDays(1),
                'end_date' => Carbon::now()->addDays(14),
                'created_by' => 1,
                'view_count' => 134
            ]
        ];

        foreach ($notifications as $notificationData) {
            Notification::create($notificationData);
        }

        $this->command->info('Created ' . count($notifications) . ' sample notifications');
    }
}