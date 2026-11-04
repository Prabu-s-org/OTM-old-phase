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

    span.po_date {
        white-space: nowrap;
    }

    span.invoice_date {
        white-space: nowrap;
    }
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
    integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<!-- Add Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>


<?php
$screen_id_val = '641ad5b47d02a30030';


session_start();
$user_type_unique_id = $_SESSION['user_type_unique_id'];

$batch_id = $_GET['batch_id'];

$form_main_unique_id = $_GET['form_main_unique_id'];

?>
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0"> Consignee List</h4>

            <button type="button" class="btn btn-primary" id="backBtn">Back</button>

            <input type="hidden" id="screen_id_val" name="screen_id_val" class="form-control"
                value="<?php echo $screen_id_val; ?>">

            <input type="hidden" id="batch_id" name="batch_id" class="form-control" value="<?php echo $batch_id; ?>">

            <input type="hidden" id="user_type_unique_id" name="user_type_unique_id" class="form-control"
                value="<?php echo $user_type_unique_id; ?>">

            <input type="hidden" class="form-control" id="form_main_unique_id" name="form_main_unique_id"
                value="<?php echo $form_main_unique_id; ?>">

            <input type="hidden" id="batch_id_holder" name="batch_id_holder" value="<?php echo $batch_id; ?>" />

        </div>
    </div>
</div>


<!----content start---------->
<div class="col-xxl-12">
    <div class="card">
        <div class="card-body">
            <div class="text-end">
                <span style="color:red">If Change Consignee Received Date</span>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#poModal">
                    Click Here
                </button>
            </div>

            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane active" id="arrow-overview" role="tabpanel">
                    <div class="row" id="list">
                        <div class="col-12">
                            <div class="">
                                <div class="card-body">
                                    <div class="row align-items-end">
                                        <!-- <div class="col-md-3">
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

                                        <div class="col-md-1">
                                            <div class="mb-3">

                                                <button type="button" class="btn btn-primary btn-lg" onclick="get_data()">Go</button>
                                            </div>
                                            <button type="button" id="export1" name="export1" class="btn btn-primary  waves-effect waves-light wavw  mb-1">
                                                <i class="ri-file-excel-2-fill"></i>
                                            </button>
                                        </div>
                                    </div> -->

                                        <div class="table-responsive">
                                            <table id="consigneeeDetails"
                                                class="table table-bordered table-striped align-middle">
                                                <thead>
                                                    <tr>
                                                         <th>ID </th>
                                                        <th>Con. Name/Branch</th>
                                                        <th>Con Branch Code</th>
                                                        <th>Con. Address </th>
                                                        <th>Con. Email Id</th>
                                                        <th>Billing Address </th>
                                                        <th>Billing Gst No</th>
                                                        <th>Region</th>
                                                        <th>State</th>
                                                        <th>District</th>
                                                        <th>Zone</th>
                                                        <th>Zone Code</th>
                                                        <th>Pincode</th>
                                                        <th>Contact Name </th>
                                                        <th>Contact Number</th>
                                                        <th>Alternate Name</th>
                                                        <th>Alternate Number</th>
                                                        <th>Landline </th>
                                                        <th>GST</th>
                                                    
                                                        <th>Assigned Team Member</th>
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
                        <!----content start---------->
                        <!--  Extra Large modal example -->
                    </div>
                    <!-- fixed-header  -->

                </div><!-- end card-body -->
            </div><!-- end card -->
        </div>
        <!--end col-->
    </div>
    <!--end row-->
    <!-- Page content Ends Here -->
</div>
</div>
</div>






<div class="modal fade" id="editConsigneeModal" tabindex="-1" aria-labelledby="editConsigneeLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="editConsigneeLabel">Edit Consignee</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="editConsigneeForm">
                    <input type="hidden" class="form-control" id="up_stored_consignee" name="up_stored_consignee">


                    <div class="mb-2">
                        <label>Consignee Name/Branch</label>
                        <input type="text" class="form-control" id="up_con_branch" name="up_con_branch">
                    </div>

                     <div class="mb-2">
                        <label>Consignee Branch Code</label>
                        <input type="text" class="form-control" id="up_branch_code" name="up_branch_code">
                    </div>
                    <div class="mb-2">
                        <label>Address</label>
                        <input type="text" class="form-control" id="up_con_address" name="up_con_address">
                    </div>

                     <div class="mb-2">
                        <label>Email Id</label>
                        <input type="text" class="form-control" id="up_con_email" name="up_con_email">
                    </div>
                    <div class="mb-2">
                        <label>Billing Address</label>
                        <textarea name="billing_address" id="billing_address" oninput="valid_address(this)"
                            class="form-control" required></textarea>
                    </div>

                    <div class="mb-2">
                        <label>Billing GST NO</label>
                        <input type="text" name="billing_gst" id="billing_gst" oninput="validateGST(this)"
                            class="form-control"  maxlength="15" >
                             <small id="gst_error" style="color:red; display:none;">Invalid GST Number</small>
                    </div>

                     <div class="mb-2">
                        <label>Region</label>
                        <input type="text" name="region" id="region"  oninput="this.value = this.value.replace(/[^a-zA-Z0-9]/g, '')" class="form-control"  maxlength="15" >
                             <small id="gst_error" style="color:red; display:none;">Invalid GST Number</small>
                    </div>
                    

                    <div class="mb-2">
                        <label>State</label>
                        <select name="up_con_state_name" id="up_con_state_name" class="form-select"
                            onchange="up_con_get_district(this.value);" required>
                        </select>
                        <input type="hidden" class="form-control" id="up_con_state_id" name="up_con_state_id"
                            oninput="handleInput(event)">
                    </div>
                    <div class="mb-2">
                        <label>District</label>
                        <select name="up_con_district" id="up_con_district" class="form-select" required>
                        </select>
                        <input type="hidden" class="form-control" id="up_con_district_id" name="up_con_district_id">
                        <!--<input type="text" class="form-control" id="up_con_district" name="up_con_district" >-->
                    </div>
                    <div class="mb-2">
                        <label>Zone</label>
                        <input type="text" class="form-control" id="up_zone" name="up_zone">
                    </div>
                     <div class="mb-2">
                        <label>Zone Code</label>
                        <input type="text" class="form-control" id="up_zone_code" name="up_zone_code">
                    </div>

                    <div class="mb-2">
                        <label>Pincode</label>
                        <input type="text" class="form-control" id="up_con_pincode" name="up_con_pincode">
                    </div>

                    <div class="mb-2">
                        <label>Contact Name</label>
                        <input type="text" class="form-control" id="up_con_contact_name" name="up_con_contact_name"
                            oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')">
                    </div>

                    <div class="mb-2">
                        <label>Contact Number</label>
                        <input type="text" class="form-control" id="up_con_contact_number" name="up_con_contact_number"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                    </div>

                    <div class="mb-2">
                        <label>Alternate Contact Name</label>
                        <input type="text" class="form-control" id="up_alter_contact_name" name="up_alter_contact_name"
                            oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')">
                    </div>

                     <div class="mb-2">
                        <label>Alternate Contact Number</label>
                        <input type="text" class="form-control" id="up_alter_contact_num" name="up_alter_contact_num"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                    </div>



                    <div class="mb-2">
                        <label>Landline</label>
                        <input type="text" class="form-control" id="up_con_lan_num" name="up_con_lan_num"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                    </div>

                    <div class="mb-2">

                        <label>Assign Team Members</label>
                        <select name="up_assign_team_member" id="up_assign_team_member" class="form-control"
                            required>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label>GST</label>
                        <input type="text" class="form-control" id="up_consignee_gst" name="up_consignee_gst"
                            oninput="this.value = this.value.replace(/[^a-zA-Z0-9]/g, '')">
                    </div>

                    <div class="mb-2">
                        <label>Status</label>
                        <select class="form-select" id="up_verify_sts" name="up_verify_sts">
                            <!--<option value=""></option>-->

                            <option value="1">Verified</option>
                    <option value="2">Not Verified</option>
                        </select>
                    </div>

                </form>
</div>


            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" onclick="change_verify_address()" class="btn btn-primary">Update</button>
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
            </div>
        </div>
    </div>
</div>



<!-- Modal -->
<div class="modal fade" id="poModal" tabindex="-1" aria-labelledby="poModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header" style="background-color: #eeece0;">
                <h5 class="modal-title mb-3" id="poModalLabel" style="color: #506018;">Update Consignee Received Date
                </h5>
                <button type="button" class="btn-close  mb-3" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">


                <div class="mb-2">
                    <label class="form-label d-block">
                        <strong style="color: #506018;">PO No:</strong>
                        <span id="po_no" class="ms-2"></span>
                    </label>
                </div>
                <br>

                <div class="mb-2">
                    <label class="form-label d-block">
                        <strong style="color: #506018;">Batch ID:</strong>
                        <span id="batch_id" class="ms-2"><?php echo $_GET['batch_id']; ?></span>
                    </label>
                </div><br>


                <div class="mb-3">
                    <label class="form-label" style="color: #506018;"><strong>Consignee Received Date:</strong></label>
                    <input type="date" class="form-control" id="consignee_date">
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" onclick="submitPO()">Submit</button>
            </div>

        </div>
    </div>
</div>

<script>

</script>
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
<!-- <script src="/otm_beta/assets/js/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script> -->
<!-- <script src="assets/bundles/jquery-validation/jquery.validate.min.js"></script> -->

<!-- <script src="po_form/script.js"></script> -->







<script>

    function submitPO() {
        const po_unique_id = document.getElementById('form_main_unique_id').value;
        const batch_id = document.getElementById('batch_id').value;
        const consignee_date = document.getElementById('consignee_date').value;

        var data = {
            "po_unique_id": po_unique_id,
            "batch_id": batch_id,
            "consignee_date": consignee_date,
            "action": "update_con_rec_date"
        }

        $.ajax({
            url: 'folders/po_form/crud.php',
            type: 'POST',
            data: data,
            dataType: 'json',
            success: function (res) {

                if (res.msg == 'success_update') {
                    sweetalert('update');
                    // Close modal after submit
                    const modal = bootstrap.Modal.getInstance(document.getElementById('poModal'));
                    modal.hide();
                }

            }

        });


    }



    $("#export").click(function () {
        // alert("hi");
        window.location = "folders/po_form/excel.php";
    });
    $("#export1").click(function () {

        var from_date = $('#from_date').val();
        // alert(from_date);
        var to_date = $('#to_date').val();
        // alert(to_date);
        // var month_fill = $('#month_fill').val();
        window.location = "folders/po_form/excel1.php?from_date=" + from_date + "&to_date=" + to_date;
    });

    function print_pdf_1(file_name) {

        onmouseover = window.open('uploads/po_form/po_attach/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
    }



    $(document).ready(function () {

        // new DataTable('#po_form_datatable', {
        //     layout: {
        //         topStart: {
        //             buttons: ['copy', 'excel', 'pdf', 'colvis']
        //         }
        //     }
        // });

        // alert('tets');
        init_datatable("consigneeeDetails");


    });

    // function get_data() {
    //     document.getElementById('month_fill').value = '';

    //     init_datatable(table_id, form_name, action);
    // // }

    // function get_data_month() {

    //     document.getElementById('from_date').value = '';
    //     document.getElementById('to_date').value = '';

    //     init_datatable(table_id, form_name, action);
    // }


    function init_datatable(table_id) {
        var table = $('#' + table_id);

        var action = 'consignee_details_by_batchId';

        var batch_id = $('#batch_id').val();

        var data = {
            "action": action,
            "batch_id": batch_id
        }

        var ajax_url = sessionStorage.getItem("folder_crud_link");

        var datatable = table.DataTable({

            destroy: true,
            searching: true,
            ordering: true,

            "ajax": {
                url: 'folders/po_form/pavicrud.php',
                type: "POST",
                data: data,

                dataSrc: function (json) {
                    if (json.po_number) {
                        $('#po_no').text(json.po_number);  // Ensure this element exists in your HTML
                        $('#consignee_date').val(json.consignee_received_date);  // Ensure this element exists in your HTML
                    }
                    return json.data; // Return data array to DataTable
                }
            },
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'copy',
                    exportOptions: {
                        columns: ':not(.noExport)'
                    }
                },
                {
                    extend: 'csv',
                    exportOptions: {
                        columns: ':not(.noExport)'
                    }
                },
                {
                    extend: 'excel',
                    exportOptions: {
                        columns: ':not(.noExport)'
                    }
                },
                {
                    extend: 'pdf',
                    exportOptions: {
                        columns: ':not(.noExport)'
                    }
                },
                {
                    extend: 'print',
                    exportOptions: {
                        columns: ':not(.noExport)'
                    }
                }
            ],

           columns: [
                { "data": "s_no" },
                { "data": "con_branch" },
                { "data" : "con_branch_code"},
                { "data": "con_address" },
                { "data" : "cons_email_id"},
                { "data": "billing_address" },
                {"data" : "billing_gst_no"},
                {"data" : "region"},
                { "data": "state" },
                { "data": "district" },
                { "data": "zone" },
                { "data" : "zone_code"},
                { "data": "con_pincode" },
                { "data": "con_contact_name" },
                { "data": "con_contact_number" },
                { "data" : "alter_contact_name"},
                { "data" : "alter_number"},
  
                { "data": "con_lan_num" },

                { "data": "consignee_gst" },
                { "data": "assigned_team_member" },
                { "data": "cons_verify_sts" },
                { "data": "form_main_unique_id", className: "noExport" }
            ]

        });


    }


    function get_user_permission() {
        var screen_id_val = $('#screen_id_val').val();
        // alert(screen_id_val);
        var user_type_unique_id = $('#user_type_unique_id').val();
        // alert(user_type_unique_id);
        var data = {
            "screen_id_val": screen_id_val,
            "user_type_unique_id": user_type_unique_id,
            "action": 'user_permission',
        };

        var ajax_url = sessionStorage.getItem("folder_crud_link");
        var url = sessionStorage.getItem("list_link");

        // console.log(data);
        $.ajax({
            type: "POST",
            url: ajax_url,
            data: data,
            success: function (data) {

                var obj = JSON.parse(data);

                var dataString = obj.data;

                // console.log(dataString);

                var addButton = document.getElementById('add_btn');
                if (dataString.includes('5f8807ff00bf726601')) {
                    addButton.style.visibility = 'visible'; // Show the button
                } else {
                    addButton.style.visibility = 'hidden'; // Hide the button but keep its space
                }
                var listpage = document.getElementById('list');
                if (dataString.includes('5f88083fd50a344823')) {
                    listpage.style.visibility = 'visible'; // Show the button
                } else {
                    listpage.style.visibility = 'hidden'; // Hide the button but keep its space
                }


            },
            error: function (data) {
                alert("Network Error");
            }
        });
    }

    function get_user_permission_1() {
        var screen_id_val = $('#screen_id_val').val();

        var user_type_unique_id = $('#user_type_unique_id').val();

        var data = {
            "screen_id_val": screen_id_val,
            "user_type_unique_id": user_type_unique_id,
            "action": 'user_permission_1',
        };

        var ajax_url = sessionStorage.getItem("folder_crud_link");
        var url = sessionStorage.getItem("list_link");

        // console.log(data);
        $.ajax({
            type: "POST",
            url: ajax_url,
            data: data,
            success: function (data) {
                alert(data);
                var obj = JSON.parse(data);

                var dataString = obj.data;


                var listpage = document.getElementById('list_1');
                if (dataString.includes('5f88083fd50a344823')) {
                    listpage.style.visibility = 'visible'; // Show the button
                } else {
                    listpage.style.visibility = 'hidden'; // Hide the button but keep its space
                }


            },
            error: function (data) {
                alert("Network Error");
            }
        });
    }



    function editConsignee_over(button) {

        //  alert('r');
        // Retrieve data attributes using button.dataset
        const data = button.dataset;

        // alert(data);

        // Log the data to verify it's correctly populated
        // console.log(data);  // This should show the dataset (e.g., uniqueid, address, etc.)

        // Pass the unique ID and other data to form fields or use as needed
        document.getElementById('up_stored_consignee').value = data.uniqueid;

        // document.getElementById('form_main_unique_id').value = data.form-uniqueid;
        document.getElementById('up_con_branch').value = data.con_branch;

        document.getElementById('up_con_address').value = data.address;
        document.getElementById('billing_address').value = data.billing_address;
        document.getElementById('up_con_district').value = data.district;
        var district_id = data.district_id;
        document.getElementById('up_zone').value = data.zone;

        // var assign_team_member_id = document.getElementById('assign_team_member_id').value = data.assign_team_member_id;
        document.getElementById('up_con_state_name').value = data.con_state_name;
        var con_state_id = data.con_state_id;
        document.getElementById('up_con_state_id').value = data.con_state_id;
        document.getElementById('up_con_district_id').value = data.district_id;
        // alert(data.district_id);
        var assign_team_member_id = data.team_member_id;

        document.getElementById('billing_gst').value = data.billing_gstno;

                 document.getElementById('region').value = data.con_region;



        document.getElementById('up_assign_team_member').value = data.team_member;


        document.getElementById('up_con_pincode').value = data.pincode;
        document.getElementById('up_con_contact_name').value = data.contactname;
        document.getElementById('up_con_contact_number').value = data.contactnumber;
        document.getElementById('up_con_lan_num').value = data.landline;
        document.getElementById('up_consignee_gst').value = data.gst;

        document.getElementById('up_verify_sts').value = data.status;

          document.getElementById('up_branch_code').value = data.con_branch_code;
        document.getElementById('up_con_email').value = data.cons_email_id;
        document.getElementById('up_alter_contact_name').value = data.alter_contact_name;
        document.getElementById('up_alter_contact_num').value = data.alter_number;
        document.getElementById('up_zone_code').value = data.zone_code;


        get_state_options(con_state_id);
        get_district_options(district_id);
        get_assign_team_member(assign_team_member_id);

        // Compare correctly using ===
        let status1 = '';
        const selectBox = document.getElementById("up_verify_sts");
selectBox.innerHTML = ""; // Clear existing options

const option1 = document.createElement("option");
option1.value = "1";
option1.text = "Verified";

const option2 = document.createElement("option");
option2.value = "2";
option2.text = "Not Verified";

// Append both options
selectBox.appendChild(option1);
selectBox.appendChild(option2);

// Set the selected value based on the data from backend
if (data.status === "Verified") {
    selectBox.value = "1"; // Select the "Verified" option
} else if (data.status === "Not Verified") {
    selectBox.value = "2"; // Select the "Not Verified" option
}
        // document.getElementById('up_verify_sts').value = data.status1;

        // Optionally, you can log the unique ID specifically
        // console.log("Unique ID: " + data.uniqueid);

        // Show Bootstrap 5 modal
        const modal = new bootstrap.Modal(document.getElementById('editConsigneeModal'));
        modal.show();
        update_val();
    }


    function update_val() {
        var up_con_state_id = document.getElementById('up_con_state_id').value;
        var up_con_district_id = document.getElementById('up_con_district_id').value;
        if (up_con_state_id != '') {
            up_con_get_district(up_con_state_id, up_con_district_id);
        }
    }


    function change_verify_address() {
        // alert("hii");

        const formData = {
            action: 'update_consignee',
            unique_id: $('#up_stored_consignee').val(),
            con_branch: $('#up_con_branch').val(),
            con_branch_code: $('#up_branch_code').val(),
            con_email_id: $('#up_con_email').val(),
            con_alter_name: $('#up_alter_contact_name').val(),
            con_alter_num: $('#up_alter_contact_num').val(),
            con_zone_code: $('#up_zone_code').val(),


            con_address: $('#up_con_address').val(),
            con_district: $('#up_con_district').val(),
            con_state_name: $('#up_con_state_name').val(),
            zone: $('#up_zone').val(),
            con_pincode: $('#up_con_pincode').val(),
            con_contact_name: $('#up_con_contact_name').val(),
            con_contact_number: $('#up_con_contact_number').val(),
            con_lan_num: $('#up_con_lan_num').val(),
            consignee_gst: $('#up_consignee_gst').val(),
            up_assign_team_member: $('#up_assign_team_member').val(),
            verify_sts: $('#up_verify_sts').val(),
            billing_address: $('#billing_address').val(),
            billing_gst     : $('#billing_gst').val(),
             region     : $('#region').val(),
            form_main_unique_id: $('#form_main_unique_id').val()
        };
        $.ajax({
            url: 'folders/po_form/crud.php',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function (res) {
                if (res.msg === 'already') {
                    sweetalert(res.msg);
                    return;
                }

                if (res.status && res.msg === 'success_update') {
                    alert('Updated Successfully');

                    // Hide the edit modal
                    $('#editConsigneeModal').modal('hide');
                    var batchId = document.getElementById('batch_id_holder').value;
                    $.ajax({
                        url: 'folders/po_form/crud.php',
                        type: 'POST',
                        data: {
                            action: 'get_consignee_by_batch',
                            batch_id: batchId
                        },
                        success: function (response) {
                            $('#consigneeModalBody').html(response);
                            $('#consigneeModal').modal('show');

                            // Reinitialize DataTable if needed
                            // sub_list_datatable_consignee("consignee_details_datatable");
                           // init_datatable("consigneeeDetails");
                           $('#consigneeeDetails').DataTable().ajax.reload(null, false);

                        },
                        error: function () {
                            $('#consigneeModalBody').html('<div class="text-danger">Failed to fetch consignee details.</div>');
                            $('#consigneeModal').modal('show');
                        }
                    });

                } else if (res.msg === 'error') {
                    alert('Update failed: ' + res.error);
                } else {
                    alert('Unexpected response: ' + JSON.stringify(res));
                }
            },
            error: function (xhr, status, error) {
                alert('AJAX request failed: ' + error);
            }
        });
    }



    function delete_consignee(btn) {
        const $btn = $(btn);


        const uniqueId = $btn.data('uni-id');

        var table = $('#' + 'consigneeeDetails');
        // your attribute is data-uni-id

        Swal.fire({
            title: 'Are you sure?',
            text: 'Do you want to delete this record?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    url: 'folders/po_form/pavicrud.php',
                    data: {
                        action: 'delete_consignee',
                        unique_id: uniqueId
                    },
                    dataType: 'json',
                    success: function (response) {
                        // alert(response);
                        console.log(response);
                        if (response.msg === 'success_delete') {
                            $btn.closest('tr').remove();
                            //  table.row($btn.closest('tr')).remove().draw();
                            Swal.fire('Deleted!', 'Record has been deleted.', 'success');

                            $('#consigneeeDetails tbody tr').each(function (index) {
                                $(this).find('td:eq(0)').text(index + 1); // 0 = s_no column
                            });
                        } else {
                            Swal.fire('Failed', 'Delete failed. Please try again.', 'error');
                        }
                    },
                    error: function () {
                        Swal.fire('Error', 'Something went wrong with the request.', 'error');
                    }
                });
            }
        });
    }
    function up_con_get_district(state_id = "", district = "") {

        var ajax_url = sessionStorage.getItem("folder_crud_link");

        if (state_id == '' || state_id) {

            var data = {
                state_id: state_id,
                district: district,
                "action": 'up_con_get_state_name'
            }

            $.ajax({
                url: ajax_url,
                type: "GET",
                data: data,

                success: function (data) {

                    if (data) {

                        $("#up_con_district").html(data);


                    }
                }
            })
        }
    }


    function get_state_options(con_state_id) {




        var data = "state_name=" + con_state_id + "&action=con_state_name_option";

        var ajax_url = sessionStorage.getItem("folder_crud_link");

        $.ajax({
            type: "POST",
            url: ajax_url,
            data: data,
            success: function (data) {
                if (data) {
                    $("#up_con_state_name").html(data);
                }
            }
        });

    }

    function get_district_options(district_id) {




        var data = "district_name=" + district_id + "&action=district_name_option";

        var ajax_url = sessionStorage.getItem("folder_crud_link");

        $.ajax({
            type: "POST",
            url: ajax_url,
            data: data,
            success: function (data) {
                if (data) {
                    $("#up_con_district").html(data);
                }
            }
        });

    }

    function get_assign_team_member(assign_team_member_id) {




        var data = "assign_team_member_id=" + assign_team_member_id + "&action=assign_team_member_id_option";

        var ajax_url = sessionStorage.getItem("folder_crud_link");

        $.ajax({
            type: "POST",
            url: ajax_url,
            data: data,
            success: function (data) {
                if (data) {
                    $("#up_assign_team_member").html(data);
                }
            }
        });

    }



    function sub_list_datatable(table_id = "", form_name = "", action = "") {


        var table_id = 'po_cancel_datatable';
        // alert(table_id);
        var table = $("#" + table_id);
        var data = {

            "action": 'po_cancel_datatable',
        };
        var ajax_url = sessionStorage.getItem("folder_crud_link");
        var datatable = table.DataTable({
            destroy: true,
            ordering: true,
            searching: true,
            "ajax": {
                url: ajax_url,
                type: "POST",
                data: data
            },
            dom: 'Bfrtip',
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
            {
                extend: 'colvis', // Column visibility button
                text: 'Column Visibility',
                action: function (e, dt, node, config) {
                    // Open the column visibility modal when the button is clicked
                    $('#columnVisibilityModal').modal('show');

                    // Populate the modal with checkboxes for each column
                    var columns = dt.columns().header();
                    var form = $('#columnVisibilityForm');
                    form.empty(); // Clear any existing checkboxes

                    // Append checkboxes one by one for each column
                    columns.each(function (header, index) {
                        var isChecked = dt.column(index).visible();
                        var colMarkup = `
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" data-column="${index}" ${isChecked ? 'checked' : ''}>
                                <label class="form-check-label">${$(header).text()}</label>
                            </div>
                        `;
                        form.append(colMarkup); // Append each checkbox in a vertical list
                    });
                }

            }
            ]
        });
        $('#columnVisibilityForm').on('change', 'input[type="checkbox"]', function () {
            var columnIdx = $(this).data('column');
            var isVisible = $(this).is(':checked');
            datatable.column(columnIdx).visible(isVisible); // Use datatable instead of table
        });
    }

    // document.getElementById("backBtn").addEventListener("click", function () {
    //     // Get current URL parameters
    //     const params = new URLSearchParams(window.location.search);
    //     const formMainUniqueId = params.get("form_main_unique_id");

    //     if (formMainUniqueId) {
    //         const redirectUrl = `http://122.165.127.123:35267/otm_beta/index.php?file=po_form/update&unique_id=${formMainUniqueId}`;
    //         window.location.href = redirectUrl;
    //     } else {
    //         alert("form_main_unique_id not found in the URL.");
    //     }
    // });
    //     document.getElementById("backBtn").addEventListener("click", function () {
    //   const params = new URLSearchParams(window.location.search);
    //   const formMainUniqueId = params.get("form_main_unique_id");

    //   if (formMainUniqueId) {
    //     // 1. Switch tab active classes
    //     // const currentActive = document.querySelector(".multisteps-form__progress-btn.js-active");


    //     // 2. Redirect
    //     const redirectUrl = `http://122.165.127.123:35267/otm_beta/index.php?file=po_form/update&unique_id=${formMainUniqueId}`;
    //     window.location.href = redirectUrl;
    //     const currentActive = document.getElementById("poDetailsBtn");


    //     if (currentActive) currentActive.classList.remove("js-active");

    //     const consigneeBtn = document.getElementById("consigneeDetailsBtn");
    //     if (consigneeBtn) consigneeBtn.classList.add("js-active");
    //   } else {
    //     alert("form_main_unique_id not found in the URL.");
    //   }
    // });
    document.getElementById("backBtn").addEventListener("click", function () {
        const params = new URLSearchParams(window.location.search);
        const formMainUniqueId = params.get("form_main_unique_id");

        if (!formMainUniqueId) {
            alert("form_main_unique_id not found in the URL.");
            return;
        }

        // Redirect with "tab=consignee" query
        const redirectUrl = `http://122.165.127.123:35267/otm_beta/index.php?file=po_form/update&unique_id=${formMainUniqueId}&tab=consignee`;
        window.location.href = redirectUrl;
    });

</script>
