
(function($) {
  "use strict";

  	$(function(){

       $('#dpopay_sec1').change(function(){
	        if($('#dpopay_sec1').is(':checked')){
	        	$('#dpopay_sec').show('fast');
	        }else{
	        	$('#dpopay_sec').hide('fast');
	        }
	    });

	});

})(jQuery);