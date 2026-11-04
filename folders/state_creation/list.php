<style>
    i.fa.fa-edit {
        font-size: 20px;
        color: green;
    }

    i.fa-sharp.fa-solid.fa-trash {
        font-size: 20px;
        color: green;
    }

    /* Example styles for the modal */
    /* Custom Styles for the Modal */
    #columnVisibilityModal .modal-dialog {
        max-width: 600px;
        /* Limit modal width */
    }

    #columnVisibilityModal .modal-body {
        padding: 20px 30px;
        /* Add some padding to the body */
    }

    #columnVisibilityModal .modal-header {
        background-color: #f8f9fa;
        /* Light background for the header */
        border-bottom: 1px solid #dee2e6;
        /* Subtle border */
    }

    #columnVisibilityModal .modal-footer {
        background-color: #f8f9fa;
        /* Light background for the footer */
        border-top: 1px solid #dee2e6;
        /* Subtle border */
    }

    /* Style for Checkboxes */
    #columnVisibilityForm .form-check {
        margin-bottom: 10px;
    }

    /* Style for Checkboxes inside a row */
    #columnVisibilityForm .form-check-label {
        font-size: 1rem;
    }

    #columnVisibilityForm .form-check-input {
        margin-top: 5px;
    }

    /* Responsive Design: Stack checkboxes on smaller screens */
    @media (max-width: 576px) {
        #columnVisibilityForm .form-check {
            margin-bottom: 15px;
        }
    }
</style>

<?php
$screen_id_val = '62b586e034f9963400';
session_start();
$user_type_unique_id = $_SESSION['user_type_unique_id'];
?>
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">List State Creation</h4>
            <input type="hidden" id="screen_id_val" name="screen_id_val" class="form-control"
                value="<?php echo $screen_id_val; ?>">
            <input type="hidden" id="user_type_unique_id" name="user_type_unique_id" class="form-control"
                value="<?php echo $user_type_unique_id; ?>">

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Admin</a></li>
                    <li class="breadcrumb-item active">State Creation</li>
                </ol>
            </div>

        </div>
    </div>
</div>


<!-- end page title -->
<div class="row">
    <div class="col-7">
    </div>
    <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-3">
        <?php echo btn_add($btn_add); ?>
    </div>
</div>

<!----content start---------->

<div class="row" id="list">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="state_creation_datatable" class="table table-bordered nowrap table-striped align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>State Name </th>
                                <th>Short Name </th>
                                <th>Active Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </diV>
            </div>
        </div>
    </div>
</div>
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
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Column Visibility Modal -->
<div id="columnVisibilityModal1" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg"> <!-- Center the modal and make it large -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Select Columns to Display</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="columnVisibilityForm1">
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

<!----content ends---------->
<script>
    $(document).ready(function () {

        get_user_permission();
    });
</script>
