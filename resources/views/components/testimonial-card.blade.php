@props(['text', 'initials', 'name', 'location'])

<div class="testimonial-card">
    <div class="testimonial-text">
        "{{ $text }}"
    </div>
    <div class="testimonial-author">
        <div class="author-avatar">{{ $initials }}</div>
        <div class="author-info">
            <h5>{{ $name }}</h5>
            <p>{{ $location }}</p>
        </div>
    </div>
</div>