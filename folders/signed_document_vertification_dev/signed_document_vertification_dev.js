$(document).ready(function () {
	// var table_id 	= "user_type_datatable";
get_data();
get_snr_data();
	//init_datatable(table_id, form_name, action);
	//sub_list_datatable_with_ir('signed_document_verification_datatable_with_ir', form_name, 'datatable_with_ir');
	//sub_list_datatable('mismatch_datatable', form_name, 'mismatch_datatable');
	// sub_list_datatable_verified('verify_datatable', form_name, 'verified_datatable');
	
get_data_mis();
 
  get_data_del();


	// get_date_filter();
});

function get_data() {
	
sub_list_datatable_with_ir('signed_document_verification_datatable_with_ir', form_name, 'datatable_with_ir');
}

function get_data_mis() {

sub_list_datatable('mismatch_datatable', form_name, 'mismatch_datatable');

}


function get_snr_data(){

	init_datatable("signed_document_verification_datatable", form_name, "datatable");
}

function get_data_del() {
	sub_list_datatable_verified('verify_datatable', form_name, 'verified_datatable');

}

var company_name = sessionStorage.getItem("company_name");
var company_address = sessionStorage.getItem("company_name");
var company_phone = sessionStorage.getItem("company_name");
var company_email = sessionStorage.getItem("company_name");
var company_logo = sessionStorage.getItem("company_name");
var form_name = 'State Creation';
var form_header = '';
var form_footer = '';
var table_name = '';
var table_id = 'signed_document_verification_datatable';
var table_id_1 = 'mismatch_datatable';
var table_id_2 = 'verify_datatable';
var action = "datatable";


// function get_list() {

// 	sub_list_datatable_with_ir('signed_document_verification_datatable_with_ir', form_name, 'datatable_with_ir');
// }

// function get_snr_list() {

// 	init_datatable(table_id, form_name, action);

// }

function signed_document_vertification_cu(unique_id = "") {

	var internet_status = is_online();


	if (!internet_status) {

		sweetalert("no_internet");
		return false;
	}

	// var is_form = form_validity_check("was-validated");

	// if (is_form) {

		var data = $(".was-validated").serialize();
		var form_main_unique_id = document.getElementById('form_main_unique_id').value;
		// alert(form_main_unique_id);
		var po_num = document.getElementById('po_num').value;
		var po_date = document.getElementById('po_date').value;
		var con_contact_name = document.getElementById('con_contact_name').value;
		var con_address = document.getElementById('con_address').value;
		var con_unique_id = document.getElementById('con_unique_id').value;
		// alert(con_unique_id);
		var ins_unique_id = document.getElementById('ins_unique_id').value;
		// alert(ins_unique_id);

		// alert(con_unique_id);
		var invoice_no = document.getElementById('invoice_no').value;
		var dc_number = document.getElementById('dc_number').value;
		// alert(invoice_no);
		var invoice_date = document.getElementById('invoice_date').value;
		// alert(bank_required);
		var sts = document.getElementById('sts').value;
		// alert(sts);
		var sts1 = document.getElementById('sts1').value;
		//  alert(sts1);
		var sts2 = document.getElementById('sts2').value;
		var snr_verify_status = document.getElementById('snr_verify_status').value;
		//  alert(sts2);
		if (sts == "DC") {
			var dc_received_status = document.getElementById('dc_received_status').value;
			var dc_signed_date = document.getElementById('dc_signed_date').value;
		}
		if (sts1 == "IR") {
			var ir_status = document.getElementById('ir_status').value;
			var ir_signed_date = document.getElementById('ir_signed_date').value;
		}
		else if (sts1 == "null") {
			var ir_status = '';
			var ir_signed_date = '';
			//alert(ir_status);
		}
		if (sts2 == "SNR") {
			var snr_status = document.getElementById('snr_status').value;
			var snr_signed_date = document.getElementById('snr_signed_date').value;
		}

		else if (sts2 == "null") {
			var snr_status = '';
			var snr_signed_date = '';
		}
		// alert(ir_status);
		
		var po_product_name = document.getElementById('po_product_name').value;
		// var approval = document.getElementById('approval').value;
		// var claim_amount = document.getElementById('claim_amount').value;
		var status = document.getElementById('status').value;

		var bank_required = document.getElementById('bank_required').value;

		if (bank_required == 'yes') {
			if (document.getElementById("with_bg").checked == true) {
				var with_bg1 = 'on';
			} else {
				var with_bg1 = 'off';
			}
			if (document.getElementById("without_bg").checked == true) {
				var without_bg1 = 'on';
			} else {
				var without_bg1 = 'off';
			}
			if (with_bg1 == 'off' && without_bg1 == 'off' && status != '1') {
				alert('Fill BG Fields');
				return;
			}
		}
		else if (bank_required == 'no') {
			var with_bg1 = 'off';
			var without_bg1 = 'on';
		}

		var status = document.getElementById('status').value;

		// alert('status' .status);
		// var ir_status = document.getElementById('ir_status').value;
		var doc_chn = document.getElementById('doc_chn').value;
		var dc_required = document.getElementById('dc_required').value;
		var reject_reason = document.getElementById('reject_reason').value;

		var unique_id = document.getElementById('update_unique_id').value;

		var data = new FormData();
		data.append("form_main_unique_id", form_main_unique_id);
		data.append("po_num", po_num);
		data.append("po_date", po_date);
		data.append("unique_id", unique_id);
		data.append("con_contact_name", con_contact_name);
		data.append("ins_unique_id", ins_unique_id);
		data.append("con_address", con_address);
		data.append("invoice_no", invoice_no);
		data.append("dc_number", dc_number);
		data.append("invoice_date", invoice_date);
		data.append("dc_received_status", dc_received_status);
		data.append("dc_signed_date", dc_signed_date);
		data.append("con_unique_id", con_unique_id);
		data.append("ir_status", ir_status);
		data.append("ir_signed_date", ir_signed_date);
		data.append("snr_status", snr_status);
		data.append("snr_signed_date", snr_signed_date);
		data.append("po_product_name", po_product_name);
		data.append("sts1", sts1);
		data.append("sts", sts);
		data.append("sts2", sts2);
		data.append("reject_reason", reject_reason);
		data.append("with_bg", with_bg1);
		data.append("without_bg", without_bg1);
		data.append("status", status);
		data.append("doc_chn", doc_chn);
		data.append("dc_required", dc_required);
		data.append("snr_verify_status", snr_verify_status);

		if (status == 2 && ir_status == 1) {
			var signed_status = 1;
			data.append("signed_complete_status", signed_status);
			// alert(signed_status);
		}

		data.append("action", "createupdate");

		var ajax_url = sessionStorage.getItem("folder_crud_link");
		var url = sessionStorage.getItem("list_link");

		// return;
		 console.log(data);
		$.ajax({
			type: "POST",
			url: ajax_url,
			data: data,
			cache: false,
			contentType: false,
			processData: false,
			method: 'POST',
			// beforeSend: function () {

			// },
			success: function (data) {


				// alert(data);
				var obj = JSON.parse(data);
				var msg = obj.msg;
				var status = obj.status;
				var error = obj.error;

				if (!status) {
					url = '';
					$(".createupdate_btn").text("Error");

				}
				else {
					if (msg == "already") {

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
				console.log("Error");
				console.table(data);
				alert("Network Error");
				
			}
		});
	// } else {
	// 	sweetalert("form_alert");
	// }
}

function init_datatable(table_id = '', form_name = '', action = '', filter_data = '') {

	// alert('test'); 
	var table = $("#" + table_id);
	var screen_id_val = $('#screen_id_val').val();
	// alert(screen_id_val);
	var user_type_unique_id = $('#user_type_unique_id').val();
	var from_date = $("#snr_from_date").val();
	// // 	 alert(from_date);
	var to_date = $("#snr_to_date").val();
	// alert(to_date);
	// var status = $("#status").val();
	var opt = $("#snr_opt").val();
	var snr_team_mem = $("#snr_team_mem").val();

	// alert(status);
	var data = {
		"action": action,
		"from_date": from_date,
		"to_date": to_date,
		// "status": status,
		"opt": opt,
		"snr_team_mem": snr_team_mem,
		"screen_id_val": screen_id_val,
		"user_type_unique_id": user_type_unique_id,
	};
	data = {
		...data,
	};
	// alert(data);
	var ajax_url = sessionStorage.getItem("folder_crud_link");
	var datatable = table.DataTable({
		destroy: true, //new line
		ordering: true,
		searching: true,
		stateSave:true,
		"ajax": {
			url: ajax_url,
			type: "POST",
			data: data
		},
		columnDefs: [
        { targets: 1, width: "25%" },  
    ],
		// dom: 'Bfrtip',
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
		lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
		pageLength: 10 // Default selected value
	});
	$('#columnVisibilityForm').on('change', 'input[type="checkbox"]', function () {
		var columnIdx = $(this).data('column');
		var isVisible = $(this).is(':checked');
		datatable.column(columnIdx).visible(isVisible); // Use datatable instead of table
	});

}
function sub_list_datatable(table_id = "", form_name = "", action = "") {
	var table_id = 'mismatch_datatable';
	var table = $("#" + table_id_1);
	var from_date = $("#from_date_mis").val();
	var to_date = $("#to_date_mis").val();
	var mismatch_team_mem = $("#mismatch_team_mem").val();
	var opt1 = $("#opt1").val();
	var data = {
		"action": 'mismatch_datatable',
		"from_date": from_date,
		"to_date": to_date,
		"mismatch_team_mem": mismatch_team_mem,
		"opt1": opt1,
		// "screen_id_val": screen_id_val,
		// "user_type_unique_id": user_type_unique_id,
	};
	var ajax_url = sessionStorage.getItem("folder_crud_link");
	var datatable = table.DataTable({
		destroy: true, //new line
		ordering: true,
		searching: true,
		stateSave:true,
		"ajax": {
			url: ajax_url,
			type: "POST",
			data: data
		},
		// dom: 'Bfrtip', columnDefs: [
    columnDefs: [
  {
    targets: [6, 7], // columns to apply the cell styling
    createdCell: function (td, cellData, rowData, row, col) {
      $(td).css('text-align', 'center');
    }
  }
],

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
		lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
		pageLength: 10 // Default selected value
	});
	$('#columnVisibilityForm').on('change', 'input[type="checkbox"]', function () {
		var columnIdx = $(this).data('column');
		var isVisible = $(this).is(':checked');
		datatable.column(columnIdx).visible(isVisible); // Use datatable instead of table
	});
}
function sub_list_datatable_with_ir(table_id = "", form_name = "", action = "") {
	// alert('hii');
	// var form_main_unique_id = $("#demo").val();
	var table_id = 'signed_document_verification_datatable_with_ir';
	// alert(table_id);
	var table = $("#" + table_id);
	var from_date = $("#from_date").val();
	// alert(from_date);
	var to_date = $("#to_date").val();
	// alert(to_date);
	var opt = $("#opt").val();
	var screen_id_val = $('#screen_id_val').val();
	// alert(screen_id_val);
	var user_type_unique_id = $('#user_type_unique_id').val();
	var team_mem = $('#team_mem').val();
	var data = {
		"action": 'datatable_with_ir',
		"from_date": from_date,
		"to_date": to_date,
		"opt": opt,
		"screen_id_val": screen_id_val,
		"team_mem": team_mem,
		"user_type_unique_id": user_type_unique_id,
	};
	var ajax_url = sessionStorage.getItem("folder_crud_link");
	var datatable = table.DataTable({
		destroy: true, //new line
		ordering: true,
		searching: true,
		stateSave:true,
		"ajax": {
			url: ajax_url,
			type: "POST",
			data: data
		},
		// dom: 'Bfrtip',
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
		lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
		pageLength: 10 // Default selected value
	});
	$('#columnVisibilityForm').on('change', 'input[type="checkbox"]', function () {
		var columnIdx = $(this).data('column');
		var isVisible = $(this).is(':checked');
		datatable.column(columnIdx).visible(isVisible); // Use datatable instead of table
	});
}

function sub_list_datatable_verified(table_id = "", form_name = "", action = "") {
	// var form_main_unique_id = $("#demo").val();
	var table_id = 'verify_datatable';
	var from_date = $("#from_date_ver").val();
	// alert(from_date);
	var to_date = $("#to_date_ver").val();
	// alert(to_date);
	var opt = $("#opt2").val();
	var screen_id_val = $('#screen_id_val').val();
	var verified_team_mem = $('#verified_team_mem').val();
	// alert(screen_id_val);
	var user_type_unique_id = $('#user_type_unique_id').val();
	// alert(table_id);
	// var invoice_no= document.getElementById('invoice_no').value;
	// var invoice_no = $("#invoice_no").val();
	// alert(invoice_no);
	// alert(con_unique_id);
	var table = $("#" + table_id_2);
	var data = {
		"action": 'verified_datatable',
		"screen_id_val": screen_id_val,
		"user_type_unique_id": user_type_unique_id,
		"from_date": from_date,
		"to_date": to_date,
		"verified_team_mem": verified_team_mem,
		"opt2": opt,
	};
	var ajax_url = sessionStorage.getItem("folder_crud_link");
	var datatable = table.DataTable({
		destroy: true, //new line
		ordering: true,
		searching: true,
		stateSave:true,
		"ajax": {
			url: ajax_url,
			type: "POST",
			data: data
		},
		// dom: 'Bfrtip',
		 columnDefs: [
  {
    targets: [6, 7], // columns to apply the cell styling
    createdCell: function (td, cellData, rowData, row, col) {
      $(td).css('text-align', 'center');
    }
  }
],

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
		lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
		pageLength: 10 // Default selected value
	});
	$('#columnVisibilityForm').on('change', 'input[type="checkbox"]', function () {
		var columnIdx = $(this).data('column');
		var isVisible = $(this).is(':checked');
		datatable.column(columnIdx).visible(isVisible); // Use datatable instead of table
	});
}
function get_date_filter(filter_action = 0) {
	// var from_date = $("#from_date").val();
	// var to_date = $("#to_date").val();
	var status = $("#status").val();
	// 		alert(status);
	// sessionStorage.setItem("from_date", from_date);
	// sessionStorage.setItem("to_date", to_date);
	// 			sessionStorage.setItem("filter_action", filter_action);
	sessionStorage.setItem("status", status);
	var filter_data = {
		// "from_date": from_date,
		// "to_date": to_date,
		"status": status,
	};
	// 	console.log(filter_data);
	init_datatable(table_id, form_name, action, filter_data);
}
function print_pdf(file_name) {
	onmouseover = window.open('uploads/installation/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
}
function print_excel(file_name) {
	window.location = 'uploads/installation/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no';
}
// function print(file_name) {
//     onmouseover = window.open('uploads/kra_kpi_form/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
// }
function print_view(file_name) {
	onmouseover = window.open('uploads/installation/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
}



function toggleCheckboxes(selected) {
	const withBox = document.getElementById('with_bg');
	const withoutBox = document.getElementById('without_bg');

	if (selected === 'with') {
		withoutBox.disabled = withBox.checked;
	} else if (selected === 'without') {
		withBox.disabled = withoutBox.checked;
	}

	// If both are unchecked, enable both
	if (!withBox.checked && !withoutBox.checked) {
		withBox.disabled = false;
		withoutBox.disabled = false;
	}
}
