@extends('theme.master')
@section('title', 'Batch')
@section('content')
@include('admin.message')
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
    <div class="container-fluid">
        <div class="business-dtl">
            <div class="row">
                <div class="col-lg-6">
                    <div class="bredcrumb-dtl">
                        @foreach($data as $datas)
                        <h1 class="wishlist-home-heading">{{$datas->title }}</h1>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif
<section id="batch-dtl" class="batch-dtl-main-block">
    <div class="container-xl">
        <div class="batch-dtl-block">
            <div class="row">
                @foreach($data as $datas)
                <div class="col-lg-4">
                    <div class="batch-dtl-img">
                        <img src="{{ asset('images/batch/'.$datas->preview_image) }}" class="img-fluid" alt="{{ $datas->courses->title }}">
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="batch-detail-block">
                        <h4 class="batch-dtl-title mb-3">{{ $datas->courses->title }}</h4>
                        <div class="user-name mb-2">
                            <div class="user-title">{{ __('Enrolled User ') }}</div>
                            <ul>
                               
                                @foreach($datas['allowed_users'] as $key => $Uid)
                                
                                <li> <a href ="{{ route('all/profile',$Uid) }}">{{ App\User::whereId($Uid)->value('fname') }}</a></li>
                                @endforeach
                               
                            </ul>
                        </div>
                        <p>{{ $datas->detail }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endsection