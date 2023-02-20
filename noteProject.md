
# Edit file .env
Sửa file ".env.example" thành ".env"

# Kiểm tra thông tin .env
1. Kiểm tra key
2. Kiểm tra tên database trước khi migrate
3. Kiểm tra Password database (nếu có)


# Chạy lệnh sau khi clone project
1. composer install
2. composer update
3. composer require laravel/ui
4. composer require doctrine/dbal
5. php artisan key:generate
6. npm install (Cần tải nodeJS để chạy lệnh này trong terminal)
7. npm run build

# Fix lỗi
1. Add tay thông tin vô cate_group table trong database (Lỗi foreign key)
2. Tạm thời set null bằng tay cho cột name và slug trong table prices