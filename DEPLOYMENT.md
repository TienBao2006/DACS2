# 🚀 Hướng dẫn Deploy lên Hosting

## 📋 Yêu cầu hệ thống

### Server Requirements:
- **PHP**: >= 8.1
- **MySQL**: >= 5.7 hoặc MariaDB >= 10.3
- **Apache/Nginx** với mod_rewrite enabled
- **Composer**: Latest version
- **Node.js**: >= 16 (nếu cần build assets)

### PHP Extensions:
- BCMath
- Ctype
- Fileinfo
- JSON
- Mbstring
- OpenSSL
- PDO
- Tokenizer
- XML
- GD hoặc Imagick (cho xử lý ảnh)

## 🛠️ Các bước deploy

### 1. Upload code lên hosting
```bash
# Clone repository
git clone https://github.com/TienBao2006/DACS2.git
cd DACS2

# Hoặc upload file zip và giải nén
```

### 2. Cấu hình database
- Tạo database MySQL trên hosting
- Ghi nhớ thông tin: database name, username, password, host

### 3. Cấu hình environment
```bash
# Copy file production environment
cp .env.production .env

# Chỉnh sửa thông tin database trong .env:
DB_HOST=localhost
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password

# Cập nhật APP_URL với domain thật:
APP_URL=https://yourdomain.com
```

### 4. Chạy script deploy
```bash
# Cấp quyền thực thi
chmod +x deploy.sh

# Chạy script deploy
./deploy.sh
```

### 5. Cấu hình web server

#### Đối với Apache (shared hosting):
- File `.htaccess` đã được cấu hình sẵn
- Đảm bảo document root trỏ đến thư mục `public/`

#### Đối với Nginx:
```nginx
server {
    listen 80;
    server_name yourdomain.com;
    root /path/to/your/project/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

## 🔧 Cấu hình bổ sung

### 1. File permissions
```bash
chmod -R 755 storage
chmod -R 755 bootstrap/cache
chmod -R 755 public/uploads
```

### 2. Cron jobs (nếu cần)
```bash
# Thêm vào crontab
* * * * * cd /path/to/your/project && php artisan schedule:run >> /dev/null 2>&1
```

### 3. SSL Certificate
- Cài đặt SSL certificate (Let's Encrypt hoặc từ hosting provider)
- Cập nhật `APP_URL` thành `https://`

## 📊 Dữ liệu mẫu

### Tài khoản mặc định:
- **Admin**: admin / 123456
- **Giáo viên**: GV001-GV008 / 123456  
- **Học sinh**: Mã học sinh (VD: HS10A1001) / 123456

### Seed dữ liệu (tùy chọn):
```bash
php artisan db:seed
```

## 🐛 Troubleshooting

### Lỗi thường gặp:

1. **500 Internal Server Error**
   - Kiểm tra file permissions
   - Xem error logs: `tail -f storage/logs/laravel.log`

2. **Database connection failed**
   - Kiểm tra thông tin database trong `.env`
   - Đảm bảo database đã được tạo

3. **Missing storage link**
   ```bash
   php artisan storage:link
   ```

4. **Cache issues**
   ```bash
   php artisan config:clear
   php artisan cache:clear
   php artisan view:clear
   ```

## 📞 Hỗ trợ

Nếu gặp vấn đề trong quá trình deploy, hãy:
1. Kiểm tra error logs
2. Đảm bảo tất cả requirements được đáp ứng
3. Liên hệ support của hosting provider nếu cần

## 🔄 Cập nhật

Để cập nhật code mới:
```bash
git pull origin main
./deploy.sh
```

---

**Lưu ý**: Luôn backup database trước khi deploy hoặc cập nhật!