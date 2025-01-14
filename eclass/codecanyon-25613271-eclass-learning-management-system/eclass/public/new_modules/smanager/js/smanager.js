
(function($) {
  "use strict";

  	$(function(){

       $('#smanager_sec1').change(function(){
	        if($('#smanager_sec1').is(':checked')){
	        	$('#smanager_sec').show('fast');
	        }else{
	        	$('#smanager_sec').hide('fast');
	        }
	    });

	});

})(jQuery);