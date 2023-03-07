
# Edit file .env
Sửa file ".env.example" thành ".env"

# Kiểm tra thông tin .env
1. Kiểm tra key
2. Kiểm tra tên database trước khi migrate
3. Kiểm tra Password database (nếu có)
4. Kiểm ra MAIL fields


# Chạy lệnh sau khi clone project
1. composer install
2. composer update
3. composer require laravel/ui
4. composer require doctrine/dbal
5. php artisan key:generate
6. npm install (Cần tải nodeJS để chạy lệnh này trong terminal)
7. npm run build
<!-- 8. download ckeditor 4 (file .zip) -->
9. composer require ckfinder/ckfinder-laravel-package
10. php artisan ckfinder:download
11. php artisan vendor:publish -> chọn 10
12. php artisan vendor:publish -> chọn 11
13. php artisan vendor:publish -> chọn 12
14. các bước còn lại làm theo link "https://vietlaravel.com/huong-dan-tich-hop-ckeditor-va-ckfinder-chuan-nhat-cho-laravel.html"
15. Nếu cần chạy schedule thì    php artisan schedule:run
16. composer require laravel/socialite (đọc fix lỗi số 10.)
17. chạy migrate và add file .sql để thêm dữ liệu thành phố (nhớ check tên database + tên table), 
NHỚ CHECK KĨ file wards.sql có nhiều câu lệnh INSERT bên trong, nhớ đổi tên database cho hết nha - do quá nhiều dữ liệu
<Vô link ghim trong nhóm để tải file .sql>

# Fix lỗi
1. Add tay thông tin vô cate_group table trong database (Lỗi foreign key)
2. Tạm thời set null bằng tay cho cột name và slug trong table prices
3. Nếu đã có records trong table price trước khi tạo table stock thì phải xóa hết records trong price rồi tạo stock
4. Nếu đã tạo bảng stocks thì -> trong mysql -> stocks table, chỉnh UPDATE và DELETE foreign key product_id lại thành CASCADE (hai options này nằm ở bên phải màn hình)
5. Xóa tay cột description trong products table nếu đã tạo product table (thêm file migrate alter thì nhiều file quá)
6. Xóa migration delete_column_stocks_table
7. Vào Xampp -> Apache Config -> php.ini -> tìm dòng "gd" -> xóa dấu ";"
8. Vào Xampp -> Apache Config -> php.ini -> tìm dòng "zip" -> xóa dấu ";" nếu ko chạy được lệnh 9
9. Sửa file config/ckfinder.php dòng 85 ->     ':8888/LapXuongStore/public/' (thống nhất port và tên project)
10. <chạy MIGRATE>

<add vào file .env>
GOOGLE_CLIENT_ID=1045147736434-ci8su7i6j5jh1j55vmnjdcohu83vs4b6.apps.googleusercontent.com
GOOGLE_CLIENT_SECRET=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

FACEBOOK_CLIENT_ID=174361068689376
FACEBOOK_CLIENT_SECRET=1231743f6954579fe4aada8b38c98089ab5

<add vào file config/services> (nếu có rồi thì thôi, vì đã đồng bộ qua github)
'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect' => 'http://localhost/LapXuongStore/public/auth/google/callback',

    ],
'facebook' => [
    'client_id' => env('FACEBOOK_CLIENT_ID'),
    'client_secret' => env('FACEBOOK_CLIENT_SECRET'),
    'redirect' => 'http://localhost/LapXuongStore/public/auth/facebook/callback',
],