"use Strict";

$('#link_by').on('change',function(){

	var getvalue = $('#link_by').val();

	if(getvalue == 'page'){
		$('#pagebox').show('fast');
		$('#page_id').attr('required','required');
	}else{
		$('#pagebox').hide('fast');
		$('#page_id').removeAttr('required');
	}

	if(getvalue == 'url'){
		$('#urlbox').show('fast');
		$('#inputurl').attr('required','required');
	}else{
		$('#urlbox').hide('fast');
		$('#inputurl').removeAttr('required');
	}

});

$('.link_by_edit').on('change',function(){

	var getvalue = $(this).val();

	if(getvalue == 'page'){
		$('.pagebox_edit').show('fast');
		$('.page_id_edit').attr('required','required');
	}else{
		$('.pagebox_edit').hide('fast');
		$('.page_id_edit').removeAttr('required');
	}

	if(getvalue == 'url'){
		$('.urlbox_edit').show('fast');
		$('.inputurl_edit').attr('required','required');
	}else{
		$('.urlbox_edit').hide('fast');
		$('.inputurl_edit').removeAttr('required');
	}

});

$('#position').on('change',function(){

	var getvalue = $('#position').val();

	if(getvalue == 'footer'){
		$('#footerbox').show('fast');
		$('#footer_id').attr('required','required');
	}else{
		$('#footerbox').hide('fast');
		$('#footer_id').removeAttr('required');
	}
	
});
$('.link_by_position').on('change',function(){

	var getvalue = $(this).val();

	if(getvalue == 'footer'){
		$('.footerbox_edit').show('fast');
		$('.footer_edit').attr('required','required');
	}else{
		$('.footerbox_edit').hide('fast');
		$('.footer_edit').removeAttr('required');
	}
});