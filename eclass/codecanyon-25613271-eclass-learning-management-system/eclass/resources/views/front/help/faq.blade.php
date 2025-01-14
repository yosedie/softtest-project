@extends('theme.master')
@section('title', 'Help')
@section('content')
@include('admin.message')

<!-- help start-->
@php
$gets = App\Breadcum::first();
@endphp
@if(isset($gets))
<section id="business-home" class="business-home-main-block">
    <div class="business-img">
        @if($gets['img'] !== NULL && $gets['img'] !== '')
        <img src="{{ url('/images/breadcum/'.$gets->img) }}" class="img-fluid" alt="{{$gets->text}}" />
        @else
        <img src="{{ Avatar::create($gets->text)->toBase64() }}" alt="{{ __('course')}}" class="img-fluid">
        @endif
    </div>
    <div class="overlay-bg"></div>
    <div class="container-fluid">
        <div class="business-dtl">
            <div class="row">
                <div class="col-lg-6">
                    <div class="bredcrumb-dtl">
                        <h1 class="wishlist-home-heading">{{ __('help text') }}</h1>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="business-home-search">
                        <form method="GET" id="searchform" action="{{ route('search') }}">
                            <div class="search">
                                <input type="text" name="searchTerm" class="searchTerm" placeholder="Search for courses" value="{{ isset($searchTerm) ? $searchTerm : '' }}" autocomplete="off">
                                <button type="submit" class="searchButton">
                                    {{ __('Search')}}
                                </button>
                            </div>
                        </form> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif
<!-- help end-->
<!-- help-tab start-->

<section id="help-tab" class="help-tab-main-block">
    <div class="container-xl">
            <div class="help-tab-block btm-30">
                <div class="row">
                    <div class="col-lg-6">
                        <h5 class="faq-cat-title">Students</h5>
                        <h3 class="student-heading btm-40">{{ __('Frequently Asked Question') }}</h3>
                        <div class="accordion" id="studentAccordion">
                            @php
                                $faqs = App\FaqStudent::all();
                            @endphp
                            @foreach($faqs as $student_key => $faq)
                            @if($faq->status == 1)
                            <div class="card">
                                <div class="card-header" id="student_heading{{$faq->id}}">
                                    <h2 class="mb-0">
                                    <button class="btn btn-link btn-block text-left {{ $student_key == 0 ? '' : 'collapsed' }}" type="button" data-toggle="collapse" data-target="#student_collapse{{$faq->id}}" aria-expanded="{{ $student_key == 0 ? 'true' : 'false' }}" aria-controls="student_collapse{{$faq->id}}">
                                        {{ $faq->title }}
                                        <i data-feather="chevron-down"></i>
                                    </button>
                                    </h2>
                                </div>                                  
                                <div id="student_collapse{{$faq->id}}" class="collapse {{ $student_key == 0 ? 'show' : '' }}" aria-labelledby="student_heading{{$faq->id}}" data-parent="#studentAccordion">
                                    <div class="card-body">
                                        {!! $faq->details !!}
                                    </div>
                                </div>
                            </div>
                            @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <h5 class="faq-cat-title">Instructors</h5>
                        <h3 class="student-heading btm-40">{{ __('Frequently Asked Question') }}</h3>
                        <div class="accordion" id="instructorAccordion">
                            @php
                                $faqss = App\FaqInstructor::all();
                            @endphp
                            @foreach($faqss as $instructor_key => $faq)
                            @if($faq->status == 1)
                            <div class="card">
                                <div class="card-header" id="instructor_heading{{$faq->id}}">
                                    <h2 class="mb-0">
                                    <button class="btn btn-link btn-block text-left {{ $instructor_key == 0 ? '' : 'collapsed' }}" type="button" data-toggle="collapse" data-target="#instructor_collapse{{$faq->id}}" aria-expanded="{{ $instructor_key == 0 ? 'true' : 'false' }}" aria-controls="instructor_collapse{{$faq->id}}">
                                        {{ $faq->title }}
                                        <i data-feather="chevron-down"></i>
                                    </button>
                                    </h2>
                                </div>                                  
                                <div id="instructor_collapse{{$faq->id}}" class="collapse {{ $instructor_key == 0 ? 'show' : '' }}" aria-labelledby="instructor_heading{{$faq->id}}" data-parent="#instructorAccordion">
                                    <div class="card-body">
                                        {!! $faq->details !!}
                                    </div>
                                </div>
                            </div>
                            @endif
                            @endforeach
                        </div>                             
                    </div>
                </div>
            </div>
            <div class="support-btn text-center mt-5">
                <a href="{{ route('supportuser') }}" class="btn btn-primary" title="{{ __('Create Ticket') }}">{{ __('Create Ticket') }}</a>
            </div>
    </div>
</section>
<!-- help-tab end-->

@endsection

@section('custom-script')
<!-- script to remain on active tab-->
<script>
(function($) {
  "use strict";
  $(document).ready(function(){
    $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
        localStorage.setItem('activeTab', $(e.target).attr('href'));
    });
    var activeTab = localStorage.getItem('activeTab');
    if(activeTab){
        $('#nav-tab a[href="' + activeTab + '"]').tab('show');
    }
  });

})(jQuery);
</script>

@endsection