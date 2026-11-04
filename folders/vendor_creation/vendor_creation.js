$(document).ready(function () {
	// var table_id 	= "user_type_datatable";
	init_datatable(table_id,form_name,action);
	// sub_list_datatable('excel_datatable',form_name,'excel_datatable');
	
});

var company_name 	= sessionStorage.getItem("company_name");
var company_address	= sessionStorage.getItem("company_name");
var company_phone 	= sessionStorage.getItem("company_name");
var company_email 	= sessionStorage.getItem("company_name");
var company_logo 	= sessionStorage.getItem("company_name");

var form_name 		= 'Vendor Creation';
var form_header		= '';
var form_footer 	= '';
var table_name 		= '';
var table_id 		= 'vendor_creation_datatable';
var action 			= "datatable";




// function vendor_creation_cu(unique_id = "") {

//     var internet_status  = is_online();

//     if (!internet_status) {
//         sweetalert("no_internet");
//         return false;
//     }

//     var is_form = form_validity_check("was-validated");

// var pan_no =$('#pan_no').val();
// pan_no = pan_no.toUpperCase().replace(/[^A-Z0-9]/g, ''); // force uppercase and remove invalid chars
//     var panRegex = /^[A-Z]{5}[0-9]{4}[A-Z]{1}$/;
// if(pan_no){

// 	 if (!panRegex.test(pan_no)) {
//         Swal.fire({
//             icon: 'error',
//             title: 'Invalid PAN Number',
//             text: 'PAN must be in the format ABCDE1234F.'
//         });
//         return false;
//     }
// }
// var gst_no = $('#gst_no').val();
// if (gst_no) {
//     gst_no = gst_no.toUpperCase().replace(/[^A-Z0-9]/g, '');
//     var gstRegex = /^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/;

//     if (!gstRegex.test(gst_no)) {
//         Swal.fire({
//             icon: 'error',
//             title: 'Invalid GST Number',
//             text: 'GST must be 15 characters: e.g., 29ABCDE1234F1Z5'
//         });
//         return false;
//     }

// }


// var password = $('#password').val();

// if (password) {
//     if (password.length < 3) {
//         Swal.fire({
//             icon: 'error',
//             title: 'Invalid Password',
//             text: 'Password must be at least 3 characters long.'
//         });
//         return false;
//     }
// }

// var confirm_password = $('#confirm_password').val();

// if(confirm_password){

// 	if(confirm_password != password){
// 		 Swal.fire({
//             icon: 'error',
//             title: 'Password Mismatch',
//             text: 'Password And Confirm Password Should be Same.'
//         });
//         return false;

// 	}
// }

   

//     if (is_form) {

//         var data 	 = $(".was-validated").serialize();
//         data 		+= "&unique_id="+unique_id+"&action=createupdate";

//         var ajax_url = sessionStorage.getItem("folder_crud_link");
//         var url      = sessionStorage.getItem("list_link");

//         // console.log(data);
//         $.ajax({
// 			type 	: "POST",
// 			url 	: ajax_url,
// 			data 	: data,
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
// 					url 	= '';
//                     $(".createupdate_btn").text("Error");
//                     console.log(error);
// 				} else {
// 					if (msg=="already") {
// 						// Button Change Attribute
// 						url 		= '';

// 						$(".createupdate_btn").removeAttr("disabled","disabled");
// 						if (unique_id) {
// 							$(".createupdate_btn").text("Update");
// 						} else {
// 							$(".createupdate_btn").text("Save");
// 						}
// 					}
// 				}

// 				sweetalert(msg,url);
// 			},
// 			error 		: function(data) {
// 				alert("Network Error");
// 			}
// 		});


//     } else {
//         sweetalert("form_alert");
//     }
// }




  function vendor_creation_cu() {

                    //alert('hi');
                    var internet_status = is_online();
                    if (!internet_status) {
                        sweetalert("no_internet");
                        return false;
                    }

                    var my_no = document.getElementById('vendor_id').value;
 
         var vendor_user_type_unique_id = document.getElementById('vendor_user_type_unique_id').value;

         var vendor_id = document.getElementById('vendor_id').value;
                
                    var company_name = document.getElementById('company_name').value;
                    var name = document.getElementById('name').value;
                    var contact_no = document.getElementById('contact_no').value;
                    var image_val = document.getElementById("pan_file").value;
                    // alert(image_val);
                    var image_val_1 = document.getElementById("bank_proof_file").value;
                    var pan_no = document.getElementById('pan_no').value;
                      var account_no = document.getElementById('account_no').value;
                      var ifsc_code = document.getElementById('ifsc_code').value;
                      var address = document.getElementById('address').value;

                        var password = document.getElementById('password').value;

                        var confirm_password = document.getElementById('confirm_password').value;
  			          var user_name = document.getElementById('user_name').value;
                    var old_pan_file   = document.getElementById("old_pan_file").value;
                    var old_bank_file  = document.getElementById("old_bank_file").value;


                  
                     var bank_name = document.getElementById('bank_name').value;
                    if ( company_name != '' && name != '' && contact_no!="" &&   pan_no != ''  && account_no!="" &&   ifsc_code != '' && password!="" &&   confirm_password != ''  && bank_name!="" && ((image_val != '') || (old_pan_file != '')) &&  ((image_val_1 != '') || (old_bank_file != ''))) {

                        var alt_contact_no = document.getElementById('alt_contact_no').value;
                       
                        var unique_id = document.getElementById('unique_id').value;
                        
                        var mail_id = document.getElementById('mail_id').value;
                      
                        var gst_no = document.getElementById('gst_no').value;
                        var state_name = document.getElementById('state_name').value;
                        var district_name = document.getElementById('district_name').value;
                        var zone_name = document.getElementById('zone_name').value;
                        var pincode = document.getElementById('pincode').value;
                        var branch_name = document.getElementById('branch_name').value;
                       
                    
                        var acc_holder_name = document.getElementById('acc_holder_name').value;
                
                    var data = new FormData();

					var panInput = document.getElementById("pan_file");
					var bankInput = document.getElementById("bank_proof_file");

					var pan_old = document.getElementById("old_pan_file").value;
					var bank_old = document.getElementById("old_bank_file").value;

// PAN File

					if (panInput.files.length > 0) {
						data.append("pan_file", panInput.files[0]);
						data.append("pan_old", "");   // no need old
					} else {
						data.append("pan_file", "");
						data.append("pan_old", pan_old);  // pass old file name
					}

					// BANK File
					if (bankInput.files.length > 0) {
						data.append("bank_file", bankInput.files[0]);
						data.append("bank_old", "");
					} else {
						data.append("bank_file", "");
						data.append("bank_old", bank_old);
					}
													
					pan_no = pan_no.toUpperCase().replace(/[^A-Z0-9]/g, ''); // force uppercase and remove invalid chars
						var panRegex = /^[A-Z]{5}[0-9]{4}[A-Z]{1}$/;
					if(pan_no){

						if (!panRegex.test(pan_no)) {
							Swal.fire({
								icon: 'error',
								title: 'Invalid PAN Number',
								text: 'PAN must be in the format ABCDE1234F.'
							});
							return false;
						}
					}
					var gst_no = $('#gst_no').val();

					if (gst_no) {
						gst_no = gst_no.toUpperCase().replace(/[^A-Z0-9]/g, '');
						var gstRegex = /^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/;

						if (!gstRegex.test(gst_no)) {
							Swal.fire({
								icon: 'error',
								title: 'Invalid GST Number',
								text: 'GST must be 15 characters: e.g., 29ABCDE1234F1Z5'
							});
							return false;
						}

					}


				var password = $('#password').val();

				if (password) {
					if (password.length < 3) {
						Swal.fire({
							icon: 'error',
							title: 'Invalid Password',
							text: 'Password must be at least 3 characters long.'
						});
						return false;
					}
				}

		var confirm_password = $('#confirm_password').val();

		if(confirm_password){

			if(confirm_password != password){
				Swal.fire({
					icon: 'error',
					title: 'Password Mismatch',
					text: 'Password And Confirm Password Should be Same.'
				});
				return false;

			}
		}

   
           
                        data.append("company_name", company_name);
                        data.append("name", name);
                        data.append("contact_no", contact_no);
                        data.append("my_no", my_no);
                        data.append("user_name", user_name);
                        data.append("pan_no", pan_no);
                        data.append("account_no", account_no);
                        data.append("ifsc_code", ifsc_code);
                        data.append("address", address);
                        data.append("password", password);
                        data.append("confirm_password", confirm_password);
                        data.append("bank_name", bank_name);
                        data.append("alt_contact_no", alt_contact_no);
                        data.append("mail_id", mail_id);
                        data.append("gst_no", gst_no);
                        data.append("state_name", state_name);
                        data.append("district_name", district_name);
                        data.append("zone_name", zone_name);
                        data.append("pincode", pincode);
                         data.append("branch_name", branch_name);
                        data.append("vendor_user_type_unique_id", vendor_user_type_unique_id);
                        data.append("vendor_id", vendor_id);
 			             data.append("acc_holder_name", acc_holder_name);

       
                        data.append("unique_id", unique_id);
                        
                        // data.append("po_unique_id", po_unique_id);
                        data.append("action", "createupdate");
                        var is_form = form_validity_check("was-validated");
                        //  if (is_form) {
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
                            beforeSend: function() {
                                $(".createupdate_btn").attr("disabled", "disabled");
                                $(".createupdate_btn").text("Loading...");
                            },
                            success: function(data) {
                                // alert(data);
                                var obj = JSON.parse(data);
                                var msg = obj.msg;
                                var status = obj.status;
                                var error = obj.error;
                                if (!status) {
                                    url 	= '';
                                    $(".createupdate_btn").text("Error");
                                    console.log(error);
                                    // sweetalert(msg);
                                } else {
                                    if (msg == "already") {
                                        // Button Change Attribute
                                        // url 		= '';
                                        // sweetalert(msg);	
                                        $(".createupdate_btn").removeAttr("disabled", "disabled");
                                        if (unique_id) {
                                            $(".createupdate_btn").text("Update");
                                        } else {
                                            $(".createupdate_btn").text("Save");
                                            // 			sweetalert(msg);	
                                        }
                                    }
                                }
                                sweetalert(msg, url);
                            },
                            error: function(data) {
                                alert("Network Error");
                            }
                        });
                    } else {
                        sweetalert("form_alert");
                    }
                }



function init_datatable_1(table_id='', form_name='', action='') {
    var table = $("#" + table_id);
    var screen_id_val = $('#screen_id_val').val();
    var user_type_unique_id = $('#user_type_unique_id').val();

    var data = {
        "action": action,
        "screen_id_val": screen_id_val,
        "user_type_unique_id": user_type_unique_id,
    };

    var ajax_url = sessionStorage.getItem("folder_crud_link");

    var datatable = table.DataTable({
        ordering: true,
        searching: true,
        ajax: {
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
		],
        
    });
    $('#columnVisibilityForm').on('change', 'input[type="checkbox"]', function() {
		var columnIdx = $(this).data('column');
		var isVisible = $(this).is(':checked');
		datatable.column(columnIdx).visible(isVisible); // Use datatable instead of table
	});
}

function init_datatable_2(table_id='', form_name='', action='') {
    var table = $("#" + table_id);
    var screen_id_val = $('#screen_id_val').val();
    var user_type_unique_id = $('#user_type_unique_id').val();

    var data = {
        "action": action,
        "screen_id_val": screen_id_val,
        "user_type_unique_id": user_type_unique_id,
    };

    var ajax_url = sessionStorage.getItem("folder_crud_link");

    var datatable = table.DataTable({
        ordering: true,
        searching: true,
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
        ajax: {
            url: ajax_url,
            type: "POST",
            data: data
        },
        columns: [
			{ data: "s_no" },             // Dynamically generated on the backend (can be generated as an alias or column in SQL)
			{ data: "company_name" },
			{ data: "name" },
			{ data: "contact_no" },
			{ data: "alt_contact_no" },
			{ data: "pan_no" },
			{ data: "mail_id" },
			{ data: "gst_no" },
			{ data: "state_name" },       // Retrieved via SQL (JOIN with state_creation table)
			{ data: "district_name" },    // Retrieved via SQL (JOIN with district_creation table)
			{ data: "zone_name" },
			{ data: "pincode" },
			{ data: "bank_name" },
			{ data: "branch_name" },
			{ data: "account_no" },
			{ data: "ifsc_code" },
			{ data: "address" },
			{ data: "unique_id" }
		]
		
    });
    $('#columnVisibilityForm').on('change', 'input[type="checkbox"]', function() {
		var columnIdx = $(this).data('column');
		var isVisible = $(this).is(':checked');
		datatable.column(columnIdx).visible(isVisible); // Use datatable instead of table
	});
}

function init_datatable(table_id='', form_name='', action='') {
    
    var table = $("#" + table_id);
    var screen_id_val = $('#screen_id_val').val();
    var user_type_unique_id = $('#user_type_unique_id').val();
	if ($.fn.DataTable.isDataTable('#' + table_id)) {
        $('#' + table_id).DataTable().destroy(); // Destroy previous instance
    }
    var data = {
        "action": action,
        "screen_id_val": screen_id_val,
        "user_type_unique_id": user_type_unique_id,
    };

    var ajax_url = sessionStorage.getItem("folder_crud_link");

    var datatable = table.DataTable({
        ordering: true,
        searching: true,
         destroy: true,
        responsive: true,
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
        ajax: {
            url: ajax_url,
            type: "POST",
            data: data,
            dataSrc: function (json) {
                // Ensure the response contains the data
                if (json.data) {
                    // Map the response data to match the columns in the DataTable
                    return json.data.map(function(row) {
                        return {
                            "serial_number": row[0],  
                              "vendor_user_type_unique_id": row[1], 
                                "vendor_id": row[2], // serial_number
                            "company_name": row[3],        // company_name
                            "name": row[4],                // name
                            "contact_no": row[5],          // contact_no
                            "alt_contact_no": row[6],      // alt_contact_no
                            "pan_no": row[7],              // pan_no
                            "mail_id": row[8],             // mail_id
                            "gst_no": row[9],              // gst_no
                            "state_name": row[10],          // state_name
                            "district_name": row[11],       // district_name
                            "zone_name": row[12],          // zone_name
                            "pincode": row[13],
							 "user_name": row[14],
							  "password": row[15],            // pincode
                            "bank_name": row[16],          // bank_name
                            "branch_name": row[17],        // branch_name
                            "account_no": row[18],         // account_no
                            "ifsc_code": row[19],          // ifsc_code
                            "address": row[20],            // address
                            "unique_id": row[21]           // unique_id (action buttons)
                        };
                    });
                } else {
                    return [];
                }
            }
        },
        columns: [
            { data: "serial_number" },  // Mapping to serial_number
            { data: "vendor_user_type_unique_id" },
             { data: "vendor_id" },
              { data: "company_name" },
            { data: "name" },
            { data: "contact_no" },
            { data: "alt_contact_no" },
            { data: "pan_no" },
            { data: "mail_id" },
            { data: "gst_no" },
            { data: "state_name" },
            { data: "district_name" },
            { data: "zone_name" },
            { data: "pincode" },
			{ data: "user_name" },
			{ data: "password" },
            { data: "bank_name" },
            { data: "branch_name" },
            { data: "account_no" },
            { data: "ifsc_code" },
            { data: "address" },
            { data: "unique_id" } // Mapping for unique_id (this can contain HTML for action buttons)
        ]
    });
    $('#columnVisibilityForm').on('change', 'input[type="checkbox"]', function() {
		var columnIdx = $(this).data('column');
		var isVisible = $(this).is(':checked');
		datatable.column(columnIdx).visible(isVisible); // Use datatable instead of table
	});
}

function init_datatable_extra(table_id='', form_name='', action='') {
    var table = $("#" + table_id);
    var screen_id_val = $('#screen_id_val').val();
    var user_type_unique_id = $('#user_type_unique_id').val();

    var data = {
        "action": action,
        "screen_id_val": screen_id_val,
        "user_type_unique_id": user_type_unique_id,
    };

    var ajax_url = sessionStorage.getItem("folder_crud_link");

    var datatable = table.DataTable({
        ordering: true,
        searching: true,
        dom: 'Bfrtip', // Adds the button and column visibility controls to the DOM
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
                text: 'Column Visibility'
            }
        ],
        ajax: {
            url: ajax_url,
            type: "POST",
            data: data,
            dataSrc: function (json) {
                // This function ensures the response from the server is properly handled
                if (json.data) {
                    return json.data;
                } else {
                    return [];
                }
            }
        },
        columns: [
            { data: "s_no" },             // Dynamically generated serial number on the backend
            { data: "company_name" },
            { data: "name" },
            { data: "contact_no" },
            { data: "alt_contact_no" },
            { data: "pan_no" },
            { data: "mail_id" },
            { data: "gst_no" },
            { data: "state_name" },       // Retrieved via SQL (JOIN with state_creation table)
            { data: "district_name" },    // Retrieved via SQL (JOIN with district_creation table)
            { data: "zone_name" },
            { data: "pincode" },
            { data: "bank_name" },
            { data: "branch_name" },
            { data: "account_no" },
            { data: "ifsc_code" },
            { data: "address" },
            { data: "unique_id" }         // Render action buttons for unique_id
        ]
    });
}

function init_datatable_olds(table_id='', form_name='', action='') {
    var table = $("#" + table_id);
    var screen_id_val = $('#screen_id_val').val();
    var user_type_unique_id = $('#user_type_unique_id').val();

    var data = {
        "action": action,
        "screen_id_val": screen_id_val,
        "user_type_unique_id": user_type_unique_id,
    };

    var ajax_url = sessionStorage.getItem("folder_crud_link");

    var datatable = table.DataTable({
        ordering: true,
        searching: true,
        dom: 'Bfrtip', // Adds the button and column visibility controls to the DOM
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
                text: 'Column Visibility'
            }
        ],
        ajax: {
            url: ajax_url,
            type: "POST",
            data: data,
            dataSrc: function(json) {
                // Ensure the data is correctly formatted before passing it to DataTable
                return json.data; // Adjust this based on your actual response structure
            }
        },
        columns: [
            { data: "s_no" },             // Dynamically generated on the backend (can be generated as an alias or column in SQL)
            { data: "company_name" },
            { data: "name" },
            { data: "contact_no" },
            { data: "alt_contact_no" },
            { data: "pan_no" },
            { data: "mail_id" },
            { data: "gst_no" },
            { data: "state_name" },       // Retrieved via SQL (JOIN with state_creation table)
            { data: "district_name" },    // Retrieved via SQL (JOIN with district_creation table)
            { data: "zone_name" },
            { data: "pincode" },
            { data: "bank_name" },
            { data: "branch_name" },
            { data: "account_no" },
            { data: "ifsc_code" },
            { data: "address" },
            { data: "unique_id" }
        ]
    });
}


function get_user_permission() {
	var screen_id_val = $('#screen_id_val').val();

	var user_type_unique_id = $('#user_type_unique_id').val();

	var data = {
		"screen_id_val": screen_id_val,
		"user_type_unique_id": user_type_unique_id,
		"action": 'user_permission',
	};

	var ajax_url = sessionStorage.getItem("folder_crud_link");
	var url = sessionStorage.getItem("list_link");

	// console.log(data);
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

function vendor_creation_delete(unique_id = "") {

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

function get_under_user_type_ids()
{ 
	var under_user_type= $('#under_user_type_name').val();
	$('#under_user_type').val(under_user_type);
}

function get_under_user_type (user_type = "") {

$("#under_user_type_name").html('');
	var ajax_url = sessionStorage.getItem("folder_crud_link");

	if (staff_id) {
		var data = {
			"user_type" : user_type,
			"action"	: "user_type_options"
		}

		$.ajax({
			type 	: "POST",
			url 	: ajax_url,
			data 	: data,
			success : function(data) {

				if (data) { 
					$("#under_user_type_name").html(data);
				}

			}
		});
	}
}


function get_district_name(state_unique_id = "") {
// alert("vgbhn");
   
	var state_name = $('#state_name').val();
	var data = "&state_name=" + state_name + "&action=district_type_option";

	var ajax_url = sessionStorage.getItem("folder_crud_link");
	$.ajax({
		type: "POST",
		url: ajax_url,
		data: data,
		success: function (data) {
			if (data) {
				$("#zone_unique_id").html(data);
			}
		}
	});

}

