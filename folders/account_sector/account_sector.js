$(document).ready(function () {
	init_datatable(table_id,form_name,action);

});

var company_name 	= sessionStorage.getItem("company_name");
var company_address	= sessionStorage.getItem("company_name");
var company_phone 	= sessionStorage.getItem("company_name");
var company_email 	= sessionStorage.getItem("company_name");
var company_logo 	= sessionStorage.getItem("company_name");

var form_name 		= 'Account Sector';
var form_header		= '';
var form_footer 	= '';
var table_name 		= '';
var table_id 		= 'account_sector_datatable';
var action 			= "datatable";

function account_sector_cu(unique_id = "") {

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
					url 	= '';
                    $(".createupdate_btn").text("Error");
                    console.log(error);
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


function init_datatable(table_id = '', form_name = '', action = '') {
	if ($.fn.DataTable.isDataTable('#' + table_id)) {
        $('#' + table_id).DataTable().destroy(); // Destroy previous instance
    }
    var table_id 		= 'account_sector_datatable';
    var table = $("#" + table_id);
   
    var screen_id_val = $('#screen_id_val').val();
     
    var user_type_unique_id = $('#user_type_unique_id').val();
  

    var data = {
        "action": action,
        "screen_id_val": screen_id_val,
        "usertype": user_type_unique_id
    };

    var ajax_url = sessionStorage.getItem("folder_crud_link");
        var url      = sessionStorage.getItem("list_link");

    var datatable = table.DataTable({
        ordering: true,
        searching: true,
		destroy: true,
        responsive: true,
		
        ajax: {
            url: ajax_url,
            type: "POST",
            data: function (d) {
                $.extend(d, data);
            },
            error: function (xhr, error, code) {
                console.error("AJAX Error: ", error);
            }
        },
        columns: [
            { data: "s_no" },
            { data: "sector_name" },
            { data: "is_active" },
            { data: "unique_id" }
        ],
        processing: true,
        serverSide: true,
        order: [[0, 'asc']]
    });
	$('#columnVisibilityForm').on('change', 'input[type="checkbox"]', function() {
		var columnIdx = $(this).data('column');
		var isVisible = $(this).is(':checked');
		datatable.column(columnIdx).visible(isVisible); // Use datatable instead of table
	});
}


function account_sector_delete(unique_id = "") {

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
