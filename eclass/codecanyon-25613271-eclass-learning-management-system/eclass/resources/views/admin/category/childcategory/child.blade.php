@if ($errors->any())
<div class="alert alert-danger">
  <ul>
    @foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
  </ul>
</div>
@endif
         
<div class="modal fade" id="myModal7" z-index="1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleSmallModalLabel">{{ __('Add Subcategory') }}</h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
          <form action="{{ route('child.store') }}" method="POST">
          {{ csrf_field() }}

          <label for="exampleInputTit1e">{{ __('Category') }}</label>
          <div class="row">
            <div class="col-sm-12">
                <select name="categories" class="form-control select2">
                  @foreach($category as $cate)
                    <option value="{{$cate->id}}">{{$cate->title}}</option>
                    @endforeach
                </select>
            </div>
            <br>
          </div>
          <br>
                
          <div class="row">
            <div class="col-sm-12">
              <label for="exampleInputTit1e">{{ __('SubCategory') }}:<sup class="redstar">*</sup></label>
              <input type="text" class="form-control" name="title" id="exampleInputTitle" placeholder="Enter Your subcategory" value="">
            </div>
            <br>
          </div>
          <br>

          <div class="row">
            <div class="col-sm-12">
              <label for="exampleInputTit1e">{{ __('Slug') }}:<sup class="redstar">*</sup></label>
              <input pattern="[/^\S*$/]+" type="text" class="form-control" name="slug" id="exampleInputTitle" placeholder="Enter slug" value="">
            </div>
            <br>
          </div>
          <br>
        @isset($cat)
          <div class="row">
            <div class="col-md-12">
              <label for="icon">{{ __('Icon') }}:</label>
              <div class="input-group">
                <input type="text" class="form-control iconvalue" name="icon"
                  value="{{$cat->icon}}">
                <span class="input-group-append">
                  <button type="button" class="btnicon btn btn-outline-secondary"
                    role="iconpicker"></button>
                </span>
              </div>
            </div>
            <br>
            <div class="col-md-12 form-group">
              <label for="exampleInputDetails">{{ __('Status') }}:</label>
              <br>
               
                <input id="c101"   class="custom_toggle" name="status" type="checkbox" checked/>
                <label class="tgl-btn" data-tg-off="Deactive" data-tg-on="Active" for="c101"></label>
                
               
                <input type="hidden" name="status" value="0" id="t101">
            </div>
          </div>
@endisset
              <div class="box-footer">
                <button type="submit" class="btn btn-primary-rgba">{{ __('Save') }}</button>
              </div>
             
            </form>
          </div>
          <!-- /.box -->
 
          </div>
          <!-- /.box -->
        </div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
</section> 



