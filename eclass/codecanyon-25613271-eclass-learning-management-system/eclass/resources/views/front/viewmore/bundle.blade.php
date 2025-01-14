@extends('theme.master')
@section('title')
@section('content')
@include('admin.message')
<div class="student-view-slider-main-block view-more-pages">
    <div class="container-xl">
        @if(count($bundles) > 0)
        <div class="row">
            @foreach($bundles as $bundle)
            @if($bundle->status == 1)
            <div class="col-lg-3">
            <div class="item student-view-block student-view-block-1">
                <div class="genre-slide-image @if($gsetting['course_hover'] == 1) protip @endif"
                    data-pt-placement="outside" data-pt-interactive="false"
                    data-pt-title="#prime-next-item-description-block-4{{$bundle->id}}">
                    <div class="view-block">
                        <div class="view-img">
                            @if($bundle['preview_image'] !== NULL && $bundle['preview_image'] !== '')
                            <a href="{{ route('bundle.detail', $bundle->slug) }}"><img
                                    src="{{ asset('images/bundle/'.$bundle['preview_image']) }}" alt="course"
                                    class="img-fluid owl-lazy"></a>
                            @else
                            <a href="{{ route('bundle.detail', $bundle->slug) }}"><img
                                    src="{{ Avatar::create($bundle->title)->toBase64() }}" alt="course"
                                    class="img-fluid owl-lazy"></a>
                            @endif
                        </div>
                        <div class="view-user-img">
                            <a href="" title="{{$bundle->title}}"><img src="http://eclass.test/images/user_img/159116548431.jpg"
                                    class="img-fluid user-img-one" alt="{{$bundle->title}}"></a>
                        </div>
                        <div class="view-dtl">
                            <div class="view-heading"><a
                                    href="{{ route('bundle.detail', $bundle->slug) }}">{{ str_limit($bundle->title, $limit = 30, $end = '...') }}</a>
                            </div>
                            <div class="user-name">
                                <h6>By <span>{{ optional($bundle->user)['fname'] }}</span></h6>
                            </div>
                            <!-- <p class="btm-10"><a herf="#">{{ __('by') }} @if(isset($bundle->user)) {{ $bundle->user['fname'] }} {{ $bundle->user['lname'] }} @endif</a></p> -->

                            <div class="view-footer">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                        <div class="count-user">
                                            <i data-feather="user"></i><span>
                                                {{ $bundle->order->count() }}</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                        @if($bundle->type == 1 && $bundle->price != null)
                                        <div class="rate text-right">
                                            <ul>

                                                @if($bundle->discount_price == !NULL)

                                                <li><a><b>{{ activeCurrency()->getData()->position == 'l'  ? activeCurrency()->getData()->symbol :'' }}{{ price_format(  currency($bundle->discount_price, $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false)) }}{{ activeCurrency()->getData()->position == 'r'  ? activeCurrency()->getData()->symbol :'' }}</b></a>
                                                </li>

                                                <li><a><b><strike>{{ activeCurrency()->getData()->position == 'l'  ? activeCurrency()->getData()->symbol :'' }}{{ price_format( currency($bundle->price, $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false)) }}{{ activeCurrency()->getData()->position == 'r'  ? activeCurrency()->getData()->symbol :'' }}</strike></b></a>
                                                </li>


                                                @else
                                                <li><a><b>
                                                    {{ activeCurrency()->getData()->position == 'l'  ? activeCurrency()->getData()->symbol :'' }}{{ price_format(  currency($bundle->price, $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false)) }}{{ activeCurrency()->getData()->position == 'r'  ? activeCurrency()->getData()->symbol :'' }}</b></a>
                                                </li>
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
                            </div>
                            <div class="img-wishlist">
                                <div class="protip-wishlist">
                                    <ul>

                                        <li class="protip-wish-btn"><a
                                                href="https://calendar.google.com/calendar/r/eventedit?text={{ $bundle['title'] }}"
                                                target="__blank" title="reminder"><i data-feather="bell"></i></a></li>

                                        @if(Auth::check())

                                        <li class="protip-wish-btn"><a class="compare" data-id="{{filter_var($bundle->id)}}"
                                                title="compare"><i data-feather="bar-chart"></i></a></li>

                                        @php
                                        $wish = App\Wishlist::where('user_id', Auth::User()->id)->where('course_id',
                                        $bundle->id)->first();
                                        @endphp
                                        @if ($wish == NULL)
                                        <li class="protip-wish-btn">
                                            <form id="demo-form2" method="post"
                                                action="{{ url('show/wishlist', $bundle->id) }}" data-parsley-validate
                                                class="form-horizontal form-label-left">
                                                {{ csrf_field() }}

                                                <input type="hidden" name="user_id" value="{{Auth::User()->id}}" />
                                                <input type="hidden" name="course_id" value="{{$bundle->id}}" />

                                                <button class="wishlisht-btn" title="Add to wishlist" type="submit"><i
                                                        data-feather="heart"></i></button>
                                            </form>
                                        </li>
                                        @else
                                        <li class="protip-wish-btn-two">
                                            <form id="demo-form2" method="post"
                                                action="{{ url('remove/wishlist', $bundle->id) }}" data-parsley-validate
                                                class="form-horizontal form-label-left">
                                                {{ csrf_field() }}

                                                <input type="hidden" name="user_id" value="{{Auth::User()->id}}" />
                                                <input type="hidden" name="course_id" value="{{$bundle->id}}" />

                                                <button class="wishlisht-btn heart-fill" title="Remove from Wishlist"
                                                    type="submit"><i data-feather="heart"></i></button>
                                            </form>
                                        </li>
                                        @endif
                                        @else
                                        <li class="protip-wish-btn"><a href="{{ route('login') }}" title="heart"><i
                                                    data-feather="heart"></i></a></li>
                                        @endif
                                    </ul>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
                <div id="prime-next-item-description-block-4{{$bundle->id}}" class="prime-description-block">
                    <div class="prime-description-under-block">
                        <div class="prime-description-under-block">
                            <h5 class="description-heading">{{ $bundle['title'] }}</h5>

                            <div class="product-main-des">
                                <p>{{ strip_tags(str_limit($bundle['detail'], $limit = 200, $end = '...')) }}</p>
                            </div>
                            <div>
                                <div class="product-learn-dtl">
                                    <ul>

                                        @foreach ($bundle->course_id as $bundles)

                                        @php
                                        $course = App\Course::where('id', $bundles)->first();
                                        @endphp
                                        @isset($course)
                                        <li><i data-feather="check-circle"></i>
                                            <a href="#">{{ $course['title'] }}</a>
                                        </li>
                                        @endisset

                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div class="des-btn-block">
                                <div class="row">
                                    <div class="col-lg-12">
                                        @if($bundle->type == 1)
                                        @if(Auth::check())
                                        @if(Auth::User()->role == "admin")
                                        <div class="protip-btn">
                                            <a href="" class="btn btn-secondary"
                                                title="course">{{ __('Purchased') }}</a>
                                        </div>
                                        @else
                                        @php
                                        $order = App\Order::where('user_id', Auth::User()->id)->where('bundle_id',
                                        $bundle->id)->first();
                                        @endphp
                                        @if(!empty($order) && $order->status == 1)
                                        <div class="protip-btn">
                                            <a href="" class="btn btn-secondary"
                                                title="course">{{ __('Purchased') }}</a>
                                        </div>
                                        @else
                                        @php
                                        $cart = App\Cart::where('user_id', Auth::User()->id)->where('bundle_id',
                                        $bundle->id)->first();
                                        @endphp
                                        @if(!empty($cart))
                                        <div class="protip-btn">
                                            <form id="demo-form2" method="post"
                                                action="{{ route('remove.item.cart',$cart->id) }}">
                                                {{ csrf_field() }}

                                                <div class="box-footer">
                                                    <button type="submit"
                                                        class="btn btn-primary">{{ __('Remove From Cart') }}</button>
                                                </div>
                                            </form>
                                        </div>
                                        @else
                                        <div class="protip-btn">
                                            <form id="demo-form2" method="post"
                                                action="{{ route('bundlecart', $bundle->id) }}" data-parsley-validate
                                                class="form-horizontal form-label-left">
                                                {{ csrf_field() }}

                                                <input type="hidden" name="user_id" value="{{Auth::User()->id}}" />
                                                <input type="hidden" name="bundle_id" value="{{$bundle->id}}" />

                                                <div class="box-footer">
                                                    <button type="submit"
                                                        class="btn btn-primary"><i data-feather="shopping-cart"></i>{{ __('Add To Cart') }}</button>
                                                </div>
                                            </form>
                                        </div>
                                        @endif
                                        @endif
                                        @endif
                                        @else
                                        <div class="protip-btn">
                                            <a href="{{ route('login') }}" class="btn btn-primary"><i data-feather="shopping-cart"></i>&nbsp;{{ __('Add To Cart') }}</a>
                                        </div>
                                        @endif
                                        @else
                                        @if(Auth::check())
                                        @if(Auth::User()->role == "admin")
                                        <div class="protip-btn">
                                            <a href="" class="btn btn-secondary"
                                                title="course">{{ __('Purchased') }}</a>
                                        </div>
                                        @else
                                        @php
                                        $enroll = App\Order::where('user_id', Auth::User()->id)->where('bundle_id',
                                        $bundle->id)->first();
                                        @endphp
                                        @if($enroll == NULL)
                                        <div class="protip-btn">
                                            <a href="{{url('enroll/show',$bundle->id)}}" class="btn btn-primary"
                                                title="Enroll Now"><i data-feather="shopping-cart"></i>{{ __('Enroll Now') }}</a>
                                        </div>
                                        @else
                                        <div class="protip-btn">
                                            <a href="" class="btn btn-secondary"
                                                title="Cart">{{ __('Purchased') }}</a>
                                        </div>
                                        @endif
                                        @endif
                                        @else
                                        <div class="protip-btn">
                                            <a href="{{ route('login') }}" class="btn btn-primary"
                                                title="Enroll Now"><i data-feather="shopping-cart"></i>{{ __('Enroll Now') }}</a>
                                        </div>
                                        @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            </div>
            @endif

            @endforeach
        </div>
        @endif
    </div>    
</div>
@endsection 
@section('custom-script')
@endsection