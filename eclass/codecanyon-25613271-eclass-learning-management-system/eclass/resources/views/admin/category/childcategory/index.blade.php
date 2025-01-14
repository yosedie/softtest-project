@extends('admin.layouts.master')
@section('title','Create a new child categories')
@section('breadcum')
@section('maincontent')
<?php
$data['heading'] = 'Child Categories';
$data['title'] = 'Category';
$data['title1'] = 'Child Categories';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar dashboard-card">
  <div class="row">
    <div class="col-lg-12">
      <div class="card dashboard-card m-b-30">
        <div class="card-header">
          <h5 class="card-box">{{ __('All Child categories') }}</h5>
           <div>
              <div class="widgetbar">
                @can('childcategories.delete')
                <button type="button" class="float-right btn btn-danger-rgba mr-2 " data-toggle="modal"
                  data-target="#bulk_delete" title="{{ __('Delete Selected') }}"
><i class="feather icon-trash mr-2"></i> {{ __('Delete Selected') }}</button>
                  @endcan
                  @can('childcategories.create')
                <button type="button" class="float-right btn btn-primary-rgba mr-2" data-toggle="modal" data-target="#create" title="{{ __('Add Child Category') }}"
>
                  <i class="feather icon-plus mr-2"></i>{{ __("Add Child Category") }}</button>
                  @endcan
                </div>
            </div>
           </div>
        <div class="card-body">

          <div class="table-responsive">
            <table id="datatable-buttons" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th>
                    <input id="checkboxAll" type="checkbox" class="filled-in" name="checked[]" value="all" />
                    <label for="checkboxAll" class="material-checkbox"></label> #</th>
                  <th>{{ __('Icon') }}</th>
                  <th>{{ __('SubCategory') }}</th>
                  <th>{{ __('ChildCategory') }}</th>
                  <th>{{ __('Status') }}</th>
                  <th>{{ __('Action') }}</th>

                </tr>
              </thead>
              <tbody>
                <?php $i=0;?>
                @foreach($childcategory as $cat)
                <?php $i++;?>
                <tr>
                  <td> <input type='checkbox' form='bulk_delete_form' class='check filled-in material-checkbox-input'
                      name='checked[]' value='{{ $cat->id }}' id='checkbox{{ $cat->id }}'>
                    <label for='checkbox{{ $cat->id }}' class='material-checkbox'></label>
                    <?php echo $i; ?>
                    <div id="bulk_delete" class="delete-modal modal fade" role="dialog">
                      <div class="modal-dialog modal-sm">
                        <!-- Modal content-->
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" title="{{ __('Close') }}"
>&times;</button>
                            <div class="delete-icon"></div>
                          </div>
                          <div class="modal-body text-center">
                            <h4 class="modal-heading">{{ __('Are You Sure') }} ?</h4>
                            <p>{{ __('Do you really want to delete selected item names here? This process
                                cannot be undone') }}.</p>
                          </div>
                          <div class="modal-footer">
                            <form id="bulk_delete_form" method="post"
                              action="{{ route('childcategories.bulk_delete') }}">
                              @csrf
                              @method('POST')
                              <button type="reset" class="btn btn-gray translate-y-3"
                                data-dismiss="modal">{{ __('No') }}</button>
                              <button type="submit" class="btn btn-danger">{{ __('Yes') }}</button>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                  </td>
                  <td>
                    <div class="index-image">
                      <i class="fa {{$cat->icon}}"></i>
                    </div>
                  </td>
                  <td>@if(isset($cat->subcategory)){{$cat->subcategory->title}}@endif</td>
                  <td>{{$cat->title}}</td>
                  <td>
                    @if( $cat->status == 1)
                    <button type="button" class="btn btn-rounded btn-success-rgba pointer-remove">
                      {{ __('Active') }}
                    </button>
                        @else
                        <button type="button" class="btn btn-rounded btn-danger-rgba pointer-remove">
                        {{ __('Deactive') }}
                  </button>
                        @endif 
                  </button>
                  </td>
                  <td>
                    <div class="dropdown">
                      <button class="btn btn-round btn-outline-primary" type="button" id="CustomdropdownMenuButton1"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="{{ __('Settings') }}"
><i
                          class="feather icon-more-vertical-"></i></button>
                      <div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton1">
                        @can('childcategories.edit')
                        <a class="dropdown-item" data-toggle="modal" data-target="#edit{{ $cat->id }}" title="{{ __('Edit') }}"
><i
                            class="feather icon-edit mr-2"></i>{{ __('Edit') }}</a>
                            @endcan
                            @can('childcategories.delete')
                        <a class="dropdown-item btn btn-link" data-toggle="modal" data-target="#delete{{ $cat->id }}" title="{{ __('Delete') }}"
>
                          <i class="feather icon-delete mr-2"></i>{{ __("Delete") }}</a>
                        </a>
                        @endcan
                      </div>
                    </div>
                  </td>
                    <div class="modal fade bd-example-modal-sm" id="edit{{$cat->id}}" role="dialog" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleSmallModalLabel">{{ __('Edit ChildCategories') }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" title="{{ __('Close') }}"
>
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <form id="demo-form" method="post"
                              action="{{action('ChildcategoryController@update', $cat->id)}}" data-parsley-validate
                              class="form-horizontal form-label-left" autocomplete="off">
                              {{ csrf_field() }}
                              {{ method_field('PUT') }}

                              <div class="row">
                                <div class="col-md-12">
                                  <label for="exampleInputSlug">{{ __('Select Category') }}</label>
                                  <select name="category_id" id="category_id" class="form-control select2">
                                    @php
                                    $category = App\Categories::all();
                                    @endphp
                                    @foreach($category as $caat)
                                    <option {{ $cat->category_id == $caat->id ? 'selected' : "" }}
                                      value="{{ $caat->id }}">{{ $caat->title }}</option>
                                    @endforeach
                                  </select>
                                </div>
                              </div>
                              <br>

                              <div class="row">
                                <div class="col-md-12">
                                  <label for="exampleInputSlug">{{ __('Select SubCategory') }}</label>
                                  <select name="subcategories" id="upload_id" class="form-control select2">
                                    @php
                                    $subcategory = App\SubCategory::all();
                                    @endphp
                                    @foreach($subcategory as $caat)
                                    <option {{ $cat->subcategory_id == $caat->id ? 'selected' : "" }}
                                      value="{{ $caat->id }}">{{ $caat->title }}</option>
                                    @endforeach
                                  </select>
                                </div>
                              </div>
                              <br>

                              <div class="row">
                                <div class="col-md-12">
                                  <label for="title">{{ __('Child Category') }}:<span
                                      class="redstar">*</span></label>
                                  <input type="text" class="form-control" name="title" id="title1" value="{{$cat->title}}">
                                </div>
                              </div>
                              <br>

                              <div class="row">
                                <div class="col-md-12">
                                  <label for="slug">{{ __('Slug') }}:<span
                                      class="redstar">*</span></label>
                                  <input pattern="[/^\S*$/]+" type="text" id="slug1" class="form-control" name="slug"
                                    value="{{$cat->slug}}">
                                </div>
                              </div>
                              <br>

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
                              </div>
                              <br>

                              <div class="row">
                                <div class="col-md-12">
                                  <label for="exampleInputDetails">{{ __('Status') }}:</label><br>
                                  <input id="status" type="checkbox" class="custom_toggle" name="status"
                                    {{ $cat->status == '1' ? 'checked' : '' }} />
                                  <input type="hidden" name="free" value="0" for="status" id="status">

                                </div>
                              </div>
                              <br>


                              <div class="form-group">
                                <button type="reset" class="btn btn-danger" title="{{ __('Reset') }}"
><i class="fa fa-ban"></i>
                                  {{ __('Reset') }}</button>
                                <button type="submit" class="btn btn-primary" title="{{ __('Update') }}"
><i class="fa fa-check-circle"></i>
                                  {{ __('Update') }}</button>
                              </div>

                              <div class="clear-both"></div>
                          </div>

                          </form>
                        </div>
                      </div>
                    </div>


                    <!-- delete Modal start -->
                    <div class="modal fade bd-example-modal-sm" id="delete{{$cat->id}}" role="dialog"
                      aria-hidden="true">
                      <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleSmallModalLabel">{{ __('Delete') }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" title="{{ __('Close') }}"
>
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <h4>{{ __('Are You Sure ?')}}</h4>
                            <p>{{ __('Do you really want to delete')}} ? {{ __('This process cannot be undone.')}}</p>
                          </div>
                          <div class="modal-footer">
                            <form method="post" action="{{action('ChildcategoryController@destroy', $cat->id)}}"
                              class="pull-right">
                              {{csrf_field()}}
                              {{method_field("DELETE")}}
                              <button type="reset" class="btn btn-secondary"
                                data-dismiss="modal">{{ __('No') }}</button>
                              <button type="submit" class="btn btn-primary">{{ __('Yes') }}</button>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- delete Model ended -->

                 

                </tr>
                @endforeach
              </tbody>
            </table>
          </div>


          <div class="modal fade bd-example-modal-sm" id="create" role="dialog" aria-hidden="true">
            <div class="modal-dialog col-md">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleSmallModalLabel">{{ __('Add New Childcategory') }}</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close" title="{{ __('Close') }}"
>
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form method="post" action="{{route('childcategory.store')}}" data-parsley-validate
                    class="form-horizontal form-label-left" autocomplete="off">
                    {{ csrf_field() }}
                    <div class="row">
                      <div class="col-md-12">
                        <label for="category">{{ __('Category') }}</label>
                        <select name="category_id" id="category_id" class="form-control select2">
                          <option value="0">{{ __('Please Select') }}
                            {{ __('Category') }}</option>
                          @foreach($category as $cat)
                          <option value="{{$cat->id}}">{{$cat->title}}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-10">
                        <label for="subcategory">{{ __('SubCategory') }}</label>
                        <select name="subcategories" mt-6name="subcategories" id="upload_id"
                          class="form-control select2">
                          <option value="0">{{ __('Please Select') }}
                            {{ __('SubCategory') }}</option>
                          @foreach($subcategory as $cat)
                          <option value="{{$cat->id}}">{{$cat->title}}</option>
                          @endforeach
                        </select>
                      </div>

                      <div class="col-md-2">
                        <br>
                        <button type="button" data-dismiss="modal" data-toggle="modal" data-target="#myModal7"
                          title="AddCategory" class="btn btn-md btn-primary">+</button>
                      </div>
                    </div>
                    <br>

                    <div class="row">
                      <div class="col-md-12">
                        <label for="title">{{ __('ChildCategory') }}:<sup class="redstar">*</sup></label>
                        <input type="text" class="form-control" name="title" id="title"
                          placeholder="Please Enter your childcategory">
                      </div>


                      <div class="col-md-12">
                        <label for="slug">{{ __('Slug') }}:<sup class="redstar">*</sup></label>
                        <input  type="text" class="form-control" name="slug" id="slug"
                          placeholder="Please Enter slug">
                      </div>



                    </div>
                    <br>

                    <div class="row">

                      <div class="col-md-12">
                        <label for="icon">{{ __('Icon') }}:</label>

                        <div class="input-group">
                          <input type="text" class="form-control iconvalue" name="icon" value="Choose icon">
                          <span class="input-group-append">
                            <button type="button" class="btnicon btn btn-outline-secondary" role="iconpicker"></button>
                          </span>
                        </div>
                      </div>


                      <div class="col-md-6">
                        <label for="exampleInputDetails">{{ __('Status') }}:</label>
                        <br>
                        <input class="custom_toggle" type="checkbox" name="status" checked />


                        <label class="tgl-btn" data-tg-off="Disable" data-tg-on="Enable" for="status"></label>

                        <input type="hidden" name="free" value="0" for="status" id="status">
                      </div>
                    </div>
                    <br>

                    <div class="box-footer">
                      <button type="submit" class="btn btn-lg col-md-3 btn-primary"  title="{{ __('Create') }}"
>{{ __('Create') }}</button>
                    </div>
                  </form>
                </div>

              </div>
            </div>
          </div>



        </div>
      </div>
    </div>
    <!-- End col -->
  </div>
  <!-- End row -->
</div>
@include('admin.category.childcategory.child')

@endsection
@section('script')
<script>
  $(document).on("change", ".childcategory", function () {
    $.ajax({
      type: "GET",
      dataType: "json",
      url: 'childcategories/status',
      data: {
        'status': $(this).is(':checked') ? 1 : 0,
        'id': $(this).data('id')
      },
      success: function (data) {
        var warning = new PNotify({
          title: 'success',
          text: 'Status Update Successfully',
          type: 'success',
          desktop: {
            desktop: true,
            icon: 'feather icon-thumbs-down'
          }
        });
        warning.get().click(function () {
          warning.remove();
        });
      }
    });

  })
</script>
<script>
  $("#checkboxAll").on('click', function () {
    $('input.check').not(this).prop('checked', this.checked);
  });
</script>
<script>
  "use strict";

  $(function () {
    var urlLike = '{{ url('
    admin / dropdown ') }}';
    $('#category_id').change(function () {
      var up = $('#upload_id').empty();
      var cat_id = $(this).val();
      if (cat_id) {
        $.ajax({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: "GET",
          url: urlLike,
          data: {
            catId: cat_id
          },
          success: function (data) {
            console.log(data);
            up.append('<option value="0">Please Choose</option>');
            $.each(data, function (id, title) {
              up.append($('<option>', {
                value: id,
                text: title
              }));
            });
          },
          error: function (XMLHttpRequest, textStatus, errorThrown) {
            console.log(XMLHttpRequest);
          }
        });
      }
    });
  });
  (jQuery);
</script><script>
  function createSlug(input) {
      return input
          .toLowerCase()
          .replace(/ /g, "-")
          .replace(/[^a-z0-9-]/g, "");
  }
  $("#title").on("input", function () {
      const headingValue = $(this).val();
      const slugValue = createSlug(headingValue);
      $("#slug").val(slugValue);
  });
      </script>
          <script>
            function createSlug1(input) {
                return input
                    .toLowerCase()
                    .replace(/ /g, "-")
                    .replace(/[^a-z0-9-]/g, "");
            }
            $("#title1").on("input", function () {
                const headingValue1 = $(this).val();
                const slugValue1 = createSlug(headingValue1);
                $("#slug1").val(slugValue1);
            });
                </script>
@endsection