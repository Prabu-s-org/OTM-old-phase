$(document).ready(function () {
	//var table_id 	= "security_despoist_datatable";
	 init_datatable(table_id,form_name,action);
 sub_list_datatable_partial_bill('partial_bill_datatable', form_name, 'partial_bill_datatable');
get_partial_po('');

 //sub_list_datatable('bill_generate_datatable', form_name, 'bill_generate_datatable');   
    
});

var company_name 	= sessionStorage.getItem("company_name");
var company_address	= sessionStorage.getItem("company_name");
var company_phone 	= sessionStorage.getItem("company_name");
var company_email 	= sessionStorage.getItem("company_name");
var company_logo 	= sessionStorage.getItem("company_name");

var form_name 		= 'Securtity Deposit';
var form_header		= '';
var form_footer 	= '';
var table_name 		= '';
var table_id 		= 'security_despoist_datatable';
var table_id_1 		= 'fixed_datatable';
var table_id_2		= 'deleivery_datatable';
var action 			= "datatable";





function get_data(){

    init_datatable("security_despoist_datatable",form_name,"datatable");
}



function init_datatable(table_id='',form_name='',action='') {



    var from_date = $("#from_date").val();
      //  alert(from_date);
      var to_date = $("#to_date").val();
      //  alert(to_date);
      var opt = $("#opt").val();
	
	// var claim_amount=document.getElementById('claim_amount').value;
	// alert(claim_amount);
//alert();
	var table = $("#"+table_id);
	var data 	  = {
      "from_date":from_date,
      "to_date":to_date,
      "opt":opt,
		"action"	: action, 
		// "claim_amount"	: claim_amount, 

	};
// 	var ajax_url = sessionStorage.getItem("folder_crud_link");

// 	var datatable = table.DataTable({
// 		ordering    : true,
// 		searching   : true,
// 		"ajax"		: {
// 			url 	: ajax_url,
// 			type 	: "POST",
// 			data 	: data
// 		}
// 	});
// }
var ajax_url = sessionStorage.getItem("folder_crud_link");
	var datatable = table.DataTable({
		destroy: true, //new line
		ordering: true,
		searching: true,
		"ajax": {
			url: ajax_url,
			type: "POST",
			data: data
		},
		// dom: 'Bfrtip',
		dom: '<"dt-top-container"<l><"dt-center-in-div"B><f>r>t<ip>',
		buttons: [
			'copy', 'csv', 'excel', 'pdf', 'print'
		],
		lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
			pageLength: 10 // Default selected value
	});
}

   	
$(document).ready(function () {
	var table = $('#security_despoist_datatable').DataTable();

	// Clear the search input value and redraw the table
	table.search('').draw();

	// Also clear the input box visually if needed
	$('.dataTables_filter input').val('');
});




function get_partial_po(po_id){


	// alert(po_id);
	 partial_payment_datatable("partial_payment_datatable",form_name,'partial_payment_datatable',po_id);
	
}

function partial_payment_datatable(table_id = "", form_name = "", action = "",po_id) {
// alert();s
    // var po_id = $("#po_num_bill").val();
    var screen_id_val = $('#screen_id_val').val();
	// alert(screen_id_val);
	var user_type_unique_id = $('#user_type_unique_id').val();
    // var ins_unique_id = $("#ins_unique_id").val();
    // alert(ins_unique_id);
// 
    var table_id = 'partial_payment_datatable';

    var table = $("#" + table_id);
    var data = {

         "action": 'partial_payment_datatable',
          "po_id"	: po_id, 
          "screen_id_val": screen_id_val,
          "user_type_unique_id": user_type_unique_id,
        //   "ins_unique_id"	: ins_unique_id, 
    };
// alert(data);
    var ajax_url = sessionStorage.getItem("folder_crud_link");

    var datatable = table.DataTable({
        destroy: true, //new line
		ordering    : true,
		// searching   : true,
		"ajax"		: {
			url 	: ajax_url,
			type 	: "POST",
			data 	: data
        },
        // dom: 'Bfrtip',
        // dom: '<"dt-top-container"<l><"dt-center-in-div"B><f>r>t<ip>',
        // buttons: [
        //     'copy', 'csv', 'excel', 'pdf', 'print'
        // ],
         lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
			pageLength: 10 // Default selected value
     
        
	});
}



function get_cus_po_details(po_id){


var po_id = po_id;
	   var data = {

         "action": 'customerDetails',
          "po_id"	: po_id,          
    };
	  var ajax_url = sessionStorage.getItem("folder_crud_link");


	$.ajax({
		url: ajax_url,
		data:data,
		type:"POST",

		success:function(response){
		

			 var res = typeof response === "string" ? JSON.parse(response) : response;

			if (res.data) {
				let value = res.data[0];
				
				// Get first row

				// Append values to respective HTML elements by ID
				$("#po_no").text(value.po_number);        // Example: <span id="po_number"></span>
				$("#po_date").text(value.po_date);
				$("#cus_dept").text(value.department);
				$("#cus_address").text(value.address);
				$("#cus_dist").text(value.district);
				$("#cus_state").text(value.state);
				$("#cus_landline").text(value.contact);
				$("#cus_email").text(value.email);



			} else {
				alert("No customer details found.");
			}
		},
		error: function (xhr, status, error) {
			console.error("AJAX error:", error);
			alert("Failed to fetch customer details.");
		}
		
	});




}




function sub_list_datatable_partial_bill(table_id = "", form_name = "", action = "") {
// alert();s
    var po_num_bill = $("#po_num_bill").val();
    var screen_id_val = $('#screen_id_val').val();
	// alert(screen_id_val);
	var user_type_unique_id = $('#user_type_unique_id').val();
    // var ins_unique_id = $("#ins_unique_id").val();
    // alert(ins_unique_id);
// 
    var table_id = 'partial_bill_datatable';

    var table = $("#" + table_id);
    var data = {

         "action": 'partial_bill_datatable',
          "po_num_bill"	: po_num_bill, 
          "screen_id_val": screen_id_val,
          "user_type_unique_id": user_type_unique_id,
        //   "ins_unique_id"	: ins_unique_id, 
    };
// alert(data);
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
        // dom: 'Bfrtip',
        dom: '<"dt-top-container"<l><"dt-center-in-div"B><f>r>t<ip>',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
         lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
			pageLength: 10 // Default selected value
     
        
	});
}


// $("#select_all_checkbox").on("change", function () {
//    $(".myCheck").prop("checked", this.checked);
// });

$(document).on("change", "#select_all_checkbox", function () {
   $(".myCheck").prop("checked", this.checked);
});

// Optional: Update "select all" checkbox based on individual checkbox states
$(document).on("change", ".myCheck", function () {
   const total = $(".myCheck").length;
   const checked = $(".myCheck:checked").length;
   $("#select_all_checkbox").prop("checked", total === checked);
});


function partial_bill_create() {
      // alert();
      var internet_status = is_online();

      const checked = document.querySelectorAll('.myCheck:checked');
      var invoice_qty_total = [];
      var invoice_qty_amt = [];
      var invoice_tot = [];

	  var claim_value_array = [];
      // for (var i = 0; i < checked.length; i++) {
      // alert(i);
      //  for (var i = 0; i < checked.length; i++){
      // alert(i);
      // var checkbox_qty_val = checkbox_qty.length;
      // var bill_form_unique_id = document.getElementById('bill_form_unique_id').value;
      for (var i = 0; i < checked.length; i++) {
         // Get the unique identifier for each row
         var checkbox = checked[i];
         var bill_form_unique_id = checkbox.parentElement.querySelector('#bill_form_unique_id').value;
         var po_num = checkbox.parentElement.querySelector('#po_num').value;
         // alert(po_num);
         var invoice_date = checkbox.parentElement.querySelector('#invoice_date').value;
         var po_date = checkbox.parentElement.querySelector('#po_date').value;
         // var invoice_qty_val = checkbox.parentElement.querySelector('#invoice_qty').value;
         // alert(invoice_qty);
         var parentElement = checked[i].parentElement;

         var invoice_value_val = parentElement.querySelector('#invoice_value').value;

		 var claim_percent  = parentElement.querySelector('#claim_checkpercent').value;

         var claim_amount = parentElement.querySelector('#claim_checkamount').value;
         // var con_address = parentElement.querySelector('#con_address').value;

         var invoice_qty_val = parentElement.querySelector('#invoice_qty').value;
         // alert(invoice_qty_val);
         var invoice_no = parentElement.querySelector('#invoice_no').value;
         // alert(invoice_no);

         invoice_tot.push(invoice_no);

         var bg_num_val = parentElement.querySelector('#bg_num').value;
         // alert(bg_num_val);
         //   var bg_id_val = parentElement.querySelector('#bg_id').value;
         var bg_date_val = parentElement.querySelector('#bg_date').value;
         var bg_value_val = parentElement.querySelector('#bg_value').value;

         var amount = parseFloat(invoice_value_val);


         if (!isNaN(amount)) {
            invoice_qty_amt.push(amount);
            var sum_of_checkbox_value = invoice_qty_amt.reduce(function (total, current) {
               return total + current;
            }, 0);
         }

         // total qty calculate
         var number = parseFloat(invoice_qty_val);
         if (!isNaN(number)) {
            invoice_qty_total.push(number);
            var sum_of_invoice_qty = invoice_qty_total.reduce(function (total, current) {
               return total + current;
            }, 0);
         }


		 var claim_value  = parseFloat(claim_amount);

		  if (!isNaN(claim_value)) {
            claim_value_array.push(claim_value);
            var sum_of_claim_value = claim_value_array.reduce(function (total, current) {
               return total + current;
            }, 0);
         }




		 
      }


      // alert(sum_of_invoice_qty);
      invoice_nos = invoice_tot.join(",");


	//   return;
      // alert(invoice_nos);
      // alert(invoice_nos);
      // "&con_contact_name=" + con_contact_name + "&con_address=" + con_address +"&consignee_unique_id=" + consignee_unique_id +
      var data = "bill_form_unique_id=" + bill_form_unique_id + "&po_num=" + po_num + "&po_date=" + po_date + "&invoice_no=" + invoice_nos + "&claim_value=" + sum_of_claim_value +"&invoice_date=" +    invoice_date + "&invoice_value=" + sum_of_checkbox_value + "&invoice_qty=" + sum_of_invoice_qty + "&bg_num=" + bg_num_val + "&bg_date=" + bg_date_val + "&bg_value=" + bg_value_val + "&claim_percent=" + claim_percent;
      // + "&checkbox_qty=" + checkbox_qty_val
      //var data="bill_form_unique_id=" +bill_form_unique_id + "&consignee_unique_id=" + consignee_unique_id;
      data += "&action=partial_bill_main";
      var ajax_url = sessionStorage.getItem("folder_crud_link");
      var url = sessionStorage.getItem("list_link");
      $.ajax({
         type: "POST",
         url: ajax_url,
         data: data,
         beforeSend: function () {
            $(".po_delivery_add_update_btn").attr("disabled", "disabled");
            $(".po_delivery_add_update_btn").text("Loading...");
         },
         success: function (data) {
            // alert(data);
         },
         error: function (data) {
            alert("Network Error");
         }
      });


      partial_bill_creation_sub();
      
   }


   
   function partial_bill_creation_sub() {
      // alert('hi');
      // var stock_qty = document.getElementsByName('stock_qty[]');
      // var checkbox_qty = document.getElementsByName('bill_checkbox[]');

	   const checked = document.querySelectorAll('.myCheck:checked');

    //   const checked = document.querySelectorAll('.myCheck:checked');
      //  var checkbox_qty_length = checkbox_qty.length;
      for (var i = 0; i < checked.length; i++) {
         var checkbox = checked[i];
         // var bill_form_unique_id = document.getElementById('bill_form_unique_id').value;
         var bill_form_unique_id = checkbox.parentElement.querySelector('#bill_form_unique_id').value;
         // alert(bill_form_unique_id);
         // var po_num = document.getElementById('po_num').value;
         var po_num = checkbox.parentElement.querySelector('#po_num').value;
         // alert(po_num);
         // var po_date = document.getElementById('po_date').value;
         var po_date = checkbox.parentElement.querySelector('#po_date').value;
         
  	 var claim_percent  = checkbox.parentElement.querySelector('#claim_checkpercent').value;
         var claim_amount = checkbox.parentElement.querySelector('#claim_checkamount').value;


         // alert(po_date);
         // var con_contact_name = checkbox.parentElement.querySelector('#con_contact_name').value;
         // alert(con_contact_name);
         // var con_address = checkbox.parentElement.querySelector('#con_address').value;
         //    alert(con_address);
         // var con_contact_name = document.getElementById('con_contact_name').value;
         // alert(con_contact_name);
         // var con_address = document.getElementById('con_address').value;
         // alert(con_address);
         // var consignee_unique_id = checkbox.parentElement.querySelector('#consignee_unique_id').value;
         // var consignee_unique_id = document.getElementById('consignee_unique_id').value;
         var invoice_date = checkbox.parentElement.querySelector('#invoice_date').value;
         //   var invoice_auto_id_val = checkbox.parentElement.querySelector('#invoice_auto_id').value;
         // alert(invoice_auto_id_val);
         var parentElement = checked[i].parentElement;
         var invoice_qty_val = parentElement.querySelector('#invoice_qty').value;
         // alert(invoice_qty_val);
         var invoice_val = parentElement.querySelector('#invoice_value').value;
         // alert(invoice_val);
         var invoice_no_val = parentElement.querySelector('#invoice_no').value;

         var data = "bill_form_unique_id=" + bill_form_unique_id + "&invoice_no=" + invoice_no_val + "&invoice_date=" + invoice_date + "&invoice_value=" + invoice_val + "&invoice_qty=" + invoice_qty_val + "&po_num=" + po_num + "&po_date=" + po_date + "&claim_amount=" + claim_amount + "&claim_percent=" + claim_percent;
;
         // + "&con_contact_name=" + con_contact_name + "&con_address=" + con_address + "&consignee_unique_id=" + consignee_unique_id
         // + "&checkbox_qty=" + checkbox_qty_val
         data += "&action=partial_bill_creation_add_update";
         var ajax_url = sessionStorage.getItem("folder_crud_link");
         var url = sessionStorage.getItem("list_link");
         $.ajax({
            type: "POST",
            url: ajax_url,
            data: data,
            beforeSend: function () {
               $(".po_delivery_add_update_btn").attr("disabled", "disabled");
               $(".po_delivery_add_update_btn").text("Loading...");
            },
            success: function (data) {

               // return;
            //    alert(data);

			//    alert('success');ss

			   sweetalert("create",url);
               var obj = JSON.parse(data);
               var msg = obj.msg;
               var status = obj.status;
               var error = obj.error;
               // alert(msg);
            //    if (!status) {
            //       url = '';
            //       $(".createupdate_btn").text("Error");
            //       console.log(error);
            //    } else {
            //       if (msg == "already") {
            //          // Button Change Attribute
            //          url = '';
            //          $(".createupdate_btn").removeAttr("disabled", "disabled");
            //          if (unique_id) {
            //             $(".createupdate_btn").text("Update");
            //          } else {
            //             $(".createupdate_btn").text("Save");
            //          }
            //       }
            //    }
               // location.reload();
              
            },
            error: function (data) {
               alert("Network Error");
            }
         });
         // }
      }
   }















$(document).ready(function () {
	var table = $('#partial_bill_datatable').DataTable();

	// Clear the search input value and redraw the table
	table.search('').draw();

	// Also clear the input box visually if needed
	$('.dataTables_filter input').val('');
});














 
function print_view_1(file_name)
{
    // 
	 	window.location='uploads/payment/' + file_name,'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no';
}
function print_pdf(file_name)
{
    
	 onmouseover=window.open('uploads/payment/' + file_name,'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
}