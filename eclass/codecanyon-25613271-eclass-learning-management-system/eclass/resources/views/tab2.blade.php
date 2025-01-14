<div class="row">
    @foreach($courses as $c)
    @if($c->status == 1)
    <div class="col-lg-4 col-md-6 col-12">
        <div class="courses-item mb-30 hover-zoomin ms-0 me-0 protip">
            <div class="thumb fix ">
                @if($c['preview_image'] !== NULL && $c['preview_image'] !== '')
                <a href="{{ route('user.course.show',['slug' => $c->slug ]) }}"><img src="{{ asset('images/course/'.$c['preview_image']) }}" alt="course" class="img-fluid" >
                </a>
            @else
                <a href="{{ route('user.course.show',['slug' => $c->slug ]) }}"><img src="{{ Avatar::create($c->title)->toBase64() }}" alt="course"class="img-fluid">
                </a>
            @endif                
            <div class="courses-icon">
                    <ul>
                        <li class="protip-wish-btn"><a href="https://calendar.google.com/calendar/r/eventedit?text={{ $c['title'] }}" target="__blank" title="{{__('Reminder')}}"><i data-feather="bell"></i></a></li>
                        @if(Auth::check())
                            <li class="protip-wish-btn"><a class="compare" data-id="{{filter_var($c->id)}}" title="{{__('Compare')}}"><i data-feather="bar-chart"></i></a></li>                            

                            @php
                                $wish = App\Wishlist::where('user_id', Auth::User()->id)->where('course_id', $c->id)->first();
                            @endphp
                            @if ($wish == NULL)
                             <li class="protip-wish-btn">
                                    <form id="demo-form2" method="post" action="{{ url('show/wishlist', $c->id) }}" data-parsley-validate
                                        class="form-horizontal form-label-left">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="user_id"  value="{{Auth::User()->id}}" />
                                        <input type="hidden" name="course_id"  value="{{$c->id}}" />
                                        <button class="wishlisht-btn" title="{{__('Add to Wishlist')}}" type="submit"><i data-feather="heart"></i></button>
                                    </form>
                                </li>
                            @else
                                <li class="protip-wish-btn-two">
                                    <form id="demo-form2" method="post" action="{{ url('remove/wishlist', $c->id) }}" data-parsley-validate
                                        class="form-horizontal form-label-left">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="user_id"  value="{{Auth::User()->id}}" />
                                        <input type="hidden" name="course_id"  value="{{$c->id}}" />
                                        <button class="wishlisht-btn heart-fill" title="Remove from Wishlist" type="submit"><i data-feather="heart"></i></button>
                                    </form>
                                </li>
                            @endif
                        @else
                            <li class="protip-wish-btn"><a href="{{ route('login') }}" title="{{__('Login')}}"><i data-feather="heart"></i></a></li>
                        @endif
                    </ul>
                </div>
            </div>
            @if($c['level_tags'] == 'trending')
            <div class="advance-badge">
                <span class="badge bg-warning">{{__('Trending')}}</span>
            </div>
            @endif
            @if($c['level_tags'] == 'featured')

            <div class="advance-badge">
                <span class="badge bg-danger">{{__('Featured')}}</span>
            </div>
            @endif
            @if($c['level_tags'] == 'new')

            <div class="advance-badge">
                <span class="badge bg-success">{{__('New')}}</span>
            </div>
            @endif
            @if($c['level_tags'] == 'onsale')

            <div class="advance-badge">
                <span class="badge bg-info">{{__('On-sale')}}</span>
            </div>
            @endif
            @if($c['level_tags'] == 'bestseller')

            <div class="advance-badge">
                <span class="badge bg-success">{{__('Bestseller')}}</span>
            </div>
            @endif
            @if($c['level_tags'] == 'beginner')

            <div class="advance-badge">
                <span class="badge bg-primary">{{__('Beginner')}}</span>
            </div>
            @endif
            @if($c['level_tags'] == 'intermediate')

            <div class="advance-badge">
                <span class="badge bg-secondary">{{__('Intermediate')}}</span>
            </div>
            @endif
            <div class="courses-content">    
                <div class="view-user-img">
                    @if($c->user['user_img'] !== NULL && $c->user['user_img'] !== '')
                    <a href="{{ route('all/profile',$c->user->id) }}" title="{{ $c->title }}"><img src="{{ asset('images/user_img/'.$c->user['user_img']) }}" class="img-fluid user-img-one" alt="{{ $c->title }}""></a>
                    @else
                    <a href="{{ route('all/profile',$c->user->id) }}" title="{{ $c->title }}"><img src="{{ asset('images/default/user.png') }}" class="img-fluid user-img-one" alt="{{ $c->title }}""></a>
                    @endif
                 
                </div>                              
                <div class="cat">
                    <div class="rate text-right">
                        @if( $c->type == 1)
                            <div class="rate text-right">
                                <ul>
                                    @if($c->discount_price == !NULL)
                                        
                                        <li><a><b>{{ activeCurrency()->getData()->position == 'l'  ? activeCurrency()->getData()->symbol :'' }}{{ price_format( currency($c['discount_price'], $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false)) }}{{ activeCurrency()->getData()->position == 'r'  ? activeCurrency()->getData()->symbol :'' }}</b></a></li>
                                        <li><a><b><strike>{{ activeCurrency()->getData()->position == 'l'  ? activeCurrency()->getData()->symbol :'' }}{{ price_format(  currency($c['price'], $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false)) }}{{ activeCurrency()->getData()->position == 'r'  ? activeCurrency()->getData()->symbol :'' }}</strike></b></a></li>
                                        @else
                                        @if($c->price == !NULL) 
                                        <li><a><b>{{ activeCurrency()->getData()->position == 'l'  ? activeCurrency()->getData()->symbol :'' }}{{ price_format(  currency($c['price'], $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false)) }}{{ activeCurrency()->getData()->position == 'r'  ? activeCurrency()->getData()->symbol :'' }}</b></a></li>
                                        @endif
                                        
                                    @endif
                                </ul>
                            </div>
                        @else
                            <div class="rate text-right">
                                <ul>
                                    <li><a><b>{{ __('Free') }}</b></a></li>
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
                <h3><a href="{{ route('user.course.show',['slug' => $c->slug ]) }}" tabindex="0" title="{{ $c->title }}">{{ $c->title }}</a></h3>
                <p>{{ strip_tags(str_limit($c['short_detail'], $limit = 200, $end = '...')) }}</p>

                    <a href="{{ route('user.course.show',['slug' => $c->slug ]) }}" class="readmore" tabindex="0" title="{{ __('Read More') }}">{{ __('Read More') }} <i class="fal fa-long-arrow-right"></i></a>
                </p>
            </div>
            <div class="icon">
                <img src="{{ url('frontcss/img/icon/cou-icon.png') }}" alt="{{ __('cou-icon')}}">
            </div>
        </div>
    </div>
    @endif
    @endforeach
</div>
<script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
<script>
  feather.replace()
</script>
