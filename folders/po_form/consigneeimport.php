
</div>


</div>

<!--</div>-->

<!--</div>-->

<!--</div>-->

<!--</div>-->

<div id="demossss"  style="position: absolute;" class="modal nobackdrop" tabindex="-1" role="dialog" aria-labelledby="fullWidthModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-full-width">
        <div class="modal-content" style="width: 135%;height: 290px;margin-left: -121px;
    margin-top: 167px;">
            <div class="modal-header">
                <h4 class="modal-title" id="fullWidthModalLabel">Consignee Product Details</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group row">

                            <!-- Hidden field for batch ID -->
                            <input type="hidden" name="modal_batch_id" id="modal_batch_id" />

                            <!-- Excel file input -->
                            <div class="col-md-6">
                                <label>Choose Excel File To Import</label>
                            <input type="file" name="files" id="files" class="form-control" accept=".xls,.xlsx">
                                
                            </div>

                            <!-- Import button -->
                            <div class="col-md-4 align-self-center mt-3 mt-md-0">
                                <button type="submit" id="import_con" name="import_con" class="btn btn-primary w-100" style="margin-top: 30px;">
                                    <i class="fas fa-file-import"></i> IMPORT
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light" onclick="import_close()">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('files').addEventListener('change', function () {
    const fileInput = this;
    const allowedExtensions = ['xls', 'xlsx', 'csv'];
    const fileName = fileInput.value;
    const fileExtension = fileName.split('.').pop().toLowerCase();

    if (!allowedExtensions.includes(fileExtension)) {
        alert("Invalid file type. Please upload only .xls, .xlsx, or .csv files.");
        fileInput.value = ""; // Reset the input
    }
});
</script>

