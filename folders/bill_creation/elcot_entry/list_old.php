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

     button#export1 {
        float: right;
        padding: 4px 9px;
     }

     #btn {
        margin-left: 88%;
     }
     span.po_date {
    white-space: nowrap;
}
  </style>
  <?php
//  $screen_id = isset($_GET['screen_id']) ? htmlspecialchars($_GET['screen_id']) : '';
$screen_id_val='641ada5bcf8e027007';
// print_r($screen_id);
   session_start();
  $user_type_unique_id = $_SESSION['user_type_unique_id'];
  ?>
  <?php include 'function.php';
   include '../../config/dbconfig.php'; ?>
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
            $file_name_po = image_view("po_form", $result_values[0]['consignee_unique_id'], $result_values[0]['file_name']);
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
           <h4 class="mb-sm-0"> Elcot Entry Form</h4>
           <input type="hidden" id="screen_id_val" name="screen_id_val" class="form-control" value="<?php echo $screen_id_val;?>">
                <input type="hidden" id="user_type_unique_id" name="user_type_unique_id" class="form-control" value="<?php echo $user_type_unique_id;?>">

           <div class="page-title-right">
              <ol class="breadcrumb m-0">
                 <li class="breadcrumb-item"><a href="javascript: void(0);">Settings</a></li>
                 <li class="breadcrumb-item active">Elcot Entry</li>
              </ol>
           </div>
        </div>
     </div>
  </div>
  <div class="col-xxl-12 mt-4">
     <div class="card">
        <div class="card-body">
           <ul class="nav nav-pills arrow-navtabs  bg-light mb-3" role="tablist">
              <li class="nav-item">
                 <a class="nav-link" data-bs-toggle="tab" href="#arrow-overview" role="tab">
                    <span class="d-block d-sm-none"><i class="mdi mdi-home-variant"></i></span>
                    <span class="d-none d-sm-block">Upload</span>
                 </a>
              </li>
              <li class="nav-item">
                 <a class="nav-link active" data-bs-toggle="tab" href="#arrow-tab" role="tab">
                    <span class="d-block d-sm-none"><i class="mdi mdi-account"></i></span>
                    <span class="d-none d-sm-block">Create Bill ID</span>
                 </a>
              </li>
              <li class="nav-item">
                 <a class="nav-link" data-bs-toggle="tab" href="#partial_arrow-tab" role="tab">
                    <span class="d-block d-sm-none"><i class="mdi mdi-account"></i></span>
                    <span class="d-none d-sm-block">SD Bill ID</span>
                 </a>
              </li>
              <li class="nav-item">
                 <a class="nav-link" data-bs-toggle="tab" href="#arrow-profile" role="tab">
                    <span class="d-block d-sm-none"><i class="mdi mdi-account"></i></span>
                    <span class="d-none d-sm-block">Complete</span>
                 </a>
              </li>
           </ul>
           <!-- Tab panes -->
           <div class="tab-content">
              <div class="tab-pane " id="arrow-overview" role="tabpanel">
                 <button type="button" id="export" name="export" class="btn btn-primary  waves-effect waves-light wavw  mb-2 mt-2">
                    <i class="ri-file-excel-2-fill"></i>
                 </button>
                 <div class="row">
                    <div class="col-12">
                       <div class="">
                          <div class="card-body">
                          <div class="row align-items-end">
                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <label class="form-label from-date-label">From Date</label>
                                                    <input type="date" class="form-control" id="from_date"
                                                        name="from_date" >
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
                                                    <select class="select2 form-control"  id="opt" name="opt" >
                                                        <option value="">Select Date</option>
                                                        <option value="4">PO Date</option>
                                                        <option value="5">Invoice Date</option>
                                                        <!-- <option value="6">Due Date</option> -->
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <div class="mb-3">

                                                    <button type="button" class="btn btn-primary btn-lg"
                                                        onclick="get_data()">Go</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="list">
                             <div class="table-responsive">
                                <table id="bill_submission_datatable" class="table table-bordered table-striped align-middle">
                                   <thead>
                                      <tr>
                                         <th>S No</th>
                                         <th>PO Number </th>
                                         <th>PO Date </th>
                                         <!-- <th>Department </th> -->
                                         <th>Ledger Name</th>
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
              <!-- 2tab -->

              <div class="tab-pane active" id="arrow-tab" role="tabpanel">
                 <!--<a href="index.php?file=dispatch/update1&unique_id=' . $value['po_form_unique_id'] . '">-->
                 <!-- <a href="index.php?file=elcot_entry/form1"> -->
                 <!-- <button type="button" id="btn" class="btn btn-info waves-effect waves-light"> Create Bill ID</button></a> -->
                 <!-- <div style="text-align:right;"> -->
                 <!-- <button type="button" id="export1" name="export1" class="btn btn-primary  waves-effect waves-light wavw  mb-2 mt-2">
                    <i class="ri-file-excel-2-fill"></i>
                 </button> -->
                 <!-- </div> -->
                 <!--<button type="button" id="btn" class="btn btn-info waves-effect waves-light"><a href="index.php?file=bill_submission/update1">-->
                 <!-- Create Bill ID</a></button> -->
                 <!----content start---------->
                 <div class="row">
                    <div class="col-12">
                       <div class="">
                          <div class="card-body">
                          <div id="list_1">
                             <div class="table-responsive">
                                <table id="bill_datatable" class="table table-bordered nowrap table-striped align-middle">
                                   <thead>
                                      <tr>
                                         <th>Selection</th>
                                         <th>S No</th>
                                         <th>BG.No / BG.ID</th>
                                         <th>BG Date</th>
                                         <th>PO Number </th>
                                         <th>PO Date </th>
                                         <!-- <th>invoice count</th> -->
                                         <th>invoice Qty</th>
                                         <th>Invoice Value</th>
                                         <th>Invoice No</th>
                                         <th>Invoice Date</th>
                                         <th>Consignee</th>
                                         <th>Location</th>
                                         <th>Claim Amount</th>
                                         <th>DC</th>
                                         <th>IR</th>
                                         <th>SNR</th>
                                         <th>INV</th>
                                         <th>Installation Ref no</th>
                                         <th>Supplier Inv No</th>
                                      </tr>
                                   </thead>
                                   <tbody>
                                      <!-- id="data_table" -->
                                      <!-- <tr ></tr> -->
                                   </tbody>
                                </table>
                             </div>
                             </div>
                             <div class="col-12 mt-3">
                                <div class="form-group row ">
                                   <div class="col-md-12" align="right">
                                      <!-- Cancel,save and update Buttons -->
                                      <!--<button type="button" class="btn btn-primary waves-effect waves-light" onclick="po_invoice_create()">Update</button>-->
                                      <?php echo btn_cancel($btn_cancel); ?>
                                      <input type="hidden" name="active_tab" id="active_tab" value="">
                                      <button type="button" class="btn btn-primary waves-effect waves-light" onclick="po_invoice_create()">Save</button>
                                      <!-- <button type="button" class="btn btn-primary waves-effect waves-light" onclick="po_invoice_create()">Save</button> -->
                                   </div>
                                </div>
                             </div>
                          </div>
                       </div>
                    </div>
                 </div>
                 <!----content start---------->
              </div>

              <!-- 2tab end -->


               <!-- 3tab -->

               <div class="tab-pane" id="partial_arrow-tab" role="tabpanel">
                 <!--<a href="index.php?file=dispatch/update1&unique_id=' . $value['po_form_unique_id'] . '">-->
                 <!-- <a href="index.php?file=elcot_entry/form1"> -->
                 <!-- <button type="button" id="btn" class="btn btn-info waves-effect waves-light"> Create Bill ID</button></a> -->
                 <!-- <div style="text-align:right;"> -->
                 <!-- <button type="button" id="export1" name="export1" class="btn btn-primary  waves-effect waves-light wavw  mb-2 mt-2">
                    <i class="ri-file-excel-2-fill"></i>
                 </button> -->
                 <!-- </div> -->
                 <!--<button type="button" id="btn" class="btn btn-info waves-effect waves-light"><a href="index.php?file=bill_submission/update1">-->
                 <!-- Create Bill ID</a></button> -->
                 <!----content start---------->
                 <div class="row">
                    <div class="col-12">
                       <div class="">
                          <div class="card-body">
                          <div id="list_2">
                             <div class="table-responsive">
                                <table id="partial_bill_datatable" class="table table-bordered nowrap table-striped align-middle">
                                   <thead>
                                      <tr>
                                         <th>Selection</th>
                                         <th>S No</th>
                                         <th>BG.No / BG.ID</th>
                                         <th>BG Date</th>
                                         <th>PO Number </th>
                                         <th>PO Date </th>
                                         <!-- <th>invoice count</th> -->
                                         <th>invoice Qty</th>
                                         <th>Invoice Value</th>
                                         <th>Invoice No</th>
                                         <th>Invoice Date</th>
                                         <th>Consignee</th>
                                         <th>Location</th>
                                         <th>Claim Amount</th>
                                      </tr>
                                   </thead>
                                   <tbody>
                                      <!-- id="data_table" -->
                                      <!-- <tr ></tr> -->
                                   </tbody>
                                </table>
                             </div>
                             </div>
                             <div class="col-12 mt-3">
                                <div class="form-group row ">
                                   <div class="col-md-12" align="right">
                                      <!-- Cancel,save and update Buttons -->
                                      <!--<button type="button" class="btn btn-primary waves-effect waves-light" onclick="po_invoice_create()">Update</button>-->
                                      <?php echo btn_cancel($btn_cancel); ?>
                                      <button type="button" class="btn btn-primary waves-effect waves-light" onclick="partial_bill_create()">Save</button>
                                      <!-- <button type="button" class="btn btn-primary waves-effect waves-light" onclick="po_invoice_create()">Save</button> -->
                                   </div>
                                </div>
                             </div>
                          </div>
                       </div>
                    </div>
                 </div>
                 <!----content start---------->
              </div>

              <!-- 3tab end -->
              <div class="tab-pane" id="arrow-profile" role="tabpanel">
                 <!--<a href="index.php?file=dispatch/update1&unique_id=' . $value['po_form_unique_id'] . '">-->
                 <!-- <a href="index.php?file=elcot_entry/form1">
                    <button type="button" id="btn" class="btn btn-info waves-effect waves-light"> Create Bill ID</button></a> -->
                 <!-- <div style="text-align:right;"> -->
                 <!-- <button type="button" id="export1" name="export1" class="btn btn-primary  waves-effect waves-light wavw  mb-2 mt-2">
                    <i class="ri-file-excel-2-fill"></i>
                 </button> -->
                 <!-- </div> -->
                 <!--<button type="button" id="btn" class="btn btn-info waves-effect waves-light"><a href="index.php?file=bill_submission/update1">-->
                 <!-- Create Bill ID</a></button> -->
                 <!----content start---------->
                 <div class="row">
                    <div class="col-12">
                       <div class="">
                          <div class="card-body">
                          <div class="row align-items-end">
                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <label class="form-label from-date-label">From Date</label>
                                                    <input type="date" class="form-control" id="from_date_com"
                                                        name="from_date_com" >
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <label class="form-label from-date-label">To Date</label>
                                                    <input type="date" class="form-control" id="to_date_com" name="to_date_com"
                                                      >
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <select class="form-select mb-3" id="opt1" name="opt1">
                                                        <option value=""></option>
                                                        <option value="40">PO Date</option>
                                                        <option value="50">Invoice Date</option>
                                                        <!-- <option value="6">Due Date</option> -->
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <div class="mb-3">

                                                    <button type="button" class="btn btn-primary btn-lg"
                                                        onclick="get_data_com()">Go</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="list_3">
                             <div class="table-responsive">
                                <table id="bill_generate_datatable" class="table table-bordered table-striped align-middle">
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
                                         <th>Bg Status</th>
                                         <!--<th>Selection</th>-->
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
                 <!----content start---------->
              </div>
           </div>
        </div><!-- end card-body -->
     </div><!-- end card -->
  </div>
  <!--end col-->
  </div>
  <!--end row-->
  <script>
     $("#export").click(function() {
        // alert("hi");
        window.location = "folders/elcot_entry/excel.php";
     });

     $("#export1").click(function() {
        // alert("hi");
        window.location = "folders/elcot_entry/excel1.php";
     });
  </script>
  <script>










     function po_invoice_create() {
        var internet_status = is_online();
        //  var checkbox_qty = document.getElementById('checkbox').value;
        // var checkbox_qty = document.getElementsByName('bill_checkbox[]');
        const checked = document.querySelectorAll('.myCheck:checked');
        var invoice_qty_total = [];
        var invoice_qty_amt = [];
        var invoice_tot = [];
        // for (var i = 0; i < checked.length; i++) {
        // alert(i);
        //  for (var i = 0; i < checked.length; i++){
        // alert(i);
        // var checkbox_qty_val = checkbox_qty.length;
        // var bill_form_unique_id = document.getElementById('bill_form_unique_id').value;
        for (var i = 0; i < checked.length; i++) {
           // Get the unique identifier for each row
           var checkbox = checked[i];
           var bill_form_unique_id = checkbox.parentElement.querySelector('#bill_form_unique_id').value;
           var po_num = checkbox.parentElement.querySelector('#po_num').value;
           // alert(po_num);
           var invoice_date = checkbox.parentElement.querySelector('#invoice_date').value;
           var po_date = checkbox.parentElement.querySelector('#po_date').value;
           // var invoice_qty_val = checkbox.parentElement.querySelector('#invoice_qty').value;
           // alert(invoice_qty);
           var parentElement = checked[i].parentElement;
           var invoice_value_val = parentElement.querySelector('#invoice_value').value;
           var claim_amount = parentElement.querySelector('#claim_amount').value;
           var con_address = parentElement.querySelector('#con_address').value;

           var invoice_qty_val = parentElement.querySelector('#invoice_qty').value;
           // alert(invoice_qty_val);
           var invoice_no = parentElement.querySelector('#invoice_no').value;
           // alert(invoice_no);

           invoice_tot.push(invoice_no);

           var bg_num_val = parentElement.querySelector('#bg_num').value;
           // alert(bg_num_val);
           var bg_id_val = parentElement.querySelector('#bg_id').value;
           var bg_date_val = parentElement.querySelector('#bg_date').value;
           var bg_value_val = parentElement.querySelector('#bg_value').value;

           var amount = parseFloat(invoice_value_val);
           if (!isNaN(amount)) {
              invoice_qty_amt.push(amount);
              var sum_of_checkbox_value = invoice_qty_amt.reduce(function(total, current) {
                 return total + current;
              }, 0);
           }
           // total qty calculate
           var number = parseFloat(invoice_qty_val);
           if (!isNaN(number)) {
              invoice_qty_total.push(number);
              var sum_of_invoice_qty = invoice_qty_total.reduce(function(total, current) {
                 return total + current;
              }, 0);
           }
        }
        // alert(sum_of_invoice_qty);
        invoice_nos = invoice_tot.join(",");
        // alert(invoice_nos);
        // alert(invoice_nos);
        // "&con_contact_name=" + con_contact_name + "&con_address=" + con_address +"&consignee_unique_id=" + consignee_unique_id +
        var data = "bill_form_unique_id=" + bill_form_unique_id + "&po_num=" + po_num + "&po_date=" + po_date + "&invoice_no=" + invoice_nos + "&invoice_date=" + invoice_date + "&invoice_value=" + sum_of_checkbox_value + "&invoice_qty=" + sum_of_invoice_qty + "&bg_num=" + bg_num_val + "&bg_id=" + bg_id_val + "&bg_date=" + bg_date_val + "&bg_value=" + bg_value_val + "&claim_amount=" + claim_amount + "&con_address=" + con_address;
        // + "&checkbox_qty=" + checkbox_qty_val
        //var data="bill_form_unique_id=" +bill_form_unique_id + "&consignee_unique_id=" + consignee_unique_id;
        data += "&action=demo";
        var ajax_url = sessionStorage.getItem("folder_crud_link");
        var url = sessionStorage.getItem("list_link");
        $.ajax({
           type: "POST",
           url: ajax_url,
           data: data,
           beforeSend: function() {
              $(".po_delivery_add_update_btn").attr("disabled", "disabled");
              $(".po_delivery_add_update_btn").text("Loading...");
           },
           success: function(data) {
              // alert(data);
           },
           error: function(data) {
              alert("Network Error");
           }
        });
        bill_creation_sub();
     }


     function bill_creation_sub() {
        // var stock_qty = document.getElementsByName('stock_qty[]');
        // var checkbox_qty = document.getElementsByName('bill_checkbox[]');
        const checked = document.querySelectorAll('.myCheck:checked');
        //  var checkbox_qty_length = checkbox_qty.length;
        for (var i = 0; i < checked.length; i++) {
           var checkbox = checked[i];
           // var bill_form_unique_id = document.getElementById('bill_form_unique_id').value;
           var bill_form_unique_id = checkbox.parentElement.querySelector('#bill_form_unique_id').value;
           // alert(bill_form_unique_id);
           // var po_num = document.getElementById('po_num').value;
           var po_num = checkbox.parentElement.querySelector('#po_num').value;
           // alert(po_num);
           // var po_date = document.getElementById('po_date').value;
           var po_date = checkbox.parentElement.querySelector('#po_date').value;
           // alert(po_date);
           var con_contact_name = checkbox.parentElement.querySelector('#con_contact_name').value;
           // alert(con_contact_name);
           var con_address = checkbox.parentElement.querySelector('#con_address').value;
           //    alert(con_address);
           // var con_contact_name = document.getElementById('con_contact_name').value;
           // alert(con_contact_name);
           // var con_address = document.getElementById('con_address').value;
           // alert(con_address);
           var consignee_unique_id = checkbox.parentElement.querySelector('#consignee_unique_id').value;
           // var consignee_unique_id = document.getElementById('consignee_unique_id').value;
           var invoice_date = checkbox.parentElement.querySelector('#invoice_date').value;
           var invoice_auto_id_val = checkbox.parentElement.querySelector('#invoice_auto_id').value;
           // alert(invoice_auto_id_val);
           var parentElement = checked[i].parentElement;
           var invoice_qty_val = parentElement.querySelector('#invoice_qty').value;
           // alert(invoice_qty_val);
           var invoice_val = parentElement.querySelector('#invoice_value').value;
           // alert(invoice_val);
           var invoice_no_val = parentElement.querySelector('#invoice_no').value;
           // alert(invoice_no_val);
           // var invoice_value = document.getElementsByName('invoice_value[]');
           // var invoice_no = document.getElementsByName('invoice_no[]');
           // var invoice_qty = document.getElementsByName('invoice_qty[]');
           // var checkbox_qty_val = checkbox_qty[i].value;
           // var invoice_no_val = invoice_no[i].value;
           // alert(invoice_no_val);
           // var invoice_val = invoice_value[i].value;
           // alert(invoice_val);
           // var invoice_qty_val = invoice_qty[i].value;
           // var invoice_date = document.getElementById('invoice_date').value;
           // var consignee_unique_id= document.getElementById('consignee_unique_id').value;
           var data = "bill_form_unique_id=" + bill_form_unique_id + "&invoice_no=" + invoice_no_val + "&invoice_date=" + invoice_date + "&invoice_value=" + invoice_val + "&invoice_qty=" + invoice_qty_val + "&po_num=" + po_num + "&po_date=" + po_date + "&con_contact_name=" + con_contact_name + "&con_address=" + con_address + "&invoice_auto_id=" + invoice_auto_id_val + "&consignee_unique_id=" + consignee_unique_id;
           // + "&checkbox_qty=" + checkbox_qty_val
           data += "&action=bill_submission_add_update";
           var ajax_url = sessionStorage.getItem("folder_crud_link");
           var url = sessionStorage.getItem("list_link");
           $.ajax({
              type: "POST",
              url: ajax_url,
              data: data,
              beforeSend: function() {
                 $(".po_delivery_add_update_btn").attr("disabled", "disabled");
                 $(".po_delivery_add_update_btn").text("Loading...");
              },
              success: function(data) {
                 // alert(data);
                 var obj = JSON.parse(data);
                 var msg = obj.msg;
                 var status = obj.status;
                 var error = obj.error;
                 // alert(msg);
                 if (!status) {
                    url = '';
                    $(".createupdate_btn").text("Error");
                    console.log(error);
                 } else {
                    if (msg == "already") {
                       // Button Change Attribute
                       url = '';
                       $(".createupdate_btn").removeAttr("disabled", "disabled");
                       if (unique_id) {
                          $(".createupdate_btn").text("Update");
                       } else {
                          $(".createupdate_btn").text("Save");
                       }
                    }
                 }
                 // location.reload();
                 sweetalert(msg, url);
              },
              error: function(data) {
                 alert("Network Error");
              }
           });
           // }
        }
     }


      // partial_bill_create    start
      function partial_bill_create() {
         alert();
        var internet_status = is_online();
       
        const checked = document.querySelectorAll('.myCheck:checked');
        var invoice_qty_total = [];
        var invoice_qty_amt = [];
        var invoice_tot = [];
        // for (var i = 0; i < checked.length; i++) {
        // alert(i);
        //  for (var i = 0; i < checked.length; i++){
        // alert(i);
        // var checkbox_qty_val = checkbox_qty.length;
        // var bill_form_unique_id = document.getElementById('bill_form_unique_id').value;
        for (var i = 0; i < checked.length; i++) {
           // Get the unique identifier for each row
           var checkbox = checked[i];
           var bill_form_unique_id = checkbox.parentElement.querySelector('#bill_form_unique_id').value;
           var po_num = checkbox.parentElement.querySelector('#po_num').value;
           // alert(po_num);
           var invoice_date = checkbox.parentElement.querySelector('#invoice_date').value;
           var po_date = checkbox.parentElement.querySelector('#po_date').value;
           // var invoice_qty_val = checkbox.parentElement.querySelector('#invoice_qty').value;
           // alert(invoice_qty);
           var parentElement = checked[i].parentElement;
           var invoice_value_val = parentElement.querySelector('#invoice_value').value;
           var claim_amount = parentElement.querySelector('#claim_amount').value;
           var con_address = parentElement.querySelector('#con_address').value;

           var invoice_qty_val = parentElement.querySelector('#invoice_qty').value;
           // alert(invoice_qty_val);
           var invoice_no = parentElement.querySelector('#invoice_no').value;
           // alert(invoice_no);

           invoice_tot.push(invoice_no);

           var bg_num_val = parentElement.querySelector('#bg_num').value;
           // alert(bg_num_val);
         //   var bg_id_val = parentElement.querySelector('#bg_id').value;
           var bg_date_val = parentElement.querySelector('#bg_date').value;
           var bg_value_val = parentElement.querySelector('#bg_value').value;

           var amount = parseFloat(invoice_value_val);
           if (!isNaN(amount)) {
              invoice_qty_amt.push(amount);
              var sum_of_checkbox_value = invoice_qty_amt.reduce(function(total, current) {
                 return total + current;
              }, 0);
           }
           // total qty calculate
           var number = parseFloat(invoice_qty_val);
           if (!isNaN(number)) {
              invoice_qty_total.push(number);
              var sum_of_invoice_qty = invoice_qty_total.reduce(function(total, current) {
                 return total + current;
              }, 0);
           }
        }
        // alert(sum_of_invoice_qty);
        invoice_nos = invoice_tot.join(",");
        // alert(invoice_nos);
        // alert(invoice_nos);
        // "&con_contact_name=" + con_contact_name + "&con_address=" + con_address +"&consignee_unique_id=" + consignee_unique_id +
        var data = "bill_form_unique_id=" + bill_form_unique_id + "&po_num=" + po_num + "&po_date=" + po_date + "&invoice_no=" + invoice_nos + "&invoice_date=" + invoice_date + "&invoice_value=" + sum_of_checkbox_value + "&invoice_qty=" + sum_of_invoice_qty + "&bg_num=" + bg_num_val  + "&bg_date=" + bg_date_val + "&bg_value=" + bg_value_val + "&claim_amount=" + claim_amount + "&con_address=" + con_address;
        // + "&checkbox_qty=" + checkbox_qty_val
        //var data="bill_form_unique_id=" +bill_form_unique_id + "&consignee_unique_id=" + consignee_unique_id;
        data += "&action=partial_bill_main";
        var ajax_url = sessionStorage.getItem("folder_crud_link");
        var url = sessionStorage.getItem("list_link");
        $.ajax({
           type: "POST",
           url: ajax_url,
           data: data,
           beforeSend: function() {
              $(".po_delivery_add_update_btn").attr("disabled", "disabled");
              $(".po_delivery_add_update_btn").text("Loading...");
           },
           success: function(data) {
              // alert(data);
           },
           error: function(data) {
              alert("Network Error");
           }
        });
        partial_bill_creation_sub();
     }

     function partial_bill_creation_sub() {
      // alert('hi');
        // var stock_qty = document.getElementsByName('stock_qty[]');
        // var checkbox_qty = document.getElementsByName('bill_checkbox[]');
        const checked = document.querySelectorAll('.myCheck:checked');
        //  var checkbox_qty_length = checkbox_qty.length;
        for (var i = 0; i < checked.length; i++) {
           var checkbox = checked[i];
           // var bill_form_unique_id = document.getElementById('bill_form_unique_id').value;
           var bill_form_unique_id = checkbox.parentElement.querySelector('#bill_form_unique_id').value;
           // alert(bill_form_unique_id);
           // var po_num = document.getElementById('po_num').value;
           var po_num = checkbox.parentElement.querySelector('#po_num').value;
           // alert(po_num);
           // var po_date = document.getElementById('po_date').value;
           var po_date = checkbox.parentElement.querySelector('#po_date').value;
           // alert(po_date);
           var con_contact_name = checkbox.parentElement.querySelector('#con_contact_name').value;
           // alert(con_contact_name);
           var con_address = checkbox.parentElement.querySelector('#con_address').value;
           //    alert(con_address);
           // var con_contact_name = document.getElementById('con_contact_name').value;
           // alert(con_contact_name);
           // var con_address = document.getElementById('con_address').value;
           // alert(con_address);
           var consignee_unique_id = checkbox.parentElement.querySelector('#consignee_unique_id').value;
           // var consignee_unique_id = document.getElementById('consignee_unique_id').value;
           var invoice_date = checkbox.parentElement.querySelector('#invoice_date').value;
         //   var invoice_auto_id_val = checkbox.parentElement.querySelector('#invoice_auto_id').value;
           // alert(invoice_auto_id_val);
           var parentElement = checked[i].parentElement;
           var invoice_qty_val = parentElement.querySelector('#invoice_qty').value;
           // alert(invoice_qty_val);
           var invoice_val = parentElement.querySelector('#invoice_value').value;
           // alert(invoice_val);
           var invoice_no_val = parentElement.querySelector('#invoice_no').value;
          
           var data = "bill_form_unique_id=" + bill_form_unique_id + "&invoice_no=" + invoice_no_val + "&invoice_date=" + invoice_date + "&invoice_value=" + invoice_val + "&invoice_qty=" + invoice_qty_val + "&po_num=" + po_num + "&po_date=" + po_date + "&con_contact_name=" + con_contact_name + "&con_address=" + con_address  + "&consignee_unique_id=" + consignee_unique_id;
           // + "&checkbox_qty=" + checkbox_qty_val
           data += "&action=partial_bill_creation_add_update";
           var ajax_url = sessionStorage.getItem("folder_crud_link");
           var url = sessionStorage.getItem("list_link");
           $.ajax({
              type: "POST",
              url: ajax_url,
              data: data,
              beforeSend: function() {
                 $(".po_delivery_add_update_btn").attr("disabled", "disabled");
                 $(".po_delivery_add_update_btn").text("Loading...");
              },
              success: function(data) {
                 // alert(data);
                 var obj = JSON.parse(data);
                 var msg = obj.msg;
                 var status = obj.status;
                 var error = obj.error;
                 // alert(msg);
                 if (!status) {
                    url = '';
                    $(".createupdate_btn").text("Error");
                    console.log(error);
                 } else {
                    if (msg == "already") {
                       // Button Change Attribute
                       url = '';
                       $(".createupdate_btn").removeAttr("disabled", "disabled");
                       if (unique_id) {
                          $(".createupdate_btn").text("Update");
                       } else {
                          $(".createupdate_btn").text("Save");
                       }
                    }
                 }
                 // location.reload();
                 sweetalert(msg, url);
              },
              error: function(data) {
                 alert("Network Error");
              }
           });
           // }
        }
     }

     $(document).ready(function () {
    // var table_id 	= "user_type_datatable";
    get_user_permission();
	get_user_permission_1();
	get_user_permission_2();
   get_user_permission_3();
   // sub_list_datatable('bill_generate_datatable', form_name, 'bill_generate_datatable');

   
    get_data_com();


});
function get_data_com() {
   //  alert(get_data_com);
 sub_list_datatable('bill_generate_datatable', form_name, 'bill_generate_datatable');
}
function sub_list_datatable(table_id = "", form_name = "", action = "") {
    // // alert('hii');
    // var bill_form_main_unique_id = $("#bill_form_main_unique_id").val();
    //  var invoice_no = $("#invoice_no").val();

    // alert(invoice_no);

    var table_id = 'bill_generate_datatable';
    // alert(table_id);
    var table = $("#" + table_id);
    var from_date = $("#from_date_com").val();
   //  alert(from_date);
    var to_date = $("#to_date_com").val();
   //  alert(to_date);
    var opt1 = $("#opt1").val();
   //  alert(opt);
    var data = {

        "action": 'bill_generate_datatable',
        "from_date": from_date,
        "to_date": to_date,
        "opt1" : opt1,
        //  "bill_form_main_unique_id":bill_form_main_unique_id,
        //  "invoice_no":invoice_no,

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
      dom: '<"dt-top-container"<l><"dt-center-in-div"B><f>r>t<ip>',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
}

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


function get_user_permission_2() {
	var screen_id_val = $('#screen_id_val').val();
// alert(screen_id_val);
	var user_type_unique_id = $('#user_type_unique_id').val();

	var data = {
		"screen_id_val": screen_id_val,
		"user_type_unique_id": user_type_unique_id,
		"action": 'user_permission_2',
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
			var listpage = document.getElementById('list_2');
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

function get_user_permission_3() {
	var screen_id_val = $('#screen_id_val').val();
// alert(screen_id_val);
	var user_type_unique_id = $('#user_type_unique_id').val();

	var data = {
		"screen_id_val": screen_id_val,
		"user_type_unique_id": user_type_unique_id,
		"action": 'user_permission_3',
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
			var listpage = document.getElementById('list_3');
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

  
  
