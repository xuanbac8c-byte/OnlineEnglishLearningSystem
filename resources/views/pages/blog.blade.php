@extends('layouts.app')

@section('title', 'Blog')

@section('content')

{{-- Page Header --}}
<section class="page-header page-header--blog">
    <div class="page-header__inner">
        <span class="page-header__tag">Bài viết & Kiến thức</span>
        <h1>Blog học tiếng <span>Anh</span></h1>
        <p>Mẹo học, tài liệu miễn phí và kiến thức từ các chuyên gia ngôn ngữ.</p>
    </div>
</section>

<section class="blog-section">
    <div class="container">

        {{-- Featured Post --}}
        <div class="blog-featured">
            <div class="blog-featured__image">
                <img src="https://picsum.photos/seed/blog1/900/500" alt="Featured Post">
                <span class="blog-tag blog-tag--featured">Nổi bật</span>
            </div>
            <div class="blog-featured__content">
                <div class="blog-meta">
                    <span class="blog-category">Học thuật</span>
                    <span class="blog-date">08 Tháng 5, 2026</span>
                    <span class="blog-read-time">5 phút đọc</span>
                </div>
                <h2>10 Phương pháp học tiếng Anh hiệu quả nhất năm 2026</h2>
                <p>Khám phá những phương pháp học ngôn ngữ đã được kiểm chứng bởi các nhà nghiên cứu và được hàng triệu học viên áp dụng thành công trên toàn thế giới.</p>
                <a href="#" class="btn btn--secondary">Đọc bài viết →</a>
            </div>
        </div>

        {{-- Category Filter --}}
        <div class="blog-categories">
            <button class="blog-cat-btn blog-cat-btn--active">Tất cả</button>
            <button class="blog-cat-btn">Ngữ pháp</button>
            <button class="blog-cat-btn">Từ vựng</button>
            <button class="blog-cat-btn">Kỹ năng nghe</button>
            <button class="blog-cat-btn">Kỹ năng nói</button>
            <button class="blog-cat-btn">TOEIC</button>
            <button class="blog-cat-btn">IELTS</button>
            <button class="blog-cat-btn">Tài liệu miễn phí</button>
        </div>

        {{-- Blog Grid --}}
        <div class="blog-grid">
            @php
                $posts = [
                    ['id'=>1,'title'=>'Bí kíp học từ vựng tiếng Anh không bao giờ quên','category'=>'Từ vựng','date'=>'05/05/2026','read'=>'4 phút','img'=>'https://picsum.photos/seed/b2/400/250','author'=>'Cô Lan'],
                    ['id'=>2,'title'=>'Phân biệt Present Perfect và Simple Past','category'=>'Ngữ pháp','date'=>'03/05/2026','read'=>'6 phút','img'=>'https://picsum.photos/seed/b3/400/250','author'=>'Thầy Hùng'],
                    ['id'=>3,'title'=>'Chiến lược làm bài TOEIC Listening đạt 495','category'=>'TOEIC','date'=>'01/05/2026','read'=>'8 phút','img'=>'https://picsum.photos/seed/b4/400/250','author'=>'Thầy Long'],
                    ['id'=>4,'title'=>'100 cụm từ thông dụng trong giao tiếp hàng ngày','category'=>'Từ vựng','date'=>'28/04/2026','read'=>'5 phút','img'=>'https://picsum.photos/seed/b5/400/250','author'=>'Cô Mai'],
                    ['id'=>5,'title'=>'Cách luyện phát âm chuẩn như người bản xứ','category'=>'Kỹ năng nói','date'=>'25/04/2026','read'=>'7 phút','img'=>'https://picsum.photos/seed/b6/400/250','author'=>'Mr. David'],
                    ['id'=>6,'title'=>'Tải miễn phí: Bộ đề IELTS 2026 có đáp án','category'=>'Tài liệu miễn phí','date'=>'22/04/2026','read'=>'2 phút','img'=>'https://picsum.photos/seed/b7/400/250','author'=>'Admin'],
                ];
            @endphp

            @foreach($posts as $post)
            <article class="blog-card">
                <a href="/blog/{{ $post['id'] }}" class="blog-card__image">
                    <img src="{{ $post['img'] }}" alt="{{ $post['title'] }}">
                    <span class="blog-tag">{{ $post['category'] }}</span>
                </a>
                <div class="blog-card__body">
                    <div class="blog-meta">
                        <span class="blog-date">{{ $post['date'] }}</span>
                        <span class="blog-read-time">{{ $post['read'] }} đọc</span>
                    </div>
                    <h3><a href="/blog/{{ $post['id'] }}">{{ $post['title'] }}</a></h3>
                    <div class="blog-card__author">
                        <div class="blog-avatar">{{ mb_substr($post['author'], 0, 1) }}</div>
                        <span>{{ $post['author'] }}</span>
                    </div>
                </div>
            </article>
            @endforeach
        </div>

        <div class="blog-load-more">
            <button class="btn btn--primary">Xem thêm bài viết</button>
        </div>

    </div>
</section>

<script>
    document.querySelectorAll('.blog-cat-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.blog-cat-btn').forEach(b => b.classList.remove('blog-cat-btn--active'));
            btn.classList.add('blog-cat-btn--active');
        });
    });
</script>

@endsection