@extends('admin.layouts.master')
@section('title','All Rejected')
@section('maincontent')
<?php
$data['heading'] = 'All Rejected';
$data['title'] = 'All Rejected';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar"> 
  <div class="row">
      <div class="col-lg-12">
          <div class="card dashboard-card m-b-30">
              <div class="card-header">
                  <h5 class="box-title">{{__('Course Review')}}</h5>
              </div>
              <div class="card-body">
              
                  <div class="table-responsive">
                      <table id="datatable-buttons" class="table table-striped table-bordered">
                          <thead>
                          <tr>
                            <th>#</th>
                            <th>{{ __('Image') }}</th>
                            <th>{{ __('Title') }}</th>
                            <th>{{ __('Instructor') }}</th>
                            <th>{{ __('Slug') }}</th>
                            <th>{{ __('View') }}</th>
                          </tr>
                        </thead>
        
                        <tbody>
                          <?php $i=0;?>
        
                            @foreach($course as $cat)
                            @if($cat->status == 0)
                              <?php $i++;?>
                              <tr>
                                <td><?php echo $i;?></td>
                                <td>
                                  @if($cat['preview_image'] !== NULL && $cat['preview_image'] !== '')
                                    <img src="{{ asset('images/course/'.$cat['preview_image']) }}" class="img-responsive img-circle" >
                                  @else
                                    <img src="{{ Avatar::create($cat->title)->toBase64() }}" class="img-responsive img-circle" >
                                  @endif
                                </td>
                                <td>{{$cat->title}}</td>
                                <td>{{ $cat->user->fname }}</td>
                                <td>{{$cat->slug}}</td>
                               
        
                                <td>
                                  <div class="dropdown">
                                    <button class="btn btn-round btn-outline-primary" type="button"
                                        id="CustomdropdownMenuButton1" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false"><i
                                            class="feather icon-more-vertical-"></i></button>
                                    <div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton1">
                                        <a class="dropdown-item" href="{{ url('rejected/view/'.$cat->id) }}"><i
                                                class="feather icon-eye mr-2"></i>{{__('View')}}</a>
                                      
                                    </div>
                                </div>
                                  
                                </td>
        
                               
                              </tr>
                            @endif
                            @endforeach
                              
                        </tbody>
                      </table>
                  </div>
              </div>
          </div>
      </div>
  </div>
</div>
@endsection
