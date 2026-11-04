$(document).ready(function () {
	// var table_id 	= "user_type_datatable";
	init_datatable(table_id, form_name, action);
	get_user_permission();
	// sub_list_datatable('print_table',form_name,'print_table');
});

var company_name = sessionStorage.getItem("company_name");
var company_address = sessionStorage.getItem("company_name");
var company_phone = sessionStorage.getItem("company_name");
var company_email = sessionStorage.getItem("company_name");
var company_logo = sessionStorage.getItem("company_name");

var form_name = 'Elcot Entry';
var form_header = '';
var form_footer = '';
var table_name = '';
var table_id = 'bill_submission_datatable';
var action = "datatable";
var table_id_1 = 'print_table';

function init_datatable(table_id = '', form_name = '', action = '') {
	// alert('ji');
	var table = $("#" + table_id);
	var screen_id_val = $('#screen_id_val').val();
	// alert(screen_id_val);
	var user_type_unique_id = $('#user_type_unique_id').val();
	var data = {
		"action": action,
		"screen_id_val": screen_id_val,
		"user_type_unique_id": user_type_unique_id,
	};
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
        // buttons: [
        //     'copy', 'csv', 'excel', 'pdf', 'print'
        // ]
        dom: 'lBfrtip',
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
        autoWidth: false,
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        pageLength: 10,
        // lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        // pageLength: 10 // Default selected value
    });
    $('#columnVisibilityForm').on('change', 'input[type="checkbox"]', function () {
        var columnIdx = $(this).data('column');
        var isVisible = $(this).is(':checked');
        datatable.column(columnIdx).visible(isVisible); // Use datatable instead of table
    });
}


$(document).ready(function () {
	var table = $('#bill_submission_datatable').DataTable();

	// Clear the search input value and redraw the table
	table.search('').draw();

	// Also clear the input box visually if needed
	$('.dataTables_filter input').val('');
});
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

			console.log(dataString);

			var addButton = document.getElementById('add_btn');
			if (dataString.includes('5f8807ff00bf726601')) {
				if (addButton) {
					addButton.style.visibility = 'visible';  // Show the button
				}
			} else {
				if (addButton) {
					addButton.style.visibility = 'hidden';  // Show the button
				}
			}
			var listpage = document.getElementById('list');
			if (dataString.includes('5f88083fd50a344823')) {
				if (listpage) {
					listpage.style.visibility = 'visible';  // Show the button
				}
			} else {
				if (listpage) {
					listpage.style.visibility = 'visible';  // Show the button
				}
			}


		},
		error: function (data) {
			alert("Network Error");
		}
	});
}

function bill_submission_delete(unique_id = "") {

	var ajax_url = sessionStorage.getItem("folder_crud_link");
	var url = sessionStorage.getItem("list_link");

	confirm_delete('delete')
		.then((result) => {
			if (result.isConfirmed) {

				var data = {
					"unique_id": unique_id,
					"action": "delete"
				}

				$.ajax({
					type: "POST",
					url: ajax_url,
					data: data,
					success: function (data) {

						var obj = JSON.parse(data);
						var msg = obj.msg;
						var status = obj.status;
						var error = obj.error;

						if (!status) {
							url = '';

						} else {
							init_datatable(table_id, form_name, action);
						}
						sweetalert(msg, url);
					}
				});

			} else {
				// alert("cancel");
			}
		});
}

