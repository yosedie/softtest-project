@extends('theme2.master')
@section('title', 'Invoice')
@section('content')

@include('admin.message')

@section('custom-head')
<style type="text/css">
  @if($invoice['border_enable']=='1') .border-one {

    border: 15px {
        {
        $invoice['border_style']
      }
    }

      {
        {
        $invoice['border_color']
      }
    }

    ;
    padding:20px;
    background-color: var(--background-white-bg-color);
    margin-bottom: 40px;

    border-radius: {
        {
        $invoice['border_radius']
      }
    }

    px;

  }

  @endif
</style>

@endsection

<!-- about-home start -->

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
                    <h2>{{__('Invoice')}}</h2>  
                </div>
            </div>
        </div>
        <div class="breadcrumb-wrap2">
              
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">{{__('Home')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{__('Invoice')}}</li>
                </ol>
            </nav>
        </div>
        
    </div>
</div>
</section>
<!-- breadcrumb-area-end -->
<!-- about-home end -->
<section id="purchase-block" class="purchase-main-block">
  <div class="container-xl">
    <div class="panel-body">

      <div id="printableArea">

        <div>
          <!-- title row -->

          <div class="page-header">


            <div class="row">

              <div class="col-md-6">
                <div class="invoice-logo">
                  @if($invoice['logo_enable'] == '1')
                  @if($gsetting['logo_type'] == 'L')
                  <img src="{{ asset('images/logo/'.$gsetting['logo']) }}" class="img-fluid" alt="logo">
                  @else
                  <a href="{{ url('/') }}"><b>
                      <div class="logotext">{{ $gsetting['project_title'] }}
                      </div>
                    </b></a>
                  @endif
                </div>
                @endif
              </div>
              <div class="col-md-6">

                <div class="invoice-sign">

                  @if($invoice['logo_enable'] == '1')
                  @if($invoice->signature != NULL)
                  <img src="{{ asset('images/signature/'.$invoice['signature']) }}" class="img-fluid-invoice" alt="{{ __('logo')}}">
                  @else
                  <a href="{{ url('/') }}"><b>
                      <div class="logotext">{{ $invoice['signature'] }}</div>
                    </b></a>
                  @endif
                  @endif</div>

              </div>


            </div>




            <br>
            @php
            $test = $invoice['date_format'];
            @endphp
            <small class="purchase-date">{{ __('Puchased on') }}:
              {{ date($test, strtotime($orders['created_at'])) }}</small>
          </div>

          <!-- info row -->
          <div class="view-order">
            <div class="row invoice-info">
              <div class="col-sm-4 invoice-col">
                From:
                @if($orders->course_id != NULL)
                <address>
                  <strong>{{ $orders->courses->user['fname'] }}</strong><br>


                  {{ __('address') }}: {{ $orders->courses->user['address'] }}<br>
                  @if($orders->courses->user['state_id'] == !NULL)
                  {{ $orders->courses->user->state['name'] }},
                  @endif
                  @if($orders->courses->user['country_id'] == !NULL)
                  {{ $orders->courses->user->country['name'] }}
                  @endif
                  <br>

                  {{ __('Phone') }}: {{ $orders->courses->user['mobile'] }}<br>
                  {{ __('Email') }}: {{ $orders->courses->user['email'] }}
                </address>
                @else
                <address>
                  <strong>{{ $orders->bundle->user['fname'] }}</strong><br>


                  {{ __('address') }}: {{ $orders->bundle->user['address'] }}<br>
                  @if($orders->bundle->user->state_id == !NULL)
                  {{ $orders->bundle->user->state['name'] }},
                  @endif
                  @if($orders->bundle->user->country_id == !NULL)
                  {{ $orders->bundle->user->country['name'] }}
                  @endif
                  <br>

                  {{ __('Phone') }}: {{ $orders->bundle->user['mobile'] }}<br>
                  {{ __('Email') }}: {{ $orders->bundle->user['email'] }}
                </address>
                @endif
              </div>
              <!-- /.col -->
              <div class="col-sm-4 invoice-col">
                To:
                <address>
                  <strong>{{ $orders->user['fname'] }}</strong><br>
                  {{ __('address') }}: {{ $orders->user['address'] }}<br>
                  @if($orders->user->state_id == !NULL)
                  {{ $orders->user->state['name'] }},
                  @endif
                  @if($orders->user->country_id == !NULL)
                  {{ $orders->user->country['name'] }}
                  @endif
                  <br>
                  {{ __('Phone') }}: {{ $orders->user['mobile'] }}<br>
                  {{ __('Email') }}: {{ $orders->user['email'] }}
                </address>
              </div>
              <!-- /.col -->
              <div class="col-sm-4 invoice-col">

                <br>
                <b>{{ __('OrderID') }}:</b> {{ $orders['order_id'] }}<br>
                <b>{{ __('TransactionID') }}:</b> {{ $orders['transaction_id'] }}<br>
                <b>{{ __('Payment Mode') }}:</b> {{ $orders['payment_method'] }}<br>
                <b>{{ __('Currency') }}:</b> {{ $orders['currency'] }}</br>
                <b>{{ __('Payment Status') }}:</b>
                @if($orders->status ==1)
                {{ __('Recieved') }}
                @else
                {{ __('Pending') }}
                @endif
                </br>
                <b>{{ __('Enroll on') }}:</b> {{ date('jS F Y', strtotime($orders['created_at'])) }}</br>
                <b>
                  @if($orders->enroll_expire != NULL)
                  {{ __('Enroll End') }}:</b>
                {{ date('jS F Y', strtotime($orders['enroll_expire'])) }}</br>
                @endif
              </div>
              <!-- /.col -->
            </div>
          </div>
          <!-- /.row -->
          <div class="order-table table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>{{ __('Courses') }}</th>
                  <th>{{ __('Instructor') }}</th>
                  <th>{{ __('Currency') }}</th>
                  @if($orders->coupon_discount != 0)
                  <th class="text-center">Coupon Discount</th>
                  @endif
                  <th class="txt-rgt">{{ __('Total') }}</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  @if($orders->course_id != NULL)
                  <td>{{ $orders->courses['title'] }}</td>
                  <td>{{ $orders->courses->user['email'] }}</td>
                  @else
                  <td>{{ $orders->bundle['title'] }}</td>
                  <td>{{ $orders->bundle->user['email'] }}</td>
                  @endif


                  <td>{{ $orders['currency'] }}</td>

                  @php
                  $contains = Illuminate\Support\Str::contains($orders->currency_icon, 'fa');
                  @endphp

                  @if($orders->coupon_discount != 0)
                  @if($contains)
                  <td class="text-center">
                    (-)&nbsp;<i class="{{ $orders['currency_icon'] }}"></i>{{ $orders['coupon_discount'] }}
                  </td>
                  @else
                  <td class="text-center">
                    (-)&nbsp;{{ $orders['currency_icon'] }} {{ $orders['coupon_discount'] }}
                  </td>
                  @endif

                  @endif

                  <td class="txt-rgt">
                    @if($orders->coupon_discount == !NULL)
                    @if($contains)
                    <i
                      class="fa {{ $orders['currency_icon'] }}"></i>{{ $orders['total_amount'] - $orders['coupon_discount'] }}
                    @else
                    {{ $orders['currency_icon'] }} {{ $orders['total_amount'] - $orders['coupon_discount'] }}
                    @endif
                    @else
                    @if($contains)
                    <i class="fa {{ $orders['currency_icon'] }}"></i>{{ $orders['total_amount'] }}
                    @else
                    {{ $orders['currency_icon'] }} {{ $orders['total_amount'] }}
                    @endif
                    @endif
                  </td>

                </tr>
              </tbody>
            </table>
          </div>

          @if($orders->bundle_id != NULL)

          @foreach($bundle_order->course_id as $bundle_course)
          @php
          $coursess = App\Course::where('id', $bundle_course)->first();
          @endphp

          <div class="purchase-table table-responsive">
            <table class="table">

              <tbody>
                <tr>
                  <td>
                    <div class="purchase-history-course-img">

                      @if($coursess['preview_image'] !== NULL && $coursess['preview_image'] !== '')
                      <a href="{{ route('course.content',['slug' => $coursess->slug ]) }}"><img
                          src="{{ asset('images/course/'. $coursess->preview_image) }}" class="img-fluid"
                          alt="course"></a>
                      @else
                      <a href="{{ route('course.content',['slug' => $coursess->slug ]) }}"><img
                          src="{{ Avatar::create($coursess->title)->toBase64() }}" class="img-fluid" alt="course"></a>
                      @endif

                    </div>
                    <div class="purchase-history-course-title">
                      <a
                        href="{{ route('course.content',['slug' => $coursess->slug ]) }}">{{ $coursess->title }}</a>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          @endforeach

          @endif

        </div>
      </div>
      <div class="print-btn">
        <input type="button" class="btn btn-primary" onclick="printDiv('printableArea')" value="Print" />
      </div>

      <div class="print-btn">
        <a href="{{route('invoice.download',$orders->id)}}" target="_blank"
          class="btn btn-secondary">{{ __('Download') }}</a>
      </div>

    </div>
  </div>
</section>

@endsection

@section('custom-script')

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