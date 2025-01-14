@if($gsetting->promo_enable == 1)
<div id="promo-outer">
    <div id="promo-inner">
        <a href="{{ $gsetting['promo_link'] }}">{{ $gsetting['promo_text'] }}</a>
        <span id="close">x</span>
    </div>
</div>
<div id="promo-tab" class="display-none">{{__('SHOW')}}</div>
@endif

<!-- header -->
<header class="header-area header-three">  
    <div class="header-top second-header d-none d-md-block">
        <div class="container">
            <div class="row align-items-center">      
                @php
                $user = \Auth::user(); 
                $gsetting = App\Setting::first();
                @endphp
                
                <div class="col-lg-4 col-md-4 d-none d-lg-block ">
                    <div class="header-social">
                        <span>
                            {{__('Follow us:-')}}
                            @if($gsetting->facebook_url)
                                <a href="{{$gsetting->facebook_url}}" target="_blank" title="Facebook">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                            @endif

                            @if($gsetting->instagram_url)
                                <a href="{{$gsetting->instagram_url}}" target="_blank" title="Instagram">
                                    <i class="fab fa-instagram"></i>
                                </a>
                            @endif

                            @if($gsetting->twitter_url)
                                <a href="{{$gsetting->twitter_url}}" target="_blank" title="Twitter">
                                    <i class="fab fa-twitter"></i>
                                </a>
                            @endif

                            @if($gsetting->youtube_url)
                                <a href="{{$gsetting->youtube_url}}" target="_blank" title="YouTube">
                                    <i class="fab fa-youtube"></i>
                                </a>
                            @endif
                        </span>                    
                            <!--  /social media icon redux -->                               
                    </div>
                </div>
                <div class="col-lg-8 col-md-8 d-none d-lg-block text-right">
                    <div class="header-cta">
                        <ul>
                            <li>
                                <div class="call-box">
                                    <div class="icon">
                                        <img src="{{url('frontcss/img/icon/phone-call.png')}}">
                                    </div>
                                    <div class="text">
                                        <span>{{__('Call Now !')}}</span>
                                        <strong><a href="tel:+917052101786">{{ $gsetting->default_phone }}</a></strong>                                              
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="call-box">
                                    <div class="icon">
                                        <img src="{{url('frontcss/img/icon/mailing.png')}}">
                                    </div>
                                    <div class="text">
                                        <span>{{__('Email Now')}}</span>
                                        <strong><a href="mailto:info@example.com">{{ $gsetting->wel_email }} </a></strong>                                               
                                    </div>
                                </div>
                            </li>                                 
                        </ul>
                    </div>                        
                </div>
                 
            </div>
        </div>
    </div>		
    <div id="header-sticky" class="menu-area">
        <div class="container">
            <div class="second-menu fullscreen">
                <div class="row">
                    <div class="col-xl-2 col-lg-3">
                        <div class="logo">
                            @if($gsetting->logo_type == 'L')
                            <a href="{{ url('/') }}" ><img src="{{ asset('images/logo/'.$gsetting->logo) }}" class="img-fluid" alt="logo"></a>
                            @else()
                            <a href="{{ url('/') }}"><b><div class="logotext">{{ $gsetting->project_title }}</div></b></a>
                            @endif
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6">
                        <div class="main-menu text-center text-xl-right">
                            <nav id="mobile-menu">
                                <ul>
                                    <li class="has-sub">
                                        <a href="{{route('home')}}">{{__('Home')}}</a>
                                    </li>
                                    <li id="cssmenu" class="has-sub navigation">
                                        <a href="#" title="Categories">{{ __('Categories') }}</a>
                                        @php
                                        $categories = App\Categories::orderBy('position','ASC')->with(['subcategory','subcategory.childcategory'])->get();
                                        @endphp
                                        <ul class="">
                                            @foreach($categories as $cate)
                                                @if($cate->status == 1 )
                                                    <li><a href="{{ route('category.page',['slug' => $cate->slug]) }}" title="{{ $cate->title }}">{{ str_limit($cate->title, $limit = 25, $end = '..') }} <i data-feather="chevron-right" class="float-right"></i></a>
                                                        <ul>   
                                                            @foreach($cate->subcategory as $sub)
                                                            @if($sub->status ==1)
                                                            <li><a href="{{ route('subcategory.page', ['categorySlug' => $sub->categories->slug, 'slug' => $sub->slug]) }}" title="{{ $sub->title }}">{{ str_limit($sub->title, $limit = 25, $end = '..') }}
                                                                <i data-feather="chevron-right" class="float-right"></i></a>
                                                                <ul>
                                                                    @foreach($sub->childcategory as $child)
                                                                    @if($child->status ==1)
                                                                    <li>
                                                                        <a href="{{ route('childcategory.page',['categorySlug' => $child->categories->slug, 'subCategorySlug' => $child->subcategory->slug ,'slug' =>  $child->slug ]) }}" title="{{ $child->title }}">{{ str_limit($child->title, $limit = 25, $end = '..') }}</a>
                                                                    </li>
                                                                    @endif
                                                                    @endforeach
                                                                </ul>
                                                            </li>
                                                            @endif
                                                            @endforeach
                                                        </ul>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </li>
                                     
                                    <li class="has-sub"> 
                                        <a href="{{route('blog.all')}}">{{__('Blog')}}</a>
                                    </li>
                                    <li><a href="{{route('contact.us')}}">{{__('Contact')}}</a></li>                                               
                                </ul>
                            </nav>
                        </div>
                    </div>
                    
                    <div class="col-xl-4 col-lg-3">
                        @guest
                        
                            <div class="Login-btn second-header-btn">   
                                <a href="{{ url('registers') }}" class="btn" title="register">{{ __('Register') }}</a>
                            </div> 
                            <div class="Login-btn second-header-btn">
                                <a href="{{ route('login') }}" class="btn" title="login">{{ __('Login') }}</a>
                            </div> 
                        
                        @endguest
                        @auth
                        <div class="nav-admin-icon">
                            <div class="row">
                                <div class="col-lg-2 col-md-1 col-sm-2 col-2">
                                    <div class="nav-wishlist">
                                        <ul id="nav">
                                            <li id="notification_li">
                                                <a href="{{ url('send') }}" id="notificationLink" title="Notification"><i data-feather="bell"></i></a>
                                                <span class="red-menu-badge red-bg-success">
                                                    {{ Auth()->user()->unreadNotifications->where('type', 'App\Notifications\UserEnroll')->count() }}
                                                </span>
                                                <div id="notificationContainer">
                                                    <div id="notificationTitle">{{ __('Notifications') }}</div>
                                                    <div id="notificationsBody" class="notifications">
                                                        <ul>
                                                            @foreach(Auth()->user()->unreadNotifications->where('type', 'App\Notifications\UserEnroll') as $notification)
                                                                <li class="unread-notification">
                                                                    <a href="{{url('notifications/'.$notification->id)}}">          
                                                                    <div class="notification-image">
                                                                        @if($notification->data['image'] !== NULL )
                                                                            <img src="{{ asset('images/course/'.$notification->data['image']) }}" alt="course" class="img-fluid" >
                                                                        @else
                                                                            <img src="{{ Avatar::create($notification->data['id'])->toBase64() }}" alt="course" class="img-fluid">
                                                                        @endif
                                                                    </div>
                                                                    <div class="notification-data">
                                                                        In {{ str_limit($notification->data['id'], $limit = 20, $end = '...') }}
                                                                        <br>
                                                                        {{ str_limit($notification->data['data'], $limit = 20, $end = '...') }}
                                                                    </div>
                                                                    </a>
                                                                </li>
                                                            @endforeach
                
                                                            @foreach(Auth()->user()->readNotifications->where('type', 'App\Notifications\UserEnroll') as $notification)
                                                                <li>
                                                                    <a href="{{ route('mycourse.show') }}">
                                                                    <div class="notification-image">
                                                                        @if($notification->data['image'] !== NULL )
                                                                            <img src="{{ asset('images/course/'.$notification->data['image']) }}" alt="course" class="img-fluid" >
                                                                        @else
                                                                        <img src="{{ Avatar::create($notification->data['id'])->toBase64() }}" alt="course" class="img-fluid">
                                                                        @endif
                                                                    </div>
                                                                    <div class="notification-data">
                                                                        In {{  str_limit($notification->data['id'], $limit = 20, $end = '...') }}
                                                                        <br>
                                                                        {{ str_limit($notification->data['data'], $limit = 20, $end = '...') }}
                                                                    </div>
                                                                    </a>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                    <div id="notificationFooter"><a href="{{route('deleteNotification')}}">{{ __('ClearAll') }}</a></div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-1 col-sm-2 col-2">
                                    <div class="nav-wishlist">
                                        <ul>
                                            <li id="wishlist_li">
                                                <a href="{{ route('wishlist.show') }}" title="Go to Wishlist"><i data-feather="heart"></i></a>
                                                <span class="red-menu-badge red-bg-success">
                                                    @php
                                                        $wishlist = App\Wishlist::where('user_id', Auth::User()->id)->get();
                                                        
                                                    @endphp
                    
                                                    
                    
                                                    @php
                                                        $counter = 0;
                                                        foreach ($wishlist as $item) {
                                                            if($item->courses->status == '1'){
                    
                                                                
                                                            $counter++;
                        
                                                            }
                                                        }
                    
                                                        echo  $counter; 
                                                    @endphp
                                                </span>
                                            </li>
                                        </ul>
                                    </div>  
                                </div>
                                <div class="col-lg-2">
                                    <div class="shopping-cart">
                                        <ul>
                                            <li id="shopping_li">
                                                <a href="{{ route('cart.show') }}" title="Cart"><i data-feather="shopping-cart"></i></a>
                                                <span class="red-menu-badge red-bg-success">
                                                    @php
                                                        $item = App\Cart::where('user_id', Auth::User()->id)->count();
                                                        if($item>0){
                                
                                                            echo $item;
                                                        }
                                                        else{
                                
                                                            echo "0";
                                                        }
                                                    @endphp
                                                </span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-lg-1">
                                    <div class="search search-one" id="search">
                                        <form method="GET" id="searchform" action="{{ route('search') }}">
                                        <div class="search-input-wrap">
                                            <input class="search-input" name="searchTerm" placeholder="Search in Site" type="text" id="course_name" autocomplete="off" />
                                        </div>
                                        <input class="search-submit" type="submit" id="go" value="">
                                        <div class="icon"><i data-feather="search"></i></div>
                                        <div id="course_data"></div>
                                        </form>
                                    </div>
                                </div>
                                @php
                                $user = \Auth::user(); 
                                $roles = $user->getRoleNames();
                                $test_id = Spatie\Permission\Models\Role::select('id')->where('name',$roles[0])->get();
                                $dropdown = App\Dropdown::where('role_id', $test_id[0]['id'])->get();
                                @endphp
                                @if($roles[0] != "admin" &&  $roles[0] != "instructor" && $roles[0] != "user")
                                @foreach($dropdown as $drop)
                                <div class="col-lg-5 col-md-3 col-sm-6 col-6">
                                    <div class="my-container second-header-btn">
                                        <div class="dropdown">
                                            <button class="btn btn-default dropdown-toggle  my-dropdown" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                               @if(Auth::User()['user_img'] != null && Auth::User()['user_img'] !='' && @file_get_contents('images/user_img/'.Auth::user()['user_img']))
                                                <img src="{{ url('/images/user_img/'.Auth::User()->user_img) }}" class="circle" alt="{{ Auth::User()->fname }}">
                                              @else
                                                  <img src="{{ asset('images/default/user.jpg')}}"  class="circle" alt="{{ Auth::User()->fname }}">
                                              @endif
                                              <span class="dropdown__item name" id="name">{{ str_limit(Auth::User()->fname, $limit = 10, $end = '..') }}</span>
                                              <span class="dropdown__item caret"></span>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-right User-Dropdown U-open" aria-labelledby="dropdownMenu1">
                                                <div id="notificationTitle">
                                                    @if(Auth::User()['user_img'] != null && Auth::User()['user_img'] !='' && @file_get_contents('images/user_img/'.Auth::user()['user_img']))
                                                        <img src="{{ url('/images/user_img/'.Auth::User()->user_img) }}" class="dropdown-user-circle" alt="{{ Auth::User()->fname }}">
                                                    @else
                                                      <img src="{{ asset('images/default/user.jpg')}}" class="dropdown-user-circle" alt="{{ Auth::User()->fname }}">
                                                    @endif
                                                    <div class="user-detailss">
                                                      {{ Auth::User()->fname }}
                                                      <br>
                                                      {{ Auth::User()->email }}
                                                    </div>                                    
                                                </div>
                                                <div class="scroll-down">
                                                    @if(Auth::User()->role == "admin" )                               
                                                        <a target="_blank" href="{{ url('/admins') }}" title="{{ __('Admin Dashboard') }}"><li><i data-feather="pie-chart"></i>{{ __('Admin Dashboard') }}</li></a>
                                             
                                                    @endif
                                                    @if(Auth::User()->role == "instructor")
                    
                                                    <a target="_blank" href="{{ url('/instructor') }}" title="{{ __('Instructor Dashboard') }}"><li><i data-feather="pie-chart"></i>{{ __('Instructor Dashboard') }}</li></a>
                                                    @endif
              
                                            
                                                    @if($drop->my_courses == '1')
                                                    <a href="{{ route('mycourse.show') }}" title="{{ __('My Courses') }}"><li><i data-feather="book-open"></i>{{ __('My Courses') }}</li></a>
                                                    @endif
                                                    @if($drop->my_wishlist == '1')
                                                    <a href="{{ route('wishlist.show') }}" title="{{ __('Wishlist')}}"><li><i data-feather="heart"></i>{{ __('Wishlist') }}</li></a>
                                                    @endif
                                                    @if($drop->purchased_history == '1')
                                                    <a href="{{ route('purchase.show') }}" title="{{ __('Purchased History')}}"><li><i data-feather="shopping-cart"></i>{{ __('Purchased History') }}</li></a>
                                                    @endif
                                                    @if($drop->my_profile == '1')
                                                    <a href="{{route('profile.show',Auth::User()->id)}}" title="{{ __('Profile')}}"><li><i data-feather="user"></i>{{ __('Profile') }}</li></a>
                                                    @endif
                                                    @if(Auth::User()->role == "user")
                                                    @if($gsetting->instructor_enable == 1)
                                                    <a href="#" data-toggle="modal" data-target="#myModalinstructor"  title="{{ __('Become An Instructor')}}"><li><i data-feather="shield"></i>{{ __('Become An Instructor') }}</li></a>
                                                    @endif
                                      
                                                    @endif
                                                    @if($drop->flash_deal == '1')
                                                    <a href="{{ route('flash.deals') }}" title="{{ __('Flash Deal')}}"><li><i data-feather="battery-charging"></i>{{ __('Flash Deals') }}</li></a>
                                                    @endif
                                                    @if(env('ENABLE_INSTRUCTOR_SUBS_SYSTEM') == 1)
                                                    @if(Auth::User()->role == "instructor")
                                                    <a href="{{ route('plan.page') }}" title="{{ __('Instructor Plan')}}"><li><i data-feather="tag"></i>{{ __('Instructor Plan') }}</li></a>
                                                    @endif
                                                    @endif
                                                    @if(Auth::User()->role == "user" || Auth::User()->role == "instructor")
                                                    @if($gsetting->device_control == 1)
                                                    <a href="{{ route('active.courses') }}" title="{{ __('Watchlist')}}"><li><i data-feather="framer"></i>{{ __('Watchlist') }}</li></a>
                                                    @endif
                                                    @endif                                
                                                    @if($gsetting->donation_enable == 1 && $drop->donation == '1')
                                                    <a target="__blank" href="{{ $gsetting->donation_link }}" title="{{ __('Donation')}}"><li><i data-feather="framer"></i>{{ __('Donation') }}</li></a>
                                                    @endif
                                                    @if($gsetting->affilate == 1 && $drop->my_wallet == '1')
                                                    @if(Schema::hasTable('affiliate') && Schema::hasTable('wallet_settings'))
                                                    @endif
                                                    @if(isset($wallet_settings) && $wallet_settings->status == 1)
                                                    <a href="{{ url('/wallet') }}" title="{{ __('Wallet')}}"><li><i class="icon-wallet icons"></i>{{ __('Wallet') }}</li></a>
                                                    @endif
                                                    @if(isset($affiliate) && $affiliate->status == 1)
                                                    <a href="{{ route('get.affiliate') }}" title="{{ __('Affiliate')}}"><li><i data-feather="users"></i>{{ __('Affiliate') }}</li></a>
                                                    @endif
                                                    @endif
                                                    @if($drop->compare == '1')
                                                    <a href="{{ route('compare.index') }}" title="{{ __('Compare')}}"><li><i data-feather="bar-chart"></i>{{ __("Compare") }}</li></a>
                                                    @endif
                                                    @if($drop->search_job == '1')
                                                    @if(Module::has('Resume') && Module::find('Resume')->isEnabled())
                                                        @include('resume::front.searchresume')
                                                    @endif
                                                    @endif
                                                    @if($drop->job_portal == '1')
                                                    @if(Module::has('Resume') && Module::find('Resume')->isEnabled())
                                                        @include('resume::front.job.icon')
                                                    @endif
                                                    @endif
                                                    @if($drop->form_enable == '1')
                                                    @if(Module::find('Forum') && Module::find('Forum')->isEnabled())
                                                        @if($gsetting->forum_enable == 1)
                                                            @include('forum::layouts.sidebar_menu')
                                                        @endif
                                                    @endif
                                                    @endif
                                                    @if($drop->my_leadership == '1')
                                                    <a href="{{ route('my.leaderboard') }}" title="{{ __('leader Board')}}"><li><i class="icon-chart icons"></i>{{ __('Leader Board') }}</li></a>
                                                    @endif
                                                    @if(Auth::User()->role == "user")
                                                    <a href="{{ route('studentprofile') }}" title="{{ __('Share Profile')}}"><li><i data-feather="share"></i>{{ __('Share Profile') }}</li></a>
                                                    <a href="{{ route('supportuser') }}" title="{{ __('Support')}}"><li><i data-feather="book-open"></i>{{ __('Support') }}</li></a>
                                                    @endif
                                                    @if($drop->affilate_dashboard == '1')
                                                    <a href="{{ route('affilate.report') }}"><li><i data-feather="users"></i>{{__('Affiliate Dashboard')}}</li></a>
                                                    @endif
                                                    <a href="{{ route('batch.front') }}" title="{{ __('Batch')}}"><li><i data-feather="book-open"></i>{{__('Batch')}}</li></a>
                                                    </div>
                                                    @if(Module::has('Ebook') && Module::find('Ebook')->isEnabled())
                                                    <a href="{{ route('web.ebook.confirm-order') }}" title="{{ __('My eBook')}}"><li><i data-feather="book-open"></i>{{ __('My eBook') }}</li></a>
                                                    @endif 
                                                    <a href="{{ route('logout') }}" title="{{ __('Logout')}}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                        <div id="notificationFooter">
                                                            {{ __('Logout') }}                                        
                                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="display-none">
                                                                @csrf
                                                            </form>
                                                        </div>
                                                    </a>
                                                
                                                </div>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @else
                                <div class="col-lg-5 col-md-3 col-sm-6 col-6">
                                    <div class="my-container second-header-btn">
                                        <div class="dropdown">
                                            <button class="btn btn-default dropdown-toggle  my-dropdown" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                @if(Auth::User()['user_img'] != null && Auth::User()['user_img'] !='' && @file_get_contents('images/user_img/'.Auth::user()['user_img']))
                                                <img src="{{ url('/images/user_img/'.Auth::User()->user_img) }}" class="circle" alt="{{Auth::User()->fname}}">
                                                @else
                                                    <img src="{{ asset('images/default/user.jpg')}}"  class="circle" alt="{{Auth::User()->fname}}">
                                                @endif
                                                <span class="dropdown__item name" id="name">{{ str_limit(Auth::User()->fname, $limit = 10, $end = '..') }}</span>
                                                <span class="dropdown__item caret"></span>
                                            </button>
                
                                            <ul class="dropdown-menu dropdown-menu-right User-Dropdown U-open" aria-labelledby="dropdownMenu1">
                                                <div id="notificationTitle">
                                                    @if(Auth::User()['user_img'] != null && Auth::User()['user_img'] !='' && @file_get_contents('images/user_img/'.Auth::user()['user_img']))
                                                    <img src="{{ url('/images/user_img/'.Auth::User()->user_img) }}" class="dropdown-user-circle" alt="{{Auth::User()->fname}}">
                                                    @else
                                                        <img src="{{ asset('images/default/user.jpg')}}" class="dropdown-user-circle" alt="{{Auth::User()->fname}}">
                                                    @endif
                                                    <div class="user-detailss">
                                                        {{ Auth::User()->fname }}
                                                        <br>
                                                        {{ Auth::User()->email }}
                                                    </div>
                                                    
                                                </div>
                
                                                <div class="scroll-down">
                                                    @if(Auth::User()->role == "admin" )                               
                                                    <a target="_blank" href="{{ url('/admins') }}" title="{{ __('Admin Dashboard')}}"><li><i data-feather="pie-chart"></i>{{ __('Admin Dashboard') }}</li></a>
                                                    @endif
                                                    @if(Auth::User()->role == "instructor")
                                                    <a target="_blank" href="{{ url('/instructor') }}" title="{{ __('Instructor Dashboard')}}"><li><i data-feather="pie-chart"></i>{{ __('Instructor Dashboard') }}</li></a>
                                                    @endif
                                                    <a href="{{ route('mycourse.show') }}" title="{{ __('My Courses')}}"><li><i data-feather="book-open"></i>{{ __('My Courses') }}</li></a>
                                                    <a href="{{ route('wishlist.show') }}" title="{{ __('Wishlist')}}"><li><i data-feather="heart"></i>{{ __('Wishlist') }}</li></a>
                                                    <a href="{{ route('purchase.show') }}" title="{{ __('Purchased History')}}"><li><i data-feather="shopping-cart"></i>{{ __('Purchased History') }}</li></a>
                                                    <a href="{{route('profile.show',Auth::User()->id)}}" title="{{ __('Profile')}}"><li><i data-feather="user"></i>{{ __('Profile') }}</li></a>
                                                    @if(Auth::User()->role == "user")
                                                    @if($gsetting->instructor_enable == 1)
                                                    <a href="#" data-toggle="modal" data-target="#myModalinstructor" title="{{ __('Become An Instructor')}}"><li><i data-feather="shield"></i>{{ __('Become An Instructor') }}</li></a>
                                                    @endif                        
                                                    @endif
                                                    <a href="{{ route('flash.deals') }}" title="{{ __('Flash Deals')}}"><li><i data-feather="battery-charging"></i>{{ __('Flash Deals') }}</li></a>
                                                    @if(env('ENABLE_INSTRUCTOR_SUBS_SYSTEM') == 1)
                                                    @if(Auth::User()->role == "instructor")
                                                    <a href="{{ route('plan.page') }}" title="{{ __('Instructor Plan')}}"><li><i data-feather="tag"></i>{{ __('Instructor Plan') }}</li></a>
                                                    @endif
                                                    @endif
                                                    @if(Auth::User()->role == "user" || Auth::User()->role == "instructor")
                                                    @if($gsetting->device_control == 1)
                                                    <a href="{{ route('active.courses') }}" title="{{ __('Watchlist')}}"><li><i data-feather="framer"></i>{{ __('Watchlist') }}</li></a>
                                                    @endif
                                                    @endif
                                                    @if($gsetting->donation_enable == 1)
                                                    <a target="__blank" href="{{ $gsetting->donation_link }}" title="{{ __('Donation')}}"><li><i data-feather="framer"></i>{{ __('Donation') }}</li></a>
                                                    @endif
                                                    @if(Schema::hasTable('affiliate') && Schema::hasTable('wallet_settings'))
                                                    @if(isset($wallet_settings) && $wallet_settings->status == 1)
                                                    <a href="{{ url('/wallet') }}" title="{{ __('Wallet')}}"><li><i class="icon-wallet icons"></i>{{ __('Wallet') }}</li></a>
                                                    @endif
                                                    @if(isset($affiliate) && $affiliate->status == 1)
                                                    <a href="{{ route('get.affiliate') }}" title="{{ __('Affiliate')}}"><li><i data-feather="users"></i>{{ __('Affiliate') }}</li></a>
                                                    @endif
                                                    @endif
                                                    <a href="{{ route('compare.index') }}" title="{{ __('Compare')}}"><li><i data-feather="bar-chart"></i>{{ __("Compare") }}</li></a>
                                                    @if(Module::has('Resume') && Module::find('Resume')->isEnabled())
                                                        @include('resume::front.searchresume')
                                                    @endif
                                                    @if(Module::has('Resume') && Module::find('Resume')->isEnabled())
                                                        @include('resume::front.job.icon')
                                                    @endif                               
                                                    @if(Module::find('Forum') && Module::find('Forum')->isEnabled())
                                                        @if($gsetting->forum_enable == 1)
                                                            @include('forum::layouts.sidebar_menu')
                                                        @endif
                                                    @endif
                                                    <a href="{{ route('my.leaderboard') }}" title="{{ __('Leader Board')}}"><li><i class="icon-chart icons"></i>{{ __('Leader Board') }}</li></a>
                                                    @if(Auth::User()->role == "user")
                                                    <a href="{{ route('studentprofile') }}" title="{{ __('Share Profile')}}"><li><i data-feather="share"></i>{{ __('Share Profile') }}</li></a>
                                                    <a href="{{ route('supportuser') }}" title="{{ __('Support')}}"><li><i data-feather="book-open"></i>{{ __('Support') }}</li></a>

                                                        <a href="#" class="" data-toggle="modal" data-target="#exampleModal"><li><i data-feather="trash"></i>
                                                            {{ __('Delete Account Request') }}
                                                       
                                                       </li>
                                                    </a>
                                                    @endif
                                                    <a href="{{ route('affilate.report') }}" title="{{ __('Affiliate Dashboard')}}"><li><i data-feather="users"></i>{{__('Affiliate Dashboard')}}</li></a>
                                                    <a href="{{ route('batch.front') }}" title="{{ __('Batch')}}"><li><i data-feather="book-open"></i>{{__('Batch')}}</li></a>
                                                    @if(Module::has('Ebook') && Module::find('Ebook')->isEnabled())
                                                    <a href="{{ route('web.ebook.confirm-order') }}" title="{{ __('My eBook')}}"><li><i data-feather="book-open"></i>{{ __('My eBook') }}</li></a>
                                                    @endif 
                                                </div>
                                                <a href="{{ route('logout') }}" title="{{ __('Logout')}}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                    <div id="notificationFooter">
                                                        {{ __('Logout') }}                                        
                                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="display-none">
                                                            @csrf
                                                        </form>
                                                    </div>
                                                </a>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                @endif

                            </div>
                        </div>
                        @endauth                   
                    </div>
                    
                </div>
            </div>
            <div class="second-menu mobilescreen">
                <div class="row">
                    <div class="col-3 col-md-3">
                    </div>
                    <div class="col-6 col-md-6">
                        <div class="logo">
                            @if($gsetting->logo_type == 'L')
                            <a href="{{ url('/') }}" ><img src="{{ asset('images/logo/'.$gsetting->logo) }}" class="img-fluid" alt="logo"></a>
                            @else()
                            <a href="{{ url('/') }}"><b><div class="logotext">{{ $gsetting->project_title }}</div></b></a>
                            @endif
                        </div>
                    </div>
                    <div class="col-3 col-md-3">
                        <div class="search search-one" id="search-one">
                            <form method="GET" id="searchform-one" action="{{ route('search') }}">
                                <div class="search-input-wrap">
                                    <input class="search-input" name="searchTerm" placeholder="Search in Site" type="text" id="course_name-one" autocomplete="off" />
                                </div>
                                <input class="search-submit" type="submit" id="go-one" value="">
                                <div class="icon" id="search-icon-one"><i data-feather="search"></i></div>
                                <div id="course_data-one"></div>
                            </form>
                        </div>
           
                    </div>
                </div>                
                <div class="mobile-menu"></div>
            </div>
        </div>
    </div>
</header>
<div class="second-menu mobilescreen">
    <div class="mobile-bottom-bar" id="mobileTabs">
        @guest
        <div class="row">
            <div class="col-3">
                <div class="mobile-bottom-menu">
                    <a href="{{ url('/') }}" title="">
                        <i data-feather="home"></i>
                    </a>
                </div>
            </div>
            <div class="col-3">
                <div class="mobile-bottom-menu">
                    <div class="shopping-cart">
                        <a href="{{ route('cart.show') }}" title="{{ __('Cart') }}"><i data-feather="shopping-cart"></i></a>
                        <span class="red-menu-badge red-bg-success">
                            @php
                                $item = session()->get('cart.add_to_cart');                                    
                                if(isset($item) && count($item)>0){
                                    echo count(array_unique($item));
                                }
                                else{
                                    echo "0";
                                }
                            @endphp
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="mobile-bottom-menu">
                    <div class="Login-btn">
                        <a href="{{ route('login') }}" class="btn btn-secondary" title="{{ __('Login') }}"><i data-feather="log-in"></i></a>                           
                    </div> 
                </div>
            </div>
            <div class="col-3">
                <div class="mobile-bottom-menu">
                    <div class="Login-btn">
                        <a href="{{ url('registers') }}" class="btn btn-secondary" title="{{ __('Signup') }}"><i data-feather="user-plus"></i></a>                            
                    </div> 
                </div> 
            </div>
        </div>
        @endguest
        @auth
        <div class="row login-mobile-bottom-bar">   
            <div class="col-3">
                <div class="mobile-bottom-menu home-menu">
                    <a href="{{ url('/') }}" title="">
                        <i data-feather="home"></i>
                    </a>
                </div>
            </div>                     
            <div class="col-3">
                <div class="mobile-bottom-menu">
                    <div class="shopping-cart">
                        <a href="{{ route('cart.show') }}" title="{{ __('Cart') }}"><i data-feather="shopping-cart"></i></a>
                        <span class="red-menu-badge red-bg-success">
                            @php
                                $item = App\Cart::where('user_id', Auth::User()->id)->count();
                                if($item>0){
                                    echo $item;
                                }
                                else{
                                    echo "0";
                                }
                            @endphp
                        </span>
                    </div> 
                </div>
            </div>                        
            <div class="col-3">
                <div class="mobile-bottom-menu">
                    <div class="nav-wishlist">
                        <ul id="nav-one">
                            <li id="notification_li-one">
                                <a href="{{ url('send') }}" id="notificationLink-one" title="Notification"><i data-feather="bell"></i></a>
                                <span class="red-menu-badge red-bg-success">
                                    {{ Auth()->user()->unreadNotifications->where('type', 'App\Notifications\UserEnroll')->count() }}
                                </span>
                                <div id="notificationContainer-one">
                                    <div id="notificationTitle-one">{{ __('Notifications') }}</div>
                                    <div id="notificationsBody-one" class="notifications">
                                        <ul>
                                            @foreach(Auth()->user()->unreadNotifications->where('type', 'App\Notifications\UserEnroll') as $notification)
                                                <li class="unread-notification">
                                                    <a href="{{url('notifications/'.$notification->id)}}">          
                                                    <div class="notification-image">
                                                        @if($notification->data['image'] !== NULL )
                                                            <img src="{{ asset('images/course/'.$notification->data['image']) }}" alt="course" class="img-fluid" >
                                                        @else
                                                            <img src="{{ Avatar::create($notification->data['id'])->toBase64() }}" alt="course" class="img-fluid">
                                                        @endif
                                                    </div>
                                                    <div class="notification-data">
                                                        In {{ str_limit($notification->data['id'], $limit = 20, $end = '...') }}
                                                        <br>
                                                        {{ str_limit($notification->data['data'], $limit = 20, $end = '...') }}
                                                    </div>
                                                    </a>
                                                </li>
                                            @endforeach

                                            @foreach(Auth()->user()->readNotifications->where('type', 'App\Notifications\UserEnroll') as $notification)
                                                <li>
                                                    <a href="{{ route('mycourse.show') }}">
                                                    <div class="notification-image">
                                                        @if($notification->data['image'] !== NULL )
                                                            <img src="{{ asset('images/course/'.$notification->data['image']) }}" alt="course" class="img-fluid" >
                                                        @else
                                                        <img src="{{ Avatar::create($notification->data['id'])->toBase64() }}" alt="course" class="img-fluid">
                                                        @endif
                                                    </div>
                                                    <div class="notification-data">
                                                        In {{  str_limit($notification->data['id'], $limit = 20, $end = '...') }}
                                                        <br>
                                                        {{ str_limit($notification->data['data'], $limit = 20, $end = '...') }}
                                                    </div>
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <div id="notificationFooter-one"><a href="{{route('deleteNotification')}}">{{ __('ClearAll') }}</a></div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="mobile-bottom-menu">
                    @php
                    $user = \Auth::user(); 
                    $roles = $user->getRoleNames();
                    $test_id = Spatie\Permission\Models\Role::select('id')->where('name',$roles[0])->get();
                    $dropdown = App\Dropdown::where('role_id', $test_id[0]['id'])->get();
                    @endphp
                    @if($roles[0] != "admin" &&  $roles[0] != "instructor" && $roles[0] != "user")
                    @foreach($dropdown as $drop)
                    <div class="my-container">
                        <div class="dropdown">
                            <button class="btn btn-default dropdown-toggle  my-dropdown" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                @if(Auth::User()['user_img'] != null && Auth::User()['user_img'] !='' && @file_get_contents('images/user_img/'.Auth::user()['user_img']))
                                <img src="{{ url('/images/user_img/'.Auth::User()->user_img) }}" class="circle" alt="{{ Auth::User()->fname }}">
                                @else
                                    <img src="{{ asset('images/default/user.jpg')}}"  class="circle" alt="{{ Auth::User()->fname }}">
                                @endif
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right User-Dropdown U-open" aria-labelledby="dropdownMenu1">
                                <div id="notificationTitle">
                                    @if(Auth::User()['user_img'] != null && Auth::User()['user_img'] !='' && @file_get_contents('images/user_img/'.Auth::user()['user_img']))
                                    <img src="{{ url('/images/user_img/'.Auth::User()->user_img) }}" class="dropdown-user-circle" alt="{{ Auth::User()->fname }}">
                                    @else
                                        <img src="{{ asset('images/default/user.jpg')}}" class="dropdown-user-circle" alt="{{ Auth::User()->fname }}">
                                    @endif
                                    <div class="user-detailss">
                                        {{ Auth::User()->fname }}
                                        <br>
                                        {{ Auth::User()->email }}
                                    </div>                                    
                                </div>
                                <div class="scroll-down">
                                @if(Auth::User()->role == "admin" )                               
                                <a target="_blank" href="{{ url('/admins') }}" title="{{ __('Admin Dashboard') }}"><li><i data-feather="pie-chart"></i>{{ __('Admin Dashboard') }}</li></a>
                                @endif
                                @if(Auth::User()->role == "instructor")
                                <a target="_blank" href="{{ url('/instructor') }}" title="{{ __('Instructor Dashboard') }}"><li><i data-feather="pie-chart"></i>{{ __('Instructor Dashboard') }}</li></a>
                                @endif

                            
                                @if($drop->my_courses == '1')
                                <a href="{{ route('mycourse.show') }}" title="{{ __('My Courses') }}"><li><i data-feather="book-open"></i>{{ __('My Courses') }}</li></a>
                                @endif
                                @if($drop->my_wishlist == '1')
                                <a href="{{ route('wishlist.show') }}" title="{{ __('Wishlist')}}"><li><i data-feather="heart"></i>{{ __('Wishlist') }}</li></a>
                                @endif
                                @if($drop->purchased_history == '1')
                                <a href="{{ route('purchase.show') }}" title="{{ __('Purchased History')}}"><li><i data-feather="shopping-cart"></i>{{ __('Purchased History') }}</li></a>
                                @endif
                                @if($drop->my_profile == '1')
                                <a href="{{route('profile.show',Auth::User()->id)}}" title="{{ __('Profile')}}"><li><i data-feather="user"></i>{{ __('Profile') }}</li></a>
                                @endif
                                @if(Auth::User()->role == "user")
                                @if($gsetting->instructor_enable == 1)
                                <a href="#" data-toggle="modal" data-target="#myModalinstructor"  title="{{ __('Become An Instructor')}}"><li><i data-feather="shield"></i>{{ __('Become An Instructor') }}</li></a>
                                @endif
                        
                                @endif
                                @if($drop->flash_deal == '1')
                                <a href="{{ route('flash.deals') }}" title="{{ __('Flash Deal')}}"><li><i data-feather="battery-charging"></i>{{ __('Flash Deals') }}</li></a>
                                @endif
                                @if(env('ENABLE_INSTRUCTOR_SUBS_SYSTEM') == 1)
                                @if(Auth::User()->role == "instructor")
                                <a href="{{ route('plan.page') }}" title="{{ __('Instructor Plan')}}"><li><i data-feather="tag"></i>{{ __('Instructor Plan') }}</li></a>
                                @endif
                                @endif
                                @if(Auth::User()->role == "user" || Auth::User()->role == "instructor")
                                @if($gsetting->device_control == 1)
                                <a href="{{ route('active.courses') }}" title="{{ __('Watchlist')}}"><li><i data-feather="framer"></i>{{ __('Watchlist') }}</li></a>
                                @endif
                                @endif                                
                                @if($gsetting->donation_enable == 1 && $drop->donation == '1')
                                <a target="__blank" href="{{ $gsetting->donation_link }}" title="{{ __('Donation')}}"><li><i data-feather="framer"></i>{{ __('Donation') }}</li></a>
                                @endif
                                @if($gsetting->affilate == 1 && $drop->my_wallet == '1')
                                @if(Schema::hasTable('affiliate') && Schema::hasTable('wallet_settings'))
                                @endif
                                @if(isset($wallet_settings) && $wallet_settings->status == 1)
                                <a href="{{ url('/wallet') }}" title="{{ __('Wallet')}}"><li><i class="icon-wallet icons"></i>{{ __('Wallet') }}</li></a>
                                @endif
                                @if(isset($affiliate) && $affiliate->status == 1)
                                <a href="{{ route('get.affiliate') }}" title="{{ __('Affiliate')}}"><li><i data-feather="users"></i>{{ __('Affiliate') }}</li></a>
                                @endif
                                @endif
                                @if($drop->compare == '1')
                                <a href="{{ route('compare.index') }}" title="{{ __('Compare')}}"><li><i data-feather="bar-chart"></i>{{ __("Compare") }}</li></a>
                                @endif
                                @if($drop->search_job == '1')
                                @if(Module::has('Resume') && Module::find('Resume')->isEnabled())
                                    @include('resume::front.searchresume')
                                @endif
                                @endif
                                @if($drop->job_portal == '1')
                                @if(Module::has('Resume') && Module::find('Resume')->isEnabled())
                                    @include('resume::front.job.icon')
                                @endif
                                @endif
                                @if($drop->form_enable == '1')
                                @if(Module::find('Forum') && Module::find('Forum')->isEnabled())
                                    @if($gsetting->forum_enable == 1)
                                        @include('forum::layouts.sidebar_menu')
                                    @endif
                                @endif
                                @endif
                                @if($drop->my_leadership == '1')
                                <a href="{{ route('my.leaderboard') }}" title="{{ __('leader Board')}}"><li><i class="icon-chart icons"></i>{{ __('Leader Board') }}</li></a>
                                @endif
                                @if(Auth::User()->role == "user")
                                <a href="{{ route('studentprofile') }}" title="{{ __('Share Profile')}}"><li><i data-feather="share"></i>{{ __('Share Profile') }}</li></a>
                                @endif
                                @if($drop->affilate_dashboard == '1')
                                <a href="{{ route('affilate.report') }}"><li><i data-feather="users"></i>{{__('Affiliate Dashboard')}}</li></a>
                                @endif
                                <a href="{{ route('batch.front') }}" title="{{ __('Batch')}}"><li><i data-feather="book-open"></i>{{__('Batch')}}</li></a>
                                </div>
                                @if(Module::has('Ebook') && Module::find('Ebook')->isEnabled())
                                <a href="{{ route('web.ebook.confirm-order') }}" title="{{ __('My eBook')}}"><li><i data-feather="book-open"></i>{{ __('My eBook') }}</li></a>
                                @endif 
                                <a href="{{ route('logout') }}" title="{{ __('Logout')}}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <div id="notificationFooter">
                                        <i data-feather="power" class="mr-2"></i> {{ __('Logout') }}                                        
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="display-none">
                                            @csrf
                                        </form>
                                    </div>
                                </a>
                            </ul>
                        </div>
                    </div>
                    @endforeach
                    @else
                    <div class="my-container">
                        <div class="dropdown">
                            <button class="btn btn-default dropdown-toggle  my-dropdown" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                @if(Auth::User()['user_img'] != null && Auth::User()['user_img'] !='' && @file_get_contents('images/user_img/'.Auth::user()['user_img']))
                                <img src="{{ url('/images/user_img/'.Auth::User()->user_img) }}" class="circle" alt="{{ Auth::User()->fname }}">
                                @else
                                    <img src="{{ asset('images/default/user.jpg')}}"  class="circle" alt="{{ Auth::User()->fname }}">
                                @endif
                            </button>

                            <ul class="dropdown-menu dropdown-menu-right User-Dropdown U-open" aria-labelledby="dropdownMenu1">
                                <div id="notificationTitle">
                                    @if(Auth::User()['user_img'] != null && Auth::User()['user_img'] !='' && @file_get_contents('images/user_img/'.Auth::user()['user_img']))
                                    <img src="{{ url('/images/user_img/'.Auth::User()->user_img) }}" class="dropdown-user-circle" alt="{{ Auth::User()->fname }}">
                                    @else
                                        <img src="{{ asset('images/default/user.jpg')}}" class="dropdown-user-circle" alt="{{ Auth::User()->fname }}">
                                    @endif
                                    <div class="user-detailss">
                                        {{ Auth::User()->fname }}
                                        <br>
                                        {{ Auth::User()->email }}
                                    </div>
                                    
                                </div>

                                <div class="scroll-down">
                                    @if(Auth::User()->role == "admin" )                               
                                    <a target="_blank" href="{{ url('/admins') }}" title="{{ __('Admin Dashboard')}}"><li><i data-feather="pie-chart"></i>{{ __('Admin Dashboard') }}</li></a>
                                    @endif
                                    @if(Auth::User()->role == "instructor")
                                    <a target="_blank" href="{{ url('/instructor') }}" title="{{ __('Instructor Dashboard')}}"><li><i data-feather="pie-chart"></i>{{ __('Instructor Dashboard') }}</li></a>
                                    @endif
                                    <a href="{{ route('mycourse.show') }}" title="{{ __('My Courses')}}"><li><i data-feather="book-open"></i>{{ __('My Courses') }}</li></a>
                                    <a href="{{ route('wishlist.show') }}" title="{{ __('Wishlist')}}"><li><i data-feather="heart"></i>{{ __('Wishlist') }}</li></a>
                                    <a href="{{ route('purchase.show') }}" title="{{ __('Purchased History')}}"><li><i data-feather="shopping-cart"></i>{{ __('Purchased History') }}</li></a>
                                    <a href="{{route('profile.show',Auth::User()->id)}}" title="{{ __('Profile')}}"><li><i data-feather="user"></i>{{ __('Profile') }}</li></a>
                                    @if(Auth::User()->role == "user")
                                    @if($gsetting->instructor_enable == 1)
                                    <a href="#" data-toggle="modal" data-target="#myModalinstructor" title="{{ __('Become An Instructor')}}"><li><i data-feather="shield"></i>{{ __('Become An Instructor') }}</li></a>
                                    @endif                        
                                    @endif
                                    <a href="{{ route('flash.deals') }}" title="{{ __('Flash Deals')}}"><li><i data-feather="battery-charging"></i>{{ __('Flash Deals') }}</li></a>
                                    @if(env('ENABLE_INSTRUCTOR_SUBS_SYSTEM') == 1)
                                    @if(Auth::User()->role == "instructor")
                                    <a href="{{ route('plan.page') }}" title="{{ __('Instructor Plan')}}"><li><i data-feather="tag"></i>{{ __('Instructor Plan') }}</li></a>
                                    @endif
                                    @endif
                                    @if(Auth::User()->role == "user" || Auth::User()->role == "instructor")
                                    @if($gsetting->device_control == 1)
                                    <a href="{{ route('active.courses') }}" title="{{ __('Watchlist')}}"><li><i data-feather="framer"></i>{{ __('Watchlist') }}</li></a>
                                    @endif
                                    @endif
                                    @if($gsetting->donation_enable == 1)
                                    <a target="__blank" href="{{ $gsetting->donation_link }}" title="{{ __('Donation')}}"><li><i data-feather="framer"></i>{{ __('Donation') }}</li></a>
                                    @endif
                                    @if(Schema::hasTable('affiliate') && Schema::hasTable('wallet_settings'))
                                    @if(isset($wallet_settings) && $wallet_settings->status == 1)
                                    <a href="{{ url('/wallet') }}" title="{{ __('Wallet')}}"><li><i class="icon-wallet icons"></i>{{ __('Wallet') }}</li></a>
                                    @endif
                                    @if(isset($affiliate) && $affiliate->status == 1)
                                    <a href="{{ route('get.affiliate') }}" title="{{ __('Affiliate')}}"><li><i data-feather="users"></i>{{ __('Affiliate') }}</li></a>
                                    @endif
                                    @endif
                                    <a href="{{ route('compare.index') }}" title="{{ __('Compare')}}"><li><i data-feather="bar-chart"></i>{{ __("Compare") }}</li></a>
                                    @if(Module::has('Resume') && Module::find('Resume')->isEnabled())
                                        @include('resume::front.searchresume')
                                    @endif
                                    @if(Module::has('Resume') && Module::find('Resume')->isEnabled())
                                        @include('resume::front.job.icon')
                                    @endif                               
                                    @if(Module::find('Forum') && Module::find('Forum')->isEnabled())
                                        @if($gsetting->forum_enable == 1)
                                            @include('forum::layouts.sidebar_menu')
                                        @endif
                                    @endif
                                    <a href="{{ route('my.leaderboard') }}" title="{{ __('Leader Board')}}"><li><i class="icon-chart icons"></i>{{ __('Leader Board') }}</li></a>
                                    @if(Auth::User()->role == "user")
                                    <a href="{{ route('studentprofile') }}" title="{{ __('Share Profile')}}"><li><i data-feather="share"></i>{{ __('Share Profile') }}</li></a>
                                    <a href="{{ route('supportuser') }}" title="{{ __('Support')}}"><li><i data-feather="book-open"></i>{{ __('Support') }}</li></a>
                                
                                    <a href="#" class="" data-toggle="modal" data-target="#exampleModal"><li><i data-feather="trash"></i>
                                        {{ __('Delete Account Request') }}</li></a>
                                
                                    @endif
                                    <a href="{{ route('affilate.report') }}" title="{{ __('Affiliate Dashboard')}}"><li><i data-feather="users"></i>{{__('Affiliate Dashboard')}}</li></a>
                                    <a href="{{ route('batch.front') }}" title="{{ __('Batch')}}"><li><i data-feather="book-open"></i>{{__('Batch')}}</li></a>
                                    @if(Module::has('Ebook') && Module::find('Ebook')->isEnabled())
                                    <a href="{{ route('web.ebook.confirm-order') }}" title="{{ __('My eBook')}}"><li><i data-feather="book-open"></i>{{ __('My eBook') }}</li></a>
                                    @endif 

                                </div>
                                <a href="{{ route('logout') }}" title="{{ __('Logout')}}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <div id="notificationFooter">
                                        <i data-feather="power"></i>{{ __('Logout') }}                                        
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="display-none">
                                            @csrf
                                        </form>
                                    </div>
                                </a>
                            </ul>
                        </div>
                    </div>
                    @endif 
                </div>
            </div>
        </div>
        @endauth
    </div>
</div>
<!-- side navigation  -->
<script>
function openNav() {
  document.getElementById("mySidenav").style.width = "250px";
}

function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
}
</script>


@include('instructormodel')