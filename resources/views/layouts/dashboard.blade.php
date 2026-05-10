<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') — E-Learn</title>
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
</head>
<body class="dash-body">

<div class="dash-layout">

    {{-- ===== SIDEBAR ===== --}}
    <aside class="dash-sidebar" id="sidebar">

        <div class="dash-sidebar__logo">
            <a href="/">
                <span class="dash-sidebar__logo-mark">E</span>
                <span class="dash-sidebar__logo-text">E-Learn</span>
            </a>
        </div>

        <div class="dash-sidebar__section-label">@yield('sidebar-label', 'MENU')</div>

        <nav class="dash-sidebar__nav">
            @yield('sidebar-nav')
        </nav>

        <div class="dash-sidebar__bottom">
            <div class="dash-sidebar__user">
                <div class="dash-sidebar__user-avatar">
                    {{ mb_substr(auth()->user()->fullname ?? 'U', 0, 1) }}
                </div>
                <div class="dash-sidebar__user-info">
                    <span class="dash-sidebar__user-name">
                        {{ auth()->user()->fullname ?? 'User' }}
                    </span>
                    <span class="dash-sidebar__user-role">
                        {{ auth()->user()->role?->value ?? 'student' }}
                    </span>
                </div>
            </div>
            <a href="/" class="dash-sidebar__logout" title="Về trang chủ">
                <i class="fa-solid fa-arrow-right-from-bracket"></i>
            </a>
        </div>

    </aside>

    {{-- ===== MAIN ===== --}}
    <div class="dash-main" id="dashMain">

        {{-- Topbar --}}
        <header class="dash-topbar">
            <button class="dash-topbar__toggle" id="sidebarToggle" aria-label="Toggle sidebar">
                <i class="fa-solid fa-bars"></i>
            </button>

            <div class="dash-topbar__title">@yield('page-title', 'Dashboard')</div>

            <div class="dash-topbar__right">
                <div class="dash-topbar__search">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" placeholder="Tìm kiếm...">
                </div>

                <button class="dash-topbar__icon-btn" aria-label="Thông báo">
                    <i class="fa-regular fa-bell"></i>
                    <span class="dash-topbar__badge">3</span>
                </button>

                <a href="/" class="dash-topbar__home-btn" title="Trang chủ">
                    <i class="fa-solid fa-house"></i>
                </a>
            </div>
        </header>

        {{-- Content --}}
        <main class="dash-content">
            @yield('content')
        </main>

    </div>
</div>

<script>
(function () {
    const toggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');
    const main   = document.getElementById('dashMain');

    toggle?.addEventListener('click', () => {
        sidebar.classList.toggle('dash-sidebar--collapsed');
        main.classList.toggle('dash-main--expanded');
    });

    // Active link
    document.querySelectorAll('.dash-sidebar__nav-link').forEach(link => {
        if (link.href && window.location.href.startsWith(link.href)) {
            link.classList.add('active');
        }
    });
})();
</script>

</body>
</html>