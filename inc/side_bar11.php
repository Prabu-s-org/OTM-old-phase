<li class="menu-title"><span data-key="t-menu">Menu</span></li>

<?php
//Main Screen Begins
$main_screens  = main_screen();

// print_r($_SESSION['main_screens']);
foreach ($main_screens as $main_key => $main_value) {

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
                            $file_name      = base64_encode(openssl_encrypt($menu_screen, $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv));

                    ?>
                            <li class="nav-item">
                                <a href="index.php?file=<?php echo $file_name; ?>" class="nav-link" data-key="t-analytics"> <?= $menu_screen_name; ?> </a>
                            </li>
                    <?php }
                    }
                    // $city = base64_encode('city_creation/list');
                    ?>

                </ul>
                <?php
                $menu_screen    = "pincode_creation/list";
                $menu_screen1    = "department_creation/list";
                $menu_screen2    = "consignee_creation/list";
                $menu_screen3 = "executive_creation/list";
                $menu_screen4 = "item_creation/list";
                $menu_screen5 = "main_category/list";
                $menu_screen6 = "product_category/list";

                $file_name      = base64_encode(openssl_encrypt($menu_screen, $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv));
                $file_name1     = base64_encode(openssl_encrypt($menu_screen1, $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv));
                $file_name2     = base64_encode(openssl_encrypt($menu_screen2, $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv));
                $file_name3     = base64_encode(openssl_encrypt($menu_screen3, $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv));
                $file_name4     = base64_encode(openssl_encrypt($menu_screen4, $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv));
                $file_name5     = base64_encode(openssl_encrypt($menu_screen5, $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv));
                $file_name6     = base64_encode(openssl_encrypt($menu_screen6, $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv));

                ?>
                <a href="index.php?file=<?php echo $file_name; ?>" class="nav-link" data-key="t-analytics">Pincode Creation </a>
                <a href="index.php?file=<?php echo $file_name1; ?>" class="nav-link" data-key="t-analytics">Department Creation </a>
                <a href="index.php?file=<?php echo $file_name2; ?>" class="nav-link" data-key="t-analytics">Consignee Creation </a>
                <a href="index.php?file=<?php echo $file_name3; ?>" class="nav-link" data-key="t-analytics">Executive Creation </a>
                <a href="index.php?file=<?php echo $file_name4; ?>" class="nav-link" data-key="t-analytics">Item Creation </a>
                <a href="index.php?file=<?php echo $file_name5; ?>" class="nav-link" data-key="t-analytics">Main Category</a>

                <a href="index.php?file=<?php echo $file_name6; ?>" class="nav-link" data-key="t-analytics">Product Category</a>
            </div>
        </li> <!-- end Dashboard Menu -->
<?php }
}
?>


</ul>