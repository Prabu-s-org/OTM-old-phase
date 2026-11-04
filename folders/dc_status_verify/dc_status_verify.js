$(document).ready(function () {
	// init_datatable(table_id, form_name, action);
});

var company_name = sessionStorage.getItem("company_name");
var company_address = sessionStorage.getItem("company_name");
var company_phone = sessionStorage.getItem("company_name");
var company_email = sessionStorage.getItem("company_name");
var company_logo = sessionStorage.getItem("company_name");

var form_name = 'City Creation';
var form_header = '';
var form_footer = '';
var table_name = '';
var table_id = 'dc_status_datatable';
var action = "datatable";

function city_creation_cu(unique_id = "") {

	var internet_status = is_online();

	if (!internet_status) {
		sweetalert("no_internet");
		return false;
	}

	var is_form = form_validity_check("was-validated");

	if (is_form) {

		var data = $(".was-validated").serialize();
		data += "&unique_id=" + unique_id + "&action=createupdate";

		var ajax_url = sessionStorage.getItem("folder_crud_link");
		var url = sessionStorage.getItem("list_link");

		$.ajax({
			type: "POST",
			url: ajax_url,
			data: data,
			beforeSend: function () {
				$(".createupdate_btn").attr("disabled", "disabled");
				$(".createupdate_btn").text("Loading...");
			},
			success: function (data) {

				var obj = JSON.parse(data);
				var msg = obj.msg;
				var status = obj.status;
				var error = obj.error;

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
function init_datatable(table_id = '', form_name = '', action = '') {

	var table = $("#" + table_id);
	var screen_id_val = $('#screen_id_val').val();
	var user_type_unique_id = $('#user_type_unique_id').val();
	var po_no = $('#po_no').val();
	// alert(po_no);
	var invoice_no = $('#invoice_no').val();
	// alert(invoice_no);

	var data = {
		"action": action,
		"screen_id_val": screen_id_val,
		"usertype": user_type_unique_id,
		"po_no": po_no,
		"invoice_no": invoice_no
	};

	var ajax_url = sessionStorage.getItem("folder_crud_link");

	var datatable = table.DataTable({
		ordering: true,
		searching: true,
		destroy: true,
		responsive: true,
		// dom: '<"dt-top-container"<l><"dt-center-in-div"B><f>r>t<ip>',
		lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
		// buttons: [
		// 	{
		// 		extend: 'copyHtml5',
		// 		text: 'Copy',
		// 		exportOptions: { columns: ':visible' }
		// 	},
		// 	{
		// 		extend: 'csvHtml5',
		// 		text: 'CSV',
		// 		exportOptions: { columns: ':visible' }
		// 	},
		// 	{
		// 		extend: 'excelHtml5',
		// 		text: 'Excel',
		// 		exportOptions: { columns: ':visible' }
		// 	},
		// 	{
		// 		extend: 'pdfHtml5',
		// 		text: 'PDF',
		// 		exportOptions: { columns: ':visible' }
		// 	},
		// 	{
		// 		extend: 'print',
		// 		text: 'Print',
		// 		exportOptions: { columns: ':visible' }
		// 	},

		// 	{
		// 		extend: 'colvis', // Column visibility button
		// 		text: 'Column Visibility',
		// 		action: function (e, dt, node, config) {
		// 			// Open the column visibility modal when the button is clicked
		// 			$('#columnVisibilityModal').modal('show');

		// 			// Populate the modal with checkboxes for each column
		// 			var columns = dt.columns().header();
		// 			var form = $('#columnVisibilityForm');
		// 			form.empty(); // Clear any existing checkboxes

		// 			// Append checkboxes one by one for each column
		// 			columns.each(function (header, index) {
		// 				var isChecked = dt.column(index).visible();
		// 				var colMarkup = `
		// 					<div class="form-check">
		// 						<input type="checkbox" class="form-check-input" data-column="${index}" ${isChecked ? 'checked' : ''}>
		// 						<label class="form-check-label">${$(header).text()}</label>
		// 					</div>
		// 				`;
		// 				form.append(colMarkup); // Append each checkbox in a vertical list
		// 			});
		// 		}

		// 	}
		// ],

		ajax: {
			url: ajax_url,
			type: "POST",
			data: function (d) {
				if (data) {
					$.extend(d, data);
					$('#dc_card').show();
					$('#dc_status').show();
				}
			},
			error: function (xhr, error, code) {
				console.error("AJAX Error: ", error);
			}
		},
		columns: [
			{ data: "s_no" },
			{ data: "invoice_no", className: "dt-left" },
			{ data: "dc_number", className: "dt-left" },
			{ data: "doc_approval_sts" },
			{ data: "ac_team_verifiy_status" },
			{ data: "material_qc" },
			{ data: "dispatch_status" },
			{ data: "vendor_icon" },
			{ data: "installation_status" },
			{ data: "dc_ir_dispatch_sts" },
			{ data: "signed_doc_status" }
		],
		processing: true,
		serverSide: true,
		order: [[0, 'asc']]
	});
	// $('#columnVisibilityForm').on('change', 'input[type="checkbox"]', function () {
	// 	var columnIdx = $(this).data('column');
	// 	var isVisible = $(this).is(':checked');
	// 	datatable.column(columnIdx).visible(isVisible); // Use datatable instead of table
	// });
}


function dc_complete(dc_num) {

	var table_id = $('#dc_status_datatable').DataTable();
	var data = {

		"action": 'dc_complete',
		"dc_num": dc_num,
		// "invoice_num": invoice_num,
		// "unique_id": unique_id
	};
	var ajax_url = sessionStorage.getItem("folder_crud_link");

	$.ajax({

		type: "POST",
		url: ajax_url,
		data: data,
		success: function (response) {

			// alert(data);
			if (response) {
				sweetalert('complete');
				table_id.ajax.reload();
			}
		},


	});
}

// function get_dc_number() {
// 	var po_no = $('#po_no').val();
// 	var invoice_no = $('#invoice_no').val();

// 	if (!po_no && !invoice_no) {
// 		Swal.fire({
// 			icon: 'warning',
// 			title: 'Warning',
// 			text: "Please choose PO No or Invoice No to filter"
// 		});
// 	} else {
// 		init_datatable(table_id, form_name, action);
// 	}

// 	var data = {
// 		"action": "cardData",
// 		"po_no": po_no,
// 		"invoice_no": invoice_no
// 	};

// 	var ajax_url = sessionStorage.getItem("folder_crud_link");
// 	$.ajax({
// 		type: "POST",
// 		url: ajax_url,
// 		data: data,
// 		success: function (data) {
// 			var obj = JSON.parse(data);

// 			if (data) {
// 				$("#po_num_val").html(obj.po_no);
// 				$("#invoice_val").html(obj.invoice_no);
// 			}
// 		}
// 	});

// }

function get_dc_number() {

	var po_no = $('#po_no').val();
	var invoice_no = $('#invoice_no').val();
	//  alert(invoice_no);

	if (!po_no && !invoice_no) {
		Swal.fire({
			icon: 'warning',
			title: 'Warning',
			text: "Please choose PO No or Invoice No to filter"
		});
		return; // stop execution if no inputs
	}

	// Load DataTable only if input is valid
	init_datatable(table_id, form_name, action);

	// Prepare AJAX data
	var data = {
		action: "cardData",
		po_no: po_no,
		invoice_no: invoice_no
	};

	var ajax_url = sessionStorage.getItem("folder_crud_link");

	// Fire AJAX request
	$.ajax({
		type: "POST",
		url: ajax_url,
		data: data,
		// success: function (response) {
		// 	try {
		// 		var obj = JSON.parse(response);

		// 		if (obj.data && obj.data.length > 0) {
		// 			var po_no = obj.data[0].po_no;
		// 			var invoice_no = obj.data[0].invoice_no;

		// 			alert(po_no);
		// 			alert(invoice_no);

		// 			$("#po_num_val").html(po_no || '');
		// 			$("#invoice_val").html(invoice_no || '');
		// 		} else {
		// 			console.warn("No data found.");
		// 			$("#po_num_val").html('');
		// 			$("#invoice_val").html('');
		// 		}
		// 	} catch (e) {
		// 		console.error("Invalid JSON response:", response);
		// 		Swal.fire({
		// 			icon: 'error',
		// 			title: 'Error',
		// 			text: "Failed to load PO/Invoice details."
		// 		});
		// 	}

		// },
		success: function (response) {
			var obj = JSON.parse(response);
			$("#po_num_val").html(obj.po_no || '');
			$("#invoice_val").html(obj.invoice_no || '');
		},
		error: function (xhr, error, code) {
			console.error("AJAX Error: ", error);
		}
	});
}



$('#state_name').on('change', function () {

	var state_name = $('#state_name').val();
	var data = "&state_name=" + state_name + "&action=district_type_option";

	var ajax_url = sessionStorage.getItem("folder_crud_link");
	$.ajax({
		type: "POST",
		url: ajax_url,
		data: data,
		success: function (data) {
			if (data) {
				$("#district_name").html(data);
			}
		}
	});

});


function validateName(input) {
	// alert('test');
	input.value = input.value.replace(/[^A-Za-z\s]/g, ''); // Remove special characters & numbers
}

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

			console.log(dataString);

			// var addButton = document.getElementById('add_btn');
			// if (dataString.includes('5f8807ff00bf726601')) {
			// 	addButton.style.visibility = 'visible';  // Show the button
			// } else {
			// 	addButton.style.visibility = 'hidden';   // Hide the button but keep its space
			// }
			// var listpage = document.getElementById('list');
			// if (dataString.includes('5f88083fd50a344823')) {
			// 	listpage.style.visibility = 'visible';  // Show the button
			// } else {
			// 	listpage.style.visibility = 'hidden';   // Hide the button but keep its space
			// }


		},
		error: function (data) {
			alert("Network Error");
		}
	});
}

function city_creation_delete(unique_id = "") {

	var ajax_url = sessionStorage.getItem("folder_crud_link");
	var url = sessionStorage.getItem("list_link");

	confirm_delete('delete')
		.then((result) => {
			if (result.isConfirmed) {

				var data = {
					"unique_id": unique_id,
					"action": "delete"
				}

				$.ajax({
					type: "POST",
					url: ajax_url,
					data: data,
					success: function (data) {

						var obj = JSON.parse(data);
						var msg = obj.msg;
						var status = obj.status;
						var error = obj.error;

						if (!status) {
							url = '';

						} else {
							init_datatable(table_id, form_name, action);
						}
						sweetalert(msg, url);
					}
				});

			} else {
			}
		});
}

function get_under_user_type_ids() {
	var under_user_type = $('#under_user_type_name').val();
	$('#under_user_type').val(under_user_type);
}

function get_under_user_type(user_type = "") {

	$("#under_user_type_name").html('');
	var ajax_url = sessionStorage.getItem("folder_crud_link");

	if (staff_id) {
		var data = {
			"user_type": user_type,
			"action": "user_type_options"
		}

		$.ajax({
			type: "POST",
			url: ajax_url,
			data: data,
			success: function (data) {

				if (data) {
					$("#under_user_type_name").html(data);
				}

			}
		});
	}
}

function get_district_name(state_unique_id = "") {


	var state_name = $('#state_name').val();
	var data = "&state_name=" + state_name + "&action=district_type_option";

	var ajax_url = sessionStorage.getItem("folder_crud_link");
	$.ajax({
		type: "POST",
		url: ajax_url,
		data: data,
		success: function (data) {
			if (data) {
				$("#zone_unique_id").html(data);
			}
		}
	});

}

function getInvoiceNo() {

	var po_no = $('#po_no').val();

	var data = "po_no=" + po_no + "&action=get_po_no";

	var ajax_url = sessionStorage.getItem("folder_crud_link");

	$.ajax({
		type: "POST",
		url: ajax_url,
		data: data,
		success: function (data) {
			if (data) {
				$("#invoice_no").html(data);
			}
		}
	});
}

function getDcNo() {
	var po_no = $('#po_no').val();
	var invoice_no = $('#invoice_no').val();
}