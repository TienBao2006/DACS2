<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Thêm dữ liệu tin tức mẫu
        $sampleNews = [
            [
                'title' => 'Khai giảng năm học 2024-2025',
                'summary' => 'Lễ khai giảng năm học mới 2024-2025 đã diễn ra trang trọng với sự tham gia của toàn thể thầy cô và học sinh.',
                'content' => '<p>Sáng ngày 5/9/2024, trường THPT ABC đã tổ chức lễ khai giảng năm học 2024-2025 với không khí trang trọng và ý nghĩa. Lễ khai giảng có sự tham gia của Ban Giám hiệu, toàn thể thầy cô giáo và học sinh toàn trường.</p>

<p>Trong bài phát biểu khai giảng, Hiệu trưởng nhà trường đã nhấn mạnh tầm quan trọng của việc học tập và rèn luyện, đồng thời đặt ra những mục tiêu phấn đấu cho năm học mới:</p>

<ul>
<li>Nâng cao chất lượng giảng dạy và học tập</li>
<li>Tăng cường hoạt động ngoại khóa và thể thao</li>
<li>Phát triển kỹ năng sống cho học sinh</li>
<li>Ứng dụng công nghệ thông tin trong giáo dục</li>
</ul>

<p>Năm học 2024-2025, nhà trường tiếp tục đầu tư cơ sở vật chất, nâng cấp phòng học và trang thiết bị hiện đại để tạo môi trường học tập tốt nhất cho các em học sinh.</p>',
                'image' => null,
                'is_featured' => true,
                'is_published' => true,
                'author' => 'Ban Giám hiệu',
                'views' => 245,
                'published_at' => '2024-09-05 08:00:00',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'Thông báo lịch thi học kỳ I năm học 2024-2025',
                'summary' => 'Ban Giám hiệu thông báo lịch thi học kỳ I năm học 2024-2025 cho toàn thể học sinh các khối 10, 11, 12.',
                'content' => '<p>Căn cứ vào kế hoạch năm học 2024-2025, Ban Giám hiệu thông báo lịch thi học kỳ I như sau:</p>

<h3>Thời gian thi:</h3>
<ul>
<li><strong>Khối 10:</strong> Từ ngày 15/12/2024 đến 20/12/2024</li>
<li><strong>Khối 11:</strong> Từ ngày 16/12/2024 đến 21/12/2024</li>
<li><strong>Khối 12:</strong> Từ ngày 17/12/2024 đến 22/12/2024</li>
</ul>

<h3>Các môn thi:</h3>
<p>Tất cả các môn học theo chương trình giáo dục phổ thông hiện hành, bao gồm:</p>
<ul>
<li>Toán, Ngữ văn, Tiếng Anh (bắt buộc)</li>
<li>Vật lý, Hóa học, Sinh học</li>
<li>Lịch sử, Địa lý, GDCD</li>
<li>Tin học, Thể dục</li>
</ul>

<h3>Lưu ý quan trọng:</h3>
<ul>
<li>Học sinh cần mang đầy đủ dụng cụ học tập</li>
<li>Có mặt tại phòng thi trước 15 phút</li>
<li>Không được mang điện thoại vào phòng thi</li>
<li>Nghiêm túc chấp hành quy chế thi</li>
</ul>',
                'image' => null,
                'is_featured' => true,
                'is_published' => true,
                'author' => 'Phòng Đào tạo',
                'views' => 189,
                'published_at' => '2024-12-01 14:30:00',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'Hội thi "Giáo viên dạy giỏi" cấp trường',
                'summary' => 'Trường THPT ABC tổ chức hội thi "Giáo viên dạy giỏi" nhằm nâng cao chất lượng giảng dạy và chia sẻ kinh nghiệm.',
                'content' => '<p>Nhằm nâng cao chất lượng giảng dạy và tạo sân chơi bổ ích cho đội ngũ giáo viên, trường THPT ABC đã tổ chức thành công hội thi "Giáo viên dạy giỏi" cấp trường.</p>

<p>Hội thi diễn ra trong 3 ngày với sự tham gia của 25 giáo viên đến từ các tổ chuyên môn khác nhau. Các tiết dạy được đánh giá dựa trên nhiều tiêu chí:</p>

<ul>
<li>Kỹ năng sư phạm và phương pháp giảng dạy</li>
<li>Sử dụng công nghệ thông tin trong giảng dạy</li>
<li>Tương tác với học sinh</li>
<li>Đổi mới phương pháp đánh giá</li>
</ul>

<p><strong>Kết quả hội thi:</strong></p>
<ul>
<li>Giải Nhất: Cô Nguyễn Thị Lan (Tổ Toán)</li>
<li>Giải Nhì: Thầy Trần Văn Nam (Tổ Lý), Cô Lê Thị Hoa (Tổ Văn)</li>
<li>Giải Ba: Cô Phạm Thị Mai (Tổ Anh), Thầy Vũ Văn Đức (Tổ Sử)</li>
</ul>

<p>Ban Giám hiệu chúc mừng các giáo viên đạt giải và mong muốn toàn thể thầy cô tiếp tục đổi mới phương pháp giảng dạy để nâng cao chất lượng giáo dục.</p>',
                'image' => null,
                'is_featured' => false,
                'is_published' => true,
                'author' => 'Tổ chức - Nhân sự',
                'views' => 156,
                'published_at' => '2024-11-20 10:15:00',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'Chương trình "Ngày hội Khoa học trẻ"',
                'summary' => 'Học sinh trường THPT ABC tham gia Ngày hội Khoa học trẻ với nhiều đề tài nghiên cứu sáng tạo và ý nghĩa.',
                'content' => '<p>Ngày 15/11/2024, trường THPT ABC đã tổ chức thành công "Ngày hội Khoa học trẻ" với chủ đề "Khoa học - Công nghệ vì tương lai bền vững".</p>

<p>Chương trình thu hút sự tham gia của hơn 200 học sinh với 45 đề tài nghiên cứu khoa học thuộc các lĩnh vực:</p>

<h3>Các lĩnh vực tham gia:</h3>
<ul>
<li><strong>Khoa học Tự nhiên:</strong> 18 đề tài</li>
<li><strong>Khoa học Xã hội:</strong> 12 đề tài</li>
<li><strong>Công nghệ - Kỹ thuật:</strong> 10 đề tài</li>
<li><strong>Môi trường - Sinh thái:</strong> 5 đề tài</li>
</ul>

<h3>Một số đề tài nổi bật:</h3>
<ul>
<li>"Ứng dụng AI trong việc phân loại rác thải" - Lớp 12A1</li>
<li>"Nghiên cứu tác động của biến đổi khí hậu đến nông nghiệp địa phương" - Lớp 11B2</li>
<li>"Phát triển ứng dụng học tập trực tuyến cho học sinh THPT" - Lớp 10A3</li>
</ul>

<p>Qua chương trình này, các em học sinh đã thể hiện được tinh thần ham học hỏi, sáng tạo và khả năng nghiên cứu khoa học. Đây là nền tảng quan trọng để các em phát triển tư duy khoa học và chuẩn bị cho việc học tập ở bậc đại học.</p>',
                'image' => null,
                'is_featured' => false,
                'is_published' => true,
                'author' => 'Đoàn - Hội',
                'views' => 134,
                'published_at' => '2024-11-16 09:00:00',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'Kết quả học sinh giỏi cấp tỉnh năm học 2023-2024',
                'summary' => 'Trường THPT ABC đạt thành tích xuất sắc trong kỳ thi học sinh giỏi cấp tỉnh với 15 giải các loại.',
                'content' => '<p>Trường THPT ABC vừa nhận được thông báo kết quả kỳ thi học sinh giỏi cấp tỉnh năm học 2023-2024 với thành tích rất khả quan.</p>

<h3>Kết quả chi tiết:</h3>
<ul>
<li><strong>Giải Nhất:</strong> 3 giải (Toán, Vật lý, Hóa học)</li>
<li><strong>Giải Nhì:</strong> 5 giải (Toán, Ngữ văn, Tiếng Anh, Sinh học, Tin học)</li>
<li><strong>Giải Ba:</strong> 7 giải (các môn Toán, Lý, Hóa, Sinh, Văn, Anh, Sử)</li>
</ul>

<h3>Danh sách học sinh đạt giải Nhất:</h3>
<ul>
<li><strong>Nguyễn Văn A</strong> - Lớp 12A1 - Môn Toán</li>
<li><strong>Trần Thị B</strong> - Lớp 11A2 - Môn Vật lý</li>
<li><strong>Lê Văn C</strong> - Lớp 12A3 - Môn Hóa học</li>
</ul>

<p>Đây là kết quả của sự nỗ lực không ngừng của các em học sinh, sự hướng dẫn tận tình của thầy cô giáo và sự quan tâm của gia đình. Thành tích này không chỉ là niềm tự hào của nhà trường mà còn khẳng định chất lượng giáo dục ngày càng được nâng cao.</p>

<p>Ban Giám hiệu chúc mừng các em học sinh đạt giải và các thầy cô giáo đã hướng dẫn. Đồng thời, nhà trường cam kết sẽ tiếp tục đầu tư và phát triển để tạo điều kiện tốt nhất cho các em học sinh phát huy tài năng.</p>',
                'image' => null,
                'is_featured' => true,
                'is_published' => true,
                'author' => 'Phòng Đào tạo',
                'views' => 298,
                'published_at' => '2024-06-15 16:45:00',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'Lễ tốt nghiệp lớp 12 năm học 2023-2024',
                'summary' => 'Lễ tốt nghiệp lớp 12 đã diễn ra trang trọng với 100% học sinh hoàn thành chương trình THPT.',
                'content' => '<p>Chiều ngày 30/5/2024, trường THPT ABC đã tổ chức lễ tốt nghiệp cho học sinh lớp 12 năm học 2023-2024 trong không khí trang trọng và đầy cảm xúc.</p>

<p>Lễ tốt nghiệp có sự tham gia của Ban Giám hiệu, toàn thể thầy cô giáo, học sinh lớp 12 và phụ huynh. Đây là dịp để ghi nhận những nỗ lực học tập của các em trong suốt 12 năm học phổ thông.</p>

<h3>Thành tích nổi bật của khóa học:</h3>
<ul>
<li><strong>Tỷ lệ tốt nghiệp:</strong> 100%</li>
<li><strong>Học sinh xuất sắc:</strong> 45 em (15%)</li>
<li><strong>Học sinh giỏi:</strong> 120 em (40%)</li>
<li><strong>Học sinh khá:</strong> 105 em (35%)</li>
</ul>

<h3>Kết quả thi THPT Quốc gia:</h3>
<ul>
<li>Điểm trung bình toàn khóa: 7.2/10</li>
<li>Tỷ lệ đậu đại học: 85%</li>
<li>Số học sinh đậu các trường top đầu: 25 em</li>
</ul>

<p>Trong bài phát biểu, Hiệu trưởng đã gửi lời chúc mừng đến các em học sinh và gia đình, đồng thời nhắn nhủ các em hãy luôn giữ vững tinh thần học hỏi, rèn luyện để trở thành những công dân có ích cho xã hội.</p>

<p>Lễ tốt nghiệp kết thúc trong không khí ấm áp với những lời chúc tốt đẹp và hy vọng các em sẽ thành công trên con đường học tập và sự nghiệp trong tương lai.</p>',
                'image' => null,
                'is_featured' => false,
                'is_published' => true,
                'author' => 'Ban Giám hiệu',
                'views' => 412,
                'published_at' => '2024-05-31 08:30:00',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        // Chèn dữ liệu vào bảng news
        foreach ($sampleNews as $news) {
            DB::table('news')->insert($news);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Xóa dữ liệu mẫu
        DB::table('news')->whereIn('title', [
            'Khai giảng năm học 2024-2025',
            'Thông báo lịch thi học kỳ I năm học 2024-2025',
            'Hội thi "Giáo viên dạy giỏi" cấp trường',
            'Chương trình "Ngày hội Khoa học trẻ"',
            'Kết quả học sinh giỏi cấp tỉnh năm học 2023-2024',
            'Lễ tốt nghiệp lớp 12 năm học 2023-2024'
        ])->delete();
    }
};