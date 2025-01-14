<div class="breadcrumbbar">
            <div class="row align-items-center">
                <div class="col-md-8 col-lg-8">
                    <h4 class="page-title">{{ $heading ?? '' }}</h4>
                    <div class="breadcrumb-list">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('Dashboard') }}</a></li>
                            @if(isset($menu1))
                                <li class="breadcrumb-item {{ $secondaryactive ?? ''}}">{{ $menu1 ?? '' }}</li>
                            @endif
                            @if(isset($menu2))
                                <li class="breadcrumb-item {{ $thirdactive ?? ''}}">{{ $menu2 ?? '' }}</li>
                            @endif
                            @if(isset($menu3))
                    <li class="breadcrumb-item {{ $fourthactive ?? ''}}">{{ $menu3 ?? '' }}</li>
                @endif
                        </ol>
                    </div>
                </div>
                {{ $button ?? ''  }}
            </div>          
        </div>

       
       
      
