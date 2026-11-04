<!-- This file Only PHP Functions -->
<?php include 'function.php'; ?>
<?php
include '../../config/dbconfig.php';
include '../../inc/header.php';
include '../../inc/footer.php';

$btn_text           = "Save";
$btn_action         = "create";
$is_btn_disable     = "";

$unique_id          = "";

$user_type               = "";
$under_user_type        = "";
$exp_under_user_type     = "";

$is_active          = 1;

$session_approved_by= $_SESSION["user_name"];      

if (isset($_GET["unique_id"])) {
    if (!empty($_GET["unique_id"])) {

        // $uni_dec = str_replace(" ", "+", $_GET['unique_id']);
        // $get_uni_id           = openssl_decrypt(base64_decode($uni_dec), $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv);

        $unique_id  = $_GET["unique_id"];
        $where      = [
            "invoice_unique_id" => $unique_id
        ];


        $table      =  "view_doc_approval_list_final";

        $columns    = [
            "po_num",
           "po_date",
           "con_contact_name",
           "con_address",
            "invoice_no",
            "doc_approval_sts",
            "approved_by",
            "invoice_unique_id",
            "invoice_date",
            "form_main_unique_id",
            "doc_approval_sts",
           
        ];

        $table_details   = [
            $table,
            $columns
        ];

        $result_values  = $pdo->select($table_details, $where);
            // print_r($result_values);

        if ($result_values->status) {

            $result_values      = $result_values->data;

            $po_num          = $result_values[0]["po_num"];
           
            $po_date          = $result_values[0]["po_date"];
             $con_contact_name          = $result_values[0]["con_contact_name"];
              $con_address          = $result_values[0]["con_address"];
               $invoice_no          = $result_values[0]["invoice_no"];
            
            $doc_approval_sts          = $result_values[0]["doc_approval_sts"];
            $invoice_unique_id         = $result_values[0]["invoice_unique_id"];
             $invoice_date        = $result_values[0]["invoice_date"];
              $form_main_unique_id        = $result_values[0]["form_main_unique_id"];
              $doc_approval_sts        = $result_values[0]["doc_approval_sts"];


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

$appr_type_options      = [
    [
        "id"    => 1,
        "text"  => "Apporval"
    ],
    [
        "id"    => 2,
        "text"  => "Not Apporval"
    ],
    
];

$appr_type_options    = select_option($appr_type_options,"Select Approved Type",$doc_approval_sts);

?>
<style>
    label {
  /* font-weight: bold;
  color: black; */
  margin-right: 20px;
  /* You can add more styles as needed */
}
/* .form-label {
  display: inline-block;
  width: 100px;
  text-align: left;
}

.form-label {
 
  margin-left: 10px;
}

.form-label span {
  margin-left: 10px;
} */

</style>
<div class="row">
	<div class="col-12">
		<div class="page-title-box d-sm-flex align-items-center justify-content-between">
			<h4 class="mb-sm-0"> Docs Approval</h4>
			<div class="page-title-right">
				<ol class="breadcrumb m-0">
					<li class="breadcrumb-item"><a href="javascript: void(0);">Settings</a></li>
					<li class="breadcrumb-item active"> Docs Approval </li>
				</ol>
			</div>

		</div>
	</div>
</div>
<div class="row cf">
    <div class="col-12">
        <div class="card">
            
            <div class="card-body">
                <form class="was-validated" autocomplete="off">
                     <input type="hidden" name="approved_by" id="approved_by" value="<?php echo $session_approved_by ?>">
                     <!--<input type="hidden" name="doc_approval_sts" id="doc_approval_sts" value="">-->
                      <input type="hidden" name="invoice_unique_id" id="invoice_unique_id" value="<?php echo $invoice_unique_id?>">
                    <input type="hidden" name="form_main_unique_id" name="form_main_unique_id" value="<?php echo $form_main_unique_id?>">
                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="row">
                                        <div class="col-md-3">PO No</div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-8"><?php echo $po_num ?></div>
                                        
                                    </div>
                                </div><!-- end col -->
                                <div class="col-xl-6">
                                    <div class="row">
                                     <div class="col-md-3">PO Date</div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-8"><?php echo $po_date ?></div>
                                       
                                    </div>
                                </div><br><br>
                                <div class="col-xl-6">
                                    <div class="row">
                                    <div class="col-md-3">Consignee Name</div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-8"><?php echo $con_contact_name ?></div>
                                        
                                    </div>
                                </div><br><br>
                                <div class="col-xl-6">
                                    <div class="row">
                                    <div class="col-md-3">Consignee Location</div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-8"><?php echo $con_address ?>i</div>
                                        
                                    </div>
                                </div><br><br>
                                <div class="col-xl-6">
                                    <div class="row">
                                    <div class="col-md-3">Invoice No</div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-8"><?php echo $invoice_no ?></div>
                                        
                                    </div>
                                </div><br><br>
                                <div class="col-xl-6">
                                    <div class="row">
                                    <div class="col-md-3">Invoice Date</div>
                                        <div class="col-md-1">:</div>
                                        <div class="col-md-8"><?php echo  $invoice_date?></div>
                                        
                                    </div>
                                </div><br><br>
                              
                               
                                <div class="col-xl-3">
                                    <div class="mb-3">
                                        <label class="form-label">Approved Status</label>
                                        
                                        <select name="doc_approval_sts" id="doc_approval_sts" class="select2 form-control" required value="">
                                            <?php echo $appr_type_options;?>
                                            <!--<option value="select">Select Option</option>-->
                                            <!--<option value="Apporval">Apporved</option>-->
                                            <!--<option value="Not_Apporval">Rejected</option>-->
                                        <!--<option value="1">Apporval</option>-->
                                        <!--<option value="2">Not Apporval</option>-->
                                        </select>
                                        <!-- <button style="left: 350px;" type="button" class="btn btn-danger">Submit</button> -->
                                    </div>
                                    
                                   
                                    <!-- <button id="btn" style="left: 350px;padding: 10px 20px;border-left: 1px ;" type="button" class="btn btn-danger">Submit</button> -->
                                </div>
                                <div class="form-group row ">
                                <div class="col-md-12" align="right">
                                    <!-- Cancel,save and update Buttons -->
                                    <?php echo btn_cancel($btn_cancel); ?>
                                    <?php echo btn_createupdate($folder_name_org, $unique_id, $btn_text); ?>
                                </div>
                            </div>
                                <!-- <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label for="cleave-delimiter" class="form-label">Active Status</label>
                                        <select name="is_active" id="is_active" class="select2 form-control" required>
                                            <?php echo $active_status_options; ?>
                                        </select>
                                    </div>
                                </div> -->
                            </div>
                            <!-- <div class="form-group row ">
                                <div class="col-md-12" align="center">

                                    <button type="button" class="btn btn-danger">Submit</button>
                                </div>
                            </div> -->
                            <!-- <div class="form-group row ">
                                <div class="col-md-12" align="right"> -->
                            <!-- Cancel,save and update Buttons -->
                            
                            <!-- <button type="submit">Submit</button> -->
                        </div>
                    </div>
            </div>
            </form>

        </div> <!-- end card-body -->
    </div> <!-- end card -->
</div><!-- end col -->
</div>

