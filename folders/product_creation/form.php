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


        $unique_id  = $_GET["unique_id"];
        $where      = [
            "unique_id" => $unique_id
        ];


        $table      =  "product_creation";

        $columns    = [
            "product_creation",
            "description",
            "is_active"
        ];

        $table_details   = [
            $table,
            $columns
        ];

        $result_values  = $pdo->select($table_details, $where);

        if ($result_values->status) {

            $result_values      = $result_values->data;

            $product_creation         = $result_values[0]["product_creation"];
            $description = $result_values[0]["description"];
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


$main_type_options = main_option();
$main_type_options = select_option($main_type_options, "Select Product", $product_creation);


$active_status_options   = active_status($is_active);

?>


<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Product Creation</h4>
            </div>
            <div class="card-body">
                <form class="was-validated" autocomplete="off">
                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                            <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label class="form-label">Product Creation</label>
                                        
                                        <select name="product_creation" id="product_creation" class="select2 form-control" required>
                                        <?php echo $main_type_options; ?>
                                        </select>
                                    </div>
                                </div>
                                <!-- end col -->
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label class="form-label">Description</label>
                                       
                                        <textarea name="description" id="description" oninput="validateName(this)" class="form-control"><?php echo $description; ?></textarea>
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


<script>

function validateName(input) {
    input.value = input.value.replace(/[^A-Za-z\s]/g, ''); // Allow letters, numbers, and spaces
}
    </script>
