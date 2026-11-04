<style>
    i.fa.fa-edit {
        font-size: 20px;
        color: green;
    }

    i.fa-sharp.fa-solid.fa-trash {
        font-size: 20px;
        color: green;
    }

    button#export {
        float: right;
        padding: 5px 10px;
    }

    table.dataTable.nowrap td {
        white-space: unset;
    }

    span.po_date {
        white-space: nowrap;
    }

    span.invoice_date {
        white-space: nowrap;
    }

    #lbs {
        font-size: 16px;
        font-weight: bold;
    }

    .spans {
        color: #1a7db7;
        font-size: 13px;
        font-weight: unset;
    }

    #po_no_datatable {
        border: 1px solid black;
        /* Bold black border for the table */
    }

    #po_no_datatable th,
    #po_no_datatable td {
        border: 1px solid black;
        /* Bold black border for table cells */
    }

    #po_no_datatable thead th {
        background-color: #f8f9fa;
        /* Optional: Light background for header */
    }


    /* Ensure the table's borders collapse properly */
    #po_no_datatable {
        border-collapse: collapse;
    }

    #invoice_datatable {
        border: 1px solid black;
        /* Bold black border for the table */
    }

    #invoice_datatable th,
    #invoice_datatable td {
        border: 1px solid black;
        /* Bold black border for table cells */
    }

    #invoice_datatable thead th {
        background-color: #f8f9fa;
        /* Optional: Light background for header */
    }



    .spinner {
        border: 6px solid #f3f3f3;
        border-top: 6px solid #3498db;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        margin: auto;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    .file-card {
        height: 90px;
        /* Adjusted height for vertical content */
        border-radius: 8px;
        /* Optional: Adds rounded corners */
    }

    .file-card .card-body {
        display: flex;
        flex-direction: column;
        /* Stacks items vertically */
        align-items: center;
        /* Centers items horizontally */
        padding: 8px;
        /* Padding inside the card */
    }

    .pdf-icon {
        font-size: 32px;
        /* Slightly larger icon for prominence */
        color: #dc3545;
    }

    .file-name {
        font-size: 0.75rem;
        /* Small font size for the filename */
        text-align: center;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        display: block;
        /* Ensures the ellipsis works correctly */
        max-width: 100%;
        /* Important for text truncation */
        margin-top: 4px;
        /* Space between icon and text */
    }

    .file-checkbox {
        margin-top: 4px;
        /* Space for checkbox at the top */
        margin-right: 94px;
        /* Space for checkbox at the top */
    }
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.3.0/exceljs.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">


<?php
//  $screen_id = isset($_GET['screen_id']) ? htmlspecialchars($_GET['screen_id']) : '';
$screen_id_val = '641ad5b47d02a30030';
// print_r($screen_id);
session_start();
$user_type_unique_id = $_SESSION['user_type_unique_id'];


$customer_name_options = department_creation_table();
$customer_name_options = select_option($customer_name_options, "Select Customer");

$po_no_options = list_of_po();
$po_no_options = select_option($po_no_options, "Select Po");

?>
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0"> PO Wise Document</h4>


            <input type="hidden" id="screen_id_val" name="screen_id_val" class="form-control"
                value="<?php echo $screen_id_val; ?>">
            <input type="hidden" id="user_type_unique_id" name="user_type_unique_id" class="form-control"
                value="<?php echo $user_type_unique_id; ?>">

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Reports</a></li>
                    <li class="breadcrumb-item active"> PO Wise Document</li>
                </ol>
            </div>

        </div>
    </div>
</div>


<!----content start---------->
<div class="col-xxl-12">
    <div class="card">
        <div class="card-body">

            <div class="row">

                <div class="col-3">

                    <label class="form-label">Customer Name</label>
                    <select class="select2 form-control" id="customer_name" name="customer_name"
                        onchange="get_po(this.value)">
                        <!-- <option value="">Select Customer Name</option> -->
                        <?php echo $customer_name_options; ?>
                    </select>
                </div>

                <div class="col-3">

                    <label class="form-label">PO No</label>
                    <select class="select2 form-control" id="po_num" name="po_num" onchange="getzone(); getstate();">
                        <?php echo $po_no_options; ?>
                    </select>
                </div>
                <div class="col-3">

                    <label class="form-label">Document Type</label>
                    <select class="select2 form-control" id="doc_type" name="doc_type">
                        <option value="unsigned_dc">Unsigned DC</option>
                        <option value="unsigned_ir">Unsigned IR</option>
                        <option value="inv">Invoice</option>
                        <option value="einvoice">E Invoice</option>
                        <option value="deliveryproof">Delivery Proof</option>
                        <option value="podproof">POD Proof</option>
                        <option value="signed_dc">Signed DC</option>
                        <option value="signed_ir">Signed IR</option>
                        <option value="signed_snr">Signed SNR</option>
                    </select>
                </div>
                <div class="col-3">

                    <label class="form-label">State</label>
                    <select class="select2 form-control" name="state_name" id="state_name" class="form-control"
                        onchange="get_district(this.value)">
                        <option value="">Select the State</option>
                    </select>
                </div>
                <div class="col-3 mt-2">
                    <label class="form-label">District</label>
                    <select class="select2 form-control" id="district" name="district" class="form-control">
                        <option value="">Select District</option>
                    </select>
                </div>
                <div class="col-3 mt-2">
                    <label class="form-label">Zone</label>
                    <select class="select2 form-control" name="zone" id="zone" class="form-control">
                        <?php echo $zone_options; ?>
                    </select>
                </div>
                <div class="col-2 mt-4">
                    <button type="button" name="go_filter" id="go_filter" onclick="fetchFileList()"
                        class="btn btn-primary mt-2">GO</button>
                </div>
                <div class="col-12 mt-3">
                    <h5>Available Files:</h5>
                    <div class="row align-items-center mb-2">

                        <div class="col-md-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="select_all">
                                <label class="form-check-label" for="select_all"> Select All </label>
                            </div>
                        </div>
                        <div class="col-md-3">
                        </div>
                        <div class="col-md-3">
                            <input type="text" id="file_search" class="form-control align-content-end"
                                placeholder="Search by file name...">
                        </div>
                    </div>
                    <div id="file_list_container" class="row"></div>
                    <button type="button" id="download_selected" class="btn btn-success mt-2">Download Selected</button>
                </div>


                <div id="file_list_container" class="row"></div>
            </div>
        </div><!-- end card-body -->
    </div><!-- end card -->
</div>

<!-- Include the XLSX library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>

<script>

    $(document).ready(function () {
        // Other event listeners and functions...

        // Event listener for the search bar
        $('#file_search').on('input', function () {
            const searchText = $(this).val().toLowerCase();

            // Loop through each file card
            $('#file_list_container .col-md-2').each(function () {
                const fileName = $(this).find('.file-name').text().toLowerCase();

                // Check if the file name includes the search text
                if (fileName.includes(searchText)) {
                    $(this).show(); // Show the card if it matches
                } else {
                    $(this).hide(); // Hide the card if it doesn't match
                }
            });
        });

        // Event listener for the "Select All" checkbox
        $('#select_all_files').on('change', function () {
            // Only toggle visible checkboxes
            $('#file_list_container .file-checkbox:visible').prop('checked', this.checked);
        });

        // Call fetchFileList() as needed elsewhere
        // ...
    });



    function get_po(value) {
        var customer = value;
        var po_num = $('#po_num').val();
        var ajax_url = sessionStorage.getItem("folder_crud_link");

        $.ajax({

            type: 'POST',
            url: ajax_url,
            data: {
                'customer': customer,
                'action': 'get_po_num'
            },

            success: function (data) {

                // var data = 
                $('#po_num').html(data);
            }

        });

    }


    function getstate(value) {
        var customer = value;
        var po_num = $('#po_num').val();
        var ajax_url = sessionStorage.getItem("folder_crud_link");
        $.ajax({

            type: 'POST',
            url: ajax_url,
            data: {
                'po_num': po_num,
                'action': 'get_state'
            },

            success: function (data) {

                // var data = 
                $('#state_name').html(data);
            }

        });
    }


    function getzone(value) {
        var customer = value;
        var po_num = $('#po_num').val();


        var ajax_url = sessionStorage.getItem("folder_crud_link");


        $.ajax({

            type: 'POST',
            url: ajax_url,
            data: {
                'po_num': po_num,
                'action': 'get_zone'
            },

            success: function (data) {

                // var data = 
                $('#zone').html(data);
            }

        });


    }

    $(document).on('change', '#select_all', function () {
        $('.file-checkbox').prop('checked', this.checked);
    });
    $(document).ready(function () {
        var state_name = document.getElementById('state_name').value;
        if (state_name != '') {
            get_district(state_name, district);
        }
    });



    function fetchFileList() {
        const id = $('#po_num').val();
        const doc_type = $('#doc_type').val();
        const state_name = $('#state_name').val();
        const district = $('#district').val();
        const zone = $('#zone').val();

        if (!id || !doc_type) {
            Swal.fire({
                icon: 'warning',
                title: 'Warning!',
                text: 'Please select PO number and document type'
            });
            return;
        }

        if (state_name && zone && district) {
            Swal.fire({
                icon: 'warning',
                title: 'Warning!',
                text: 'Select either State and District or Zone.'
            });
            return;
        }
        const container = $('#file_list_container'); // define once
        container.empty(); // clear container before AJAX

        $.ajax({
            url: 'folders/po_wise_document/fetch_files.php',
            type: 'POST',
            data: { id: id, doc_type: doc_type, state_name: state_name, district: district, zone: zone, list_only: true },
            dataType: 'json',
            success: function (response) {
                container.empty(); // clear previous list
                $('#available_files_count').remove();

                if (response.error) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Oops!',
                        text: response.error
                    });
                    return;
                }
                const fileCount = response.files ? response.files.length : 0;

                // Append count near "Available Files"
                $('.col-12.mt-3 h5').append(` <span id="available_files_count" class="badge bg-primary">${fileCount}</span>`);

                if (response.files && response.files.length > 0) {
                    response.files.forEach(function (file, index) {
                        const cardHtml = `
                     <div class="col-md-2 mb-3">
    <div class="card file-card">
        <div class="card-body d-flex flex-column align-items-center p-2">
            <input class="form-check-input mt-1 file-checkbox" type="checkbox" value="${file}" id="file_${index}">
            <i class="fa-solid  fa-file-pdf text-danger mt-2 pdf-icon"></i>
            <a href="#" class="file-name individual-download text-decoration-none text-truncate text-center mt-2" data-file="${file}">
                ${file}
            </a>
        </div>
    </div>
</div>
                    `;
                        container.append(cardHtml);
                    });
                } else {
                    container.append('<div class="col-12"><p>No files found for the selected criteria.</p></div>');
                }
            },
            error: function () {
                container.empty(); // clear container on AJAX error
                Swal.fire({
                    icon: 'warning',
                    title: 'Error',
                    text: 'Could not fetch file list.'
                });
            }
        });
    }

    $(document).on('click', '.individual-download', function (e) {
        e.preventDefault(); // prevent link default
        const fileName = $(this).data('file');
        const po_num = $('#po_num').val();
        const doc_type = $('#doc_type').val();

        // Create a temporary form to POST and download individual file
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = 'folders/po_wise_document/fetch_filesindu.php';

        form.appendChild(createHiddenInput('id', po_num));
        form.appendChild(createHiddenInput('doc_type', doc_type));
        form.appendChild(createHiddenInput('selected_files[]', fileName));

        document.body.appendChild(form);
        form.submit();
        document.body.removeChild(form);
    });

    // Helper to create hidden input
    function createHiddenInput(name, value) {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = name;
        input.value = value;
        return input;
    }



    // $('#download_selected').click(function () {
    //     var selectedFiles = [];
    //     $('.file-checkbox:checked').each(function () {
    //         selectedFiles.push($(this).val());
    //     });
    //     alert(selectedFiles);
    //     if (selectedFiles.length === 0) {
    //         Swal.fire({ icon: 'warning', title: 'Warning', text: 'Please select at least one file' });
    //         return;
    //     }

    //     var po_num = $('#po_num').val();
    //     var doc_type = $('#doc_type').val();

    //     // Create form to download ZIP
    //     let form = document.createElement('form');
    //     form.method = 'POST';
    //     form.action = 'folders/po_wise_document/fetch_files.php';

    //     // Add hidden inputs
    //     form.appendChild(createHiddenInput('id', po_num));
    //     form.appendChild(createHiddenInput('doc_type', doc_type));
    //     selectedFiles.forEach(file => {
    //         form.appendChild(createHiddenInput('selected_files[]', file));
    //     });

    //     document.body.appendChild(form);
    //     form.submit();
    //     document.body.removeChild(form);
    // });


    $('#download_selected').click(function () {

        let selectedFiles = [];
        $('.file-checkbox:checked').each(function () {
            selectedFiles.push($(this).val());
        });

        if (selectedFiles.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Warning',
                text: 'Please select at least one file'
            });
            return;
        }

        const CHUNK_SIZE = 1000;
        const po_num = $('#po_num').val();
        const doc_type = $('#doc_type').val();

        let part = 1;

        for (let i = 0; i < selectedFiles.length; i += CHUNK_SIZE) {

            const chunk = selectedFiles.slice(i, i + CHUNK_SIZE);
            const currentPart = part; // ✅ fix closure issue

            setTimeout(() => {
                submitZipChunk(chunk, po_num, doc_type, currentPart);
            }, currentPart * 1500); // ✅ more reliable delay

            part++;
        }


    });
    function submitZipChunk(files, po_num, doc_type, part) {

        let form = document.createElement('form');
        form.method = 'POST';
        form.action = 'folders/po_wise_document/fetch_files.php';
        form.target = '_blank';


        form.appendChild(createHiddenInput('id', po_num));
        form.appendChild(createHiddenInput('doc_type', doc_type));
        form.appendChild(createHiddenInput('zip_part', part));

        files.forEach(file => {
            form.appendChild(createHiddenInput('selected_files[]', file));
        });

        document.body.appendChild(form);
        form.submit();
        document.body.removeChild(form);
    }


    function get_district(state_id = "", district = "") {
        var ajax_url = sessionStorage.getItem("folder_crud_link");
        var po_num = $('#po_num').val();

        if (state_id == '' || state_id != '') {
            var data = {
                "state_id": state_id,
                "district": district,
                "po_num": po_num,

                "action": "get_state_name"
            }

            $.ajax({
                type: "POST",
                url: ajax_url,
                data: data,
                success: function (data) {

                    if (data) {
                        // alert(data);
                        $("#district").html(data);


                    }
                }
            });
        }
    }
</script>
