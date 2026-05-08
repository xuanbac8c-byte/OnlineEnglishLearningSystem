## He thong hoc tieng anh online

> Nền tảng học tiếng Anh trực tuyến được xây dựng bằng **Laravel 12**, thiết kế theo kiến trúc **MVC** — đơn giản, rõ ràng và dễ mở rộng.

---

## Muc Luc
- [Gioi Thieu](#-gioi-thieu)
- [Cong nghe su dung](#-cong-nghe-su-dung)
- [Kien truc phan mem](#-kien-truc-phan-mem)
- [Cau truc thu muc](#-cau-truc-thu-muc)
- [Cac lenh thuong dung](#-cac-lenh-thuong-dung)
- [Trang thai phat trien](#-trang-thai-phat-trien)
- [Cai dat he thong](#-cai-dat-he-thong)
- [Tai lieu tham khao](#-tai-lieu-tham-khao)

## Gioi Thieu

He thong hoc tieng anh online la mot ung dung web cho phep nguoi dung co the hoc tieng anh thong qua cac khoa hoc co
cau truc, bai tap tuong tac, flashcard tu vung va theo doi tien do ca nhan.

Du an duoc phat trien dua tren kien truc MVC pattern tren Laravel Framework

## Cong nghe su dung 
| Thanh phan | phien ban |
|---|---|
| PHP | 8.2.31 |
| Composer | 2.9.7 |
| PostgreSQL | 14.21 |
| Laravel | 12.58.0 |


--- 

## Kien truc phan mem
-- thiet ke theo mau kien truc MVC
-- mo ta ngan gon ve kien truc:
- **Model**: Đại diện cho dữ liệu và tương tác với database thông qua Eloquent ORM. Không chứa logic hiển thị.
- **View**: Blade templates hiển thị dữ liệu cho người dùng. Không chứa logic nghiệp vụ.
- **Controller**: Nhận request, gọi Model lấy dữ liệu, trả kết quả về View.
![img](/public/images/MVC-Architecture.png)


---

## Cau truc thu muc
![img](/public/images/Project-Structure.png)

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

---

## Cac cau lenh su dung
`php artisan migrate`: tao database va cac bang da cau hinh
`php artisan make:model TenBang -m`: Tao mot tep tin model "TenBang" -m: tao migration tuong ung voi model tren


---

## Trang thai phat trien

=======
`composer show`: Kiem tra package (thu vien) da cai thong qua composer
`composer require illuminate/database`: Tai package **illuminate/database** chua cac thu vien quan trong Eloquent ORM, Query Builder...
`php artisan make:migration create_user_table --create=users`: tao migrations cua bang user ten **create_user_table**, tham so cuoi cho biet tao bang users moi (options: **--table=users** cho biet la sua bang da ton tai)
`php artisan migrate`: load tat ca cac migration va tao bang trong database
---

## Trang thai phat trien
#### Module Người dùng (User) — CRUD đầy đủ

---
 
#### Module Khóa học (Course) — CRUD đầy đủ


Thiet ke ERD:
![img](/public/images/OnlineEnglishLearningSystem.drawio.png)

Phase 1: Thiet ke moi quan he giua cac bang trong Models

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
