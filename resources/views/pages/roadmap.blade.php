@extends('layouts.app')

@section('title', 'Lộ Trình Học - E-Learn')

@section('content')

{{-- Page Header --}}
<section class="page-header page-header--roadmap">
    <div class="container">
        <span class="section-tag">Định hướng học tập</span>
        <h1>Lộ trình học tiếng Anh</h1>
        <p>Chọn mục tiêu của bạn và chúng tôi sẽ dẫn đường từng bước</p>
    </div>
</section>

{{-- Goal Selector --}}
<section class="roadmap-goals section-pad">
    <div class="container">
        <div class="goals-grid">
            @foreach ([
                ['icon' => '🎓', 'title' => 'IELTS / TOEFL', 'desc' => 'Chinh phục chứng chỉ quốc tế', 'target' => 'ielts', 'color' => 'blue'],
                ['icon' => '💼', 'title' => 'TOEIC Công sở', 'desc' => 'Thăng tiến trong sự nghiệp', 'target' => 'toeic', 'color' => 'green'],
                ['icon' => '✈️', 'title' => 'Giao tiếp du lịch', 'desc' => 'Tự tin khám phá thế giới', 'target' => 'travel', 'color' => 'orange'],
                ['icon' => '👶', 'title' => 'Trẻ em & Thiếu niên', 'desc' => 'Nền tảng vững chắc từ sớm', 'target' => 'kids', 'color' => 'purple'],
                ['icon' => '💻', 'title' => 'Tiếng Anh IT', 'desc' => 'Đọc tài liệu, code, meeting', 'target' => 'tech', 'color' => 'cyan'],
                ['icon' => '🏢', 'title' => 'Business English', 'desc' => 'Đàm phán và thuyết trình', 'target' => 'business', 'color' => 'red'],
            ] as $goal)
            <div class="goal-card goal-card--{{ $goal['color'] }}" data-target="{{ $goal['target'] }}">
                <span class="goal-card__icon">{{ $goal['icon'] }}</span>
                <h3>{{ $goal['title'] }}</h3>
                <p>{{ $goal['desc'] }}</p>
                <span class="goal-card__arrow">→</span>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Roadmap: IELTS (default shown) --}}
<section class="roadmap-detail section-pad section-pad--dark" id="roadmap-ielts">
    <div class="container">
        <div class="roadmap-header">
            <h2>🎓 Lộ trình chinh phục IELTS</h2>
            <p>Từ con số 0 đến Band 7.0+ trong 12 tháng</p>
        </div>

        <div class="roadmap-timeline">

            {{-- Phase 1 --}}
            <div class="roadmap-phase">
                <div class="phase-marker">
                    <div class="phase-dot phase-dot--active">1</div>
                    <div class="phase-line"></div>
                </div>
                <div class="phase-content">
                    <div class="phase-header">
                        <span class="phase-duration">Tháng 1–2</span>
                        <h3>Nền tảng cơ bản</h3>
                        <span class="phase-level">Mục tiêu: Band 4.0</span>
                    </div>
                    <div class="phase-courses">
                        <div class="mini-course-card">
                            <span class="mini-course-icon">📖</span>
                            <div>
                                <strong>English Fundamentals</strong>
                                <span>Ngữ pháp & Từ vựng cơ bản · 24 bài</span>
                            </div>
                        </div>
                        <div class="mini-course-card">
                            <span class="mini-course-icon">🎧</span>
                            <div>
                                <strong>Listening Skills 101</strong>
                                <span>Luyện nghe từ cơ bản · 18 bài</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Phase 2 --}}
            <div class="roadmap-phase">
                <div class="phase-marker">
                    <div class="phase-dot">2</div>
                    <div class="phase-line"></div>
                </div>
                <div class="phase-content">
                    <div class="phase-header">
                        <span class="phase-duration">Tháng 3–5</span>
                        <h3>Phát triển 4 kỹ năng</h3>
                        <span class="phase-level">Mục tiêu: Band 5.0–5.5</span>
                    </div>
                    <div class="phase-courses">
                        <div class="mini-course-card">
                            <span class="mini-course-icon">✍️</span>
                            <div>
                                <strong>IELTS Writing Task 1 & 2</strong>
                                <span>Kỹ năng viết học thuật · 32 bài</span>
                            </div>
                        </div>
                        <div class="mini-course-card">
                            <span class="mini-course-icon">🗣️</span>
                            <div>
                                <strong>IELTS Speaking Intensive</strong>
                                <span>Luyện nói với AI · 28 bài</span>
                            </div>
                        </div>
                        <div class="mini-course-card">
                            <span class="mini-course-icon">📚</span>
                            <div>
                                <strong>Academic Reading Skills</strong>
                                <span>Đọc hiểu học thuật · 20 bài</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Phase 3 --}}
            <div class="roadmap-phase">
                <div class="phase-marker">
                    <div class="phase-dot">3</div>
                    <div class="phase-line"></div>
                </div>
                <div class="phase-content">
                    <div class="phase-header">
                        <span class="phase-duration">Tháng 6–9</span>
                        <h3>Luyện tập chuyên sâu</h3>
                        <span class="phase-level">Mục tiêu: Band 6.0–6.5</span>
                    </div>
                    <div class="phase-courses">
                        <div class="mini-course-card">
                            <span class="mini-course-icon">🎯</span>
                            <div>
                                <strong>IELTS Mock Tests</strong>
                                <span>Thi thử theo chuẩn Cambridge · 12 đề</span>
                            </div>
                        </div>
                        <div class="mini-course-card">
                            <span class="mini-course-icon">💡</span>
                            <div>
                                <strong>Vocabulary for IELTS</strong>
                                <span>4000 từ vựng học thuật · Flashcard</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Phase 4 --}}
            <div class="roadmap-phase roadmap-phase--last">
                <div class="phase-marker">
                    <div class="phase-dot phase-dot--gold">🏆</div>
                </div>
                <div class="phase-content">
                    <div class="phase-header">
                        <span class="phase-duration">Tháng 10–12</span>
                        <h3>Chinh phục mục tiêu</h3>
                        <span class="phase-level">Mục tiêu: Band 7.0+</span>
                    </div>
                    <div class="phase-courses">
                        <div class="mini-course-card mini-course-card--gold">
                            <span class="mini-course-icon">⭐</span>
                            <div>
                                <strong>IELTS Master Class</strong>
                                <span>Tổng ôn toàn diện với cựu giám khảo · 40 bài</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="roadmap-cta">
            <a href="/courses" class="btn btn--secondary">Bắt đầu lộ trình này</a>
            <a href="/instructors" class="btn btn--outline-light">Tư vấn với giảng viên</a>
        </div>
    </div>
</section>

{{-- Level Test CTA --}}
<section class="level-test section-pad">
    <div class="container">
        <div class="level-test__card">
            <div class="level-test__content">
                <h2>Chưa biết trình độ của mình?</h2>
                <p>Làm bài kiểm tra đầu vào miễn phí chỉ 15 phút để nhận lộ trình phù hợp nhất.</p>
                <a href="#" class="btn btn--secondary">Làm bài kiểm tra ngay →</a>
            </div>
            <div class="level-test__decoration">
                <div class="decoration-circle">?</div>
            </div>
        </div>
    </div>
</section>

@endsection