@extends('admin.layouts.master')
@section('title','View Order')
@section('maincontent')
<?php
$data['heading'] = 'View Order';
$data['title'] = 'Orders';
$data['title1'] = 'View Order';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar">                
  <!-- End row -->
  <div class="row">
      <!-- Start col -->
      <div class="col-md-12 col-lg-12 col-xl-12">
          <div class="card dashboard-card m-b-30">
              <div class="card-body">
                  <div class="invoice">
                      <div class="invoice-head">
                          <div class="row">
                              <div class="col-12 col-md-7 col-lg-7">
                                @if($setting->logo_type == 'L')
                                <div class="logo-invoice">
                                  <img src="{{ asset('images/logo/'.$setting->logo) }}" style="height:50px">
                                </div>
                              @else()
                                  <a href="{{ url('/') }}"><b><div class="logotext" >{{ $setting->project_title }}</div></b></a>
                              @endif
                                 
                              </div>
                              <div class="col-12 col-md-5 col-lg-5">
                                  <div class="invoice-name">
                                      <h5 class="text-uppercase mb-3">{{ __('Invoice') }}</h5>
                                      <small>{{ __('Date') }}:&nbsp;{{ date('jS F Y', strtotime($show['created_at'])) }}</small>
                                     
                                  </div>
                              </div>
                          </div>
                      </div> 


                    
                      <div class="invoice-billing">
                          <div class="row">
                              <div class="col-sm-6 col-md-4 col-lg-4">
                                  <div class="invoice-address">
                                    {{ __('From') }}:
                                    @if($show->course_id != NULL)
                                    
                                      <h6 >{{ $show->courses->user['fname'] }}</h6>
                                      <ul class="list-unstyled">
                                          <li> {{ __('Address') }}: {{ $show->courses->user['address'] }}</li>  
                                          @if($show->courses->user['state_id'] == !NULL)
                                            {{ $show->courses->user->state['name'] }},
                                            @endif
                                            @if($show->courses->user['country_id'] == !NULL)
                                              {{ $show->courses->user->country['name'] }}
                                            @endif
                                          <li>{{ $show->courses->user['mobile'] }}</li>  
                                          <li> {{ $show->courses->user['email'] }}</li>  
                                      </ul>
                                      @else
                                     
                                      <h6>{{ $show->bundle->user['fname'] }}</h6>
                                      <ul class="list-unstyled">
                                          <li> {{ __('Back') }}Address: {{ $show->bundle->user['address'] }}</li>  
                                          @if($show->bundle->user->state_id == !NULL)
                                            {{ $show->bundle->user->state['name'] }},
                                          @endif
                                          @if($show->bundle->user->state_id == !NULL)
                                            {{ $show->bundle->user->country['name'] }}
                                          @endif
                                          <li> {{ $show->bundle->user['mobile'] }}</li>  
                                          <li> {{ $show->bundle->user['email'] }}</li>  
                                      </ul>
                                      @endif
                                  </div>
                              </div>
                              <div class="col-sm-6 col-md-4 col-lg-4">

                                  <div class="invoice-address">
                                    {{ __('To') }}:
                                    @if(Auth::user()->role == "admin")
                                    <h6> {{$show->user['fname'] }} {{$show->user['lname']}}</h6>
                                    @else
                                    @if($gsetting->hide_identity == 0)
                                    <h6> {{$show->user['fname'] }} {{$show->user['lname']}}</h6>
                                    @else
                                    {{ __('Hidden') }}
                                    @endif
                                  @endif
                                   
                                    
                                   
                                      <ul class="list-unstyled">

                                          <li><b>{{ __('Address') }}:</b> {{ $show->user['address'] }}<br>
                                          @if($show->user['state_id'] == !NULL)
                                           {{ $show->user->state['name'] }},
                                          @endif
                                          @if($show->user['country_id'] == !NULL)
                                          {{ $show->user->country['name'] }}</li>
                                          @endif
                                          
                                          @if(Auth::user()->role == "admin")
                                          <li>{{ $show->user['mobile'] }}
                                            </li>
                                          @else
                                            @if($gsetting->hide_identity == 0)
                                            <li>{{ $show->user['mobile'] }}</li>
                                            @else
                                              {{ __('Hidden') }}
                                            @endif
                                          @endif

                                          @if(Auth::user()->role == "admin")
                                          <li>{{ $show->user['email'] }}</li>
                                          @else
                                            @if($gsetting->hide_identity == 0)
                                            <li>{{ $show->user['email'] }}</li>
                                            @else
                                              {{ __('Hidden') }}
                                            @endif
                                          @endif
                                          
                                      </ul>
                                      
                                  </div>
                              </div>
                              <div class="col-sm-12 col-md-4 col-lg-4 mt-3">
                                
                                <b>{{ __('Order ID') }}:</b> {{ $show['order_id'] }}<br>
                                <b>{{ __('Transaction ID') }}:</b>&nbsp;{{ $show['transaction_id'] }}<br>
                                <b>{{ __('Payment Method') }}:</b>&nbsp;{{ $show['payment_method'] }}<br>
                                <b>{{ __('Currency') }}:</b>&nbsp;{{ $show['currency'] }}
                                <b>{{ __('Payment Status') }}:</b> 
                                @if($show->status ==1)
                                  {{ __('Received') }}
                                @else 
                                  {{ __('Pending') }}
                                @endif
                                </br>
                                <b>{{ __('Enroll On') }}:</b> {{ date('jS F Y', strtotime($show['created_at'])) }}</br>
                                <b>
                                  @if($show->enroll_expire != NULL)
                                    {{ __('Enroll Expire') }}:</b> {{ date('jS F Y', strtotime($show['enroll_expire'])) }}</br>
                                  @endif
                                  <br>
          
                                  @if($show->proof != NULL)
                                     <a href="{{ asset('images/order/'.$show->proof) }}" download="{{$show->proof}}" title="{{ __('Download Proof') }}">{{ __('Download Proof') }} <i class="fa fa-download"></i></a></br>
                                  @endif
                              
                              </div>
                              </div>
                          </div>
                      </div>  
                      <div class="invoice-summary">
                          <div class="table-responsive ">
                              <table class="table table-borderless">
                                  <thead>
                                      <tr>
                                        <th>{{ __('Course Name') }}</th>
                                        <th>{{ __('Instructor Name') }}</th>
                                        <th>{{ __('Currency') }}</th>
                                        @if($show->coupon_discount != 0)
                                        <th>{{ __('Coupon Discount') }}</th>
                                        @endif
                                        <th>{{ __('Total Amount') }}</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      <tr>
                                        <td>
                                          @if($show->course_id != NULL)
                                            {{ $show->courses['title'] }}
                                          @else
                                            {{ $show->bundle['title'] }}
                                          @endif
                                        </td>
                                        <td>
                                          @if($show->course_id != NULL)
                                            {{ $show->courses->user['email'] }}
                                          @else
                                            {{ $show->bundle->user['email'] }}
                                          @endif
                                        </td>
                                        <td>{{ $show['currency'] }}</td>

                                        @php
                                            $contains = Illuminate\Support\Str::contains($show->currency_icon, 'fa');
                                        @endphp
                  
                                        @if($show->coupon_discount != 0)
                                        <td>
                                          @if($contains)
                                            (-)&nbsp;<i class="{{ $show['currency_icon'] }}"></i>{{ $show['coupon_discount'] }}
                  
                                          @else
                  
                                            (-)&nbsp;{{ $show['currency_icon'] }} {{ $show['coupon_discount'] }}
                                          @endif
                                        </td>
                                        @endif
                  
                                        <td>
                                          @if($show->coupon_discount == !NULL)
                                            @if($contains)
                                              <i class="fa {{ $show['currency_icon'] }}"></i>{{ $show['total_amount'] - $show['coupon_discount'] }}
                                            @else
                                              {{ $show['currency_icon'] }} {{ $show['total_amount'] - $show['coupon_discount'] }}<i class="fa "></i>
                                            @endif
                                          @else
                                            @if($contains)
                                              <i class="fa {{ $show['currency_icon'] }}"></i>{{ $show['total_amount'] }}
                  
                                            @else
                                              {{ $show['currency_icon'] }} {{ $show['total_amount'] }}
                                            @endif
                                          @endif
                                        </td>
                                      </tr>
                                      
                                  </tbody>
                              </table>
                          </div>
                      </div>
                      <div class="invoice-summary-total">
                          <div class="row">
                              <div class="col-md-12">
                                  <div class="order-note">
                                    @if($show->bundle_id != NULL)

                                    @foreach($bundle_order->course_id as $bundle_course)
                                        @php
                                          $coursess = App\Course::where('id', $bundle_course)->first();
                                        @endphp
                    
                                        <div class="mt-3">
                                         
                                                  <div class="row">
                                                      <div class="col-md-2">
                                                    
                                                        @if($coursess['preview_image'] !== NULL && $coursess['preview_image'] !== '')
                                                            <img src="{{ asset('images/course/'. $coursess->preview_image) }}" class="img-fluid" alt="course" style="height:70px; width:70px; border-radius:50%">
                                                        @else
                                                            <img src="{{ Avatar::create($coursess->title)->toBase64() }}" class="img-fluid" alt="course">
                                                        @endif
                      
                                                    </div>
                                                    <div  class="col-md-6 mt-4">
                                                      {{ $coursess->title }}
                                                    </div>
                                                  </div>
                                                 
                                               
                                        </div>
                                    @endforeach
                    
                                  @endif
                                  </div>
                              </div>
                             
                          </div>
                      </div> 
                      <div class="invoice-footer mt-4">
                          <div class="row align-items-center">
                             
                              <div class="col-md-6">
                                  <div class="invoice-footer-btn">
                                      <a href="javascript:window.print()" class="btn btn-primary-rgba py-1 font-16" title="{{ __('Print') }}"><i class="feather icon-printer mr-2"></i>{{ __('Print') }}</a>
                                     
                                  </div>
                              </div>
                          </div>
                      </div>                                   
                  </div>
              </div>
          </div>
      </div>
      <!-- End col -->
  </div>
  <!-- End row -->
</div>
@endsection
@section('script')

<script>
    $(document).ready(function() {
      $('.js-example-basic-single').select2();
    });
</script>

<script lang='javascript'>
    function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
  }
</script>
@endsection