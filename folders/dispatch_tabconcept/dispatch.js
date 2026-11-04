$(document).ready(function () {
	// var table_id 	= "user_type_datatable";
	init_datatable(table_id,form_name,action);
	sub_list_datatable('fixed_datatable',form_name,'fixed_datatable');
    // sub_list_datatable_delivery('deleivery_datatable',form_name,'deleivery_datatable');
	get_data();
	get_data1();
	// get_data_delivery();
});
function get_data(){
	// alert();
	init_datatable(table_id,form_name,action);
}
function get_data1(){
	// alert();
	sub_list_datatable('fixed_datatable',form_name,'fixed_datatable');
}
// function get_data_delivery(){
// 	sub_list_datatable_delivery('deleivery_datatable',form_name,'deleivery_datatable');
// }
var company_name 	= sessionStorage.getItem("company_name");
var company_address	= sessionStorage.getItem("company_name");
var company_phone 	= sessionStorage.getItem("company_name");
var company_email 	= sessionStorage.getItem("company_name");
var company_logo 	= sessionStorage.getItem("company_name");
var form_name 		= 'Dispatch Form';
var form_header		= '';
var form_footer 	= '';
var table_name 		= '';
var table_id 		= 'dispatch_pending_datatable';
var table_id_1 		= 'fixed_datatable';
var table_id_2		= 'deleivery_datatable';
var action 			= "datatable";

function init_datatable(table_id='',form_name='',action='') {
    var table_id = 'dispatch_pending_datatable';
	var from_date = $("#from_date").val();
	var to_date = $("#to_date").val();
	// alert(to_date);
	var opt1 = $("#opt1").val();
	var screen_id_val = $('#screen_id_val').val();
	// alert(screen_id_val);
		var user_type_unique_id = $('#user_type_unique_id').val();
	var table = $("#"+table_id);
	var data 	  = {
		"action"	: action, 
		"from_date"	: from_date,
		"to_date"   : to_date,
		"opt1": opt1,
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
		dom: 'Bfrtip',
		buttons: [
			'copy', 'csv', 'excel', 'pdf', 'print'
		]
	});
}
function sub_list_datatable(table_id = "", form_name = "", action = "") {
    // alert('hii');
    // var form_main_unique_id = $("#demo").val();
    var table_id = 'fixed_datatable';
	var from_date = $("#from_date_dis").val();
    // alert(from_date);
	var to_date = $("#to_date_dis").val();
	var opt = $("#opt").val();
	var screen_id_val = $('#screen_id_val').val();
	// alert(screen_id_val);
		var user_type_unique_id = $('#user_type_unique_id').val();
// alert(table_id);
    var table = $("#" + table_id_1);
    var data = {
        
        "action": 'fixed_datatable',
		"from_date"	: from_date,
		"to_date"   : to_date,
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
		dom: 'Bfrtip',
		buttons: [
			'copy', 'csv', 'excel', 'pdf', 'print'
		]
	});
}
// function sub_list_datatable_delivery(table_id = "", form_name = "", action = "") {
//     // alert('hii');
//     // var form_main_unique_id = $("#demo").val();
//     var table_id = 'deleivery_datatable';
	
//     var table = $("#" + table_id_2);
// 	var from_date = $("#from_date_de").val();
//     alert(from_date);
// 	var to_date = $("#to_date_de").val();
// 	alert(to_date);
// 	var opt3 = $("#opt3").val();
// 	alert(opt3);
//     var data = {
        
//         "action": 'deleivery_datatable',
// 		"from_date"	: from_date,
// 		"to_date"   : to_date,
// 		"opt3": opt3,
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
function print(file_name)
{
// 	onmouseover= window.open('uploads/dispatch/' + file_name,'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
// }
onmouseover=window.open('uploads/dispatch/' + file_name,'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
}
// function print(file_name) {
//     onmouseover = window.open('uploads/kra_kpi_form/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
// }
function print_view(file_name) {
    // window.location = 'uploads/dispatch/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no';
    window.open('uploads/dispatch/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
}
// function invoice_details(unique_id = "") { // au = add,update
