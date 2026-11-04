<!--<li class="menu-title"><span data-key="t-menu">Menu</span></li>-->

<?php
//Main Screen Begins
$main_screens  = main_screen();

// print_r($_SESSION['main_screens']);
foreach ($main_screens as $main_key => $main_value) {
;;p;
    // Menu Permission based on User type Begin
    if (in_array($main_value['unique_id'], $_SESSION['main_screens'])) {

        $menu_main_name    =  disname($main_value["screen_main_name"]);

        $menu_main_icon    = "";

        if ($main_value["icon_name"]) {
            $menu_main_icon    =  '<i class="' . $main_value["icon_name"] . ' me-1"></i>';
        }
?>

        <li class="nav-item">
            <a class="nav-link menu-link" href="#sidebarDashboards<?= $main_value["unique_id"]; ?>" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarDashboards<?= $main_value["unique_id"]; ?>">
                <?= $menu_main_icon; ?> <span data-key="t-dashboards"><?php echo $menu_main_name; ?></span>
            </a>
            <div class="collapse menu-dropdown" id="sidebarDashboards<?= $main_value["unique_id"]; ?>">
                <ul class="nav nav-sm flex-column">
                    <?php
                    $user_screens   = user_screen('', $main_value['unique_id']);

                    foreach ($user_screens as $screens_key => $screens_value) {
                        // User Screen Permission Based On User Type
                        if (in_array($screens_value['unique_id'], $_SESSION['screens'])) {

                            $menu_screen_name   = disname($screens_value["screen_name"]);
                            $menu_screen_folder = $screens_value["folder_name"];
                            $menu_screen_icon   = "";


                            $menu_screen    = $menu_screen_folder . "/list";
                            // $file_name      = base64_encode(openssl_encrypt($menu_screen, $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv));

                    ?>
                            <li class="nav-item">
                                <a href="index.php?file=<?php echo $menu_screen; ?>" class="nav-link" data-key="t-analytics"> <?= $menu_screen_name; ?> </a>

                            </li>

                    <?php }
                    }


                    ?>

                    <li>

                </ul>

            </div>
           
        </li> <!-- end Dashboard Menu -->
<?php
    }
}
?>


</ul>