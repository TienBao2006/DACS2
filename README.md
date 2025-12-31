# Hệ thống Quản lý Trường THPT Bách Khoa Lịch Sử

## Giới thiệu
Hệ thống quản lý học tập dành cho Trường THPT Bách Khoa Lịch Sử, được phát triển bằng Laravel Framework.

## Tính năng chính

### 🏠 Trang chủ công khai
- Hiển thị thông tin trường học
- Tin tức và thông báo
- Danh sách giáo viên
- Kho tài liệu học tập

### 👨‍🎓 Portal học sinh
- Xem điểm số và kết quả học tập
- Lịch học và thời khóa biểu
- Nộp bài tập và đề án
- Thông tin cá nhân

### 👨‍🏫 Portal giáo viên  
- Nhập điểm cho học sinh
- Quản lý lớp học được phân công
- Xem thống kê và báo cáo
- Thông tin cá nhân

### 🔧 Quản trị hệ thống
- Quản lý tài khoản học sinh/giáo viên
- Phân công giảng dạy
- Quản lý thời khóa biểu
- Quản lý tin tức và tài liệu

## Yêu cầu hệ thống
- PHP >= 8.1
- MySQL/MariaDB
- Composer
- Apache/Nginx

## Cài đặt

### 1. Clone project
```bash
git clone https://github.com/username/bachkhoalichsu-school.git
cd bachkhoalichsu-school
```

### 2. Cài đặt dependencies
```bash
composer install
```

### 3. Cấu hình môi trường
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Thiết lập database
```bash
php artisan migrate
php artisan db:seed
```

### 5. Chạy ứng dụng
```bash
php artisan serve
```

## Deploy lên Production

Sử dụng script tự động:
```bash
.\deploy-bachkhoalichsu.bat
```

Hoặc xem hướng dẫn chi tiết trong file `deploy-bachkhoalichsu.md`

## Tài khoản mặc định

### Admin
- Username: `admin`
- Password: `admin123`

### Giáo viên mẫu
- Username: `GV001`
- Password: `123456`

### Học sinh mẫu
- Username: `HS10A1001`
- Password: `123456`

## Công nghệ sử dụng
- **Backend**: Laravel 11
- **Frontend**: Blade Templates + Tailwind CSS
- **Database**: MySQL
- **Icons**: Material Symbols

## Liên hệ
- Website: https://bachkhoalichsu.id.vn
- Email: admin@bachkhoalichsu.id.vn

## License
Bản quyền thuộc về Trường THPT Bách Khoa Lịch Sử