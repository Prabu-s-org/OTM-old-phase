
<?php
require_once __DIR__ . '/../../config/env.php';

// // Include DB file and Common Functions
include '../../config/dbconfig.php';
 include 'simplexlsx.php'; 

require_once("../../assets/PHPExcel-1.8/Classes/PHPExcel.php");
// $password = project_env('LEGACY_CREDENTIAL_2');
// $database_name = "aed_elcot_beta";
try {
    $conn = new PDO("mysql:host=localhost;dbname=operation_team_beta", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}
session_start();
// $acc_year = $_SESSION['acc_year'];
// print_r($_POST['no_of_consignee']);
$no_of_consignee = $_POST['no_of_consignee'];

$form_main_unique_id  =  $_POST['form_main_unique_id'];

$cons_verify_sts  = $_POST['cons_verfiy_sts'];


// if (isset($_REQUEST["import"])) {
    // if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
    $allowedFileType = [
        'application/vnd.ms-excel',
        'text/xls',
        'text/xlsx',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
    ];

    if (in_array($_FILES["file"]["type"], $allowedFileType)) {
        $file_path = $_FILES['file']['tmp_name'];
        $xlsx = new SimpleXLSX($file_path);


        $rows = $xlsx->rows();


        $uploaded_count  = count($rows);


        $check_existing = $conn->prepare('select COUNT(*) from consignee_details_sub where form_main_unique_id = ? and is_delete = 0' );
        $check_existing->execute([$form_main_unique_id]);

        $exisiting_count  = $check_existing->fetchColumn();

        $total_after_upload = $exisiting_count + $uploaded_count;

        // print_r($total_after_upload); die();



        if($total_after_upload > $no_of_consignee){

            echo "<script>alert('Error:You can only have $no_of_consignee consignee records')</script>";
            // exit;
        }



      
            if ($no_of_consignee == 1 && count($rows) > 1) {

                // print_r('hi');
            echo json_encode(['status' => 'error',"message" => "Ony 1 row is allowed when consignee is 1"]);
            // exit;
        }

        $check_existing = $conn->prepare('select COUNT(*) from consignee_details_sub where form_main_unique_id = ? AND no_of_consignee = 1 AND is_delete = 0');
        $check_existing->execute([$form_main_unique_id]);

        $exisiting_count  = $check_existing->fetchColumn();

        // print_r($exisiting_count);die();


        if($no_of_consignee == 1 &&  $exisiting_count > 0 ){

            echo json_encode(["status" => "error", "message" => "Excel file already uploaded for consignee 1. Delete before re-uploading."]);
            // exit;
        }

        $stmt = $conn->prepare("INSERT INTO consignee_details_sub(con_address,con_district,zone,con_pincode,con_contact_name,con_contact_number,con_lan_num,consignee_gst, unique_id,form_main_unique_id,no_of_consignee,cons_verify_sts) VALUES (?, ?, ?,?, ?, ?,?,?,?,?,?,?)");
        

        
        // $stmt->bindParam(1, $no_of_consignee);
        $stmt->bindParam(1, $con_address);
        $stmt->bindParam(2, $con_district);
        $stmt->bindParam(3, $zone);
        $stmt->bindParam(4, $con_pincode);
        $stmt->bindParam(5, $con_contact_name);
        $stmt->bindParam(6, $con_contact_number);
        $stmt->bindParam(7, $con_lan_num);
         $stmt->bindParam(8, $consignee_gst);       
        // $stmt->bindParam(8, $gst);
        // $stmt->bindParam(9, $warranty_in_yrs);
        // $stmt->bindParam(9, $bg_months);
        $stmt->bindParam(9, $unique_id);
        $stmt->bindParam(10, $form_main_unique_id);
        $stmt->bindParam(11, $no_of_consignee);
        $stmt->bindParam(12,$cons_verify_sts);
       

        foreach ($rows as $fields) {
            // print_r($fields);

        // // GET District ID
            $select_district_name = $conn->prepare("select unique_id from district_creation where district_name ='".$fields[1]."'");
            $select_district_name->execute();
            $row_district_name = $select_district_name->fetch();
            $district_name_value = $row_district_name['unique_id'];
          
            // foreach ($xlsx->rows() as $fields) {
            $select_con_no = $conn->prepare("select  no_of_consignee from po_form where no_of_consignee ='".$_POST['no_of_consignee']."'");
            $select_con_no->execute();
            $row_con_no = $select_con_no->fetch();
            $no_con_value = $row_con_no['no_of_consignee'];
            // }
        //   print_r($no_con_value);
            // if($_POST['no_of_consignee'] > $no_con_value){
            //     $type = "error";
            //     $message = "no of consignee not match.";
            // }
            // else{
            $unique_id              = unique_id("");
            // $no_of_consignee            = $fields[0];
            $con_address            = $fields[0];
            $con_district          = $district_name_value;
            $zone                   = $fields[2];
            $con_pincode             = $fields[3];
            $con_contact_name        =$fields[4];
            $con_contact_number         =$fields[5];
            $con_lan_num             = $fields[6];
             $consignee_gst             = $fields[7];
            $form_main_unique_id = $_POST['form_main_unique_id'];
            $no_of_consignee = $_POST['no_of_consignee'];
            $cons_verify_sts = $_POST['cons_verfiy_sts'];
            // $con_lan_num             = $fields[8];
            // $gst                = $fields[7];
            // $warranty_in_yrs                = $fields[8];
            // $bg_months               = $fields[6];
            $stmt->execute();
          
            // print_r($stmt);
            echo "<script>alert('Upload Successfully')</script>";
        }
    // }
        // Display alert after successful upload
        
    // print_r('<script>alert("Upload Successfully")</script>');
    } else {
        $type = "error";
        $message = "Invalid File Type. Upload Excel File.";
    }
// }

?>




