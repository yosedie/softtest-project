
(function($) {
  "use strict";

  	$(function(){

       $('#paytab_sec1').change(function(){
	        if($('#paytab_sec1').is(':checked')){
	        	$('#paytab_sec').show('fast');
	        }else{
	        	$('#paytab_sec').hide('fast');
	        }
	    });

	});

})(jQuery);