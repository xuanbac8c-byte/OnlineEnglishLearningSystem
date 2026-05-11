@extends('layouts.dashboard')
@section('title', 'Quản lý khóa học')
@section('page-title', 'Quản lý khóa học')
@section('sidebar-label', 'QUẢN TRỊ')
@section('sidebar-nav')
    <a href="{{ route('admin.dashboard') }}" class="dash-sidebar__nav-link"><i class="fa-solid fa-chart-pie"></i><span>Tổng quan</span></a>
    <a href="{{ route('admin.users') }}" class="dash-sidebar__nav-link"><i class="fa-solid fa-users"></i><span>Người dùng</span></a>
    <a href="{{ route('admin.courses') }}" class="dash-sidebar__nav-link active"><i class="fa-solid fa-book-open"></i><span>Khóa học</span></a>
@endsection
@section('content')

@if(session('success'))
<div style="background: #f0fdf4; border: 1px solid #86efac; border-radius: 10px; padding: 12px 16px; margin-bottom: 16px; color: #16a34a; font-size: 14px; display: flex; gap: 10px;">
    <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
</div>
@endif

<form method="GET" style="display: flex; gap: 12px; flex-wrap: wrap; margin-bottom: 20px;">
    <div class="dash-filter-bar__search" style="flex: 1; min-width: 240px;">
        <i class="fa-solid fa-magnifying-glass" style="color: #94a3b8;"></i>
        <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="Tìm tên khóa học...">
    </div>
    <select name="level" class="dash-select" onchange="this.form.submit()">
        <option value="">Tất cả cấp độ</option>
        @foreach(['beginner','elementary','intermediate','upper_intermediate','advanced'] as $level)
        <option value="{{ $level }}" {{ request('level')==$level ? 'selected' : '' }}>{{ ucwords(str_replace('_',' ',$level)) }}</option>
        @endforeach
    </select>
    <button type="submit" style="padding: 9px 20px; background: rgb(40,40,254); color: white; border: none; border-radius: 10px; font-size: 13px; font-weight: 600; cursor: pointer;">Lọc</button>
</form>

<div class="dash-card dash-card--no-pad">
    <div class="dash-table-wrap">
        <table class="dash-table">
            <thead>
                <tr>
                    <th>Khóa học</th>
                    <th>Giảng viên</th>
                    <th>Cấp độ</th>
                    <th>Học viên</th>
                    <th>Đánh giá</th>
                    <th>Giá</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse($courses as $course)
                <tr>
                    <td>
                        <div class="dash-course-cell">
                            <img src="{{ $course->thumbnail_url ?? 'https://picsum.photos/seed/'.$course->course_id.'/60/40' }}"
                                 alt="{{ $course->title }}" class="dash-course-cell__thumb">
                            <div>
                                <span class="dash-course-cell__title">{{ Str::limit($course->title, 36) }}</span>
                                <span class="dash-course-cell__meta">{{ $course->sections_count }} chương</span>
                            </div>
                        </div>
                    </td>
                    <td class="dash-table__muted">{{ $course->user->fullname ?? '—' }}</td>
                    <td>
                        <span class="dash-level-badge dash-level-badge--{{ str_replace('_','',$course->level) }}">
                            {{ ucfirst(str_replace('_',' ',$course->level)) }}
                        </span>
                    </td>
                    <td>{{ number_format($course->enrollments_count) }}</td>
                    <td>
                        <span class="dash-rating">★ {{ number_format($course->course_reviews_avg_rating ?? 0, 1) }}</span>
                    </td>
                    <td><strong>{{ $course->price == 0 ? 'Miễn phí' : number_format($course->price, 0, '.', '.').'đ' }}</strong></td>
                    <td>
                        <span class="dash-badge dash-badge--{{ $course->is_published ? 'published' : 'draft' }}">
                            {{ $course->is_published ? 'Đang mở' : 'Ẩn' }}
                        </span>
                    </td>
                    <td>
                        <div class="dash-action-group">
                            <a href="{{ route('admin.courses.show', $course->course_id) }}" class="dash-action-btn" title="Xem">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            @if($course->is_published)
                            <form action="{{ route('admin.courses.unpublish', $course->course_id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="dash-action-btn" title="Ẩn khóa học" style="color: #f59e0b;">
                                    <i class="fa-solid fa-eye-slash"></i>
                                </button>
                            </form>
                            @else
                            <form action="{{ route('admin.courses.publish', $course->course_id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="dash-action-btn" title="Xuất bản" style="color: #10b981;">
                                    <i class="fa-solid fa-check"></i>
                                </button>
                            </form>
                            @endif
                            <form action="{{ route('admin.courses.destroy', $course->course_id) }}" method="POST"
                                  onsubmit="return confirm('Xóa khóa học này?');" style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="submit" class="dash-action-btn dash-action-btn--danger" title="Xóa">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align: center; color: #94a3b8; padding: 40px;">Không tìm thấy khóa học nào.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="dash-pagination">
        <span class="dash-pagination__info">{{ $courses->total() }} khóa học</span>
        {{ $courses->withQueryString()->links() }}
    </div>
</div>
@endsection