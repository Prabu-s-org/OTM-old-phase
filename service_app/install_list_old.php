<?php
include 'header.php';
?>
<style>
    .view-icon {
    display: inline-block !important;
    visibility: visible !important;
    color: blue !important;
    font-size: 20px;
}
#installation-container {
    max-height: 500px; /* Adjust height as needed */
    overflow-y: auto;
}
#status, #status * {
    color: green !important;
    font-weight: bold;
}


</style>
<body>
<div class="sub-hed">
    <div class="row">
        
    <div class="col-10 log-out">
    <h4 class="mb-sm-0"> Installation </h4>
    <div class="page-title-right">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item">
                <i class="bi bi-arrow-left" id="backButton" style="cursor: pointer;"></i>
            </li>
            <li class="breadcrumb-item"><a href="javascript: void(0);">Settings</a></li>
            <li class="breadcrumb-item active"> Installation </li>
        </ol>
    </div>
</div>
        <div class="col-2 log-out logout_style">
            <a href="index.php"><i class="fa fa-sign-out"></i></a>
        </div>
     </div>
    </div>
</div>
<div class="row mt-3">
   <div class="col-6 col-sm-6 col-md-6 col-lg-6 ">
      <a href="install_list.php"><button type="button"  style="float: right;" class="btn btn-primary active">Installation Followups</button></a>
   </div>
   <div class="col-6 col-sm-6 col-md-6 col-lg-6 ">
      <a href="install_list2.php"><button type="button" class="btn btn-primary" style=" ">DC and IR Document Dispatch Details</button></a>
   </div>
</div>
   <div class="card  m-3">
      <div class="card-body">
      <div id="installation-container">
         <div class="row mb-2">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 form-icons">
              
            <i class="bi bi-pen green edit-icon" data-unique_id="" data-invoice_no=""></i>

            <i class="bi bi-trash3 red"></i>
            <i class="bi bi-eye blue view-icon"></i>
            </div>
           
         </div>
         

         <div class="row mb-2">
    <div class="col-6 lable_name_style">
        <p>PO No.</p>
        <h6 id="po_num"></h6>
    </div>
    <div class="col-6 lable_name_style">
        <p>PO Date</p>
        <h6 id="po_date"></h6>
    </div>
</div>
<div class="row mb-2">
    <div class="col-6 lable_name_style">
        <p>Invoice No.</p>
        <h6 id="invoice_no"></h6>
    </div>
    <div class="col-6 lable_name_style">
        <p>Invoice Date</p>
        <h6 id="invoice_date"></h6>
    </div>
</div>
<div class="row mb-2">
    <div class="col-6 lable_name_style">
        <p>Department</p>
        <h6 id="department"></h6>
    </div>
    <div class="col-6 lable_name_style">
        <p>Address</p>
        <h6 id="address"></h6>
    </div>
</div>
<div class="row mb-2">
    <div class="col-6 lable_name_style">
        <p>Status</p>
        <h6 id="status"></h6>
    </div>
</div>
<div class="row mb-2 text-center">
    <div class="col-12 lable_name_style name_stl">
        <p>Engineer Name</p>
        <h6 id="engineer_name"></h6>
    </div>
</div>
<div class="row text-center bg-light p-2"style=" text-align:center;    bśackground-color: #efefef; padding: 11px 0px">
    <div class="col-4">
        <div class="pdf-item p-2">
            <div class="pdf-title">DC</div>
            <a id="dc_link" target="_blank">
                <i class="bi bi-file-earmark-pdf-fill pdf-icon"></i>
            </a>
        </div>
    </div>
    <div class="col-4">
        <div class="pdf-item p-2">
            <div class="pdf-title">IR</div>
            <a id="ir_link" target="_blank">
                <i class="bi bi-file-earmark-pdf-fill pdf-icon"></i>
            </a>
        </div>
    </div>
    <div class="col-4">
        <div class="pdf-item p-2">
            <div class="pdf-title">SNR</div>
            <a id="snr_link" target="_blank">
                <i class="bi bi-file-earmark-pdf-fill pdf-icon"></i>
            </a>
        </div>
    </div>
    </div>
</div>
<div id="pagination-controls" class="text-center mt-3">
    <button id="prev-page" class="btn btn-secondary">Previous</button>
    <span id="page-info"></span>
    <button id="next-page" class="btn btn-secondary">Next</button>
</div>
  
</div>
</div>
</div>
</div>
</div>
</div>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
 <script>
    document.getElementById("backButton").addEventListener("click", function() {
        window.location.href = "list.php"; // Redirects to list.php
    });


    let installationData = []; 
let currentPage = 1;
const recordsPerPage = 3; 

// Fetch installation data
function fetchInstallationData() {
    $.ajax({
        url: '../service_app/crud.php',
        type: 'POST',
        data: { action: 'fetchlist' },
        dataType: 'json',
        success: function (response) {
            console.log("AJAX Response:", response);

            if (response.status && response.data.length > 0) {
                installationData = response.data;
                currentPage = 1; 
                displayPage(currentPage);
            } else {
                $("#installation-container").html("<p class='text-center text-danger'>No data available.</p>");
            }
        },
        error: function (xhr) {
            console.error('AJAX Error:', xhr.responseText);
        }
    });
}
const statusMapping = {
    0: "Pending",
    1: "Processing",
    2: "Complete",
    3: "Rejected",
    4: "Eng Call Attn",
    5: "Partial Completed"
};
// Function to display paginated data
function displayPage(page) {
    let totalPages = Math.ceil(installationData.length / recordsPerPage);

    if (page < 1 || page > totalPages) {
        return;
    }

    let startIndex = (page - 1) * recordsPerPage;
    let endIndex = startIndex + recordsPerPage;
    let paginatedData = installationData.slice(startIndex, endIndex);

    // Clear the container before adding new records
    $("#installation-container").html("");

    paginatedData.forEach((record) => {
        let statusText = statusMapping[record.installation_status] || "Unknown";

        // Action Icons Logic
        let actionIcons = `<div class="col-12 form-icons">`;
        if (record.dc_file_name && record.ir_file_name) {
            actionIcons += `<i class='bi bi-eye blue view-icon' data-unique_id='${record.consignee_unique_id}' data-invoice_no='${record.invoice_no}'></i>`;
        } else {
            actionIcons += `<i class='bi bi-pen green edit-icon' data-unique_id='${record.consignee_unique_id}' data-invoice_no='${record.invoice_no}'></i>
                            <i class='bi bi-trash3 red delete-icon'></i>`;
        }
        actionIcons += `</div>`;

        let recordHTML = `
        <div class="row mb-2">${actionIcons}</div>
        <div class="row mb-2">
            <div class="col-6 lable_name_style">
                <p>PO No.</p>
                <h6>${record.po_num}</h6>
            </div>
            <div class="col-6 lable_name_style">
                <p>PO Date</p>
                <h6>${record.po_date}</h6>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-6 lable_name_style">
                <p>Invoice No.</p>
                <h6>${record.invoice_no}</h6>
            </div>
            <div class="col-6 lable_name_style">
                <p>Invoice Date</p>
                <h6>${record.invoice_date}</h6>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-6 lable_name_style">
                <p>Department</p>
                <h6>${record.con_district}</h6>
            </div>
            <div class="col-6 lable_name_style">
                <p>Address</p>
                <h6>${record.con_address}</h6>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-6 lable_name_style">
                <p>Status</p>
                <h6 style="color: green; font-weight: bold;">${statusText}</h6>
            </div>
        </div>
        <div class="row mb-2 text-center">
            <div class="col-12 lable_name_style name_stl">
                <p>Engineer Name</p>
                <h6>${record.engineer_name}</h6>
            </div>
        </div>`;

        // Adding File Links
        if (record.dc_file_name || record.ir_file_name) {
            recordHTML += `
            <div class="row text-center bg-light p-2">
                ${record.dc_file_name ? `
                <div class="col-4">
                    <div class="pdf-item p-2">
                        <div class="pdf-title">DC</div>
                        <a href="${record.dc_file_name}" target="_blank">
                            <i class="bi bi-file-earmark-pdf-fill pdf-icon"></i>
                        </a>
                    </div>
                </div>` : ''}
                
                ${record.ir_file_name ? `
                <div class="col-4">
                    <div class="pdf-item p-2">
                        <div class="pdf-title">IR</div>
                        <a href="${record.ir_file_name}" target="_blank">
                            <i class="bi bi-file-earmark-pdf-fill pdf-icon"></i>
                        </a>
                    </div>
                </div>` : ''}
            </div>`;
        }

        $("#installation-container").append(recordHTML);
    });

    updatePaginationControls(totalPages);
}

// Update Pagination Controls
function updatePaginationControls(totalPages) {
    $("#page-info").text(`Page ${currentPage} of ${totalPages}`);
    $("#prev-page").prop("disabled", currentPage === 1);
    $("#next-page").prop("disabled", currentPage === totalPages);
}

// Click Events for Pagination Buttons
$("#prev-page").click(function () {
    if (currentPage > 1) {
        currentPage--;
        displayPage(currentPage);
    }
});

$("#next-page").click(function () {
    let totalPages = Math.ceil(installationData.length / recordsPerPage);
    if (currentPage < totalPages) {
        currentPage++;
        displayPage(currentPage);
    }
});
$(document).on("click", ".edit-icon", function () {
    let uniqueId = $(this).data("unique_id");
    let invoiceNo = $(this).data("invoice_no");

    console.log("Edit Clicked - Unique ID:", uniqueId, "Invoice No:", invoiceNo); // Debugging

    if (uniqueId && invoiceNo) {
        window.location.href = `form.php?unique_id=${uniqueId}&invoice_no=${invoiceNo}`;
    } else {
        alert("Invalid data for editing!");
    }
});

$(document).on("click", ".view-icon", function () {
    let uniqueId = $(this).data("unique_id");
    let invoiceNo = $(this).data("invoice_no");

    console.log("Edit Clicked - Unique ID:", uniqueId, "Invoice No:", invoiceNo); // Debugging

    if (uniqueId && invoiceNo) {
        window.location.href = `view.php?unique_id=${uniqueId}&invoice_no=${invoiceNo}`;
    } else {
        alert("Invalid data for editing!");
    }
});

// Handle Delete Button Click
$(document).on("click", ".delete-icon", function () {
    let uniqueId = $(this).closest('.card').find(".edit-icon").data("unique_id");
    let invoiceNo = $(this).closest('.card').find(".edit-icon").data("invoice_no");

    if (!uniqueId || !invoiceNo) {
        alert("Invalid data for deletion!");
        return;
    }

    // Confirmation before deleting
    if (confirm("Are you sure you want to delete this record?")) {
        $.ajax({
            url: '../service_app/crud.php',
            type: 'POST',
            data: {
                action: 'delete_record',
                unique_id: uniqueId,
                invoice_no: invoiceNo
            },
            dataType: 'json',
            success: function (response) {
                if (response.status) {
                    alert("Record deleted successfully!");
                    fetchInstallationData(); // Refresh data after deletion
                } else {
                    alert("Failed to delete the record!");
                }
            },
            error: function (xhr) {
                console.error('AJAX Error:', xhr.responseText);
                alert("Error deleting record. Please try again.");
            }
        });
    }
});

// Fetch data on page load
fetchInstallationData();</script>
</body>
</html>

