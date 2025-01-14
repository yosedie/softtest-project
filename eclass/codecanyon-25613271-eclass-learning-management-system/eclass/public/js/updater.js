"use Strict";

/** This will check for updates on every load at admin dashboard ! */

$(function(){

    $.ajax({

        method : 'GET',
        url : baseurl+'/api/check-for-update',
        dataType: 'json',
        beforeSend : function(){
            $('#update_text').html("<i class='fa fa-cloud-upload'></i> Checking for update....");
        },
        success : function(response){

            console.log(response);


            if(response.status != 'uptodate'){

                $('input[name="filename"]').val(response.filename);
                $('input[name="version"]').val(response.version);

                $('#update_text').html('<i class="fa fa-cloud-upload"></i>  <b>'+response.msg+'</b> <span class="label label-primary">v'+response.version+'</span>');

                $('.updaterform').removeClass('d-none');
                

            }else{
            
                $('#update_text').html('<i class="fa fa-check-circle"></i>   <b>'+response.msg+'</b>');

            }
            
        },
        error : function(jqXHR, xml, err){

        }

    });

});