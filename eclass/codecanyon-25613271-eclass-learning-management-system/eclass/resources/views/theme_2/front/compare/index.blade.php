@extends('theme2.master')
@section('title', 'Compare')
@section('content')
@include('admin.message')
<style>
    .compare-image{
        height:150px;
        width:150px;
    }
</style>
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
                        <h2>{{ __('Course Compare ') }}</h2>    
                        
                    </div>
                </div>
            </div>
            <div class="breadcrumb-wrap2">
                  
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">{{__('Home')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{__('Course Compare ')}}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- Compare Start -->
<section id="compare" class="compare-main-block">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
      <div class="compare-block">
        @if(count($compare) > 0)                
          <!-- Start table div -->
          <div class="table-responsive">
              <!-- Start table-->
              <table  class="table table-bordered">
                  
                  
                  <tbody>
                      <tr>
                          <td>
                              
                          </td>
                          @foreach($compare as $cour)
                          @php
                          $c = App\Course::where('id', $cour->course_id)->first();
                          @endphp
                          <td>
                              <img src="{{ asset('images/course/'.$c->preview_image) }}" alt="{{ __('course')}}" class="img-fluid compare-image">
                          <h5 class="text-info mt-2">{{ $c->title }}</h5>

                          </td>
                          
                          @endforeach
                          
                      </tr>
                  </tbody>
                  <tbody>
                      <tr class="bg_lightblue">
                          <td>
                            <h5>{{__('Price')}}</h5> 
                          </td>
                          @foreach($compare as $cour)
                              @php
                              $c = App\Course::where('id', $cour->course_id)->first();
                              @endphp
                              <td>{{ $c->price }}</td>
                          @endforeach
                          
                      </tr>
                  </tbody>
                  <tbody>
                      <tr>
                          <td>
                            <h5>{{__('Discount Price')}}</h5>  
                          </td>
                          @foreach($compare as $cour)
                              @php
                              $c = App\Course::where('id', $cour->course_id)->first();
                              @endphp
                              <td>@if($c->discount_price)
                                  {{  $c->discount_price }}
                                  @else
                                  <i class="fa fa-times text-danger" aria-hidden="true"></i>
                                  @endif
                              </td>
                          @endforeach
                          
                      </tr>
                  </tbody >
                  <tbody>
                      <tr class="bg_lightblue">
                          <td>
                            <h5>{{ __('Language')}}</h5>  
                          </td>
                          @foreach($compare as $cour)
                          @php
                          $c = App\Course::where('id', $cour->course_id)->first();
                          @endphp
                          @php
                          $lang = App\Language::where('id', $c->language_id)->first();
                          @endphp
                          <td>
                          <p>{{ $lang->name }}</p>
                          </td>
                          @endforeach
                      </tr>
                  </tbody>
                  <tbody>
                      <tr>
                          <td>
                            <h5>{{ __('Last updated at')}}</h5>   
                          </td>
                          @foreach($compare as $cour)
                          @php
                          $c = App\Course::where('id', $cour->course_id)->first();
                          @endphp
                          
                          <td>
                          <p>{{ date('d-M-Y', strtotime($c->updated_at)) }}</p>
                          </td>
                          @endforeach
                      </tr>
                  </tbody>
                  <tbody>
                    <tr class="bg_lightblue">
                        <td>
                            <h5>{{ __('Duration end time')}}</h5>
                            
                        </td>
                        @foreach($compare as $cour)
                        @php
                        $c = App\Course::where('id', $cour->course_id)->first();
                        @endphp
                        
                        <td>
                          <p>@if($c->duration && $c->duration_type)
                              {{ $c->duration }}  {{ $c->duration_type }}
                              @else
                              <span class="badge badge-pill badge-primary">{{ __('Life time')}} </span>
                          @endif

                          </p>
                        </td>
                        @endforeach
                    </tr>
                  </tbody>
                  <tbody>
                      <tr>
                          <td>
                              <h5>{{ __('Requirements')}}</h5> 
                          </td>
                          @foreach($compare as $cour)
                          @php
                          $c = App\Course::where('id', $cour->course_id)->first();
                          @endphp
                          
                          <td>
                          <p>{{ $c->requirement }}</p>
                          </td>
                          @endforeach
                      </tr>
                  </tbody>
                  <tbody>
                      <tr class="bg_lightblue">
                          <td>
                            <h5>{{ __('Short Detail')}}</h5>   
                          </td>
                          @foreach($compare as $cour)
                          @php
                          $c = App\Course::where('id', $cour->course_id)->first();
                          @endphp
                          
                          <td>
                          <p>{{ $c->short_detail }}</p>
                          </td>
                          @endforeach
                      </tr>
                  </tbody>
                  <tbody>
                      <tr>
                          <td>
                              <h5>{{ __('Category')}}</h5> 
                          </td>
                          @foreach($compare as $cour)
                          @php
                              $c = App\Course::where('id', $cour->course_id)->first();
                          @endphp
                          @php
                              $cate = App\Categories::where('id', $c->category_id)->first();
                          @endphp
                          <td>
                          <p>{{ $cate->title }}</p>
                          </td>
                          @endforeach
                      </tr>
                  </tbody>
                  <tbody>
                      <tr class="bg_lightblue">
                          <td>
                            <h5>{{ __('Sub Category')}}</h5>  
                          </td>
                          @foreach($compare as $cour)
                          @php
                              $c = App\Course::where('id', $cour->course_id)->first();
                          @endphp
                          @php
                              $subcate = App\SubCategory::where('id', $c->subcategory_id)->first();
                          @endphp
                          <td>
                          <p>{{ $subcate->title }}</p>
                          </td>
                          @endforeach
                      </tr>
                  </tbody>
                  <tbody>
                      <tr>
                          <td>
                              <h5>{{ __('Certificate')}}</h5> 
                          </td>
                          @foreach($compare as $cour)
                          @php
                              $c = App\Course::where('id', $cour->course_id)->first();
                          @endphp
                          
                          <td>
                          <p>@if($c->certificate_enable == 1)</p>
                          <i class="fa fa-check-circle text-success" aria-hidden="true"></i>
                            @else
                            <i class="fa fa-times text-danger" aria-hidden="true"></i>
                            @endif

                          </td>
                          @endforeach
                      </tr>
                  </tbody>
                  <tbody>
                      <tr class="bg_lightblue">
                          <td>
                              <h5>{{ __('Appointment')}}</h5> 
                          </td>
                          @foreach($compare as $cour)
                          @php
                              $c = App\Course::where('id', $cour->course_id)->first();
                          @endphp
                          
                          <td>
                          <p>@if($c->appointment_enable == 1)</p>
                          <i class="fa fa-check-circle text-success" aria-hidden="true"></i>
                            @else
                            <i class="fa fa-times text-danger" aria-hidden="true"></i>
                            @endif

                          </td>
                          @endforeach
                      </tr>
                  </tbody>
                  <tbody>
                      <tr>
                          <td>
                              <h5>{{ __('Assignment')}}</h5> 
                          </td>
                          @foreach($compare as $cour)
                          @php
                              $c = App\Course::where('id', $cour->course_id)->first();
                          @endphp
                          
                          <td>
                          <p>@if($c->assignment_enable == 1)</p>
                          <i class="fa fa-check-circle text-success" aria-hidden="true"></i>
                            @else
                            <i class="fa fa-times text-danger" aria-hidden="true"></i>
                            @endif

                          </td>
                          @endforeach
                      </tr>
                  </tbody>
                  <tbody>
                      <tr class="bg_lightblue">
                          <td>
                              
                          </td>
                              @foreach($compare as $cour)
                          <td>

                          <a href="{{ route('compare.remove',['id' => $cour->id]) }}">
                              <span class="badge bg-danger">{{ __("Remove") }}</span>
                          </a> 

                          </td>
                          @endforeach
                      </tr>
                  </tbody>
              </table>
              <!-- end table -->
          </div>
          @else
          <div class="compare-data-block">
              {{ __('No Data Found')}}
          </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</section>
    <!-- Compare End -->@endsection