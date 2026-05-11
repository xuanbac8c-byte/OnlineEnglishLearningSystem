@extends('layouts.app')

@section('title', $course->title . ' — E-Learn')

@section('content')

{{-- Hero --}}
<section style="background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 100%); color: white; padding: 60px 80px 0;">
    <div style="max-width: 1200px; margin: 0 auto; display: flex; gap: 60px; align-items: flex-start;">
        <div style="flex: 1; padding-bottom: 40px;">
            <div style="display: flex; gap: 10px; margin-bottom: 16px; flex-wrap: wrap;">
                <span style="background: rgba(255,255,255,0.15); color: #93c5fd; font-size: 12px; font-weight: 700; padding: 5px 14px; border-radius: 100px; text-transform: uppercase; letter-spacing: 1px;">
                    {{ $course->language->name ?? 'English' }}
                </span>
                <span style="background: rgba(255,255,255,0.12); color: #c7d2fe; font-size: 12px; font-weight: 700; padding: 5px 14px; border-radius: 100px; text-transform: uppercase; letter-spacing: 1px;">
                    {{ ucfirst(str_replace('_', ' ', $course->level)) }}
                </span>
                @if($course->is_published)
                <span style="background: #10b981; color: white; font-size: 12px; font-weight: 700; padding: 5px 14px; border-radius: 100px;">
                    ✓ Đang mở
                </span>
                @endif
            </div>

            <h1 style="font-size: 38px; font-weight: 800; line-height: 1.25; margin-bottom: 20px;">
                {{ $course->title }}
            </h1>

            <p style="font-size: 17px; line-height: 1.8; color: #cbd5e1; margin-bottom: 28px;">
                {{ Str::limit($course->description, 200) }}
            </p>

            <div style="display: flex; gap: 24px; flex-wrap: wrap; margin-bottom: 28px;">
                <div style="display: flex; align-items: center; gap: 8px; font-size: 14px;">
                    <span style="color: #f59e0b; font-size: 16px;">★</span>
                    <strong>{{ number_format($course->courseReviews->avg('rating') ?? 0, 1) }}</strong>
                    <span style="color: #94a3b8;">({{ $course->courseReviews->count() }} đánh giá)</span>
                </div>
                <div style="display: flex; align-items: center; gap: 8px; font-size: 14px;">
                    <i class="fa-solid fa-users" style="color: #94a3b8;"></i>
                    <span>{{ $course->enrollments->count() }} học viên</span>
                </div>
                <div style="display: flex; align-items: center; gap: 8px; font-size: 14px;">
                    <i class="fa-solid fa-layer-group" style="color: #94a3b8;"></i>
                    <span>{{ $course->sections->count() }} chương</span>
                </div>
                <div style="display: flex; align-items: center; gap: 8px; font-size: 14px;">
                    <i class="fa-solid fa-user-tie" style="color: #94a3b8;"></i>
                    <span>{{ $course->user->fullname ?? 'Giảng viên' }}</span>
                </div>
            </div>
        </div>

        {{-- Sticky card --}}
        <div style="width: 340px; background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 20px 60px rgba(0,0,0,0.3); flex-shrink: 0; transform: translateY(40px);">
            <img src="{{ $course->thumbnail_url ?? 'https://picsum.photos/seed/'.$course->course_id.'/340/200' }}"
                 alt="{{ $course->title }}"
                 style="width: 100%; height: 200px; object-fit: cover; display: block;">
            <div style="padding: 24px;">
                <div style="font-size: 32px; font-weight: 900; color: #0f172a; margin-bottom: 6px;">
                    @if($course->price == 0)
                        <span style="color: #10b981;">Miễn phí</span>
                    @else
                        {{ number_format($course->price, 0, '.', '.') }}đ
                    @endif
                </div>

                @if(session('user_id'))
                    @if($course->price == 0)
                        <form action="{{ route('student.enroll', $course->course_id) }}" method="POST">
                            @csrf
                            <button type="submit" style="width: 100%; background: rgb(40,40,254); color: white; border: none; padding: 14px; border-radius: 10px; font-size: 15px; font-weight: 700; cursor: pointer; margin-bottom: 12px;">
                                Đăng ký học ngay (Miễn phí)
                            </button>
                        </form>
                    @else
                        <a href="{{ route('student.checkout', $course->course_id) }}"
                           style="display: block; width: 100%; background: rgb(40,40,254); color: white; border: none; padding: 14px; border-radius: 10px; font-size: 15px; font-weight: 700; cursor: pointer; margin-bottom: 12px; text-align: center; text-decoration: none;">
                            Đăng ký ngay
                        </a>
                    @endif
                @else
                    <a href="{{ route('login') }}"
                       style="display: block; width: 100%; background: rgb(40,40,254); color: white; padding: 14px; border-radius: 10px; font-size: 15px; font-weight: 700; text-align: center; text-decoration: none; margin-bottom: 12px;">
                        Đăng nhập để học
                    </a>
                @endif

                <p style="font-size: 12px; color: #94a3b8; text-align: center; margin-bottom: 20px;">
                    <i class="fa-solid fa-shield-halved"></i> Đảm bảo hoàn tiền 30 ngày
                </p>

                <div style="display: flex; flex-direction: column; gap: 10px; font-size: 13px; color: #475569; border-top: 1px solid #e2e8f0; padding-top: 16px;">
                    <div style="display: flex; justify-content: space-between;">
                        <span>Cấp độ</span>
                        <strong>{{ ucfirst(str_replace('_', ' ', $course->level)) }}</strong>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span>Tổng bài học</span>
                        <strong>{{ $course->sections->flatMap->lessons->count() }} bài</strong>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span>Ngôn ngữ</span>
                        <strong>{{ $course->language->name ?? 'Tiếng Anh' }}</strong>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span>Chứng chỉ</span>
                        <strong style="color: #10b981;">✓ Có</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Main Content --}}
<section style="padding: 80px 80px 60px; max-width: 1200px; margin: 0 auto; display: grid; grid-template-columns: 1fr 340px; gap: 60px;">

    {{-- Left --}}
    <div>

        {{-- What you'll learn --}}
        <div style="background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 12px; padding: 28px; margin-bottom: 36px;">
            <h2 style="font-size: 20px; font-weight: 800; margin-bottom: 16px;">Bạn sẽ học được gì?</h2>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                @foreach(['Kỹ năng nghe hiểu tiếng Anh','Giao tiếp tự nhiên và tự tin','Từ vựng theo chủ đề','Ngữ pháp cơ bản đến nâng cao','Phát âm chuẩn','Viết email và văn bản'] as $skill)
                <div style="display: flex; gap: 10px; font-size: 14px; color: #1e40af;">
                    <i class="fa-solid fa-check" style="color: #10b981; flex-shrink: 0; margin-top: 2px;"></i>
                    <span>{{ $skill }}</span>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Course Content --}}
        <div style="margin-bottom: 36px;">
            <h2 style="font-size: 22px; font-weight: 800; margin-bottom: 8px;">Nội dung khóa học</h2>
            <p style="font-size: 14px; color: #64748b; margin-bottom: 20px;">
                {{ $course->sections->count() }} chương
                · {{ $course->sections->flatMap->lessons->count() }} bài học
            </p>

            <div style="border: 1px solid #e2e8f0; border-radius: 12px; overflow: hidden;">
                @foreach($course->sections as $index => $section)
                <div style="border-bottom: 1px solid #e2e8f0;">
                    <div class="section-toggle" onclick="toggleSection({{ $index }})"
                         style="display: flex; align-items: center; justify-content: space-between; padding: 16px 20px; cursor: pointer; background: {{ $index === 0 ? '#f8fafc' : 'white' }};">
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <i class="fa-solid fa-chevron-{{ $index === 0 ? 'up' : 'down' }} toggle-icon-{{ $index }}" style="color: #64748b; width: 14px;"></i>
                            <div>
                                <strong style="font-size: 14px; color: #0f172a;">{{ $section->title }}</strong>
                            </div>
                        </div>
                        <span style="font-size: 13px; color: #94a3b8;">{{ $section->lessons->count() }} bài</span>
                    </div>

                    <div id="section-{{ $index }}" style="{{ $index === 0 ? '' : 'display:none;' }}">
                        @foreach($section->lessons as $lesson)
                        <div style="display: flex; align-items: center; gap: 12px; padding: 12px 20px 12px 46px; border-top: 1px solid #f1f5f9;">
                            <i class="fa-{{ $lesson->video_url ? 'solid fa-play-circle' : 'regular fa-file-lines' }}"
                               style="color: {{ $lesson->video_url ? 'rgb(40,40,254)' : '#94a3b8' }}; width: 16px;"></i>
                            <span style="flex: 1; font-size: 13px; color: #374151;">{{ $lesson->title }}</span>
                            @if($lesson->duration_minutes)
                            <span style="font-size: 12px; color: #94a3b8;">{{ $lesson->duration_minutes }} phút</span>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Instructor --}}
        @if($course->user)
        <div style="margin-bottom: 36px;">
            <h2 style="font-size: 22px; font-weight: 800; margin-bottom: 20px;">Giảng viên</h2>
            <div style="display: flex; gap: 20px; align-items: flex-start; background: #f8fafc; border-radius: 12px; padding: 24px; border: 1px solid #e2e8f0;">
                @if($course->user->avatar_url)
                    <img src="{{ $course->user->avatar_url }}" alt="{{ $course->user->fullname }}"
                         style="width: 72px; height: 72px; border-radius: 50%; object-fit: cover; flex-shrink: 0;">
                @else
                    <div style="width: 72px; height: 72px; border-radius: 50%; background: rgb(40,40,254); color: white; display: flex; align-items: center; justify-content: center; font-size: 28px; font-weight: 700; flex-shrink: 0;">
                        {{ mb_substr($course->user->fullname, 0, 1) }}
                    </div>
                @endif
                <div>
                    <h3 style="font-size: 18px; font-weight: 800; margin-bottom: 4px;">{{ $course->user->fullname }}</h3>
                    <p style="font-size: 13px; color: rgb(40,40,254); font-weight: 600; margin-bottom: 10px;">Giảng viên</p>
                    <div style="display: flex; gap: 16px; font-size: 13px; color: #64748b;">
                        <span><i class="fa-solid fa-book-open"></i> {{ $course->user->courses->count() }} khóa học</span>
                        <span><i class="fa-solid fa-star" style="color: #f59e0b;"></i> 4.8 đánh giá</span>
                    </div>
                </div>
            </div>
        </div>
        @endif

        {{-- Reviews --}}
        <div>
            <h2 style="font-size: 22px; font-weight: 800; margin-bottom: 20px;">
                Đánh giá ({{ $course->courseReviews->count() }})
            </h2>

            @if($course->courseReviews->isEmpty())
                <p style="color: #94a3b8; font-size: 14px;">Chưa có đánh giá nào. Hãy là người đầu tiên!</p>
            @else
                @foreach($course->courseReviews->take(5) as $review)
                <div style="padding: 20px 0; border-bottom: 1px solid #f1f5f9;">
                    <div style="display: flex; gap: 14px; align-items: flex-start;">
                        <div style="width: 40px; height: 40px; border-radius: 50%; background: hsl({{ $review->user_id * 47 % 360 }}, 60%, 55%); color: white; display: flex; align-items: center; justify-content: center; font-size: 15px; font-weight: 700; flex-shrink: 0;">
                            {{ mb_substr($review->user->fullname ?? 'U', 0, 1) }}
                        </div>
                        <div style="flex: 1;">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                                <strong style="font-size: 14px;">{{ $review->user->fullname ?? 'Ẩn danh' }}</strong>
                                <span style="font-size: 13px; color: #f59e0b;">
                                    @for($i = 1; $i <= 5; $i++)
                                        {{ $i <= $review->rating ? '★' : '☆' }}
                                    @endfor
                                </span>
                            </div>
                            <p style="font-size: 14px; color: #475569; line-height: 1.7;">{{ $review->comment }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            @endif
        </div>

    </div>

    {{-- Right: empty (card is sticky above) --}}
    <div></div>

</section>

<script>
function toggleSection(index) {
    const el = document.getElementById('section-' + index);
    const icon = document.querySelector('.toggle-icon-' + index);
    if (el.style.display === 'none') {
        el.style.display = 'block';
        icon.classList.replace('fa-chevron-down', 'fa-chevron-up');
    } else {
        el.style.display = 'none';
        icon.classList.replace('fa-chevron-up', 'fa-chevron-down');
    }
}
</script>

@endsection