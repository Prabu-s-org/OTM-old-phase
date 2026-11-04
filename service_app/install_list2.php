<?php
include 'header.php';
?>
<style>
    .view-icon {
        display: inline-block !important;
        visibility: visible !important;
        color: blue !important;
        font-size: 18px;
    }

    .card {
        margin-bottom: 20px;
        /* Adds space between the cards */
        display: block;
        /* Ensures each card appears separately */
    }
body{background-color: #f9f6fb;}
    .edit-icon,
    .delete-icon {
        color: white !important;
    }
.shadow-lg{box-shadow:0 1rem 3rem rgba(0, 0, 0, 0.175) !important}
.label_name_style h4{  font-size: 1rem; font-weight: 600;}
.label_name_style p{    font-size: 0.9rem; font-weight: normal;  color: #494949;margin-bottom: 0px;}
.card_one{background: #ffffff;}
    /* .card_one .row{ background-color:white;} */
.nav-tabs .nav-link{margin-bottom: -3px;padding: 20px 20px 9px 0px;    font-size: 15px;font-weight: 500;}
.label_name_style p span{font-weight: 600;}

</style>

<body>

    <div class="sub-hed">
        <div class="row">
            <div class="col-2 log-out">

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <i class="bi bi-arrow-left" id="backButton"
                                style="cursor: pointer;  font-size: 25px;  "></i>
                        </li>
                        <li>
                            
                        </li>
                        
                    </ol>
                </div>
            </div>
            <h4 class="col-8  mb-sm-0" style="line-height: 1.6;text-align: center; color: #fff;"> Installation </h4>
            <div class="col-2 log-out logout_style">
                <a href="index.php"><i class="fa fa-sign-out"></i></a>
            </div>
        </div>

        <!-- Tabs inside .sub-hed -->
        <ul class="nav nav-tabs " id="installationTabs">
            <li class="nav-item">
                <a class="nav-link" id="followups-tab" href="install_list.php"> Followups</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" id="dispatch-tab" href="install_list2.php">DC & IR Dispatch Details</a>
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
                </div>
                <!-- Right Side: Eye Icon & Three Dots -->
                <div class="col-2 col-sm-2 col-md-2 col-lg-2 text-end position-relative">
                    <div>
                        <span class="dots-menu" onclick="toggleMenu(event)">&#x22EE;</span> <!-- Three Dots -->

                        <!-- Dropdown Menu -->
                        <div class="dropdown-menu-box" id="dropdownMenu">
                            <div class="row pdf-item p-2">
                                <div class="col-2 p-0"><a id="ir_link" target="_blank"> <i
                                            class="bi bi-file-earmark-pdf-fill pdf-icon"></i> </a> </div>
                                <div class="col-10  pdf-title">IR</div>
                            </div>
                            <div class="row pdf-item p-2">
                                <div class="col-2 p-0"><a id="ir_link" target="_blank"><i
                                            class="bi bi-file-earmark-pdf-fill pdf-icon"></i> </a> </div>
                                <div class="col-10  pdf-title">IR</div>
                            </div>


                        </div>
                    </div>
                    <div style="line-height: 5;">
                      
                    </div>
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

        document.addEventListener("click", function () {
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
        document.getElementById("backButton").addEventListener("click", function () {
            window.location.href = "list.php"; // Redirect to list page
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
            1: "SNR",
            3: "Complete",
            5: "Rejected",
            // 4: "Eng Call Attn",
            // 5: "Partial Completed"
        };
        function displayPage(page) {
            let startIndex = (page - 1) * recordsPerPage;
            let endIndex = startIndex + recordsPerPage;
            let paginatedRecords = installationData.slice(startIndex, endIndex);

            if (paginatedRecords.length === 0) return;

            let htmlContent = "";

            paginatedRecords.forEach(record => {
                // let statusText = "Unknown"; // Default value

                let statusText = statusMapping[record.dc_delivery_status] || "Unknown"; // Default
                if (record.dc_delivery_status == "0") {
                    statusText = "Pending";
                } else if (record.dc_delivery_status == "1") {
                    statusText = "SNR";
                } else if (record.dc_delivery_status == "3") {
                    statusText = "Completed";
                } else if (record.dc_delivery_status == "5") {
                    statusText = "Partial Completed";
                }

                // let actionIcons = `
                //     <i class='bi bi-pen green edit-icon' data-unique_id='${record.consignee_unique_id}' data-invoice_no='${record.invoice_no}'></i>
                // `;

                let dc_delivery_status = (record.dc_delivery_status || "").trim();
                let actionIcons = `<div class='col-12 form-icons'>`;

                // Check if both files exist and are not empty
                if (dc_delivery_status == '3') {

                actionIcons += `
        <button class='btn btn-outline-primary view-icon' data-unique_id='${record.consignee_unique_id}' data-invoice_no='${record.invoice_no}' data-dc_number='${record.dc_number}' title="View">
            <i class='bi bi-eye'></i>
        </button>
    `;
                }
                else if (dc_delivery_status != '3') {
                    actionIcons += `
        <button class='btn btn-outline-secondary edit-icon' data-unique_id='${record.consignee_unique_id}' data-invoice_no='${record.invoice_no}' data-dc_number='${record.dc_number}' title="Edit">
            <i class='bi bi-pen text-white'></i>
        </button>
    `; }

               

                htmlContent += `
            <div class="col-md-4 mt-3">
                <div class="card_one shadow-lg">
                    <div class="card-body">
                    <div class="row">
                        <div class=" col-9 label_name_style">
                            <h4 class="m-0 p-0"><span> Cus - </spna>${record.department}</h4>
                        </div>
                        <div class=" col-3 text-end">
                            <div class="dropdown">
                                ${actionIcons}
                                
                            </div>

                        </div>
                    </div>
                   
                        <div class="row">
                            <div class="col-12">
                                <div class="row ">
                                    <div class="col-12 label_name_style">
                                        <p>PO No.: <span>${record.po_num} </span></p>
                                        <p>PO Date :   <span>${record.po_date} </span></p>
                                        <p>Dc No. : <span> ${record.dc_number} </span> </p>
                                        <p>Invoice No. : <span> ${record.invoice_no} </span> </p>
                                        <p>Invoice Date :  <span>${record.invoice_date} </span></p>
                                         <p>Address :  <span>${record.con_address} </span></p>
                                        <p>Status :  <span>${statusText} </span></p>
                                         <p  style="text-align: right;"> Assign - <span> ${record.engineer_name} </span></p>
                                    </div>
                                    
                                </div>
                            </div>   
                            
                        </div>   
                    </div>
                </div>
            </div>
    

        `;
            });

            $("#installation-container").html(htmlContent);
            let totalPages = Math.ceil(installationData.length / recordsPerPage);
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

        fetchInstallationData();

        $(document).on("click", ".edit-icon", function () {
            let uniqueId = $(this).data("unique_id");
            let invoiceNo = $(this).data("invoice_no");
            let dc_number = $(this).data("dc_number");

            console.log("Edit Clicked - Unique ID:", uniqueId, "Invoice No:", invoiceNo); // Debugging

            if (uniqueId && invoiceNo) {
                window.location.href = `form2.php?unique_id=${uniqueId}&invoice_no=${invoiceNo}&dc_number=${dc_number}`;
            } else {
                alert("Invalid data for editing!");
            }
        });

        $(document).on("click", ".view-icon", function () {
            let uniqueId = $(this).data("unique_id");
            let invoiceNo = $(this).data("invoice_no");
            let dc_number = $(this).data("dc_number");

            console.log("Edit Clicked - Unique ID:", uniqueId, "Invoice No:", invoiceNo); // Debugging

            if (uniqueId && invoiceNo) {
                window.location.href = `view2.php?unique_id=${uniqueId}&invoice_no=${invoiceNo}&dc_number=${dc_number}`;
            } else {
                alert("Invalid data for editing!");
            }
        });

        // Handle Delete Button Click
        $(document).on("click", ".delete-icon", function () {
            let uniqueId = $(this).closest('.card').find(".edit-icon").data("unique_id");
            let invoiceNo = $(this).closest('.card').find(".edit-icon").data("invoice_no");
            let dc_number = $(this).closest('.card').find(".edit-icon").data("dc_number");

            if (!uniqueId || !invoiceNo || !dc_number) {
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
                        invoice_no: invoiceNo,
                        dc_number: dc_number

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
