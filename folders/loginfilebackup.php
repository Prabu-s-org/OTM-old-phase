<?php 

$folder_name        = explode("/",$_SERVER['PHP_SELF']);

$folder_name        = $folder_name[count($folder_name)-2];

$table              = "user";
$table_log          = "user_login_details";

// Include DB file and Common Functions
include '../../config/dbconfig.php';

// Variables Declaration 
$action             = $_REQUEST['action'];
$action_obj         = (object) [
    "status"    => 0,
    "data"      => "",
    "error"     => "Action Not Performed"
];
$json_array         = "";
$sql                = "";

$data               = "";
$msg                = "";
$error              = "";
$status             = "";
$test               = ""; // For Developer Testing Purpose

// $acc_year       = explode(" to ",$_REQUEST['acc_year']);
// $from_year      = (explode("-",$acc_year[0]))[0];
// $to_year        = (explode("-",$acc_year[1]))[0];

// $acc_year       = explode(" to ",$_REQUEST['acc_year']);
$from_year      = "2020";
$to_year        = "2021";

$sess_acc_year  = $from_year."-".$to_year;

$sess_acc_year  = acc_year();

switch ($action) {
    
    
    case 'login':

        $user_name  = $_REQUEST['user_name'];
        // $password   = md5($_REQUEST['password']);
        $password  = $_REQUEST['password'];


        $columns    = [
            "COUNT(unique_id) AS count",
            "user_type_unique_id",
            
            "staff_name",
            "profile_image AS user_image",
            
            "zone_name",
            "ward_name",
            "unique_id"
        ];

        $table_details = [
            $table,
            $columns
        ];

        $where = [
            "user_name" => $user_name,
            "password"  => $password,
            "is_active" => 1,
            "is_delete" => 0 
        ]; 

        // $where  = " (user_name LIKE BINARY '".$user_name."' OR phone_no LIKE BINARY  '".$user_name."') AND password LIKE BINARY  '".$password."' AND is_active = 1 AND is_delete = 0 ";

        $where  = "user_name = '".$user_name."'  AND password =  '".$password."' AND is_delete = 0 AND is_active = 1";

        $action_obj    = $pdo->select($table_details,$where);

        if ($action_obj->status) {
            $count_data     = $action_obj->data[0]["count"];
            if ($count_data == 1) {
                // session_start();
                $user                              = $action_obj->data[0];
                $msg                               = "success_login";

                $user_id                           = $user['unique_id'];
                $_SESSION["acc_year"]              = $sess_acc_year;
                $_SESSION["user_id"]               = $user_id;
                $_SESSION["staff_name"]            = $user['staff_name'];
                $_SESSION["user_name"]             = $user_name;
                $user_type                         = user_type($user['user_type_unique_id']);
                $_SESSION['sess_user_type']        = $user_type[0]['user_type'];
                $_SESSION['user_type_unique_id']        = $user['user_type_unique_id'];
                $_SESSION['sess_zone_name']  = $user['zone_name'];
                $_SESSION['sess_ward_name']  = $user['ward_name'];
                $_SESSION['sess_user_id']          = $user_id;
                $_SESSION['sess_user_location']    = 'Erode';
                $_SESSION['sess_company_name']     = 'Ascent E-Digit Solutions';
                $_SESSION['sess_company_address']  = '64, Kalaimagal School Road,';
                $_SESSION['sess_company_district'] = 'Erode 638001,';
                $_SESSION['sess_company_state']    = 'Tamil Nadu, INDIA.';
                $_SESSION['sess_company_phone_no'] = '0424-2269797';
                $_SESSION['sess_company_id']       = "comp5fa3b1c2a3bab70290";
                $_SESSION['sess_img_path']         = "img/";
                //$_SESSION['company_logo']          = "logo-light.png";
		$_SESSION['company_logo']          = "logo-new.png";
                $_SESSION['sess_branch_id']        = "bran5fa3b1dced5d363322";
                $_SESSION['ip_address']            = get_client_ip();
                $msg                               = "success_login";

                $permissions                       = menu_permission($user['user_type_unique_id']);

                 //print_r($permissions);

                $main_screens                      = $permissions["main_screens"];
                $sections                          = $permissions["sections"];
                $screens                           = $permissions["screens"];

                $_SESSION['main_screens']          = $main_screens;
                $_SESSION['sections']              = $sections;
                $_SESSION['screens']               = $screens;
                $user_image                        = "upload/user/user.png";

         
                if ($user['user_image']) {
                    $user_image = "upload/user/".$user['user_image'];
                }

                
                $_SESSION["user_image"] = $user_image;

                //login CURD function

                if($user_id!=''){

                $columns_login       = [
                        
                        "user_id"              => $user_id,
                        "entry_date"           => date('Y-m-d'),
                        "entry_time"           => date('h:i:s'),
                        "log_type"             => 1,
                        "unique_id"            => unique_id($prefix)
                 ];

                 $action_obj_log     = $pdo->insert($table_log,$columns_login);

              }


                $json_array = [
                    "status"    => 1,
                    "data"      => 1,
                    "error"     => 0,
                    "msg"       => "success_login",
                    // "test"      => $_SESSION["file_status"],
                    "sql"       => $_SESSION["user_id"],
                    "session"   => $_SESSION
                ];

            } else {
                // Incorrect username and password handling 
                $json_array = [
                    "status"    => 0,
                    "data"      => 1,
                    "error"     => 0,
                    "msg"       => "incorrect",
                    "sql"       => ""
                ];
            }
        } else {
            $msg    = "error";
        }

        


        // // For Tempervary Login 
        // if (($user_name == "admin") && ($password == "password")) {
        //         // session_start();
        //         $user_id                           = "user5fa3b19be003d60568";
        //         $_SESSION["acc_year"]              = $sess_acc_year;
        //         $_SESSION["user_id"]               = $user_id;
        //         $_SESSION["user_name"]             = $user_name;
        //         $_SESSION['sess_user_type']        = "5f97fc3257f2525529";
        //         $_SESSION['sess_user_id']          = $user_id;
        //         $_SESSION['sess_user_location']    = 'Erode';
        //         $_SESSION['sess_company_name']     = 'Ascent E-Digit Solutions';
        //         $_SESSION['sess_company_address']  = '64, Kalaimagal School Road,';
        //         $_SESSION['sess_company_district']  = 'Erode 638001,';
        //         $_SESSION['sess_company_state']  = 'Tamil Nadu, INDIA.';
        //         $_SESSION['sess_company_phone_no'] = '0424-2269797';
        //         $_SESSION['sess_company_id']       = "comp5fa3b1c2a3bab70290"; 
        //         $_SESSION['sess_img_path']         = "img/";
        //         $_SESSION['sess_branch_id']        = "bran5fa3b1dced5d363322";
        //         $msg                               = "success_login";

        //         $json_array = [
        //             "status"    => 1,
        //             "data"      => 1,
        //             "error"     => 0,
        //             "msg"       => "success_login",
        //             "sql"       => $_SESSION["user_id"]
        //         ];
        // } else {
        //     $json_array = [
        //         "status"    => 0,
        //         "data"      => 1,
        //         "error"     => 0,
        //         "msg"       => "incorrect",
        //         "sql"       => ""
        //     ];
        // }
        
        echo json_encode($json_array); 
        
        break;

         case 'validate':

        $mobile_no  = $_REQUEST["mobile_no"];
        //$email_id   = $_REQUEST["email_id"];

        $columns    = [
            "COUNT(unique_id) AS count",
            "user_type_unique_id",
            "staff_name",
            "email_id",
            "mobile_no",
            "profile_image AS user_image",
            "zone_name",
            "ward_name",
            "unique_id",
            "is_active"
        ];

        $table_details = [
            $table,
            $columns
        ];

        
        $where  = "mobile_no = '".$mobile_no."' AND is_delete = 0 ";

        $action_obj    = $pdo->select($table_details,$where);

        if ($action_obj->status) {
            $count_data        = $action_obj->data[0]["count"];
            $active_status     = $action_obj->data[0]["is_active"];
            if (($count_data == 1)&&($active_status == 1)) {
               
                $user                              = $action_obj->data[0];
                $msg                               = "success_login";
                
                $user_id                           = $user['unique_id'];
                
                $msg                               = "success_login";

                $user_image                        = "upload/user/user.png";

                $mobile_no = $user['mobile_no'];
			$mobile_no_enc = base64_encode(openssl_encrypt($mobile_no, $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv));
            // echo $mobile_no_enc;

            $unique_id = $user['unique_id'];
			$unique_id_enc = base64_encode(openssl_encrypt($unique_id, $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv));

         
                if ($user['user_image']) {
                    $user_image = "upload/user/".$user['user_image'];
                }
              

                if($user_id!=''){

                $columns_login       = [
                        
                        "user_id"              => $user_id,
                        "entry_date"           => date('Y-m-d'),
                        "entry_time"           => date('h:i:s'),
                        "log_type"             => 1,
                        "unique_id"            => unique_id($prefix)
                 ];

                 $action_obj_log     = $pdo->insert($table_log,$columns_login);

              }


                $json_array = [
                    "status"    => 1,
                    "data"      => 1,
                    "error"     => 0,
                    "msg"       => "success_login",
                    "mobile_no"      => $mobile_no,
                    "unique_id_enc"       => $unique_id_enc,
                    "mobile_no_enc"       => $mobile_no_enc,
                    "unique_id"       => $user_id,
                    "session"   => $_SESSION
                ];

            }elseif(($count_data != 0)&&($active_status == 0)){
                $json_array = [
                    "status"    => 1,
                    "data"      => 1,
                    "error"     => 0,
                    "msg"       => "inactive_user",
                    "sql"       => ""
                ];
            }else {
                // Incorrect username and password handling 
                $json_array = [
                    "status"    => 0,
                    "data"      => 1,
                    "error"     => 0,
                    "msg"       => "incorrect",
                   "sql"       => ""
                ];
            }
        } else {
            $msg    = "error";
        }
        
        echo json_encode($json_array);
        
        break;
    
    default:
        
        break;
}

?>

 
