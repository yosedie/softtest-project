@extends('theme.master')
@section('title', 'Terms & Condition')
@section('content')
@include('admin.message')
  <!-- main wrapper -->
@php
$gets = App\Breadcum::first();
@endphp
@if(isset($gets))
<section id="business-home" class="business-home-main-block">
    <div class="business-img">
        @if($gets['img'] !== NULL && $gets['img'] !== '')
        <img src="{{ url('/images/breadcum/'.$gets->img) }}" class="img-fluid" alt="{{$gets->text}}" />
        @else
        <img src="{{ Avatar::create($gets->text)->toBase64() }}" alt="course" class="img-fluid">
        @endif
    </div>
    <div class="overlay-bg"></div>
    <div class="container-xl">
        <div class="business-dtl">
            <div class="row">
                <div class="col-lg-6">
                    <div class="bredcrumb-dtl">
                        <h1 class="wishlist-home-heading">{{ __('Terms & Condition') }}</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif
  <section id="policy-block" class="privacy-policy-block">
    <div class="container-xl">
      <div class="panel-setting-main-block">
        <div class="panel-setting">
          <div class="row">
            <div class="col-md-12"> 
              @php
                $data = App\Terms::first();
              @endphp             
              @if(isset($data))
                <div class="info">{!! $data->terms !!}</div>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- end main wrapper -->
@endsection
