

    $(document).ready(function() {
       var videourl;
        youtubeApiCall();
        $("#pageTokenNext").on( "click", function( event ) {
            $("#pageToken").val($("#pageTokenNext").val());
            youtubeApiCall();
        });
        $("#pageTokenPrev").on( "click", function( event ) {
            $("#pageToken").val($("#pageTokenPrev").val());
            youtubeApiCall();
        });
        $("#hyv-searchBtn").on( "click", function( event ) {
            youtubeApiCall();
            return false;
        });
        jQuery( "#hyv-search" ).autocomplete({
          source: function( request, response ) {
            //console.log(request.term);
            var sqValue = [];
            jQuery.ajax({
                type: "POST",
                url: "http://suggestqueries.google.com/complete/search?hl=en&ds=yt&client=youtube&hjson=t&cp=1",
                dataType: 'jsonp',
                data: jQuery.extend({
                    q: request.term
                }, {  }),
                success: function(data){
                    // console.log(data[1]);
                    obj = data[1];
                    jQuery.each( obj, function( key, value ) {
                        sqValue.push(value[0]);
                    });
                    response( sqValue);
                }
            });
          },
          select: function( event, ui ) {
            setTimeout( function () { 
                youtubeApiCall();
            }, 300);
          }
        });  
    });
    function youtubeApiCall(){
        $.ajax({
            cache: false,
            data: $.extend({
                key: youtubekey,
                q: $('#hyv-search').val(),
                part: 'snippet'
            }, {maxResults:15,pageToken:$("#pageToken").val()}),
            dataType: 'json',
            type: 'GET',
            timeout: 5000,
            url: 'https://www.googleapis.com/youtube/v3/search'
        })
        .done(function(data) {
            if (typeof data.prevPageToken === "undefined") {$("#pageTokenPrev").hide();}else{$("#pageTokenPrev").show();}
            if (typeof data.nextPageToken === "undefined") {$("#pageTokenNext").hide();}else{$("#pageTokenNext").show();}
            var items = data.items, videoList = "";
            $("#pageTokenNext").val(data.nextPageToken);
            $("#pageTokenPrev").val(data.prevPageToken);
            console.log(items);
            $.each(items, function(index,e) {
                 
                 videourl="https://www.youtube.com/watch?v="+e.id.videoId;
                   console.log(videourl);
                videoList = videoList 
                + '<li class="hyv-video-list-item" ><div class="hyv-content-wrapper"><p  class="hyv-content-link" title="'+e.snippet.title+'"><span class="title">'+e.snippet.title+'</span><span class="stat attribution">by <span>'+e.snippet.channelTitle+'</span></span></p><button class="bn btn-info btn-sm inline" onclick=setVideoURl("'+videourl+'")>Add</button></div><div class="hyv-thumb-wrapper"><p class="hyv-thumb-link"><span class="hyv-simple-thumb-wrap"><img alt="'+e.snippet.title+'" src="'+e.snippet.thumbnails.default.url+'" height="90"></span></p></div></li>';
                  
              
            });

            $("#hyv-watch-related").html(videoList);
           
        });
    }
