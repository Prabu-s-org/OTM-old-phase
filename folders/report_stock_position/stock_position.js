$(document).ready(function () {
	// var table_id 	= "user_type_datatable";
	init_datatable(table_id,form_name,action);
// 	stock_position_pending();
	// sub_list_datatable('stock_processing_datatable',form_name,'stock_position_processing_datatable');
	complete_list_datatable('complete_stock_position_datatable',form_name,'stock_position_complete_datatable');
// 	stock_position_processing(table_id_1,form_name,action);
// stock_poistion_sublist('stock_poistion_sublist',form_name,'stock_poistion_sublist');

get_data();
});
function get_data(){
   init_datatable(table_id,form_name,action);
   }
function get_data_com(){
	complete_list_datatable('complete_stock_position_datatable',form_name,'stock_position_complete_datatable');
    }

var company_name 	= sessionStorage.getItem("company_name");
var company_address	= sessionStorage.getItem("company_name");
var company_phone 	= sessionStorage.getItem("company_name");
var company_email 	= sessionStorage.getItem("company_name");
var company_logo 	= sessionStorage.getItem("company_name");

var form_name 		= 'Stock Position';
var form_header		= '';
var form_footer 	= '';
var table_name 		= '';


var table_id 		= 'stock_position_datatable';
var table_id_1 		= 'stock_position_processing_datatable';
var action 			= "datatable";

// var action 			= "datatable";

// var table_stock_position_pending 		= 'stock_position_pending_datatable';
// var table_stock_position_processing 	= 'stock_position_processing_datatable';
// var table_stock_position_complete 		= 'stock_position_complete_datatable';
// function consignee(event){
//     var consignee_val = event.target.value;
//     // alert(consignee_val);
 
//     		var data = $(".was-validated").serialize();
//     data += "&unique_id=" + consignee_val + "&action=get_consignee";

// 		var ajax_url = sessionStorage.getItem("folder_crud_link");
// 		var url      = sessionStorage.getItem("list_link");

//         $.ajax({
// 			type: "POST",
// 			url: ajax_url,
// 		    data:data,
// 			success: function (data) {

// 				var obj = JSON.parse(data);
// 				$('#con_address').append(obj.data[0]);
// 				$('#con_mobile').append(obj.data[1]);
// 		}
// 		});
// }



// function stock_position_pending(table_id= "", form_name = "", action = "") {
//     // alert("test");
//     var table = $("#" + table_id);
//     var data = {
//         "action": "table_stock_position_pending",
//     };
    
//     var ajax_url = sessionStorage.getItem("folder_crud_link");

//     var datatable = table.DataTable({
        
//         ordering: true,
//         searching: true,
//         "searching": false,
//         "paging": false,
//         "ordering": false,
//         "info": false,
//         "ajax": {
           
//             url: ajax_url,
//             type: "POST",
//             data: data
           
//         }
//     });
// }


    // // processing
    // function stock_position_processing(table_id_1 = "", form_name = "", action = "") {
    
    //     var table = $("#" + table_id_1);
    //     var data = {
    //         "action": "table_stock_position_processing",
    //     };
    //     //  alert("test");
    //     var ajax_url = sessionStorage.getItem("folder_crud_link");

    //     var datatable = table.DataTable({
    //         ordering: true,
    //         searching: true,
    //         // "searching": false,
    //         // "paging": false,
    //         // "ordering": false,
    //         // "info": false,
    //         "ajax": {
    //             url: ajax_url,
    //             type: "POST",
    //             data: data
    //         }
    //     });
    // }


function init_datatable(table_id='',form_name='',action='') {

	var table = $("#"+table_id);
    var from_date = $("#from_date").val();
   
	var to_date = $("#to_date").val();
    var screen_id_val = $('#screen_id_val').val();

	// alert(screen_id_val);
	var user_type_unique_id = $('#user_type_unique_id').val();
	var data 	  = {
		"action"	: action, 
        "from_date"	: from_date,
		"to_date"   : to_date,
        "screen_id_val": screen_id_val,
        "user_type_unique_id": user_type_unique_id,
	};
	var ajax_url = sessionStorage.getItem("folder_crud_link");

	var datatable = table.DataTable({
        destroy: true,
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


// stock Position complete tab start
function complete_list_datatable(table_id = '', form_name = '', action = '') {
    // alert('hii');
    // var form_main_unique_id = $("#demo").val();
    var table_id = 'complete_stock_position_datatable';
    var from_date = $("#from_date_com").val();
    // alert(from_date);
	var to_date = $("#to_date_com").val();
    var screen_id_val = $('#screen_id_val').val();

	// alert(screen_id_val);
	var user_type_unique_id = $('#user_type_unique_id').val();
    // alert(table_id);
// alert(table_id);
    var table = $("#" + table_id);
    var data = {
        
        "action": 'stock_position_complete_datatable',
        "from_date"	: from_date,
		"to_date"   : to_date,
        "screen_id_val": screen_id_val,
        "user_type_unique_id": user_type_unique_id,
    };
    var ajax_url = sessionStorage.getItem("folder_crud_link");

    var datatable = table.DataTable({
        destroy: true,
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
// stack Position complete tab end

function stock_position_add_update(){
// 	alert('hello');
}
function print_pdf_1(file_name)
{
    
 onmouseover=window.open('uploads/po_form/po_attach/' + file_name,'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
}