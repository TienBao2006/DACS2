<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\News;
use Carbon\Carbon;

class NewsSeeder extends Seeder
{
    public function run()
    {
        $news = [
            [
                'title' => 'Khai giảng năm học 2024-2025',
                'summary' => 'Lễ khai giảng năm học mới 2024-2025 đã diễn ra trang trọng với sự tham gia của toàn thể thầy cô và học sinh.',
                'content' => 'Sáng ngày 5/9/2024, Trường THPT Bách Khoa Lịch Sử đã tổ chức Lễ khai giảng năm học 2024-2025 với không khí trang trọng và ý nghĩa. Buổi lễ có sự tham gia của Ban Giám hiệu, toàn thể thầy cô giáo và học sinh các khối lớp. Trong bài phát biểu khai giảng, Hiệu trưởng nhà trường đã nhấn mạnh tầm quan trọng của việc học tập và rèn luyện, đồng thời đặt ra những mục tiêu phấn đấu cho năm học mới.',
                'image' => 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=800&h=400&fit=crop',
                'is_featured' => true,
                'is_published' => true,
                'author' => 'Ban Giám hiệu',
                'views' => 245,
                'published_at' => Carbon::now()->subDays(2)
            ],
            [
                'title' => 'Thông báo lịch thi học kỳ I năm học 2024-2025',
                'summary' => 'Ban Giám hiệu thông báo lịch thi học kỳ I năm học 2024-2025 cho toàn thể học sinh các khối 10, 11, 12.',
                'content' => 'Căn cứ vào kế hoạch năm học 2024-2025, Ban Giám hiệu thông báo lịch thi học kỳ I như sau: Thời gian thi từ ngày 15/12/2024 đến 20/12/2024. Các em học sinh cần chuẩn bị tốt kiến thức và lưu ý các quy định trong phòng thi. Lịch thi chi tiết sẽ được thông báo cụ thể cho từng lớp.',
                'image' => 'https://images.unsplash.com/photo-1434030216411-0b793f4b4173?w=800&h=400&fit=crop',
                'is_featured' => false,
                'is_published' => true,
                'author' => 'Phòng Đào tạo',
                'views' => 189,
                'published_at' => Carbon::now()->subDays(5)
            ],
            [
                'title' => 'Hội thi "Giáo viên dạy giỏi" cấp trường',
                'summary' => 'Trường THPT Bách Khoa Lịch Sử tổ chức hội thi "Giáo viên dạy giỏi" nhằm nâng cao chất lượng giảng dạy và chia sẻ kinh nghiệm.',
                'content' => 'Từ ngày 10-15/12/2024, nhà trường tổ chức Hội thi "Giáo viên dạy giỏi" cấp trường với sự tham gia của 25 giáo viên đến từ các tổ bộ môn. Hội thi nhằm tạo sân chơi bổ ích cho các thầy cô giáo thể hiện năng lực chuyên môn, chia sẻ kinh nghiệm giảng dạy và học hỏi lẫn nhau.',
                'image' => 'https://images.unsplash.com/photo-1577896851231-70ef18881754?w=800&h=400&fit=crop',
                'is_featured' => true,
                'is_published' => true,
                'author' => 'Tổ chức - Nhân sự',
                'views' => 156,
                'published_at' => Carbon::now()->subDays(7)
            ],
            [
                'title' => 'Học sinh đạt giải Nhất cuộc thi KHKT Quốc gia',
                'summary' => 'Đội tuyển Robotics của trường đã xuất sắc vượt qua hàng trăm đội thi để giành huy chương vàng với dự án cánh tay robot hỗ trợ người khuyết tật.',
                'content' => 'Tại cuộc thi Khoa học Kỹ thuật Quốc gia năm 2024, đội tuyển Robotics gồm 3 học sinh lớp 11A1 đã giành giải Nhất với dự án "Cánh tay robot hỗ trợ người khuyết tật". Đây là thành tích đáng tự hào của nhà trường và là kết quả của quá trình nghiên cứu, chế tạo công phu trong suốt 8 tháng.',
                'image' => 'https://images.unsplash.com/photo-1485827404703-89b55fcc595e?w=800&h=400&fit=crop',
                'is_featured' => true,
                'is_published' => true,
                'author' => 'Đoàn Thanh niên',
                'views' => 312,
                'published_at' => Carbon::now()->subDays(10)
            ],
            [
                'title' => 'Hội thảo hướng nghiệp: "Định vị bản thân - Kiến tạo tương lai"',
                'summary' => 'Chương trình thu hút sự tham gia của hơn 500 học sinh khối 12 cùng các diễn giả nổi tiếng đến từ các trường đại học hàng đầu.',
                'content' => 'Ngày 20/11/2024, nhà trường tổ chức Hội thảo hướng nghiệp với chủ đề "Định vị bản thân - Kiến tạo tương lai" dành cho học sinh khối 12. Hội thảo có sự tham gia của các chuyên gia tư vấn từ ĐH Bách Khoa, ĐH Kinh tế Quốc dân, ĐH Y Hà Nội... giúp các em định hướng nghề nghiệp phù hợp.',
                'image' => 'https://images.unsplash.com/photo-1560472354-b33ff0c44a43?w=800&h=400&fit=crop',
                'is_featured' => false,
                'is_published' => true,
                'author' => 'Phòng Hướng nghiệp',
                'views' => 198,
                'published_at' => Carbon::now()->subDays(12)
            ],
            [
                'title' => 'Khai mạc giải bóng đá nam học sinh chào mừng ngày thành lập Đoàn',
                'summary' => 'Không khí sôi động tại sân vận động trường với những trận cầu kịch tính ngay từ vòng bảng.',
                'content' => 'Nhân dịp kỷ niệm 93 năm ngày thành lập Đoàn TNCS Hồ Chí Minh, Đoàn trường tổ chức Giải bóng đá nam học sinh với sự tham gia của 16 đội bóng đại diện cho các lớp. Giải đấu diễn ra từ ngày 15-25/3/2024 với tinh thần "Đoàn kết - Thể thao - Phát triển".',
                'image' => 'https://images.unsplash.com/photo-1574629810360-7efbbe195018?w=800&h=400&fit=crop',
                'is_featured' => false,
                'is_published' => true,
                'author' => 'Đoàn Thanh niên',
                'views' => 167,
                'published_at' => Carbon::now()->subDays(15)
            ],
            [
                'title' => 'Chương trình "Mùa đông ấm áp" hỗ trợ học sinh có hoàn cảnh khó khăn',
                'summary' => 'Nhà trường phối hợp với các nhà hảo tâm trao tặng 50 suất quà cho học sinh có hoàn cảnh khó khăn.',
                'content' => 'Trong không khí Tết Nguyên đán Ất Tỵ 2025, chương trình "Mùa đông ấm áp" do nhà trường phối hợp với Hội Khuyến học tỉnh tổ chức đã trao tặng 50 suất quà, mỗi suất trị giá 500.000 đồng cho các em học sinh có hoàn cảnh khó khăn nhưng có thành tích học tập tốt.',
                'image' => 'https://images.unsplash.com/photo-1559027615-cd4628902d4a?w=800&h=400&fit=crop',
                'is_featured' => false,
                'is_published' => true,
                'author' => 'Hội Khuyến học',
                'views' => 134,
                'published_at' => Carbon::now()->subDays(18)
            ],
            [
                'title' => 'Thông báo tuyển sinh lớp 10 năm học 2024-2025',
                'summary' => 'Nhà trường thông báo về việc tuyển sinh lớp 10 năm học 2024-2025. Hồ sơ đăng ký dự thi từ ngày 15/05 đến 30/05/2024.',
                'content' => 'Căn cứ Thông tư của Bộ GD&ĐT về tuyển sinh lớp 10, nhà trường thông báo kế hoạch tuyển sinh năm học 2024-2025. Chỉ tiêu tuyển sinh: 450 học sinh (15 lớp). Thời gian nộp hồ sơ từ 15/05 đến 30/05/2024. Kỳ thi tuyển sinh dự kiến diễn ra vào đầu tháng 6/2024.',
                'image' => 'https://images.unsplash.com/photo-1427504494785-3a9ca7044f45?w=800&h=400&fit=crop',
                'is_featured' => true,
                'is_published' => true,
                'author' => 'Phòng Tuyển sinh',
                'views' => 567,
                'published_at' => Carbon::now()->subDays(20)
            ]
        ];

        foreach ($news as $newsData) {
            News::create($newsData);
        }

        $this->command->info('Created ' . count($news) . ' sample news articles');
    }
}