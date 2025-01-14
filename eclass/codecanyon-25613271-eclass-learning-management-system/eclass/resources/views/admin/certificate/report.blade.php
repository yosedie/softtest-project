@extends('admin.layouts.master')
@section('title','Certificate Report')
@section('maincontent')
<?php
$data['heading'] = 'Certificates Reports';
$data['title'] = 'Reports';
$data['title1'] = 'Certificates Reports';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar dashboard-card"> 
  <div class="row">
    <div class="col-lg-12">
          <div class="card dashboard-card m-b-30">
              <div class="card-header">
                  <h5 class="card-title">{{ __('Certificates Reports') }}</h5>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                      <table id="datatable-buttons" class="table table-striped table-bordered">
                          <thead>
                            <tr>
                              <th>#</th>
                              <th>{{ __('User Name') }}</th>
                              <th>{{ __('Email') }}</th>
                              <th>{{ __('Course') }}</th>          
                            </tr>
                          </thead>
                          <tbody>
                            @if ($progress)
                              @foreach($progress as $key => $student)
                                <tr>
                                  <td>
                                    {{$key+1}}
                                  </td>
                                  <td>{{$student->fname}}</td>
                                  <td>{{$student->email}}</td>
                                  <td>{{$student->title}}</td>  
                                </tr>
                              @endforeach
            
                            @endif
                          </tbody>
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

