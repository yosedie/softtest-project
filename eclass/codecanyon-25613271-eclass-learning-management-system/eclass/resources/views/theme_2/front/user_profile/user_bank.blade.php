@extends('theme2.master')
@section('title', 'Profile & Setting')
@section('content')

@include('admin.message')

<!-- about-home start -->
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
                        <h1 class="wishlist-home-heading">{{ __('Bank Details') }}</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif
<!-- profile update start -->
<section id="profile-item" class="profile-item-block">
    <div class="container-xl">

        <div class="row">
            <div class="col-xl-3 col-lg-4">
                <div class="dashboard-author-block text-center">
                    <div class="author-image">
					    <div class="avatar-upload">
					        <div class="avatar-preview">
					        	@if(Auth::User()->user_img != null || Auth::User()->user_img !='')
						            <div class="avatar-preview-img" id="imagePreview" style="background-image: url({{ url('/images/user_img/'.Auth::User()->user_img) }});">
						            </div>
						        @else
						        	<div class="avatar-preview-img" id="imagePreview" style="background-image: url({{ asset('images/default/user.jpg')}});">
						            </div>
						        @endif
					        </div>
					    </div>
                    </div>
                    <div class="author-name">{{ Auth::User()->fname }}&nbsp;{{ Auth::User()->lname }}</div>
                </div>
                <div class="dashboard-items">
                    <ul>
                        <li>
                          <i class="fa fa-bookmark"></i>
                          <a href="{{ route('mycourse.show') }}" title="{{ __('My Courses')}}">{{ __('My Courses') }}</a>
                        </li>
                        <li>
                          <i class="fa fa-heart"></i>
                          <a href="{{ route('wishlist.show') }}" title="{{ __('My wishlist')}}">{{ __('My Wishlist') }}</a>
                        </li>
                        <li>
                          <i class="fa fa-history"></i>
                          <a href="{{ route('purchase.show') }}" title="{{ __('Purchase History')}}">{{ __('Purchase History') }}</a>
                        </li>
                        <li>
                          <i class="fa fa-user"></i>
                          <a href="{{route('profile.show',Auth::User()->id)}}" title="{{ __('User Profile')}}">{{ __('User Profile') }}</a>
                        </li>
                        @if(Auth::User()->role == "user")
                        <li><i class="fas fa-chalkboard-teacher"></i><a href="#" data-toggle="modal" data-target="#myModalinstructor" title="{{ __('Become An Instructor') }}">{{ __('Become An Instructor') }}</a></li>
                        @endif

                        <li><i class="fa fa-bank"></i><a href="{{ url('bankdetail') }}" title="{{ __('My Bank Details') }}">{{ __('My Bank Details') }}</a></li>

                        <li><i class="fa fa-check"></i><a href="{{ route('2fa.show') }}" title="{{ __('2 Factor Auth') }}">{{ __('2 Factor Auth') }}</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-xl-9 col-lg-8">

                <div class="profile-info-block user-bank-button">


                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModalBank">{{ __('Add Bank') }}</button>


                  <div class="modal fade" id="myModalBank" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog modal-lg" role="document">
                      <div class="modal-content">
                        <div class="modal-header">

                          <h4 class="modal-title" id="myModalLabel">{{ __('Add Bank Details') }}</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="box box-primary">
                          <div class="panel panel-sum">
                            <div class="modal-body">

                              <form  method="post" action="{{url('bankdetail/')}}" data-parsley-validate class="form-horizontal form-label-left">
                                  {{ csrf_field() }} 

                                  <input type="hidden" name="user_id"  value="{{Auth::User()->id}}" />

                                  <div class="row">
                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label for="account_holder_name">{{ __('Account Holder Name')}}:<sup class="redstar">*</sup></label>
                                        <input type="text" class="form-control" name="account_holder_name" id="title" placeholder="{{ __('Please Enter Acc. Holder Name')}}"  required>
                                      </div>
                                    </div>
                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label for="bank_name">{{ __('Bank Name')}}:<sup class="redstar">*</sup></label>
                                        <input type="text" class="form-control" name="bank_name" id="title" placeholder="{{ __('Please Enter Bank Name')}}"  required>
                                      </div>
                                    </div>
                                  </div>

                                  <div class="row">
                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label for="account_number">{{ __('Account Number')}}:<sup class="redstar">*</sup></label>
                                        <input type="text" class="form-control" name="account_number" id="title" placeholder="{{ __('Please Enter Account Number')}}"  required>
                                      </div>
                                    </div>
                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label for="ifcs_code">{{ __('IFSC Code')}}:<sup class="redstar">*</sup></label>
                                        <input type="text" class="form-control" name="ifcs_code" id="title" placeholder="{{ __('Please Enter IFSC Code')}}"  required>
                                      </div>
                                    </div>
                                  </div>



                                  <div class="cancel-button" style="text-align:center">
                                  <button type="submit" class="btn btn-primary"> {{ __('Add')}}</button>
                                </div>
                              </form>
                             
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                   
                </div>


                <div id="purchase-block" class="purchase-main-block user-bank-block">
                 
                    <div class="purchase-table table-responsive">
                      <table class="table">
                        <thead>
                          <tr>
                            <th class="purchase-text">{{ __('A/C Holder Name') }}</th>
                            <th class="purchase-text">{{ __('Bank name') }}</th>
                            <th class="purchase-text">{{ __('A/C No') }}</th>
                            <th class="purchase-text">{{ __('IFSC Code') }}s</th>
                            <th class="purchase-text">{{ __('Actions') }}</th>
                            
                          </tr>
                        </thead>
                          @foreach($banks as $bank)
                        
                            <div class="purchase-history-table">
                              <tbody>
                                <tr>
                                  <td>
                                    <div class="purchase-text"> {{ $bank['account_holder_name'] }}</div>                         
                                  </td>
                                  <td>
                                    <div class="purchase-text"> {{ $bank['bank_name'] }}</div>                         
                                  </td>
                                  <td>
                                    <div class="purchase-text"> {{ $bank['account_number'] }}</div>                         
                                  </td>
                                  <td>
                                    <div class="purchase-text"> {{ $bank['ifcs_code'] }}</div>                         
                                  </td>
                                     
                                  <td>
                                    <div class="invoice-btn">
                                      <a type="button" href="{{route('invoice.show',$bank->id)}}"  class="btn btn-secondary" data-toggle="modal" data-target="#myModalBankEdit{{ $bank->id }}">{{ __('Edit') }}</a>


                                   

                                      <div class="modal fade" id="myModalBankEdit{{ $bank->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                        <div class="modal-dialog modal-lg" role="document">
                                          <div class="modal-content">
                                            <div class="modal-header">

                                              <h4 class="modal-title" id="myModalLabel">{{ __('Edit Bank Details') }}</h4>
                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="box box-primary">
                                              <div class="panel panel-sum">
                                                <div class="modal-body">

                                                  <form  method="post" action="{{route('bankdetail.update',$bank->id)}}" data-parsley-validate class="form-horizontal form-label-left">
                                                      {{ csrf_field() }} 
                                                      {{ method_field('PUT') }}



                                                      <input type="hidden" name="user_id"  value="{{Auth::User()->id}}" />

                                                      <div class="row">
                                                        <div class="col-md-6">
                                                          <div class="form-group">
                                                            <label for="account_holder_name">{{ __('Account Holder Name')}}:<sup class="redstar">*</sup></label>
                                                            <input type="text" class="form-control" name="account_holder_name" id="title" value="{{ $bank->account_holder_name  }}" placeholder="{{ __('Please Enter Acc. Holder Name')}}"  required>
                                                          </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                          <div class="form-group">
                                                            <label for="bank_name">{{ __('Bank Name')}}:<sup class="redstar">*</sup></label>
                                                            <input type="text" class="form-control" name="bank_name" id="title" value="{{ $bank->bank_name  }}" placeholder="{{ __('Please Enter Bank Name')}}"  required>
                                                          </div>
                                                        </div>
                                                      </div>

                                                      <div class="row">
                                                        <div class="col-md-6">
                                                          <div class="form-group">
                                                            <label for="account_number">{{ __('Account Number')}}:<sup class="redstar">*</sup></label>
                                                            <input type="text" class="form-control" name="account_number" id="title" value="{{ $bank->account_number  }}" placeholder="{{ __('Please Enter Account Number')}}"  required>
                                                          </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                          <div class="form-group">
                                                            <label for="ifcs_code">{{ __('IFSC Code')}}:<sup class="redstar">*</sup></label>
                                                            <input type="text" class="form-control" name="ifcs_code" id="title" value="{{ $bank->ifcs_code  }}" placeholder="{{ __('Please Enter IFSC Code')}}"  required>
                                                          </div>
                                                        </div>
                                                      </div>



                                                      <div class="cancel-button">
                                                      <button type="submit" class="btn btn-primary"> {{ __('Edit')}}</button>
                                                    </div>
                                                  </form>
                                                 
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>


                                    </div>
                                  </td>
                                </tr>
                              </tbody>
                            </div>

                          @endforeach
                      </table>
                    </div>
                  
                </div>
                
            </div>
        </div>
    </div>
</section>
<!-- profile update end -->
@endsection

@section('custom-script')

<script>
(function($) {
  "use strict";
	tinymce.init({selector:'textarea#detail'});
})(jQuery);
</script>

@endsection
