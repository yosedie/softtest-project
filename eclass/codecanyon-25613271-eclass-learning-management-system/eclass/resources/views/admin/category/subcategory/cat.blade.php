@if ($errors->any())
<div class="alert alert-danger">
  <ul>
    @foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
  </ul>
</div>
@endif
<div class="modal fade" id="myModal9" z-index="1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" title="{{ __('Close') }}"
><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('cat.store') }}" method="POST">
          {{ csrf_field() }}



          <div class="row">
            <div class="col-md-6">
              <label for="category">{{ __('Name') }}:<sup class="redstar">*</sup></label>
              <input required placeholder="Enter Category name" type="text" class="form-control" name="category">
            </div>

             <div class="col-md-6">
              <label for="category">{{ __('Slug') }}:<sup class="redstar">*</sup></label>
              <input pattern="[/^\S*$/]+" required placeholder="Enter Category name" type="text" class="form-control" id="slug" name="slug">
            </div>


           


          </div>
         
          <br>

          <div class="row">

             <div class="col-md-6">
              <label for="icon">{{ __('Icon') }}:<sup class="redstar"></sup></label>
              <input type="text" class="form-control icp-auto icp" name="icon" required placeholder="Choose Icon">
            </div>



          <div class="col-md-3">
                   
            <label for="exampleInputDetails">{{ __('Status') }}:</label>
            <br>
            
              
              <input  id="c1001" type="checkbox" class="custom_toggle" name="status" checked/>

              <label class="tgl-btn" data-tg-off="Deactive" data-tg-on="Active" for="c1001"></label>
          
            <input type="hidden" name="status" value="0" id="t1001">


          </div>

          <div class="col-md-3">
            <label for="exampleInputDetails">{{ __('Featured') }}:</label>
            <input  id="featured" type="checkbox" class="custom_toggle" name="featured" checked/>        
             
              <label class="tgl-btn" data-tg-off="Disable" data-tg-on="Enable" for="featured"></label>
            
            <input type="hidden"  name="free" value="0" for="featured" id="featured">
          </div>

        </div>
          <br>

          <input type="submit" value="Save" class="btn btn-md btn-primary-rgba">

        </form>
      </div>

    </div>
  </div>
</div>