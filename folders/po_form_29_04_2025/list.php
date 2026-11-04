<style>
    i.fa.fa-edit {
        font-size: 20px;
        color: green;
    }
    i.fa-sharp.fa-solid.fa-trash {
        font-size: 20px;
        color: green;
    }
button#export {
    float: right;
    padding: 5px 10px;
}
table.dataTable.nowrap td {
    white-space: unset;
}
span.po_date {
    white-space: nowrap;
}
span.invoice_date {
    white-space: nowrap;
}
</style>
<!-- <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.jqueryui.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.2.2/css/buttons.jqueryui.css"> -->

<?php
//  $screen_id = isset($_GET['screen_id']) ? htmlspecialchars($_GET['screen_id']) : '';
$screen_id_val='641ad5b47d02a30030';
// print_r($screen_id);
   session_start();
  $user_type_unique_id = $_SESSION['user_type_unique_id'];
  ?>
<!-- start page title -->
<div class="row">
     <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
           <h4 class="mb-sm-0"> PO List</h4>


           <input type="hidden" id="screen_id_val" name="screen_id_val" class="form-control" value="<?php echo $screen_id_val;?>">
            <input type="hidden" id="user_type_unique_id" name="user_type_unique_id" class="form-control" value="<?php echo $user_type_unique_id;?>">

           <div class="page-title-right">
              <ol class="breadcrumb m-0">
                 <li class="breadcrumb-item"><a href="javascript: void(0);">Forms</a></li>
                 <li class="breadcrumb-item active"> PO List</li>
              </ol>
           </div>

        </div>
     </div>
  </div>
<div class="row mt-2 po-class">
  <div class="col-md-4">

<div class="input-group">
   <!-- value="<?php echo date('Y-m'); ?>" -->
<input type="month" id="month_fill" name="month_fill" class="form-control">
                                    <!-- <input class="form-control" id="month_fill" type="month" name="month" value="2024-05"> -->
                                    <!-- <input type="date" value="03" class="form-control form-control-light" > -->
                                    <!-- <input type="text" class="form-control form-control-light" id="dash-daterange">  -->
                                    <!-- <span class="input-group-text thme-colo  border-primary text-white"> -->
                                    <!-- <i class="mdi mdi-calendar-range font-13"></i> -->
                                    <!-- <button type="button" id="date_filter" name="date_filter" class="input-group-text thme-colo  border-primary text-white">GO</button> -->
                                    <button type="button" id="date_filter" name="date_filter" class="input-group-text thme-colo btn btn-primary border-primary text-white" 
                                     onclick="get_data_month()"
                                    >GO</button>
                                </div>
</div>

<div class="col-md-5"></div>
      
     <div class="col-md-3 mb-1 d-grid gap-2 d-md-flex justify-content-md-end btn-green ">
        <?php echo btn_add($btn_add); ?>
        <div class="">
        <!--<button type="button" id="export" name="export" class="btn btn-primary  waves-effect waves-light wavw  mb-1">-->
        <!-- <i class="ri-file-excel-2-fill"></i>-->
        <!--</button>-->
     </div>
     </div>
     
  </div>

<!----content start---------->
<div class="col-xxl-12">
    <div class="card">
        <div class="card-body">
            <ul class="nav nav-pills arrow-navtabs  bg-light mb-3" role="tablist">
                <li class="nav-item" >
                    <!--onclick="dispatch_pending()"-->
                    <a class="nav-link active" data-bs-toggle="tab" href="#arrow-overview" role="tab">
                        <span class="d-block d-sm-none"><i class="mdi mdi-home-variant"></i></span>
                        <span class="d-none d-sm-block">Po List</span>
                    </a>
                </li>
                <li class="nav-item" >
                    <!--onclick="dispatch_transist()"-->
                    <a class="nav-link" data-bs-toggle="tab" href="#arrow-profile" role="tab">
                        <span class="d-block d-sm-none"><i class="mdi mdi-account"></i></span>
                        <span class="d-none d-sm-block">Po Cancel List</span>
                    </a>
                </li>
               
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane active" id="arrow-overview" role="tabpanel">
                <div class="row" id="list">
                        <div class="col-12">
                            <div class="">
                                <div class="card-body">
                                <div class="row align-items-end">
               <div class="col-md-3">
                  <div class="mb-3">
                     <label class="form-label from-date-label">From Date</label>
                     <input type="date" class="form-control" id="from_date" name="from_date">
                   
                  </div>
               </div>
               <div class="col-md-3">
                  <div class="mb-3">
                     <label class="form-label from-date-label">To Date</label>
                     <input type="date" class="form-control" id="to_date" name="to_date">
                  </div>
               </div>

               <div class="col-md-1">
                  <div class="mb-3">

                     <button type="button" class="btn btn-primary btn-lg" onclick="get_data()">Go</button>
                  </div>
                  <button type="button" id="export1" name="export1" class="btn btn-primary  waves-effect waves-light wavw  mb-1">
         <i class="ri-file-excel-2-fill"></i>
        </button>
               </div>
            </div>
          
                                    <div class="table-responsive">
                                    <table id="po_form_datatable" class="table table-bordered table-striped align-middle">
                                        <thead>
                                        <tr>
                                       <th>S.No</th>
                                       <th>PO Number </th>
                                       <th>PO Date </th>
                                       <th>State</th>
                                       <th>District</th>
                                       <th>Customer </th>
                                       <th>Customer GST Number </th>
                                       <th>Executive Name</th>
                                       <th>PO Total Value</th>
                                       <th>PO Attachment</th>
                                       <th>PO Cancel</th>
                                       <th>Action</th>
                                       
                                    </tr>
                                        </thead>
                                        <tbody>
                                           
                                        </tbody>
                                    </table>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!----content start---------->
                    <!--  Extra Large modal example -->
                 </div>
                <!-- fixed-header  -->
                <div class="tab-pane" id="arrow-profile" role="tabpanel">
                    <div class="row">
                        <div class="col-12">
                            <div class="">
                                <div class="card-body">
                                <!-- <button type="button" id="export2" name="export2" class="btn btn-primary  waves-effect waves-light wavw  mb-2 mt-2">
         <i class="ri-file-excel-2-fill"></i>
        </button> -->
                             <div id="list_1">
                                    <div class="table-responsive">
                                        <table id="po_cancel_datatable" class="table table-bordered table-striped align-middle">
                                            <thead>
                                            <tr>
                                       <th>S.No</th>
                                       <th>PO Number </th>
                                       <th>PO Date </th>
                                       <th>State Name</th>
                                       <th>District Name</th>
                                       <th>Customer </th>
                                       <th>Customer GST Number </th>
                                       <th>Executive Name</th>
                                       <th>PO Total Value</th>
                                       <th>PO Cancel Attachment</th>
                                       <!-- <th>Action</th> -->
                                    </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                   
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div> 
                <!----content start---------->
            </div>
        </div><!-- end card-body -->
    </div><!-- end card -->
</div>
<!--end col-->
</div>
<!--end row-->
<!-- Page content Ends Here -->
</div>
</div>
</div>


<!-- Column Visibility Modal -->
<div id="columnVisibilityModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg"> <!-- Center the modal and make it large -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Select Columns to Display</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="columnVisibilityForm">
                    <!-- Dynamically populated checkboxes will go here -->
                    <div class="row">
                        <!-- Each column will have a checkbox -->
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <!--<button type="button" class="btn btn-primary" id="saveColumnVisibility">Save Changes</button>-->
            </div>
        </div>
    </div>
</div>
<script>
//   window.addEventListener('DOMContentLoaded', function () {
//     //   alert();
//     const today = new Date().toISOString().split('T')[0];
//     document.getElementById('from_date').value = today;
//     document.getElementById('to_date').value = today;
//   });
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<!-- <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.jqueryui.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.2/js/dataTables.buttons.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.2/js/buttons.jqueryui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.2/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.2/js/buttons.colVis.min.js"></script> -->
<!--<input type="date" class="form-control" id="from_date" name="from_date">-->




<script>
    
      $("#export").click(function(){
    // alert("hi");
    window.location="folders/po_form/excel.php";
    });
    $("#export1").click(function(){
        
        var from_date = $('#from_date').val();
        // alert(from_date);
        var to_date = $('#to_date').val();
        // alert(to_date);
        // var month_fill = $('#month_fill').val();
   window.location="folders/po_form/excel1.php?from_date="+from_date+"&to_date="+to_date;
});
    function print_pdf_1(file_name)
{
    
 onmouseover=window.open('uploads/po_form/po_attach/' + file_name,'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
}

// function print_pdf_1(file_name)
// {
    
//  onmouseover=window.open('uploads/po_form/po_attach/' + file_name,'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
// }

$(document).ready(function () {
      // var table_id 	= "user_type_datatable";
      // init_datatable(table_id,form_name,action);
    //   alert("hiii");
      new DataTable('#po_form_datatable', {
    layout: {
        topStart: {
            buttons: ['copy', 'excel', 'pdf', 'colvis']
        }
    }
});
      get_data();
    //   get_data_month();
      sub_list_datatable('po_cancel_datatable', form_name, 'po_cancel_datatable');
	// sub_list_datatable('po_cancel_datatable', form_name, 'po_cancel_datatable');
    // get_user_permission();
    // get_user_permission_1();

   });

   function get_data() {
    // alert("hii");
      document.getElementById('month_fill').value = '';

      init_datatable(table_id, form_name, action);
   }
   function get_data_month() {

      document.getElementById('from_date').value = '';
      document.getElementById('to_date').value = '';

      init_datatable(table_id, form_name, action);
   }


   function init_datatable(table_id = '', form_name = '', action = '') {
// alert("cfvgbhn");
      var table = $("#" + table_id);
      var action = 'datatable';
    //   alert(action);
      var month_fill = $('#month_fill').val();
      var from_date = $("#from_date").val();
      var to_date = $("#to_date").val();
      var screen_id_val = $('#screen_id_val').val();

	// alert(screen_id_val);
	var user_type_unique_id = $('#user_type_unique_id').val();
    // alert(user_type_unique_id);

      if (month_fill != '') {
        // alert("i am if");
         var data = {
            "month_fill": month_fill,
            "action": action,
            "screen_id_val": screen_id_val,
		    "user_type_unique_id": user_type_unique_id,
         };
         var ajax_url = sessionStorage.getItem("folder_crud_link");

         var datatable = table.DataTable({
            destroy: true,
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
            { data: "po_num" },
			{ data: "po_date" },
            { data: "state_name" },
            { data: "district_name" },
            { data: "department" },
			{ data: "gst_value" },
            { data: "executive_name" },
			{ data: "total_value" },
			{ data: "file_name" },
			
            // { data: "gst_value" },
            { data: "po_count" },
// 			{ data: "is_active" },
            { data: "unique_id" }
        ]
    });

      } 
      else if(from_date!='' && to_date!='') {
        // alert("i am elseif");
         var data = {
            "action": action,
            "from_date": from_date,
            "to_date": to_date,
            "screen_id_val": screen_id_val,
		    "user_type_unique_id": user_type_unique_id,
         };
         var ajax_url = sessionStorage.getItem("folder_crud_link");

         var datatable = table.DataTable({
            destroy: true,
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
            { data: "po_num" },
			{ data: "po_date" },
            { data: "state_name" },
            { data: "district_name" },
            { data: "department" },
			{ data: "gst_value" },
            { data: "executive_name" },
			{ data: "total_value" },
			{ data: "file_name" },
            // { data: "gst_value" },
            { data: "po_count" },
// 			{ data: "is_active" },
            { data: "unique_id" }
        ]
    });
      }
      else {
        // alert("i am else");
         var data = {
            "action": action,
            "from_date": from_date,
            "to_date": to_date,
            "screen_id_val": screen_id_val,
		    "user_type_unique_id": user_type_unique_id,
         };
         var ajax_url = sessionStorage.getItem("folder_crud_link");

         var datatable = table.DataTable({
            destroy: true,
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
            { data: "po_num" },
			{ data: "po_date" },
            { data: "state_name" },
            { data: "district_name" },
            { data: "department" },
			{ data: "gst_value" },
            { data: "executive_name" },
			{ data: "total_value" },
			{ data: "file_name" },
            // { data: "gst_value" },
            { data: "po_count" },
// 			{ data: "is_active" },
            { data: "unique_id" }
        ]
    });
      }
      $('#columnVisibilityForm').on('change', 'input[type="checkbox"]', function() {
        var columnIdx = $(this).data('column');
        var isVisible = $(this).is(':checked');
        datatable.column(columnIdx).visible(isVisible); // Use datatable instead of table
    });

   }
   
   function get_user_permission() {
	var screen_id_val = $('#screen_id_val').val();
// alert(screen_id_val);
	var user_type_unique_id = $('#user_type_unique_id').val();
// alert(user_type_unique_id);
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
function get_user_permission_1() {
	var screen_id_val = $('#screen_id_val').val();

	var user_type_unique_id = $('#user_type_unique_id').val();

	var data = {
		"screen_id_val": screen_id_val,
		"user_type_unique_id": user_type_unique_id,
		"action": 'user_permission_1',
	};

	var ajax_url = sessionStorage.getItem("folder_crud_link");
	var url = sessionStorage.getItem("list_link");

	// console.log(data);
	$.ajax({
		type: "POST",
		url: ajax_url,
		data: data,
		success: function (data) {
alert(data);
			var obj = JSON.parse(data);

			var dataString = obj.data;

			// console.log(dataString);

			// var addButton = document.getElementById('add_btn');
			// if (dataString.includes('5f8807ff00bf726601')) {
			// 	addButton.style.visibility = 'visible';  // Show the button
			// } else {
			// 	addButton.style.visibility = 'hidden';   // Hide the button but keep its space
			// }
			var listpage = document.getElementById('list_1');
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

   function sub_list_datatable(table_id = "", form_name = "", action = "") {
	// alert();
	// alert('hii');
	// var po_cancel_datatable = $("#demo").val();
	var table_id = 'po_cancel_datatable';
	// alert(table_id);
	var table = $("#" + table_id);
	var data = {

		"action": 'po_cancel_datatable',
	};
	var ajax_url = sessionStorage.getItem("folder_crud_link");
	var datatable = table.DataTable({
        destroy: true,
		ordering: true,
		searching: true,
		"ajax": {
			url: ajax_url,
			type: "POST",
			data: data
		},
            dom: 'Bfrtip',
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
        ]
	});
    $('#columnVisibilityForm').on('change', 'input[type="checkbox"]', function() {
        var columnIdx = $(this).data('column');
        var isVisible = $(this).is(':checked');
        datatable.column(columnIdx).visible(isVisible); // Use datatable instead of table
    });
}

  </script>
  

