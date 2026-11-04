$(document).ready(function () {
	// var table_id 	= "user_type_datatable";
	init_datatable(table_id,form_name,action);
	sub_list_datatable('bg_update_datatable',form_name,'bg_update_datatable');
	sub_list_datatable1('bg_datatable',form_name,'bg_datatable');
	get_user_permission();
	get_user_permission_1();
	
});
var company_name 	= sessionStorage.getItem("company_name");
var company_address	= sessionStorage.getItem("company_name");
var company_phone 	= sessionStorage.getItem("company_name");
var company_email 	= sessionStorage.getItem("company_name");
var company_logo 	= sessionStorage.getItem("company_name");
var form_name 		= 'State Creation';
var form_header		= '';
var form_footer 	= '';
var table_name 		= '';
var table_id 		= 'bg_datatable';
var action 			= "datatable";
function get_filter(filter_action = 0) {
// 		var from_date       = $("#from_date").val();
// 		var to_date         = $("#to_date").val();
		var status  = $("#status").val();
// 			sessionStorage.setItem("from_date", from_date);
// 			sessionStorage.setItem("to_date", to_date);
			sessionStorage.setItem("status", status);
            
			var filter_data = {
				// "from_date": from_date,
				// "to_date": to_date,
				"status": status,
				
			};
// 			console.log(filter_data);
			init_datatable(table_id, form_name, action, filter_data);
}
function init_datatable(table_id='',form_name='',action='') {
 var status     = $("#status").val();
//  alert(status);
	var table = $("#"+table_id);
	var screen_id_val = $('#screen_id_val').val();
	// alert(screen_id_val);
		var user_type_unique_id = $('#user_type_unique_id').val();
	var data 	  = {
		"action"	: action, 
		"status"	: status,
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
function get_bg_data(filter_data_bill= 0){
    	var po_num  = $("#po_num").val();
		sessionStorage.setItem("po_num", po_num);
            
			var filter_data_bill = {
				"po_num": po_num,
				
			};
// 			console.log(filter_data_bill);
			
		sub_list_datatable('bg_create_datatable',form_name= "",'bg_create_datatable');
}
function sub_list_datatable(table_id = "", form_name = "", action = "") {
    // alert('hii');
    
    var table_id = 'bg_create_datatable';
// alert(table_id);
var po_num  = $("#po_num").val();
    var table = $("#" + table_id);
    var data = {
         "action": 'bg_create_datatable',
         "po_num": po_num
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
		destroy: true, //new line
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
		dom: 'Bfrtip',
		buttons: [
			'copy', 'csv', 'excel', 'pdf', 'print'
		]
    });
}
// function state_creation_delete(unique_id = "") {
// 	var ajax_url = sessionStorage.getItem("folder_crud_link");
// 	var url      = sessionStorage.getItem("list_link");
	
// 	confirm_delete('delete')
// 	.then((result) => {
// 		if (result.isConfirmed) {
// 			var data = {
// 				"unique_id" 	: unique_id,
// 				"action"		: "delete"
// 			}
// 			$.ajax({
// 				type 	: "POST",
// 				url 	: ajax_url,
// 				data 	: data,
// 				success : function(data) {
// 					var obj     = JSON.parse(data);
// 					var msg     = obj.msg;
// 					var status  = obj.status;
// 					var error   = obj.error;
// 					if (!status) {
// 						url 	= '';
						
// 					} else {
// 						init_datatable(table_id,form_name,action);
// 					}
// 					sweetalert(msg,url);
// 				}
// 			});
// 		} else {
// 			// alert("cancel");
// 		}
// 	});
// }
// function get_under_user_type_ids()
// { 
// 	var under_user_type= $('#under_user_type_name').val();
// 	$('#under_user_type').val(under_user_type);
// }
// function get_under_user_type (user_type = "") {
// $("#under_user_type_name").html('');
// 	var ajax_url = sessionStorage.getItem("folder_crud_link");
// 	if (staff_id) {
// 		var data = {
// 			"user_type" : user_type,
// 			"action"	: "user_type_options"
// 		}
// 		$.ajax({
// 			type 	: "POST",
// 			url 	: ajax_url,
// 			data 	: data,
// 			success : function(data) {
// 				if (data) { 
// 					$("#under_user_type_name").html(data);
// 				}
// 			}
// 		});
// 	}
// }
function excel(export_1, bg_no) {
	// Assuming you want to include the form_unique_id in the URL
	// var link = "folders/bg/excel";
	// alert(link);
	// // Redirect to the generated link
	// window.location.href = link;
	// alert(bg_no);
	window.location.href = "folders/bg/excel.php?bg_no="+bg_no;
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
	console.log(data);
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

			// console.log(dataString);

			// var addButton = document.getElementById('add_btn');
			// if (dataString.includes('5f8807ff00bf726601')) {
			// 	addButton.style.visibility = 'visible';  // Show the button
			// } else {
			// 	addButton.style.visibility = 'hidden';   // Hide the button but keep its space
			// }
			var listpage = document.getElementById('list_1');
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
