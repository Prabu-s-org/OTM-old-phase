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
$screen_id_val = '641ad99a3f61227010';
// print_r($screen_id);
session_start();
$user_type_unique_id = $_SESSION['user_type_unique_id'];

//   $department_options = department_creation_table();=
//   $department_options = select_option($department_options, "Select Department",  $department);
$consignee_district_options = district_name();
$consignee_district_options = select_option($consignee_district_options, "Select Consignee District");

?>
<?php
$staff_ids = $_SESSION['staff_id'];

//  echo $_SESSION['user_type_unique_id'];

// if ($_SESSION['user_type_unique_id'] != '5f97fc3257f2525529' && $_SESSION['user_type_unique_id'] != '65deef78ba17d65741') {
if ($_SESSION['user_type_unique_id'] == '65efd97b4df4040205') {
   $team_members_list = assign_team_member($staff_ids); // returns list
   $team_members_options = $team_members_list[0]['staff_name'] ?? '';

   $team_members_options_id = $team_members_list[0]['staff_id'] ?? '';
   // $team_members_options = select_option($team_members_options, "Select Team Member",$staff_ids );


} else {
   // $staff_ids
   $team_members_options = assign_team_member();

   $team_members_options = select_option($team_members_options, "All");
}
?>

<!-- start page title -->
<div class="row">
   <div class="col-12">
      <div class="page-title-box d-sm-flex align-items-center justify-content-between">
         <h4 class="mb-sm-0"> Installation</h4>
         <input type="hidden" id="screen_id_val" name="screen_id_val" class="form-control"
            value="<?php echo $screen_id_val; ?>">
         <input type="hidden" id="user_type_unique_id" name="user_type_unique_id" class="form-control"
            value="<?php echo $user_type_unique_id; ?>">

         <div class="page-title-right">
            <ol class="breadcrumb m-0">
               <li class="breadcrumb-item"><a href="javascript: void(0);">Forms</a></li>
               <li class="breadcrumb-item active">Installation</li>
            </ol>
         </div>

      </div>
      <div>
      </div>
   </div>
</div>


<div class="card">
   <div class="card-body">
      <div class="col-12">
         <ul class="nav nav-pills arrow-navtabs bg-light mb-3" role="tablist">
            <li class="nav-item">
               <a class="nav-link active" data-bs-toggle="tab" href="#arrow-overview" role="tab">
                  <span class="d-block d-sm-none"><i class="mdi mdi-home-variant"></i></span>
                  <span class="d-none d-sm-block">Installation Pending</span>
               </a>
            </li>
             <li class="nav-item">
               <a class="nav-link" data-bs-toggle="tab" href="#arrow-completed" role="tab">
                  <span class="d-block d-sm-none"><i class="mdi mdi-home-variant"></i></span>
                  <span class="d-none d-sm-block">Document Uploaded</span>
               </a>
            </li>
            <li class="nav-item" onclick="sub_list_datatable()">
               <a class="nav-link" data-bs-toggle="tab" href="#arrow-contact" role="tab">
                  <span class="d-block d-sm-none"><i class="mdi mdi-email"></i></span>
                  <span class="d-none d-sm-block">DC and IR Pending</span>
               </a>
            </li>
            <li class="nav-item" onclick="sub_list_comdatatable()">
               <a class="nav-link" data-bs-toggle="tab" href="#arrow-comcontact" role="tab">
                  <span class="d-block d-sm-none"><i class="mdi mdi-email"></i></span>
                  <span class="d-none d-sm-block">DC and IR Completed</span>
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
                  <div class="col-md-3">
                     <div class="mb-3">
                        <label class="form-label from-date-label">Date type</label>
                        <select class="form-select" id="opt" name="opt" >
                           <option value="">Select Date</option>
                           <option value="4">PO Date</option>
                           <option value="5">Invoice Date</option>
                        </select>
                     </div>
                  </div>
                  
                  <div class="col-md-3">
                     <div class="mb-3">
                        <label class="form-label">Consignee District</label>
                        <select class="form-select" id="con_district" name="con_district" required>
                           <?php echo $consignee_district_options; ?>
                        </select>
                     </div>
                  </div>
                  <!-- <div class="col-md-3">
                     <div class="mb-3">
                        <label class="form-label">Result Filter</label>
                        <select class="form-select" name="installation_status" id="installation_status" 
                           required>
                           <option value="">All</option>
                           <option value="3">Rejected</option>
                           <option value="0">Pending</option>
                           <option value="4">Call Assigned</option>
                           <option value="5">Partial Completed</option>
                           <option value="1">SNR</option>
                           <option value="2">Completed</option>
                        </select>
                     </div>
                  </div> -->

                  <div class="col-md-3">
                     <div class="mb-3">
                       
                        <?php
                     //   if ($_SESSION['user_type_unique_id'] === '67e7997ad327489044' || $_SESSION['user_type_unique_id'] === '66a3334baa22534432') {
                        if ($_SESSION['user_type_unique_id'] === '67e7997ad327489044' || $_SESSION['user_type_unique_id'] === '66a3334baa22534432' && $_SESSION['user_type_unique_id'] != '65efd97b4df4040205') {
                       
                        // User is one of these two IDs
                           //  echo "if";
                           ?>
                           <input type="hidden" name="team_mem" id="team_mem" value="">
                           <?php
                        } 
                        // elseif ($_SESSION['user_type_unique_id'] !== '5f97fc3257f2525529' && $_SESSION['user_type_unique_id'] !== '65deef78ba17d65741' && $_SESSION['user_type_unique_id'] !== '67e7997ad327489044' && $_SESSION['user_type_unique_id'] !== '65efd9a94bcdb30916') {
                           if ($_SESSION['user_type_unique_id'] == '65efd97b4df4040205') {
                          
                           // User is not any of the above IDs
                           //  echo "elseif";
                           ?>
                            <label>Team Member</label>
                           <select class="form-select" name="team_mem" id="team_mem" >
                              <!-- oninput="get_list();"> -->
                              <option value="<?php echo $team_members_options_id; ?>">
                                 <?php echo $team_members_options; ?>
                              </option>
                           </select>
                           <?php
                        // } elseif ($_SESSION['user_type_unique_id'] === '5f97fc3257f2525529' || $_SESSION['user_type_unique_id'] === '65deef78ba17d65741') {
                        } 
                        // elseif ($_SESSION['user_type_unique_id'] == '65efd97b4df4040205') {
                           else  if ($_SESSION['user_type_unique_id'] != '67e7997ad327489044' && $_SESSION['user_type_unique_id'] != '66a3334baa22534432' && $_SESSION['user_type_unique_id'] != '65efd97b4df4040205') {
                          
                           // User matches one of these two IDs
                           //  echo "else if if";
                           ?>
                            <label>Team Member</label>
                           <select class="form-select" name="team_mem" id="team_mem" >
                              <!-- oninput="get_list();"> -->
                              <?php echo $team_members_options; ?>
                           </select>
                           <?php
                        }
                        ?>


                     </div>
                  </div>

                    <div class="col-md-3">
                      <div class="mb-3">
                     <label class="">Engineer Type</label>
                     <select class="form-select" id="engineer_type" id="engineer_type">
                        <option value="">Select Engineer Type</option>
                        <option value="1">Own Engineer</option>
                        <option value="2">Outsource Engineer</option>

                     </select>
                      </div>
                  </div>

                  <div class="col-md-1">
                     <div class="mb-3">

                        <button type="button" class="btn btn-primary btn-lg gos" onclick="get_data()">Go</button>
                     </div>
                  </div>

               </div>


               <div class="row align-items-end">

               </div>
               <br>

               <div id="list">
                  <div class="table-responsive">
                     <table id="installation_datatable" class="table table-bordered table-striped align-middle">
                        <thead class="text-center">
                           <tr>
                              <th style="text-align: center;">S.No</th>
                               <th style="text-align: center;">PO No</th>
                               <th style="text-align: center;">Ledger Name</th>
                               <th style="text-align: center;">Followed By</th>
                               <th style="text-align: center;">Invoice</th>
                               <th style="text-align: center;">DC</th>
                               <th style="text-align: center;">Invoice Value</th>
                               <th style="text-align: center;">Installation Allocation Date</th>
                               <th style="text-align: center;">PO.Att.</th>
                               <th style="text-align: center;">DC.Att.</th>
                               <th style="text-align: center;">IR.Att.</th>
                               <th style="text-align: center;">INV.Att.</th>
                               <th style="text-align: center;">Action</th>
                           </tr>
                        </thead>
                        <tbody>

                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
            <div class="tab-pane" id="arrow-completed" role="tabpanel">
               <div class="row align-items-end">
                  <div class="col-md-3">
                     <div class="mb-3">
                        <label class="form-label from-date-label">From Date</label>
                        <input type="date" class="form-control" id="com_from_date" name="com_from_date" value="<?php echo date('Y-m-d'); ?>" >
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="mb-3">
                        <label class="form-label from-date-label">To Date</label>
                        <input type="date" class="form-control" id="com_to_date" name="to_date" value="<?php echo date('Y-m-d'); ?>">
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="mb-3">
                        <label class="form-label from-date-label">Date type</label>
                        <select class="form-select" id="com_opt" name="com_opt" >
                           <option value="">Select Date</option>
                           <option value="4">PO Date</option>
                           <option value="5">Invoice Date</option>
                           <!-- <option value="6">Due Date</option> -->
                        </select>
                     </div>
                  </div>
                  
                  <div class="col-md-3">
                     <div class="mb-3">
                        <label class="form-label">Consignee District</label>
                        <select class="form-select" id="com_con_district" name="com_con_district" required>
                           <?php echo $consignee_district_options; ?>
                        </select>
                     </div>
                  </div>
                  <!-- <div class="col-md-3">
                     <div class="mb-3">
                        <label class="form-label">Result Filter</label>
                        <select class="form-select" name="com_installation_status" id="com_installation_status" 
                           required>
                           <option value="">All</option>
                           <option value="3">Rejected</option>
                           <option value="0">Pending</option>
                           <option value="4">Call Assigned</option>
                           <option value="5">Partial Completed</option>
                           <option value="1">SNR</option>
                           <option value="2">Completed</option>
                        </select>
                     </div>
                  </div> -->

                  <div class="col-md-3">
                     <div class="mb-3">
                       
                        <?php
                     //   if ($_SESSION['user_type_unique_id'] === '67e7997ad327489044' || $_SESSION['user_type_unique_id'] === '66a3334baa22534432') {
                        if ($_SESSION['user_type_unique_id'] === '67e7997ad327489044' || $_SESSION['user_type_unique_id'] === '66a3334baa22534432' && $_SESSION['user_type_unique_id'] != '65efd97b4df4040205') {
                       
                        // User is one of these two IDs
                           //  echo "if";
                           ?>
                           <input type="hidden" name="com_team_mem" id="com_team_mem" value="">
                           <?php
                        } 
                        // elseif ($_SESSION['user_type_unique_id'] !== '5f97fc3257f2525529' && $_SESSION['user_type_unique_id'] !== '65deef78ba17d65741' && $_SESSION['user_type_unique_id'] !== '67e7997ad327489044' && $_SESSION['user_type_unique_id'] !== '65efd9a94bcdb30916') {
                           if ($_SESSION['user_type_unique_id'] == '65efd97b4df4040205') {
                          
                           // User is not any of the above IDs
                           //  echo "elseif";
                           ?>
                            <label>Team Member</label>
                           <select class="form-select" name="com_team_mem" id="com_team_mem" >
                              <!-- oninput="get_list();"> -->
                              <option value="<?php echo $team_members_options_id; ?>">
                                 <?php echo $team_members_options; ?>
                              </option>
                           </select>
                           <?php
                        // } elseif ($_SESSION['user_type_unique_id'] === '5f97fc3257f2525529' || $_SESSION['user_type_unique_id'] === '65deef78ba17d65741') {
                        } 
                        // elseif ($_SESSION['user_type_unique_id'] == '65efd97b4df4040205') {
                           else  if ($_SESSION['user_type_unique_id'] != '67e7997ad327489044' && $_SESSION['user_type_unique_id'] != '66a3334baa22534432' && $_SESSION['user_type_unique_id'] != '65efd97b4df4040205') {
                          
                           // User matches one of these two IDs
                           //  echo "else if if";
                           ?>
                            <label>Team Member</label>
                           <select class="form-select" name="com_team_mem" id="com_team_mem" >
                              <!-- oninput="get_list();"> -->
                              <?php echo $team_members_options; ?>
                           </select>
                           <?php
                        }
                        ?>


                     </div>
                  </div>

                  <div class="col-md-3">
                      <div class="mb-3">
                     <label class="">Engineer Type</label>
                     <select class="form-select" id="engineer_type2" id="engineer_type2">
                        <option value="">Select Engineer Type</option>
                        <option value="1">Own Engineer</option>
                        <option value="2">Outsource Engineer</option>

                     </select>
                      </div>
                  </div>

                  <div class="col-md-1">
                     <div class="mb-3">

                        <button type="button" class="btn btn-primary btn-lg gos" onclick="get_comdata()">Go</button>
                     </div>
                  </div>

               </div>


               <div class="row align-items-end">

               </div>
               <br>

               <div id="list">
                  <div class="table-responsive">
                     <table id="installation_completeddatatable" class="table table-bordered table-striped align-middle">
                        <thead class="text-center">
                           <tr>
                               <th style="text-align: center;">S.No</th>
                               <th style="text-align: center;">PO No</th>
                               <th style="text-align: center;">Ledger Name</th>
                               <th style="text-align: center;">Followed By</th>
                               <th style="text-align: center;">Invoice</th>
                               <th style="text-align: center;">DC</th>
                               <th style="text-align: center;">Invoice Value</th>
                               <!-- <th style="text-align: center;">PO.Att.</th>
                               <th style="text-align: center;">DC.Att.</th>
                               <th style="text-align: center;">IR.Att.</th>
                               <th style="text-align: center;">INV.Att.</th> -->
                                <th style="text-align: center;">PO.Att.</th>
                               <th style="text-align: center;">Ins DC.Att.</th>
                               <th style="text-align: center;">Ins IR.Att.</th>
                               <th style="text-align: center;">Ins SNR.Att.</th>
                              <!--  <th style="text-align: center;">Engineer Name</th> -->
                              <!--  <th style="text-align: center;">Status</th> -->
                               <th style="text-align: center;">Action</th>
                           </tr>
                        </thead>
                        <tbody>

                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
            <div class="tab-pane" id="arrow-contact" role="tabpanel">
               <div class="row align-items-end">
                  <div class="col-md-3">
                     <div class="mb-3">
                        <label class="form-label from-date-label">From Date</label>
                        <input type="date" class="form-control" id="from_date_dc" name="from_date_dc">
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="mb-3">
                        <label class="form-label from-date-label">To Date</label>
                        <input type="date" class="form-control" id="to_date_dc" name="to_date_dc">
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="mb-3">
                        <label class="form-label from-date-label">Date type</label>
                        <select class="form-select" id="dc_ir_opt1" name="dc_ir_opt1">
                           <option value="">Select Date</option>
                           <option value="9">PO Date</option>
                           <option value="10">Invoice Date</option>
                           <!-- <option value="11">Due Date</option> -->
                        </select>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="mb-3">
                        <label class="form-label">Consignee District</label>
                        <select class="form-select" id="con_district_dc" name="con_district_dc" required>
                           <?php echo $consignee_district_options; ?>
                        </select>
                     </div>
                  </div>
                  <!-- <div class="col-md-3">
                     <div class="mb-3">
                        <label class="form-label">Result Filter</label>
                        <select class="form-select" name="dc_delivery_status" id="dc_delivery_status"  required>
                           <option value="">All</option>
                           <option value="0">Pending</option>
                           <option value="1">SNR</option>
                           <option value="5">Partial Completed</option>
                           <option value="3">Completed</option>


                        </select>
                     </div>
                  </div> -->

                  <div class="col-md-3">
                     <div class="mb-3">

                        <?php
                        if ($_SESSION['user_type_unique_id'] === '67e7997ad327489044' || $_SESSION['user_type_unique_id'] === '66a3334baa22534432' && $_SESSION['user_type_unique_id'] != '65efd97b4df4040205') {
                       
                           // User is one of these two IDs
                           //  echo "if";
                           ?>
                           <input type="hidden" name="team_mem1" id="team_mem1" value="">
                           <?php
                        } 
                        if ($_SESSION['user_type_unique_id'] == '65efd97b4df4040205') {
                          
                           ?>
                           <label class="form-label">Team Member</label>
                           <select class="form-select" name="team_mem1" id="team_mem1" >
                              <!-- oninput="get_list1();"> -->
                              <option value="<?php echo $team_members_options_id; ?>">
                                 <?php echo $team_members_options; ?>
                              </option>
                           </select>
                           <?php
                        } 
                           else  if ($_SESSION['user_type_unique_id'] != '67e7997ad327489044' && $_SESSION['user_type_unique_id'] != '66a3334baa22534432' && $_SESSION['user_type_unique_id'] != '65efd97b4df4040205') {
                          
                           ?>
                           <label class="form-label">Team Member</label>
                           <select class="form-select" name="team_mem1" id="team_mem1" >
                              <!-- oninput="get_list1();"> -->
                              <?php echo $team_members_options; ?>
                           </select>
                           <?php
                        }
                        ?>

                     </div>
                  </div>

                          <div class="col-md-3">
                      <div class="mb-3">
                     <label class="">Engineer Type</label>
                     <select class="form-select" id="engineer_type3" id="engineer_type3">
                        <option value="">Select Engineer Type</option>
                        <option value="1">Own Engineer</option>
                        <option value="2">Outsource Engineer</option>

                     </select>
                      </div>
                  </div>

                  <div class="col-md-1">
                     <div class="mb-3">
                        <button type="button" class="btn btn-primary btn-lg gos" onclick="get_data_dc()">Go</button>
                     </div>
                  </div>
               </div>
               <?php
               $staff_ids = $_SESSION['staff_id'];               
               if ($_SESSION['user_type_unique_id'] != '5f97fc3257f2525529' && $_SESSION['user_type_unique_id'] != '65deef78ba17d65741') {
                  $team_members_list = assign_team_member($staff_ids); // returns list
                  $team_members_options = $team_members_list[0]['staff_name'] ?? '';

                  $team_members_options_id = $team_members_list[0]['staff_id'] ?? '';              

               } else {
                  // $staff_ids
                  $team_members_options = assign_team_member();

                  $team_members_options = select_option($team_members_options, "All");
               }
               ?>
               <div class="row align-items-end">

               </div>
               <br>
               <div id="list_1">
                  <div class="table-responsive">
                     <table id="dc_ir_dispatch_datatable" class="table table-bordered table-striped align-middle">
                        <thead class="text-center">
                           <tr>
                               <th style="text-align: center;">S.No</th>
                               <th style="text-align: center;">PO No</th>
                               <th style="text-align: center;">Ledger Name</th>
                               <th style="text-align: center;">Followed By</th>
                               <th style="text-align: center;">Invoice</th>
                               <th style="text-align: center;">DC</th>
                               <th style="text-align: center;">Invoice Value</th>
                               <th style="text-align: center;">Action</th>
                           </tr>
                        </thead>
                        <tbody>
                           
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
  <div class="tab-pane" id="arrow-comcontact" role="tabpanel">
               <div class="row align-items-end">
                  <div class="col-md-3">
                     <div class="mb-3">
                        <label class="form-label from-date-label">From Date</label>
                        <input type="date" class="form-control" id="com_from_date_dc" name="com_from_date_dc" value="<?php echo date('Y-m-d'); ?>">
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="mb-3">
                        <label class="form-label from-date-label">To Date</label>
                        <input type="date" class="form-control" id="com_to_date_dc" name="com_to_date_dc" value="<?php echo date('Y-m-d'); ?>">
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="mb-3">
                        <label class="form-label from-date-label">Date type</label>
                        <select class="form-select" id="com_opt1" name="com_opt1">
                           <option value="">Select Date</option>
                           <option value="9">PO Date</option>
                           <option value="10">Invoice Date</option>
                        </select>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="mb-3">
                        <label class="form-label">Consignee District</label>
                        <select class="form-select" id="com_con_district_dc" name="com_con_district_dc" required>
                           <?php echo $consignee_district_options; ?>
                        </select>
                     </div>
                  </div>
                  <!-- <div class="col-md-3">
                     <div class="mb-3">
                        <label class="form-label">Result Filter</label>
                        <select  class="form-select" name="com_dc_delivery_status" id="com_dc_delivery_status" required>
                           <option value="">All</option>
                           <option value="0">Pending</option>
                           <option value="1">SNR</option>
                           <option value="5">Partial Completed</option>
                           <option value="3">Completed</option>


                        </select>
                     </div>
                  </div> -->

                  <div class="col-md-3">
                     <div class="mb-3">

                        <?php
                           if ($_SESSION['user_type_unique_id'] === '67e7997ad327489044' || $_SESSION['user_type_unique_id'] === '66a3334baa22534432' && $_SESSION['user_type_unique_id'] != '65efd97b4df4040205') {
                           ?>
                           <input type="hidden" name="com_team_mem1" id="com_team_mem1" value="">
                           <?php
                        } 
                        if ($_SESSION['user_type_unique_id'] == '65efd97b4df4040205') {
                          
                           ?>
                           <label class="form-label">Team Member</label>
                           <select class="form-select"name="com_team_mem1" id="com_team_mem1" >
                              <option value="<?php echo $team_members_options_id; ?>">
                                 <?php echo $team_members_options; ?>
                              </option>
                           </select>
                           <?php
                        } 
                           else  if ($_SESSION['user_type_unique_id'] != '67e7997ad327489044' && $_SESSION['user_type_unique_id'] != '66a3334baa22534432' && $_SESSION['user_type_unique_id'] != '65efd97b4df4040205') {
                           ?>
                           <label class="form-label">Team Member</label>
                           <select class="form-select"name="com_team_mem1" id="com_team_mem1" >
                              <?php echo $team_members_options; ?>
                           </select>
                           <?php
                        }
                        ?>

                     </div>
                  </div>

                    <div class="col-md-3">
                      <div class="mb-3">
                     <label class="">Engineer Type</label>
                     <select class="form-select" id="engineer_type4" id="engineer_type4">
                        <option value="">Select Engineer Type</option>
                        <option value="1">Own Engineer</option>
                        <option value="2">Outsource Engineer</option>

                     </select>
                      </div>
                  </div>

                  <div class="col-md-1">
                     <div class="mb-3">
                        <button type="button" class="btn btn-primary btn-lg gos" onclick="get_data_comdc()">Go</button>
                     </div>
                  </div>
               </div>
               <?php
               $staff_ids = $_SESSION['staff_id'];
               
               if ($_SESSION['user_type_unique_id'] != '5f97fc3257f2525529' && $_SESSION['user_type_unique_id'] != '65deef78ba17d65741') {
                  $team_members_list = assign_team_member($staff_ids); // returns list
                  $team_members_options = $team_members_list[0]['staff_name'] ?? '';
                  $team_members_options_id = $team_members_list[0]['staff_id'] ?? '';             
               } else {
                  // $staff_ids
                  $team_members_options = assign_team_member();

                  $team_members_options = select_option($team_members_options, "All");
               }
               ?>
               <div class="row align-items-end">

               </div>
               <br>
               <div id="list_1">
                  <div class="table-responsive">
                     <table id="dc_ir_dispatch_comdatatable" class="table table-bordered table-striped align-middle">
                        <thead class="text-center">
                           <tr>
                            <tr>
                               <th style="text-align: center;">S.No</th>
                               <th style="text-align: center;">PO No</th>
                               <th style="text-align: center;">Ledger Name</th>
                               <th style="text-align: center;">Followed By</th>
                               <th style="text-align: center;">Invoice</th>
                               <th style="text-align: center;">DC</th>
                               <th style="text-align: center;">Invoice Value</th>
                               <th style="text-align: center;">Action</th>
                           </tr>
                           </tr>
                        </thead>
                        <tbody>
                     
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

<div id="columnVisibilityModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title">Select Columns to Display</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <form id="columnVisibilityForm">
               <div class="row">
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
   $("#export").click(function () {
      window.location = "folders/installation/excel.php";
   });
</script>
<script>
   $("#export1").click(function () {

      var from_date = $('#from_date').val();
      var to_date = $('#to_date').val();
      var opt = $('#opt').val();
      var installation_status = $('#installation_status').val();
      window.location = "folders/installation/excel1.php?from_date=" + from_date + "&to_date=" + to_date + "&opt=" + opt + "&installation_status=" + installation_status;
   });


   //tab 2
   $("#export2").click(function () {

      var from_date_dc = $("#from_date_dc").val();
      var to_date_dc = $("#to_date_dc").val();
      var opt1 = $("#opt1").val();
      var dc_delivery_status = $("#dc_delivery_status").val();

      window.location = "folders/installation/excel2.php?from_date=" + from_date_dc + "&to_date=" + to_date_dc + "&opt1=" + opt1 + "&dc_delivery_status=" + dc_delivery_status;
   });
</script>
<script>


   $(document).ready(function () {

      get_user_permission();
      get_user_permission_1();
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
      // 
      console.log(data);
      $.ajax({
         type: "POST",
         url: ajax_url,
         data: data,
         success: function (data) {
            var obj = JSON.parse(data);
            var dataString = obj.data;
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
