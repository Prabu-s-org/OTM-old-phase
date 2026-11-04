<?php include 'function.php'; ?>

<?php

include '../../config/dbconfig.php';
include '../../inc/header.php';
include '../../inc/footer.php';

?>
<div class="row">
    <div class="card">
        <div class="card-body">
            <center>
                <h3>PENDING LIST</h3>
            </center>
        </div>
    </div>

</div>
<input type="hidden" id="team_mem" name ="team_mem">
<div class="row">
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="doc_pending_list_datatable" class="table table-bordered table-striped align-middle">
                    <thead>
                        <tr>
                            <th>Selection<br>(Select All)
                                <?php echo '<input type="checkbox"  id="select_all">' ?>
                            </th>
                            <th>S.No</th>
                            <th>PO NO</th>
                            <th>Customer</th>
                            <th>DC</th>
                            <th>Invoice</th>
                            <th>PO</th>
                            <th>DC</th>
                            <th>IR</th>
                            <th>Invoice</th>
                            <th>Comparison</th>
                            <th>A/C Team Verify Status</th>
                            <th>Approved by</th>

                        </tr>
                    </thead>
                    <tbody>
                        <tr>

                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-12 mt-3">
                <div class="form-group row ">
                    <div class="col-md-12" align="right">
                        <?php echo btn_cancel($btn_cancel); ?>
                        <button type="button" class="btn btn-primary waves-effect waves-light" id="approve_btn"
                            onclick="approve()">Approve</button>
                        <!-- <button type="button" class="btn btn-primary waves-effect waves-light" onclick="po_invoice_create()">Save</button> -->
                    </div>
                </div>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
    integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    document.getElementById('select_all').addEventListener('change', function () {
        const checkboxes = document.querySelectorAll('.myCheck');
        checkboxes.forEach(function (checkbox) {
            checkbox.checked = this.checked;
        }.bind(this));
    });
</script>
