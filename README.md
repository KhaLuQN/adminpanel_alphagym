# Hệ thống Quản lý Phòng Gym - AlphaGym Admin

Đây là hệ thống quản trị (admin panel) cho AlphaGym, được xây dựng trên nền tảng Laravel. Hệ thống cung cấp các công cụ cần thiết để quản lý hội viên, gói tập, thiết bị, bài viết, và theo dõi hoạt động kinh doanh. Ngoài ra, dự án còn cung cấp một bộ API để phục vụ cho các ứng dụng phía client.

## Tính năng chính

### Phần Quản trị (Admin Panel)

- **Bảng điều khiển:** Tổng quan về doanh thu, hội viên mới, và các hoạt động gần đây.
- **Quản lý Hội viên:** Quản lý thông tin chi tiết, lịch sử đăng ký gói tập và lịch sử check-in của hội viên.
- **Quản lý Gói tập:** Tạo và quản lý các gói thành viên, bao gồm giá, thời hạn và các quyền lợi đi kèm.
- **Quản lý Thiết bị:** Theo dõi tình trạng và lịch sử bảo trì của các trang thiết bị trong phòng tập.
- **Quản lý Nội dung:** Soạn thảo và đăng tải các bài viết, tin tức, và các trang thông tin.
- **Quản lý Lịch tập & Huấn luyện viên:** Quản lý thông tin và lịch làm việc của huấn luyện viên.
- **Hệ thống Check-in:** Ghi nhận lịch sử ra vào của hội viên.
- **Báo cáo & Thống kê:** Cung cấp các báo cáo về doanh thu, hoạt động của hội viên theo thời gian.
- **Quản lý Phản hồi:** Xem và quản lý các liên hệ, phản hồi từ người dùng.

### API cho Client

- Lấy danh sách bài viết, gói tập, huấn luyện viên.
- Gửi liên hệ, phản hồi.
- **Xác thực thành viên:** Hỗ trợ đăng nhập bằng "magic link" gửi qua email.
- **Tài khoản thành viên:** Xem thông tin cá nhân, lịch sử gói tập, lịch sử check-in.

## Công nghệ sử dụng

- **Backend:**
    - PHP 8.1+
    - Laravel 10
    - Laravel Sanctum (cho xác thực API)
- **Frontend:**
    - Vite
    - Tailwind CSS
    - JavaScript (ES6+)
- **Cơ sở dữ liệu:**
    - MySQL (mặc định) hoặc các CSDL khác được Laravel hỗ trợ.

## Hướng dẫn cài đặt

### Yêu cầu hệ thống

- PHP >= 8.1
- Composer
- Node.js & NPM
- Một hệ quản trị cơ sở dữ liệu (ví dụ: MySQL)

### Các bước cài đặt

1.  **Clone repository về máy của bạn:**

    ```bash
    git clone <your-repository-url>
    cd alphagym_admin
    ```

2.  **Sao chép file cấu hình môi trường:**

    ```bash
    cp .env.example .env
    ```

3.  **Cài đặt các dependency của Composer (backend):**

    ```bash
    composer install
    ```

4.  **Tạo khóa ứng dụng (Application Key):**

    ```bash
    php artisan key:generate
    ```

5.  **Cấu hình file `.env`:**
    Mở file `.env` và cập nhật các thông tin cần thiết, quan trọng nhất là cấu hình kết nối cơ sở dữ liệu:

    ```ini
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=alphagym_db
    DB_USERNAME=root
    DB_PASSWORD=
    ```

    Đồng thời, cấu hình các dịch vụ mail (MAIL\_\*) để các tính năng gửi email hoạt động.

6.  **Chạy migration và seeder để tạo cấu trúc database và dữ liệu mẫu (nếu có):**

    ```bash
    php artisan migrate --seed
    ```

7.  **Cài đặt các dependency của NPM (frontend):**

    ```bash
    npm install
    ```

8.  **Build tài nguyên frontend:**
    - Để phát triển (development):
        ```bash
        npm run dev
        ```
    - Để build cho production:
        ```bash
        npm run build
        ```

9.  **Khởi động server:**
    ```bash
    php artisan serve
    ```

Sau khi hoàn tất, ứng dụng sẽ chạy tại địa chỉ `http://127.0.0.1:8000`.

## API

Các endpoint của API được định nghĩa trong file `routes/api_v1.php`. API sử dụng Laravel Sanctum để xác thực các request từ người dùng đã đăng nhập.
