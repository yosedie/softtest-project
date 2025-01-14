@extends('theme.master')
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
                        <h1 class="wishlist-home-heading">{{ __('Course Compare') }}</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif
<section id="blog" class="blog-main-block compare-block">
    <div class="container-xl">
       
      <div class="row">
          <div class="col-md-12">
            <div class="card-body">
                @if(count($compare) > 0)                
                <!-- Start table div -->
                <div class="table-responsive">
                    <!-- Start table-->
                    <table  class="table table-striped table-bordered">
                       
                        
                        <tbody class="bg-white">
                            <tr>
                                <td width="10%">
                                    
                                </td>
                                @foreach($compare as $cour)
                                @php
                                $c = App\Course::where('id', $cour->course_id)->first();
                                @endphp
                                <td width="18%">
                                    <img src="{{ asset('images/course/'.$c->preview_image) }}" alt="{{ __('course')}}" class="img-fluid compare-image">
                                <h5 class="mt-2">{{ $c->title }}</h5>

                                </td>
                                
                                @endforeach
                               
                            </tr>
                        </tbody>
                        <tbody>
                            <tr class="bg-white">
                                <td width="10%">
                                  <h5>{{__('Price')}}</h5> 
                                </td>
                                @foreach($compare as $cour)
                                    @php
                                    $c = App\Course::where('id', $cour->course_id)->first();
                                    @endphp
                                    <td width="18%">{{ $c->price }}</td>
                                @endforeach
                               
                            </tr>
                        </tbody>
                        <tbody>
                            <tr>
                                <td width="10%">
                                 <h5>{{__('Discount Price')}}</h5>  
                                </td>
                                @foreach($compare as $cour)
                                    @php
                                    $c = App\Course::where('id', $cour->course_id)->first();
                                    @endphp
                                    <td width="18%">@if($c->discount_price)
                                        {{  $c->discount_price }}
                                        @else
                                        <i class="fa fa-times text-danger" aria-hidden="true"></i>
                                        @endif
                                    </td>
                                @endforeach
                               
                            </tr>
                        </tbody >
                        <tbody>
                            <tr class="bg-white">
                                <td width="10%">
                                  <h5>{{ __('Language')}}</h5>  
                                </td>
                                @foreach($compare as $cour)
                                @php
                                $c = App\Course::where('id', $cour->course_id)->first();
                                @endphp
                                @php
                                $lang = App\Language::where('id', $c->language_id)->first();
                                @endphp
                               <td width="18%">
                               <p>{{ $lang->name }}</p>
                               </td>
                               @endforeach
                            </tr>
                        </tbody>
                        <tbody>
                            <tr>
                                <td width="10%">
                                 <h5>{{ __('Last updated at')}}</h5>   
                                </td>
                                @foreach($compare as $cour)
                                @php
                                $c = App\Course::where('id', $cour->course_id)->first();
                                @endphp
                               
                               <td width="18%">
                               <p>{{ date('d-M-Y', strtotime($c->updated_at)) }}</p>
                               </td>
                               @endforeach
                            </tr>
                        </tbody>
                        <tbody >
                            <tr class="bg-white">
                                <td width="10%">
                                    <h5>{{ __('Duration end time')}}</h5>
                                    
                                </td>
                                @foreach($compare as $cour)
                                @php
                                $c = App\Course::where('id', $cour->course_id)->first();
                                @endphp
                               
                               <td width="18%">
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
                                <td width="10%">
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
                            <tr class="bg-white">
                                <td width="10%">
                                 <h5>{{ __('Short Detail')}}</h5>   
                                </td>
                                @foreach($compare as $cour)
                                @php
                                $c = App\Course::where('id', $cour->course_id)->first();
                                @endphp
                               
                               <td width="18%">
                                <p>{{ $c->short_detail }}</p>
                                </td>
                               @endforeach
                            </tr>
                        </tbody>
                        <tbody>
                            <tr>
                                <td width="10%">
                                   <h5>{{ __('Category')}}</h5> 
                                </td>
                                @foreach($compare as $cour)
                                @php
                                    $c = App\Course::where('id', $cour->course_id)->first();
                                @endphp
                                @php
                                    $cate = App\Categories::where('id', $c->category_id)->first();
                                @endphp
                               <td width="18%">
                                <p>{{ $cate->title }}</p>
                                </td>
                               @endforeach
                            </tr>
                        </tbody>
                        <tbody>
                            <tr class="bg-white">
                                <td width="10%">
                                  <h5>{{ __('Sub Category')}}</h5>  
                                </td>
                                @foreach($compare as $cour)
                                @php
                                    $c = App\Course::where('id', $cour->course_id)->first();
                                @endphp
                                @php
                                    $subcate = App\SubCategory::where('id', $c->subcategory_id)->first();
                                @endphp
                               <td width="18%">
                                <p>{{ $subcate->title }}</p>
                                </td>
                               @endforeach
                            </tr>
                        </tbody>
                        <tbody>
                            <tr>
                                <td width="10%">
                                   <h5>{{ __('Certificate')}}</h5> 
                                </td>
                                @foreach($compare as $cour)
                                @php
                                    $c = App\Course::where('id', $cour->course_id)->first();
                                @endphp
                               
                               <td width="18%">
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
                            <tr class="bg-white">
                                <td width="10%">
                                   <h5>{{ __('Appointment')}}</h5> 
                                </td>
                                @foreach($compare as $cour)
                                @php
                                    $c = App\Course::where('id', $cour->course_id)->first();
                                @endphp
                               
                               <td width="18%">
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
                                <td width="10%">
                                   <h5>{{ __('Assignment')}}</h5> 
                                </td>
                                @foreach($compare as $cour)
                                @php
                                    $c = App\Course::where('id', $cour->course_id)->first();
                                @endphp
                               
                               <td width="18%">
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
                            <tr class="bg-white">
                                <td width="10%">
                                    
                                </td>
                                    @foreach($compare as $cour)
                                <td width="18%">

                                <a href="{{ route('compare.remove',['id' => $cour->id]) }}">
                                    <span class="badge badge-danger">{{ __("Remove") }}</span>
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
                <!-- end table div -->
            </div>
          </div>
      </div>
                   
                      
                        

    </div>
</section>

@endsection
