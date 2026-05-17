@props(['icon', 'title', 'desc'])

<div class="feature-item">
    <div class="feature-icon">{{ $icon }}</div>
    <h4 class="feature-title">{{ $title }}</h4>
    <p class="feature-desc">{{ $desc }}</p>
</div>