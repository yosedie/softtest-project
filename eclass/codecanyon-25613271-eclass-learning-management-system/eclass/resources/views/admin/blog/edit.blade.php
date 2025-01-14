@extends('admin.layouts.master')
@section('title', 'Edit Blog Post')
@section('maincontent')
<?php
$data['heading'] = 'Edit Blog Post';
$data['title'] = 'Blog';
$data['title1'] = 'Edit Post';;
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar dashboard-card">
    <div class="row">
@if ($errors->any())  
  <div class="alert alert-danger" role="alert">
  @foreach($errors->all() as $error)     
  <p>{{ $error}}<button type="button" class="close" data-dismiss="alert" aria-label="Close" title="{{ __('Close') }}">
  <span aria-hidden="true" style="color:red;">&times;</span></button></p>
      @endforeach  
  </div>
  @endif
  <!-- row started -->
    <div class="col-lg-12">
         <div class="card dashboard-card m-b-30">
             <!-- Card header will display you the heading -->
            <div class="card-header">
                <h5 class="card-box"> {{ __('Edit Blog Post') }}</h5>
                <div>
                        <div class="widgetbar">
                        <a href="{{url('blog')}}" class="btn btn-primary-rgba" title="{{ __('Back') }}"><i class="feather icon-arrow-left mr-2"></i>{{ __("Back")}}</a>
                        </div>
                      </div>
            </div> 
             <!-- card body started -->
            <div class="card-body">
               <!-- form start -->
              <form action="{{route('blog.update',$show->id)}}" class="form" method="POST" novalidate enctype="multipart/form-data">
			  		{{ csrf_field() }}
	                {{ method_field('PUT') }}
                    <!-- row start -->
                    <div class="row">
                        <div class="col-md-12">
                            <!-- card start -->
                            <div class="card">
                                <!-- card body start -->
                                <div class="card-body">
                                    <!-- row start -->
                                      <div class="row">
                                          
                                          <div class="col-md-12">
                                              <!-- row start -->
                                              <div class="row">
                                                
                                                 <!-- Heading -->
                                                 <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="text-dark">{{ __('Heading') }} : <span class="text-danger">*</span></label>
                                                        <input type="text" value="{{ $show->heading }}" autofocus="" class="form-control @error('heading') is-invalid @enderror" placeholder="{{ __('Enter Heading') }}" name="heading" required="">
                                                        @error('heading')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                 <!-- slug -->
                                                 <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="text-dark">{{ __('Slug') }} : <span class="text-danger">*</span></label>
                                                        <input type="text" pattern="[/^\S*$/]+"  value="{{ $show->slug}}" autofocus="" class="form-control @error('slug') is-invalid @enderror" placeholder="{{ __('Enter Slug') }}" name="slug" required="">
                                                        @error('slug')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                 <!-- ButtonText -->
                                                 <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="text-dark">{{ __('Button Text') }} : <span class="text-danger">*</span></label>
                                                        <input type="text" value="{{ $show->text }}" autofocus="" class="form-control @error('title') is-invalid @enderror" placeholder="{{ __('Enter Button Text') }}" name="text" required="">
                                                        @error('text')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <!-- Date -->
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="text-dark">{{ __('Date') }} : <span class="text-danger">*</span></label>
                                                        <input type="date" class="form-control" value="{{ $show->date }}" name="date" id="inputDate" placeholder="{{ __('Select Date') }}" required>
                                                        
                                                        @error('date')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <!-- detail -->
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="text-dark">{{ __('Details') }}: <span class="text-danger">*</span></label>
                                                        <textarea id="detail" name="detail" class="@error('detail') is-invalid @enderror" placeholder="{{ __('Enter') }} {{ __('Detail') }}" required="">{{ $show->detail }}</textarea>
                                                        @error('detail')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                
                                                <!-- image -->
												@if(Auth::user()->role == 'instructor')
                                                <div class="form-group col-md-4">
                                                <label class="text-dark">{{ __('Image') }}:<span class="text-danger">*</span></label><br>
                                                <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="inputGroupFileAddon01">{{ __('Upload') }}</span>
                                                </div>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="inputGroupFile01" name="image" aria-describedby="inputGroupFileAddon01">
                                                    <label class="custom-file-label" for="inputGroupFile01">{{ __('Choose file') }}</label>
                                                </div>
                                                </div>
                                                <img src="{{ url('/images/blog/'.$show->image) }}" class="image_size"/>
                                                </div>

                                                @endif

                                                @if(Auth::user()->role == 'admin')
                                                <div class="form-group">
              <label class="control-label" for="first-name">{{ __('Image') }} <span
                  class="required">*</span> </label>
             
                  <div class="input-group">

                    <input required readonly id="image" name="image" type="text"
                        class="form-control">
                    <div class="input-group-append">
                        <span data-input="image"
                            class="bg-primary text-light midia-toggle input-group-text">{{ __('Browse') }}</span>
                    </div>
                  </div>

                <small class="text-info"> <i class="text-dark feather icon-help-circle"></i>({{ __('Choose Image for blog
                  post') }})</small>
                  <br>
                  <img src=" {{url('images/blog/'.$show->image)}}"
                  class="pro-img" />
            </div>

            @endif
                                                

                                                @if(Auth::user()->role == 'admin')
                                                <!-- Approved -->
                                                <div class="form-group col-md-3">
                                                    <label class="text-dark" for="exampleInputDetails">{{ __('Approved') }}:<sup class="redstar text-danger">*</sup></label><br>
                                                    <input type="checkbox" class="custom_toggle" name="approved"{{ $show->approved == '1' ? 'checked' : '' }} />
                                                    <input type="hidden"  name="free" value="0" for="status" id="status">
                                                </div>
                                               
                                                <!-- status -->
                                                <div class="form-group col-md-3">
                                                <label class="text-dark" for="exampleInputDetails">{{ __('Status') }} :</label><br>
                                                <input type="checkbox" class="custom_toggle" name="status" {{ $show->status == '1' ? 'checked' : '' }} />
                                                <input type="hidden"  name="free" value="0" for="status" id="status">
                                                </div>
                                                @endif
                                                                  
                                                <!-- update and reset button -->
                                                <div class="col-md-12">
                                                    <button type="reset" class="btn btn-danger-rgba mr-1" title="{{ __('Reset') }}"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
                                                    <button type="submit" class="btn btn-primary-rgba" title="{{ __('Update') }}"><i class="fa fa-check-circle"></i>
                                                        {{ __("Update")}}</button>
                                                </div>

                                              </div><!-- row end -->
                                          </div><!-- col end -->
                                      </div><!-- row end -->

                                </div><!-- card body end -->
                            </div><!-- card end -->
                        </div><!-- col end -->
                    </div><!-- row end -->
              </form>
              <!-- form end -->
            </div><!-- card body end -->
            
        </div><!-- col end -->
    </div>
</div>
</div><!-- row end -->
    <br><br>
@endsection
<!-- main content section ended -->
<!-- This section will contain javacsript start -->
@section('script')

<script>
    $(".midia-toggle").midia({
        base_url: '{{ url('') }}',
        title : 'Choose Blog Image',
        dropzone : {
          acceptedFiles: '.jpg,.png,.jpeg,.webp,.bmp,.gif'
        },
        directory_name: 'blog'
    });
</script>

<style>
    .image_size{
    height:80px;
    width:200px;
}
</style>
@endsection
<!-- This section will contain javacsript end -->