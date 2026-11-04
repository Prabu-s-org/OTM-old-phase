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
//  $screen_id = isset($_GET['screen_id']) ? htmlspecialchars($_GET['screen_id']) : '';
$screen_id_val='641ad99a3f61227010';
// print_r($screen_id);
   session_start();
  $user_type_unique_id = $_SESSION['user_type_unique_id'];
  
 echo  $_SESSION["staff_name"];            
                   echo  $_SESSION["state_name"];
                   echo  $_SESSION["district_name"];
  $session_user_name = $_SESSION['user_type_unique_id'];
//   $department_options = department_creation_table();
//   $department_options = select_option($department_options, "Select Department",  $department);
$consignee_district_options = district_name();
$consignee_district_options = select_option($consignee_district_options, "Select Consignee District");

  ?>

  <!-- start page titleN -->
  <div class="row">
     <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
           <h4 class="mb-sm-0">Vendor Followups</h4>
           <input type="hidden" id="screen_id_val" name="screen_id_val" class="form-control" value="<?php echo $screen_id_val;?>">
                <input type="hidden" id="user_type_unique_id" name="user_type_unique_id" class="form-control" value="<?php echo $user_type_unique_id;?>">

           <div class="page-title-right">
              <ol class="breadcrumb m-0">
                 <li class="breadcrumb-item"><a href="javascript: void(0);">Forms</a></li>
                 <li class="breadcrumb-item active">Vendor Followups</li>
              </ol>
           </div>

        </div>
       <div>
        <!-- <button type="button" id="export" name="export" class="btn btn-primary  waves-effect waves-light wavw  mb-2 mt-2">-->
        <!-- <i class="ri-file-excel-2-fill"></i>-->
        <!--</button>-->
     </div>
     </div>
  </div>


  <div class="card">
     <div class="card-body">
        <div class="col-12">
       <!-- <a href="index.php?file=installation/installation_sublist"  -->
       <!-- class="btn btn-primary waves-effect waves-light" style="float: right;">Refresh</a>  -->

           <ul class="nav nav-pills arrow-navtabs 	  bg-light mb-3" role="tablist">
              <li class="nav-item" >
                 <a class="nav-link active" data-bs-toggle="tab" href="#arrow-overview" role="tab">
                    <span class="d-block d-sm-none"><i class="mdi mdi-home-variant"></i></span>
                    <span class="d-none d-sm-block"> Followups</span>
                 </a>
              </li>
              <!-- <li class="nav-item">
                                            <a class="nav-link" data-bs-toggle="tab" href="#arrow-profile" role="tab">
                                                <span class="d-block d-sm-none"><i class="mdi mdi-account"></i></span>
                                                <span class="d-none d-sm-block">Installation Completed Details</span>
                                            </a>
                                        </li>-->
              <li class="nav-item" onclick="sub_list_datatable()">
                 <a class="nav-link" data-bs-toggle="tab" href="#arrow-contact" role="tab">
                    <span class="d-block d-sm-none"><i class="mdi mdi-email"></i></span>
                    <span class="d-none d-sm-block">Vendor Billing Terms</span>
                 </a>
              </li>
           </ul>
           <!-- Tab panes -->
           <div class="tab-content">
              <div class="tab-pane active" id="arrow-overview" role="tabpanel">
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
                  <!--<div class="col-md-3">-->
                  <!--   <div class="mb-3">-->
                  <!--      <select  id="opt" name="opt" class="select2 form-control">-->
                  <!--         <option value="">Select Date</option>-->
                  <!--         <option value="4">PO Date</option>-->
                  <!--         <option value="5">Invoice Date</option>-->
                           <!-- <option value="6">Due Date</option> -->
                  <!--      </select>-->
                  <!--   </div>-->
                  <!--</div>-->
                  <!-- <div class="col-md-3">
                     <div class="mb-3">
                   <label class="form-label">Department</label>
                  <select class="select2 form-control" id="department"  name="department" required> 
                  <?php echo $department_options;?>
                  </select>
                  </div>
</div> -->
               <!--<div class="col-md-3">-->
               <!--      <div class="mb-3">-->
               <!--    <label class="form-label">Consignee District</label>-->
               <!--   <select class="select2 form-control" id="con_district"  name="con_district" required> -->
               <!--   <?php echo $consignee_district_options;?>-->
               <!--   </select>-->
               <!--   </div>-->
               <!--  </div>-->
                  <!--<div class="col-md-3">-->
                  <!--   <div class="mb-3">-->
                  <!--      <label class="form-label">Result Filter</label>-->
                  <!--      <select name="installation_status" id="installation_status" class="select2 form-control"-->
                  <!--         required>-->
                  <!--         <option value="">All</option>-->
                  <!--              <option value="3">Rejected</option>-->
                  <!--              <option value="0">Pending</option>-->
                  <!--              <option value="4">Call Assigned</option>-->
                  <!--              <option value="5">Partial Completed</option>-->
                  <!--              <option value="1">SNR</option>-->
                  <!--              <option value="2">Completed</option>-->
                           

                  <!--      </select>-->

                  <!--   </div>-->

                  <!--</div>-->
                 
                  <div class="col-md-1">
                     <div class="mb-3">

                        <button type="button" class="btn btn-primary btn-lg" onclick="get_data()">Go</button>
                     </div>
                  </div>

               </div>
               <div id="list">
                  <div class="table-responsive">
                  <!-- <div class="col-md-3">
                        <div class="mb-3">
                            <label class="form-label">Result Filter</label>
                            <select name="installation_status" id="installation_status" class="select2 form-control" onchange="get_data_install(this.value)" required>
                                <option value="">All</option>
                                <option value="3">Rejected</option>
                                <option value="0">Pending</option>
                                <option value="1">Processing</option>
                                <option value="2">Completed</option>
                            </select>
                        </div>
                    </div> -->
                    <button type="button" id="export1" name="export1" class="btn btn-primary  waves-effect waves-light wavw  mb-2 mt-2" >
         <i class="ri-file-excel-2-fill"></i>
        </button>
        
                 <table id="vendor_followups_datatable" class="table table-bordered table-striped align-middle">
                    <thead>
                                        <tr>
                                       <th>S.No</th>
                                       <th>PO Number </th>
                                       <th>PO Date </th>
                                       <th>State</th>
                                       <th>District</th>
                                       <th>Department </th>
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
              <!-- <div class="tab-pane" id="arrow-profile" role="tabpanel">
                                            
                                        </div>-->
              <div class="tab-pane" id="arrow-contact" role="tabpanel">
              <div class="row align-items-end">
                  <div class="col-md-3">
                     <div class="mb-3">
                        <label class="form-label from-date-label">Zone</label> &nbsp; &nbsp; &nbsp;<b>North</b>
                        </div>
                      
                        
                     
                  </div>
                  <div class="col-md-3">
                     <div class="mb-3">
                        <label class="form-label from-date-label">Vendor Name</label> &nbsp; &nbsp; &nbsp;<b>Jeeva</b>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="mb-3">
                    <label class="form-label from-date-label">Vendor Region</label> &nbsp; &nbsp; &nbsp;<b>Erode</b>

                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="mb-3">
                   <label class="form-label">Consignee District</label>
                  <select class="select2 form-control" id="con_district_dc"  name="con_district_dc" required> 
                  <?php echo $consignee_district_options;?>
                  </select>
                  </div>
                 </div>
                  <div class="col-md-3">
                     <div class="mb-3">
                        <label class="form-label">Result Filter</label>
                        <select name="dc_delivery_status" id="dc_delivery_status" class="select2 form-control" required>
                           <option value="">All</option>
                           <option value="0">Pending</option>
                           <option value="1">SNR</option>
                           <option value="5">Partial Completed</option>
                           <option value="3">Completed</option>
                          

                        </select>
                     </div>
                  </div>
                  <div class="col-md-1">
                     <div class="mb-3">
                        <button type="button" class="btn btn-primary btn-lg" onclick="get_data_dc()">Go</button>
                     </div>
                  </div>
               </div>
               <div id="list_1">
                 <div class="table-responsive">
                 <!-- <div class="col-md-3">
                        <div class="mb-3">
                            <label class="form-label">Result Filter</label>
                            <select name="dc_delivery_status" id="dc_delivery_status" class="select2 form-control" onchange="get_data(this.value)" required>
                                <option value="">All</option>
                                <option value="0">Pending</option>
                                <option value="1">Processing</option>
                                <option value="3">Completed</option>
                                </select>
                        </div>
                    </div> -->
                    <button type="button" id="export2" name="export2" class="btn btn-primary  waves-effect waves-light wavw  mb-2 mt-2" >
         <i class="ri-file-excel-2-fill"></i>
        </button>
                 <table id="dc_ir_dispatch_datatable" class="table table-bordered table-striped align-middle">
                    <thead>
                       <tr>
                          <th>S.No</th>
                          <th>PO Number </th>
                          <!-- <th>PO Date </th> -->
                          <!-- <th>Department</th> -->
                          <th>Ledger Name</th>
                          <th>Consignee District</th>
                          <th>Location </th>
                          <th>Invoice No</th>
                          <th>Invoice Date</th>
                          <th>Invoice Value</th>
                          <th>Engineer Name</th>
                          <th>Call Assign Date</th>
                          <th>Status</th>
                          <th>Action</th>
                       </tr>
                    </thead>
                    <tbody>
                       <!--<tr>-->
                       <!--   <td>01</td>-->
                       <!--   <td>ELT-001</td>-->
                       <!--   <td>30-10-2023</td>-->
                       <!--   <td>ABC Infotech </td>-->
                       <!--   <td>Chennai</td>-->
                       <!--   <td>4422</td>-->
                       <!--   <td>03-01-2023</td>-->
                       <!--   <td>Pending</td>-->


                       <!--   <td>-->
                       <!--      <a href="index.php?file=installation/create1">-->
                       <!--         <i class="mdi mdi-square-edit-outline mdi-24px waves-effect waves-light mt-n2 mb-n2 text-green"></i>-->
                       <!--      </a>-->
                       <!--   </td>-->
                       <!--</tr>-->

                    </tbody>
                 </table>
                 </div>
              </div>
              </div>

           </div>
           <!--end col-->
        </div>
        <!--end row-->
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
                <button type="button" class="btn btn-primary" id="saveColumnVisibility">Save Changes</button>
            </div>
        </div>
    </div>
</div>
  <script>
      $("#export").click(function(){
    // alert("hi");
    window.location="folders/installation/excel.php";
    });
  </script>
  <script>
      $("#export1").click(function(){
        
         var from_date = $('#from_date').val();
         var to_date = $('#to_date').val();
         var opt = $('#opt').val();
         var installation_status = $('#installation_status').val();


    // alert("hi");
    window.location="folders/installation/excel1.php?from_date="+from_date+"&to_date="+to_date+"&opt="+opt+"&installation_status="+installation_status;
    });


    //tab 2
    $("#export2").click(function(){
        
   var from_date_dc = $("#from_date_dc").val();
  var to_date_dc = $("#to_date_dc").val();
  var opt1 = $("#opt1").val();
  var dc_delivery_status = $("#dc_delivery_status").val();

   // alert("hi");
   window.location="folders/installation/excel2.php?from_date="+from_date_dc+"&to_date="+to_date_dc+"&opt1="+opt1+"&dc_delivery_status="+dc_delivery_status;
   });
  </script>
  <script>
   //    $("#export2").click(function(){
   //  // alert("hi");
   //  window.location="folders/installation/excel2.php";
   //  });
    
$(document).ready(function () {
	
   get_user_permission();
	get_user_permission_1();
});


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
// 
	console.log(data);
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
// alert(screen_id_val);
	var user_type_unique_id = $('#user_type_unique_id').val();

	var data = {
		"screen_id_val": screen_id_val,
		"user_type_unique_id": user_type_unique_id,
		"action": 'user_permission_1',
	};

	var ajax_url = sessionStorage.getItem("folder_crud_link");
	var url = sessionStorage.getItem("list_link");
// 
	console.log(data);
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
