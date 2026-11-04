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
$btn_text           = "Save";
$btn_action         = "create";
$is_btn_disable     = "";
$unique_id          = "";
$user_type               = "";
$under_user_type        = "";
$exp_under_user_type     = "";
$is_active          = 1;
if (isset($_GET["unique_id"])) {
    if (!empty($_GET["unique_id"])) {

        $unique_id  = $_GET["unique_id"];
        $where      = [
            "unique_id" => $unique_id
        ];
        $table      =  "item_creation";
        $columns    = [
            "tender_name",
            "tender_code",
            "tender_no",
            "tender_type",
            "validity_from",
            "validity_to",
            "validity_date_extension",
            "is_active"
        ];
        $table_details   = [
            $table,
            $columns
        ];
        $result_values  = $pdo->select($table_details, $where);
        if ($result_values->status) {
            $result_values      = $result_values->data;
            $tender_name          = $result_values[0]["tender_name"];
            $tender_code          = $result_values[0]["tender_code"];
            $tender_no          = $result_values[0]["tender_no"];
            $tender_type          = $result_values[0]["tender_type"];

            $validity_from          = $result_values[0]["validity_from"];
            $validity_to          = $result_values[0]["validity_to"];
            $validity_date_extension          = $result_values[0]["validity_date_extension"];
            $is_active          = $result_values[0]["is_active"];
            $btn_text           = "Update";
            $btn_action         = "update";
        } else {
            $btn_text           = "Error";
            $btn_action         = "error";
            $is_btn_disable     = "disabled='disabled'";
        }
    }
}

$tender_option      = [

    "Open Tender" => [
        "unique_id" => "1",
        "value"     => "Open Tender",
    ],
    "Limited Tender" => [
        "unique_id" => "2",
        "value"     => "Limited Tender",
    ],
];
$tender_options           = select_option($tender_option, "Select", $tender_type);
$active_status_options   = active_status($is_active);
?>
<div class="row">
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
                    <a class="nav-link active" data-bs-toggle="tab" href="#arrow-overview" role="tab">
                        <span class="d-block d-sm-none"><i class="mdi mdi-home-variant"></i></span>
                        <span class="d-none d-sm-block">PO Details</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#arrow-profile" role="tab">
                        <span class="d-block d-sm-none"><i class="mdi mdi-account"></i></span>
                        <span class="d-none d-sm-block">Item details upload</span>
                    </a>
                </li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane active" id="arrow-overview" role="tabpanel">
                    <div class="row">
                        <div class="col-12">
                            <form class="was-validated" autocomplete="off">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-6">
                                            <label class="form-label">Tender Name</label>
                                            <input type="text" id="tender_name" name="tender_name" class="form-control" value="<?php echo  $tender_name ?>" required>
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label">Tender Code</label>
                                            <input type="text" id="tender_code_1" name="tender_code_1" class="form-control" value="<?php echo $tender_code ?>" required>
                                            <input type="hidden" name="tender_stored_code" id="tender_stored_code" value="<?php echo $tender_code ?>">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <label class="form-label">Tender No</label>
                                            <input type="text" id="tender_no" name="tender_no" class="form-control" value="<?php echo $tender_no; ?>" required>
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label">Tender Type</label>
                                            <select class="select2 form-control" id="tender_type" name="tender_type" required>
                                                <?php echo  $tender_options ?>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <label class="form-label">Validity From</label>
                                            <input type="date" id="validity_from" name="validity_from" class="form-control" value="<?php echo $validity_from ?>" required>
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label">Validity To</label>
                                            <input type="date" id="validity_to" name="validity_to" class="form-control" value="<?php echo $validity_to ?>" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <label class="form-label">Validity Date Extension</label>
                                            <input type="date" id="validity_date" name="validity_date" class="form-control" value="<?php echo $validity_date_extension ?>">
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
                <div class="tab-pane" id="arrow-profile" role="tabpanel">

                   <div class="row">
                        <div class="col-12">
                            <form class="was-validated" autocomplete="off"  method="POST">
                                <div class="col-12">
                                    <div class="row">
                                         <!-- <div class="col-6"> -->
                                            <!-- <label class="form-label">Tender Code</label> -->
                                            <input type="hidden" id="tender_code" name="tender_code" class="form-control" value="<?php  echo $tender_code?>" required>
                                    <input type="hidden" id="unique_id" name="unique_id" class="form-control" value="<?php  echo $unique_id?>" required>

                                        <!-- </div> -->
                                        <div class="col-6">
                                            <label class="form-label">Item Code</label>
                                            <input type="text" id="item_code" name="item_code" class="form-control" value="<?php echo  $item_code ?>" required>
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label">Item Description</label>
                                            <input type="text" id="item_description" name="item_description" class="form-control" value="<?php  echo $item_description?>" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <label class="form-label">Item Specification</label>
                                            <input type="text" id="item_specification" name="item_specification" class="form-control" value="<?php echo $item_specification;?>" required>
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label">Brand</label>
                        <input type="text" id="brand" name="brand" class="form-control" value="<?php echo $brand;?>" required>

                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <label class="form-label">Product Category</label>
                                            <input type="text" id="product_category" name="product_category" class="form-control" value="<?php echo $product_category ?>" required>
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label">Short Category</label>
                                            <input type="text" id="short_category" name="short_category" class="form-control" value="<?php echo $short_category ?>" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <label class="form-label">RC Unit Price</label>
                                            <input type="number" id="rc_unit_price" name="rc_unit_price" class="form-control" value="<?php echo $rc_unit_price ?>" >
                                        </div>
                                    
                                        <div class="col-6">
                                            <label class="form-label">GST%</label>
                                            <input type="number" id="gst" name="gst" class="form-control" value="<?php echo $gst ?>" >
                                        </div>
                                    </div>
                                     <div class="row">
                                        <div class="col-6">
                                            <label class="form-label">Net Price</label>
                                            <input type="number" id="rc_net_price" name="view_bill_submission_with_bg" class="form-control" value="<?php echo $rc_net_price ?>" >
                                        </div>
                                   
                                        <div class="col-6">
                                            <label class="form-label">Warranty In Years</label>
                                            <input type="number" id="warranty_in_yrs" name="warranty_in_yrs" class="form-control" value="<?php echo $warranty_in_yrs ?>" >
                                        </div>
                                    </div>
                                     <br>
                                     
                                    <div class="form-group row ">
                                        <div class="col-md-12" align="right">
                                            <!-- <?php echo btn_cancel($btn_cancel); ?> -->

                                             <button type="button" name="submit" id="submit" onclick="item_submit()" class="btn btn-primary"
                                             style="margin-left: 10px;">Save</button>
                                             <!-- background-color: #4CAF50; color: white;font-size: 25px; -->
                                            <!-- <?php echo btn_createupdate($folder_name_org, $unique_id, $btn_text); ?> -->
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>








                    <div class="modal fade bs-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title w-100 text-center" id="myExtraLargeModalLabel">Excel Import </h5>
                                    <hr />
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-6">
                                            <label>File Import</label>
                                            <input type="file" id="file" accept=".xlsx,.xls,.csv" name="file" class="form-control" value="">
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
                        <div class="col">
                            <div class="btn-header">
                                <a href="javascript:tested()">
                                    <button type="button" id="export1" name="export1" class="btn btn-primary waves-effect waves-light mb-1 mt-1">
                                        <i class="ri-file-excel-2-fill"></i> &nbsp;Import
                                    </button>
                                </a>
                            </div>

                        </div>
                        <script>
                            function tested() {
                                var modal = document.getElementById("excel_import_export");
                                modal.style.display = "block";
                            }
                        </script>
                        <div class="col">

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 mt-2">
                            <div class="table-responsive mb-4">
                                <table class="table table-striped table-bordered align-middle table mb-0 small_table" id="excel_datatable">
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
                                            <th scope="col">Warranty In Years</th>

                                            <th scope="col">Action</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                    <?php include 'excel.php' ?>

                </div>
            </div>
        </div>
    </div>
</div>

<script>


function item_submit() {
    var tender_code = document.getElementById('tender_code').value;
    var item_code = document.getElementById('item_code').value;

    var item_description = document.getElementById('item_description').value;

    var item_specification = document.getElementById('item_specification').value;

    var product_category = document.getElementById('product_category').value;
  
    var brand = document.getElementById('brand').value;

    var short_category = document.getElementById('short_category').value;

    var rc_unit_price = document.getElementById('rc_unit_price').value;
    var rc_net_price = document.getElementById('rc_net_price').value;

    var gst = document.getElementById('gst').value;
   
    var warranty_in_yrs = document.getElementById('warranty_in_yrs').value;
   

    var ajax_url = sessionStorage.getItem("folder_crud_link");
	var url = sessionStorage.getItem("list_link");

    var data = "tender_code=" + tender_code + "&item_code=" + item_code +
        "&item_description=" + item_description + "&item_specification=" + item_specification +
        "&product_category=" + product_category + "&brand=" + brand +
        "&short_category=" + short_category + "rc_net_price=" + rc_net_price +
         "&gst=" + gst + 
        "&warranty_in_yrs=" + warranty_in_yrs + "&action=get_item";

    $.ajax({
        type: "POST",
        // url: 'folders/item_creation/crud.php', // Make sure this path is correct
        url:ajax_url,
        data: data,
        beforeSend: function () {
            // loading spinner etc.
        },
        success: function (response) {
            // alert(response);
            var obj = JSON.parse(response);
            var msg = obj.msg;
            var status = obj.status;
            var error = obj.error;

            sweetalert(msg,url);  // ensure `sweetalert` is defined
        },
        error: function () {
            alert("Network Error");
        }
    });
}














    $("#main_import123").click(function() {
        if (file === 0) {
            alert("Please select a file to upload.");
            return;
        }
        var image_s = document.getElementById("file");
        var data = new FormData();

        if (image_s.files.length > 0) {
            data.append("file", image_s.files[0]); // single file
        }

        $.ajax({
            type: "POST",
            url: 'folders/item_creation/myimport.php',
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            success: function(res) {
                console.log("Server response:", res);
                let response;

            },
            error: function(xhr, status, error) {
                console.error("Upload failed:", error);
                alert("An error occurred while uploading the file.");
            }
        });
    });
</script>
