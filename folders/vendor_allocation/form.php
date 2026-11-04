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

     .custom-wide-modal {
    max-width: 85vw;
    width: 80vw;
  }

  .mdi-eye {
    font-size: 20px;
  }

  table thead tr th{
        text-align:center;
    }

    /* .dot {
    align-self: center;
} */
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


            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Form</a></li>
                    <li class="breadcrumb-item active">Vendor Allocation</li>
                </ol>
            </div>
        </div>

        <div>


        </div>
    </div>
</div>
<div class="row">
    <!-- <div class="card">
           <div class="card-body">


               <center>
                   <h3> LIST</h3>
               </center>


           </div>
       </div> -->

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

                $invoice_qty = $result_values[0]["invoice_qty"];

                $vendor_bulk_sts = $result_values[0]["vendor_bulk_sts"];

                $bulk_dc_total_amount = $result_values[0]["bulk_dc_total_amount"];



                if ($eng_type == 'own-engineer') {

                    $eng_type = 'Own Engineer';
                } elseif ($eng_type == 'outsource-vendor') {
                    $eng_type = 'Outsource Engineer';
                }



                $btn_text = "Update";
                $btn_action = "update";
            } else {
                $btn_text = "Error";
                $btn_action = "error";
                $is_btn_disable = "disabled='disabled'";
            }
        }
    }


    $sess_user_id = $_SESSION['user_type_unique_id'];



    $is_admin = (($sess_user_id == '65deef78ba17d65741') || ($sess_user_id == '5f97fc3257f2525529'));

    // echo $is_admin;


    $vendor_name = vendor_names();

    $vendor_option = select_option($vendor_name, "Select Vendor", $eng_name);

    $invoice_no = $_GET['invoice_no'];


    // print_r($invoice_no);





    $engineer_name_optionss = engineer_name();
    $engineer_name_options1 = select_option($engineer_name_optionss, "Select Engineer Name", $eng_name);


    //vendor name
    $engineer_type_options = engineer_type();
    $engineer_type_options1 = select_option($engineer_type_options, "Select Eng Name");



    // $assign  = ven_assign_no();


    // print_r($assign);die();




    ?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css">






    <input type="hidden" id="dc_no" value="<?= $dc_no; ?>">
    <div class="card">
        <div class="card-body">

            <div class="row g-2">

                <!-- LEFT COLUMN -->
                <div class="col-md-6">
                    <div class="row mb-2">
                        <label class="col-md-3 col-form-label">
                            Engineer Type<span class="mx-1"></span>
                        </label>
                        <div class="col-md-1 dot">:</div>
                        <div class="col-md-7">
                            <span class=""><b><?= $eng_type; ?></b></span>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <label class="col-md-3 col-form-label ">Engineer Name </label>
                        <div class="col-md-1 dot">:</div>
                        <div class="col-md-7">
                             <span class=""><b><?= $eng_type; ?></b></span>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <label class="col-md-3 col-form-label ">Installation Date </label>
                        <div class="col-md-1 dot">:</div>
                        <div class="col-md-7">

                            <span class=""><b><?= $vendor_ins_date; ?></b></span>
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
                            <span class=""><b><?= $ven_assign_no; ?></b></span>




                        </div>
                    </div>

                    <div class="row mb-2">
                        <label class="col-md-2 col-form-label ">
                            Assign Date
                        </label>
                        <div class="col-md-1 dot">:</div>
                        <div class="col-md-6">
                            <span class=""><b><?= $ven_assign_date; ?></b></span> <input type="hidden" name="assign_date" class="form-control" id="assign_date" value="<?php echo $assigndate; ?>">
                        </div>
                    </div>

                    <div class="row mb-2">
                        <label class="col-md-2 col-form-label ">Time Line
                        </label>
                        <div class="col-md-1 dot">:</div>
                        <div class="col-md-6">
                            <!-- vendor_timeline -->
                            <span class=""><b><?= $vendor_timeline; ?></b></span>
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
            <div class="table-responsive">
                <table id="list_datatable" class="table table-bordered table-striped align-middle">
                    <thead>
                        <tr>


                            <th style="text-align: center;">S.No</th>
                            <th style="text-align: center;">PO No / Date</th>
                            <th style="text-align: center;">Invoice No / Date</th>
                            <th style="text-align: center;">DC No / Date</th>
                            <th style="text-align: center;">Qty</th>
                            <th style="text-align: center;">Department</th>
                            <th style="text-align: center;">Consignee</th>
                            <th style="text-align: center;">Action</th>

                        </tr>
                    </thead>
                    <tbody>
                        <tr>

                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-12 mt-3">
                <div class="form-group row">
                    <div class="col-md-12" align="right">



                        <?php if ($vendor_bulk_sts == '1') { ?>
                            <?php echo btn_cancel($btn_cancel); ?>
                        <?php } else { ?>
                            <?php echo btn_cancel($btn_cancel); ?>
                            <button type="button" class="btn btn-primary waves-effect waves-light" id="approve_btn"
                                onclick="individual_vendor_update()">Submit</button>

                        <?php } ?>
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










<div class="modal fade" id="producdetailsmodal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
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
                                            <table id="dc_product_datatable"
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
                                               <tbody id="product_table_body">
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


<!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>

document.getElementById('producdetailsmodal').addEventListener('hidden.bs.modal', function () {
    document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
    document.body.classList.remove('modal-open');
});



function product_popup(dc_num) {


    // Optional: Load dynamic data here using AJAX if needed
                // $('#producdetailsmodal').modal('show');

    var data = {
        dc_num :dc_num,
        "action":"product_details"
    };

      var ajax_url = sessionStorage.getItem("folder_crud_link");


    $.ajax({

        type:"POST",
        url:ajax_url,
        data:data,

         dataType: "json",
        success: function(response) {
            var tbody = $('#product_table_body');
            tbody.empty();

            var productData = response.data;

            var totalSum = 0;



            // console.log("Product Data:", productData); // Debug
            // alert(JSON.stringify(productData, null, 2)); // Optional: Show in readable format

            if (productData && productData.length > 0) {
                productData.forEach(function(item, index) {

                    var total = parseFloat(item.total_amount);

                    totalSum += total;
                    var row = `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${item.item_code}</td>
                           
                            <td style="text-align: right; font-weight: bold;">${item.invoice_qty}</td>
                            <td style="text-align: right; font-weight: bold;">${item.rate}</td>
                            <td style="text-align: right; font-weight: bold;">${item.gst}</td>
                            <td style="text-align: right; font-weight: bold;">${item.tax_amount}</td>
                            <td style="text-align: right; font-weight: bold;">${item.total_amount}</td>
                        </tr>
                    `;
                    tbody.append(row);
                });

               $('#total_sum').text(totalSum.toFixed(2));
            } else {
                tbody.append('<tr><td colspan="8" class="text-center">No data found.</td></tr>');
            }

            // Show the Bootstrap 5 modal
            var myModal = new bootstrap.Modal(document.getElementById('producdetailsmodal'));
            myModal.show();
        },
        error: function(err) {
            console.error("Error loading product data:", err);
        }
    });
}     

        
    // Open the modal


    $(document).ready(function() {

        allocation_list();

    })




    function allocation_list(table_id = '') {

        var table_id = 'list_datatable';


        var invoice_no = $("#invoice_no").val();
        var dc_no = $("#dc_no").val();
        // alert(screen_id_val);
        var table = $("#" + table_id);

        var data = {
            "action": "allocation_list",
            "dc_no": dc_no,
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
            buttons: [{
                    extend: 'copyHtml5',
                    text: 'Copy',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'csvHtml5',
                    text: 'CSV',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'excelHtml5',
                    text: 'Excel',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'pdfHtml5',
                    text: 'PDF',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'print',
                    text: 'Print',
                    exportOptions: {
                        columns: ':visible'
                    }
                },

            ]
        });

    }
























    //   document.addEventListener("DOMContentLoaded", function () {
    //     const selectAll = document.getElementById("select_all");

    //     // Event listener for "Select All" checkbox
    //     selectAll.addEventListener("change", function () {
    //         const checkboxes = document.querySelectorAll(".myCheck");
    //         checkboxes.forEach(checkbox => {
    //             checkbox.checked = selectAll.checked;
    //         });
    //     });

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


    $(document).ready(function() {

        get_eng_name();

        calculateGST();
    });



    // function get_eng_name() {
    //     var engType = document.getElementById("s_eng_type").value;
    //     var engNameDropdown = document.getElementById("s_eng_name");

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
        var engType = document.getElementById("s_eng_type").value;
        var engNameDropdown = document.getElementById("s_eng_name");

        // Toggle visibility of outsource fields
        var outsourceFields = document.querySelectorAll(".outsource-field");

        engNameDropdown.innerHTML = "";

        if (engType === "own-engineer") {
            engNameDropdown.innerHTML = `<?php echo $engineer_name_options1; ?>`;
            outsourceFields.forEach(f => f.classList.add('d-none'));
        } else if (engType === "outsource-vendor") {
            engNameDropdown.innerHTML = `<?php echo $vendor_option; ?>`;
            outsourceFields.forEach(f => f.classList.remove('d-none'));
        } else {
            outsourceFields.forEach(f => f.classList.add('d-none'));
        }
    }



    document.getElementById('s_rate').addEventListener('input', calculateGST);
    document.getElementById('s_gst').addEventListener('change', calculateGST);


    function calculateGST() {

        // alert('test');
        // Get the rate (amount entered by the user)
        var rate = parseFloat(document.getElementById('s_rate').value);

        //    alert(rate);

        var invoice_qty = parseFloat(document.getElementById('invoice_qty').value);


        // Get the selected GST percentage
        var gstPercentage = parseFloat(document.getElementById('s_gst').value);

        //    alert(gstPercentage);


        if (isNaN(rate) || isNaN(gstPercentage)) {
            document.getElementById('s_ttl_amnt').value = '-';
            return;
        }

        // var single

        var total_rate = rate * invoice_qty;

        // Calculate the GST amount
        var single_gstAmount = (rate * gstPercentage) / 100;

        var ttl_gst_amnt = (total_rate * gstPercentage) / 100;

        // Calculate the total amount (rate + gstAmount)
        var single_ttl_amnt = rate + ttl_gst_amnt;

        //    alert(single_ttl_amnt);

        var totalAmount = (total_rate + ttl_gst_amnt);

        document.getElementById('per_ttl_amnt').value = single_ttl_amnt.toFixed(2);
        document.getElementById('s_ttl_amnt').value = totalAmount.toFixed(2);

        document.getElementById('div_ttl_amnt').textContent = totalAmount.toFixed(2);


    }


    function print_pdf_1(file_name) {

        onmouseover = window.open('uploads/po_form/po_attach/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
    }

    function print_pdf(file_name) {

        onmouseover = window.open('uploads/invoice/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
    }
</script>
