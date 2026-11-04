$(document).ready(function () {
    // var table_id 	= "user_type_datatable";
    init_datatable(table_id, form_name, action);
    // sub_list_datatable('bill_generate_datatable', form_name, 'bill_generate_datatable');

    sub_list_datatable_bill('bill_datatable', form_name, 'bill_datatable');
    sub_list_datatable_partial_bill('partial_bill_datatable', form_name, 'partial_bill_datatable');
    
	get_data();
	// get_date_filter();
});
function get_data() {
    init_datatable(table_id, form_name, action);

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
    
    var ins_unique_id = document.getElementById('ins_unique_id').value;
    var my_inv_no = document.getElementById('my_inv_no').value;
    // alert(ins_unique_id);
    var bill_form_main_unique_id = document.getElementById('bill_form_main_unique_id').value;
    var po_num = document.getElementById('po_num').value;
    var po_date = document.getElementById('po_date').value;
    var con_contact_name = document.getElementById('con_contact_name').value;
    var con_address = document.getElementById('con_address').value;

    var invoice_no = document.getElementById('invoice_no').value;
    var invoice_date = document.getElementById('invoice_date').value;
    var invoice_value = document.getElementById('invoice_value').value;
    var file_name = document.getElementById('file_name').value;
    var consignee_unique_id = document.getElementById('consignee_unique_id').value;
    var invoice_qty = document.getElementById('invoice_qty').value;
    // alert(invoice_qty);
    var claim_amount = document.getElementById('claim_amount').value;
    // alert(claim_amount);
    // var invoice_copy = document.getElementById('invoice_copy').value;
    var ir_status = document.getElementById('ir_status').value;
  
    var installation_reference_no = document.getElementById('installation_reference_no').value;
        
    var supplier_invoice_number = document.getElementById('supplier_invoice_number').value;
    var unique_id = document.getElementById('unique_id').value;
    var bill_status = document.getElementById('bill_status').value;
    var snr_status = document.getElementById('snr_status').value;
    // alert(snr_status);

    if((snr_status=='1')||(snr_status=='SNR')){
        var test_doc3 = document.getElementById('scanned_snr_copy').value;
        // }  
        // if(ir_status!='1'){
       
    
        }
        else{
            var test_doc3='';
        }

        
    

    var test_doc = document.getElementById('scanned_dc_copy').value;
    if(ir_status=='undefined'){
        // if((snr_status=='1')||(snr_status=='SNR')){
        var test_doc1 = '';
        }
        else{
            var test_doc1 = document.getElementById("scanned_ir_copy");
        }
    // alert(test_doc);
    // if(ir_status=='1'){
    //     var test_doc1 = document.getElementById('scanned_ir_copy').value;
    //     }
    // alert(test_doc1);
    var test_doc2 = document.getElementById('invoice_copy').value;
    //  alert(test_doc2);
    var image_s = document.getElementById("scanned_dc_copy");

    if(ir_status=='undefined'){
        // if((snr_status=='1')||(snr_status=='SNR')){
        var image_ir = '';
        }
        else{
            var image_ir = document.getElementById("scanned_ir_copy");
        }
        if(snr_status=='undefined' || snr_status=='' ){
            // if((snr_status=='1')||(snr_status=='SNR')){
            var image_snr = '';
            }
            else{
                var image_snr = document.getElementById("scanned_snr_copy");
            }
    // if(ir_status=='1'){
        
    //     }
    // var image_ir = document.getElementById("scanned_ir_copy");
    var image_in = document.getElementById("invoice_copy");

    if (test_doc != '' || test_doc1 != '' || test_doc2 != '' || test_doc3!='') {
        var data = new FormData();
        if(image_snr!= '') {
            for (var i = 0; i<image_snr.files.length; i++) {
                data.append("test_file3", document.getElementById('scanned_snr_copy').files[i]);
            }
        } else {
            data.append("test_doc3", '');

        }

        if (image_s != '') {
            for (var i = 0; i < image_s.files.length; i++) {
                data.append("test_file", document.getElementById('scanned_dc_copy').files[i]);
            }
        } else {

            data.append("test_doc", '');

        }
        if (image_ir != '') {
            for (var i = 0; i < image_ir.files.length; i++) {
                data.append("test_file1", document.getElementById('scanned_ir_copy').files[i]);
            }
        } else {

            data.append("test_doc1", '');

        }
        if (image_in != '') {
            for (var i = 0; i < image_in.files.length; i++) {
                data.append("test_file2", document.getElementById('invoice_copy').files[i]);
            }
        } else {

            data.append("test_doc2", '');

        }
        data.append("bill_form_main_unique_id", bill_form_main_unique_id);
        data.append("my_inv_no", my_inv_no);
        data.append("po_num", po_num);
        data.append("po_date", po_date);
        data.append("consignee_unique_id", consignee_unique_id);
        data.append("con_contact_name", con_contact_name);
        data.append("ins_unique_id", ins_unique_id);
        //  data.append("con_contact_number", con_contact_number);
        data.append("con_address", con_address);
        data.append("invoice_no", invoice_no);
        data.append("invoice_date", invoice_date);
        // data.append("dc_no", dc_no);
        data.append("invoice_value", invoice_value);
        data.append("file_name", file_name);
        data.append("consignee_unique_id", consignee_unique_id);
        data.append("invoice_qty", invoice_qty);
        data.append("claim_amount", claim_amount);
        data.append("bill_status", bill_status);
        data.append("installation_reference_no", installation_reference_no);
        data.append("unique_id", unique_id);// data.append("district", district);
        data.append("supplier_invoice_number", supplier_invoice_number);

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


    } else {
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
     // Destroy existing DataTable instance if it exists
    //  if ($.fn.DataTable.isDataTable('#' + table_id)) {
    //     $('#' + table_id).DataTable().destroy();
    // }

    // // Initialize DataTable
    // $('#' + table_id).DataTable({
    //     "destroy": true  ,    // Allows re-initializing the table
    //     "processing": true,    // Show a processing indicator while loading data
    //     "serverSide": true,    // Use server-side processing
    //     "ajax": {
    //         "url": ajax_url,  // The URL to which the request is sent
    //         "type": "POST",   // HTTP method used for the request
    //         "data": data      // Data sent with the request
    //     },
    //     "pageLength": 10,      // Set initial page length
    //     // "lengthMenu": [ [5, 10, 25, 50, 100, 200, 500,1000,1500,2000], [5, 10, 25, 50, 100, 200, 500,1000,1500,2000] ], // Page length options
    //     "lengthMenu": [ [10, 50, 100,500, -1], [10, 50, 100,500, "All"] ],
    //     dom: '<"top"lBf>rt<"bottom"ip><"clear">',

    //     buttons: [
    //         'copy', 'csv', 'excel', 'pdf', 'print' // Include export and print options
    //     ],
        
    });
    
}

$(document).ready(function () {
	var table = $('#bill_submission_datatable').DataTable();

	// Clear the search input value and redraw the table
	table.search('').draw();

	// Also clear the input box visually if needed
	$('.dataTables_filter input').val('');
});

// function sub_list_datatable(table_id = "", form_name = "", action = "") {
//     // // alert('hii');
//     // var bill_form_main_unique_id = $("#bill_form_main_unique_id").val();
//     //  var invoice_no = $("#invoice_no").val();

//     // alert(invoice_no);

//     var table_id = 'bill_generate_datatable';
//     // alert(table_id);
//     var table = $("#" + table_id);
//     var from_date = $("#from_date_com").val();
// 	// alert(from_date);
// 	var to_date = $("#to_date_com").val();
// 	// alert(to_date);
// 	var opt1 = $("#opt1").val();
//     var data = {

//         "action": 'bill_generate_datatable',
//         "from_date": from_date,
// 		"to_date": to_date,
// 		"opt1": opt1,
//         //  "bill_form_main_unique_id":bill_form_main_unique_id,
//         //  "invoice_no":invoice_no,

//     };

//     var ajax_url = sessionStorage.getItem("folder_crud_link");

//     var datatable = table.DataTable({
// 		ordering    : true,
// 		searching   : true,
// 		"ajax"		: {
// 			url 	: ajax_url,
// 			type 	: "POST",
// 			data 	: data
// 		}
// 	});
// }
function sub_list_datatable_bill(table_id = "", form_name = "", action = "") {
    var po_num_bill = $("#po_num_bill").val();
    var ins_unique_id = $("#ins_unique_id").val();
    var screen_id_val = $('#screen_id_val').val();
    var user_type_unique_id = $('#user_type_unique_id').val();

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
        "destroy": true  ,    // Allows re-initializing the table
        "processing": true,    // Show a processing indicator while loading data
        "serverSide": true,    // Use server-side processing
        "ajax": {
            "url": ajax_url,  // The URL to which the request is sent
            "type": "POST",   // HTTP method used for the request
            "data": data      // Data sent with the request
        },
        // "pageLength": 10,      // Set initial page length
        // "lengthMenu": [ [10, 50, 100,500, -1], [10, 50, 100,500, "All"] ],
        // "lengthMenu": [ [5, 10, 25, 50, 100, 200, 500], [5, 10, 25, 50, 100, 200, 500] ], // Page length options
        // dom: '<"top"lBf>rt<"bottom"ip><"clear">',
//   dom: 'Bfrtip',
        dom: '<"dt-top-container"<l><"dt-center-in-div"B><f>r>t<ip>',

        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print' // Include export and print options
        ],
         lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
			pageLength: 10 // Default selected value
        
    });
}


$(document).ready(function () {
	var table = $('#bill_datatable').DataTable();

	// Clear the search input value and redraw the table
	table.search('').draw();

	// Also clear the input box visually if needed
	$('.dataTables_filter input').val('');
});

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
          "po_num_bill"	: po_num_bill, 
          "screen_id_val": screen_id_val,
          "user_type_unique_id": user_type_unique_id,
        //   "ins_unique_id"	: ins_unique_id, 
    };
// alert(data);
    var ajax_url = sessionStorage.getItem("folder_crud_link");

    var datatable = table.DataTable({
        destroy: true, //new line
		ordering    : true,
		searching   : true,
		"ajax"		: {
			url 	: ajax_url,
			type 	: "POST",
			data 	: data
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
function get_invoice_data(filter_data_bill= 0){

    	var po_num_bill  = $("#po_num_bill").val();
    	// alert(po_num_bill);

		sessionStorage.setItem("po_num_bill", po_num_bill);

			var filter_data_bill = {
				"po_num_bill": po_num_bill,

			};
			console.log(filter_data_bill);

		sub_list_datatable_bill('bill_datatable',form_name,'bill_datatable');
}

// function get_invoice_data() {

//     var po_num_bill = $("#po_num_bill").val();
//     var table_id = 'bill_datatable';


//     var table = $("#" + table_id);

//     var ajax_url = sessionStorage.getItem("folder_crud_link");
//     //   var url      = sessionStorage.getItem("list_link");

//     var data = {
//         "action": 'bill_datatable',
//         "po_num_bill": po_num_bill,

//     };

//     $.ajax({

//         url: ajax_url,
//         type: "POST",
//         data: data,


//         success: function (data) {
//             var obj = JSON.parse(data);
//             var data = obj.data;
//             var bg_sts = obj.bg_sts;

//             if (bg_sts == "on") {

//                 $('#bill_datatable_bg').css('display', 'block');
//                 $('#bill_datatable').css('display', 'none');
//                 $('#data_table1').html(data);

//             }
//             else if (bg_sts != "on") {
//                 $('#bill_datatable').css('display', 'block');
//                 $('#bill_datatable_bg').css('display', 'none');
//                 $('#data_table').html(data);

//             }


//         }


//     });
// }


function po_invoice_create() {
    // alert();
        var internet_status = is_online();
        //  var checkbox_qty = document.getElementById('checkbox').value;
        // var checkbox_qty = document.getElementsByName('bill_checkbox[]');
        const checked = document.querySelectorAll('.myCheck:checked');
        var invoice_qty_total = [];
        var invoice_qty_amt = [];
        var invoice_tot = [];
        // for (var i = 0; i < checked.length; i++) {
        // alert(i);
        //  for (var i = 0; i < checked.length; i++){
        // alert(i);
        // var checkbox_qty_val = checkbox_qty.length;
        // var bill_form_unique_id = document.getElementById('bill_form_unique_id').value;
        for (var i = 0; i < checked.length; i++) {
            // Get the unique identifier for each row
            var checkbox = checked[i];
            var bill_form_unique_id = checkbox.parentElement.querySelector('#bill_form_unique_id').value;
            var po_num = checkbox.parentElement.querySelector('#po_num').value;
            // alert(po_num);
            var invoice_date = checkbox.parentElement.querySelector('#invoice_date').value;
            var po_date = checkbox.parentElement.querySelector('#po_date').value;

            // var invoice_auto_id_val = checkbox.parentElement.querySelector('#invoice_auto_id').value;
            // alert(invoice_auto_id_val);
            // var invoice_qty_val = checkbox.parentElement.querySelector('#invoice_qty').value;
            // alert(invoice_qty);
            var parentElement = checked[i].parentElement;
            var invoice_value_val = parentElement.querySelector('#invoice_value').value;
            
            var claim_amount = parentElement.querySelector('#claim_amount').value;
            var con_address = parentElement.querySelector('#con_address').value;
           
            var invoice_qty_val = parentElement.querySelector('#invoice_qty').value;
            // alert(invoice_qty_val);
            var invoice_no = parentElement.querySelector('#invoice_no').value;
            // alert(invoice_no);
           
            invoice_tot.push(invoice_no);
            
            var bg_num_val = parentElement.querySelector('#bg_num').value;
            // alert(bg_num_val);
            var bg_id_val = parentElement.querySelector('#bg_id').value;
            var bg_date_val = parentElement.querySelector('#bg_date').value;
            var bg_value_val = parentElement.querySelector('#bg_value').value;

           // Clean the value (remove commas, etc.)
    invoice_value_val = invoice_value_val.replace(/,/g, ''); // remove commas if any
    // alert(invoice_value_val);
            var amount = parseFloat(invoice_value_val);
            // alert(amount);
            
            if (!isNaN(amount)) {
                invoice_qty_amt.push(amount);
                var sum_of_checkbox_value = invoice_qty_amt.reduce(function(total, current) {
                    return total + current;
                }, 0);
            }
            // alert(sum_of_checkbox_value);
            // total qty calculate
            var number = parseFloat(invoice_qty_val);
            if (!isNaN(number)) {
                invoice_qty_total.push(number);
                var sum_of_invoice_qty = invoice_qty_total.reduce(function(total, current) {
                    return total + current;
                }, 0);
            }
        }
        // alert(sum_of_invoice_qty);
        invoice_nos = invoice_tot.join(",");
        // alert(invoice_nos);
        // alert(invoice_nos);
        // "&con_contact_name=" + con_contact_name + "&con_address=" + con_address +"&consignee_unique_id=" + consignee_unique_id +
        var data = "bill_form_unique_id=" + bill_form_unique_id + "&po_num=" + po_num + "&po_date=" + po_date + "&invoice_no=" + invoice_nos + "&invoice_date=" + invoice_date + "&invoice_value=" + sum_of_checkbox_value + "&invoice_qty=" + sum_of_invoice_qty + "&bg_num=" + bg_num_val  + "&bg_id=" + bg_id_val + "&bg_date=" + bg_date_val + "&bg_value=" + bg_value_val+"&claim_amount=" + claim_amount + "&con_address=" + con_address;
        // + "&invoice_auto_id=" + invoice_auto_id_val
        // + "&checkbox_qty=" + checkbox_qty_val
        //var data="bill_form_unique_id=" +bill_form_unique_id + "&consignee_unique_id=" + consignee_unique_id;
        data += "&action=demo";
        var ajax_url = sessionStorage.getItem("folder_crud_link");
        var url = sessionStorage.getItem("list_link");
        $.ajax({
            type: "POST",
            url: ajax_url,
            data: data,
            beforeSend: function() {
                $(".po_delivery_add_update_btn").attr("disabled", "disabled");
                $(".po_delivery_add_update_btn").text("Loading...");
            },
            success: function(data) {
                // alert(data);
        bill_creation_sub();

            },
            error: function(data) {
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
            // alert(po_date);
            var con_contact_name = checkbox.parentElement.querySelector('#con_contact_name').value;
            // alert(con_contact_name);
            var con_address = checkbox.parentElement.querySelector('#con_address').value;
            //    alert(con_address);
            // var con_contact_name = document.getElementById('con_contact_name').value;
            // alert(con_contact_name);
            // var con_address = document.getElementById('con_address').value;
            // alert(con_address);
            var consignee_unique_id = checkbox.parentElement.querySelector('#consignee_unique_id').value;
            // var consignee_unique_id = document.getElementById('consignee_unique_id').value;
            var invoice_date = checkbox.parentElement.querySelector('#invoice_date').value;
            // alert(invoice_date);
            var invoice_auto_id_val = checkbox.parentElement.querySelector('#invoice_auto_id').value;
            // alert(invoice_auto_id_val);
            var parentElement = checked[i].parentElement;
            var invoice_qty_val = parentElement.querySelector('#invoice_qty').value;
            // alert(invoice_qty_val);
            var invoice_val = parentElement.querySelector('#invoice_value').value;
            invoice_val = invoice_val.replace(/,/g, '');
            // alert(invoice_val);
            var invoice_no_val = parentElement.querySelector('#invoice_no').value;
            var ins_unique_id = parentElement.querySelector('#ins_unique_id').value;
            // alert(ins_unique_id);
            // var ins_unique_id = document.getElementById('ins_unique_id').value;
            // alert(ins_unique_id);
            // var invoice_value = document.getElementsByName('invoice_value[]');
            // var invoice_no = document.getElementsByName('invoice_no[]');
            // var invoice_qty = document.getElementsByName('invoice_qty[]');
            // var checkbox_qty_val = checkbox_qty[i].value;
            // var invoice_no_val = invoice_no[i].value;
            // alert(invoice_no_val);
            // var invoice_val = invoice_value[i].value;
            // alert(invoice_val);
            // var invoice_qty_val = invoice_qty[i].value;
            // var invoice_date = document.getElementById('invoice_date').value;
            // var consignee_unique_id= document.getElementById('consignee_unique_id').value;
            var data = "bill_form_unique_id=" + bill_form_unique_id + "&invoice_no=" + invoice_no_val + "&invoice_date=" + invoice_date + "&invoice_value=" + invoice_val + "&invoice_qty=" + invoice_qty_val + "&po_num=" + po_num + "&po_date=" + po_date + "&con_contact_name=" + con_contact_name + "&con_address=" + con_address + "&invoice_auto_id=" + invoice_auto_id_val + "&consignee_unique_id=" + consignee_unique_id+"&ins_unique_id=" + ins_unique_id;
            // + "&checkbox_qty=" + checkbox_qty_val
            data += "&action=bill_submission_add_update";
            var ajax_url = sessionStorage.getItem("folder_crud_link");
            var url = sessionStorage.getItem("list_link");
            $.ajax({
                type: "POST",
                url: ajax_url,
                data: data,
                beforeSend: function() {
                    $(".po_delivery_add_update_btn").attr("disabled", "disabled");
                    $(".po_delivery_add_update_btn").text("Loading...");
                },
                success: function(data) {
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
                    var xx = document.getElementById('tabs_val').value;
                    // alert(xx);
                    // const urls = 'http://122.165.127.123/aed_elcot_beta/index.php?file=elcot_entry/list&page=1';
                    // var urls = 'http://122.165.127.123:41290/aed_elcot/index.php?file=elcot_entry/list&page=1';
                    // var urls = 'http://localhost/aed_elcot/index.php?file=elcot_entry/list&page=1';
                     var urls = 'http://122.165.127.123:35267/aed_elcot/index.php?file=elcot_entry/list&page=1';
                    if(xx == '1'){
                             sweetalert(msg, urls);
                    }else{
                       sweetalert(msg, url);
                    }
                    // location.reload();
                    // sweetalert(msg, url);
                },
                error: function(data) {
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



