@extends('layouts.dashboard')
@section('title', 'Quản lý người dùng')
@section('page-title', 'Quản lý người dùng')
@section('sidebar-label', 'QUẢN TRỊ')

@section('sidebar-nav')
    <a href="{{ route('admin.dashboard') }}" class="dash-sidebar__nav-link"><i class="fa-solid fa-chart-pie"></i><span>Tổng quan</span></a>
    <a href="{{ route('admin.users') }}" class="dash-sidebar__nav-link active"><i class="fa-solid fa-users"></i><span>Người dùng</span></a>
    <a href="{{ route('admin.courses') }}" class="dash-sidebar__nav-link"><i class="fa-solid fa-book-open"></i><span>Khóa học</span></a>
    <div class="dash-sidebar__divider"></div>
    <a href="{{ route('home') }}" class="dash-sidebar__nav-link"><i class="fa-solid fa-globe"></i><span>Về trang chủ</span></a>
@endsection

@section('content')

{{-- Alerts --}}
@if(session('success'))
<div style="background: #f0fdf4; border: 1px solid #86efac; border-radius: 10px; padding: 12px 16px; margin-bottom: 16px; color: #16a34a; font-size: 14px; display: flex; gap: 10px;">
    <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
</div>
@endif

{{-- Filter bar --}}
<form method="GET" action="{{ route('admin.users') }}" style="display: flex; gap: 12px; flex-wrap: wrap; margin-bottom: 20px;">
    <div class="dash-filter-bar__search" style="flex: 1; min-width: 240px;">
        <i class="fa-solid fa-magnifying-glass" style="color: #94a3b8;"></i>
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Tìm theo tên hoặc email...">
    </div>
    <select name="role" class="dash-select" onchange="this.form.submit()">
        <option value="">Tất cả vai trò</option>
        <option value="student"    {{ request('role')=='student'    ? 'selected' : '' }}>Học viên</option>
        <option value="instructor" {{ request('role')=='instructor' ? 'selected' : '' }}>Giảng viên</option>
        <option value="admin"      {{ request('role')=='admin'      ? 'selected' : '' }}>Admin</option>
    </select>
    <button type="submit" style="padding: 9px 20px; background: rgb(40,40,254); color: white; border: none; border-radius: 10px; font-size: 13px; font-weight: 600; cursor: pointer;">
        <i class="fa-solid fa-search"></i> Tìm kiếm
    </button>
    @if(request('search') || request('role'))
    <a href="{{ route('admin.users') }}" style="padding: 9px 16px; border: 1px solid #e2e8f0; border-radius: 10px; font-size: 13px; color: #64748b; text-decoration: none;">
        <i class="fa-solid fa-times"></i> Xóa lọc
    </a>
    @endif
</form>

{{-- Table --}}
<div class="dash-card dash-card--no-pad">
    <div class="dash-table-wrap">
        <table class="dash-table">
            <thead>
                <tr>
                    <th><input type="checkbox" class="dash-checkbox"></th>
                    <th>Người dùng</th>
                    <th>Email</th>
                    <th>Vai trò</th>
                    <th>Ngày tham gia</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td><input type="checkbox" class="dash-checkbox"></td>
                    <td>
                        <div class="dash-user-cell">
                            @if($user->avatar_url)
                                <img src="{{ $user->avatar_url }}" alt="{{ $user->fullname }}"
                                     style="width: 34px; height: 34px; border-radius: 50%; object-fit: cover;">
                            @else
                                <div class="dash-avatar" style="background: hsl({{ $user->user_id * 47 % 360 }}, 60%, 55%);">
                                    {{ mb_substr($user->fullname, 0, 1) }}
                                </div>
                            @endif
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
                            <a href="{{ route('admin.users.show', $user->user_id) }}" class="dash-action-btn" title="Xem chi tiết">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.users.edit', $user->user_id) }}" class="dash-action-btn" title="Chỉnh sửa">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            @if($user->user_id !== session('user_id'))
                            <form action="{{ route('admin.users.destroy', $user->user_id) }}" method="POST"
                                  onsubmit="return confirm('Xóa người dùng {{ $user->fullname }}?');" style="display: inline;">
                                @csrf @method('DELETE')
                                <button type="submit" class="dash-action-btn dash-action-btn--danger" title="Xóa">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; color: #94a3b8; padding: 40px;">
                        <i class="fa-solid fa-users" style="font-size: 32px; margin-bottom: 12px; display: block;"></i>
                        Không tìm thấy người dùng nào.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="dash-pagination">
        <span class="dash-pagination__info">
            Hiển thị {{ $users->firstItem() }}–{{ $users->lastItem() }} / {{ $users->total() }} người dùng
        </span>
        {{ $users->withQueryString()->links() }}
    </div>
</div>

@endsection