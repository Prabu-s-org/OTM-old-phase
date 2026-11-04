<style>
    .footer {
        right: 0%;}
</style>

<!--This file Only PHP Functions-->
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


$sess_user_id   =   $_SESSION["user_type_unique_id"];

// echo 'test';

// print_r('test');die();
// print_r($sess_user_id);die();

 
        // $sess_user_id = $_SESSION['user_id'] ?? '';
$is_admin = (($sess_user_id == '5f97fc3257f2525529')|| ($sess_user_id == '65deef78ba17d65741'));


        

if (isset($_GET["unique_id"])) {
    if (!empty($_GET["unique_id"])) {

        $invoice_no  = $_GET["invoice_no"];
        $unique_id  = $_GET["unique_id"];
        $dc_number = $_GET["dc_number"];
        $where      = [
            "consignee_unique_id" => $unique_id,
            "invoice_no" => $invoice_no,
            "dc_number" => $dc_number
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
            "ins_reqired",
            "dc_required",
            "dc_number",
            "DATE_FORMAT(dc_date, '%d-%m-%Y') AS dc_date",
              "(SELECT bulk_eng_type from invoice_creation_main where  invoice_creation_main.invoice_no = view_installation_followups.invoice_no and invoice_creation_main.dc_number = view_installation_followups.dc_number)as bulk_engineer_type",
            "(SELECT bulk_eng_name from invoice_creation_main where  invoice_creation_main.invoice_no = view_installation_followups.invoice_no and invoice_creation_main.dc_number = view_installation_followups.dc_number)as bulk_engineer_name",
            
        "(SELECT vendor_bulk_rate from invoice_creation_main where  invoice_creation_main.invoice_no = view_installation_followups.invoice_no and invoice_creation_main.dc_number = view_installation_followups.dc_number  AND invoice_creation_main.vendor_bulk_sts = '1')as vendor_bulk_rate",
        
          "(SELECT vendor_bulk_gst from invoice_creation_main where  invoice_creation_main.invoice_no = view_installation_followups.invoice_no and invoice_creation_main.dc_number = view_installation_followups.dc_number AND invoice_creation_main.vendor_bulk_sts = '1')as vendor_bulk_gst",
          
              "(SELECT bulk_total_amount from invoice_creation_main where  invoice_creation_main.invoice_no = view_installation_followups.invoice_no and invoice_creation_main.dc_number = view_installation_followups.dc_number AND invoice_creation_main.vendor_bulk_sts = '1')as bulk_ttl_amnt",
          
          "(SELECT vendor_bulk_zone from invoice_creation_main where  invoice_creation_main.invoice_no = view_installation_followups.invoice_no and invoice_creation_main.dc_number = view_installation_followups.dc_number AND  invoice_creation_main.vendor_bulk_sts = '1')as vendor_bulk_zone",
          
           "(SELECT vendor_bulk_timeline from invoice_creation_main where  invoice_creation_main.invoice_no = view_installation_followups.invoice_no and invoice_creation_main.dc_number = view_installation_followups.dc_number AND invoice_creation_main.vendor_bulk_sts = '1')as vendor_bulk_timeline",
           
"(SELECT CASE 
     WHEN SUM(CASE WHEN document_required = 'ir_required' THEN 1 ELSE 0 END) > 0 
     THEN 2 
     ELSE 1 
 END 
 FROM product_details_sub 
 WHERE form_main_unique_id = view_installation_followups.form_main_unique_id) AS doc_required_status",


            // "engineer_name",
            // "engineer_name",
            "date",
            "engg_type",
            "in_charge",
            "eng_remarks",
            "department",
            "con_district",
            "con_pincode",
            "con_state_name",
            "zone",
        ];

        $table_details   = [
            $table,
            $columns
        ];
        // $groupby = "Group by dc_number";
        $result_values  = $pdo->select($table_details, $where);
        //  print_r($result_values);die();


         

        if ($result_values->status) {

            $result_values      = $result_values->data;

            $po_unique_id          = $result_values[0]["po_num"];
            
            $con_contact_name          = $result_values[0]["con_contact_name"];
            $con_address          = $result_values[0]["con_address"];
            $invoice_no    = $result_values[0]["invoice_no"];
            
            
            
            $doc_required_status = $result_values[0]["doc_required_status"];
            
            if($doc_required_status == 1){

                $doc_type = "DC Required";
            }else{
                $doc_type = "IR Required";
            }

            // print_r($doc_required_status);die();
            
            // print_r($doc_required_status);s
            $consignee_unique_id         = $result_values[0]["consignee_unique_id"];
            $dc_required         = $result_values[0]["dc_required"];
            $ins_reqired    = $result_values[0]["ins_reqired"];
            
            
            

                $engineer_type = $result_values[0]["engineer_type"]; 
                
                
                 $total_amount = $result_values[0]["bulk_ttl_amnt"]; 
                 
                  $gst = $result_values[0]["vendor_bulk_gst"]; 
                
                
                   $bulk_engineer_type = $result_values[0]["bulk_engineer_type"]; 
                  
                //   print_r($bulk_engineer_type);die();
                  
                  
                 $bulk_engineer_name = $result_values[0]["bulk_engineer_name"]; 
                
                if($bulk_engineer_type == 'outsource-vendor'){
                    
                     $engg_type = '2';

                    // print_r($engg_type);
                }
                
                else if($bulk_engineer_type == 'own-engineer'){
                    
                     $engg_type = '1';
                }
               


            $dc_number = $result_values[0]["dc_number"]; 
            $dc_date = $result_values[0]["dc_date"]; 

                
    
             $engineer_name_inv = $result_values[0]["engineer_name"]; 
             
            $date = $result_values[0]["date"];  

            $vendor_bulk_timeline = $result_values[0]["vendor_bulk_timeline"];  
            
            // $engg_type = $result_values[0]["engg_type"];
            $in_charge = $result_values[0]["vendor_bulk_rate"];
            
            $eng_remarks = $result_values[0]["eng_remarks"];  
              $department = $result_values[0]["department"];
              $con_district = $result_values[0]["con_district"];
              $con_state_name = $result_values[0]["con_state_name"];
              $zone = $result_values[0]["zone"];
              $con_pincode = $result_values[0]["con_pincode"];
            $orgDate = $result_values[0]["po_date"];
            $po_date = date("d-m-Y", strtotime($orgDate));

            if($result_values[0]["invoice_date"]==''){
                $invoice_date='';
            }
            else{
            
                $orgDate1 = $result_values[0]["invoice_date"];
                $invoice_date = date("d-m-Y", strtotime($orgDate1));
    
            }

           

            $btn_text           = "Update";
            $btn_action         = "update";
        } else {
            $btn_text           = "Error";
            $btn_action         = "error";
            $is_btn_disable     = "disabled='disabled'";
        }
    }
}


// if($bulk_engineer_type == 'outsource-vendor'){
    
    
//     //  print_r('tet');die();
//       $engineer_type_options = vendor_names();
//     //   print_r($engineer_type_options);
//         $engineer_type_options1 = select_option($engineer_type_options, "Select Eng Name", $bulk_engineer_name);
        
//             // print_r($engineer_type_options1);die();

    
// }

// elseif ($bulk_engineer_type == 'own-engineer') {
    
    
//     $engineer_name_options = engineer_name();
//     $engineer_name_options1 = select_option($engineer_name_options, "Select Eng Name", $bulk_engineer_name);
    
//     // print_r($engineer_name_options1);die();
// }



if (!empty($bulk_engineer_type) && !empty($bulk_engineer_name)) {

    if ($bulk_engineer_type == 'own-engineer') {
        
        $engineer_data = engineer_name(); 
        // print_r($engineer_data);die();
        
        // print_r($engineer_data);die();// should return [unique_id => name]
    } elseif ($bulk_engineer_type == 'outsource-vendor') {
        
        $engineer_data = vendor_names();
        // print_r($engineer_data);die();// should return [unique_id => name]

        // print_r($engineer_data);die();
    }
    
    $engineer_list = [];
    
foreach ($engineer_data as $row) {
    
      $engineer_list[$row['unique_id']] = $row['engineer_name'] ?? $row['name'] ?? 'Unknown';
    // $engineer_list[$row['unique_id']] = $row['name'] ?? $row['engineer_name'];
    // echo $engineer_list[$row['unique_id']] = $row['engineer_name'] ?? $row['name'] ?? 'Unknown';
}


 $engineer_name_label = $engineer_list[$bulk_engineer_name] ?? "Engineer Not Found";


} else {
    echo "<script>
        alert('NO vendor allocated');
    </script>";
}

$active_status_options   = active_status($is_active);

?>

<style>
    .head_po {
        font-size: 14px;
        margin-bottom: 5px;
    }



    /* checkbox design start */
    .container {
        display: block;
        position: relative;
        padding-left: 35px;
        margin-bottom: 9px;
        cursor: pointer;
        font-size: 15px;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    /* Hide the browser's default checkbox */
    .container input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
        height: 0;
        width: 0;
    }

    /* Create a custom checkbox */
    .checkmark {
        position: absolute;
        top: 0;
        left: 0;
        height: 16px;
        width: 16px;
        background-color: #eee;
    }

    /* On mouse-over, add a grey background color */
    .container:hover input~.checkmark {
        background-color: #ccc;
    }

    /* When the checkbox is checked, add a blue background */
    .container input:checked~.checkmark {
        background-color: #2196F3;
    }

    /* Create the checkmark/indicator (hidden when not checked) */
    .checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }

    /* Show the checkmark when checked */
    .container input:checked~.checkmark:after {
        display: block;
    }

    /* Style the checkmark/indicator */
    .container .checkmark:after {
        left: 6px;
        top: 2px;
        width: 5px;
        height: 11px;
        border: solid white;
        border-width: 0 3px 3px 0;
        -webkit-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        transform: rotate(45deg);
    }
</style>

<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0"> Installation Form</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Settings</a></li>
                    <li class="breadcrumb-item active"> Installation </li>
                </ol>
            </div>
        </div>
    </div>
</div>


<input type="hidden" id="admin" name="admin" value="<?php echo $is_admin;?>">

<div class="card cf">
    <div class="card-body mt-1">
        <h3 class="mb-4 text-info">Installation Completed Details</h3>
        <div class="col-12">
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
                        <div class="col-xl-3 head_po"> <label class="form-label">DC No</label></div>
                        <div class="col-xl-1">:</div>
                        <div class="col-xl-8"><?php echo $dc_number; ?></div>
                        <input type="hidden" name="dc_number" id="dc_number" value="<?php echo $dc_number;?>">
                    </div>
                    <div class="row">
                        <div class="col-xl-3 head_po"> <label class="form-label">DC Date</label></div>
                        <div class="col-xl-1">:</div>
                        <div class="col-xl-8"><?php echo $dc_date; ?></div>
                        <input type="hidden" name="dc_date" id="dc_date" value="<?php echo $dc_date;?>">
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
                    
                    <div class="row">
                        <div class="col-xl-3 head_po"> <label class="form-label">Department Name</label></div>
                        <div class="col-xl-1">:</div>
                        <div class="col-xl-8"><?php echo $department; ?></div>
                    </div>
                   
                </div>
                


                <div class="col-12">
                <div class="row">
                        <div class="col-xl-3 head_po"> <label class="form-label">Consignee Name</label></div>
                        <div class="col-xl-1">:</div>
                        <div class="col-xl-8"><?php echo $con_contact_name; ?></div>
                    </div>
                    <div class="row">
                        <div class="col-xl-3 head_po"> <label class="form-label">Consignee Address</label></div>
                        <div class="col-xl-1">:</div>
                        <div class="col-xl-8"><?php echo $con_address; ?></div>
                    </div>
                    <div class="row">
                        <div class="col-xl-3 head_po"> <label class="form-label">Consignee State Name</label></div>
                        <div class="col-xl-1">:</div>
                        <div class="col-xl-8"><?php echo $con_state_name; ?></div>
                    </div>
                    <div class="row">
                        <div class="col-xl-3 head_po"> <label class="form-label">Consignee District Name</label></div>
                        <div class="col-xl-1">:</div>
                        <div class="col-xl-8"><?php echo $con_district; ?></div>
                    </div>
                    <div class="row">
                        <div class="col-xl-3 head_po"> <label class="form-label">Consignee Zone</label></div>
                        <div class="col-xl-1">:</div>
                        <div class="col-xl-8"><?php echo $zone; ?></div>
                    </div>
                    <div class="row">
                        <div class="col-xl-3 head_po"> <label class="form-label">Pincode</label></div>
                        <div class="col-xl-1">:</div>
                        <div class="col-xl-8"><?php echo $con_pincode; ?></div>
                    </div>

                    <div class="row">
                        <div class="col-xl-3 head_po"> <label class="form-label">Document Type</label></div>
                        <div class="col-xl-1">:</div>
                        <div class="col-xl-8"><?php echo  $doc_type; ?></div>
                    </div>
                    
                   
                    <?php if(!$is_admin){?>
                        <div class="row">
                        <div class="col-xl-3 head_po"> <label class="form-label">Engineer Type</label></div>
                        <div class="col-xl-1">:</div>
                        <div class="col-xl-8"> <?= ($bulk_engineer_type == 'own-engineer') ? 'Own Engineer' : 'Outsource Vendor';  ?></div>
                    </div>
                    
                      <div class="row">
                        <div class="col-xl-3 head_po"> <label class="form-label">Engineer Name</label></div>
                        <div class="col-xl-1">:</div>
                        <div class="col-xl-8"><?php echo $engineer_name_label; ?></div>
                    </div>
                    
                    <?php if($engg_type == '2'){?>

                        <div class="row">
                        <div class="col-xl-3 head_po"> <label class="form-label">Rate</label></div>
                        <div class="col-xl-1">:</div>
                        <div class="col-xl-8"><?php echo $in_charge; ?></div>
                    </div>
                    
                
                     <div class="row">
                        <div class="col-xl-3 head_po"> <label class="form-label">GST</label></div>
                        <div class="col-xl-1">:</div>
                        <div class="col-xl-8"><?php echo $gst; ?></div>
                    </div>
                    
                     <div class="row">
                        <div class="col-xl-3 head_po"> <label class="form-label">Total Gross Amount</label></div>
                        <div class="col-xl-1">:</div>
                        <div class="col-xl-8"><?php echo $total_amount; ?></div>
                    </div>
                    <?php } ?>

                 
                    
                    <?php } ?>
                      
                    </div>
                    <div class="col-6">
                    <?php if($installation_status=='3'){?>
                    <div class="row">
                        <div class="col-xl-3 head_po"> <label class="form-label">Reject Reason</label></div>
                        <div class="col-xl-1">:</div>
                        <div class="col-xl-8"><?php echo $sign_reject_reason; ?></div>
                    </div>
                    <?php } ?>
                    
                    </div>
                    <div class="col-12 mt-2">
										<div class="table-responsive mb-4">
										<table class="table table-striped table-bordered align-middle mb-0 small_table">
    <thead class="table-light">
        <tr>
            <th>S.No</th>
            <th scope="col">Item Code</th>
            <th scope="col">Item Details</th>
            <th scope="col">Item QTY</th>
            <th scope="col">Stock QTY</th>
            <th scope="col">Delivery Date</th>
            <th scope="col">Installation Date</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $search  = $_POST['search']['value'];    
        $length  = $_POST['length'];
        $start   = $_POST['start'];
        $draw    = $_POST['draw'];
        $limit   = $length;

        if ($length == '-1') {
            $limit = "";
        }

        $where1 = "form_main_unique_id = '".$result_values[0]["form_main_unique_id"]."' AND is_delete=0";
        $where2 = "unique_id = '".$result_values[0]["form_main_unique_id"]."' AND is_delete=0";
        $groupBy = "item_code, stock_date";
        $limit = null;
        $start = null;
        $order_by = null;

        // Stock query
        $table1 = "stock_position_sublist";
        $columns1 = [
            "item_code",
            "product",
            "item_qty",
            "SUM(stock_qty) AS stock_qty",
            "stock_date",
            "unique_id",
            "form_main_unique_id"
        ];
        $table_details1 = [$table1, $columns1];

        // Delivery date query
        $table2 = "po_form";
        $columns2 = [
            "DATE_FORMAT(ld_delivery_due_date,'%d-%m-%Y')as ld_delivery_due_date",
        "DATE_FORMAT(ld_installation_due_date,'%d-%m-%Y')as ld_installation_due_date"
    ];
        $table_details2 = [$table2, $columns2];

        $values_product = $pdo->select($table_details1, $where1, "", "", "", "", $groupBy);
        $values_date    = $pdo->select($table_details2, $where2);
        // Extract the delivery date safely
        $delivery_date = "";
        if (!empty($values_date->data) && isset($values_date->data[0]['ld_delivery_due_date'])) {
            $delivery_date = $values_date->data[0]['ld_delivery_due_date'];
            $installation_date = $values_date->data[0]['ld_installation_due_date'];
        }

        $j = 1;
        if ($values_product->status) {
            $product_array = $values_product->data;

            foreach ($product_array as $key => $product) {
                ?>
                <tr>
                    <td><?php echo $j; ?></td>
                    <td><?php echo $product['item_code']; ?></td>
                    <td><?php echo $product['product']; ?></td>
                    <td><?php echo $product['item_qty']; ?></td>
                    <td><?php echo $product['stock_qty']; ?></td>
                    <td><?php echo $delivery_date; ?></td>
                    <td><?php echo $installation_date; ?></td>
                </tr>
                <?php
                $j++;
            }
        }
        ?>
    </tbody>
</table>

										</div>
									</div>
            </div>
        </div>
        
        <?php
        $where      = [
            "consignee_unique_id" => $unique_id,
            "invoice_no" => $invoice_no,
            "dc_number" => $dc_number,
            "is_delete" => 0,
            
        ];

        $table_sub_install      =  "installation_details";

        $columns    = [
            "po_form_unique_id",
            "engineer_name",
            "installation_com_date",
            "cus_ack_date",
            "documents_type",
            "documents_type1",
            "documents_type2",
            "dc_received_sts",
            "dc_cus_signed_date",
            "ir_rec_status",
            "ir_cus_signed_date",
            "snr_rec_status",
            "snr_cus_signed_date",
            "dc_file",
            "ir_file",
            "snr_file",
            "unique_id",
            "consignee_unique_id",
            "dc_original_name",
            "ir_original_name",
            "snr_original_name",
            "dc_required"
        ];

        $table_details   = [
            $table_sub_install,
            $columns
        ];

        $result_values_data  = $pdo->select($table_details, $where);
// print_r($result_values_data);die();
        if ($result_values_data->status) {

            $result_values_data      = $result_values_data->data;
            $engineer_name    = $result_values_data[0]["engineer_name"];
            $installation_com_date          = $result_values_data[0]["installation_com_date"];
            $cus_ack_date          = $result_values_data[0]["cus_ack_date"];
            $documents_type          = $result_values_data[0]["documents_type"];
            $documents_type1          = $result_values_data[0]["documents_type1"];
            $documents_type2          = $result_values_data[0]["documents_type2"];

            $dc_received_sts          = $result_values_data[0]["dc_received_sts"];

            $dc_cus_signed_date         = $result_values_data[0]["dc_cus_signed_date"];
            $ir_rec_status         = $result_values_data[0]["ir_rec_status"];
            $ir_cus_signed_date = $result_values_data[0]["ir_cus_signed_date"];
            $snr_rec_status         = $result_values_data[0]["snr_rec_status"];
            $snr_cus_signed_date         = $result_values_data[0]["snr_cus_signed_date"];

            $ir_file         = $result_values_data[0]["ir_file"];
            $ir_file_show = image_view_ir_file("installation", $result_values_data[0]['consignee_unique_id'], $result_values_data[0]['ir_file']);

            $dc_file         = $result_values_data[0]["dc_file"];
            $dc_file_show = image_view_dc_file("installation", $result_values_data[0]['consignee_unique_id'], $result_values_data[0]['dc_file']);
            
            
            // print_r($dc_file_show);die();

           
            $snr_file         = $result_values_data[0]["snr_file"];
            $snr_file_show =  image_view_snr_file("installation", $result_values_data[0]['consignee_unique_id'], $result_values_data[0]['snr_file']);
           
            $dc_original_name         = $result_values_data[0]["dc_original_name"];
            $ir_original_name         = $result_values_data[0]["ir_original_name"];
            $snr_original_name         = $result_values_data[0]["snr_original_name"];


            $sign_unique_id         = $result_values_data[0]["unique_id"];

            $dc_required         = $result_values_data[0]["dc_required"];
            $consignee_unique_id         = $result_values_data[0]["consignee_unique_id"];



            $btn_text           = "Update";
            $btn_action         = "update";
        } else {
            $btn_text           = "Error";
            $btn_action         = "error";
            $is_btn_disable     = "disabled='disabled'";
        }


        $dc_received_sts_options      = [
            [
                "id"    => '1',
                "text"  => "Yes"
            ],
            

        ];
        $dc_received_sts_options    = select_option($dc_received_sts_options, "Select Status", $dc_received_sts);

        $ir_rec_status_options      = [
            [
                "id"    => '1',
                "text"  => "Yes"
            ],
           

        ];

        $ir_rec_status_options    = select_option($ir_rec_status_options, "Select Status", $ir_rec_status);

        $snr_rec_status_options      = [
            [
                "id"    => '1',
                "text"  => "Yes"
            ],
           

        ];

        $snr_rec_status_options    = select_option($snr_rec_status_options, "Select Status", $snr_rec_status);
        
        $engineer_name_options = engineer_name();
        $engineer_name_options = select_option($engineer_name_options, "Select Eng Name", $engineer_name);
        
        $engineer_type_options = engineer_type();
        $engineer_type_options = select_option($engineer_type_options, "Select Eng Type", $engineer_name);
        

        ?>
     

<div class="card p-3">
        <form class="was-validated" autocomplete="off">
            <div class="row">

            <input type="hidden" id="sess_id" name="sess_id" value="<?= $sess_user_id;?>">
        
                <div class="col-12 mt-3">
                <?php if ($is_admin) { ?>
                   
                <div class="row">
                      <?php if ($is_admin) { ?>
                    <div class="col-3">
                        
                        
                      
    <label class="form-label">Engg. Type</label>
    
    
    
        <select id="engg_type" name="engg_type" class="form-control" required <?php if($bulk_engineer_type){echo 'disabled';} ?>>
            <option value="" <?= (!$bulk_engineer_type == '') ? 'selected' : '' ?>>Select Engineer Type</option>
            <option value="own-engineer" <?= ($bulk_engineer_type == 'own-engineer') ? 'selected' : '' ?>>Own Engineer</option>
            <option value="outsource-vendor" <?= ($bulk_engineer_type == 'outsource-vendor') ? 'selected' : '' ?>>Outsource Vendor</option>
        </select>
    <?php } else { ?>
        <!--<input type="text" class="form-control" value="<?= ($bulk_engineer_type == 'own-engineer') ? 'Own Engineer' : 'Outsource Vendor'; ?>" readonly>-->
    <?php } ?>
</div>

  <?php if ($is_admin) { ?>
<div class="col-3">
   
    <label class="form-label">Engg. Name</label>
   
        <select id="engineer_name" name="engineer_name" class="form-control select2" required <?php if($engineer_list){echo 'disabled';} ?>>
            <option value="" disabled selected>Select Engineer Name</option>
            <?php foreach ($engineer_list as $id => $name) { ?>
                <option value="<?= $id ?>" <?= ($id == $bulk_engineer_name) ? 'selected' : '' ?>><?= $name ?></option>
            <?php } ?>
        </select>
    <?php } else { ?>
        <!--<input type="text" class="form-control" value="<?= $engineer_name_label ?>" readonly>-->
    <?php } ?>
</div>
                
                              <?php if ($is_admin) { ?>
                                <?php
								$today1 = date('Y-m-d');
								?>
                        <div class="col-3">
                      <label class="form-label">Installation allocation Date</label>
                             <input class="form-control" type="date" id="date" name="date" value="<?php echo $date ?>" max="<?php echo $today1; ?>" required <?php if($date){echo 'readonly';} ?>>
                            
                      </div>
                      <?php } ?>
                    
                      <?php if ($is_admin) { ?>
                                <?php
								$today1 = date('Y-m-d');
								?>
                        <div class="col-3">
                      <label class="form-label">Vendor Timeline Complition Date</label>
                             <input class="form-control" type="date" id="ven_time_line" name="ven_time_line" value="<?php echo $vendor_bulk_timeline ?>"  required <?php if($vendor_bulk_timeline){echo 'readonly';} ?>>
                            
                      </div>
                      <?php } ?>



                        <?php if($is_admin) { ?>
                            <div class="row" id="outsource-fields" style="display: none;">
                            <!-- <div class="col-12" > -->
                      <div class="col-3">
                      <label class="form-label">Rate</label>
             <input class="form-control" type="text" id="rate" name="rate" oninput="calculateGST()"
             value="<?php echo $in_charge?>" required <?php if($in_charge){echo 'readonly';} ?>>
                            
                      </div>
                      
                       <div class="col-3">
                      
                <label class="form-label">GST</label>
                
                   <select class="form-control" id="gst" name="gst" <?php if($gst){echo 'disabled';} ?>>
                    <option value="">Select GST</option>
    <option value="3"  <?php if($gst == 3) echo 'selected'; ?>>3 %</option>
    <option value="15" <?php if($gst == 15) echo 'selected'; ?>>15 %</option>
    <option value="25" <?php if($gst == 25) echo 'selected'; ?>>25 %</option>
</select>
                            
                      </div>
                      
                      
                       <div class="col-3">
                      
                            <label class="form-label">Total Amount</label>
             <input type="text" name="ttl_amnt" class="form-control" readonly id="ttl_amnt" value=<?= $total_amount;?> <?php if($total_amount){echo 'readonly';} ?>>

                </select>
                            
                      </div>
                      <!-- </div> -->
                      <!-- </div> -->
                      </div>
                     <?php } ?>
                     
                     

                      
                        <br>
                        <br>


                        
                         <?php if ($is_admin && empty($bulk_engineer_name)) {  ?>
    <div class="col-xl-2">
        <label class="form-label"></label>
        <div></div>
        <!-- <button type="button" name="btn" id="btn">Eng call Save</button> -->
        <button type="button" class="btn btn-primary" onclick="get_call_date()">Eng call Save</button>
    </div>
<?php } ?>

                            </div>
                            <?php }?>
                            <input type="hidden" name="doc_required_status" id="doc_required_status" value="<?= $doc_required_status;?>">
                            <!--<br>-->
 <br>
                   <br>
                   <label><b>Document Uploads</b></label>
                  <?php if($doc_required_status =="1"){?> 

    <!-- Hidden Install Date -->
     
    <input type="hidden" class="form-control" id="install_date" onchange="demo()" name="install_date" value="<?php echo $current_date; ?>" style="display:none;">
    <label class="container">DC
        <input name="documents_type" class="check_box" type="checkbox" data-ptag="sb1" id="documents_type" value="DC"
            <?php echo ($documents_type == 'DC') ? 'checked disabled' : ''; ?>>
        <span class="checkmark"></span>
    </label>
   <?php } else if($doc_required_status == "2") { ?>
    <!-- DC Checkbox -->
    <label class="container">DC
        <input name="documents_type" class="check_box" type="checkbox" data-ptag="sb1" id="documents_type" value="DC"
            <?php echo ($documents_type == 'DC') ? 'checked disabled' : ''; ?>>
        <span class="checkmark"></span>
    </label>

    <!-- IR Checkbox -->
    <label class="container">IR
        <input name="documents_type1" class="check_box1" type="checkbox" data-ptag="sb1" id="documents_type1" value="IR"
            <?php echo ($documents_type1 == 'IR') ? 'checked disabled' : ''; ?>>
        <span class="checkmark"></span>
    </label>

      <!-- SNR Checkbox -->
      <label class="container">SNR
        <input name="documents_type2" class="check_box2" type="checkbox" data-ptag="sb1" id="documents_type2" value="SNR"
            <?php echo ($documents_type2 == 'SNR') ? 'checked disabled' : ''; ?>>
        <span class="checkmark"></span>
    </label>

    <!-- Hidden Install Date for IR (only if IR is not already selected) -->
    <?php if ($documents_type1 != 'IR') { ?>
        <input type="hidden" class="form-control" id="ir_install_date" name="ir_install_date" value="<?php echo $current_date; ?>" style="display:none;">
    <?php } ?>
    <?php } ?>

                       <div class="row">
                           <?php if($dc_received_sts==''){ ?>
                            <div class="col-xl-3" id="dc_option" style="display:none;">
                                <label class="form-label">DC Received Status</label>
                                <select class="form-select mb-3" id="dc_received_sts" name="dc_received_sts" required>
                                    <?php echo $dc_received_sts_options; ?>
                                </select>
                            </div>
                            <?php } else if($dc_received_sts!=''){?>
                                <div class="col-xl-3" id="dc_option" style="display:none;">
                                <label class="form-label">DC Received Status</label>
                                <select class="form-select mb-3" id="dc_received_sts" name="dc_received_sts" disabled required>
                                    <?php echo $dc_received_sts_options; ?>
                                </select>
                            </div>
                                <?php }?>
                                <?php if($dc_cus_signed_date==''){ ?>
                            <div class="col-xl-3" id="dc_option1" style="display:none;">

                                <label class="form-label">DC Customer Signed Date</label>
                                <input type="date" class="form-control" id="dc_cus_signed_date" name="dc_cus_signed_date" value="<?php echo $dc_cus_signed_date ?>"  max="<?php echo date('Y-m-d'); ?>" required>

                            </div>
                            <?php } else if($dc_cus_signed_date!=''){?>
                                <div class="col-xl-3" id="dc_option1" style="display:none;">

                                <label class="form-label">DC Customer Signed Date</label>
                                <input type="date" class="form-control" id="dc_cus_signed_date" name="dc_cus_signed_date" value="<?php echo $dc_cus_signed_date ?>"  max="<?php echo date('Y-m-d'); ?>" disabled required>
                                </div>
                                <?php }?>

                                <?php if($dc_file==''){ ?>
                            <div class="col-xl-3" id="dc_option2" style="display:none;">

                                <label class="form-label">DC Signed Proof</label>
                                <input class="form-control" type="file" id="dc_file" name="dc_file" accept="application/pdf" value="<?php echo $dc_file; ?>">

                            </div>
                            <?php } else if($dc_file!=''){?>
                            <div class="col-xl-3" id="dc_option2" style="display:none;">

                                <label class="form-label">DC Signed Proof</label>
                                <div>
                                <input class="form-control" type="file" id="dc_file" name="dc_file" accept="application/pdf" disabled value="<?php echo $dc_file; ?>" disabled >
                                
                                </div> 
                            </div>
                            <div class="col-xl-3" id="dc_option3" style="display:none;">
                            <label class="form-label">DC Attached Proof</label><br>
                            
                            
                                <input class="form-control" type="hidden" id="dc_file_data" name="dc_file_data" value="<?php echo $dc_file?>">
                                <input class="form-control" type="hidden" id="dc_file_name" name="dc_file_name" value="<?php echo $dc_original_name ?>">
                           
                                <?php echo  $dc_file_show;?>
                                <?php echo $dc_original_name;?>
                            </div>
                            <?php }?>
                        </div>
                        <div class="row">
        <?php if ($ir_rec_status == '') { ?>
    <!-- IR Received Status -->
    <div class="col-xl-3" id="ir_option" style="display:none;">
        <label class="form-label">IR Received Status</label>
        <select class="form-select mb-3" id="ir_rec_status" name="ir_rec_status"
            required>
            <?php echo $ir_rec_status_options ?>
        </select>
    </div>
    <?php } else if ($ir_rec_status != '') { ?>

        <div class="col-xl-3" id="ir_option" style="display:none;">
        <label class="form-label">IR Received Status</label>
        <select class="form-select mb-3" id="ir_rec_status" name="ir_rec_status" disabled>
            <?php echo $ir_rec_status_options ?>
        </select>
    
    </div>
    <?php } ?>

    <?php if ($ir_cus_signed_date == '') { ?>  
    <!-- IR Customer Signed Date -->
    <div class="col-xl-3" id="ir_option1" style="display:none;">
        <label class="form-label">IR Customer Signed Date</label>
        <input type="date" class="form-control" id="ir_cus_signed_date" name="ir_cus_signed_date"
            value="<?php echo $ir_cus_signed_date ?>" 
            <?php //echo ($ir_cus_signed_date) ? 'disabled' : ''; ?> required max="<?php echo date('Y-m-d'); ?>">
    </div>
    <?php } else if ($ir_cus_signed_date != '') { ?>
        <div class="col-xl-3" id="ir_option1" style="display:none;">

        <label class="form-label">IR Customer Signed Date</label>
        <input type="date" class="form-control" id="ir_cus_signed_date" name="ir_cus_signed_date" value="<?php echo $ir_cus_signed_date ?>" disabled max="<?php echo date('Y-m-d'); ?>">

    </div>
<?php } ?>

    <!-- IR Signed Proof -->
    <?php if ($ir_file == '') { ?>
        <div class="col-xl-3" id="ir_option2" style="display:none;">
            <label class="form-label">IR Signed Proof</label>
            <input class="form-control" type="file" id="ir_file" name="ir_file" accept="application/pdf">
        </div>
    <?php } else { ?>
        <!-- Disabled file input -->
        <div class="col-xl-3" id="ir_option2" style="display:none;">
            <label class="form-label">IR Signed Proof</label>
            <input class="form-control" type="file" id="ir_file_display" name="ir_file_display" accept="application/pdf" disabled>
        </div>

        <!-- Display Attached File Info -->
        <div class="col-xl-3" id="ir_option3" style="display:none;">
            <label class="form-label">IR Attached Proof</label><br>
            <input type="hidden" class="form-control" id="ir_file" name="ir_file" value="<?php echo $ir_original_name; ?>">
            <input type="hidden" class="form-control" id="ir_file_data" name="ir_file_data" value="<?php echo $ir_file; ?>">
            <input type="hidden" class="form-control" id="ir_file_name" name="ir_file_name" value="<?php echo $ir_original_name; ?>">

            <?php echo $ir_file_show; ?>
            <?php echo $ir_original_name; ?>
        </div>
    <?php } ?>

</div>
<!-- NEW CANES -->
<div class="row">

<?php if ($snr_rec_status == '') { ?>
    <div class="col-xl-3" id="snr_option" style="display:none;">
        <label class="form-label">SNR Received Status</label>
        <select class="form-select mb-3" id="snr_rec_status" name="snr_rec_status">
            <?php echo $snr_rec_status_options ?>
        </select>
    </div>
<?php } else if ($snr_rec_status != '') { ?>
    <div class="col-xl-3" id="snr_option" style="display:none;">
        <label class="form-label">SNR Received Status</label>
        <select class="form-select mb-3" id="snr_rec_status" name="snr_rec_status" disabled>
            <?php echo $snr_rec_status_options ?>
        </select>
    </div>
<?php } ?>
<?php if ($snr_cus_signed_date == '') { ?>
    <div class="col-xl-3" id="snr_option1" style="display:none;">

        <label class="form-label">SNR Customer Signed Date</label>
        <input type="date" class="form-control" id="snr_cus_signed_date" name="snr_cus_signed_date" value="<?php echo $snr_cus_signed_date ?>" max="<?php echo date('Y-m-d'); ?>">

    </div>
<?php } else if ($snr_cus_signed_date != '') { ?>
    <div class="col-xl-3" id="snr_option1" style="display:none;">

        <label class="form-label">SNR Customer Signed Date</label>
        <input type="date" class="form-control" id="snr_cus_signed_date" name="snr_cus_signed_date" value="<?php echo $snr_cus_signed_date ?>" disabled max="<?php echo date('Y-m-d'); ?>">

    </div>
<?php } ?>
<?php if ($snr_file == '') { ?>
    <div class="col-xl-3" id="snr_option2" style="display:none;">

        <label class="form-label">SNR Signed Proof</label>
        <input class="form-control" type="file" id="snr_file" name="snr_file" accept="application/pdf" value="<?php echo $snr_file; ?>">

        <!-- $snr_file_show -->
    </div>
<?php } else if ($snr_file != '') { ?>


    <div class="col-xl-3" id="snr_option2" style="display:none;">
    <label class="form-label">SNR Signed Proof</label>
        <input class="form-control" type="file" id="snr_file" name="snr_file" accept="application/pdf" value="<?php echo $snr_file; ?>" disabled>

</div>

    <div class="col-xl-3" id="snr_option3" style="display:none;">

       
        <!-- <div> -->
        <label class="form-label">SNR Attached Proof</label><br>
        <input type="hidden" class="form-control" id="snr_file" name="snr_file" value="<?php echo $snr_original_name; ?>">
            <input type="hidden" class="form-control" id="snr_file_data" name="snr_file_data" value="<?php echo $snr_file; ?>">
            <input type="hidden" class="form-control" id="snr_file_name" name="snr_file_name" value="<?php echo $snr_original_name; ?>">

            <?php echo $snr_file_show; ?>
            <?php echo  $snr_original_name; ?>

       
           
        </div>

    <?php } ?>


                      
                        
                        
                       

                <input  type="hidden" class="form-control"  id="form_unique_id" name="form_unique_id" value="<?php echo $result_values_data[0]["unique_id"] ?>">
                <input class="form-control" type="hidden" id="unique_id" name="unique_id" value="<?php echo $result_values_data[0]["unique_id"] ?>">
                 <input class="form-control" type="hidden" id="po_unique_id" name="po_unique_id" value="<?php echo $result_values[0]["po_unique_id"] ?>">
                                
                                
                                <input class="form-control" type="hidden" id="po_num" name="po_num" value="<?php echo $result_values[0]["po_num"] ?>">
                                <input class="form-control" type="hidden" id="po_date" name="po_date" value="<?php echo $result_values[0]["po_date"] ?>">
                                <input class="form-control" type="hidden" id="invoice_auto_id" name="invoice_auto_id" value="<?php echo $result_values[0]["invoice_auto_id"] ?>">
                                <input class="form-control" type="hidden" id="invoice_no" name="invoice_no" value="<?php echo $result_values[0]["invoice_no"] ?>">
                                <input class="form-control" type="hidden" id="invoice_date" name="invoice_date" value="<?php echo $result_values[0]["invoice_date"] ?>">
                                <input class="form-control" type="hidden" id="consignee_unique_id" name="consignee_unique_id" value="<?php echo $result_values[0]["consignee_unique_id"] ?>">
                                <input class="form-control" type="hidden" id="po_form_unique_id" name="po_form_unique_id" value="<?php echo $result_values[0]["form_main_unique_id"] ?>">
                                <input class="form-control" type="hidden" id="dc_required" name="dc_required" value="<?php echo $result_values[0]["dc_required"] ?>">
                               <input class="form-control" type="hidden" id="ins_reqired" name="ins_reqired" value="<?php echo $result_values[0]["ins_reqired"] ?>">
                               <input class="form-control" type="hidden" id="engineer_name_inv" name="engineer_name_inv" value="<?php echo $result_values_data[0]["engineer_name"]; ?>">
                               
                               <input class="form-control" type="hidden" id="installation_status" name="installation_status" value="<?php echo $result_values[0]["installation_status"] ?>">
                               
                    <input type="hidden" id="rate_vendor" name="rate_vendor" value="<?php echo $in_charge; ?>">
                      
                     <input type="hidden" id="gst_vendor" name="gst_vendor" value="<?php echo $gst; ?>">
                    <input type="hidden" id="ttl_amnt_vendor" name="ttl_amnt_vendor" value="<?php echo $total_amount; ?>">
                    
             <input type="hidden" id="vendor_eng_name" name="vendor_eng_name" value="<?php echo $bulk_engineer_name; ?>">
             
             <input type="hidden" id="vendor_engg_type" name="vendor_engg_type" value="<?php echo $engg_type; ?>">
             
              <input class="form-control"  hidden type="date" id="date1" name="date1" value="<?php echo $date;?>" required>


                    <!---->


                        </div>
                    </div>
                </div>
        </form>
        </div>



       
        <div class="form-group row pb-3">
            <div class="col-md-12" align="right">
                <!-- Cancel,save and update Buttons -->
                <?php echo btn_cancel($btn_cancel); ?>


                <?php if ($sign_unique_id != '') { ?> 

    <?php  if (($dc_required) && ($dc_received_sts)) { ?>
        <!-- <button type="button" id="submitButton" style="display:none;" class="btn btn-primary waves-effect waves-light" onclick="installation_cu();">Update</button> -->
    <?php } elseif ($ir_cus_signed_date == '') { ?>
        <button type="button" id="submitButton" style="display:none;" class="btn btn-primary waves-effect waves-light" onclick="installation_cu();">Update</button>
    <?php }  elseif (($ir_cus_signed_date) && ($dc_received_sts)) { ?>
        <!-- <button type="button" id="submitButton" style="display:none;" class="btn btn-primary waves-effect waves-light" onclick="installation_cu();">Update</button> -->
    <?php } ?>
    
<?php } else { ?>
    <button type="button" id="submitButton" style="display:none;" class="btn btn-primary waves-effect waves-light" onclick="installation_cu();">Save</button>
<?php } ?>

                
            </div>
        </div>
        <!--</form>-->


    </div>
</div>

<script>

$(document).ready(function() {


var engg_type = document.getElementById('engg_type').value;
// // alert(engg_type);
if(engg_type != ''){
    myupdateEngineerNameOptions();
}
    document.getElementById('date').addEventListener('input', function () {
		const selectedDate = new Date(this.value);
		const today = new Date();
		today.setHours(0, 0, 0, 0); // normalize time

		if (selectedDate > today) {
			// Format today's date as YYYY-MM-DD
			const yyyy = today.getFullYear();
			const mm = String(today.getMonth() + 1).padStart(2, '0');
			const dd = String(today.getDate()).padStart(2, '0');
			this.value = `${yyyy}-${mm}-${dd}`; // set current date
		}
	});
    // Listen for changes in Engg. Type dropdown
    $('#engg_type').on('change', function() {
        updateEngineerNameOptions();
        document.getElementById('rate').value='';
        document.getElementById('gst').value='';
        document.getElementById('ttl_amnt').value='';
        document.getElementById('rate_vendor').value='';
        document.getElementById('gst_vendor').value='';
        document.getElementById('ttl_amnt_vendor').value='';
    });

    function myupdateEngineerNameOptions() {

var enggType = $('#engg_type').val();
var engineerNameSelect = $('#engineer_name');

    // var outsourceFields  = $('#outsource-fields').val();
// alert(enggType);


// Clear existing options
// engineerNameSelect.empty();

// $('#outsource-fields').hide();


// Add default option
// engineerNameSelect.append('<option value="">Select Engg. Name</option>');

// Check which Engg. Type is selected and load corresponding options
if (enggType == 'own-engineer') { // Own Engineer
    // Append Own Engineer options
// alert("working now");
document.getElementById('rate_vendor').value='';
document.getElementById('gst_vendor').value='';
document.getElementById('ttl_amnt_vendor').value='';
    // engineerNameSelect.append('');


    $('#outsource-fields').hide();

    // $('#engineer_name').append("<?php echo $engineer_name_options; ?>");
} else if (enggType == 'outsource-vendor') { // Outsource Vendor
    // Append Outsource Vendor options
    // engineerNameSelect.append('');
    $('#outsource-fields').show();

    // $('#engineer_name').append("<?php echo $engineer_type_options; ?>");
}
}
    function updateEngineerNameOptions() {

        var enggType = $('#engg_type').val();
        var engineerNameSelect = $('#engineer_name');

            // var outsourceFields  = $('#outsource-fields').val();
        // alert(enggType);

        
        // Clear existing options
        engineerNameSelect.empty();

        $('#outsource-fields').hide();

        
        // Add default option
        engineerNameSelect.append('<option value="">Select Engg. Name</option>');
        
        // Check which Engg. Type is selected and load corresponding options
        if (enggType == 'own-engineer') { // Own Engineer
            // Append Own Engineer options
// alert("working now");
document.getElementById('rate_vendor').value='';
        document.getElementById('gst_vendor').value='';
        document.getElementById('ttl_amnt_vendor').value='';
            engineerNameSelect.append('');


            $('#outsource-fields').hide();

            $('#engineer_name').append("<?php echo $engineer_name_options; ?>");
        } else if (enggType == 'outsource-vendor') { // Outsource Vendor
            // Append Outsource Vendor options
            engineerNameSelect.append('');
            $('#outsource-fields').show();

            $('#engineer_name').append("<?php echo $engineer_type_options; ?>");
        }
    }
});


$(document).ready(function(){
   
   
   var sess_id = $('#sess_id').val();
   if(sess_id === '5f97fc3257f2525529' || sess_id === '65deef78ba17d65741' ){
       
    //   alert(sess_id);
       calculateGST();
       
       document.getElementById('rate').addEventListener('input', calculateGST);
document.getElementById('gst').addEventListener('change', calculateGST);
 
} 
});


    
    
    






function calculateGST() {
    
    // Get the rate (amount entered by the user)
    // var rate = parseFloat(document.getElementById('rate').value);
    
    // // Get the selected GST percentage
    // var gstPercentage = parseFloat(document.getElementById('gst').value);
    
     var rate = parseFloat(document.getElementById('rate').value) || 0;
    var gstPercentage = parseFloat(document.getElementById('gst').value) || 0;
    
    
    // if (!rate || !gstPercentage) return;
    
    // Check if the rate is a valid number
    // if (isNaN(rate) || rate <= 0) {
    //     document.getElementById('gst_amount').value = '';
    //     document.getElementById('ttl_amnt').value = '';
    //     return;
    // }
    
    // Calculate the GST amount
    var gstAmount = (rate * gstPercentage) / 100;
    
    // Calculate the total amount (rate + gstAmount)
    var totalAmount = rate + gstAmount;
    
    // Display the calculated GST and total amount
    document.getElementById('ttl_amnt').value = totalAmount.toFixed(2);  // Display total amount with 2 decimals
}




function get_call_date() {
    // alert("cfvgbh");
    var internet_status = is_online();

    var engineer_name_inv = document.getElementById('engineer_name').value;

    // alert(engineer_name_inv);
    var engg_type = document.getElementById('engg_type').value;
    //  alert(engg_type);
    var engineer_name = document.getElementById('engineer_name').value;
    // alert(engg_type);
    var date = document.getElementById('date').value;
    var in_charge = document.getElementById('rate').value;
    
    var gst = document.getElementById('gst').value;
    
    var ttl_amnt = document.getElementById('ttl_amnt').value;
   
    var invoice_no = document.getElementById('invoice_no').value;
    // alert(invoice_no);
    var po_form_unique_id = document.getElementById('po_form_unique_id').value;
// alert(po_form_unique_id);
     var consignee_unique_id = document.getElementById('consignee_unique_id').value;
    // alert(consignee_unique_id);
    var installation_status = document.getElementById('installation_status').value;

    var dc_number = document.getElementById('dc_number').value;
    var dc_date = document.getElementById('dc_date').value;

    var ven_time_line = document.getElementById('ven_time_line').value;
    //alert(dc_number);
    //alert(dc_date);
    
    
    
    if (!engg_type) {
    Swal.fire({
        icon: 'error',
        title: 'Required',
        text: 'Please select the Engineering Type',
    });
    return false;
}

if (!engineer_name) {
    Swal.fire({
        icon: 'error',
        title: 'Required',
        text: 'Please enter the Engineer Name',
    });
    return false;
}

if (!date) {
    Swal.fire({
        icon: 'error',
        title: 'Required',
        text: 'Please enter the Date',
    });
    return false;
}

    
    var data = "engg_type=" + engg_type + "&engineer_name=" + engineer_name + "&date=" + date + "&in_charge=" + in_charge +"&gst=" + gst + "&ttl_amnt=" + ttl_amnt + "&invoice_no=" + invoice_no + "&po_form_unique_id=" + po_form_unique_id + "&consignee_unique_id=" + consignee_unique_id +"&engineer_name_inv="+engineer_name_inv+"&installation_status="+installation_status+"&dc_number="+dc_number+"&dc_date="+dc_date+"&ven_time_line="+ven_time_line; 
    data += "&action=eng_call_add_update";
    var ajax_url = sessionStorage.getItem("folder_crud_link");
    var url = sessionStorage.getItem("list_link");
    if (engg_type && engineer_name && date != '') {
    $.ajax({
        type: "POST",
        url: ajax_url,
        data: data,
        
        success		: function(data) {
            //alert(data);
            var obj     = JSON.parse(data);
            var msg     = obj.msg;
            var status  = obj.status;
            var error   = obj.error;
            
            if (!status) {
                url 	= '';
                $(".createupdate_btn").text("Error");
                console.log(error);
            }
             else {

                if (msg=="already") {
                    // Button Change Attribute
                    url 		= '';

                    $(".createupdate_btn").removeAttr("disabled","disabled");
                    if (unique_id) {
                        $(".createupdate_btn").text("Update");
                    } 
                }
            }
            // var url = 'folders/po_form/list.php';
            sweetalert(msg,url);
            

        },
        error 		: function(data) {
            // alert("Network Error");
        }
    });
}else{
    alert();
}
}




    // $(document).ready(function() {

    //     // alert();

    //     var documents_type = document.querySelector('.check_box').checked;
    //     // alert(documents_type);
    //     var documents_type1 = document.querySelector('.check_box1').checked;
    //     // alert(documents_type1);
    //     var documents_type2 = document.querySelector('.check_box2').checked;

    //     if (documents_type) {
    //         $('#dc_option').show();
    //         $('#dc_option1').show();
    //         $('#dc_option2').show();
    //         $('#submitButton').show();
    //     } else {
    //         $('#dc_option').hide();
    //         $('#dc_option1').hide();
    //         $('#dc_option2').hide();
    //         $('#submitButton').hide();
    //     }

    //     if (documents_type1) {
    //         $('#ir_option').show();
    //         $('#ir_option1').show();
    //         $('#ir_option2').show();
    //         $('#submitButton').show();
    //     } else {
    //         $('#ir_option').hide();
    //         $('#ir_option1').hide();
    //         $('#ir_option2').hide();
    //         $('#submitButton').hide();
    //     }

    //     if (documents_type2) {
    //         $('#snr_option').show();
    //         $('#snr_option1').show();
    //         $('#snr_option2').show();
    //         $('#submitButton').show();
    //     } else {
    //         $('#snr_option').hide();
    //         $('#snr_option1').hide();
    //         $('#snr_option2').hide();
    //         $('#submitButton').hide();
    //     }


    //     $("#documents_type").on('change', function() {
            
    //         var tags = $("#dc_option,#dc_option1,#dc_option2,#submitButton");
    //         if ($(this).prop('checked')) {
    //             tags.show();
    //         } else {
    //             tags.hide();
    //         }
    //     });
    //     $("#documents_type1").on('change', function() {
    //         var tags = $("#ir_option,#ir_option1,#ir_option2,#submitButton");
    //         if ($(this).prop('checked')) {
    //             tags.show();
    //         } else {
    //             tags.hide();
    //         }
    //     });
    //     $("#documents_type2").on('change', function() {
    //         var tags = $("#snr_option,#snr_option1,#snr_option2,#submitButton");
    //         if ($(this).prop('checked')) {
    //             tags.show();
    //         } else {
    //             tags.hide();
    //         }
    //     });

    // });
    
    
    
//     $(document).ready(function () {
//     // Check DC checkbox (visible)
//     if ($('.check_box').length && $('.check_box').prop('checked')) {
//         $('#dc_option, #dc_option1, #dc_option2, #dc_option3, #submitButton').show();
//     }

//     // Check IR checkbox (hidden input)
//     if ($('.check_box1').length && $('.check_box1').val() === 'IR') {
//         $('#ir_option, #ir_option1, #ir_option2, #ir_option3, #submitButton').show();
//     }

//     // Check SNR checkbox (hidden input)
//     if ($('.check_box2').length && $('.check_box2').val() === 'SNR') {
//         $('#snr_option, #snr_option1, #snr_option2, #snr_option3, #submitButton').show();
//     }

//     // For interactive checkbox (DC) - only this is visible
//     $("#documents_type").on('change', function () {
//         var tags = $("#dc_option, #dc_option1, #dc_option2, #dc_option3, #submitButton, #installation_date");
//         if ($(this).prop('checked')) {
//             tags.show();
//         } else {
//             tags.hide();
//         }
//     });
    
//       $("#documents_type1").on('change', function () {
          
//           alert('ir');
//         var tags = $("#ir_option, #ir_option1, #ir_option2, #ir_option3, #submitButton, #installation_date");
//         if ($(this).prop('checked')) {
//             tags.show();
//         } else {
//             tags.hide();
//         }
//     });
// });



// $(document).ready(function(){
    
    
    
    
//     toggleFields();
    
//     $('#documents_type').on('change',function(){
        
//         toggleFields();
        
        
//     });
    
    
//      $('#documents_type1').on('change',function(){
        
//         toggleFields();
        
        
//     });
    
    
//     // function toggleFields(){
        
    //     // alert('test');
        
        
    //     var dcChecked = $('#documents_type').is(':checked');
    //     var irChecked = $('#documents_type1').is(':checked');
        
    //     // alert(irChecked);
        
    //     if(dcChecked){
            
    //         $('#dc_option,#dc_option1,#dc_option2,#dc_option3').show();
            
    //     }
    //     else{
    //         $('#dc_option,#dc_option1,#dc_option2,#dc_option3').hide();

    //     }
        
    //     if(irChecked){
            
    //         // alert('ir');
    //          $("#ir_option,#ir_option1,#ir_option2,#ir_option3,#ir_install_date").show();
    //     }
        
    //     else{
    //          $("#ir_option,#ir_option1,#ir_option2,#ir_option3,#ir_install_date").hide();
    //     }
        
        
    //     if(dcChecked || irChecked){
    //         $('#submitButton').show();
    //     }
    //     else{
    //         $('#submitButton').hide();
    //     }
    // }
    
// });


// NEW CANES


function toggleSections() {

    var doc_required_status = $("#doc_required_status").val();

    if(doc_required_status === '1'){
       
        var isDCChecked = $("#documents_type").prop("checked");

        $("#dc_option, #dc_option1, #dc_option2,#dc_option3, #installation_date").toggle(isDCChecked);


    }

    else if(doc_required_status === '2'){

        var isDCChecked = $("#documents_type").prop("checked");
    var isIRChecked = $("#documents_type1").prop("checked");

    var isSNRChecked = $("#documents_type2").prop("checked");


    
    $("#dc_option, #dc_option1, #dc_option2,#dc_option3, #installation_date").toggle(isDCChecked);
    $("#ir_option, #ir_option1, #ir_option2,#ir_option3, #ir_install_date").toggle(isIRChecked);
    $("#snr_option, #snr_option1, #snr_option2,#snr_option3").toggle(isSNRChecked);
    }

  


    if (isDCChecked || isIRChecked || isSNRChecked) {
        $("#submitButton").show();
    } else {
        $("#submitButton").hide();
    }
}

$(document).ready(function () {
    toggleSections();

    $("#documents_type, #documents_type1, #documents_type2").on("change", function () {
        toggleSections();
    });
});




// $(document).ready(function() {

// // alert();

// // var documents_type = document.querySelector('.check_box').checked;\



// var documents_type = document.querySelector('.check_box');

// if(documents_type){

//     var isChecked  = documents_type.checked;

//     if(isChecked){

//         $("#dc_option,#dc_option1, #dc_option2, #submitButton, #installation_date").show();

//     }
//     else{
//         $("#dc_option, #dc_option1, #dc_option2, #submitButton, #installation_date").hide();

//     }
// }
// // alert(documents_type);
// var documents_type1 = document.querySelector('.check_box1');


// if(documents_type1){

// var isChecked1  = documents_type1.checked;

// if(isChecked1){

//     $("#ir_option,#ir_option1,#ir_option2,#submitButton,#ir_install_date").show();
// }
// else{
//     $("#ir_option,#ir_option1,#ir_option2,#submitButton,#ir_install_date").hide();

// }
// }


// // alert(documents_type1);
// var documents_type2 = document.querySelector('.check_box2');

// if(documents_type2){

//     var isChecked2  = documents_type2.checked;

//     if(isChecked1){

// $("#snr_option,#snr_option1,#snr_option2,#submitButton").show();
// }
// else{
//     $("#snr_option,#snr_option1,#snr_option2,#submitButton").hide();
// }

// }



// // if (documents_type) {
// //     $('#dc_option').show();
// //     $('#dc_option1').show();
// //     $('#dc_option2').show();
// //     $('#dc_option3').show();
// //     $('#installation_date').show();
// //     $('#submitButton').show();
// // } else {
// //     $('#dc_option').hide();
// //     $('#dc_option1').hide();
// //     $('#dc_option2').hide();
// //     $('#dc_option3').hide();
// //     $('#installation_date').hide();  
// //     $('#submitButton').hide();
// // }

// // if (documents_type1) {
// //     $('#ir_option').show();
// //     $('#ir_option1').show();
// //     $('#ir_option2').show();
// //     $('#ir_option3').show();
  
// //     $('#ir_install_date').show(); 
    
   
// //     $('#submitButton').show();
// // } else {
// //     $('#ir_option').hide();
// //     $('#ir_option1').hide();
// //     $('#ir_option2').hide();
// //     $('#ir_option3').hide();
// //     $('#ir_install_date').hide(); 
// //     $('#submitButton').hide();
// // }

// // if (documents_type2) {
// //     $('#snr_option').show();
// //     $('#snr_option1').show();
// //     $('#snr_option2').show();
// //     $('#snr_option3').show();
    
// //     $('#submitButton').show();
// // } else {
// //     $('#snr_option').hide();
// //     $('#snr_option1').hide();
// //     $('#snr_option2').hide();
// //     $('#snr_option3').hide();
    
// //     $('#submitButton').hide();
// // }


// $("#documents_type").on('change', function () {

// // alert('test');
//         var tags = $("#dc_option, #dc_option1, #dc_option2, #submitButton, #installation_date");
//         if ($(this).prop('checked')) {
//             tags.show();
//         } else {
//             tags.hide();
//         }
//     });
// $("#documents_type1").on('change', function() {
//     alert("#documents_type1");

//     var tags = $("#ir_option,#ir_option1,#ir_option2,#submitButton,#ir_install_date");
//     if ($(this).prop('checked')) {
//         tags.show();
//     } else {
//         tags.hide();
//     }
// });

// $("#documents_type2").on('change', function() {
//     var tags = $("#snr_option,#snr_option1,#snr_option2,#submitButton");
//     if ($(this).prop('checked')) {
//         tags.show();
//     } else {
//         tags.hide();
//     }
// });

// });



    
    // $(document).ready(function() {

    //     // alert();

      
    //     // var documents_type2 = document.querySelector('.check_box2').checked;
    //     // alert(documents_type2);
        
        
    //     var documents_type = document.querySelector('.check_box');
    //     if(documents_type){
            
    //         var isChecked = documents_type.checked;
            
    //         if(isChecked){
    //             $('#dc_option,#dc_option1,#dc_option2,#dc_option3,#submitButton').show();
    //         }else{
                
    //         $('#dc_option,#dc_option1,#dc_option2,#dc_option3,#submitButton').hide();

                
    //         }
    //     }
        
        
        
    //     var documents_type1 = document.querySelector('.check_box1');
        
    //     if(documents_type1){
            
    //         var isChecked1 = documents_type1.checked;
            
    //         alert(isChecked1);
            
    //         if(isChecked1){
    //              $("#ir_option,#ir_option1,#ir_option2,#ir_option3,#submitButton,#ir_install_date").show();
    //         }
    //         else{
    //              $('#ir_option,#ir_option1,#ir_option2,#ir_option3').hide();
    //         }
    //     }
        
    //     if(documents_type || documents_type1){
            
    //         if(isChecked ||isChecked1 ){
    //                       $('#submitButton').show();
 
    //         }
            
    //     }
    //     else{
    //          $('#submitButton').show();
    //     }

    //          if ($('#documents_type').is(':checked')) {
  

    //     $("#documents_type").on('change', function() {
            
    //         alert('test');
            
    //         var tags = $("#dc_option,#dc_option1,#dc_option2,#dc_option3,#submitButton,#installation_date");
    //         if ($(this).prop('checked')) {
    //             tags.show();
    //         } else {
    //             tags.hide();
    //         }
    //     });
        
    // //      if ($('#documents_type1').is(':checked')) {
    // //     $("#ir_option,#ir_option1,#ir_option2,#ir_option3,#submitButton,#ir_install_date").show();
    // // }
    //     $("#documents_type1").on('change', function() {
    //                     alert('ir');

    //         var tags = $("#ir_option,#ir_option1,#ir_option2,#ir_option3,#submitButton,#ir_install_date");
            
    //         if ($(this).prop('checked')) {
    //             tags.show();
    //         } else {
    //             tags.hide();
    //         }
    //     });
   
    // });
    
    
    
    
    
   



    //  sub table

//     function installation_creation_sub() {
//         // alert("from");
//         var internet_status = is_online();

//         if (!internet_status) {
//             sweetalert("no_internet");
//             return false;
//         }
        
//           var doc_required_status = $("#doc_required_status").val();
          
          
//           alert(doc_required_status);
  
// //   var sess_id = document.getElementById('sess_id').value;
        
//         // var dc_required = document.getElementById('dc_required').value;
//         // // alert(dc_required);
//         // var ins_reqired = document.getElementById('ins_reqired').value;
        
//         if(doc_required_status === '2'){
            
//             // alert("ins");
//         var po_num = document.getElementById('po_num').value;
//         // alert(po_num);
//         var po_unique_id = document.getElementById('po_unique_id').value;
//         //   alert(po_form_unique_id);
//         var po_form_unique_id = document.getElementById('po_form_unique_id').value;
//         //   alert(po_unique_id);
//         var po_date = document.getElementById('po_date').value;
//         var invoice_auto_id = document.getElementById('invoice_auto_id').value;
//         var invoice_no = document.getElementById('invoice_no').value;

//         var invoice_date = document.getElementById('invoice_date').value;
//         var consignee_unique_id = document.getElementById('consignee_unique_id').value;
        
        
        
//           var sess_id = document.getElementById('sess_id').value;
  
//   if(sess_id === '5ff562ed542d625323'){
//             var engineer_name = document.getElementById('engineer_name').value;

//   }
//   else{
//     //   alert('test');
      
//                     var engineer_name = document.getElementById('vendor_eng_name').value;
                    
//                     // alert(engineer_name);s
    
//   }
        
        
      
  
        
//         // var ins_com_date = document.getElementById('ins_com_date').value;
//         // var eng_remarks = document.getElementById('eng_remarks').value;
//         // var cus_ack_date = document.getElementById('cus_ack_date').value;

//         var dc_received_sts = document.getElementById('dc_received_sts').value;
//         var dc_cus_signed_date = document.getElementById('dc_cus_signed_date').value;
//         var ir_rec_status = document.getElementById('ir_rec_status').value;
//         var ir_cus_signed_date = document.getElementById('ir_cus_signed_date').value;
      
//         //  var consignee_unique_id = document.getElementById('consignee_unique_id').value;


//         // var form_unique_id = document.getElementById('form_unique_id').value;
        
// var dc_file_data;

// element = document.getElementById('dc_file_data');
// // alert(element);
// if (element != null) {
//     dc_file_data = element.value;
// }
// else {
//     dc_file_data = null;
// }


// var dc_file_name;
// element1 = document.getElementById('dc_file_name');
// if (element1 != null) {
//     dc_file_name = element1.value;
// }
// else {
//     dc_file_name = null;
// }



     

// var documents_type = document.getElementById('documents_type').checked;
// var documents_type1 = document.getElementById('documents_type1').checked;
// // var documents_type2 = document.getElementById('documents_type2').checked;

// // Set checkbox variables based on their checked state
// var dc_checkbox = documents_type ? 'DC' : '0';
// var ir_checkbox = documents_type1 ? 'IR' : '0';



// // If only one checkbox is checked, store its value
// if (documents_type && !documents_type1 ) {
//   // Only DC checkbox is checked
//   dc_checkbox = 'DC';
// } else if (!documents_type && documents_type1) {
//   // Only IR checkbox is checked
//   ir_checkbox = 'IR';
// }
// // If two checkboxes are checked, store both values
// if (documents_type && documents_type1) {
//   // DC and IR checkboxes are checked
//   dc_checkbox = 'DC';
// //   alert(dc_checkbox);
//   ir_checkbox = 'IR';
// //   alert(ir_checkbox);
// } else if (documents_type && !documents_type1) {
//   // DC and SNR checkboxes are checked
//   dc_checkbox = 'DC';
// } 

// else if (documents_type1 && documents_type ) {
//   // IR checkbox is checked after DC and SNR
//   dc_checkbox = 'DC';
// //   alert(dc_checkbox);
// //   alert(snr_checkbox);
//   ir_checkbox = 'IR'; // Update IR value without changing DC and SNR values
// //   alert(ir_checkbox);
// }

//         var test_doc = document.getElementById('dc_file').value;
//         // alert(test_doc);
//         var test_doc1 = document.getElementById('ir_file').value;
//         // alert(test_doc1);

//         var image_s = document.getElementById("dc_file");

//         var image_ir = document.getElementById("ir_file");


//         // var is_form = form_validity_check("was-validated");
//         var data = new FormData();
//         if (image_s != '') {
//             if (image_s.files) {
//                 for (var i = 0; i < image_s.files.length; i++) {
//                     data.append("test_file[]", document.getElementById('dc_file').files[i]);
//                 }
//             }
//         } else {

//             data.append("test_doc", '');

//         }

//         if (image_ir != '') {
//             if (image_ir.files) {
//                 for (var i = 0; i < image_ir.files.length; i++) {
//                     data.append("test_file1[]", document.getElementById('ir_file').files[i]);
//                 }
//             }
//         } else {

//             data.append("test_doc1", '');

//         }
        
        
        
//         var test_doc = document.getElementById('dc_file').value;
//         // alert(test_doc);
       
//         var image_s = document.getElementById("dc_file");

      

//         // var is_form = form_validity_check("was-validated");
//         var data = new FormData();
//         if (image_s != '') {
//             if (image_s.files) {
//                 for (var i = 0; i < image_s.files.length; i++) {
//                     data.append("test_file[]", document.getElementById('dc_file').files[i]);
//                 }
//             }
//         } else {

//             data.append("test_doc", '');

//         }

//     }

//         data.append("po_num", po_num);
//         data.append("po_form_unique_id", po_form_unique_id);
//         data.append("po_unique_id", po_unique_id);
//         data.append("po_date", po_date);
//         data.append("invoice_auto_id", invoice_auto_id);
//         data.append("invoice_no", invoice_no);
//         data.append("invoice_date", invoice_date);
//         data.append("consignee_unique_id", consignee_unique_id);
//         data.append("engineer_name", engineer_name);
//         data.append("ins_com_date", ins_com_date);
//         // data.append("eng_remarks", eng_remarks);
//         // data.append("", eng_remarks);
//         // data.append("cus_ack_date", cus_ack_date);
//         data.append("documents_type", dc_checkbox);
//         data.append("documents_type1", ir_checkbox);
//         data.append("dc_received_sts", dc_received_sts);
//         data.append("dc_cus_signed_date", dc_cus_signed_date);
//      data.append("ir_rec_status", ir_rec_status);
//      data.append("ir_cus_signed_date", ir_cus_signed_date);
//         // data.append("snr_rec_status", snr_rec_status);
//         // data.append("snr_cus_signed_date", snr_cus_signed_date);
//         // data.append("form_unique_id", form_unique_id);
//         data.append("dc_file_data", dc_file_data);
//         data.append("dc_file_name", dc_file_name);
//         // data.append("snr_file_data", snr_file_data);
//         // data.append("snr_file_name", snr_file_name);
//         data.append("action", "demo");
        
        
    
       
//     }
    
    
//     else if(doc_required_status ==='1'){
//         // alert();
//         var po_num = document.getElementById('po_num').value;
//         // alert(po_num);
//         var po_unique_id = document.getElementById('po_unique_id').value;
//         //   alert(po_form_unique_id);
//         var po_form_unique_id = document.getElementById('po_form_unique_id').value;
//         //   alert(po_unique_id);
//         var po_date = document.getElementById('po_date').value;
//         var invoice_auto_id = document.getElementById('invoice_auto_id').value;
//         var invoice_no = document.getElementById('invoice_no').value;

//         var invoice_date = document.getElementById('invoice_date').value;
//         var consignee_unique_id = document.getElementById('consignee_unique_id').value;
        
       
//         // var ins_com_date = document.getElementById('ins_com_date').value;
//         // var eng_remarks = document.getElementById('eng_remarks').value;
//         // data.append("", eng_remarks);
//         // var cus_ack_date = document.getElementById('cus_ack_date').value;
//         // var eng_remarks = document.getElementById('eng_remarks').value;
//         var dc_received_sts = document.getElementById('dc_received_sts').value;
//         var dc_cus_signed_date = document.getElementById('dc_cus_signed_date').value;
        

//         // var form_unique_id = document.getElementById('form_unique_id').value;
        
// var dc_file_data;
// element = document.getElementById('dc_file_data');
// if (element != null) {
//     dc_file_data = element.value;
// }
// else {
//     dc_file_data = null;
// }


// var dc_file_name;
// element1 = document.getElementById('dc_file_name');
// if (element1 != null) {
//     dc_file_name = element1.value;
// }
// else {
//     dc_file_name = null;
// }



     

// var documents_type = document.getElementById('documents_type').checked;
// // var documents_type = document.getElementById('documents_type').checked;
// var documents_type1 = document.getElementById('documents_type1').checked;

// // Set checkbox variables based on their checked state
// var dc_checkbox = documents_type ? 'DC' : '0';
// // var ir_checkbox = documents_type1 ? 'IR' : '0';
// // var snr_checkbox = documents_type2 ? 'SNR' : '0';


// // If only one checkbox is checked, store its value
// if (documents_type) {
//   // Only DC checkbox is checked
//   dc_checkbox = 'DC';
// } 
// // e
// // lse if (!documents_type && documents_type1 && !documents_type2) {
// //   // Only IR checkbox is checked
// //   ir_checkbox = 'IR';
// // } else if (!documents_type && !documents_type1 && documents_type2) {
// //   // Only SNR checkbox is checked
// //   snr_checkbox = 'SNR';
// // }

// // If two checkboxes are checked, store both values
// // if (documents_type && documents_type1 && !documents_type2) {
// //   // DC and IR checkboxes are checked
// //   dc_checkbox = 'DC';
// // //   alert(dc_checkbox);
// //   ir_checkbox = 'IR';
// // //   alert(ir_checkbox);
// // } 
// // else if (documents_type && !documents_type1 && documents_type2) {
// //   // DC and SNR checkboxes are checked
// //   dc_checkbox = 'DC';
// //   snr_checkbox = 'SNR';
// // } 

// // else if (documents_type1 && documents_type && documents_type2) {
// //   // IR checkbox is checked after DC and SNR
// //   dc_checkbox = 'DC';
// // //   alert(dc_checkbox);
// //   snr_checkbox = 'SNR';
// // //   alert(snr_checkbox);
// //   ir_checkbox = 'IR'; // Update IR value without changing DC and SNR values
// // //   alert(ir_checkbox);
// // }


//         var test_doc = document.getElementById('dc_file').value;
//         // alert(test_doc);
       
//         var image_s = document.getElementById("dc_file");

      

//         // var is_form = form_validity_check("was-validated");
//         var data = new FormData();
//         if (image_s != '') {
//             if (image_s.files) {
//                 for (var i = 0; i <script image_s.files.length; i++) {
//                     data.append("test_file[]", document.getElementById('dc_file').files[i]);
//                 }
//             }
//         } else {

//             data.append("test_doc", '');

//         }

    

//         data.append("po_num", po_num);
//         data.append("po_form_unique_id", po_form_unique_id);
//         data.append("po_unique_id", po_unique_id);
//         data.append("po_date", po_date);
//         data.append("invoice_auto_id", invoice_auto_id);
//         data.append("invoice_no", invoice_no);
//         data.append("invoice_date", invoice_date);
//         data.append("consignee_unique_id", consignee_unique_id);
//         data.append("engineer_name", engineer_name);
//         // data.append("ins_com_date", ins_com_date);
//         // data.append("eng_remarks", eng_remarks);
//         // data.append("", eng_remarks);
//         // data.append("cus_ack_date", cus_ack_date);
//         data.append("documents_type", dc_checkbox);
//         data.append("documents_type1", ir_checkbox);
//         data.append("dc_received_sts", dc_received_sts);
//         data.append("dc_cus_signed_date", dc_cus_signed_date);
//         // data.append("ir_rec_status", ir_rec_status);
//         // data.append("ir_cus_signed_date", ir_cus_signed_date);
//         // data.append("snr_rec_status", snr_rec_status);
//         // data.append("snr_cus_signed_date", snr_cus_signed_date);
//         // data.append("form_unique_id", form_unique_id);
//         data.append("dc_file_data", dc_file_data);
//         data.append("dc_file_name", dc_file_name);
//         // data.append("snr_file_data", snr_file_data);
//         // data.append("snr_file_name", snr_file_name);
//         data.append("action", "demo");


// }
//         // if (is_form) {
//         // var data 	 = $(".was-validated").serialize();
//         // data 		+= "&unique_id="+unique_id+"&action=demo";

//         var ajax_url = sessionStorage.getItem("folder_crud_link");
//         var url = sessionStorage.getItem("list_link");
//         // console.log(data);
//         $.ajax({
//             type: "POST",
//             url: ajax_url,
//             data: data,
//             cache: false,
//             contentType: false,
//             processData: false,
//             method: 'POST',
//             beforeSend: function() {
//                 // 	$(".createupdate_btn").attr("disabled","disabled");
//                 // 	$(".createupdate_btn").text("Loading...");
//             },

//             success: function(data) {
//                 // alert(data);

//                 var obj = JSON.parse(data);
//                 var msg = obj.msg;
//                 var status = obj.status;
//                 var error = obj.error;

//                 if (!status) {
//                     url = '';
//                     $(".createupdate_btn").text("Error");
//                     // console.log(error);
//                 } else {
//                     if (msg == "already") {
//                         // Button Change Attribute
//                         url = '';

//                         $(".createupdate_btn").removeAttr("disabled", "disabled");
//                         if (form_unique_id) {
//                             $(".createupdate_btn").text("Update");
//                         } else {
//                             $(".createupdate_btn").text("Save");
//                         }
//                     }
//                 }


//                 sweetalert(msg, url);
//             },
//             error: function(data) {
//                 alert("Network Error");
//             }

//         });


//         // } else {
//         //   sweetalert("form_alert");
//         // }
//     }

 
 
 function installation_creation_sub() {
//    alert();
//    alert("hi");
       // alert("from");
       var internet_status = is_online();
 
       if (!internet_status) {
           sweetalert("no_internet");
           return false;
       }
 
       var dc_number = document.getElementById('dc_number').value;
    //    alert(dc_number);
       
 var sess_id = document.getElementById('sess_id').value;
  
  if((sess_id === '5f97fc3257f2525529') || (sess_id === '65deef78ba17d65741')){
      
      var in_charge = document.getElementById('rate').value;
      var gst = document.getElementById('gst').value;
      var ttl_amount = document.getElementById('ttl_amnt').value;
      
      var engg_type = document.getElementById('engg_type').value;
      
      if(engg_type === 'outsource-vendor'){
          engg_type = '2';
      }
      else if(engg_type === 'own-engineer'){
                    engg_type = '1';
 
      }
      var engineer_name = document.getElementById('engineer_name').value;
        var ins_com_date = document.getElementById('date').value;
 
      }
      
      else{
          
           var in_charge = document.getElementById('rate_vendor').value;
            var gst = document.getElementById('gst_vendor').value;
      var ttl_amount = document.getElementById('ttl_amnt_vendor').value;
      
              var engg_type = document.getElementById('vendor_engg_type').value;
 
      
              var engineer_name = document.getElementById('vendor_eng_name').value;
                var ins_com_date = document.getElementById('date1').value;
 
 
 
      }
     
 
       var doc_required_status = $("#doc_required_status").val();
  
 
       // var dc_required = document.getElementById('dc_required').value;
       // var ins_reqired = document.getElementById('ins_reqired').value;
       if(doc_required_status ==='2'){
           
           // alert('2');
           // alert("ins");
       var po_num = document.getElementById('po_num').value;
       // alert(po_num);
       var po_unique_id = document.getElementById('po_unique_id').value;
       //   alert(po_form_unique_id);
       var po_form_unique_id = document.getElementById('po_form_unique_id').value;
       //   alert(po_unique_id);
       var po_date = document.getElementById('po_date').value;
       var invoice_auto_id = document.getElementById('invoice_auto_id').value;
       var invoice_no = document.getElementById('invoice_no').value;
 
       var invoice_date = document.getElementById('invoice_date').value;
       var consignee_unique_id = document.getElementById('consignee_unique_id').value;
       // var ins_com_date = document.getElementById('ins_com_date').value;
       // var engineer_name = document.getElementById('engineer_name').value;
       // var ins_com_date = document.getElementById('ins_com_date').value;
       // var eng_remarks = document.getElementById('eng_remarks').value;
       // var cus_ack_date = document.getElementById('cus_ack_date').value;
 
       var dc_received_sts = document.getElementById('dc_received_sts').value;
       var dc_cus_signed_date = document.getElementById('dc_cus_signed_date').value;
       var ir_rec_status = document.getElementById('ir_rec_status').value;
       var ir_cus_signed_date = document.getElementById('ir_cus_signed_date').value;
       var snr_rec_status = document.getElementById('snr_rec_status').value;
       var snr_cus_signed_date = document.getElementById('snr_cus_signed_date').value;
       //  var consignee_unique_id = document.getElementById('consignee_unique_id').value;
 
 
       // var form_unique_id = document.getElementById('form_unique_id').value;
       
 var dc_file_data;
 // alert(dc_file_data);
 element = document.getElementById('dc_file_data');
 // alert(element);
 if (element != null) {
   dc_file_data = element.value;
 }
 else {
   dc_file_data = null;
 }
 
 
 var dc_file_name;
 element1 = document.getElementById('dc_file_name');
 if (element1 != null) {
   dc_file_name = element1.value;
 }
 else {
   dc_file_name = null;
 }
 
 var snr_file_data;
 element2 = document.getElementById('snr_file_data');
 if (element2 != null) {
   snr_file_data = element2.value;
 }
 else {
   snr_file_data = null;
 }
 
 var snr_file_name;
 element3 = document.getElementById('snr_file_name');
 if (element3 != null) {
   snr_file_name = element3.value;
 }
 else {
   snr_file_name = null;
 }
 
    
 
 var documents_type = document.getElementById('documents_type').checked;
 var documents_type1 = document.getElementById('documents_type1').checked;
 var documents_type2 = document.getElementById('documents_type2').checked;
 
 // Set checkbox variables based on their checked state
 var dc_checkbox = documents_type ? 'DC' : '0';
 var ir_checkbox = documents_type1 ? 'IR' : '0';
 var snr_checkbox = documents_type2 ? 'SNR' : '0';
 
 // Set checkbox variables based on their checked state
 var dc_checkbox = documents_type ? 'DC' : '0';
 var ir_checkbox = documents_type1 ? 'IR' : '0';
 var snr_checkbox = documents_type2 ? 'SNR' : '0';
 
 // If only one checkbox is checked, store its value
 if (documents_type && !documents_type1 && !documents_type2) {
 // Only DC checkbox is checked
 dc_checkbox = 'DC';
 } else if (!documents_type && documents_type1 && !documents_type2) {
 // Only IR checkbox is checked
 ir_checkbox = 'IR';
 } else if (!documents_type && !documents_type1 && documents_type2) {
 // Only SNR checkbox is checked
 snr_checkbox = 'SNR';
 }
 
 // If two checkboxes are checked, store both values
 if (documents_type && documents_type1 && !documents_type2) {
 // DC and IR checkboxes are checked
 dc_checkbox = 'DC';
 //   alert(dc_checkbox);
 ir_checkbox = 'IR';
 //   alert(ir_checkbox);
 } else if (documents_type && !documents_type1 && documents_type2) {
 // DC and SNR checkboxes are checked
 dc_checkbox = 'DC';
 snr_checkbox = 'SNR';
 } 
 
 else if (documents_type1 && documents_type && documents_type2) {
 // IR checkbox is checked after DC and SNR
 dc_checkbox = 'DC';
 //   alert(dc_checkbox);
 snr_checkbox = 'SNR';
 //   alert(snr_checkbox);
 ir_checkbox = 'IR'; // Update IR value without changing DC and SNR values
 //   alert(ir_checkbox);
 }
 
       var test_doc = document.getElementById('dc_file').value;
       // alert(test_doc);
       var test_doc1 = document.getElementById('ir_file').value;
       // alert(test_doc1);
       var test_doc2 = document.getElementById('snr_file').value;
 
       var image_s = document.getElementById("dc_file");
 
       var image_ir = document.getElementById("ir_file");
       var image_in = document.getElementById("snr_file");
 
 
       // var is_form = form_validity_check("was-validated");
       var data = new FormData();
       if (image_s != '') {
           if (image_s.files) {
               for (var i = 0; i < image_s.files.length; i++) {
                   data.append("test_file[]", document.getElementById('dc_file').files[i]);
               }
           }
       } else {
 
           data.append("test_doc", '');
 
       }
 
       if (image_ir != '') {
           if (image_ir.files) {
               for (var i = 0; i < image_ir.files.length; i++) {
                   data.append("test_file1[]", document.getElementById('ir_file').files[i]);
               }
           }
       } else {
 
           data.append("test_doc1", '');
 
       }
       if (image_in != '') {
           if (image_in.files) {
               for (var i = 0; i < image_in.files.length; i++) {
                   data.append("test_file2[]", document.getElementById('snr_file').files[i]);
               }
           }
       } else {
 
           data.append("test_doc2", '');
 
       }

       
      
  data.append("po_num", po_num);
  data.append("po_form_unique_id", po_form_unique_id);
  data.append("po_unique_id", po_unique_id);
  data.append("po_date", po_date);
  data.append("invoice_auto_id", invoice_auto_id);
  data.append("invoice_no", invoice_no);
  data.append("invoice_date", invoice_date);
  data.append("consignee_unique_id", consignee_unique_id);
  data.append("engineer_name", engineer_name);
  data.append("ins_com_date", ins_com_date);
  data.append("dc_number", dc_number);
 //    data.append("in_charge", in_charge);
  
  
   // data.append("gst",gst);
   // data.append("ttl_amount",ttl_amount);
 
  
  
 //    data.append("engg_type", engg_type);
  data.append("documents_type", dc_checkbox);
  data.append("documents_type1", ir_checkbox);
  data.append("documents_type2", snr_checkbox);
  
  
 
  data.append("dc_received_sts", dc_received_sts);
  data.append("dc_cus_signed_date", dc_cus_signed_date);
  data.append("ir_rec_status", ir_rec_status);
  data.append("ir_cus_signed_date", ir_cus_signed_date);
  data.append("snr_rec_status", snr_rec_status);
  data.append("snr_cus_signed_date", snr_cus_signed_date);
       // data.append("form_unique_id", form_unique_id);
       data.append("dc_file_data", dc_file_data);
       data.append("dc_file_name", dc_file_name);
       data.append("snr_file_data", snr_file_data);
       data.append("snr_file_name", snr_file_name);
       // data.append("unique_id", unique_id);
       data.append("action", "demo");
 
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
               // alert(data);
 
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
                       if (form_unique_id) {
                           $(".createupdate_btn").text("Update");
                       } else {
                           $(".createupdate_btn").text("Save");
                       }
                   }
               }
 
 
               sweetalert(msg,url);
           },
           error: function(data) {
               alert("Network Error");
           }
 
       });
 
 
   }
 
   else if(doc_required_status ==='1'){
       var po_num = document.getElementById('po_num').value;
  var po_unique_id = document.getElementById('po_unique_id').value;
  var po_form_unique_id = document.getElementById('po_form_unique_id').value;
  var po_date = document.getElementById('po_date').value;
  var invoice_auto_id = document.getElementById('invoice_auto_id').value;
  var invoice_no = document.getElementById('invoice_no').value;
 
  var invoice_date = document.getElementById('invoice_date').value;
  var consignee_unique_id = document.getElementById('consignee_unique_id').value;
 //    var ins_com_date = document.getElementById('date').value;.
 // var ins_com_date = document.getElementById('ins_com_date').value;
 
  var dc_received_sts = document.getElementById('dc_received_sts').value;
  var dc_cus_signed_date = document.getElementById('dc_cus_signed_date').value;
  
 
       // var form_unique_id = document.getElementById('form_unique_id').value;
       
 var dc_file_data;
 element = document.getElementById('dc_file_data');
 if (element != null) {
   dc_file_data = element.value;
 }
 else {
   dc_file_data = null;
 }
 
 
 var dc_file_name;
 element1 = document.getElementById('dc_file_name');
 if (element1 != null) {
   dc_file_name = element1.value;
 }
 else {
   dc_file_name = null;
 }
 
 
 
    
 
 var documents_type = document.getElementById('documents_type').checked;
 // var documents_type = document.getElementById('documents_type').checked;
 
 
 // Set checkbox variables based on their checked state
 var dc_checkbox = documents_type ? 'DC' : '0';
 var ir_checkbox = documents_type1 ? 'IR' : '0';
 var snr_checkbox = documents_type2 ? 'SNR' : '0';
 
 
 // If only one checkbox is checked, store its value
 if (documents_type) {
 // Only DC checkbox is checked
 dc_checkbox = 'DC';
 } 
 
 
       var test_doc = document.getElementById('dc_file').value;
       // alert(test_doc);
      
       var image_s = document.getElementById("dc_file");
 
     
 
       // var is_form = form_validity_check("was-validated");
       var data = new FormData();
       if (image_s != '') {
           if (image_s.files) {
               for (var i = 0; i < image_s.files.length; i++) {
                   data.append("test_file[]", document.getElementById('dc_file').files[i]);
               }
           }
       } else {
 
           data.append("test_doc", '');
 
       }


       
      
  data.append("po_num", po_num);
  data.append("po_form_unique_id", po_form_unique_id);
  data.append("po_unique_id", po_unique_id);
  data.append("po_date", po_date);
  data.append("invoice_auto_id", invoice_auto_id);
  data.append("invoice_no", invoice_no);
  data.append("invoice_date", invoice_date);
  data.append("consignee_unique_id", consignee_unique_id);
  data.append("engineer_name", engineer_name);
  data.append("ins_com_date", ins_com_date);
 //    data.append("in_charge", in_charge);
 data.append("dc_number", dc_number);
  
   // data.append("gst",gst);
   // data.append("ttl_amount",ttl_amount);
 
  
  
 //    data.append("engg_type", engg_type);
  data.append("documents_type", dc_checkbox);
//   data.append("documents_type1", ir_checkbox);
//   data.append("documents_type2", snr_checkbox);
  
  
 
  data.append("dc_received_sts", dc_received_sts);
  data.append("dc_cus_signed_date", dc_cus_signed_date);
//   data.append("ir_rec_status", ir_rec_status);
//   data.append("ir_cus_signed_date", ir_cus_signed_date);
//   data.append("snr_rec_status", snr_rec_status);
//   data.append("snr_cus_signed_date", snr_cus_signed_date);
       // data.append("form_unique_id", form_unique_id);
       data.append("dc_file_data", dc_file_data);
       data.append("dc_file_name", dc_file_name);
    //    data.append("snr_file_data", snr_file_data);
    //    data.append("snr_file_name", snr_file_name);
       // data.append("unique_id", unique_id);
       data.append("action", "demo");
 
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
               // alert(data);
 
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
                       if (form_unique_id) {
                           $(".createupdate_btn").text("Update");
                       } else {
                           $(".createupdate_btn").text("Save");
                       }
                   }
               }
 
 
               sweetalert(msg,url);
           },
           error: function(data) {
               alert("Network Error");
           }
 
       });
 
 
 
   }
 
      
//   data.append("po_num", po_num);
//   data.append("po_form_unique_id", po_form_unique_id);
//   data.append("po_unique_id", po_unique_id);
//   data.append("po_date", po_date);
//   data.append("invoice_auto_id", invoice_auto_id);
//   data.append("invoice_no", invoice_no);
//   data.append("invoice_date", invoice_date);
//   data.append("consignee_unique_id", consignee_unique_id);
//   data.append("engineer_name", engineer_name);
//   data.append("ins_com_date", ins_com_date);
 //    data.append("in_charge", in_charge);
  
  
   // data.append("gst",gst);
   // data.append("ttl_amount",ttl_amount);
 
  
  
//  //    data.append("engg_type", engg_type);
//   data.append("documents_type", dc_checkbox);
//   data.append("documents_type1", ir_checkbox);
//   data.append("documents_type2", snr_checkbox);
  
  
 
//   data.append("dc_received_sts", dc_received_sts);
//   data.append("dc_cus_signed_date", dc_cus_signed_date);
//   data.append("ir_rec_status", ir_rec_status);
//   data.append("ir_cus_signed_date", ir_cus_signed_date);
//   data.append("snr_rec_status", snr_rec_status);
//   data.append("snr_cus_signed_date", snr_cus_signed_date);
//        // data.append("form_unique_id", form_unique_id);
//        data.append("dc_file_data", dc_file_data);
//        data.append("dc_file_name", dc_file_name);
//        data.append("snr_file_data", snr_file_data);
//        data.append("snr_file_name", snr_file_name);
//        // data.append("unique_id", unique_id);
//        data.append("action", "demo");
 
//        // if (is_form) {
//        // var data 	 = $(".was-validated").serialize();
//        // data 		+= "&unique_id="+unique_id+"&action=demo";
//        var ajax_url = sessionStorage.getItem("folder_crud_link");
//    var url = sessionStorage.getItem("list_link");
//    // console.log(data);
//    $.ajax({
//      type: "POST",
//      url: ajax_url,
//            data: data,
//            cache: false,
//            contentType: false,
//            processData: false,
//            method: 'POST',
//            beforeSend: function() {
//                // 	$(".createupdate_btn").attr("disabled","disabled");
//                // 	$(".createupdate_btn").text("Loading...");
//            },
 
//            success: function(data) {
//                // alert(data);
 
//                var obj = JSON.parse(data);
//                var msg = obj.msg;
//                var status = obj.status;
//                var error = obj.error;
 
//                if (!status) {
//                    url = '';
//                    $(".createupdate_btn").text("Error");
//                    // console.log(error);
//                } else {
//                    if (msg == "already") {
//                        // Button Change Attribute
//                        url = '';
 
//                        $(".createupdate_btn").removeAttr("disabled", "disabled");
//                        if (form_unique_id) {
//                            $(".createupdate_btn").text("Update");
//                        } else {
//                            $(".createupdate_btn").text("Save");
//                        }
//                    }
//                }
 
 
//                sweetalert(msg,url);
//            },
//            error: function(data) {
//                alert("Network Error");
//            }
 
//        });
 
 
       // } else {
       //   sweetalert("form_alert");
       // }
   }


    
</script>

<?php
function image_view_dc_file($folder_name = "", $unique_id = "", $dc_file = "")
{
    // echo $dc_file_name;
    $file_names = explode(',', $dc_file);
    $image_view_dc_file = '';

    if ($dc_file) {
        foreach ($file_names as $file_key => $dc_file) {
            if ($file_key != 0) {
                if ($file_key % 4 != 0) {
                    $image_view_dc_file .= "&nbsp";
                } else {
                    $image_view_dc_file .= "<br><br>";
                }
            }

            $cfile_name = explode('.', $dc_file);

            if ($dc_file) {

                if (($cfile_name[1] == 'jpg') || ($cfile_name[1] == 'png') || ($cfile_name[1] == 'jpeg')) {
                    $image_view_dc_file .= '<a href="javascript:print_view_dc(\'/' . $dc_file . '\')"><img src="uploads/' . $folder_name . '/' . $dc_file . '"  height="30px" width="30px" ></a>';
                    // $image_view_dc_file .= '<img src="uploads/'.$folder_name.'/'.$doc_name.'"  height="50px" width="50px" >';
                } else if ($cfile_name[1] == 'pdf') {
                    $image_view_dc_file .= '<a href="javascript:print_pdf_dc(\'/' . $dc_file . '\')"><img src="uploads/installation/pdf.png"  height="30px" width="30px" ></a>';
                } else if (($cfile_name[1] == 'pdf') || ($cfile_name[1] == 'xls') || ($cfile_name[1] == 'xlsx')) {
                    $image_view_dc_file .= '<a href="javascript:print_dc(\'/' . $dc_file . '\')"><img src="uploads/installation/excel.png"  height="30px" width="30px" ></a>';
                } else if (($cfile_name[1] == 'txt') || ($cfile_name[1] == 'docx') || ($cfile_name[1] == 'doc')) {
                    $image_view_dc_file .= '<a href="javascript:print_dc(\'/' . $dc_file . '\')"><img src="uploads/installation/word.png"  height="30px" width="30px" ></a>';
                }
            }
        }
    }

    return $image_view_dc_file;
}


function image_view_ir_file($folder_name = "", $unique_id = "", $ir_file = "")
{
    // echo $dc_file_name;
    $file_names = explode(',', $ir_file);
    $image_view_ir_file = '';

    if ($ir_file) {
        foreach ($file_names as $file_key => $ir_file) {
            if ($file_key != 0) {
                if ($file_key % 4 != 0) {
                    $image_view_ir_file .= "&nbsp";
                } else {
                    $image_view_ir_file .= "<br><br>";
                }
            }

            $cfile_name = explode('.', $ir_file);

            if ($ir_file) {

                if (($cfile_name[1] == 'jpg') || ($cfile_name[1] == 'png') || ($cfile_name[1] == 'jpeg')) {
                    $image_view_ir_file .= '<a href="javascript:print_view_dc(\'/' . $ir_file . '\')"><img src="uploads/' . $folder_name . '/' . $ir_file . '"  height="30px" width="30px" ></a>';
                    // $image_view_ir_file .= '<img src="uploads/'.$folder_name.'/'.$doc_name.'"  height="50px" width="50px" >';
                } else if ($cfile_name[1] == 'pdf') {
                    $image_view_ir_file .= '<a href="javascript:print_pdf_dc(\'/' . $ir_file . '\')"><img src="uploads/installation/pdf.png"  height="30px" width="30px" ></a>';
                } else if (($cfile_name[1] == 'pdf') || ($cfile_name[1] == 'xls') || ($cfile_name[1] == 'xlsx')) {
                    $image_view_ir_file .= '<a href="javascript:print_dc(\'/' . $ir_file . '\')"><img src="uploads/installation/excel.png"  height="30px" width="30px" ></a>';
                } else if (($cfile_name[1] == 'txt') || ($cfile_name[1] == 'docx') || ($cfile_name[1] == 'doc')) {
                    $image_view_ir_file .= '<a href="javascript:print_dc(\'/' . $ir_file . '\')"><img src="uploads/installation/word.png"  height="30px" width="30px" ></a>';
                }
            }
        }
    }

    return $image_view_ir_file;
}


function image_view_snr_file($folder_name = "", $unique_id = "", $snr_file = "")
{
    // echo $dc_file_name;
    $file_names = explode(',', $snr_file);
    $image_view_snr_file = '';

    if ($snr_file) {
        foreach ($file_names as $file_key => $snr_file) {
            if ($file_key != 0) {
                if ($file_key % 4 != 0) {
                    $image_view_snr_file .= "&nbsp";
                } else {
                    $image_view_snr_file .= "<br><br>";
                }
            }

            $cfile_name = explode('.', $snr_file);

            if ($snr_file) {

                if (($cfile_name[1] == 'jpg') || ($cfile_name[1] == 'png') || ($cfile_name[1] == 'jpeg')) {
                    $image_view_snr_file .= '<a href="javascript:print_view_dc(\'/' . $snr_file . '\')"><img src="uploads/' . $folder_name . '/' . $snr_file . '"  height="30px" width="30px" ></a>';
                    // $image_view_snr_file .= '<img src="uploads/'.$folder_name.'/'.$doc_name.'"  height="50px" width="50px" >';
                } else if ($cfile_name[1] == 'pdf') {
                    $image_view_snr_file .= '<a href="javascript:print_pdf_dc(\'/' . $snr_file . '\')"><img src="uploads/installation/pdf.png"  height="30px" width="30px" ></a>';
                } else if (($cfile_name[1] == 'pdf') || ($cfile_name[1] == 'xls') || ($cfile_name[1] == 'xlsx')) {
                    $image_view_snr_file .= '<a href="javascript:print_dc(\'/' . $snr_file . '\')"><img src="uploads/installation/excel.png"  height="30px" width="30px" ></a>';
                } else if (($cfile_name[1] == 'txt') || ($cfile_name[1] == 'docx') || ($cfile_name[1] == 'doc')) {
                    $image_view_snr_file .= '<a href="javascript:print_dc(\'/' . $snr_file . '\')"><img src="uploads/installation/word.png"  height="30px" width="30px" ></a>';
                }
            }
        }
    }

    return $image_view_snr_file;
}



?>

