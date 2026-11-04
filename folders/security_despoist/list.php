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

table.dataTable thead tr th{
        text-align:center;
    }
  span.text-right {
    text-align: right;
}
span.d-block {
    display: block;
}
</style>



<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Partial Payment</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Form</a></li>
                    <li class="breadcrumb-item active">Partial Payment</li>
                </ol>
            </div>
        </div>
        <div>
         <!-- <button type="button" id="export" name="export" class="btn btn-primary  waves-effect waves-light wavw  mb-2 mt-2">
         <i class="ri-file-excel-2-fill"></i>
        </button> -->
     </div>
    </div>
</div>
<?php
$pages = $_GET['page'];
?>
<input type="hidden" name="tabs_val" id="tabs_val" value="<?php echo $pages; ?>">
<!----content start---------->
<div class="col-xxl-12">
    <div class="card">
        <div class="card-body">
            <ul class="nav nav-pills arrow-navtabs  bg-light mb-3" role="tablist">
                <li class="nav-item" >
                    <!--onclick="dispatch_transist()"-->
                    <a class="nav-link active" id="testdemo" data-bs-toggle="tab" href="#arrow-profile" role="tab" onclick="up_fun(event)">
                        <span class="d-block d-sm-none"><i class="mdi mdi-account"></i></span>
                        <span class="d-none d-sm-block">Partially Payment</span>
                    </a>
                </li>
                <!-- <li class="nav-item">
                    <a class="nav-link" id="sd_bs" data-bs-toggle="tab" href="#partial_arrow-tab" role="tab"
                        onclick="sd_bills(event)">
                        <span class="d-block d-sm-none"><i class="mdi mdi-account"></i></span>
                        <span class="d-none d-sm-block">SD Bill ID</span>
                    </a>
                </li> -->

                <!-- <li class="nav-item">
                <a class="nav-link" id="comp" data-bs-toggle="tab" href="#arrow-tab" role="tab"
                    onclick="complteds(event)">
                    <span class="d-block d-sm-none"><i class="mdi mdi-account"></i></span>
                    <span class="d-none d-sm-block">Complete Tab</span>
                </a>
                 </li> -->
                <li class="nav-item">
                    <a class="nav-link" id="comp" data-bs-toggle="tab" href="#comp1" role="tab" onclick="complteds(event)">SD Complete</a>
                </li> 
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane active" id="testdemo1" id="arrow-overview" role="tabpanel">

               <div class="d-flex justify-content-end mt-3">
    <div id="add_btn">
        <a href="index.php?file=security_despoist/partial_payment">
            <button type="button" id="btn" class="btn btn-success waves-effect waves-light">
                Create Bill
            </button>
        </a>
    </div>
</div>

               
                    <!-- <div class="tab-pane" id="arrow-profile" role="tabpanel"> -->
                    <div class="row">
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
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <select class="form-select mb-3" id="opt" name="opt">
                                            <option value="">Select Date</option>
                                            <option value="40">PO Date</option>
                                            <option value="50">Bill Date</option>
                                            <!-- <option value="6">Due Date</option> -->
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="mb-3">

                                            <button type="button" class="btn btn-primary btn-lg gos"
                                            onclick="get_data()">Go</button>
                                        </div>
                                    </div>
                                </div>
                                    <div class="table-responsive">
                                        <!-- id="security_despoist_datatable"    -->
                                        <table  id="security_despoist_datatable" class="table table-bordered table-striped align-middle">
                                            <thead>
                                            <tr>
                                                   <th>S.No</th>
                                                    <th>Bill No / Date </th>
                                                   <th>PO No / Date </th>
                                                   <th>Invoice No / Date</th>
                                                   <th>Customer Name</th>
                                                   <th>Invoice Value</th>
                                                   <th>Claim %</th>
                                                   <th>Claim Value</th>
                                                  <!-- <th>BG</th> -->
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
                
                <!-- fixed-header  -->
                
                <!----content start---------->

                <div class="tab-pane" id="sd_bs1" id="partial_arrow-tab" role="tabpanel">
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
                                        <table id="partial_bill_datatable"
                                            class="table table-bordered nowrap table-striped align-middle">
                                            <thead>
                                            <tr>
                                                <th>Selection</th>
                                                <th>S.No</th>
                                                <th>BG No / Date </th>
                                                <!-- / BG.ID -->
                                                <th>PO No / Date  </th>
                                                 <th>Invoice No / Date</th>
                                                <th>Customer Name</th>
                                                <!-- <th>Customer No</th> -->
                                                <th>Invoice Qty</th>
                                                <th>Invoice Value</th>
                                                <!-- <th>Consignee</th> -->
                                                <!-- <th>Location</th> -->
                                                <th>Claim (%)</th>
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
                                            <button type="button" class="btn btn-primary waves-effect waves-light"
                                            onclick="partial_bill_create()">Save</button>
                                            <!-- <button type="button" class="btn btn-primary waves-effect waves-light" onclick="po_invoice_create()">Save</button> -->
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>  
                    </div>

                </div>  <!-- tab content clse-->


                <div class="tab-pane" id="comp1" id="arrow-profile" role="tabpanel">
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
                                            <input type="date" class="form-control" id="from_date_com" name="from_date_com">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label from-date-label">To Date</label>
                                            <input type="date" class="form-control" id="to_date_com" name="to_date_com">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <select class="form-select mb-3" id="opt1" name="opt1">
                                            <option value="">Select Date</option>
                                            <option value="40">PO Date</option>
                                            <option value="50">Bill Date</option>
                                            <!-- <option value="6">Due Date</option> -->
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="mb-3">

                                            <button type="button" class="btn btn-primary btn-lg gos"
                                            onclick="get_data_com()">Go</button>
                                        </div>
                                    </div>
                                </div>
                                <div id="list_3">
                                    <div class="table-responsive">
                                        <table id="bill_generate_datatable"
                                            class="table table-bordered table-striped align-middle">
                                            <thead>
                                            <tr>
                                                <th>S.No</th>
                                                <th>Bill No / Bill Date</th>
                                                <th>PO No /  Date </th>
                                                <th>Customer Name</th>
                                                <th>Invoice count</th>
                                                <th>Invoice Value</th>
                                                <th>Claim (%)</th>
                                                <th>Claim Amount</th>
                                                <th>Bg Status</th>
                                                <th>View</th>
                                        
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
            </div><!-- end card-body -->
        </div>  <!-- tab content clse-->
    </div><!-- end card -->
</div>
        <!--end col-->
</div>

<script>
$(document).ready(function () {
    // Export button click
    $("#export").click(function () {
        window.location = "folders/payment/excel.php";
    });

    // Tab initialization based on value
    const tabVal = $('#tabs_val').val();

    function activateTab(navId, paneId) {
        $('.nav-link').removeClass('active');
        $('.tab-pane').removeClass('active show');

        $('#' + navId).addClass('active');
        $('#' + paneId).addClass('active show');
    }

    if (tabVal === '1') {
        activateTab('sd_bs', 'sd_bs1');
    } else if (tabVal === '2') {
        activateTab('comp', 'comp1');
    } else {
        activateTab('testdemo', 'testdemo1'); // default
    }

    // Load table data
    get_data_com();
    // alert();
});

// "Partially Payment" tab function
function up_fun(event) {
    event.preventDefault();
    $('#tabs_val').val('');
    activateTab('testdemo', 'testdemo1');

    const url = 'http://122.165.127.123:35267/otm_beta/index.php?file=security_despoist/list';
    window.location.href = url;
}

// "SD Bill ID" tab function
function sd_bills(event) {
    event.preventDefault();
    $('#tabs_val').val('1');
    activateTab('sd_bs', 'sd_bs1');

    const url = 'http://122.165.127.123:35267/otm_beta/index.php?file=security_despoist/list&page=1';
    window.location.href = url;
}

// "Complete Tab" function
function complteds(event) {
    event.preventDefault();
    $('#tabs_val').val('2');
    activateTab('comp', 'comp1');

    const url = 'http://122.165.127.123:35267/otm_beta/index.php?file=security_despoist/list&page=2';
    window.location.href = url;
}

// Generic function to activate tab (shared between tab changes)
function activateTab(navId, paneId) {
    $('.nav-link').removeClass('active');
    $('.tab-pane').removeClass('active show');

    $('#' + navId).addClass('active');
    $('#' + paneId).addClass('active show');
}
 function get_data_com() {
      //  alert(get_data_com);
      sub_list_datatable('bill_generate_datatable', form_name, 'bill_generate_datatable');
   }

   function sub_list_datatable(table_id = "", form_name = "", action = "") {
      // alert();
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
    //   alert(opt1);
      var data = {

         "action": 'bill_generate_datatable',
         "from_date": from_date,
         "to_date": to_date,
         "opt1": opt1,
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
         dom: 'Bfrtip',
         buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
         ],
         lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
         pageLength: 10 // Default selected value
      });
   }


//    // partial_bill_create    start
//    function partial_bill_create() {
//       // alert();
//       var internet_status = is_online();

//       const checked = document.querySelectorAll('.myCheck:checked');
//       var invoice_qty_total = [];
//       var invoice_qty_amt = [];
//       var invoice_tot = [];
//       // for (var i = 0; i < checked.length; i++) {
//       // alert(i);
//       //  for (var i = 0; i < checked.length; i++){
//       // alert(i);
//       // var checkbox_qty_val = checkbox_qty.length;
//       // var bill_form_unique_id = document.getElementById('bill_form_unique_id').value;
//       for (var i = 0; i < checked.length; i++) {
//          // Get the unique identifier for each row
//          var checkbox = checked[i];
//          var bill_form_unique_id = checkbox.parentElement.querySelector('#bill_form_unique_id').value;
//          var po_num = checkbox.parentElement.querySelector('#po_num').value;
//          // alert(po_num);
//          var invoice_date = checkbox.parentElement.querySelector('#invoice_date').value;
//          var po_date = checkbox.parentElement.querySelector('#po_date').value;
//          // var invoice_qty_val = checkbox.parentElement.querySelector('#invoice_qty').value;
//          // alert(invoice_qty);
//          var parentElement = checked[i].parentElement;
//          var invoice_value_val = parentElement.querySelector('#invoice_value').value;
//          var claim_amount = parentElement.querySelector('#claim_amount').value;
//          // var con_address = parentElement.querySelector('#con_address').value;

//          var invoice_qty_val = parentElement.querySelector('#invoice_qty').value;
//          // alert(invoice_qty_val);
//          var invoice_no = parentElement.querySelector('#invoice_no').value;
//          // alert(invoice_no);

//          invoice_tot.push(invoice_no);

//          var bg_num_val = parentElement.querySelector('#bg_num').value;
//          // alert(bg_num_val);
//          //   var bg_id_val = parentElement.querySelector('#bg_id').value;
//          var bg_date_val = parentElement.querySelector('#bg_date').value;
//          var bg_value_val = parentElement.querySelector('#bg_value').value;

//          var amount = parseFloat(invoice_value_val);
//          if (!isNaN(amount)) {
//             invoice_qty_amt.push(amount);
//             var sum_of_checkbox_value = invoice_qty_amt.reduce(function (total, current) {
//                return total + current;
//             }, 0);
//          }
//          // total qty calculate
//          var number = parseFloat(invoice_qty_val);
//          if (!isNaN(number)) {
//             invoice_qty_total.push(number);
//             var sum_of_invoice_qty = invoice_qty_total.reduce(function (total, current) {
//                return total + current;
//             }, 0);
//          }
//       }
//       // alert(sum_of_invoice_qty);
//       invoice_nos = invoice_tot.join(",");
//       // alert(invoice_nos);
//       // alert(invoice_nos);
//       // "&con_contact_name=" + con_contact_name + "&con_address=" + con_address +"&consignee_unique_id=" + consignee_unique_id +
//       var data = "bill_form_unique_id=" + bill_form_unique_id + "&po_num=" + po_num + "&po_date=" + po_date + "&invoice_no=" + invoice_nos + "&invoice_date=" + invoice_date + "&invoice_value=" + sum_of_checkbox_value + "&invoice_qty=" + sum_of_invoice_qty + "&bg_num=" + bg_num_val + "&bg_date=" + bg_date_val + "&bg_value=" + bg_value_val + "&claim_amount=" + claim_amount;
//       // + "&checkbox_qty=" + checkbox_qty_val
//       //var data="bill_form_unique_id=" +bill_form_unique_id + "&consignee_unique_id=" + consignee_unique_id;
//       data += "&action=partial_bill_main";
//       var ajax_url = sessionStorage.getItem("folder_crud_link");
//       var url = sessionStorage.getItem("list_link");
//       $.ajax({
//          type: "POST",
//          url: ajax_url,
//          data: data,
//          beforeSend: function () {
//             $(".po_delivery_add_update_btn").attr("disabled", "disabled");
//             $(".po_delivery_add_update_btn").text("Loading...");
//          },
//          success: function (data) {
//             // alert(data);
//          },
//          error: function (data) {
//             alert("Network Error");
//          }
//       });
//       partial_bill_creation_sub();
//    }


//    function partial_bill_creation_sub() {
//       // alert('hi');
//       // var stock_qty = document.getElementsByName('stock_qty[]');
//       // var checkbox_qty = document.getElementsByName('bill_checkbox[]');
//       const checked = document.querySelectorAll('.myCheck:checked');
//       //  var checkbox_qty_length = checkbox_qty.length;
//       for (var i = 0; i < checked.length; i++) {
//          var checkbox = checked[i];
//          // var bill_form_unique_id = document.getElementById('bill_form_unique_id').value;
//          var bill_form_unique_id = checkbox.parentElement.querySelector('#bill_form_unique_id').value;
//          // alert(bill_form_unique_id);
//          // var po_num = document.getElementById('po_num').value;
//          var po_num = checkbox.parentElement.querySelector('#po_num').value;
//          // alert(po_num);
//          // var po_date = document.getElementById('po_date').value;
//          var po_date = checkbox.parentElement.querySelector('#po_date').value;
         
//   var claim_amount = checkbox.parentElement.querySelector('#claim_amount').value;


//          // alert(po_date);
//          // var con_contact_name = checkbox.parentElement.querySelector('#con_contact_name').value;
//          // alert(con_contact_name);
//          // var con_address = checkbox.parentElement.querySelector('#con_address').value;
//          //    alert(con_address);
//          // var con_contact_name = document.getElementById('con_contact_name').value;
//          // alert(con_contact_name);
//          // var con_address = document.getElementById('con_address').value;
//          // alert(con_address);
//          // var consignee_unique_id = checkbox.parentElement.querySelector('#consignee_unique_id').value;
//          // var consignee_unique_id = document.getElementById('consignee_unique_id').value;
//          var invoice_date = checkbox.parentElement.querySelector('#invoice_date').value;
//          //   var invoice_auto_id_val = checkbox.parentElement.querySelector('#invoice_auto_id').value;
//          // alert(invoice_auto_id_val);
//          var parentElement = checked[i].parentElement;
//          var invoice_qty_val = parentElement.querySelector('#invoice_qty').value;
//          // alert(invoice_qty_val);
//          var invoice_val = parentElement.querySelector('#invoice_value').value;
//          // alert(invoice_val);
//          var invoice_no_val = parentElement.querySelector('#invoice_no').value;

//          var data = "bill_form_unique_id=" + bill_form_unique_id + "&invoice_no=" + invoice_no_val + "&invoice_date=" + invoice_date + "&invoice_value=" + invoice_val + "&invoice_qty=" + invoice_qty_val + "&po_num=" + po_num + "&po_date=" + po_date + "&claim_amount=" + claim_amount;
// ;
//          // + "&con_contact_name=" + con_contact_name + "&con_address=" + con_address + "&consignee_unique_id=" + consignee_unique_id
//          // + "&checkbox_qty=" + checkbox_qty_val
//          data += "&action=partial_bill_creation_add_update";
//          var ajax_url = sessionStorage.getItem("folder_crud_link");
//          var url = sessionStorage.getItem("list_link");
//          $.ajax({
//             type: "POST",
//             url: ajax_url,
//             data: data,
//             beforeSend: function () {
//                $(".po_delivery_add_update_btn").attr("disabled", "disabled");
//                $(".po_delivery_add_update_btn").text("Loading...");
//             },
//             success: function (data) {
//                // alert(data);
//                var obj = JSON.parse(data);
//                var msg = obj.msg;
//                var status = obj.status;
//                var error = obj.error;
//                // alert(msg);
//                if (!status) {
//                   url = '';
//                   $(".createupdate_btn").text("Error");
//                   console.log(error);
//                } else {
//                   if (msg == "already") {
//                      // Button Change Attribute
//                      url = '';
//                      $(".createupdate_btn").removeAttr("disabled", "disabled");
//                      if (unique_id) {
//                         $(".createupdate_btn").text("Update");
//                      } else {
//                         $(".createupdate_btn").text("Save");
//                      }
//                   }
//                }
//                // location.reload();
//                var xx = document.getElementById('tabs_val').value;
//                // alert(xx);
//                //   const url = 'http://122.165.127.123:41290/aed_elcot_beta/index.php?file=elcot_entry/list&page=2';
//                var urls = 'http://122.165.127.123:35267/otm_beta/index.php?file=security_despoist/list&page=1';
//                // var urls = 'http://localhost/aed_elcot/index.php?file=elcot_entry/list&page=2';
//                if (xx == '1') {
//                   sweetalert(msg, urls);
//                 //   sweetalert(msg);

//                } else {
//                   sweetalert(msg, url);
//                 //   sweetalert(msg);

//                }
//             },
//             error: function (data) {
//                alert("Network Error");
//             }
//          });
//          // }
//       }
//    }
</script>

