<!-- This file Only PHP Functions -->
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




$active_status_options   = active_status($is_active);

?>


<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Product Category</h4>
            </div>
            <div class="card-body">
                <form class="was-validated" autocomplete="off">
                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                            <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label class="form-label">Main  Category</label>
                                        <!-- <input type="text" id="state_name" name="state_name" class="form-control" value="<?php echo $state_name; ?>" required> -->
                                        <select name="district_name" id="district_name" class="select2 form-control" required>
                                        <option value="select">select</option>
                                           <option value="tamilnadu">erode</option>
                                        </select>
                                    </div>
                                </div>
                            <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label class="form-label">Product Category</label>
                                        <input type="text" id="state_name" name="state_name" class="form-control" value="<?php echo $state_name; ?>" required>
                                        <!-- <select name="district_name" id="district_name" class="select2 form-control" required>
                                        <option value="select">select</option>
                                           <option value="tamilnadu">erode</option>
                                        </select> -->
                                    </div>
                                </div><!-- end col -->
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label class="form-label">Description</label>
                                        <!-- <input type="text" id="district_name" name="district_name" class="form-control" value="<?php echo $district_name; ?>" required> -->
                                        <textarea name="district_name" id="district_name"   class="form-control"><?php echo $district_name; ?></textarea>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label class="form-label">Active Status</label>
                                        <select name="is_active" id="is_active" class="select2 form-control" required>
                                            <?php echo $active_status_options; ?>
                                        </select>
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
