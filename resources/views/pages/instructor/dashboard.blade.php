@extends('layouts.dashboard')

@section('title', 'Instructor Dashboard')
@section('page-title', 'Trang giảng viên')
@section('sidebar-label', 'GIẢNG VIÊN')

@section('sidebar-nav')
    <a href="{{ route('instructor.dashboard') }}" class="dash-sidebar__nav-link">
        <i class="fa-solid fa-chart-line"></i>
        <span>Tổng quan</span>
    </a>
    <a href="{{ route('instructor.courses') }}" class="dash-sidebar__nav-link">
        <i class="fa-solid fa-book-open"></i>
        <span>Khóa học của tôi</span>
        <span class="dash-sidebar__nav-badge">{{ $stats['my_courses'] }}</span>
    </a>
    <a href="#" class="dash-sidebar__nav-link">
        <i class="fa-solid fa-users"></i>
        <span>Học viên</span>
        <span class="dash-sidebar__nav-badge">{{ $stats['total_students'] }}</span>
    </a>
    <a href="#" class="dash-sidebar__nav-link">
        <i class="fa-solid fa-star"></i>
        <span>Đánh giá</span>
    </a>
    <a href="#" class="dash-sidebar__nav-link">
        <i class="fa-solid fa-circle-dollar-to-slot"></i>
        <span>Doanh thu</span>
    </a>
    <div class="dash-sidebar__divider"></div>
    <a href="{{ route('instructor.create-course') }}" class="dash-sidebar__nav-link">
        <i class="fa-solid fa-plus"></i>
        <span>Tạo khóa học mới</span>
    </a>
    <a href="#" class="dash-sidebar__nav-link">
        <i class="fa-solid fa-gear"></i>
        <span>Cài đặt</span>
    </a>
@endsection

@section('content')

{{-- ── STAT CARDS ─────────────────────────────────────── --}}
<div class="ins-stat-grid">

    <div class="ins-stat-card ins-stat-card--blue">
        <div class="ins-stat-card__icon"><i class="fa-solid fa-book-open"></i></div>
        <div class="ins-stat-card__body">
            <span class="ins-stat-card__label">Khóa học của tôi</span>
            <span class="ins-stat-card__value">{{ $stats['my_courses'] }}</span>
            <span class="ins-stat-card__sub">{{ $stats['published_courses'] }} đã xuất bản</span>
        </div>
    </div>

    <div class="ins-stat-card ins-stat-card--green">
        <div class="ins-stat-card__icon"><i class="fa-solid fa-users"></i></div>
        <div class="ins-stat-card__body">
            <span class="ins-stat-card__label">Tổng học viên</span>
            <span class="ins-stat-card__value">{{ number_format($stats['total_students']) }}</span>
            <span class="ins-stat-card__sub">+{{ $stats['new_students_month'] }} tháng này</span>
        </div>
    </div>

    <div class="ins-stat-card ins-stat-card--amber">
        <div class="ins-stat-card__icon"><i class="fa-solid fa-star"></i></div>
        <div class="ins-stat-card__body">
            <span class="ins-stat-card__label">Đánh giá TB</span>
            <span class="ins-stat-card__value">{{ number_format($stats['avg_rating'], 1) }} ★</span>
            <span class="ins-stat-card__sub">{{ $stats['total_reviews'] }} đánh giá</span>
        </div>
    </div>

    <div class="ins-stat-card ins-stat-card--rose">
        <div class="ins-stat-card__icon"><i class="fa-solid fa-circle-dollar-to-slot"></i></div>
        <div class="ins-stat-card__body">
            <span class="ins-stat-card__label">Doanh thu</span>
            <span class="ins-stat-card__value">
                {{ number_format($stats['total_revenue'] / 1000000, 1) }}tr đ
            </span>
            <span class="ins-stat-card__sub">Tháng này: {{ number_format($stats['month_revenue'] / 1000000, 1) }}tr đ</span>
        </div>
    </div>

</div>

{{-- ── ROW: Course list + Quick actions ─────────────────── --}}
<div class="dash-row dash-row--2-1">

    {{-- Course performance --}}
    <div class="dash-card">
        <div class="dash-card__header">
            <h3 class="dash-card__title">Hiệu suất khóa học</h3>
            <a href="{{ route('instructor.courses') }}" class="dash-card__link">Xem tất cả →</a>
        </div>
        <div class="ins-course-list">
            @foreach($my_courses as $course)
            <div class="ins-course-item">
                <img src="{{ $course->thumbnail_url
                             ?? 'https://picsum.photos/seed/'.$course->course_id.'/72/48' }}"
                     alt="{{ $course->title }}"
                     class="ins-course-item__thumb">
                <div class="ins-course-item__info">
                    <span class="ins-course-item__title">
                        {{ Str::limit($course->title, 40) }}
                    </span>
                    <div class="ins-course-item__meta">
                        <span class="ins-course-item__meta-item">
                            <i class="fa-solid fa-users"></i>
                            {{ $course->enrollments_count }} học viên
                        </span>
                        <span class="ins-course-item__meta-item">
                            <i class="fa-solid fa-star" style="color: #f59e0b"></i>
                            {{ number_format($course->course_reviews_avg_rating ?? 0, 1) }}
                        </span>
                        <span class="ins-course-item__meta-item">
                            <i class="fa-solid fa-layer-group"></i>
                            {{ $course->sections_count }} chương
                        </span>
                    </div>
                </div>
                <div class="ins-course-item__actions">
                    <span class="dash-badge dash-badge--{{ $course->is_published ? 'published' : 'draft' }}">
                        {{ $course->is_published ? 'Live' : 'Draft' }}
                    </span>
                    <a href="#" class="dash-action-btn" title="Chỉnh sửa">
                        <i class="fa-solid fa-pen"></i>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Right column --}}
    <div style="display: flex; flex-direction: column; gap: 20px;">

        {{-- Revenue mini chart --}}
        <div class="dash-card">
            <div class="dash-card__header">
                <h3 class="dash-card__title">Doanh thu 6 tháng</h3>
            </div>
            @php
                $revMonths = ['T7','T8','T9','T10','T11','T12'];
                $revData   = [18, 24, 31, 28, 42, 38];
                $maxRev2   = max($revData);
            @endphp
            <div class="ins-rev-chart">
                @foreach($revMonths as $i => $m)
                <div class="ins-rev-bar"
                     style="height: {{ round(($revData[$i] / $maxRev2) * 100) }}%"
                     title="{{ $m }}: {{ $revData[$i] }}tr đ">
                </div>
                @endforeach
            </div>
            <div class="ins-rev-label">
                @foreach($revMonths as $m)
                <span>{{ $m }}</span>
                @endforeach
            </div>
        </div>

        {{-- Rating breakdown --}}
        <div class="dash-card">
            <div class="dash-card__header">
                <h3 class="dash-card__title">Phân bố đánh giá</h3>
            </div>
            @php
                $ratingDist = [
                    5 => 68, 4 => 20, 3 => 7, 2 => 3, 1 => 2
                ];
                $totalReviews = array_sum($ratingDist);
            @endphp
            <div class="ins-rating-breakdown">
                @foreach($ratingDist as $star => $count)
                <div class="ins-rating-row">
                    <span class="ins-rating-row__star">{{ $star }}★</span>
                    <div class="ins-rating-row__bar">
                        <div class="ins-rating-row__fill"
                             style="width: {{ $totalReviews ? round($count / $totalReviews * 100) : 0 }}%">
                        </div>
                    </div>
                    <span class="ins-rating-row__count">{{ $count }}</span>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Quick actions --}}
        <div class="dash-card">
            <div class="dash-card__header">
                <h3 class="dash-card__title">Thao tác nhanh</h3>
            </div>
            <div class="ins-quick-actions">
                <a href="{{ route('instructor.create-course') }}" class="ins-quick-btn">
                    <i class="fa-solid fa-plus"></i> Tạo khóa học
                </a>
                <a href="#" class="ins-quick-btn">
                    <i class="fa-solid fa-file-alt"></i> Thêm bài học
                </a>
                <a href="#" class="ins-quick-btn">
                    <i class="fa-solid fa-question-circle"></i> Tạo quiz
                </a>
                <a href="#" class="ins-quick-btn">
                    <i class="fa-solid fa-bullhorn"></i> Thông báo
                </a>
            </div>
        </div>

    </div>

</div>

{{-- ── ROW: Recent reviews + Student enrollments ────────── --}}
<div class="dash-row dash-row--2">

    {{-- Recent reviews --}}
    <div class="dash-card">
        <div class="dash-card__header">
            <h3 class="dash-card__title">Đánh giá gần đây</h3>
            <a href="#" class="dash-card__link">Xem tất cả →</a>
        </div>
        <div class="ins-review-list">
            @foreach($recent_reviews as $review)
            <div class="ins-review-item">
                <div class="ins-review-item__header">
                    <div class="ins-review-item__user">
                        <div class="ins-review-item__avatar">
                            {{ mb_substr($review->user->fullname ?? 'U', 0, 1) }}
                        </div>
                        <div>
                            <span>{{ $review->user->fullname ?? 'Ẩn danh' }}</span>
                            <span class="ins-review-item__course">
                                {{ Str::limit($review->course->title ?? '', 28) }}
                            </span>
                        </div>
                    </div>
                    <div class="dash-stars">
                        @for($s = 1; $s <= 5; $s++)
                            <i class="fa-{{ $s <= $review->rating ? 'solid' : 'regular' }} fa-star"></i>
                        @endfor
                    </div>
                </div>
                <p class="ins-review-item__text">
                    {{ $review->comment ?? 'Không có nhận xét.' }}
                </p>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Recent enrollments --}}
    <div class="dash-card">
        <div class="dash-card__header">
            <h3 class="dash-card__title">Học viên đăng ký gần đây</h3>
        </div>
        <div class="dash-table-wrap">
            <table class="dash-table">
                <thead>
                    <tr>
                        <th>Học viên</th>
                        <th>Khóa học</th>
                        <th>Ngày ĐK</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recent_enrollments as $enrollment)
                    <tr>
                        <td>
                            <div class="dash-user-cell">
                                <div class="dash-avatar"
                                     style="background-color: hsl({{ (($enrollment->user->user_id ?? 1) * 53) % 360 }}, 60%, 55%);">
                                    {{ mb_substr($enrollment->user->fullname ?? 'U', 0, 1) }}
                                </div>
                                <span>{{ $enrollment->user->fullname ?? '—' }}</span>
                            </div>
                        </td>
                        <td class="dash-table__muted dash-table__ellipsis">
                            {{ Str::limit($enrollment->course->title ?? '—', 24) }}
                        </td>
                        <td class="dash-table__muted">
                            {{ $enrollment->enrolled_at->format('d/m/Y') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection