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


        $table = "department_creation";

        $columns = [
            "acc_sector",
            "department",
            "description",
            "ledger_name",
            "ledger_no",
            "is_active"
        ];

        $table_details = [
            $table,
            $columns
        ];

        $result_values = $pdo->select($table_details, $where);

        if ($result_values->status) {

            $result_values = $result_values->data;

            $acc_sector = $result_values[0]["acc_sector"];
            $department = $result_values[0]["department"];
            $description = $result_values[0]["description"];
            $ledger_name = $result_values[0]["ledger_name"];
            $ledger_no = $result_values[0]["ledger_no"];
            $empty = $unique_id;
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

if ($_GET["unique_id"] != '') {
    $unique_id = $_GET["unique_id"];
} else {
    $prefix = "";
    $unique_id = unique_id($prefix);

}


$active_status_options = active_status($is_active);



$account_sector_options = account_sector();
$account_sector_options = select_option($account_sector_options, "Select Account Sector", $acc_sector);

?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="..."
    crossorigin="anonymous">

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Customer Creation</h4>
            </div>
            <div class="card-body">
                <form class="was-validated" autocomplete="off">
                    <div class="row">
                        <div class="col-12">
                            <div class="row">

                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label class="form-label">Account Sector<span
                                                class="red-star">*</span></label><br>
                                        <select class="select form-control" name="acc_sector" id="acc_sector" required>
                                            <?php echo $account_sector_options; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label class="form-label">Customer </label>
                                        <input type="text" id="department" name="department" class="form-control"
                                            oninput="validateName(this)" value="<?php echo $department; ?>" required>

                                    </div>
                                </div><!-- end col -->
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label class="form-label">Description</label>

                                        <textarea name="description" oninput="validateNameNum(this)" id="description"
                                            value="<?php echo $description; ?>"
                                            class="form-control"><?php echo $description; ?></textarea>
                                    </div>
                                </div><!-- end col -->
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label class="form-label">Ledger Name</label>
                                        <input type="text" id="ledger_name" name="ledger_name" class="form-control"
                                            value="<?php echo $ledger_name; ?>" oninput="validateLedgerName(this)">

                                    </div>
                                </div><!-- end col -->
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label class="form-label">Ledger No</label>
                                        <input type="text" id="ledger_no" name="ledger_no"
                                            oninput="validateNameNum(this)" class="form-control"
                                            value="<?php echo $ledger_no; ?>" >
                                        <input type="hidden" id="sub_unique_id" name="sub_unique_id"
                                            class="form-control">
                                    </div>
                                </div><!-- end col -->
                                <input type="hidden" id="empty" name="empty" class="form-control"
                                    value="<?php echo $empty; ?>">

                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label class="form-label">Active Status</label>
                                        <select name="is_active" id="is_active" class="select2 form-control" required>
                                            <?php echo $active_status_options; ?>
                                        </select>
                                    </div>
                                </div><!-- end col -->
                                <input type="hidden" id="form_main_unique_id" name="form_main_unique_id" value="<?php if ($update_unique_id != '') {
                                    echo $update_unique_id;
                                } else {
                                    echo $unique_id;
                                } ?>">
                                <input type="hidden" id="demo" name="demo" value="<?php if ($update_unique_id != '') {
                                    echo $update_unique_id;
                                } else {
                                    echo $unique_id;
                                } ?>">

                                <input type="hidden" name="get_unique_id" id="get_unique_id"
                                    value="<?php echo $_GET['unique_id']; ?>">

                                <div class="col-xl-3 ">
                                    <div class="mb-3">
                                        <button type="button" id="pro_details"
                                            class="btn btn-success btn-label department_details_add_update_btn"
                                            onclick="department_details_add_update()"><i
                                                class="lab la as la-plus-circle label-icon align-middle fs-16 me-2"></i>
                                            Add New</button>

                                    </div>
                                </div><!-- end col -->
                                <input type="hidden" name="stored_item" id="stored_item">
                                <input type="hidden" name="count_item" id="count_item">


                            </div>
                            <div class="table-responsive mb-4">
                                <div id="department_details_datatable_wrapper"
                                    class="dataTables_wrapper dt-bootstrap5 no-footer">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6"></div>
                                        <div class="col-sm-12 col-md-6"></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <table id="department_details_datatable"
                                                class="table table-hover table-bordered align-middle mb-0 dataTable no-footer"
                                                width="50%" style="width: 50%;">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th class="sorting_disabled text-center" rowspan="1" colspan="1"
                                                            style="width: 0px;">
                                                            ID </th>
                                                        <th scope="col" class="sorting_disabled" style="width:  0px;">
                                                            Ledger Name</th>
                                                        <th scope="col" class="sorting_disabled" rowspan="1" colspan="1"
                                                            style="width: 0px;">
                                                            Ledger No</th>
                                                        <th scope="col" class="sorting_disabled text-center" rowspan="1"
                                                            colspan="1" style="width: 0px;">
                                                            Action </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    </form>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-5"></div>
                                        <div class="col-sm-12 col-md-7"></div>
                                    </div>
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
                

            </div> <!-- end card-body -->
        </div> <!-- end card -->
    </div><!-- end col -->
</div>
<script>
    
// function validateLedgerName(input) {
//     // Allow only letters, numbers, spaces, and / & ( ) -
//     input.value = input.value.replace(/[^a-zA-Z0-9\s\/&()\-\(\)]/g, '');
// }

function validateLedgerName(input) {
    // Allow only letters, numbers, spaces, / & ( ) - .
    input.value = input.value.replace(/[^a-zA-Z0-9\s\/&()\-.]/g, '');
}


    
    function validateLedgerName_old(input) {
    // Allow letters, numbers, spaces, and special characters
    input.value = input.value.replace(/[^a-zA-Z0-9\s\-\_@#\$%\^\&\*\(\)\+\=\!\?\.]/g, '');
}

    function validateLedgerName1(input) {
        // Regular expression to allow only letters, spaces, and special characters
        input.value = input.value.replace(/[^a-zA-Z\s\-\_@#\$%\^\&\*\(\)\+\=\!\?\.]/g, '');
    }

    $(document).ready(function () {
        sub_list_datatable("department_details_datatable");

    });


    function validateName(input) {
        input.value = input.value.replace(/[^A-Za-z\s]/g, ''); // Remove special characters & numbers
    }

    function validateNameNum(input) {
    // Allow only alphabets, numbers, and spaces
    input.value = input.value.replace(/[^A-Za-z0-9\s]/g, '');
}
//     function validateNameNum(input) {
//     // Allow only alphabets, numbers, and spaces
//     input.value = input.value.replace(/[^A-Za-z0-9 ]/g, '');
// }
    function validateNameNum1(input) {
        input.value = input.value.replace(/[^A-Za-z0-9\s]/g, ''); // Remove special characters & numbers
    }

    function sub_list_datatable(table_id = "", form_name = "", action = "") {
        var table_id = 'department_details_datatable';
        var form_main_unique_id = $("#demo").val();

        var table = $("#" + table_id);
        var data = {

            "action": 'department_details_datatable',
            "form_main_unique_id": form_main_unique_id
        };
        var ajax_url = sessionStorage.getItem("folder_crud_link");
        var datatable = table.DataTable({
            destroy: true,
            ordering: true,
            searching: true,
            "ajax": {
                url: ajax_url,
                type: "POST",
                data: data
            },

        });
    }

    function department_details_add_update(unique_id = "") {
        // alert(unique_id);
        var internet_status = is_online();
        var form_class = "department_creation_sublist";
        var is_form = form_validity_check(form_class);

        var department = document.getElementById('department').value;
        var description = document.getElementById('description').value;
        var ledger_name = document.getElementById('ledger_name').value;
        var ledger_no = document.getElementById('ledger_no').value;

        var form_main_unique_id = document.getElementById('form_main_unique_id').value;
        var sub_unique_id = document.getElementById('sub_unique_id').value;

        var data = "department=" + department + "&description=" + description + "&ledger_name=" + ledger_name + "&ledger_no=" + ledger_no +
            "&form_main_unique_id=" + form_main_unique_id;
        data += "&sub_unique_id=" + sub_unique_id + "&action=department_details_add_update";

        var ajax_url = sessionStorage.getItem("folder_crud_link");

        if (!ledger_name || !ledger_no) {

            Swal.fire({
                icon: 'info',
                text: 'Fill Out the Mandatory Fields',
                ShowConfirmButtontext: 'OK'
            });

            return;
        }

        $.ajax({
            type: "POST",
            url: ajax_url,
            data: data,
            beforeSend: function () {
                $(".department_details_add_update").attr("disabled", "disabled");
                $(".department_details_add_update").text("Loading...");
            },
            success: function (response) {
                var obj = JSON.parse(response);
                var msg = obj.msg;
                var status = obj.status;
                var error = obj.error;

                if (!status) {
                    $(".department_details_add_update").text("Error");
                } else {
                    // Only reset description, ledger name, and ledger number but keep department value
                    document.getElementById('ledger_name').value = '';
                    document.getElementById('ledger_no').value = '';
                     
                        $("#sub_unique_id").val('');

                    // Check if the message is to add or update
                    if (msg === "add") {
                        sweetalert("Department Added!");
                    } else if (msg === "update") {
                        sweetalert("Department Updated!");
                    }

                    //   sub_list_datatable("department_details_datatable");

                    // Reload the Datatable to reflect the new data
                    $('#department_details_datatable').DataTable().ajax.reload(null, false); // This refreshes the data without full page reload

                    // Reset the button state
                    $(".department_details_add_update").removeAttr("disabled");
                    $(".department_details_add_update").text("Add");
                }
            },
            error: function () {
                alert("Network Error");
                $(".department_details_add_update").removeAttr("disabled");
                $(".department_details_add_update").text("Add");
            }
        });
    }

    // get invoice update
    function get_department(unique_id = "") {
        var internet_status = is_online();
        if (!internet_status) {
            sweetalert("no_internet");
            return false;
        }
        var form_main_unique_id = document.getElementById('form_main_unique_id').value;
        var department = document.getElementById('department').value;
        var description = document.getElementById('description').value;
        var ledger_name = document.getElementById('ledger_name').value;
        var ledger_no = document.getElementById('ledger_no').value;

        var data = new FormData();
        data.append("form_main_unique_id", form_main_unique_id);

        data.append("department", department);
        data.append("description", description);
        data.append("ledger_name", ledger_name);
        data.append("ledger_no", ledger_no);


        data.append("action", "editupdate");
        var is_form = form_validity_check("was-validated");
        if (is_form) {
            var ajax_url = sessionStorage.getItem("folder_crud_link");
            var url = sessionStorage.getItem("list_link");
            $.ajax({
                type: "POST",
                url: ajax_url,
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                success: function (data) {
                    var obj = JSON.parse(data);
                    var msg = obj.msg;
                    var status = obj.status;
                    var error = obj.error;
                    if (!status) {
                        url = '';
                        $(".createupdate_btn").text("Error");
                        console.log(error);
                    } else {
                        if (msg == "already") {
                            // Button Change Attribute
                            url = '';
                            $(".createupdate_btn").removeAttr("disabled", "disabled");
                            if (unique_id) {
                                $(".createupdate_btn").text("Update");
                            }
                        }
                    }
                    sweetalert(msg, url);
                },
                error: function (data) {
                    alert("Network Error");
                }
            });
        }
    }

    function department_details_edit(unique_id = "") {

        // alert('edit');
        if (unique_id) {
            var data = "unique_id=" + unique_id + "&action=department_details_edit";

            var ajax_url = sessionStorage.getItem("folder_crud_link");
            var url = "";

            $.ajax({
                type: "POST",
                url: ajax_url,
                data: data,
                beforeSend: function () {
                    $(".department_details_add_update").attr("disabled", "disabled");
                    $(".department_details_add_update").text("Loading...");
                },
                success: function (data) {

                    var obj = JSON.parse(data);
                    var data = obj.data;
                    var msg = obj.msg;
                    var status = obj.status;
                    var error = obj.error;

                    if (!status) {
                        $(".department_details_add_update").text("Error");
                        console.log(error);
                    } else {
                        var ledger_name = data.ledger_name;

                        var ledger_no = data.ledger_no;
                        var unique_id = data.unique_id;

                        $("#ledger_name").val(ledger_name);

                        $("#ledger_no").val(ledger_no);
                        $("#sub_unique_id").val(unique_id);


                        // Button Change 
                        $(".department_details_add_update").removeAttr("disabled", "disabled");
                        $(".department_details_add_update").text("Update");
                        $(".department_details_add_update").attr("onclick", "department_details_add_update('" + unique_id + "')");
                    }
                },
                error: function (data) {
                    alert("Network Error");
                }
            });
        }
    }

    function department_details_delete(unique_id = "") {

        if (unique_id) {
            var ajax_url = sessionStorage.getItem("folder_crud_link");
            var url = sessionStorage.getItem("list_link");

            // Show confirmation dialog before deletion
            confirm_delete('delete').then((result) => {
                if (result.isConfirmed) {
                    // Data to be sent to the server via AJAX
                    var data = {
                        "unique_id": unique_id,
                        "action": "department_details_delete"
                    };

                    // Send AJAX request
                    $.ajax({
                        type: "POST",
                        url: ajax_url,
                        data: data,
                        success: function (response) {
                            // Parse the JSON response from the server
                            var obj = JSON.parse(response);
                            var msg = obj.msg;
                            var status = obj.status;
                            var error = obj.error;

                            if (status) {
                                // If delete was successful, refresh the data table
                                sub_list_datatable("department_details_datatable");
                            } else {
                                // Log the error for debugging purposes
                                console.log(error);
                            }

                            // Show a SweetAlert with the result (success or error)
                            sweetalert(msg, url);
                        }
                    });
                }
            });
        }
    }
</script>
