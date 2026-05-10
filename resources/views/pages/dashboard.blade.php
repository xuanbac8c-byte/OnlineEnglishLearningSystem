@extends('layouts.dashboard')

@section('title', 'Dashboard Học viên')
@section('page-title', 'Trang học viên')
@section('sidebar-label', 'HỌC VIÊN')

@section('sidebar-nav')
    <a href="{{ route('student.dashboard') }}" class="dash-sidebar__nav-link">
        <i class="fa-solid fa-house"></i>
        <span>Tổng quan</span>
    </a>
    <a href="{{ route('student.my-courses') }}" class="dash-sidebar__nav-link">
        <i class="fa-solid fa-book-open"></i>
        <span>Khóa học của tôi</span>
        <span class="dash-sidebar__nav-badge">{{ $stats['enrolled_courses'] }}</span>
    </a>
    <a href="#" class="dash-sidebar__nav-link">
        <i class="fa-solid fa-circle-check"></i>
        <span>Bài kiểm tra</span>
    </a>
    <a href="#" class="dash-sidebar__nav-link">
        <i class="fa-solid fa-certificate"></i>
        <span>Chứng chỉ</span>
        <span class="dash-sidebar__nav-badge">{{ $stats['certificates'] }}</span>
    </a>
    <a href="/courses" class="dash-sidebar__nav-link">
        <i class="fa-solid fa-magnifying-glass"></i>
        <span>Khám phá khóa học</span>
    </a>
    <div class="dash-sidebar__divider"></div>
    <a href="#" class="dash-sidebar__nav-link">
        <i class="fa-solid fa-gear"></i>
        <span>Cài đặt</span>
    </a>
@endsection

@section('content')

{{-- ── STAT CARDS ─────────────────────────────────────── --}}
<div class="stu-stat-grid">

    <div class="stu-stat-card stu-stat-card--blue">
        <div class="stu-stat-card__icon"><i class="fa-solid fa-book-open"></i></div>
        <div class="stu-stat-card__body">
            <span class="stu-stat-card__label">Khóa học đã đăng ký</span>
            <span class="stu-stat-card__value">{{ $stats['enrolled_courses'] }}</span>
            <span class="stu-stat-card__sub">{{ $stats['in_progress'] }} đang học</span>
        </div>
    </div>

    <div class="stu-stat-card stu-stat-card--green">
        <div class="stu-stat-card__icon"><i class="fa-solid fa-circle-check"></i></div>
        <div class="stu-stat-card__body">
            <span class="stu-stat-card__label">Đã hoàn thành</span>
            <span class="stu-stat-card__value">{{ $stats['completed_courses'] }}</span>
            <span class="stu-stat-card__sub">{{ $stats['completed_lessons'] }} bài học</span>
        </div>
    </div>

    <div class="stu-stat-card stu-stat-card--amber">
        <div class="stu-stat-card__icon"><i class="fa-solid fa-certificate"></i></div>
        <div class="stu-stat-card__body">
            <span class="stu-stat-card__label">Chứng chỉ</span>
            <span class="stu-stat-card__value">{{ $stats['certificates'] }}</span>
            <span class="stu-stat-card__sub">Đã nhận được</span>
        </div>
    </div>

    <div class="stu-stat-card stu-stat-card--purple">
        <div class="stu-stat-card__icon"><i class="fa-solid fa-brain"></i></div>
        <div class="stu-stat-card__body">
            <span class="stu-stat-card__label">Điểm quiz TB</span>
            <span class="stu-stat-card__value">{{ $stats['avg_quiz_score'] }}%</span>
            <span class="stu-stat-card__sub">{{ $stats['quiz_passed'] }} bài đạt</span>
        </div>
    </div>

</div>

{{-- ── Continue learning banner ────────────────────────── --}}
@if($continue_course)
<div class="stu-continue-card">
    <img src="{{ $continue_course->thumbnail_url
                 ?? 'https://picsum.photos/seed/'.$continue_course->course_id.'/96/64' }}"
         alt="{{ $continue_course->title }}"
         class="stu-continue-card__thumb">
    <div class="stu-continue-card__info">
        <div class="stu-continue-card__tag">
            <i class="fa-solid fa-play"></i> Tiếp tục học
        </div>
        <div class="stu-continue-card__title">{{ $continue_course->title }}</div>
        <div class="stu-continue-card__progress-wrap">
            <div class="stu-continue-card__progress-bar">
                <div class="stu-continue-card__progress-fill"
                     style="width: '{{ $continue_progress }}%'">
                </div>
            </div>
            <span class="stu-continue-card__percent">{{ $continue_progress }}%</span>
        </div>
    </div>
    <div class="stu-continue-card__action">
        <a href="/courses/{{ $continue_course->course_id }}" class="btn btn--secondary">
            Học tiếp <i class="fa-solid fa-arrow-right"></i>
        </a>
    </div>
</div>
@endif

{{-- ── ROW: My courses + Quiz results ───────────────────── --}}
<div class="dash-row dash-row--2-1">

    {{-- My courses --}}
    <div class="dash-card">
        <div class="dash-card__header">
            <h3 class="dash-card__title">Khóa học của tôi</h3>
            <a href="{{ route('student.my-courses') }}" class="dash-card__link">Xem tất cả →</a>
        </div>
        <div class="stu-course-list">
            @foreach($my_courses as $enrollment)
            @php
                $course   = $enrollment->course;
                $progress = $enrollment->progress_percent ?? rand(20, 95);
                $color    = $progress >= 100 ? '#10b981' : ($progress >= 50 ? 'rgb(40,40,254)' : '#f59e0b');
                $status   = $progress >= 100 ? 'completed' : ($progress > 0 ? 'inprogress' : 'notstarted');
            @endphp
            <div class="stu-course-item">
                <img src="{{ $course->thumbnail_url
                             ?? 'https://picsum.photos/seed/'.$course->course_id.'/72/48' }}"
                     alt="{{ $course->title }}"
                     class="stu-course-item__thumb">
                <div class="stu-course-item__info">
                    <div class="stu-course-item__title">{{ Str::limit($course->title, 40) }}</div>
                    <div class="stu-course-item__meta">
                        {{ $course->user->fullname ?? 'Giảng viên' }}
                        · {{ $course->sections_count ?? 0 }} chương
                    </div>
                    <div class="stu-course-item__progress-wrap">
                        <div class="stu-course-item__progress-bar">
                            <div class="stu-course-item__progress-fill"
                                 style="width: '{{ $progress }}%'; background: '{{ $color }}'">
                            </div>
                        </div>
                        <span class="stu-course-item__percent">{{ $progress }}%</span>
                    </div>
                </div>
                <div class="stu-course-item__badge-wrap">
                    <span class="dash-badge dash-badge--{{ $status }}">
                        {{ match($status) {
                            'completed'  => 'Xong',
                            'inprogress' => 'Đang học',
                            default      => 'Chưa bắt đầu',
                        } }}
                    </span>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Right column --}}
    <div style="display: flex; flex-direction: column; gap: 20px;">

        {{-- Streak --}}
        <div class="dash-card">
            <div class="dash-card__header">
                <h3 class="dash-card__title">Chuỗi học hàng ngày</h3>
            </div>
            <div class="stu-streak">
                <div class="stu-streak__fire">🔥</div>
                <div class="stu-streak__info">
                    <div class="stu-streak__number">{{ $stats['streak_days'] }}</div>
                    <div class="stu-streak__label">ngày liên tiếp</div>
                </div>
            </div>
        </div>

        {{-- Quiz results --}}
        <div class="dash-card">
            <div class="dash-card__header">
                <h3 class="dash-card__title">Kết quả quiz</h3>
                <a href="#" class="dash-card__link">Xem tất cả →</a>
            </div>
            <div class="stu-quiz-list">
                @foreach($quiz_attempts as $attempt)
                <div class="stu-quiz-item">
                    <div class="stu-quiz-item__score-ring
                         stu-quiz-item__score-ring--{{ $attempt->is_passed ? 'pass' : 'fail' }}">
                        {{ round($attempt->score) }}%
                    </div>
                    <div class="stu-quiz-item__info">
                        <div class="stu-quiz-item__title">
                            {{ Str::limit($attempt->quiz->title ?? 'Quiz', 28) }}
                        </div>
                        <div class="stu-quiz-item__meta">
                            Lần {{ $attempt->attempt_number }}
                            · {{ $attempt->submitted_at?->format('d/m/Y') ?? '—' }}
                        </div>
                    </div>
                    <div class="stu-quiz-item__result">
                        <span class="dash-badge dash-badge--{{ $attempt->is_passed ? 'published' : 'failed' }}">
                            {{ $attempt->is_passed ? 'Đạt' : 'Chưa đạt' }}
                        </span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

    </div>

</div>

{{-- ── ROW: Certificates + Activity ─────────────────────── --}}
<div class="dash-row dash-row--2">

    {{-- Certificates --}}
    <div class="dash-card">
        <div class="dash-card__header">
            <h3 class="dash-card__title">Chứng chỉ của tôi</h3>
            <a href="#" class="dash-card__link">Xem tất cả →</a>
        </div>
        @if($certificates->isEmpty())
            <p style="color: #94a3b8; font-size: 13px; text-align: center; padding: 20px 0;">
                Hoàn thành khóa học để nhận chứng chỉ đầu tiên 🎓
            </p>
        @else
        <div class="stu-cert-list">
            @foreach($certificates as $cert)
            <div class="stu-cert-item">
                <div class="stu-cert-item__icon">
                    <i class="fa-solid fa-trophy"></i>
                </div>
                <div class="stu-cert-item__info">
                    <div class="stu-cert-item__title">
                        {{ Str::limit($cert->course->title ?? 'Khóa học', 36) }}
                    </div>
                    <div class="stu-cert-item__code">{{ $cert->cert_code }}</div>
                </div>
                <a href="#" class="stu-cert-item__action">
                    <i class="fa-solid fa-download"></i> Tải về
                </a>
            </div>
            @endforeach
        </div>
        @endif
    </div>

    {{-- Activity heatmap --}}
    <div class="dash-card">
        <div class="dash-card__header">
            <h3 class="dash-card__title">Hoạt động học tập (12 tuần)</h3>
        </div>
        @php
            // Sinh dữ liệu heatmap giả 12 tuần × 7 ngày
            $heatmap = [];
            for ($w = 0; $w < 12; $w++) {
                $week = [];
                for ($d = 0; $d < 7; $d++) {
                    $v = rand(0, 10);
                    $week[] = $v === 0 ? '' : ($v <= 3 ? 'l1' : ($v <= 6 ? 'l2' : ($v <= 8 ? 'l3' : 'l4')));
                }
                $heatmap[] = $week;
            }
            $days = ['CN','T2','T3','T4','T5','T6','T7'];
        @endphp
        <div class="stu-activity">
            <div class="stu-activity__grid">
                @foreach($heatmap as $week)
                <div class="stu-activity__week">
                    @foreach($week as $level)
                    <div class="stu-activity__day {{ $level ? 'stu-activity__day--'.$level : '' }}"
                         title="{{ $level ? 'Đã học' : 'Không hoạt động' }}">
                    </div>
                    @endforeach
                </div>
                @endforeach
            </div>
            <div class="stu-activity__labels">
                @foreach($days as $d)
                <span>{{ $d }}</span>
                @endforeach
            </div>
        </div>
        <div style="display: flex; align-items: center; gap: 6px; margin-top: 16px; font-size: 11px; color: #94a3b8;">
            <span>Ít</span>
            <div style="width: 12px; height: 12px; border-radius: 2px; background: #e2e8f0;"></div>
            <div style="width: 12px; height: 12px; border-radius: 2px; background: #bfdbfe;"></div>
            <div style="width: 12px; height: 12px; border-radius: 2px; background: #60a5fa;"></div>
            <div style="width: 12px; height: 12px; border-radius: 2px; background: rgb(40,40,254);"></div>
            <span>Nhiều</span>
        </div>
    </div>

</div>

@endsection