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

</style>
<?php 
//   $screen_id = isset($_GET['screen_id']) ? htmlspecialchars($_GET['screen_id']) : '';
$screen_id_val ='641adb14666c465380';
   session_start();
  $user_type_unique_id = $_SESSION['user_type_unique_id'];
  ?>
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Payment</h4>
            <input type="hidden" id="screen_id_val" name="screen_id_val" class="form-control" value="<?php echo $screen_id_val;?>">
            <input type="hidden" id="user_type_unique_id" name="user_type_unique_id" class="form-control" value="<?php echo $user_type_unique_id;?>">

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Form</a></li>
                    <li class="breadcrumb-item active">Payment</li>
                </ol>
            </div>
        </div>
        <div>
         <button type="button" id="export" name="export" class="btn btn-primary  waves-effect waves-light wavw  mb-2 mt-2">
         <i class="ri-file-excel-2-fill"></i>
        </button>
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
                        <span class="d-none d-sm-block">Pending</span>
                    </a>
                </li>
                <!-- <li class="nav-item" > -->
                    <!--onclick="dispatch_pending()"-->
                    <!-- <a class="nav-link " data-bs-toggle="tab" href="#arrow-pending" role="tab">
                        <span class="d-block d-sm-none"><i class="mdi mdi-account"></i></span>
                        <span class="d-none d-sm-block">Pending 25%</span>
                    </a>
                </li>
                <li class="nav-item" > -->
                    <!--onclick="dispatch_pending()"-->
                    <!-- <a class="nav-link " data-bs-toggle="tab" href="#arrow-remaining" role="tab">
                        <span class="d-block d-sm-none"><i class="mdi mdi-account"></i></span>
                        <span class="d-none d-sm-block">Pending 5%</span>
                    </a>
                </li> -->
                <!-- <li class="nav-item" > -->
                    <!--onclick="dispatch_transist()"-->
                    <!-- <a class="nav-link" data-bs-toggle="tab" href="#arrow-profile" role="tab">
                        <span class="d-block d-sm-none"><i class="mdi mdi-account"></i></span>
                        <span class="d-none d-sm-block">Partially Completed</span>
                    </a>
                </li> -->
                <!-- <li class="nav-item" > -->
                    <!--onclick="dispatch_delivery()"-->
                    <!-- <a class="nav-link" data-bs-toggle="tab" href="#arrow-contact" role="tab">
                        <span class="d-block d-sm-none"><i class="mdi mdi-email"></i></span>
                        <span class="d-none d-sm-block">Completed</span>
                    </a> -->
                <!-- </li> -->
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane active" id="arrow-overview" role="tabpanel">
                    <div class="row">
                        <div class="col-12">
                            <div class="">
                                <div class="card-body">
                                <div class="row align-items-end">
            <div class="col-md-3">
                <div class="mb-3">
                    <label class="form-label from-date-label">From Date</label>
                    <input type="date" class="form-control" id="from_date" name="from_date"
                        >
                </div>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <label class="form-label from-date-label">To Date</label>
                    <input type="date" class="form-control" id="to_date" name="to_date"
                       >
                </div>
            </div>
            <div class="col-md-3">
            <div class="mb-3">
            <select class="form-select mb-3"  id="opt" name="opt">
               <option value=""></option>
               <option value="4">PO Date</option>
               <option value="5">Invoice Date</option>
               <option value="6">Payment Date</option>
               <option value="7">Bill Submission Date</option>
            </select>
            </div>
            </div>
            <div class="col-md-1">
                <div class="mb-3">

                    <button type="button" class="btn btn-primary btn-lg" onclick="get_data()">Go</button>
                </div>
            </div>
        </div>
        <div id="list">
                                    <div class="table-responsive">
                                    <table id="payment_datatable" class="table table-bordered table-striped align-middle">
                                        <thead>
                                                   <tr>
                                                   <th>S.No</th>
                                                   <th>PO Number </th>
                                                   <th>PO Date </th>
                                                   <!-- <th>Consignee </th> -->
                                                   <!-- <th>Location</th> -->
                                                   <th>Invoice No</th>
                                                   <th>Invoice Date</th>
                                                   <th>Invoice Value</th>
                                                   <th>Ledger Name</th>
                                                   <th>Ledger No</th>
                                                   <th>Bill Submission Date</th>
                                                    <th>Claim %</th>
                                                   <th>Claim Amount</th>
                                                   <th>E No</th>
                                                   <!-- <th>LD Days </th> -->
                                                   <th>LD Value </th>
                                                   <!-- <th>DC signed Date</th> -->
                                                   <!-- <th>Delivery Due Day</th> -->
                                                   <th>Payment Received</th>
                                                   <th >Payment Receipt</th>
                                                   <th>Payment Date</th>
                                                   <th>Transcation Amt</th>
                                                   <th>GST %</th>
                                                   <th>GST Value</th>
                                                   <th>Remaining Amt</th>
                                                   <th>Status</th>
                                                   <th>Action</th>
                                             </tr>
                                        </thead>
                                        <tbody>
                                            <!--<tr>-->
                                            <!--    <td>01</td>-->
                                            <!--    <td>001</td>-->
                                            <!--    <td>2023-10-02</td>-->
                                            <!--    <td>Ocean Clothes</td>-->
                                            <!--    <td>Chennai</td>-->
                                            <!--    <td>1000</td>-->
                                            <!--    <td>2023-10-02</td>-->
                                            <!--    <td>-->
                                            <!--        <a data-bs-toggle="modal" data-bs-target=".bs-example-modal-xl">-->
                                            <!--            <i-->
                                            <!--                class="mdi mdi-square-edit-outline mdi-24px waves-effect waves-light mt-n2 mb-n2 text-green"></i>-->
                                            <!--        </a>-->
                                            <!--    </td>-->
                                            <!--</tr>-->
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
                <!-- pending 25% -->
                <div class="tab-pane" id="arrow-pending" role="tabpanel">
                    <div class="row">
                        <div class="col-12">
                            <div class="">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="pending_one_datatable" class="table table-bordered table-striped align-middle">
                                            <thead>
                                            <tr>
                                                   <th>S.No</th>
                                                   <th>PO Number </th>
                                                   <th>PO Date </th>
                                                   <!-- <th>Consignee </th> -->
                                                   <!-- <th>Location</th> -->
                                                   <th>Invoice No</th>
                                                   <th>Invoice Date</th>
                                                   <th>Invoice Value</th>
                                                   <th>Bill Submission Date</th>
                                                   <th>Claim Amount</th>
                                                   <th>E No</th>
                                                   <th>LD Days </th>
                                                   <th>LD Value </th>
                                                   <!-- <th>DC signed Date</th> -->
                                                   <th>Delivery Due Day</th>
                                                   <th>Payment Receivable</th>
                                                   <th>Payment Receipt</th>
                                                   <th>Status</th>
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
                    
                </div>
                <!-- end -->
                <!-- pending 5 -->
                <div class="tab-pane" id="arrow-remaining" role="tabpanel">
                    <div class="row">
                        <div class="col-12">
                            <div class="">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="pending_5_datatable" class="table table-bordered table-striped align-middle">
                                            <thead>
                                            <tr>
                                                   <th>S.No</th>
                                                   <th>PO Number </th>
                                                   <th>PO Date </th>
                                                   <!-- <th>Consignee </th> -->
                                                   <!-- <th>Location</th> -->
                                                   <th>Invoice No</th>
                                                   <th>Invoice Date</th>
                                                   <th>Invoice Value</th>
                                                   <th>Bill Submission Date</th>
                                                   <th>Claim Amount</th>
                                                   <th>E No</th>
                                                   <th>LD Days </th>
                                                   <th>LD Value </th>
                                                   <!-- <th>DC signed Date</th> -->
                                                   <th>Delivery Due Day</th>
                                                   <th>Payment Receivable</th>
                                                   <th>Payment Receipt</th>
                                                   <th>Status</th>
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
                    
                </div>
                <!-- end -->
                <!-- fixed-header  -->
                <div class="tab-pane" id="arrow-profile" role="tabpanel">
                    <div class="row">
                        <div class="col-12">
                            <div class="">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="fixed_datatable" class="table table-bordered table-striped align-middle">
                                            <thead>
                                            <tr>
                                                   <th>S.No</th>
                                                   <th>PO Number </th>
                                                   <th>PO Date </th>
                                                   <!-- <th>Consignee </th> -->
                                                   <!-- <th>Location</th> -->
                                                   <th>Invoice No</th>
                                                   <th>Invoice Date</th>
                                                   <th>Invoice Value</th>
                                                   <th>Bill Submission Date</th>
                                                   <th>Claim Amount</th>
                                                   <th>E No</th>
                                                   <th>LD Days </th>
                                                   <th>LD Value </th>
                                                   <!-- <th>DC signed Date</th> -->
                                                   <th>Delivery Due Day</th>
                                                   <th>Payment Receivable</th>
                                                   <th>Payment Receipt</th>
                                                   <th>Status</th>
                                                   <!-- <th>Action</th> -->
                                             </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <!-- <td>1</td>
                                                    <td>001</td>
                                                    <td>06-11-2023</td>
                                                    <td>Ocean Clothes</td>
                                                    <td>Chennai</td>
                                                    <td>1000</td>
                                                    <td>04-11-2023</td>
                                                    <td> 06-11-2023</td>
                                                    <td>Hand</td>
                                                    <td>ABC Parcel / Mr.Santhosh</td>
                                                    <td>101</td>
                                                    <td>-</td> -->
                                                    <!-- <td>
                                                        <a data-bs-toggle="modal"
                                                            data-bs-target=".bs-example-modal-xl1"><i
                                                                class="mdi mdi-square-edit-outline mdi-24px waves-effect waves-light mt-n2 mb-n2 text-green"></i></a>
                                                    </td> -->
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
                <div class="tab-pane" id="arrow-contact" role="tabpanel">
                    <div class="row">
                        <div class="col-12">
                            <div class="">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="deleivery_datatable" class="table table-bordered table-striped align-middle">
                                            <thead>
                                            <tr>
                                                   <th>S.No</th>
                                                   <th>PO Number </th>
                                                   <th>PO Date </th>
                                                   <!-- <th>Consignee </th> -->
                                                   <!-- <th>Location</th> -->
                                                   <th>Invoice No</th>
                                                   <th>Invoice Date</th>
                                                   <th>Invoice Value</th>
                                                   <th>Bill Submission Date</th>
                                                   <th>Claim Amount</th>
                                                   <th>E No</th>
                                                   <th>LD Days </th>
                                                   <th>LD Value </th>
                                                   <!-- <th>DC signed Date</th> -->
                                                   <th>Delivery Due Day</th>
                                                   <th>Payment Receivable</th>
                                                   <th >Payment Receipt</th>
                                                   <th>Status</th>
                                                   <!-- <th>Action</th> -->
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
                </div>
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
      $("#export").click(function(){
    // alert("hi");
    window.location="folders/payment/excel.php";
    });
    $(document).ready(function () { 
	// var table_id 	= "user_datatable";
	// init_datatable(table_id,form_name,action);
    get_user_permission();

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

			// console.log(dataString);

			// var addButton = document.getElementById('add_btn');
			// if (dataString.includes('5f8807ff00bf726601')) {
			// 	addButton.style.visibility = 'visible';  // Show the button
			// } else {
			// 	addButton.style.visibility = 'hidden';   // Hide the button but keep its space
			// }
			var listpage = document.getElementById('list');
// 			if (dataString.includes('5f88083fd50a344823')) {
// 				listpage.style.visibility = 'visible';  // Show the button
// 			} else {
// 				listpage.style.visibility = 'hidden';   // Hide the button but keep its space
// 			}


		},
		error: function (data) {
			alert("Network Error");
		}
	});
}

  </script>
