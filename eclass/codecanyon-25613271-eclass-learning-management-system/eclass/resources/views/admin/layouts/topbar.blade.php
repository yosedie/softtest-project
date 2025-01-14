<!-- Start Topbar Mobile -->
<div class="topbar-mobile">
    <div class="row align-items-center">
        <div class="col-md-12">
            <div class="mobile-logobar">
                <a href="{{ url('/') }}" class="mobile-logo"><img src="{{ url('images/favicon/'.$gsetting->favicon) }}" class="img-fluid" alt="logo"></a>
            </div>
            <div class="mobile-togglebar">
                <ul class="list-inline mb-0">
                    
                    <li class="list-inline-item">
                        <div class="topbar-toggle-icon">
                            <a class="topbar-toggle-hamburger" href="javascript:void();">
                                <img src="{{ url('admin_assets/assets/images/svg-icon/horizontal.svg') }}" class="img-fluid menu-hamburger-horizontal" alt="horizontal">
                                <img src="{{ url('admin_assets/assets/images/svg-icon/verticle.svg') }}" class="img-fluid menu-hamburger-vertical" alt="verticle">
                             </a>
                         </div>
                    </li>
                    <li class="list-inline-item">
                        <div class="menubar">
                            <a class="menu-hamburger" href="javascript:void();">
                                <img src="{{ url('admin_assets/assets/images/svg-icon/menu.svg') }}" class="img-fluid menu-hamburger-collapse" alt="collapse">
                                <img src="{{ url('admin_assets/assets/images/svg-icon/close.svg') }}" class="img-fluid menu-hamburger-close" alt="close">
                             </a>
                         </div>
                    </li>                                
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- Start Topbar -->
<div class="topbar">
    <!-- Start row -->
    <div class="row align-items-center">
        <!-- Start col -->
        <div class="col-md-12 align-self-center">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="togglebar">
                        <div class="breadcrumbbar">
                            <h4 class="page-title">{{ $heading ??'' }}</h4>
                            <div class="breadcrumb-list">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('Dashboard') }}</a></li>
                                    @if(isset($title))
                                    <li class="breadcrumb-item ">{{ $title ?? '' }}</li>
                                    @endif
                                    @if(isset($title1))
                                    <li class="breadcrumb-item ">{{ $title1 ?? '' }}</li>
                                    @endif
                                    @if(isset($title2))
                                    <li class="breadcrumb-item active">{{ $title2 ?? '' }}</li>
                                    @endif
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="infobar">
                        @include('sweetalert::alert')
                        <ul class="list-inline mb-0">
                            <!-- - site visit start -->
                            <li class="list-inline-item">
                                <div class="languagebar">
                                <a href="{{ url('/') }}" target="_blank"><span class="live-icon">{{ __('Visit Site') }}</span>&nbsp;<i class="feather icon-external-link" aria-hidden="true"></i></a>   
                                </div>
                            </li>
                            <li class="list-inline-item dark-light-mode">
                                <div class="toggle-container">
                                    <a href="" id="modeSwitch1" onclick="toggleMode1()">
                                        <i class="fa fa-sun-o modeIcon" id="modeIcon1" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </li>
                            @if($gsetting->api_enable == '1')
                            <li class="list-inline-item">   
                                <div class="ai-tool-block">
                                    <a href="#" class="menu-tigger infobar-icon"><img src="{{ url('admin_assets/assets/images/svg-icon/ai.svg') }}" class="img-fluid" alt="{{ __('Ai Tool') }}"><span>{{ __('Ai Tool') }}</span></a>
                                </div>
                            </li>
                            @endif
                            <!-- = site visit end -->
                            <!-- notification start -->
                            @if(Auth()->user()->role == "admin")
                            <li class="list-inline-item">
                                <div class="notifybar">
                                    <div class="dropdown">
                                        <a class="dropdown-toggle infobar-icon" href="#" role="button" id="notoficationlink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="{{ url('admin_assets/assets/images/svg-icon/notifications.svg') }}" class="img-fluid" alt="notifications">
                                        <span class="live-icon">{{ Auth()->user()->unreadNotifications->where('type', 'App\Notifications\AdminOrder')->count() }}</span></a>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="notoficationlink">
                                            <div class="notification-dropdown-title">
                                                <h6>{{ __('You have') }} {{ Auth()->user()->unreadNotifications->where('type', 'App\Notifications\AdminOrder')->count() }} {{ __('notifications') }}</h6>                            
                                            </div>
                                            <ul class="list-unstyled">  
                                            <?php $i=0;?>
                                            @foreach(Auth()->user()->unreadNotifications->where('type', 'App\Notifications\AdminOrder') as $notification)
                                            <?php $i++;?>
                                                                                            
                                                <li class="media dropdown-item">
                                                    
                                                    <span class="mr-3 action-icon badge badge-warning-inverse"><?php echo $i; ?></span>
                                                    <div class="media-body">
                                                        <a href="#"><p><span class="timing">{{ $notification->data['data'] }}</span></p></a>
                                                    </div>
                                                </li>
                                                @endforeach
                                                                                                
                                            </ul>
                                            <div class="notification-dropdown-title">
                                            <a href="{{route('deleteNotification')}}"><p>{{ __('Clear all') }}</p></a>                            
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            @endif
                            <!-- notification end -->
                            <!-- language start -->
                            @php
                            $languages = App\Language::all(); 
                            @endphp
                            <li class="list-inline-item">
                                <div class="languagebar">
                                    <div class="dropdown">
                                        <a class="dropdown-toggle" href="#" role="button" id="languagelink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="live-icon">{{Session::has('changed_language') ? Session::get('changed_language') : ''}}</span><span class="feather icon-chevron-down live-icon"></span></a>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="languagelink">
                                            @if (isset($languages) && count($languages) > 0)
                                            @foreach ($languages as $language)
                                            <a class="dropdown-item" href="{{ route('languageSwitch', $language->local) }}">
                                                <i class="feather icon-globe"></i>
                                                {{$language->name}} ({{$language->local}})</a>
                                            @endforeach
                                            @endif
                                            
                                        </div>
                                    </div>
                                </div>                                   
                            </li>
                                <!-- language end -->
                            <li class="list-inline-item">
                                <div class="profilebar">
                                    <div class="dropdown">
                                        <a class="dropdown-toggle" href="#" role="button" id="profilelink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                        @if(Auth()->User()['user_img'] != null && Auth()->User()['user_img'] !='' && @file_get_contents('images/user_img/'.Auth::user()['user_img']))
                                            <img src="{{ url('images/user_img/'.Auth()->User()['user_img'])}}" alt="profilephoto" class="rounded img-fluid">
                                        @else
                                            <img @error('photo') is-invalid @enderror src="{{ Avatar::create(Auth::user()->fname)->toBase64() }}" alt="profilephoto" class="rounded img-fluid">
                                        @endif

                                        <span class="live-icon">{{ __('Hi') }} {{ Auth::user()->fname }}</span><span class="feather icon-chevron-down live-icon"></span></a>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="profilelink">
                                            <div class="dropdown-item">
                                                <div class="profilename">
                                                    <h5>{{ Auth::user()->fname }}</h5>
                                                </div>
                                            </div>
                                            <div class="userbox">
                                                <ul class="list-unstyled mb-0">
                                                    <li class="media dropdown-item">
                                                        <a href="{{ url('user/edit/'.Auth()->User()->id)}}" class="profile-icon"><img src="{{ url('admin_assets/assets/images/svg-icon/crm.svg') }}" class="img-fluid" alt="user">{{ __('My Profile') }}</a>
                                                    </li>
                                                                                                    
                                                    <li class="media dropdown-item">
                                                        <a href="{{ route('logout') }}" class="profile-icon"  onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();"><img src="{{ url('admin_assets/assets/images/svg-icon/logout.svg') }}" class="img-fluid" alt="logout">{{ __('Logout') }}</a>

                                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                            @csrf
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>                                   
                            </li>
                        </ul>
                    </div>
                    @include('admin.openai.topbar')
                </div>
            </div>
        </div>
        <!-- End col -->
    </div> 
    <!-- End row -->
</div>
<!-- End Topbar -->
<!-- Start Breadcrumbbar -->                    
@yield('breadcum')
<!-- End Breadcrumbbar -->