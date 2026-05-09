<div class="review-card">
    <div class="review-card__stars">
        @for ($i = 0; $i < 5; $i++)
            <i class="fa-solid fa-star"></i>
        @endfor
    </div>

    <p class="review-card__text">
        "{{ $text }}"
    </p>

    <div class="review-card__author">
        <img src="{{ asset($avatar) }}" alt="{{ $name }}">
        <div>
            <span class="review-card__name">{{ $name }}</span>
            <span class="review-card__role">{{ $role }}</span>
        </div>
    </div>

</div>