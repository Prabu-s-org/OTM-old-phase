<!DOCTYPE html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">
<link href="assets/js/jquery.dataTables.min.css"></link>
<head>
    <meta charset="utf-8" />
    <title>Ascent | Operation Team - Admin & Dashboard </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Ascent Elcot Admin " name="description" />
    <!-- mythili -->
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"> -->


    <!-- end -->
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico" type="image/vnd.microsoft.icon" />

    <!-- jsvectormap css -->
    <link href="assets/libs/jsvectormap/css/jsvectormap.min.css" rel="stylesheet" type="text/css" />    
    <script src="assets/libs/jsvectormap/js/jsvectormap.min.js"></script>

    <!--Swiper slider css-->
    <link href="assets/libs/swiper/swiper-bundle.min.css" rel="stylesheet" type="text/css" />

     <script src="assets/datatable_new/jquery-3.7.0.min.js"></script> 
    <!-- <script src="assets/js/jquery.min.js"></script> -->

     <!--datatable css-->
     <link rel="stylesheet" href="assets/js/dataTables.bootstrap5.min.css" />
    <!--datatable responsive css-->
    <link rel="stylesheet" href="assets/js/responsive.bootstrap.min.css" />

    <!--<link rel="stylesheet" href="assets/js/buttons.dataTables.min.css">-->

   <link href="assets/css/select2.min.css" rel="stylesheet" />
   
   <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Layout config Js -->
    <script src="assets/js/layout.js"></script>
    <!-- Bootstrap Css -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    
    
    <!-- Icons Css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="assets/css/custom.min.css" rel="stylesheet" type="text/css" />
   
    <link href="assets/js/jquery.dataTables.min.js"/>
 
   

    
</head>


<body>


<!-- <div id="page-loader">
    <svg class="loop-loader" viewBox="0 0 120 120">
        <defs>
            <linearGradient id="loopGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                <stop offset="0%" stop-color="#9b7cff"/>
                <stop offset="50%" stop-color="#5ad7ff"/>
                <stop offset="100%" stop-color="#38f9d7"/>
            </linearGradient>
        </defs>

        <path
            d="M60 15
               C85 15, 105 35, 105 60
               C105 85, 85 105, 60 105
               C35 105, 15 85, 15 60
               C15 35, 35 15, 60 15"
            fill="none"
            stroke="url(#loopGradient)"
            stroke-width="7"
            stroke-linecap="round"
            stroke-dasharray="140"
        />
    </svg>
</div> -->

<style>
#page-loader {
    position: fixed;
    inset: 0;
    background: rgba(255, 255, 255, 0.45); /* transparent + disabled */
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 99999;
    pointer-events: all;
}

.loop-loader {
    width: 90px;
    height: 90px;
    animation: rotateLoop 1.4s linear infinite;
}

.loop-loader path {
    animation: dashLoop 1.6s ease-in-out infinite;
}

@keyframes rotateLoop {
    100% {
        transform: rotate(360deg);
    }
}

@keyframes dashLoop {
    0% {
        stroke-dasharray: 1, 200;
        stroke-dashoffset: 0;
    }
    50% {
        stroke-dasharray: 90, 200;
        stroke-dashoffset: -40;
    }
    100% {
        stroke-dasharray: 90, 200;
        stroke-dashoffset: -140;
    }
}
</style>

    <div id="layout-wrapper">
        <?php include 'nav_bar.php'; ?>
        <!-- ========== App Menu ========== -->
        <div class="app-menu navbar-menu">
            <!-- LOGO -->
            <div class="navbar-brand-box" style="background: white;">
                <!-- Dark Logo-->
                <a href="index.php" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="assets/images/ascent-otm.svg" alt="" width="100%"  class="sv-logo">
                    </span>
                    <span class="logo-lg">
                        <img src="assets/images/ascent-otm.svg" alt="" width="100%" class="sv-logo">
                    </span>
                </a>
             
                <!-- Light Logo-->
                <a href="index.php" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="assets/images/ascent-otm.svg" alt="" width="100%" class="sv-logo" >
                    </span>
                    <span class="logo-lg">
                        <img src="assets/images/ascent-otm.svg" alt="" width="100%" class="sv-logo" >
                    </span>
                </a>
                <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
                    <i class="ri-record-circle-line"></i>
                </button>
            </div>
            <div id="scrollbar">
                <div class="container-fluid">
                    <div id="two-column-menu">
                    </div>
                    <ul class="navbar-nav" id="navbar-nav">
                        <?php include 'side_bar.php'; ?>
                    </ul>
                </div>
                <!-- Sidebar -->
            </div>

            <div class="sidebar-background"></div>
        </div>
        <!-- Left Sidebar End -->

        <!-- Vertical Overlay-->
        <div class="vertical-overlay"></div>
    </div>
<!--</body>-->
<script>
  function logout() {
    if (confirm("Are you sure you want to logout?")) {
      window.location.href = "logout.php";
    }
  }

/* Hide loader after page load (already correct) */
// window.addEventListener('load', function () {
//     const loader = document.getElementById('page-loader');
//     if (loader) {
//         loader.style.opacity = '0';
//         setTimeout(() => {
//             loader.style.display = 'none';
//         }, 300);
//     }
// });

/* Show loader on ANY page navigation */
// window.addEventListener('beforeunload', function () {
//     const loader = document.getElementById('page-loader');
//     if (loader) {
//         loader.style.display = 'flex';
//         loader.style.opacity = '1';
//     }
// });
</script>

