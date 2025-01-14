@extends('theme2.master')
@section('title', 'Profile & Setting')
@section('content')
@include('admin.message')
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
                        <h2>{{ __('User Profile') }}</h2>    
                        
                    </div>
                </div>
            </div>
			<div class="breadcrumb-wrap2">
                  
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">{{__('Home')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{__('User Profile')}}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- profile update start -->
<section id="profile-item" class="profile-item-block">
    <div class="container-xl">
    	<form action="{{ route('user.profile',$orders->id) }}" method="POST" enctype="multipart/form-data">
        	{{ csrf_field() }}
            {{ method_field('PUT') }}

	        <div class="row">
	            <div class="col-xl-3 col-lg-4 col-md-4">
	                <div class="dashboard-author-block text-center">
	                    <div class="author-image">
						    <div class="avatar-upload">
						        <div class="avatar-edit">
						            <input type='file' id="imageUpload" name="user_img" accept=".png, .jpg, .jpeg" />
						            <label for="imageUpload"><i class="fa fa-pencil"></i></label>
						        </div>
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
								<i data-feather="bookmark"></i>
								<a href="{{ route('mycourse.show') }}" title="{{ __('My Courses')}}">{{ __('My Courses') }}</a>
							</li>
	                        <li>
								<i data-feather="heart"></i>
								<a href="{{ route('wishlist.show') }}" title="{{ __('My wishlist')}}">{{ __('My Wishlist') }}</a>
							</li>
	                        <li>
								<i data-feather="crosshair"></i>
								<a href="{{ route('purchase.show') }}" title="{{ __('Purchase History')}}">{{ __('Purchase History') }}</a>
							</li>
	                        <li>
								<i data-feather="user"></i>
								<a href="{{route('profile.show',Auth::User()->id)}}" title="{{ __('User Profile')}}">{{ __('User Profile') }}</a>
							</li>
	                        @if(Auth::User()->role == "user")
	                        <li>
								<i data-feather="user-plus"></i>
								<a href="#" data-toggle="modal" data-target="#myModalinstructor" title="{{ __('Become An Instructor') }}">{{ __('Become An Instructor') }}</a>
							</li>
	                        @endif
	                        <li>
								<i data-feather="credit-card"></i>
								<a href="{{ url('bankdetail') }}" title="{{ __('My Bank Details') }}">{{ __('My Bank Details') }}</a>
							</li>

	                        <li>
								<i data-feather="lock"></i>
								<a href="{{ route('2fa.show') }}" title="{{ __('2 Factor Auth') }}">{{ __('2 Factor Auth') }}</a>
							</li>
							<li>
								<i data-feather="check-circle"></i>
								<a href="{{ route('verifaction') }}" title="{{ __('Verifaction') }}">{{ __('Verifaction') }}</a>
							</li>
							@if(Auth::User()->role == "user" && Auth::User()->role == "Admin")
	                        <li>
								<i data-feather="layers"></i>
								<a href="{{ route('front.alumini') }}" title="{{ __('Alumini') }}">{{ __('Alumini') }}</a>
							</li>
	                        @endif
	                    </ul>
	                </div>
	            </div>
	            <div class="col-xl-9 col-lg-8 col-md-8">

	                <div class="profile-info-block">
	                    <div class="profile-heading">{{ __('Personal Info') }}</div>
	                    <div class="row">
	                        <div class="col-lg-6">
	                            <div class="form-group mb-3">
	                                <label for="name">{{ __('First Name') }}</label>
	                                <input type="text" id="name" name="fname" class="form-control" placeholder="{{ __('Enter First Name') }}" value="{{ $orders->fname }}" required>
	                            </div>
							</div>
							<div class="col-lg-6">
	                            <div class="form-group mb-3">
	                                <label for="email">{{ __('Email') }}</label>
	                                <input type="email" id="email" name="email" class="form-control" placeholder="info@example.com" required value="{{ $orders->email }}" >
	                            </div>
	                        </div>
	                        <div class="col-lg-6">
	                            <div class="form-group mb-3">
	                                <label for="Username">{{ __('Last Name') }}</label>
	                                <input type="text" id="lname" name="lname" class="form-control" placeholder="{{ __('Enter Last Name') }}" value="{{ $orders->lname }}" required>
	                            </div>
							</div>
							<div class="col-lg-6">
	                            <div class="form-group mb-3">
	                                <label for="mobile">{{ __('Mobile') }}</label>
	                                <input type="text" name="mobile" id="mobile" value="{{ $orders->mobile }}" class="form-control" placeholder="{{ __('Enter Mobile No') }}">
	                            </div>	                            
	                        </div>
							<div class="col-lg-12">
								<div class="form-group mb-3">
									<label for="bio">{{ __('address') }}</label>
									<textarea id="address" name="address" class="form-control" placeholder="{{ __('Enter your Address') }}" value="">{{ $orders->address }}</textarea>
								</div>
							</div>
	                        <div class="col-lg-4">
	                        	<div class="form-group mb-3">
	                                <label for="city_id">{{ __('Country') }}:</label>
					                <select class="form-select" aria-label="Default select example">
										<option selected>Country</option>
										@foreach ($countries as $coun)
					                    <option value="{{ $coun->country_id }}" {{ $orders->country_id == $coun->country_id ? 'selected' : ''}}>{{ $coun->nicename }}
					                    </option>
					                  @endforeach
									</select>
	                            </div>
	                        </div>
	                        <div class="col-lg-4">
	                        	<div class="form-group mb-3">
	                        		<label for="city_id">{{ __('State') }}:</label>
					                <select class="form-select" aria-label="Default select example">
										<option selected>State</option>
										@foreach ($states as $s)
					                    <option value="{{ $s->id}}" {{ $orders->state_id==$s->id ? 'selected' : '' }}>{{ $s->name}}</option>
					                  @endforeach
									</select>
	                        	</div>
	                        </div>
	                        <div class="col-lg-4">
	                        	<div class="form-group mb-3">
	                        		<label for="city_id">{{ __('City') }}:</label>
					                <select class="form-select" aria-label="Default select example">
										<option selected>City</option>
										@foreach ($cities as $c)
					                    <option value="{{ $c->id }}" {{ $orders->city_id == $c->id ? 'selected' : ''}}>{{ $c->name }}
					                    </option>
					                  @endforeach
									</select>
	                        	</div>
	                        </div>
							<div class="col-lg-12">
								<div class="form-group mb-3">
									<label for="bio">{{ __('Author Bio') }}</label>
									<textarea id="detail" name="detail" class="form-control" placeholder="{{ __('Enter your details') }}" value="">{{ $orders->detail }}</textarea>
								</div>
							</div>
		                    <div class="col-lg-12">
		                      	<div class="update-password mb-2">
									<label for="box1">{{ __('Update Password') }}:</label>
									<input type="checkbox" name="update_pass" id="myCheck" onclick="myFunction()">
		                      	</div>
		                    </div>
							<div class="password" id="update-password">
								<div class="row">
									<div class="col-lg-6">
										<div class="form-group">
											<label for="confirmpassword">{{ __('Password') }}:</label>
											<span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
											<input name="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" id="password" type="password" placeholder="{{ __('Enter Password') }}" onkeyup='check();' />
											@if ($errors->has('password'))
											<span class="invalid-feedback" role="alert">
												<strong>{{ $errors->first('password') }}</strong>
											</span>
										@endif
										</div>
									</div>
									<div class="col-lg-6">
										<div class="form-group">
											<label>{{ __('Confirm Password') }}:</label>
											<input type="password" name="confirm_password" id="confirm_password" class="form-control " placeholder="{{ __('Confirm Password') }}" onkeyup='check();' /> 
											@if ($errors->has('password'))
											<span class="invalid-feedback" role="alert">
												<strong>{{ $errors->first('password') }}</strong>
											</span>
										@endif
											<span id='message'></span>
											</label>
										</div>
									</div>
								</div>
							</div>
						</div>
	                </div>
	                <div class="social-profile-block">
	                    <div class="social-profile-heading">{{ __('Social Profile') }}</div>
	                    <div class="row">
	                        <div class="col-lg-6">
	                            <div class="social-block">
	                                <div class="form-group">
	                                    <label for="facebook">{{ __('Facebook Url') }}</label><br>
	                                    <div class="row">
	                                        <div class="col-lg-2 col-2">
	                                            <div class="profile-update-icon">
	                                                <div class="product-update-social-icons"><a href="{{ $orders->fb_url }}" class="facebook" target="_blank" title="facebook"><i data-feather="facebook"></i></a>
	                                                </div>
	                                            </div>
	                                        </div>
	                                        <div class="col-lg-10 col-10">
	                                            <input type="text" name="fb_url" value="{{ $orders->fb_url }}" id="facebook" class="form-control" placeholder="{{ __('Facebook.com')}}" />
	                                        </div>
	                                    </div>    
	                                </div>
	                            </div>
	                            <div class="social-block">
	                                <div class="form-group">
	                                    <label for="behance2">{{ __('Youtube Url') }}</label><br>
	                                    <div class="row">
	                                        <div class="col-lg-2 col-2">
	                                            <div class="profile-update-icon">
	                                                <div class="product-update-social-icons">
														<a href="{{ $orders->youtube_url }}" target="_blank" class="youtube" title="googleplus"><i data-feather="youtube"></i></a>
	                                                </div>
	                                            </div>
	                                        </div>
	                                        <div class="col-lg-10 col-10">
	                                            <input type="text" name="youtube_url" value="{{ $orders->youtube_url }}" id="behance2" class="form-control" placeholder="{{ __('youtube.com')}}" />
	                                        </div>
	                                    </div>    
	                                </div>
	                            </div>
	                        </div>
	                        <div class="col-lg-6">
	                            <div class="social-block">
	                                <div class="form-group">
	                                    <label for="twitter">{{ __('Twitter Url') }}</label><br>
	                                    <div class="row">
	                                        <div class="col-lg-2 col-2">
	                                            <div class="profile-update-icon">
	                                                <div class="product-update-social-icons"><a href="{{ $orders->twitter_url }}" class="twitter" target="_blank" title="twitter"><i data-feather="twitter"></i></a>
	                                                </div>
	                                            </div>
	                                        </div>
	                                        <div class="col-lg-10 col-10">
	                                            <input type="text" name="twitter_url" value="{{ $orders->twitter_url }}" id="twitter" class="form-control" placeholder="{{ __('Twitter.com')}}" />
	                                        </div>
	                                    </div>    
	                                </div>
	                            </div>
	                            <div class="social-block">
	                                <div class="form-group">
	                                    <label for="dribbble2">{{ __('Linked In Url') }}</label><br>
	                                    <div class="row">
	                                        <div class="col-lg-2 col-2">
	                                            <div class="profile-update-icon">
	                                                <div class="product-update-social-icons"><a href="{{ $orders->linkedin_url }}" class="linkedin" target="_blank" title="linkedin"><i data-feather="linkedin"></i></a>
	                                                </div>
	                                            </div>
	                                        </div>
	                                        <div class="col-lg-10 col-10">
	                                            <input type="text" name="linkedin_url" value="{{ $orders->linkedin_url }}" id="dribbble2" class="form-control" placeholder="Linkedin.com/">
	                                        </div>
	                                    </div>    
	                                </div>
	                            </div>
	                        </div>
	                    </div>
	                </div>

	                <div class="upload-items text-right">
	                    <button type="submit" class="btn btn-primary" title="upload items">{{ __('Update Profile') }}</button>
	                </div>
	                
	            </div>
	        </div>

        </form>
    </div>
</section>
<!-- profile update end -->
@endsection
@section('custom-script')





<script>
(function($) {
  "use strict";
  $(function() {
    var urlLike = '{{ url('country/dropdown') }}';
    $('#country_id').change(function() {
      var up = $('#upload_id').empty();
      var cat_id = $(this).val();    
      if(cat_id){
        $.ajax({
          headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type:"GET",
          url: urlLike,
          data: {catId: cat_id},
          success:function(data){   
            console.log(data);
            up.append('<option value="0">Please Choose</option>');
            $.each(data, function(id, title) {
              up.append($('<option>', {value:id, text:title}));
            });
          },
          error: function(XMLHttpRequest, textStatus, errorThrown) {
            console.log(XMLHttpRequest);
          }
        });
      }
    });
  });
  })(jQuery);

</script>

<script>
(function($) {
  "use strict";
  $(function() {
    var urlLike = '{{ url('country/gcity') }}';
    $('#upload_id').change(function() {
      var up = $('#grand').empty();
      var cat_id = $(this).val();    
      if(cat_id){
        $.ajax({
          headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type:"GET",
          url: urlLike,
          data: {catId: cat_id},
          success:function(data){   
            console.log(data);
            up.append('<option value="0">Please Choose</option>');
            $.each(data, function(id, title) {
              up.append($('<option>', {value:id, text:title}));
            });
          },
          error: function(XMLHttpRequest, textStatus, errorThrown) {
            console.log(XMLHttpRequest);
          }
        });
      }
    });
  });
  })(jQuery);

</script>

<script>
(function($) {
  "use strict";
	function readURL(input) {
	if (input.files && input.files[0]) {
	    var reader = new FileReader();
	    reader.onload = function(e) {
	        $('#imagePreview').css('background-image', 'url('+e.target.result +')');
	        $('#imagePreview').hide();
	        $('#imagePreview').fadeIn(650);
	    }
	    reader.readAsDataURL(input.files[0]);
		}
	}
	$("#imageUpload").change(function() {
	    readURL(this);
	});
})(jQuery);
</script>

<script>
  function myFunction() {
    var checkBox = document.getElementById("myCheck");
    var text = document.getElementById("update-password");
    if (checkBox.checked == true){
      text.style.display = "block";
    } else {
       text.style.display = "none";
    }
  }
</script>

<script>
(function($) {
  "use strict";
	$('#password, #confirm_password').on('keyup', function () {
	  if ($('#password').val() == $('#confirm_password').val()) {
	    $('#message').html('Password Match').css('color', 'green');
	  } else 
	    $('#message').html('Password Do Not Match').css('color', 'red');
	});
})(jQuery);

</script>

<script>
(function($) {
  "use strict";
	tinymce.init({selector:'textarea#detail'});
})(jQuery);
</script>

@endsection