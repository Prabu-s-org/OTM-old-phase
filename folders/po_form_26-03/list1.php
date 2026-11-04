<style>
    /* i.fa.fa-edit {
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
    span.invoice_date {
        white-space: nowrap;
    }

    .dataTables_wrapper .dt-buttons {
        margin-bottom: 10px;
    }

    .dt-button {
        margin-right: 5px;
    } */
</style>

<?php
$screen_id_val = '641ad5b47d02a30030'; // Adjust as needed
session_start();
$user_type_unique_id = $_SESSION['user_type_unique_id'];
?>
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0"> PO List</h4>
            <input type="hidden" id="screen_id_val" name="screen_id_val" class="form-control" value="<?php echo $screen_id_val;?>">
            <input type="hidden" id="user_type_unique_id" name="user_type_unique_id" class="form-control" value="<?php echo $user_type_unique_id;?>">

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Settings</a></li>
                    <li class="breadcrumb-item active"> PO List</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DataTables with ColVis</title>

   
</head>
<body>

<div class="row mt-2 po-class">
    <div class="col-md-4">
        <div class="input-group">
            <input type="month" id="month_fill" name="month_fill" class="form-control">
            <button type="button" id="date_filter" name="date_filter" class="input-group-text thme-colo btn btn-primary border-primary text-white" onclick="get_data_month()">GO</button>
        </div>
    </div>
    <div class="col-md-3 mb-1 d-grid gap-2 d-md-flex justify-content-md-end btn-green ">
        <div class="">
            <button type="button" id="export" name="export" class="btn btn-primary  waves-effect waves-light wavw  mb-1">
                <i class="ri-file-excel-2-fill"></i>
            </button>
        </div>
    </div>
</div>

<div class="col-xxl-12">
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="po_form_datatable" class="table table-bordered table-striped align-middle">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>PO Number </th>
                            <th>PO Date </th>
                            <th>Department </th>
                            <th>Customer GST Number </th>
                            <th>Executive Name</th>
                            <th>PO Total Value</th>
                            <th>PO Attachment</th>
                            <th>PO Cancel</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>


     <script>
        $(document).ready(function() {
            alert();
            $('#po_form_datatable').DataTable({
                dom: 'Bfrtip', // Buttons will be shown at the top (B is for buttons)
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print', 'colvis' // Include the 'colvis' button
                ]
            });
        });

    
// // Initialize when the document is ready
// jQuery(document).ready(function() {
//     init_datatable(); // Initialize the DataTable
//     get_data_month(); // Ensure data for the month is populated
// });

// // Function to handle filtering by month
// function get_data_month() {
//     jQuery('#from_date').val('');
//     jQuery('#to_date').val('');
//     init_datatable(); // Reinitialize table with filtered data
// }
// Ensure no conflict with other libraries
// jQuery.noConflict();

// Function to initialize DataTable with the required buttons
// function init_datatable() {
//     var table = jQuery("#po_form_datatable");
//     var month_fill = jQuery('#month_fill').val();
//     var from_date = jQuery("#from_date").val();
//     var to_date = jQuery("#to_date").val();
//     var screen_id_val = jQuery('#screen_id_val').val();
//     var user_type_unique_id = jQuery('#user_type_unique_id').val();

//     var data = {
//         "from_date": from_date,
//         "to_date": to_date,
//         "screen_id_val": screen_id_val,
//         "user_type_unique_id": user_type_unique_id,
//     };

//     if (month_fill != '') {
//         data["month_fill"] = month_fill;
//     }

//     var ajax_url = sessionStorage.getItem("folder_crud_link");

//     table.DataTable({
//         destroy: true,
//         ordering: true,
//         searching: true,
//         "ajax": {
//             url: ajax_url,
//             type: "POST",
//             data: data
//         },
//         // dom: 'Bfrtip', // Include Buttons (B -> Button)
//         // buttons: [
//         //     'copy', 'csv', 'excel', 'pdf', 'print', 'colvis' // Include column visibility toggle (colvis)
//         // ],
//         // initComplete: function() {
//         //     console.log("DataTable initialized with CSV, Excel, Print, and Colvis buttons.");
//         // }
//         dom: 'Bfrtip', // Buttons will be shown at the top (B is for buttons)
//                 buttons: [
//                     'copy', 'csv', 'excel', 'pdf', 'print', 'colvis' // Include the 'colvis' button
//                 ]
//     });
// }


</script>
</body>
</html>

