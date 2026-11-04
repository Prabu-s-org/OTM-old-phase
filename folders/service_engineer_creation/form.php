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

        $unique_id  = $uni_dec;
        $where      = [
            "unique_id" => $unique_id
        ];


        $table      =  "engineer_name_creation";

        $columns    = [
            "engineer_name",
            "emp_id",
            "is_active"
        ];

        $table_details   = [
            $table,
            $columns
        ];

        $result_values  = $pdo->select($table_details, $where);

        if ($result_values->status) {

            $result_values      = $result_values->data;

            $emp_id    = $result_values[0]["emp_id"];
            $engineer_name = $result_values[0]["engineer_name"];
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

$emp_options              = user_id_name();
$emp_option               = select_option($emp_options,"Select EMP ID",$emp_id); 

$engineer_name_optionss   = usertype_engineer_name();
$engineer_name_option     = select_option($engineer_name_optionss, "Select Eng Name", $engineer_name);


$active_status_options    = active_status($is_active);

?>


<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Service Engineer Creation</h4>
            </div>
            <div class="card-body">
                <form class="was-validated" autocomplete="off">
                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">Engineer Name</label>
                                        <select name="engineer_name" id="engineer_name" class="select2 form-control" onchange="get_empid()"  aria-label="Default select example" >
                                       <?php echo  $engineer_name_option; ?>
                                        </select>
                                    </div>
                                </div><!-- end col -->
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">Employee ID</label>
                                        <select name="emp_id" id="emp_id"  class="select2 form-control" aria-label="Default select example">
                                            <!-- <?php echo $emp_option; ?> -->
                                        </select>
                                    </div>
                                </div><!-- end col -->
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label for="cleave-delimiter" class="form-label">Active Status</label>
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



$(document).ready(function(){
get_empid();
});

    function get_empid(){

       

 var engineer_name = $('#engineer_name').val();

        var data = "&engineer_name=" + engineer_name + "&action=emp_id";

        var ajax_url = sessionStorage.getItem("folder_crud_link");
        $.ajax({
            type: "POST",
            url: ajax_url,
            data: data,
            success: function (data) {
                if (data) {

                    // alert(data);
                    $("#emp_id").html(data);
                }
            }
        });
   }
</script>
