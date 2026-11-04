<!-- This file Only PHP Functions -->
<?php include 'function.php'; ?>
<?php
// Form variables
$btn_text           = "Save";
$btn_action         = "create";
$is_btn_disable     = "";
$action_type = "Create";
$unique_id          = "";
$user_type               = "";
$under_user_type        = "";
$exp_under_user_type     = "";
$is_active          = 1;
if (isset($_GET["unique_id"])) {
    if (!empty($_GET["unique_id"])) {
        // $uni_dec = str_replace(" ", "+", $_GET['unique_id']);
        // $get_uni_id           = openssl_decrypt(base64_decode($uni_dec), $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv);
        $unique_id  = $_GET["unique_id"];
        $invoice_no  = $_GET["invoice_no"];
        $where      = [
            "consignee_unique_id" => $unique_id,
            "invoice_no" => $invoice_no
        ];
        $table      =  "view_installation_followups";
        $columns    = [
            "po_unique_id",
            "po_num",
            "po_date",
            "con_contact_name",
            "con_address",
            "invoice_auto_id",
            "invoice_no",
            "invoice_date",
            "form_main_unique_id",
            "consignee_unique_id",
            "dc_required"
        ];
        $table_details   = [
            $table,
            $columns
        ];
        $result_values  = $pdo->select($table_details, $where);
        // print_r( $result_values);
        if ($result_values->status) {
            $result_values      = $result_values->data;
            $po_unique_id          = $result_values[0]["po_num"];
            // . ' / ' . $result_values[0]["po_unique_id"]
            // $po_date    = $result_values[0]["po_date"];
            $con_contact_name          = $result_values[0]["con_contact_name"];
            $con_address          = $result_values[0]["con_address"];
            $invoice_no    = $result_values[0]["invoice_no"];
            // . ' / ' . $result_values[0]["invoice_auto_id"]
            $dc_required         = $result_values[0]["dc_required"];
            $consignee_unique_id         = $result_values[0]["consignee_unique_id"];
            $orgDate = $result_values[0]["po_date"];  
            $po_date = date("d-m-Y", strtotime($orgDate));


            
            if($result_values[0]["invoice_date"]==''){
                $invoice_date='';
            }
            else{
                $orgDate1 = $result_values[0]["invoice_date"];  
                $invoice_date = date("d-m-Y", strtotime($orgDate1));
            }

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
            <h4 class="mb-sm-0"> Installation - DC & IR Document Dispatch Details</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Settings</a></li>
                    <li class="breadcrumb-item active"> Installation</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body mt-1">
                <form class="was-validated" autocomplete="off">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-6">
                                <div class="row">
                                    <div class="col-xl-3 head_po"> <label class="form-label">PO Number</label></div>
                                    <div class="col-xl-1">:</div>
                                    <div class="col-xl-8"><?php echo $po_unique_id; ?></div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-3 head_po"> <label class="form-label">PO Date</label></div>
                                    <div class="col-xl-1">:</div>
                                    <div class="col-xl-8"><?php echo $po_date; ?></div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-3 head_po"> <label class="form-label">Consignee Name</label></div>
                                    <div class="col-xl-1">:</div>
                                    <div class="col-xl-8"><?php echo $con_contact_name; ?></div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="row">
                                    <div class="col-xl-3 head_po"> <label class="form-label">Location</label></div>
                                    <div class="col-xl-1">:</div>
                                    <div class="col-xl-8"><?php echo $con_address; ?></div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-3 head_po"> <label class="form-label">Invoice No</label></div>
                                    <div class="col-xl-1">:</div>
                                    <div class="col-xl-8"><?php echo $invoice_no; ?></div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-3 head_po"> <label class="form-label">Invoice Date</label></div>
                                    <div class="col-xl-1">:</div>
                                    <div class="col-xl-8"><?php echo $invoice_date; ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    // $where      = [
                    //     "consignee_unique_id" => $unique_id
                    // ];
                    $where      = "consignee_unique_id='".$unique_id."' and invoice_no='".$invoice_no."' AND is_delete='0'";

                    $table_sub_dc      =  "dc_ir_doc_dispatch_details";
                    $columns    = [
                        "po_form_unique_id",
                        "dc_dispatch_mode",
                        "dc_pod_no",
                        "dc_pod_date",
                        "ir_dispatch_mode",
                        "ir_pod_no",
                        "ir_pod_date",
                        "name_of_courier",
                        "ins_name_of_courier",
                        "snr_dispatch_mode",
                        "snr_pod_no",
                        "snr_pod_date",
                        "snr_name_courier",
                        "unique_id",
                    ];
                    $table_details   = [
                        $table_sub_dc,
                        $columns
                    ];
                    $result_values_data  = $pdo->select($table_details, $where);
                    // print_r($result_values_data);
                    if ($result_values_data->status) {
                        $result_values_data      = $result_values_data->data;
                        $dc_dispatch_mode    = $result_values_data[0]["dc_dispatch_mode"];
                        $name_of_courier = $result_values_data[0]["name_of_courier"];
                        $dc_pod_no          = $result_values_data[0]["dc_pod_no"];
                        $dc_pod_date          = $result_values_data[0]["dc_pod_date"];
                        $ir_dispatch_mode          = $result_values_data[0]["ir_dispatch_mode"];
                        $ins_name_of_courier = $result_values_data[0]["ins_name_of_courier"];
                        $ir_pod_no          = $result_values_data[0]["ir_pod_no"];
                        $ir_pod_date         = $result_values_data[0]["ir_pod_date"];
                        $snr_dispatch_mode          = $result_values_data[0]["snr_dispatch_mode"];
                        $snr_pod_no          = $result_values_data[0]["snr_pod_no"];
                        $snr_pod_date          = $result_values_data[0]["snr_pod_date"];
                        $snr_name_courier = $result_values_data[0]["snr_name_courier"];
                        $unique_id         = $result_values_data[0]["unique_id"];
                        // $exp_under_user_type  = explode(",", $under_user_type);
                        $btn_text           = "Update";
                        $btn_action         = "update";
                    } else {
                        $btn_text           = "Error";
                        $btn_action         = "error";
                        $is_btn_disable     = "disabled='disabled'";
                    }
                    $dc_dispatch_mode_options      = [
                        [
                            "id"    => 'Hand Delivery',
                            "text"  => "Hand Delivery"
                        ],
                        [
                            "id"    => 'Courier',
                            "text"  => "Courier"
                        ],
                        [
                            "id"    => 'Transporter',
                            "text"  => "Transporter"
                        ],
                    ];
                    $dc_dispatch_mode_options    = select_option($dc_dispatch_mode_options, "Select Dispatch Mode", $dc_dispatch_mode);
                    $ir_dispatch_mode_options      = [
                        [
                            "id"    => 'Hand Delivery',
                            "text"  => "Hand Delivery"
                        ],
                        [
                            "id"    => 'Courier',
                            "text"  => "Courier"
                        ],
                        [
                            "id"    => 'Transporter',
                            "text"  => "Transporter"
                        ],
                    ];
                    $ir_dispatch_mode_options    = select_option($ir_dispatch_mode_options, "Select Ir Dispatch Mode", $ir_dispatch_mode);
                    $snr_dispatch_mode_options      = [
                        [
                            "id"    => 'Hand Delivery',
                            "text"  => "Hand Delivery"
                        ],
                        [
                            "id"    => 'Courier',
                            "text"  => "Courier"
                        ],
                        [
                            "id"    => 'Transporter',
                            "text"  => "Transporter"
                        ],
                    ];
                    $snr_dispatch_mode_options    = select_option($snr_dispatch_mode_options, "Select Snr Dispatch Mode", $snr_dispatch_mode);
                    ?>
                    <?php 
                    //  $where      = [
                    //     "consignee_unique_id" => $unique_id
                    // ];
                    $where_1      = "consignee_unique_id='$consignee_unique_id' AND invoice_no='$invoice_no' AND is_delete='0'";
                    // AND invoice_no='$invoice_no'

                    $table_ins_det      =  "installation_details";
                    $columns_1    = [
                        "documents_type",
                        "documents_type1",
                        "documents_type2"

                       
                    ];
                    $table_details_1   = [
                        $table_ins_det,
                        $columns_1
                    ];
                    $result_values_data_sts  = $pdo->select($table_details_1, $where_1);
                    // print_R($result_values_data_sts);
                    if ($result_values_data_sts->status) {
                        $result_values_data_status      = $result_values_data_sts->data;
                        $dc_sts    = $result_values_data_status[0]["documents_type"];
                        $ir_sts = $result_values_data_status[0]["documents_type1"];
                        $snr_sts = $result_values_data_status[0]["documents_type2"];
                       
                       
                        // $exp_under_user_type  = explode(",", $under_user_type);
                        $btn_text           = "Update";
                        $btn_action         = "update";
                    } else {
                        $btn_text           = "Error";
                        $btn_action         = "error";
                        $is_btn_disable     = "disabled='disabled'";
                    }
                    ?>
                    <div class="row">
                    <input type="hidden" id="dc_sts" name="dc_sts" class="form-control" value="<?php if($dc_sts!=''){ echo $dc_sts; }else{echo '';
                        }?>" required>
                    <input type="hidden" id="ir_sts" name="ir_sts" class="form-control"  value="<?php if($ir_sts!=''){ echo $ir_sts;} else{echo '';
                        } ?>" required>
                    <input type="hidden" id="snr_sts" name="snr_sts" class="form-control"  value="<?php if($snr_sts!=''){ echo $snr_sts; }else{echo '';
                        } ?>"required>
                                        

                        <div class="col-12 mt-3">
                        <?php if($dc_sts==''){ ?>
                           
                            <div class="table-responsive mb-4" id="dc_option" style="display:none;">
                                <h4 class="text-info">Delivery Document</h4>
                                <table class="table table-striped table-bordered align-middle mb-0 small_table">
                                    <thead class="table-light">
                                        <tr>
                                            <!--<th>S.No</th>-->
                                            <th scope="col">DC Dispatch Mode</th>
                                            <th scope="col">Name of the Person/Courier or Transporter Name</th>
                                            <th scope="col" id="dc_pod_tab">POD No.</th>
                                            <th scope="col">POD Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <!--<td>1</td>-->
                                            <td>
                                                <select class="form-select mb-3" id="dc_dispatch_mode" name="dc_dispatch_mode" onchange="shows()">
                                                    <!--<option value="">Select Option</option>-->
                                                    <!--<option>Hand Delivery                       </option>-->
                                                    <!--<option>Courier</option>-->
                                                    <!--<option>Transporter</option>-->
                                                    <?php echo $dc_dispatch_mode_options ?>
                                                </select>
                                            </td>
                                            <td><input type="text" id="name_of_courier" name="name_of_courier" class="form-control" value="<?php echo $name_of_courier ?>"></td>
                                            <td id="dc_pod_tab1">
                                                <input type="text" id="dc_pod_no" name="dc_pod_no" class="form-control" value="<?php echo $dc_pod_no ?>">
                                            </td>
                                            <td> <input type="date" id="dc_pod_date" name="dc_pod_date" class="form-control" value="<?php echo $dc_pod_date ?>"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <?php } else if($dc_sts!=''){?>
                                <div class="table-responsive mb-4" id="dc_option" style="display:none;">
                                <h4 class="text-info">Delivery Document</h4>
                                <table class="table table-striped table-bordered align-middle mb-0 small_table">
                                    <thead class="table-light">
                                        <tr>
                                            <!--<th>S.No</th>-->
                                            <th scope="col">DC Dispatch Mode</th>
                                            <th scope="col">Name of the Person/Courier or Transporter Name</th>
                                            <th scope="col" id="dc_pod_tab">POD No.</th>
                                            <th scope="col">POD Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <!--<td>1</td>-->
                                            <td>
                                                <!-- <select class="form-select mb-3" id="dc_dispatch_mode" name="dc_dispatch_mode" onchange="shows()"> -->
                                                    <!--<option value="">Select Option</option>-->
                                                    <!--<option>Hand Delivery                       </option>-->
                                                    <!--<option>Courier</option>-->
                                                    <!--<option>Transporter</option>-->
                                                    <!-- <?php echo $dc_dispatch_mode_options ?>
                                                </select> -->
                                                <label id="dc_dispatch_mode" name="dc_dispatch_mode" class="form-control">
                                                <?php echo $dc_dispatch_mode ?>
</label>

                                            </td>
                                            <!-- <td><input type="text" id="name_of_courier" name="name_of_courier" class="form-control" value="<?php echo $name_of_courier ?>"></td> -->
                                            <td>
                                            <label id="name_of_courier" name="name_of_courier" class="form-control">
                                                <?php echo htmlspecialchars($name_of_courier); ?>
                                            </label>
                                            </td>

                                            <!-- <td id="dc_pod_tab1">
                                                <input type="text" id="dc_pod_no" name="dc_pod_no" class="form-control" value="<?php echo $dc_pod_no ?>">
                                            </td> -->
                                            <td id="dc_pod_tab1">
    <label id="dc_pod_no" name="dc_pod_no" class="form-control">
        <?php echo htmlspecialchars($dc_pod_no); ?>
    </label>
</td>

                                            <!-- <td> <input type="date" id="dc_pod_date" name="dc_pod_date" class="form-control" value="<?php echo $dc_pod_date ?>"></td> -->
                                            <td>
    <label id="dc_pod_date" name="dc_pod_date" class="form-control">
        <?php echo date("Y-m-d", strtotime($dc_pod_date)); ?>
    </label>
</td>

                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                             <?php } if($ir_sts!=''){?>

                        
                            <div class="table-responsive mb-4" id="ir_option" style="display:none;">
                                <h4 class="text-info">Installation Document</h4>
                                <table class="table table-striped table-bordered align-middle mb-0 small_table">
                                    <thead class="table-light">
                                        <tr>
                                            <!--<th>S.No</th>-->
                                            <th scope="col">IR Dispatch Mode</th>
                                            <th scope="col">Name of the Person/Courier or Transporter Name</th>
                                            <th scope="col" id="ir_pdo_tab">POD No.</th>
                                            <th scope="col">POD Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <!--<td>1</td>-->
                                            <!-- <td><select class="form-select mb-3" id="ir_dispatch_mode" name="ir_dispatch_mode" onchange="shows1()">
                                                    <?php echo $ir_dispatch_mode_options ?> -->
                                                    <!--<option value="">Select Option</option>-->
                                                    <!--<option>Hand Delivery</option>-->
                                                    <!--<option>Courier</option>-->
                                                    <!--<option>Transporter</option>-->
                                                <!-- </select> -->
                                                <td>
    <label id="ir_dispatch_mode" name="ir_dispatch_mode" class="form-control">
    <?php echo $ir_dispatch_mode ?>
    </label>
</td>
<td>
    <label id="ins_name_of_courier" name="ins_name_of_courier" class="form-control">
        <?php echo htmlspecialchars($ins_name_of_courier); ?>
    </label>
</td>
<td id="ir_pdo_tab1">
    <label id="ir_pod_no" name="ir_pod_no" class="form-control">
        <?php echo htmlspecialchars($ir_pod_no); ?>
    </label>
</td>
<td>
    <label id="ir_pod_date" name="ir_pod_date" class="form-control">
        <?php echo date("Y-m-d", strtotime($ir_pod_date)); ?>
    </label>
</td>

                                            <!-- <td><input type="text" id="ins_name_of_courier" name="ins_name_of_courier" class="form-control" value="<?php echo $ins_name_of_courier ?>"></td>
                                            <td id="ir_pdo_tab1">
                                                <input type="text" id="ir_pod_no" name="ir_pod_no" class="form-control" value="<?php echo $ir_pod_no ?>">
                                            </td>
                                            <td> <input type="date" id="ir_pod_date" name="ir_pod_date" class="form-control" value="<?php echo $ir_pod_date ?>"></td> -->
                                        </tr>
                                    </tbody>
                                </table>
                               
                            </div>
                            <?php } else if($ir_sts==''){?>

                                <div class="table-responsive mb-4" id="ir_option" style="display:none;">
                                <h4 class="text-info">Installation Document</h4>
                                <table class="table table-striped table-bordered align-middle mb-0 small_table">
                                    <thead class="table-light">
                                        <tr>
                                            <!--<th>S.No</th>-->
                                            <th scope="col">IR Dispatch Mode</th>
                                            <th scope="col">Name of the Person/Courier or Transporter Name</th>
                                            <th scope="col" id="ir_pdo_tab">POD No.</th>
                                            <th scope="col">POD Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <!--<td>1</td>-->
                                            <td><select class="form-select mb-3" id="ir_dispatch_mode" name="ir_dispatch_mode" onchange="shows1()">
                                                    <?php echo $ir_dispatch_mode_options ?>
                        
                                                </select>
                                            </td>
                                            <td><input type="text" id="ins_name_of_courier" name="ins_name_of_courier" class="form-control" value="<?php echo $ins_name_of_courier ?>"></td>
                                            <td id="ir_pdo_tab1">
                                                <input type="text" id="ir_pod_no" name="ir_pod_no" class="form-control" value="<?php echo $ir_pod_no ?>">
                                            </td>
                                            <td> <input type="date" id="ir_pod_date" name="ir_pod_date" class="form-control" value="<?php echo $ir_pod_date ?>"></td>
                                        </tr>
                                    </tbody>
                                </table>
                               
                            </div>

                            <?php }if($snr_sts!=''){?>
                               
                            <!-- SNR FILE -->
                            <div class="table-responsive mb-4" id="snr_option" style="display:none;">
								<h4 class="text-info">Signed Document</h4>
								<table class="table table-striped table-bordered align-middle mb-0 small_table">
									<thead class="table-light">
										<tr>
											<!--<th>S.No</th>-->
											<th scope="col">Snr Dispatch Mode</th>
                                            <th scope="col">Name of the Person/Courier or Transporter Name</th>
											<th scope="col" id="snr_pdo_tab">POD No.</th>
											<th scope="col">POD Date</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<!--<td>1</td>-->
											<td><select class="form-select mb-3" id="snr_dispatch_mode" name="snr_dispatch_mode" onchange="shows2()">
											    <?php echo $snr_dispatch_mode_options?>
													
												</select>
												</td>
                                                <td><input type="text" id="snr_name_courier" name="snr_name_courier" class="form-control" value="<?php echo $snr_name_courier?>"></td>
											<td id="snr_pdo_tab1">
												<input type="text" id="snr_pod_no" name="snr_pod_no" class="form-control" value="<?php echo $snr_pod_no?>"  >
											</td>
											<td> <input type="date" id="snr_pod_date" name="snr_pod_date" class="form-control" value="<?php echo $snr_pod_date?>"  ></td>
										</tr>
									</tbody>
								</table>
								
							</div>
                            <?PHP } else if($snr_sts==''){?>
                                <div class="table-responsive mb-4" id="snr_option" style="display:none;">
								<h4 class="text-info">Signed Document</h4>
								<table class="table table-striped table-bordered align-middle mb-0 small_table">
									<thead class="table-light">
										<tr>
											<!--<th>S.No</th>-->
											<th scope="col">Snr Dispatch Mode</th>
                                            <th scope="col">Name of the Person/Courier or Transporter Name</th>
											<th scope="col" id="snr_pdo_tab">POD No.</th>
											<th scope="col">POD Date</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<!--<td>1</td>-->
											<td><select class="form-select mb-3" id="snr_dispatch_mode" name="snr_dispatch_mode" onchange="shows2()">
											    <?php echo $snr_dispatch_mode_options?>
													
												</select>
												</td>
                                                <td><input type="text" id="snr_name_courier" name="snr_name_courier" class="form-control" value="<?php echo $snr_name_courier?>"></td>
											<td id="snr_pdo_tab1">
												<input type="text" id="snr_pod_no" name="snr_pod_no" class="form-control" value="<?php echo $snr_pod_no?>"  >
											</td>
											<td> <input type="date" id="snr_pod_date" name="snr_pod_date" class="form-control" value="<?php echo $snr_pod_date?>"  ></td>
										</tr>
									</tbody>
								</table>
								
							</div>
                                <?php }?>
                            <input class="form-control" type="hidden" id="unique_id" name="unique_id" value="<?php echo $result_values_data[0]["unique_id"]?>">
								<input class="form-control" type="hidden" id="po_unique_id" name="po_unique_id" value="<?php echo $result_values[0]["po_unique_id"]?>">
                                <input class="form-control" type="hidden" id="po_num" name="po_num" value="<?php echo $result_values[0]["po_num"]?>">
                                <input class="form-control" type="hidden" id="po_date" name="po_date" value="<?php echo $result_values[0]["po_date"]?>">
                                    <input class="form-control" type="hidden" id="invoice_auto_id" name="invoice_auto_id" value="<?php echo $result_values[0]["invoice_auto_id"]?>">
                                    <input class="form-control" type="hidden" id="invoice_no" name="invoice_no" value="<?php echo $result_values[0]["invoice_no"]?>">
                                    <input class="form-control" type="hidden" id="invoice_date" name="invoice_date" value="<?php echo $result_values[0]["invoice_date"]?>">
                                    <input class="form-control" type="hidden" id="consignee_unique_id" name="consignee_unique_id" value="<?php echo $result_values[0]["consignee_unique_id"]?>">
                                    <input class="form-control" type="hidden" id="form_main_unique_id" name="form_main_unique_id" value="<?php echo $result_values[0]["form_main_unique_id"]?>">
                                    <input class="form-control" type="hidden" id="dc_required" name="dc_required" value="<?php echo $result_values[0]["dc_required"]?>">
                            <div class="form-group row ">
                                <div class="col-md-12" align="right">
                                    <!-- Cancel,save and update Buttons -->
                                    <a href="index.php?file=installation/list"><button type="button" class="btn btn-danger waves-effect waves-light">Cancel</button>
                                    </a>
                                    <?php if ($unique_id) { ?>
                                        <!-- <button type="button" class="btn btn-primary waves-effect waves-light" onclick="dispatch_save()">Update</button> -->
                                    <?php } else { ?>
                                        <button type="button" class="btn btn-primary waves-effect waves-light" onclick="dispatch_save()">Save</button>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
            </div> <!-- end card -->
        </div><!-- end col -->
    </div>
</div>
<script>
    $(document).ready(function () {
        // alert();
        shows();
        shows1();
        shows2();
        status();

});

function status(){
var dc_sts = document.getElementById('dc_sts').value;
	// alert(dc_sts);
var ir_sts = document.getElementById('ir_sts').value;
	// alert(ir_sts);
var snr_sts = document.getElementById('snr_sts').value; 
// alert(snr_sts);
if(dc_sts=='DC') {
    // alert();
    $('#dc_option').show();
    $('#ir_option').hide();
    $('#snr_option').hide();
    // $('#dc_option1').show();
    // $('#dc_option2').show();
    // $('#dc_option3').show();

} 
 if (dc_sts === 'DC' && ir_sts === 'IR') {
        $('#dc_option').show();
        $('#ir_option').show();
        $('#snr_option').hide();
    }
 if (dc_sts === 'DC' && snr_sts === 'SNR' ) {
        $('#snr_option').show();
        $('#ir_option').hide();
        $('#dc_option').show();
    } 
    if (dc_sts === 'DC' && snr_sts === 'SNR' && ir_sts === 'IR') {
        $('#snr_option').show();
        $('#ir_option').show();
        $('#dc_option').show();
    } 
// else if(ir_sts=='IR') {
//     // alert('fdgfd');
//     $('#ir_option').show();
//     $('#dc_option').hide();
//     $('#snr_option').hide();
// } 

// else if(snr_sts=='SNR') {
//     alert(hello);
//     $('#snr_option').show();
//     $('#ir_option').hide();
//     $('#dc_option').hide();
//     // $('#snr_option').show();
    
// } 
}
    
function shows(){
        var mode_of_delivery = document.getElementById('dc_dispatch_mode').value;
        // alert();
        if(mode_of_delivery == 'Hand Delivery'){
            $('#dc_pod_tab').hide();
            $('#dc_pod_tab1').hide();
        }else{
            $('#dc_pod_tab').show();
            $('#dc_pod_tab1').show();
        }
    }
    
    function shows1(){
        var mode_of_delivery1 = document.getElementById('ir_dispatch_mode').value;
        // alert();
        if(mode_of_delivery1 == 'Hand Delivery'){
            $('#ir_pdo_tab').hide();
            $('#ir_pdo_tab1').hide();
        }else{
            $('#ir_pdo_tab').show();
            $('#ir_pdo_tab1').show();
        }
    }

    function shows2(){
        var mode_of_delivery2 = document.getElementById('snr_dispatch_mode').value;
        // alert();
        if(mode_of_delivery2 == 'Hand Delivery'){
            $('#snr_pdo_tab').hide();
            $('#snr_pdo_tab1').hide();
        }else{
            $('#snr_pdo_tab').show();
            $('#snr_pdo_tab1').show();
        }
    }

    function dispatch_save() {
        // alert('hi');
        var internet_status = is_online();
        if (!internet_status) {
            sweetalert("no_internet");
            return false;
        }
        var unique_id = document.getElementById('unique_id').value;
        var po_form_unique_id = document.getElementById('form_main_unique_id').value;
        var po_num = document.getElementById('po_num').value;
        var po_auto_id = document.getElementById('po_unique_id').value;
        var po_date = document.getElementById('po_date').value;
        var consignee_id = document.getElementById('consignee_unique_id').value;
        var invoice_auto_id = document.getElementById('invoice_auto_id').value;
        var invoice_no = document.getElementById('invoice_no').value;
        var invoice_date = document.getElementById('invoice_date').value;
        var dc_required = document.getElementById('dc_required').value;
        
    var dc_sts = document.getElementById('dc_sts').value;
// 	alert(dc_sts);
	var ir_sts = document.getElementById('ir_sts').value;
// 	alert(ir_sts);
	var snr_sts = document.getElementById('snr_sts').value;   
    // alert(snr_sts);

    if(dc_sts == "DC"){
        var dc_dispatch_mode = document.getElementById('dc_dispatch_mode').value;
        var name_of_courier = document.getElementById('name_of_courier').value;
        var dc_pod_no = document.getElementById('dc_pod_no').value;
        var dc_pod_date = document.getElementById('dc_pod_date').value;
	}
    else{
        var dc_dispatch_mode = '';
        var name_of_courier = '';
        var dc_pod_no = '';
        var dc_pod_date = '';
    }
	if(ir_sts == "IR"){
        var ir_dispatch_mode = document.getElementById('ir_dispatch_mode').value;
        var ins_name_of_courier = document.getElementById('ins_name_of_courier').value;
        var ir_pod_no = document.getElementById('ir_pod_no').value;
        var ir_pod_date = document.getElementById('ir_pod_date').value;
	}
    else{
        var ir_dispatch_mode = '';
        var ins_name_of_courier = '';
        var ir_pod_no = '';
        var ir_pod_date = '';

    }
	if(snr_sts == "SNR"){
        var snr_dispatch_mode = document.getElementById('snr_dispatch_mode').value;
        var snr_name_courier = document.getElementById('snr_name_courier').value;
        var snr_pod_no = document.getElementById('snr_pod_no').value;
        var snr_pod_date = document.getElementById('snr_pod_date').value;
	}
    else{
        var snr_dispatch_mode = '';
        var snr_name_courier = '';
        var snr_pod_no = '';
        var snr_pod_date = '';
    }
        if (dc_dispatch_mode && dc_pod_date || ir_dispatch_mode && ir_pod_date || snr_dispatch_mode && snr_pod_date) {
            var is_form = form_validity_check("was-validated");
            var data = new FormData();
            data.append("unique_id", unique_id);
            data.append("po_form_unique_id", po_form_unique_id);
            data.append("po_num", po_num);
            data.append("po_auto_id", po_auto_id);
            data.append("po_date", po_date);
            data.append("consignee_id", consignee_id);
            data.append("invoice_auto_id", invoice_auto_id);
            data.append("invoice_no", invoice_no);
            data.append("invoice_date", invoice_date);
            data.append("dc_dispatch_mode", dc_dispatch_mode);
            data.append("name_of_courier", name_of_courier);
            data.append("dc_pod_no", dc_pod_no);
            data.append("dc_pod_date", dc_pod_date);
            data.append("ir_dispatch_mode", ir_dispatch_mode);
            data.append("ins_name_of_courier", ins_name_of_courier);
            data.append("ir_pod_no", ir_pod_no);
            data.append("ir_pod_date", ir_pod_date);
            data.append("snr_dispatch_mode", snr_dispatch_mode);
            data.append("snr_name_courier", snr_name_courier);
            data.append("snr_pod_no", snr_pod_no);
            data.append("snr_pod_date", snr_pod_date);
            data.append("dc_required", dc_required);
            
            data.append("action", "dc_ir_add_update");
            // if (is_form) {
            // var data 	 = $(".was-validated").serialize();
            // data 		+= "&unique_id="+unique_id+"&action=demo";
            var ajax_url = sessionStorage.getItem("folder_crud_link");
            var url = sessionStorage.getItem("list_link");
            // console.log(data);
            $.ajax({
                type: "POST",
                url: ajax_url,
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                beforeSend: function() {
                    // 	$(".createupdate_btn").attr("disabled","disabled");
                    // 	$(".createupdate_btn").text("Loading...");
                },
                success: function(data) {
                    var obj = JSON.parse(data);
                    var msg = obj.msg;
                    var status = obj.status;
                    var error = obj.error;
                    if (!status) {
                        url = '';
                        $(".createupdate_btn").text("Error");
                        // console.log(error);
                    } else {
                        if (msg == "already") {
                            // Button Change Attribute
                            url = '';
                            $(".createupdate_btn").removeAttr("disabled", "disabled");
                            if (unique_id) {
                                $(".createupdate_btn").text("Update");
                            } else {
                                $(".createupdate_btn").text("Save");
                            }
                        }
                    }
                    sweetalert(msg, url);
                },
                error: function(data) {
                    alert("Network Error");
                }
            });
        } else {
            sweetalert("form_alert");
        }
    }
</script>
<script>
// $(document).ready(function() {

// var documents_type = document.querySelector('.check_box').checked;
// var documents_type1 = document.querySelector('.check_box1').checked;
// var documents_type2 = document.querySelector('.check_box2').checked;

// else {
//     $('#snr_option').hide();
//     $('#ir_option').show();
//     $('#dc_option').show();
    
// 


    </script>
