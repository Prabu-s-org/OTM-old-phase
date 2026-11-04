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
#lbs{
    font-size: 16px;
    font-weight: bold;
}
.spans{
    color: #1a7db7;
    font-size: 13px;
    font-weight: unset;
}
#po_no_datatable {
        border: 1px solid black; /* Bold black border for the table */
    }
    
    #po_no_datatable th,
    #po_no_datatable td {
        border: 1px solid black; /* Bold black border for table cells */
    }

    #po_no_datatable thead th {
        background-color: #f8f9fa; /* Optional: Light background for header */
    }

  
    /* Ensure the table's borders collapse properly */
    #po_no_datatable {
        border-collapse: collapse; 
    }
    #invoice_datatable {
        border: 1px solid black; /* Bold black border for the table */
    }
    #invoice_datatable th,
    #invoice_datatable td {
        border: 1px solid black; /* Bold black border for table cells */
    }

    #invoice_datatable thead th {
        background-color: #f8f9fa; /* Optional: Light background for header */
    }

  

</style>
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
           <h4 class="mb-sm-0"> PO Report</h4>


           <input type="hidden" id="screen_id_val" name="screen_id_val" class="form-control" value="<?php echo $screen_id_val;?>">
            <input type="hidden" id="user_type_unique_id" name="user_type_unique_id" class="form-control" value="<?php echo $user_type_unique_id;?>">

           <div class="page-title-right">
              <ol class="breadcrumb m-0">
                 <li class="breadcrumb-item"><a href="javascript: void(0);">Reports</a></li>
                 <li class="breadcrumb-item active"> PO Report</li>
              </ol>
           </div>

        </div>
     </div>
  </div>
<div class="row mt-2 po-class">

   <?php include 'filter.php';?>
     
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
                        <span class="d-none d-sm-block">Po Report</span>
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
               <div class="col-4">
                  <div class="mb-3">
                     <!-- <label class="form-label from-date-label" id="lbs">From Date : <span id="val1" class="spans"></span></label> -->
                     <label class="form-label from-date-label" id="lbs">Po Numbers : <span id="val1" class="spans"></span></label>
                     
                  </div>
               </div>
               <div class="col-4">
                  <div class="mb-3">
                     <!-- <label class="form-label from-date-label" id="lbs">To Date : <span id="val2" class="spans"></span></label> -->
                     <label class="form-label from-date-label" id="lbs">Po Date : <span id="val2" class="spans"></span></label>
                     
                  </div>
               </div>
            </div>
                <div class="row align-items-end">
               <div class="col-4">
                  <div class="mb-3">
                     <label class="form-label from-date-label" id="lbs">Department Name : <span id="val3" class="spans"></span></label>
                     
                  </div>
               </div>
               <div class="col-4">
                  <div class="mb-3">
                  <label class="form-label from-date-label" id="lbs">Executive Name : <span id="val4" class="spans"></span></label>
                     
                  </div>
               </div>
        </div>
 
  <div class="table-responsive" id="po_no_table">
    <h4>Report PO Item </h4>
    <table id="po_no_datatable" class="table table-bordered table-striped align-middle">
        <thead>
            <tr>
                <th>S.No</th>
                <th>Item Code</th>
                <th>Item Description</th>
                <th>Qty</th>
                <th>Unit Price</th>
                <th>Total Value</th>
                <th>Total Value with GST</th>
                <th>Due Days </th>
                <th>Warranty</th>
              
            </tr>
        </thead>
        <tbody id="no_data">
            <tr>
                <td colspan="9" style="text-align: center;">No Data Found!</td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" style="text-align: center;"><b>Total</b></td>
                
                <td style="text-align: right;">
                    <b class="header font-weight-bold d-inline" id="total_no_of_qty" style="font-size: 13px;"></b>
                </td>
                <td style="text-align: right;">
                    <b class="header font-weight-bold d-inline" id="" style="font-size: 13px;"></b>
                </td>
                <td style="text-align: right;">
                    <b class="header font-weight-bold d-inline" id="without_tax_amount" style="font-size: 13px;"></b>
                </td>
                <td style="text-align: right;">
                    <b class="header font-weight-bold d-inline" id="with_tax_amount" style="font-size: 13px;"></b>
                </td>
              
                <td style="text-align: right;">
                    <b class="header font-weight-bold d-inline" id="total_due_days" style="font-size: 13px;"></b>
                </td>
            </tr>
                                    </tfoot>
                                   
                                    </table>
                                </div>
                        
<div class="table-responsive">
    <h4>Report On Consignee Details</h4>
    <table id="invoice_datatable" class="table table-bordered table-striped align-middle">
        <thead>
            <tr>
                <th>S.No</th>
                <th>Address </th>
                <th>District</th> 
                <!-- <th>District</th> -->
                <!-- <th>Item Code</th> -->
                <!-- <th>Item Description</th> -->
                <th>Item Code</th>
                <th>Item Description</th>
                <th>PO Qty</th>
                <th>Invoice Qty</th>
                <th>Invoice No</th>
                <th>Invoice Date</th>
                <th>Form Wise Status</th>
                <th>Payment Status</th>
                <th>Ageing</th>
            </tr>
        </thead>
        <tbody id="no_data">
            <tr>
                <td colspan="9" style="text-align: center;">No Data Found!</td>
            </tr>
        </tbody>
        <tfoot>
            <!-- <tr>
                <td colspan="5" style="text-align: center;"><b>Total</b></td>
                <td style="text-align: right;">
                    <b class="header font-weight-bold d-inline" id="total_no_of_cus_qty" style="font-size: 13px;"></b>
                </td>
                <td style="text-align: right;">
                    <b class="header font-weight-bold d-inline" id="without_tax_amount_customer" style="font-size: 13px;"></b>
                </td>
            </tr> -->
        </tfoot>
    </table>
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
<script>

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


  </script>
