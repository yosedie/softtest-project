<!DOCTYPE html>
<!--
**********************************************************************************************************
    Copyright (c) 2019.
**********************************************************************************************************  -->
<!-- 
Template Name: eClass
Author: Media City
-->
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]> -->
<?php
$language = Session::get('changed_language'); //or 'english' //set the system language
$rtl = array('ar','he','ur', 'arc', 'az', 'dv', 'ku', 'fa'); //make a list of rtl languages
?>

<html lang="en" @if (in_array($language,$rtl)) dir="rtl" @endif>
<!-- <![endif]-->
<!-- head -->

<head>
  <link href="{{ url('css/style.css') }}" rel="stylesheet" type="text/css" /> <!-- custom css -->

  <style>
    * {
      font-family: DejaVu Sans, sans-serif;
    }

    .invoiceheading {
      font-size: 30px;
      margin-bottom: 40px;
    }

    .invoice-col {
      text-align: -webkit-left !important;
    }

    .table {
      width: 100% !important;
      max-width: 100% !important;
      margin-bottom: 1rem;
      background-color: transparent;
    }

    .view-order {
      margin-bottom: 20px;
      color: #29303B !important;
    }


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
  <!-- end theme styles -->
</head>
<!-- end head -->
<!-- body start-->

<body>
  <!-- terms end-->
  <!-- about-home start -->
  <section id="wishlist-home" class="invoice-home-main-block">
    <div class="container-xl">
      <div class="invoiceheading">{{ __('Invoice') }}</div>
    </div>
  </section>
  <!-- about-home end -->
  <section id="purchase-block" class="Invoice-main-block">
    <div class="container-xl">
      <div class="panel-body">

        <div class="border-one">

          <!-- title row -->
          <div class="row">
            <div class="col-xs-12">
              <div class="page-header">
                @php
                $setting = App\setting::first();
                @endphp

                <div class="row">

                  <div class="col-md-6">
                    <div class="invoice-logo">
                      @if($invoice['logo_enable'] == '1')
                      @if($setting['logo_type'] == 'L')
                    <img src="{{ asset('images/logo/'.$setting['logo']) }}" class="img-fluid" width="150px" alt="logo">
                      @else()
                      <a href="{{ url('/') }}"><b>
                          <div class="logotext">{{ $setting['project_title'] }}</div>
                        </b></a>
                      @endif
                      @endif
                    </div>
                  </div>
                  <div class="col-md-6">

                    <div class="invoice-sign">

                      @if($invoice['logo_enable'] == '1')
                      @if($invoice->signature != NULL)
                      <img src="{{ asset('images/signature/'.$invoice['signature']) }}" class="img-fluid-invoice"
                        alt="logo" width="70px" height="70px" style="margin-top:-50px;">
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
                <small class="purchase-date">{{ __('Purchased on') }}:
                  {{ date($test, strtotime($orders['created_at'])) }}</small>
              </div>
            </div>
            <!-- /.col -->
          </div>
          <!-- info row -->
          <div class="view-order">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th class="col-sm-4 invoice-col">
                    From:
                    @if($orders->course_id != NULL)

                    <strong>{{ $orders->courses->user['fname'] }}</strong><br>
                    {{ __('address') }}: {{ $orders->courses->user['address'] }}<br>
                    @if($orders->courses->user->state_id == !NULL)
                    {{ $orders->courses->user->state['name'] }},
                    @endif
                    @if($orders->courses->user->country_id == !NULL)
                    {{ $orders->courses->user->country['name'] }}
                    @endif
                    <br>

                    {{ __('Phone') }}: {{ $orders->courses->user['mobile'] }}<br>
                    {{ __('Email') }}: {{ $orders->courses->user['email'] }}

                    @else

                    <strong>{{ $orders->bundle->user['fname'] }}</strong><br>


                    {{ __('address') }}: {{ $orders->bundle->user['address'] }}<br>
                    @if($orders->bundle->user->state_id == !NULL)
                    {{ $orders->bundle->user->state['name'] }},
                    @endif
                    @if($orders->bundle->user->state_id == !NULL)
                    {{ $orders->bundle->user->country['name'] }}
                    @endif
                    <br>

                    {{ __('Phone') }}: {{ $orders->bundle->user['mobile'] }}<br>
                    {{ __('Email') }}: {{ $orders->bundle->user['email'] }}

                    @endif
                  </th>
                  <!-- /.col -->
                  <th class="col-sm-4 invoice-col">
                    To:

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

                  </th>
                  <!-- /.col -->
                  <th class="col-sm-4 invoice-col">
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
                  </th>
                </tr>
              </thead>
            </table>

          </div>
          <!-- /.row -->
          <div class="order-table table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th class="invoice-col">{{ __('Courses') }}</th>
                  <th class="invoice-col">{{ __('Instructor') }}</th>
                  <th class="invoice-col">{{ __('Currency') }}</th>
                  @if($orders->coupon_discount != 0)
                  <th class="text-center invoice-col">Coupon Discount</th>
                  @endif
                  <th class="txt-rgt invoice-col">{{ __('Total') }}</th>
                </tr>
              </thead>
              <tbody>
                <tr class="view-order">
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
                  <td class="text-center">
                    (-)&nbsp; @if($contains) <i class="{{ $orders['currency_icon'] }}"></i>
                    @else {{ $orders['currency_icon'] }} @endif {{ $orders['coupon_discount'] }}
                  </td>
                  @endif

                  <td class="txt-rgt">
                    @if($orders->coupon_discount == !NULL)
                    @if($contains) <i class="fa {{ $orders['currency_icon'] }}"></i> @else
                    {{ $orders['currency_icon'] }} @endif{{ $orders['total_amount'] - $orders['coupon_discount'] }}
                    @else
                    @if($contains) <i class="fa {{ $orders['currency_icon'] }}"></i> @else
                    {{ $orders['currency_icon'] }} @endif{{ $orders['total_amount'] }}
                    @endif
                  </td>

                </tr>
              </tbody>
            </table>

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
                        <a
                          href="{{ route('course.content',['slug' => $orders->bundle->slug ]) }}"><img
                            src="{{ asset('images/course/'. $coursess->preview_image) }}" class="img-fluid"
                            alt="course"></a>
                        @else
                        <a
                          href="{{ route('course.content',['slug' => $orders->bundle->slug ]) }}"><img
                            src="{{ Avatar::create($coursess->title)->toBase64() }}" class="img-fluid" alt="{{ __('course')}}"></a>
                        @endif

                      </div>
                      <div class="purchase-history-course-title">
                        <a
                          href="{{ route('course.content',['slug' => $orders->bundle->slug ]) }}">{{ $coursess->title }}</a>
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

      </div>
    </div>
  </section>
  <!-- footer start -->

  <!-- footer end -->
  <!-- jquery -->
  <script src="{{ url('js/jquery-2.min.js') }}"></script> <!-- jquery library js -->
  <script src="{{ url('js/bootstrap.bundle.js') }}"></script> <!-- bootstrap js -->
  <!-- end jquery -->
</body>
<!-- body end -->

</html>