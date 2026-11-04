<?php include 'function.php'; ?>

<?php

include '../../config/dbconfig.php';
include '../../inc/header.php';
include '../../inc/footer.php';



$unique_id = $_GET["invoice_no"];
      $where = [
         "invoice_no" => $unique_id
      ];


      $table = "invoice_verfication_table";

      $columns = [
        // "po_num",
        "get_po_number(form_main_unique_id) As po_num",
        "po_date",
        "invoice_no",
        "invoice_date",
         "form_main_unique_id",
         "consignee_unique_id",
         "inv_verify_status",
         "inv_verify_approvedby",
         "inv_verify_approved_date"
      ];

      $table_details = [
         $table,
         $columns
      ];
      $result_values = $pdo->select($table_details, $where);
      //   print_r($result_values);die();
      if ($result_values->status) {

         $result_values = $result_values->data;

         $po_num = $result_values[0]["po_num"];
         $po_date = $result_values[0]["po_date"];
         $invoice_no = $result_values[0]["invoice_no"];
         $invoice_date = $result_values[0]["invoice_date"];
         $dc_number = $result_values[0]["dc_count"];
         $dc_count_pending = $result_values[0]["dc_count_pending"];

         $verifyStatus = $result_values[0]["inv_verify_status"];
         $ApproveBy = $result_values[0]["inv_verify_approvedby"];
         $ApproveDate = $result_values[0]["inv_verify_approved_date"];


         $form_main_uid = $result_values[0]["form_main_unique_id"];

         $stmtCus = $conn->prepare("CALL GetCustomerDetailByponum(:po_unique_id)");
            $stmtCus->bindParam(':po_unique_id', $form_main_uid);
            $stmtCus->execute();

            $customer_data = $stmtCus->fetchAll(PDO::FETCH_ASSOC);

           if (!empty($customer_data)) {
                $cusAdd    = $customer_data[0]["bill_address"];
                $department    = department_name($customer_data[0]["department"]);
                $customerName  = $customer_data[0]["contact_name"];
                $customerContact  = $customer_data[0]["contact_number"];
                $customerLan         = $customer_data[0]["landline_number"];
                $customerEmail = $customer_data[0]["email"];
                $customerState      = con_state_name_stock($customer_data[0]["state_name"]);
                $customerDistrict      = district_name_stock($customer_data[0]["district"]);
                $customerPincode      = $customer_data[0]["pin"];
            }
            $stmtCus->closeCursor(); // <--- this clears the result set

      } else {
         $btn_text = "Error";
         $btn_action = "error";
         $is_btn_disable = "disabled='disabled'";
      }
?>
<style>
     table.dataTable thead tr th{
        text-align:center;
    }

    
    table thead th {
    vertical-align: middle; /* centers text vertically */
    text-align: center;     /* centers text horizontally */
    padding: 8px;
    position: relative;
    white-space: nowrap;
}

table thead th .sorting-icon {
    position: absolute;
    right: 6px;
    top: 50%;
    transform: translateY(-50%);
}
</style>

<div class="row">
   <div class="col-12">
      <div class="page-title-box d-sm-flex align-items-center justify-content-between">
         <h4 class="mb-sm-0">DC Status Verifiy</h4>
         <input type="hidden" id="screen_id_val" name="screen_id_val" class="form-control"
            value="<?php echo $screen_id_val; ?>">
         <input type="hidden" id="user_type_unique_id" name="user_type_unique_id" class="form-control"
            value="<?php echo $user_type_unique_id; ?>">
         <div class="page-title-right">
            <ol class="breadcrumb m-0">
               <li class="breadcrumb-item"><a href="javascript: void(0);">Admin</a></li>
               <li class="breadcrumb-item active">DC Status Verifiy</li>
            </ol>
         </div>
      </div>
   </div>
</div>

<?php
?>
<input type="hidden" name="invoice_no" id="invoice_no" value="<?php echo $_GET['invoice_no'];?>">
<input type="hidden" id="team_mem" name ="team_mem">

<div class="row">
    <div class="card">
      <div class="card-body">

      <div class="row">
               <!-- Customer Details -->
               <div class="col-md-6">
                  <h6 class="text-uppercase text-body-primary" style="font-size: large; color: #878a99;">Customer Details</h6>
                  <h6 style="font-size: x-large; color: #506018;"><strong><?php echo $department ?></strong></h6>
                  <p class="mb-1"><?php echo $customerAddress ?>, <?php echo $customerDistrict ?><br><?php echo $customerState ?>, <?php echo $customerPincode ?></p>
                  <p class="mb-1">
                     <i data-feather="phone" style="width:15px; height:15px; color:#506018"></i>
                     <?php echo !empty($customerContact) ? $customerContact : '--'; ?>
                  </p>
                  <p>
                     <i data-feather="mail" style="width:15px; height:15px; color:#506018"></i>
                     <?php echo !empty($customerEmail) ? $customerEmail : '--'; ?>
                  </p>
               </div>

              
               <!-- Consignee / Invoice Details -->
               <div class="col-md-6">
                  <h6 class="text-uppercase text-body-primary" style="font-size: large; color: #878a99;">PO & Invoice Details</h6>
                  <div class="row mb-1">
                     <div class="col-2 text-body-secondary">PO Number</div>
                     <div class="col-1">:</div>
                     <div class="col-6 "><?php echo $po_num ?></div>
                  </div>
                  <div class="row mb-1">
                     <div class="col-2 text-body-secondary">PO Date</div>
                     <div class="col-1">:</div>
                     <div class="col-6 "><?php echo date('d-m-Y', strtotime($po_date)) ?></div>
                  </div>
                  <div class="row mb-1">
                     <div class="col-2 text-body-secondary">Invoice No</div>
                     <div class="col-1">:</div>
                     <div class="col-6 "><?php echo $invoice_no; ?></div>
                  </div>
                  <div class="row mb-1">
                     <div class="col-2 text-body-secondary">Invoice Date</div>
                     <div class="col-1">:</div>
                     <div class="col-6 "><?php echo date('d-m-Y', strtotime($invoice_date)) ?></div>
                  </div>                 
               </div>
                <input type="hidden" id="po_no" name="po_no" class="form-control" value="<?php echo $po_no; ?>">
               <input type="hidden" id="invoice_no" name="invoice_no" class="form-control"
                  value="<?php echo $inv_no; ?>">
         </div>

    <div class="table-responsive">
                <table id="doc_pending_list_datatable" class="table table-bordered table-striped align-middle">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Selection<br>(Select All)
                         <?php echo '<input type="checkbox"  id="select_all" checked disabled=disbled>' ?>
                            </th>
                            <th>DC No</th>
                            <th>DC Date</th>
                            <th>Consignee Name</th>
                            <th>Location</th>
                            <th>QTY</th>
                            <th>Value</th>
                        
                        </tr>
                    </thead>
                    <tbody>
                        <tr>

                        </tr>
                    </tbody>
                </table>


                <?php


                        $where      = [
                            "invoice_no" => $_GET['invoice_no']
                        ];
                        $table_sub      =  "invoice_verfication_table";

                        $columns    = [
                            "inv_verify_status",
                            // "supplier_invoice_number",
                            // "bill_form_main_unique_id",
                            // "unique_id",
                            // "scanned_dc_copy",
                            // "scanned_snr_copy",
                            // "scanned_ir_copy",
                            // "invoice_copy",
                            // "claim_amount",
                            // "bill_form_main_unique_id",
                            // "ins_unique_id",
                        ];

                        $table_details   = [
                            $table_sub,
                            $columns
                        ];

                        $result_values_data  = $pdo->select($table_details, $where);
                        // print_r($result_values_data);die();

                        if ($result_values_data->status) {

                            $result_values_data      = $result_values_data->data;
                          
                            $inv_verify_status         = $result_values_data[0]["inv_verify_status"];
                            // $exp_under_user_type  = explode(",", $under_user_type);

                            $btn_text           = "Update";
                            $btn_action         = "update";
                        } else {
                            $btn_text           = "Error";
                            $btn_action         = "error";
                            $is_btn_disable     = "disabled='disabled'";
                        }

                ?>

                <div class="row">        
                    <div class="col-md-6 mt-3">
                        <h6 class="text-uppercase text-body-primary" style="font-size: large; color: #878a99;">Approve Details</h6>
                        <div class="row mb-1">
                            <div class="col-2 text-body-secondary">Status</div>
                            <div class="col-1">:</div>
                            <div class="col-6 "><?php
                            if ($verifyStatus == 1) { echo '<span style="color:green; font-weight:800;">Approved</span>';} ?></div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-2 text-body-secondary">Approved By</div>
                            <div class="col-1">:</div>
                            <div class="col-6 "><?php echo $ApproveBy ?></div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-2 text-body-secondary">Date</div>
                            <div class="col-1">:</div>
                            <div class="col-6 "><?php echo $ApproveDate ?></div>
                        </div>                   
                    </div>
                </div>
                <div class="col-12 mt-3">
                    <div class="form-group row">
                        <div class="col-md-12" align="right">            
                            <?php echo btn_cancel($btn_cancel); ?>
                        </div>
                    </div>
                </div>

            </div>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
    integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    document.getElementById('select_all').addEventListener('change', function () {
        const checkboxes = document.querySelectorAll('.myCheck');
        checkboxes.forEach(function (checkbox) {
            checkbox.checked = this.checked;
        }.bind(this));
    });
</script>
