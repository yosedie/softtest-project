(function($) {
    "use strict";
    $(function(){
        $('#myCheck').change(function(){
          if($('#myCheck').is(':checked')){
            $('#update-password').show('fast');
          }else{
            $('#update-password').hide('fast');
          }
        });
        
    });
})(jQuery);

$(function() {
    $('.googlecourcestatus').change(function() {
        var status = $(this).prop('checked') == true ? 1 : 0; 
        var id = $(this).data('id'); 
        $.ajax({
            type: "GET",
            dataType: "json",
            url: 'class-status',
            data: {'status': status, 'id': id},
            success: function(data){
              console.log(id)
            }
        });
    });
});

$("#checkboxAll").on('click', function () {
    $('input.check').not(this).prop('checked', this.checked);
});

(function($) {
  "use strict";
  $(function(){
      $('#myCheck').change(function(){
        if($('#myCheck').is(':checked')){
          $('#update-password').show('fast');
        }else{
          $('#update-password').hide('fast');
        }
      });
      
  });
})(jQuery);
