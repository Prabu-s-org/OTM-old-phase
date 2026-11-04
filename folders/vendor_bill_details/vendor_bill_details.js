$(document).ready(function () {
	// var table_id 	= "user_type_datatable";
	init_datatable(table_id,form_name,action);
	datatable_completed(table_id_1,form_name,action_1);
	// sub_list_datatable('fixed_datatable',form_name,'fixed_datatable');
	// sub_list_datatable_delivery('deleivery_datatable',form_name,'deleivery_datatable');
	// sub_list_datatable_5('pending_5_datatable',form_name,'pending_5_datatable');
	// sub_list_datatable_25('pending_one_datatable',form_name,'pending_one_datatable');
	// get_data();
});
function get_data() {
	// alert();
	init_datatable(table_id, form_name, action);
	datatable_completed(table_id_1,form_name,action_1);
	// sub_list_datatable(dc_ir_dispatch_datatable, form_name, dc_ir_dispatch_datatable);
  
  }
var company_name 	= sessionStorage.getItem("company_name");
var company_address	= sessionStorage.getItem("company_name");
var company_phone 	= sessionStorage.getItem("company_name");
var company_email 	= sessionStorage.getItem("company_name");
var company_logo 	= sessionStorage.getItem("company_name");

var form_name 		= 'vendorpayment Payment Creation';
var form_header		= '';
var form_footer 	= '';
var table_name 		= '';
var table_id 		= 'vendorpayment_datatable';
var table_id_1		= 'vendorpayment_datatable_completed';
// var table_id_1 		= 'fixed_datatable';
// var table_id_2		= 'deleivery_datatable';
var action 			= "datatable";
var action_1		= "datatable_completed";



function init_datatable(table_id='',form_name='',action='') {

	var table = $("#"+table_id);
	var from_date = $("#from_date").val();
	var to_date = $("#to_date").val();
	var screen_id_val = $('#screen_id_val').val();
	var user_type_unique_id = $('#user_type_unique_id').val();
  
	var opt = $("#opt").val();
	
	var data 	  = {
		"action"	: action, 
		"from_date": from_date,
		"to_date": to_date,
		"opt": opt,
		"screen_id_val": screen_id_val,
		"user_type_unique_id": user_type_unique_id,

	};
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
		dom: 'lBfrtip',
		buttons: [
			'copy', 'csv', 'excel', 'pdf', 'print'
		] 
	});
}

function datatable_completed(table_id_1='',form_name='',action_1='') {
	
	var table = $("#"+table_id_1);
	var from_date = $("#from_date").val();
	var to_date = $("#to_date").val();
	var screen_id_val = $('#screen_id_val').val();
	var user_type_unique_id = $('#user_type_unique_id').val();
	var opt = $("#opt").val();

	var data 	  = {
		"action"	: action_1, 
		"from_date": from_date,
		"to_date": to_date,
		"opt": opt,
		"screen_id_val": screen_id_val,
		"user_type_unique_id": user_type_unique_id,

	};
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
		dom: 'lBfrtip',
		buttons: [
			'copy', 'csv', 'excel', 'pdf', 'print'
		],
		autoWidth: false,
		columnDefs: [
			{ targets: 0, width: '5%' },
			{ targets: 1, width: '10%' },
			{ targets: 2, width: '15%' },
			{ targets: 3, width: '40%' },
			{ targets: 4, width: '10%' },
			{ targets: 5, width: '10%' }
		]
	});
}

function vendor_payment_delete(unique_id = "") {

	var ajax_url = sessionStorage.getItem("folder_crud_link");
	var url      = sessionStorage.getItem("list_link");
	
	confirm_delete('delete')
	.then((result) => {
		if (result.isConfirmed) {

			var data = {
				"unique_id" 	: unique_id,
				"action"		: "delete"
			}

			$.ajax({
				type 	: "POST",
				url 	: ajax_url,
				data 	: data,
				success : function(data) {

					var obj     = JSON.parse(data);
					var msg     = obj.msg;
					var status  = obj.status;
					var error   = obj.error;

					if (!status) {
						url 	= '';
						
					} else {
						init_datatable(table_id,form_name,action);
					}
					sweetalert(msg,url);
				}
			});

		} else {
			// alert("cancel");
		}
	});
}



function cancel_bill(){
	// alert();

	var internet_status = is_online();
var unique_id = document.getElementById('unique_id').value;
  var bill_no = document.getElementById('bill_no').value;
//   alert(bill_no);
	
	var invoice_no = document.getElementById('invoice_no').value;
	// alert(invoice_no);
	var invoice_val = document.getElementById('invoice_val').value;
	// alert(invoice_val);
	var invoice_qty = document.getElementById('invoice_qty').value;
	// alert(invoice_qty);

	var reject_reason = document.getElementById('reject_reason').value;

	var rejectInvoiceNoInput = document.getElementById('invoice_no').value;
	var main_invoice_no = document.getElementById('main_invoice_no').value;
	var remaing_main_invoice_no = document.getElementById('remaing_main_invoice_no').value;
	
	var mainInvoiceNo = document.getElementById('main_invoice_no').value;
	
var rejectInvoiceNo = document.getElementById('invoice_no').value;
// alert(rejectInvoiceNo);

// Update the remaining invoice numbers input field
var remainingInvoiceInput = document.getElementById('remaing_main_invoice_no');

var cancelInvoiceInput = document.getElementById('cancel_invoice_no');



// Ensure input fields are correctly referenced
if (!remainingInvoiceInput) {
	console.error('Input field "remaing_main_invoice_no" not found');
	return;
}
if (!cancelInvoiceInput) {
	console.error('Input field "cancel_invoice_no" not found');
	return;
}

// Split the main invoice numbers into an array
var mainInvoiceNumbers = mainInvoiceNo.split(',').map(num => num.trim());

// Get the already rejected invoices from the cancel_invoice_no input field
var existingCancelInvoiceNo = cancelInvoiceInput.value.split(',').map(num => num.trim()).filter(num => num);

// Add the new rejected invoice to the list if not already included
if (!existingCancelInvoiceNo.includes(rejectInvoiceNo)) {
	existingCancelInvoiceNo.push(rejectInvoiceNo);
}

// Update the cancel_invoice_no field with the new list of rejected invoices
cancelInvoiceInput.value = existingCancelInvoiceNo.join(',');

// Filter out the rejected invoices from the main invoice numbers to get remaining invoices
var updatedMainInvoices = mainInvoiceNumbers.filter(num => !existingCancelInvoiceNo.includes(num));

// Update the remaining invoice numbers input field
remainingInvoiceInput.value = updatedMainInvoices.join(',');

	var is_form = form_validity_check("was-validated");


		var data = "unique_id=" +unique_id + "&bill_no=" + bill_no + "&reject_reason=" + reject_reason +"&invoice_qty=" + invoice_qty+"&invoice_val=" + invoice_val + "&cancel_invoice_no=" + cancelInvoiceInput.value+"&remaining_invoice_no="+ remainingInvoiceInput.value + "&invoice_no=" + invoice_no + "&main_invoice_no=" + main_invoice_no;
		data += "&action=bill_cancel_add_update";

		var ajax_url = sessionStorage.getItem("folder_crud_link");
			var url      = sessionStorage.getItem("list_link");
			$.ajax({
				type: "POST",
				url: ajax_url,
				data: data,
				beforeSend: function() {
					$(".po_delivery_add_update_btn").attr("disabled", "disabled");
					$(".po_delivery_add_update_btn").text("Loading...");
				},
				success: function(data) {
					alert(data);
					var obj = JSON.parse(data);
					var msg = obj.msg;
					var status = obj.status;
					var error = obj.error;
					// alert(msg);
					if (!status) {
				url 	= '';
				$(".createupdate_btn").text("Error");
				console.log(error);
			} else {
				if (msg=="already") {
					// Button Change Attribute
					url 		= '';

					// $(".createupdate_btn").removeAttr("disabled","disabled");
					if (unique_id) {
						$(".createupdate_btn").text("Update");
					} else {
						$(".createupdate_btn").text("Save");
					}
				}
			}
		
					sweetalert(msg,url);
					//alert(data);
					// stock_creation_sub();
		
			},
			error: function(data) {
				alert("Network Error");
			}
		});
		}
		// else{
		// 		// alert("Enter Valid Product Quantity..");
		// 	// alert('hello');
		// }
	

function print_view_1(file_name)
{
    // 
	 	window.location='uploads/payment/' + file_name,'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no';
}
function print_pdf(file_name)
{
    
	 onmouseover=window.open('uploads/payment/' + file_name,'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
}






