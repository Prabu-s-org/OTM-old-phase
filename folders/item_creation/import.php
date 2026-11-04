<?php

if (isset($_REQUEST["import"])) {

    $allowedFileType = [
        'application/vnd.ms-excel',
        'text/xls',
        'text/xlsx',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
    ];

    if (in_array($_FILES["file"]["type"], $allowedFileType)) {

        $file_path = $_FILES['file']['tmp_name']; //get file from the path

        $xlsx = new SimpleXLSX($file_path);
        $fp = fopen('file.csv', 'w');
        foreach ($xlsx->rows() as $fields) {
            fputcsv($fp, $fields);
        }

        fclose($fp);

        $stmt = $conn->prepare("INSERT INTO item_creation_sub(tender_code, item_code, item_description, item_specification, brand, product_category, short_category, rc_unit_price, gst, warranty_in_yrs, unique_id) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
        
        foreach ($xlsx->rows() as $fields) {
            $tender_code = $fields[0];
            $item_code = $fields[1];
            $item_description = $fields[2];
            $item_specification = $fields[3];
            $brand = $fields[4];
            $product_category = $fields[5];
            $short_category = $fields[6];
            $rc_unit_price = $fields[7];
            $gst = $fields[8];
            $warranty_in_yrs = $fields[9];
            $unique_id = unique_id(""); // Assuming unique_id is a function that generates a unique ID

            // Check if the combination of tender_code and item_code already exists in the database
            $check_existing = $conn->prepare('SELECT COUNT(*) FROM item_creation_sub WHERE tender_code = ? AND item_code = ? AND is_delete = 0');
            $check_existing->execute([$tender_code, $item_code]);
            $existing_count = $check_existing->fetchColumn();

            if ($existing_count == 0) {
                // If not, insert the record
                $stmt->bindParam(1, $tender_code);
                $stmt->bindParam(2, $item_code);
                $stmt->bindParam(3, $item_description);
                $stmt->bindParam(4, $item_specification);
                $stmt->bindParam(5, $brand);
                $stmt->bindParam(6, $product_category);
                $stmt->bindParam(7, $short_category);
                $stmt->bindParam(8, $rc_unit_price);
                $stmt->bindParam(9, $gst);
                $stmt->bindParam(10, $warranty_in_yrs);
                $stmt->bindParam(11, $unique_id);
                $stmt->execute();
                // header('Location=')
            } else {
                // If the combination already exists, show an alert
                echo '<script>alert("Duplicate Tender Code and Item Code found. Data was not inserted.");</script>';
            }
        }
    } else {
        echo '<script>alert("Invalid File Type. Upload Excel File.");</script>';
    }
}

// if (isset($_REQUEST["import123"])) {

//     $allowedFileType = [
//         'application/vnd.ms-excel',
//         'text/xls',
//         'text/xlsx',
//         'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
//     ];

//     if (in_array($_FILES["file"]["type"], $allowedFileType)) {

//         $file_path = $_FILES['file']['tmp_name']; //get file from the path

//         $xlsx = new SimpleXLSX($file_path);
//         $fp = fopen('file.csv', 'w');
//         foreach ($xlsx->rows() as $fields) {
//             fputcsv($fp, $fields);
//         }

//         fclose($fp);

//         $table             = "item_creation_sub";


//         $check_existing = $conn->prepare('SELECT COUNT(*) FROM item_creation_sub WHERE tender_code = ? AND item_code = ? AND is_delete = 0');
// $check_existing->execute([$tender_code, $item_code]);  // Pass both variables here

// $existing_count = $check_existing->fetchColumn();
        
//         if($existing_count == 0){

//         $stmt = $conn->prepare("INSERT INTO item_creation_sub(tender_code,item_code,item_description,item_specification,brand,product_category,short_category,
//         rc_unit_price,gst,warranty_in_yrs,unique_id) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
//         // print_r($stmt);die();
      
//         $stmt->bindParam(1, $tender_code);
//         $stmt->bindParam(2, $item_code);
//         $stmt->bindParam(3, $item_description);
//         $stmt->bindParam(4, $item_specification);
//         $stmt->bindParam(5, $brand);
//         $stmt->bindParam(6, $product_category);
//         $stmt->bindParam(7, $short_category);
//         $stmt->bindParam(8, $rc_unit_price);
//         $stmt->bindParam(9, $gst);
//         $stmt->bindParam(10, $warranty_in_yrs);
//         // $stmt->bindParam(9, $bg_months);
//         $stmt->bindParam(11, $unique_id);
//         foreach ($xlsx->rows() as $fields) {


//              $unique_id              = unique_id("");
//              $tender_code            = $fields[0];
//             $item_code            = $fields[1];
//           $item_description          = $fields[2];
//             $item_specification             = $fields[3];
//           $brand                    = $fields[4];
//             $product_category        =$fields[5];
//             $short_category         =$fields[6];
//           $rc_unit_price             = $fields[7];
//           $gst                = $fields[8];
//           $warranty_in_yrs                = $fields[9];
//             // $bg_months               = $fields[6];
//             $stmt->execute();
//             // print_r( $stmt);die();
//         }
//         $type = "error";
//         $message = "Invalid File Type. Upload Excel File.";
//     }
//     }else{
//     echo '<script>alert("Same Tender code and Product values to change it")</script>';
//     // $cnt = '1';
//     }
    
// }

?>
<?php
function ticket_number($table_name, $where, $prefix = "", $y = 1, $m = 1, $d = 1, $custom_date = false, $separator = "-")
{
    $billno = $prefix;

    if (!$custom_date) {
        $custom_date = date("Y-m-d");
    }

    if ($y) {
        $billno .= date('Y', strtotime($custom_date));
    }

    if ($m) {
        $billno .= date('m', strtotime($custom_date)) . $separator;
    }
    $bill_order_no  =  cnt_value($table_name, $where);
    // print_r($bill_order_no);
    $billno        .= sprintf("%04d", $bill_order_no);
    return $billno;
}

function cnt_value($table_name, $where)
{
    if ($table_name) {
        global $pdo;

        $columns    = [
            "count(acc_year) AS save_status"
        ];

        $table_details = [
            $table_name,
            $columns
        ];

        $result         = $pdo->select($table_details, $where);

        if ($result->status) {

            $res_array      = $result->data[0]['save_status'] + 1;
            // print_r($res_array);
        } else {
            print_r($result);
            $res_array = uniqid() . rand(10000, 99999) . "Error";
        }

        return $res_array;
    }
}

?>
