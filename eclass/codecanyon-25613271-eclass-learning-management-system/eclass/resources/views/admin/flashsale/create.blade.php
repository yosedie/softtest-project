@extends('admin.layouts.master')
@section('title','Create Flash Deal | ')
@section('maincontent')
<?php
$data['heading'] = 'Create Flash Deal';
$data['title'] = 'Flash Deals';
$data['title1'] = 'Create Flash Deal';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar dashboard-card">
    <div class="row">
        <div class="col-md-12 mb-3">
            @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                @foreach($errors->all() as $error)
                <p>{{ $error}}<button type="button" class="close" data-dismiss="alert" aria-label="Close" title="{{ __('Close') }}">
                        <span aria-hidden="true" style="color:red;">&times;</span></button></p>
                @endforeach
            </div>
            @endif
            <div class="card dashboard-card m-b-30">
                <div class="card-header">
                    <h3 class="card-title">
                        {{__("Create New Flash Deal")}}
                    </h3>
                    <div class="widgetbar">
                        <a href=" {{ route('flash-sales.index') }}" class="btn btn-primary-rgba mr-2" title="{{ __('Back') }}">
                            <i class="feather icon-arrow-left mr-2"></i> {{__("Back")}}
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <form action="{{ route('flash-sales.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                    <div class="row">
                        <div class="form-group col-md-3">

                            <label for="">{{ __("Deal Name:") }} <span class="text-danger">*</span> </label>
                            <input type="text" class="form-control" class="required" name="title"
                                placeholder="{{ __('Enter Deal Name:') }}" value="{{ old('title') }}">
                        </div>

                        <div class="form-group col-md-3">
                            <label for="">{{ __("Banner Image:") }} <span class="text-danger">*</span> </label>
                            <div class="input-group ">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroupFileAddon01">{{ __('Upload') }}</span>
                                </div>
                                <div class="custom-file">

                                    <input accept="image/*" required type="file" name="background_image" class="custom-file-input"
                                        id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                    <label class="custom-file-label" for="inputGroupFile01">{{ __('Choose Image') }}
                                         {{__('Recommended Size: 2000x2000PX')}}</label>
                                </div>

                            </div>
                        </div>
                   
                        <div class="form-group col-md-3">
                            <label for="">{{ __("Start Date:") }} <span class="text-danger">*</span> </label>
                            <input required value="{{ old('start_date') ?? now()->addDays(1)->format('Y-m-d h:i a') }}"
                                type="text" class="timepickerwithdate form-control" class="required"
                                name="start_date" />
                        </div>

                        <div class="form-group col-md-3">
                            <label for="">{{ __("End Date:") }} <span class="text-danger">*</span> </label>
                            <input required value="{{ old('end_date') ?? now()->addDays(7)->format('Y-m-d h:i a') }}"
                                type="text" class="timepickerwithdate form-control" class="required" name="end_date" />
                        </div>
                        
                    </div>
                        <div class="form-group">
                            <label for="">{{ __("Details:") }}</label>
                            <textarea name="detail" id="detail" cols="30" rows="2">{{ old("detail") }}</textarea>
                        </div>

                       

                        <h4>{{ __('Select Courses') }}</h4>

                        <table class="courselist table table-bordered table-hover">
                            <thead>
                                <th>{{ __('Courses') }}</th>
                                <th>{{ __('Discount') }}</th>
                                <th>{{ __("Discount Type") }}</th>
                                <th>
                                    {{ __('#') }}
                                </th>
                            </thead>

                            <tbody>

                                @if(!old('course'))

                                    <tr>
                                        <td>
                                            <input type="text" class="course_name form-control" placeholder="{{ __('Search Course') }}"
                                                required name="course[]">
                                            
                                            <input type="hidden" class="form-control course_ids" name="course_id[]">
                                        </td>
                                        <td>
                                            <div class="input-group">

                                                <input type="number" min="1" class="form-control" placeholder="50" required
                                                    name="discount[]">
                                                <span class="input-group-text">
                                                    %
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <select name="discount_type[]" class="mt-3 form-control" id="discount_type">
                                                    <option value="">{{ __('Select Discount Type') }}</option>
                                                    <option value="fixed">{{ __('Fixed') }}</option>
                                                    <option value="upto">{{ __('Up-to') }}</option>
                                                </select>
                                            </div>
                                        </td>
                                        <td>
                                            <button type="button" class="addnew btn-primary-rgba btn-sm">
                                                <i class="feather icon-plus"></i>
                                            </button>
                                            <button type="button" class="removeBtn btn-danger-rgba btn-sm">
                                                <i class="feather icon-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @else 
                                    @foreach(old('course') as $key => $course)                                    
                                        <tr>
                                            <td>
                                                <input type="text" class="course_name form-control" placeholder="Search course"
                                                    required name="course[]" value="{{ $course ?? '' }}">                                               
                                                <input type="hidden" value="{{ old('course_id')[$key] }}" class="form-control course_ids" name="course_id[]">
                                            </td>
                                            <td>
                                                <div class="input-group">

                                                    <input value="{{ old('discount')[$key] }}" type="number" min="1" class="form-control" placeholder="50" required
                                                        name="discount[]">
                                                    <span class="input-group-text">
                                                        %
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <select name="discount_type[]" class="mt-3 form-control" id="discount_type">
                                                        <option value="">{{ __('Select Discount Type') }}</option>
                                                        <option {{ old('discount_type')[$key] == 'fixed' ? "selected" : "" }} value="fixed">{{ __('Fixed') }}</option>
                                                        <option {{ old('discount_type')[$key] == 'upto' ? "selected" : "" }} value="upto">{{ __('Upto') }}</option>
                                                    </select>
                                                </div>
                                            </td>
                                            <td>
                                                <button type="button" class="addnew btn-primary-rgba btn-sm">
                                                    <i class="feather icon-plus"></i>
                                                </button>
                                                <button type="button" class="removeBtn btn-danger-rgba btn-sm">
                                                    <i class="feather icon-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                
                                    @endforeach

                                @endif
                            </tbody>
                        </table>
                        <div class="form-group col-md-12">
                            <label>{{ __('Status') }} :</label>
                            <br>
                            <label class="switch">
                                <input id="status" type="checkbox" name="status" {{ old('status') ? "checked" : "" }}>
                                <span class="knob"></span>
                            </label>
                        </div>
                        <div class="form-group">
                            <button type="reset" class="btn btn-danger-rgba mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
                            <button type="submit" class="btn btn-primary-rgba" title="{{ __('Create') }}">
                                <i class="feather icon-plus"></i> {{__("Create")}}
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
function enableAutoComplete($element) {

        $element.autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: @json(route('test.fetch')),
                    data: {
                        term: request.term
                    },
                    dataType: "json",
                    success: function (data) {

                        var resp = $.map(data, function (obj) {
                            return {
                                value: obj.value,
                                label: obj.label,
                                id: obj.id
                            }
                        });

                        response(resp);
                    }
                });
            },
            select: function (event, ui) {

                if (ui.item.value != 'No result found') {
                    this.value = ui.item.value.replace(/\D/g, '');
                    // $(this).closest('td').find('input.product_type').val(ui.item.type);
                    $(this).closest('td').find('input.course_ids').val(ui.item.id);
                } else {
                    $(this).val('');
                    // $(this).closest('td').find('input.product_type').val('');
                    $(this).closest('td').find('input.course_ids').val('');
                    return false;
                }

            },
            minlength: 1,

        });
    }

    $(document).ready(function () {
        $(".course_name").each(function (index) {
            enableAutoComplete($(this));
        });
    });

    $(".courselist").on('click', 'button.addnew', function () {

        var n = $(this).closest('tr');
        addNewRow(n);


        function addNewRow(n) {

            // e.preventDefault();

            var $tr = n;
            var allTrs = $tr.closest('table').find('tr');
            var lastTr = allTrs[allTrs.length - 1];
            var $clone = $(lastTr).clone();
            $clone.find('td').each(function () {
                var el = $(this).find(':first-child');
                var id = el.attr('id') || null;
                if (id) {

                    var i = id.substr(id.length - 1);
                    var prefix = id.substr(0, (id.length - 1));
                    el.attr('id', prefix + (+i + 1));
                    el.attr('name', prefix + (+i + 1));
                }
            });

            $clone.find('input').val('');

            $tr.closest('table').append($clone);

            $('input.course_name').last().focus();

            enableAutoComplete($("input.course_name:last"));
        }

    });

    $('.courselist').on('click', '.removeBtn', function () {

        var d = $(this);
        removeRow(d);

    });

    function removeRow(d) {
        var rowCount = $('.courselist tr').length;
        if (rowCount !== 2) {
            d.closest('tr').remove();
        } else {
            console.log('Atleast one sell is required');
        }
    }
</script>
@endsection