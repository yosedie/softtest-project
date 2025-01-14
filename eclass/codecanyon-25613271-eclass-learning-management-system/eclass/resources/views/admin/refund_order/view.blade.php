@extends('admin.layouts.master')
@section('title','View Refund Request')
@section('maincontent')
<?php
$data['heading'] = 'View Refund Request';
$data['title'] = 'Orders';
$data['title1'] = 'View Refund Request';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar"> 
  <div class="row">
      <div class="col-lg-12">
          <div class="card dashboard-card m-b-30">
              <div class="card-header">
                  <h5 class="box-title"> {{ __('Order ID') }} - {!! $refunds->order->order_id !!}</h5>
              </div>
              <div class="card-body">
                <div class="card-body py-5">
                  <div class="row">
                      <div class="col-lg-3 text-center">
                        <img src="{{ asset('images/course/'.$refunds->courses->preview_image) }}" class="img-circle"/>
                      </div>
                      <div class="col-lg-9">
                          <h4>{{ $refunds->user->fname }} {{ $refunds->user->lname }}</h4>
                          <p>{{ $refunds->user->email }}</p>
                         
                          <div class="table-responsive">
                              <table class="table table-borderless mb-0">
                                  <tbody>
                                      <tr>
                                          <th scope="row" class="p-1">{{ __('Order ID') }} :</th>
                                          <td class="p-1">{{ $refunds->order->order_id }}</td>
                                      </tr>
                                      <tr>
                                          <th scope="row" class="p-1">{{ __('Course') }} :</th>
                                          <td class="p-1">{{ $refunds->courses->title }}</td>
                                      </tr>
                                      <tr>
                                          <th scope="row" class="p-1">{{ __('Payment Method') }} :</th>
                                          <td class="p-1">{{ $refunds->payment_method }}</td>
                                      </tr>
                                      <tr>
                                          <th scope="row" class="p-1">{{ __('Total Amount') }} :</th>
                                          <td class="p-1">{{ $refunds->total_amount }}</td>
                                      </tr>
                                      <tr>
                                        <th scope="row" class="p-1">{{ __('Reason') }} :</th>
                                        <td class="p-1">{{ $refunds->reason }}</td>
                                    </tr>
                                    <tr>
                                      <th scope="row" class="p-1">{{ __('Details') }} :</th>
                                      <td class="p-1">{{ $refunds->detail }}</td>
                                  </tr>
                                  </tbody>
                              </table>
                          </div>
                          @if($refunds->bank_id == !NULL)
                          @php
              
                          $user_detail = App\UserBankDetail::where('id', $refunds->bank_id)->first()
              
                          @endphp
              
                          <h3 class="box-title"> {{ __('BankDetail') }}</h3>
              
                          <div class="view-instructor">
                            <div class="instructor-detail">
                              <ul>
                                <li>{{ __('User') }}: {{ $user_detail->user->fname }} </li>
                                <li>{{ __('Account Holder Name') }}: {{ $user_detail->account_holder_name }} </li>
                                <li>{{ __('Bank Name') }}: {{ $user_detail->bank_name }}</li>
                                <li>{{ __('IFCS Code') }}: {{ $user_detail->ifcs_code }}</li>
                                <li>{{ __('Account Number') }}: {{ $user_detail->account_number }}</li>
              
                              </ul>
                            </div>
                          </div>
                        @endif
              <div class="form-group">              
                          <form id="demo-form2" method="post" action="{{url('refundorder/'.$refunds->id)}}" data-parsley-validate class="form-horizontal form-label-left"  enctype="multipart/form-data">
                            {{ csrf_field() }}
                            {{method_field('PATCH')}}
              
              
                            @if( $refunds->status==0)
              
                            <div class="row">
                             
                              <div class="col-md-12">
                                 <label for="exampleInputTit1e">{{ __('Status') }}:</label>
                                 <input type="checkbox" class="custom_toggle" name="status"
                                 value="{{ $refunds->status }}"  id="j"/>
                               <input type="hidden" name="status" value="{{ $refunds->status }}" id="j">
                              </div>
                              
                            </div>
                            <br>
                            <button type="submit" class="btn btn-primary-rgba" title="{{ __('Proceed Refund') }}"><i class="fa fa-check-circle"></i>
                              {{ __('Proceed Refund') }}</button>
                            @endif
                          </form>
                      </div>
                  </div>
              </div>
              </div>
          </div>
        </div>
      </div>
  </div>
@endsection
@section('script')

 <script>
tinymce.init({
  selector: '#editor1,#editor2,.editor',
  height: 350,
  menubar: 'edit view insert format tools table tc',
  autosave_ask_before_unload: true,
  autosave_interval: "30s",
  autosave_prefix: "{path}{query}-{id}-",
  autosave_restore_when_empty: false,
  autosave_retention: "2m",
  image_advtab: true,
  plugins: [
    'advlist autolink lists link image charmap print preview anchor',
    'searchreplace visualblocks fullscreen',
    'insertdatetime media table paste wordcount'
  ],
  toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media  template link anchor codesample | a11ycheck ltr rtl | showcomments addcomment',
  content_css: '//www.tiny.cloud/css/codepen.min.css'
});
</script>
@endsection
