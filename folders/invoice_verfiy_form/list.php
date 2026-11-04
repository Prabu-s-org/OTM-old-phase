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

    table.dataTable thead tr th{
        text-align:center;
    }

    
    table thead th {
    vertical-align: middle; /* centers text vertically */
    text-align: center;     /* centers text horizontally */
    padding: 8px;
    position: relative;
    white-space: nowrap;
}

table thead th .sorting-icon {
    position: absolute;
    right: 6px;
    top: 50%;
    transform: translateY(-50%);
}

</style>

<?php
//  $screen_id = isset($_GET['screen_id']) ? htmlspecialchars($_GET['screen_id']) : '';
$screen_id_val = '683f347db4bdc72408';
session_start();
$user_type_unique_id = $_SESSION['user_type_unique_id'];
?>

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0"> DC Verfiy Form </h4>
            <input type="hidden" id="screen_id_val" name="screen_id_val" class="form-control"
                value="<?php echo $screen_id_val; ?>">
            <input type="hidden" id="user_type_unique_id" name="user_type_unique_id" class="form-control"
                value="<?php echo $user_type_unique_id; ?>">

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Admin</a></li>
                    <li class="breadcrumb-item active">Dc Verfiy Form</li>
                </ol>
            </div>
        </div>
        <!-- <div>
            <?php if ($_SESSION['user_type_unique_id'] == "65deef78ba17d65741") { ?>
                <a href="index.php?file=dc_status_verify/list" class="btn btn-primary waves-effect waves-light"
                    style="float:right;margin-right: 43px;margin-top: 5px;">Dc Verfiy Form</a>
            <?php } ?>
        </div> -->
    </div>
</div>

<!----content start---------->
<div class="row" id="list">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-pills arrow-navtabs bg-light mb-3" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#arrow-overview" role="tab">
                            <span class="d-block d-sm-none"><i class="mdi mdi-home-variant"></i></span>
                            <span class="d-none d-sm-block">Pending</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#arrow-approval" role="tab">
                            <span class="d-block d-sm-none"><i class="mdi mdi-email"></i></span>
                            <span class="d-none d-sm-block">Approval</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#arrow-contact" role="tab">
                            <span class="d-block d-sm-none"><i class="mdi mdi-email"></i></span>
                            <span class="d-none d-sm-block">Completed</span>
                        </a>
                    </li>
                </ul>
                <div class="tab-content ">
                    <div class="tab-pane active" id="arrow-overview" role="tabpanel">
                        <div class="row">
                            <div class="row" id="list">
                                <div class="table-responsive">
                                    <table id="pending_datatable" class="table table-bordered table-striped align-middle">
                                        <thead>
                                            <tr>
                                                <th>S.No</th>
                                                <th>Po No</th>
                                                <th>Po Date</th>
                                                <th>Invoice No</th>
                                                <th>Invoice Date</th>
                                                <th>DC Count</th>
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
                    <div class="tab-pane" id="arrow-approval" role="tabpanel">
                        <div class="row">
                            <div class="row" id="list_1">
                                <div class="table-responsive">
                                    <table id="invoice_approval_datatable" class="table table-bordered table-striped align-middle">
                                        <thead>
                                            <tr>
                                                <th>S.No</th>
                                                <th>PO No</th>
                                                <th>PO Date</th>
                                                <th>Invoice No</th>
                                                <th>Invoice Date</th>
                                                <th>DC Count</th>
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

                    <div class="tab-pane" id="arrow-contact" role="tabpanel">
                        <div class="row">
                            <div class="row" id="list_1">
                                <div class="table-responsive">
                                    <table id="invoice_verfiy_form_datatable" class="table table-bordered table-striped align-middle">
                                        <thead>
                                            <tr>
                                                <th rowspan="2">S.No</th>
                                                <th rowspan="2">Po No</th>
                                                <th rowspan="2">Po Date</th>
                                                <th rowspan="2">Invoice No</th>
                                                <th rowspan="2">Invoice Date</th>
                                                <th rowspan="2">DC Count</th>
                                                <th colspan="3">INV & DC verification</th>
                                                <th rowspan="2">Action</th>
                                            </tr>
                                            <tr>
                                                <th>Status</th>
                                                <th>Date</th>
                                                <th>Approved By</th>
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
        </div>
    </div>
</div>

<script>
    $("#export").click(function () {
        window.location = "folders/doc_approval_ac_team/excel.php";
    });

    $(document).ready(function () {
        get_user_permission();
    });

    function get_user_permission() {
        var screen_id_val = $('#screen_id_val').val();
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
</script>
