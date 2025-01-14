@extends('theme.master')
@section('title', 'Sign Up')
@section('content')
@include('admin.message')
<!-- Signup start-->
<section id="signup" class="signup-block-main-block register-page">
    <div class="container">
        <div class="login-signup">
            <div class="row no-gutters">
                <div class="col-lg-6 col-md-6">
                    <div class="signup-side-block">
                        <img src="{{ url('images/login/login.png')}}" class="img-fluid" alt="{{ $gsetting->text }}">
                        <div class="login-img">
                            <img src="{{ url('/images/login/'.$gsetting->img) }}" class="img-fluid" alt="{{ $gsetting->text }}">
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="signup-heading">
                        
                        {{ $gsetting->text }}

                        <div class="signup-block">
                            <form id="otpForm" class="signup-form" action="{{ route('verifyOtp') }}"  method="POST">
                                @csrf
                                <div id="phoneInput" class="input-group mb-3">
                                    <div class="input-group-prepend d-inline-block">
                                        @php
                                            $code = App\Allcountry::get();
                                        @endphp
                                        <select class="select2-single custom-select mr-sm-2" id="code">
                                            @foreach ($code as $codes)
                                                <option selected>+{{$codes->phonecode}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <i data-feather="phone"></i>
                                    <input type="text" id="phone_number" class="form-control" name="phone_number" placeholder="{{ __('Enter Phone No.')}}" required>                              
                                    <button type="button" id="requestOtpBtn" class="btn btn-primary mt-4">{{ __('Request OTP') }}</button>
                                </div>
                                <div id="otpInput" class="hidden form-group">
                                    <input type="text" id="verification_code" class="form-control" name="verification_code" required>
                                    <button type="submit" class="btn btn-primary mt-4">{{ __('Verify OTP') }}</button>
                                </div>
                            </form>
                            <div class="sign-up text-center">{{ __('Already have an account') }}?<a href="{{ route('login') }}" title="sign-up"> {{ __('Login') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Signup end-->
@endsection
@section('custom-script')
<script>
    $(document).ready(function() { 
        /* -- Form Select - Select2 -- */
        $('.select2-single').select2();
    });
</script>
{{-- <script>
    $(document).ready(function() {
        $('#requestOtpBtn').on('click', function() {
            var phoneNumber = $('#phone_number').val();
            var code = $('#code').val();
            if (!phoneNumber) {
                toastr.error('Please enter your phone number');
                return;
            }
            
            $.ajax({
                url: "{{ route('sendOtp') }}",
                type: "POST",
                data: {
                    phone_number: phoneNumber,
                    country_code: code,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        if (response.status === 'pending') {
                            toastr.warning('OTP is being processed. Please wait...');
                        } else {
                            toastr.success('OTP sent successfully');
                            $('#requestOtpBtn').text('Please wait...').prop('disabled', true);
                        }
                        $('#phoneInput').addClass('hidden');
                        $('#otpInput').removeClass('hidden');
                    } else {
                        toastr.error('Failed to send OTP: ' + response.message);
                    }
                },
                error: function(xhr, status, error) {
                    toastr.error('Failed to send OTP: ' + error);
                }
            });
        });
    });
</script> --}}

<script>
    $(document).ready(function() {
        $('#requestOtpBtn').on('click', function() {
            var phoneNumber = $('#phone_number').val();
            var code = $('#code').val();
            if (!phoneNumber) {
                toastr.error('Please enter your phone number');
                return;
            }
            
            // Show "Please wait..." message and disable the button immediately
            toastr.info('Please wait...');
            $('#requestOtpBtn').text('Please wait...').prop('disabled', true);

            $.ajax({
                url: "{{ route('sendOtp') }}",
                type: "POST",
                data: {
                    phone_number: phoneNumber,
                    country_code: code,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        if (response.status === 'pending') {
                            toastr.warning('OTP is being processed. Please wait...');
                        } else {
                            toastr.success('OTP sent successfully');
                        }
                        $('#phoneInput').addClass('hidden');
                        $('#otpInput').removeClass('hidden');
                    } else {
                        toastr.error('Failed to send OTP: ' + response.message);
                        // Re-enable the button if there is an error
                        $('#requestOtpBtn').text('Send OTP').prop('disabled', false);
                    }
                },
                error: function(xhr, status, error) {
                    toastr.error('Failed to send OTP: ' + error);
                    // Re-enable the button if there is an error
                    $('#requestOtpBtn').text('Send OTP').prop('disabled', false);
                }
            });
        });
    });
</script>


@endsection