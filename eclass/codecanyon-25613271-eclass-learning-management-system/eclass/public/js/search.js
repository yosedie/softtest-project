"use strict";

$(function(){
  $(".search-input").autocomplete({
    
    source: function(request, response) {
        $.ajax({
            url: sendurl,
            data: {
                search: request.term
            },
            dataType: "json",
            success: function(data) {
                var resp = $.map(data, function(obj) {
                    return {
                        label: obj.value,
                        value: obj.value,
                        img: obj.image,
                        url: obj.url
                    }
                });
                response(resp);
            }
        });
    },
    select: function(event, ui) {
        if(ui.item.value != 'No Result found') {
            event.preventDefault();
            location.href = ui.item.url;
        } else {
            return false;
        }
    },
    html: true,
    open: function(event, ui) {
        $(".ui-autocomplete").css("z-index", 1000);
    },
}).autocomplete("instance")._renderItem = function(ul, item) {
    return $("<li><div><img style='object-fit:scale-down;' width='50px' height='50px' src='" + item.img + "'><span> " + item.value + "</span></div></li>").appendTo(ul);
};
})


var catids = sessionStorage.getItem("searchcat");
$(function() {
  
        
  if (window.location.href.indexOf('&keyword=') > 0) {
     // No code
  }else{
    sessionStorage.clear();
  }
      
  var cachesearchedValue;
  if(typeof(Storage) !== "undefined") {
    cachesearchedValue = sessionStorage.getItem("searchItem");
  }
  $('.search-field').val(cachesearchedValue);
  setinhtmlsession(catids);
  $(".searchDropMenu option").each(function() {
    if($(this).val() == catids) { // EDITED THIS LINE
      $(this).attr("selected", "selected");
    } else {
      $(this).removeAttr("selected");
    }
  });
});

$('.searchDropMenu').on('change', function() {
  catids = $(this).val();
  setinhtmlsession(catids);
});

function setinhtmlsession(catids) {
  if(!catids) {
    var catids1 = $('.searchDropMenu').val();
  } else {
    var catids1 = catids;
  }
  sessionStorage.setItem("searchcat", catids1);
}
