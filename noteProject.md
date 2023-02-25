
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
3. Nếu đã có records trong table price trước khi tạo table stock thì phải xóa hết records trong price rồi tạo stock
4. Nếu đã tạo bảng stocks thì -> trong mysql -> stocks table, chỉnh UPDATE và DELETE foreign key product_id lại thành CASCADE (hai options này nằm ở bên phải màn hình)
5. Xóa tay cột description trong products table nếu đã tạo product table (thêm file migrate alter thì nhiều file quá)