$(document).ready(function () {
	init_datatable(table_id, form_name, action);
});

var company_name = sessionStorage.getItem("company_name");
var company_address = sessionStorage.getItem("company_name");
var company_phone = sessionStorage.getItem("company_name");
var company_email = sessionStorage.getItem("company_name");
var company_logo = sessionStorage.getItem("company_name");

var form_name = 'District Creation';
var form_header = '';
var form_footer = '';
var table_name = '';
var table_id = 'district_creation_datatable';
var action = "datatable";

function district_creation_cu(unique_id = "") {

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
	if ($.fn.DataTable.isDataTable('#' + table_id)) {
		$('#' + table_id).DataTable().destroy(); // Destroy previous instance
	}

	var user_type_unique_id = $('#user_type_unique_id').val();
	var data = {
		"action": action,
		"screen_id_val": screen_id_val,
		"usertype": user_type_unique_id
	};
	var ajax_url = sessionStorage.getItem("folder_crud_link");

	var datatable = table.DataTable({
		ordering: true,
		destroy: true,
		responsive: true,
		dom: '<"dt-top-container"<l><"dt-center-in-div"B><f>r>t<ip>',
		lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
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
			data: data
		},
		columns: [
			{ data: "s_no" },        // This column is dynamically generated on the backend
			{ data: "state_name" },
			{ data: "district_name" },
			{ data: "is_active" },
			{ data: "unique_id" }
		]
	});
	$('#columnVisibilityForm').on('change', 'input[type="checkbox"]', function () {
		var columnIdx = $(this).data('column');
		var isVisible = $(this).is(':checked');
		datatable.column(columnIdx).visible(isVisible); // Use datatable instead of table
	});
}
function district_creation_delete(unique_id = "") {

	var ajax_url = sessionStorage.getItem("folder_crud_link");
	var url = sessionStorage.getItem("list_link");

	confirm_delete('delete').then((result) => {
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