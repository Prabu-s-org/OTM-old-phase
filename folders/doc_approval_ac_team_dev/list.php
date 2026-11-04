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

    span.po_date {
        white-space: nowrap;
    }

    span.invoice_date {
        white-space: nowrap;
    }

  table.dataTable thead tr th {
        text-align: center;
    }
  table.dataTable tbody td:nth-child(6),
table.dataTable thead th:nth-child(6),
 {
    text-align: right;
}

</style>
<?php
//  $screen_id = isset($_GET['screen_id']) ? htmlspecialchars($_GET['screen_id']) : '';
$screen_id_val = '65b73e563f5d820147';
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
            <h4 class="mb-sm-0">Accounts Approval</h4>
            <input type="hidden" id="screen_id_val" name="screen_id_val" class="form-control"
                value="<?php echo $screen_id_val; ?>">
            <input type="hidden" id="user_type_unique_id" name="user_type_unique_id" class="form-control"
                value="<?php echo $user_type_unique_id; ?>">

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Admin</a></li>
                    <li class="breadcrumb-item active">Accounts Approval</li>
                </ol>
            </div>

        </div>
        <!-- <div> -->
            <!-- <button type="button" id="export" name="export"
                class="btn btn-primary  waves-effect waves-light wavw  mb-2 mt-2">
                <i class="ri-file-excel-2-fill"></i>
            </button> -->
            <!-- <?php if ($_SESSION['user_type_unique_id'] == "65deef78ba17d65741") { ?>
                <a href="index.php?file=doc_approval_ac_team/pending" class="btn btn-primary waves-effect waves-light"
                    style="float:right;margin-right: 43px;margin-top: 5px;">OverAll Approval</a>
            <?php } ?> -->
        <!-- </div> -->
    </div>
</div>


<!-- end page title -->
<div class="row">
    <div class="col-7">

    </div>
    <!-- <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-3">
          <?php echo btn_add($btn_add); ?>
      </div> -->
</div>

<!----content start---------->



<div class="row" id="list">
    <div class="col-xl-12">
        <!-- <div class="col-md-3">
                        <div class="mb-3">
                            <label class="form-label">Result Filter</label>
                            <select name="ac_team_verifiy_status" id="ac_team_verifiy_status" class="select2 form-control" onchange="get_data(this.value)" required>
                                <option value="">All</option>
                                <option value="0">Pending</option>
                                <option value="1">Approved</option>
                            </select>
                        </div>
                    </div> -->
        <div class="card">
            <div class="card-body">

                <!-- new changes -->
                <ul class="nav nav-pills arrow-navtabs bg-light mb-3" role="tablist">
                    <li class="nav-item" onclick="stock_position_pending()">
                        <a class="nav-link active" data-bs-toggle="tab" href="#arrow-overview" role="tab">
                            <span class="d-block d-sm-none"><i class="mdi mdi-home-variant"></i></span>
                            <span class="d-none d-sm-block">Pending</span>
                        </a>
                    </li>
                    <li class="nav-item" onclick="complete_list_datatable()">
                        <a class="nav-link" data-bs-toggle="tab" href="#arrow-contact" role="tab">
                            <span class="d-block d-sm-none"><i class="mdi mdi-email"></i></span>
                            <span class="d-none d-sm-block">Completed</span>
                        </a>
                    </li>
                </ul>

                <!-- end -->
                 <div class="tab-content ">
                    <div class="tab-pane active" id="arrow-overview" role="tabpanel">
                        <div class="row">

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
                            <input type="date" class="form-control" id="to_date" name="to_date" >
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="mb-3">
                            <label class="form-label">PO / Invoice Date</label>
                                        <select class="form-select mb-3" id="opt" name="opt">
                                            <option value="4">PO Date</option>
                                            <option value="5">Invoice Date</option>
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
                                <select name="team_mem" id="team_mem" class="form-select select2">
                                    <!-- oninput="get_list();"> -->

                                    <option value="<?php echo $team_members_options_id; ?>">
                                        <?php echo $team_members_options; ?>
                                    </option>
                                </select>
                                <?php

                            } else { ?>
                                <label class="form-label">Team Members</label>
                                <select name="team_mem" id="team_mem" class="form-select select2">
                                    <!-- oninput="get_list();"> -->
                                    <?php echo $team_members_options; ?>
                                </select>
                                <?php
                            }

                            ?>

                        </div>

                    </div>

                    <div class="col-md-2">
                        <div class="mb-3">

                            <button type="button" class="btn btn-primary btn-lg gos" onclick="get_data()">Go</button>
                        </div>
                    </div>

                     <div class="col-md-2 text-end">
                                    <div class="mb-3 ">
                                        <!-- <button type="button" id="export" name="export"
                                            class="btn btn-primary  waves-effect waves-light wavw  mb-2 mt-2">
                                            <i class="ri-file-excel-2-fill"></i>
                                        </button> -->
                                        <?php if (($_SESSION['user_type_unique_id'] == "65deef78ba17d65741") || ($_SESSION['sess_user_id'] == "68a54f3806c3964362")) { ?>

                <a href="index.php?file=doc_approval_ac_team/pending" class="btn btn-primary waves-effect waves-light"
                    >OverAll Approval</a>
            <?php } ?> 
                                    </div>
                                </div>
                </div>

                <!-- <div class="row align-items-end">

                </div> -->
                <br>

                <div class="table-responsive">
                    <table id="doc_approval_ac_team_list_datatable"
                        class="table table-bordered table-striped align-middle">
                        <thead>
                             <tr>
                                <th>S.No</th>
                               
                                <th style="width: 134px;">Po No </th>
                                <th>Location</th>
                                <!-- $value['dc_date'] -->
                                <th>Followed By</th>
                            
                                <th>Invoice No </th>
                                <th>Dc No </th>
                              <th >Dc Value</th>

                                <th>PO</th>
                                <th>DC</th>
                                <th>IR</th>
                                <th>Inv</th>
                                <th>Compare</th>
                                <th>Status</th>
                                <th>Ac Verify </th>
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



         <!-- 2nd tab start-->
                    <div class="tab-pane" id="arrow-contact" role="tabpanel">
                        <table id="complete_stock_position_datatable"
                            class="table table-bordered table-striped align-middle">
                            <div class="row align-items-end">
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label class="form-label from-date-label">From Date</label>
                                        <input type="date" class="form-control" id="comfrom_date" name="comfrom_date" value="<?php echo date('Y-m-d')?>">

                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label class="form-label from-date-label">To Date</label>
                                        <input type="date" class="form-control" id="comto_date" name="comto_date" value="<?php echo date('Y-m-d')?>">

                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label class="form-label">PO / Invoice Date</label>
                                        <select class="form-select mb-3" id="comopt" name="comopt">
                                            <option value="4">PO Date</option>
                                            <option value="5">Invoice Date</option>
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
                                <select name="comteam_mem1" id="comteam_mem1" class="form-select select2">
                                    <!-- oninput="get_list();"> -->

                                    <option value="<?php echo $team_members_options_id; ?>">
                                        <?php echo $team_members_options; ?>
                                    </option>
                                </select>
                                <?php

                            } else { ?>
                                <label class="form-label">Team Members</label>
                                <select name="comteam_mem1" id="comteam_mem1" class="form-select select2">
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

                                        <button type="button" class="btn btn-primary btn-lg gos" onclick="get_data_com()">Go</button>
                                    </div>
                                </div>
                            </div>
                                                         
                            </div>
                            <div class="row" id="list_1"></div>
                            <div class="table-responsive mb-4">

                                <thead>
                                    <tr>
                                <th>S.No</th>
                               
                                <th style="width: 134px;">Po No </th>
                                <th>Location</th>
                                <!-- $value['dc_date'] -->
                                <th>Followed By</th>
                            
                                <th>Invoice No </th>
                                <th>Dc No </th>
                              <th >Dc Value</th>

                                <th>PO</th>
                                <th>DC</th>
                                <th>IR</th>
                                <th>Inv</th>
                                <th>Compare</th>
                                <th>Status</th>
                                <th>Ac Verify </th>
                                <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                        </table>
                    </div>
                    <!-- 2tab end -->

                </div> <!----tabcontentend end ---->
            </div>  <!----cardbody end ---->
<!----content start---------->

<!-- 
    </div>
</div> -->
<!----content start---------->


<div class="modal fade bs-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title w-100 text-center" id="myExtraLargeModalLabel">PO & DC
                    Comparison Attachment </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="row mt-2">
                    <div class="col-md-6">
                        <h4 class="text-center">PO Attachment</h4>
                        <object data='https://pdfjs-express.s3-us-west-2.amazonaws.com/docs/choosing-a-pdf-viewer.pdf'
                            type="application/pdf" width="100%" height="400">

                            <iframe
                                src='https://pdfjs-express.s3-us-west-2.amazonaws.com/docs/choosing-a-pdf-viewer.pdf'
                                width="100%" height="400">

                            </iframe>
                        </object>

                    </div>
                    <div class="col-md-6">
                        <h4 class="text-center">DC Attachment</h4>
                        <object data='https://pdfjs-express.s3-us-west-2.amazonaws.com/docs/choosing-a-pdf-viewer.pdf'
                            type="application/pdf" width="100%" height="400">

                            <iframe
                                src='https://pdfjs-express.s3-us-west-2.amazonaws.com/docs/choosing-a-pdf-viewer.pdf'
                                width="100%" height="400">
                            </iframe>
                        </object>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="javascript:void(0);" class="btn btn-link link-success fw-medium" data-bs-dismiss="modal"><i
                        class="ri-close-line me-1 align-middle"></i> Close</a>
                <button type="button" class="btn btn-primary ">Save changes</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->






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




<script>
    $("#export").click(function () {
        // alert("hi");
        window.location = "folders/doc_approval_ac_team/excel.php";
    });

    $(document).ready(function () {
        // var table_id 	= "user_type_datatable";
        // init_datatable(table_id,form_name,action);
        // get_data();
        get_user_permission();
        // alert();
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

        // console.log(data);
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
                // alert(listpage);
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
