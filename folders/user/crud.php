<?php 
// Get folder Name From Currnent Url 
$folder_name        = explode("/",$_SERVER['PHP_SELF']);
$folder_name        = $folder_name[count($folder_name)-2];

// Database Country Table Name
$table             = "user";

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

$unique_id          = "";
$prefix             = "";

$data               = "";
$msg                = "";
$error              = "";
$status             = "";
$test               = ""; // For Developer Testing Purpose


$fileUploadPath = $fileUploadConfig->get("upload_folder");

// Create Folder in root->uploads->(this_folder_name) Before using this file upload
$fileUploadConfig->set("upload_folder",$fileUploadPath. $folder_name . DIRECTORY_SEPARATOR);

// File Upload Library Call
$fileUpload         = new Alirdn\SecureUPload\SecureUPload( $fileUploadConfig );

switch ($action) {
    case 'createupdate':

        $staff_name         = $_POST["staff_name"];
        $staff_id           = $_POST["staff_id"];
       // $gender             = $_POST["gender"];
       // $age                = $_POST["age"];
        $user_name          = $_POST["user_name"];
        // $zone_name          = $_POST["zone_name"];
        // $ward_name          = $_POST["ward_name"];
        $en_password        = md5($_POST["password"]);
        $password           = $_POST["password"];
        $user_type          = $_POST["user_type"];
        $is_active          = $_POST["is_active"];
        $email_id           = $_POST["email_id"];
        $mobile_no          = $_POST["mobile_no"];
        $confirm_password   = $_POST["confirm_password"];
        // $profile_image      = $_POST["profile_image"];
        // $securityquestion1  = $_POST["securityquestion1"];
        // $securityquestion2  = $_POST["securityquestion2"];
        // $securityquestion3  = $_POST["securityquestion3"];
        // $profile_status     = $_POST["profile_status"];
        // $document_number    = $_POST["document_number"];
        // $document_type      = $_POST["document_type"];
        // $otherProof_name    = $_POST["otherProof_name"];
        //$document_upload    = $_POST["document_upload"];
        $unique_id          = $_POST["unique_id"];

        $update_where       = "";

        $columns            = [
            "staff_name"            => $staff_name,
            "staff_id"              => $staff_id,
           // "gender"                => $gender,
           // "age"                   => $age,
            "user_name"             => $user_name,
            // "zone_name"             => $zone_name,
            // "ward_name"             => $ward_name,
            "password"              => $password,
            "en_password"           => $en_password,
            "email_id"              => $email_id,
            "mobile_no"             => $mobile_no,
            "is_active"             => $is_active,
            "user_type_unique_id"   => $user_type,
            // "profile_image"         => $profile_image,
            // "securityquestion1"     => $securityquestion1,
            // "securityquestion2"     => $securityquestion2,
            // "securityquestion3"     => $securityquestion3,
            // "profile_status"        => $profile_status,
            // "document_number"       => $document_number,
            // "document_type"         => $document_type,
            // "otherProof_name"       => $otherProof_name,
            //"document_upload"       => $document_upload,
            "unique_id"             => unique_id($prefix)
        ];

        
        

        // check already Exist Or not
        $table_details      = [
            $table,
            [
                "COUNT(unique_id) AS count"
            ]
        ];
        $select_where       = '(user_name = "'.$user_name.'")  AND staff_name = "'.$staff_name.'"  AND is_delete = 0  ';

        // When Update Check without current id
        if ($unique_id) {
            $select_where   .= ' AND unique_id !="'.$unique_id.'" ';
        }

        $action_obj         = $pdo->select($table_details,$select_where);

        if ($action_obj->status) {
            $status     = $action_obj->status;
            $data       = $action_obj->data;
            $error      = "";
            $sql        = $action_obj->sql;

        } else {
            $status     = $action_obj->status;
            $data       = $action_obj->data;
            $error      = $action_obj->error;
            $sql        = $action_obj->sql;
            $msg        = "error";
        }
        if ($data[0]["count"]) {
            $msg        = "already";
        } else if ($data[0]["count"] == 0) {
            // Update Begins
            if($unique_id) {

                unset($columns['unique_id']);

                $update_where   = [
                    "unique_id"     => $unique_id
                ];

                $action_obj     = $pdo->update($table,$columns,$update_where);

            // Update Ends
            } else {

                // Insert Begins            
                $action_obj     = $pdo->insert($table,$columns);
                // Insert Ends

            }

            if ($action_obj->status) {
                $status     = $action_obj->status;
                $data       = $action_obj->data;
                $error      = "";
                $sql        = $action_obj->sql;

                if ($unique_id) {
                    $msg        = "update";
                } else {
                    $msg        = "create";
                }

                $unique_id = "";

                if ($unique_id) {
                    $unique_id = $unique_id;
                } else {
                    $unique_id = $columns['unique_id'];
                }
            } else {
                $status     = $action_obj->status;
                $data       = $action_obj->data;
                $error      = $action_obj->error;
                $sql        = $action_obj->sql;
                $msg        = "error";
            }
        }

        $json_array   = [
            "status"    => $status,
            "data"      => $data,
            "error"     => $error,
            "msg"       => $msg,
            "sql"       => $sql,
            "unique_id" => $unique_id
        ];

        echo json_encode($json_array);

        break;
    
    
    case 'datatable':
        // DataTable Variables
        $search     = $_POST['search']['value'];
        $length     = $_POST['length'];
        $start      = $_POST['start'];
        $draw       = $_POST['draw'];
        $limit      = $length;

        $data       = [];
        

        if($length == '-1') {
            $limit  = "";
        }

        // Query Variables
        $json_array     = "";
        $columns        = [
            "'' as  s_no",
            "staff_name",
            "mobile_no",
            "user_name",
            "(SELECT user_type FROM user_type AS user_type WHERE user_type.unique_id = ".$table.".user_type_unique_id ) AS user_type",
            // "password",
            "is_active",
            "unique_id"
        ];
        $table_details  = [
            $table,
            $columns
        ];

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
        $screen_id_val      = $_POST['screen_id_val'];
        // print_r($screen_id_val);die();
        $user_type  = $_POST['usertype'];
        
    $table_user ="user_screen_permission";
        $columns        = [
            // "screen_unique_id",
            "action_unique_id",
            "user_type"
        ];
        $select_where ="screen_unique_id='".$screen_id_val."' AND user_type='".$user_type."'";
        // print_r($select_where);die();
        $table_details   = [
            $table_user,
            $columns
        ];

        $table_users  = $pdo->select($table_details, $select_where);

            $table_users      = $table_users->data;

            // print_r($table_users);die();
            $action_ids = [];

            foreach ($table_users as $item) {
                if (isset($item['action_unique_id'])) {
                    $action_ids[] = $item['action_unique_id'];
                }
            }

        if ($result->status) {

            $res_array      = $result->data;
            $sno = 0;

            foreach ($res_array as $key => $value) {
                $value['s_no'] = $sno + 1;
                $btn_update   = btn_update($folder_name,$value['unique_id']);
                $btn_delete   = btn_delete($folder_name,$value['unique_id']);
                // $value['unique_id'] = $btn_update.$btn_delete;
                if (in_array('5f88082b25ec031952', $action_ids) && in_array('5f8808504271036738', $action_ids)) {
                    $value['unique_id'] = $btn_update.$btn_delete;                   
                }else if(in_array('5f88082b25ec031952', $action_ids)){
                    $value['unique_id'] = $btn_update;
                }else if(in_array('5f8808504271036738', $action_ids)){
                    $value['unique_id'] = $btn_delete;
                }else{
                    $value['unique_id'] = '';
                }

                 if ($value['is_active'] == "1") {
                    $value['is_active']   = "Active";
                } else {

                    $value['is_active']   = "Inactive";
                }

                $data[]       = array_values($value);
                $sno ++;
            }
            
            $json_array = [
                "draw"              => intval($draw),
                "recordsTotal"      => intval($total_records),
                "recordsFiltered"   => intval($total_records),
                "data"              => $data,
                "testing"           => $result->sql
            ];
        } else {
            print_r($result);
        }
        
        echo json_encode($json_array);
        break;
    
        case 'user_permission':
            $screen_id_val      = $_POST['screen_id_val'];
            $user_type_unique_id   = $_POST['user_type_unique_id'];
            // print_r( $user_type_unique_id);die();
            
        $table_user ="user_screen_permission";
            $columns        = [
                // "screen_unique_id",
                "action_unique_id",
                "user_type"
            ];
            $select_where ="screen_unique_id='".$screen_id_val."' AND user_type='".$user_type_unique_id."'";
            // print_r($select_where);die();
            $table_details   = [
                $table_user,
                $columns
            ];
    
            $table_users  = $pdo->select($table_details, $select_where);
    
            if ($table_users->status) {
    
                $table_users      = $table_users->data;
    // print_r($table_users);die();
    $action_unique_ids = [];

    foreach ($table_users as $item) {
        if (isset($item['action_unique_id'])) {
            $action_unique_ids[] = $item['action_unique_id'];
        }
    }
    
    // Now $action_unique_ids contains all the action_unique_id values
    // print_r($action_unique_ids);die();
               
            
    
            // $data = array($table_users);
            } 
                $json_array = [
                    "draw"				=> intval($draw),
                    "recordsTotal" 		=> intval($total_records),
                    "recordsFiltered" 	=> intval($total_records),
                    "data" 				=> $action_unique_ids,
                    "testing"			=> $result->sql
                ];
            
             echo json_encode($json_array);
    
            break;

    case 'delete':

        $unique_id  = $_POST['unique_id'];

        $columns            = [
            "is_delete"   => 1,
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
    
   case 'image_upload':

        $update_where       = "";

        $unique_id          = $_POST['unique_id'];

        $columns            = [
            //"user_input"            => $_POST['input_name'],
            "file_original_name"    => is_array($_FILES['test_file']['name']) ? implode(",",$_FILES['test_file']['name']) : $_FILES['test_file']['name'] ,
            "unique_id"             => unique_id($prefix)
        ];

    
            $file_name          = "";
            $file_path          = "";
   
            foreach ($_FILES as $file_key => $file_value) {

               if (!empty($file_value['name'])) {

                    // Single File Upload
                    $confirm_upload     = $fileUpload->uploadFile($file_key);
                    
                    if($confirm_upload->status == 1) {

                        $c_file_name = $confirm_upload->name ? $confirm_upload->name.".".$confirm_upload->ext : "";
                        $c_file_path = $confirm_upload->path;

                        $_FILES[$file_key]['file_name']  = $c_file_name;
                        $_FILES[$file_key]['path']       = $c_file_path;

                    } else {

                        // if Any Error Occured in File Upload Stop the loop

                        $status     = $confirm_upload->status;
                        $data       = "file not uploaded";
                        $error      = $confirm_upload->error;
                        $sql        = "file upload error";
                        $msg        = "file_error";

                    }                    
                }
                
            }
            

            if ($msg != "file_error") {
                
                foreach ($_FILES as $fi_key => $fi_value) {
                    
                    if (!empty($fi_value['name'])) {

                        $file_names     = $fi_value['file_name'];
                        $file_org_names = $fi_value['name'];

                    }

                    if ($file_names) {

                        // Set Here Columns(from database) and Equal input(from Form) Names
                        // Add cases depending on how many fields You have 
                        switch ($fi_key) {
                            case 'test_file':
                                $columns['file_name']           = $file_names;
                                $columns['file_original_name']  = $file_org_names;
                                break;
                                
                                default:
                                # code...
                                break;
                        }
                            
                    }
                }

                // Update Begins

                if($unique_id) {

                    unset($columns['unique_id']);

                    $update_where   = [
                        "unique_id"     => $unique_id
                    ];

                    $action_obj     = $pdo->update("user",$columns,$update_where);

                // Update Ends
                } else {

                    // Insert Begins            
                    $action_obj     = $pdo->insert("user",$columns);
                    // Insert Ends

                }

                if ($action_obj->status) {
                    $status     = $action_obj->status;
                    $data       = $action_obj->data;
                    $error      = "";
                    $sql        = $action_obj->sql;

                    if ($unique_id) {
                        $msg        = "update";
                    } else {
                        $msg        = "create";
                    }
                } else {
                    $status     = $action_obj->status;
                    $data       = $action_obj->data;
                    $error      = $action_obj->error;
                    $sql        = $action_obj->sql;
                    $msg        = "error";
                }
            } 
       // }

        $json_array   = [
            "status"    => $status,
            "data"      => $data,
            "error"     => $error,
            "msg"       => $msg,
            "sql"       => $sql
        ];

        echo json_encode($json_array);

        break;
    

    default:
        
        break;

        
}

?>
