<?php
require_once __DIR__ . '/../../config/env.php';
require_once("../../assets/PHPExcel-1.8/Classes/PHPExcel.php");
$driver         = "mysql";
$host           = "localhost";
$username       = project_env('APP_DB_USERNAME', 'root');
$password       = "";
$databasename   = "operation_team_beta";
try {
    $conn = new PDO($driver . ":host=" . $host . ";dbname=" . $databasename, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}
$excel = new PHPExcel();
$excel->setActiveSheetIndex(0);
$excel->getActiveSheet()
    ->mergeCells('A1:F1');
$excel->getActiveSheet()
    ->setCellValue('A1', 'Elcot Tracker');
$excel->getActiveSheet()
    ->setCellValue('A3', 'S.No')
    ->setCellValue('B3', 'Po No')
    ->setCellValue('C3', 'Po Date')
    ->setCellValue('D3', 'Department')
    ->setCellValue('E3', 'Executive Name')
    ->setCellValue('F3', 'Ledger Name')
    ->setCellValue('G3', 'Ledger No')
    ->setCellValue('H3', 'Bill Address')
    ->setCellValue('I3', 'Pincode')
    ->setCellValue('J3', 'Consignee Address')
    ->setCellValue('K3', 'Con Location')
    ->setCellValue('L3', 'Con Pincode')
    ->setCellValue('M3', 'Contact Person')
    ->setCellValue('N3', 'Contact Number')
    ->setCellValue('O3', 'Po Prepared By')
    ->setCellValue('P3', 'Item Code')
    ->setCellValue('Q3', 'Product')
    ->setCellValue('R3', 'Qty')
    // ->setCellValue('R3', 'Qty')
    ->setCellValue('S3', 'Unit Price')
    ->setCellValue('T3', 'Tax')
    ->setCellValue('U3', 'Net Value')
    ->setCellValue('V3', 'Total value')
    // ->setCellValue('V3','Dc NO')
    ->setCellValue('W3', 'Stock Position')
    ->setCellValue('X3', 'Invoice No')
    ->setCellValue('Y3', 'Invoice Date')
    // ->setCellValue('X3', 'Invoice Verfied By')
    ->setCellValue('Z3', 'Elcot Verfied By')
    ->setCellValue('AA3', 'Account Verfied By')
    ->setCellValue('AB3', 'Dispatch Date')
    ->setCellValue('AC3', 'Mode Of Delivery')
    ->setCellValue('AD3', 'POD NO.')
    // ->setCellValue('AE3','Mode Of Delivery')
    ->setCellValue('AE3', 'Delivery Status')
    ->setCellValue('AF3', 'Installation Status')
    ->setCellValue('AG3', 'Engg Name')
    ->setCellValue('AH3', 'Installation Completed Date')

    ->setCellValue('AI3', 'DC Received Status')
    ->setCellValue('AJ3', 'IR Received Status')
    ->setCellValue('AK3', 'SNR Received Status')
    ->setCellValue('AL3', 'Dispatch Status')
    ->setCellValue('AM3', 'DC Dispatch Mode')
    ->setCellValue('AN3', 'SNR Dispatch Mode')
    ->setCellValue('AO3', 'IR Dispatch Mode')
    ->setCellValue('AP3', 'DC POD No.')
    ->setCellValue('AQ3', 'SNR POD No.')
    ->setCellValue('AR3', 'IR POD No.')
    ->setCellValue('AS3', 'DC POD Date')
    ->setCellValue('AT3', 'SNR POD Date')
    ->setCellValue('AU3', 'IR POD Date')


    ->setCellValue('AV3', 'Customer DC Signed Date.')
    ->setCellValue('AW3', 'CUS.Installation Signed Date.')
    ->setCellValue('AX3', 'Document Received to Chennai Date')
    ->setCellValue('AY3', 'DC Status')

    ->setCellValue('AZ3', 'IR Status.')
    ->setCellValue('BA3', 'BG Months.')
    ->setCellValue('BB3', 'BG %')
    ->setCellValue('BC3', 'BG STATUS')
    ->setCellValue('BD3', 'BG Number.')
    ->setCellValue('BE3', 'BG DATE')
    ->setCellValue('BF3', 'BG Valid From')
    ->setCellValue('BG3', 'BG Valid TO')

    ->setCellValue('BH3', 'BILL SUBMISSION DATE')
    // ->setCellValue('BH3', 'SUP-INST')
    ->setCellValue('BI3', 'SUP-INV')
    ->setCellValue('BJ3', 'SUP-INST')
    ->setCellValue('BK3', 'E NO')
    ->setCellValue('BL3', 'PAYMENT DATE')
    ->setCellValue('BM3', 'Transacation Amount')
    ->setCellValue('BN3', 'LD Days')
    ->setCellValue('BO3', 'LD Amount')
    ->setCellValue('BP3', 'LD Deducted by Elcot')
    ->setCellValue('BQ3', 'Claim Amount%')
    ->setCellValue('BR3', 'Form Wise Status')
    ->setCellValue('BS3', 'Financial Year')
    ->setCellValue('BT3', 'Status');
 

// ->setCellValue('AC3','Payment Status')
// ->setCellValue('AD3','Payment Date');
// ->setCellValue('E4','Closing Date')
// ->setCellValue('F4','LD Days')
// ->setCellValue('G4','Closing Date');
$i = 0;
$row_val    = 4;
// .$relieve_date
$sql = ("SELECT *  from view_overall_form_final");
// $sql = ("SELECT * FROM view_overall_form_final ORDER BY po_num ASC");

$overall_form       = $conn->query($sql);
foreach ($overall_form as $row) {
    $department_details   = $conn->prepare("SELECT department FROM department_creation WHERE unique_id = '" . $row['department'] . "'");
    $department_details->execute();
    $department_name      = $department_details->fetch();


    $ledger_name_details = $conn->prepare("SELECT ledger_name FROM department_creation_sublist WHERE unique_id = :ledger_name");
    $ledger_name_details->bindParam(':ledger_name', $row['ledger_name']);
    $ledger_name_details->execute();
    $ledger_name = $ledger_name_details->fetch();

if ($ledger_name !== false) {
    $ledger_name = $ledger_name['ledger_name'];
} else {
    $ledger_name = "";
}


$ledger_no_details = $conn->prepare("SELECT ledger_no FROM department_creation_sublist WHERE unique_id = :ledger_no");
$ledger_no_details->bindParam(':ledger_no', $row['ledger_no']);
$ledger_no_details->execute();
$ledger_no = $ledger_no_details->fetch();

if ($ledger_no !== false) {
$ledger_no = $ledger_no['ledger_no'];
} else {
$ledger_no = "";
}








    //  $engineer_name_details   = $conn->prepare("SELECT staff_name FROM view_eng_data WHERE eng_unique_id = '".$row['engineer_name']. "'");
    // $engineer_name_details->execute();
    // $engineer_name      = $engineer_name_details->fetch();


    $engineer_name_details = $conn->prepare("SELECT staff_name FROM view_eng_data WHERE eng_unique_id = :engineer_name");
    $engineer_name_details->bindParam(':engineer_name', $row['engineer_name'], PDO::PARAM_STR);
    $engineer_name_details->execute();
    $engineer_name = $engineer_name_details->fetch(PDO::FETCH_ASSOC);



    
    if ($engineer_name !== false) {
        // Access the staff_name
        $staff_name = $engineer_name['staff_name'];
    }
     else {
        // Handle the case where no data was found
        $staff_name = ""; // or handle it in another appropriate way
    }
    


    // Prepare the SQL statement with a placeholder
$con_district_query = $conn->prepare("SELECT district_name FROM district_creation WHERE unique_id = :unique_id");

// Bind the parameter
$con_district_query->bindParam(':unique_id', $row['con_district']);

// Execute the prepared statement
$con_district_query->execute();

// Fetch the result
$con_district_result = $con_district_query->fetch(PDO::FETCH_ASSOC);
// print_r($con_district_result);die();
if ($con_district_result !== false) {
    // Fetch the district name
    $con_district_name = $con_district_result["district_name"];

    // Set the district name in Excel cell
    // $objPHPExcel->getActiveSheet()->setCellValue('K' . $row_val, $con_district_name);
} 
   
$item   = $conn->prepare("SELECT item_code FROM item_creation_sub WHERE unique_id = '" . $row['item_code'] . "' AND is_delete='0'");
    $item->execute();
    $item      = $item->fetch();

$con_item_query = $conn->prepare("SELECT item_code FROM item_creation_sub WHERE unique_id = :unique_id");
$con_item_query->bindParam(':unique_id', $row['item_code']);
$con_item_query->execute();
$con_item_result = $con_item_query->fetch(PDO::FETCH_ASSOC);

if ($con_item_result !== false) {
  
    $con_item_name = $con_item_result["item_code"];

} 
// print_r($con_item_name);
    $executive   = $conn->prepare("SELECT executive_name FROM executive_name WHERE unique_id = '" . $row['executive_name'] . "'");
    $executive->execute();
    $executive      = $executive->fetch();
    if ($row['elcot_team_verifiy_status'] == "1") {
        $row['elcot_team_verifiy_status']   = "Approval";
    } else if($row['elcot_team_verifiy_status'] == "2") {
        $row['elcot_team_verifiy_status']   = "Not Approval";
    } else {
        $row['elcot_team_verifiy_status']   = "Pending";
    }

    if ($row['ac_team_verifiy_status'] == "1") {
        $row['ac_team_verifiy_status']   = "Approval";
    } else if($row['ac_team_verifiy_status'] == "2") {
        $row['ac_team_verifiy_status']   = "Not Approval";
    } else {
        $row['ac_team_verifiy_status']   = "Pending";
    }
    if ($row["mode_of_delivery"] == "1") {
        $row['mode_of_delivery'] = "Hand";
    } else if ($row["mode_of_delivery"] == "2") {
        $row['mode_of_delivery'] = "Courier";
    }
    if($row['delivery_status'] == "0") {
        $row['delivery_status'] = "Pending";
    }
     else if($row['delivery_status'] == "1") {
        $row['delivery_status'] = "DELIVERD";
    } else if ($row['delivery_status'] == "2") {
        $row['delivery_status'] = "UNDELIVERD";
    }
    // if ($row['documents_type'] != 0 && $row['documents_type2'] != 0 && $row['documents_type1'] == 0) {
    //     $row['installation_invoice_no'] = "Partially Completed";
    // } else if ($row['documents_type'] != 0 && $row['documents_type1'] != 0) {
    //     $row['installation_invoice_no'] = "Completed";
    // } else {
    //     $row['installation_invoice_no'] = "Pending";
    // }
if($row['installation_status'] == 0){
    $row['installation_invoice_no'] = 'Installation pending';
}

else if($row['installation_status'] == 3){
    $row['installation_invoice_no'] = "Installation Rejected";

  }
  else if($row['installation_status'] == 4){
    $row['installation_invoice_no'] = "Eng Assigned";
  }
  else if($row['installation_status'] == 1){
    $row['installation_invoice_no'] = "SNR";
  }
  else if($row['installation_status'] == 5){
    $row['installation_invoice_no'] = 'Partial completed';
}
else if($row['installation_status'] == 2){
    $row['installation_invoice_no'] = 'Completed';
  }
    if($row['dc_received_sts'] == "1") {
        $row['dc_received_sts'] = "YES";
    }
     else if($row['dc_received_sts'] == "2") {
        $row['dc_received_sts'] = "NO";
    } 
   $ir_cus_signed_date= $row['ir_cus_signed_date'];

    if($row['ir_cus_signed_date'] == "undefined") {
        $row['ir_cus_signed_date'] = "NULL";
    }
   else if($row['ir_cus_signed_date'] == "0") {
        $row['ir_cus_signed_date'] = "NULL";
    }

     else  {
        $row['ir_cus_signed_date'] = $ir_cus_signed_date;
    } 

    if($row['ir_rec_status'] == "1") {
        $row['ir_rec_status'] = "YES";
    }
     else if($row['ir_rec_status'] == "2") {
        $row['ir_rec_status'] = "NO";
    } 
    else if($row['ir_rec_status'] == "undefined") {
        $row['ir_rec_status'] = "NULL";
    } 
    else if($row['ir_rec_status'] == "0") {
        $row['ir_rec_status'] = "NULL";
    } 

    if($row['snr_rec_status'] == "1") {
        $row['snr_rec_status'] = "YES";
    }
     else if($row['snr_rec_status'] == "2") {
        $row['snr_rec_status'] = "NO";
    } 
    else if($row['snr_rec_status'] == "undefined") {
        $row['snr_rec_status'] = "NULL";
    } 
    else if($row['snr_rec_status'] == "0") {
        $row['snr_rec_status'] = "NULL";
    } 

    if($row['sign_dc_received_status'] == "1") {
        $row['sign_dc_received_status'] = "Received";
    }
     else if($row['sign_dc_received_status'] == "2") {
        $row['sign_dc_received_status'] = "Pending";
    } 
    else if($row['sign_dc_received_status'] == "undefined") {
        $row['sign_dc_received_status'] = "NULL";
    }
    else if($row['sign_dc_received_status'] == "0") {
        $row['sign_dc_received_status'] = "NULL";
    }
    if($row['sign_ir_status'] == "1") {
        $row['sign_ir_status'] = "Received";
    }
     else if($row['sign_ir_status'] == "2") {
        $row['sign_ir_status'] = "Pending";
    } 
    else if($row['sign_ir_status'] == "undefined") {
        $row['sign_ir_status'] = "NULL";
    } 
    else if($row['sign_ir_status'] == "0") {
        $row['sign_ir_status'] = "NULL";
    } 

    if ($row['payment_status'] == "1") {
        $row['payment_status'] = " PAYMENT PENDING";
    } else if ($row['payment_status'] == "2") {
        $row['payment_status'] = "PAYMENT RECEIVED";
    }
   $tax        = $row['tax']; 
//    $total_value = $row["total_value"];

if($row['invoice_doc_status']!='2' && $row['invoice_no']!=''){
    $assign_qty = $row["invoice_qty"];
}
else {
    $assign_qty = $row["assign_qty"];
}
  
   $invoice_qty = $row["invoice_qty"];

   $unit_price= $row["unit_price"];
   
// if($row['invoice_no']==''){

    if($row['invoice_doc_status']!='2' && $row['invoice_no']!=''){
        $tot_value=  $unit_price * $invoice_qty;
        //    $total_value=  $net_value;
           $row['total_value']= $tot_value;
        //    
            if($tax=='18'){
                // const net_value = qty * unit_price;
                // const percentage_value = $tot_value * (18 / 100);
                $net_value = $tot_value * (18 / 100);
                $row["net_value"]= $net_value+$tot_value;
           
            }
           else if($tax=='28'){
                // const net_value = qty * unit_price;
                // const percentage_value = $tot_value * (18 / 100);
              $net_value = $tot_value * (28 / 100);
                $row["net_value"]= $net_value+$tot_value;
            }
            // else{
            //     $tot_value=  $unit_price * $invoice_qty;
            //     // $net_value = $qty * $unit_price;
            //     // percentage_value = net_value * (28 / 100);
            //      $total_value =  $tot_value;
            //      $row["net_value"]=  $total_value;
            //      $row['total_value']= $total_value;

            //     // document.getElementById('net_value').value = net_value;
        
            //     // document.getElementById('total_value').value = total_value;

            // }
           
    }
    else{
        $tot_value = (float)$unit_price * (float)$assign_qty;

//    $tot_value=  $unit_price * $assign_qty;
//    $total_value=  $net_value;
   $row['total_value']= $tot_value;
//    
    if($tax=='18'){
        // const net_value = qty * unit_price;
        // const percentage_value = $tot_value * (18 / 100);
        $net_value = $tot_value * (18 / 100);
        $row["net_value"]= $net_value+$tot_value;
   
    }
   else if($tax=='28'){
        // const net_value = qty * unit_price;
        // const percentage_value = $tot_value * (18 / 100);
      $net_value = $tot_value * (28 / 100);
        $row["net_value"]= $net_value+$tot_value;
    } 
    // else{
    //     $tot_value = (float)$unit_price * (float)$assign_qty;
    //             // $net_value = $qty * $unit_price;
    //             // percentage_value = net_value * (28 / 100);
    //              $total_value =   $tot_value;
    //              $row["net_value"]=  $total_value;
    //              $row['total_value']= $total_value;
    //          }
 }
    // if($row["invoice_date"]==''){
    //     $row["status"]='Invoice Pending';
    //    }
        
    //   else if($row['invoice_verified_by']==''){
    //     $row["status"] ='Document Elcot Pending';
    //    }
           
    //   else if($row['ac_team_approved_by']==''){
    //     $row["status"]='Document Account Pending';
    //    }

// new chnags
    //    if($row['invoice_doc_status'] == 4) {
    //     // $row['invoice_doc_status'] = "A/c Team Approval";
    //     $row["status"] = "invoice Completed";
    // } 

     if ($row['invoice_doc_status'] == 0){
        $row["status"] = "invoice Pending";
    }
     else if($row['invoice_doc_status'] == 1) {
        $row["status"] = "Accounts Team Pending";
    } 
    // if($row['invoice_doc_status'] == 1 && $row['approved_by']!='' && $row['ac_team_approved_by']!='') {
    //     $row['invoice_doc_status'] = "A/c Team Approval";
    // } 
    //  else if($row['invoice_doc_status'] == 1 && $row['approved_by']!='') {
    //     $row['invoice_doc_status'] = "Elcot Team Approval";
    // } 
    else if ($row['invoice_doc_status'] == 2) {
        $row["status"] = "Invoice Rejected";
        //  = "";
    } else if ($row['invoice_doc_status'] == 3) {
        $row["status"] = "Elcot Team Pending";
    } 
       else if($row['deleivery_status']=='0'){
        $row["status"]='Dispatch Pending';
       }
       else if($row['deleivery_status']=='1'){
        $row["status"]='Transit Pending';
       }

    else  if ($row['bill_status'] == '0') {
        $row['bill_status'] = 'Pending';
    } else if ($row['bill_status'] == '1') {
        $row['bill_status'] = 'Completed';
    } else if ($row['bill_status'] == '2') {
        $row['bill_status'] = 'Completed';
    }
    else if ($row['bill_status'] == '3') {
        $row['bill_status'] ="Bill Rejected"; 
    }
    else if ($row['bill_status'] == '4') {
        $row['bill_status'] ="payment Rejected"; 
    }








// new changes after change status
// else if($row['installation_status'] == 0){
//     $row["status"] = 'Installation pending';
// }

// else if($row['installation_status'] == 3){
//     $row["status"] = "Installation Rejected";

//   }
//   else if($row['installation_status'] == 4){
//     $row["status"] = "Eng Assigned";
//   }
//   else if($row['installation_status'] == 1){
//     $row["status"] = "SNR";
//   }

// // dc_delivery_status
//   $dc_delivery_status=$row['dc_delivery_status'];

//   if($row['dc_delivery_status'] == 0){
//     $row["dc_delivery_status"] = 'documnent Pending';
//   }
//   else if($row['dc_delivery_status'] == 5){
//     $row["dc_delivery_status"] = 'document partial Completed';
//   }
//   else if($row['dc_delivery_status'] == 1){
//       $row['dc_delivery_status'] = 'SNR';
//   }
//   else if($row['dc_delivery_status'] == 3){
//       $row['dc_delivery_status'] = 'Completed';
//   }
       else if($row['documents_type'] == 0){
        $row["status"]='Installation pending';
       }
       else if($row['ir_dispatch_mode'] == '' && $row['dc_required'] != 'on'   ){
        // || (($row['snr_dispatch_mode'] == '' )|| ($row['snr_dispatch_mode'] == ''))
        $row["status"]='Installation document pending';
       }
    //    else if( $row["sign_dc_received_status"]==''){
    //     // || (($row['snr_dispatch_mode'] == '' )|| ($row['snr_dispatch_mode'] == ''))
    //     $row["status"]='signed document pending';
    //    }
    else if($row["sign_dc_received_status"]=='' || $row["status_app"]!='2' ){
        // || (($row['snr_dispatch_mode'] == '' )|| ($row['snr_dispatch_mode'] == ''))
        $row["status"]='signed document pending';
       }

    //    else if($row["sign_dc_received_status"]==''  ){
    //     // || (($row['snr_dispatch_mode'] == '' )|| ($row['snr_dispatch_mode'] == ''))
    //     $row["status"]='signed document pending';
    //    }
    // end==
   
       else if($row['bg_num'] == '' && $row['with_bg'] == 'on'){
        // || (($row['snr_dispatch_mode'] == '' )|| ($row['snr_dispatch_mode'] == ''))
        $row["status"]='Bg pending';
       }
       else if($row['bill_status'] == '0' || $row['bill_status'] == '1'  ){
        // || (($row['snr_dispatch_mode'] == '' )|| ($row['snr_dispatch_mode'] == ''))
        $row["status"]='Elcot Entry Pending';
       }
       else if($row['e_no'] == '' ){
        // || (($row['snr_dispatch_mode'] == '' )|| ($row['snr_dispatch_mode'] == ''))
        $row["status"]='Bill submission Pending';
       }
   
       else if($row['payment_date'] == ''){
        // || (($row['snr_dispatch_mode'] == '' )|| ($row['snr_dispatch_mode'] == ''))
        $row["status"]='Payment Pending';
       }
       else if($row['payment_date'] != ''){
        // || (($row['snr_dispatch_mode'] == '' )|| ($row['snr_dispatch_mode'] == ''))
        $row["status"]='Payment Completed';
       }
    
     // status of elcot 
    // $row["invoice_auto_id"]='Invoice Pending';
    
    if($row["invoice_date"] == ''){
        $elcot_status ='Invoice Pending';
    }
    else if($row['invoice_verified_by'] == '' || $row['ac_team_approved_by'] == '' || $row['deleivery_status'] == '0' || $row['deleivery_status'] == '1'){
        $elcot_status ='Material intransit';
    }
    else if($row['documents_type'] == 0 || $row['ir_dispatch_mode'] == '' && $row['dc_required'] != 'on' ){
        $elcot_status ='Installation pending';
    }
    else if($row['snr_rec_status'] == "0") {
        $elcot_status = "SNR Pending";
    } 
    else if($row['bill_status'] == '0' || $row['bill_status'] == '1' || $row['e_no'] == '' || $row["status_app"]!='2'){
        // || (($row['snr_dispatch_mode'] == '' )|| ($row['snr_dispatch_mode'] == ''))
        $elcot_status='Elcot Entry Pending';
       }
    // else if($row["sign_dc_received_status"] == '' || $row['sign_ir_status'] == '2' || $row['bill_status'] == '0' || $row['bill_status'] == '1' || $row['e_no'] == ''){
    //     $elcot_status='Elcot Entry Pending';
    // }
    else if($row['payment_date'] == ''){
        $elcot_status='Payment Pending';
    }
    else if($row['payment_date'] != ''){
        $elcot_status='Payment Completed';
    }
    // else{
    //     $elcot_status ='--';
    // }
// dc installation tab 2 status
// $dc_delivery_status=$row['dc_delivery_status'];

// else if($row['payment_date'] == ''){
//     // || (($row['snr_dispatch_mode'] == '' )|| ($row['snr_dispatch_mode'] == ''))
//     $row["status"]='Payment Pending';
//    }
//    else if($row['payment_date'] != ''){
//     // || (($row['snr_dispatch_mode'] == '' )|| ($row['snr_dispatch_mode'] == ''))
//     $row["status"]='Payment Completed';
//    }


if($row['dc_delivery_status'] == 0){
    $dc_delivery_status = 'Pending';
}
else if($row['dc_delivery_status'] == 5){
    $dc_delivery_status = 'partial Completed';
}
else if($row['dc_delivery_status'] == 1){
    $dc_delivery_status = 'SNR';
}
else if($row['dc_delivery_status'] == 3){
    $dc_delivery_status = 'Completed';
}
    $excel->getActiveSheet()
        ->setCellValue('A' . $row_val, ++$i)
        ->setCellValue('B' . $row_val, ($row["po_num"]))
        // ->setCellValue('B' . $row_val, $poNumber) // PO number
        ->setCellValue('C' . $row_val, disdate($row["po_date"]))
        ->setCellValue('D' . $row_val, ($department_name["department"]))
        ->setCellValue('E' . $row_val, ($executive["executive_name"]))
        // ->setCellValue('F' . $row_val, ($row["ledger_name"]))
        ->setCellValue('F' . $row_val, ($ledger_name))
        // ->setCellValue('G' . $row_val, ($row["ledger_no"]))
        ->setCellValue('G' . $row_val, ($ledger_no))
        ->setCellValue('H' . $row_val, ($row["po_bill_address"]))
        ->setCellValue('I' . $row_val, ($row["po_pin"]))
        ->setCellValue('J' . $row_val, ($row["con_address"]))
        ->setCellValue('K' . $row_val, $con_district_name)
         ->setCellValue('L' . $row_val, ($row["con_pincode"]))
        ->setCellValue('M' . $row_val, ($row["con_contact_name"]))
        ->setCellValue('N' . $row_val, ($row["con_contact_number"]))
        ->setCellValue('O' . $row_val, ($row["po_prepared_by"]))
        ->setCellValue('P' . $row_val, $con_item_name)
        ->setCellValue('Q' . $row_val, ($row["product"]))
        ->setCellValue('R' . $row_val, ($row["assign_qty"]))
        ->setCellValue('S' . $row_val, ($row["unit_price"]))
        ->setCellValue('T' . $row_val, ($row["tax"]))
        ->setCellValue('U' . $row_val, ($row["total_value"]))
        ->setCellValue('V' . $row_val, ($row["net_value"]))
        ->setCellValue('W' . $row_val, ($row["stock_qty"]))
        ->setCellValue('X' . $row_val, ($row["invoice_no"]))
        ->setCellValue('Y' . $row_val, disdate($row["invoice_date"]))
        ->setCellValue('Z' . $row_val, ($row["elcot_team_verifiy_status"]))
        ->setCellValue('AA' . $row_val, ($row["ac_team_verifiy_status"]))
        ->setCellValue('AB' . $row_val, disdate($row["dispatch_date"]))
        ->setCellValue('AC' . $row_val, ($row["mode_of_delivery"]))
        ->setCellValue('AD' . $row_val, ($row["pod_no"]))
        ->setCellValue('AE' . $row_val, ($row["delivery_status"]))

        ->setCellValue('AF' . $row_val, ($row["installation_invoice_no"]))

        // $worksheet->setCellValue('AG' . $row_val, $staff_name);
        ->setCellValue('AG' . $row_val, ($staff_name))
        // ($department_name["department"]))

        ->setCellValue('AH' . $row_val, disdate($row["ir_cus_signed_date"]))
        ->setCellValue('AI' . $row_val, ($row["dc_received_sts"]))

        ->setCellValue('AJ' . $row_val, ($row["ir_rec_status"]))
        ->setCellValue('AK' . $row_val, ($row["snr_rec_status"]))
        ->setCellValue('AL' . $row_val, ($dc_delivery_status))
        ->setCellValue('AM' . $row_val, ($row["dc_dispatch_mode"]))
        ->setCellValue('AN' . $row_val, ($row["snr_dispatch_mode"]))
        ->setCellValue('AO' . $row_val, ($row["ir_dispatch_mode"]))
        ->setCellValue('AP' . $row_val, ($row["dc_pod_no"]))
        ->setCellValue('AQ' . $row_val, ($row["snr_pod_no"]))
        ->setCellValue('AR' . $row_val, ($row["ir_pod_no"]))
        ->setCellValue('AS' . $row_val, disdate($row["dc_pod_date"]))
        ->setCellValue('AT' . $row_val, disdate($row["snr_pod_date"]))
        ->setCellValue('AU' . $row_val, disdate($row["ir_pod_date"]))
        ->setCellValue('AV' . $row_val, disdate($row["dc_cus_signed_date"]))
        ->setCellValue('AW' . $row_val, disdate($row["ir_cus_signed_date"])) 
        
        // ->setCellValue('AS' . $row_val, ($row["ir_pod_no"]))

        ->setCellValue('AX' . $row_val, disdate($row["doc_chn"]))
        ->setCellValue('AY' . $row_val, ($row["sign_dc_received_status"]))
        ->setCellValue('AZ' . $row_val, ($row["sign_ir_status"]))
        ->setCellValue('BA' . $row_val, ($row["bg_month"]))
        ->setCellValue('BB' . $row_val, ($row["bg_percentage"]))
        ->setCellValue('BC' . $row_val, ($row["bg_status"]))
        ->setCellValue('BD' . $row_val, ($row["bg_num"]))
        ->setCellValue('BE' . $row_val, disdate($row["bg_date"]))
        ->setCellValue('BF' . $row_val, ($row["bg_validity_date"]))
        ->setCellValue('BG' . $row_val, ($row["bg_validity_end_date"]))
        ->setCellValue('BH' . $row_val, disdate($row["bill_submission_date"]))
        ->setCellValue('BI' . $row_val, ($row["supplier_invoice_number"]))
        ->setCellValue('BJ' . $row_val, ($row["installation_reference_no"]))
        ->setCellValue('BK' . $row_val, ($row["e_no"]))
        ->setCellValue('BL' . $row_val, disdate($row["payment_date"]))
        ->setCellValue('BM' . $row_val, ($row["tran_amt"]))
        // ->setCellValue('BN'.$row_val,   ($row["ld_amount"]))
        // ->setCellValue('BO'.$row_val,   ($row["ld_days"]))
        ->setCellValue('BN'.$row_val,   ($row["ld_days"]))
        ->setCellValue('BO'.$row_val,   ($row["ld_amount"]))
        ->setCellValue('BP'.$row_val,   ($row["ld_deducted"]))

        ->setCellValue('BQ'.$row_val,   ($row["payment%"]))
        ->setCellValue('BR'.$row_val,   ($row["status"]))
        ->setCellValue('BS'.$row_val,   ($row["acc_year"]))
        ->setCellValue('BT'.$row_val,   ($elcot_status));
		
    $row_val++;
    // $i++;
}
//for Styling
$styleArray = array(
    'font' => array(
        'bold' => true
    )
);
// $excel->mergeCells('A1:E1');
$excel->getActiveSheet()->getStyle('A1:BT3')->applyFromArray($styleArray);
$excel->getActiveSheet()->getStyle('A3:BT3')->applyFromArray($styleArray);
// $excel->getActiveSheet()->getStyle('A1:F1')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
// $excel = [
//     'borders' => [
//         'outline' => [
//             'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
//             'color' => ['rgb' => '000000'],
//         ],
//     ],
// ];
$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal('center');
$excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
$excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
$excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
$excel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
$excel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
$excel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
$excel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
$excel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
$excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
$excel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
$excel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
$excel->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
$excel->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);
$excel->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true);
$excel->getActiveSheet()->getColumnDimension('R')->setAutoSize(true);
$excel->getActiveSheet()->getColumnDimension('S')->setAutoSize(true);
$excel->getActiveSheet()->getColumnDimension('T')->setAutoSize(true);
$excel->getActiveSheet()->getColumnDimension('U')->setAutoSize(true);
$excel->getActiveSheet()->getColumnDimension('V')->setAutoSize(true);
$excel->getActiveSheet()->getColumnDimension('W')->setAutoSize(true);
$excel->getActiveSheet()->getColumnDimension('X')->setAutoSize(true);
$excel->getActiveSheet()->getColumnDimension('Y')->setAutoSize(true);
$excel->getActiveSheet()->getColumnDimension('Z')->setAutoSize(true);
$excel->getActiveSheet()->getColumnDimension('AA')->setAutoSize(true);
$excel->getActiveSheet()->getColumnDimension('AB')->setAutoSize(true);
$excel->getActiveSheet()->getColumnDimension('AC')->setAutoSize(true);
$excel->getActiveSheet()->getColumnDimension('AD')->setAutoSize(true);
$excel->getActiveSheet()->getColumnDimension('AE')->setAutoSize(true);
$excel->getActiveSheet()->getColumnDimension('AF')->setAutoSize(true);
$excel->getActiveSheet()->getColumnDimension('AG')->setAutoSize(true);
$excel->getActiveSheet()->getColumnDimension('AH')->setAutoSize(true);
$excel->getActiveSheet()->getColumnDimension('AI')->setAutoSize(true);

$excel->getActiveSheet()->getColumnDimension('AJ')->setAutoSize(true);
$excel->getActiveSheet()->getColumnDimension('AK')->setAutoSize(true);
$excel->getActiveSheet()->getColumnDimension('AL')->setAutoSize(true);
$excel->getActiveSheet()->getColumnDimension('AM')->setAutoSize(true);
$excel->getActiveSheet()->getColumnDimension('AN')->setAutoSize(true);

$excel->getActiveSheet()->getColumnDimension('AO')->setAutoSize(true);
$excel->getActiveSheet()->getColumnDimension('AP')->setAutoSize(true);
$excel->getActiveSheet()->getColumnDimension('AQ')->setAutoSize(true);
$excel->getActiveSheet()->getColumnDimension('AR')->setAutoSize(true);
$excel->getActiveSheet()->getColumnDimension('AS')->setAutoSize(true);

$excel->getActiveSheet()->getColumnDimension('AT')->setAutoSize(true);
$excel->getActiveSheet()->getColumnDimension('AU')->setAutoSize(true);
$excel->getActiveSheet()->getColumnDimension('AV')->setAutoSize(true);
$excel->getActiveSheet()->getColumnDimension('AW')->setAutoSize(true);
$excel->getActiveSheet()->getColumnDimension('AX')->setAutoSize(true);



$excel->getActiveSheet()->getColumnDimension('AY')->setAutoSize(true);
$excel->getActiveSheet()->getColumnDimension('AZ')->setAutoSize(true);
$excel->getActiveSheet()->getColumnDimension('BA')->setAutoSize(true);
$excel->getActiveSheet()->getColumnDimension('BB')->setAutoSize(true);
$excel->getActiveSheet()->getColumnDimension('BC')->setAutoSize(true);

$excel->getActiveSheet()->getColumnDimension('BD')->setAutoSize(true);
$excel->getActiveSheet()->getColumnDimension('BE')->setAutoSize(true);
$excel->getActiveSheet()->getColumnDimension('BF')->setAutoSize(true);
$excel->getActiveSheet()->getColumnDimension('BG')->setAutoSize(true);
$excel->getActiveSheet()->getColumnDimension('BH')->setAutoSize(true);
$excel->getActiveSheet()->getColumnDimension('BI')->setAutoSize(true);
$excel->getActiveSheet()->getColumnDimension('BJ')->setAutoSize(true);
$excel->getActiveSheet()->getColumnDimension('BK')->setAutoSize(true);
$excel->getActiveSheet()->getColumnDimension('BL')->setAutoSize(true);
$excel->getActiveSheet()->getColumnDimension('BM')->setAutoSize(true);
$excel->getActiveSheet()->getColumnDimension('BN')->setAutoSize(true);
$excel->getActiveSheet()->getColumnDimension('BO')->setAutoSize(true);
$excel->getActiveSheet()->getColumnDimension('BP')->setAutoSize(true);
$excel->getActiveSheet()->getColumnDimension('BQ')->setAutoSize(true);
$excel->getActiveSheet()->getColumnDimension('BR')->setAutoSize(true);
$excel->getActiveSheet()->getColumnDimension('BS')->setAutoSize(true);
$excel->getActiveSheet()->getColumnDimension('BT')->setAutoSize(true);



header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="overall Form Excel.xls"');
header('Cache-Control: max-age=0');
$fileDownload = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
ob_clean();
$fileDownload->save('php://output');
function disdate($date)
{
    $result     = "";
    if ($date) {
        $result =  implode("-", array_reverse(explode("-", $date)));
    }
    return $result;
}


