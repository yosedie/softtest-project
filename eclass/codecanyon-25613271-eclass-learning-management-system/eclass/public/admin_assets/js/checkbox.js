/*@nkit 2020*/

"use strict";

$(".selectallpermissionlogin").click(function(){
    $("input[type=checkbox].loginselect").prop('checked', $(this).prop('checked'));
});

$(".selectallpermissionusers").click(function(){
    $(".usersselect").prop('checked', $(this).prop('checked'));
});

$(".selectallpermissiondoctors").click(function(){
    $(".selectdoctors").prop('checked', $(this).prop('checked'));
});

$(".selectallpermissionpatient").click(function(){
    $(".selectpateint").prop('checked', $(this).prop('checked'));
});

$(".selectallpermissionpatient").click(function(){
    $(".selectpateint").prop('checked', $(this).prop('checked'));
});

$(".selectallpermissionorders").click(function(){
    $(".selectorders").prop('checked', $(this).prop('checked'));
});

$(".selectallpermissionproducts").click(function(){
    $(".selectproducts").prop('checked', $(this).prop('checked'));
});

$(".selectallpermissionsettings").click(function(){
    $(".selectsettings").prop('checked', $(this).prop('checked'));
});

$(".selectallpermissionroles").click(function(){
    $(".selectroles").prop('checked', $(this).prop('checked'));
});
// designations
$(".selectallpermissiondesignation").click(function(){
    $(".selectdesignation").prop('checked', $(this).prop('checked'));
});

// apply for candidates start
$(".selectallpermissionapplycndidates").click(function(){
    $(".selectapplycndidates").prop('checked', $(this).prop('checked'));
});
// apply for candidates end

// apply for vote start
$(".selectallpermissionvotes").click(function(){
    $(".selectvotes").prop('checked', $(this).prop('checked'));
});
// apply for vote end

// apply for candidates start
$(".selectallpermissioncadidates").click(function(){
    $(".selectcadidates").prop('checked', $(this).prop('checked'));
});
// apply for candidates end

// apply for voters start
$(".selectallpermissionvoters").click(function(){
    $(".selectvoters").prop('checked', $(this).prop('checked'));
});
// apply for voters end

// apply for constituency start
$(".selectallpermissionconstituencies").click(function(){
    $(".selectconstituencies").prop('checked', $(this).prop('checked'));
});
// apply for constituency end

// apply for party start
$(".selectallpermissionparties").click(function(){
    $(".selectparties").prop('checked', $(this).prop('checked'));
});
// apply for party end

// apply for electiontypes start
$(".selectallpermissionelectiontypes").click(function(){
    $(".selectelectiontypes").prop('checked', $(this).prop('checked'));
});
// apply for electiontypes end

// apply for location start
$(".selectallpermissionlocations").click(function(){
    $(".selectlocations").prop('checked', $(this).prop('checked'));
});
// apply for location end

// apply for report start
$(".selectallpermissionreports").click(function(){
    $(".selectreports").prop('checked', $(this).prop('checked'));
});
// apply for report end

 $(document).ready(function() {
    var checkedall = new Array;
    var checkedall2 = new Array;
    var checkedall3 = new Array;
    var checkedall4 = new Array;
    var checkedall5 = new Array;
    var checkedall6 = new Array;
    var checkedall7 = new Array;
    var checkedall8 = new Array;
    var checkedall9 = new Array;
    var checkedall10 = new Array;
    var checkedall11 = new Array;
    var checkedall12 = new Array;
    var checkedall13 = new Array;
    var checkedall14 = new Array;
    var checkedall15 = new Array;
    var checkedall16 = new Array;
    var checkedall17 = new Array;
    var checkedall18 = new Array;


    //Login
    $('.loginselect').each(function(index){
        if($(this).is(':checked')){
            checkedall.push(1);
        }else{
            checkedall.push(0);
        }
    });

    if(jQuery.inArray(0, checkedall) != -1){
       $('.selectallpermissionlogin').prop('checked',false);
    }else{
        $('.selectallpermissionlogin').prop('checked',true);
    }

    //Users

    $('.usersselect').each(function(index){
        if($(this).is(':checked')){
            checkedall2.push(1);
        }else{
            checkedall2.push(0);
        }
    });

    if(jQuery.inArray(0, checkedall2) != -1){
       $('.selectallpermissionusers').prop('checked',false);
    }else{
        $('.selectallpermissionusers').prop('checked',true);
    }

    //Doctors
    $('.selectdoctors').each(function(index){
        if($(this).is(':checked')){
            checkedall3.push(1);
        }else{
            checkedall3.push(0);
        }
    });

    if(jQuery.inArray(0, checkedall3) != -1){
       $('.selectallpermissiondoctors').prop('checked',false);
    }else{
        $('.selectallpermissiondoctors').prop('checked',true);
    }

    //Pateints

    $('.selectpateint').each(function(index){
        if($(this).is(':checked')){
            checkedall4.push(1);
        }else{
            checkedall4.push(0);
        }
    });

    if(jQuery.inArray(0, checkedall4) != -1){
       $('.selectallpermissionpatient').prop('checked',false);
    }else{
        $('.selectallpermissionpatient').prop('checked',true);
    }

    //Orders

    $('.selectorders').each(function(index){
        if($(this).is(':checked')){
            checkedall5.push(1);
        }else{
            checkedall5.push(0);
        }
    });

    if(jQuery.inArray(0, checkedall5) != -1){
       $('.selectallpermissionorders').prop('checked',false);
    }else{
        $('.selectallpermissionorders').prop('checked',true);
    }

    //Products

    $('.selectproducts').each(function(index){
        if($(this).is(':checked')){
            checkedall6.push(1);
        }else{
            checkedall6.push(0);
        }
    });

    if(jQuery.inArray(0, checkedall6) != -1){
       $('.selectallpermissionproducts').prop('checked',false);
    }else{
        $('.selectallpermissionproducts').prop('checked',true);
    }

    //Setting

    $('.selectsettings').each(function(index){
        if($(this).is(':checked')){
            checkedall7.push(1);
        }else{
            checkedall7.push(0);
        }
    });

    if(jQuery.inArray(0, checkedall7) != -1){
       $('.selectallpermissionsettings').prop('checked',false);
    }else{
        $('.selectallpermissionsettings').prop('checked',true);
    }

    //Roles

    $('.selectroles').each(function(index){
        if($(this).is(':checked')){
            checkedall8.push(1);
        }else{
            checkedall8.push(0);
        }
    });

    if(jQuery.inArray(0, checkedall8) != -1){
       $('.selectallpermissionroles').prop('checked',false);
    }else{
        $('.selectallpermissionroles').prop('checked',true);
    }

    // designations start
    $('.selectdesignation').each(function(index){
        if($(this).is(':checked')){
            
            checkedall9.push(1);
        }else{
            checkedall9.push(0);
        }
    });

    if(jQuery.inArray(0, checkedall9) != -1){
       $('.selectallpermissiondesignation').prop('checked',false);
    }else{
        $('.selectallpermissiondesignation').prop('checked',true);
    }
    // designations end

    // apply for candidates start
    $('.selectapplycndidates').each(function(index){
        if($(this).is(':checked')){
            
            checkedall10.push(1);
        }else{
            checkedall10.push(0);
        }
    });

    if(jQuery.inArray(0, checkedall10) != -1){
       $('.selectallpermissionapplycndidates').prop('checked',false);
    }else{
        $('.selectallpermissionapplycndidates').prop('checked',true);
    }
    // apply for candidates end 

    // vote start
    $('.selectvotes').each(function(index){
        if($(this).is(':checked')){
            
            checkedall11.push(1);
        }else{
            checkedall11.push(0);
        }
    });

    if(jQuery.inArray(0, checkedall11) != -1){
       $('.selectallpermissionvotes').prop('checked',false);
    }else{
        $('.selectallpermissionvotes').prop('checked',true);
    }
    // votes end 

     // candidates start
     $('.selectcadidates').each(function(index){
        if($(this).is(':checked')){
            
            checkedall12.push(1);
        }else{
            checkedall12.push(0);
        }
    });

    if(jQuery.inArray(0, checkedall12) != -1){
       $('.selectallpermissioncadidates').prop('checked',false);
    }else{
        $('.selectallpermissioncadidates').prop('checked',true);
    }
    // candidates end 

    // voters start
    $('.selectvoters').each(function(index){
        if($(this).is(':checked')){
            
            checkedall13.push(1);
        }else{
            checkedall13.push(0);
        }
    });

    if(jQuery.inArray(0, checkedall13) != -1){
       $('.selectallpermissionvoters').prop('checked',false);
    }else{
        $('.selectallpermissionvoters').prop('checked',true);
    }

    // voters end

    // constituencies start
    $('.selectconstituencies').each(function(index){
        if($(this).is(':checked')){
            
            checkedall14.push(1);
        }else{
            checkedall14.push(0);
        }
    });

    if(jQuery.inArray(0, checkedall14) != -1){
       $('.selectallpermissionconstituencies').prop('checked',false);
    }else{
        $('.selectallpermissionconstituencies').prop('checked',true);
    }

    // constituencies end

    // party start

    $('.selectparties').each(function(index){
        if($(this).is(':checked')){
            
            checkedall15.push(1);
        }else{
            checkedall15.push(0);
        }
    });

    if(jQuery.inArray(0, checkedall15) != -1){
       $('.selectallpermissionparties').prop('checked',false);
    }else{
        $('.selectallpermissionparties').prop('checked',true);
    }

    // party end

    // election type start

    $('.selectelectiontypes').each(function(index){
        if($(this).is(':checked')){
            
            checkedall16.push(1);
        }else{
            checkedall16.push(0);
        }
    });

    if(jQuery.inArray(0, checkedall16) != -1){
       $('.selectallpermissionelectiontypes').prop('checked',false);
    }else{
        $('.selectallpermissionelectiontypes').prop('checked',true);
    }

    // election type end

     // location start

     $('.selectlocations').each(function(index){
        if($(this).is(':checked')){
            
            checkedall17.push(1);
        }else{
            checkedall17.push(0);
        }
    });

    if(jQuery.inArray(0, checkedall17) != -1){
       $('.selectallpermissionlocations').prop('checked',false);
    }else{
        $('.selectallpermissionlocations').prop('checked',true);
    }

    // location end

    // report start

    $('.selectreports').each(function(index){
        if($(this).is(':checked')){
            
            checkedall18.push(1);
        }else{
            checkedall18.push(0);
        }
    });

    if(jQuery.inArray(0, checkedall18) != -1){
       $('.selectallpermissionreports').prop('checked',false);
    }else{
        $('.selectallpermissionreports').prop('checked',true);
    }

    // report end



});


