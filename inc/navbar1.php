<style>
    .logout {
        font-size: 30px;
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
                            <img src="assets/images/Elcot_Logo.png" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="assets/images/Elcot_Logo.png" alt="" height="17">
                        </span>
                    </a>

                    <a href="index.php" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="assets/images/Elcot_Logo.png" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="assets/images/Elcot_Logo.png" alt="" height="17">
                        </span>
                    </a>
                </div>
                <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger" id="topnav-hamburger-icon">
                    <span class="hamburger-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </button>
            </div>
            <style>
        .notification-card {
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 10px;
            color: white;
        }
        .bg-primary { background-color: #007bff !important; }
        .bg-success { background-color: #28a745 !important; }
        .bg-warning { background-color: #ffc107 !important; color: black !important; }
        .bg-danger { background-color: #dc3545 !important; }
    </style>
            <div class="d-flex align-items-center">
                <!-- <div class="dropdown ms-sm-3 header-item topbar-user">
                    <button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="d-flex align-items-center">
                            <span class="text-start ms-xl-2">
                                <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text"><?= $_SESSION["staff_name"]; ?></span>
                            </span>
                        </span>
                    </button>
                </div> -->
<?php 
session_start();
// include '../config/dbconfig.php';
$conn1 = mysqli_connect("localhost", "root", "", "operation_team");

// Check connection
if (!$conn1) {
    die(json_encode(["error" => mysqli_connect_error()]));
}
// Prevent SQL injection
echo $date = date('Y-m-d');
// echo $date = $conn->real_escape_string($date); 
echo "SELECT 
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
    po.po_date = '$date' 
    AND sub.cons_verify_sts = 0 
    AND DATE_FORMAT(sub.created, '%Y-%m-%d') = '$date' 
    AND sub.is_delete = 0 
    AND po.is_delete = 0
GROUP BY po.po_num, po.po_date, dept.department";
// SQL Query
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
    po.po_date = '$date' 
    AND sub.cons_verify_sts = 0 
    AND DATE_FORMAT(sub.created, '%Y-%m-%d') = '$date' 
    AND sub.is_delete = 0 
    AND po.is_delete = 0
GROUP BY po.po_num, po.po_date, dept.department";

// $result = $conn->query($query);

// // // Check for query errors
// // if (!$result) {
// //     die(json_encode(["error" => $conn->error])); 
// // }

// // $po_numbers = [];
// $po_count_total = 0; // Initialize variable

// while ($row = $result->fetch_assoc()) {
    
//   echo "rro".$po_count_total += (int) $row['cnt']; // Accumulate total count
//     // echo $po_numbers[] = $row; // Store row data
// }
// Database connection

// Execute the query
$result = mysqli_query($conn1, $query);

// Check for query errors
if (!$result) {
    die(json_encode(["error" => mysqli_error($conn)])); 
}

$po_count_total = 0; // Initialize variable

while ($row = mysqli_fetch_assoc($result)) {
    $po_count_total += (int) $row['cnt']; // Accumulate total count
    //  $po_count_total . "<br>"; // Display the updated count
}


?>
                <div class="dropdown ms-sm-3 header-item topbar-user">
                    <div class="row">
                        <div class="col-6">
                        <div class="position-relative d-inline-block">
               <i class="mdi mdi-bell fs-3" role="button" data-bs-toggle="modal" data-bs-target="#notificationModal"></i>

<?php if ( $po_count_total > 0): ?>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                    <?php echo  $po_count_total; ?>
                </span>
                <?php endif; ?>
            </div>
                        </div>
                    </div>
                    <div class="col-6">
                    <button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="d-flex align-items-center">
                            <!-- <img class="rounded-circle header-profile-user" src="assets/images/users/avatar-1.jpg" alt="Header Avatar"> -->
                            <span class="text-start ms-xl-2">
                                <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text"><?= $_SESSION["staff_name"]; ?></span>
                                <!-- <span class="d-none d-xl-block ms-1 fs-12 text-muted user-name-sub-text">Founder</span> -->
                            </span>
                        </span>
                    </button>
                    
                    <div class="dropdown-menu dropdown-menu-end">
                        <!-- <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated profile-dropdown"> -->

                        <!-- <h6 class="dropdown-header">Welcome </h6> -->
                        <!-- <a class="dropdown-item" href="pages-profile.html"><i class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Profile</span></a>
                        <a class="dropdown-item" href="apps-chat.html"><i class="mdi mdi-message-text-outline text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Messages</span></a>
                        <a class="dropdown-item" href="apps-tasks-kanban.html"><i class="mdi mdi-calendar-check-outline text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Taskboard</span></a>
                        <a class="dropdown-item" href="pages-faqs.html"><i class="mdi mdi-lifebuoy text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Help</span></a> -->
                        <!-- <div class="dropdown-divider"></div> -->
                        <!-- <a class="dropdown-item" href="pages-profile.html"><i class="mdi mdi-wallet text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Balance : <b>$5971.67</b></span></a> -->
                        <!-- <a class="dropdown-item" href="pages-profile-settings.html"><span class="badge bg-soft-success text-success mt-1 float-end">New</span><i class="mdi mdi-cog-outline text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Settings</span></a> -->
                        <!-- <a class="dropdown-item" href="auth-lockscreen-basic.html"><i class="mdi mdi-lock text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Lock screen</span></a> -->
                        <div class=" dropdown-header noti-title">
                            <h6 class="text-overflow m-0">Welcome !</h6>
                        </div>
                        <a href="logout.php" class="dropdown-item">
                            <i class="mdi mdi-logout me-1"></i>
                            <span>Logout</span>
                        </a>
                        <a href="index.php?file=password/create" class="dropdown-item">
                            <!-- data-bs-toggle="modal" data-bs-target=".bs-example-modal-xl" class="dropdown-item" -->
                            <i class="ri-door-lock-line me-1"></i>
                            <span class="align-middle">Change Password</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</header>
 <!-- Modal -->
 <!-- Modal for Notifications -->
 <div class="modal fade" id="notificationModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Pending PO Numbers</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
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

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- JavaScript to Fetch and Display Notifications -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            fetch("fetch_po_numbers.php")
            // alert(response);
                .then(response => response.json())
                .then(poNumbers => {
                    console.log("Fetched PO Data:", poNumbers); // Debugging

                    if (!Array.isArray(poNumbers) || poNumbers.length === 0) {
                        console.error("Invalid PO data received.");
                        return;
                    }

                    updateNotificationIcon(poNumbers);
                    document.getElementById('notificationModal').addEventListener('show.bs.modal', function () {
                        loadNotifications(poNumbers);
                    });
                })
                .catch(error => console.error("Error fetching PO numbers:", error));

            function updateNotificationIcon(poNumbers) {
                const badge = document.getElementById("poCountBadge");
                if (poNumbers.length > 0) {
                    badge.textContent = poNumbers.length;
                    badge.style.display = "inline-block";
                } else {
                    badge.style.display = "none";
                }
            }

            function loadNotifications(poNumbers) {
                const notificationList = document.getElementById("notificationList");
                notificationList.innerHTML = ""; 

                if (poNumbers.length === 0) {
                    notificationList.innerHTML = "<p class='text-muted'>No pending PO numbers.</p>";
                    return;
                }

                poNumbers.forEach(po => {
                    const card = document.createElement("div");
                    card.classList.add("card", "mb-2");

                    card.innerHTML = `
                        <div class="card-body">
                            <h5 class="card-title">Pending PO</h5>
                            <p class="card-text">PO Number: <strong>${po.po_num}</strong></p>
                            <p class="card-text">Consignee Count: <strong>${po.po_date}</strong></p>
                            <p class="card-text">Consignee Count: <strong>${po.department}</strong></p>
                            
                            <p class="card-text">Total Addresses: <strong>${po.cnt}</strong></p>

                        </div>
                    `;

                    notificationList.appendChild(card);
                });
            }
        });
    </script>






<!-- <div class="modal fade bs-example-modal-xl" id="mymodel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header" style="background: #2999c4;color: #fff;">
                <h3 class="modal-title w-100 text-center" id="myExtraLargeModalLabel">Change Password </h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <input type="hidden" class="form-control" id="otp_no" name="otp_no">
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <div class="mb-3">
                                <label class="form-label">Old Password </label>
                                <input class="form-control" type="text" name="student" id="student" maxlength="20" size="30">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">New Password</label>
                                <input class="form-control" type="text" name="mobile" id="mobile" maxlength="10" size="30">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Confirm Password </label>
                                <input class="form-control" type="text" name="mobile" id="mobile" maxlength="10" size="30">
                            </div>
                        </div>
                        <div class="col-md-1"></div>
                    </div>
                    <br>
                    <div class="btns" style="margin-right:240px">
                        <button type="button" name="submit" id="submit" class="btn btn-primary" onclick="validate();">Submit</button>
                    </div>
                </div>
            </div>
            <br>
        </div>
    </div>
</div> -->
<script>


    function logout() {
     
        if (confirm("Are you sure you want to logout?")) {
            window.location.href = "logout.php";
        }
    }
</script>