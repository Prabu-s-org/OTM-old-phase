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

if (!empty($_GET["unique_id"])) {

    $uni_dec = str_replace(" ", "+", $_GET['unique_id']);
    // $get_uni_id = openssl_decrypt(base64_decode($uni_dec), $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv);

    $unique_id = $uni_dec;

    $where = [
        "unique_id" => $unique_id
    ];

    $table = "executive_name";
    $tableuser = "user";

    $columns = [
        "executive_name",
        "is_active"
    ];

    $usercolumns = [
        "user_name",
        "email_id",
        "mobile_no"
    ];

    $table_details = [$table, $columns];
    $table_details_user = [$tableuser, $usercolumns];

    $result_values = $pdo->select($table_details, $where);
    $result_user = $pdo->select($table_details_user, $where);

    // ----- USER DETAILS -----
    if ($result_user->status && !empty($result_user->data)) {

        $user_data = $result_user->data;

        $user_name = $user_data[0]["user_name"] ?? '';
        $email_id  = $user_data[0]["email_id"] ?? '';
        $mobile_no = $user_data[0]["mobile_no"] ?? '';
    }

    // ----- EXECUTIVE DETAILS -----
    if ($result_values->status && !empty($result_values->data)) {

        $result_data = $result_values->data;

        $executive_name = $result_data[0]["executive_name"] ?? '';
        $is_active      = $result_data[0]["is_active"] ?? '';

        $btn_text = "Update";
        $btn_action = "update";

    } else {

        $btn_text = "Error";
        $btn_action = "error";
        $is_btn_disable = "disabled='disabled'";
    }
}

// $under_user_type_options = under_user_type($user_type);
// $under_user_type_options = select_option($under_user_type_options, "Select Staff", $exp_under_user_type);


$active_status_options = active_status($is_active);

?>


<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Executive Creation</h4>
            </div>
            <div class="card-body">
                <form class="was-validated" autocomplete="off">
                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">Executive Name</label>
                                        <input type="text" id="executive_name" name="executive_name"
                                            oninput="validateName(this)" class="form-control"
                                            value="<?php echo $executive_name; ?>" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="inputEmail3" class="form-label">Email Id</label>
                                        <input type="mail" id="email_id" name="email_id" class="form-control"
                                            pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" oninput="mail_valid(this)"
                                            value="<?php echo $email_id; ?>" required>
                                    </div>
                                  
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>

                                        <div class="input-group">
                                            <input type="text" id="password" name="password" class="form-control"
                                                pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[~!@#$%^&*()_+.])[A-Za-z\d~!@#$%^&*()_+.]{8,}$"
                                                value="<?php echo $password; ?>" minlength="8" required> <br>

                                            <button type="button" id="button" class="btn btn-primary"
                                                onclick="generatePassword()">
                                                Generate
                                            </button>
                                        </div>

                                        <span id="StrengthDisp" class="badge displayBadge" style="color:red">
                                            Password must at least be 8 characters, one uppercase, one lowercase and one
                                            special character
                                        </span>
                                    </div>
                                   

                                    <div class="col-xl-6">
                                        <div class="mb-3">
                                            <label for="cleave-delimiter" class="form-label">Active Status</label>
                                            <select name="is_active" id="is_active" class="select2 form-control"
                                                required>
                                                <?php echo $active_status_options; ?>
                                            </select>
                                        </div>
                                    </div><!-- end col -->
                                </div>
                                <div class="col-xl-6"><div class="mb-3">
                                        <label for="inputEmail3" class="form-label">Mobile No.</label>
                                        <input type="text" id="mobile_no" name="mobile_no" class="form-control"
                                            onkeypress="number_only(event);" minlength="10" maxlength="10"
                                            value="<?php echo $mobile_no; ?>" required>
                                    </div>
                                
                                  <div class="mb-3">
                                        <label for="inputEmail3" class="form-label">User Name</label>
                                        <input type="text" id="user_name" name="user_name" class="form-control"
                                            oninput="validateNameNum(this)" value="<?php echo $user_name; ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="inputEmail3" class="form-label">Confirm Password</label>
                                        <input type="password" id="confirm_password" name="confirm_password"
                                            class="form-control"  value="<?php echo $password; ?>" required>
                                    </div>
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

function validateNum(input) {
    input.value = input.value.replace(/[^0-9\s]/g, ''); // Allow letters, numbers, and spaces
}

function validateNameNum(input) {
    input.value = input.value.replace(/[^A-Za-z0-9\s]/g, ''); // Allow letters, numbers, and spaces
}

function validateAddress(input) {
    input.value = input.value.replace(/[^A-Za-z0-9-,./ \s]/g, ''); // Allow letters, numbers, and spaces
}


function mail_valid(input) {

const allowedChars = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9',
 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
  ' ', '_', '.','@'];

// Filter out characters that are not in the allowedChars array
input.value = input.value.split('').filter(char => allowedChars.includes(char)).join('');
}

    function generatePassword() {
        // Define variables containing possible characters for each type of requirement
        const uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        const lowercase = 'abcdefghijklmnopqrstuvwxyz';
        const numbers = '0123456789';
        const special = '~!@#$%^&*()_+.';

        // Initialize variables for the password and each requirement
        let password = '';
        let upperCount = 0;
        let lowerCount = 0;
        let numberCount = 0;
        let specialCount = 0;

        // Generate password by selecting characters from each requirement until all requirements are met
        while (upperCount < 3 || lowerCount < 3 || numberCount < 2 || specialCount < 2) {
            let randomChar = '';
            if (upperCount < 3) {
                randomChar = uppercase[Math.floor(Math.random() * uppercase.length)];
                upperCount++;
            } else if (lowerCount < 3) {
                randomChar = lowercase[Math.floor(Math.random() * lowercase.length)];
                lowerCount++;
            } else if (numberCount < 2) {
                randomChar = numbers[Math.floor(Math.random() * numbers.length)];
                numberCount++;
            } else if (specialCount < 2) {
                randomChar = special[Math.floor(Math.random() * special.length)];
                specialCount++;
            }
            password += randomChar;
        }

        // Display generated password in the textbox
        document.getElementById('password').value = password;
    }
</script>
