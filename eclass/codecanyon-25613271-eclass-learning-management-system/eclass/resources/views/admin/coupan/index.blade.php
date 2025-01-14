@extends('admin.layouts.master')
@section('title','Coupons')
@section('maincontent')
<?php
$data['heading'] = 'Coupons';
$data['title'] = 'Coupons';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar dashboard-card"> 
  <div class="row">
      <div class="col-lg-12">
          <div class="card dashboard-card m-b-30">
              <div class="card-header">
                  <h5 class="card-box">{{ __('All Coupons') }}</h5>
                  <div class="widgetbar">
                    @can('coupons.delete')
                    <button type="button" class="float-right btn btn-danger-rgba mr-2 " data-toggle="modal" data-target="#bulk_delete" title="{{ __('Delete Selected') }}"><i
                      class="feather icon-trash mr-2"></i> {{ __('Delete Selected') }}</button>
                      @endcan
                      @can('coupons.create')
                    <a href="{{ route('coupon.create') }}"  class="float-right btn btn-primary-rgba mr-2" title="{{ __('Add Coupon') }}"><i class="feather icon-plus mr-2"></i>{{ __('Add Coupon') }}</a>
                  @endcan
                  </div> 
              </div>
              <div class="card-body">
              
                  <div class="table-responsive">
                      <table id="datatable-buttons" class="table table-striped table-bordered">
                          <thead>
                    <th> <input id="checkboxAll" type="checkbox" class="filled-in" name="checked[]"
                      value="all" /> {{ __('ID') }}  </th>
                  <label for="checkboxAll" class="material-checkbox"></label></th>
                    <th>{{ __('Coupon Code') }}</th>
                    <th>{{ __('Amount') }}</th>
                    <th>{{ __('Max Usage') }}</th>
                    <th>{{ __('Detail') }}</th>
                    <th>{{ __('Action') }}</th>
                  </thead>
  
                  <tbody>
                    @foreach($coupans as $key=> $cpn)
                      <tr>
                        <td>                         
                              <input type='checkbox' form='bulk_delete_form' class='check filled-in material-checkbox-input'
                                  name='checked[]' value='{{ $cpn->id }}' id='checkbox{{ $cpn->id }}'>
                              <label for='checkbox{{ $cpn->id }}' class='material-checkbox'></label>
                        
                          <div id="bulk_delete" class="delete-modal modal fade" role="dialog">
                              <div class="modal-dialog modal-sm">
                                  <!-- Modal content-->
                                  <div class="modal-content">
                                      <div class="modal-header">
                                          <button type="button" class="close" data-dismiss="modal" title="{{ __('Close') }}">&times;</button>
                                          <div class="delete-icon"></div>
                                      </div>
                                      <div class="modal-body text-center">
                                          <h4 class="modal-heading">{{ __('Are You Sure') }} ?</h4>
                                          <p>{{ __('Do you really want to delete selected item names here? This process
                                              cannot be undone') }}.</p>
                                      </div>
                                      <div class="modal-footer">
                                          <form id="bulk_delete_form" method="post"
                                              action="{{ route('coupon.bulk_delete') }}">
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
                          {{ $key+1 }}
                      </td>
                       
                        <td>{{ $cpn->code }}</td>
                        
                        <td>@if($cpn->distype == 'fix') <i class="fa {{ $currency->icon }}"></i> @endif {{ $cpn->amount }}@if($cpn->distype == 'per')% @endif </td>
                        <td>{{ $cpn->maxusage }}</td>
                        <td>
                          <p>{{ __('Linked to') }}: <b>{{ ucfirst($cpn->link_by) }}</b></p>
                          <p>{{ __('Expiry Date') }}: <b>{{ date('d-M-Y',strtotime($cpn->expirydate)) }}</b></p>
                          <p>{{ __('Discount Type') }}: <b>{{ $cpn->distype == 'per' ? "Percentage" : "Fixed Amount" }}</b></p>
                           <p>{{ __('Coupon Code Display on front') }}: <b> 
                             @if($cpn->show_to_users == '1')
                                {{ __('Yes') }}
                              @else
                                {{ __('No') }}
                              @endif
    
                           </b></p>
                        </td>
                        <td>
                            @if (isset($cpn->stripe_coupon_id))
                            -
                        @else
                        <div class="btn-group mr-2">
                          <div class="dropdown">
                              <button class="btn btn-round btn-primary-rgba" type="button" id="CustomdropdownMenuButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="{{ __('Settings') }}"><i class="feather icon-more-vertical-"></i></button>
                              <div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton3">
                                @can('coupons.edit')
                                  <a class="dropdown-item" href="{{ route('coupon.edit',$cpn->id) }}" class="btn btn-xs btn-success-rgba" title="{{ __('Edit') }}"><i class="feather icon-edit-2"></i> {{ __('Edit') }}</a>
                                  @endcan
                                  @can('coupons.delete')
                                  <a class="dropdown-item btn btn-link" data-toggle="modal" data-target="#delete{{$cpn->id}}" title="{{ __('Delete') }}">
                                    <i class="feather icon-delete mr-2"></i> {{ __("Delete") }}</a>
                                </a>
                                @endcan
                 
                          </div>
                      </div>
                          @endif
                        </td>
                        
    
                        <div id="delete{{ $cpn->id }}" class="delete-modal modal fade" role="dialog">
                            <div class="modal-dialog modal-sm">
                              <!-- Modal content-->
                              <div class="modal-content">
                                <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal" title="{{ __('Close') }}">&times;</button>
                                  <div class="delete-icon"></div>
                                </div>
                                <div class="modal-body text-center">
                                  <h4 class="modal-heading">{{ __('Are You Sure') }} ?</h4>
                                  <p>{{ __('Do you really want to delete this Coupon ? This process cannot be undone') }}.</p>
                                </div>
                                <div class="modal-footer">
                                     <form method="post" action="{{route('coupon.destroy',$cpn->id)}}" class="pull-right">
                                        {{csrf_field()}}
                                        {{method_field("DELETE")}}
    
                                     <button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">{{ __('No') }}</button>
                                    <button type="submit" class="btn btn-danger">{{ __('Yes') }}</button>
                                  </form>
                                </div>
                              </div>
                            </div>
                        </div>
                      </tr>
                    @endforeach
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
@section('script')

<script>
  $("#checkboxAll").on('click', function () {
  $('input.check').not(this).prop('checked', this.checked);
});
</script>
@endsection