<div class="course-card">
    <div class="course-card__thumb">
        <img src="{{ $course['thumbnail'] ?? 'https://picsum.photos/seed/'.($course['id'] ?? 1).'/400/225' }}"
             alt="{{ $course['title'] ?? 'Course' }}">
        <span class="course-card__level">{{ $course['level'] ?? 'Beginner' }}</span>
    </div>
    <div class="course-card__body">
        <div class="course-card__meta">
            <span class="course-card__lang">{{ $course['language'] ?? 'English' }}</span>
            <span class="course-card__rating">
                ★ {{ number_format($course['rating'] ?? 4.5, 1) }}
                <small>({{ $course['reviews'] ?? 120 }})</small>
            </span>
        </div>
        <h3 class="course-card__title">{{ $course['title'] ?? 'Course Title' }}</h3>
        <p class="course-card__instructor">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
            {{ $course['instructor'] ?? 'Instructor Name' }}
        </p>
        <div class="course-card__footer">
            <span class="course-card__price">
                {{ number_format($course['price'] ?? 299000, 0, '.', '.') }}đ
            </span>
            <a href="/courses/{{ $course['id'] ?? 1 }}" class="btn btn--secondary btn--sm">
                Xem khóa học
            </a>
        </div>
    </div>
</div>