<style>
    i.fa.fa-edit {
        font-size: 20px;
        color: green;
    }

    i.fa-sharp.fa-solid.fa-trash {
        font-size: 20px;
        color: green;
    }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<?php
$screen_id_val = '62b58736229a333128';
session_start();
$user_type_unique_id = $_SESSION['user_type_unique_id'];
?>
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">List District Creation</h4>
            <input type="hidden" id="screen_id_val" name="screen_id_val" class="form-control"
                value="<?php echo $screen_id_val; ?>">
            <input type="hidden" id="user_type_unique_id" name="user_type_unique_id" class="form-control"
                value="<?php echo $user_type_unique_id; ?>">

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Admin</a></li>
                    <li class="breadcrumb-item active">District Creation</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<!-- end page title -->
<div class="row">
    <div class="col-7">

    </div>

    <a href="javascript:excel_popup()">
        <button type="button" id="export1" name="export1"
            class="btn btn-primary  waves-effect waves-light wavw mb-1 mt-1"><i class="ri-file-excel-2-fill"></i>
            &nbsp;Import </button></a>

    <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-3" id="add_btn">
        <?php echo btn_add($btn_add); ?>
    </div>
</div>
<!----content start---------->
<div class="row" id="list">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="district_creation_datatable"
                        class="table table-bordered nowrap table-striped align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>State Name</th>
                                <th>District Name</th>
                                <th>Active Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!----content start---------->


<!-- Column Visibility Modal -->
<div id="columnVisibilityModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg"> <!-- Center the modal and make it large -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Select Columns to Display</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="columnVisibilityForm">
                    <!-- Dynamically populated checkboxes will go here -->
                    <div class="row">
                        <!-- Each column will have a checkbox -->
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveColumnVisibility">Save Changes</button>
            </div>
        </div>
    </div>
</div>




<div id="consignee_excel_import" style="position: absolute;" class="modal nobackdrop" tabindex="-1" role="dialog"
    aria-labelledby="fullWidthModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-full-width">
        <div class="modal-content" style="width: 135%;height: 290px;margin-left: -156px;">
            <div class="modal-header">
                <h4 class="modal-title" id="fullWidthModalLabel">District Creation Import</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-12">
                        <div class="form-group row ">
                            <div class="col-6">
                                <label class="">Choose Excel File To Import</label>
                                <input type="file" name="file" id="file" class='form-control' accept=".xls,.xlsx"><br />

                            </div>
                            <div class="col-md-4 align-self-center">
                                <button type="submit" id="con_import_data" name="con_import_data"
                                    class="btn btn-icon icon-left btn-primary" style="width:100px"><i
                                        class="fas fa-file-import"></i>IMPORT </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <a href="javascript:modal_close()"><button type="button" class="btn btn-light"
                        data-bs-dismiss="modal">Close</button></a>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>
<script>

    $(document).ready(function () {
        get_user_permission();
    });

    function excel_popup() {
        $("#consignee_excel_import").modal("show");
    }

    function modal_close() {
        $("#consignee_excel_import").modal("hide");
    }

    $("#con_import_data").click(function () {
        var file = document.getElementById('file').files.length;

        if (file === 0) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Please select a file to upload.'
            });
            return;
        }

        var data = new FormData();
        var image_s = document.getElementById("file");
        if (image_s.files.length > 0) {
            data.append("file", image_s.files[0]); // single file
        }

        $.ajax({
            type: "POST",
            url: 'folders/district_creation/district_import.php',
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            success: function (res) {
                console.log("Server response:", res);
                let response;
                try {
                    response = JSON.parse(res);
                } catch (e) {
                    console.error("JSON Parse Error:", e);
                    Swal.fire({
                        icon: 'error',
                        title: 'Unexpected Error',
                        text: 'Unexpected server response. Please contact support.'
                    });
                    return;
                }

                if (response.status === "error") {
                    let errorMessage = response.message;

                    Swal.fire({
                        icon: 'error',
                        title: 'Upload Failed',
                        text: errorMessage
                    });
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: 'Upload Successful!',
                        text: 'All records have been uploaded successfully.'
                    });
                    modal_close(); // Close the modal if applicable
                }
                document.getElementById('file').value = ''; // Reset the file input
            },
            error: function (xhr, status, error) {
                console.error("Upload failed:", error);
                Swal.fire({
                    icon: 'error',
                    title: 'Upload Failed',
                    text: 'An error occurred while uploading the file. Please try again.'
                });
            }
        });
    });

    function get_user_permission() {
        var screen_id_val = $('#screen_id_val').val();

        var user_type_unique_id = $('#user_type_unique_id').val();

        var data = {
            "screen_id_val": screen_id_val,
            "user_type_unique_id": user_type_unique_id,
            "action": 'user_permission',
        };

        var ajax_url = sessionStorage.getItem("folder_crud_link");
        var url = sessionStorage.getItem("list_link");

        console.log(data);
        $.ajax({
            type: "POST",
            url: ajax_url,
            data: data,
            success: function (data) {

                var obj = JSON.parse(data);

                var dataString = obj.data;

                console.log(dataString);

                var addButton = document.getElementById('add_btn');

                if (dataString.includes('5f8807ff00bf726601')) {
                    addButton.style.visibility = 'visible';  // Show the button
                } else {
                    addButton.style.visibility = 'hidden';   // Hide the button but keep its space
                }
                var listpage = document.getElementById('list');
                if (dataString.includes('5f88083fd50a344823')) {
                    listpage.style.visibility = 'visible';  // Show the button
                } else {
                    listpage.style.visibility = 'hidden';   // Hide the button but keep its space
                }


            },
            error: function (data) {
                alert("Network Error");
            }
        });
    }

</script>
