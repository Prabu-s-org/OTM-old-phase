<?php
require_once __DIR__ . '/../../config/env.php';
function unique_id($prefix = "") {

    $unique_id = uniqid().rand(10000,99999);

    if($prefix) {
        $unique_id = $prefix.$unique_id;
    }

    return $unique_id;
}
// header("Access-Control-Allow-Origin: *");
// header("Content-Type: application/json; charset=UTF-8");
// header("Access-Control-Allow-Methods: POST");
// header("Access-Control-Max-Age: 3600");
// header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
include_once 'database.php';
include_once 'po_assign.php';

$database = new Database();
$db = $database->getConnection();
$item = new Poassign($db);
// echo "hii";
$data = json_decode(file_get_contents("php://input"));
  

// $item->rem_qty = $data->rem_qty;
// $item->status = $data->status;

// if($item->createPoassign()){
//     // echo $msg = "create";
//     echo json_encode(["status" => true, "msg" => "Po Assign Api created successfully."]);
// } else {
//     echo json_encode(["status" => false, "msg" => "Po Assign Api could not be created."]);
// }


if(!empty($data->form_main_unique_id) && !empty($data->con_unique_id) && !empty($data->con_name) && !empty($data->con_contact_no) && !empty($data->unit_price) && !empty($data->product_unique_id) && !empty($data->item_code) && !empty($data->item_name) && !empty($data->qty) && !empty($data->bill_qty)){    
  
    $item->unique_id                   = unique_id();  
    
    $item->form_main_unique_id = $data->form_main_unique_id;
    $item->con_unique_id = $data->con_unique_id;
    $item->con_name = $data->con_name;
    $item->con_contact_no = $data->con_contact_no;
    $item->unit_price = $data->unit_price;
    $item->product_unique_id = $data->product_unique_id;
    $item->item_code = $data->item_code;
    $item->product = $data->item_name;
    $item->qty = $data->qty;
    $item->assign_qty = $data->bill_qty;

$servername = "localhost";
$username = project_env('APP_DB_USERNAME', 'root');
$password = "";
$database_name = "operation_team_beta";
$conn = new mysqli($servername,$username,$password,$database_name);

$stmt = "SELECT count(*) as count FROM po_product_assign_details where form_main_unique_id = '$data->form_main_unique_id' AND con_unique_id = '$data->con_unique_id' AND product_unique_id = '$data->product_unique_id'";
// AND con_contact_no = $data->con_contact_no

$sql = mysqli_query($conn,$stmt);
// $stmt->execute();

// $result = $stmt->get_result();
while($num = mysqli_fetch_array($sql)){
$nums = $num['count'];
}
// print_r($nums);die();
// echo $cnt = $sql->num_rows;
// echo "SELECT * FROM enquiry_creation where mobile_no = '$data->mobile_no'";
//    $count = count($sql);
    if($nums == 0){
    // echo "hoo";
            if($item->createPoassign()){  
                //  http_response_code(201);     
                echo "Record Created Successfully";

            } 
            else{


        http_response_code(503);        
        echo json_encode(array("message" => "Unable to create item."));
    }
}
else{
    if($item->updatePoassign()){  
        //  http_response_code(201);     
         echo "con num already Exit";
    
    } else{
    
    
        http_response_code(503);        
        echo json_encode(array("message" => "Unable to create item."));
    }
// echo "con Num Already Exists";
}

}else{    
http_response_code(400);    
echo json_encode(array("message" => "Unable to create item. Data is incomplete."));
}

?>


