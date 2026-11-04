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





    $engineer_name_optionss = engineer_name();
    $engineer_name_options1 = select_option($engineer_name_optionss, "Select Engineer Name");

    // print_r($engineer_type_options1);
    

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


            <!-- 


            <div class="row g-3">

            

            

                <div class="col-md-2">
                    <div class="row">
                            <label class="form-label">Engineer Type</label>
                    <select class="form-control" name="eng_type" id="eng_type" onchange="get_eng_name()">

                        <option value="">Select Engineer Type</option>
                        <option value="own-engineer">Own Engineer</option>
                        <option value="outsource-vendor">Outsource Vendor</option>

                    </select>
                    </div>
                    
                </div>


                <div class="col-md-2">
                    <label class="form-label">Engineer Name</label>
                    <select class="form-control" name="eng_name" id="eng_name">
                        <option value="">Select Engineer Name</option>

                    </select>
                </div>

            


                <div class="col-md-2 outsource-field d-none">
                    <label class="form-label">Rate</label>
                    <input type="text" name="rate" class="form-control" id="rate" oninput="calculateGST()">
                  

                </div>

                <div class="col-md-2 outsource-field d-none">
                    <label class="form-label">Qty</label>
                    <div class="v-bor">
                        <h5 id="b_qty"><?= $invoice_qty; ?></h5>
                    </div>
                    <input type="hidden" name="qty" class="form-control" id="qty" readonly>
                  

                </div>

                <div class="col-md-2 outsource-field d-none">
                    <label class="form-label">GST</label>

                    <div class="v-bor">
                        <h5 id="b_gst">18%</h5>
                    </div>

                </div>
                <input type="hidden" id="gst" name="gst" value="18">

                <div class="col-md-2 outsource-field d-none">
                    <label class="form-label">Total Amount</label>
                    <div class="v-bor">
                        <h5 id="b_ttl_amnt"></h5>
                    </div>
                    <input type="hidden" name="ttl_amnt" class="form-control" readonly id="ttl_amnt">

                    <input type="hidden" name="dc_total_amount[{{dc_number}}]" id="dc_total_{{dc_number}}" value="">

                    <input type="hidden" name="per_ttl_amnt" class="form-control" readonly id="per_ttl_amnt"
                        value="<?php echo $bulk_dc_total_amount; ?>">

                </div>


                <input type="hidden" name="bulk_status" id="bulk_status" value="1">



                <div class="col-md-2">
                    <label class="form-label">Installation Allocation Date</label>
                    <input type="date" id="date" class="form-control" name="date">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Vendor Time Line Complition Date</label>
                    <input type="date" id="timeline" class="form-control" name="timeline">
                </div>

            </div> -->
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
                                    <!-- <option value="">Select PO No</option> -->
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
                                     
                                    <!-- <?php echo $vendor_inv_options; ?> -->


                                </select>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- <div class="row g-2">

    <div class="col-md-4">
        <div class="row mb-2">
            <label class="col-md-4 col-form-label">
                STATE<span class="mx-1"></span>
            </label>
            <div class="col-md-1 dot">:</div>
            <div class="col-md-6">
                <select class="form-control" name="state" id="state">
                    <option value="">Select State</option>
                    <?php echo $state_options; ?>
                </select>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="row mb-2">
            <label class="col-md-4 col-form-label">
                DISTRICT<span class="mx-1"></span>
            </label>
            <div class="col-md-1 dot">:</div>
            <div class="col-md-6">
                <select class="form-control" name="district" id="district">
                    <option value="">Select District</option>
                    <?php echo $district_options; ?>
                </select>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="row mb-2">
            <label class="col-md-4 col-form-label">
                ZONE<span class="mx-1"></span>
            </label>
            <div class="col-md-1 dot">:</div>
            <div class="col-md-6">
                <select class="form-control" name="zone" id="zone">
                    <option value="">Select Zone</option>
                    <?php echo $zone_options; ?>
                </select>
            </div>
        </div>
    </div>

</div> -->



                <!-- <div class="col-md-2">
                    <label class="form-label">DC NO</label>
                    <select class="form-control" name="dc_num" id="dc_num" onchange="get_qty()">
                        <option value="">Select DC No</option>
                     
                    </select>
                </div> -->

                <!-- <div class="col-md-2">
                    <label class="form-label">Rate</label>
                      <input type="text" name="rate" class="form-control" id="rate" oninput="calculateGST()">
                    
                </div>
                 <div class="col-md-2">
                    <label class="form-label">Qty</label>
                   

                </div>


                 <div class="col-md-2">
                    <label class="form-label">GST</label>
                   
                </div>

                
                  <input type="hidden" id="gst" name="gst" value="18">
                  <input type="hidden" name="qty"  id="qty" readonly>


                 

                

            </div> -->

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



    document.addEventListener("DOMContentLoaded", function () {
        document.getElementById("po_num").disabled = true;

        document.getElementById("eng_type").addEventListener('change', function () {

            var engg_type = this.value;
            var poselect = document.getElementById("po_num");

            if (engg_type == "own-engineer" || engg_type == "outsource-vendor") {
                poselect.disabled = false;

            }
            else {
                poselect.disabled = true;
                poselect.value = "";

            }
        });
    });




    function get_qty() {
        var dc_num = document.getElementById("dc_num");
        var selectedValues = Array.from(select.selectedoptions).map(option => option.value);

    }

    document.addEventListener("DOMContentLoaded", function () {
        // alert('test');
        const selectAll = document.getElementById("select_all");
        const eng_type = document.getElementById("eng_type").value;
        // alert(eng_type);

        if (!selectAll) return;

        selectAll.addEventListener("change", function () {
            // alert('select all');
            const checkboxes = document.querySelectorAll(".myCheck");
            checkboxes.forEach(checkbox => {
                checkbox.checked = selectAll.checked;




            });

            if (eng_type != 'own-engineer') {
                if (selectAll.checked) {
                    $('#product_table').show();
                    get_productdetails(); // Load product data once after selecting
                } else {
                    //  $('#product_table').hide(); // Optionally hide table when deselected
                }
            }
            else {
                // alert('own');
                $('#product_table').hide();
            }
        });
    });


    // document.addEventListener("DOMContentLoaded", function () {
    //     const selectAll = document.getElementById("select_all");


    //      if (eng_type == 'own-engineer') {

    //           selectAll.addEventListener("change", function () {
    //         const checkboxes = document.querySelectorAll(".myCheck");
    //         checkboxes.forEach(checkbox => {
    //             checkbox.checked = selectAll.checked;
    //         });




    //     });
    //      }

    //      else{
    //          // Event listener for "Select All" checkbox
    //     selectAll.addEventListener("change", function () {
    //         const checkboxes = document.querySelectorAll(".myCheck");
    //         checkboxes.forEach(checkbox => {
    //             checkbox.checked = selectAll.checked;
    //         });



    //         $('#product_table').show();

    //         if (checkbox.checked) {
    //             get_productdetails();
    //              // Fetch and populate data
    //         }


    //     });
    //      }


    // });

    //     // Event listener for individual checkboxes
    //     document.addEventListener("change", function (event) {
    //         if (event.target.classList.contains("myCheck")) {
    //             const checkboxes = document.querySelectorAll(".myCheck");
    //             const checkedBoxes = document.querySelectorAll(".myCheck:checked");

    //             // Uncheck "Select All" if any checkbox is unchecked
    //             if (checkedBoxes.length !== checkboxes.length) {
    //                 selectAll.checked = false;
    //             } else {
    //                 selectAll.checked = true;
    //             }
    //         }
    //     });
    // });




    // document.getElementById('rate').addEventListener('input', calculateGST);
    // document.getElementById('gst').addEventListener('change', calculateGST);







    // let checkedItems = {}; // Stores checked DCs with their qty

    // document.addEventListener("DOMContentLoaded", function () {



    //     const table = $('#doc_pending_list_datatable').DataTable();
    //     const selectAll = document.getElementById("select_all");

    //     // Handle "Select All" checkbox
    //     selectAll.addEventListener("change", function () {
    //         const isChecked = this.checked;
    //         document.querySelectorAll(".myCheck").forEach(checkbox => {
    //             checkbox.checked = isChecked;

    //             const dc_id = checkbox.getAttribute("data-id");
    //             const invoice_qty = parseInt(checkbox.getAttribute("data-invoice-qty")) || 0;

    //             $('#qty').val(invoice_qty);

    //             document.getElementById('b_qty').textContent = invoice_qty;

    //             if (isChecked) {
    //                 checkedItems[dc_id] = invoice_qty;
    //             } else {
    //                 delete checkedItems[dc_id];
    //             }
    //         });
    //         updateTotalInvoiceQty();
    //         calculateGST();
    //     });

    //     // Handle individual checkbox clicks
    //     document.addEventListener("change", function (e) {
    //         if (e.target.classList.contains("myCheck")) {
    //             const checkbox = e.target;
    //             const dc_id = checkbox.getAttribute("data-id");
    //             const invoice_qty = parseInt(checkbox.getAttribute("data-invoice-qty")) || 0;

    //             if (checkbox.checked) {
    //                 checkedItems[dc_id] = invoice_qty;
    //             } else {
    //                 delete checkedItems[dc_id];
    //             }

    //             // Update select all checkbox state
    //             const allVisible = document.querySelectorAll(".myCheck");
    //             const allChecked = [...allVisible].every(cb => cb.checked);
    //             selectAll.checked = allChecked;

    //             updateTotalInvoiceQty();
    //             calculateGST();
    //         }
    //     });

    //     // Rate or GST change
    //     document.getElementById('rate').addEventListener('input', calculateGST);
    //     document.getElementById('gst').addEventListener('change', calculateGST);
    // });


    // document.addEventListener("change", function (e){

    //     alert('check');

    //     if(e.target.classList.contains("mycheck")){
    //           const checkbox = e.target;
    //         const dc_num = checkbox.getAttribute("data-id");

    //         if(checkbox.checked){

    //             get_productdetails(dc_num);
    //         }
    //     }
    // });



    // function updateTotalInvoiceQty() {
    //     let total_qty = 0;
    //     document.querySelectorAll(".myCheck:checked").forEach(checkbox => {
    //         const invoice_qty = parseInt(checkbox.getAttribute("data-invoice-qty")) || 0;
    //         total_qty += invoice_qty;
    //     });

    //     document.getElementById("qty").value = total_qty;
    //     document.getElementById('b_qty').textContent = total_qty;
    // }

    // function calculateGST() {
    //     const rate = parseFloat(document.getElementById('rate').value) || 0;
    //     const gst = parseFloat(document.getElementById('gst').value) || 0;

    //     let total_qty = 0;

    //     for (let dc_id in checkedItems) {
    //         total_qty += checkedItems[dc_id];
    //     }

    //     const baseAmount = total_qty * rate;

    //     // alert(baseAmount);
    //     const gstAmount = (baseAmount * gst) / 100;

    //     // alert(gstAmount);
    //     const totalAmount = baseAmount + gstAmount;

    //     // alert(totalAmount);

    //     document.getElementById('ttl_amnt').value = totalAmount.toFixed(2);

    //     document.getElementById('b_ttl_amnt').textContent = totalAmount.toFixed(2);

    //     document.getElementById('per_ttl_amnt').value = (rate + (rate * gst / 100)).toFixed(2);


    //     // Update per DC total value
    //     for (let dc_id in checkedItems) {
    //         const qty = checkedItems[dc_id];
    //         const dc_base = qty * rate;
    //         const dc_gst = (dc_base * gst) / 100;
    //         const dc_total = dc_base + dc_gst;

    //         const dc_input = document.getElementById("dc_total_" + dc_id);
    //         if (dc_input) {
    //             dc_input.value = dc_total.toFixed(2);
    //         }
    //     }
    // }

    //from crud

    function gstcalculation(sno) {

        const span = document.getElementById('pd_qty_' + sno);
        const qty = span.getAttribute('data-value');

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


    //     function get_productdetails(){

    // document.addEventListener("change", function (e) {
    //             if (e.target.classList.contains("myCheck")) {
    //                 const checkbox = e.target;
    //                 const dc_id = checkbox.getAttribute("data-id");

    //                 alert(dc_id);



    //             }
    //         });

    //     }


    // document.addEventListener("change", function (e) 
    // {

    //      var eng_type   =  $("#eng_type").val();
    //   var eng_name   =  $("#eng_name").val();


    //   if(eng_type === 'own-engineer'){


    //   }

    //   else{

    //      $('#product_table').show();
    //      if (e.target.classList.contains("myCheck")) {



    //                 // alert('te');
    //                 const checkbox = e.target;

    //                 if(checkbox.checked){
    //                     $('#product_table').show();
    //                     // alert('tes');
    //                      get_productdetails();
    //                 }
    //                 else {

    //                      $('#product_table').show();


    //      var tableid = 'product_details_datatable';

    //    if ( $.fn.DataTable.isDataTable('#product_details_datatable') ) {
    //     $('#product_details_datatable').DataTable().columns.adjust();
    // }

    //     // Show a custom "no data" message manually (optional)
    //     $("#" + tableid + " tbody").html("<tr><td colspan='10' style='text-align:center;'>No data</td></tr>");
    //     // 
    //     //   var tableid = 'product_details_datatable';
    //     // var table = $("#" + tableid);

    //     // if ($.fn.DataTable.isDataTable('#' + tableid)) {
    //     //     // Destroy and clear DataTable properly
    //     //     table.DataTable().clear().destroy();
    //     // }

    //     // // Insert "No data" message into <tbody>
    //     // const tbody = document.querySelector('#' + tableid + ' tbody');
    //     // if (tbody) {
    //     //     tbody.innerHTML = "<tr><td colspan='6' style='text-align:center;'>No data</td></tr>";
    //     // }
    //             // Optional: clear the table if unchecked
    //             // document.getElementById("product_details_datatable").innerHTML = "<tr><td colspan='5'>No data</td></tr>";
    //         }






    //             }
    //   }

    //         });


    //final correct code,values null alone not done

    document.addEventListener("change", function (e) {
        const eng_type = $("#eng_type").val();
        const eng_name = $("#eng_name").val();


        if (eng_type !== 'own-engineer') {
            if (e.target.classList.contains("myCheck")) {
                const checkbox = e.target;

                $('#product_table').show();

                // Sync select_all checkbox status
                const allCheckboxes = document.querySelectorAll('.myCheck');
                const checkedCheckboxes = document.querySelectorAll('.myCheck:checked');
                document.getElementById('select_all').checked = allCheckboxes.length === checkedCheckboxes.length;

                if (checkbox.checked) {
                    get_productdetails();
                    // Fetch and populate data
                }

                else {

                    const tableid = 'product_details_datatable';
                    const tableSelector = $("#" + tableid);

                    const checkedCount = document.querySelectorAll('.myCheck:checked').length;

                    // alert(checkedCount);

                    if (checkedCount === 0) {

                        // alert('etst');
                        if ($.fn.DataTable.isDataTable(tableSelector)) {
                            tableSelector.DataTable().clear().destroy();
                        }




                        $("#" + tableid + " tbody").html(
                            "<tr><td colspan='10' style='text-align:center;'>No data</td></tr>"
                        );
                        // get_productdetails();

                        $("#grand_total").text("0.00"); // Optional: reset grand total
                    } else {
                        // alert('last else');

                        get_productdetails(); // reload with remaining checked boxes
                    }
                }

            }
        }

        else {
            $('#product_table').hide();
        }
    });



    // document.addEventListener("change", function (e) {
    //     const eng_type = $("#eng_type").val();
    //     const eng_name = $("#eng_name").val();

    //     if (eng_type !== 'own-engineer') {
    //         if (e.target.classList.contains("myCheck")) {
    //             const checkbox = e.target;
    //             const tableid = 'product_details_datatable';
    //             const tableSelector = $("#" + tableid);

    //             $('#product_table').show();

    //             if (checkbox.checked) {
    //                 get_productdetails(); // Load data for new selection
    //             } else {
    //                 const checkedBoxes = document.querySelectorAll('.myCheck:checked');
    //                 const rowData = [];

    //                 checkedBoxes.forEach((cb) => {
    //                     const row = cb.closest('tr');

    //                     const data = {
    //                         po_unique_id: row.querySelector(".ven_po_unique_id")?.value || '',
    //                         product_unique_id: row.querySelector(".ven_product_unique_id")?.value || '',
    //                         item_code: row.querySelector(".ven_item_code")?.value || '',
    //                         product: row.querySelector(".ven_product")?.value || '',
    //                         dc_no: row.querySelector(".ven_dc_no")?.value || '',
    //                         qty: row.querySelector(".qty")?.textContent.trim() || '0',
    //                         rate: row.querySelector("input[name='rate[]']")?.value || '',
    //                         tax_amount: row.querySelector(".tax_amount")?.textContent || '',
    //                         total_amount: row.querySelector(".total_amount")?.textContent || ''
    //                     };

    //                     rowData.push(data);
    //                 });

    //                 // Clear old DataTable if exists
    //                 if ($.fn.DataTable.isDataTable(tableSelector)) {
    //                     tableSelector.DataTable().clear().destroy();
    //                 }

    //                 // Clear the table body
    //                 $("#" + tableid + " tbody").empty();

    //                 if (rowData.length === 0) {
    //                     $("#" + tableid + " tbody").html("<tr><td colspan='10' style='text-align:center;'>No data</td></tr>");
    //                     $("#grand_total").text("0.00");
    //                     return;
    //                 }

    //                 // Rebuild table rows from cached values
    //                 rowData.forEach((item, index) => {
    //                     const rowHTML = `
    //                         <tr>
    //                             <td>${index + 1}</td>
    //                             <td>${item.product}</td>
    //                             <td class="qty">${item.qty}</td>
    //                             <td><input type="text" name="rate[]" class="form-control" value="${item.rate}"></td>
    //                             <td>18%</td>
    //                             <td class="tax_amount">${item.tax_amount}</td>
    //                             <td class="total_amount">${item.total_amount}</td>

    //                             <input type="hidden" class="ven_po_unique_id" value="${item.po_unique_id}">
    //                             <input type="hidden" class="ven_product_unique_id" value="${item.product_unique_id}">
    //                             <input type="hidden" class="ven_item_code" value="${item.item_code}">
    //                             <input type="hidden" class="ven_product" value="${item.product}">
    //                             <input type="hidden" class="ven_dc_no" value="${item.dc_no}">
    //                         </tr>
    //                     `;
    //                     $("#" + tableid + " tbody").append(rowHTML);
    //                 });

    //                 // Optional: reinitialize DataTable if required
    //                 // $("#" + tableid).DataTable();
    //             }
    //         }
    //     }
    // });


    function get_productdetails() {

        $('#product_table').show();


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

        // alert(selected_dc_numbers);
        var gstType = $('#gst_type').val();
        var engType = $('#eng_type').val();

        if (selected_dc_numbers.length === 0 && engType == 1) {
            alert('not selected');
            return;
        }

        // alert('myfunc');


        var tableid = 'product_details_datatable';

        var table = $("#" + tableid);

        var data = {
            "dc_no": selected_dc_numbers,
            "gst_type": gstType,
            "action": 'product_details_datatable',

        };

        // alert('succ');

        var ajax_url = sessionStorage.getItem("folder_crud_link");

        if ($.fn.DataTable.isDataTable('#' + tableid)) {
            table.DataTable().clear().destroy();
        }

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
            columns: [

                { data: "sno" },
                { data: "item_code" },        // product + item code display
                // { data: "dc_no" },            // optional - visible or hidden
                { data: "invoice_qty" },      // qty
                { data: "rate" },
                { data: "gst" },
                { data: "tax_amount" },
                { data: "total_amount" },

            ],
            initComplete: function () {
                // Adjust column widths after render
                // this.api().columns.adjust();

                setTimeout(() => {
                    document.querySelectorAll("input[name='rate[]']").forEach(input => {
                        const row = input.closest("tr");
                        const item_code = row.querySelector(".ven_item_code")?.value || "";
                        if (rateMemory[item_code]) {
                            input.value = rateMemory[item_code];
                            const sno = input.id.split("_").pop();
                            gstcalculation(sno); // 3️⃣ Recalculate tax & total
                        }
                    });
                }, 100);
            }

        });

    }




    // function calculateGST() {

    //     // alert('gst');
    //      let total_invoice_qty = 0;
    //     // Get the rate (amount entered by the user)
    //     var rate = parseFloat(document.getElementById('rate').value);

    //     // Get the selected GST percentage
    //     var gstPercentage = parseFloat(document.getElementById('gst').value);

    //      document.querySelectorAll(".myCheck:checked").forEach(checkbox =>{
    //         // alert('checkbox');
    //         const invoice_qty = parseInt(checkbox.getAttribute("data-invoice-qty")) || 0;


    //         //  alert(invoice_qty);
    //         total_invoice_qty += invoice_qty;

    //         alert(total_invoice_qty);
    //     });

    //     // Check if the rate is a valid number
    //     // if (isNaN(rate) || rate <= 0) {
    //     //     document.getElementById('gst_amount').value = '';
    //     //     document.getElementById('ttl_amnt').value = '';
    //     //     return;
    //     // }
    //     if (isNaN(rate) || isNaN(gstPercentage)) {
    //         document.getElementById('s_ttl_amnt').value = '-';
    //         // return;
    //     }

    //     var baseAmount = parseInt(total_invoice_qty * rate);

    //     // alert(baseAmount);

    //     // Calculate the GST amount
    //     var gstAmount = (baseAmount * gstPercentage) / 100;

    //     var singleperAmount = (rate * gstPercentage) / 100;


    //     // Calculate the total amount (rate + gstAmount)
    //     var totalAmount = baseAmount + gstAmount;

    //      var pertotalAmount = rate + singleperAmount;

    //   document.getElementById('per_ttl_amnt').value = pertotalAmount;

    //     // Display the calculated GST and total amount
    //     document.getElementById('ttl_amnt').value = totalAmount.toFixed(2); 




    //      document.querySelectorAll(".myCheck").forEach(checkbox => {

    //         console.log(document.querySelectorAll("input[id^='dc_total_']"));

    //         const dc_qty = parseFloat(checkbox.getAttribute("data-invoice-qty")) || 0;
    //         const dc_number = checkbox.getAttribute("data-id"); 
    //         // alert(dc_number);
    //         // Must match ID
    //         const dc_amount_span = document.getElementById("dc_total_" + dc_number);

    //         const dc_input = document.querySelector(`input[id="dc_total_${dc_number}"]`);

    //         // const inv_qty  = 

    //         if (checkbox.checked && dc_number && dc_amount_span) {

    //             // alert('dc checked');
    //             const dc_base_amount = dc_qty * rate;
    //             const dc_gst_amount = (dc_base_amount * gstPercentage) / 100;
    //             const dc_total = dc_base_amount + dc_gst_amount;
    //             const dc_totl_amnt = dc_total.toFixed(2);

    //             // dc_amount_span.textContent = `${dc_totl_amnt}`;

    //             if (dc_input) {
    //                 dc_input.value = dc_totl_amnt;
    //             } else {
    //                 console.warn(`No input found for ID: dc_total_${dc_number}`);
    //             }
    //         } else if (dc_amount_span) {
    //             dc_amount_span.textContent = `₹0.00`;
    //         }
    //     });
    // }


    // document.addEventListener("change", function (event) {
    //     if (event.target.classList.contains("myCheck")) {
    //         calculateGST();
    //     }
    // });







    // Display total amount with 2 decimals



    // function get_eng_name() {
    //     var engType = document.getElementById("eng_type").value;

    //     //  alert(engType);
    //     var engNameDropdown = document.getElementById("eng_name");

    //     var outsourceFields = document.getElementById("outsource-fields");

    //     outsourceFields.style.display = 'none';

    //     // Clear existing options
    //     engNameDropdown.innerHTML = "";

    //     if (engType === "own-engineer") {

    //         engNameDropdown.innerHTML = `<?php echo $engineer_name_options1; ?>`;
    //         outsourceFields.style.display = 'none';

    //     } else if (engType === "outsource-vendor") {

    //         outsourceFields.style.display = 'block';

    //         engNameDropdown.innerHTML = `<?php echo $vendor_option; ?>`;
    //     }
    // }



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
        } else {
            outsourceFields.forEach(f => f.classList.add('d-none'));
        }
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




    //      document.getElementById('select_all').addEventListener('change', function() {
    //     const checkboxes = document.querySelectorAll('.myCheck');
    //     checkboxes.forEach(function(checkbox) {
    //         checkbox.checked = this.checked;
    //     }.bind(this));
    // });
</script>
