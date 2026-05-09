@props([
    'id'         => 1,
    'thumbnail'  => null,
    'level'      => 'Beginner',
    'language'   => 'English',
    'rating'     => 4.5,
    'reviews'    => 0,
    'title'      => 'Course Title',
    'instructor' => 'Instructor',
    'price'      => 0,
])

<div class="course-card">
    <div class="course-card__thumb">
        <img src="{{ $thumbnail ?? 'https://picsum.photos/seed/' . $id . '/400/225' }}"
             alt="{{ $title }}">
        <span class="course-card__level">{{ $level }}</span>
    </div>
    <div class="course-card__body">
        <div class="course-card__meta">
            <span class="course-card__lang">{{ $language }}</span>
            <span class="course-card__rating">
                ★ {{ number_format((float)$rating, 1) }}
                @if($reviews > 0)
                    <small>({{ $reviews }})</small>
                @endif
            </span>
        </div>
        <h3 class="course-card__title">{{ $title }}</h3>
        @if($instructor)
        <p class="course-card__instructor">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="8" r="4"/>
                <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
            </svg>
            {{ $instructor }}
        </p>
        @endif
        <div class="course-card__footer">
            <span class="course-card__price">
                {{ number_format((float)$price, 0, '.', '.') }}đ
            </span>
            <a href="/courses/{{ $id }}" class="btn btn--secondary btn--sm">
                Xem khóa học
            </a>
        </div>
    </div>
</div>