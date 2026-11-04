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
.card {
    margin-bottom: 20px; /* Adds space between the cards */
    display: block; /* Ensures each card appears separately */
}
.edit-icon, .delete-icon {
    color: white !important;
}

/* .card_one .row{ background-color:white;} */

</style>
<body>
<div class="sub-hed">
    <div class="row">
        <div class="col-10 log-out">
           
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item">
                        <i class="bi bi-arrow-left" id="backButton" style="cursor: pointer;  font-size: 25px;  "></i>
                    </li>
                    <li> <h4 class="mb-sm-0" style="line-height: 1.6;"> Installation </h4></li>
                </ol>
            </div>
        </div>
        <div class="col-2 log-out logout_style">
            <a href="index.php"><i class="fa fa-sign-out"></i></a>
        </div>
    </div>

    <!-- Tabs inside .sub-hed -->
    <ul class="nav nav-tabs " id="installationTabs">
        <li class="nav-item">
            <a class="nav-link active" id="followups-tab" data-bs-toggle="tab" href="#followups"> Followups</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="dispatch-tab" href="install_list2.php">DC & IR Dispatch Details</a>
        </li>
    </ul>
</div>

<!-- Card 1 -->
<div class=" m-3">
    
        <div id="installation-container">
            <div class="row">
                <div class="col-10 col-sm-10 col-md-10 col-lg-10">
                    <div class="row mb-1">
                        <div class="col-12 lable_name_style name_stl">
                            <p>Engineer Name</p>
                            <h6 id="engineer_name"></h6>
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
                </div>   
                <!-- Right Side: Eye Icon & Three Dots -->
                <div class="col-2 col-sm-2 col-md-2 col-lg-2 text-end position-relative">
                    <div>
                    <span class="dots-menu" onclick="toggleMenu(event)">&#x22EE;</span> <!-- Three Dots -->
                    
                    <!-- Dropdown Menu -->
                    <div class="dropdown-menu-box" id="dropdownMenu">
                        <div class="row pdf-item p-2">
                            <div class="col-2 p-0"><a id="ir_link" target="_blank">  <i class="bi bi-file-earmark-pdf-fill pdf-icon"></i>  </a> </div>
                            <div class="col-10  pdf-title">DC</div>
                        </div>
                        <div class="row pdf-item p-2">
                            <div class="col-2 p-0"><a id="ir_link" target="_blank"><i class="bi bi-file-earmark-pdf-fill pdf-icon"></i>  </a>  </div>
                            <div class="col-10  pdf-title">IR</div>
                        </div>
                        <!-- <div class="row pdf-item p-2">

        <div class="col-2 p-0"><a id="snr_link" target="_blank">  <i class="bi bi-file-earmark-pdf-fill pdf-icon"></i>   </a>  </div>
        <div class="col-10 pdf-title">SNR</div>
        </div> -->
                       
                    </div>
                    </div>
                    <!-- <div style="line-height: 5;">
                        <i class="bi bi-eye blue view-icon"></i>
                    </div> -->
                </div>
            </div>   
        </div>
    
</div>
<!-- card 1 ends here -->
<div id="pagination-controls" class="text-center mt-3">
    <button id="prev-page" class="btn btn-secondary">Previous</button>
    <span id="page-info"></span>
    <button id="next-page" class="btn btn-secondary">Next</button>
</div>

<!-- CSS -->
<style>
    .dots-menu {
        cursor: pointer;
        font-size: 22px;
        margin-left: 10px;
    }

    .dropdown-menu-box {
        display: none;
        position: absolute;
        right: 0;
        background: white;
        border: 1px solid #ddd;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        border-radius: 5px;
        padding: 10px;
        z-index: 10;
        width: 200px;
    }

    .dropdown-menu-box a {
        display: block;
        padding: 8px;
        text-decoration: none;
        color: #333;
    }

    .dropdown-menu-box a:hover {
        background: #f8f9fa;
    }
</style>

<!-- JavaScript -->
<script>
    function toggleMenu(event) {
        event.stopPropagation();
        let menu = event.target.nextElementSibling;
        menu.style.display = menu.style.display === "block" ? "none" : "block";
    }

    document.addEventListener("click", function() {
        document.querySelectorAll(".dropdown-menu-box").forEach(menu => menu.style.display = "none");
    });
</script>


  
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

    let installationData = []; // Store fetched data
    let currentPage = 1;
    const recordsPerPage = 3; // Number of records per page

    // Fetch installation data
    function fetchInstallationData() {
        $.ajax({
            url: '../service_app/crud.php',
            type: 'POST',
            data: { action: 'fetchlist' },
            dataType: 'json',
            success: function (response) {
                console.log("AJAX Response:", response); // Debugging

                if (response.status && response.data.length > 0) {
                    installationData = response.data;
                    currentPage = 1; // Reset to first page
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
function displayPage(page) {

    let recordsPerPage = 3;
    let startIndex = (page - 1) * recordsPerPage;
    let endIndex = startIndex + recordsPerPage;

    if (startIndex < 0 || startIndex >= installationData.length) {
        return;
    }

    let records = installationData.slice(startIndex, endIndex);
    $("#installation-container").html(""); // Clear previous content

    let rowHtml = `<div class="row">`; // Open row container

    records.forEach(record => {
        let statusText = statusMapping[record.installation_status] || "Unknown";

        // alert(record.installation_status);
        let dcFile = (record.dc_file_name || "").trim();
        let irFile = (record.ir_file_name || "").trim();

        let actionIcons = `<div class='col-12 form-icons'>`;

        // Check if both files exist and are not empty
        if (dcFile !== "" && irFile !== "") {
            actionIcons += `<i class='bi bi-eye blue view-icon' data-unique_id='${record.consignee_unique_id}' data-invoice_no='${record.invoice_no}'></i>`;
        } else {
            actionIcons += `
                <i class='bi bi-pen edit-icon text-white' data-unique_id='${record.consignee_unique_id}' data-invoice_no='${record.invoice_no}'></i>
        <i class='bi bi-trash3 delete-icon text-white'></i>
            `;
        }
        actionIcons += `</div>`;

        let cardHtml = `
            <div class="col-md-4 mb-3"> <!-- Each card occupies 1/3rd of the row -->
                <div class="card_one p-3 shadow-lg">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-10">
                                <div class="row mb-1">
                                    <div class="col-12 label_name_style">
                                        <p>Engineer Name</p>
                                        <h6>${record.engineer_name}</h6>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-6 label_name_style">
                                        <p>PO No.</p>
                                        <h6>${record.po_num}</h6>
                                    </div>
                                    <div class="col-6 label_name_style">
                                        <p>PO Date</p>
                                        <h6>${record.po_date}</h6>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-6 label_name_style">
                                        <p>Invoice No.</p>
                                        <h6>${record.invoice_no}</h6>
                                    </div>
                                    <div class="col-6 label_name_style">
                                        <p>Invoice Date</p>
                                        <h6>${record.invoice_date}</h6>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-6 label_name_style">
                                        <p>Department</p>
                                        <h6>${record.con_district}</h6>
                                    </div>
                                    <div class="col-6 label_name_style">
                                        <p>Address</p>
                                        <h6>${record.con_address}</h6>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-6 label_name_style">
                                        <p>Status</p>
                                        <h6>${statusText}</h6>
                                    </div>
                                </div>
                            </div>   
                            <div class="col-2 text-end">
                                <div class="dropdown">
                                    <span class="dots-menu" onclick="toggleMenu(event)">&#x22EE;</span>
                                    <div class="dropdown-menu-box">
                                        <div class="row pdf-item p-2">
                                            <div class="col-2 p-0">
                                                <a href="${record.dc_file_name}" target="_blank">
                                                    <i class="bi bi-file-earmark-pdf-fill pdf-icon"></i>
                                                </a> 
                                            </div>
                                            <div class="col-10 pdf-title">DC</div>
                                        </div>
                                        <div class="row pdf-item p-2">
                                            <div class="col-2 p-0">
                                                <a href="${record.ir_file_name}" target="_blank">
                                                    <i class="bi bi-file-earmark-pdf-fill pdf-icon"></i>
                                                </a>  
                                            </div>
                                            <div class="col-10 pdf-title">IR</div>
                                        </div>
                                    </div>
                                </div>
                                <div style="line-height: 5;">
                                    ${actionIcons}
                                </div>
                            </div>
                        </div>   
                    </div>
                </div>
            </div>
        `;

        rowHtml += cardHtml; // Append each card inside row
    });

    rowHtml += `</div>`; // Close row container
    $("#installation-container").append(rowHtml); // Append row to container

    // Update pagination
    updatePaginationControls();
}


function updatePaginationControls() {
    let totalPages = Math.ceil(installationData.length / recordsPerPage); // Correct total pages calculation
    $("#page-info").text(`Page ${currentPage} of ${totalPages}`);

    $("#prev-page").prop("disabled", currentPage === 1);
    $("#next-page").prop("disabled", currentPage === totalPages);
}

// Pagination events
$("#prev-page").click(function() {
    if (currentPage > 1) {
        currentPage--;
        displayPage(currentPage);
    }
});

$("#next-page").click(function() {
    let totalPages = Math.ceil(installationData.length / recordsPerPage); // Ensure total pages is calculated
    if (currentPage < totalPages) {
        currentPage++;
        displayPage(currentPage);
    }
});


    // Toggle dropdown menu (Three Dots)
    function toggleMenu(event) {
        event.stopPropagation();
        let menu = event.target.nextElementSibling;
        menu.style.display = menu.style.display === "block" ? "none" : "block";
    }

    document.addEventListener("click", function() {
        document.querySelectorAll(".dropdown-menu-box").forEach(menu => menu.style.display = "none");
    });

    // Initialize data on page load
    $(document).ready(function () {
        fetchInstallationData();
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


</script>
</body>
</html>

