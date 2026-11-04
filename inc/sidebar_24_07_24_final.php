<?php
$current_page = basename($_SERVER['PHP_SELF']); // Get the current page filename

// Main Screen Begins
$main_screens  = main_screen();

// Loop through main screens
foreach ($main_screens as $main_key => $main_value) {

    // Menu Permission based on User type Begin
    if (in_array($main_value['unique_id'], $_SESSION['main_screens'])) {

        $menu_main_name    =  disname($main_value["screen_main_name"]);
        $menu_main_icon    = "";

        if ($main_value["icon_name"]) {
            $menu_main_icon    =  '<i class="' . $main_value["icon_name"] . ' me-1"></i>';
        }
        
        // Check if any submenu item is active
        $is_active_sub = '';
        $active_sub_parent_id = '';
        $user_screens   = user_screen('', $main_value['unique_id']);
        foreach ($user_screens as $screens_key => $screens_value) {
            if (in_array($screens_value['unique_id'], $_SESSION['screens'])) {
                $menu_screen    = $screens_value["folder_name"] . "/list";
                if ($current_page === 'index.php' && isset($_GET['file']) && $_GET['file'] === $menu_screen) {
                    $is_active_sub = 'active';
                    $active_sub_parent_id = 'sidebarDashboards' . $main_value["unique_id"];
                    break;
                }
            }
        }
?>

        <li class="nav-item">
            <a class="nav-link menu-link <?= $is_active_sub ? 'active' : ''; ?>" href="#sidebarDashboards<?= $main_value["unique_id"]; ?>" data-bs-toggle="collapse" role="button" aria-expanded="<?= $is_active_sub ? 'true' : 'false'; ?>" aria-controls="sidebarDashboards<?= $main_value["unique_id"]; ?>">
                <?= $menu_main_icon; ?> <span data-key="t-dashboards"><?php echo $menu_main_name; ?></span>
            </a>
            <div class="collapse menu-dropdown<?= $is_active_sub ? ' show' : ''; ?>" id="sidebarDashboards<?= $main_value["unique_id"]; ?>">
                <ul class="nav nav-sm flex-column">
                    <?php
                    // Loop through user screens
                    foreach ($user_screens as $screens_key => $screens_value) {
                        // User Screen Permission Based On User Type
                        if (in_array($screens_value['unique_id'], $_SESSION['screens'])) {

                            $menu_screen_name   = disname($screens_value["screen_name"]);
                            $menu_screen_folder = $screens_value["folder_name"];
                            $menu_screen_icon   = "";

                            $menu_screen    = $menu_screen_folder . "/list";
                            $is_current_sub_active = $current_page === 'index.php' && isset($_GET['file']) && $_GET['file'] === $menu_screen;
                    ?>
                            <li class="nav-item">
                                <a href="index.php?file=<?php echo $menu_screen; ?>" class="nav-link <?php if($is_current_sub_active) echo 'active'; ?> <?php if($is_current_sub_active) echo 'text-danger'; ?>" data-key="t-crm"> <?= $menu_screen_name; ?> </a>
                            </li>
                    <?php
                        }
                    }
                    ?>
                </ul>
            </div>
        </li> <!-- end Dashboard Menu -->
<?php
    }
}
?>
<style>
 /* .nav-item .nav-link.active {
    background-color: #007bff; /* Blue color */
    /* color: #ffffff; White text color */
/* } */ 
.menu-dropdown .nav-link.active {
    background-color: #007bff; /* Blue color */
    color: #ffffff; /* White text color */
}



    </style>