@extends('layouts.app')
@section('title', 'Thanh toán — ' . $course->title)
@section('content')

<section style="min-height: calc(100vh - 80px); display: flex; align-items: center; justify-content: center; background: #f8fafc; padding: 60px 20px;">
    <div style="width: 100%; max-width: 900px; display: grid; grid-template-columns: 1fr 400px; gap: 32px; align-items: start;">

        {{-- Payment form --}}
        <div style="background: white; border-radius: 16px; border: 1px solid #e2e8f0; padding: 36px;">
            <h2 style="font-size: 24px; font-weight: 800; margin-bottom: 8px;">Thanh toán</h2>
            <p style="color: #64748b; font-size: 14px; margin-bottom: 32px;">Hoàn tất đăng ký khóa học</p>

            <form action="{{ route('student.payment.create', $course->course_id) }}" method="POST">
                @csrf

                <h3 style="font-size: 14px; font-weight: 700; margin-bottom: 16px; color: #0f172a;">Chọn phương thức thanh toán</h3>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 28px;">
                    @php
                        $methods = [
                            ['id'=>'vnpay','label'=>'VNPay','icon'=>'fa-credit-card','color'=>'#e3002b'],
                            ['id'=>'momo','label'=>'MoMo','icon'=>'fa-mobile-alt','color'=>'#ae2070'],
                            ['id'=>'credit_card','label'=>'Thẻ tín dụng','icon'=>'fa-credit-card','color'=>'#1a56db'],
                            ['id'=>'bank_transfer','label'=>'Chuyển khoản','icon'=>'fa-university','color'=>'#0369a1'],
                            ['id'=>'zalopay','label'=>'ZaloPay','icon'=>'fa-wallet','color'=>'#0068ff'],
                        ];
                    @endphp
                    @foreach($methods as $m)
                    <label style="display: flex; align-items: center; gap: 12px; padding: 14px 16px; border: 1.5px solid #e2e8f0; border-radius: 10px; cursor: pointer; transition: all 0.2s;"
                           onmouseover="this.style.borderColor='rgb(40,40,254)'" onmouseout="checkBorder(this)">
                        <input type="radio" name="payment_method" value="{{ $m['id'] }}" {{ $loop->first ? 'checked' : '' }}
                               style="accent-color: rgb(40,40,254); width: 16px; height: 16px;">
                        <i class="fa-solid {{ $m['icon'] }}" style="color: {{ $m['color'] }}; font-size: 18px; width: 24px;"></i>
                        <span style="font-size: 14px; font-weight: 600; color: #374151;">{{ $m['label'] }}</span>
                    </label>
                    @endforeach
                </div>

                <div style="background: #fffbeb; border: 1px solid #fcd34d; border-radius: 10px; padding: 14px 16px; margin-bottom: 24px; display: flex; gap: 10px; font-size: 13px; color: #92400e;">
                    <i class="fa-solid fa-shield-halved" style="margin-top: 1px;"></i>
                    <span>Thanh toán được bảo mật với mã hóa SSL 256-bit. Đảm bảo hoàn tiền trong 30 ngày.</span>
                </div>

                <button type="submit" style="width: 100%; padding: 16px; background: rgb(40,40,254); color: white; border: none; border-radius: 12px; font-size: 16px; font-weight: 800; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 10px;">
                    <i class="fa-solid fa-lock"></i>
                    Thanh toán {{ number_format($course->price, 0, '.', '.') }}đ
                </button>
            </form>
        </div>

        {{-- Order summary --}}
        <div style="background: white; border-radius: 16px; border: 1px solid #e2e8f0; overflow: hidden; position: sticky; top: 100px;">
            <img src="{{ $course->thumbnail_url ?? 'https://picsum.photos/seed/'.$course->course_id.'/400/220' }}"
                 alt="{{ $course->title }}" style="width: 100%; height: 200px; object-fit: cover; display: block;">
            <div style="padding: 24px;">
                <h3 style="font-size: 16px; font-weight: 700; margin-bottom: 6px; color: #0f172a; line-height: 1.4;">{{ $course->title }}</h3>
                <p style="font-size: 13px; color: #64748b; margin-bottom: 20px;">
                    {{ $course->user->fullname ?? 'Giảng viên' }} · {{ ucfirst($course->level) }}
                </p>

                <div style="border-top: 1px solid #f1f5f9; padding-top: 16px;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 14px; color: #64748b;">
                        <span>Giá gốc</span>
                        <span>{{ number_format($course->price, 0, '.', '.') }}đ</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; font-size: 17px; font-weight: 800; color: #0f172a; padding-top: 12px; border-top: 1px solid #e2e8f0;">
                        <span>Tổng cộng</span>
                        <span style="color: rgb(40,40,254);">{{ number_format($course->price, 0, '.', '.') }}đ</span>
                    </div>
                </div>

                <div style="margin-top: 20px; font-size: 12px; color: #94a3b8; display: flex; flex-direction: column; gap: 8px;">
                    <div style="display: flex; gap: 8px;"><i class="fa-solid fa-infinity"></i><span>Truy cập trọn đời</span></div>
                    <div style="display: flex; gap: 8px;"><i class="fa-solid fa-mobile-screen"></i><span>Học mọi thiết bị</span></div>
                    <div style="display: flex; gap: 8px;"><i class="fa-solid fa-certificate"></i><span>Chứng chỉ hoàn thành</span></div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
function checkBorder(el) {
    const inp = el.querySelector('input[type=radio]');
    el.style.borderColor = inp.checked ? 'rgb(40,40,254)' : '#e2e8f0';
}
document.querySelectorAll('input[type=radio]').forEach(r => {
    r.addEventListener('change', () => {
        document.querySelectorAll('label').forEach(l => l.style.borderColor = '#e2e8f0');
        r.closest('label').style.borderColor = 'rgb(40,40,254)';
    });
});
</script>
@endsection