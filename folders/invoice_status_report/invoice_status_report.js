

var company_name = sessionStorage.getItem("company_name");
var company_address = sessionStorage.getItem("company_name");
var company_phone = sessionStorage.getItem("company_name");
var company_email = sessionStorage.getItem("company_name");
var company_logo = sessionStorage.getItem("company_name");

var form_name = 'State Creation';
var form_header = '';
var form_footer = '';
var table_name = '';
var table_id = 'po_form_datatable';
var action = "datatable";



// function init_datatable(table_id = '', form_name = '', action = '') {
// 	// alert();
// 	var table = $("#" + table_id);
// 	var month_fill = $('#month_fill').val();
// 	var data = {
// 		"month_fill": month_fill,
// 		"action": action,
// 	};
// 	var ajax_url = sessionStorage.getItem("folder_crud_link");

// 	var datatable = table.DataTable({
// 		ordering: true,
// 		searching: true,
// 		"ajax": {
// 			url: ajax_url,
// 			type: "POST",
// 			data: data
// 		}
// 	});
// }

// function sub_list_datatable(table_id = "", form_name = "", action = "") {
// 	// alert();
// 	// alert('hii');
// 	// var po_cancel_datatable = $("#demo").val();
// 	var table_id = 'po_cancel_datatable';
// 	// alert(table_id);
// 	var table = $("#" + table_id);
// 	var data = {

// 		"action": 'po_cancel_datatable',
// 	};
// 	var ajax_url = sessionStorage.getItem("folder_crud_link");
// 	var datatable = table.DataTable({
// 		ordering: true,
// 		searching: true,
// 		"ajax": {
// 			url: ajax_url,
// 			type: "POST",
// 			data: data
// 		}
// 	});
// }


function po_form_delete(unique_id = "") {

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

$('#tender_code').on('change', function () {

	// alert('hi');
	var tender_code = $('#tender_code').val();
	//  alert(tender_code);
	var data = "&tender_code=" + tender_code + "&action=item_code_option";


	var ajax_url = sessionStorage.getItem("folder_crud_link");
	$.ajax({
		type: "POST",
		url: ajax_url,
		data: data,
		success: function (data) {
			// alert(data);
			if (data) {
				$("#item_code").html(data);
			}
		}
	});

})
function print_pdf_1(file_name) {

	onmouseover = window.open('uploads/po_form/po_attach/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
}
function print_pdf_2(file_name) {

	onmouseover = window.open('uploads/po_form/po_attach/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
}