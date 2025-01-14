/*
---------------------------------
    : Custom - Switchery js :
---------------------------------
*/
$(function() {
    "use strict";
    var success_multicolor_on_off = document.querySelectorAll('.custom_toggle');
    $(success_multicolor_on_off).map(function( index ,val ) {
        var switchery = new Switchery(val, {  color: '#43D187', secondaryColor: '#F9616D', jackColor: '#A5ECC4', jackSecondaryColor: '#FFE4E6' });
    });
    // var switchery = new Switchery(success_multicolor_on_off, { color: '#43D187', secondaryColor: '#F9616D', jackColor: '#A5ECC4', jackSecondaryColor: '#FFE4E6' });
});