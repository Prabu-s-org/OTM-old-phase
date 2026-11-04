<!-- This file Only PHP Functions -->
<?php include 'function.php'; ?>

<?php

// $under_user_type_options = under_user_type($user_type);
// $under_user_type_options = select_option($under_user_type_options, "Select Staff", $exp_under_user_type);
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
                <h4 class="card-title mb-0">Signed_Document Update Form</h4>
            </div>
            <div class="card-body">
                <form class="was-validated" autocomplete="off">
                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">PO Number</label>
                                        <input type="text" id="state_name" name="state_name" class="form-control" value="<?php echo 0001; ?>" required>
                                    </div>
                                </div><!-- end col -->
                            <div class="col-xl-6">
                                <div>
                                <label for="exampleInputdate" class="form-label">PO Date</label>
                                <input type="date" class="form-control" id="exampleInputdate">
                            </div>
                            </div>
                            <div class="col-lg-6">
                            <label for="main_screen" class="form-label">Department</label>
                                <select class="form-select mb-3" aria-label="Default select example">
                                    <option selected>Select Department </option>
                                    <option value="1">Department1</option>
                                    <option value="2">Department2</option>
                                    <option value="3">Department3</option>
                                </select>
                            
                            </div>


                            <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">Excutive Name</label>
                                        <input type="text" id="state_name" name="state_name" class="form-control" value="<?php echo 1121; ?>" required>
                                    </div>
                            </div><!-- end col -->
                            <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">No of Consignee</label>
                                        <input type="text" id="state_name" name="state_name" class="form-control" value="<?php echo 2; ?>" required>
                                    </div>
                            </div><!-- end col -->
                            <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">No of Items in PO</label>
                                        <input type="text" id="state_name" name="state_name" class="form-control" value="<?php echo 10; ?>" required>
                                    </div>
                            </div><!-- end col -->
                            <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">QTY</label>
                                        <input type="text" id="state_name" name="state_name" class="form-control" value="<?php echo 2; ?>" required>
                                    </div>
                            </div><!-- end col -->
                            <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">Net Value</label>
                                        <input type="text" id="state_name" name="state_name" class="form-control" value="<?php echo 1212121; ?>" required>
                                    </div>
                            </div><!-- end col -->


                            <div class="form-group row ">
                                <div class="col-md-12" align="right">
                                    <!-- Cancel,save and update Buttons -->
                                    <?php echo btn_cancel($btn_cancel); ?>
                                    <?php echo btn_createupdate($folder_name_org, $unique_id, $btn_text); ?>
                                </div>
                            </div>
                        </div>
                </form>

            </div> <!-- end card-body -->
        </div> <!-- end card -->
    </div><!-- end col -->
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Stock Position Sub Form</h4>
            </div>
            <div class="card-body">
                <form class="was-validated" autocomplete="off">
                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">Item Code</label>
                                        <input type="text" id="state_name" name="state_name" class="form-control" value="" >
                                    </div>
                                </div><!-- end col -->
                            <div class="col-xl-6">
                                <div>
                                <label for="exampleInputdate" class="form-label">Item Details</label>
                                <input type="text" id="state_name" name="state_name" class="form-control" value="" >
                            </div>
                            </div>
                            


                            <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">QTY</label>
                                        <input type="text" id="state_name" name="state_name" class="form-control" value="<?php echo $state_name; ?>" required>
                                    </div>
                            </div><!-- end col -->
                            <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">Billed QTY</label>
                                        <input type="text" id="state_name" name="state_name" class="form-control" value="<?php echo $state_name; ?>" required>
                                    </div>
                            </div><!-- end col -->
                            <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label"> Request to Bill QTY</label>
                                        <input type="text" id="state_name" name="state_name" class="form-control" value="<?php echo $state_name; ?>" required>
                                    </div>
                            </div><!-- end col -->
                            <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">Remaining QTY</label>
                                        <input type="text" id="state_name" name="state_name" class="form-control" value="<?php echo $state_name; ?>" required>
                                    </div>
                            </div><!-- end col -->
                            
                            </div>

                            <div class="form-group row ">
                                <div class="col-md-12" align="right">
                                    <!-- Cancel,save and update Buttons -->
                                    <?php echo btn_cancel($btn_cancel); ?>
                                    <?php echo btn_createupdate($folder_name_org, $unique_id, $btn_text); ?>
                                </div>
                            </div>
                        </div>
                </form>

            </div> <!-- end card-body -->
        </div> <!-- end card -->
    </div><!-- end col -->
</div>
