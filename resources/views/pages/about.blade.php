@extends('layouts.app')

@section('title', 'Về chúng tôi')

@section('content')

{{-- Hero About --}}
<section class="about-hero">
    <div class="about-hero__content">
        <span class="page-header__tag">Câu chuyện của chúng tôi</span>
        <h1>Sứ mệnh mang tiếng Anh <span>đến mọi người</span></h1>
        <p>
            E-Learn ra đời từ niềm tin rằng mỗi người đều xứng đáng được tiếp cận nền giáo dục ngôn ngữ chất lượng cao.
            Từ năm 2020, chúng tôi đã đồng hành cùng hơn 15,000 học viên trên hành trình chinh phục tiếng Anh.
        </p>
    </div>
    <div class="about-hero__image">
        <img src="{{ asset('images/about_hero.jpg') }}" alt="About E-Learn"
             onerror="this.src='https://picsum.photos/seed/about/700/500'">
    </div>
</section>

{{-- Mission Values --}}
<section class="values-section">
    <div class="container">
        <div class="section-header">
            <h2>Giá trị cốt lõi</h2>
            <p>Những nguyên tắc định hướng mọi quyết định của chúng tôi.</p>
        </div>
        <div class="values-grid">
            <div class="value-card">
                <div class="value-card__icon">🎯</div>
                <h3>Chất lượng</h3>
                <p>Mỗi khóa học đều trải qua quá trình kiểm duyệt nghiêm ngặt bởi hội đồng chuyên gia.</p>
            </div>
            <div class="value-card">
                <div class="value-card__icon">🌍</div>
                <h3>Tiếp cận</h3>
                <p>Học tiếng Anh mọi lúc, mọi nơi với chi phí hợp lý, không rào cản địa lý.</p>
            </div>
            <div class="value-card">
                <div class="value-card__icon">🤝</div>
                <h3>Cộng đồng</h3>
                <p>Xây dựng cộng đồng học viên hỗ trợ lẫn nhau, cùng nhau tiến bộ.</p>
            </div>
            <div class="value-card">
                <div class="value-card__icon">💡</div>
                <h3>Đổi mới</h3>
                <p>Không ngừng cải tiến phương pháp giảng dạy dựa trên công nghệ và nghiên cứu mới nhất.</p>
            </div>
        </div>
    </div>
</section>

{{-- Roadmap --}}
<section class="roadmap-section">
    <div class="container">
        <div class="section-header">
            <h2>Lộ trình học tập</h2>
            <p>Hành trình từ zero đến thành thạo tiếng Anh.</p>
        </div>
        <div class="roadmap">
            @php
                $levels = [
                    ['level'=>'A1','title'=>'Beginner','desc'=>'Bảng chữ cái, phát âm cơ bản, chào hỏi, số đếm, màu sắc.','duration'=>'1-2 tháng','color'=>'#e3f2fd'],
                    ['level'=>'A2','title'=>'Elementary','desc'=>'Câu đơn giản, thì hiện tại, từ vựng gia đình, thực phẩm, du lịch.','duration'=>'2-3 tháng','color'=>'#e8f5e9'],
                    ['level'=>'B1','title'=>'Intermediate','desc'=>'Kể chuyện, ngữ pháp nâng cao, đọc hiểu bài báo đơn giản.','duration'=>'3-4 tháng','color'=>'#fff8e1'],
                    ['level'=>'B2','title'=>'Upper-Intermediate','desc'=>'Tranh luận, viết luận, TOEIC 600-750, IELTS 5.5-6.5.','duration'=>'4-6 tháng','color'=>'#fce4ec'],
                    ['level'=>'C1','title'=>'Advanced','desc'=>'Thành thạo giao tiếp, TOEIC 900+, IELTS 7.0+, tiếng Anh học thuật.','duration'=>'6-12 tháng','color'=>'#ede7f6'],
                ];
            @endphp
            @foreach($levels as $i => $step)
            <div class="roadmap__step">
                <div class="roadmap__connector {{ $i === 0 ? 'roadmap__connector--first' : '' }}"></div>
                <div class="roadmap__node" style="background-color: '{{ $step['color'] }}'">
                    <div class="roadmap__level">{{ $step['level'] }}</div>
                    <div class="roadmap__content">
                        <h3>{{ $step['title'] }}</h3>
                        <p>{{ $step['desc'] }}</p>
                        <span class="roadmap__duration">⏱ {{ $step['duration'] }}</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Timeline --}}
<section class="timeline-section">
    <div class="container">
        <div class="section-header">
            <h2>Hành trình của E-Learn</h2>
        </div>
        <div class="timeline">
            <div class="timeline__item timeline__item--left">
                <div class="timeline__year">2020</div>
                <div class="timeline__card">
                    <h3>Thành lập</h3>
                    <p>E-Learn ra đời với 5 giảng viên và 200 học viên đầu tiên.</p>
                </div>
            </div>
            <div class="timeline__item timeline__item--right">
                <div class="timeline__year">2021</div>
                <div class="timeline__card">
                    <h3>Ra mắt nền tảng online</h3>
                    <p>Đưa toàn bộ nội dung lên nền tảng trực tuyến, phủ sóng toàn quốc.</p>
                </div>
            </div>
            <div class="timeline__item timeline__item--left">
                <div class="timeline__year">2023</div>
                <div class="timeline__card">
                    <h3>10,000 học viên</h3>
                    <p>Cột mốc 10,000 học viên đăng ký, mở rộng đội ngũ giảng viên lên 15 người.</p>
                </div>
            </div>
            <div class="timeline__item timeline__item--right">
                <div class="timeline__year">2026</div>
                <div class="timeline__card">
                    <h3>15,000+ học viên</h3>
                    <p>1,000+ khóa học, 20+ giảng viên, hợp tác với các đối tác giáo dục quốc tế.</p>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection