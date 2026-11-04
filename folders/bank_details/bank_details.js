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

    if ($.fn.DataTable.isDataTable('#' + table_id)) {
        table.DataTable().destroy();
    }

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
        ],
        columnDefs: [
            { orderable: false, targets: [12] }
        ]
    });
}

$(document).on('click', '.approve-btn', function () {
    var id = $(this).data('id');
    var type = $(this).data('type');
    var ajax_url = sessionStorage.getItem("folder_crud_link");

    Swal.fire({
        title: 'Are you sure?',
        text: 'Do you want to approve this record?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, Approve',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: ajax_url,
                type: 'POST',
                data: {
                    action: 'approve_vendor_bank',
                    id: id,
                    type: type
                },
                success: function (response) {
                    var res = typeof response === 'string' ? JSON.parse(response) : response;

                    if (res.status == 1) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Approved',
                            text: res.msg,
                            timer: 1500,
                            showConfirmButton: false
                        });
location.reload();
                        // $('#vendor_payment_report').DataTable().ajax.reload(null, false);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: res.msg || 'Approval failed'
                        });
                    }
                },
                error: function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Something went wrong'
                    });
                }
            });
        }
    });
});