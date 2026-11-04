$(document).ready(function () {
	init_datatable(table_id, form_name, action);
	sub_list_datatable('excel_datatable', form_name, 'excel_datatable');

});

var company_name = sessionStorage.getItem("company_name");
var company_address = sessionStorage.getItem("company_name");
var company_phone = sessionStorage.getItem("company_name");
var company_email = sessionStorage.getItem("company_name");
var company_logo = sessionStorage.getItem("company_name");

var form_name = 'Item Creation';
var form_header = '';
var form_footer = '';
var table_name = '';
var table_id = 'item_creation_datatable';
var action = "datatable";

function item_creation_cu(unique_id = "") {

	var internet_status = is_online();

	if (!internet_status) {
		sweetalert("no_internet");
		return false;
	}

	var is_form = form_validity_check("was-validated");

	if (is_form) {

		// Empty checks
		if (!tenderName || !tenderCode || !tenderNo || !tenderType || !validityFrom || !validityTo) {
			valid = false;
			msg = "Please fill out all required fields.";
		}

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

	var data = {
		"action": action,
		"screen_id_val": screen_id_val,
		"user_type_unique_id": user_type_unique_id,
	};

	var ajax_url = sessionStorage.getItem("folder_crud_link");

	var datatable = table.DataTable({
		destroy: true, // Destroy the existing table to initialize a new one
		ordering: true,
		searching: true,
		dom: '<"dt-top-container"<l><"dt-center-in-div"B><f>r>t<ip>',
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
		ajax: {
			url: ajax_url,
			type: "POST",
			data: data,
			dataSrc: function (json) {
				// Ensure the response contains the data
				if (json.data) {
					// Map the response data to match the columns in the DataTable
					return json.data.map(function (row) {
						return {
							"s_no": row[0],              // Mapping the serial number (empty string as placeholder)
							"tender_name": row[1],       // Mapping to tender_name
							"tender_code": row[2],       // Mapping to tender_code
							"tender_no": row[3],         // Mapping to tender_no
							"tender_type": row[4],       // Mapping to tender_type
							"validity_from": row[5],       // Mapping to tender_type
							"validity_to": row[6],       // Mapping to tender_type
							"validity_date_extension": row[7],       // Mapping to tender_type
							// Add any other columns here if necessary
							"unique_id": row[8]          // Mapping to unique_id (could contain action buttons)
						};
					});
				} else {
					return [];
				}
			}
		},
		columns: [
			{ data: "s_no" },              // Mapping to s_no (if using it as an empty or sequential value)
			{ data: "tender_name" },       // Mapping to tender_name
			{ data: "tender_code" },       // Mapping to tender_code
			{ data: "tender_no" },         // Mapping to tender_no
			{ data: "tender_type" },       // Mapping to tender_type
			{ data: "validity_from" },    // Mapping to validity_from
			{ data: "validity_to" },      // Mapping to validity_to
			{ data: "validity_date_extension" }, // Mapping to validity_date_extension
			{ data: "unique_id" }          // Mapping to unique_id (action buttons or links)
		]
	});

	$('#columnVisibilityForm').on('change', 'input[type="checkbox"]', function () {
		var columnIdx = $(this).data('column');
		var isVisible = $(this).is(':checked');
		datatable.column(columnIdx).visible(isVisible); // Use datatable instead of table
	});
}

function init_datatable_new(table_id = '', form_name = '', action = '') {

	var table = $("#" + table_id);
	var screen_id_val = $('#screen_id_val').val();

	var user_type_unique_id = $('#user_type_unique_id').val();
	var data = {
		"action": action,
		"screen_id_val": screen_id_val,
		"user_type_unique_id": user_type_unique_id,
	};
	var ajax_url = sessionStorage.getItem("folder_crud_link");

	var datatable = table.DataTable({
		destroy: true,
		ordering: true,
		searching: true,
		ajax: {
			url: ajax_url,
			type: "POST",
			data: data
		},
	});
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

			var addButton = document.getElementById('add_btn');
			if (dataString.includes('5f8807ff00bf726601')) {
				addButton.style.visibility = 'visible';  // Show the button
			} else {
				addButton.style.visibility = 'hidden';   // Hide the button but keep its space
			}
			var listpage = document.getElementById('list');
			if (dataString.includes('5f88083fd50a344823')) {
				listpage.style.visibility = 'visible';  // Show the button
			} else {
				listpage.style.visibility = 'hidden';   // Hide the button but keep its space
			}


		},
		error: function (data) {
			alert("Network Error");
		}
	});
}
function sub_list_datatable(table_id = "", form_name = "", action = "") {

	var table_id = 'excel_datatable';
	var tender_code = $("#tender_code").val();

	var table = $("#" + table_id);
	var data = {
		"tender_code": tender_code,
		"action": 'excel_datatable',
	};

	var ajax_url = sessionStorage.getItem("folder_crud_link");

	var datatable = table.DataTable({
		destroy: true,
		ordering: true,
		searching: true,
		"searching": false,
		"paging": false,
		"ordering": false,
		"info": false,
		"ajax": {
			url: ajax_url,
			type: "POST",
			data: data
		},
		dom: '<"dt-top-container"<l><"dt-center-in-div"B><f>r>t<ip>',
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
	});

	$('#columnVisibilityForm').on('change', 'input[type="checkbox"]', function () {
		var columnIdx = $(this).data('column');
		var isVisible = $(this).is(':checked');
		datatable.column(columnIdx).visible(isVisible); // Use datatable instead of table
	});
}

function item_creation_delete(unique_id = "") {

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
				// alert("cancel");
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

function excel_popup() {
	$("#excel_import_export").modal("show");
}

function modal_close() {
	$("#excel_import_export").modal("hide");
}

