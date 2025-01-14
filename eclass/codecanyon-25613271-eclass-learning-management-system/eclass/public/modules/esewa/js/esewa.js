
(function($) {
  "use strict";

  	$(function(){

       $('#esewa_sec1').change(function(){
	        if($('#esewa_sec1').is(':checked')){
	        	$('#esewa_sec').show('fast');
	        }else{
	        	$('#esewa_sec').hide('fast');
	        }
	    });

	});

})(jQuery);