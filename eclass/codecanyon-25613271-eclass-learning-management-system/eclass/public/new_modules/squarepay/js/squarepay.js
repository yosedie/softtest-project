
(function($) {
  "use strict";

  	$(function(){

       $('#squarepay_sec1').change(function(){
	        if($('#squarepay_sec1').is(':checked')){
	        	$('#squarepay_sec').show('fast');
	        }else{
	        	$('#squarepay_sec').hide('fast');
	        }
	    });

	});

})(jQuery);