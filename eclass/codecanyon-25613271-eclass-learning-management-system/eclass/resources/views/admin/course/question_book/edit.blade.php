@extends('admin.layouts.master')
@section('title','Edit Question Bank')
@section('maincontent')
<?php
$data['heading'] = 'Edit Question Bank';
$data['title'] = 'Course';
$data['title1'] = 'Edit Question Bank';
?>
@include('admin.layouts.topbar',$data)
<div class="contentbar dashboard-card">
    <div class="row">
        <div class="col-lg-12">
            <div class="card dashboard-card m-b-30">
                <div class="card-header">
                    <h5 class="card-title">{{ __('Edit') }} {{ __('Question Bank') }}</h5>
                    <div class="widgetbar">
                        <a href="{{ url('course/create/'. $question->course->id) }}"
                            class="float-right btn btn-primary-rgba"><i class="feather icon-arrow-left mr-2"></i>{{
                            __('Back') }}</a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('question_book.update', $question->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="d-none">
                            <label class="display-none" for="exampleInputSlug">{{ __('Select Course') }}</label>
                            <select name="course_id" class="form-control select2">
                                @foreach($courses as $course)
                                <option value="{{ $course->id }}" {{ $question->course_id == $course->id ? 'selected' : '' }}>
                                    {{ $course->title }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-dark">{{ __('Question Type') }}: <span class="text-danger">*</span></label>
                                    <select required name="type" id="type" class="form-control">
                                        <option value="subjective" {{ $question->type == 'subjective' ? 'selected' : '' }}>
                                            {{ __('Subjective') }}</option>
                                        <option value="objective" {{ $question->type == 'objective' ? 'selected' : '' }}>
                                            {{ __('Objective') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputTitle">{{ __('Question') }}: <sup class="text-danger">*</sup></label>
                                    <input type="text" class="form-control" name="question" id="exampleInputTitle"
                                        placeholder="{{ __('Enter Question') }}" value="{{ old('question', $question->question) }}"
                                        required>
                                </div>
                            </div>
                    
                            <!-- Textarea for Subjective Questions -->
                            <div class="col-md-12" id="subjectiveFields"
                                style="{{ $question->type == 'subjective' ? '' : 'display: none;' }}">
                                <div class="form-group">
                                    <label class="text-dark">{{ __('Answer') }}: <span class="text-danger">*</span></label>
                                    <textarea name="answer" id="detail" class="form-control"
                                        rows="4">{{ old('answer', $question->answer) }}</textarea>
                                </div>
                            </div>
                    
                            <!-- Input fields for Objective Questions -->
                            <div class="col-md-12" id="objectiveFields"
                                style="{{ $question->type == 'objective' ? '' : 'display: none;' }}">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="text-dark">{{ __('Option 1') }}: <span class="text-danger">*</span></label>
                                            <input type="text" name="option_one" class="form-control"
                                                value="{{ old('option_one', $question->option_one) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="text-dark">{{ __('Option 2') }}: <span class="text-danger">*</span></label>
                                            <input type="text" name="option_two" class="form-control"
                                                value="{{ old('option_two', $question->option_two) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="text-dark">{{ __('Option 3') }}:</label>
                                            <input type="text" name="option_three" class="form-control"
                                                value="{{ old('option_three', $question->option_three) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="text-dark">{{ __('Option 4') }}:</label>
                                            <input type="text" name="option_four" class="form-control"
                                                value="{{ old('option_four', $question->option_four) }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="text-dark">{{ __('Correct Option') }}: <span class="text-danger">*</span></label>
                                    <input type="text" name="correct_option" class="form-control"
                                        value="{{ old('correct_option', $question->correct_option) }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6 mt-5">
                                <button type="reset" class="btn btn-danger-rgba" title="{{ __('Reset') }}"><i class="fa fa-ban"></i>
                                    {{__('Reset')}}</button>
                                <button type="submit" class="btn btn-primary-rgba" title="{{ __('Update') }}"><i
                                        class="fa fa-check-circle"></i>
                                    {{__('Update')}}</button>
                            </div>
                            <div class="clear-both"></div>
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
    document.addEventListener('DOMContentLoaded', function () {
    const distypeSelect = document.getElementById('type');
    const subjectiveFields = document.getElementById('subjectiveFields');
    const objectiveFields = document.getElementById('objectiveFields');

    distypeSelect.addEventListener('change', function () {
        if (this.value === 'subjective') {
            subjectiveFields.style.display = 'block';
            objectiveFields.style.display = 'none';
        } else if (this.value === 'objective') {
            subjectiveFields.style.display = 'none';
            objectiveFields.style.display = 'block';
        }
    });

    // Trigger change event on page load to set the initial state
    distypeSelect.dispatchEvent(new Event('change'));
});

</script>
@endsection