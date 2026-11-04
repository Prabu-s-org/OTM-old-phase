<!-- This file Only PHP Functions -->
<style>
    button#export {
        float: right;
        padding: 5px 10px;
    }

    #icon {
        font-size: x-large;
    }
</style>
<?php include 'simplexlsx.php'; ?>
<?php
require_once("assets/PHPExcel-1.8/Classes/PHPExcel.php");
?>
<?php include 'function.php'; ?>
<?php
// Form variables
$btn_text = "Save";
$btn_action = "create";
$is_btn_disable = "";
$unique_id = "";
$user_type = "";
$under_user_type = "";
$exp_under_user_type = "";
$is_active = 1;
$encoded = $_GET['id'];
$ids = base64_decode($encoded);
echo $tabs_vals = $_GET['tab'];
if (isset($_GET["unique_id"])) {
    if (!empty($_GET["unique_id"])) {
        // $uni_dec = str_replace(" ", "+", $_GET['unique_id']);
        // $get_uni_id           = openssl_decrypt(base64_decode($uni_dec), $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv);
        $unique_id = $_GET["unique_id"];
        $where = [
            "unique_id" => $unique_id
        ];
        $table = "item_creation";
        $columns = [
            // "rate_contract",
            "tender_name",
            "tender_code",
            "tender_no",
            "tender_type",

            "validity_from",
            "validity_to",
            "validity_date_extension",
            //"under_user_type",
            "is_active"
        ];
        $table_details = [
            $table,
            $columns
        ];
        $result_values = $pdo->select($table_details, $where);
        if ($result_values->status) {
            $result_values = $result_values->data;
            // $rate_contract          = $result_values[0]["rate_contract"];
            $tender_name = $result_values[0]["tender_name"];
            $tender_code = $result_values[0]["tender_code"];
            $tender_no = $result_values[0]["tender_no"];
            $tender_type = $result_values[0]["tender_type"];

            $validity_from = $result_values[0]["validity_from"];
            $validity_to = $result_values[0]["validity_to"];
            $validity_date_extension = $result_values[0]["validity_date_extension"];
            // $tender_type          = $result_values[0]["tender_type"];
            //$under_user_type    = $result_values[0]["under_user_type"];
            $is_active = $result_values[0]["is_active"];
            // $exp_under_user_type  = explode(",", $under_user_type);
            $btn_text = "Update";
            $btn_action = "update";
        } else {
            $btn_text = "Error";
            $btn_action = "error";
            $is_btn_disable = "disabled='disabled'";
        }
    }
}

$tender_option = [
    // "0" => [
    //     "unique_id" => "0",
    //     "value"     => "Pending",
    // ],
    "Open Tender" => [
        "unique_id" => "1",
        "value" => "Open Tender",
    ],
    "Limited Tender" => [
        "unique_id" => "2",
        "value" => "Limited Tender",
    ],
];
$tender_options = select_option($tender_option, "Select", $tender_type);


// $under_user_type_options = under_user_type($user_type);
// $under_user_type_options = select_option($under_user_type_options, "Select Staff", $exp_under_user_type);
$active_status_options = active_status($is_active);
?>
<div class="row">
    <input type="hidden" name="sec_tab_values" id="sec_tab_values" value="<?php echo $_GET['tab']; ?>">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0"> Item Creation</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Settings</a></li>
                    <li class="breadcrumb-item active"> Item Creation </li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="col-xxl-12 cf">
    <div class="card">
        <div class="card-body">
            <ul class="nav nav-pills arrow-navtabs bg-light mb-3" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" id="frst_tabs" href="#frst_sub_tabs" role="tab">
                        <span class="d-block d-sm-none"><i class="mdi mdi-home-variant"></i></span>
                        <span class="d-none d-sm-block">PO Details</span>
                    </a>
                </li>
                <!-- sec_sub_tabs -->
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#sec_sub_tabs" id="sec_tabs" role="tab">
                        <span class="d-block d-sm-none"><i class="mdi mdi-account"></i></span>
                        <span class="d-none d-sm-block">Item details upload</span>
                    </a>
                </li>


            </ul>
            <!-- Tab panes frst_sub_tabs-->
            <div class="tab-content">
                <div class="tab-pane active" id="frst_sub_tabs" role="tabpanel">
                    <div class="row">
                        <div class="col-12">
                            <form class="was-validated" autocomplete="off">
                                <div class="col-12">

                                    <div class="row">
                                        <div class="col-6">
                                            <label class="form-label">Tender Name</label>
                                            <input type="text" id="tender_name" name="tender_name" class="form-control"
                                                value="<?php echo $tender_name ?>" required>
                                            <!-- oninput="restrictToAlphabets(this)" -->
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label">Tender Code</label>
                                            <input type="text" id="tender_code_1" name="tender_code_1"
                                                class="form-control" value="<?php echo $tender_code ?>"
                                                oninput="get_tendercode();" required>
                                            <input type="hidden" name="tender_stored_code" id="tender_stored_code"
                                                value="<?php echo $tender_code ?>">

                                            <!-- oninput="restrictToAlphaNumeric(this)" -->
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <label class="form-label">Tender No</label>
                                            <input type="text" id="tender_no" name="tender_no" class="form-control"
                                                value="<?php echo $tender_no; ?>" required>
                                            <!-- oninput="restrictToAlphaNumeric(this)"  -->
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label">Tender Type</label>
                                            <select class="select2 form-control" id="tender_type" name="tender_type"
                                                required>
                                                <?php echo $tender_options ?>
                                                <!-- <option>Select option</option>
                                                <option>Open Tender</option>
                                                <option>Limited Tender</option> -->
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <label class="form-label">Validity From</label>
                                            <input type="date" id="validity_from" name="validity_from"
                                                class="form-control" value="<?php echo $validity_from ?>" required>
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label">Validity To</label>
                                            <input type="date" id="validity_to" name="validity_to" class="form-control"
                                                value="<?php echo $validity_to ?>" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <label class="form-label">Validity Date Extension</label>
                                            <input type="date" id="validity_date" name="validity_date"
                                                class="form-control" value="<?php echo $validity_date_extension ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row ">
                                        <div class="col-md-12" align="right">
                                            <?php echo btn_cancel($btn_cancel); ?>
                                            <?php echo btn_createupdate($folder_name_org, $unique_id, $btn_text); ?>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="tab-pane" id="sec_sub_tabs" role="tabpanel">
                    <div class="row">
                        <div class="col-12">
                            <form class="was-validated" autocomplete="off" method="POST">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-6">
                                            <label class="form-label">Tender Code</label>
                                            <input type="text" id="tender_code" name="tender_code" class="form-control"
                                                value="<?php if ($tender_code != '') {
                                                    echo $tender_code;
                                                } else {
                                                    echo $ids;
                                                } ?>" required readonly>
                                        </div>
                                    </div>
                                    <div class="row">

                                        <!-- <div class="col-6"> -->
                                        <!-- <label class="form-label">Tender Code</label> -->

                                        <input type="hidden" id="unique_id" name="unique_id" class="form-control"
                                            value="<?php echo $unique_id ?>" required>

                                        <!-- </div> -->
                                        <div class="col-6">
                                            <label class="form-label">Item Code</label>
                                            <input type="text" id="item_code" name="item_code" class="form-control"
                                                value="<?php echo $item_code ?>" required>
                                            <!-- oninput="restrictToAlphaNumeric(this)" -->
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label">Item Description</label>
                                            <input type="text" id="item_description" name="item_description"
                                                class="form-control" value="<?php echo $item_description ?>" required>
                                            <!-- oninput="restrictToAlphabets(this)" -->
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <label class="form-label">Item Specification</label>
                                            <input type="text" id="item_specification" name="item_specification"
                                                class="form-control" value="<?php echo $item_specification; ?>"
                                                required>

                                            <!-- oninput="restrictToAlphaNumeric(this)" -->
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label">Brand</label>
                                            <input type="text" id="brand" name="brand" class="form-control"
                                                value="<?php echo $brand; ?>" required>
                                            <!-- oninput="restrictToAlphabets(this)" -->
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <label class="form-label">Product Category</label>
                                            <input type="text" id="product_category" name="product_category"
                                                class="form-control" value="<?php echo $product_category ?>" required>
                                            <!-- oninput="restrictToAlphaNumeric(this)"  -->
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label">Short Category</label>
                                            <input type="text" id="short_category" name="short_category"
                                                class="form-control" value="<?php echo $short_category ?>" required>
                                            <!-- oninput="restrictToAlphabets(this)" -->
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <label class="form-label">Net Price</label>
                                            <!-- <input type="number" id="rc_net_price" name="rc_net_price" oninput="restrictToNumbers(this)" class="form-control" value="<?php echo $rc_net_price ?>" onchange="unitPriceCal()"> oninput="restrictToNumbers(this)"-->
                                            <input type="number" id="rc_net_price" name="rc_net_price" step="0.00001"
                                                class="form-control" value="<?php echo $rc_net_price ?>"
                                                onchange="unitPriceCal()">

                                        </div>

                                        <div class="col-6">
                                            <label class="form-label">GST%</label>
                                            <input type="number" id="gst" name="gst" class="form-control"
                                                oninput="restrictToNumbers(this)" value="<?php echo $gst ?>"
                                                onchange="unitPriceCal()">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <label class="form-label">RC Unit Price</label>
                                            <input type="number" id="rc_unit_price" name="rc_unit_price" step="0.00001"
                                                class="form-control" value="<?php echo $rc_unit_price ?>" readonly>

                                            <!-- <input type="number" id="rc_unit_price" name="rc_unit_price" class="form-control" value="<?php echo $rc_unit_price ?>" readonly> -->
                                        </div>

                                        <div class="col-6">
                                            <label class="form-label">Warranty In Months</label>
                                            <input type="number" id="warranty_in_yrs" name="warranty_in_yrs"
                                                oninput="restrictToNumbers(this)" class="form-control"
                                                value="<?php echo $warranty_in_yrs ?>">
                                        </div>
                                    </div>
                                    <br>

                                    <div class="form-group row ">
                                        <div class="col-md-12" align="right">
                                            <!-- <?php echo btn_cancel($btn_cancel); ?> -->

                                            <button type="button" name="submit" id="submit" onclick="item_submit()"
                                                class="btn btn-primary" style="margin-left: 10px;">Save</button>
                                            <!-- background-color: #4CAF50; color: white;font-size: 25px; -->
                                            <!-- <?php echo btn_createupdate($folder_name_org, $unique_id, $btn_text); ?> -->
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="modal fade bs-example-modal-xl" tabindex="-1" role="dialog"
                        aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title w-100 text-center" id="myExtraLargeModalLabel">Excel Import
                                    </h5>
                                    <hr />
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-6">
                                            <label>File Import</label>
                                            <input type="file" id="file" accept=".xlsx,.xls,.csv" name="file"
                                                class="form-control" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary ">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <div class="btn-header">
                                <!-- <dic class="col-3"> -->
                                <!-- <a href="javascript:excel_popup()"><button type="button" id="export1" name="export1" class="btn btn-primary  waves-effect waves-light wavw  mb-1 mt-1"><i class="ri-file-excel-2-fill"></i> &nbsp;Import </button></a> -->
                                <a href="javascript:tested()">
                                    <button type="button" id="export1" name="export1"
                                        class="btn btn-primary waves-effect waves-light mb-1 mt-1">
                                        <i class="ri-file-excel-2-fill"></i> &nbsp;Import
                                    </button>
                                </a>

                                <!-- </div> -->
                            </div>

                            <div style="margin-left: 126px;margin-top: -71px;">
                                <span>Excel Format</span><br>
                                <a class="align-items-center btn btn-primary waves-effect waves-light mb-1 mt-1"
                                    href="folders/item_creation/item_creation_excel_format.xlsx"
                                    download="import_format.xlsx" role="tab">
                                    <i class="mdi mdi-download me-1" aria-hidden="true"></i>
                                    <span>Download</span>
                                </a>

                            </div>

                            <!-- <a data-bs-toggle="modal" data-bs-target=".bs-example-modal-xl" href="javascript:excel_popup()">
                                <button type="button" class="btn btn-primary  waves-effect waves-light wavw  mb-1 mt-1">
                                    <i class="ri-file-excel-2-fill"></i> Import </button></a> -->
                        </div>
                        <script>
                            function tested() {
                                // alert();
                                var modal = document.getElementById("excel_import_export");
                                modal.style.display = "block";
                            }

                        </script>


                        <div class="col">
                            <!-- <button type="button" id="export" name="export" class="btn btn-primary  waves-effect waves-light wavw  mb-1 mt-1"> -->
                            <!-- <i class="ri-file-excel-2-fill"></i> Export -->
                            <!-- </button> -->
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 mt-2">
                            <div class="table-responsive mb-4">
                                <table class="table table-striped table-bordered align-middle table mb-0 small_table"
                                    id="excel_datatable">
                                    <thead class="table-light">
                                        <tr>
                                            <th>S.No</th>
                                            <th scope="col">Item Code</th>
                                            <th scope="col">Item Description</th>
                                            <th scope="col">Item Specification</th>
                                            <th scope="col">Brand</th>
                                            <th scope="col">Product Category</th>
                                            <th scope="col">Short Category</th>
                                            <th scope="col">RC Unit Price</th>
                                            <th scope="col">GST%</th>
                                            <th scope="col">Net Price</th>
                                            <th scope="col">Warranty In Months</th>

                                            <th scope="col">Action</th>

                                            <!-- <th scope="col">BG Months</th> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- <tr>
                                            <td>2</td>
                                            <td>002</td>
                                            <td>DELL</td>
                                            <td>20</td>
                                            <td> 0</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr> -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="form-group row ">
                            <div class="col-md-12" align="right">
                                <?php echo btn_cancel($btn_cancel); ?>
                            </div>
                        </div>

                    </div>
                    <?php include 'excel.php' ?>

                </div>

            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>

    function unitPriceCal() {
        var netValue = document.getElementById('rc_net_price').value;
        var gstValue = document.getElementById('gst').value;

        if (gstValue != '' && netValue != '') {
            var unitValue = netValue / (1 + (gstValue / 100));
            document.getElementById('rc_unit_price').value = unitValue;
        } else {
            console.log('Net Value is first fill then GST');
        }
    }
    function get_tendercode() {
        var tendercodes = document.getElementById('tender_code_1').value;
        // alert(tendercodes);
        document.getElementById('tender_code').value = tendercodes;
    }

    // function tab_function(){
    // alert();
    // var tab_vals = $('#sec_tab').val();
    // document.getElementById('sec_tab').value = 2;
    //  $('#frst_tabs, #frst_sub_tabs').removeClass('active');
    // $('#sec_tabs, #sec_sub_tabs').addClass('active');
    // window.location.href="index.php?file=item_creation/create?tab=2";

    $(document).ready(function () {
        // var tab_vals = $('#sec_tab').val();
        var tab_vals = document.getElementById('sec_tab_values').value;
        // alert(tab_vals);
        // console.log(tab_vals);
        if (tab_vals === '2') {
            $('#sec_tabs, #sec_sub_tabs').addClass('active');

            // Remove active from first tab elements
            $('#frst_tabs, #frst_sub_tabs').removeClass('active');

            // Add active to second tab elements
            $('#sec_tabs, #sec_sub_tabs').addClass('active');
        } else {

            //  $('#sec_tabs, #sec_sub_tabs').addClass('active');
            $('#frst_tabs, #frst_sub_tabs').addClass('active');
            $('#sec_tabs, #sec_sub_tabs').removeClass('active');
            //   Add active to second tab elements

        }
    });
    //  }
    // function item_submit() {
    //     var tender_code = document.getElementById('tender_code').value;
    //     var item_code = document.getElementById('item_code').value;

    //     var item_description = document.getElementById('item_description').value;

    //     var item_specification = document.getElementById('item_specification').value;

    //     var product_category = document.getElementById('product_category').value;

    //     var brand = document.getElementById('brand').value;

    //     var short_category = document.getElementById('short_category').value;

    //     var rc_unit_price = document.getElementById('rc_unit_price').value;
    //     var rc_net_price = document.getElementById('rc_net_price').value;

    //     var gst = document.getElementById('gst').value;

    //     var warranty_in_yrs = document.getElementById('warranty_in_yrs').value;


    //     var ajax_url = sessionStorage.getItem("folder_crud_link");
    //     var url = sessionStorage.getItem("list_link");

    //     // alert(rc_unit_price);
    //     // alert(rc_net_price);
    //     // var data = "tender_code=" + tender_code + "&item_code=" + item_code +
    //     //     "&item_description=" + item_description + "&item_specification=" + item_specification +
    //     //     "&product_category=" + product_category + "&brand=" + brand + "&rc_unit_price=" + rc_unit_price +
    //     //     "&short_category=" + short_category + "&rc_net_price=" + rc_net_price +
    //     //     "&gst=" + gst +
    //     //     "&warranty_in_yrs=" + warranty_in_yrs + "&action=get_item";
    //     // alert(data);


    //     var formData = new FormData();
    //     formData.append("tender_code", tender_code);
    //     formData.append("item_code", item_code);
    //     formData.append("item_description", item_description);
    //     formData.append("item_specification", item_specification);
    //     formData.append("product_category", product_category);
    //     formData.append("brand", brand);
    //     formData.append("short_category", short_category);
    //     formData.append("rc_unit_price", rc_unit_price);
    //     formData.append("rc_net_price", rc_net_price);
    //     formData.append("gst", gst);
    //     formData.append("warranty_in_yrs", warranty_in_yrs);
    //     formData.append("action", "get_item");



    //     if (tender_code && item_code && item_description && item_specification && product_category && brand && short_category && rc_unit_price && rc_net_price && gst && warranty_in_yrs != '') {
    //         $.ajax({
    //             type: "POST",
    //             // url: 'folders/item_creation/crud.php', // Make sure this path is correct
    //             url: ajax_url,
    //             data: formData,
    //             beforeSend: function () {
    //                 // loading spinner etc.
    //             },
    //             success: function (response) {
    //                 var obj = JSON.parse(response);
    //                 var msg = obj.msg;
    //                 var status = obj.status;
    //                 var error = obj.error;
    //                 var tender_code = document.getElementById('tender_code').value;
    //                 var encodedId = btoa(tender_code); // Base64-encode the raw ID
    //                 sweetalert(msg);  // ensure `sweetalert` is defined
    //                 // window.location.href = "index.php?file=item_creation/create&id=id&tab=2";
    //                 // tab_function();
    //                 const triggerEl = document.querySelector('#sec_tabs');
    //                 bootstrap.Tab.getOrCreateInstance(triggerEl).show();

    //                 // If desired, hide the first (optional, plugin handles it)
    //                 $('#frst_tabs, #frst_sub_tabs').removeClass('active');
    //                 $('#sec_tabs, #sec_sub_tabs').addClass('active');
    //                 window.location.href = 'index.php?file=item_creation/create&id=' + encodeURIComponent(encodedId) + '&tab=2';
    //             },
    //             error: function () {
    //                 alert("Network Error");
    //             }
    //         });
    //     } else {

    //         Swal.fire({
    //             icon: 'warning',
    //             title: 'Validation Error',
    //             text: 'Please fill out all required fields.',
    //             confirmButtonText: 'OK'
    //         });
    //     }
    // }


    function item_submit() {

        var tender_code = document.getElementById('tender_code').value.trim();
        var item_code = document.getElementById('item_code').value.trim();
        var item_description = document.getElementById('item_description').value.trim();
        var item_specification = document.getElementById('item_specification').value.trim();
        var product_category = document.getElementById('product_category').value.trim();
        var brand = document.getElementById('brand').value.trim();
        var short_category = document.getElementById('short_category').value.trim();
        var rc_unit_price = document.getElementById('rc_unit_price').value.trim();
        var rc_net_price = document.getElementById('rc_net_price').value.trim();
        var gst = document.getElementById('gst').value.trim();
        var warranty_in_yrs = document.getElementById('warranty_in_yrs').value.trim();

        var ajax_url = sessionStorage.getItem("folder_crud_link");

        if (
            tender_code !== '' &&
            item_code !== '' &&
            item_description !== '' &&
            item_specification !== '' &&
            product_category !== '' &&
            brand !== '' &&
            short_category !== '' &&
            rc_unit_price !== '' &&
            rc_net_price !== '' &&
            gst !== '' &&
            warranty_in_yrs !== ''
        ) {

            var formData = new FormData();
            formData.append("tender_code", tender_code);
            formData.append("item_code", item_code);
            formData.append("item_description", item_description);
            formData.append("item_specification", item_specification);
            formData.append("product_category", product_category);
            formData.append("brand", brand);
            formData.append("short_category", short_category);
            formData.append("rc_unit_price", rc_unit_price);
            formData.append("rc_net_price", rc_net_price);
            formData.append("gst", gst);
            formData.append("warranty_in_yrs", warranty_in_yrs);
            formData.append("action", "get_item");

            $.ajax({
                type: "POST",
                url: ajax_url,
                data: formData,
                processData: false,   // 🔥 IMPORTANT
                contentType: false,   // 🔥 IMPORTANT
                beforeSend: function () {
                    // Optional loader
                },
                success: function (response) {

                    var obj = JSON.parse(response);

                    Swal.fire({
                        icon: obj.status === 'success' ? 'success' : 'info',
                        title: obj.msg
                    });

                    var encodedId = btoa(tender_code);

                    window.location.href =
                        'index.php?file=item_creation/create&id=' +
                        encodeURIComponent(encodedId) +
                        '&tab=2';
                },
                error: function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'Network Error'
                    });
                }
            });

        } else {
            Swal.fire({
                icon: 'warning',
                title: 'Validation Error',
                text: 'Please fill out all required fields.'
            });
        }
    }

    $("#main_import123").click(function () {
        // var form_main_unique_id = $("#demo").val();
        // var file = document.getElementById('file').files.length;
        // var no_of_consignee = document.getElementById('no_of_consignee').value;
        // var cons_verfiy_sts = document.getElementById('cons_verfiy_sts').value;
        // var batch_id = $("#batch_id").val();
        // var consignee_received_date = $("#consignee_received_date").val();
        // var po_number = $("#po_numbers").val();
        // alert("i am working");
        if (file === 0) {
            alert("Please select a file to upload.");
            return;
        }
        var image_s = document.getElementById("file");
        var data = new FormData();

        if (image_s.files.length > 0) {
            data.append("file", image_s.files[0]); // single file
        }
        // alert(data);
        // data.append("form_main_unique_id", form_main_unique_id);
        // data.append("no_of_consignee", no_of_consignee);
        // data.append("cons_verfiy_sts", cons_verfiy_sts);
        // data.append("batch_id", batch_id);
        // data.append("consignee_received_date", consignee_received_date);
        // data.append("po_number", po_number);

        $.ajax({
            type: "POST",
            url: 'folders/item_creation/myimport.php',
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            success: function (res) {
                console.log("Server response:", res);
                let response;
                // try {
                //     response = JSON.parse(res);
                // } catch (e) {
                //     console.error("JSON Parse Error:", e);
                //     alert("Unexpected server response. Please contact support.");
                //     return;
                // }

                // if (response.status === "error") {
                //     let errorMessage = "❌ Error:\n" + response.message;
                //     if (response.missing_ids && response.missing_ids.length > 0) {
                //         errorMessage += "\n\nMissing/Invalid Staff IDs:\n" + response.missing_ids.join(", ");
                //     }

                //     alert(errorMessage); // Replace with SweetAlert if needed
                //     // Example SweetAlert:
                //     // Swal.fire({ icon: 'error', title: 'Upload Failed', text: errorMessage });
                // } else {
                //     alert("✅ Upload successful!");
                //     // Swal.fire({ icon: 'success', title: 'Success', text: 'Upload successful!' });
                //     modal_close();
                //     sub_list_datatable_consignee("consignee_details_datatable");
                // }
                // document.getElementById('file').value = '';
            },
            error: function (xhr, status, error) {
                console.error("Upload failed:", error);
                alert("An error occurred while uploading the file.");
            }
        });
    });


</script>
<!-- <script>
    $("#export").click(function() {
        // alert('hi');
        window.location = "folders/item_creation/excel.php";
    });
</script> -->
