<style>
   i.fa.fa-edit {
      font-size: 20px;
      color: green;
   }

   i.fa-sharp.fa-solid.fa-trash {
      font-size: 20px;
      color: green;
   }

   table {
      width: 100%;
      border-collapse: collapse;
      text-align: center;
      /* Center text horizontally */
   }

   th {
      border: 1px solid #ddd;
      padding: 8px;
      vertical-align: middle;
      /* Center text vertically */
   }

   th {
      background-color: #f2f2f2;
   }

   .field-group {
      display: flex;
      align-items: center;
      margin-bottom: 10px;
   }

   .label-col {
      width: 150px;
      font-weight: 500;
      font-size: 15px;
   }

   .colon-col {
      width: 10px;
   }

   .value-col {
      flex: 1;
   }
</style>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

<?php
$screen_id_val = '62b589c21c0ba28931';
session_start();
$user_type_unique_id = $_SESSION['user_type_unique_id'];

$list_of_po = list_of_po();
$list_of_po = select_option($list_of_po, "Select PO Number", );

$list_of_invoice = list_of_invoice();


$list_of_invoice = invoice_select_option($list_of_invoice, "Select Invoice Number");

?>
<!-- start page title -->
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
<!-- end page title -->
<div class="row mt-3">
   <div class="col-12">
      <div class="card">
         <div class="card-body">
            <div class="row">
               <div class="col-md-3">
                  <div class="mb-3">
                     <label class="form-label from-date-label">Select PO No</label>
                     <select id="po_no" name="po_no" class="select2 form-control" onchange="getInvoiceNo(this.value);">
                        <?php echo $list_of_po; ?>
                     </select>
                  </div>
               </div>
               <div class="col-md-3">
                  <div class="mb-3">
                     <label class="form-label from-date-label">Select Invoice No</label>
                     <select id="invoice_no" name="invoice_no" class="select2 form-control">
                        <?php echo $list_of_invoice; ?>
                     </select>
                  </div>
               </div>
               <div class="col-md-1 mt-3">
                  <div class="mb-3">
                     <button type="button" class="btn btn-primary btn-lg" onclick="get_dc_number();">Go</button>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>

   <div class="col-12" id="dc_card" style="display: none;">
      <div class="card">
         <div class="card-body">
            <h6><b>DC Details</b></h6>
            <div class="row">

               <!-- <div class="col-md-4">
                  <div class="field-group">
                     <div class="label-col">PO No.</div>
                     <div class="colon-col">:</div>
                     <div class="value-col"><span id="po_num_val"></span></div>
                  </div>
               </div> -->

               <div class="col-md-8">
                  <div class="field-group">
                     <div class="label-col">Invoice No.</div>
                     <div class="colon-col">:</div>
                     <div class="value-col"><span id="invoice_val"></span></div>
                  </div>
               </div>

            </div>
         </div>
      </div>
   </div>

   <!----content start---------->
   <div class="row" id="list">
      <div class="col-12">
         <div class="card" id="dc_status" style="display:none;">
            <div class="card-body">
               <div class="table-responsive">
                  <table id="dc_status_datatable" class="table table-bordered nowrap table-striped align-middle">
                     <thead>
                        <tr>

                           <th rowspan="2">#</th>
                           <th rowspan="2">Invoice No.</th>
                           <th rowspan="2">DC No.</th>
                           <th rowspan="2">Doc. App Oper Team</th>
                           <th rowspan="2">Doc. App A/C Team</th>
                           <th rowspan="2">Material QC</th>
                           <th rowspan="2">Dispatch</th>
                           <th rowspan="2">Vendor Allocation</th>
                           <th colspan="2">Installation</th>
                           <th rowspan="2">Signed Doc Verify</th>
                        </tr>
                        <tr>
                           <th>Installation Followups</th>
                           <th>DC & IR Doc Dispatch</th>
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
      $(document).ready(function () {
         get_user_permission();
      });
   </script>
