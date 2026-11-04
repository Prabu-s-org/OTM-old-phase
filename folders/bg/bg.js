$(document).ready(function () {
	// var table_id 	= "user_type_datatable";
	init_datatable(table_id, form_name, action);
	sub_list_datatable1('bg_update_datatable', form_name, 'bg_update_datatable');
	sub_list_datatable('bg_datatable', form_name, 'bg_datatable');
	get_user_permission();
	get_user_permission_1();
	// get_dc_number();
});
var company_name = sessionStorage.getItem("company_name");
var company_address = sessionStorage.getItem("company_name");
var company_phone = sessionStorage.getItem("company_name");
var company_email = sessionStorage.getItem("company_name");
var company_logo = sessionStorage.getItem("company_name");
var form_name = 'State Creation';
var form_header = '';
var form_footer = '';
var table_name = '';
var table_id = 'bg_datatable';
var action = "datatable";
function get_filter(filter_action = 0) {
	// 		var from_date       = $("#from_date").val();
	// 		var to_date         = $("#to_date").val();
	var status = $("#status").val();
	// 			sessionStorage.setItem("from_date", from_date);
	// 			sessionStorage.setItem("to_date", to_date);
	sessionStorage.setItem("status", status);

	var filter_data = {
		// "from_date": from_date,
		// "to_date": to_date,
		"status": status,

	};
		init_datatable(table_id, form_name, action, filter_data);
}
function init_datatable(table_id = '', form_name = '', action = '') {
	var status = $("#status").val();
		var table = $("#" + table_id);
	var screen_id_val = $('#screen_id_val').val();
		var user_type_unique_id = $('#user_type_unique_id').val();
	var data = {
		"action": action,
		"status": status,
		"screen_id_val": screen_id_val,
		"user_type_unique_id": user_type_unique_id,
	};
	var ajax_url = sessionStorage.getItem("folder_crud_link");
	var datatable = table.DataTable({
		destroy: true,
		ordering: true,
		searching: true,
		
		"ajax": {
			url: ajax_url,
			type: "POST",
			data: data
		},
		dom: 'Bfrtip',
		buttons: [
			'copy', 'csv', 'excel', 'pdf', 'print'
		],
		 columnDefs: [
        { width: "15%", targets: 3 } // 4th column (index 3)
    ],
    autoWidth: false 
	});
}
function get_bg_data(filter_data_bill = 0) {

	var po_num = $("#po_num").val();
	// alert(po_num);
	sessionStorage.setItem("po_num", po_num);
	// sessionStorage.setItem("dc_count", dc_count);

	var filter_data_bill = {
		"po_num": po_num,
		// "dc_count": dc_count,
		action: "cardData",

	};
	sub_list_datatable('bg_create_datatable', form_name = "", 'bg_create_datatable');

	// var data = {
	// 	action: "cardData",
	// 	po_num: po_num,
	// 	dc_count: dc_count
	// };

	// var ajax_url = sessionStorage.getItem("folder_crud_link");

	// // Fire AJAX request
	// $.ajax({
	// 	type: "POST",
	// 	url: ajax_url,
	// 	data: filter_data_bill,
		
	// 	success: function (response) {
	// 		var obj = JSON.parse(response);
	// 		//console.reponse
	// 		 // Clear any existing content first
  	// 	  $("#dc_count").text(''); // Reset the count area

	// 		// if(po_no != ''){
	// 		// $("#po_num_val").html(obj.po_no || '');
	// 		$("#dc_count").text(obj.dccount || '');
	// 		// }else{
	// 		// 	$("#po_num_val").append('No Record Found!');
	// 		// }
			
	// 	},
	// 	error: function (xhr, error, code) {
	// 		console.error("AJAX Error: ", error);
	// 	}
	// });



	// 			console.log(filter_data_bill);

	
}




// function get_dc_number() {
// 	var po_no = $('#po_no').val();
// 	// alert(po_no);
// 	// var invoice_no = $('#invoice_no').val();
// 	// alert(invoice_no);

// 	if (!po_no) {
// 		Swal.fire({
// 			icon: 'warning',
// 			title: 'Warning',
// 			text: "Please choose PO No or Invoice No to filter"
// 		});
// 		return; // stop execution if no inputs
// 	}

// 	// Load DataTable only if input is valid
// 	sub_list_datatable('bg_create_datatable', form_name = "", 'bg_create_datatable');

// 	// Prepare AJAX data
// 	var data = {
// 		action: "cardData",
// 		po_no: po_no,
// 		// invoice_no: invoice_no
// 	};

// 	var ajax_url = sessionStorage.getItem("folder_crud_link");

// 	// Fire AJAX request
// 	$.ajax({
// 		type: "POST",
// 		url: ajax_url,
// 		data: data,
		
// 		success: function (response) {
// 			var obj = JSON.parse(response);
// 			if(po_no != ''){
// 			$("#po_num_val").html(obj.po_no || '');
// 			}else{
// 				$("#po_num_val").append('No Record Found!');
// 			}
// 			// $("#invoice_val").html(obj.invoice_no || '');
// 		},
// 		error: function (xhr, error, code) {
// 			console.error("AJAX Error: ", error);
// 		}
// 	});
// }

function sub_list_datatable(table_id = "", form_name = "", action = "") {

	// alert('hii');
	var table_id = 'bg_create_datatable';
	// alert(table_id);
	var po_num = $("#po_num").val();
	// alert();
	var table = $("#" + table_id);
	var data = {
		"action": 'bg_create_datatable',
		"po_num": po_num
	};
	var ajax_url = sessionStorage.getItem("folder_crud_link");
	var datatable = table.DataTable({
		destroy: true,
		ordering: true,
		searching: true,
		"ajax": {
			url: ajax_url,
			type: "POST",
			data: data
		},
		dom: 'Bfrtip',
		buttons: [
			'copy', 'csv', 'excel', 'pdf', 'print'
		]
	});
}

function sub_list_datatable1(table_id = "", form_name = "", action = "") {
	// alert('hii');

	var table_id = 'bg_update_datatable';
	// alert(table_id);
	var table = $("#" + table_id);
	var screen_id_val = $('#screen_id_val').val();
	// alert(screen_id_val);
	var user_type_unique_id = $('#user_type_unique_id').val();
	var data = {
		"action": 'bg_update_datatable',
		"screen_id_val": screen_id_val,
		"user_type_unique_id": user_type_unique_id,
	};

	var ajax_url = sessionStorage.getItem("folder_crud_link");
	var datatable = table.DataTable({
		// destroy: true,
		// ordering: true,
		// searching: true,
		// "searching": false,
		// "paging": false,
		// "ordering": false,
		// "info": false,
		destroy: true,
		ordering: true,
		searching: true,
		"ajax": {
			url: ajax_url,
			type: "POST",
			data: data
		},
		dom: 'Bfrtip',
		buttons: [
			'copy', 'csv', 'excel', 'pdf', 'print'
		]
	});
}

function excel(export_1, bg_no) {
	
	window.location.href = "folders/bg/excel.php?bg_no=" + bg_no;
}
function get_user_permission() {
	var screen_id_val = $('#screen_id_val').val();
	// alert(screen_id_val);
	var user_type_unique_id = $('#user_type_unique_id').val();
	var data = {
		"screen_id_val": screen_id_val,
		"user_type_unique_id": user_type_unique_id,
		"action": 'user_permission',
	};

	var ajax_url = sessionStorage.getItem("folder_crud_link");
	var url = sessionStorage.getItem("list_link");
	// 
	// console.log(data);
	$.ajax({
		type: "POST",
		url: ajax_url,
		data: data,
		success: function (data) {

			var obj = JSON.parse(data);

			var dataString = obj.data;

			// console.log(dataString);

			var addButton = document.getElementById('add_btn');
			if (dataString.includes('5f8807ff00bf726601')) {
				if (addButton) {
					addButton.style.visibility = 'visible';  // Show the button
				}
			} else {
				if (addButton) {
					addButton.style.visibility = 'hidden';   // Hide the button but keep its space
				}
			}
			var listpage = document.getElementById('list');
			if (dataString.includes('5f88083fd50a344823')) {
				if (listpage) {
					listpage.style.visibility = 'visible';   // Hide the button but keep its space
				}
			} else {
				if (listpage) {
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
	// alert(screen_id_val);
	var user_type_unique_id = $('#user_type_unique_id').val();

	var data = {
		"screen_id_val": screen_id_val,
		"user_type_unique_id": user_type_unique_id,
		"action": 'user_permission_1',
	};

	var ajax_url = sessionStorage.getItem("folder_crud_link");
	var url = sessionStorage.getItem("list_link");
	// 
	// console.log(data);
	$.ajax({
		type: "POST",
		url: ajax_url,
		data: data,
		success: function (data) {

			var obj = JSON.parse(data);

			var dataString = obj.data;

			var listpage = document.getElementById('list_1');
			if (dataString.includes('5f88083fd50a344823')) {
				if (listpage) {
					listpage.style.visibility = 'visible';   // Hide the button but keep its space
				}
			} else {
				if (listpage) {
					listpage.style.visibility = 'hidden';   // Hide the button but keep its space
				}
			}


		},
		error: function (data) {
			alert("Network Error");
		}
	});
}
