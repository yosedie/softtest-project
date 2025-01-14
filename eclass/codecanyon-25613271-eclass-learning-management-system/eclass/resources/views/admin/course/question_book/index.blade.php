@if(session('success'))
<div class="alert alert-success">
  {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="alert alert-danger">
  {{ session('error') }}
</div>
@endif
@php
$questionbook= App\QuestionBook::where('course_id',$cor->id)->orderBy('created_at','desc')->get();
@endphp
<div class="row">
  <div class="col-lg-12">
    <div class="card m-b-30">
      <div class="card-header">
        @can('questionbook.delete')
        <button type="button" class=" btn btn-danger-rgba mr-2 mb-2" data-toggle="modal"
          data-target="#questionbookbulk_delete"><i class="feather icon-trash mr-2"></i>{{ __('Delete
          Selected')
          }}</button>
        @endcan
        @can('questionbook.create')
        <a data-toggle="modal" data-target="#questionbank" href="#" class="btn btn-primary-rgba mb-2"><i
            class="feather icon-plus mr-2"></i>{{ __('Add Question') }}</a>
        

        @if($questionbook->isNotEmpty())
        <div class="question-bank-download-button mb-2">
          <a href="{{ route('question_book.generate_pdf', ['course_id' => $cor->id]) }}"  class="btn btn-info-rgba">{{ __('Download PDF') }}</a><br>
          <small>{{ __('(The PDF will not be shown on the frontend until the download is complete.)') }}</small>
        </div>
        @endif

        <form action="{{ route('import.question.book') }}" method="POST" class="py-4 mt-4" enctype="multipart/form-data">
          @csrf   
          <label for="file">Import File:</label><br>
          <div class="row">
            <div class="col-lg-8">
              <input type="file" class="form-control" name="file" id="file" accept=".csv, .xlsx" required>
            </div>
            <div class="col-lg-4">
              <button type="submit" class="btn btn-primary-rgba float-lg-right float-md-left">{{ __('Import Questions') }}</button>
            </div>
          </div>
      </form>
      @endcan
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table id="" class="displaytable table table-striped table-bordered w-100">
            <thead>
              <tr>
                <th>
                  <input id="checkboxAllquestionbook" type="checkbox" class="filled-in" name="checked[]" value="all" />
                  <label for="checkboxAll" class="material-checkbox"></label> #
                </th>
                <th>{{ __('Question') }}</th>
                <th>{{ __('type') }}</th>
                <th>{{ __('Action') }}</th>
              </tr>
            </thead>
            <tbody id="sortable-chapter">
              <?php $i=0;?>
             
              @foreach($questionbook as $cat)
              <tr class="sortable row1" data-id="{{ $cat->id }}" course-id="{{ $cor->id }}">
                <?php $i++;?>
                <td>
                  <input type="checkbox" form="quesbookulk_delete_form3" class="filled-in material-checkbox-input check"
                    name="checked[]" value="{{$cat->id}}" id="checkbox{{$cat->id}}">
                  <label for="checkbox" class="material-checkbox"></label>
                  <?php echo $i; ?>
                </td>
                <td>{{$cat->question}}</td>
                <td>{{$cat->type}}</td>
                <td>
                  <div class="dropdown">
                    <button class="btn btn-round btn-outline-primary" type="button" id="CustomdropdownMenuButton1"
                      data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
                        class="feather icon-more-vertical-"></i></button>
                    <div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton1">
                      @can('questionbook.edit')
                      <a class="dropdown-item" href="{{ route('question_book.edit', $cat->id) }}">
                        <i class="feather icon-edit mr-2"></i>{{ __('Edit') }}
                      </a>
                      @endcan
                      @can('questionbook.delete')
                      <a class="dropdown-item btn btn-link" data-toggle="modal" data-target="#delete{{ $cat->id}}">
                        <i class="feather icon-delete mr-2"></i>{{ __("Delete") }}</a>
                      </a>
                      @endcan
                    </div>
                  </div>
                  <div class="modal fade bd-example-modal-sm" id="delete{{$cat->id}}" tabindex="-1" role="dialog"
                    aria-hidden="true">
                    <div class="modal-dialog modal-sm">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleSmallModalLabel">{{__('Delete')}}
                          </h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <h4>{{ __('Are You Sure ?')}}</h4>
                          <p>{{ __('Do you really want to delete')}}
                            {{ __('This process cannot be
                            undone.')}}
                          </p>
                        </div>
                        <div class="modal-footer">
                          <form method="post" action="{{ route('question_book.destroy', $cat->id) }}" class="pull-right">
                            {{csrf_field()}}
                            {{method_field("DELETE")}}
                            <button type="reset" class="btn btn-secondary" data-dismiss="modal">{{__('No')}}</button>
                            <button type="submit" class="btn btn-primary">{{__('Yes')}}</button>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>

                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="questionbank" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="my-modal-title">
          <b>{{ __('Add Question') }}</b>
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
      </div>
      <div class="box box-primary">
        <div class="panel panel-sum">
          <div class="modal-body">
            <form id="demo-form2" method="post" action="{{ route('question_book.store') }}" data-parsley-validate
              class="form-horizontal form-label-left" enctype="multipart/form-data">
              {{ csrf_field() }}
              <select class="d-none" name="course_id" class="form-control select2">
                <option value="{{ $cor->id }}">{{ $cor->title }}</option>
              </select>

              <div id="questions-container">
                <div class="question-row">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="text-dark">{{ __('Question Type') }}: <span class="text-danger">*</span></label>
                        <select required="" name="type[]" class="form-control question-type">
                          <option value="subjective">{{ __('Subjective') }}</option>
                          <option value="objective">{{ __('Objective') }}</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                      <div class="form-group">
                        <label>{{ __('Question') }}: <sup class="text-danger">*</sup></label>
                        <input type="text" class="form-control" name="question[]"
                          placeholder="{{ __('Enter Question') }}" required>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <!-- Textarea for Subjective Questions -->
                    <div class="col-md-12 subjectiveFields">
                      <div class="form-group">
                        <label class="text-dark">{{ __('Answer') }}: <span class="text-danger">*</span></label>
                        <textarea name="answer[]" id="detail" class="form-control" rows="4"></textarea>
                      </div>
                    </div>

                    <!-- Input fields for Objective Questions -->
                    <div class="col-md-12 objectiveFields" style="display: none;">
                      <div class="row">
                        <div class="col-md-3">
                          <div class="form-group">
                            <label class="text-dark">{{ __('Option 1') }}: <span class="text-danger">*</span></label>
                            <input type="text" name="option_one[]" class="form-control">
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label class="text-dark">{{ __('Option 2') }}: <span class="text-danger">*</span></label>
                            <input type="text" name="option_two[]" class="form-control">
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label class="text-dark">{{ __('Option 3') }}:</label>
                            <input type="text" name="option_three[]" class="form-control">
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label class="text-dark">{{ __('Option 4') }}:</label>
                            <input type="text" name="option_four[]" class="form-control">
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="text-dark">{{ __('Correct Option') }}: <span class="text-danger">*</span></label>
                        <input type="text" name="correct_option[]" class="form-control">
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <button type="button" class="btn btn-danger remove-question"><i class="fa fa-minus"></i> {{
                      __('Remove') }}</button>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <button type="button" id="add-question" class="btn btn-secondary"><i class="fa fa-plus"></i> {{ __('More
                  Question') }}</button>
                <button type="reset" class="btn btn-danger-rgba"><i class="fa fa-ban"></i> {{__('Reset')}}</button>
                <button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
                  {{__('Create')}}</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- =============== -->
<div id="questionbookbulk_delete" class="delete-modal modal fade" role="dialog">
  <div class="modal-dialog modal-sm">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <div class="delete-icon"></div>
      </div>
      <div class="modal-body text-center">
        <h4 class="modal-heading">{{ __('Are You Sure') }} ?</h4>
        <p>{{ __('Do you really want to delete selected item ? This process
          cannot be undone') }}.</p>
      </div>
      <div class="modal-footer">
        <form id="quesbookulk_delete_form3" method="post" action="{{ route('question_book.bulk_delete') }}">
          @csrf
          @method('POST')
          <button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">{{ __('No') }}</button>
          <button type="submit" class="btn btn-danger">{{ __('Yes')
            }}</button>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- =============== -->

<script>
  document.addEventListener('DOMContentLoaded', function() {
      function toggleFields(questionType, row) {
          var subjectiveFields = row.querySelector('.subjectiveFields');
          var objectiveFields = row.querySelector('.objectiveFields');
  
          if (questionType === 'subjective') {
              subjectiveFields.style.display = 'block';
              objectiveFields.style.display = 'none';
          } else if (questionType === 'objective') {
              subjectiveFields.style.display = 'none';
              objectiveFields.style.display = 'block';
          }
      }
  
      function updateRemoveButtons() {
          document.querySelectorAll('.remove-question').forEach(function(button, index) {
              button.style.display = index === 0 ? 'none' : 'inline-block';
          });
      }
  
      document.getElementById('questions-container').addEventListener('change', function(e) {
          if (e.target.classList.contains('question-type')) {
              toggleFields(e.target.value, e.target.closest('.question-row'));
          }
      });
  
      document.getElementById('add-question').addEventListener('click', function() {
          var container = document.getElementById('questions-container');
          var newRow = container.querySelector('.question-row').cloneNode(true);
  
          newRow.querySelectorAll('input, textarea').forEach(function(input) {
              input.value = ''; // Clear the value
          });
  
          container.appendChild(newRow);
          updateRemoveButtons();
      });
  
      document.getElementById('questions-container').addEventListener('click', function(e) {
          if (e.target.classList.contains('remove-question') || e.target.closest('.remove-question')) {
              var row = e.target.closest('.question-row');
              if (row.parentNode.childElementCount > 1) {
                  row.parentNode.removeChild(row);
                  updateRemoveButtons();
              }
          }
      });
  
      // Initialize the fields for the first question row and set the remove button visibility
      document.querySelectorAll('.question-row').forEach(function(row) {
          toggleFields(row.querySelector('.question-type').value, row);
      });
  
      updateRemoveButtons(); // Set initial state for remove buttons
  });
</script>
<script>
  $(document).ready(function() {
      $('#downloadPdf').click(function(e) {
          e.preventDefault(); // Prevent the default form submission

          // Gather selected question IDs
          var selectedQuestions = [];
          $('input[name="questions[]"]:checked').each(function() {
              selectedQuestions.push($(this).val());
          });

          $.ajax({
              url: '{{ route('question_book.generate_pdf') }}', // Your route URL
              type: 'GET',
              data: {
                  course_id: '{{ $cor->id }}', // Pass the course ID
                  questions: selectedQuestions // Pass selected question IDs
              },
              success: function(response) {
                  // Create a link element and trigger download
                  var link = document.createElement('a');
                  link.href = window.URL.createObjectURL(response);
                  link.download = 'questionbook.pdf';
                  link.click();
              },
              error: function(xhr) {
                  console.log(xhr.responseText); // Log errors if any
              }
          });
      });
  });
</script>