$(document).ready(function () {
	// var table_id 	= "user_type_datatable";
	
	init_datatable(table_id,form_name,action);
	get_user_permission();
// 	get_district_name();
});

var company_name 	= sessionStorage.getItem("company_name");
var company_address	= sessionStorage.getItem("company_name");
var company_phone 	= sessionStorage.getItem("company_name");
var company_email 	= sessionStorage.getItem("company_name");
var company_logo 	= sessionStorage.getItem("company_name");

var form_name 		= 'Team Allocation';
var form_header		= '';
var form_footer 	= '';
var table_name 		= '';
var table_id 		= 'team_allocation_datatable';
var action 			= "datatable";

function team_allocations_cu(unique_id = "") {

    var internet_status  = is_online();

    if (!internet_status) {
        sweetalert("no_internet");
        return false;
    }

    var is_form = form_validity_check("was-validated");

    if (is_form) {

        var data 	 = $(".was-validated").serialize();
        data 		+= "&unique_id="+unique_id+"&action=createupdate";

        var ajax_url = sessionStorage.getItem("folder_crud_link");
        var url      = sessionStorage.getItem("list_link");

        // console.log(data);
        $.ajax({
			type 	: "POST",
			url 	: ajax_url,
			data 	: data,
			beforeSend 	: function() {
				$(".createupdate_btn").attr("disabled","disabled");
				$(".createupdate_btn").text("Loading...");
			},
			success		: function(data) {

				var obj     = JSON.parse(data);
				var msg     = obj.msg;
				var status  = obj.status;
				var error   = obj.error;

				if (!status) {
					 $(".createupdate_btn").text("Error");
        console.log(error);

        // ❌ Show alert if PO Number does not exist or QC is not approved
        if (msg.includes("Error: PO Number does not exist or Material QC is not approved!")) {
            alert(msg);
        }
				} else {
					if (msg=="already") {
						// Button Change Attribute
						url 		= '';

						$(".createupdate_btn").removeAttr("disabled","disabled");
						if (unique_id) {
							$(".createupdate_btn").text("Update");
						} else {
							$(".createupdate_btn").text("Save");
						}
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


function get_district_name(state_unique_id = "") {

//   alert("fvgbhn");
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
        "usertype": user_type_unique_id,
    };
    
    var ajax_url = sessionStorage.getItem("folder_crud_link");

    var datatable = table.DataTable({
        ordering: true,
        destroy: true,
        responsive: true,
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
            { data: "s_no" },        // This column is dynamically generated on the backend
            { data: "region" },
            { data: "state_name" },
            { data: "district_name" },
            { data: "po_no" },
            { data: "consignee_address" },
            { data: "consignee_name" },
            { data: "consignee_district" },
            { data: "eng_name" },
            { data: "user_role" },
            // { data: "is_active" },
            { data: "unique_id" }
        ]
    });

    // Handle column visibility change when checkboxes are toggled
    // $('#saveColumnVisibility').on('click', function() {
    //     var form = $('#columnVisibilityForm');
    //     form.find('input[type="checkbox"]').each(function() {
    //         var columnIdx = $(this).data('column');
    //         var isVisible = $(this).is(':checked');
    //         datatable.column(columnIdx).visible(isVisible); // Use datatable instead of table
    //     });

    //     // Close the modal
    //     $('#columnVisibilityModal').modal('hide');
    // });
	$('#columnVisibilityForm').on('change', 'input[type="checkbox"]', function() {
        var columnIdx = $(this).data('column');
        var isVisible = $(this).is(':checked');
        datatable.column(columnIdx).visible(isVisible); // Use datatable instead of table
    });
}

function init_datatable_1111(table_id='', form_name='', action='') {
    var table = $("#" + table_id);
    var screen_id_val = $('#screen_id_val').val();
    var user_type_unique_id = $('#user_type_unique_id').val();
    
    var data = {
        "action": action,
        "screen_id_val": screen_id_val,
        "usertype": user_type_unique_id,
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
                text: 'Column Visibility',
				action: function (e, dt, node, config) {
                    // Open the column visibility modal when the button is clicked
                    $('#columnVisibilityModal').modal('show');

                    // Populate the modal with checkboxes for each column
                    var columns = dt.columns().header();
                    var form = $('#columnVisibilityForm');
                    form.empty(); // Clear any existing checkboxes
                    columns.each(function (header, index) {
                        var isChecked = dt.column(index).visible();
                        form.append(
                            '<div class="form-check">' +
                                '<input type="checkbox" class="form-check-input" data-column="' + index + '" ' + (isChecked ? 'checked' : '') + '>' +
                                '<label class="form-check-label">' + $(header).text() + '</label>' +
                            '</div>'
                        );
                    });
                // }
            }
            }
        ],
		
        ajax: {
            url: ajax_url,
            type: "POST",
            data: data
        },
        columns: [
            { data: "s_no" },        // This column is dynamically generated on the backend
            { data: "state_name" },
            { data: "is_active" },
            { data: "unique_id" }
        ]
    });
}
$('#saveColumnVisibility1').on('click', function() {
	var form = $('#columnVisibilityForm');
	form.find('input[type="checkbox"]').each(function() {
		var columnIdx = $(this).data('column');
		var isVisible = $(this).is(':checked');
		table.column(columnIdx).visible(isVisible);
	});

	// Close the modal
	$('#columnVisibilityModal').modal('hide');
});

// function init_datatable(table_id='',form_name='',action='') {

// 	var table = $("#"+table_id);
// 	var screen_id_val = $('#screen_id_val').val();

// 	// alert(screen_id_val);
// 	var user_type_unique_id = $('#user_type_unique_id').val();
// 	var data 	  = {
// 		"action"	: action, 
// 		"screen_id_val": screen_id_val,
// 		"usertype": user_type_unique_id,
// 	};
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

	// console.log(data);
	$.ajax({
		type: "POST",
		url: ajax_url,
		data: data,
		success: function (data) {

			var obj = JSON.parse(data);

			var dataString = obj.data;

			console.log(dataString);

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
function team_allocations_delete(unique_id = "") {

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


