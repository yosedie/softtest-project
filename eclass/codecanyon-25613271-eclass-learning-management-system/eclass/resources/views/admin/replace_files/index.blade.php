@extends('admin.layouts.master')
@section('title', 'Quick Updates - Admin')
@section('maincontent')
<?php
$data['heading'] = 'Quick Updates';
$data['title'] = 'Quick Updates';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar">
<div class="row">
@if ($errors->any())  
  <div class="alert alert-danger" role="alert">
  @foreach($errors->all() as $error)     
  <p>{{ $error}}<button type="button" class="close" data-dismiss="alert" aria-label="Close">
  <span aria-hidden="true" style="color:red;">&times;</span></button></p>
      @endforeach  
  </div>
  @endif
  <!-- row started -->
    <div class="col-lg-12">
        <div class="card dashboard-card m-b-30">
                <!-- Card header will display you the heading -->
                <div class="card-header">
                    <h5 class="card-box">{{ __('Quick Updates') }}</h5>
                </div> 
               
                <!-- card body started -->
                <div class="card-body">
                    <div class="card-body bg-success-rgba">
                        <div class="row align-items-center">
                            <div class="col-12">
                                <small class="text-success process-fonts"><i class="fa fa-info-circle"></i> {{ __('ImportantNote') }}

                                <ul class="process-font">
                                    <li>
                                        {{__("Quick update is for bug fix update of version " . env('APP_VERSION'))}}
                                    </li>
                                    <li>
                                        {{__("Click to quick update when update is available.")}}
                                    </li>
                                </ul>
                                
                            </div>
                        </div>
                    </div>
                <!-- ========== quick update and No Update is Available start ===================== -->
                <div class="row">
                    <!-- DemoImport start -->
                    @if($contents == !NULL)   
                    <div class="col-12">
                        <!-- ========== quick update start ===================== -->
                        <!-- form start -->
                        <form action="{{ url('replace') }}" class="form" method="POST">
                            @csrf
                            <!-- row start -->
                            <div class="row">
                                <div class="col-md-12">
                                    <!-- card start -->
                                    <div class="card">
                                        <!-- card body start -->
                                        <div class="card-body">
                                            <!-- row start -->
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <!-- row start -->
                                                    <div class="row">       
                                                            <!-- DemoImport -->
                                                            <div class="col-md-12">
                                                                <label class="text-dark">{{ __('Updates') }} {{ $app_version }} {{ __('is available') }}</label>
                                                                    <button type="submit" class="btn btn-primary btn-block">
                                                                    {{__("Click to quick update")}}
                                                                    </button>
                                                            </div>
                                                    </div><!-- row end -->
                                                </div><!-- col end -->
                                            </div><!-- row end -->
                                        </div><!-- card body end -->
                                    </div><!-- card end -->
                                </div><!-- col end -->
                            </div><!-- row end -->
                        </form>
                    <!-- form end -->
                    </div>
                    @else
                    <!-- quick update end -->
                    <!-- No Update is Available start -->
                        <div class="col-12">
                            <!-- row start -->
                            <div class="row">
                                <div class="col-md-12">
                                    <!-- card start -->
                                    <div class="card">
                                        <!-- card body start -->
                                        <div class="card-body">
                                            <!-- row start -->
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <!-- row start -->
                                                    <div class="row">       
                                                        <!-- ResetDemo -->
                                                        <div class="col-md-3">
                                                            <button type="disabled" class="btn btn-primary-rgba btn-lg btn-block">
                                                            {{__("No Update is Available !!")}}
                                                            </button>
                                                        </div>
                                                    </div><!-- row end -->
                                                </div><!-- col end -->
                                            </div><!-- row end -->
                                        </div><!-- card body end -->
                                    </div><!-- card end -->
                                </div><!-- col end -->
                            </div><!-- row end -->
                        </div>
                        @endif
                     <!-- Update is Available end -->
                </div>
                <!-- ========== quick update and No Update is Available end ===================== -->
                </div>
                <!-- card body end -->
            
        </div><!-- col end -->
    </div>
</div>
</div><!-- row end -->
    <br><br>
@endsection
<!-- main content section ended -->
<!-- This section will contain javacsript start -->
@section('script')
<!-- script for bulk detele start  -->
<script type="text/javascript">
    $(document).ready(function () {

        $('#master').on('click', function(e) {
         if($(this).is(':checked',true))  
         {
            $(".sub_chk").prop('checked', true);  
         } else {  
            $(".sub_chk").prop('checked',false);  
         }  
        });

        $('.delete_all').on('click', function(e) {

            var allVals = [];  
            $(".sub_chk:checked").each(function() {  
                allVals.push($(this).attr('data-id'));
            });  

            if(allVals.length <=0)  
            {  
                alert("Please select row.");  
            }  else {  

                var check = confirm("Are you sure you want to delete this row?");  
                if(check == true){  

                    var join_selected_values = allVals.join(","); 

                    $.ajax({
                        url: $(this).data('url'),
                        type: 'DELETE',
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: 'ids='+join_selected_values,
                        success: function (data) {
                            if (data['success']) {
                                $(".sub_chk:checked").each(function() {  
                                    $(this).parents("tr").remove();
                                });
                                alert(data['success']);
                            } else if (data['error']) {
                                alert(data['error']);
                            } else {
                                alert('Whoops Something went wrong!!');
                            }
                        },
                        error: function (data) {
                            alert(data.responseText);
                        }
                    });

                  $.each(allVals, function( index, value ) {
                      $('table tr').filter("[data-row-id='" + value + "']").remove();
                  });
                }  
            }  
        });

        $('[data-toggle=confirmation]').confirmation({
            rootSelector: '[data-toggle=confirmation]',
            onConfirm: function (event, element) {
                element.trigger('confirm');
            }
        });

        $(document).on('confirm', function (e) {
            var ele = e.target;
            e.preventDefault();

            $.ajax({
                url: ele.href,
                type: 'DELETE',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (data) {
                    if (data['success']) {
                        $("#" + data['tr']).slideUp("slow");
                        alert(data['success']);
                    } else if (data['error']) {
                        alert(data['error']);
                    } else {
                        alert('Whoops Something went wrong!!');
                    }
                },
                error: function (data) {
                    alert(data.responseText);
                }
            });

            return false;
        });
    });
</script>
<!-- script for bulk detele end  -->
<!-- script to change status start -->
<script>
  $(function() {
    $('.custom_toggle').change(function() {
        var status = $(this).prop('checked') == true ? 1 : 0; 
        
        var id = $(this).data('id'); 
        
        
        $.ajax({
            type: "GET",
            dataType: "json",
            url: 'faqinstructor-status',
            data: {'status': status, 'id': id},
            success: function(data){
              console.log(id)
            }
        });
    });
  });
</script>
<!-- script to change status end -->
@endsection
<!-- This section will contain javacsript end -->