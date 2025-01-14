<section class="content">
  <div class="row">
    <div class="col-xs-12">

        <!-- /.box-header -->
        <div class="box-body">
          <form action="{{ route('sw.update') }}" method="POST">
              @csrf            
              <div class="form-group">
                <label>{{__('Service Worker Setting:')}}</label>
                <textarea name="swupdate" class="form-control" id="" cols="30" rows="25">{{ $swjs }}</textarea>
              </div>
              <div class="box-footer">
              <button type="submit" class="btn btn-md col-md-2 btn-flat btn-primary" title="{{ __('Save')}}">{{__('Save')}}
              </button>
          </form>
        </div>
        <!-- /.box-body -->
     
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->
</section>