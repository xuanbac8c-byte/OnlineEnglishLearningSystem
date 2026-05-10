@extends('layouts.app')

@section('title', 'Đăng ký')

@section('content')

<section class="auth-section">
    <div class="auth-card auth-card--wide">

        <div class="auth-card__header">
            <a href="/" class="auth-logo">E-Learn</a>
            <h2>Tạo tài khoản miễn phí</h2>
            <p>Tham gia cùng 15,000+ học viên đang học tại E-Learn.</p>
        </div>
        
        {{-- Social Register --}}
        <div class="auth-social">
            <button class="social-btn social-btn--google">
                <svg width="20" height="20" viewBox="0 0 24 24"><path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/><path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/><path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/><path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/></svg>
                Đăng ký với Google
            </button>
        </div>

        <div class="auth-divider"><span>hoặc điền thông tin bên dưới</span></div>

        <form action="/register" method="POST" class="auth-form">
            @csrf

            <div class="form-row">
                <div class="form-group">
                    <label for="fullname">Họ và tên</label>
                    <div class="input-wrapper">
                        <svg class="input-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
                        <input type="text" id="fullname" name="fullname" placeholder="Nguyễn Văn A"
                               value="{{ old('fullname') }}" required>
                    </div>
                    @error('fullname') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <div class="input-wrapper">
                        <svg class="input-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                        <input type="email" id="email" name="email" placeholder="email@example.com"
                               value="{{ old('email') }}" required>
                    </div>
                    @error('email') <span class="form-error">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="password">Mật khẩu</label>
                    <div class="input-wrapper">
                        <svg class="input-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        <input type="password" id="password" name="password" placeholder="Ít nhất 8 ký tự" required>
                    </div>
                    @error('password') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Xác nhận mật khẩu</label>
                    <div class="input-wrapper">
                        <svg class="input-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Nhập lại mật khẩu" required>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Bạn là</label>
                <div class="role-selector">
                    <label class="role-option role-option--active" id="role-student">
                        <input type="radio" name="role" value="student" checked>
                        <div class="role-option__icon">📚</div>
                        <div>
                            <strong>Học viên</strong>
                            <small>Tôi muốn học các khóa học</small>
                        </div>
                    </label>
                    <label class="role-option" id="role-instructor">
                        <input type="radio" name="role" value="instructor">
                        <div class="role-option__icon">🎓</div>
                        <div>
                            <strong>Giảng viên</strong>
                            <small>Tôi muốn dạy học</small>
                        </div>
                    </label>
                </div>
            </div>

            {{-- Password strength --}}
            <div class="password-strength" id="password-strength" style="display:none">
                <div class="password-strength__bar">
                    <div class="password-strength__fill" id="strength-fill"></div>
                </div>
                <span id="strength-label">Mật khẩu yếu</span>
            </div>

            <div class="form-group form-group--row">
                <label class="checkbox-label">
                    <input type="checkbox" name="terms" required>
                    <span class="checkmark"></span>
                    Tôi đồng ý với <a href="/terms" class="form-link">Điều khoản dịch vụ</a>
                    và <a href="/privacy" class="form-link">Chính sách bảo mật</a>
                </label>
            </div>

            <button type="submit" class="btn btn--secondary btn--full">Tạo tài khoản</button>
        </form>

        <p class="auth-card__footer">
            Đã có tài khoản? <a href="/login" class="form-link">Đăng nhập</a>
        </p>

    </div>

    {{-- Right Panel --}}
    <div class="auth-panel">
        <div class="auth-panel__inner">
            <h3>Tại sao chọn E-Learn?</h3>
            <ul class="auth-panel__benefits">
                <li>
                    <span class="benefit-icon">✅</span>
                    <div><strong>Miễn phí đăng ký</strong><small>Không cần thẻ tín dụng</small></div>
                </li>
                <li>
                    <span class="benefit-icon">🎯</span>
                    <div><strong>Lộ trình cá nhân hóa</strong><small>Theo mục tiêu của bạn</small></div>
                </li>
                <li>
                    <span class="benefit-icon">📱</span>
                    <div><strong>Học mọi thiết bị</strong><small>PC, tablet, điện thoại</small></div>
                </li>
                <li>
                    <span class="benefit-icon">🏆</span>
                    <div><strong>Chứng chỉ hoàn thành</strong><small>Được công nhận toàn quốc</small></div>
                </li>
                <li>
                    <span class="benefit-icon">💬</span>
                    <div><strong>Hỗ trợ 24/7</strong><small>Đội ngũ tư vấn luôn sẵn sàng</small></div>
                </li>
            </ul>
        </div>
    </div>
</section>

<script>
    // Role selector
    document.querySelectorAll('.role-option input').forEach(radio => {
        radio.addEventListener('change', () => {
            document.querySelectorAll('.role-option').forEach(opt => opt.classList.remove('role-option--active'));
            radio.closest('.role-option').classList.add('role-option--active');
        });
    });

    // Password strength
    const pwInput = document.getElementById('password');
    const strengthBar = document.getElementById('password-strength');
    const strengthFill = document.getElementById('strength-fill');
    const strengthLabel = document.getElementById('strength-label');

    pwInput.addEventListener('input', () => {
        const val = pwInput.value;
        strengthBar.style.display = val ? 'flex' : 'none';
        let score = 0;
        if (val.length >= 8) score++;
        if (/[A-Z]/.test(val)) score++;
        if (/[0-9]/.test(val)) score++;
        if (/[^A-Za-z0-9]/.test(val)) score++;
        const colors = ['#ef4444','#f97316','#eab308','#22c55e'];
        const labels = ['Yếu','Trung bình','Tốt','Rất mạnh'];
        strengthFill.style.width = (score * 25) + '%';
        strengthFill.style.background = colors[score - 1] || '#ef4444';
        strengthLabel.textContent = labels[score - 1] || 'Mật khẩu yếu';
    });
</script>

@endsection