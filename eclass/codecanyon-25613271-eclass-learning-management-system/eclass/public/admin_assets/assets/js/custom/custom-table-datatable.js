/*
---------------------------------------
    : Custom - Table Datatable js :
---------------------------------------
*/
"use strict";
$(document).ready(function() {
    /* -- Table - Datatable -- */
    $('#datatable').DataTable({
        responsive: true
    });
    $('#default-datatable').DataTable( {
        "order": [[ 3, "desc" ]],
        responsive: true
    } );    
    var table = $('#datatable-buttons').DataTable({
            "responsive": true,
            "order": [],
            "columnDefs" : [ {
                'targets': [0], /* column index */
                'orderable': false, /* true or false */
             }],
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
    });
    table.buttons().container().appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');
    
    var table = $('.displaytable').DataTable({
        responsive: true,
        "order": [],
        "columnDefs" : [ {
            'targets': [0], /* column index */
            'orderable': false, /* true or false */
         }],
        buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
    });
    table.buttons().container().appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');
});

