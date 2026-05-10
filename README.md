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
`composer show`: Kiem tra package (thu vien) da cai thong qua composer
`composer require illuminate/database`: Tai package **illuminate/database** chua cac thu vien quan trong Eloquent ORM, Query Builder...
`php artisan make:migration create_user_table --create=users`: tao migrations cua bang user ten **create_user_table**, tham so cuoi cho biet tao bang users moi (options: **--table=users** cho biet la sua bang da ton tai)
`php artisan migrate`: load tat ca cac migration va tao bang trong database
---

---

## Trang thai phat trien
| Trang | Route | Mô tả |
|---|---|---|
| Trang chủ | `GET /` | Hero, khóa học nổi bật, reviews, stats |
| Danh sách khóa học | `GET /courses` | Lọc theo cấp độ, ngôn ngữ, sort |
| Chi tiết khóa học | `GET /courses/{id}` | Sections, lessons, reviews, giảng viên |
| Danh sách giảng viên | `GET /instructors` | Grid card với stats |
| Blog | `GET /blog` | Danh sách bài viết, filter category |
| Lộ trình học | `GET /about` | Roadmap, timeline, giá trị cốt lõi |
| Đăng nhập | `GET /login` | Form login + social buttons |
| Đăng ký | `GET /register` | Form với role selector, password strength |
 
### Dashboard Admin
 
| Chức năng | Mô tả |
|---|---|
| Thống kê tổng quan | Tổng users, courses, doanh thu, enrollments |
| Biểu đồ doanh thu | Bar chart theo 12 tháng |
| Phân loại người dùng | Donut chart student / instructor / admin |
| Danh sách người dùng mới | Table 8 users gần nhất, role badge, actions |
| Thanh toán gần đây | Mã GD, số tiền, phương thức, trạng thái |
| Khóa học nổi bật | Top 5 theo enrollment count |
| Quản lý users | Paginate 20, xem/sửa/xóa |
| Quản lý courses | Paginate 20, rating avg, enrollment count |
 
### Dashboard Instructor
 
| Chức năng | Mô tả |
|---|---|
| Stat cards | Số khóa học, tổng học viên, rating TB, doanh thu |
| Hiệu suất khóa học | List 6 courses với enrollment, rating, sections |
| Mini revenue chart | Bar chart 6 tháng gần nhất |
| Phân bố đánh giá | Rating breakdown 1–5 sao |
| Đánh giá gần đây | 4 reviews mới nhất |
| Học viên đăng ký gần đây | Table 8 enrollments mới |
| Thao tác nhanh | Tạo khóa học, thêm bài học, tạo quiz |
 
### Dashboard Student
 
| Chức năng | Mô tả |
|---|---|
| Stat cards | Khóa học đã đăng ký, hoàn thành, chứng chỉ, điểm quiz TB |
| Tiếp tục học | Banner progress bar khóa học đang học dở |
| Danh sách khóa học | Progress bar từng khóa, status badge |
| Chuỗi học hàng ngày | Streak counter |
| Kết quả quiz | Score ring pass/fail, lịch sử làm bài |
| Chứng chỉ | List cert với mã code, nút tải về |
| Heatmap hoạt động | Grid 12 tuần × 7 ngày |
 
### Xác thực
 
| Chức năng | Mô tả |
|---|---|
| Đăng ký | Validate fullname, email unique, password confirm, role, terms |
| Đăng nhập | Validate email/password, lưu session (user_id, fullname, role) |
| Session-based auth | Không dùng Laravel Auth guard mặc định |

| Chức năng | Mô tả |
|---|---|
| Đăng ký | Validate fullname, email unique, password confirm, role, terms |
| Đăng nhập | Validate email/password, lưu session (user_id, fullname, role) |
| Session-based auth | Không dùng Laravel Auth guard mặc định |
 
---

## Controllers

### Auth
| Controller | Method | Route | Mô tả |
|---|---|---|---|
| `LoginController` | `showForm` | `GET /login` | Hiển thị form đăng nhập |
| `LoginController` | `login` | `POST /login` | Xác thực, lưu session, redirect theo role |
| `LoginController` | `logout` | `POST /logout` | Flush session |
| `RegisterController` | `showForm` | `GET /register` | Hiển thị form đăng ký |
| `RegisterController` | `register` | `POST /register` | Validate, tạo user |

### Student (`/student/*`, middleware: `auth_session` + `role:student`)
| Controller | Method | Mô tả |
|---|---|---|
| `Student\DashboardController` | `index` | Dashboard với stats, progress, quiz history, certificates |
| `Student\DashboardController` | `myCourses` | Danh sách khóa học đã đăng ký, paginate |
| `Student\EnrollmentController` | `enroll` | Đăng ký khóa học miễn phí |
| `Student\EnrollmentController` | `unenroll` | Huỷ đăng ký |
| `Student\EnrollmentController` | `afterPayment` | Auto-enroll sau khi payment confirm |
| `Student\LessonController` | `show` | Xem bài học (kiểm tra enrollment) |
| `Student\LessonController` | `updateProgress` | Cập nhật % xem video (AJAX) |
| `Student\LessonController` | `markComplete` | Hoàn thành bài học, tự động cấp cert nếu đủ điều kiện |
| `Student\QuizController` | `show` | Trang giới thiệu quiz + lịch sử |
| `Student\QuizController` | `start` | Tạo attempt mới |
| `Student\QuizController` | `attempt` | Trang làm bài |
| `Student\QuizController` | `submit` | Nộp bài, tính điểm |
| `Student\QuizController` | `result` | Kết quả + đáp án |
| `Student\PaymentController` | `checkout` | Trang thanh toán |
| `Student\PaymentController` | `createPayment` | Tạo payment record, redirect cổng TT |
| `Student\PaymentController` | `callback` | Nhận callback từ VNPay/MoMo |
| `Student\PaymentController` | `history` | Lịch sử thanh toán |
| `Student\CourseReviewController` | `store/update/destroy` | CRUD đánh giá |
| `Student\CertificateController` | `index` | Danh sách chứng chỉ |
| `CertificateController` | `show/verify` | Public: xem và verify mã cert |

### Instructor (`/instructor/*`, middleware: `role:instructor`)
| Controller | Method | Mô tả |
|---|---|---|
| `Instructor\DashboardController` | `index` | Dashboard stats, courses, reviews, enrollments |
| `Instructor\DashboardController` | `courses` | Danh sách khóa học của giảng viên |
| `Instructor\CourseManagerController` | `create/store` | Tạo khóa học mới |
| `Instructor\CourseManagerController` | `edit/update` | Sửa thông tin khóa học |
| `Instructor\CourseManagerController` | `destroy` | Xoá khóa học |
| `Instructor\CourseManagerController` | `publish/unpublish` | Xuất bản / ẩn khóa học |
| `Instructor\CourseManagerController` | `storeSection/updateSection/destroySection` | CRUD chương học |
| `Instructor\CourseManagerController` | `reorderSections` | Drag-drop sắp xếp chương (AJAX) |
| `Instructor\CourseManagerController` | `storeLesson/updateLesson/destroyLesson` | CRUD bài học |
| `Instructor\CourseManagerController` | `reorderLessons` | Drag-drop sắp xếp bài học (AJAX) |
| `Instructor\QuizManagerController` | `store/update/destroy` | CRUD quiz |
| `Instructor\QuizManagerController` | `storeQuestion/updateQuestion/destroyQuestion` | CRUD câu hỏi |
| `Instructor\QuizManagerController` | `storeOption/updateOption/destroyOption` | CRUD đáp án |
| `Instructor\QuizManagerController` | `setCorrectOption` | Đánh dấu đáp án đúng |

### Admin (`/admin/*`, middleware: `role:admin`)
| Controller | Method | Mô tả |
|---|---|---|
| `Admin\DashboardController` | `index` | Tổng quan hệ thống |
| `Admin\DashboardController` | `users` | Danh sách users (redirect sang AdminUser) |
| `Admin\DashboardController` | `courses` | Danh sách courses |
| `Admin\UserController` | `index` | Danh sách users, filter theo role/search |
| `Admin\UserController` | `show` | Chi tiết người dùng |
| `Admin\UserController` | `update` | Cập nhật thông tin, đổi role |
| `Admin\UserController` | `resetPassword` | Đặt lại mật khẩu |
| `Admin\UserController` | `destroy` | Xoá người dùng |
| `Admin\CourseController` | `index` | Danh sách tất cả khóa học |
| `Admin\CourseController` | `show` | Chi tiết khóa học |
| `Admin\CourseController` | `publish/unpublish` | Duyệt/ẩn khóa học |
| `Admin\CourseController` | `destroy` | Xoá khóa học |

### ProfileController (`/profile/*`, middleware: `auth_session`)
| Method | Mô tả |
|---|---|
| `show` | Xem hồ sơ cá nhân |
| `update` | Cập nhật fullname, email |
| `updateAvatar` | Upload ảnh đại diện |
| `changePassword` | Đổi mật khẩu |

---

## Middleware

| Alias | Class | Mô tả |
|---|---|---|
| `auth_session` | `AuthMiddleware` | Kiểm tra `session('user_id')` tồn tại |
| `role` | `RoleMiddleware` | Kiểm tra `session('role')` khớp với roles được phép |

Đăng ký trong `bootstrap/app.php`:
```php
->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
        'auth_session' => \App\Http\Middleware\AuthMiddleware::class,
        'role'         => \App\Http\Middleware\RoleMiddleware::class,
    ]);
})
```
 
## Service Layer
 
Toàn bộ logic nghiệp vụ được tách vào Service, bind qua `AppServiceProvider`.
 
### Danh sách Interface → Implementation
 
| Interface | Implementation | Mô tả |
|---|---|---|
| `IUserService` | `UserService` | Tạo user, profile, đổi mật khẩu, avatar, enroll, progress, certificate |
| `ILanguageService` | `LanguageService` | CRUD ngôn ngữ, tìm theo code |
| `ICourseService` | `CourseService` | CRUD khóa học, lọc, publish/unpublish, load by instructor |
| `ICourseReviewService` | `CourseReviewService` | CRUD review, rating TB, kiểm tra đã review chưa |
| `IEnrollmentService` | `EnrollmentService` | Đăng ký / huỷ đăng ký, kiểm tra enrolled, đếm theo khóa học |
| `ISectionService` | `SectionService` | CRUD section, drag-drop reorder |
| `ILessonService` | `LessonService` | CRUD lesson, reorder, tổng thời lượng khóa học |
| `ILessonProgressService` | `LessonProgressService` | Cập nhật % tiến độ, mark completed, % hoàn thành khóa học |
| `IPaymentService` | `PaymentService` | Tạo payment, confirm, refund, kiểm tra đã thanh toán, doanh thu |
| `ICertificateService` | `CertificateService` | Cấp chứng chỉ, kiểm tra điều kiện, verify mã, tránh cấp trùng |
| `IQuizService` | `QuizService` | CRUD quiz, kiểm tra còn lượt làm không (`canAttempt`) |
| `IQuizOptionService` | `QuizOptionService` | CRUD đáp án, đánh dấu đáp án đúng, lấy đáp án đúng |
| `IQuizAnswerService` | `QuizAnswerService` | Lưu câu trả lời, bulk submit, chấm điểm, đếm câu đúng |
| `IQuizAttemptService` | `QuizAttemptService` | Bắt đầu/nộp bài thi, tính điểm, lịch sử thi, điểm cao nhất |
 
### Cách inject service vào Controller
 
```php
use App\Services\Interfaces\ICourseService;
 
class CourseController extends Controller
{
    public function __construct(
        protected ICourseService $courseService
    ) {}
 
    public function index()
    {
        $courses = $this->courseService->getPublished(['level' => 'intermediate']);
        return view('pages.course', compact('courses'));
    }
}
```
 
---


Thiet ke ERD:
![img](/public/images/OnlineEnglishLearningSystem.drawio.png)

Phase 1: Thiet ke moi quan he giua cac bang trong Models

## Cai dat he thong
-- su dung git clone `https://github.com/NguyenQuangDiep12/OnlineEnglishLearningSystem.git`
cd e-learn
 
composer install
npm install

-- chay server: `php artisan serve`

-- mo trinh duyet: http://127.0.0.1:8000 (Cong mac dinh local cua Laravel)

-- cau hinh database: mo file .env cua du an sua
DB_CONNECTION=pgsql (DB_CONNECTION: loai database ket noi vd: postgresql(pgsql))
DB_HOST=127.0.0.1 (HOST: Dia chi may chu vat ly --> Ip Address: 127.0.0.1)
DB_PORT=5432 (PORT: Cong cua database giao tiep vd: 5432 (Cong mac dinh cua database postgresql))
DB_DATABASE=OnlineEnglishLearningSystem (Ten database vd: OnlineEnglishLearningSystem)
DB_USERNAME=***postgres*** (Ten user dang nhap vd: postgres)
DB_PASSWORD=***dmdsaf*** (Mat khau dang nhap cua user vd: dmdsaf)

# Cấu hình DB trong .env (PostgreSQL mặc định)
-- tao database tren co so du lieu: `php artisan migrate`

php artisan db:seed          # hoặc chạy DataSample.sql trực tiếp

## Routes
 
```
GET  /                          → HomeController@index
GET  /courses                   → CourseController@index
GET  /courses/{id}              → CourseController@show
GET  /instructors               → InstructorController@index
GET  /instructors/{id}          → InstructorController@show
GET  /blog                      → pages.blog
GET  /about                     → pages.about
GET  /login                     → pages.login
GET  /register                  → pages.register
POST /register                  → UserController@register
POST /login                     → UserController@login
 
# Admin (middleware: auth, admin)
GET  /admin/dashboard           → Admin\DashboardController@index
GET  /admin/users               → Admin\DashboardController@users
GET  /admin/courses             → Admin\DashboardController@courses
 
# Instructor
GET  /instructor/dashboard      → Instructor\DashboardController@index
GET  /instructor/courses        → Instructor\DashboardController@courses
GET  /instructor/courses/create → Instructor\DashboardController@createCourse
```
 
---
 
## Ghi chú phát triển
 
- **Auth chưa dùng Laravel Guard** — đang lưu session thủ công. Cần migrate sang `Auth::attempt()` hoặc Sanctum để dùng middleware `auth`.
- **CertificateService** — các raw query dùng tên bảng sai (`lesson`, `section`). Cần sửa thành `lessons`, `sections`.
- **UserService::getEnrolledCourse** — raw query dùng tên bảng sai (`enrollment`, `course`). Cần sửa thành `enrollments`, `courses`.
- **QuizAttemptService cũ** implement sai interface (`IQuizAnswerService`). File mới implement đúng `IQuizAttemptService`.

## Tai lieu hoc tap
-- Tham khao tu cac nguon `https://www.w3schools.in/laravel`
-- `https://www.w3schools.com/php`
-- `https://laravel.com/`
