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
    <!--     -->
    <!-- <div class="card">
<div class="card-body">
    <center>
<h3>BULK VENDOR ALLOCATION LIST</h3>
</center>
</div>
</div> -->

    <?php

    $vendor_name = vendor_names();
    $vendor_option = select_option($vendor_name, "Select Vendor");

    $inhouse = inhouse();
    $inhouse_option = select_option($inhouse, "Select Inhouse Team");





    // $engineer_name_optionss = engineer_name();
    // $engineer_name_options1 = select_option($engineer_name_optionss, "Select Engineer Name");
    
    // Fetch all engineer names
    $engineer_name_optionss = engineer_name();

    // Define the default unique_id
    $default_unique_id = '685d064d6a03b86431'; // This will be pre-selected by default
    
    // Build the HTML for the <option> elements with the pre-selected option
    $engineer_name_options1 = '<option value="">Select Engineer Name</option>';

    foreach ($engineer_name_optionss as $engineer) {
        $selected = ($engineer['emp_id'] === $default_unique_id) ? 'selected' : '';
        $engineer_name_options1 .= '<option value="' . $engineer['unique_id'] . '" ' . $selected . '>' . $engineer['engineer_name'] . '</option>';
    }


    //  print_r($engineer_name_optionss);die();
    

    //vendor name
    $engineer_type_options = engineer_type();
    $engineer_type_options1 = select_option($engineer_type_options, "Select Eng Name");



    $date = date('d-m-Y');


    $assigndate = date('Y-m-d H:i:s');



    // Example usage
    $assign_no = generateVenAssignNo();


    $vendor_po = vendor_po_number();

    $vendor_po_options = select_option($vendor_po, "");


    $list_of_po = list_of_po();
    $list_of_po = select_option($list_of_po, "Select PO Number", );


    $vendor_inv_no = vendorinvoice_no();
    $vendor_inv_options = select_option($vendor_inv_no, "Select Invoice No");


    $ven_partial_no = generateVenProductAssignNo();
    // print_r($ven_partial_no);die();
    


    // echo "Generated Serial No: " . $assign_no;
    
    //  print_r($assign_no);die();
    

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
                                <option value="own-engineer">Own Engineer</option>
                                <option value="outsource-vendor">Outsource Vendor</option>
                                <option value="inhouse">Inhouse Operation Team</option>
                            </select>
                        </div>
                    </div>



                    <div class="row mb-2" id="gst-div" style="display: none;">
                        <label class="col-md-3 col-form-label">GST Type<span class="mx-1"></span></label>
                        <div class="col-md-1 dot">:</div>
                        <div class="col-md-7">
                            <select class="form-control" name="gst_type" id="gst_type" onchange="get_productdetails1()">
                                <option value="">Select GST Type</option>
                                <option value="1">With GST</option>
                                <option value="2">Without GST</option>
                            </select>
                        </div>
                    </div>

                    <input type="hidden" name="ven_partial_no" id="ven_partial_no"
                        value="<?php echo $ven_partial_no; ?>">

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

                            <input type="date" class="form-control" name="ins_date" id="ins_date">
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
                            <label class="col-form-label "><b><?php echo $assign_no; ?></b></label>

                            <input type="hidden" id="assign_no" name="assign_no" value="<?php echo $assign_no; ?>">

                        </div>
                    </div>

                    <div class="row mb-2">
                        <label class="col-md-2 col-form-label ">
                            Assign Date
                        </label>
                        <div class="col-md-1 dot">:</div>
                        <div class="col-md-6">
                            <label class="col-md-4 col-form-label"><?php echo $date; ?></label>
                            <input type="hidden" name="assign_date" class="form-control" id="assign_date"
                                value="<?php echo $assigndate; ?>">
                        </div>
                    </div>

                    <div class="row mb-2">
                        <label class="col-md-2 col-form-label ">Time Line
                        </label>
                        <div class="col-md-1 dot">:</div>
                        <div class="col-md-6">
                            <input type="date" id="timeline" class="form-control" name="timeline">
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
                                    <option value="">All</option>
                                    <!-- <?php echo $vendor_inv_options; ?> -->


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



                <!-- style="display: none;" -->

                <div class="row mt-3" id="product_table">
                    <div class="table-responsive">
                        <table id="product_details_datatable"
                            class="table table-bordered table-striped align-middle display">
                            <thead>
                                <tr>
                                    <th>S. No</th>
                                    <th>Product Details</th>
                                    <th>Qty</th>
                                    <th id="shd">Assign Qty</th>
                                    <th id="rmq">Remaining Qty</th>
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

                <div class="row mt-3" id="partial_product_table" style="display:none">
                    <div class="table-responsive">
                        <table id="partial_product_details_datatable"
                            class="table table-bordered table-striped align-middle display">
                            <thead>
                                <tr>
                                    <th>S. No</th>
                                    <th>Vendor Type</th>
                                    <th>Assign Date</th>
                                    <th>Vendor Name</th>
                                    <th>Product Details</th>
                                    <th>Qty</th>
                                    <th>Assigned Qty</th>
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
                            <strong>Total: ₹ <span id="partial_grand_total">0.00</span></strong>
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
                <h5 class="modal-title fw-bold text-center w-100" id="viewModalLabel" style="color: #506018;">Product
                    Details
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close">x</button>
                <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
            </div>
            <div class="modal-body" style="background-color: #f9fafb;">


                <div class="table-responsive">
                    <table id="dc_details_datatable" class="table table-bordered table-striped align-middle">
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



   $(document).ready(function () {

    $("#po_num").prop("disabled", true);

    $("#eng_type").on("change", function () {

        var engg_type = $(this).val();

        if (engg_type == "own-engineer" || engg_type == "outsource-vendor" || engg_type == "inhouse") {
            $("#po_num").prop("disabled", false);
        } else {
            $("#po_num").prop("disabled", true);
            $("#po_num").val("");
        }

    });

});




    function get_qty() {
        var dc_num = document.getElementById("dc_num");
        var selectedValues = Array.from(select.selectedoptions).map(option => option.value);

    }


    document.addEventListener("DOMContentLoaded", function () {
        const selectAll = document.getElementById("select_all");

        if (!selectAll) return;

        selectAll.addEventListener("change", function () {
            const checkboxes = document.querySelectorAll(".myCheck");
            const eng_type = document.getElementById("eng_type")?.value || '';

            checkboxes.forEach(checkbox => {
                const partialSts = checkbox.dataset.partialSts || checkbox.getAttribute('data-partial-sts');

                if (selectAll.checked) {
                    if (partialSts === "1") {
                        checkbox.checked = false;
                        checkbox.disabled = true; // disable partial DCs
                    } else {
                        checkbox.checked = true;
                        checkbox.disabled = false;
                    }
                } else {
                    // Reset everything when unchecking "select all"
                    checkbox.checked = false;
                    checkbox.disabled = false;
                }
            });


            if (eng_type != 'own-engineer' || eng_type != 'inhouse') {
                if (selectAll.checked) {
                    $('#product_table').show();
                    get_productdetails(); // Load product data once after selecting
                } else {
                    //  $('#product_table').hide(); // Optionally hide table when deselected
                }
            }
            else {
                // alert('own');
                // $('#product_table').hide();
                $('#product_table').show();

            }

        });
    });



    function validation(sno) {
        // Partial qty input
        const input = document.getElementById('pd_partial_qty_' + sno);
        let enteredQty = input.value.trim();

        // Remaining qty fields
        const rem_input = document.getElementById('pd_remaining_qty_' + sno);

        const rem_old_qty = document.getElementById('pd_remaining_qty_old_' + sno);

        const rem_balance_qty = parseFloat(rem_old_qty.value) || 0;

        // Empty or invalid qty
        if (enteredQty === '' || isNaN(enteredQty)) {
            input.value = '';
            rem_input.value = rem_balance_qty; // reset to old remaining
            // return;
        }

        enteredQty = parseFloat(enteredQty);

        // Validation: entered qty > old remaining qty
        if (enteredQty > rem_balance_qty) {
            Swal.fire({
                icon: "error",
                title: "Invalid Quantity",
                text: "Partial quantity cannot be greater than remaining quantity!",
            }).then(() => {
                input.value = 0;             // reset input
                // rem_input.value = 0;         // reset new remaining qty
            });
            return;
        }

        // Calculate new remaining qty
        const new_rem_qty = ((rem_balance_qty) - (enteredQty));

        // alert(new_rem_qty);
        rem_input.value = new_rem_qty;
    }



    function validation_main_test(sno) {
        // alert(sno);
        // Get invoice quantity

        const qtySpan = document.getElementById('pd_qty_' + sno);
        const maxQty = parseFloat(qtySpan.getAttribute('data-value')) || 0;

        // Get partial quantity input
        const input = document.getElementById('pd_partial_qty_' + sno);
        let enteredQty = parseFloat(input.value) || 0;
        alert(enteredQty);
        // Get remaining quantity input and previous remaining value
        const rem_input = document.getElementById('pd_remaining_qty_' + sno);

        let rem_qtysss = parseFloat(rem_input.value) || 0;

        const rem_old_qty = document.getElementById('pd_remaining_qty_old_' + sno);

        let rem_balance_qty = parseFloat(rem_old_qty.value) || 0;

        // alert(rem_qtysss);
        let prev_rem_qty;


        // alert("Qty".maxQty); alert("entered_qty".enteredQty); alert("Previous qty".prev_rem_qty);
        // Check if remaining quantity is empty
        // if (rem_input.value === '' || rem_input.value === null || isNaN(prev_rem_qty)) {
        if (rem_qtysss === '' || rem_qtysss === null || isNaN(rem_qtysss)) {

            prev_rem_qty = maxQty; // First time entry
        } else {
            prev_rem_qty = rem_qtysss;
        }
        // alert(maxQty);
        // alert(enteredQty);
        // alert(prev_rem_qty);
        if (enteredQty.trim() === '') {
            // alert("working");
            document.getElementById('pd_remaining_qty_' + sno).value = rem_balance_qty;
        }
        // Validate entered quantity
        if (enteredQty > prev_rem_qty) {
            alert("Partial quantity cannot be greater than remaining quantity!");
            input.value = prev_rem_qty;
            enteredQty = prev_rem_qty;
        }
        else if (enteredQty > prev_rem_qty) {
            alert("Partial quantity cannot be greater than remaining quantity!");
            input.value = prev_rem_qty;
            enteredQty = prev_rem_qty;
        }

        if (enteredQty <= prev_rem_qty) {
            // Calculate new remaining quantity
            const new_rem_qty = prev_rem_qty - enteredQty;
            rem_input.value = new_rem_qty;
        }
        // Update remaining quantity input


    }

    function validation_notworking(sno) {
        // alert("hii");
        // Get invoice quantity max value
        const qtySpan = document.getElementById('pd_qty_' + sno);
        const maxQty = parseFloat(qtySpan.getAttribute('data-value')) || 0;

        // Get the input and entered value
        const input = document.getElementById('pd_partial_qty_' + sno);
        let enteredQty = parseFloat(input.value) || 0;

        // Get remaining quantity span and its stored value
        const rem_span = document.getElementById('pd_remaining_qty_' + sno);
        let prev_rem_qty = parseFloat(rem_span.value);

        // If prev_rem_qty is invalid or not set, treat as first time entry
        if (prev_rem_qty == '') {
            // First time: validate against maxQty
            if (enteredQty > maxQty) {
                alert("Partial quantity cannot be greater than invoice quantity!");
                input.value = maxQty;
                enteredQty = maxQty;
            }
            // Set initial remaining quantity
            const new_rem_qty = maxQty - enteredQty;
            rem_span.textContent = new_rem_qty.toFixed(2);

            // rem_span.setAttribute('data-remaining', new_rem_qty);
            document.getElementById("pd_remaining_qty_" + sno).textContent = new_rem_qty;
        } else {
            // Subsequent entry: validate against previous remaining quantity
            if (enteredQty > prev_rem_qty) {
                alert("Partial quantity cannot be greater than remaining quantity!");
                input.value = prev_rem_qty;
                enteredQty = prev_rem_qty;
            }
            const new_rem_qty = prev_rem_qty - enteredQty;
            document.getElementById("pd_remaining_qty_" + sno).textContent = new_rem_qty;
            // rem_span.textContent = new_rem_qty.toFixed(2);
            // rem_span.setAttribute('data-remaining', new_rem_qty);
        }
    }

    function validation_olds(sno) {
        // alert("hii");
        // Get invoice quantity max value
        const qtySpan = document.getElementById('pd_qty_' + sno);
        const maxQty = parseFloat(qtySpan.getAttribute('data-value')) || 0;

        // Get the input and entered value
        const input = document.getElementById('pd_partial_qty_' + sno);
        let enteredQty = parseFloat(input.value) || 0;

        // Get remaining quantity span and its stored value
        const rem_span = document.getElementById('pd_remaining_qty_' + sno);
        let prev_rem_qty = parseFloat(rem_span.getAttribute('data-remaining'));

        // If data-remaining is empty or invalid, treat as first time
        if (isNaN(prev_rem_qty)) {
            prev_rem_qty = maxQty;
        }


        if (enteredQty > maxQty) {
            alert("Partial quantity cannot be greater than remaining quantity!");
            input.value = maxQty; // Reset to allowed max
            enteredQty = maxQty;
        }
        // Validate that entered quantity cannot exceed previous remaining qty
        if (enteredQty > prev_rem_qty) {
            alert("Partial quantity cannot be greater than remaining quantity!");
            input.value = prev_rem_qty; // Reset to allowed max
            enteredQty = prev_rem_qty;
        }

        // Calculate new remaining quantity
        const new_rem_qty = prev_rem_qty - enteredQty;

        // Update the display and store the new remaining quantity
        rem_span.textContent = new_rem_qty.toFixed(2);
        rem_span.setAttribute('data-remaining', new_rem_qty);

        // Optionally, clear the input after processing to allow fresh entry next time
        // input.value = '';
    }

    function validation_old(sno) {
        // alert(sno);
        const qtySpan = document.getElementById('pd_qty_' + sno);
        const maxQty = parseFloat(qtySpan.getAttribute('data-value')) || 0;

        const input = document.getElementById('pd_partial_qty_' + sno);
        let enteredQty = parseFloat(input.value) || 0;

        if (enteredQty > maxQty) {
            alert("Partial quantity cannot be greater than invoice quantity!");

            input.value = maxQty; // Optionally reset to max allowed
            enteredQty = maxQty;
        }

        const rem_qtys = document.getElementById('pd_remaining_qty_' + sno);
        let remqty_val = parseFloat(rem_qtys.value);
        if (remqty_val == '') {
            const rem_qty = maxQty - enteredQty;
            document.getElementById("pd_remaining_qty_" + sno).textContent = rem_qty;

        }
        if (remqty_val == '') {

            const rem_qty = remqty_val - enteredQty;
            document.getElementById("pd_remaining_qty_" + sno).textContent = rem_qty;

        }


    }

    function gstcalculation(sno, par_cnt) {

        let qty = 0;
        let input;

        // Choose the correct input based on par_cnt
        if (par_cnt == '1') {
            const input = document.getElementById('pd_partial_qty_' + sno);
            qty = parseFloat(input?.value) || 0;
        } else {
            const span = document.getElementById('pd_qty_' + sno);
            qty = parseFloat(span?.textContent) || 0;
            // alert(qty);
        }




        const rateInput = document.getElementById("pd_rate_" + sno);

        // alert(rateInput);

        const rate = parseFloat(rateInput.value) || 0;

        if (qty === 0 || rate === 0) {
            console.warn("Invalid qty or rate", { qty, rate });
        }

        // alert(rate);
        // 
        const gstType = document.getElementById('gst_type').value;

        let gst = 0;
        if (gstType === "1") {
            gst = 18;
        } else if (gstType === "2") {
            gst = 0;
        }

        const tax_amount = (rate * qty * gst) / 100;

        // alert(tax_amount);

        const indiv_total_amnt = (rate * qty) + tax_amount;

        // alert(indiv_total_amnt);

        document.getElementById("tax_amnt_" + sno).textContent = tax_amount.toFixed(2);
        document.getElementById("pd_ttl_amnt_" + sno).textContent = indiv_total_amnt.toFixed(2);

        overalltotalcalculation();
    }

    // Function to calculate overall total
    // function overalltotalcalculation() {
    //     let total = 0;
    //     for (let i = 1; i <= rowCount; i++) {
    //         const totalElement = document.getElementById("pd_ttl_amnt_" + i);
    //         if (totalElement) {
    //             total += parseFloat(totalElement.textContent) || 0;
    //         }
    //     }
    //     document.getElementById("grand_total").textContent = total.toFixed(2);
    // }
    function gstcalculation11(sno) {
        // alert("hii");
        // const span = document.getElementById('pd_qty_' + sno);
        // const span = document.getElementById('pd_partial_qty_' + sno);
        // const qty = span.getAttribute('data-value');

        // Get the input element
        const input = document.getElementById('pd_partial_qty_' + sno);

        // Get its value
        const qtys = input.value;

        // Convert it to a number
        const qty = parseFloat(qtys);

        var gstType = $('#gst_type').val();
        var gst;

        if (gstType === "1") {
            gst = 18;
        } else if (gstType === "2") {
            gst = 0;
        }

        let rate = parseFloat(document.getElementById("pd_rate_" + sno).value) || 0;

        var tax_amount = (rate * qty * gst) / 100;

        var indiv_total_amnt = (rate * qty) + tax_amount;

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

    function overalltotalcalculation1() {

        // alert("hii");

        let grandTotal = 0;
        document.querySelectorAll("[id^='pd_ttl_amnt1_']").forEach(el => {

            grandTotal += parseFloat(el.textContent) || 0;
        });

        let round_grandTotal = Math.round(grandTotal);
        //  alert(round_grandTotal);
        document.getElementById("partial_grand_total").textContent = grandTotal.toFixed(2);
    }



    //final correct code,values null alone not done


    let allocationMode = null; // "partial" or "non-partial" (kept for UI/readability)

    document.addEventListener("change", function (e) {
        const eng_type = $("#eng_type").val();

        // If it's "own-engineer", just show table and exit
        if ((eng_type === 'own-engineer') || (eng_type === 'inhouse')) {
            $('#product_table').hide();
            return;
        }

        // Only handle checkbox clicks
        if (!e.target.classList.contains("myCheck")) return;

        const clicked = e.target;
        const allCheckboxes = Array.from(document.querySelectorAll('.myCheck'));
        const checkedBoxes = Array.from(document.querySelectorAll('.myCheck:checked'));

        // Update "select all" checkbox
        const selectAllEl = document.getElementById('select_all');
        if (selectAllEl) {
            selectAllEl.checked = allCheckboxes.length === checkedBoxes.length;
        }

        // Get partial status for each checked checkbox
        const partialStatuses = checkedBoxes.map(cb =>
            cb.dataset && cb.dataset.partialSts
                ? cb.dataset.partialSts
                : cb.getAttribute('data-partial-sts')
        );

        // If nothing is checked, clear the table & reset allocationMode
        if (checkedBoxes.length === 0) {
            allocationMode = null;
            clearProductTable();
            return;
        }

        let mode = null;

        // Single selection → always allowed as "partial"
        if (checkedBoxes.length === 1) {
            mode = 'partial';
        } else {
            const allZero = partialStatuses.every(s => s === "0" || s === "");
            const allOne = partialStatuses.every(s => s === "1");

            // ❗ Disallow multiple partials
            if (allOne && checkedBoxes.length > 1) {
                clicked.checked = false;

                // Update "select all" checkbox again after removal
                if (selectAllEl) {
                    selectAllEl.checked = allCheckboxes.length === document.querySelectorAll('.myCheck:checked').length;
                }

                Swal.fire({
                    icon: "error",
                    title: "Not Allowed",
                    text: "You cannot select more than one Partial DC."
                });

                return;
            }

            // Allow only if all are non-partial
            if (allZero) {
                mode = 'non-partial';
            } else if (allOne) {
                mode = 'partial';
            } else {
                // Mixed partial + non-partial → not allowed
                clicked.checked = false;

                if (selectAllEl) {
                    selectAllEl.checked = allCheckboxes.length === document.querySelectorAll('.myCheck:checked').length;
                }

                Swal.fire({
                    icon: "error",
                    title: "Not Allowed",
                    text: "Cannot mix Partial and Non-Partial DCs. The last selection was removed."
                });

                return;
            }
        }
        // Set mode and proceed
        allocationMode = mode;

        get_productdetails(mode);
    });



    function get_productdetails1() {
        let rateMemory = {};

        document.querySelectorAll("input[name='rate[]']").forEach(input => {
            const row = input.closest("tr");
            const item_code = row.querySelector(".ven_item_code")?.value || "";

            rateMemory[item_code] = input.value;
        });

        let selected_dc_numbers = [];

        // const dc_no = checkbox.getAttribute("data-id");

        document.querySelectorAll('.myCheck:checked').forEach(function (checkbox) {
            selected_dc_numbers.push(checkbox.getAttribute("data-id"));
        });
        const dcs = selected_dc_numbers.length;



        if (dcs != '' || dcs != 0) {
            get_productdetails(allocationMode);
        }
    }



    /* Clear product details table and UI */

    function clearProductTable() {
        const tableid = 'product_details_datatable';
        const tableSelector = $("#" + tableid);
        if ($.fn.DataTable.isDataTable(tableSelector)) {
            tableSelector.DataTable().clear().destroy();
        }
        $("#" + tableid + " tbody").html("<tr><td colspan='10' style='text-align:center;'>No data</td></tr>");
        $("#grand_total").text("0.00");
        $('#partial_product_table').hide();
        $('#shd').hide();
        $('#rmq').hide();
        $("input[id^='pd_partial_qty_']").hide();
        $("input[id^='pd_remaining_qty']").hide();
    }


    let initialValues = {};  // Store initial rate and ven_assign_qty

    // Store initial values of rate and ven_assign_qty when page loads
    function storeInitialValues() {
        document.querySelectorAll("input[name='rate[]']").forEach(input => {
            const row = input.closest("tr");
            const item_code = row?.querySelector(".ven_item_code")?.value || "";
            if (item_code) {
                initialValues[item_code] = {
                    rate: input.value,
                    ven_assign_qty: row?.querySelector(".ven_assign_qty")?.value || 0
                };
            }
        });
    }



    function get_productdetails(mode) {
        // keep a memory of existing rate inputs so we don't lose user-typed values on reload
        let rateMemory = {};

        let qtyMemory = {};

        storeInitialValues();

        document.querySelectorAll("input[name='rate[]']").forEach(input => {
            const row = input.closest("tr");
            const item_code = row?.querySelector(".ven_item_code")?.value || "";
            if (item_code) rateMemory[item_code] = input.value;

            if (item_code && initialValues[item_code]) {
                // Restore the initial rate value
                input.value = initialValues[item_code].rate;
            }
        });

        document.querySelectorAll("input[name^='pd_partial_qty_']").forEach(input => {
            const row = input.closest("tr");
            const item_code = row?.querySelector(".ven_item_code")?.value || "";

            if (item_code && initialValues[item_code]) {
                // Restore the initial ven_assign_qty value
                input.value = initialValues[item_code].ven_assign_qty;
            }
        });

        // collect selected DC numbers
        let selected_dc_numbers = [];
        document.querySelectorAll('.myCheck:checked').forEach(function (checkbox) {
            selected_dc_numbers.push(checkbox.getAttribute("data-id"));
        });

        if (selected_dc_numbers.length === 0) {
            allocationMode = null;
            clearProductTable();
            return;
        }

        // show/hide partial fields based on mode
        const isPartial = (mode === 'partial');
        if (isPartial) {
            $('#shd').show();
            $('#rmq').show();
            $("input[id^='pd_partial_qty_']").show();
            $("input[id^='pd_remaining_qty']").show();
        } else {
            $('#shd').hide();
            $('#rmq').hide();
            $("input[id^='pd_partial_qty_']").hide();
            $("input[id^='pd_remaining_qty']").hide();
        }

        const tableid = 'product_details_datatable';
        const table = $("#" + tableid);
        const ajax_url = sessionStorage.getItem("folder_crud_link");

        const data = {
            dc_no: selected_dc_numbers,
            gst_type: $('#gst_type').val(),
            partial: isPartial ? 1 : 0,   // IMPORTANT: send partial flag to server
            action: 'product_details_datatable'
        };

        // destroy previous DataTable if exists
        if ($.fn.DataTable.isDataTable('#' + tableid)) {
            table.DataTable().clear().destroy();
        }

        // choose columns according to mode
        const columns = isPartial ? [
            { data: "sno" },
            { data: "item_code" },
            { data: "invoice_qty" },
            { data: "partial_qty", defaultContent: "" },
            { data: "remaining_qty", defaultContent: "" },
            { data: "rate" },
            { data: "gst" },
            { data: "tax_amount" },
            { data: "total_amount" }
        ] : [
            { data: "sno" },
            { data: "item_code" },
            { data: "invoice_qty" },
            { data: "rate" },
            { data: "gst" },
            { data: "tax_amount" },
            { data: "total_amount" }
        ];

        // init datatable
        table.DataTable({
            ordering: false,
            searching: false,
            paging: false,
            info: false,
            lengthChange: false,
            ajax: {
                url: ajax_url,
                type: "POST",
                data: data,
                dataSrc: function (json) {
                    // server can still override using json.par_cnt; we also rely on client mode
                    if (isPartial || (json && json.par_cnt && json.par_cnt == 1)) {
                        $('#partial_product_table').show();
                        try { test(); } catch (err) { /* ignore if test() missing */ }
                    } else {
                        $('#partial_product_table').hide();
                    }
                    return json.data || [];
                }
            },
            columns: columns,
            initComplete: function () {
                // restore rates & recalc
                let par_cnt = this.api().ajax.json().par_cnt ?? (isPartial ? 1 : 2);
                setTimeout(() => {
                    document.querySelectorAll("input[name='rate[]']").forEach(input => {
                        const row = input.closest("tr");
                        const item_code = row?.querySelector(".ven_item_code")?.value || "";

                        const sno = input.id.split("_").pop();


                        if (rateMemory[item_code]) {
                            input.value = rateMemory[item_code];

                        }
                        try { gstcalculation(sno, par_cnt); } catch (err) { /* ignore */ }
                    });

                    document.querySelectorAll("input[name^='pd_partial_qty_']").forEach(input => {
                        const row = input.closest("tr");
                        const item_code = row?.querySelector(".ven_item_code")?.value || "";
                        if (qtyMemory[item_code]) {
                            input.value = qtyMemory[item_code];
                        }
                    });

                }, 100);
            },
            // be safe if a field is missing
            columnDefs: [
                { targets: "_all", defaultContent: "" }
            ]
        });
    }


    function test() {
        // alert("hii");
        let rateMemory = {};

        document.querySelectorAll("input[name='rate[]']").forEach(input => {
            const row = input.closest("tr");
            const item_code = row.querySelector(".ven_item_code")?.value || "";
            rateMemory[item_code] = input.value;
        });

        let selected_dc_numbers = [];

        // const dc_no = checkbox.getAttribute("data-id");

        document.querySelectorAll('.myCheck:checked').forEach(function (checkbox) {
            selected_dc_numbers.push(checkbox.getAttribute("data-id"));
        });
        const dcs = selected_dc_numbers.length;

        // Show the count
        // alert("Selected DC numbers: " + dcs);

        // Show or hide based on count

        // alert(selected_dc_numbers);
        var gstType = $('#gst_type').val();
        var engType = $('#eng_type').val();

        if (selected_dc_numbers.length === 0 && engType == 1) {
            alert('not selected');
            return;
        }

        // alert('myfunc');
        // var dcs = length(selected_dc_numbers);
        // alert(dcs);

        var tableid = 'partial_product_details_datatable';

        var table = $("#" + tableid);

        var data = {
            "dc_no": selected_dc_numbers,
            "gst_type": gstType,
            "action": 'partial_product_details_datatable',

        };

        // alert('succ');

        var ajax_url = sessionStorage.getItem("folder_crud_link");

        if ($.fn.DataTable.isDataTable('#' + tableid)) {
            table.DataTable().clear().destroy();
        }

        // Prepare the columns array based on dcs value //  { data: "remaining_qty" }, // Include partial_qty when dcs is 1  
        let columns = [];

        if (dcs === 1) {
            columns = [
                { data: "sno" },
                { data: "engg_type" },
                { data: "assign_date" },
                { data: "engg_name" },
                { data: "item_code" },
                { data: "invoice_qty" },
                { data: "partial_qty" }, // Include partial_qty when dcs is 1
                { data: "rate" },
                { data: "gst" },
                { data: "tax_amount" },
                { data: "total_amount" }
            ];
        } else {
            columns = [
                { data: "sno" },
                { data: "engg_type" },
                { data: "assign_date" },
                { data: "engg_name" },
                { data: "item_code" },
                { data: "invoice_qty" },
                // { data: "partial_qty" }, // Excluded when dcs is not 1
                { data: "rate" },
                { data: "gst" },
                { data: "tax_amount" },
                { data: "total_amount" }
            ];
        }

        // Initialize the DataTable
        var datatable = table.DataTable({
            ordering: false,
            searching: false,
            paging: false,
            info: false,
            lengthChange: false,
            ajax: {
                url: ajax_url,
                type: "POST",
                data: data

            },
            columns: columns, // Use the conditionally prepared columns array
            initComplete: function () {
                setTimeout(() => {
                    document.querySelectorAll("input[name='rate[]']").forEach(input => {
                        const row = input.closest("tr");
                        const item_code = row.querySelector(".ven_item_code")?.value || "";
                        if (rateMemory[item_code]) {
                            input.value = rateMemory[item_code];
                            const sno = input.id.split("_").pop();
                            overalltotalcalculation1(); // Recalculate tax & total
                        }
                    });
                }, 100);
            }
        });




    }



    function get_eng_name() {
        var engType = document.getElementById("eng_type").value;
        var engNameDropdown = document.getElementById("eng_name");

        // Toggle visibility of outsource fields
        var outsourceFields = document.querySelectorAll(".outsource-field");

        engNameDropdown.innerHTML = "";

        if (engType === "own-engineer") {

            engNameDropdown.innerHTML = `<?php echo $engineer_name_options1; ?>`;
            outsourceFields.forEach(f => f.classList.add('d-none'));

            $('#product_table').hide();
        } else if (engType === "outsource-vendor") {
            engNameDropdown.innerHTML = `<?php echo $vendor_option; ?>`;
            outsourceFields.forEach(f => f.classList.remove('d-none'));
            $('#product_table').show();
        }
        else if (engType === "inhouse") {
            engNameDropdown.innerHTML = `<?php echo $inhouse_option; ?>`;
            outsourceFields.forEach(f => f.classList.remove('d-none'));
            $('#product_table').hide();

        }
        // else {
        //     outsourceFields.forEach(f => f.classList.add('d-none'));
        // }


        var invoice_no = $('#inv_num').val();
        if (invoice_no) {
            pending_list(invoice_no);
        }

        // ✅ Also apply rules immediately when eng_type changes
        applyPartialCheckboxRules('doc_pending_list_datatable');
    }


    function applyPartialCheckboxRules(tableId) {
        const eng_type = $("#eng_type").val();

        $('#' + tableId + ' .myCheck').each(function () {
            if (((eng_type === 'own-engineer') || (eng_type === 'inhouse')) && $(this).data('partial-sts') == "1") {
                $(this).prop("disabled", true);
            } else {
                $(this).prop("disabled", false); // re-enable when not own-engineer
            }
        });
    }


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
                let options = '<option value="">Select Invoice</option><br><option value="">All</option>';

                if (Array.isArray(response.data)) {
                    response.data.forEach(row => {
                        options += `<option value="${row.invoice_no}">${row.invoice_no}</option>`;
                    });
                }

                $('#inv_num').html(options);
            },
            error: function () {
                // alert("Error retrieving invoice numbers.");
            }
        });
    }





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
