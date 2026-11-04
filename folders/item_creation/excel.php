<!-- Full width modal content -->
<div id="excel_import_export" style="position: absolute;" class="modal nobackdrop" tabindex="-1" role="dialog" aria-labelledby="fullWidthModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-full-width">
        <div class="modal-content" style="width: 135%;height: 290px;margin-left: -156px;">
            <div class="modal-header">
                <h4 class="modal-title" id="fullWidthModalLabel">Ticket Creation Import</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="was-validated" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group row ">
                                <div class="col-md-6">
                                    <label class="">Choose Excel File To Import</label> 
                                    <input type="file" name="test_file" id="test_file" class='form-control' accept=".xls,.xlsx"><br />
                                    
                                </div>
                                <div class="col-md-6 align-self-center">
                                    <button type="button" id="main_import" name="main_import" class="btn btn-icon icon-left btn-primary" style="width:100px"><i class="fas fa-file-import"></i>IMPORT </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <a href="javascript:modal_close()"><button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button></a>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    // Ensure the file input works and send data correctly
    $("#main_import").click(function (event) {
        event.preventDefault(); // Prevent form submission

        // Get the file input element and check the selected files
        var file = document.getElementById('test_file').files.length;
        // var tender_stored_code = document.getElementById('tender_stored_code').value;
        // alert(tender_stored_code);
        // var fileInput = document.getElementById('file');
        // var files = fileInput.files;

        // console.log("Files selected: ", files);  // Log the files selected

        // Check if a file is selected
       

        if (file === 0) {
        alert("Please select a file to upload.");
        return;
    }

    var data = new FormData();
    var image_s = document.getElementById("test_file");
    if (image_s.files.length > 0) {
        data.append("file", image_s.files[0]); // single file
    }

        // Send the file to the server using AJAX
        $.ajax({
            type: "POST",
            url: 'folders/item_creation/myimport.php', // Update this URL based on your actual file
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            success: function (response) {
                console.log("Server response:", response);
                var modal = document.getElementById("excel_import_export");
                modal.style.display = "none";
                window.location.reload();
                alert("File uploaded and data processed successfully.");
               
            },
            error: function (xhr, status, error) {
                console.error("Error uploading file:", error);
                alert("There was an error uploading the file. Please try again.");
            }
        });
    });
</script>

