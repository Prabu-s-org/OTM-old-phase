<!-- This file Only PHP Functions -->
<?php
require_once __DIR__ . '/../../config/env.php';
include 'function.php'; ?>

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


        $table = "city_creation";

        $columns = [
            "district_name",
            "state_name",
            "city_name",
            "is_active"
        ];

        $table_details = [
            $table,
            $columns
        ];

        $result_values = $pdo->select($table_details, $where);

        if ($result_values->status) {

            $result_values = $result_values->data;

            $district_name = $result_values[0]["district_name"];
            $state_name = $result_values[0]["state_name"];
            $city_name = $result_values[0]["city_name"];
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



$active_status_options = active_status($is_active);

$pdo = new PDO("mysql:host=localhost;dbname=operation_team_beta", project_env('APP_DB_USERNAME', 'root'), project_env('APP_DB_PASSWORD'));
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Handle Form Submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['district_name'])) {
        $selectedValues = $_POST['district_name']; // Get selected values as an array
        $storedValue = implode(",", $selectedValues); // Convert array to comma-separated string

        // Store in database (Adjust table/column as needed)
        $stmt = $pdo->prepare("INSERT INTO district_data (districts) VALUES (:districts)");
        $stmt->bindParam(':districts', $storedValue);
        $stmt->execute();

        // Store message to display after refresh
        $message = "Data stored successfully: " . $storedValue;
    } else {
        $message = "No values selected!";
    }
}
?>


<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">City Creation</h4>
            </div>
            <div class="card-body">
                <form class="was-validated" autocomplete="off">
                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label class="form-label">State Name</label>
                                        <select name="state_name" id="state_name" class="select2 form-control" required>
                                            <?php
echo $state_type_options; ?>
                                        </select>
                                    </div>
                                </div><!-- end col -->
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label class="form-label">District Name</label>
                                        <select name="district_name" id="district_name" class="select2 form-control"
                                            required>

                                            <?php
echo $district_type_options; ?>
                                        </select>
                                    </div>
                                </div><!-- end col -->
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label class="form-label">City Name</label>
                                        <input type="text" id="city_name" name="city_name" oninput="validateName(this)"
                                            class="form-control" value="<?php
echo $city_name; ?>" required>

                                    </div>
                                </div><!-- end col -->
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label class="form-label">Active Status</label>
                                        <select name="is_active" id="is_active" class="select2 form-control" required>
                                            <?php
echo $active_status_options; ?>
                                        </select>
                                    </div>
                                </div><!-- end col -->
                            </div>
                            <div class="form-group row ">
                                <div class="col-md-12" align="right">
                                    <!-- Cancel,save and update Buttons -->
                                    <?php
echo btn_cancel($btn_cancel); ?>
                                    <?php
echo btn_createupdate($folder_name_org, $unique_id, $btn_text); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div> <!-- end card-body -->
        </div> <!-- end card -->
    </div><!-- end col -->
</div>

<script src='https://code.jquery.com/jquery-3.6.1.min.js'></script>

<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

<script>

    $(document).ready(function () {
        // Initialize Select2 with placeholder
        $('#district_data').select2({
            placeholder: "Select Districts",
            allowClear: true
        });

        // On button click, get selected values and display as tags
        $("#getSelectedValues").click(function () {
            let selectedValues = $("#district_data").val();
            let selectedTexts = $("#district_data option:selected").map(function () {
                return $(this).text();
            }).get();

            // Clear the display div and add selected items as tags
            let displayDiv = $("#selectedValues").html("");
            selectedTexts.forEach(function (text) {
                displayDiv.append(`<span class="tag">${text}</span>`);
            });
        });
    });


    $('#state_name').on('change', function () {

        var state_name = $('#state_name').val();
        var data = "&state_name=" + state_name + "&action=district_type_option";

        var ajax_url = sessionStorage.getItem("folder_crud_link");
        $.ajax({
            type: "POST",
            url: ajax_url,
            data: data,
            success: function (data) {
                if (data) {
                    $("#district_name").html(data);
                }
            }
        });

    });


    function validateName(input) {
        // alert('test');
        input.value = input.value.replace(/[^A-Za-z\s]/g, ''); // Remove special characters & numbers
    }

</script>


