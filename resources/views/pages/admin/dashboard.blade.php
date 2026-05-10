@extends('layouts.dashboard')

@section('title', 'Admin Dashboard')
@section('page-title', 'Tổng quan hệ thống')
@section('sidebar-label', 'QUẢN TRỊ')

@section('sidebar-nav')
    <a href="{{ route('admin.dashboard') }}" class="dash-sidebar__nav-link">
        <i class="fa-solid fa-chart-pie"></i>
        <span>Tổng quan</span>
    </a>
    <a href="{{ route('admin.users') }}" class="dash-sidebar__nav-link">
        <i class="fa-solid fa-users"></i>
        <span>Người dùng</span>
        <span class="dash-sidebar__nav-badge">{{ number_format($stats['total_users']) }}</span>
    </a>
    <a href="{{ route('admin.courses') }}" class="dash-sidebar__nav-link">
        <i class="fa-solid fa-book-open"></i>
        <span>Khóa học</span>
        <span class="dash-sidebar__nav-badge">{{ number_format($stats['total_courses']) }}</span>
    </a>
    <a href="#" class="dash-sidebar__nav-link">
        <i class="fa-solid fa-credit-card"></i>
        <span>Thanh toán</span>
    </a>
    <a href="#" class="dash-sidebar__nav-link">
        <i class="fa-solid fa-star"></i>
        <span>Đánh giá</span>
    </a>
    <a href="#" class="dash-sidebar__nav-link">
        <i class="fa-solid fa-certificate"></i>
        <span>Chứng chỉ</span>
    </a>
    <div class="dash-sidebar__divider"></div>
    <a href="#" class="dash-sidebar__nav-link">
        <i class="fa-solid fa-gear"></i>
        <span>Cài đặt</span>
    </a>
@endsection

@section('content')

{{-- ── STAT CARDS ─────────────────────────────────────── --}}
<div class="dash-stat-grid">

    <div class="dash-stat-card dash-stat-card--blue">
        <div class="dash-stat-card__icon">
            <i class="fa-solid fa-users"></i>
        </div>
        <div class="dash-stat-card__body">
            <span class="dash-stat-card__label">Tổng người dùng</span>
            <span class="dash-stat-card__value">{{ number_format($stats['total_users']) }}</span>
            <span class="dash-stat-card__trend dash-stat-card__trend--up">
                <i class="fa-solid fa-arrow-trend-up"></i> +12% tháng này
            </span>
        </div>
    </div>

    <div class="dash-stat-card dash-stat-card--green">
        <div class="dash-stat-card__icon">
            <i class="fa-solid fa-book-open"></i>
        </div>
        <div class="dash-stat-card__body">
            <span class="dash-stat-card__label">Tổng khóa học</span>
            <span class="dash-stat-card__value">{{ number_format($stats['total_courses']) }}</span>
            <span class="dash-stat-card__trend dash-stat-card__trend--up">
                <i class="fa-solid fa-arrow-trend-up"></i> +8% tháng này
            </span>
        </div>
    </div>

    <div class="dash-stat-card dash-stat-card--amber">
        <div class="dash-stat-card__icon">
            <i class="fa-solid fa-money-bill-wave"></i>
        </div>
        <div class="dash-stat-card__body">
            <span class="dash-stat-card__label">Doanh thu</span>
            <span class="dash-stat-card__value">
                {{ number_format($stats['total_revenue'] / 1000000, 1) }}tr đ
            </span>
            <span class="dash-stat-card__trend dash-stat-card__trend--up">
                <i class="fa-solid fa-arrow-trend-up"></i> +23% tháng này
            </span>
        </div>
    </div>

    <div class="dash-stat-card dash-stat-card--purple">
        <div class="dash-stat-card__icon">
            <i class="fa-solid fa-graduation-cap"></i>
        </div>
        <div class="dash-stat-card__body">
            <span class="dash-stat-card__label">Lượt đăng ký</span>
            <span class="dash-stat-card__value">{{ number_format($stats['total_enrollments']) }}</span>
            <span class="dash-stat-card__trend dash-stat-card__trend--up">
                <i class="fa-solid fa-arrow-trend-up"></i> +18% tháng này
            </span>
        </div>
    </div>

</div>

{{-- ── ROW: Revenue chart + Role donut ──────────────────── --}}
<div class="dash-row dash-row--2-1">

    {{-- Bar chart --}}
    <div class="dash-card">
        <div class="dash-card__header">
            <h3 class="dash-card__title">Doanh thu theo tháng</h3>
            <div class="dash-card__actions">
                <select class="dash-select">
                    <option>2026</option>
                    <option>2025</option>
                </select>
            </div>
        </div>
        @php
            $months   = ['T1','T2','T3','T4','T5','T6','T7','T8','T9','T10','T11','T12'];
            $revenues = [42, 58, 71, 65, 83, 90, 77, 94, 88, 102, 115, 130];
            $maxRev   = max($revenues);
        @endphp
        <div class="dash-chart">
            @foreach($months as $i => $m)
            <div class="dash-chart__col">
                <div class="dash-chart__bar-wrap">
                    <div class="dash-chart__bar"
                         style="height: '{{ round(($revenues[$i] / $maxRev) * 100) }}%'"
                         title="{{ $m }}: {{ $revenues[$i] }}tr đ">
                    </div>
                </div>
                <span class="dash-chart__label">{{ $m }}</span>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Donut --}}
    <div class="dash-card">
        <div class="dash-card__header">
            <h3 class="dash-card__title">Phân loại người dùng</h3>
        </div>
        <div class="dash-donut-wrap">
            <svg viewBox="0 0 120 120" class="dash-donut">
                @php
                    $total     = $stats['total_users'] ?: 1;
                    $students  = $stats['student_count']    ?? ($total - 30);
                    $instructors = $stats['instructor_count'] ?? 20;
                    $admins    = $stats['admin_count']      ?? 10;
                    $circum    = 283;
                    $sLen = round($students    / $total * $circum);
                    $iLen = round($instructors / $total * $circum);
                    $aLen = round($admins      / $total * $circum);
                @endphp
                <circle cx="60" cy="60" r="45" fill="none" stroke="#e2e8f0" stroke-width="18"/>
                <circle cx="60" cy="60" r="45" fill="none"
                        stroke="rgb(40,40,254)" stroke-width="18"
                        stroke-dasharray="{{ $sLen }} {{ $circum }}"
                        stroke-dashoffset="0" transform="rotate(-90 60 60)"/>
                <circle cx="60" cy="60" r="45" fill="none"
                        stroke="#10b981" stroke-width="18"
                        stroke-dasharray="{{ $iLen }} {{ $circum }}"
                        stroke-dashoffset="{{ -$sLen }}" transform="rotate(-90 60 60)"/>
                <circle cx="60" cy="60" r="45" fill="none"
                        stroke="#f59e0b" stroke-width="18"
                        stroke-dasharray="{{ $aLen }} {{ $circum }}"
                        stroke-dashoffset="{{ -($sLen + $iLen) }}" transform="rotate(-90 60 60)"/>
                <text x="60" y="55" text-anchor="middle" font-size="14" font-weight="700" fill="#0f172a">
                    {{ number_format($total) }}
                </text>
                <text x="60" y="69" text-anchor="middle" font-size="9" fill="#94a3b8">users</text>
            </svg>
        </div>
        <div class="dash-legend">
            <div class="dash-legend__item">
                <span class="dash-legend__dot" style="background: rgb(40,40,254)"></span>
                <span>Học viên</span>
                <strong>{{ number_format($students) }}</strong>
            </div>
            <div class="dash-legend__item">
                <span class="dash-legend__dot" style="background: #10b981"></span>
                <span>Giảng viên</span>
                <strong>{{ number_format($instructors) }}</strong>
            </div>
            <div class="dash-legend__item">
                <span class="dash-legend__dot" style="background: #f59e0b"></span>
                <span>Admin</span>
                <strong>{{ number_format($admins) }}</strong>
            </div>
        </div>
    </div>

</div>

{{-- ── ROW: Recent users ─────────────────────────────────── --}}
<div class="dash-card">
    <div class="dash-card__header">
        <h3 class="dash-card__title">Người dùng mới nhất</h3>
        <a href="{{ route('admin.users') }}" class="dash-card__link">Xem tất cả →</a>
    </div>
    <div class="dash-table-wrap">
        <table class="dash-table">
            <thead>
                <tr>
                    <th>Người dùng</th>
                    <th>Email</th>
                    <th>Vai trò</th>
                    <th>Ngày tham gia</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recent_users as $user)
                <tr>
                    <td>
                        <div class="dash-user-cell">
                            <div class="dash-avatar"
                                 style="background: 'hsl({{ $user->user_id * 47 % 360 }}, 65%, 55%)'">
                                {{ mb_substr($user->fullname, 0, 1) }}
                            </div>
                            <div>
                                <span class="dash-user-cell__name">{{ $user->fullname }}</span>
                                <span class="dash-user-cell__sub">#{{ $user->user_id }}</span>
                            </div>
                        </div>
                    </td>
                    <td class="dash-table__muted">{{ $user->email }}</td>
                    <td>
                        <span class="dash-badge dash-badge--{{ $user->role->value }}">
                            {{ match($user->role->value) {
                                'student'    => 'Học viên',
                                'instructor' => 'Giảng viên',
                                'admin'      => 'Admin',
                                default      => $user->role->value,
                            } }}
                        </span>
                    </td>
                    <td class="dash-table__muted">{{ $user->created_at->format('d/m/Y') }}</td>
                    <td>
                        <div class="dash-action-group">
                            <button class="dash-action-btn" title="Xem"><i class="fa-solid fa-eye"></i></button>
                            <button class="dash-action-btn" title="Sửa"><i class="fa-solid fa-pen"></i></button>
                            <button class="dash-action-btn dash-action-btn--danger" title="Xóa">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- ── ROW: Recent payments + Top courses ───────────────── --}}
<div class="dash-row dash-row--3-2">

    {{-- Payments --}}
    <div class="dash-card">
        <div class="dash-card__header">
            <h3 class="dash-card__title">Thanh toán gần đây</h3>
            <a href="#" class="dash-card__link">Xem tất cả →</a>
        </div>
        <div class="dash-table-wrap">
            <table class="dash-table">
                <thead>
                    <tr>
                        <th>Mã GD</th>
                        <th>Học viên</th>
                        <th>Số tiền</th>
                        <th>Phương thức</th>
                        <th>Trạng thái</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recent_payments as $p)
                    <tr>
                        <td class="dash-table__mono">
                            {{ strtoupper(substr($p->transaction_ref, 0, 10)) }}
                        </td>
                        <td>{{ $p->user->fullname ?? '—' }}</td>
                        <td><strong>{{ number_format($p->amount, 0, '.', '.') }}đ</strong></td>
                        <td class="dash-table__muted">{{ $p->payment_method }}</td>
                        <td>
                            <span class="dash-badge dash-badge--{{ $p->status }}">
                                {{ match($p->status) {
                                    'paid'     => 'Đã TT',
                                    'pending'  => 'Chờ',
                                    'failed'   => 'Lỗi',
                                    'refunded' => 'Hoàn',
                                    default    => $p->status,
                                } }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Top courses --}}
    <div class="dash-card">
        <div class="dash-card__header">
            <h3 class="dash-card__title">Khóa học nổi bật</h3>
            <a href="{{ route('admin.courses') }}" class="dash-card__link">Xem tất cả →</a>
        </div>
        @foreach($top_courses as $course)
        <div class="dash-course-row">
            <img src="{{ $course->thumbnail_url
                         ?? 'https://picsum.photos/seed/'.$course->course_id.'/60/40' }}"
                 alt="{{ $course->title }}"
                 class="dash-course-row__thumb">
            <div class="dash-course-row__info">
                <span class="dash-course-row__title">
                    {{ Str::limit($course->title, 32) }}
                </span>
                <span class="dash-course-row__meta">
                    {{ $course->enrollments_count }} học viên
                    · ★ {{ number_format($course->course_reviews_avg_rating ?? 0, 1) }}
                </span>
            </div>
            <span class="dash-badge dash-badge--{{ $course->is_published ? 'published' : 'draft' }}">
                {{ $course->is_published ? 'Live' : 'Draft' }}
            </span>
        </div>
        @endforeach
    </div>

</div>

@endsection