<!-- This file Only PHP Functions -->
<?php include 'function.php'; ?>

<?php
include '../../config/dbconfig.php';
include '../../inc/header.php'; 
include '../../inc/footer.php';
?>


<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">BG Update Form</h4>
            </div>
            <div class="card-body">
                <form class="was-validated" autocomplete="off">
                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">S.No</label>
                                        <input type="text" id="sno" name="sno" class="form-control"  required>
                                    </div>
                                </div><!-- end col -->
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">Po_No</label>
                                        <input type="text" id="pono" name="pono" class="form-control"  required>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">Po_Date</label>
                                        <input type="text" id="podate" name="podate" class="form-control"  required>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">Consignee</label>
                                        <input type="text" id="podate" name="podate" class="form-control"  required>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">Location</label>
                                        <input type="text" id="podate" name="podate" class="form-control"  required>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">Invoice_No</label>
                                        <input type="text" id="podate" name="podate" class="form-control"  required>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">Invoice_Date</label>
                                        <input type="text" id="podate" name="podate" class="form-control"  required>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">Primary Product as per BG</label>
                                        <input type="text" id="podate" name="podate" class="form-control"  required>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">Quantity as per Invoice</label>
                                        <input type="text" id="podate" name="podate" class="form-control"  required>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">Invoice Value</label>
                                        <input type="text" id="podate" name="podate" class="form-control"  required>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">BG Month</label>
                                        <input type="text" id="podate" name="podate" class="form-control"  required>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">Tick</label>
                                        <input type="checkbox" name="select" class="form-control"  required>
                                    </div>
                                </div>
                               <!-- end col -->
                            </div>
                         
                        </div>
                </form>

            </div> <!-- end card-body -->
        </div> <!-- end card -->
    </div><!-- end col -->
</div>
