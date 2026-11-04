$(document).ready(function () {
    // var table_id 	= "user_type_datatable";
   // init_datatable(table_id, form_name, action);
    // 	stock_position_pending();
    // sub_list_datatable('stock_processing_datatable',form_name,'stock_position_processing_datatable');
    complete_list_datatable('complete_stock_position_datatable', form_name, 'stock_position_complete_datatable');
    // 	stock_position_processing(table_id_1,form_name,action);
    // stock_poistion_sublist('stock_poistion_sublist',form_name,'stock_poistion_sublist');

    get_data();
});

function get_data() {
    init_datatable(table_id, form_name, action);
}
function get_data_com() {
    complete_list_datatable('complete_stock_position_datatable', form_name, 'stock_position_complete_datatable');
}


var company_name = sessionStorage.getItem("company_name");
var company_address = sessionStorage.getItem("company_name");
var company_phone = sessionStorage.getItem("company_name");
var company_email = sessionStorage.getItem("company_name");
var company_logo = sessionStorage.getItem("company_name");

var form_name = 'Stock Position';
var form_header = '';
var form_footer = '';
var table_name = '';


var table_id = 'stock_position_datatable';
var table_id_1 = 'stock_position_processing_datatable';
var action = "datatable";


function init_datatable(table_id = '', form_name = '', action = '') {

    var table = $("#" + table_id);
    var from_date = $("#from_date").val();

    var to_date = $("#to_date").val();
    var screen_id_val = $('#screen_id_val').val();

    // 	alert(screen_id_val);
    var user_type_unique_id = $('#user_type_unique_id').val();
    var data = {
        "action": action,
        "from_date": from_date,
        "to_date": to_date,
        "screen_id_val": screen_id_val,
        "user_type_unique_id": user_type_unique_id,
    };
    var ajax_url = sessionStorage.getItem("folder_crud_link");

    // var datatable = table.DataTable({
    //     destroy: true,
    //     ordering: true,
    //     searching: true,
    //     "ajax": {
    //         url: ajax_url,
    //         type: "POST",
    //         data: data
    //     },
    //     // dom: 'Bfrtip',
    //     dom: '<"dt-top-container"<l><"dt-center-in-div"B><f>r>t<ip>',

    //     buttons: [
    //         'copy', 'csv', 'excel', 'pdf', 'print'
    //     ]
    // });

    var datatable = table.DataTable({
        destroy: true,
        ordering: true,
        searching: true,
        stateSave:true,
        "ajax": {
            url: ajax_url,
            type: "POST",
            data: data
        },
        dom: 'lBfrtip',
        buttons: [{
            extend: 'copyHtml5',
            text: 'Copy',
            exportOptions: {
                columns: ':visible'
            }
        },
        {
            extend: 'csvHtml5',
            text: 'CSV',
            exportOptions: {
                columns: ':visible'
            }
        },
        {
            extend: 'excelHtml5',
            text: 'Excel',
            exportOptions: {
                columns: ':visible'
            }
        },
        {
            extend: 'pdfHtml5',
            text: 'PDF',
            exportOptions: {
                columns: ':visible'
            }
        },
        {
            extend: 'print',
            text: 'Print',
            exportOptions: {
                columns: ':visible'
            }
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
        ]
    });
    $('#columnVisibilityForm').on('change', 'input[type="checkbox"]', function () {
        var columnIdx = $(this).data('column');
        var isVisible = $(this).is(':checked');
        datatable.column(columnIdx).visible(isVisible); // Use datatable instead of table
    });

}


// stock Position complete tab start
function complete_list_datatable(table_id = '', form_name = '', action = '') {
    // alert('hii');
    // var form_main_unique_id = $("#demo").val();
    var table_id = 'complete_stock_position_datatable';
    var from_date = $("#from_date_com").val();
    // alert(from_date);
    var to_date = $("#to_date_com").val();
    var screen_id_val = $('#screen_id_val').val();

    // alert(screen_id_val);
    var user_type_unique_id = $('#user_type_unique_id').val();
    // alert(table_id);
    // alert(table_id);
    var table = $("#" + table_id);
    var data = {

        "action": 'stock_position_complete_datatable',
        "from_date": from_date,
        "to_date": to_date,
        "screen_id_val": screen_id_val,
        "user_type_unique_id": user_type_unique_id,
    };
    var ajax_url = sessionStorage.getItem("folder_crud_link");

    // var datatable = table.DataTable({
    //     destroy: true,
    //     ordering: true,
    //     searching: true,
    //     "ajax": {
    //         url: ajax_url,
    //         type: "POST",
    //         data: data
    //     },
    //     // dom: 'Bfrtip',
    //     dom: '<"dt-top-container"<l><"dt-center-in-div"B><f>r>t<ip>',

    //     buttons: [
    //         'copy', 'csv', 'excel', 'pdf', 'print'
    //     ]
    // });

    var datatable = table.DataTable({
        destroy: true,
        ordering: true,
        searching: true,
        stateSave:true,
        "ajax": {
            url: ajax_url,
            type: "POST",
            data: data
        },
        dom: 'lBfrtip',
        buttons: [{
            extend: 'copyHtml5',
            text: 'Copy',
            exportOptions: {
                columns: ':visible'
            }
        },
        {
            extend: 'csvHtml5',
            text: 'CSV',
            exportOptions: {
                columns: ':visible'
            }
        },
        {
            extend: 'excelHtml5',
            text: 'Excel',
            exportOptions: {
                columns: ':visible'
            }
        },
        {
            extend: 'pdfHtml5',
            text: 'PDF',
            exportOptions: {
                columns: ':visible'
            }
        },
        {
            extend: 'print',
            text: 'Print',
            exportOptions: {
                columns: ':visible'
            }
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
        ]
    });
    $('#columnVisibilityForm').on('change', 'input[type="checkbox"]', function () {
        var columnIdx = $(this).data('column');
        var isVisible = $(this).is(':checked');
        datatable.column(columnIdx).visible(isVisible); // Use datatable instead of table
    });

}
// stack Position complete tab end

function stock_position_add_update() {
    // 	alert('hello');
}
function print_pdf_1(file_name) {

    onmouseover = window.open('uploads/po_form/po_attach/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
}