@extends('layouts.app')

@section('title', 'Trang chủ')

@section('content')

    {{-- Hero Section --}}
    @include('components.herosection')

    {{-- Features --}}
    <section class="features section">
        <div class="container">

            <div class="section-heading">
                <h2>Tại sao chọn E-Learn?</h2>
            </div>

            <div class="features__grid">

                <x-feature-card
                    icon="fa-solid fa-user-graduate"
                    title="Giảng viên hàng đầu"
                    description="Đội ngũ giáo viên giàu kinh nghiệm, chứng chỉ quốc tế."
                />

                <x-feature-card
                    icon="fa-solid fa-book-open"
                    title="Lộ trình cá nhân hóa"
                    description="Lộ trình học phù hợp với trình độ và mục tiêu của bạn."
                />

                <x-feature-card
                    icon="fa-solid fa-desktop"
                    title="Học mọi lúc, mọi nơi"
                    description="Học trên mọi thiết bị với thời gian linh hoạt."
                />

                <x-feature-card
                    icon="fa-solid fa-trophy"
                    title="Chứng chỉ uy tín"
                    description="Nhận chứng chỉ sau khi hoàn thành khóa học."
                />

            </div>

        </div>
    </section>

    {{-- Popular Courses --}}
    <section class="courses section">
        <div class="container">

            <div class="section-heading">
                <h2>Khóa học phổ biến</h2>
                <a href="/courses" class="view-all">Xem tất cả</a>
            </div>

            <div class="courses__wrapper" id="coursesWrapper">
                <div class="courses__grid">

                    @foreach($courses as $index => $course)
                        <x-course-card
                            :id="$index + 1"
                            :thumbnail="$course->thumbnail_url"
                            :level="$course->level"
                            :title="$course->title"
                            :rating="$course->course_review_avg_rating ?? 0"
                            :price="$course->price"
                            instructor=""
                        />
                    @endforeach

                </div>
            </div>

            <div class="courses__more">
                <button class="courses__button" id="toggleCourses">
                    Xem thêm
                </button>
            </div>

        </div>
    </section>

    {{-- Stats Bar --}}
    <section class="section" style="padding: 48px 0">
        <div class="container">
            @include('components.stats-bar')
        </div>
    </section>

    {{-- Reviews --}}
    <section class="reviews section">
        <div class="container">

            <div class="section-heading" style="justify-content: center; text-align: center; display: block">
                <h2>Học viên nói gì về chúng tôi?</h2>
            </div>

            <div class="reviews__grid">

                <x-review-card
                    text="E-Learn giúp tôi tự tin giao tiếp hơn rất nhiều. Bài giảng dễ hiểu, giáo viên nhiệt tình."
                    name="Nguyễn Minh Anh"
                    role="Học viên khóa giao tiếp cơ bản"
                    avatar="images/avatars/avatar1.jpg"
                />

                <x-review-card
                    text="Lộ trình học rõ ràng, nội dung thực tế và hữu ích. Highly recommend!"
                    name="Trần Hoàng Nam"
                    role="Học viên khóa IELTS 6.5+"
                    avatar="images/avatars/avatar2.jpg"
                />

                <x-review-card
                    text="Tôi thích việc có thể học mọi lúc mọi nơi, phù hợp với người bận rộn như tôi."
                    name="Lê Thảo Vy"
                    role="Học viên khóa giao tiếp trung cấp"
                    avatar="images/avatars/avatar3.jpg"
                />

            </div>

        </div>
    </section>

@endsection