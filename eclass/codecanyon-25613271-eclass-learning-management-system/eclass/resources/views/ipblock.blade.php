@section('title', 'Login')
@include('theme.head')
@include('admin.message')
<body>
<!-- top-nav bar start-->
<section id="nav-bar" class="nav-bar-main-block nav-bar-main-block-one">
    <div class="container-xl">
        <div class="row">
            <div class="col-lg-12">
                <div class="logo text-center btm-10">
                    @php
                        $logo = App\Setting::first();
                    @endphp

                    @if($logo->logo_type == 'L')
                        <a href="{{ url('/') }}" title="{{ $logo->project_title }}"><img src="{{ asset('images/logo/'.$logo->logo) }}" class="img-fluid" alt="{{ $logo->project_title }}"></a>
                    @else()
                        <a href="{{ url('/') }}" title="{{ $logo->project_title }}"><b><div class="logotext">{{ $logo->project_title }}</div></b></a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
<section id="ip-block" class="ip-block-main-block text-center">
	<div class="container-xl">
		<div class="logout-device-block">
			<div class="signup-block">
				<h2>{{__('IP BLOCKED')}}</h2>
				@php
					$ip = $_SERVER['REMOTE_ADDR'];
				@endphp
				{{ $ip }}  
		    </div>
    	</div>
	</div>
</section>
<!-- jquery -->
@include('theme.scripts')
<!-- end jquery -->
</body>
</html> 
