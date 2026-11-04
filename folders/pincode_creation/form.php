<!-- This file Only PHP Functions -->
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

if (isset($_GET["unique_id"])) {
    if (!empty($_GET["unique_id"])) {


        $unique_id = $_GET["unique_id"];
        $where = [
            "unique_id" => $unique_id
        ];


        $table = "pincode_creation";

        $columns = [
            "state_name",
            "district_name",
            "city_name",
            "pincode",
            "is_active"
        ];

        $table_details = [
            $table,
            $columns
        ];

        $result_values = $pdo->select($table_details, $where);

        if ($result_values->status) {

            $result_values = $result_values->data;

            $state_name = $result_values[0]["state_name"];
            $district_name = $result_values[0]["district_name"];
            $city_name = $result_values[0]["city_name"];
            $pincode = $result_values[0]["pincode"];
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

$state_type_options = state_option();
$state_type_options = select_option($state_type_options, "Select State", $state_name);

$district_type_options = district_option();
$district_type_options = select_option($district_type_options, "Select District", $district_name);

$city_type_options = city_option();
$city_type_options = select_option($city_type_options, "Select City", $city_name);


$active_status_options = active_status($is_active);

?>


<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Pincode Creation</h4>
            </div>
            <div class="card-body">
                <form class="was-validated" autocomplete="off">
                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label class="form-label">State Name</label>
                                        <select name="state_name" id="state_name" class="select2 form-control" onchange="get_district()"  required>
                                            <?php echo $state_type_options; ?>
                                        </select>
                                    </div>
                                </div><!-- end col -->
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label class="form-label">District Name</label>
                                        <select name="district_name" id="district_name" onchange="get_city()" class="select2 form-control"
                                            required>

                                            <?php echo $district_type_options; ?>
                                        </select>
                                    </div>
                                </div><!-- end col -->
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label class="form-label">City Name</label>
                                        <select name="city_name" id="city_name" class="select2 form-control" required>
                                            <?php echo $city_type_options; ?>
                                        </select>
                                    </div>
                                </div><!-- end col -->
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label class="form-label">Pincode</label>
                                        <input type="text" id="pincode" name="pincode" maxlength="6"
                                            class="form-control" value="<?php echo $pincode; ?>" required>
                                    </div>
                                </div><!-- end col -->
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label class="form-label">Active Status</label>
                                        <select name="is_active" id="is_active" class="select2 form-control" required>
                                            <?php echo $active_status_options; ?>
                                        </select>
                                    </div>
                                </div><!-- end col -->
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


<script src='https://code.jquery.com/jquery-3.6.1.min.js'></script>

<!-- DataTables core -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<!-- Optional extensions if used -->
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

<script src="assets/js/common.js"></script>

<script>
    


        function get_district(){

        var state_name = $('#state_name').val();
        var data = "&state_name=" + state_name + "&action=district_type_option";

        var ajax_url = sessionStorage.getItem("folder_crud_link");
        $.ajax({
            type: "POST",
            url: ajax_url,
            data: data,
            success: function (data) {
                if (data) {
                    // alert(data);
                    $("#district_name").html(data);
                }
            }
        });

        }

       

   function get_city(){

 var district_name = $('#district_name').val();
        var data = "&district_name=" + district_name + "&action=city_type_option";

        var ajax_url = sessionStorage.getItem("folder_crud_link");
        $.ajax({
            type: "POST",
            url: ajax_url,
            data: data,
            success: function (data) {
                if (data) {
                    $("#city_name").html(data);
                }
            }
        });
   }


   


    document.getElementById('pincode').addEventListener('input', function (event) {
        const pincodeInput = event.target.value;


        const numericValue = pincodeInput.replace(/\D/g, '');


        const sanitizedValue = numericValue.slice(0, 6);

        event.target.value = sanitizedValue;
    });

</script>
