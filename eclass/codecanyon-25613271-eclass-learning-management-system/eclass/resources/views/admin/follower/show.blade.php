@extends('admin.layouts.master')
@section('title','Followers & Followings')
@section('maincontent')
<?php
$data['heading'] = 'Followers & Followings';
$data['title'] = 'Followers & Followings';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar"> 
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-body">
       <div class="col-md-12">
      <div class="card dashboard-card m-b-30">
          <div class="card-header all-user-card-header">
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true" title="{{ __('Followers') }}">{{ __('Followers') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false" title="{{ __('Followings') }}">{{ __('Followings') }}</a>
                </li>
            </ul>
          </div>
          <div class="tab-content" id="pills-tabContent">
              <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                @include('admin.follower.follower')
              </div>
              <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                @include('admin.follower.following')
              </div>
              
          </div>
          
      </div>
  </div>
       </div>
      </div>
    </div>
  </div>
</div>
@endsection