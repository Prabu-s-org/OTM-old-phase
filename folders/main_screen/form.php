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


      $table      =  "user_screen_main";

      $columns    = [
         "screen_type_unique_id",
         "screen_main_name",
         "icon_name",
         "order_no",
         "is_active",
         "description",
         
      ];

      $table_details   = [
         $table,
         $columns
      ];

      $result_values  = $pdo->select($table_details, $where);
// print_r($result_values );
      if ($result_values->status) {

         $result_values     = $result_values->data;

         $screen_typeid           = $result_values[0]["screen_type_unique_id"];
         $screen_name              = $result_values[0]["screen_main_name"];
         $icon_name                = $result_values[0]["icon_name"];
         $order_no                 = $result_values[0]["order_no"];
         $is_active                = $result_values[0]["is_active"];
         $description              = $result_values[0]["description"];
       
       


         $btn_text           = "Update";
         $btn_action         = "update";
      } else {
         $btn_text           = "Error";
         $btn_action         = "error";
         $is_btn_disable     = "disabled='disabled'";
      }
   }
}


$active_status_options = active_status($is_active);



$screen_typeoptions = screen_type($screen_typeid);

//  print_r($screen_typeoptions);die();

$screen_typeoptions = select_option($screen_typeoptions,"");



?>

<div class="wizard-form-field">
   <div class="row">
      <div class="col-12">
         <div class="card p-5">
            <h4 class=" mb-3 sub_header_style ">Main Screen</h4>
            <form class="was-validated" autocomplete="off">
               <div class="row">
                  <div class="col-12">
                        <!-- <h4 class="header-title">Delivery / Invoice Details </h4> -->

                     <!-- --------------------------Designed by MI ------------------------------->
                     <div class="row pb-3">
                        <div class="col-xl-6 " style="padding-right: 20px;">
                           <div class="row pb-2">
                              <div class="col-xl-6">
                                 <label for="main_screen" class="form-label">Screen Type</label>
                              </div><!-- end col -->
                              <div class="col-xl-6">
                                 <select name="screen_type" id="screen_type" class="select2 form-control"  required>
                                   <?php echo $screen_typeoptions;?>
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
                                 <label for="cleave-delimiter" class="form-label">Icon</label>
                              </div><!-- end col -->
                              <div class="col-xl-6">
                                 <input type="text" id="icon_name" name="icon_name" class="form-control" value="<?php echo $icon_name; ?>" placeholder="Material Design Icon" required>
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

                      </form>

                     <div class="row">
                        <!-- ss -->
                        <div class="col-xl-12" style="float: right; text-align:right">
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
              
            </div>
         </div>
      </div>
   </div>
</div>
<style>
.ul_style_one li{ display: inline; padding-right: 3%;}
.ul_style_one{ padding: 20px; border: 1px solid #d6d8b3; border-radius: 10px; margin-bottom: 0;font-size: 15px;}
</style>
