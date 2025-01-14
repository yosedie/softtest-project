
(function($) {
  "use strict";

  	$(function(){

       $('#midtrains_sec1').change(function(){
	        if($('#midtrains_sec1').is(':checked')){
	        	$('#midtrains_sec').show('fast');
	        }else{
	        	$('#midtrains_sec').hide('fast');
	        }
	    });

	});

})(jQuery);