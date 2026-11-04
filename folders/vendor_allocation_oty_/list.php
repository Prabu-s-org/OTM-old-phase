<style>
    i.fa.fa-edit {
        font-size: 20px;
        color: green;
    }

    i.fa-sharp.fa-solid.fa-trash {
        font-size: 20px;
        color: green;
    }

table thead tr th{
        text-align :center !important;
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
<?php
//  $screen_id = isset($_GET['screen_id']) ? htmlspecialchars($_GET['screen_id']) : '';
$screen_id_val = '641ad8d856caa93768';
// print_r($screen_id);
session_start();
$user_type_unique_id = $_SESSION['user_type_unique_id'];
?>
<?php
$staff_ids = $_SESSION['staff_id'];

// echo $_SESSION['user_type_unique_id'];

// if ($_SESSION['user_type_unique_id'] != '5f97fc3257f2525529' && $_SESSION['user_type_unique_id'] != '65deef78ba17d65741') {
if ($_SESSION['user_type_unique_id'] == '65efd97b4df4040205') {
    $team_members_list = assign_team_member($staff_ids); // returns list
    $team_members_options = $team_members_list[0]['staff_name'] ?? '';

    $team_members_options_id = $team_members_list[0]['staff_id'] ?? '';
    // $team_members_options = select_option($team_members_options, "Select Team Member",$staff_ids );


} else {
    // $staff_ids
    $team_members_options = assign_team_member();

    $team_members_options = select_option($team_members_options, "All");
}
?>
<!-- start page title -->
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
                    <li class="breadcrumb-item active">Vendor Allocation</li>
                </ol>
            </div>
        </div>

        <!-- <a href="index.php?file=vendor_allocation/team_allocation" class="btn btn-primary waves-effect waves-light" style="float:right;margin-right: 43px;margin-top: 5px;">Team Allocation</a> -->

        <div>

            <!--<a href="index.php?file=vendor_allocation/pending class="btn btn-primary waves-effect waves-light" style="float:right;margin-right: 43px;margin-top: 5px";></a>-->
            <!-- <button type="button" id="export" name="export" class="btn btn-primary  waves-effect waves-light wavw  mb-2 mt-2">-->
            <!-- <i class="ri-file-excel-2-fill"></i>-->
            <!--</button>-->
        </div>
    </div>
</div>
<!----content start---------->
<div class="col-xxl-12">
    <div class="card">
        <div class="card-body">
            <ul class="nav nav-pills arrow-navtabs  bg-light mb-3" role="tablist">
                <li class="nav-item">
                    <!--onclick="dispatch_pending()"-->
                    <a class="nav-link active" data-bs-toggle="tab" href="#arrow-overview" role="tab">
                        <span class="d-block d-sm-none"><i class="mdi mdi-home-variant"></i></span>
                        <span class="d-none d-sm-block">Pending</span>
                    </a>
                </li>


                <li class="nav-item">
                    <!--onclick="dispatch_transist()"-->
                    <a class="nav-link" data-bs-toggle="tab" href="#arrow-contact" role="tab">
                        <span class="d-block d-sm-none"><i class="mdi mdi-account"></i></span>
                        <span class="d-none d-sm-block">Completed</span>
                    </a>
                </li>
                
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane active" id="arrow-overview" role="tabpanel">
                    <div class="row">
                        <div class="col-12">
                            <div class="" id="list">
                                <div class="card-body">
                                
                                    </div>
                                    
                                    <!--                        <button type="button" id="export1" name="export1" class="btn btn-primary  waves-effect waves-light wavw  mb-2 mt-2">-->
                                    <!-- <i class="ri-file-excel-2-fill"></i>-->
                                    <!--</button>-->
                                    <div class="row align-items-end">
                                        <div class="col-md-2">
                                            <div class="mb-3">
                                                <label class="form-label from-date-label">From Date</label>
                                                <input type="date" class="form-control" id="from_date" name="from_date">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="mb-3">
                                                <label class="form-label from-date-label">To Date</label>
                                                <input type="date" class="form-control" id="to_date" name="to_date">
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="mb-3">
                                                <label class="form-label from-date-label">Select Date Type</label>
                                                <select class="form-select mb-3" id="opt1" name="opt1">
                                                    <option value="">Select</option>
                                                    <option value="101">PO Date</option>
                                                    <option value="100">Invoice Date</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="mb-3">
                                                <?php
                                                // if ($_SESSION['user_type_unique_id'] != '5f97fc3257f2525529' && $_SESSION['user_type_unique_id'] != '65deef78ba17d65741') {
                                                if ($_SESSION['user_type_unique_id'] == '65efd97b4df4040205') {
                                                    ?>
                                                    <label class="form-label">Team Members</label>

                                                    <select name="team_mem" id="team_mem" class=" select2 form-select mb-3">
                                                        <!-- oninput="get_list();"> -->

                                                        <option value="<?php echo $team_members_options_id; ?>">
                                                            <?php echo $team_members_options; ?>
                                                        </option>
                                                    </select>
                                                    <?php

                                                } else { ?>
                                                    <label class="form-label">Team Members</label>

                                                    <select name="team_mem" id="team_mem" class="select2  form-select mb-3">
                                                        <!-- oninput="get_list();"> -->
                                                        <?php echo $team_members_options; ?>
                                                    </select>
                                                    <?php
                                                }

                                                ?>

                                            </div>
                                        </div>

                                        <div class="col-md-1">
                                            <div class="mb-3">

                                                <button type="button" class="btn btn-primary btn-lg gos"
                                                    onclick="get_data();">Go</button>
                                            </div>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <div id="bulk_vendorbtn" class="mb-1">
                                                <div id="bulk_vendorbtn">
                                                    <a href="index.php?file=vendor_allocation_oty/pending"
                                                        class="btn btn-primary waves-effect waves-light"
                                                        style="float:right;  ">
                                                     Vendor Allocation
                                            </a>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table id="dispatch_pending_datatable"
                                            class="table table-bordered table-striped align-middle">
                                            <thead>
                                                <tr>
                                                    <th>S.No</th>
                                                    <th>PO No </th>
                                                    <th>Invoice No </th>
                                                    <th>DC No </th>

                                                    <th>Customer Name</th>
                                                    <th>Consignee</th>
                                                    <th>Followed By</th>
                                                    <!-- <th>Consignee Address</th>
                                                    <th>Consignee State</th>
                                                    <th>Consignee District</th> -->
                                                    <!-- <th>Consignee Zone</th> -->
                                                    <!--<th>Qty</th>-->


                                                    <th>Qty</th>

                                                    <!-- <th>Action</th> -->
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!--<tr>-->
                                                <!--    <td>01</td>-->
                                                <!--    <td>001</td>-->
                                                <!--    <td>2023-10-02</td>-->
                                                <!--    <td>Ocean Clothes</td>-->
                                                <!--    <td>Chennai</td>-->
                                                <!--    <td>1000</td>-->
                                                <!--    <td>2023-10-02</td>-->
                                                <!--    <td>-->
                                                <!--        <a data-bs-toggle="modal" data-bs-target=".bs-example-modal-xl">-->
                                                <!--            <i-->
                                                <!--                class="mdi mdi-square-edit-outline mdi-24px waves-effect waves-light mt-n2 mb-n2 text-green"></i>-->
                                                <!--        </a>-->
                                                <!--    </td>-->
                                                <!--</tr>-->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!----content start---------->
                    <!--  Extra Large modal example -->
                    <!-- <div class="col-xl-3">
                                                                    <button type="button"
                                                                        class="btn btn-primary btn-label rounded-pill"><i
                                                                            class="lab la as la-plus-circle label-icon align-middle rounded-pill fs-16 me-2"></i>
                                                                        Add </button>
                                                                </div> -->
                    <!-- <div class="table-responsive mt-4">
                                                                    <table
                                                                        class="table table-hover table-bordered align-middle table-nowrap mb-0">
                                                                        <thead class="table-light">
                                                                            <tr>
                                                                                <th>ID </th>
                                                                                <th scope="col">Dispatch Date</th>
                                                                                <th scope="col">Mode of Delivery</th>
                                                                                <th scope="col">Name of Courier / Person
                                                                                    Name</th>
                                                                                <th scope="col">POD NO.</th>
                                                                                <th scope="col">Action </th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr>
                                                                                <td>1 </td>
                                                                                <td>06-11-2023</td>
                                                                                <td>Hand</td>
                                                                                <td>ABC Parcel / Mr.Santhosh</td>
                                                                                <td> 101</td>
                                                                                <td>
                                                                                    <i
                                                                                        class="mdi mdi-delete  mdi-24px waves-effect waves-light mt-n2 mb-n2 text-danger"></i>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                         
                     
                <!-- fixed-header  -->
                    <!--  Extra Large modal example -->
                    <div class="modal fade bs-example-modal-xl1" tabindex="-1" role="dialog"
                        aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title w-100 text-center" id="myExtraLargeModalLabel">Vendor
                                        Allocation</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <form class="was-validated" autocomplete="off">
                                                <div class="col-12">
                                                    <div class="row">
                                                        <div class="col-5">
                                                            <div class="row">
                                                                <div class="col-xl-4 head_po"> <label
                                                                        class="form-label">PO Number</label></div>
                                                                <div class="col-xl-1">:</div>
                                                                <div class="col-xl-7"><?php echo $po_num ?></div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-xl-4 head_po"> <label
                                                                        class="form-label">PO Date</label></div>
                                                                <div class="col-xl-1">:</div>
                                                                <div class="col-xl-7"><?php echo $po_date ?></div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-xl-4 head_po"> <label
                                                                        class="form-label">Consignee</label></div>
                                                                <div class="col-xl-1">:</div>
                                                                <div class="col-xl-7"><?php echo $consignee ?></div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-xl-4 head_po"> <label
                                                                        class="form-label">Location</label></div>
                                                                <div class="col-xl-1">:</div>
                                                                <div class="col-xl-7"><?php echo $con_address ?></div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-xl-4 head_po"> <label
                                                                        class="form-label">Invoice No</label></div>
                                                                <div class="col-xl-1">:</div>
                                                                <div class="col-xl-7"><?php echo $invoice_no ?></div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-xl-4 head_po"> <label
                                                                        class="form-label">Invoice Date</label></div>
                                                                <div class="col-xl-1">:</div>
                                                                <div class="col-xl-7"><?php echo $invoice_date ?></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-7">
                                                            <div class="row">
                                                                <div class="col-xl-4 head_po"> <label
                                                                        class="form-label">Dispatch Date</label></div>
                                                                <div class="col-xl-1">:</div>
                                                                <div class="col-xl-7"><?php echo $invoice_date ?></div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-xl-4 head_po"> <label
                                                                        class="form-label">Mode of Delivery</label>
                                                                </div>
                                                                <div class="col-xl-1">:</div>
                                                                <div class="col-xl-7"><?php echo $invoice_date ?></div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-xl-4 head_po"> <label
                                                                        class="form-label">Name of Courier / Person
                                                                        Name</label></div>
                                                                <div class="col-xl-1">:</div>
                                                                <div class="col-xl-7"><?php echo $invoice_date ?></div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-xl-4 head_po"> <label
                                                                        class="form-label">POD NO.</label></div>
                                                                <div class="col-xl-1">:</div>
                                                                <div class="col-xl-7"><?php echo $invoice_date ?></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-12 mt-2">
                                                        <div class="row">
                                                            <div class="col-xl-3">
                                                                <label class="form-label">Delivery
                                                                    Status</label>
                                                                <select class="form-select mb-3"
                                                                    aria-label="Default select example">
                                                                    <option selected="">Select Status </option>
                                                                    <option value="1">Yes</option>
                                                                    <option value="2">No</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-xl-3">
                                                                <label class="form-label">Delivery
                                                                    Date</label>
                                                                <input type="date" class="form-control"
                                                                    id="delivery_date">
                                                            </div>
                                                            <!-- <div class="col-xl-3"> -->

                                                            <!-- </div> -->
                                                            <!-- <div class="col-xl-3">
                                                                <label class="form-label">Delivery Proof Attachment</label>
                                                                <input type="text" class="form-control" id="delivery_proff">
                                                            </div> -->
                                                            <!-- <div class="form-group row ">
                                                                    <div class="col-md-12 mt-4" align="">
                                                                        Cancel,save and update Buttons
                                                                        <a href="index.php?file=invoice/list"><button
                                                                                type="button"
                                                                                class="btn btn-danger waves-effect waves-light">Cancel</button></a>
                                                                        <button type="button"
                                                                            class="btn btn-success waves-effect waves-light createupdate_btn  "
                                                                            onclick="invoice_cu('')">Save</button>
                                                                    </div>
                                                                </div> -->
                                                            <!-- </div> -->
                                                        </div> <!-- end card -->
                                                    </div>
                                                </div>
                                            </form>
                                            <!-- end card-body -->
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <a href="javascript:void(0);" class="btn btn-link link-success fw-medium"
                                        data-bs-dismiss="modal()" onclick="modal()"><i
                                            class="ri-close-line me-1 align-middle"></i>
                                        Close</a>
                                    <button type="button" class="btn btn-primary ">Save changes</button>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->
                </div>
                <!----content start---------->
                <div class="tab-pane" id="arrow-contact" role="tabpanel">
                    <div class="row">
                        <div class="col-12">
                            <div class="">
                                <div class="card-body">
                                    <!-- <button type="button" id="export3" name="export3"
                                        class="btn btn-primary  waves-effect waves-light wavw  mb-2 mt-2">
                                        <i class="ri-file-excel-2-fill"></i>
                                    </button> -->
                                    <div class="row align-items-end">
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label from-date-label">From Date</label>
                                                <input type="date" class="form-control" id="from_date_de"
                                                    name="from_date_de">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label from-date-label">To Date</label>
                                                <input type="date" class="form-control" id="to_date_de"
                                                    name="to_date_de">
                                            </div>
                                        </div>
                                       
                                             <div class="col-md-3">
                                            <div class="mb-3">
                                                <?php
                                                // if ($_SESSION['user_type_unique_id'] != '5f97fc3257f2525529' && $_SESSION['user_type_unique_id'] != '65deef78ba17d65741') {
                                                if ($_SESSION['user_type_unique_id'] == '65efd97b4df4040205') {
                                                    ?>
                                                    <label class="form-label">Team Members</label>

                                                    <select name="cm_team_mem" id="cm_team_mem" class=" select2 form-select mb-3">
                                                        <!-- oninput="get_list();"> -->

                                                        <option value="<?php echo $team_members_options_id; ?>">
                                                            <?php echo $team_members_options; ?>
                                                        </option>
                                                    </select>
                                                    <?php

                                                } else { ?>
                                                    <label class="form-label">Team Members</label>

                                                    <select name="cm_team_mem" id="cm_team_mem" class="select2  form-select mb-3">
                                                        <!-- oninput="get_list();"> -->
                                                        <?php echo $team_members_options; ?>
                                                    </select>
                                                    <?php
                                                }

                                                ?>

                                            </div>
                                        
                                        </div>
                                        <div class="col-md-1">
                                            <div class="mb-3">

                                                <button type="button" class="btn btn-primary btn-lg"
                                                    onclick="get_completed_data()">Go</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="list_2">
                                        <div class="table-responsive">
                                            <table id="completed_datatable"
                                                class="table table-bordered table-striped align-middle">
                                                <thead>
                                                    <tr>
                                                        <th>S.No</th>
                                                        <th>PO No </th>
                                                        <th>Invoice No </th>
                                                        <th>DC No </th>
                                                        <th>Customer Name</th>
                                                        <th>Consignee </th>
                                                        <th>Followed By</th>
                                                        <th>Assigned To</th>
                                                        <th>Qty</th>
                                                        <th>Timeline</th>
                                                        <th>Ageing</th>
                                                        <th style="text-align: center !important;">Date</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>

                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
<script> $("#export").click(function () {
        // alert("hi");
        window.location = "folders/dispatch/excel.php";
    });
    $("#export1").click(function () {
        // alert("hi");
        window.location = "folders/dispatch/excel_pending.php";
    });
    $("#export2").click(function () {
        // alert("hi");
        window.location = "folders/dispatch/excel_transit.php";
    });
    $("#export3").click(function () {
        // alert("hi");
        window.location = "folders/dispatch/excel_complete.php";
    });

    $(document).ready(function () {
        //  sub_list_datatable_delivery('deleivery_datatable',form_name,'deleivery_datatable');
        get_data_delivery();
    });


    function get_data_delivery() {
        sub_list_datatable_delivery('deleivery_datatable', form_name, 'deleivery_datatable');
    }
    function sub_list_datatable_delivery(table_id = "", form_name = "", action = "") {
        // alert('hii');
        // var form_main_unique_id = $("#demo").val();
        var table_id = 'deleivery_datatable';
        var screen_id_val = $('#screen_id_val').val();
        // alert(screen_id_val);
        var user_type_unique_id = $('#user_type_unique_id').val();

        var table = $("#" + table_id_2);
        var from_date = $("#from_date_de").val();
        // alert(from_date);
        var to_date = $("#to_date_de").val();
        // alert(to_date);
        var opt3 = $("#opt3").val();
        // alert(opt3);
        var data = {

            "action": 'deleivery_datatable',
            "from_date": from_date,
            "to_date": to_date,
            "opt3": opt3,
            "screen_id_val": screen_id_val,
            "user_type_unique_id": user_type_unique_id,
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
            // dom: 'Bfrtip',
            dom: '<"dt-top-container"<l><"dt-center-in-div"B><f>r>t<ip>',
            buttons: [
                {
                    extend: 'copyHtml5',
                    text: 'Copy',
                    exportOptions: { columns: ':visible' }
                },
                {
                    extend: 'csvHtml5',
                    text: 'CSV',
                    exportOptions: { columns: ':visible' }
                },
                {
                    extend: 'excelHtml5',
                    text: 'Excel',
                    exportOptions: { columns: ':visible' }
                },
                {
                    extend: 'pdfHtml5',
                    text: 'PDF',
                    exportOptions: { columns: ':visible' }
                },
                {
                    extend: 'print',
                    text: 'Print',
                    exportOptions: { columns: ':visible' }
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
            ],
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            pageLength: 10 // Default selected value
        });
        $('#columnVisibilityForm').on('change', 'input[type="checkbox"]', function () {
            var columnIdx = $(this).data('column');
            var isVisible = $(this).is(':checked');
            datatable.column(columnIdx).visible(isVisible); // Use datatable instead of table
        });
    }
    $(document).ready(function () {
        // var table_id 	= "user_type_datatable";

        get_user_permission();
        get_user_permission_1();
        get_user_permission_2();
        // dispatch_pending();
        // dispatch_transist();
        // dispatch_delivery();
    });

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



                // var listpage = document.getElementById('list_1');
                // if (dataString.includes('5f88083fd50a344823')) {
                //     listpage.style.visibility = 'visible';  // Show the button
                // } else {
                //     listpage.style.visibility = 'hidden';   // Hide the button but keep its space
                // }


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


</script>
