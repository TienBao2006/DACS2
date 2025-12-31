<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Teacher;
use App\Models\Login;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class TeacherWithLoginSeeder extends Seeder
{
    public function run()
    {
        echo "Bắt đầu tạo 13 giáo viên cho 13 môn học...\n";
        
        // Tắt foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        
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
                'mon_kiem_nhiem' => null,
                'nam_cong_tac' => 2010,
                'chuc_vu' => 'Tổ trưởng Ngữ văn',
                'lop_chu_nhiem' => '12A1',
                'mo_ta' => 'Giáo viên giàu kinh nghiệm với 14 năm giảng dạy môn Ngữ văn.',
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
                'mon_kiem_nhiem' => null,
                'nam_cong_tac' => 2008,
                'chuc_vu' => 'Tổ trưởng Toán',
                'lop_chu_nhiem' => '11A2',
                'mo_ta' => 'Chuyên gia về phương pháp giảng dạy Toán hiện đại.',
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
                'bang_cap' => 'Thạc sĩ Hóa học',
                'trinh_do_chuyen_mon' => 'Thạc sĩ',
                'to_chuyen_mon' => 'Tổ Hóa - Sinh',
                'mon_day' => 'Hóa học',
                'mon_kiem_nhiem' => null,
                'nam_cong_tac' => 2012,
                'chuc_vu' => 'Giáo viên',
                'lop_chu_nhiem' => '10A3',
                'mo_ta' => 'Giáo viên trẻ năng động, chuyên môn sâu về Hóa học.',
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
                'mon_kiem_nhiem' => null,
                'nam_cong_tac' => 2005,
                'chuc_vu' => 'Tổ trưởng Lý',
                'lop_chu_nhiem' => '12A3',
                'mo_ta' => 'Giáo viên kỳ cựu với gần 20 năm kinh nghiệm giảng dạy Vật lý.',
            ],
            [
                'ma_giao_vien' => 'GV005',
                'ho_ten' => 'Hoàng Văn Đức',
                'gioi_tinh' => 'Nam',
                'ngay_sinh' => '1983-12-03',
                'anh_dai_dien' => 'teacher-5.jpg',
                'cccd' => '001083321654',
                'so_dien_thoai' => '0954321098',
                'email' => 'vanduc@thptbachkhoa.edu.vn',
                'dia_chi' => '987 Đường MNO, Quận 4, TP.HCM',
                'bang_cap' => 'Thạc sĩ Sinh học',
                'trinh_do_chuyen_mon' => 'Thạc sĩ',
                'to_chuyen_mon' => 'Tổ Hóa - Sinh',
                'mon_day' => 'Sinh học',
                'mon_kiem_nhiem' => null,
                'nam_cong_tac' => 2009,
                'chuc_vu' => 'Giáo viên',
                'lop_chu_nhiem' => '10A1',
                'mo_ta' => 'Chuyên gia về sinh học phân tử và di truyền học.',
            ],
            [
                'ma_giao_vien' => 'GV006',
                'ho_ten' => 'Bùi Minh Tuấn',
                'gioi_tinh' => 'Nam',
                'ngay_sinh' => '1984-08-30',
                'anh_dai_dien' => 'teacher-6.jpg',
                'cccd' => '001084753951',
                'so_dien_thoai' => '0932109876',
                'email' => 'minhtuan@thptbachkhoa.edu.vn',
                'dia_chi' => '753 Đường STU, Quận 8, TP.HCM',
                'bang_cap' => 'Thạc sĩ Lịch sử',
                'trinh_do_chuyen_mon' => 'Thạc sĩ',
                'to_chuyen_mon' => 'Tổ Sử - Địa',
                'mon_day' => 'Lịch sử',
                'mon_kiem_nhiem' => null,
                'nam_cong_tac' => 2007,
                'chuc_vu' => 'Tổ trưởng Sử - Địa',
                'lop_chu_nhiem' => '11A3',
                'mo_ta' => 'Chuyên gia về lịch sử Việt Nam và phương pháp giảng dạy sáng tạo.',
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
                'mo_ta' => 'Giáo viên nhiệt huyết với phương pháp giảng dạy Địa lý thực tế.',
            ],
            [
                'ma_giao_vien' => 'GV008',
                'ho_ten' => 'Võ Thị Mai',
                'gioi_tinh' => 'Nữ',
                'ngay_sinh' => '1990-09-25',
                'anh_dai_dien' => 'teacher-8.jpg',
                'cccd' => '001090987654',
                'so_dien_thoai' => '0965432109',
                'email' => 'thimai@thptbachkhoa.edu.vn',
                'dia_chi' => '654 Đường JKL, Quận 2, TP.HCM',
                'bang_cap' => 'Thạc sĩ Tiếng Anh',
                'trinh_do_chuyen_mon' => 'Thạc sĩ',
                'to_chuyen_mon' => 'Tổ Ngoại ngữ',
                'mon_day' => 'Tiếng Anh',
                'mon_kiem_nhiem' => null,
                'nam_cong_tac' => 2015,
                'chuc_vu' => 'Tổ trưởng Ngoại ngữ',
                'lop_chu_nhiem' => '11A1',
                'mo_ta' => 'Giáo viên trẻ với phương pháp giảng dạy tiếng Anh giao tiếp hiện đại.',
            ],
            [
                'ma_giao_vien' => 'GV009',
                'ho_ten' => 'Nguyễn Văn Hùng',
                'gioi_tinh' => 'Nam',
                'ngay_sinh' => '1986-06-14',
                'anh_dai_dien' => 'teacher-9.jpg',
                'cccd' => '001086456123',
                'so_dien_thoai' => '0978123456',
                'email' => 'vanhung@thptbachkhoa.edu.vn',
                'dia_chi' => '456 Đường ABC, Quận 9, TP.HCM',
                'bang_cap' => 'Cử nhân Tin học',
                'trinh_do_chuyen_mon' => 'Cử nhân',
                'to_chuyen_mon' => 'Tổ Toán - Tin',
                'mon_day' => 'Tin học',
                'mon_kiem_nhiem' => null,
                'nam_cong_tac' => 2013,
                'chuc_vu' => 'Giáo viên',
                'lop_chu_nhiem' => '10B1',
                'mo_ta' => 'Chuyên gia về lập trình và ứng dụng công nghệ trong giáo dục.',
            ],
            [
                'ma_giao_vien' => 'GV010',
                'ho_ten' => 'Trần Thị Hoa',
                'gioi_tinh' => 'Nữ',
                'ngay_sinh' => '1989-12-20',
                'anh_dai_dien' => 'teacher-10.jpg',
                'cccd' => '001089789456',
                'so_dien_thoai' => '0967890123',
                'email' => 'thihoa@thptbachkhoa.edu.vn',
                'dia_chi' => '789 Đường XYZ, Quận 11, TP.HCM',
                'bang_cap' => 'Cử nhân Giáo dục công dân',
                'trinh_do_chuyen_mon' => 'Cử nhân',
                'to_chuyen_mon' => 'Tổ Chính trị',
                'mon_day' => 'Giáo dục công dân',
                'mon_kiem_nhiem' => null,
                'nam_cong_tac' => 2014,
                'chuc_vu' => 'Giáo viên',
                'lop_chu_nhiem' => '10B2',
                'mo_ta' => 'Giáo viên tận tâm với việc giáo dục đạo đức và kỹ năng sống.',
            ],
            [
                'ma_giao_vien' => 'GV011',
                'ho_ten' => 'Lê Văn Thắng',
                'gioi_tinh' => 'Nam',
                'ngay_sinh' => '1981-03-08',
                'anh_dai_dien' => 'teacher-11.jpg',
                'cccd' => '001081234567',
                'so_dien_thoai' => '0956789012',
                'email' => 'vanthang@thptbachkhoa.edu.vn',
                'dia_chi' => '321 Đường DEF, Quận 12, TP.HCM',
                'bang_cap' => 'Cử nhân Giáo dục thể chất',
                'trinh_do_chuyen_mon' => 'Cử nhân',
                'to_chuyen_mon' => 'Tổ Thể chất',
                'mon_day' => 'Thể dục',
                'mon_kiem_nhiem' => null,
                'nam_cong_tac' => 2006,
                'chuc_vu' => 'Tổ trưởng Thể chất',
                'lop_chu_nhiem' => '11B1',
                'mo_ta' => 'Huấn luyện viên bóng đá và giáo viên thể dục giàu kinh nghiệm.',
            ],
            [
                'ma_giao_vien' => 'GV012',
                'ho_ten' => 'Phạm Thị Lan',
                'gioi_tinh' => 'Nữ',
                'ngay_sinh' => '1992-11-30',
                'anh_dai_dien' => 'teacher-12.jpg',
                'cccd' => '001092345678',
                'so_dien_thoai' => '0945678901',
                'email' => 'thilan@thptbachkhoa.edu.vn',
                'dia_chi' => '654 Đường GHI, Quận Thủ Đức, TP.HCM',
                'bang_cap' => 'Cử nhân Công nghệ',
                'trinh_do_chuyen_mon' => 'Cử nhân',
                'to_chuyen_mon' => 'Tổ Lý - Công nghệ',
                'mon_day' => 'Công nghệ',
                'mon_kiem_nhiem' => null,
                'nam_cong_tac' => 2018,
                'chuc_vu' => 'Giáo viên',
                'lop_chu_nhiem' => '10B3',
                'mo_ta' => 'Giáo viên trẻ chuyên về công nghệ thông tin và kỹ thuật.',
            ],
            [
                'ma_giao_vien' => 'GV013',
                'ho_ten' => 'Hoàng Minh Đức',
                'gioi_tinh' => 'Nam',
                'ngay_sinh' => '1985-07-15',
                'anh_dai_dien' => 'teacher-13.jpg',
                'cccd' => '001085567890',
                'so_dien_thoai' => '0934567890',
                'email' => 'minhduc@thptbachkhoa.edu.vn',
                'dia_chi' => '987 Đường JKL, Quận Bình Tân, TP.HCM',
                'bang_cap' => 'Cử nhân Giáo dục quốc phòng',
                'trinh_do_chuyen_mon' => 'Cử nhân',
                'to_chuyen_mon' => 'Tổ Quốc phòng',
                'mon_day' => 'Giáo dục quốc phòng',
                'mon_kiem_nhiem' => null,
                'nam_cong_tac' => 2010,
                'chuc_vu' => 'Giáo viên',
                'lop_chu_nhiem' => '12B1',
                'mo_ta' => 'Cựu sĩ quan với kinh nghiệm giảng dạy giáo dục quốc phòng.',
            ]
        ];

        $teacherCount = 0;

        foreach ($teachers as $teacherData) {
            $teacherCount++;
            
            try {
                // Tạo tài khoản login trước
                $login = Login::create([
                    'username' => strtolower($teacherData['ma_giao_vien']),
                    'password' => Hash::make('123456'), // Mật khẩu mặc định
                    'role' => 'teacher',
                    'is_active' => true
                ]);
                
                // Thêm login_id vào dữ liệu giáo viên
                $teacherData['login_id'] = $login->id;
                
                // Tạo giáo viên
                Teacher::create($teacherData);
                
                echo "✓ Đã tạo giáo viên {$teacherData['ho_ten']} - Môn: {$teacherData['mon_day']}\n";
                
            } catch (Exception $e) {
                echo "❌ Lỗi tạo giáo viên {$teacherData['ma_giao_vien']}: " . $e->getMessage() . "\n";
            }
        }
        
        // Bật lại foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        
        echo "\n✅ Hoàn thành! Đã tạo {$teacherCount} giáo viên với tài khoản login.\n";
        echo "📊 Thống kê:\n";
        echo "- Tổng giáo viên: " . Teacher::count() . "\n";
        echo "- Tổng tài khoản login: " . Login::count() . "\n";
        
        // Hiển thị danh sách môn học
        echo "\n📚 Danh sách môn học:\n";
        $subjects = Teacher::pluck('mon_day')->unique()->sort();
        foreach ($subjects as $subject) {
            echo "- {$subject}\n";
        }
    }
}