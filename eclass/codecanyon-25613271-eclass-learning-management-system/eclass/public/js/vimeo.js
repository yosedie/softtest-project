 $(document).ready(function() {
     var videourl;
      vimeoApiCall();
      $("#vpageTokenNext").on( "click", function( event ) {
          $("#vpageToken").val($("#vpageTokenNext").val());
          vimeoApiCall();
      });
      $("#vpageTokenPrev").on( "click", function( event ) {
          $("#vpageToken").val($("#vpageTokenPrev").val());
          vimeoApiCall();
      });
      $("#vimeo-searchBtn").on( "click", function( event ) {
          vimeoApiCall();
          return false;
      });
      jQuery( "#vimeo-search" ).autocomplete({
        source: function( request, response ) {
          //console.log(request.term);
          var sqValue = [];
          var accesstoken= vimeokey;
          var myvimeourl='https://api.vimeo.com/videos?query=videos'+'&access_token=' + accesstoken +'&per_page=1';
          console.log(myvimeourl);
          jQuery.ajax({
              type: "GET",
              url: myvimeourl,
              dataType: 'jsonp',
              
              success: function(data){
                  console.log(data[1]);
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
              vimeoApiCall();
          }, 300);
        }
      });  
  });

function vimeoApiCall(){

    var accesstoken= vimeokey;
    var text=$("#vimeo-search").val();
   var next=  $("#vpageTokenNext").val();
   console.log('jxhh'+next);
   var prev= $("#vpageTokenPrev").val();
    var myvimeourl=null;
   if (next != null && next !='') {
     myvimeourl='https://api.vimeo.com'+next;
   }else if (prev != null && prev !='') {
       myvimeourl='https://api.vimeo.com'+prev;
   }else{
       // myvimeourl='https://api.vimeo.com/videos?query='+ text + '&access_token=' + accesstoken+'&per_page=5';

       myvimeourl='https://api.vimeo.com/videos?query=videos'+'&access_token=' + accesstoken +'&per_page=10';
   }
  
   console.log('url'+myvimeourl);
    $.ajax({
        cache: false,
     
        dataType: 'json',
        type: 'GET',
       
        url: myvimeourl,

    })
    .done(function(data) {
      console.log(data);
    // alert('duhjf');
        if ( data.paging.previous === null) {$("#vpageTokenPrev").hide();}else{$("#vpageTokenPrev").show();}
        if ( data.paging.next === null) {$("#vpageTokenNext").hide();}else{$("#vpageTokenNext").show();}
        var items = data.data, videoList = "";
     
        $("#vpageTokenNext").val(data.paging.next);
        $("#vpageTokenPrev").val(data.paging.previous);
        console.log(items);
        $.each(items, function(index,e) {
             
             videourl=e.link;
               // console.log(videourl);
            videoList = videoList 
            + '<li class="hyv-video-list-item" ><div class="hyv-thumb-wrapper"><p class="hyv-thumb-link"><span class="hyv-simple-thumb-wrap"><img alt="'+e.name+'" src="'+e.pictures.sizes[3].link+'" height="90"></span></p></div><div class="hyv-content-wrapper"><p  class="hyv-content-link">'+e.name+'<span class="title">'+e.description.substr(0, 105)+'</span><span class="stat attribution">by <span>'+e.user.name+'</span></span></p><button class="bn btn-info btn-sm inline" onclick=setVideovimeoURl("'+videourl+'")>Add</button></div></li>';
              
          
        });

        $("#vimeo-watch-related").html(videoList);
       
    });

}