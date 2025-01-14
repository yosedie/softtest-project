@if($cats->courses_count >= 4)

    <a href="{{ route('category.page',['slug' => $cats->slug]) }}" class="btn btn-secondary" title="{{ __('View More') }}">{{ __('View More') }}<i data-feather="chevrons-right"></i>
    </a>

@endif