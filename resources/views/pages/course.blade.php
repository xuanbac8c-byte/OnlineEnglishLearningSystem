@extends('layouts.app')

@section('title', 'Khóa học')

@section('content')

{{-- Page Header --}}
<section class="page-header">
    <div class="page-header__inner">
        <span class="page-header__tag">Danh mục khóa học</span>
        <h1>Khám phá <span>khóa học</span> của chúng tôi</h1>
        <p>Hơn 1,000+ khóa học được thiết kế bởi các chuyên gia hàng đầu, phù hợp với mọi cấp độ.</p>
    </div>
</section>

{{-- Filter + Course Grid --}}
<section class="courses-section">
    <div class="container">

        {{-- Filter Bar --}}
        <div class="filter-bar">
            <div class="filter-bar__search">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
                </svg>
                <input type="text" placeholder="Tìm kiếm khóa học...">
            </div>
            <div class="filter-bar__groups">
                <select class="filter-select">
                    <option value="">Tất cả cấp độ</option>
                    <option value="beginner">Beginner</option>
                    <option value="intermediate">Intermediate</option>
                    <option value="advanced">Advanced</option>
                </select>
                <select class="filter-select">
                    <option value="">Ngôn ngữ</option>
                    <option value="en">English</option>
                    <option value="fr">French</option>
                    <option value="ja">Japanese</option>
                </select>
                <select class="filter-select">
                    <option value="">Sắp xếp</option>
                    <option value="popular">Phổ biến nhất</option>
                    <option value="newest">Mới nhất</option>
                    <option value="price-asc">Giá tăng dần</option>
                    <option value="price-desc">Giá giảm dần</option>
                </select>
            </div>
        </div>

        {{-- Level Tabs --}}
        <div class="level-tabs">
            <button class="level-tab level-tab--active">Tất cả</button>
            <button class="level-tab">Beginner</button>
            <button class="level-tab">Elementary</button>
            <button class="level-tab">Intermediate</button>
            <button class="level-tab">Upper-Intermediate</button>
            <button class="level-tab">Advanced</button>
        </div>

        {{-- Results Count --}}
        <div class="results-meta">
            <span>Hiển thị <strong>12</strong> / <strong>1,000+</strong> khóa học</span>
        </div>

        {{-- Course Grid --}}
        <div class="course-grid">
            @php
                $mockCourses = [
                    ['id'=>1,'title'=>'TOEIC 750+ Complete Course','level'=>'Intermediate','language'=>'English','rating'=>4.8,'reviews'=>342,'price'=>499000,'instructor'=>'Thầy Long','thumbnail'=>'https://picsum.photos/seed/11/400/225'],
                    ['id'=>2,'title'=>'English for Beginners','level'=>'Beginner','language'=>'English','rating'=>4.6,'reviews'=>210,'price'=>299000,'instructor'=>'Cô Mai','thumbnail'=>'https://picsum.photos/seed/22/400/225'],
                    ['id'=>3,'title'=>'Business English Masterclass','level'=>'Advanced','language'=>'English','rating'=>4.9,'reviews'=>185,'price'=>799000,'instructor'=>'Mr. David','thumbnail'=>'https://picsum.photos/seed/33/400/225'],
                    ['id'=>4,'title'=>'IELTS 7.0 Band Preparation','level'=>'Upper-Intermediate','language'=>'English','rating'=>4.7,'reviews'=>276,'price'=>599000,'instructor'=>'Cô Hoa','thumbnail'=>'https://picsum.photos/seed/44/400/225'],
                    ['id'=>5,'title'=>'Everyday English Speaking','level'=>'Elementary','language'=>'English','rating'=>4.5,'reviews'=>158,'price'=>349000,'instructor'=>'Thầy Hùng','thumbnail'=>'https://picsum.photos/seed/55/400/225'],
                    ['id'=>6,'title'=>'French for Beginners','level'=>'Beginner','language'=>'French','rating'=>4.4,'reviews'=>94,'price'=>399000,'instructor'=>'Mme. Sophie','thumbnail'=>'https://picsum.photos/seed/66/400/225'],
                    ['id'=>7,'title'=>'Japanese N5 Foundation','level'=>'Beginner','language'=>'Japanese','rating'=>4.7,'reviews'=>201,'price'=>449000,'instructor'=>'Tanaka Sensei','thumbnail'=>'https://picsum.photos/seed/77/400/225'],
                    ['id'=>8,'title'=>'Grammar Masterclass','level'=>'Intermediate','language'=>'English','rating'=>4.6,'reviews'=>312,'price'=>299000,'instructor'=>'Cô Lan','thumbnail'=>'https://picsum.photos/seed/88/400/225'],
                    ['id'=>9,'title'=>'Pronunciation & Accent','level'=>'Elementary','language'=>'English','rating'=>4.8,'reviews'=>143,'price'=>199000,'instructor'=>'Thầy Minh','thumbnail'=>'https://picsum.photos/seed/99/400/225'],
                    ['id'=>10,'title'=>'Advanced TOEIC Reading','level'=>'Advanced','language'=>'English','rating'=>4.5,'reviews'=>89,'price'=>499000,'instructor'=>'Cô Phương','thumbnail'=>'https://picsum.photos/seed/101/400/225'],
                    ['id'=>11,'title'=>'Korean for Beginners','level'=>'Beginner','language'=>'Korean','rating'=>4.6,'reviews'=>167,'price'=>349000,'instructor'=>'Park Teacher','thumbnail'=>'https://picsum.photos/seed/112/400/225'],
                    ['id'=>12,'title'=>'English Vocabulary Builder','level'=>'Elementary','language'=>'English','rating'=>4.4,'reviews'=>225,'price'=>249000,'instructor'=>'Mr. James','thumbnail'=>'https://picsum.photos/seed/123/400/225'],
                ];
            @endphp

            @foreach($mockCourses as $course)
                <x-course-card
                    :id="$course['id']"
                    :thumbnail="$course['thumbnail']"
                    :level="$course['level']"
                    :language="$course['language']"
                    :rating="$course['rating']"
                    :reviews="$course['reviews']"
                    :title="$course['title']"
                    :instructor="$course['instructor']"
                    :price="$course['price']"
                />
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="pagination">
            <button class="pagination__btn pagination__btn--disabled">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 18l-6-6 6-6"/></svg>
            </button>
            <button class="pagination__btn pagination__btn--active">1</button>
            <button class="pagination__btn">2</button>
            <button class="pagination__btn">3</button>
            <span class="pagination__dots">...</span>
            <button class="pagination__btn">84</button>
            <button class="pagination__btn">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>
            </button>
        </div>

    </div>
</section>

<script>
    document.querySelectorAll('.level-tab').forEach(tab => {
        tab.addEventListener('click', () => {
            document.querySelectorAll('.level-tab').forEach(t => t.classList.remove('level-tab--active'));
            tab.classList.add('level-tab--active');
        });
    });
</script>

@endsection