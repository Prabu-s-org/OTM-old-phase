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
                <h4 class="card-title mb-0">Docs Approval</h4>
            </div>
            <div class="card-body">
                <form class="was-validated" autocomplete="off">
                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">PO No</label>
                                        <input type="text" id="po_no" name="po_no" class="form-control" value="<?php echo 100; ?>" required>
                                    </div>
                                </div><!-- end col -->
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">PO Date</label>
                                        <input type="date" id="po_date" name="po_date" class="form-control" value="<?php echo 2023-10-23; ?>" required>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">Consignee</label>
                                        <!-- <input type="text" id="state_name" name="state_name" class="form-control" value="<?php echo 1; ?>" required> -->
                                        <select name="consignee" id="consignee" class="select2 form-control" required>
                                        <option value="select">select</option>
                                           <option value="Ocean Clothes">Ocean Clothes</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">Location</label>
                                        <input type="text" id="location" name="location" class="form-control" value="<?php echo 1; ?>" required>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">Invoice No</label>
                                        <input type="text" id="invoice_no" name="invoice_no" class="form-control" value="<?php echo 1; ?>" required>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">PO Attachment</label>
                                        <input type="text" id="po_attachment" name="po_attachment" class="form-control" value="<?php echo 1; ?>" required>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">DC/IR Attachment</label>
                                        <input type="text" id="dcir" name="dcir" class="form-control" value="<?php echo 1; ?>" required>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">Comparision Attachment</label>
                                        <input type="text" id="comparision" name="comparision" class="form-control" value="<?php echo 1; ?>" required>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">Approval</label>
                                        <select name="approval" id="approval" class="select2 form-control" required value="<?php echo Not_Approval; ?>">
                                        <option value="select">select</option>
                                           <option value="Apporval">Apporval</option>
                                           <option value="Not_Apporval">Not Apporval</option>

                                        </select>
                                    </div>
                                </div>
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
