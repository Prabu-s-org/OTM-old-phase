<?php include 'config/dbconfig.php'; ?>

<?php
// Temp variables
$company_name = "elcot";
$user_id      = "";

if (isset($_SESSION['user_id'])) {
    $user_id      = $_SESSION['user_id'];

    if (isset($_SESSION['LAST_ACTIVITY']) && ((time() - $_SESSION['LAST_ACTIVITY']) > 3600)) {
        // last request was more than 1 hour ago
        //session_unset();     // unset $_SESSION variable for the run-time 
        //session_destroy();   // destroy session data in storage
?>

<?php
        header("Location: logout.php");
    }

    $_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp
}
?>

<?php


if (session_id() and ($user_id)) {
    // permission_check();
?>

    <?php include 'inc/header.php' ?>

    <!-- <div class="main-content"> -->
    <?php include 'body.php'; ?>
    <!-- </div> -->


<?php
} else {
    // LOGIN PAGE 
    $folder_name_org = "login1";
?>

    <body class="loading auth-fluid-pages pb-0">

        <?php include "folders/login1/login.php"; ?>
        

    </body>
<?php
}
?>