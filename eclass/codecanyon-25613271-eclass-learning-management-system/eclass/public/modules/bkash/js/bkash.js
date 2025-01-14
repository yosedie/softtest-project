
(function($) {
  "use strict";

  	$(function(){

       $('#bkash_sec1').change(function(){
	        if($('#bkash_sec1').is(':checked')){
	        	$('#bkash_sec').show('fast');
	        }else{
	        	$('#bkash_sec').hide('fast');
	        }
	    });

	});

})(jQuery);