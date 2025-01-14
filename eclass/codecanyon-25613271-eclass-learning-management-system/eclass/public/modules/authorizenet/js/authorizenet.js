(function($) {
  "use strict";

  	$(function(){

       $('#authorizenet_sec1').change(function(){
	        if($('#authorizenet_sec1').is(':checked')){
	        	$('#authorizenet_sec').show('fast');
	        }else{
	        	$('#authorizenet_sec').hide('fast');
	        }
	    });

	});

})(jQuery);