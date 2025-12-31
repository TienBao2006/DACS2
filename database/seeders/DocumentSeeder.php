<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Document;
use Illuminate\Support\Facades\Storage;

class DocumentSeeder extends Seeder
{
    public function run()
    {
        // Create sample documents
        $documents = [
            [
                'title' => 'Quy chế thi học kỳ 2024-2025',
                'description' => 'Quy định về việc tổ chức thi học kỳ, quy trình làm bài và nộp bài thi cho năm học 2024-2025',
                'file_name' => 'quy-che-thi-hk-2024-2025.pdf',
                'file_path' => 'documents/quy-che-thi-hk-2024-2025.pdf',
                'file_size' => 1024000, // 1MB
                'file_type' => 'application/pdf',
                'category' => 'regulation',
                'is_public' => true,
                'downloads' => 45,
                'tags' => ['quy chế', 'thi cử', 'học kỳ', '2024-2025']
            ],
            [
                'title' => 'Đề thi thử Toán 12 - Lần 1',
                'description' => 'Đề thi thử môn Toán lớp 12 lần 1, chuẩn bị cho kỳ thi tốt nghiệp THPT',
                'file_name' => 'de-thi-thu-toan-12-lan-1.pdf',
                'file_path' => 'documents/de-thi-thu-toan-12-lan-1.pdf',
                'file_size' => 512000, // 512KB
                'file_type' => 'application/pdf',
                'category' => 'exam',
                'is_public' => true,
                'downloads' => 128,
                'tags' => ['đề thi', 'toán', 'lớp 12', 'thi thử']
            ],
            [
                'title' => 'Chương trình học Vật lý 11',
                'description' => 'Chương trình giảng dạy môn Vật lý lớp 11 theo chương trình mới',
                'file_name' => 'chuong-trinh-vat-ly-11.docx',
                'file_path' => 'documents/chuong-trinh-vat-ly-11.docx',
                'file_size' => 256000, // 256KB
                'file_type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'category' => 'curriculum',
                'is_public' => true,
                'downloads' => 67,
                'tags' => ['chương trình', 'vật lý', 'lớp 11']
            ],
            [
                'title' => 'Biểu mẫu đăng ký học bổng',
                'description' => 'Mẫu đơn đăng ký học bổng khuyến học cho học sinh có thành tích xuất sắc',
                'file_name' => 'bieu-mau-dang-ky-hoc-bong.docx',
                'file_path' => 'documents/bieu-mau-dang-ky-hoc-bong.docx',
                'file_size' => 128000, // 128KB
                'file_type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'category' => 'form',
                'is_public' => true,
                'downloads' => 89,
                'tags' => ['biểu mẫu', 'học bổng', 'đăng ký']
            ],
            [
                'title' => 'Đề thi thử Ngữ văn 12 - Lần 2',
                'description' => 'Đề thi thử môn Ngữ văn lớp 12 lần 2, bao gồm phần đọc hiểu và làm văn',
                'file_name' => 'de-thi-thu-ngu-van-12-lan-2.pdf',
                'file_path' => 'documents/de-thi-thu-ngu-van-12-lan-2.pdf',
                'file_size' => 768000, // 768KB
                'file_type' => 'application/pdf',
                'category' => 'exam',
                'is_public' => true,
                'downloads' => 156,
                'tags' => ['đề thi', 'ngữ văn', 'lớp 12', 'thi thử']
            ],
            [
                'title' => 'Báo cáo hoạt động giáo dục 2024',
                'description' => 'Báo cáo tổng kết các hoạt động giáo dục và đào tạo trong năm học 2023-2024',
                'file_name' => 'bao-cao-hoat-dong-giao-duc-2024.pdf',
                'file_path' => 'documents/bao-cao-hoat-dong-giao-duc-2024.pdf',
                'file_size' => 2048000, // 2MB
                'file_type' => 'application/pdf',
                'category' => 'report',
                'is_public' => true,
                'downloads' => 34,
                'tags' => ['báo cáo', 'giáo dục', '2024', 'tổng kết']
            ],
            [
                'title' => 'Tài liệu ôn tập Hóa học 10',
                'description' => 'Tổng hợp kiến thức và bài tập ôn tập môn Hóa học lớp 10',
                'file_name' => 'tai-lieu-on-tap-hoa-10.pdf',
                'file_path' => 'documents/tai-lieu-on-tap-hoa-10.pdf',
                'file_size' => 1536000, // 1.5MB
                'file_type' => 'application/pdf',
                'category' => 'general',
                'is_public' => true,
                'downloads' => 203,
                'tags' => ['ôn tập', 'hóa học', 'lớp 10', 'tài liệu']
            ],
            [
                'title' => 'Thông tư về trang phục học sinh',
                'description' => 'Quy định về trang phục, đồng phục học sinh trong trường học',
                'file_name' => 'thong-tu-trang-phuc-hoc-sinh.pdf',
                'file_path' => 'documents/thong-tu-trang-phuc-hoc-sinh.pdf',
                'file_size' => 384000, // 384KB
                'file_type' => 'application/pdf',
                'category' => 'regulation',
                'is_public' => true,
                'downloads' => 78,
                'tags' => ['thông tư', 'trang phục', 'quy định']
            ]
        ];

        foreach ($documents as $documentData) {
            Document::create($documentData);
        }

        $this->command->info('Created ' . count($documents) . ' sample documents');
    }
}