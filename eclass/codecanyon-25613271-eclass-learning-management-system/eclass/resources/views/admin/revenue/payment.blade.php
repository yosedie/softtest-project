@extends('admin.layouts.master')
@section('title', 'Payment - Instructor')
@section('maincontent')
<?php
$data['heading'] = 'Pay to Instructor';
$data['title'] = 'Pay to Instructor';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar">
  <div class="row">
    <div class="col-xs-12">
      <div class="card dashboard-card m-b-30">
        <div class="card-header">
          <h3 class="box-title">  {{ __('PaytoInstructor') }}</h3>
        </div>
        <div class="card-body">

          <div class="view-order">
            <div class="row">
              <div class="col-md-12">
                <b>{{ __('Instructor') }} </b>:  {{ $user->fname }}
                <br>
                <b>{{ __('TotalInstructorRevenue') }}</b>:  {{ $total }}
                <br>
                
              </div>
            </div>
            <br>
          </div>
          
        @if($user->prefer_pay_method == "paypal")
          <form method="post" action="{{ route('admin.paypal', $user->id) }}" data-parsley-validate class="form-horizontal form-label-left">
              {{ csrf_field() }}

              <input type="hidden" value="{{ $total }}" name="total" class="form-control">
              
              <div class="d-none">
              @foreach($allchecked as $checked)
               <label >
                  <input type="hidden" name="checked[]" value="{{ $checked }}">
                  {{ $checked }}
               </label>
              @endforeach
              </div>
             
              <b>{{ __('PayPalEmail') }}</b>:  {{ $user->paypal_email }}
              <br>
              <br>
               
            <button type="submit" class="btn btn-primary">{{ __('PayWithPaypal') }}</button>
          </form>
        @endif


        @if($user->prefer_pay_method == "banktransfer")
          <form method="post" action="{{ route('admin.banktransfer', $user->id) }}" data-parsley-validate class="form-horizontal form-label-left">
              {{ csrf_field() }}

              <input type="hidden" value="{{ $total }}" name="total" class="form-control">
              
              <div class="d-none">
              @foreach($allchecked as $checked)
               <label >
                  <input type="hidden" name="checked[]" value="{{ $checked }}">
                  {{ $checked }}
               </label>
              @endforeach
              </div>
             
              <b>{{ __('BankTransfer') }}</b>: 

              <ul class="list-group list-group-flush">
                <li class="list-group-item"><b>{{ __('AccountHolderName') }}:</b>&nbsp;{{ $user['bank_acc_name'] }}</li>
                <li class="list-group-item"><b>{{ __('BankName') }}:</b>&nbsp;{{ $user['bank_name'] }}</li>
                <li class="list-group-item"><b>{{ __('IFCSCode') }}</b>:&nbsp;{{ $user['ifsc_code'] }}</li>
                <li class="list-group-item"><b>{{ __('AccountNumber') }}:</b>&nbsp;{{ $user['bank_acc_no'] }}</li>
              </ul>
                 
              <br>
               
            <button type="submit" class="btn btn-primary">{{ __('PaytoInstructor') }}</button>
          </form>
        @endif


        @if($user->prefer_pay_method == "paytm")
          <form method="post" action="{{ route('admin.paytm', $user->id) }}" data-parsley-validate class="form-horizontal form-label-left">
              {{ csrf_field() }}

              <input type="hidden" value="{{ $total }}" name="total" class="form-control">
              
              <div class="d-none">
              @foreach($allchecked as $checked)
               <label >
                  <input type="hidden" name="checked[]" value="{{ $checked }}">
                  {{ $checked }}
               </label>
              @endforeach
              </div>
             
              <b>{{ __('PaytmMobileNo') }}</b>:  {{ $user->paytm_mobile }}
              <p>{{ __('DoManualpaymentpaytm') }}</p>
              <br>
              <br>
               
            <button type="submit" class="btn btn-primary">{{ __('PayWithPaytm') }}</button>
          </form>
        @endif
          
         
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->
</div>

@endsection


