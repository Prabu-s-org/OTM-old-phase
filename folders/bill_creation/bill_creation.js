$(document).ready(function () {
    // var table_id 	= "user_type_datatable";
   // init_datatable(table_id, form_name, action);
 get_data();
    // sub_list_datatable('bill_generate_datatable', form_name, 'bill_generate_datatable');
    sub_list_datatable_partial_bill('partial_bill_datatable', form_name, 'partial_bill_datatable');
   

    $('#bill_datatable').DataTable({
        searching: false,
        lengthChange: false
    });
});
function get_data() {
    init_datatable(table_id, form_name, action);

}

function get_po_data() {
    sub_list_datatable_bill('bill_datatable', form_name, 'bill_datatable');

}


var company_name = sessionStorage.getItem("company_name");
var company_address = sessionStorage.getItem("company_name");
var company_phone = sessionStorage.getItem("company_name");
var company_email = sessionStorage.getItem("company_name");
var company_logo = sessionStorage.getItem("company_name");

var form_name = 'Bill Submission';
var form_header = '';
var form_footer = '';
var table_name = '';
var table_id = 'bill_submission_datatable';
var table_id_1 = 'bill_generate_datatable';
var action = "datatable";

var table_id_1 = 'bill_generate_datatable';

if (table_id) {
    var action = "datatable";
} else if (table_id_1) {
    var action = "bill_generate_datatable";

}
function bill_submission_cu(unique_id = "") {
    // alert();
    var internet_status = is_online();

    if (!internet_status) {
        sweetalert("no_internet");
        return false;
    }

    // var ins_unique_id = document.getElementById('ins_unique_id').value;
    var my_inv_no = document.getElementById('my_inv_no').value;
    // alert(ins_unique_id);
    var bill_form_main_unique_id = document.getElementById('bill_form_main_unique_id').value;
    var po_num = document.getElementById('po_num').value;
    var po_date = document.getElementById('po_date').value;
    // var con_contact_name = document.getElementById('con_contact_name').value;
    // var con_address = document.getElementById('con_address').value;

    var invoice_no = document.getElementById('invoice_no').value;
    var invoice_date = document.getElementById('invoice_date').value;
    var invoice_value = document.getElementById('invoice_value').value;
    var file_name = document.getElementById('file_name').value;
    // var consignee_unique_id = document.getElementById('consignee_unique_id').value;
    var invoice_qty = document.getElementById('invoice_qty').value;
    // alert(invoice_qty);
    var claim_amount = document.getElementById('claim_amount').value;
    // alert(claim_amount);
    // var invoice_copy = document.getElementById('invoice_copy').value;
    // var ir_status = document.getElementById('ir_status').value;

    //var installation_reference_no = document.getElementById('installation_reference_no').value;

    var cutomername = document.getElementById('cutomername').value;
    var unique_id = document.getElementById('unique_id').value;
    var bill_status = document.getElementById('bill_status').value;

    if (claim_amount != '') {
        var data = new FormData();
        data.append("bill_form_main_unique_id", bill_form_main_unique_id);
        data.append("my_inv_no", my_inv_no);
        data.append("po_num", po_num);
        data.append("po_date", po_date);

        data.append("invoice_no", invoice_no);
        data.append("invoice_date", invoice_date);
        // data.append("dc_no", dc_no);
        data.append("invoice_value", invoice_value);
        data.append("file_name", file_name);
        // data.append("consignee_unique_id", consignee_unique_id);
        data.append("invoice_qty", invoice_qty);

        data.append("claim_amount", claim_amount);
        data.append("bill_status", bill_status);
        //data.append("installation_reference_no", installation_reference_no);
        data.append("unique_id", unique_id);// data.append("district", district);
        data.append("cutomername", cutomername);

        data.append("action", "createupdate");

        // var is_form = form_validity_check("was-validated");

        // if (is_form) {
        // var data 	 = $(".was-validated").serialize();
        // data 		+= "&unique_id="+unique_id+"&action=demo";

        var ajax_url = sessionStorage.getItem("folder_crud_link");
        var url = sessionStorage.getItem("list_link");
        // console.log(data);
        $.ajax({
            type: "POST",
            url: ajax_url,
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            beforeSend: function () {
                // 	$(".createupdate_btn").attr("disabled","disabled");
                // 	$(".createupdate_btn").text("Loading...");
            },

            success: function (data) {
                // alert(data);
                var obj = JSON.parse(data);
                var msg = obj.msg;
                var status = obj.status;
                var error = obj.error;

                if (!status) {
                    url = '';
                    $(".createupdate_btn").text("Error");
                    // console.log(error);
                } else {
                    if (msg == "already") {
                        // Button Change Attribute
                        url = '';

                        $(".createupdate_btn").removeAttr("disabled", "disabled");
                        if (unique_id) {
                            $(".createupdate_btn").text("Update");
                        } else {
                            $(".createupdate_btn").text("Save");
                        }
                    }
                }

                sweetalert(msg, url);
            },
            error: function (data) {
                alert("Network Error");
            }
        });


    }
    else {
        sweetalert("form_alert");
    }
}

function get_status_filter(filter_action = 0) {

    // 	alert('hi');
    var status = $("#status").val();
    sessionStorage.setItem("status", status);
    var filter_data = {
        "status": status,

    };
    console.log(filter_data);

    init_datatable(table_id, form_name, action, filter_data);

}

function init_datatable(table_id = '', form_name = '', action = '', filter_data = '') {

    var status = $("#status").val();
    var table = $("#" + table_id);
    // alert(table_id);
    // alert(action);
    var from_date = $("#from_date").val();
    // alert(from_date);
    var to_date = $("#to_date").val();
    // alert(to_date);
    var opt = $("#opt").val();
    // alert(opt);
    var screen_id_val = $('#screen_id_val').val();
    // alert(screen_id_val);
    var user_type_unique_id = $('#user_type_unique_id').val();
    // alert(opt);
    var data = {
        "action": action,
        "status": status,
        "from_date": from_date,
        "to_date": to_date,
        "opt": opt,
        "screen_id_val": screen_id_val,
        "user_type_unique_id": user_type_unique_id,
    };
    data = {
        ...data,

    };
    var ajax_url = sessionStorage.getItem("folder_crud_link");

    var datatable = table.DataTable({
        destroy: true, //new line
        ordering: true,
        searching: true,
        "ajax": {
            url: ajax_url,
            type: "POST",
            data: data
        },
        // dom: 'Bfrtip',
        dom: '<"dt-top-container"<l><"dt-center-in-div"B><f>r>t<ip>',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        pageLength: 10 // Default selected value


    });

}

$(document).ready(function () {
    var table = $('#bill_submission_datatable').DataTable();

    // Clear the search input value and redraw the table
    table.search('').draw();

    // Also clear the input box visually if needed
    $('.dataTables_filter input').val('');
});

function sub_list_datatable_bill(table_id = "", form_name = "", action = "") {
    // alert('sublist');
    var po_num_bill = $("#po_num_bill").val();
    var ins_unique_id = $("#ins_unique_id").val();
    var screen_id_val = $('#screen_id_val').val();
    var user_type_unique_id = $('#user_type_unique_id').val();
    var po_num = $("#po_num").val();

    // alert(po_num);

    // If table_id is not provided, default to 'bill_datatable'
    if (table_id === "") {
        table_id = 'bill_datatable';
    }

    // Prepare the data to be sent in the AJAX request
    var data = {
        "action": 'bill_datatable',
        "po_num_bill": po_num_bill,
        "ins_unique_id": ins_unique_id,
        "screen_id_val": screen_id_val,
        "po_num": po_num,
        "user_type_unique_id": user_type_unique_id
    };

    // Get the URL for AJAX from session storage
    var ajax_url = sessionStorage.getItem("folder_crud_link");

    // Destroy existing DataTable instance if it exists
    if ($.fn.DataTable.isDataTable('#' + table_id)) {
        $('#' + table_id).DataTable().destroy();
    }

    // Initialize DataTable
    $('#' + table_id).DataTable({
        "destroy": true,    // Allows re-initializing the table
        "processing": true,    // Show a processing indicator while loading data
        "serverSide": true,    // Use server-side processing
        "searching": false,
        lengthChange: false,


        "ajax": {
            "url": ajax_url,  // The URL to which the request is sent
            "type": "POST",   // HTTP method used for the request
            "data": data      // Data sent with the request
        },


    });

}


// $(document).ready(function () {
// 	var table = $('#bill_datatable').DataTable();

// 	// Clear the search input value and redraw the table
// 	table.search('').draw();

// 	// Also clear the input box visually if needed
// 	$('.dataTables_filter input').val('');
// });

function sub_list_datatable_partial_bill(table_id = "", form_name = "", action = "") {
    // alert();s
    var po_num_bill = $("#po_num_bill").val();
    var screen_id_val = $('#screen_id_val').val();
    // alert(screen_id_val);
    var user_type_unique_id = $('#user_type_unique_id').val();
    // var ins_unique_id = $("#ins_unique_id").val();
    // alert(ins_unique_id);
    // 
    var table_id = 'partial_bill_datatable';

    var table = $("#" + table_id);
    var data = {

        "action": 'partial_bill_datatable',
        "po_num_bill": po_num_bill,
        "screen_id_val": screen_id_val,
        "user_type_unique_id": user_type_unique_id,
        //   "ins_unique_id"	: ins_unique_id, 
    };
    // alert(data);
    var ajax_url = sessionStorage.getItem("folder_crud_link");

    var datatable = table.DataTable({
        destroy: true, //new line
        ordering: true,
        searching: true,
        "ajax": {
            url: ajax_url,
            type: "POST",
            data: data
        },
        // dom: 'Bfrtip',
        dom: '<"dt-top-container"<l><"dt-center-in-div"B><f>r>t<ip>',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        pageLength: 10 // Default selected value


    });
}



$(document).ready(function () {
    var table = $('#partial_bill_datatable').DataTable();

    // Clear the search input value and redraw the table
    table.search('').draw();

    // Also clear the input box visually if needed
    $('.dataTables_filter input').val('');
});
function get_invoice_data(filter_data_bill = 0) {

    var po_num_bill = $("#po_num_bill").val();
    // alert(po_num_bill);

    sessionStorage.setItem("po_num_bill", po_num_bill);

    var filter_data_bill = {
        "po_num_bill": po_num_bill,

    };
    console.log(filter_data_bill);

    sub_list_datatable_bill('bill_datatable', form_name, 'bill_datatable');
}


// Handle "Select All" checkbox
$(document).on("change", "#checkAll", function () {
  $(".myCheck").prop("checked", this.checked);
});

// Optional: if user unchecks any box, uncheck the "Select All"
$(document).on("change", ".myCheck", function () {
  const total = $(".myCheck").length;
  const checked = $(".myCheck:checked").length;
  $("#checkAll").prop("checked", total === checked);
});




function po_invoice_create() {
    // alert();
    var internet_status = is_online();

    var formData = new FormData();


    var bg_value = $("#bg_value").val();
    var bg_date  = $("#bg_date").val();
    var bg_num  = $("#bg_num").val();
    var bg  = $("#bg").val();
    var bg_doc_val  = $("#bg_doc").val();

    var fileInput = document.getElementById("bg_doc"); // Your file input ID
    if (fileInput && fileInput.files.length > 0) {
        formData.append("bg_doc", fileInput.files[0]); // single file
    }

     if(bg == 'with_bg'){
        if(bg_value == '' || bg_date == '' || bg_num == '' || bg_doc_val == ''){
            sweetalert("form_alert");
            return;
        }
    }

    const checked = document.querySelectorAll('.myCheck:checked');

    let claimAmounts = new Set();

    for (let i = 0; i < checked.length; i++) {
        let parent = checked[i].parentElement;
        let claim_amount = parent.querySelector('#claim_amount').value.trim();

        claimAmounts.add(claim_amount);
    }


    if (claimAmounts.size > 1) {
        sweetalert("diff_claim");
        return;
    }


    var invoice_qty_total = [];
    var invoice_qty_amt = [];
    var invoice_tot = [];

    for (var i = 0; i < checked.length; i++) {
        // Get the unique identifier for each row
        var checkbox = checked[i];
        var bill_form_unique_id = checkbox.parentElement.querySelector('#bill_form_unique_id').value;
        var po_num = checkbox.parentElement.querySelector('#po_num').value;
        // alert(po_num);
        var invoice_date = checkbox.parentElement.querySelector('#invoice_date').value;
        var po_date = checkbox.parentElement.querySelector('#po_date').value;


        var parentElement = checked[i].parentElement;
        var invoice_value_val = parentElement.querySelector('#invoice_value').value;

        var claim_amount = parentElement.querySelector('#claim_amount').value;
        var ledger_name = parentElement.querySelector('#ledgername').value;

        var invoice_qty_val = parentElement.querySelector('#invoice_qty').value;
        // alert(invoice_qty_val);
        var invoice_no = parentElement.querySelector('#invoice_no').value;
        // alert(invoice_no);


        invoice_tot.push(invoice_no);

       

        // Clean the value (remove commas, etc.)
        invoice_value_val = invoice_value_val.replace(/,/g, ''); // remove commas if any
        // alert(invoice_value_val);
        var amount = parseFloat(invoice_value_val);
        // alert(amount);

        if (!isNaN(amount)) {
            invoice_qty_amt.push(amount);
            var sum_of_checkbox_value = invoice_qty_amt.reduce(function (total, current) {
                return total + current;
            }, 0);
        }
        // alert(sum_of_checkbox_value);
        // total qty calculate
        var number = parseFloat(invoice_qty_val);
        if (!isNaN(number)) {
            invoice_qty_total.push(number);
            var sum_of_invoice_qty = invoice_qty_total.reduce(function (total, current) {
                return total + current;
            }, 0);
        }
    }

    invoice_nos = invoice_tot.join(",");

    


    formData.append("bill_form_unique_id", bill_form_unique_id);
    formData.append("po_num", po_num);
    formData.append("po_date", po_date);
    formData.append("invoice_no", invoice_nos);
    formData.append("invoice_date", invoice_date);
    formData.append("invoice_value", sum_of_checkbox_value);
    formData.append("invoice_qty", sum_of_invoice_qty);
    formData.append("claim_amount", claim_amount);
    formData.append("ledger_name", ledger_name);
    formData.append("bg_value", bg_value);
    formData.append("bg_date", bg_date);
    formData.append("bg_num", bg_num);
    formData.append("action", "demo");

    // Optional: attach file if any

   

    var ajax_url = sessionStorage.getItem("folder_crud_link");
    var url = sessionStorage.getItem("list_link");
    $.ajax({
        type: "POST",
        url: ajax_url,
        data: formData,
        contentType: false,
        processData: false,
        beforeSend: function () {
            $(".po_delivery_add_update_btn").attr("disabled", "disabled");
            $(".po_delivery_add_update_btn").text("Loading...");
        },
        success: function (data) {
            // alert(data);



            bill_creation_sub();

        },
        error: function (data) {
            alert("Network Error");
        }
    });
}

function bill_creation_sub() {

    
    // alert();
    // var stock_qty = document.getElementsByName('stock_qty[]');
    // var checkbox_qty = document.getElementsByName('bill_checkbox[]');
    const checked = document.querySelectorAll('.myCheck:checked');
    //  var checkbox_qty_length = checkbox_qty.length;
    for (var i = 0; i < checked.length; i++) {
        var checkbox = checked[i];
        // var bill_form_unique_id = document.getElementById('bill_form_unique_id').value;
        var bill_form_unique_id = checkbox.parentElement.querySelector('#bill_form_unique_id').value;
        // alert(bill_form_unique_id);
        // var po_num = document.getElementById('po_num').value;
        var po_num = checkbox.parentElement.querySelector('#po_num').value;
        // alert(po_num);
        // var po_date = document.getElementById('po_date').value;
        var po_date = checkbox.parentElement.querySelector('#po_date').value;

        var invoice_date = checkbox.parentElement.querySelector('#invoice_date').value;
        // alert(invoice_date);
        // var invoice_auto_id_val = checkbox.parentElement.querySelector('#invoice_auto_id').value;
        // alert(invoice_auto_id_val);


        var claim_amount = checkbox.parentElement.querySelector('#claim_amount').value;

        var parentElement = checked[i].parentElement;
        var invoice_qty_val = parentElement.querySelector('#invoice_qty').value;
        // alert(invoice_qty_val);
        var invoice_val = parentElement.querySelector('#invoice_value').value;
        invoice_val = invoice_val.replace(/,/g, '');

        // alert(invoice_val);
        var invoice_no_val = parentElement.querySelector('#invoice_no').value;


        var data = "bill_form_unique_id=" + bill_form_unique_id + "&invoice_no=" + invoice_no_val + "&invoice_date=" + invoice_date + "&invoice_value=" + invoice_val + "&invoice_qty=" + invoice_qty_val + "&po_num=" + po_num + "&po_date=" + po_date + "&claim_amount=" + claim_amount;
        // + "&checkbox_qty=" + checkbox_qty_val
        data += "&action=bill_submission_add_update";
        var ajax_url = sessionStorage.getItem("folder_crud_link");
        var url = sessionStorage.getItem("list_link");
        $.ajax({
            type: "POST",
            url: ajax_url,
            data: data,
            beforeSend: function () {
                $(".po_delivery_add_update_btn").attr("disabled", "disabled");
                $(".po_delivery_add_update_btn").text("Loading...");
            },
            success: function (data) {
                // alert(data);
                var obj = JSON.parse(data);
                var msg = obj.msg;
                var status = obj.status;
                var error = obj.error;
                // alert(msg);
                if (!status) {
                    url = '';
                    $(".createupdate_btn").text("Error");
                    console.log(error);
                } else {
                    if (msg == "already") {
                        // Button Change Attribute
                        url = '';
                        $(".createupdate_btn").removeAttr("disabled", "disabled");
                        if (unique_id) {
                            $(".createupdate_btn").text("Update");
                        } else {
                            $(".createupdate_btn").text("Save");
                        }
                    }
                }
                // location.reload();
                // alert("hello");
                // var xx = document.getElementById('tabs_val').value;
                // alert(xx);
                // const urls = 'http://122.165.127.123/aed_elcot_beta/index.php?file=elcot_entry/list&page=1';
                // var urls = 'http://122.165.127.123:41290/aed_elcot/index.php?file=elcot_entry/list&page=1';
                // var urls = 'http://localhost/aed_elcot/index.php?file=elcot_entry/list&page=1';
                var urls = 'http://122.165.127.123:35267/otm_beta/index.php?file=bill_creation/list&page=1';
                //                     if(xx == '1'){
                //                             sweetalert(msg, urls);
                // //sweetalert(msg);

                //                     }else{
                sweetalert(msg, url);


                // location.reload();
                // sweetalert(msg, url);
            },
            error: function (data) {
                alert("Network Error");
            }
        });
        // }
    }
}

function print_1(file_name) {
    window.location = 'uploads/po_form/po_attach/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no';
}


function print_pdf_1(file_name) {

    onmouseover = window.open('uploads/po_form/po_attach/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
}
// function print(file_name) {
//     onmouseover = window.open('uploads/kra_kpi_form/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
// }
function print_view_1(file_name) {

    window.open('uploads/po_form/po_attach/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
}

function bill_submission_add_update() {
    // 	alert('hello');
}




function print_2(file_name) {
    window.location = 'uploads/elcot_entry/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no';
}


function print_pdf_2(file_name) {

    onmouseover = window.open('uploads/elcot_entry/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
}
// function print(file_name) {
//     onmouseover = window.open('uploads/kra_kpi_form/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
// }
function print_view_2(file_name) {

    window.open('uploads/elcot_entry/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
}

function bill_submission_add_update() {
    // 	alert('hello');
}


function get_cus_po_details(po_num) {

    var data = {
        "po_num": po_num,
        "action": "get_cus_po_details"
    }

    var ajax_url = sessionStorage.getItem("folder_crud_link");

    $.ajax({
        type: "POST",
        url: ajax_url,
        data: data,

        success: function (data) {

            var obj = JSON.parse(data);

            var customerAddress = obj.customerAddress;
            var customerName = obj.customerName;
            var customerDept = obj.customerDept;
            var customerLan = obj.customerLan;
            var customerEmail = obj.customerEmail;
            var customerState = obj.customerState;
            var customerDistrict = obj.customerDistrict;
            var customerPincode = obj.customerPincode;
            var customerContact = obj.customerContact;
            var po_num = obj.po_num;
            var po_date = obj.po_date;
            var executive_name = obj.executive_name;
            var warranty = obj.warranty;
            var bg_percen = obj.bg_percen;
            var bg_month = obj.bg_month;
            var cus_address = obj.cus_address;

            $("#cus_address").html(cus_address);
            $("#cus_dept").html(customerDept);
            $("#cus_landline").html(customerLan);
            $("#cus_email").html(customerEmail);
            $("#po_no").html(po_num);
            $("#po_date").html(po_date);
            $("#executive_name").html(executive_name);
            $("#warranty").html(warranty);
            $("#bg_percen").html(bg_percen);
            $("#bg_month").html(bg_month);

            if (bg_percen != '-' && bg_percen != '') {
                $("#bg_value").val('');
                $("#bg_date").val('');
                $("#bg_doc").val('');
                $("#bg").val('with_bg');
                $("#bg_div").css("display", "inline-flex");
            } else {
                $("#bg_value").val('');
                $("#bg_date").val('');
                $("#bg_doc").val('');
                $("#bg").val('without_bg');
                $("#bg_div").css("display", "none");
            }




        },
    });



}



