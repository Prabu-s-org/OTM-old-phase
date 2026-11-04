<?php 

// Get folder Name From Currnent Url 
$folder_name        = explode("/",$_SERVER['PHP_SELF']);
$folder_name        = $folder_name[count($folder_name)-2];

// Database Country Table Name
$table             = "bill_submission_main_table";
$table_sub  ="bill_submission_sub";
// Include DB file and Common Functions
include '../../config/dbconfig.php';

// Variables Declaration
$action             = $_POST['action'];
$action_obj         = (object) [
    "status"    => 0,
    "data"      => "",
    "error"     => "Action Not Performed"
];
$json_array         = "";
$sql                = "";

$user_type          = "";
$is_active          = "";
$unique_id          = "";
$prefix             = "";

$data               = "";
$msg                = "";
$error              = "";
$status             = "";
$test               = ""; // For Developer Testing Purpose

switch ($action) {
    case 'createupdate':

        $unique_id          = $_POST["unique_id"];
        $e_no          = $_POST["e_no"];
        $bill_sub_date          = $_POST["bill_sub_date"];

        $update_where       = "";

        $columns            = [
            "e_no"           => $e_no,
            "bill_submission_date"           => $bill_sub_date,
            "elcot_ent_status"     => 1
        ];

        // Update Begins
        if($unique_id) {

            unset($columns['unique_id']);

            $update_where   = [
                "unique_id"     => $unique_id,
            ];
            
            $action_obj     = $pdo->update($table,$columns,$update_where);

        // Update Ends
        } 

        if ($action_obj->status) {
            $status     = $action_obj->status;
            $data       = $action_obj->data;
            $error      = "";
            $sql        = $action_obj->sql;

            if ($unique_id) {
                $msg        = "update";
            } 
            // else {
            //     $msg        = "create";
            // }
        } else {
            $status     = $action_obj->status;
            $data       = $action_obj->data;
            $error      = $action_obj->error;
            $sql        = $action_obj->sql;
            $msg        = "error";
        }

        $json_array   = [
            "status"    => $status,
            "data"      => $data,
            "error"     => $error,
            "msg"       => $msg,
            "sql"       => $sql
        ];

        echo json_encode($json_array);

        break;

    case 'datatable':
        // DataTable Variables
		$search 	= $_POST['search']['value'];
		$length 	= $_POST['length'];
	    $start 		= $_POST['start'];
		$draw 		= $_POST['draw'];
		$limit 		= $length;

		$data	    = [];
		

		if($length == '-1') {
			$limit  = "";
        }

        // Query Variables
        $json_array     = "";
        $columns        = [
            "'' as  s_no",
            "po_num",
            "po_date",
            "bill_no",
            "invoice_no",
            "invoice_value",
            "e_no",
            "elcot_ent_status",
            "unique_id",
            // "bill_no"
        ];
        $table_details  = [
            $table,
            $columns
        ];
        // $where          = [
        //     "is_delete"     => 0
        // ];
        // $order_by       = "";

        $where = " is_delete = '0'";

        $order_column   = $_POST["order"][0]["column"];
        $order_dir      = $_POST["order"][0]["dir"];

        // Datatable Ordering 
        $order_by       = datatable_sorting($order_column,$order_dir,$columns);

        // Datatable Searching
        $search         = datatable_searching($search,$columns);

        if ($search) {
            if ($where) {
                $where .= " AND ";
            }

            $where .= $search;
        }

        $sql_function   = "SQL_CALC_FOUND_ROWS";

        $result         = $pdo->select($table_details,$where,$limit,$start,$order_by,$sql_function);
        $total_records  = total_records();

        if ($result->status) {

            $res_array      = $result->data;

            foreach ($res_array as $key => $value) {
                $value['s_no'] = $sno + 1;
                
                $invoice_no= $value['invoice_no'];
                $arrayOfValues = explode(",", $value['invoice_no']);
                $count = count($arrayOfValues);
                $value['invoice_no'] = $count;

                 if ($value['elcot_ent_status'] == "0") {
                    $value['elcot_ent_status']   = "Pending";
                } else {
                    $value['elcot_ent_status']   = "Complete";
                }
                // $value['dc_file_name']= image_view("invoice", $value['invoice_unique_id'], $value['dc_file_name']);
            //    $value['e_no']= btn_download("elcot_entry", $value['unique_id'], $value['e_no']);
            // '<a href="index.php?file=dispatch/update1&unique_id=' . $value['po_form_unique_id'] . '"><i class="mdi mdi-square-edit-outline  mdi-24px waves-effect waves-light mt-n2 mb-n2 text-success"></i></a>';

            // $value['e_no']= '<a href="elcot.php?file=elcot_entry&unique_id=' . $value['unique_id'] .'">download</a>';
            // $value['e_no']= '<a href="elcot_entry.php?file=elcot.php">download</a>';
            // $value['e_no']='<a href="elcot_entry.php" target="_blank"> Download PDF </a>';
              
                $value['e_no'] = btn_download($folder_name,$value['unique_id'],'elcot',"","","");
            
                $btn_update         = btn_update($folder_name,$value['unique_id']);
                $btn_delete         = btn_delete($folder_name,$value['unique_id']);
                $value['unique_id'] = $btn_update.$btn_delete;

                // if ($value['is_active'] == "1") {
                //     $value['is_active']   = "Active";
                // } else {

                //     $value['is_active']   = "Inactive";
                // }

                $value['unique_id'] = $btn_update.$btn_delete;
                $data[]             = array_values($value);
                $sno ++;
            }
            
            $json_array = [
                "draw"				=> intval($draw),
                "recordsTotal" 		=> intval($total_records),
                "recordsFiltered" 	=> intval($total_records),
                "data" 				=> $data,
                "testing"			=> $result->sql
            ];
        } else {
            print_r($result);
        }
        
        echo json_encode($json_array);
        break;
    
    

    case 'delete':
        
        $unique_id      = $_POST['unique_id'];

        $columns        = [
            "is_delete"   => 1
        ];

        $update_where   = [
            "unique_id"     => $unique_id
        ];

        $action_obj     = $pdo->update($table,$columns,$update_where);

        if ($action_obj->status) {
            $status     = $action_obj->status;
            $data       = $action_obj->data;
            $error      = "";
            $sql        = $action_obj->sql;
            $msg        = "success_delete";

        } else {
            $status     = $action_obj->status;
            $data       = $action_obj->data;
            $error      = $action_obj->error;
            $sql        = $action_obj->sql;
            $msg        = "error";
        }

        $json_array   = [
            "status"    => $status,
            "data"      => $data,
            "error"     => $error,
            "msg"       => $msg,
            "sql"       => $sql
        ];

        echo json_encode($json_array);
        break;

        //  case 'user_type_options':

        // $user_type          = $_POST['user_type'];

        // $user_type_options  = under_user_type($user_type);

        // $user_type_options  = select_option($user_type_options,"Select");

        // echo $user_type_options;
        
        // break;

    
    default:
        
        break;
}



// function btn_download(){
    
//   if(!empty($_GET['file'])){
//     $filename =basename($_GET['file']);
//     $filepath='elcot_entry/'. $filename;
//     if(!empty($filename)&&file_exists( $filepath)){
//         header("cache-Control:public");
//         header("Content-Description:File Transfer");
//         header("Content-Desposition:attachment;filename=$filename");
//         header("content-Type:application/zip");
//         header("content-transfer-Emcodeing:binary");
//         readfile($filepath);
//         exit;


//     }
//     else{
//         echo "This File Doses not exist.";

//     }
//   }  
// }
?>

