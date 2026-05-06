## He thong hoc tieng anh online

## Cong nghe su dung 
-- PHP version 8.2.31
-- Composer version 2.9.7
-- PostgreSQL version 14.21
-- Laravel v12.58.0

## Cac cau lenh su dung
`php artisan migrate`: tao database va cac bang da cau hinh
`php artisan make:model TenBang -m`: Tao mot tep tin model "TenBang" -m: tao migration tuong ung voi model tren

## Kien truc phan mem
-- thiet ke theo mau kien truc MVC
-- mo ta ngan gon ve kien truc:
-- Model: Model bao gồm dữ liệu ứng dụng đã được làm sạch. Tuy nhiên, mô hình không xử lý bất kỳ logic nào về cách trình bày dữ liệu.
-- View: Phần tử View được sử dụng để hiển thị dữ liệu của mô hình cho người dùng. Phần tử này xử lý cách liên kết với dữ liệu của mô hình nhưng không cung cấp bất kỳ logic nào về ý nghĩa của dữ liệu đó hoặc cách người dùng có thể sử dụng dữ liệu đó.
-- Controller: Controller nằm giữa mô hình và phần tử hiển thị. Nó lắng nghe tất cả các sự kiện và hành động được kích hoạt trong phần hiển thị và thực hiện phản hồi thích hợp trở lại các sự kiện đó.
![img](/public/images/MVC-Architecture.png)

## Cau truc thu muc cua laravel
-- app: Thu muc chua ma nguon co ban de chay du an (Entry Point cua du an)
-- bootstrap: Thư mục bootstrap chứa tất cả các tập lệnh khởi tạo được sử dụng cho ứng dụng của bạn.
-- config: Thư mục config chứa tất cả các tệp cấu hình dự án của bạn (.config).
-- database: Thư mục cơ sở dữ liệu chứa các tệp cơ sở dữ liệu của bạn.
-- public: Thư mục public giúp bạn khởi tạo dự án Laravel và lưu trữ các tệp cần thiết khác như JavaScript, CSS và hình ảnh của dự án.
-- resources: Thư mục resources chứa tất cả các tệp Sass, tệp ngôn ngữ (bản địa hóa) và các mẫu (nếu có).
-- routes: Thư mục routes chứa tất cả các tệp định nghĩa định tuyến của bạn, chẳng hạn như console.php, api.php, channels.php, v.v.
-- storage: Thư mục lưu trữ này chứa các tệp phiên làm việc, bộ nhớ đệm, các mẫu đã biên dịch và các tệp khác do framework tạo ra.
-- test: Thư mục kiểm thử chứa tất cả các trường hợp kiểm thử của bạn.
-- vendor: Thư mục vendor chứa tất cả các tệp phụ thuộc của Composer.


## Cai dat he thong
-- su dung git clone `https://github.com/NguyenQuangDiep12/OnlineEnglishLearningSystem.git`

-- chay server: `php artisan serve`

-- mo trinh duyet: http://127.0.0.1:8000 (Cong mac dinh local cua Laravel)

-- cau hinh database: mo file .env cua du an sua
DB_CONNECTION=pgsql (DB_CONNECTION: loai database ket noi vd: postgresql(pgsql))
DB_HOST=127.0.0.1 (HOST: Dia chi may chu vat ly --> Ip Address: 127.0.0.1)
DB_PORT=5432 (PORT: Cong cua database giao tiep vd: 5432 (Cong mac dinh cua database postgresql))
DB_DATABASE=OnlineEnglishLearningSystem (Ten database vd: OnlineEnglishLearningSystem)
DB_USERNAME=***postgres*** (Ten user dang nhap vd: postgres)
DB_PASSWORD=***dmdsaf*** (Mat khau dang nhap cua user vd: dmdsaf)

-- tao database tren co so du lieu: `php artisan migrate`

## Tai lieu hoc tap
-- Tham khao tu cac nguon `https://www.w3schools.in/laravel`
-- `https://www.w3schools.com/php`
-- `https://laravel.com/`