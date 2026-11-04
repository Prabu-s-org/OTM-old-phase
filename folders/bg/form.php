<?php include 'function.php';
$po_num_options   = list_of_po();
$po_num_options = select_option($po_num_options, "Select Po.No");



// $list_of_po = list_of_po();
// $list_of_po = select_option($list_of_po, "Select PO Number", );

?>
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0"> BG Create Form</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Forms</a></li>
                    <li class="breadcrumb-item active"> BG Create</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<style>
    .head_po {
        font-size: 14px;
        margin-bottom: 5px;
    }

    table.dataTable thead tr th{
        text-align:center !important;
    }
</style>
 <!-- <div class="row">
               <div class="col-md-3">
                  <div class="mb-3">
                     <label class="form-label from-date-label">Select PO No</label>
                     <select id="po_no" name="po_no" class="select2 form-control" onchange="getInvoiceNo(this.value);">
                        <?php echo $list_of_po; ?>
                     </select>
                  </div>
               </div>
               
            <div class="col-md-1 mt-3">
                  <div class="mb-3 mt-2">
                     <button type="button" class="btn btn-primary btn-lg" onclick="get_dc_number();">Go</button>
                  </div>
               </div>
</div> -->
<div class="row cf">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form class="was-validated" autocomplete="off">
                    <div class="row">
                        
                        <div class="row">
                            <div class="col-12">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-4 head_po">
                                            <div class="row">
                                                <div class="col-xl-12 head_po">
                                                    <label class="form-label">PO NO</label>
                                                    <select name="po_num" id="po_num" class="select2 form-control" onchange="get_bg_data(this.value)">
                                                        <?php echo $po_num_options; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                            <!-- 
                                         <div class="col-4 head_po">
                                            <div class="row">
                                                <div class="col-xl-12 head_po">
                                                    <label class="form-label">Dc Count</label>
                                                    
                                                </div>
                                                 <div class="col-xl-12 head_po">
                                                    <span class="form-label" id="dc_count"></span>
                                                   
                                                </div>
                                                  
                                            </div>
                                        </div> -->
                                    </div>

                                    
                                       
                                    
                                </div>
                            </div>




                        </div> 
                        <div class="table-responsive">
                            <table id="bg_create_datatable" class="table table-bordered nowrap table-striped align-middle">
                                <thead>
                                    <tr>
                                        <th>Selection</th>
                                        <th>S.No</th>
                                        <th>PO No / Date</th>
                                          <th>Invoice No / Date</th>
                                         <th>Customer Name</th>
                                        <!-- <th>Consignee </th> -->
                                        <th>Invoice Qty</th>
                                        <th>Invoice Value</th>
                                        <!-- <th>Dc Number</th> -->
                                        <!-- <th>Dc Date</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                     <!-- <div class="col-md-4" >
                  <div class="field-group">
                     <div class="label-col">PO No.</div>
                     <div class="colon-col">:</div>
                     <div class="value-col"><span id="po_num_val"></span></div>
                  </div>
               </div> -->
                    <div class="col-12 mt-3">
                        <div class="form-group row ">
                            <div class="col-md-12" align="right">
                                <!-- Cancel,save and update Buttons -->
                                <?php echo btn_cancel($btn_cancel); ?>
                                <button type="button" class="btn btn-primary waves-effect waves-light" onclick="bg_create()">Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div><!-- end col -->
        </div>
    </div>
</div>
<script>
    function bg_create() {
        // alert('hi');
        var internet_status = is_online();
        // var checkbox_qty = document.getElementsByName('invoice_check[]');
        const checked = document.querySelectorAll('.myCheck:checked');
        var invoice_qty_total = [];
        var invoice_tot_amt = [];
        var invoice_tot = [];
        for (var i = 0; i < checked.length; i++) {
            var checkbox = checked[i];
            var form_unique_id = checkbox.parentElement.querySelector('#form_unique_id').value;
            
            // alert(form_unique_id);
            var po_num = checkbox.parentElement.querySelector('#po_num_val').value;
 var customername = checkbox.parentElement.querySelector('#customername').value;

           
            // alert(po_num);
            var po_date = checkbox.parentElement.querySelector('#po_date').value;
            // alert(po_date);
            // var po_product_name = checkbox.parentElement.querySelector('#po_product_name').value;
            // alert(po_product_name);
            var bg_month = checkbox.parentElement.querySelector('#bg_month').value;
            // alert(bg_month);
            var bg_per = checkbox.parentElement.querySelector('#bg_per').value;
            // alert(bg_per);
            var invoice_date = checkbox.parentElement.querySelector('#invoice_date').value;
            // var ins_unique_id = checkbox.parentElement.querySelector('#ins_unique_id').value;
            // alert(ins_unique_id);
            
            var parentElement = checked[i].parentElement;
            var invoice_no = parentElement.querySelector('#invoice_no').value;
            // var dc_number = parentElement.querySelector('#dc_number').value;
            // var dc_date = parentElement.querySelector('#dc_date').value;
            // alert(invoice_no);
            // var invoice_no = document.getElementsByName('invoice_no[]');
            invoice_tot.push(invoice_no);
            // invoice_tot.push(invoice_no[i].value);
            var invoice_qty_val = parentElement.querySelector('#invoice_qty').value;
            // alert(invoice_qty_val);
            var invoice_value_val = parentElement.querySelector('#invoice_value').value;
            invoice_value_val = invoice_value_val.replace(/,/g, ''); // remove commas if any
           
            // amount of value calculate
            var amount = parseFloat(invoice_value_val);
            if (!isNaN(amount)) {
                invoice_tot_amt.push(amount);
                var sum_of_invoice_value = invoice_tot_amt.reduce(function(total, current) {
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
        var invoice_no = invoice_tot.join(",");
        // alert(invoice_no);
        var data = "form_unique_id=" + form_unique_id + "&po_num=" + po_num + "&po_date="  +po_date + "&invoice_nos=" + invoice_no + "&invoice_date=" + invoice_date + "&bg_month=" + bg_month + "&bg_per=" + bg_per + "&invoice_value=" + sum_of_invoice_value + "&invoice_qty=" + sum_of_invoice_qty + "&customername=" + customername ;
        data += "&action=bgmain_createupdate";
        var ajax_url = sessionStorage.getItem("folder_crud_link");
        var url = sessionStorage.getItem("list_link");
        $.ajax({
            type: "POST",
            url: ajax_url,
            data: data,
            beforeSend: function() {
                $(".bg_add_update_btn").attr("disabled", "disabled");
                $(".bg_add_update_btn").text("Loading...");
            },
            success: function(data) {
                var obj = JSON.parse(data);
                                var msg = obj.msg;
                                var status = obj.status;
                                var error = obj.error;
                                //alert(msg);
                                if (!status) {
                                    $(".bg_add_update_btn").text("Error");
                                    //console.log(error);
                                } else {
                                    if (msg == "already") {
                                        // sweetalert(msg, url);
                                        form_reset("consignee_details_form");
                                    }
                                    $(".bg_add_update_btn").removeAttr("disabled", "disabled");
                                    if (msg == "already") {
                                        $(".bg_add_update_btn").text("Update");
                                    } else {
                                        $(".bg_add_update_btn").text("Add");
                                        $(".bg_add_update_btn").attr("onclick",
                                            "bg_add_update_btn('')");
                                    }
                                }
                                sweetalert(msg, url);
                                //  sweetalert(msg);
                // alert(data);
            },
            error: function(data) {
                alert("Network Error");
            }
        });
        bg_creation_sub();
    }
    function bg_creation_sub() {
        // var stock_qty = document.getElementsByName('stock_qty[]');
        // var checkbox_qty = document.getElementsByName('checkbox[]');
        const checked = document.querySelectorAll('.myCheck:checked');
        for (var i = 0; i < checked.length; i++) {
            var parentElement = checked[i].parentElement;
            var invoice_no_val = parentElement.querySelector('#invoice_no').value;
            //  var dc_number = parentElement.querySelector('#dc_number').value;
            // var dc_date = parentElement.querySelector('#dc_date').value;
            // alert(invoice_no);
            var invoice_val = parentElement.querySelector('#invoice_value').value;
            // alert(invoice_value);
            var invoice_qty_val = parentElement.querySelector('#invoice_qty').value;
          
            // alert(invoice_qty);
            // var invoice_no = document.getElementsByName('invoice_no[]');
            // var invoice_value = document.getElementsByName('invoice_value[]');
            // var invoice_qty = document.getElementsByName('invoice_qty[]');
            // // var invoice_no_val = invoice_no[i].value;
            // var invoice_val = invoice_value[i].value;
            // var invoice_qty_val = invoice_qty[i].value;
            var checkbox = checked[i];
            var form_unique_id = checkbox.parentElement.querySelector('#form_unique_id').value;
            // alert(form_unique_id);
            var po_num = checkbox.parentElement.querySelector('#po_num_val').value;
            var customername = checkbox.parentElement.querySelector('#customername').value;

            // alert(po_num);
            var po_date = checkbox.parentElement.querySelector('#po_date').value;
            // alert(po_date);
            // var po_product_name = checkbox.parentElement.querySelector('#po_product_name').value;
            // alert(po_product_name);
            // var con_name = checkbox.parentElement.querySelector('#con_name').value;
            // alert(con_name);
            // var con_address = checkbox.parentElement.querySelector('#con_address').value;
            // alert(con_address);
            // var con_unique_id = checkbox.parentElement.querySelector('#con_unique_id').value;
            // alert(con_unique_id);
            // var bg_per = checkbox.parentElement.querySelector('#bg_per').value;
            // alert(bg_per);
            // var bg_per = checkbox.parentElement.querySelector('#bg_per').value;
            // alert(bg_per);
            var invoice_date = checkbox.parentElement.querySelector('#invoice_date').value;

              var bg_month = checkbox.parentElement.querySelector('#bg_month').value;
            // alert(bg_month);
            var bg_per = checkbox.parentElement.querySelector('#bg_per').value;
            // var ins_unique_id = checkbox.parentElement.querySelector('#ins_unique_id').value;
            //alert(ins_unique_id);
            // var form_unique_id = document.getElementById('form_unique_id').value;
            // // alert(form_unique_id);
            // var po_num = document.getElementById('po_num_val').value;
            // var po_date = document.getElementById('po_date').value;
            // var con_name = document.getElementById('con_name').value;
            // var con_address = document.getElementById('con_address').value;
            // var con_unique_id = document.getElementById('con_unique_id').value;
            // var po_product_name = document.getElementById('po_product_name').value;
            // var bg_per = document.getElementById('bg_per').value;
            // var invoice_date = document.getElementById('invoice_date').value;
            var data = "form_unique_id=" + form_unique_id + "&po_num=" + po_num + "&po_date="  + po_date + "&invoice_date=" + invoice_date + "&invoice_no=" + invoice_no_val + "&invoice_qty=" + invoice_qty_val + "&invoice_val=" + invoice_val  + "&bg_per=" + bg_per + "&bg_month=" + bg_month + "&customername=" + customername ;
            // 
            data += "&action=bg_sub_addupdate";
            var ajax_url = sessionStorage.getItem("folder_crud_link");
            var url = sessionStorage.getItem("list_link");
            $.ajax({
                type: "POST",
                url: ajax_url,
                data: data,
                beforeSend: function() {
                    $(".bg_add_update_btn").attr("disabled", "disabled");
                    $(".bg_add_update_btn").text("Loading...");
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
                        //console.log(error);
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
                    // sweetalert(msg);
                    sweetalert(msg, url);
                },
                error: function(data) {
                    alert("Network Error");
                }
            });
        }
    }
</script>
