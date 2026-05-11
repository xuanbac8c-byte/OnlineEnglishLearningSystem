<nav class="navbar">
    <div class="navbar__logo">
        <a href="/">
            <div class="logo-title">E-Learn</div>
            <span>English Online</span>
        </a>
    </div>

    <div class="navbar__links">
        <a href="/" class="{{ request()->is('/') ? 'active' : '' }}">Home</a>
        <a href="{{ route('courses.index') }}" class="{{ request()->is('courses*') ? 'active' : '' }}">Courses</a>
        <a href="{{ route('roadmap') }}" class="{{ request()->is('roadmap*') ? 'active' : '' }}">Road Maps</a>
        <a href="{{ route('instructor.index') }}" class="{{ request()->is('instructors*') ? 'active' : '' }}">Instructors</a>
        <a href="{{ route('blog.index') }}" class="{{ request()->is('blog*') ? 'active' : '' }}">Blog</a>
        <a href="{{ route('about') }}" class="{{ request()->is('about*') ? 'active' : '' }}">About Us</a>
    </div>

    <div class="navbar__actions">
        <input type="text" placeholder="Search...">

        @if(session('user_id'))
            {{-- Đã đăng nhập --}}
            @php
                $dashRoute = match(session('role')) {
                    'admin'      => route('admin.dashboard'),
                    'instructor' => route('instructor.dashboard'),
                    default      => route('student.dashboard'),
                };
                $roleLabel = match(session('role')) {
                    'admin'      => 'Admin',
                    'instructor' => 'Giảng viên',
                    default      => 'Học viên',
                };
            @endphp
            <a href="{{ $dashRoute }}" class="btn btn--primary">
                {{ mb_substr(session('fullname', 'U'), 0, 1) }} · {{ $roleLabel }}
            </a>
            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="btn btn--secondary" style="cursor:pointer;border:none;">
                    Đăng xuất
                </button>
            </form>
        @else
            {{-- Chưa đăng nhập --}}
            <a href="{{ route('login') }}" class="btn btn--primary">Đăng nhập</a>
            <a href="{{ route('register') }}" class="btn btn--secondary">Đăng ký</a>
        @endif
    </div>
</nav>
