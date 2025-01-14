@extends('admin.layouts.master')
@section('title','All Assignments')
@section('maincontent')
<?php
$data['heading'] = 'All Assignments';
$data['title'] = 'Courses';
$data['title1'] = 'Assignments';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar dashboard-card">
  <div class="row">

    <div class="col-lg-12">
      <div class="card dashboard-card m-b-30">
        <div class="card-header">
          <h5 class="box-title">{{ __('All Assignments') }}</h5>
        </div>
        <div class="card-body">

          <div class="table-responsive">
            <table id="datatable-buttons" class="table table-striped table-bordered">
              <thead>
                <tr>

                  <th>#</th>
                  <th>{{ __('Course') }}</th>
                  <th>{{ __('View Assignment') }}</th>
                </tr>
              </thead>
              <tbody>
                <?php $i=0;?>
                @foreach($courses as $course)
                <?php $i++;?>
                <tr>
                  <td><?php echo $i;?></td>
                  
                  <td>
                    <p><b>{{ __('course') }}:</b> {{ $course['title'] }}</p>

                  </td>
                <td>
                  <a type="button" href="{{ route('list.assignment',$course->id) }}" class="btn btn-rounded btn-primary-rgba" title="{{ __('View') }}">{{ __('View') }}</a>

                </td>
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