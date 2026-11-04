$(document).ready(function () {
	// var table_id 	= "user_type_datatable";
	init_datatable(table_id,form_name,action);
// 	get_assign_qty_record();

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
var table_id 		= 'po_form_datatable';
var action 			= "datatable";



// function po_form_cu(unique_id = "") {
//     // alert('hi');
//     var internet_status  = is_online();

//     if (!internet_status) {
//         sweetalert("no_internet");
//         return false;
//     }
// 	var po_num = document.getElementById('po_num').value;
//     var po_date = document.getElementById('po_date').value;
// 	 var department = document.getElementById('department').value;
// 	 var gst_option = document.getElementById('gst_option').value;
//     var gst_value = document.getElementById('gst_value').value;
//     var executive_name = document.getElementById('executive_name').value;
//     var bill_address = document.getElementById('bill_address').value;
//     var contact_name = document.getElementById('contact_name').value;
//     var contact_number = document.getElementById('contact_number').value;
// 	var email = document.getElementById('email').value;
//     var district = document.getElementById('district').value;
//     var pin = document.getElementById('pin').value;
// 	var po_prepared_by = document.getElementById('po_prepared_by').value;
//     var po_type = document.getElementById('po_type').value;
//     var no_of_po = document.getElementById('no_of_po').value;
// 	// var delivery_due_dates = document.getElementById('delivery_due_dates').value;
//     // var ld_per_day = document.getElementById('ld_per_day').value;
//     // var ld_maximum_val = document.getElementById('ld_maximum_val').value;
// 	// var warranty = document.getElementById('warranty').value;
// 	// var warranty_duration = document.getElementById('warranty_duration').value;
// 	// var ins_reqired = document.getElementById('ins_reqired').value;
// 	// var bank_required = document.getElementById('bank_required').value;
// 	// var bg = document.getElementById('bg').value;
// 	// var bg_month = document.getElementById('bg_month').value;
// 	var unique_id = document.getElementById('unique_id').value;
//     var m_unique_id = document.getElementById('m_unique_id').value;
// 	var no_of_consignee = document.getElementById('no_of_consignee').value;
// 	var po_unique_id = document.getElementById('po_unique_id').value;

// 	// var file = document.getElementById('file').value;


//    var data = new FormData();
//             // var image_s = document.getElementById("file");
//             // if (image_s != '') {
//             //     for (var i = 0; i < image_s.files.length; i++) {
//             //         data.append("file", document.getElementById('file').files[i]);
 
//             //     }
//             // } else {
//             //     data.append("file", '');
//             // }

// //    alert(image_s);
	 
// 	data.append("po_num", po_num);
// 	data.append("m_unique_id", document.getElementById('m_unique_id').value);
// 	data.append("po_date", po_date);
// 	data.append("department", department);
// 	data.append("gst_option", gst_option);
// 	data.append("gst_value", gst_value);
// 	data.append("executive_name", executive_name);
// 	data.append("bill_address", bill_address);
// 	data.append("unique_id", unique_id);
// 	data.append("contact_name", contact_name);
// 	data.append("contact_number", contact_number);
// 	data.append("email", email);
// 	data.append("district", district);
// 	data.append("pin", pin);
// 	data.append("po_prepared_by", po_prepared_by);
// 	data.append("po_type", po_type);
// 	data.append("no_of_po", no_of_po);
// 	// data.append("delivery_due_dates", delivery_due_dates);
// 	// data.append("ld_per_day", ld_per_day);
// 	// data.append("ld_maximum_val", ld_maximum_val);
// 	// data.append("warranty", warranty);
// 	// data.append("warranty_duration", warranty_duration);
// 	// data.append("ins_reqired", ins_reqired);
// 	// data.append("bank_required", bank_required);
// 	// data.append("bg", bg);
// 	// data.append("bg_month", bg_month);
// 	data.append("no_of_consignee", no_of_consignee);
// 	data.append("po_unique_id", po_unique_id);

// 	data.append("action", "createupdate");

// 	var is_form = form_validity_check("was-validated");
// //  if (is_form) {
// 			var ajax_url = sessionStorage.getItem("folder_crud_link");
// 			var url1      = sessionStorage.getItem("list_link");
	
//         // console.log(data);
//         $.ajax({ 
// 			type: "POST",
// 			url: 'folders/po_form/crud.php',
// 			data: data,
// 			cache: false,
// 			contentType: false,
// 			processData: false,
// 			method: 'POST',
// 			beforeSend 	: function() {
// 				$(".createupdate_btn").attr("disabled","disabled");
// 				$(".createupdate_btn").text("Loading...");
// 			},
// 			success		: function(data) {
// 				var obj     = JSON.parse(data);
// 				var msg     = obj.msg;
// 				var status  = obj.status;
// 				var error   = obj.error;
				
// 				if (!status) {
// 					// url 	= '';
//                     // $(".createupdate_btn").text("Error");
//                     // console.log(error);
// 				} 
// 				else {
// 					if (msg =="already") {
// 						// Button Change Attribute
// 						// url 		= '';

// 						$(".createupdate_btn").removeAttr("disabled","disabled");
// 						if (unique_id) {
// 							$(".createupdate_btn").text("Update");
// 						} else {
							
// 							$(".createupdate_btn").text("Save");
// 						}
// 					}
// 				}
				
// 				sweetalert(msg,url);
// 				var url= $('#sec_tab').show();
// 			},
// 			error 		: function(data) {
// 				alert("Network Error");
// 			}
// 		});
// // 	} 
// // 	else {
// //         sweetalert("form_alert");
// //     }
// }

function term_condition() {
    var internet_status  = is_online();

    if (!internet_status) {
        sweetalert("no_internet");
        return false;
    }

	var delivery_due_dates = document.getElementById('delivery_due_dates').value;
    var ld_per_day = document.getElementById('ld_per_day').value;
    var ld_maximum_val = document.getElementById('ld_maximum_val').value;
	var warranty = document.getElementById('warranty').value;
	var warranty_duration = document.getElementById('warranty_duration').value;
	// var bank_required = document.getElementById("bank_required").checked;
	// var ins_reqired = document.getElementById("ins_reqired").checked;

	var bg = document.getElementById('bg').value;
	var bg_month = document.getElementById('bg_month').value;
	var unique_id = document.getElementById('unique_id').value;
    var demo = document.getElementById('demo').value;
	// var no_of_consignee = document.getElementById('no_of_consignee').value;
	var po_unique_id = document.getElementById('po_unique_id').value;

	var file = document.getElementById('file').value;

	
	// alert(ins_reqired);
	if(document.getElementById("ins_reqired").checked == true){
		var ins_reqired1 = 'on';
	}else{
		var ins_reqired1 = 'off';
	}

	if(document.getElementById("bank_required").checked == true){
		var bank_required1 = 'on';
	}else{
		var bank_required1 = 'off';
	}
   var data = new FormData();
            var image_s = document.getElementById("file");
            if (image_s != '') {
                for (var i = 0; i < image_s.files.length; i++) {
                    data.append("file", document.getElementById('file').files[i]);
 
                }
            } else {
                data.append("file", '');
            }

//    alert(image_s);
	 
	// data.append("no_of_po", no_of_po);
	data.append("delivery_due_dates", delivery_due_dates);
	data.append("ld_per_day", ld_per_day);
	data.append("ld_maximum_val", ld_maximum_val);
	data.append("warranty", warranty);
	data.append("warranty_duration", warranty_duration);
	data.append("ins_reqired", ins_reqired1);
	data.append("bank_required", bank_required1);
	data.append("bg", bg);
	data.append("bg_month", bg_month);
	data.append("demo", demo);
	data.append("po_unique_id", po_unique_id);
	data.append("action", "terms_condition");

// 	var is_form = form_validity_check("was-validated");
//  if (is_form) {
	// var data 	 = $(".was-validated").serialize();
	// data 		+= "&unique_id="+unique_id+"&action=demo";

			var ajax_url = sessionStorage.getItem("folder_crud_link");
			var url      = sessionStorage.getItem("list_link");
	
        // console.log(data);
        $.ajax({
			type: "POST",
			url: 'folders/po_form/crud.php',
			data: data,
			cache: false,
			contentType: false,
			processData: false,
			method: 'POST',
			// beforeSend 	: function() {
			// 	$(".createupdate_btn").attr("disabled","disabled");
			// 	$(".createupdate_btn").text("Loading...");
			// },
			success		: function(data) {
				var obj     = JSON.parse(data);
				var msg     = obj.msg;
				var status  = obj.status;
				var error   = obj.error;
				
				if (!status) {
					url 	= '';
                    $(".createupdate_btn").text("Error");
                    console.log(error);
				}
				 else {

					if (msg=="already") {
						// Button Change Attribute
						url 		= '';

						$(".createupdate_btn").removeAttr("disabled","disabled");
						if (unique_id) {
							$(".createupdate_btn").text("Update");
						} 
					}
				}
				// var url = 'folders/po_form/list.php';
				sweetalert(msg,url);
				

			},
			error 		: function(data) {
				alert("Network Error");
			}
		});
	// } 
	// else {
    //     sweetalert("form_alert");
    // }
}


function init_datatable(table_id='',form_name='',action='') {

	var table = $("#"+table_id);
	var data 	  = {
		"action"	: action, 
	};
	var ajax_url = sessionStorage.getItem("folder_crud_link");

	var datatable = table.DataTable({
		ordering    : true,
		searching   : true,
		"ajax"		: {
			url 	: ajax_url,
			type 	: "POST",
			data 	: data
		}
	});
}



function po_form_delete(unique_id = "") {

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





