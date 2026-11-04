<style>
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

    #icon {
        font-size: x-large;
    }

    table.dataTable.nowrap td {
        white-space: unset;
    }

    .sorting_asc::before {
        display: none;
    }

    span.po_date {
        white-space: nowrap;
    }

    .text-end {
    text-align: right !important;
}
 .text-right {
        text-align: right !important;
    }
  th {
    text-align: center !important;
}


</style>
<?php
$screen_id_val = '641ad605643eb62575';
session_start();
$user_type_unique_id = $_SESSION['user_type_unique_id'];
?>
<!-- start page title -->
<div class="row"> 
    <div class="container">
        <div class="icon">🚧</div>
        <h1>Page Under Construction</h1>
        <p>
            This page is currently under development.<br>
            Please check back later.
        </p>
        <div class="footer-text">
            Thank you for your patience.
        </div>
    </div>

<script>
    $("#export").click(function () {
        window.location = "folders/invoice/excel.php";
    });
    $("#export1").click(function () {
        var selectedColumns = $(".exportColumn:checked").map(function () {
            return $(this).val();
        }).get(); // Get selected columns as an array

        if (selectedColumns.length === 0) {
            alert("Please select at least one column to export!");
            return;
        }
        var selectedColumnsStr = selectedColumns.join(",");
        window.location = "folders/invoice/excel_invoice.php?&columns=" + selectedColumnsStr;

    });
    $("#export2").click(function () {

        var selectedColumns = $(".exportColumn:checked").map(function () {

            return $(this).val();
        }).get(); // Get selected columns as an array
        if (selectedColumns.length === 0) {
            alert("Please select at least one column to export!");
            return;
        }
        var selectedColumnsStr = selectedColumns.join(",");
        window.location = "folders/invoice/excel_invoicetab2.php?columns=" + selectedColumnsStr;
    });

    $(document).ready(function () {
        // allocation_list_datatable('invoice_datatable', form_name, 'invoice_datatable');
    //    allocation_list('invoice_datatable',form_name,'invoice_datatable_pending');
        ass_stock_data();
    });
    function ass_stock_data() {
        allocation_list_datatable('invoice_datatable_pending', form_name, 'datatable');

    }


    function allocation_list_datatable(table_id = "", form_name = "", action = "") {
        var table_id = 'invoice_datatable_pending';
        var table = $("#" + table_id);
        var from_date = $("#from_date_ass").val();
        var to_date = $("#to_date_ass").val();
        var team_mem = $('#team_mem').val();

        var screen_id_val = $('#screen_id_val').val();
        var user_type_unique_id = $('#user_type_unique_id').val();

        var data = {
            "from_date": from_date,
            "to_date": to_date,
            "action": 'datatable',
            "screen_id_val": screen_id_val,
             "team_mem": team_mem,
            "user_type_unique_id": user_type_unique_id,
        };

        var ajax_url = sessionStorage.getItem("folder_crud_link");

        var datatable = table.DataTable({
            destroy: true, //new line
            ordering: true,
            searching: true,
            stateSave:true,
            "ajax": {
                url: ajax_url,
                type: "POST",
                data: data
            },
            dom: 'lBfrtip',
             // Adds the button and column visibility controls to the DOM
            buttons: [
                {
                    extend: 'copyHtml5',
                    text: 'Copy',
                    exportOptions: { columns: ':visible' }
                },
                {
                    extend: 'csvHtml5',
                    text: 'CSV',
                    exportOptions: { columns: ':visible' }
                },
                {
                    extend: 'excelHtml5',
                    text: 'Excel',
                    exportOptions: { columns: ':visible' }
                },
                {
                    extend: 'pdfHtml5',
                    text: 'PDF',
                    exportOptions: { columns: ':visible' }
                },
                {
                    extend: 'print',
                    text: 'Print',
                    exportOptions: { columns: ':visible' }
                },
                {
                    extend: 'colvis', // Column visibility button
                    text: 'Column Visibility',
                    action: function (e, dt, node, config) {
                        // Open the column visibility modal when the button is clicked
                        $('#columnVisibilityModal').modal('show');

                        // Populate the modal with checkboxes for each column
                        var columns = dt.columns().header();
                        var form = $('#columnVisibilityForm');
                        form.empty(); // Clear any existing checkboxes

                        // Append checkboxes one by one for each column
                        columns.each(function (header, index) {
                            var isChecked = dt.column(index).visible();
                            var colMarkup = `
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" data-column="${index}" ${isChecked ? 'checked' : ''}>
                                <label class="form-check-label">${$(header).text()}</label>
                            </div>
                        `;
                            form.append(colMarkup); // Append each checkbox in a vertical list
                        });
                    }

                }
            ],
             columnDefs: [
        {
            targets: [6, 7], // 5=No.Of.Items, 6=Qty (item_qty), 7=Value (stock_value)
            className: 'dt-body-right'
        }
    ],
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            pageLength: 10 // Default selected value
        });

        $('#columnVisibilityForm').on('change', 'input[type="checkbox"]', function () {
            var columnIdx = $(this).data('column');
            var isVisible = $(this).is(':checked');
            datatable.column(columnIdx).visible(isVisible); // Use datatable instead of table
        });
    }
    $(document).ready(function () {
        get_user_permission();
        get_user_permission_1();
    });

    function get_user_permission() {
        var screen_id_val = $('#screen_id_val').val();
        var user_type_unique_id = $('#user_type_unique_id').val();

        var data = {
            "screen_id_val": screen_id_val,
            "user_type_unique_id": user_type_unique_id,
            "action": 'user_permission',
        };

        var ajax_url = sessionStorage.getItem("folder_crud_link");
        var url = sessionStorage.getItem("list_link");

        $.ajax({
            type: "POST",
            url: ajax_url,
            data: data,
            success: function (data) {

                var obj = JSON.parse(data);

                var dataString = obj.data;


                var listpage = document.getElementById('list');
                if (listpage) {
    if (dataString.includes('5f88083fd50a344823')) {
        listpage.style.visibility = 'visible';  // Show the button
    } else {
        listpage.style.visibility = 'hidden';   // Hide the button but keep its space
    }
}


            },
            error: function (data) {
                alert("Network Error");
            }
        });
    }
    function get_user_permission_1() {
        var screen_id_val = $('#screen_id_val').val();
        var user_type_unique_id = $('#user_type_unique_id').val();

        var data = {
            "screen_id_val": screen_id_val,
            "user_type_unique_id": user_type_unique_id,
            "action": 'user_permission_1',
        };

        var ajax_url = sessionStorage.getItem("folder_crud_link");
        var url = sessionStorage.getItem("list_link");

        $.ajax({
            type: "POST",
            url: ajax_url,
            data: data,
            success: function (data) {

                var obj = JSON.parse(data);

                var dataString = obj.data;

                var listpage = document.getElementById('list_1');
if (listpage) {
    if (dataString.includes('5f88083fd50a344823')) {
        listpage.style.visibility = 'visible';  // Show the button
    } else {
        listpage.style.visibility = 'hidden';   // Hide the button but keep its space
    }
}

            },
            error: function (data) {
                alert("Network Error");
            }
        });
    }
</script>
