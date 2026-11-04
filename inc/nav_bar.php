<style>
    .logout {
        font-size: 30px;
    }

    #page-header {
        display: inline-flex !important;
        opacity: 1 !important;
        visibility: visible !important;
    }
</style>

<header id="page-topbar">
    <div class="layout-width">
        <div class="navbar-header">
            <div class="d-flex">
                <!-- LOGO -->
                <div class="navbar-brand-box horizontal-logo">
                    <a href="index.php" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="assets/images/ascent-otm.svg" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="assets/images/ascent-otm.svg" alt="" height="17">
                        </span>
                    </a>

                    <a href="index.php" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="assets/images/ascent-otm.svg" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="assets/images/ascent-otm.svg" alt="" height="17">
                        </span>
                    </a>
                </div>
                <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger"
                    id="topnav-hamburger-icon">
                    <span class="hamburger-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </button>
            </div>
            <div class="d-flex align-items-center">

                <?php
                // session_start();
                
                $conn1 = @mysqli_connect("localhost", "root", "", "operation_team_beta");

                // Check connection
                if (!$conn1) {
                    $conn1 = false;
                }
                // Prevent SQL injection
                $date = date('Y-m-d');

                $query = "SELECT 
    po.po_num, 
    COUNT(sub.con_address) AS cnt, 
    po.po_date, 
    dept.department
FROM `po_form` AS po 
INNER JOIN `consignee_details_sub` AS sub 
    ON po.unique_id = sub.form_main_unique_id  
LEFT JOIN `department_creation` AS dept 
    ON po.department = dept.unique_id
WHERE 
    sub.cons_verify_sts = 2
    AND sub.is_delete = 0 
    AND po.is_delete = 0
GROUP BY po.po_num, po.po_date, dept.department";

                // echo "SELECT 
//     po.po_num, 
//     COUNT(sub.con_address) AS cnt, 
//     po.po_date, 
//     dept.department
// FROM `po_form` AS po 
// INNER JOIN `consignee_details_sub` AS sub 
//     ON po.unique_id = sub.form_main_unique_id  
// LEFT JOIN `department_creation` AS dept 
//     ON po.department = dept.unique_id
// WHERE 
//     sub.cons_verify_sts = 2
//     AND sub.is_delete = 0 
//     AND po.is_delete = 0
// GROUP BY po.po_num, po.po_date, dept.department";
//  po.po_date = '$date' ANDAND DATE_FORMAT(sub.created, '%Y-%m-%d') = '$date' 
                // Execute the query
                $result = mysqli_query($conn1, $query);

                // Check for query errors
                if (!$result) {
                    $result = false;
                }

                $po_count_total = 0; // Initialize variable
                
                while ($row = mysqli_fetch_assoc($result)) {
                    $po_count_total += (int) $row['cnt']; // Accumulate total count
                
                }

                ?>
                <div class="dropdown ms-sm-3 header-item topbar-user">
                    <div class="row">
                        <div class="col-6">

                            <!-- <div class="position-relative d-inline-block">


                                <button id="poNotificationButton" class="btn btn-primary" style="padding: 0px;margin-top: 10px;margin-right: 19px;">
                                    <?php if ($po_count_total > 0): ?>
                                        <span
                                            class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                            <?php echo $po_count_total; ?>
                                        </span>

                                        <i class="mdi mdi-bell fs-3" role="button" data-bs-toggle="modal"
                                            data-bs-target="#notificationModal"></i><span id="poCountBadge"
                                            class="badge bg-danger position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                                            style="display:none;"> </span>
                                    </button>
                                 
                                   
                                <?php endif; ?>

                            </div> -->
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="dropdown">
                            <span id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false" style="cursor: pointer;">
                                <?= $_SESSION["staff_name"]; ?>
                            </span>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="page-header-user-dropdown">
                                <div class="dropdown-header noti-title">
                                    <h6 class="text-overflow m-0">Welcome!</h6>
                                </div>
                                <a onclick="logout_check()" class="dropdown-item">
                                    <i class="mdi mdi-logout me-1"></i> Logout
                                </a>
                                <a href="index.php?file=password/create" class="dropdown-item">
                                    <i class="ri-door-lock-line me-1"></i> Change Password
                                </a>
                            </div>
                        </div>





                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Notification Modal -->
<div class="modal" id="notificationModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Not Verified Consignee Address</h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!--         <h5 class="card-title text-danger fw-bold">-->
            <!--    The below PO consignee addresses are not verified.I am reminding you!-->
            <!--</h5>-->
            <div class="modal-body">

                <div id="notificationList">

                    <p class="text-muted">Loading...</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>


    function logout_check() {
        // alert("hii");
        // Send a request to the server to destroy the session
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "logout.php", true); // Assuming logout.php is used to destroy the session
        xhr.onload = function () {
            if (xhr.status == 200) {
                // Redirect to the index.php page after logout
                window.location.href = "index.php";
            }
        };
        xhr.send();
    }

    const colors = [
        "#ffcccc", "#ccffcc", "#cce5ff", "#ffffcc", "#ffccff",
        "#ffb3b3", "#b3ffb3", "#b3d9ff", "#ffff99", "#ff99ff",
        "#ff9966", "#66ff66", "#6699ff", "#ffcc99", "#ff66cc"
    ];

    // Function to get a random color from the array
    function getRandomColor() {
        return colors[Math.floor(Math.random() * colors.length)];
    }

    document.addEventListener("DOMContentLoaded", function () {
        const notificationModal = new bootstrap.Modal(document.getElementById('notificationModal'));

        function fetchPONumbers() {
            fetch("fetch_po_numbers.php")
                .then(response => response.json())
                .then(poNumbers => {
                    console.log("Fetched PO Data:", poNumbers); // Debugging

                    if (!Array.isArray(poNumbers) || poNumbers.length === 0) {
                        console.error("Invalid PO data received.");
                        document.getElementById("notificationList").innerHTML = "<p class='text-muted'>No pending PO numbers.</p>";
                        return;
                    }

                    // updateNotificationIcon(poNumbers);
                    loadNotifications(poNumbers);
                })
                .catch(error => console.error("Error fetching PO numbers:", error));
        }

        function updateNotificationIcon(poNumbers) {
            const badge = document.getElementById("poCountBadge");
            if (badge) {
                if (poNumbers.length > 0) {
                    badge.textContent = poNumbers.length;
                    badge.style.display = "inline-block";
                } else {
                    badge.style.display = "none";
                }
            }
        }

        function loadNotifications(poNumbers) {
            const notificationList = document.getElementById("notificationList");
            notificationList.innerHTML = ""; // Clear old notifications

            if (poNumbers.length === 0) {
                notificationList.innerHTML = "<p class='text-muted'>No pending PO numbers.</p>";
                return;
            }

            // Define background colors for alternating cards
            // const colors = ["#ffcccc", "#ccffcc", "#cce5ff", "#ffffcc", "#ffccff"];

            const row = document.createElement("div");
            row.classList.add("row", "g-3"); // Bootstrap Grid

            poNumbers.forEach((po, index) => {
                const col = document.createElement("div");
                col.classList.add("col-md-12"); // 2 columns per row on medium+ screens

                const card = document.createElement("div");
                card.classList.add("card123", "shadow-sm", "p-3");
                // card.style.backgroundColor = colors[index % colors.length]; // Apply alternating background colors
                card.style.backgroundColor = getRandomColor();

                card.innerHTML = `
                     
                <div class="card-body123">
                
                    <div class="row">
            <div class="col-6">
                <p class="card-text"><strong>PO Number:</strong> ${po.po_num}</p>
            </div>
            <div class="col-6">
                <p class="card-text"><strong>PO Date:</strong> ${po.po_date}</p>
            </div>
        </div>
        
        <div class="row">
            <div class="col-6">
                <p class="card-text"><strong>Department:</strong> ${po.department}</p>
            </div>
            <div class="col-6">
                <p class="card-text"><strong>Total Addresses:</strong> ${po.cnt}</p>
            </div>
        </div>
    </div>
                </div>
            `;

                col.appendChild(card);
                row.appendChild(col);
            });

            notificationList.appendChild(row);
        }

        // When the button is clicked, fetch and show notifications
        // document.getElementById("poNotificationButton").addEventListener("click", function () {
        //     fetchPONumbers();
        //     notificationModal.show();
        // });
    });

</script>
