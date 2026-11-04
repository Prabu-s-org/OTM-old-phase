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
     #btn{
      margin-left: 89%;
      
     }
  </style>
  <?php include 'function.php'; 
  include '../../config/dbconfig.php';?>
  
  <?php
  if (isset($_GET["unique_id"])) {
    if (!empty($_GET["unique_id"])) {

        // $uni_dec = str_replace(" ", "+", $_GET['unique_id']);
        // $get_uni_id           = openssl_decrypt(base64_decode($uni_dec), $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv);

        $unique_id_1  = $_GET["unique_id"];
        $where      = [
            "consignee_unique_id" => $unique_id_1
        ];


        $table      =  "view_bill_submission_list";

        $columns    = [
           "po_num",
           "po_date",
           "con_contact_name",
           "con_address",
           "invoice_no",
           "invoice_date",
           "invoice_value",
           "file_name",
           "consignee_unique_id",
           "form_main_unique_id"
           
        ];

        $table_details   = [
            $table,
            $columns
        ];

        $result_values  = $pdo->select($table_details, $where);
        // print_r($result_values);die();

        if ($result_values->status) {

            $result_values      = $result_values->data;

            $po_num          = $result_values[0]["po_num"];
            $po_date    = $result_values[0]["po_date"];
            $con_contact_name          = $result_values[0]["con_contact_name"];
            $con_address          = $result_values[0]["con_address"];
            $invoice_no    = $result_values[0]["invoice_no"];
            $invoice_date          = $result_values[0]["invoice_date"];
            $invoice_value          = $result_values[0]["invoice_value"];
            $file_name    = $result_values[0]["file_name"];
            $consignee_unique_id          = $result_values[0]["consignee_unique_id"];
            $form_main_unique_id          = $result_values[0]["form_main_unique_id"];
    
            $file_name_po= image_view("po_form", $result_values[0]['consignee_unique_id'], $result_values[0]['file_name']);
           

            $btn_text           = "Update";
            $btn_action         = "update";
        } else {
            $btn_text           = "Error";
            $btn_action         = "error";
            $is_btn_disable     = "disabled='disabled'";
        }
    }
}

  ?>
   <!-- start page title -->
  <div class="row">
     <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
           <h4 class="mb-sm-0"> Bill Submission</h4>

           <div class="page-title-right">
              <ol class="breadcrumb m-0">
                 <li class="breadcrumb-item"><a href="javascript: void(0);">Settings</a></li>
                 <li class="breadcrumb-item active">Bill Submission</li>
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

  <div class="col-xxl-12">

     <div class="card">
         
         
        <div class="card-body">
 
           <ul class="nav nav-pills arrow-navtabs  bg-light mb-3" role="tablist">
              <li class="nav-item">
                 <a class="nav-link active" data-bs-toggle="tab" href="#arrow-overview" role="tab">
                    <span class="d-block d-sm-none"><i class="mdi mdi-home-variant"></i></span>
                    <span class="d-none d-sm-block">Upload</span>
                 </a>
              </li>
              <li class="nav-item">
                 <a class="nav-link" data-bs-toggle="tab" href="#arrow-profile" role="tab">
                    <span class="d-block d-sm-none"><i class="mdi mdi-account"></i></span>
                    <span class="d-none d-sm-block">Submit</span>
                 </a>
              </li>

           </ul>
           <!-- Tab panes -->
           <div class="tab-content">
               
              <div class="tab-pane active" id="arrow-overview" role="tabpanel">
                  <div class="row">
   <div class="col-xxl-12">
       <p>
                  <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseWidthExample"
                     aria-expanded="false" aria-controls="collapseWidthExample">
                  Filter With Date Wise
                  </button>
               </p>
               <div >
                  <div class="collapse collapse-horizontal" id="collapseWidthExample">
                     <div class="card card-body mb-0" style="width: 100%;">
                        <div class="row">
                           <div class="col-6">
                              <div class="col-md-6">
                                  <label  class="form-label">Status</label>

                                    <select name="status" id="status" class="select2 form-control">
                                        <option value='0'>Pending</option>
                                        <option value='1'>Completed</option>
                                        <option value='2'>Bill_submit</option>
                                    
                                    </select>
                                </div>
                           </div>
                           
                           <div class="col-3 align-self-center">
                              <button type="button" class="btn btn-primary rounded-pill waves-effect waves-light" onclick="get_status_filter()">GO</button>
                           </div>
                        </div>
                     </div>
                  </div>
               </div> 
   </div>
</div>

                 <div class="row">
                    <div class="col-12">
                       <div class="">
                          <div class="card-body">
                               <div class="table-responsive">
                             <table id="bill_submission_datatable" class="table table-bordered nowrap table-striped align-middle">
                                <thead>
                                   <tr>
                                      <th>S No</th>
                                      <th>PO Number </th>
                                      <th>PO Date </th>
                                      <th>Consignee </th>
                                      <th>Location</th>
                                      <th>Invoice No</th>
                                      <th>Invoice Date</th>
                                      <th>Invoice Value</th>
                                      <th>PO Copy</th>
                                      <th>Status</th>
                                      <th>Action</th>

                                   </tr>
                                </thead>
                                <tbody>
                                   <!--<tr>-->
                                   <!--   <td>01</td>-->
                                   <!--   <td>ELT-001</td>-->
                                   <!--   <td>01-11-2023</td>-->
                                   <!--   <td>ABC Infotech</td>-->
                                   <!--   <td>Chennai</td>-->
                                   <!--   <td>1001</td>-->
                                   <!--   <td>30-10-2023</td>-->
                                   <!--   <td>20</td>-->
                                   <!--   <td><a href="#"><i class="mdi mdi-download-circle-outline"></i> Download</a></td>-->
                                   <!--   <td>-->
                                   <!--      <a href="index.php?file=bill_submission/create"><i class="mdi mdi-square-edit-outline mdi-24px waves-effect waves-light mt-n2 mb-n2 text-green"></i>-->
                                   <!--         <i class="mdi mdi-delete  mdi-24px waves-effect waves-light mt-n2 mb-n2 text-danger"></i></a>-->
                                   <!--   </td>-->
                                   <!--</tr>-->

                                </tbody>
                             </table>
                             </div>
                          </div>
                       </div>
                    </div>
                 </div>
                 <!----content start---------->


              </div>
                 
              <div class="tab-pane" id="arrow-profile" role="tabpanel">
                  <!--<a href="index.php?file=dispatch/update1&unique_id=' . $value['po_form_unique_id'] . '">-->
                  <a href="index.php?file=bill_submission/form1">
                       <button type="button" id="btn" class="btn btn-info waves-effect waves-light"> Create Bill ID</button></a>
                   <!--<button type="button" id="btn" class="btn btn-info waves-effect waves-light"><a href="index.php?file=bill_submission/update1">-->
                                Create Bill ID</a></button>
                                        <!----content start---------->
                  
                 <div class="row">
                    <div class="col-12">
                       <div class="">
                          <div class="card-body">
                             <div class="table-responsive">
                             <table id="bill_generate_datatable" class="table table-bordered nowrap table-striped align-middle">
                                <thead>
                                   <tr>
                                      <th>S No</th>
                                      <th>PO Number </th>
                                      <th>PO Date </th>
                                      <th>Consignee </th>
                                      <th>Location</th>
                                      
                                      <th>Invoice No</th>
                                      <th>Invoice Date</th>
                                      <th>Invoice Value</th>
                                      <th>Bg Status</th>
                                      <!--<th>Selection</th>-->
                                   </tr>
                                </thead>
                                <tbody>
                                   <!--<tr>-->
                                   <!--   <td>01</td>-->
                                   <!--   <td>ELT-001</td>-->
                                   <!--   <td>01-11-2023</td>-->
                                   <!--   <td>ABC Infotech</td>-->
                                   <!--   <td>Chennai</td>-->
                                   <!--   <td>1001</td>-->
                                   <!--   <td>30-10-2023</td>-->
                                   <!--   <td>20</td>-->
                                   <!--   <td><input class="form-check-input" type="checkbox" id="formCheck1">-->
                                   <!--      <a href="#"><i class="mdi mdi-download-circle-outline"></i> Download</a>-->
                                   <!--   </td>-->

                                   <!--</tr>-->

                                </tbody>
                             </table>
                             </div>
                          </div>
                       </div>
                    </div>
                 </div>
                         <!--<input type="text" id="bill_form_main_unique_id" name="bill_form_main_unique_id" class="form-control" value="<?php echo $form_main_unique_id ?>">-->
						  <!-- <input type="hidden" id="po_num" name="po_num" class="form-control"  value="<?php echo $po_num ?>">-->
						  <!--<input type="hidden" id="po_date" name="po_date" class="form-control"  value="<?php echo $po_date ?>">-->
						  <!--<input type="hidden" id="con_contact_name" name="con_contact_name" class="form-control"  value="<?php echo $con_contact_name ?>">-->
						  <!--<input type="hidden" id="con_address" name="con_address" class="form-control"  value="<?php echo $con_address ?>">-->
						  <!--<input type="text" id="invoice_no" name="invoice_no" class="form-control"  value="<?php echo $invoice_no ?>">-->
						  <!--<input type="hidden" id="invoice_date" name="invoice_date" class="form-control"  value="<?php echo $invoice_date ?>">-->
						  <!--<input type="hidden" id="invoice_value" name="invoice_value" class="form-control"  value="<?php echo $invoice_value ?>">-->
						  <!--<input type="hidden" id="file_name" name="file_name" class="form-control"  value="<?php echo $file_name ?>">-->
						  <!--<input type="hidden" id="consignee_unique_id" name="consignee_unique_id" class="form-control"  value="<?php echo $result_values[0]["consignee_unique_id"];?>">-->
						  <!--<input type="hidden" id="unique_id" name="unique_id" class="form-control" value="<?php echo $result_values_data[0]["unique_id"]?>">-->
						  <!--<input type="hidden" id="invoice_qty" name="invoice_qty" value="<?php echo $invoice_qty; ?>">-->
						  
                 <!----content start---------->


              </div>

           </div>
        </div><!-- end card-body -->
     </div><!-- end card -->
  </div>
  <!--end col-->
  </div>
  <!--end row-->
 
