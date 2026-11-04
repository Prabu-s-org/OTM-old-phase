<style>
    #outsource-fields {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }


    .v-bor h5 {
        margin-bottom: 0px;
        border-radius: 3px;
        height: 37px;
        vertical-align: middle;
        align-self: center;
        padding: 9px 0px 0px 0px;
    }

    table.dataTable thead tr th {
        text-align: center !important;
    }

    .dot {
        align-self: center;
    }

    /* .r */
</style>

<?php include 'function.php'; ?>

<?php

include '../../config/dbconfig.php';
include '../../inc/header.php';
include '../../inc/footer.php';


?>
<div class="row">


    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Vendor Allocation</h4>
            <input type="hidden" id="screen_id_val" name="screen_id_val" class="form-control"
                value="<?php echo $screen_id_val; ?>">
            <input type="hidden" id="user_type_unique_id" name="user_type_unique_id" class="form-control"
                value="<?php echo $user_type_unique_id; ?>">

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Form</a></li>
                    <li class="breadcrumb-item active">Bulk Vendor Allocation</li>
                </ol>
            </div>
        </div>

        <div>


        </div>
    </div>
  

    
    <?php


    if (isset($_GET["unique_id"])) {
        if (!empty($_GET["unique_id"])) {

            $unique_id = $_GET["unique_id"];
            // print_r( $unique_id);die();
            $consignee_unique_id = $_GET["consignee_unique_id"];


            $dc_no = $_GET["dc_no"];
            // $invoice_no = $_GET["invoice_no"];
            // $where      = [
            //     "po_form_unique_id" => $unique_id
            // ];
            $where = "dc_number='$dc_no' and is_delete='0'";
            // print_r($where);die();
            $table = "invoice_creation_main";
            $columns = [

                "bulk_eng_type",
                "bulk_eng_name",
                "(CASE 
            WHEN $table.bulk_eng_type = 1 THEN (SELECT name FROM vendor_creation WHERE unique_id = $table.bulk_eng_name)
            WHEN $table.bulk_eng_type = 2 THEN (SELECT staff_name FROM user WHERE unique_id = $table.bulk_eng_name) END) AS name",
                "vendor_bulk_rate",
                "vendor_bulk_gst",
                "bulk_total_amount",
                "vendor_bulk_zone",
                "vendor_bulk_timeline",
                "date",
                "invoice_qty",
                "bulk_dc_total_amount",
                "vendor_bulk_sts",
                "ven_assign_no",
                "DATE_FORMAT(ven_assign_date,'%d-%m-%Y') AS ven_assign_date",
                "DATE_FORMAT(vendor_ins_date,'%d-%m-%Y') AS vendor_ins_date",
                "DATE_FORMAT(vendor_timeline,'%d-%m-%Y') AS vendor_timeline",
                "form_main_unique_id",
                "invoice_no"


            ];
            $table_details = [
                $table,
                $columns
            ];
            $result_values = $pdo->select($table_details, $where);
            //  print_r($result_values);die();
            if ($result_values->status) {
                $result_values = $result_values->data;



                $eng_type = $result_values[0]["bulk_eng_type"];

                $eng_name = $result_values[0]["bulk_eng_name"];

                $bulk_rate = $result_values[0]["vendor_bulk_rate"];
                $form_main_unique_id = $result_values[0]["form_main_unique_id"];

                $bulk_gst = $result_values[0]["vendor_bulk_gst"];

                // $bulk_ttl_amnt  = $result_values[0]["vendor_bulk_gst"];

                $bulk_zone = $result_values[0]["vendor_bulk_zone"];

                $bulk_ttl_amnt = $result_values[0]["bulk_total_amount"];

                $bulk_time = $result_values[0]["vendor_bulk_timeline"];
                $date = $result_values[0]["date"];


                $ven_assign_no = $result_values[0]["ven_assign_no"];
                $ven_assign_date = $result_values[0]["ven_assign_date"];
                $vendor_ins_date = $result_values[0]["vendor_ins_date"];
                $vendor_timeline = $result_values[0]["vendor_timeline"];
                $form_main_unique_id = $result_values[0]["form_main_unique_id"];

                $invoice_qty = $result_values[0]["invoice_qty"];

                $vendor_bulk_sts = $result_values[0]["vendor_bulk_sts"];

                $bulk_dc_total_amount = $result_values[0]["bulk_dc_total_amount"];
 

                $btn_text = "Update";
                $btn_action = "update";
            } else {
                $btn_text = "Error";
                $btn_action = "error";
                $is_btn_disable = "disabled='disabled'";
            }
        }
    }


    $vendor_name = vendor_names();
    $vendor_option = select_option($vendor_name, "Select Vendor");



    $ven_cmp_name = vendor_company_name();
    $ven_cmp_options = select_option($ven_cmp_name,"Select Company");


    $inhouse        = inhouse();
    $inhouse_option = select_option($inhouse,"Select Inhouse Team");


    $engineer_name_optionss  = engineer_name(); 
    $default_unique_id       = '685d064d6a03b86431'; 
    $engineer_name_options1  = '<option value="">Select Engineer Name</option>';

foreach ($engineer_name_optionss as $engineer) {
    $selected = ($engineer['emp_id'] === $default_unique_id) ? 'selected' : '';
    $engineer_name_options1 .= '<option value="' . $engineer['unique_id'] . '" ' . $selected . '>' . $engineer['engineer_name'] . '</option>';
}

    // $engineer_name_optionss = engineer_name();
    // $engineer_name_options1 = select_option($engineer_name_optionss, "Select Engineer Name");

    

    //vendor name
    $engineer_type_options = engineer_type();
    $engineer_type_options1 = select_option($engineer_type_options, "Select Eng Name");



    $date = date('d-m-Y');


    $assigndate = date('Y-m-d H:i:s');
$final_assign_date = !empty($ven_assign_date) ? $ven_assign_date : $assigndate;



    // Example usage
    $assign_no = generateVenAssignNo();

$final_assign_no = !empty($ven_assign_no) ? $ven_assign_no : $assign_no;

    $vendor_po = vendor_po_number();

    $vendor_po_options = select_option($vendor_po, "");


    // $list_of_po = list_of_po();
    // $list_of_po = select_option($list_of_po, "Select PO Number" );
$list_of_po_data = list_of_po();

$list_of_po = '<option value="">Select PO Number</option>';

foreach ($list_of_po_data as $po) {

    $selected = ($po['unique_id'] == $form_main_unique_id) ? 'selected' : '';

    $list_of_po .= '<option value="'.$po['unique_id'].'" '.$selected.'>'.$po['po_num'].'</option>';
}

if (!empty($vendor_bulk_sts) && $vendor_bulk_sts == 1) {

    $vendor_inv_no = vendorinvoice_no_update($unique_id, $form_main_unique_id);
   foreach ($vendor_inv_no as $vo) {

    $selected = ($vo['unique_id'] == $unique_id) ? 'selected' : '';

    $vendor_inv_options .= '<option value="'.$vo['unique_id'].'" '.$selected.'>'.$vo['invoice_no'].'</option>';
}

}else{
    $vendor_inv_no = vendorinvoice_no();
    $vendor_inv_options = select_option($vendor_inv_no);

}

//     $edit_invoice_unique_id = $result_values[0]["unique_id"];

// $vendor_inv_options = '';

// foreach ($vendor_inv_no as $vo) {

//     $selected = ($vo['unique_id'] == $edit_invoice_unique_id) ? 'selected' : '';

//     $vendor_inv_options .= '<option value="'.$vo['unique_id'].'" '.$selected.'>'.$vo['invoice_no'].'</option>';
// }


    ?>




    <div class="card">
        <div class="card-body">


            <div class="row g-2">

                <!-- LEFT COLUMN -->

                <div class="col-md-6">
                    <div class="row mb-2">
                        <label class="col-md-3 col-form-label"> Engineer Type<span class="mx-1"></span> </label>
                        <div class="col-md-1 dot">:</div>
                        <div class="col-md-7">
                           <select class="form-control" name="eng_type" id="eng_type"
    onchange="get_eng_name();toggleGstDiv()">

    <option value="">Select Engineer Type</option>

    <option value="own-engineer"
        <?= ($eng_type == 'own-engineer') ? 'selected' : ''; ?>>
        Own Engineer
    </option>

    <option value="outsource-vendor"
        <?= ($eng_type == 'outsource-vendor') ? 'selected' : ''; ?>>
        Outsource Vendor
    </option>

    <option value="inhouse"
        <?= ($eng_type == 'inhouse') ? 'selected' : ''; ?>>
        Inhouse Operation Team
    </option>

</select>

                        </div>
                    </div>

                    <div class="row mb-2" id="gst-div" style="display: none;">
                        <label class="col-md-3 col-form-label">GST Type<span class="mx-1"></span></label>
                        <div class="col-md-1 dot">:</div>
                        <div class="col-md-7">
                            <select class="form-control" name="gst_type" id="gst_type" onchange="get_productdetails()">
                                <option value="">Select GST Type</option>
                                <option value="1">With GST</option>
                                <option value="2">Without GST</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <label class="col-md-3 col-form-label ">Engineer Name </label>
                        <div class="col-md-1 dot">:</div>
                        <div class="col-md-7">
                            <select class="form-control" name="eng_name" id="eng_name">
                                <option value="">Select Engineer Name</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <label class="col-md-3 col-form-label ">Installation Date </label>
                        <div class="col-md-1 dot">:</div>
                        <div class="col-md-7">
<input type="date" class="form-control" 
       name="ins_date" 
       id="ins_date" 
       value="<?= !empty($vendor_ins_date) ? date('Y-m-d', strtotime($vendor_ins_date)) : ''; ?>">

                        </div>
                    </div>


                </div>

                <!-- RIGHT COLUMN -->
                <div class="col-md-6">
                    <div class="row mb-2">
                        <label class="col-md-2 col-form-label ">
                            Assign No
                        </label>
                        <div class="col-md-1 dot">:</div>
                        <div class="col-md-5">
                            <label class="col-form-label "><b><?php echo $final_assign_no; ?></b></label>

                            <input type="hidden" id="assign_no" name="assign_no" value="<?php echo $final_assign_no; ?>">
                            <input type="hidden" id="vendor_bulk_sts" name="vendor_bulk_sts" value="<?php echo $vendor_bulk_sts; ?>">
  
                        </div>
                    </div>

                    <div class="row mb-2">
                        <label class="col-md-2 col-form-label ">
                            Assign Date
                        </label>
                        <div class="col-md-1 dot">:</div>
                        <div class="col-md-6">
                            <label class="col-md-4 col-form-label"><?php echo $final_assign_date; ?></label>
                            <input type="hidden" name="assign_date" class="form-control" id="assign_date"
                                value="<?php echo $final_assign_date; ?>">
                        </div>
                    </div>

                    <div class="row mb-2">
                        <label class="col-md-2 col-form-label ">Time Line
                        </label>
                        <div class="col-md-1 dot">:</div>
                        <div class="col-md-6">
<input type="date" class="form-control"  id="dead_line" name="dead_line" value="<?= !empty($vendor_timeline) ? date('Y-m-d', strtotime($vendor_timeline)) : ''; ?>">

                        </div>
                    </div>
                </div>

            </div>


        </div>
    </div>
</div>


</div>
<div class="row">
    <div class="card">
        <div class="card-body">

            <div class="row">



                <div class="row g-2">

                    <!-- LEFT COLUMN -->
                    <div class="col-md-6">
                        <div class="row mb-2">
                            <label class="col-md-3 col-form-label">
                                PO NO<span class="mx-1"></span>
                            </label>
                            <div class="col-md-1 dot">:</div>
                            <div class="col-md-7">
                                <select class="select2 form-control" name="po_num" id="po_num"
                                    onchange="get_invoice_no()">
                                    <?php echo $list_of_po; ?>

                                    <input type="hidden" name="bulk_status" id="bulk_status" value="1">


                                </select>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="row mb-2">

                            <label class="col-md-2 col-form-label">
                                INVOICE NO<span class="mx-1"></span>
                            </label>
                            <div class="col-md-1 dot">:</div>
                            <div class="col-md-6">
                                <select class="form-control" name="inv_num" id="inv_num"
                                    onchange="get_dc_detail(this.value)">
                                    <option value="">Select Invoice No</option>
                                     
                                    <?php echo $vendor_inv_options; ?>


                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">



                    <div class="table-responsive">
                        <table id="doc_pending_list_datatable" class="table table-bordered table-striped align-middle">
                            <thead>
                                <tr>
                                    <th>Selection<br>(Select All)
                                        <?php echo '<input type="checkbox"  id="select_all">' ?>
                                    </th>
                                    <th>S.No</th>
                                    <th>PO No / Date</th>
                                    <th>Invoice No / Date</th>
                                    <th>DC No / Date</th>
                                    <th>Qty</th>
                                    <th>Department</th>
                                    <th>Consignee</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>

                </div>





                <div class="row mt-3" id="product_table" style="display: none;">
                    <div class="table-responsive">
                        <table id="product_details_datatable"
                            class="table table-bordered table-striped align-middle display">
                            <thead>
                                <tr>
                                    <th>S. No</th>
                                    <th>Product Details</th>
                                    <th>Qty</th>
                                    <th>Rate </th>
                                    <th>GST</th>
                                    <th>Tax Amount</th>
                                    <th>Total Amount</th>

                                </tr>
                            </thead>
                            <tbody>


                            </tbody>


                        </table>
                    </div>

                    <div class="row">
                        <div class="col-md-12 text-end">
                            <strong>Total: ₹ <span id="grand_total">0.00</span></strong>
                        </div>
                    </div>

                </div>




                <div class="col-12 mt-3">
                    <div class="form-group row ">
                        <div class="col-md-12" align="right">
                            
                            <?php echo btn_cancel($btn_cancel); ?>
                            <button type="button" class="btn btn-primary waves-effect waves-light" id="approve_btn"
                                onclick="submitvendor_update()">Submit</button>
                            <!-- <button type="button" class="btn btn-primary waves-effect waves-light" onclick="po_invoice_create()">Save</button> -->
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





<div class="modal fade" id="dcdetailsmodal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
  <div class="modal-dialog custom-wide-modal modal-dialog-centered modal-dialog-scrollable">
 
<!-- <div class="modal-dialog modal-xl"> -->
    <div class="modal-content shadow-lg rounded-4 border-0">
     <div class="modal-header"
        style="background-color: #d6d8b3; color: #506018; font-weight: bold; border-top-left-radius: 0.3rem; border-top-right-radius: 0.3rem; padding: 0.8rem !important;">
        <h5 class="modal-title fw-bold text-center w-100" id="viewModalLabel" style="color: #506018;">Product Details
          </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close">x</button>
<!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
      </div>
      <div class="modal-body" style="background-color: #f9fafb;">


        <div class="table-responsive">
                                            <table id="dc_details_datatable"
                                                class="table table-bordered table-striped align-middle">
                                                <thead>
                                                    <tr>
                                                        <th>S.No</th>
                                                        <th>Item Details</th>
                                                        <th>Qty</th>
                                                        <th>Rate</th>
                                                        <th>GST</th>
                                                        <th>Tax Amount</th>
                                                        <th>Total Amount</th>
                                                    </tr>
                                                </thead>
                                               <tbody id="dc_table_body">
              <!-- Dynamic rows will be appended here -->
            </tbody>
             <tfoot>
        <tr>
            <td colspan="6" style="text-align: right; font-weight: bold;">Total:</td>
            <td id="total_sum" style="text-align: right; font-weight: bold;">₹0.00</td>
        </tr>
    </tfoot>
                                            </table>
                                        </div>
                                        <div class="modal-footer">
             <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Close
                  </button>
                <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
            </div>
      </div>
    </div>
  </div>
</div>




<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
    integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<!-- Add Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>

<script>
    function OnlyNumbers(el) {
        // Remove all characters except digits and a single decimal point
        el.value = el.value
            .replace(/[^0-9.]/g, '')       // Remove non-numeric and non-dot characters
            .replace(/(\..*)\./g, '$1');   // Allow only one decimal point
    }

 var selected_eng_name = "<?= $eng_name ?>";

    // document.addEventListener("DOMContentLoaded", function () {
    //     document.getElementById("po_num").disabled = true;

    //     document.getElementById("eng_type").addEventListener('change', function () {

    //         var engg_type = this.value;
    //         var poselect = document.getElementById("po_num");

    //         if (engg_type == "own-engineer" || engg_type == "outsource-vendor"  || engg_type == "inhouse") {
    //             poselect.disabled = false;

    //         }
    //         else {
    //             poselect.disabled = true;
    //             poselect.value = "";

    //         }
    //     });
    // });






    function get_qty() {
        var dc_num = document.getElementById("dc_num");
        var selectedValues = Array.from(select.selectedoptions).map(option => option.value);

    }

        let selectedDCs = new Set();   // stores selected DC numbers permanently


        document.addEventListener("DOMContentLoaded", function () {

    const selectAll = document.getElementById("select_all");
    const eng_type = document.getElementById("eng_type").value;

    if (!selectAll) return;

    selectAll.addEventListener("change", function () {

        document.querySelectorAll(".myCheck").forEach(cb => {

            const dcNo = cb.getAttribute("data-id");
            cb.checked = selectAll.checked;

            if (selectAll.checked) {
                selectedDCs.add(dcNo);
            } else {
                selectedDCs.delete(dcNo);
            }
        });

        if ((eng_type !== 'own-engineer') && (eng_type !== 'inhouse')) {
            if (selectedDCs.size > 0) {
                $('#product_table').show();
                get_productdetails();
            } else {
                resetProductTable();
            }
        } else {
            $('#product_table').hide();
        }
    });
});




    function gstcalculation(sno) {

        // alert(sno);
        const span = document.getElementById('pd_qty_' + sno);
        const qty = span.getAttribute('data-value');


        var gstType = $('#gst_type').val();

        // alert(gstType);

        var gst;

        if (gstType === "1") {
            gst = 18;
        } else if (gstType === "2") {
            gst = 0;
        }

        let rate = parseFloat(document.getElementById("pd_rate_" + sno).value) || 0;

        var tax_amount = (rate * qty * gst) / 100;

        var indiv_total_amnt = (rate * qty) + tax_amount;

        // alert(indiv_total_amnt);

        document.getElementById("tax_amnt_" + sno).textContent = tax_amount.toFixed(2);
        document.getElementById("pd_ttl_amnt_" + sno).textContent = indiv_total_amnt.toFixed(2);

        overalltotalcalculation();

        // document.getElementById("tax_amnt"+ sno ).textContent = tax_amount;

        // document.getElementById("tax_amnt" + sno).textContent = indiv_total_amnt;

    }

    function overalltotalcalculation() {

        let grandTotal = 0;
        document.querySelectorAll("[id^='pd_ttl_amnt_']").forEach(el => {

            grandTotal += parseFloat(el.textContent) || 0;
        });

        let round_grandTotal = Math.round(grandTotal);

        document.getElementById("grand_total").textContent = grandTotal.toFixed(2);
    }


    // new function written on 22-01-26
  document.addEventListener("change", function (e) {

    const eng_type = $("#eng_type").val();

    if ((eng_type !== 'own-engineer') && (eng_type !== 'inhouse')) {

        if (e.target.classList.contains("myCheck")) {

            const checkbox = e.target;
            const dcNo = checkbox.getAttribute("data-id");

            if (checkbox.checked) {
                selectedDCs.add(dcNo);
            } else {
                selectedDCs.delete(dcNo);
            }

            // Sync select all checkbox
            const totalCheckboxes = document.querySelectorAll('.myCheck').length;
            document.getElementById('select_all').checked =
                selectedDCs.size === totalCheckboxes;

            if (selectedDCs.size > 0) {
                $('#product_table').show();
                get_productdetails();
            } else {
                resetProductTable();
            }
        }

    } else {
        $('#product_table').hide();
    }
});



// new function on 22-01-2026



function get_productdetails() {

    let selected_dc_numbers = [];   // ✅ FIXED

    $(".myCheck:checked").each(function () {
        selected_dc_numbers.push($(this).data("dc"));
    });

    if (selected_dc_numbers.length === 0) {
        $('#product_table').hide();
        return;
    }

    $('#product_table').show();

    var po_no = $('#po_num').val();

    let rateMemory = {};

    document.querySelectorAll("input[name='rate[]']").forEach(input => {
        const row = input.closest("tr");
        const item_code = row.querySelector(".ven_item_code")?.value || "";
        rateMemory[item_code] = input.value;
    });

    // alert(selected_dc_numbers);

    var data = {
        dc_no: selected_dc_numbers,
        po_no: po_no,
        gst_type: $('#gst_type').val(),
        action: 'product_details_datatable'
    };

    var tableid = 'product_details_datatable';
    var table = $("#" + tableid);

    if ($.fn.DataTable.isDataTable(table)) {
        table.DataTable().clear().destroy();
    }

    table.DataTable({
        ordering: false,
        searching: true,
        stateSave: true,
        paging: false,
        info: false,
        lengthChange: false,
        ajax: {
            url: sessionStorage.getItem("folder_crud_link"),
            type: "POST",
            data: data
        },
        columns: [
            { data: "sno" },
            { data: "item_code" },
            { data: "invoice_qty" },
            { data: "rate" },
            { data: "gst" },
            { data: "tax_amount" },
            { data: "total_amount" }
        ],
        initComplete: function () {

            setTimeout(() => {
                document.querySelectorAll("input[name='rate[]']").forEach(input => {
                    const row = input.closest("tr");
                    const item_code = row.querySelector(".ven_item_code")?.value || "";

                    if (rateMemory[item_code]) {
                        input.value = rateMemory[item_code];
                        const sno = input.id.split("_").pop();
                        gstcalculation(sno);
                    }
                });
            }, 100);
        }
    });
}


// function get_productdetails() {

//     // if (selectedDCs.size === 0) return;
//  $(".myCheck:checked").each(function () {
//         selected_dc_numbers.push($(this).data("dc"));
//     });

//     $('#product_table').show();

//     var po_no = $('#po_num').val();

//     let rateMemory = {};


//     document.querySelectorAll("input[name='rate[]']").forEach(input => {
//         const row = input.closest("tr");
//         const item_code = row.querySelector(".ven_item_code")?.value || "";
//         rateMemory[item_code] = input.value;
//     });

//     alert(selected_dc_numbers);
//     // let selected_dc_numbers = Array.from(selectedDCs);
// // alert(selected_dc_numbers);
//     var data = {
//         dc_no: selected_dc_numbers,
//         po_no : po_no,
//         gst_type: $('#gst_type').val(),
//         action: 'product_details_datatable'
//     };

//     var tableid = 'product_details_datatable';
//     var table = $("#" + tableid);

//     if ($.fn.DataTable.isDataTable(table)) {
//         table.DataTable().clear().destroy();
//     }

//     table.DataTable({
//         ordering: false,
//         searching: true,
//         stateSave: true,
//         paging: false,
//         info: false,
//         lengthChange: false,
//         ajax: {
//             url: sessionStorage.getItem("folder_crud_link"),
//             type: "POST",
//             data: data
//         },
//         columns: [
//             { data: "sno" },
//             { data: "item_code" },
//             { data: "invoice_qty" },
//             { data: "rate" },
//             { data: "gst" },
//             { data: "tax_amount" },
//             { data: "total_amount" }
//         ],
//         initComplete: function () {

//             setTimeout(() => {
//                 document.querySelectorAll("input[name='rate[]']").forEach(input => {
//                     const row = input.closest("tr");
//                     const item_code = row.querySelector(".ven_item_code")?.value || "";

//                     if (rateMemory[item_code]) {
//                         input.value = rateMemory[item_code];
//                         const sno = input.id.split("_").pop();
//                         gstcalculation(sno);
//                     }
//                 });
//             }, 100);
//         }
//     });
// }


function resetProductTable() {

    const tableid = 'product_details_datatable';
    const table = $("#" + tableid);

    if ($.fn.DataTable.isDataTable(table)) {
        table.DataTable().clear().destroy();
    }

    $("#" + tableid + " tbody").html(
        "<tr><td colspan='10' style='text-align:center;'>No data</td></tr>"
    );

    $("#grand_total").text("0.00");
}


    // function get_eng_name() {
    //     var engType = document.getElementById("eng_type").value;
    //     var engNameDropdown = document.getElementById("eng_name");

    //     // Toggle visibility of outsource fields
    //     var outsourceFields = document.querySelectorAll(".outsource-field");
    //     engNameDropdown.innerHTML = "";

    //     if (engType === "own-engineer") {
    //         engNameDropdown.innerHTML = `<?php echo $engineer_name_options1; ?>`;
    //         outsourceFields.forEach(f => f.classList.add('d-none'));

    //         $('#product_table').hide();
    //     } else if (engType === "outsource-vendor") {
    //         engNameDropdown.innerHTML = `<?php echo $vendor_option; ?>`;
    //         outsourceFields.forEach(f => f.classList.remove('d-none'));
    //         $('#product_table').show();
    //     } 
        
    //      else if(engType === "inhouse") {

    //             engNameDropdown.innerHTML = `<?php echo $inhouse_option; ?>`;
    //               outsourceFields.forEach(f => f.classList.remove('d-none'));
    //               $('#product_table').hide();

    //         } 
      
    // }

function get_eng_name() {

    var engType = document.getElementById("eng_type").value;
    var engNameDropdown = document.getElementById("eng_name");
    var outsourceFields = document.querySelectorAll(".outsource-field");

    engNameDropdown.innerHTML = "";

    if (engType === "own-engineer") {
        engNameDropdown.innerHTML = `<?= $engineer_name_options1 ?>`;
        outsourceFields.forEach(f => f.classList.add('d-none'));
        $('#product_table').hide();

    } else if (engType === "outsource-vendor") {
        engNameDropdown.innerHTML = `<?= $vendor_option ?>`;
        outsourceFields.forEach(f => f.classList.remove('d-none'));
        $('#product_table').show();

    } else if (engType === "inhouse") {
        engNameDropdown.innerHTML = `<?= $inhouse_option ?>`;
        outsourceFields.forEach(f => f.classList.remove('d-none'));
        $('#product_table').hide();
    }

    // ✅ Auto select saved engineer name
    if (selected_eng_name !== "") {
        $('#eng_name').val(selected_eng_name);
    }
}

// <br><option value="">All</option>
    function get_invoice_no() {
        
        var po_id = document.getElementById('po_num').value;

        var data = {

            action: "get_invoice",
            po_id: po_id

        };

        var ajax_url = sessionStorage.getItem("folder_crud_link");

        $.ajax({
            url: ajax_url,
            data: data,
            type: 'POST',
            dataType: 'json', // Ensure response is parsed as JSON
            success: function (response) {

                // alert(response);

                // let options;
               if(response.data !=''){

                    let options = '<option value="">Select Invoice</option><br><option value="">All</option>';

                if (Array.isArray(response.data)) {
                    response.data.forEach(row => {
                        options += `<option value="${row.invoice_no}">${row.invoice_no}</option>`;
                    });
                }

                $('#inv_num').html(options);
                }

                else{
                     let options = '<option value="">Select Invoice</option>';

                       $('#inv_num').html(options);
                }
           },
            error: function () {
                // alert("Error retrieving invoice numbers.");
            }
        });
    }


// <br><option value="">All</option>


    function get_dc_no() {

        // alert('test');
        var po_id = document.getElementById('po_num').value;

        var inv_no = document.getElementById('inv_num').value

        // alert(screen_id_val);

        var data = {

            "action": "get_dc",
            "inv_no": inv_no,
        };

        var ajax_url = sessionStorage.getItem("folder_crud_link");

        $.ajax({
            url: ajax_url,
            data: data,
            type: 'POST',
            success: function (response) {
                console.log("Raw response:", response);

                // Try to parse response if it's a JSON string
                var dc_list = typeof response === "string" ? JSON.parse(response) : response;

                console.log("Data array:", dc_list);
                // alert("Number of items: " + dc_list.length); // For testing

                let options = '<option value="">Select DC No</option>';

                dc_list.forEach(row => {
                    if (row.dc_number) {

                        // alert(row.dc_number);
                        options += `<option value="${row.dc_number}">${row.dc_number}</option>`;
                    }
                });

                //  $('#dc_num').empty().append(options);
                document.getElementById("dc_num").innerHTML = options;
            }


        });

    }












    function print_pdf_1(file_name) {

        onmouseover = window.open('uploads/po_form/po_attach/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
    }

    function print_pdf(file_name) {

        onmouseover = window.open('uploads/invoice/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
    }

 
</script>
