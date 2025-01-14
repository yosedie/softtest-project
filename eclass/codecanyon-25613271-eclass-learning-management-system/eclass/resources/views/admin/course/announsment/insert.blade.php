@extends('admin.layouts.master')
@section('title','Create a new announcement')
@section('maincontent')
<?php
$data['heading'] = 'Create a new announcement';
$data['title'] = 'Create a new announcement';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar dashboard-card">
  @if ($errors->any())
<div class="alert alert-danger">
  <ul>
    @foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
  </ul>
</div>
@endif
  <div class="row">
    <div class="col-lg-12">
      <div class="card dashboard-card m-b-30">
        <div class="card-header">
          <h5 class="box-tittle">{{ __('Add') }} {{ __('User') }}</h5>
        </div>
        <div class="card-body">
          <form id="demo-form2" method="post" action="{{ route('announsment.store') }}" data-parsley-validate class="form-horizontal form-label-left">
            {{ csrf_field() }}
                      
           
            <label class="d-none" for="exampleInputSlug"> {{ __('Course') }}<span class="required" >*</span></label>
            <select name="course_id" class="form-control select2 d-none">
              <option value="{{ $cor->id }}">{{ $cor->title }}</option>
            </select>
        
            <label class="d-none"  for="exampleInputTit1e">{{ __('User') }}</label>

            <select class="d-none" name="user_id" class="form-control col-md-7 col-xs-12">
              @php
               $users = App\User::all();
              @endphp

              @foreach($users as $us)
              <option value="{{$us->id}}">{{$us->fname}}</option>
              @endforeach
            </select>
            
            <div class="row">
              <div class="col-md-12">
                <label for="exampleInputDetails">{{ __('Announcement') }}:<sup class="redstar">*</sup></label>

                <textarea name="announsment" id="editor6" rows="2" class="form-control select2" placeholder="Enter Your Announcement"></textarea>
              </div>
            </div>
            <br>

            <div class="row">
              <div class="col-md-12">
                <label for="exampleInputDetails">{{ __('Status') }}:</label>
                <input id="uuuu"  type="checkbox" class="custom_toggle" name="status" checked />

                  <label class="tgl-btn" data-tg-off="Deactive" data-tg-on="Active" for="uuuu"></label>
               
                <input type="hidden" name="status" value="1" id="uuuuu">
              </div>
            </div>
            <br>
      
            <div class="form-group">
              <button type="reset" class="btn btn-danger-rgba"><i class="fa fa-ban"></i> {{ __('Reset') }}</button>
              <button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
                {{ __('Create') }}</button>
            </div>

            <div class="clear-both"></div>
         
        </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('script')


  <script>
  tinymce.init({
  selector: '#editor1,#editor2,.editor',
  height: 350,
  menubar: 'edit view insert format tools table tc',
  autosave_ask_before_unload: true,
  autosave_interval: "30s",
  autosave_prefix: "{path}{query}-{id}-",
  autosave_restore_when_empty: false,
  autosave_retention: "2m",
  image_advtab: true,
  plugins: [
    'advlist autolink lists link image charmap print preview anchor',
    'searchreplace visualblocks fullscreen',
    'insertdatetime media table paste wordcount'
  ],
  toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media  template link anchor codesample | a11ycheck ltr rtl | showcomments addcomment',
  content_css: '//www.tiny.cloud/css/codepen.min.css'
});
</script>
@endsection