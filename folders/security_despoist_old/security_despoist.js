$(document).ready(function () {
	// var table_id 	= "user_type_datatable";
	init_datatable(table_id,form_name,action);
	sub_list_datatable('fixed_datatable',form_name,'fixed_datatable');
	sub_list_datatable_delivery('deleivery_datatable',form_name,'deleivery_datatable');
	sub_list_datatable_5('pending_5_datatable',form_name,'pending_5_datatable');
	sub_list_datatable_25('pending_one_datatable',form_name,'pending_one_datatable');
    
});

var company_name 	= sessionStorage.getItem("company_name");
var company_address	= sessionStorage.getItem("company_name");
var company_phone 	= sessionStorage.getItem("company_name");
var company_email 	= sessionStorage.getItem("company_name");
var company_logo 	= sessionStorage.getItem("company_name");

var form_name 		= 'Payment Creation';
var form_header		= '';
var form_footer 	= '';
var table_name 		= '';
var table_id 		= 'security_despoist_datatable';
var table_id_1 		= 'fixed_datatable';
var table_id_2		= 'deleivery_datatable';
var action 			= "datatable";



function init_datatable(table_id='',form_name='',action='') {
	
	// var claim_amount=document.getElementById('claim_amount').value;
	// alert(claim_amount);
// alert();
	var table = $("#"+table_id);
	var data 	  = {
		"action"	: action, 
		// "claim_amount"	: claim_amount, 

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

function sub_list_datatable(table_id = "", form_name = "", action = "") {
    // alert('hii');
	// alert();
    // var form_main_unique_id = $("#demo").val();
    var table_id = 'fixed_datatable';
// alert(table_id);
    var table = $("#" + table_id_1);
    var data = {
        
        "action": 'fixed_datatable',
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


function sub_list_datatable_delivery(table_id = "", form_name = "", action = "") {
    // alert('hii');
    // var form_main_unique_id = $("#demo").val();
    var table_id = 'deleivery_datatable';
// alert(table_id);
    var table = $("#" + table_id_2);
    var data = {
        
        "action": 'deleivery_datatable',
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


function sub_list_datatable_25(table_id = "", form_name = "", action = "") {
    // var form_main_unique_id = $("#demo").val();
    var table_id = 'pending_one_datatable';
// alert(table_id);
    var table = $("#" + table_id);
    var data = {
        
        "action": 'pending_one_datatable',
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

function sub_list_datatable_5(table_id = "", form_name = "", action = "") {
    // alert('hii');
    // var form_main_unique_id = $("#demo").val();
    var table_id = 'pending_5_datatable';
// alert(table_id);
    var table = $("#" + table_id);
    var data = {
        
        "action": 'pending_5_datatable',
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
function payment_delete(unique_id = "") {

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

	
function installation_cu(unique_id = "") {

	var internet_status = is_online();
  
	if (!internet_status) {
	  sweetalert("no_internet");
	  return false;
	}
  
	var po_num = document.getElementById('po_num').value;
	//   alert(doc_approval_sts);
	var po_unique_id = document.getElementById('po_unique_id').value;
	//   alert(po_form_unique_id);
	var po_form_unique_id = document.getElementById('po_form_unique_id').value;
	//   alert(po_unique_id);
	var po_date = document.getElementById('po_date').value;
	var invoice_auto_id = document.getElementById('invoice_auto_id').value;
	var invoice_no = document.getElementById('invoice_no').value;
  
	var invoice_date = document.getElementById('invoice_date').value;
	var consignee_unique_id = document.getElementById('consignee_unique_id').value;
	var engineer_name = document.getElementById('engineer_name').value;
	var ins_com_date = document.getElementById('ins_com_date').value;
	// var cus_ack_date = document.getElementById('cus_ack_date').value;
  
	var dc_received_sts = document.getElementById('dc_received_sts').value;
	var dc_cus_signed_date = document.getElementById('dc_cus_signed_date').value;
	var ir_rec_status = document.getElementById('ir_rec_status').value;
	var ir_cus_signed_date = document.getElementById('ir_cus_signed_date').value;
	var snr_rec_status = document.getElementById('snr_rec_status').value;
	var snr_cus_signed_date = document.getElementById('snr_cus_signed_date').value;
	//  var consignee_unique_id = document.getElementById('consignee_unique_id').value;
  
  
	var unique_id = document.getElementById('unique_id').value;
	//   var ir_file = document.getElementById('ir_file').value;
	//   var snr_file = document.getElementById('snr_file').value;
  
	var documents_type = document.getElementById('documents_type');
	if (documents_type.checked) {
	  var dc_checkbox = 'DC';
	} else {
	  var dc_checkbox = '0';
	}
  
	var documents_type1 = document.getElementById('documents_type1');
	if (documents_type1.checked) {
	  var ir_checkbox = 'IR';
	} else {
	  var ir_checkbox = '0';
	}
  
	var documents_type2 = document.getElementById('documents_type2');
	if (documents_type2.checked) {
	  var snr_checkbox = 'SNR';
	} else {
	  var snr_checkbox = '0';
	}
  
  
	var test_doc = document.getElementById('dc_file').value;
	// alert(test_doc);
	var test_doc1 = document.getElementById('ir_file').value;
	// alert(test_doc1);
	var test_doc2 = document.getElementById('snr_file').value;
  
	var image_s = document.getElementById("dc_file");
  
	var image_ir = document.getElementById("ir_file");
	// alert(image_ir);
	var image_in = document.getElementById("snr_file");
  
  
	// var is_form = form_validity_check("was-validated");
	var data = new FormData();
	if (image_s != '') {
	  if(image_s.files){
	  for (var i = 0; i < image_s.files.length; i++) {
		data.append("test_file[]", document.getElementById('dc_file').files[i]);
	  }
	}
	} else {
  
	  data.append("test_doc", '');
  
	}
  
	if (image_ir != '') {
	  if(image_ir.files){
	  for (var i = 0; i < image_ir.files.length; i++) {
		data.append("test_file1[]", document.getElementById('ir_file').files[i]);
	  }
	}
	} else {
  
	  data.append("test_doc1", '');
  
	}
	if (image_in != '') {
	  if(image_in.files){
	  for (var i = 0; i < image_in.files.length; i++) {
		data.append("test_file2[]", document.getElementById('snr_file').files[i]);
	  }
	}
	} else {
  
	  data.append("test_doc2", '');
  
	}
  
	data.append("po_num", po_num);
	data.append("po_form_unique_id", po_form_unique_id);
	data.append("po_unique_id", po_unique_id);
	data.append("po_date", po_date);
	data.append("invoice_auto_id", invoice_auto_id);
	data.append("invoice_no", invoice_no);
	data.append("invoice_date", invoice_date);
	data.append("consignee_unique_id", consignee_unique_id);
	data.append("engineer_name", engineer_name);
	data.append("ins_com_date", ins_com_date);
	// data.append("cus_ack_date", cus_ack_date);
	data.append("documents_type", dc_checkbox);
	data.append("documents_type1", ir_checkbox);
	data.append("documents_type2", snr_checkbox);
	data.append("dc_received_sts", dc_received_sts);
	data.append("dc_cus_signed_date", dc_cus_signed_date);
	data.append("ir_rec_status", ir_rec_status);
	data.append("ir_cus_signed_date", ir_cus_signed_date);
	data.append("snr_rec_status", snr_rec_status);
	data.append("snr_cus_signed_date", snr_cus_signed_date);
	data.append("unique_id", unique_id);
	//  data.append("consignee_unique_id", consignee_unique_id);
  
	data.append("action", "createupdate");
  
  
	// if (is_form) {
	  // var data 	 = $(".was-validated").serialize();
	  // data 		+= "&unique_id="+unique_id+"&action=demo";
  
	  var ajax_url = sessionStorage.getItem("folder_crud_link");
	  var url = sessionStorage.getItem("list_link");
	  // console.log(data);
	  $.ajax({
		type: "POST",
		url: ajax_url,
		data: data,
		cache: false,
		contentType: false,
		processData: false,
		method: 'POST',
		beforeSend: function () {
		  // 	$(".createupdate_btn").attr("disabled","disabled");
		  // 	$(".createupdate_btn").text("Loading...");
		},
  
		success: function (data) {
  
		  var obj = JSON.parse(data);
		  var msg = obj.msg;
		  var status = obj.status;
		  var error = obj.error;
  
		  if (!status) {
			url = '';
			$(".createupdate_btn").text("Error");
			// console.log(error);
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
		 
		  //  installation_creation_sub();
  
		  sweetalert(msg, url);
		 
		},
		error: function (data) {
		  alert("Network Error");
		}
  
	  });
  
	  
	// } else {
	//   sweetalert("form_alert");
	// }
  }

function print_view_1(file_name)
{
    // 
	 	window.location='uploads/payment/' + file_name,'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no';
}
function print_pdf(file_name)
{
    
	 onmouseover=window.open('uploads/payment/' + file_name,'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
}