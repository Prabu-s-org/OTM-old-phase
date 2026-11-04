$(document).ready(function () {

    init_datatable(table_id, form_name, action);
});

var company_name = sessionStorage.getItem("company_name");
var company_address = sessionStorage.getItem("company_name");
var company_phone = sessionStorage.getItem("company_name");
var company_email = sessionStorage.getItem("company_name");
var company_logo = sessionStorage.getItem("company_name");

var form_name = 'Mcc List';
var form_header = '';
var form_footer = '';
var table_name = '';
var table_id = 'user_login_report_datatable';
var action = "datatable";

function init_datatable(table_id = '', form_name = '', action = '') {
    var table = $("#" + table_id);
    var from_date = $("#from_date").val();
    var to_date = $("#to_date").val();

    var data = {
        "action": action,
        "from_date": from_date,
        "to_date": to_date,
    };
    var columnDefs = '';
    if (table_id == 'user_login_report_datatable') {
        columnDefs = [{

            "class": "text-center",
            "targets": [0, 2, 3]
        }];
    }

    data = {
        ...data,
    };


    var ajax_url = sessionStorage.getItem("folder_crud_link");

    var datatable = table.DataTable({
        "columnDefs": columnDefs,
        
        destroy: true,
        stateSave: true,
        ordering: false,
        responsive: true,
        paging: true,
        processing: true,
        serverSide: true,
        searching: true,
        "searching" : true,

        "ajax": {
            url: ajax_url,
            type: "POST",
            data: data
        },
        dom: 'Blfrtip',

        buttons: [
            'copy',
            'csv',
            "pdf",
            'excel',
            'print'
        ],
        lengthChange: true

    });

    return datatable;
}


function user_login_filter(filter_action = 0) {
    var internet_status = is_online();

    if (!internet_status) {
        sweetalert("no_internet");
        return false;
    }

    var from_date = $("#from_date").val();
    var to_date = $("#to_date").val();

    var is_vaild = fromToDateValidity(from_date, to_date);

    if ((from_date) && (to_date)) {

        sessionStorage.setItem("from_date", from_date);
        sessionStorage.setItem("from_date", to_date);

        var filter_data = {
            "from_date": from_date,
            "to_date": to_date,

        };

        console.log(filter_data);

        init_datatable(table_id, form_name, action, filter_data);

    }

}

