<div class="ai-generate-image scroll-down">
    @if(isset($imageUrl))
    <img src="{{$imageUrl ?? ''}}" class="img-fluid" alt="{{ __('Ai image')}}">
    @endif
    <div class="img-output-icon">
        <ul>
            <li><a href="{{$imageUrl ?? ''}}" title="Download" download><i class="feather icon-download"></i></a></li>
            <li><a href="{{$imageUrl ?? ''}}" data-lightbox="homePortfolio" title="View" target="_blank"><i class="feather icon-eye"></i></a></li>
        </ul>
    </div>
</div>