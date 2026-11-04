<?php
include 'header.php';
?>

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

<div class="row mt-3">
    <div class="col-6">
        <a href="install_list.php">
            <button type="button" class="btn btn-primary" style="float: right;">Installation Followups</button>
        </a>
    </div>
    <div class="col-6">
        <a href="install_list2.php">
            <button type="button" class="btn btn-primary active">DC and IR Document Dispatch Details</button>
        </a>
    </div>
</div>

<div id="card-container" class="card-container"></div>

<div class="pagination-controls text-center mt-3">
    <button id="prev-page" class="btn btn-secondary">Previous</button>
    <span id="page-info" class="mx-2"></span>
    <button id="next-page" class="btn btn-secondary">Next</button>
</div>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

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

function fetchInstallationData() {
    $.ajax({
        url: '../service_app/crud.php',
        type: 'POST',
        data: { action: 'tab2list' },
        dataType: 'json',
        success: function (response) {
            console.log("AJAX Response:", response);
            if (response.status && response.data.length > 0) {
                installationData = response.data;
                currentPage = 1;
                displayPage(currentPage);
            } else {
                $("#card-container").html("<p class='text-center text-danger'>No data available.</p>");
            }
        },
        error: function (xhr) {
            console.error('AJAX Error:', xhr.responseText);
        }
    });
}
function displayPage(page) {
    let container = $("#card-container");
    container.empty();

    let totalPages = Math.ceil(installationData.length / recordsPerPage);
    if (totalPages === 0) {
        $("#page-info").text("");
        $("#prev-page, #next-page").hide();
        return;
    } else {
        $("#prev-page, #next-page").show();
    }

    let start = (page - 1) * recordsPerPage;
    let end = start + recordsPerPage;
    let paginatedData = installationData.slice(start, end);

    console.log(`Displaying Page ${page}:`, paginatedData);

    let contentHtml = "";
    paginatedData.forEach((item) => {
        let actionIcons = "<div class='col-12 form-icons'>";
        
        if (item.document_verification_status == 2) {
            actionIcons += `<i class="fa-solid fa-eye view-icon" style="font-size: 24px; color: #333;" data-unique_id="${item.consignee_unique_id}" data-invoice_no="${item.invoice_no}"></i>`;
        } else {
            actionIcons += `
                <i class='bi bi-pen green edit-icon' data-unique_id='${item.consignee_unique_id}' data-invoice_no='${item.invoice_no}'></i>
                <i class='bi bi-trash3 red delete-icon' data-unique_id='${item.consignee_unique_id}'></i>
            `;
        }
        actionIcons += "</div>";

        contentHtml += `
            <div class="card m-3">
                <div class="card-body">
                    ${actionIcons}
                    <div class="row mb-2">
                        <div class="col-6 lable_name_style"><p>PO No.</p><h6>${item.po_num || '-'}</h6></div>
                        <div class="col-6 lable_name_style"><p>Ledger Name</p><h6>${item.ledger_name || '-'}</h6></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6 lable_name_style"><p>Consignee District</p><h6>${item.con_district || '-'}</h6></div>
                        <div class="col-6 lable_name_style"><p>Location</p><h6>${item.con_address || '-'}</h6></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6 lable_name_style"><p>Invoice No</p><h6>${item.invoice_no || '-'}</h6></div>
                        <div class="col-6 lable_name_style"><p>Invoice Date</p><h6>${item.invoice_date || '-'}</h6></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6 lable_name_style"><p>Invoice Value</p><h6>${item.invoice_value || '-'}</h6></div>
                        <div class="col-6 lable_name_style"><p>Call Assign Date</p><h6>${item.installation_com_date || '-'}</h6></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6 lable_name_style"><p>Status</p><h6>${getInstallationStatusText(item.installation_status)}</h6></div>
                    </div>
                    <div class="row mb-2 text-center">
                        <div class="col-12 lable_name_style name_stl">
                            <p>Engineer Name</p><h6>${item.engineer_name || '-'}</h6>
                        </div>
                    </div>
                </div>
            </div>`;
    });

    container.html(contentHtml);
    updatePaginationControls(totalPages);
}


function updatePaginationControls(totalPages) {
    $("#page-info").text(`Page ${currentPage} of ${totalPages}`);
    $("#prev-page").prop("disabled", currentPage === 1);
    $("#next-page").prop("disabled", currentPage >= totalPages);
}

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

// Ensure function is defined to prevent errors
function getInstallationStatusText(status) {
    switch (status) {
        case '1': return 'Completed';
        case '2': return 'In Progress';
        default: return 'Pending';
    }
}

$(document).ready(function () {
    fetchInstallationData();
});
$(document).on("click", ".edit-icon", function () {
    let uniqueId = $(this).data("unique_id");
    let invoiceNo = $(this).data("invoice_no");

    console.log("Edit Clicked - Unique ID:", uniqueId, "Invoice No:", invoiceNo); // Debugging

    if (uniqueId && invoiceNo) {
        window.location.href = `form2.php?unique_id=${uniqueId}&invoice_no=${invoiceNo}`;
    } else {
        alert("Invalid data for editing!");
    }
});
$(document).on("click", ".view-icon", function () {
    let uniqueId = $(this).data("unique_id");
    let invoiceNo = $(this).data("invoice_no");

    console.log("Edit Clicked - Unique ID:", uniqueId, "Invoice No:", invoiceNo); // Debugging

    if (uniqueId && invoiceNo) {
        window.location.href = `view2.php?unique_id=${uniqueId}&invoice_no=${invoiceNo}`;
    } else {
        alert("Invalid data for editing!");
    }
});
$(document).on("click", ".delete-icon", function () {
    let uniqueId = $(this).data("unique_id");

    if (!uniqueId) {
        alert("Invalid record for deletion!");
        return;
    }

    if (confirm("Are you sure you want to delete this record?")) {
        $.ajax({
            url: '../service_app/crud.php',
            type: 'POST',
            data: { action: 'deleteInstallation', unique_id: uniqueId },
            dataType: 'json',
            success: function (response) {
                if (response.status) {
                    alert("Record deleted successfully.");
                    fetchInstallationData(); // Refresh data
                } else {
                    alert("Error: " + response.msg);
                }
            },
            error: function (xhr) {
                console.error('AJAX Error:', xhr.responseText);
            }
        });
    }
});

</script>

</body>
</html>

