@extends('admin.layouts.master')
@section('title','Currency')
@section('maincontent')
<?php
$data['heading'] = 'Currency';
$data['title'] = 'Currency';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar bardashboard-card">
  <div class="row">   
    <div class="col-lg-8">
      <div class="card m-b-30">
        <div class="card-body"> 
            <div class="widgetbar">
              @can('currency.create')
                <a href="" data-toggle="modal" data-target="#addcurrency" class="btn btn-primary-rgba mr-2" title="{{ __('Add Currency') }}"> <i class="feather icon-plus mr-2"></i>{{__('Add Currency')}}</button>
                @endcan
                @can('currency.edit')
                <a href="" class="float-right btn btn-success-rgba mr-2 updateRateBtn" title="{{ __('Update Currency Rate') }}"><span id="buttontext">{{__('Update Currency Rate')}}</span></a>
                @endcan
            </div> 

            <div style="display:none;" class="alert alert-success" id="msg_div">
                  <center><span id="res_message"></span></center>
            </div>
            <div class="content-block box-body content-block-two">
                <table id="currency" class="table table-hover db">
                    <thead>
                      <tr class="table-heading-row">
                        <th>
                         #
                          
                        </th>
                        <th>{{__('Currency')}}</th>
                        <th>{{__('Code')}}</th>
                        <th>{{__('Symbol')}}</th>
                        <th>{{ __('Position') }}</th>
                        <th>{{__('Exchange Rate')}}</th>
                        <th>{{__("Action")}}</th>
                        <th>{{__("Update")}}</th>
                        <th>{{__("Default")}}</th>
                      </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
          </div>


          <div id="addcurrency" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="my-modal-title">{{ __("Add Currency") }}</h5>
                        <button class="close" data-dismiss="modal" aria-label="Close" title="{{ __('Close') }}">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                      <form action="{{ route("currency.store") }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="my-input">{{ __('Currency') }} (ISO Code 3): <span class="text-danger">*</span> </label>
                            <input required class="form-control" type="text" name="code">
                        </div>     
                      
                        <button type="submit" class="btn btn-primary" title="{{ __('Create') }}"><i class="fa fa-check-circle"></i> {{ __('Create') }} </button>
                      </form>
                    </div>
                </div>
            </div>
        </div>
      </div>  
    </div>
    <div class="col-lg-4">
      <div class="card m-b-30">
        <div class="card-body">
          <div class="content-main-block mrg-t-40">
            <div class="content-block box-body content-block-two" style="padding:5px">
              
                <form action="{{route('currency.exchanges.save')}}" method="POST">
                    @csrf
                    <small>
                      <a target="__blank" title="{{ __('Get Your OPEN EXCHANGE RATE KEY From Here') }}" class="text-info"
                        href="https://openexchangerates.org/signup/free"><i class="fa fa-key"></i> {{ __('Get Your OPEN EXCHANGE RATE KEY From Here') }} </a>
                    </small>
                    <br>
                    <div class="form-group exchange-rate-key-form">
                      <label>{{ __('OPEN EXCHANGE RATE KEY') }} : <span class="required">*</span></label>
                      <input required id="OPEN_EXCHANGE_RATE_KEY" value="{{ env('OPEN_EXCHANGE_RATE_KEY') }}"
                        name="OPEN_EXCHANGE_RATE_KEY" type="text" class="form-control"
                        placeholder="{{ __('enter OPEN EXCHANGE RATE KEY') }}">
                        <span toggle="#OPEN_EXCHANGE_RATE_KEY" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                        <small class="text-info">
                          <i class="fa fa-question-circle"></i> {{__("It will be used to fetch exchange rates of currencies.")}}
                        </small>
                    </div>
                    <div class="form-group">
                      <button type="submit"  class="btn btn-md btn-primary-rgba" title="{{ __('Save') }}">
                            <i class="fa fa-save"></i> {{ __('Save') }}
                      </button>
                    </div>
                </form>
              
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
    

@endsection
@section('script')
    
    <script>
    

        $(document).ready(function() {
           var table = $('#currency').DataTable({
                lengthChange: false,
                responsive: true,
                serverSide: true,
                ajax: '{{ route('currency.index') }}',
                columns: [

                   {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable : false, orderable : false},
                  {data : 'name', name : 'currencies.name'},
                  {data : 'code', name : 'currencies.code'},
                  {data : 'symbol', name : 'currencies.symbol'},
                  {data : 'position', name : 'position', searchable : false, orderable : false},
                  {data : 'exchange_rate', name : 'currencies.exchange_rate'},
                  {data : 'action', name : 'action', searchable : false, orderable : false},
                  {data : 'update', name : 'update', searchable : false, orderable : false},
                  {data : 'default', name : 'default', searchable : false, orderable : false},
                  
                 
                ],
                dom : 'lBfrtip',
                buttons : [
                    'csv','excel','pdf','print'
                ],
                order : [[0,'desc']]
            });

            table.buttons().container().appendTo('#userstable .col-md-3:eq(0)');
        


            $('.updateRateBtn').on('click',function(){
              $.ajax({
                  headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  },
                  type: "POST",
                  url: '{{ route("auto.update.rates") }}',
                  beforeSend: function() {
                    $('#buttontext').html('<i class="fa fa-refresh fa-spin fa-fw"></i>');
                  },
                  success: function(data) {
                    table.draw();
                    console.log(data);
                    $('#msg_div').show();
                    $('#res_message').html('');
                    $('#res_message').append(data.msg);
                    $('#buttontext').html('Update Currency Rate');
                    setTimeout(function(){
                        $('#res_message').hide();
                        $('#msg_div').hide();

                    },2000);
                  
                  },
                  error: function(XMLHttpRequest, textStatus, errorThrown) {
                    console.log(XMLHttpRequest);
                  }
                });
            });
        });
    </script>
@endsection