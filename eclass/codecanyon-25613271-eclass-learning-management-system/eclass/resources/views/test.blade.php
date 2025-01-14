<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel 8 Bootstrap 5 Progress Bar Example</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet">
    
</head>
<body>

  <h2>{{__('HTML5 File Upload Progress Bar Tutorial')}}</h2>
  <form id="upload_form" enctype="multipart/form-data" method="post">
    <input type="file" name="file1" id="file1" onchange="uploadFile()"><br>
    <progress id="progressBar" value="0" max="100" style="width:300px;"></progress>
    <h3 id="status"></h3>
    <p id="loaded_n_total"></p>
  </form>

    <div class="container mt-5" style="max-width: 500px">
       
        <div class="alert alert-warning mb-4 text-center">
           <h2 class="display-6">{{__('Laravel Dynamic Ajax Progress Bar Example')}}</h2>
        </div>  
        <form id="fileUploadForm" method="POST" action="{{ url('/upload-doc-file') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group mb-3">
                <input name="file" type="file" class="form-control">
            </div>
            <div class="d-grid mb-3">
                <input type="submit" value="Submit" class="btn btn-primary">
            </div>

            {{-- <div class="form-group">
                <div class="progress">
                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                </div>
            </div> --}}
            <div class="progress">
              <div class="bar"></div >
              <div class="percent">{{__('0%')}}</div >
          </div>
          
          <div id="status"></div>
        </form>
    </div>
    
    <script src="{{ url('js/jquery-2.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>
    <script src="{{ url('js/progress.js')}}"></script>

    {{-- <script>
      function _() {
    return document.getElementById('fileUploadForm');
  }
  
  uploadFile = function(){
    var file = _("file1").files[0];
    // alert(file.name+" | "+file.size+" | "+file.type);
    var formdata = new FormData();
    formdata.append("file1", file);
    var ajax = new XMLHttpRequest();
    ajax.upload.addEventListener("progress", progressHandler, false);
    ajax.addEventListener("load", completeHandler, false);
    ajax.addEventListener("error", errorHandler, false);
    ajax.addEventListener("abort", abortHandler, false);
   //  ajax.setRequestHeader({
   //    headers: {
   //       'X-CSRF-TOKEN': $('meta[name="token"]').attr('content')
   //   }
   //  })
     ajax.open("POST", "{{ url('/upload-doc-file') }}"); // http://www.developphp.com/video/JavaScript/File-Upload-Progress-Bar-Meter-Tutorial-Ajax-PHP
    //use file_upload_parser.php from above url
    ajax.send(formdata);
  };
 
  
  function progressHandler(event) {
    _("loaded_n_total").innerHTML = "Uploaded " + event.loaded + " bytes of " + event.total;
    var percent = (event.loaded / event.total) * 100;
    _("progressBar").value = Math.round(percent);
    _("status").innerHTML = Math.round(percent) + "% uploaded... please wait";
  }
  
  function completeHandler(event) {
    _("status").innerHTML = event.target.responseText;
    _("progressBar").value = 0; //wil clear progress bar after successful upload
  }
  
  function errorHandler(event) {
    _("status").innerHTML = "Upload Failed";
  }
  
  function abortHandler(event) {
    _("status").innerHTML = "Upload Aborted";
  }
    </script> --}}
    {{-- <script>
        $(function () {
          var bar = $('.bar');
          var percent = $('.percent');
          var status = $('#status');
            $(document).ready(function () {
              
                $('#fileUploadForm').ajaxForm({
                    beforeSend: function () {
                      status.empty();
                        var percentVal = '0';
                        bar.width(percentVal);
                    percent.html(percentVal);
                    },
                    uploadProgress: function(event, position, total, percentComplete) {
                      console.log('hello');
                      var percentVal = percentComplete + '%';
                      bar.width(percentVal);
                      percent.html(percentVal);
                  },
                    complete: function (xhr) {
                        console.log('File has uploaded');
                    }
                });
            });
        });
    </script> --}}
</body>
</html>