$(document).ready(function () {
	// var table_id 	= "user_type_datatable";
	init_datatable(table_id,form_name,action);
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
var table_id 		= 'docs_approval_list_datatable';
var action 			= "datatable";

function doc_apporval_cu(unique_id = "") {
// alert('hi');
    var internet_status  = is_online();

    if (!internet_status) {
        sweetalert("no_internet");
        return false;
    }
  var doc_approval_sts = document.getElementById('doc_approval_sts').value;
//   alert(doc_approval_sts);
  var approved_by = document.getElementById('approved_by').value;
  var invoice_unique_id = document.getElementById('invoice_unique_id').value;
//   var form_main_unique_id = document.getElementById('form_main_unique_id').value;
// $form_main_unique_id

    var is_form = form_validity_check("was-validated");
     var data = new FormData();
    
            data.append("doc_approval_sts", doc_approval_sts);
            data.append("approved_by", approved_by);
             data.append("invoice_unique_id", invoice_unique_id);
            //   data.append("form_main_unique_id", form_main_unique_id);
           
            data.append("action", "createupdate");
    

    if (is_form) {
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
                    // beforeSend 	: function() {
                    // 	$(".createupdate_btn").attr("disabled","disabled");
                    // 	$(".createupdate_btn").text("Loading...");
                    // },
              success: function(data) {
                      
                        var obj = JSON.parse(data);
                        var msg = obj.msg;
                        var status = obj.status;
                        var error = obj.error;

				if (!status) {
					url 	= '';
                    $(".createupdate_btn").text("Error");
                    console.log(error);
				} else {
					if (msg=="already") {
						// Button Change Attribute
						url 		= '';

						$(".createupdate_btn").removeAttr("disabled","disabled");
						if (invoice_unique_id) {
							$(".createupdate_btn").text("Update");
						} 
				// 		else {
				// 			$(".createupdate_btn").text("Save");
				// 		}
					}
				}

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

function doc_apporval_delete(unique_id = "") {

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


function print(file_name)
{
    // 
	 	window.location='uploads/invoice/' + file_name,'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no';
}
function print_pdf(file_name)
{
    
	 onmouseover=window.open('uploads/invoice/' + file_name,'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
}

// function print(file_name) {
//     onmouseover = window.open('uploads/kra_kpi_form/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
// }
function print_view(file_name) {
// window.location
    window.open('uploads/invoice/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
}


function print_1(file_name)
{
    	window.location='uploads/po_form/po_attach/' + file_name,'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no';
}


function print_pdf_1(file_name)
{
    
 onmouseover=window.open('uploads/po_form/po_attach/' + file_name,'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
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