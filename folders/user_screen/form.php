<!-- This file Only PHP Functions -->
<?php include 'function.php'; ?>

<?php
// Form variables
$btn_text           = "Save";
$btn_action         = "create";
$is_btn_disable     = "";

$unique_id          = "";

$main_screen_id     = "";
$screen_section_id  = "";
$screen_name        = "";
$screen_folder_name = "";
$order_no           = "";
$icon_name          = "";
$is_active          = 1;
$description        = "";

$user_action_options    = "";
$user_action_selected   = "";

if (isset($_GET["unique_id"])) {
   if (!empty($_GET["unique_id"])) {

      // $uni_dec = str_replace(" ", "+", $_GET['unique_id']);
      // $get_uni_id           = openssl_decrypt(base64_decode($uni_dec), $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv);

      $unique_id  = $_GET["unique_id"];
      $where      = [
         "unique_id" => $unique_id
      ];


      $table      =  "user_screen";

      $columns    = [
         "main_screen_unique_id",
         "screen_section_unique_id",
         "screen_name",
         "folder_name",
         "icon_name",
         "order_no",
         "is_active",
         "description",
         "actions"
      ];

      $table_details   = [
         $table,
         $columns
      ];

      $result_values  = $pdo->select($table_details, $where);
// print_r($result_values );
      if ($result_values->status) {

         $result_values     = $result_values->data;

         $main_screen_id           = $result_values[0]["main_screen_unique_id"];
         $screen_section_id        = $result_values[0]["screen_section_unique_id"];
         $screen_name              = $result_values[0]["screen_name"];
         $screen_folder_name       = $result_values[0]["folder_name"];
         $icon_name                = $result_values[0]["icon_name"];
         $order_no                 = $result_values[0]["order_no"];
         $is_active                = $result_values[0]["is_active"];
         $description              = $result_values[0]["description"];
         $user_action_selected     = $result_values[0]["actions"];
         $dashboard_setting_menu   = $result_values[0]["dashboard_setting_menu"];


         $btn_text           = "Update";
         $btn_action         = "update";
      } else {
         $btn_text           = "Error";
         $btn_action         = "error";
         $is_btn_disable     = "disabled='disabled'";
      }
   }
}

$main_screen_options  = main_screen();

$main_screen_options  = select_option($main_screen_options, "Select the Main Screen", $main_screen_id);

$section_name_options = "<option value='' disabled='disabled' selected>Select the Screen Section</option>";

if ($main_screen_id) {

   $section_name_options  = section_name('', $main_screen_id);

   $section_name_options  = select_option($section_name_options, "Select the Screen Section", $screen_section_id);
}

$active_status_options = active_status($is_active);

$user_action_options    = user_actions();

$user_action_options    = user_action_list($user_action_options, $user_action_selected);


// $dashboard_admin_menu_options    = dashboard_admin_menu();
// $dashboard_admin_menu_options   = select_option($dashboard_admin_menu_options,"Select",$dashboard_setting_menu);

?>

<div class="wizard-form-field">
   <div class="row">
      <div class="col-12">
         <div class="card p-5">
            <h4 class=" mb-3 sub_header_style ">User Screen</h4>
            <form class="was-validated" autocomplete="off">
               <div class="row">
                  <div class="col-12">
                        <!-- <h4 class="header-title">Delivery / Invoice Details </h4> -->

                     <!-- --------------------------Designed by MI ------------------------------->
                     <div class="row pb-3">
                        <div class="col-xl-6 " style="padding-right: 20px;">
                           <div class="row pb-2">
                              <div class="col-xl-6">
                                 <label for="main_screen" class="form-label">Main Screen</label>
                              </div><!-- end col -->
                              <div class="col-xl-6">
                                 <select name="main_screen" id="main_screen" class="select2 form-control" onchange="get_sections(this.value)" required>
                                 <?php echo $main_screen_options; ?>
                              </select>
                              </div><!-- end col -->
                           </div>
                           <div class="row pb-2">
                              <div class="col-xl-6">
                                 <label for="cleave-delimiter" class="form-label">Screen Name</label>
                              </div><!-- end col -->
                              <div class="col-xl-6">
                                 <input type="text" id="screen_name" name="screen_name" class="form-control" value="<?php echo $screen_name; ?>" required>
                              </div><!-- end col -->
                           </div> 
                           <div class="row pb-2">
                              <div class="col-xl-6">
                                 <label for="main_screen" class="form-label">Screen Section</label>
                              </div><!-- end col -->
                              <div class="col-xl-6">
                                 <select name="section_name" id="section_name" class="select2 form-control">
                                    <?php echo $section_name_options; ?>
                              </select>
                              </div><!-- end col -->
                           </div>

                           <!-- <div class="row pb-2">
                              <div class="col-xl-6">
                                 <label for="main_screen" class="form-label">Screen Section</label>
                              </div>
                              <div class="col-xl-6">
                                 <select name="section_name" id="section_name" class="select2 form-control" required>
                                    <?php echo $section_name_options; ?>
                              </select>
                              </div>
                            
                           </div> -->
                           <div class="row pb-2">
                              <div class="col-xl-6">
                                 <label for="cleave-delimiter" class="form-label">Icon</label>
                              </div><!-- end col -->
                              <div class="col-xl-6">
                                 <input type="text" id="icon_name" name="icon_name" class="form-control" value="<?php echo $icon_name; ?>" placeholder="Material Design Icon">
                              </div><!-- end col -->
                           </div>
                           <div class="row pb-2">
                              <div class="col-xl-6">
                                 <label for="cleave-delimiter" class="form-label">Folder Name</label>
                              </div><!-- end col -->
                              <div class="col-xl-6">
                                 <input type="text" id="folder_name" name="folder_name" class="form-control" value="<?php echo $screen_folder_name; ?>" required>
                              </div><!-- end col -->
                           </div>
                        </div><!-- end col -->
                        


                        <div class="col-xl-6" style="padding-left:20px;">
                           <div class="row pb-2">
                              <div class="col-xl-6">
                                 <label for="cleave-ccard" class="form-label">Order No</label>
                              </div><!-- end col -->
                              <div class="col-xl-6">
                                 <input type="number" id="order_no" name="order_no" class="form-control" value="<?php echo $order_no; ?>" required>
                              </div><!-- end col -->
                           </div>
                            <div class="row pb-2">
                              <div class="col-xl-6">
                                 <label for="main_screen" class="form-label">Active Status</label>
                              </div><!-- end col -->
                              <div class="col-xl-6">
                                 <select name="active_status" id="active_status" class="select2 form-control" required>
                                    <?php echo $active_status_options; ?>
                                 </select>
                              </div><!-- end col -->
                           </div>
                           <div class="row pb-2">
                              <div class="col-xl-6">
                                 <label for="cleave-delimiter" class="form-label">Description</label>
                              </div><!-- end col -->
                              <div class="col-xl-6">
                                 <textarea name="description" id="description" rows="5" class="form-control"><?php echo $description; ?></textarea>
                              </div><!-- end col -->
                           </div>
                        </div><!-- end col -->
                     </div>

                     <div class="row">
                        <h4 class=" mb-3 sub_header_style ">Actions</h4>
                        <div class="col-xl-6 form-group">
                           <ul class="ul_style_one">
                                 <?php echo $user_action_options; ?>
                           </ul>
                        </div>
                        <div class="col-xl-6" style="float: right; text-align:right">
                           <?php echo btn_cancel($btn_cancel); ?>
                           <?php echo btn_createupdate($folder_name_org, $unique_id, $btn_text); ?>
                        </div>
                        <div class="form-group row "> 
                           <div class="col-md-12" "> 
                              <!-- Cancel,save and update Buttons -->
                           </div> 
                        </div> 
                          
                     </div> 
                  </div> 
                  <div class="col-12 pt-4">
                      
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>
<style>
.ul_style_one li{ display: inline; padding-right: 3%;}
.ul_style_one{ padding: 20px; border: 1px solid #d6d8b3; border-radius: 10px; margin-bottom: 0;font-size: 15px;}
</style>
