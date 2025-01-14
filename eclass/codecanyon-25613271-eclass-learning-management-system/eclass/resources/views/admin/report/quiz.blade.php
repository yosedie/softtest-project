@extends('admin.layouts.master')
@section('title','Quiz Reports')
@section('maincontent')
<?php
$data['heading'] = 'Quiz Reports';
$data['title'] = 'Reports';
$data['title1'] = 'Quiz Reports';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar"> 
  <div class="row">
    <div class="col-lg-12">
          <div class="card dashboard-card m-b-30">
              <div class="card-header">
                  <h5 class="card-title">{{ __('Quiz Reports') }}</h5>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                      <table id="datatable-buttons" class="table table-striped table-bordered">
                          <thead>
                            <tr>
                              <th>#</th>
                              <th>{{__('User Name')}}</th>
                              <th>{{__('Action')}}</th>
                              </tr>
                          </thead>
                          <tbody>
                            
                              @foreach($user as $key => $u)
                             
                                <tr>
                                  <td>
                                    {{$key+1}}
                                  </td>
                                 
                                
                                  <td>{{$u->fname}} {{$u->lname}}</td>               
                                <td>
                                  <div class="btn-group mr-2">
                                            <a  href="{{url('show/quiz/report/'.$u->id)}}" class="btn btn-xs btn-primary-rgba" title="{{ __('View') }}"><i class="feather icon-eye mr-2"></i>{{ __('View') }}</a>
                                </div>
                                </td>
                                  
                                </tr> 
                              @endforeach
            
                          
                          </tbody>
             
            </table>
          </div>
      </div>
  </div>
</div>
<!-- End col -->
</div>
<!-- End row -->
</div>
@endsection

