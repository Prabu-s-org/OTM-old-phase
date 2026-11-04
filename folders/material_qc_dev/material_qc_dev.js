
$(document).ready(function () {
	// var table_id 	= "user_type_datatable";
	// init_datatable(table_id,form_name,action);
	// get_data();
	get_list();
	get_data_com();
	pending_list();

	// show_rejection_reason();
});

function get_list(){

  init_datatable(table_id,form_name,action);
    
    
    }

 function get_data_com(){
	complete_list_datatable('doc_approval_ac_team_list_datatable',form_name,'mqc_complete_datatable');
}
//function get_data_com(){
   
//}


var company_name = sessionStorage.getItem("company_name");
var company_address = sessionStorage.getItem("company_name");
var company_phone = sessionStorage.getItem("company_name");
var company_email = sessionStorage.getItem("company_name");
var company_logo = sessionStorage.getItem("company_name");

var form_name = 'State Creation';
var form_header = '';
var form_footer = '';


var table_name = '';
var table_id = 'doc_approval_ac_team_list_datatable';
var action = "datatable";


function material_qc_cu(unique_id = "") {

	var internet_status = is_online();

	if (!internet_status) {
		sweetalert("no_internet");
		return false;
	}
	
	

	var is_form = form_validity_check("was-validated");


	if (is_form) {
	
		var data 	 = $(".was-validated").serialize();
		data 		+= "&unique_id="+unique_id+"&action=createupdate";

		var ajax_url = sessionStorage.getItem("folder_crud_link");
		var url      = sessionStorage.getItem("list_link");

		// console.log(data);
		$.ajax({
			type 	: "POST",
			url 	: ajax_url,
			data 	: data,
			beforeSend 	: function() {
				$(".createupdate_btn").attr("disabled","disabled");
				$(".createupdate_btn").text("Loading...");
			},
			success		: function(data) {

				var obj     = JSON.parse(data);
				var msg     = obj.msg;
				var status  = obj.status;
				var error   = obj.error;

				sweetalert(msg,url);
			},
			error 		: function(data) {
				alert("Network Error");
			}
		});


	} else {
		sweetalert("form_alert");
	}
}





function init_datatable(table_id = '', form_name = '', action = '') {


	var table = $("#" + table_id);
	var from_date = $("#from_date").val();
	var to_date = $("#to_date").val();
  	var opt = $("#opt").val();
	var ac_team_verifiy_status = $("#ac_team_verifiy_status").val();
	var screen_id_val = $('#screen_id_val').val();
	// alert(screen_id_val);
	var user_type_unique_id = $('#user_type_unique_id').val();
    var team_mem = $('#team_mem').val();

	var data = {
		"ac_team_verifiy_status" : ac_team_verifiy_status,
		"action": action,
		"from_date"	: from_date,
		"to_date"   : to_date,
		"opt"  : opt,
		"screen_id_val": screen_id_val,
		"team_mem" : team_mem,	
		"user_type_unique_id": user_type_unique_id,
	};
	var ajax_url = sessionStorage.getItem("folder_crud_link");

	var datatable = table.DataTable({
		destroy: true,
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
	$('#columnVisibilityForm').on('change', 'input[type="checkbox"]', function() {
		var columnIdx = $(this).data('column');
		var isVisible = $(this).is(':checked');
		datatable.column(columnIdx).visible(isVisible); // Use datatable instead of table
	});
}


function complete_list_datatable(table_id = '', form_name = '', action = '') {
	

	$('#team_mem1').removeClass('select2-hidden-accessible').show();

    // If using select2 or any plugin, reinitialize
    if ($.fn.select2) {
        $('#team_mem1').select2(); 
    }
     var table_id='doc_approval_qc_team_list_datatable';
	var table = $("#" + table_id);

	var from_date = $("#comfrom_date").val();
	var to_date = $("#comto_date").val();
 	 var opt = $("#comopt").val();
	var ac_team_verifiy_status = $("#comac_team_verifiy_status").val();
	var screen_id_val = $('#screen_id_val').val();
	// alert(screen_id_val);
	var user_type_unique_id = $('#user_type_unique_id').val();
    var team_mem = $('#comteam_mem1').val();

	var data = {
		"ac_team_verifiy_status" : ac_team_verifiy_status,
		"action": 'mqc_complete_datatable',
		"from_date"	: from_date,
		"to_date"   : to_date,
		"opt"  : opt,
		"screen_id_val": screen_id_val,
		"team_mem" : team_mem,	
		"user_type_unique_id": user_type_unique_id,
	};
	var ajax_url = sessionStorage.getItem("folder_crud_link");

	var datatable = table.DataTable({
		destroy: true,
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
	$('#columnVisibilityForm').on('change', 'input[type="checkbox"]', function() {
		var columnIdx = $(this).data('column');
		var isVisible = $(this).is(':checked');
		datatable.column(columnIdx).visible(isVisible); // Use datatable instead of table
	});
}



function material_qc_delete(unique_id = "") {

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



// new
function pending_list() {	

	var table ="doc_pending_list_datatable";
	var table = $("#" + table);
	var data = {
		
		"action" : "pending_list_datatable",
	};
	var ajax_url = sessionStorage.getItem("folder_crud_link");

	var datatable = table.DataTable({
		ordering: true,
		searching: true,
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
		]
	});
	$('#columnVisibilityForm').on('change', 'input[type="checkbox"]', function() {
		var columnIdx = $(this).data('column');
		var isVisible = $(this).is(':checked');
		datatable.column(columnIdx).visible(isVisible); // Use datatable instead of table
	});
}


function approve(){



	var internet_status = is_online();

	const checked = document.querySelectorAll('.myCheck:checked');

	for (var i = 0; i < checked.length; i++) {

		var checkbox = checked[i];

		var approved_by = checkbox.parentElement.querySelector('#approved_by').value;

	// alert(approved_by);
			
		var doc_approval_sts = checkbox.parentElement.querySelector('#doc_approval_sts').value;
		// alert(po_num);
		var invoice_unique_id = checkbox.parentElement.querySelector('#invoice_id').value;


	// console.log(approved_by);
	// console.log(doc_approval_sts);
	// console.log(invoice_unique_id);

	var data = "approved_by=" + approved_by + "&approval_status=" +
	doc_approval_sts + "&invoice_unique_id=" + invoice_unique_id;
	// var data = "approved_by=" + approved_by +"&approval_status=" + doc_approval_sts + "&inovoice_unique_id=" + inovoice_unique_id;

	data+="&action=approval_list";

	var ajax_url = sessionStorage.getItem("folder_crud_link");
	var url = sessionStorage.getItem("list_link");

	$.ajax({

		type:"POST",
		url:ajax_url,
		data:data,
		beforeSend: function() {
			$(".po_delivery_add_update_btn").attr("disabled", "disabled");
			$(".po_delivery_add_update_btn").text("Loading...");
		},
		success: function(data) {
			sweetalert("approve");
			window.reload();
			

		},
		error: function(data) {
			alert("Network Error");
		}

	});
	}


}



function print(file_name) {
	// 
	window.location = 'uploads/invoice/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no';
}
// function print_pdf(file_name) {

// 	onmouseover = window.open('uploads/invoice/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
// }

function print_pdf(file_name) {

	onmouseover = window.open('uploads/invoice/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
}
// function print(file_name) {
//     onmouseover = window.open('uploads/kra_kpi_form/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
// }
function print_view(file_name) {
	// window.location
	window.open('uploads/invoice/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
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
// function print(file_name)
// {
// 	window.location='uploads/aed_elcot/' + file_name,'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no';
// }
// function print_view(file_name) {

//     window.location = 'uploads/aed_elcot/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no';
// }

// function getPdfFiles(file) {
//     // The 'file' parameter now contains the value of $file1
//     alert('Clicked! File: ' + file);

//     // You can perform additional actions with the 'file' variable here
//     // For example, opening a PDF file
//     // For demonstration purposes, opening the file in a new tab/window:
//     window.open(file, '_blank');
// }

// function getPdfFiles(file1, file2) {
//     // The 'file1' and 'file2' parameters now contain the values of $file1 and $file2
//     alert('Clicked! File 1: ' + file1 + ', File 2: ' + file2);

//     // You can perform additional actions with the 'file1' and 'file2' variables here
//     // For example, opening PDF files
//     // For demonstration purposes, opening the files in new tabs/windows:
//     window.open(file1, '_blank');
//     window.open(file2, '_blank');
// }


function check(my_obj, sno)
{	
	var chk = my_obj.checked;
	if(chk===true)
	{   
		$('#po_att'+sno).show();
		// document.getElementById('po_att'+sno).style.display="block";
	}
	else
	{
		$('#po_att'+sno).hide();
		// document.getElementById('po_att'+sno).style.display="none";
	}	
}

function check_dc(my_obj, sno)
{	
	var chk = my_obj.checked;
	if(chk===true)
	{   
		$('#dc_att'+sno).show();
		// document.getElementById('dc_att').style.display="block";
	}
	else
	{
		$('#dc_att'+sno).hide();
		// document.getElementById('dc_att').style.display="none";
	}	
}

function check_ir(my_obj, sno)
{	
	var chk = my_obj.checked;
	if(chk===true)
	{   
		$('#ir_att'+sno).show();
		// document.getElementById('ir_att').style.display="block";
	}
	else
	{
		$('#ir_att'+sno).hide();
		// document.getElementById('ir_att').style.display="none";
	}	
}

function check_inv(my_obj, sno)
{	
	var chk = my_obj.checked;
	if(chk===true)
	{   
		$('#invoice'+sno).show();
		// document.getElementById('invoice').style.display="block";
	}
	else
	{
		$('#invoice'+sno).hide();
		// document.getElementById('invoice').style.display="none";
	}
	
}
