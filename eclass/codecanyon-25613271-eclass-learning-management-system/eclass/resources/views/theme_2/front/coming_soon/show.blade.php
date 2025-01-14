@section('title', 'Coming Soon')
@include('theme2.head')

<!-- end head -->
<!-- body start-->
<body>

<section id="nav-bar" class="nav-bar-main-block nav-bar-main-block-one">
    <div class="container-xl">
        <div class="row">
            <div class="col-lg-4">
               
            </div>
            <div class="col-lg-4">
                <div class="logo text-center btm-10">
                    @php
                        $logo = App\Setting::first();
                    @endphp

                    @if($logo->logo_type == 'L')
                        <a href="{{ url('/') }}" title="logo"><img src="{{ asset('images/logo/'.$logo->logo) }}" class="img-fluid" alt="logo"></a>
                    @else()
                        <a href="{{ url('/') }}"><b><div class="logotext">{{ $logo->project_title }}</div></b></a>
                    @endif
                </div>
            </div>
            @guest
            <div class="col-lg-4">
                <div class="Login-btn txt-rgt">
                    <a href="{{ route('login') }}" class="btn btn-secondary" title="{{ __('login')}}">
                        {{ __('Login') }}
                    </a>
                </div> 
            </div>
            @endguest
            
            @auth
            <div class="col-lg-4">
                <div class="Login-btn txt-rgt">
                    <a href="{{ route('logout') }}" class="btn btn-secondary" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    
                        {{ __('Logout') }}
                        
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="display-none">
                            @csrf
                        </form>
                    
                    </a>
                </div> 
            </div>  
            @endauth
        </div>
    </div>
</section>

@if(isset($data))
<!-- top-nav bar start-->
<section id="comimg-soon" class="coming-soon-main-block" style="background-image: url('{{ asset('images/comingsoon/'.$data->bg_image) }}')">
    <div class="overlay-bg"></div>
    <div class="container-xl">
      
        <div class="coming-soon-block">
            <h1 class="comming-soon-heading text-white text-center btm-40"> {{ $data->heading }} </h1>
            <div class="facts-dtl-block btm-40">
                <div class="row">
                    <div class="offset-lg-2 col-lg-2 col-md-3 col-sm-6 col-6">
                        <div class="facts-block text-center btm-20">
                            <h1 class="facts-heading counter text-white">{{ $data->count_one }}</h1>
                            <div class="facts-dtl text-white">{{ $data->text_one }}</div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-3 col-sm-6 col-6">
                        <div class="facts-block text-center btm-20">
                            <h1 class="facts-heading counter text-white">{{ $data->count_two }}</h1>
                            <div class="facts-dtl text-white">{{ $data->text_two }}</div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-3 col-sm-6 col-6">
                        <div class="facts-block text-center btm-20">
                            <h1 class="facts-heading counter text-white">{{ $data->count_three }}</h1>
                            <div class="facts-dtl text-white">{{ $data->text_three }}</div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-3 col-sm-6 col-6">
                        <div class="facts-block text-center btm-20">
                            <h1 class="facts-heading counter text-white">{{ $data->count_four }}</h1>
                            <div class="facts-dtl text-white">{{ $data->text_four }}</div>
                        </div>
                    </div>
                </div>
            </div>
            @if(isset($data->btn_text))
            <div class="nav-bar-btn btm-20 text-center">
                <a href="{{ url('/') }}" class="btn btn-primary" title="{{ __('instructor')}}">{{ $data->btn_text }}</a>
            </div>
            @endif
        </div>
    </div>
</section>
<!-- top-nav bar end-->
@endif

@include('theme2.scripts')
<!-- end jquery -->
</body>
<!-- body end -->
</html> 