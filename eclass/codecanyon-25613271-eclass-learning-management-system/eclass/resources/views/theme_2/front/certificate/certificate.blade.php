@extends('theme2.master')
@section('title', "Course Completion Certificate")
@section('content')
@include('admin.message')

<section id="cirtificate" class="course-cirtificate">
    <div class="container-xl">
        <div class="row">
            <div class="col-lg-9 col-md-9">
                <div id="printableArea" class="certificate-responsive">
                    @if(Module::has('Certificate') && Module::find('Certificate')->isEnabled())
                        @include('certificate::front.certificate_view')
                    @else
                    <div class="cirtificate-border-one text-center free-certificate">
                        <div class="cirtificate-border-two">
                            <div class="cirtificate-heading">{{ __('Certificate of Completion') }}</div>
                            @php
                                $mytime = Carbon\Carbon::now();
                                $courses = $course->title;
                            @endphp
                            <p class="cirtificate-detail" style="font-size:30px">
                                {{ __('This is to certify that') }} <b>{{ $progress->user['fname'] }} {{ $progress->user['lname'] }}</b>
                                {{ __('successfully completed') }} <b>{{ $course['title'] }}</b>
                                {{ __('online course on') }}<br>
                                <span style="font-size:25px">{{ date('jS F Y', strtotime($progress['updated_at'])) }}</span>
                            </p>
                
                            <span class="cirtificate-instructor">{{ ($course->user['fname']) }} {{ ($course->user['lname']) }}</span>
                            <br>
                            <span class="cirtificate-one">{{ ($course->user['fname']) }} {{ ($course->user['lname']) }}, {{ __('Instructor') }}</span>
                            <br>
                            <span>&</span>
                            <div class="cirtificate-logo">
                                @if($gsetting['logo_type'] == 'L')
                                    <img src="{{ asset('images/logo/'.$gsetting['logo']) }}" class="img-fluid" alt="{{ __('logo') }}">
                                @else
                                    <a href="{{ url('/') }}">
                                        <b><div class="logotext">{{ $gsetting['project_title'] }}</div></b>
                                    </a>
                                @endif
                            </div>
                
                            <div class="cirtificate-serial">{{ __('Certificate no.') }} :{{ $serial_no }}</div>
                            <div class="cirtificate-serial">{{ __('Certificate url.') }} :{{ url()->full() }}</div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            <div class="col-lg-3 col-md-3">
                <h4>{{ __('Certificate Recipient') }}:</h4>
                <div class="recipient-block">
                    <div class="row">
                        <div class="col-md-4 col-4">
            
                            @if($progress->user->user_img != null || $progress->user->user_img !='')
                                <img src="{{ asset('images/user_img/'.$progress->user->user_img) }}" alt="{{ __('user')}}" class="img-fluid img-circle">
                            @else
                                <img src="{{ asset('images/default/user.jpg')}}" alt="{{ __('user')}}" class="img-fluid img-circle">
                            @endif
                        </div>
                        <div class="col-md-8 col-8">
                            {{ $progress->user->fname }}
                        </div>
                    </div>
                </div>

                <h4>{{ __('About the Course') }}:</h4>
                <div class="courses-item mb-30 hover-zoomin ms-0 me-0 protip">
                    <div class="thumb fix ">
                        <a href="#" tabindex="0"><img src="{{ asset('images/course/'.$course['preview_image']) }}" alt="contact-bg-an-01" class="img-fluid"></a>   
                        <div class="courses-icon">
                            <ul>
                                <li class="protip-wish-btn"><a href="#" target="__blank" title="reminder" tabindex="0"></a><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg></li>
                                <li class="protip-wish-btn"><a href="#" title="heart" tabindex="0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-heart"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg></a></li>
                                <li class="protip-wish-btn"><a href="#" title="compare" tabindex="0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bar-chart"><line x1="12" y1="20" x2="12" y2="10"></line><line x1="18" y1="20" x2="18" y2="4"></line><line x1="6" y1="20" x2="6" y2="16"></line></svg></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="badges bg-priamry offer-badge"><span>OFF<span>44%</span></span></div>
                    <div class="courses-content">    
                        <div class="view-user-img">
                            <a href="#" title="Jordan" tabindex="0">
                                <img src="{{ asset('images/user_img/'.$course->user->user_img) }}" class="img-fluid user-img-one" alt="{{ $course->user->fname}}">
                            </a>                   
                        </div>                                
                        <div class="cat">
                            <div class="rate text-right">
                                <ul>
                                    <li><a tabindex="0"><b>899,00 $</b></a></li>
                                    <li><a tabindex="0"><b><strike>1 600,00$</strike></b></a></li>
                                </ul>
                            </div>
                        </div>
                        <h3><a href="#" tabindex="0">  Software</a></h3>
                        <p>Artificial Intelligence is finally here and most of us are already act...
                            <a href="#" class="readmore" tabindex="0">Read More <i class="fal fa-long-arrow-right"></i></a>
                        </p>
                    </div>
                    <div class="icon">
                        <img src="{{ asset('frontcss/img/icon/cou-icon.png')}}" alt="img">
                    </div>
                </div>
                <div class="download-btn mb-20">
                    <?php
                            
                        $parameter= Crypt::encrypt($course->id);
                    ?>

                    @php
                    $random = $progress->id.'CR-'.uniqid();
                    @endphp

                    @if(Module::has('Certificate') && Module::find('Certificate')->isEnabled())
                        @include('certificate::front.download_link')

                    @else

                    <a href="javascript:void(0);" onclick="printDiv('printableArea')" target="_blank" class="btn btn-secondary">{{ __('Print Certificate') }}</a>

                    @endif
                </div>
                @auth
                <p><a href="#" data-toggle="modal" data-target="#myModalCirtificate" title="{{ __('report')}}">{{ __('Updateyourcertificate') }}</a> {{ __('with your correct name') }}.</p>
                <div class="modal fade" id="myModalCirtificate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog modal-lg" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title" id="myModalLabel">{{ __('Update You Certificate') }}</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        
                        <div class="box box-primary">
                          <div class="panel panel-sum">
                            <div class="modal-body">
                                 {{ __('Confirm your name is') }} <b>{{ Auth::User()->fname }}</b>
                                <br>

                                 {{ __('Incorrect') }}? <a href="{{route('profile.show',Auth::User()->id)}}">{{ __('Update your profile name') }}</a>.
                           
                            </div>
                          </div>
                        </div>
                        
                      </div>
                    </div> 
                </div>
                @endauth
            </div>
        </div>
    </div>
</section>
<style>

    .free-certificate {
        height: auto !important;
    }
    .free-certificate .cirtificate-border-two {
        height: auto !important;
        padding: 60px !important;
    }
</style>
<style>
    @media print{
        body * {
      visibility: hidden;
    }
    .free-certificate {
        height: auto !important;
    }
    .free-certificate .cirtificate-border-two {
        height: auto !important;
        padding: 60px !important;
    }
    }
</style>
<script>
    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;
    
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
    </script>
@endsection