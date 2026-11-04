<!-- ============================================================== -->
<!-- Start Page Content here -->
<!-- ============================================================== -->
<?php
if (isset($_GET['file'])) {
    $folder_name_dec = str_replace(" ", "+", $_GET['file']);

    // $get_dec_file           = base64_decode($_GET['file']);

    // $get_dec_file           = openssl_decrypt(base64_decode($folder_name_dec), $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv);

    $file_str               = $folder_name_dec;

    $file_arr               = explode("/", $file_str);
    $folder_name_org        = $file_arr[0];
    $file_name_org          = $file_arr[1];

    $menu_screen            = $folder_name_org . "/create";
    // $file_name_create       = base64_encode(openssl_encrypt($menu_screen, $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv));
    $add_btn_link           = "index.php?file=" . $menu_screen;


    $menu_screen            = $folder_name_org . "/list";
    // $file_name_list         = base64_encode(openssl_encrypt($menu_screen, $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv));
    $cancel_btn_link        = "index.php?file=" . $menu_screen;


    $folder_crud_link       = "folders/" . $folder_name_org . "/crud.php";


    $menu_screen            = $folder_name_org . "/create";
    // $file_name_create       = base64_encode(openssl_encrypt($menu_screen, $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv));
    $btn_add                = "index.php?file=" . $menu_screen;

    $menu_screen            = $folder_name_org . "/list";
    // $file_name_list         = base64_encode(openssl_encrypt($menu_screen, $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv));
    $btn_cancel             = "index.php?file=" . $menu_screen;

    $folder_crud_link       = "folders/" . $folder_name_org . "/crud.php";

    $folder_name            = disname($folder_name_org);
    $file_name              = disname($file_name_org);
} else {


    $file_str        = "dashboard/form";

    $folder_name     = "Dashboard";
    $file_name       = "";

    $folder_name_org = "dashboard";
    $file_name_org   = "dashboard";


    $btn_add         = "index.php?file=" . $folder_name_org . "/create";
    $btn_cancel      = "index.php?file=" . $folder_name_org . "/list";

    $folder_crud_link = "folders/" . $folder_name_org . "/crud.php";
}
?>
<script>
    sessionStorage.setItem("folder_crud_link", "<?php echo $folder_crud_link; ?>");
    sessionStorage.setItem("list_link", "<?php echo $btn_cancel; ?>");
    sessionStorage.setItem("company_name", "<?php echo "Ascent"; ?>");
    sessionStorage.setItem("create", "<?php echo $btn_add; ?>");
</script>
<div class="main-content">
<div class="page-content">
    <div class="container-fluid">
        <!-- Start Content-->
        <div class="">
            <input type="hidden" name="location" id="location" class="form-control" value="" disabled>
            <input type="hidden" name="latitude" id="latitude" class="form-control" value="">
            <input type="hidden" name="longitude" id="longitude" class="form-control" value="">

            <!-- Page content Begins Here -->
            <?php    
            ?>
            <?php include 'folders/' . $file_str . '.php'; ?>
            <!-- Page content Ends Here -->

        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- End Page content -->
<!-- ============================================================== -->

<?php include 'inc/footer.php'; ?>