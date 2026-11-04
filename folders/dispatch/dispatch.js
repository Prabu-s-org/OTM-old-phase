// $(document).ready(function () {
	// var table_id 	= "user_type_datatable";
	//init_datatable(table_id, form_name, action);
	//sub_list_datatable('fixed_datatable', form_name, 'fixed_datatable');
	// sub_list_datatable_delivery('deleivery_datatable',form_name,'deleivery_datatable');
	// get_data();
	// get_data1();

	// get_data_delivery();
// });
// function get_data() {
// 	// alert();
// 	init_datatable(table_id, form_name, action);
// }
// function get_data1() {
// 	// alert();
// 	sub_list_datatable('fixed_datatable', form_name, 'fixed_datatable');
// }

var company_name = sessionStorage.getItem("company_name");
var company_address = sessionStorage.getItem("company_name");
var company_phone = sessionStorage.getItem("company_name");
var company_email = sessionStorage.getItem("company_name");
var company_logo = sessionStorage.getItem("company_name");
var form_name = 'Dispatch Form';
var form_header = '';
var form_footer = '';
var table_name = '';
var table_id = 'dispatch_pending_datatable';
var table_id_1 = 'fixed_datatable';
var table_id_2 = 'deleivery_datatable';
var action = "datatable";

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


// function print(file_name) {
// 	// 	onmouseover= window.open('uploads/dispatch/' + file_name,'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
// 	// }
// 	onmouseover = window.open('uploads/dispatch/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
// }
// // function print(file_name) {
// //     onmouseover = window.open('uploads/kra_kpi_form/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
// // }
// function print_view(file_name) {
// 	// window.location = 'uploads/dispatch/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no';
// 	window.open('uploads/dispatch/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
// }
// // function invoice_details(unique_id = "") { // au = add,update
// function print1(file_name) {
// 	// 	onmouseover= window.open('uploads/dispatch/' + file_name,'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
// 	// }
// 	onmouseover = window.open('uploads/invoice/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
// }
// // function print(file_name) {
// //     onmouseover = window.open('uploads/kra_kpi_form/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
// // }
// function print_view1(file_name) {
// 	// window.location = 'uploads/dispatch/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no';
// 	window.open('uploads/invoice/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
// }




function cleanUploadFilePath(file_name) {

    if (!file_name) {
        return '';
    }

    return String(file_name)
        .replace(/\\/g, '/')
        .replace(/^\/+/, '');
}


/* =========================================================
   DISPATCH PDF / FILE
   ========================================================= */

function print(file_name) {

    file_name =
        cleanUploadFilePath(
            file_name
        );


    if (!file_name) {
        return;
    }


    window.open(
        'uploads/dispatch/' + file_name,
        'dispatch_file',
        'height=600,width=900,scrollbars=yes,resizable=yes,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no'
    );
}


/* =========================================================
   DISPATCH IMAGE
   ========================================================= */

function print_view(file_name) {

    file_name =
        cleanUploadFilePath(
            file_name
        );


    if (!file_name) {
        return;
    }


    window.open(
        'uploads/dispatch/' + file_name,
        'dispatch_image',
        'height=600,width=900,scrollbars=yes,resizable=yes,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no'
    );
}


/* =========================================================
   INVOICE PDF / FILE
   ========================================================= */

function print1(file_name) {

    file_name =
        cleanUploadFilePath(
            file_name
        );


    if (!file_name) {
        return;
    }


    window.open(
        'uploads/invoice/' + file_name,
        'invoice_file',
        'height=600,width=900,scrollbars=yes,resizable=yes,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no'
    );
}


/* =========================================================
   INVOICE IMAGE
   ========================================================= */

function print_view1(file_name) {

    file_name =
        cleanUploadFilePath(
            file_name
        );


    if (!file_name) {
        return;
    }


    window.open(
        'uploads/invoice/' + file_name,
        'invoice_image',
        'height=600,width=900,scrollbars=yes,resizable=yes,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no'
    );
}

function get_list1() {
	//alert("hii");
	var team_mem = document.getElementById('team_mem1').value;

	//alert(team_mem);

	init_datatable(table_id, form_name, action);


}

function get_list2() {
	//alert("hii");
	var team_mem = document.getElementById('team_mem2').value;

	//alert(team_mem);

	sub_list_datatable(table_id, form_name, action);


}

function restrictToAlphaNumeric(input) {
    input.value = input.value.replace(/[^a-zA-Z0-9 ]/g, '');
}

function restrictToAlphaNumeric1(input) {
    input.value = input.value.replace(/[^a-zA-Z0-9 \-\/]/g, '');
}