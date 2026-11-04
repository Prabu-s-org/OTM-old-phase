<?php
error_log( 0 );
include 'header.php';
// include '../../config/dbconfig.php';
// include '../config/dbconfig.php';

include '../service_app/config/dbconfig.php';

?>
<!DOCTYPE html>
<html lang = 'en'>
<head>
<meta charset = 'UTF-8'>
<meta name = 'viewport' content = 'width=device-width, initial-scale=1.0'>
<!-- Bootstrap CSS -->
<link href = 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel = 'stylesheet'>
<!-- Font Awesome for icons -->
<link href = 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css' rel = 'stylesheet'>
<style>
.btn-custom {
    margin: 10px;
    width: 50%;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.accordion-item {
    display: none;
}
.accordion-item.show {
    display: block;
}
.get {
    padding: 0px 14px;
}

i.fa.fa-edit {
    font-size: 20px;
    color: green;
}

i.fa-sharp.fa-solid.fa-trash {
    font-size: 20px;
    color: green;
}
button#export {
    float: right;
    padding: 5px 10px;
}
table.dataTable.nowrap td {
    white-space: unset;
}
span.po_date {
    white-space: nowrap;
}
</style>

</head>
<body>
<!-- <style>

</style> -->
<?php
//  $screen_id = isset( $_GET[ 'screen_id' ] ) ? htmlspecialchars( $_GET[ 'screen_id' ] ) : '';
$screen_id_val = '641ad99a3f61227010';
// print_r( $screen_id );
session_start();

$user_type_unique_id = $_SESSION[ 'user_type_unique_id' ];
error_reporting( 0 );
session_start();
include( 'session.php' );

?>

<div class = 'sub-hed'>
<div class = 'row'>
<div class = 'col-3 log-out'>
<a href = 'logout.php'><i class = 'fa fa-sign-out'></i></a>
</div>

</div>
</div>

<div class = 'accordion accordion-flush botm-box ox-2' id = 'accordionFlushExample'>
<!-- start page title -->
<div class = 'row'>
<div class = 'col-12'>
<div class = 'page-title-box d-sm-flex align-items-center justify-content-between'>
<h4 class = 'mb-sm-0'> Installation</h4>
<input type = 'hidden' id = 'screen_id_val' name = 'screen_id_val' class = 'form-control' value = "<?php echo $screen_id_val;?>">
<input type = 'hidden' id = 'user_type_unique_id' name = 'user_type_unique_id' class = 'form-control' value = "<?php echo $user_type_unique_id;?>">

<div class = 'page-title-right'>
<ol class = 'breadcrumb m-0'>
<li class = 'breadcrumb-item'><a href = 'javascript: void(0);'>Settings</a></li>
<li class = 'breadcrumb-item active'>Installation</li>
</ol>
</div>

</div>

</div>
</div>

<div class = 'card'>
<div class = 'card-body'>
<div class = 'col-12'>

<ul class = 'nav nav-pills arrow-navtabs 	  bg-light mb-3' role = 'tablist'>
<li class = 'nav-item' >
<a class = 'nav-link active' data-bs-toggle = 'tab' href = '#arrow-overview' role = 'tab'>
<span class = 'd-block d-sm-none'><i class = 'mdi mdi-home-variant'></i></span>
<span class = 'd-none d-sm-block'>Installation Followups</span>
</a>
</li>

<li class = 'nav-item' onclick = 'sub_list_datatable()'>
<a class = 'nav-link' data-bs-toggle = 'tab' href = '#arrow-contact' role = 'tab'>
<span class = 'd-block d-sm-none'><i class = 'mdi mdi-email'></i></span>
<span class = 'd-none d-sm-block'>DC and IR Document Dispatch Details</span>
</a>
</li>
</ul>
<!-- Tab panes -->
<div class = 'tab-content'>

<div id = 'list'>
<div class = 'table-responsive'>

<table id = 'installation_datatable' class = 'table table-bordered table-striped align-middle'>
<thead>
<tr>
<th>S.No</th>
<th>PO Number </th>
<th>PO Date </th>
<!-- <th>Department</th> -->
<th>Ledger Name</th>
<th>Consignee District</th>
<th>Location </th>
<th>Invoice No </th>
<th>Invoice Date</th>
<th>Invoice Value</th>
<th>PO.Att.</th>
<th>DC.Att.</th>
<th>IR.Att.</th>
<th>INV.Att.</th>
<th>Engineer Name</th>
<th>Status</th>
<th>Due date</th>
<th>Action</th>
</tr>
</thead>
<tbody>

</tbody>
</table>
</div>
</div>
</div>
<!-- <div class = 'tab-pane' id = 'arrow-profile' role = 'tabpanel'>

</div>-->
<!-- <div class = 'tab-pane' id = 'arrow-contact' role = 'tabpanel'>
<div id = 'list_1'>
<div class = 'table-responsive'>

<table id = 'dc_ir_dispatch_datatable' class = 'table table-bordered table-striped align-middle'>
<thead>
<tr>
<th>S.No</th>
<th>PO Number </th>
<th>Ledger Name</th>
<th>Consignee District</th>
<th>Location </th>
<th>Invoice No</th>
<th>Invoice Date</th>
<th>Invoice Value</th>
<th>Engineer Name</th>
<th>Call Assign Date</th>
<th>Status</th>
<th>Action</th>
</tr>
</thead>
<tbody>

</tbody>
</table> -->
</div>
</div>
</div>

</div>
<!--end col-->
</div>
<!--end row-->
</div>
</div>
</div>

<!-- Bootstrap Bundle with Popper -->
<script src = 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js'></script>
<!-- Add jQuery from CDN -->
<script src = 'https://code.jquery.com/jquery-3.6.0.min.js'></script>
<!-- Add DataTables -->
<script src = 'https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js'></script>
<link rel = 'stylesheet' href = 'https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css'>

<link rel = 'stylesheet' href = 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>

<script>
$( document ).ready( function () {
    function init_datatable() {
        var table_id = 'installation_datatable';
        var table = $( '#' + table_id );

        var url = '../service_app/crud.php';
        // Update the path if needed

        var datatable = table.DataTable( {
            destroy: true,
            ordering: true,
            processing: true,
            serverSide: true,
            searching: true,
            ajax: {
                url: url,
                type: 'POST',
                data: function ( d ) {
                    d.action = 'datatable';
                    d.screen_id_val = $( '#screen_id_val' ).val();
                    d.user_type_unique_id = $( '#user_type_unique_id' ).val();
                    d.opt = $( '#opt' ).val();
                    d.from_date = $( '#from_date' ).val();
                    d.to_date = $( '#to_date' ).val();
                    d.installation_status = $( '#installation_status' ).val();
                    d.con_district = $( '#con_district' ).val();
                }
                ,
                error: function ( xhr, error, thrown ) {
                    console.log( 'Error: ', xhr.responseText );

                }
            },
            columns: [ 
                    {data: 's_no' }, 
                     {data: 'po_num' }, 
                    {data: 'po_date' }, 
                    { data: 'ledger_name' }, 
                    {data: 'con_district' }, 
                    {data: 'con_address' }, 
                    {data: 'invoice_no' }, 
                    {data: 'invoice_date' } , 
                    { data: 'invoice_value' }, 
                    {data: 'po_file_name', orderable: false, searchable: false } , 
                    { data: 'dc_file_name', orderable: false, searchable: false },
                    {data: 'ir_file_name', orderable: false, searchable: false } , 
                     {data: 'file_invoice' }, 
                    { data: 'engineer_name' }, 
                    {data: 'installation_status' }, 
                    {data: 'delivery_due_dates' }, 
                    {data: 'actions', orderable: false }
                     ]
                    });
                    }
                    init_datatable();
                });

                                                        function sub_list_datatable() {
                                                            var table_id = 'dc_ir_dispatch_datatable';
                                                            var table = $( '#' + table_id );
                                                            var url = '../service_app/crud.php';

                                                            var datatable = table.DataTable( {
                                                                destroy: true,
                                                                ordering: true,
                                                                searching: true,
                                                                processing: true,
                                                                serverSide: true,
                                                                ajax: {
                                                                    url: url,
                                                                    type: 'POST',
                                                                    data: function ( d ) {
                                                                        return {
                                                                            action: 'dc_ir_dispatch_datatable',
                                                                            from_date: $( '#from_date_dc' ).length ? $( '#from_date_dc' ).val().trim() : '',
                                                                            to_date: $( '#to_date_dc' ).length ? $( '#to_date_dc' ).val().trim() : '',
                                                                            opt1: $( '#opt1' ).length ? $( '#opt1' ).val().trim() : '',
                                                                            dc_delivery_status: $( '#dc_delivery_status' ).length ? $( '#dc_delivery_status' ).val().trim() : '',
                                                                            con_district: $( '#con_district_dc' ).length ? $( '#con_district_dc' ).val().trim() : '',
                                                                            screen_id_val: $( '#screen_id_val' ).length ? $( '#screen_id_val' ).val().trim() : '',
                                                                            user_type_unique_id: $( '#user_type_unique_id' ).length ? $( '#user_type_unique_id' ).val().trim() : ''
                                                                        }
                                                                        ;
                                                                    }
                                                                }
                                                            }
                                                        );
                                                    }

                                                    </script><script>

                                                    function get_user_permission() {
                                                        var screen_id_val = $( '#screen_id_val' ).val();
                                                        // alert( screen_id_val );
                                                        var user_type_unique_id = $( '#user_type_unique_id' ).val();

                                                        var data = {
                                                            'screen_id_val': screen_id_val,
                                                            'user_type_unique_id': user_type_unique_id,
                                                            'action': 'user_permission',
                                                        }
                                                        ;

                                                        var ajax_url = sessionStorage.getItem( 'folder_crud_link' );
                                                        var url = sessionStorage.getItem( 'list_link' );
                                                        //
                                                        console.log( data );
                                                        $.ajax( {
                                                            type: 'POST',
                                                            url: ajax_url,
                                                            data: data,
                                                            success: function ( data ) {

                                                                var obj = JSON.parse( data );

                                                                var dataString = obj.data;

                                                                var listpage = document.getElementById( 'list' );
                                                                if ( dataString.includes( '5f88083fd50a344823' ) ) {
                                                                    listpage.style.visibility = 'visible';
                                                                    // Show the button
                                                                } else {
                                                                    listpage.style.visibility = 'hidden';
                                                                    // Hide the button but keep its space
                                                                }

                                                            }
                                                            ,
                                                            error: function ( data ) {
                                                                alert( 'Network Error' );
                                                            }
                                                        }
                                                    );
                                                }

                                                function get_user_permission_1() {
                                                    var screen_id_val = $( '#screen_id_val' ).val();
                                                    // alert( screen_id_val );
                                                    var user_type_unique_id = $( '#user_type_unique_id' ).val();

                                                    var data = {
                                                        'screen_id_val': screen_id_val,
                                                        'user_type_unique_id': user_type_unique_id,
                                                        'action': 'user_permission_1',
                                                    }
                                                    ;

                                                    var ajax_url = sessionStorage.getItem( 'folder_crud_link' );
                                                    var url = sessionStorage.getItem( 'list_link' );
                                                    //
                                                    console.log( data );
                                                    $.ajax( {
                                                        type: 'POST',
                                                        url: ajax_url,
                                                        data: data,
                                                        success: function ( data ) {

                                                            var obj = JSON.parse( data );

                                                            var dataString = obj.data;

                                                            var listpage = document.getElementById( 'list_1' );
                                                            if ( dataString.includes( '5f88083fd50a344823' ) ) {
                                                                listpage.style.visibility = 'visible';
                                                                // Show the button
                                                            } else {
                                                                listpage.style.visibility = 'hidden';
                                                                // Hide the button but keep its space
                                                            }

                                                        }
                                                        ,
                                                        error: function ( data ) {
                                                            alert( 'Network Error' );
                                                        }
                                                    }
                                                );
                                            }

                                            </script>

                                            </body>
                                            </html>

