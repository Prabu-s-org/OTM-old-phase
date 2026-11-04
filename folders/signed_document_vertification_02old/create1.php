<!-- This file Only PHP Functions -->
<?php include 'function.php'; ?>

<?php
// Form variables

// $under_user_type_options = under_user_type($user_type);
// $under_user_type_options = select_option($under_user_type_options, "Select Staff", $exp_under_user_type);


// $active_status_options   = active_status($is_active);
include '../../config/dbconfig.php';
include '../../inc/header.php';
include '../../inc/footer.php';

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

        $uni_dec = str_replace(" ", "+", $_GET['unique_id']);
        $get_uni_id           = openssl_decrypt(base64_decode($uni_dec), $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv);

        $unique_id  = $get_uni_id;
        $where      = [
            "unique_id" => $unique_id
        ];


        $table      =  "state_creation";

        $columns    = [
            "state_name",
            //"under_user_type",
            "is_active"
        ];

        $table_details   = [
            $table,
            $columns
        ];

        $result_values  = $pdo->select($table_details, $where);

        if ($result_values->status) {

            $result_values      = $result_values->data;

            $state_name          = $result_values[0]["state_name"];
            //$under_user_type    = $result_values[0]["under_user_type"];
            $is_active          = $result_values[0]["is_active"];

            // $exp_under_user_type  = explode(",", $under_user_type);

            $btn_text           = "Update";
            $btn_action         = "update";
        } else {
            $btn_text           = "Error";
            $btn_action         = "error";
            $is_btn_disable     = "disabled='disabled'";
        }
    }
}
?>



<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Signed_Document UpdateForm</h4>
            </div>
            <div class="card-body">
                <form class="was-validated" autocomplete="off">
                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="row">
                                        <div class="col-md-3">PO No</div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-8">100</div>
                                    </div>
                                </div><br><br><!-- end col -->
                                <div class="col-xl-6">
                                    <div class="row">
                                        <div class="col-md-3">PO Date</div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-8">23-11-2023</div>
                                    </div>
                                </div><br><br><!-- end col -->
                                <div class="col-xl-6">
                                    <div class="row">
                                        <div class="col-md-3">Consignee Name</div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-8">Ocean Clothes</div>
                                    </div>
                                </div><br><br><!-- end col -->
                                <div class="col-xl-6">
                                    <div class="row">
                                        <div class="col-md-3">Consignee Location</div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-8">Chennai</div>
                                    </div>
                                </div><br><br><!-- end col -->
                                <div class="col-xl-6">
                                    <div class="row">
                                        <div class="col-md-3">Invoice No</div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-8">101</div>
                                    </div>
                                </div><br><br><!-- end col -->
                                <div class="col-xl-6">
                                    <div class="row">
                                        <div class="col-md-3">Invoice Date</div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-8">23-11-2023</div>
                                    </div>
                                </div><br><br><!-- end col -->
                              
                               <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">DC Received status</label>
                                        <input type="text" id="state_name" name="state_name" class="form-control" value="<?php echo $state_name; ?>" required>

                                    </div>
                                </div><br><br><!-- end col -->
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">DC Signed Date</label>
                                        <input type="text" id="state_name" name="state_name" class="form-control" value="<?php echo $state_name; ?>" required>

                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">IR Received Status</label>
                                        <input type="text" id="state_name" name="state_name" class="form-control" value="<?php echo $state_name; ?>" required>

                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">IR Signed Date</label>
                                        <input type="date" id="state_name" name="state_name" class="form-control" value="<?php echo $state_name; ?>" required>

                                    </div>
                                </div>

                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">Primary Product For BG</label>
                                        <!-- <input type="date" id="state_name" name="state_name" class="form-control" value="<?php echo $state_name; ?>" required> -->
                                        <select class="form-select mb-3" aria-label="Default select example">
                                            <option selected>Select product</option>
                                            <option value="1">Laptop</option>
                                            <option value="2">Keyboard</option>
                                            <option value="3">Mouse</option>
                                        </select>

                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">Approval</label>
                                        <select name="approval" id="approval" class="select2 form-control" required>
                                            <option value="select">select option</option>
                                            <option value="Apporval">Apporval</option>
                                            <option value="Not_Apporval">Not Apporval</option>

                                        </select>
                                    </div>
                                </div>

                              
                                <!-- end col -->
                            </div>
                            <div class="form-group row ">
                                <div class="col-md-12" align="right">

                                    <?php echo btn_cancel($btn_cancel); ?>
                                    <?php echo btn_createupdate($folder_name_org, $unique_id, $btn_text); ?>
                                    <!-- <button type="button" class="btn btn-primary">Submit</button> -->
                                </div>

                            </div>
                        </div>
                    </div>
                </form>

            </div> <!-- end card-body -->
        </div> <!-- end card -->
    </div><!-- end col -->
</div>
<!-- 
<div class="col-md-12" align="right">
              <button type="button" class="btn btn-info">Submit</button></div> -->
