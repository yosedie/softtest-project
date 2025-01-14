
(function($) {
  "use strict";

  	$(function(){

       $('#worldpay_sec1').change(function(){
	        if($('#worldpay_sec1').is(':checked')){
	        	$('#worldpay_sec').show('fast');
	        }else{
	        	$('#worldpay_sec').hide('fast');
	        }
	    });

	});

})(jQuery);