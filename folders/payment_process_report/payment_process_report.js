$(document).ready(function () {
	vendor_payment_report_datatable();

});
function vendor_payment_report_datatable() {
    var table_id = 'vendor_payment_report';
    var table = $("#" + table_id);

    var data = {
        "action": "vendor_payment_report_datatable"
    };

    var ajax_url = sessionStorage.getItem("folder_crud_link");

    table.DataTable({
        destroy: true,
        ordering: true,
        searching: true,
        ajax: {
            url: ajax_url,
            type: "POST",
            data: data
        },
        dom: '<"dt-top-container"<l><"dt-center-in-div"B><f>r>t<ip>',
        buttons: [
            { extend: 'copyHtml5', text: 'Copy' },
            { extend: 'csvHtml5', text: 'CSV' },
            { extend: 'excelHtml5', text: 'Excel' },
            { extend: 'pdfHtml5', text: 'PDF' },
            { extend: 'print', text: 'Print' }
        ]
    });
}

