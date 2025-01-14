<!-- Affiliate Refferal section start -->
@extends('theme2.master')
@section('title', 'Refer Link')
@section('content')
@include('admin.message')
@php
$gets = App\Breadcum::first();
@endphp

@if($gets['img'] !== NULL && $gets['img'] !== '')
<section class="breadcrumb-area d-flex  p-relative align-items-center" style="background-image: url('{{ asset('/images/breadcum/'.$gets->img) }}')">
@else
<section class="breadcrumb-area d-flex  p-relative align-items-center" style="background-image: url('{{ asset('Avatar::create($gets->text)->toBase64() ') }}')">
@endif
<div class="overlay-bg"></div>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-xl-12 col-lg-12">
                <div class="breadcrumb-wrap text-left">
                    <div class="breadcrumb-title">
                        <h2>{{ __('Affiliate Dashboard') }}</h2>    
                        
                    </div>
                </div>
            </div>
            <div class="breadcrumb-wrap2">
                  
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">{{__('Home')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{__('Affiliate Dashboard')}}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>
<section id="affiliate-dashboard" class="affiliate-dashboard-main-block">
    <div class="container-xl">
        <div class="row">
            <div class="col-lg-12">
                <div class="affiliate-dashboard-card">
                    <div class="card-body">
                        <h3 class="card-title text-center mb-3">
                            {{__('Start referring your friends and start earning !!')}}'
                        </h3>
                        <p class="card-text text-center mb-4">
                            {{__('This is your unique refer link share with your friends and family and start earning !')}}'
                        </p>
                        <div class="input-group mb-3">
                            <input type="text" id="myInput" class="form-control" value="{{ url('/register') . '/?ref=' . Auth::user()->affiliate_id }}">
                            <div class="input-group-append refer-btn">
                                <button onclick="myFunction()" class="btn btn-primary" type="button"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-copy"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="qr-code-block">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="qr-code-title">{{__('Simple QR Code')}}</h2>
                        </div>
                        <div class="card-body">
                            <!--?xml version="1.0" encoding="UTF-8"?-->
                        <?php 
                        $path= url('/register') . '/?ref=' . Auth::user()->affiliate_id;
                        ?>

                    {!! QrCode::size(200)->generate($path) !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="affiliate-dashboard-wallet">
                    <h4 class="title">{{__('Wallet')}}</h4>
                    <div class="row mt-4">
                        <div class="col-lg-4 col-3">  
                            <div class="affiliate-dashboard-wallet-img">
                                <img src="https://eclass.mediacity.co.in/demo/public/images/wallet.png" class="img-fluid" alt="{{ __('wallet')}}">
                            </div>
                        </div>
                        <div class="col-lg-8 col-9">
                            <div class="affiliate-dashboard-wallet-dtl">
                                <h6>{{__('Total Balance')}}</h6>
                                <p class="wallet-balance">0</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>            
        </div>
    </div>
</section>
@endsection

@section('custom-script')

<script>
    var speedCanvas = document.getElementById("myChart");

Chart.defaults.global.defaultFontFamily = "Lato";
Chart.defaults.global.defaultFontSize = 18;

var dataFirst = {
    label: "Car A - Speed (mph)",
    data: [0, 59, 75, 20, 20, 55, 40],
    lineTension: 0,
    fill: false,
    borderColor: 'rgb(244, 74, 74)'
  };

var dataSecond = {
    label: "Car B - Speed (mph)",
    data: [20, 15, 60, 60, 65, 30, 70],
    lineTension: 0,
    fill: false,
  borderColor: 'rgb(2, 132, 162)'
  };

var speedData = {
  labels: ["0s", "10s", "20s", "30s", "40s", "50s", "60s"],
  datasets: [dataFirst, dataSecond]
};

var chartOptions = {
  legend: {
    display: true,
    position: 'top',
    labels: {
      boxWidth: 80,
      fontColor: 'black'
    }
  }
};

var lineChart = new Chart(speedCanvas, {
  type: 'line',
  data: speedData,
  options: chartOptions
});
</script>
@endsection