<!-- This file Only PHP Functions -->
<?php include 'function.php'; ?>

<?php
// Form variables
$btn_text           = "Save";
$btn_action         = "create";
$is_btn_disable     = "";

$unique_id          = "";

$user_type               = "";
$under_user_type        = "";
$exp_under_user_type     = "";

$is_active          = 1;

if (isset($_GET["unique_id"])) {
    if (!empty($_GET["unique_id"])) {

        $uni_dec = str_replace(" ", "+", $_GET['unique_id']);
        $get_uni_id           = openssl_decrypt(base64_decode($uni_dec), $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv);

        $unique_id  = $get_uni_id;
        $where      = [
            "unique_id" => $unique_id
        ];


        $table      =  "state_creation";

        $columns    = [
            "state_name",
            //"under_user_type",
            "is_active"
        ];

        $table_details   = [
            $table,
            $columns
        ];

        $result_values  = $pdo->select($table_details, $where);

        if ($result_values->status) {

            $result_values      = $result_values->data;

            $state_name          = $result_values[0]["state_name"];
            //$under_user_type    = $result_values[0]["under_user_type"];
            $is_active          = $result_values[0]["is_active"];

            // $exp_under_user_type  = explode(",", $under_user_type);

            $btn_text           = "Update";
            $btn_action         = "update";
        } else {
            $btn_text           = "Error";
            $btn_action         = "error";
            $is_btn_disable     = "disabled='disabled'";
        }
    }
}

// $under_user_type_options = under_user_type($user_type);
// $under_user_type_options = select_option($under_user_type_options, "Select Staff", $exp_under_user_type);


$active_status_options   = active_status($is_active);

?>
 <div class="row">
      <div class="col-12">
         <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0"> Stock Position Form</h4>

            <div class="page-title-right">
                  <ol class="breadcrumb m-0">
                     <li class="breadcrumb-item"><a href="javascript: void(0);">Settings</a></li>
                     <li class="breadcrumb-item active"> Stock Position </li>
                  </ol>
            </div>

         </div>
      </div>   
  </div>



<div class="row">
    <div class="col-12">
        <div class="card">
           
            <div class="card-body">
                <form class="was-validated" autocomplete="off">
                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-xl-3">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">PO Number</label>
                                        <input type="text" id="state_name" name="state_name" class="form-control" value="<?php echo $state_name; ?>" required>
                                    </div>
                                </div><!-- end col -->
                            <div class="col-xl-3">
                                <div>
                                <label for="exampleInputdate" class="form-label">PO Date</label>
                                <input type="date" class="form-control" id="exampleInputdate">
                            </div>
                            </div>
                            <div class="col-lg-3">
                            <label for="main_screen" class="form-label">Department</label>
                                <select class="form-select mb-3" aria-label="Default select example">
                                    <option selected>Select Department </option>
                                    <option value="1">Department1</option>
                                    <option value="2">Department2</option>
                                    <option value="3">Department3</option>
                                </select>
                            
                            </div>


                            <div class="col-xl-3">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">Excutive Name</label>
                                        <input type="text" id="state_name" name="state_name" class="form-control" value="<?php echo $state_name; ?>" required>
                                    </div>
                            </div><!-- end col -->
                            <div class="col-xl-3">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">No of Consignee</label>
                                        <input type="text" id="state_name" name="state_name" class="form-control" value="<?php echo $state_name; ?>" required>
                                    </div>
                            </div><!-- end col -->
                            <div class="col-xl-3">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">No of Items in PO</label>
                                        <input type="text" id="state_name" name="state_name" class="form-control" value="<?php echo $state_name; ?>" required>
                                    </div>
                            </div><!-- end col -->
                            <div class="col-xl-3">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">QTY</label>
                                        <input type="text" id="state_name" name="state_name" class="form-control" value="<?php echo $state_name; ?>" required>
                                    </div>
                            </div><!-- end col -->
                            <div class="col-xl-3">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">Net Value</label>
                                        <input type="text" id="state_name" name="state_name" class="form-control" value="<?php echo $state_name; ?>" required>
                                    </div>
                            </div><!-- end col -->
							
							
                                <div class="col-xl-3">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">Item Code</label>
                                        <input type="text" id="state_name" name="state_name" class="form-control" value="" >
                                    </div>
                                </div><!-- end col -->
                            <div class="col-xl-3">
                                <div>
                                <label for="exampleInputdate" class="form-label">Item Details</label>
                                <input type="text" id="state_name" name="state_name" class="form-control" value="" >
                            </div>
                            </div>
                            <div class="col-xl-3">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">QTY</label>
                                        <input type="text" id="state_name" name="state_name" class="form-control" value="<?php echo $state_name; ?>" required>
                                    </div>
                            </div><!-- end col -->
                            <div class="col-xl-3">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">Billed QTY</label>
                                        <input type="text" id="state_name" name="state_name" class="form-control" value="<?php echo $state_name; ?>" required>
                                    </div>
                            </div><!-- end col -->
                            <div class="col-xl-3">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label"> Request to Bill QTY</label>
                                        <input type="text" id="state_name" name="state_name" class="form-control" value="<?php echo $state_name; ?>" required>
                                    </div>
                            </div><!-- end col -->
                            <div class="col-xl-3">
                                    <div class="mb-3">
                                        <label for="main_screen" class="form-label">Remaining QTY</label>
                                        <input type="text" id="state_name" name="state_name" class="form-control" value="<?php echo $state_name; ?>" required>
                                    </div>
                            </div><!-- end col -->
                            <div class="col-xl-3 mt-4">
							 <div class="mb-3">
								<button type="button" class="btn btn-primary btn-label rounded-pill"><i class="lab la as la-plus-circle label-icon align-middle rounded-pill fs-16 me-2"></i>   Add New</button>
								</div>
                            </div><!-- end col -->
                           
											
								<div class="table-responsive mb-4">
                                    <table class="table table-hover table-bordered align-middle table-nowrap mb-0">
										<thead class="table-light">
											<tr>
												<th>S.No</th>
												<th scope="col">Item Code</th>
												<th scope="col">Item Details</th>
												<th scope="col">QTY</th>
												<th scope="col">Billed QTY</th>
												<th scope="col">Request to Bill QTY </th>
												<th scope="col">Remaining QTY </th>
											</tr>
										</thead>
										<tbody>
											<tr>
												
												<td>1</td>
												<td>001</td>
												<td>Lenovo Laptop</td>
												<td>20</td>
												<td> 15</td>
												<td>5</td>
												<td> 5 </td>											
											</tr>
								  
										</tbody>
									</table>
								</div>


                        </div>
                </form>

            </div> <!-- end card-body -->
        </div> <!-- end card -->
    </div><!-- end col -->
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
           
            <div class="card-body">
                <form class="was-validated" autocomplete="off">
                    <div class="row">
                        <div class="col-12">
                  

                            <div class="form-group row ">
                                <div class="col-md-12" align="right">
                                    <!-- Cancel,save and update Buttons -->
                                    <?php echo btn_cancel($btn_cancel); ?>
                                    <?php echo btn_createupdate($folder_name_org, $unique_id, $btn_text); ?>
                                </div>
                            </div>
                        </div>
                </form>

            </div> <!-- end card-body -->
        </div> <!-- end card -->
    </div><!-- end col -->
</div>
