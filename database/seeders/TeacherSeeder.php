<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Teacher;

class TeacherSeeder extends Seeder
{
    public function run()
    {
        $teachers = [
            [
                'ma_giao_vien' => 'GV001',
                'ho_ten' => 'Nguyễn Thị Lan Anh',
                'gioi_tinh' => 'Nữ',
                'ngay_sinh' => '1985-03-15',
                'anh_dai_dien' => 'teacher-1.jpg',
                'cccd' => '001085123456',
                'so_dien_thoai' => '0912345678',
                'email' => 'lananh@thptbachkhoa.edu.vn',
                'dia_chi' => '123 Đường ABC, Quận 1, TP.HCM',
                'bang_cap' => 'Thạc sĩ Ngữ văn',
                'trinh_do_chuyen_mon' => 'Thạc sĩ',
                'to_chuyen_mon' => 'Tổ Ngữ văn',
                'mon_day' => 'Ngữ văn',
                'mon_kiem_nhiem' => 'Lịch sử',
                'nam_cong_tac' => 2010,
                'chuc_vu' => 'Tổ trưởng Ngữ văn',
                'lop_chu_nhiem' => '12A1',
                'mo_ta' => 'Giáo viên giàu kinh nghiệm với 14 năm giảng dạy. Đã đạt nhiều giải thưởng trong các cuộc thi giáo viên dạy giỏi cấp thành phố.',
            ],
            [
                'ma_giao_vien' => 'GV002',
                'ho_ten' => 'Trần Văn Minh',
                'gioi_tinh' => 'Nam',
                'ngay_sinh' => '1982-07-22',
                'anh_dai_dien' => 'teacher-2.jpg',
                'cccd' => '001082654321',
                'so_dien_thoai' => '0987654321',
                'email' => 'vanminh@thptbachkhoa.edu.vn',
                'dia_chi' => '456 Đường XYZ, Quận 3, TP.HCM',
                'bang_cap' => 'Thạc sĩ Toán học',
                'trinh_do_chuyen_mon' => 'Thạc sĩ',
                'to_chuyen_mon' => 'Tổ Toán - Tin',
                'mon_day' => 'Toán',
                'mon_kiem_nhiem' => 'Tin học',
                'nam_cong_tac' => 2008,
                'chuc_vu' => 'Phó Hiệu trưởng',
                'lop_chu_nhiem' => '11A2',
                'mo_ta' => 'Chuyên gia về phương pháp giảng dạy Toán hiện đại. Tác giả của nhiều bài báo khoa học về giáo dục.',
            ],
            [
                'ma_giao_vien' => 'GV003',
                'ho_ten' => 'Lê Thị Hương',
                'gioi_tinh' => 'Nữ',
                'ngay_sinh' => '1988-11-08',
                'anh_dai_dien' => 'teacher-3.jpg',
                'cccd' => '001088789123',
                'so_dien_thoai' => '0901234567',
                'email' => 'thihuong@thptbachkhoa.edu.vn',
                'dia_chi' => '789 Đường DEF, Quận 5, TP.HCM',
                'bang_cap' => 'Cử nhân Hóa học',
                'trinh_do_chuyen_mon' => 'Cử nhân',
                'to_chuyen_mon' => 'Tổ Hóa - Sinh',
                'mon_day' => 'Hóa học',
                'mon_kiem_nhiem' => null,
                'nam_cong_tac' => 2012,
                'chuc_vu' => 'Giáo viên',
                'lop_chu_nhiem' => '10A3',
                'mo_ta' => 'Giáo viên trẻ năng động, luôn áp dụng các phương pháp giảng dạy sáng tạo để thu hút học sinh.',
            ],
            [
                'ma_giao_vien' => 'GV004',
                'ho_ten' => 'Phạm Đức Thành',
                'gioi_tinh' => 'Nam',
                'ngay_sinh' => '1980-05-12',
                'anh_dai_dien' => 'teacher-4.jpg',
                'cccd' => '001080456789',
                'so_dien_thoai' => '0976543210',
                'email' => 'ducthanh@thptbachkhoa.edu.vn',
                'dia_chi' => '321 Đường GHI, Quận 7, TP.HCM',
                'bang_cap' => 'Thạc sĩ Vật lý',
                'trinh_do_chuyen_mon' => 'Thạc sĩ',
                'to_chuyen_mon' => 'Tổ Lý - Công nghệ',
                'mon_day' => 'Vật lý',
                'mon_kiem_nhiem' => 'Công nghệ',
                'nam_cong_tac' => 2005,
                'chuc_vu' => 'Tổ trưởng Lý - Công nghệ',
                'lop_chu_nhiem' => '12A3',
                'mo_ta' => 'Giáo viên kỳ cựu với gần 20 năm kinh nghiệm. Chuyên gia về thí nghiệm Vật lý và ứng dụng công nghệ trong giảng dạy.',
            ],
            [
                'ma_giao_vien' => 'GV005',
                'ho_ten' => 'Võ Thị Mai',
                'gioi_tinh' => 'Nữ',
                'ngay_sinh' => '1990-09-25',
                'anh_dai_dien' => 'teacher-5.jpg',
                'cccd' => '001090987654',
                'so_dien_thoai' => '0965432109',
                'email' => 'thimai@thptbachkhoa.edu.vn',
                'dia_chi' => '654 Đường JKL, Quận 2, TP.HCM',
                'bang_cap' => 'Cử nhân Tiếng Anh',
                'trinh_do_chuyen_mon' => 'Cử nhân',
                'to_chuyen_mon' => 'Tổ Ngoại ngữ',
                'mon_day' => 'Tiếng Anh',
                'mon_kiem_nhiem' => null,
                'nam_cong_tac' => 2015,
                'chuc_vu' => 'Giáo viên',
                'lop_chu_nhiem' => '11A1',
                'mo_ta' => 'Giáo viên trẻ với phương pháp giảng dạy tiếng Anh giao tiếp hiện đại. Có chứng chỉ IELTS 8.0.',
            ],
            [
                'ma_giao_vien' => 'GV006',
                'ho_ten' => 'Hoàng Văn Đức',
                'gioi_tinh' => 'Nam',
                'ngay_sinh' => '1983-12-03',
                'anh_dai_dien' => 'teacher-6.jpg',
                'cccd' => '001083321654',
                'so_dien_thoai' => '0954321098',
                'email' => 'vanduc@thptbachkhoa.edu.vn',
                'dia_chi' => '987 Đường MNO, Quận 4, TP.HCM',
                'bang_cap' => 'Thạc sĩ Sinh học',
                'trinh_do_chuyen_mon' => 'Thạc sĩ',
                'to_chuyen_mon' => 'Tổ Hóa - Sinh',
                'mon_day' => 'Sinh học',
                'mon_kiem_nhiem' => 'Giáo dục công dân',
                'nam_cong_tac' => 2009,
                'chuc_vu' => 'Giáo viên',
                'lop_chu_nhiem' => '10A1',
                'mo_ta' => 'Chuyên gia về sinh học phân tử. Thường xuyên hướng dẫn học sinh tham gia các cuộc thi khoa học kỹ thuật.',
            ],
            [
                'ma_giao_vien' => 'GV007',
                'ho_ten' => 'Đặng Thị Bích',
                'gioi_tinh' => 'Nữ',
                'ngay_sinh' => '1987-04-18',
                'anh_dai_dien' => 'teacher-7.jpg',
                'cccd' => '001087159753',
                'so_dien_thoai' => '0943210987',
                'email' => 'thibich@thptbachkhoa.edu.vn',
                'dia_chi' => '159 Đường PQR, Quận 6, TP.HCM',
                'bang_cap' => 'Cử nhân Địa lý',
                'trinh_do_chuyen_mon' => 'Cử nhân',
                'to_chuyen_mon' => 'Tổ Sử - Địa',
                'mon_day' => 'Địa lý',
                'mon_kiem_nhiem' => null,
                'nam_cong_tac' => 2011,
                'chuc_vu' => 'Giáo viên',
                'lop_chu_nhiem' => '10A2',
                'mo_ta' => 'Giáo viên nhiệt huyết với phương pháp giảng dạy Địa lý thực tế. Thường tổ chức các chuyến tham quan học tập.',
            ],
            [
                'ma_giao_vien' => 'GV008',
                'ho_ten' => 'Bùi Minh Tuấn',
                'gioi_tinh' => 'Nam',
                'ngay_sinh' => '1984-08-30',
                'anh_dai_dien' => 'teacher-8.jpg',
                'cccd' => '001084753951',
                'so_dien_thoai' => '0932109876',
                'email' => 'minhtuan@thptbachkhoa.edu.vn',
                'dia_chi' => '753 Đường STU, Quận 8, TP.HCM',
                'bang_cap' => 'Thạc sĩ Lịch sử',
                'trinh_do_chuyen_mon' => 'Thạc sĩ',
                'to_chuyen_mon' => 'Tổ Sử - Địa',
                'mon_day' => 'Lịch sử',
                'mon_kiem_nhiem' => 'Giáo dục quốc phòng',
                'nam_cong_tac' => 2007,
                'chuc_vu' => 'Tổ trưởng Sử - Địa',
                'lop_chu_nhiem' => '11A3',
                'mo_ta' => 'Chuyên gia về lịch sử Việt Nam. Tác giả nhiều bài viết về phương pháp giảng dạy lịch sử sáng tạo.',
            ]
        ];

        foreach ($teachers as $teacherData) {
            // Kiểm tra xem giáo viên đã tồn tại chưa
            $existingTeacher = Teacher::where('ma_giao_vien', $teacherData['ma_giao_vien'])->first();
            
            if (!$existingTeacher) {
                Teacher::create($teacherData);
            } else {
                // Cập nhật thông tin nếu giáo viên đã tồn tại
                $existingTeacher->update($teacherData);
            }
        }

        $this->command->info('Created/Updated ' . count($teachers) . ' teachers');
    }
}