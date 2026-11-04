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

        // $uni_dec = str_replace(" ", "+", $_GET['unique_id']);
        // $get_uni_id           = openssl_decrypt(base64_decode($uni_dec), $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv);

        $unique_id  = $_GET["unique_id"];
        $where      = [
            "unique_id" => $unique_id
        ];


        $table      =  "user_type";

        $columns    = [
            "user_type",
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

            $user_type          = $result_values[0]["user_type"];
            //$under_user_type    = $result_values[0]["under_user_type"];
            $is_active          = $result_values[0]["is_active"];

            $exp_under_user_type  = explode(",", $under_user_type);

            $btn_text           = "Update";
            $btn_action         = "update";
        } else {
            $btn_text           = "Error";
            $btn_action         = "error";
            $is_btn_disable     = "disabled='disabled'";
        }
    }
}

// $under_user_type_options = under_user_type($user_type);
// $under_user_type_options = select_option($under_user_type_options, "Select Staff", $exp_under_user_type);


$active_status_options   = active_status($is_active);

?>

<!-- <div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form class="was-validated" autocomplete="off">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group row ">
                                <label class="col-md-2 col-form-label" for="user_type"> User Type </label>
                                <div class="col-md-4">
                                    <input type="text" id="user_type" name="user_type" class="form-control" value="<?php echo $user_type; ?>" required>
                                </div>
                                <label class="col-md-2 col-form-label" for="is_active"> Active Status</label>
                                <div class="col-md-4">
                                    <select name="is_active" id="is_active" class="select2 form-control" required>
                                        <?php echo $active_status_options; ?>
                                    </select>
                                </div>
                            </div>
                            <br>
                            <div class="form-group row ">
                                <div class="col-md-12" align="right">
                                    <?php echo btn_cancel($btn_cancel); ?>
                                    <?php echo btn_createupdate($folder_name_org, $unique_id, $btn_text); ?>
                                </div>

                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div> 
    </div>
</div> -->


<div class="row">
    <div class="col-12">
        <div class="card ">
            <div class="card-body p-5">
                <h4 class="sub_header_style pb-2">User Type</h4>
                <form class="was-validated" autocomplete="off">
                    <div class="row">
                        <div class="col-12">
                            <div class="row" >
                                <div class="col-xl-6">
                                    <div class="row">
                                        <div class="col-xl-5">
                                            <label for="main_screen" class="form-label">User Type</label>
                                        </div>
                                        <div class="col-xl-6">
                                            <input type="text" id="user_type" name="user_type" class="form-control" value="<?php echo  $user_type; ?>" required>
                                        </div>
                                        <div class="col-xl-1"></div>
                                    </div>
                                   
                                </div><!-- end col -->
                                <div class="col-xl-6">
                                   
                                    <div class="row">
                                        <div class="col-xl-6">
                                            <label for="cleave-delimiter" class="form-label">Active Status</label>
                                        </div>
                                        <div class="col-xl-6">
                                            <select name="is_active" id="is_active" class=" form-select" required>
                                            <?php echo $active_status_options; ?>
                                        </select>
                                        </div>
                                    </div>
                                    
                                </div><!-- end col -->

                                
                            </div>
                            <div class="form-group row pt-4">
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
