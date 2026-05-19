@props(['icon', 'title', 'desc'])

<div class="feature-item">
    <div class="feature-icon">
        @if(str_starts_with($icon, 'fa-') || str_starts_with($icon, 'fas '))
            <i class="{{ $icon }}"></i>
        @else
            {!! $icon !!}
        @endif
    </div>
    <h4 class="feature-title">{{ $title }}</h4>
    <p class="feature-desc">{{ $desc }}</p>
</div>