@php
$widgets = App\WidgetSetting::first();
$menus = App\Menu::where('footer', 'widget2')->orWhere('footer', 'widget3')->orWhere('footer', 'widget4')->get();
$pages = App\Page::where('status', 1)->get();
$languages = App\Language::get();
$currencies = DB::table('currencies')->get();
@endphp

<footer id="footer" class="footer-main-block">
    <!-- Newsletter -->
    @if($hsetting->newsletter_enable == 1)
    <section id="newsletter" class="newsletter-main-block">
        <div class="container-xl">
            <div class="newsletter-block">
                <div class="row">
                    <div class="col-lg-6 col-md-5">
                        <h1 class="newsletter-heading">{{ __('Join our mailing list') }}</h1>
                    </div>
                    <div class="col-lg-6 col-md-7">
                        <form method="post" action="{{ url('store-newsletter') }}">
                            @csrf
                            <input type="email" required placeholder="Enter your email address" name="subscribed_email">
                            <button type="submit" class="btn btn-primary">{{ __('Subscribe') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    <div class="container-xl">
        <div class="footer-block">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-12">
                    <div class="footer-logo">
                        @if($gsetting->logo_type == 'L' && $gsetting->footer_logo)
                        <a href="{{ url('/') }}" title="{{ $gsetting->project_title }}">
                            <img src="{{ asset('images/logo/'.$gsetting->footer_logo) }}"
                                alt="{{ $gsetting->project_title }}" class="img-fluid">
                        </a>
                        @else
                        <a href="{{ url('/') }}"><b>{{ $gsetting->project_title }}</b></a>
                        @endif
                    </div>

                    <div class="mobile-btn">
                        @if($gsetting->play_download == '1')
                        <a href="{{ $gsetting->play_link }}" title="{{ __('Google Play') }}" target="_blank">
                            <img src="{{ url('images/icons/download-google-play.png') }}" alt="{{ __('Google Play') }}">
                        </a>
                        @endif
                        @if($gsetting->app_download == '1')
                        <a href="{{ $gsetting->app_link }}" title="{{ __('iOS') }}" target="_blank">
                            <img src="{{ url('images/icons/app-download-ios.png') }}" alt="{{ __('iOS') }}">
                        </a>
                        @endif
                    </div>
                </div>

                @if($widgets && $widgets->widget_enable == 1)
                <div class="col-lg-2 col-md-2 col-12">
                    <div class="widget"><b>{{ $widgets->widget_one }}</b></div>
                    <div class="footer-link">
                        <ul>
                            @if($gsetting->instructor_enable == 1 && Auth::check())
                            @if(Auth::user()->role == "user")
                            <li><a href="#" data-toggle="modal" data-target="#myModalinstructor"
                                    title="{{ __('Become An Instructor') }}">{{ __('Become An Instructor') }}</a></li>
                            @endif
                            @else
                            <li><a href="{{ route('login') }}" title="{{ __('Become An Instructor') }}">{{ __('Become An
                                    Instructor') }}</a></li>
                            @endif

                            @if($widgets->contact_enable == 1)
                            <li><a href="{{ route('contact.us') }}" title="{{ __('Contact Us') }}">{{ __('Contact Us')
                                    }}</a></li>
                            @endif
                            <li><a href="{{ route('front.service') }}" title="{{ __('Our Services') }}"
                                    target="_blank">{{ __('Our Services') }}</a></li>
                            <li><a href="{{ route('front.feature') }}" title="{{ __('Our Feature') }}"
                                    target="_blank">{{ __('Our Feature') }}</a></li>
                            <li><a href="{{ route('footer.alumini') }}" title="{{ __('Our Alumni') }}"
                                    target="_blank">{{ __('Alumni') }}</a></li>

                            <li>
                                <ul>
                                    @foreach($menus as $menu)
                                    @if($menu->link_by == 'url')
                                    <li><a href="{{ $menu->url }}" title="{{ $menu->title }}">{{ $menu->title }}</a>
                                    </li>
                                    @elseif($menu->link_by == 'page')
                                    <li><a href="{{ route('page.show', $menu->page->slug) }}"
                                            title="{{ $menu->title }}">{{ $menu->title }}</a></li>
                                    @endif
                                    @endforeach
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-2 col-md-2 col-12">
                    <div class="widget"><b>{{ $widgets->widget_two }}</b></div>
                    <div class="footer-link">
                        <ul>
                            @if($widgets->blog_enable == 1)
                            <li><a href="{{ route('blog.all') }}" title="{{ __('Blog') }}">{{ __('Blog') }}</a></li>
                            @endif
                            @if($widgets->help_enable == 1)
                            <li><a href="{{ route('help.show') }}" title="{{ __('Help & Support') }}">{{ __('Help &
                                    Support') }}</a></li>
                            @endif

                            <li>
                                <ul>
                                    @foreach($menus as $menu)
                                    @if($menu->link_by == 'url')
                                    <li><a href="{{ $menu->url }}" title="{{ $menu->title }}">{{ $menu->title }}</a>
                                    </li>
                                    @elseif($menu->link_by == 'page')
                                    <li><a href="{{ route('page.show', $menu->page->slug) }}"
                                            title="{{ $menu->title }}">{{ $menu->title }}</a></li>
                                    @endif
                                    @endforeach
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-2 col-md-2 col-12">
                    <div class="widget"><b>{{ $widgets->widget_three }}</b></div>
                    <div class="footer-link">
                        <ul>
                            @foreach($pages as $page)
                            <li><a href="{{ route('page.show', $page->slug) }}" title="{{ $page->title }}">{{
                                    $page->title }}</a></li>
                            @endforeach

                            <li>
                                <ul>
                                    @foreach($menus as $menu)
                                    @if($menu->link_by == 'url')
                                    <li><a href="{{ $menu->url }}">{{ $menu->title }}</a></li>
                                    @elseif($menu->link_by == 'page')
                                    <li><a href="{{ route('page.show', $menu->page->slug) }}">{{ $menu->title }}</a>
                                    </li>
                                    @endif
                                    @endforeach
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
                @endif

                <div class="col-lg-2 col-md-2 col-12">
                    <!-- Language & Currency -->
                    @if($languages && $languages->count() > 0)
                    <div class="footer-dropdown">
                        <a href="#" class="a" data-toggle="dropdown" title="{{ __('Language') }}">
                            <i data-feather="globe"></i>
                            {{ Session::has('changed_language') ? ucfirst(Session::get('changed_language')) : '' }}
                            <i class="fa fa-angle-up lft-10"></i>
                        </a>
                        <ul class="dropdown-menu">
                            @foreach($languages as $language)
                            <li><a href="{{ route('languageSwitch', $language->local) }}"
                                    title="{{ $language->name }}">{{ $language->name }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    @if($currencies && $currencies->count() > 0)
                    <div class="footer-dropdown footer-dropdown-two">
                        <a href="#" class="a" data-toggle="dropdown" title="{{ __('Currency') }}">
                            <i class="icon-wallet icons mr-2"></i>
                            {{ Session::has('changed_currency') ? ucfirst(Session::get('changed_currency')) :
                            $currency->code }}
                            <i class="fa fa-angle-up lft-10"></i>
                        </a>
                        <ul class="dropdown-menu">
                            @foreach($currencies as $currency)
                            <li><a href="{{ route('CurrencySwitch', $currency->code) }}"
                                    title="{{ $currency->code }}">{{ $currency->code }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <hr>
    <div class="tiny-footer">
        <div class="container-xl">
            <div class="row">
                <div class="col-md-6">
                    <div class="logo-footer">
                        <ul>
                            <li>{{ $gsetting->cpy_txt }}</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="copyright-social">
                        <ul>
                            <li>
                                @if(isset($terms->terms) && $terms->terms != NULL && $terms->terms != '')
                                <a href="{{ url('terms_condition') }}" title="{{ __('Terms & Condition') }}">{{ __('Terms & Condition') }}</a>
                                @endif
                            </li>
                            <li>
                                @if(isset($terms->policy) && $terms->policy != NULL && $terms->policy != '')
                                <a href="{{ url('privacy_policy') }}" title="{{ __('Privacy Policy') }}">{{ __('Privacy Policy') }}</a>
                                @endif
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</footer>
@include('instructormodel')