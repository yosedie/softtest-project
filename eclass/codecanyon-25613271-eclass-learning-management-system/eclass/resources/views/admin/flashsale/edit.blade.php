@extends('admin.layouts.master')
@section('title','Edit Flash Deal | ')
@section('maincontent')
<?php
$data['heading'] = 'Edit Flash Deal';
$data['title'] = 'Flash Deals';
$data['title1'] = 'Edit Flash Deal';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar dashboard-card">
    <div class="row">
        <div class="col-md-12">
            @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                @foreach($errors->all() as $error)
                <p>{{ $error}}<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true" style="color:red;">&times;</span></button></p>
                @endforeach
            </div>
            @endif
            <div class="card dashboard-card m-b-30">
                <div class="card-header">
                    <h3 class="card-title">
                        {{__("Edit Flash Deal")}}
                    </h3>
                    <div>
                        <div class="widgetbar">
                            <a href=" {{ route('flash-sales.index') }}" class="btn btn-primary-rgba mr-2" title="{{ __('Back') }}">
                                <i class="feather icon-arrow-left mr-2"></i> {{__("Back")}}
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <form action="{{ route('flash-sales.update',$deal->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @method("PUT")
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="">{{ __("Deal Name:") }} <span class="text-danger">*</span> </label>
                                <input type="text" class="form-control" class="required" name="title"
                                    placeholder="Halloween Sale" value="{{ $deal->title }}">
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-9">
                                        <div class="form-group">
                                            <label for="">{{ __("Banner Image:") }} <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group ">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="inputGroupFileAddon01">{{ __('Upload') }}</span>
                                                </div>
                                                <div class="custom-file">

                                                    <input accept="image/*" type="file" name="background_image" class="custom-file-input"
                                                        id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                                    <label class="custom-file-label" for="inputGroupFile01">{{ __('Choose Image') }} {{__('Recommended Size: 2000x2000PX')}}</label>

                                                </div>

                                            </div>
                                        </div>  
                                    </div>
                                    <div class="col-md-3">
                                        <img title="Current banner" width="200px"
                                            src="{{ url('/images/flashdeals/'.$deal->background_image) }}"
                                            alt="{{ $deal->background_image }}" class="img-fluid rounded">
                                    </div>
                                </div>
                                
                            </div>
                        
                       
                            <div class="form-group col-md-3">
                                <label for="">{{ __("Start Date:") }} <span class="text-danger">*</span> </label>
                                <input required value="{{ date('Y-m-d h:i a',strtotime($deal->start_date)) }}" type="text"
                                    class="timepickerwithdate form-control" class="required" name="start_date" />
                            </div>

                            <div class="form-group col-md-3">
                                <label for="">{{ __("End Date:") }} <span class="text-danger">*</span> </label>
                                <input required value="{{ date('Y-m-d h:i a',strtotime($deal->end_date)) }}" type="text"
                                    class="timepickerwithdate form-control" class="required" name="end_date" />
                            </div>
                        </div>

                        

                        <div class="form-group">
                            <label for="">{{ __("Details:") }}</label>
                            <textarea name="detail" id="detail" cols="30" rows="5">{!! $deal->detail !!}</textarea>
                        </div>

                        

                        <h4>{{ __('Update Courses') }}</h4>

                        <table class="courselist table table-bordered table-hover">
                            <thead>
                                <th>{{ __('Course') }}</th>
                                <th>{{ __('Discount') }}</th>
                                <th>{{ __('Discount Type') }}</th>
                                <th>#</th>
                            </thead>

                            <tbody>
                                @forelse($deal->saleitems as $item)
                                <tr>
                                    <td>
                                        @isset( $item->courses->title)

                                        <input type="text" class="course form-control" placeholder="Search course"
                                            name="course[]" required
                                            value="{{ $item->courses->title}}" />
                                            @endisset

                                        <input type="hidden" value="{{ $item->course_id }}"
                                            class="form-control product_type" name="type[]">
                                        <input
                                            value="{{ $item->course_id }}"
                                            type="hidden" class="form-control course_ids" name="course_id[]" />
                                    </td>
                                    <td>
                                        <div class="input-group">

                                            <input value="{{ $item->discount }}" type="number" min="1"
                                                class="form-control" placeholder="50" required name="discount[]">
                                            <span class="input-group-text">
                                                %
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <select name="discount_type[]" class="mt-3 form-control" id="discount_type">
                                                <option value="">{{ __('Select Discount Type') }} </option>
                                                <option {{ $item->discount_type == 'fixed' ? "selected" : "" }}
                                                    value="fixed">{{ __('Fixed') }}</option>
                                                <option {{ $item->discount_type == 'upto' ? "selected" : "" }}
                                                    value="upto">{{ __('Up to') }}</option>
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
                                @empty
                                <tr>
                                    <td>
                                        <input type="text" class="course form-control" placeholder="Search course"
                                            required name="course[]">
                                        <input type="hidden" class="form-control course_type" name="type[]">
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
                                                <option value="upto">{{ __('Up to') }}</option>
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
                                @endforelse
                            </tbody>
                        </table>
                        <div class="form-group">
                            <label>{{ __('Status') }} :</label>
                            <br>
                            <label class="switch">
                                <input id="status" type="checkbox" name="status"
                                    {{ $deal->status == 1 ? "checked" : "" }}>
                                <span class="knob"></span>
                            </label>
                        </div>
                        <div class="form-group">
                             <button type="reset" class="btn btn-danger-rgba mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
                            <button type="submit" class="btn btn-info-rgba" title="{{ __('Update') }}">
                                <i class="feather icon-save"></i> {{__("Update")}}
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

                                label: obj.label,
                                value: obj.value,
                                id: obj.id,
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
        $(".course").each(function (index) {
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

            $('input.product').last().focus();

            enableAutoComplete($("input.product:last"));
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