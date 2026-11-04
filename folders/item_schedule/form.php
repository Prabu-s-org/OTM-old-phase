<!-- This file Only PHP Functions -->
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

if (isset($_GET["unique_id"])) {
    if (!empty($_GET["unique_id"])) {

        $unique_id = $_GET["unique_id"];
        $where = [
            "unique_id" => $unique_id
        ];


        $table = "item_schedule";

        $columns = [
            "schedule_name",
            "schedule_short_name",
            "item_directory",
            "is_active"
        ];

        $table_details = [
            $table,
            $columns
        ];

        $result_values = $pdo->select($table_details, $where);

        if ($result_values->status) {

            $result_values = $result_values->data;

            $schedule_name = $result_values[0]["schedule_name"];
             $schedule_short_name = $result_values[0]["schedule_short_name"];
             $item_directory = $result_values[0]["item_directory"];
            $is_active = $result_values[0]["is_active"];
            $btn_text = "Update";
            $btn_action = "update";
        } else {
            $btn_text = "Error";
            $btn_action = "error";
            $is_btn_disable = "disabled='disabled'";
        }
    }
}

$active_status_options = active_status($is_active);

?>


<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Item Schedule</h4>
            </div>
            <div class="card-body">
                <form class="was-validated" autocomplete="off">
                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-xl-4">
                                    <div class="mb-3">
                                        <label class="form-label">Schedule Name</label>
                                        <input type="text" id="schedule_name" name="schedule_name"
                                            oninput="validateName(this)" class="form-control"
                                            value="<?php echo $schedule_name; ?>" required>
                                    </div>
                                </div><!-- end col -->
                                 <div class="col-xl-4">
                                    <div class="mb-3">
                                        <label class="form-label">Schedule Short Name</label>
                                        <input type="text" id="schedule_short_name" name="schedule_short_name"
                                            oninput="validateName(this)" class="form-control"
                                            value="<?php echo $schedule_short_name; ?>" required>
                                    </div>
                                </div><!-- end col -->
                                  <div class="col-xl-4">
                                    <div class="mb-3">
                                        <label class="form-label">Item Directory</label>
                                        <input type="text" id="item_directory" name="item_directory"
                                            oninput="validateName(this)" class="form-control"
                                            value="<?php echo $item_directory; ?>" required>
                                    </div>
                                </div><!-- end col -->
                                <div class="col-xl-4">
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
                    </div>
                </form>
            </div> <!-- end card-body -->
        </div> <!-- end card -->
    </div><!-- end col -->
</div>


<script>

    function validateName(input) {
        input.value = input.value.replace(/[^A-Za-z\s]/g, ''); // Remove special characters & numbers
    }
</script>
