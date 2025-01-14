    "use Strict"
    $("#text").on('submit',function (e) {
        alert('hello');
        e.preventDefault();
        $('.service_btn').text('Please Wait..');
        $('.service_btn').prop("disabled", true);
        var formData = new FormData();
        var a = formData.append('service', $("#service").val());
        var b = formData.append('language', $("#language").val());
        var c = formData.append('keyword', $("#keyword").val());
        var baseUrl = "{{ url('/') }}";
        var urlLike2 = baseUrl+'/openai/text'; 
        $.ajax({
            type: "post",
            url: urlLike2,
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            contentType: false,
            processData: false,
            success: function (data) {
                console.log(data);
                if(data){
                    // toastr.success('Generated Successfully!');
                    console.log(data.html);
                    z = data.code;
                    $("#generator_sidebar_table").html(data.html);
                    
                } else {
                    $('.service_btn').text('Generate');
                    // toastr.error( 'Your words limit has been exceeded.' );
                }
                    $('.service_btn').prop("disabled", false);
                    $('.service_btn').text('Generate');
            },
                error: function (data) {
                // toastr.error('Error' + data.responseText);
                    console.log(data);
                    $('.service_btnn').prop("disabled", false);
                    $('.service_btn').text('Generate');            
                 }
        });
    });
    function generatorFormImage(ev) {
			'use strict';
            ev?.preventDefault();
			ev?.stopPropagation();
            $('.generate-btn-text').text('Please Wait...');
            $('.generate-btn-text').prop("disabled", true);
            document.getElementById("image-generator").disabled = true;
            document.getElementById("image-generator").innerHTML = "Please Wait...";
			document.querySelector('#app-loading-indicator')?.classList?.remove('opacity-0');
            var formData = new FormData();
            formData.append('image_number_of_images', $("#image_number_of_images").val());
            formData.append('description', $("#description").val());
            formData.append('size', $("#size").val());
            var urlLike = baseUrl+'/openai/image'; 
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                },
                type: "post",
                url: urlLike,
                data: formData,
                contentType: false,
                processData: false,
                success: function (data) {
                    console.log('img',data);
                    if(data.status=='True'){
                        setTimeout(function () {
                            $("#image-output").html(data.response);
                            document.getElementById("image-generator").disabled = false;
                            document.getElementById("image-generator").innerHTML = "Regenerate";
                            document.querySelector('#app-loading-indicator')?.classList?.add('opacity-0');
                            $('.generate-btn-text').text('Generate');
                        }, 750);
                    } else {
                        $('.generate-btn-text').text('Generate');
                        // toastr.error('Your image limit has been exceeded.');
                    }
                },
            });
            return false;
        }