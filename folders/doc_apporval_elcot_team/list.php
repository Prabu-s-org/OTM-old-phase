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

    /* td.po_date {
    white-space: nowrap !important;
} */
    span.po_date {
        white-space: nowrap;
    }

    span.invoice_date {
        white-space: nowrap;
    }

    table.dataTable thead tr th {
        text-align: center;
    }

    /* button:first-child {
    /* margin-left: 0; */
    /* margin-left: 500px; */
    /* } */

    /* .dt-buttons{
   margin-left: 500px;
} */
</style>
<?php
//  $screen_id = isset($_GET['screen_id']) ? htmlspecialchars($_GET['screen_id']) : '';
$screen_id_val = '641ad899dc4e963523';
// echo $screen_id_val; die();
// print_r($screen_id);
session_start();
$user_type_unique_id = $_SESSION['user_type_unique_id'];

//   echo $user_type_unique_id;die();
?>
<script>
    //  <!-- Include Bootstrap 5 CSS -->

</script>

<?php
$staff_ids = $_SESSION['staff_id'];

// echo $_SESSION['user_type_unique_id'];

// if ($_SESSION['user_type_unique_id'] != '5f97fc3257f2525529' && $_SESSION['user_type_unique_id'] != '65deef78ba17d65741' && $_SESSION['user_type_unique_id'] != '65efd97b4df4040205') {
if ($_SESSION['user_type_unique_id'] == '65efd97b4df4040205') {

    $team_members_list = assign_team_member($staff_ids);
     // returns list
    $team_members_options = $team_members_list[0]['staff_name'] ?? '';

    $team_members_options_id = $team_members_list[0]['staff_id'] ?? '';
    // $team_members_options = select_option($team_members_options, "Select Team Member",$staff_ids );


} else {
    // $staff_ids
    $team_members_options = assign_team_member();

    $team_members_options = select_option($team_members_options, "All");
}

$state_name = con_state_name();
$state_name_options = select_option($state_name, "Select State");

$zone_name = zone_name_option();
$zone_name_options = select_option($zone_name, "Select Zone");

?>

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Operation Approval</h4>
            <input type="hidden" id="screen_id_val" name="screen_id_val" class="form-control"
                value="<?php echo $screen_id_val; ?>">
            <input type="hidden" id="user_type_unique_id" name="user_type_unique_id" class="form-control"
                value="<?php echo $user_type_unique_id; ?>">

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Admin</a></li>
                    <li class="breadcrumb-item active">Operation Approval</li>
                </ol>
            </div>
        </div>


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
                    <!-- onclick="complete_list_datatable1()" -->
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#arrow-contact" role="tab">
                            <span class="d-block d-sm-none"><i class="mdi mdi-email"></i></span>
                            <span class="d-none d-sm-block">Completed</span>
                        </a>
                    </li>
                </ul>

                <!-- end -->

                <!-- Tab panes -->
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
                                        <label class="form-label">PO/Invoice Date</label>
                                        <select class="form-select mb-3" id="opt" name="opt">
                                            <option value="4">PO Date</option>
                                            <option value="5">Invoice Date</option>
                                        </select>
                                    </div>
                                </div>
                               
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <?php
                                        if ($_SESSION['user_type_unique_id'] == '65efd97b4df4040205') {
                                            ?>
                                            <label class="form-label">Team Members</label>
                                            <select class="form-select select2 mb-3" name="team_mem" id="team_mem">
                                                <!-- oninput="get_list();"> -->

                                                <option value="<?php echo $team_members_options_id; ?>">
                                                    <?php echo $team_members_options; ?>
                                                </option>
                                            </select>
                                            <?php
                                        } else { ?>
                                            <label class="form-label">Team Members</label>
                                            <select class="form-select select2 mb-3" name="team_mem" id="team_mem">
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

                                        <label class="form-label">State</label>
                                        <select class="form-control" name="state" id="state"
                                            onchange="get_zone();savestate();">
                                            <?php echo $state_name_options; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="mb-3">

                                        <label class="form-label">Zone</label>
                                        <select class="form-control" name="zone" id="zone"
                                            onchange="saveSelectedZone()">
                                            <?php echo $zone_name_options; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <button type="button" class="btn btn-primary btn-lg gos"
                                            onclick="get_data()">Go</button>
                                    </div>
                                </div>
                                <div class="col-md-2 text-end">
                                    <div class="mb-3">
                                     
                                        <?php if ($_SESSION['user_type_unique_id'] == "65deef78ba17d65741" || $_SESSION['user_type_unique_id'] == "68cba503472bd48995") { ?>
                                            <a href="index.php?file=doc_apporval_elcot_team/pending_list"
                                                class="btn btn-primary waves-effect waves-light">OverAll
                                                Approval</a>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>

                            <!-- <div class="row align-items-end">

                            </div> -->
                            <br>

                            <div class="table-responsive">


                                <table id="doc_apporval_elcot_team_list_datatable"
                                    class="table table-bordered table-striped align-middle">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>

                                            <th style="width: 128px;">Po No </th>
                                            <th scope="col">Location</th>
                                            <th scope="col">Branch Name</th>
                                            <!-- $value['dc_date'] -->
                                            <th>Followed By</th>

                                            <th style="width: 95px;">Invoice No </th>
                                            <th style="width: 95px;">Dc No </th>
                                            <th>Dc Value</th>
                                            <th>PO</th>
                                            <th>DC</th>
                                            <th>IR</th>
                                            <th>Inv</th>
                                            <th>Compare</th>
                                            <th>Status</th>
                                            <th>Approved</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- 2nd tab start-->
                    <div class="tab-pane" id="arrow-contact" role="tabpanel">

                        <div class="row align-items-end">
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label class="form-label from-date-label">From Date</label>
                                    <input type="date" class="form-control" id="from_date1" name="from_date1"  value="<?php echo date('Y-m-d')?>">

                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label class="form-label from-date-label">To Date</label>
                                    <input type="date" class="form-control" id="to_date1" name="to_date1" value="<?php echo date('Y-m-d')?>">

                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label class="form-label">PO/Invoice Date</label>
                                    <select class="form-select mb-3" id="opt1" name="opt1">
                                        <option value="4">PO Date</option>
                                        <option value="5">Invoice Date</option>
                                        <!-- <option value="11">Due Date</option> -->
                                    </select>
                                </div>
                            </div>


                            <div class="col-md-2">
                                <div class="mb-3">
                                    <?php
                                    // if ($_SESSION['user_type_unique_id'] != '5f97fc3257f2525529' && $_SESSION['user_type_unique_id'] != '65deef78ba17d65741' && $_SESSION['user_type_unique_id'] != '65efd97b4df4040205') { 
                                    if ($_SESSION['user_type_unique_id'] == '65efd97b4df4040205') {
                                        ?>
                                        <label class="form-label">Team Members</label>
                                        <select class="form-select select2 mb-3" name="team_mem1" id="team_mem1">
                                            <!-- oninput="get_list();"> -->

                                            <option value="<?php echo $team_members_options_id; ?>">
                                                <?php echo $team_members_options; ?>
                                            </option>
                                        </select>
                                        <?php
                                    } else { ?>
                                        <label class="form-label">Team Members</label>
                                        <select class="form-select select2 mb-3" name="team_mem1" id="team_mem1">
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

                                    <label class="form-label">State</label>
                                    <select class="form-control" name="com_state" id="com_state"
                                        onchange="get_com_zone();com_savestate()">
                                        <?php echo $state_name_options; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="mb-3">

                                    <label class="form-label">Zone</label>
                                    <select class="form-control" name="com_zone" id="com_zone"
                                        onchange="com_SelectedZone()">
                                        <?php echo $zone_name_options; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="mb-3">

                                    <button type="button" class="btn btn-primary btn-lg gos"
                                        onclick="get_data_com()">Go</button>
                                </div>
                            </div>

                            <div class="row" id="list_1"></div>
                            <div class="table-responsive mb-4">
                                <table id="complete_stock_position_datatable"
                                    class="table table-bordered table-striped align-middle">


                                    <thead>
                                        <tr>
                                            <th>S.No</th>

                                            <th style="width: 135px;">Po No </th>
                                            <th scope="col">Location</th>
                                            <!-- $value['dc_date'] -->
                                            <th>Branch Name</th>
                                            <th>Followed By</th>

                                            <th style="width: 95px;">Invoice No </th>
                                            <th style="width: 95px;">Dc No </th>
                                            <th>Dc Value</th>
                                            <th>PO</th>
                                            <th>DC</th>
                                            <th>IR</th>
                                            <th>Inv</th>
                                            <th>Compare</th>
                                            <th>Status</th>
                                            <th>Approved</th>
                                            <th>Action</th>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>

                            </div>
                        </div>

                    </div>
                    <!-- 2tab end -->

                </div> <!----tabcontentend end ---->
            </div> <!----cardbody end ---->
            <!----content start---------->



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
                            <button type="button" class="btn btn-primary" id="saveColumnVisibility">Save
                                Changes</button>
                        </div>
                    </div>
                </div>
            </div>
            <script>


                function savestate() {

                    // alert(selectedZone);
                    var selectedState = $('#state').val();

                    // Store the selected zone and state in sessionStorage

                    sessionStorage.setItem('selected_state', selectedState);
                }

                function saveSelectedZone() {
                    var selectedZone = $('#zone').val();

                    sessionStorage.setItem('selected_zone', selectedZone);
                }


                function com_savestate() {
                    var State = $('#com_state').val();
                    sessionStorage.setItem('selected_comstate', State);

                }

                function com_SelectedZone() {

                    var zone = $('#com_zone').val();

                    // alert(zone);
                    sessionStorage.setItem("select_com_zone", zone);
                }


                $("#export").click(function () {
                    // alert("hi");
                    window.location = "folders/doc_apporval_elcot_team/excel.php";
                    // window.location = "folders/doc_approval_ac_team/excel.php";

                });
                $(document).ready(function () {
                    get_user_permission();
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

                    $.ajax({
                        type: "POST",
                        url: ajax_url,
                        data: data,
                        success: function (data) {

                            var obj = JSON.parse(data);

                            var dataString = obj.data;


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


                function get_zone() {

                    var state_name = $('#state').val();
                    var ajax_url = sessionStorage.getItem("folder_crud_link");


                    $.ajax({

                        type: 'POST',
                        url: ajax_url,
                        data: {
                            state_name: state_name,
                            "action": "get_zone"
                        },
                        success: function (data) {

                            $('#zone').html(data);

                            var savedZone = sessionStorage.getItem('selected_zone');

                            if (savedZone) {
                                $('#zone').val(savedZone); // Set the saved zone if available
                            }


                        },
                        error: function (data) {
                            alert("Network Error");
                        }
                    });
                }


                function get_com_zone() {
                    var state_name = $('#com_state').val();
                    var ajax_url = sessionStorage.getItem("folder_crud_link");

                    $.ajax({

                        type: 'POST',
                        url: ajax_url,
                        data: {
                            state_name: state_name,
                            "action": "com_get_zone"
                        },
                        success: function (data) {

                            $('#com_zone').html(data);

                               var savedZone = sessionStorage.getItem('select_com_zone');

                            if (savedZone) {
                                $('#com_zone').val(savedZone); // Set the saved zone if available
                            }

                        },
                        error: function (data) {
                            alert("Network Error");
                        }
                    });
                }
            </script>
