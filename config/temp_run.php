<?php
//     echo $user_image = "uploads/staff/3fc81e0e57c9ea9b7cd3d57ef4e1bec6.png";

// if (file_exists("../uploads/staff/3fc81e0e57c9ea9b7cd3d57ef4e1bec6.png")) {
//     echo $user_image = "uploads/staff/3fc81e0e57c9ea9b7cd3d57ef4e1bec6.png";
// } else {
//     echo "file_not_exits";
// }

include "dbconfig.php";

$where = [];

$table          = "zone_creation";

$where = "  is_delete = 0";


$continents_arr = $pdo->select($table,$where);
if ($continents_arr->status) {

    $continents_list    = $continents_arr->data;
    

    // $table              = "countries";

    foreach ($continents_list as $key => $value) {
        

        
        $unique_id          = $value["unique_id"];
       

print_r($unique_id);
        $columns = [
            "zone_name"            => $unique_id,
            
        ];

        $where   = [];

   


         $where   = [
            "zone_name" => $value["zone_name"]
        ];


        $update_val = $pdo->update("mcc_entry_sub",$columns,$where);
 print_r($update_val);

        if ($update_val->status) {
            echo "Update ID = ".$update_val->data;
        } else {
            print_r($update_val);
        }
    }
}

?>