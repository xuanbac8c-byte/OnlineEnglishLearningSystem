@extends('layouts.app')

@section('title', 'Đăng nhập')

@section('content')

<section class="auth-section">
    <div class="auth-card">

        <div class="auth-card__header">
            <a href="/" class="auth-logo">E-Learn</a>
            <h2>Chào mừng trở lại!</h2>
            <p>Đăng nhập để tiếp tục hành trình học của bạn.</p>
        </div>

        {{-- Social Login --}}
        <div class="auth-social">
            <button class="social-btn social-btn--google">
                <svg width="20" height="20" viewBox="0 0 24 24"><path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/><path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/><path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/><path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/></svg>
                Tiếp tục với Google
            </button>
            <button class="social-btn social-btn--facebook">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="#1877F2"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                Tiếp tục với Facebook
            </button>
        </div>

        <div class="auth-divider">
            <span>hoặc đăng nhập bằng email</span>
        </div>

        {{-- Login Form --}}
        <form action="/login" method="POST" class="auth-form">
            @csrf

            <div class="form-group">
                <label for="email">Email</label>
                <div class="input-wrapper">
                    <svg class="input-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                    <input type="email" id="email" name="email" placeholder="email@example.com"
                           value="{{ old('email') }}" required autofocus>
                </div>
                @error('email')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">
                    Mật khẩu
                    <a href="/forgot-password" class="form-link">Quên mật khẩu?</a>
                </label>
                <div class="input-wrapper">
                    <svg class="input-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                    <input type="password" id="password" name="password" placeholder="••••••••" required>
                    <button type="button" class="input-toggle" onclick="togglePassword()">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                    </button>
                </div>
                @error('password')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group form-group--row">
                <label class="checkbox-label">
                    <input type="checkbox" name="remember">
                    <span class="checkmark"></span>
                    Ghi nhớ đăng nhập
                </label>
            </div>

            <button type="submit" class="btn btn--secondary btn--full">Đăng nhập</button>
        </form>

        <p class="auth-card__footer">
            Chưa có tài khoản? <a href="/register" class="form-link">Đăng ký ngay</a>
        </p>

    </div>

    {{-- Right Panel --}}
    <div class="auth-panel">
        <div class="auth-panel__inner">
            <div class="auth-panel__quote">
                <div class="quote-mark">"</div>
                <p>E-Learn đã giúp tôi đạt TOEIC 850 sau 3 tháng học. Phương pháp giảng dạy rất dễ hiểu và thực tế!</p>
                <div class="quote-author">
                    <img src="https://i.pravatar.cc/48?img=32" alt="Student">
                    <div>
                        <strong>Nguyễn Thu Hà</strong>
                        <small>Học viên, TOEIC 850</small>
                    </div>
                </div>
            </div>
            <div class="auth-panel__stats">
                <div><strong>15,000+</strong><span>Học viên</span></div>
                <div><strong>4.8★</strong><span>Đánh giá</span></div>
                <div><strong>1,000+</strong><span>Khóa học</span></div>
            </div>
        </div>
    </div>
</section>

<script>
function togglePassword() {
    const input = document.getElementById('password');
    input.type = input.type === 'password' ? 'text' : 'password';
}
</script>

@endsection