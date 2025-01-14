@extends('theme.master')
@section('title', "$batch->title")
@section('content')
@include('admin.message')
<!-- course detail header start -->
<section id="about-home" class="about-home-main-block">
    <div class="container-xl">
        <div class="row">
            <div class="col-lg-8">
                <div class="about-home-block text-white">
                    <h1 class="about-home-heading text-white">{{ $batch['title'] }}</h1>
                    <ul>
                        <ul>
                            <li><a href="#" title="about">{{ __('Created') }}:
                                    {{ $batch->user['fname'] }} </a></li>
                            <li><a href="#" title="about">{{ __('Last Updated') }}:
                                    {{ date('jS F Y', strtotime($batch['updated_at'])) }}</a></li>
                                </ul>
                </div>
            </div>
            <!-- course preview -->
            <div class="col-lg-4">
                <div class="about-home-product">
                    <div class="video-item hidden-xs">
                        <div class="video-device">
                            @if ($batch['preview_image'] !== null && $batch['preview_image'] !== '')
                                <img src="{{ asset('images/batch/' . $batch['preview_image']) }}"
                                    class="bg_img img-fluid" alt="Background">
                            @else
                                <img src="{{ Avatar::create($batch->title)->toBase64() }}" class="bg_img img-fluid"
                                    alt="Background">
                            @endif

                        </div>
                    </div>
                    <div class="about-home-dtl-training">
                        <div class="about-home-dtl-block btm-10">
                            <div class="about-home-btn btm-20">
                                @if (Auth::check())
                                    <form id="demo-form2" method="post" action="{{ route('batchcart', $batch->id) }}" data-parsley-validate class="form-horizontal form-label-left">
                                            {{ csrf_field() }}
                                                
                                        <div class="box-footer">
                                         <button type="submit" class="btn btn-primary"><i class="fa fa-cart-plus" aria-hidden="true"></i>&nbsp;{{ __('Add To Cart') }}</button>
                                        </div>
                                    </form>
                                @else

                                    <a href="{{ route('login') }}" class="btn btn-primary"><i class="fa fa-cart-plus" aria-hidden="true"></i>&nbsp;{{ __('Add To Cart') }}</a>
                                @endif
                            </div>
                                
                        </div>
                    </div>
                 </div>
            </div>
        </div>
    </div>
</section>
<!-- course header end -->
<!-- course detail start -->
<section id="about-product" class="about-product-main-block">
    <div class="container-xl">
        <div class="row">
            <div class="col-lg-8">
                <div class="requirements">
                    <h3>{{ __('Detail') }}</h3>
                    <ul>
                        <li class="comment more">

                            {!! $batch->detail !!}

                        </li>

                    </ul>
                </div>
                <div class="course-content-block btm-30">
                    <h3>{{ __('Courses In batch') }}</h3>
                    <div class="faq-block">
                        <div class="faq-dtl">
                            <div id="accordion" class="second-accordion">
                                @foreach ($batch->allowed_courses as $batchs)

                                    @php
                                    $course = App\Course::where('id', $batchs)->first();
                                    @endphp

                                    <div class="card">
                                        <div class="card-header" id="headingTwo{{ $course->id }}">
                                            <div class="mb-0">
                                                <button class="btn btn-link" data-toggle="collapse"
                                                    data-target="#collapseTwo{{ $course->id }}" aria-expanded="false"
                                                    aria-controls="collapseTwo">

                                                    <div class="row">
                                                        <div class="col-lg-8 col-6">
                                                            <a href="{{ route('user.course.show', ['slug' => $course->slug]) }}">{{ $course->title }}</a>
                                                        </div>

                                                    </div>

                                                </button>
                                            </div>

                                        </div>

                                        <div id="collapseTwo{{ $course->id }}"
                                            class="collapse {{ $loop->first ? 'show' : '' }}"
                                            aria-labelledby="headingTwo" data-parent="#accordion">

                                            <div class="card-body">
                                                <table class="table">
                                                    <tbody>
                                                        <tr>
                                                            <td class="class-icon">
                                                                {{ $course->short_detail }}
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                    </div>

                                @endforeach
                            </div>
                        </div>
                    </div>

                    @if(isset($batch->allowed_bundles))

                    <h3>{{ __('Bundles In batch') }}</h3>
                    <div class="faq-block">
                        <div class="faq-dtl">
                            <div id="accordion" class="second-accordion">
                                @foreach ($batch->allowed_bundles as $bundles)

                                    @php
                                    $course = App\BundleCourse::where('id', $bundles)->first();
                                    @endphp

                                    <div class="card">
                                        <div class="card-header" id="headingTwo{{ $course->id }}">
                                            <div class="mb-0">
                                                <button class="btn btn-link" data-toggle="collapse"
                                                    data-target="#collapseTwo{{ $course->id }}" aria-expanded="false"
                                                    aria-controls="collapseTwo">

                                                    <div class="row">
                                                        <div class="col-lg-8 col-6">
                                                            <a href="{{ route('user.course.show', ['slug' => $course->slug]) }}">{{ $course->title }}</a>
                                                        </div>

                                                    </div>

                                                </button>
                                            </div>

                                        </div>

                                        <div id="collapseTwo{{ $course->id }}"
                                            class="collapse {{ $loop->first ? 'show' : '' }}"
                                            aria-labelledby="headingTwo" data-parent="#accordion">

                                            <div class="card-body">
                                                <table class="table">
                                                    <tbody>
                                                        <tr>
                                                            <td class="class-icon">
                                                                {{ $course->short_detail }}
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                    </div>

                                @endforeach
                            </div>
                        </div>
                    </div>

                    @endif
                </div>
            </div>
        </div>
    </div>
</section>


<!-- course detail end -->
@endsection
