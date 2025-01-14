@if($hsetting->newsletter_enable == 1)
<!-- footer -->
<footer class="l footer-p pt-90" style="background-image: url('{{ asset('images/footer-bg.png') }}')">
    <div class="footer-top pb-70">
        <div class="container">
            <div class="row justify-content-between">

                <div class="col-xl-4 col-lg-4 col-sm-6">
                    <div class="footer-widget mb-30">
                        <div class="f-widget-title">
                            <h2>{{ __('About Us') }}</h2>
                        </div>
                        @php
                            $gsetting = App\Setting::first();
                        @endphp
                        <div class="footer-social mt-10">
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
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-2 col-sm-6">
                    <div class="footer-widget mb-30">
                        <div class="f-widget-title">
                            <h2>{{ __('Our Links') }}</h2>
                        </div>
                        <div class="footer-link">
                            <ul>
                                <li><a href="{{route('home')}}">{{__('Home')}}</a></li>
                                <li><a href="{{route('all.course')}}">{{__('Courses')}}</a></li>
                                <li><a href="{{route('contact.us')}}">{{__(' Contact Us')}}</a></li>
                                <li><a href="{{ route('blog.all') }}">{{__('Blog')}} </a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-sm-6">
                    <div class="footer-widget mb-30">
                        <div class="f-widget-title">
                            <h2>Latest Post</h2>
                        </div>
                        @php
                            $blog = App\Blog::all()->take(2);
                        @endphp
                        <div class="recent-blog-footer">
                            <ul>
                                @foreach($blog as $data)
                                <li>
                                    <div class="thum"> <img src="{{ asset('images/blog/'.$data['image']) }}"
                                            alt="img"></div>
                                    <div class="text"> <a
                                            href="{{route('blog.all')}}">{{ $data['heading'] }}</a>
                                        <span>{{ date('d-m-Y',strtotime($data['created_at'])) }}</span></div>
                                </li>
                                @endforeach

                            </ul>


                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-sm-6">
                    <div class="footer-widget mb-30">
                        <div class="f-widget-title">
                            <h2>{{__('Contact Us')}}</h2>
                        </div>
                        <div class="f-contact">
                            <ul>
                                <li>
                                    <i class="icon fal fa-phone"></i>
                                    <span><a href="tel:+{{ $gsetting->default_phone }}">{{ $gsetting->default_phone }}</a><br>                                </li>
                                <li><i class="icon fal fa-envelope"></i>
                                    <span>
                                        <a href="mailto:info@example.com">{{ $gsetting->wel_email }}</a>
                                        <br>
                                    </span>
                                </li>
                                <li>
                                    <i class="icon fal fa-map-marker-check"></i>
                                    <span>{{ $gsetting->default_address }}</span>
                                </li>

                            </ul>

                        </div>

                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-6">
                            @php
                            $languages = App\Language::get();
                            @endphp
                            @if(isset($languages) && count($languages) > 0)
                            <div class="footer-dropdown">
                                <a href="#" class="a" data-toggle="dropdown"><i
                                        data-feather="globe"></i>{{Session::has('changed_language') ? ucfirst(Session::get('changed_language')) : ''}}<i
                                        class="fa fa-angle-up lft-10"></i></a>
                                <ul class="dropdown-menu">
                                    @foreach($languages as $language)
                                    <a href="{{ route('languageSwitch', $language->local) }}">
                                        <li>{{$language->name}}</li>
                                    </a>
                                    @endforeach

                                </ul>
                            </div>
                            @endif
                        </div>
                        <div class="col-lg-6 col-md-6 col-6">
                            @php
                            $currencies = DB::table('currencies')->get();
                            @endphp
                            @if(isset($currencies) && count($currencies) > 0)
                            <div class="footer-dropdown footer-dropdown-two">
                                <a href="#" class="a" data-toggle="dropdown"><i data-feather="credit-card"></i>
                                    {{Session::has('changed_currency') ? ucfirst(Session::get('changed_currency')) : $currency->code}}<i
                                        class="fa fa-angle-up lft-10"></i></a>
                                <ul class="dropdown-menu">
                                    @foreach($currencies as $currency)
                                    <li><a href="{{ route('CurrencySwitch', $currency->code) }}">{{$currency->code}}</a>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2">

                </div>

            </div>
        </div>
    </div>
    <div class="copyright-wrap">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="copy-text">
                        <a href="{{route('home')}}"><img src="{{ asset('images/logo/'.$gsetting->footer_logo) }}"
                                alt="img"></a>
                    </div>
                </div>
                @if(isset($terms->terms) && $terms->terms != NULL && $terms->terms != '')
                <div class="col-lg-6 col-md-6 col-12 text-center text-md-end text-lg-end text-xl-end">
                    {{ $gsetting->cpy_txt }}
                </div>
                @endif
            </div>
        </div>
    </div>
</footer>
<!-- footer-end -->
@endif
@include('instructormodel')