<div class="row">
        <div class="col-md-12">
            <!-- card started -->
            <div class="card">
              <!-- ========= -->
                <!-- to show add button start -->
                <div class="card-header">
                <div class="row align-items-center">
                    <div class="col-md-7">
                    <!-- <div class="card-header">
                        <h5 class="card-title">{{ __('.Language') }}</h5>
                    </div>  -->
                    </div> 
                    <div class="col-md-5">
                    <div class="widgetbar">
                        @can(' site-settings.language.create')
                    <a href="{{ action('LanguageController@create') }}" class="float-right btn btn-primary-rgba mr-2"><i class="feather icon-plus mr-2"></i>{{ __('Add Language') }}</a>
                    @endcan
                    </div>
                    </div>
                </div>
                </div>
                <!-- to show add button end -->
                <!-- card body started -->
                <div class="card-body">
                <div class="table-responsive">
                          <!-- table to display faq start -->
                          <table id="datatable-buttons1" class="table table-striped table-bordered">
                              <thead>
                                    <th>
                                     # 
                                    </th>
                                  <th>{{ __('Name') }}</th>
                                  <th>{{ __('Local') }}</th>
                                  <th>{{ __('Default') }}</th>
                                  <th>{{ __('Action') }}</th>
                              </thead>
                              @if ($languages)
                              <tbody>
                                  @foreach ($languages as $key => $language)
                                  <tr>
                                  <td>{{  $key+1 }}</td>
                                  <td>{{$language->name}}</td>
                                  <td>{{$language->local}}</td>
                                  <td align="left">
                                    @if($language->def ==1)
                                      <i class="text-success fa fa-check"></i>
                                    @else
                                      <i class="text-danger fa fa-times"></i>
                                    @endif
                                  </td>
                                  <td>
                                      <div class="dropdown">
                                          <button class="btn btn-round btn-outline-primary" type="button" id="CustomdropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="feather icon-more-vertical-"></i></button>
                                          <div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton1">
                                              {{-- <a class="dropdown-item" href="{{route('frontstatic.lang', $language->local)}}"><i class="feather icon-edit mr-2"></i>{{__('Edit')}}</a> --}}

                                              <a class="dropdown-item" href="{{url('admin/languages/'. $language->local.'/translations')}}"><i class="feather icon-edit mr-2"></i>{{__('Edit')}}</a>
                                          </div>
                                      </div>
                                  </td>
                                      
                                  </tr> 
                                  @endforeach
                              </tbody>
                              @endif
                          </table>                  
                          <!-- table to display faq data end -->                
                    </div><!-- table-responsive div end -->
                </div><!-- card body end -->
            </div><!-- card end -->
        </div><!-- col end -->
    </div><!-- row end -->
<script>
    $("#checkboxAll").on('click', function () {
$('input.check').not(this).prop('checked', this.checked);
});
</script>