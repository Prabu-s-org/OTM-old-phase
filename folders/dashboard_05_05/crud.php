<?php

// Get folder Name From Currnent Url 
$folder_name = explode("/", $_SERVER['PHP_SELF']);
$folder_name = $folder_name[count($folder_name) - 2];

// // Database Country Table Name
// $table          = "complaint_creation";
// $table_sub      = "complaint_creation_doc_upload";
// $table_stage_1  = "stage_1";

// // Include DB file and Common Functions
include '../../config/dbconfig.php';
include 'function.php';

// // Variables Declaration
$action = $_POST['action'];

//$user_type          = "";
$is_active = "";
$unique_id = "";
$prefix = "";

$data = "";
$msg = "";
$error = "";
$status = "";
$test = ""; // For Developer Testing Purpose

switch ($action) {

    case 'task_details':

        $json_array     = "";
       $acc_year= $_POST['acc_year'];
        $table = "view_po_count_value";
        $today  =  date('Y-m-d');
        $columns = [
            "count(unique_id) as po_count",
            "(sum(invoice_value)) as invoice_value",
            
            // "FORMAT(ROUND((SUM(invoice_value)), 2), 2) AS invoice_value",
            "acc_year",
        ];
        $table_details  = [
            $table,
            $columns
        ];
        // if($acc_year==''){
        //     $where       = "";
        // }
        // else{
            $where        = "acc_year = '$acc_year'";
        // }
               // Check if the session user_type is set and not Admin or SuperAdmin
               if (isset($_SESSION['sess_user_type']) && !empty($_SESSION['sess_user_type'])) {
                $session_user_type =$_SESSION['sess_user_type'];  // Get the user type from the session
    // print_r($session_user_type);die();
                // Exclude Admin and SuperAdmin from the filtering
                if ($session_user_type != 'Admin' && $session_user_type != 'SuperAdmin') {
                    // Add the user_type filter for non-Admin/SuperAdmin users
                    $where .= " AND sess_user_type = '$session_user_type'";
                }else{
                    $where .= '';
                }
            }
        $result         = $pdo->select($table_details, $where);
        // print_r( $result );die();
        $res_array      = $result->data;
        // print_r($res_array);
        foreach ($res_array as $value) {

            $po_count     = $value['po_count'];
            // $invoice_val        = $value['invoice_value'];
            // $invoice_value         = $value['invoice_value'];
            if($value['invoice_value']==''){
                $invoice_value         = 0;
               }
               else{
                $invoice_value       = moneyFormatIndia($value['invoice_value']);
                // $invoice_value = moneyFormatIndia(($invoice_val));
               
               }
            // $completed_complaints     = $value['completed_complaints'];
            // $pending_complaints     = abs($completed_complaints  - ($opening_complaints + $new_complaints));
        }

        $json_array = [
            "po_count"           => $po_count,
            "invoice_value"               => $invoice_value,
            // "completed_complaints"        => $completed_complaints,
            // "pending_complaints"           => $pending_complaints,


        ];

    
        echo json_encode($json_array);
        break;

// stock
case 'stock_details':
    
$table_stock = "view_stock_count_value";

    $json_array     = "";
    $acc_year= $_POST['acc_year'];
    $columns = [
        "count(form_main_unique_id) AS po_count",
        // "FORMAT(ROUND((SUM(value)), 2), 2) AS value",
        "sum(value) as value",
        "acc_year",

    ];
    $table_details = [
        $table_stock,
        $columns
    ];
		$table_details = [
			$table_stock,
			$columns
		];
        // if($acc_year==''){
            // $where_1        = "";
        // }
        // else{
        $where_1        = "acc_year = '$acc_year'";
        // }
		$result_values = $pdo->select($table_details,$where_1);
    
    // print_r( $result_values );
    $res_array      = $result_values->data;
    // print_r($res_array);
    foreach($res_array as $value) {

        $po_count     = $value['po_count'];
        // $value         = $value['value'];
          
        if($value['value']==''){
            $value         = 0;
           }
           else{
            $value        = moneyFormatIndia($value['value']);
                
           }
        // $completed_complaints     = $value['completed_complaints'];
        // $pending_complaints     = abs($completed_complaints  - ($opening_complaints + $new_complaints));
    }
    $table_stock_pending = "view_pur_stock_pending_count";
    $json_array     = "";
    $acc_year= $_POST['acc_year'];
    $columns = [
        "count(po_count1) AS po_count1",
        // "FORMAT(ROUND((SUM(value1)), 2), 2) AS value1",
        "sum(value1) as value1",
        "acc_year",

    ];
    $table_details = [
        $table_stock_pending,
        $columns
    ];

    $where_2        = "acc_year = '$acc_year'";
		$result_values = $pdo->select($table_details,$where_2);
    
    // print_r($result_values);
    $res_array      = $result_values->data;
    // print_r($res_array);
    foreach ($res_array as $value1) {

        $po_count_1     = $value1['po_count1'];
        
        
        if($value1['value1']==''){
            $value_1         = 0;
           }
           else{
            $value_1        = moneyFormatIndia($value1['value1']);
            // $value_1         = $value1['value1'];
           }
        // $completed_complaints     = $value['completed_complaints'];
        // $pending_complaints     = abs($completed_complaints  - ($opening_complaints + $new_complaints));
    }
 $json_array = [
        "po_count1"           => $po_count_1,
         "value1"               => $value_1,
        "po_count"           => $po_count,
        "value"               => $value,
   
    ];
    echo json_encode($json_array);
    break;
    
    
    
    case 'amc_details':
    
    $table_stock = "po_form";
    $json_array = [];

    $acc_year = $_POST['acc_year'];

    // Define columns
    $columns = [
        "SUM(amcvalue) AS value",
        "SUM(amc_percentae) AS amc_percentae",
        "acc_year"
    ];

    // Define table details
    $table_details = [
        $table_stock,
        $columns
    ];

    // Define where condition
    $where_1 = "acc_year = '$acc_year'";

    // Execute query
    $result_values = $pdo->select($table_details, $where_1);

    if ($result_values->status) {
        $res_array = $result_values->data;

        // Initialize default values
        $po_count_1 = 0;
        $value_1 = 0;
        $po_count = 0;
        $value = 0;

        foreach ($res_array as $row) {
            $value = $row['value'] ?? 0; // Assign sum of amcvalue
            $amc_perce = $row['amc_percentae'] ?? 0; // Assign sum of amc_percentae
        }

        // Prepare JSON response
        $json_array = [
            
            "value" => $value,
            "amc_percentae" => $amc_perce,
        ];
    } else {
        $json_array = ["error" => "No data found"];
    }

    echo json_encode($json_array);
    break;

    
    
    
    
    
   
// assign qty
case 'assign_qty':

    $json_array     = "";
   $acc_year= $_POST['acc_year'];
//    $table_inv_assign = "view_invoice_assign_qty_count";
$table_inv_assign = "view_stock_qty";
   $columns = [
       "count(form_main_unique_id) As po_count",
    //    "sum(invoice_count) AS invoice_count",
    // "FORMAT(ROUND((SUM(stock_value)), 2), 2) AS stock_value",
       "SUM(stock_value) AS stock_value",
    //    "billed_qty"
    

   ];
   $table_details = [
       $table_inv_assign,
       $columns
   ];
    $where3        = "acc_year = '$acc_year'";
    $result         = $pdo->select($table_details, $where3);
    // print_r( $result );
    $res_array      = $result->data;
    // print_r($res_array);
    foreach ($res_array as $value) {

        $po_count     = $value['po_count'];
       
        if($value['stock_value']==''){
            $stock_value         = 0;
           }
           else{
            $stock_value        = moneyFormatIndia($value['stock_value']);
            // $stock_value         = $value['stock_value'];
           }
          
        
        // $invoice_count     = $value['invoice_count'];
        // $pending_complaints     = abs($completed_complaints  - ($opening_complaints + $new_complaints));
    }

    $json_array = [
        "po_count"           => $po_count,
        "stock_value"               => $stock_value,
        // "invoice_count"        => $invoice_count,
        // "pending_complaints"           => $pending_complaints,


    ];


    echo json_encode($json_array);
    break;
    // partial invoice pending
    // assign qty
case 'partial_assign_qty':

    $json_array     = "";
   $acc_year= $_POST['acc_year'];
   $table_inv_assign = "view_invoice_assign_qty_count";
// $table_inv_assign = "view_stock_qty";
   $columns = [
       "count(form_main_unique_id) As po_count",
    //    "sum(invoice_count) AS invoice_count",
    // "FORMAT(ROUND((SUM(stock_value)), 2), 2) AS stock_value",
       "SUM(total_value) AS stock_value",
    //    "billed_qty"
    

   ];
   $table_details = [
       $table_inv_assign,
       $columns
   ];
    $where3        = "acc_year = '$acc_year' and stk_qty!=inv_qty";
    $result         = $pdo->select($table_details, $where3);
    // print_r( $result );
    $res_array      = $result->data;
    // print_r($res_array);
    foreach ($res_array as $value) {

        $po_count     = $value['po_count'];
       
        if($value['stock_value']==''){
            $stock_value         = 0;
           }
           else{
            $stock_value        = moneyFormatIndia($value['stock_value']);
            // $stock_value         = $value['stock_value'];
           }
          
        
        // $invoice_count     = $value['invoice_count'];
        // $pending_complaints     = abs($completed_complaints  - ($opening_complaints + $new_complaints));
    }

    $json_array = [
        "po_count"           => $po_count,
        "stock_value"               => $stock_value,
        // "invoice_count"        => $invoice_count,
        // "pending_complaints"           => $pending_complaints,


    ];


    echo json_encode($json_array);
    break;




// invoice pending 
    case 'inv_pending':

        $json_array     = "";
       $acc_year= $_POST['acc_year'];
       $table_inv = "view_pending_invoice_count_value";
       $columns = [
           "count(po_count) As po_count",
           "sum(invoice_count) AS invoice_count",
        //    "FORMAT(ROUND((SUM(invoice_value)), 2), 2) AS invoice_value",
           "SUM(invoice_value) AS invoice_value",
   
       ];
       $table_details = [
           $table_inv,
           $columns
       ];
        $where3        = "acc_year = '$acc_year'";
        $result         = $pdo->select($table_details, $where3);
        // print_r( $result );
        $res_array      = $result->data;
        // print_r($res_array);
        foreach ($res_array as $value) {

            $po_count     = $value['po_count'];
            // $invoice_value         = $value['invoice_value'];
            // $invoice_count     = $value['invoice_count'];
            if($value['invoice_count']==''){
                $invoice_count         = 0;
               }
               else{
                $invoice_count         = $value['invoice_count'];
               }
              
               
               if($value['invoice_value']==''){
                $invoice_value     = 0;
               }
               else{
                $invoice_value        = moneyFormatIndia($value['invoice_value']);
                // $invoice_value     = $value['invoice_value'];
               }
            // $pending_complaints     = abs($completed_complaints  - ($opening_complaints + $new_complaints));
        }

        $json_array = [
            "po_count"           => $po_count,
            "invoice_value"               => $invoice_value,
            "invoice_count"        => $invoice_count,
            // "pending_complaints"           => $pending_complaints,


        ];

    
        echo json_encode($json_array);
        break;

// invoice complete 
    case 'inv_complete':

        $json_array     = "";
       $acc_year= $_POST['acc_year'];

       $table_com = "view_invoice_completed_count_value";
						$columns_4 = [
							"count(po_count) As po_count",
							"sum(invoice_count) AS invoice_count",
                            // "FORMAT(ROUND((SUM(invoice_value)), 2), 2) AS invoice_value",
							"SUM(invoice_value) AS invoice_value",

						];
						$table_details_4 = [
							$table_com,
							$columns_4
						];
                        $where_4        = "acc_year = '$acc_year'";
						$result_values_4 = $pdo->select($table_details_4, $where_4);
        // print_r( $result );
        $res_array      = $result_values_4->data;
        // print_r($res_array);
        foreach ($res_array as $value) {

            $po_count     = $value['po_count'];
            // $invoice_value         = $value['invoice_value'];
            // $invoice_count     = $value['invoice_count'];
            if($value['invoice_count']==''){
                $invoice_count         = 0;
               }
               else{
                $invoice_count         = $value['invoice_count'];
               }
              
               
               if($value['invoice_value']==''){
                $invoice_value     = 0;
               }
               else{
                $invoice_value        = moneyFormatIndia($value['invoice_value']);
                // $invoice_value     = $value['invoice_value'];
               }
            // $pending_complaints     = abs($completed_complaints  - ($opening_complaints + $new_complaints));
        }

        $json_array = [
            "po_count"           => $po_count,
            "invoice_value"               => $invoice_value,
            "invoice_count"        => $invoice_count,
            // "pending_complaints"           => $pending_complaints,


        ];

    
        echo json_encode($json_array);
        break;

// delivery pending
case 'delivery_pending':

    $json_array     = "";
   $acc_year= $_POST['acc_year'];

   $table_dis = "view_dispatch_pending_count";
						$columns_5 = [
							"count(form_main_unique_id) As po_count",
							"sum(invoice_count) AS invoice_count",
                            // "FORMAT(ROUND((SUM(invoice_value)), 2), 2) AS invoice_value",
							"SUM(invoice_value) AS invoice_value",

						];
						$table_details_5 = [
							$table_dis,
							$columns_5
						];
                        $where_5        = "acc_year = '$acc_year'";
		$result_values_5 = $pdo->select($table_details_5, $where_5);   
         $res_array      = $result_values_5 ->data;
    // print_r($res_array);
    foreach ($res_array as $value) {

        $po_count     = $value['po_count'];
        // $invoice_value         = $value['invoice_value'];
        // $invoice_count     = $value['invoice_count'];
        if($value['invoice_count']==''){
            $invoice_count          = 0;
           }
           else{
            $invoice_count          = $value['invoice_count'];
           }
          
           
           if($value['invoice_value']==''){
            $invoice_value     = 0;
           }
           else{
            $invoice_value        = moneyFormatIndia($value['invoice_value']);
            // $invoice_value     = $value['invoice_value'];
           }
        // $pending_complaints     = abs($completed_complaints  - ($opening_complaints + $new_complaints));
    }

    $json_array = [
        "po_count"           => $po_count,
        "invoice_value"               => $invoice_value,
        "invoice_count"        => $invoice_count,
        // "pending_complaints"           => $pending_complaints,


    ];


    echo json_encode($json_array);
    break;


    // delivery transit
    case 'delivery_transit':

        $json_array     = "";
       $acc_year= $_POST['acc_year'];
                            $table_dis_com = "view_dispatch_complete_count";
                            $columns_6 = [
                                "count(form_main_unique_id) As po_count",
                                "sum(invoice_count) AS invoice_count",
                                // "FORMAT(ROUND((SUM(invoice_value)), 2), 2) AS invoice_value",
                                "SUM(invoice_value) AS invoice_value",
    
                            ];
                            $table_details_6 = [
                                $table_dis_com,
                                $columns_6
                            ];
                            $where_6        = "acc_year = '$acc_year'";
                            $result_values_6 = $pdo->select($table_details_6, $where_6   );
             $res_array      = $result_values_6 ->data;
        // print_r($res_array);
        foreach ($res_array as $value) {
    
            $po_count     = $value['po_count'];
            // $invoice_value         = $value['invoice_value'];
            // $invoice_count     = $value['invoice_count'];
            if($value['invoice_count']==''){
                $invoice_count          = 0;
               }
               else{
                $invoice_count          = $value['invoice_count'];
               }
              
               
               if($value['invoice_value']==''){
                $invoice_value     = 0;
               }
               else{
                $invoice_value        = moneyFormatIndia($value['invoice_value']);
                // $invoice_value     = $value['invoice_value'];
               }
            // $pending_complaints     = abs($completed_complaints  - ($opening_complaints + $new_complaints));
        }
    
        $json_array = [
            "po_count"           => $po_count,
            "invoice_value"               => $invoice_value,
            "invoice_count"        => $invoice_count,
            // "pending_complaints"           => $pending_complaints,
    
    
        ];
    
    
        echo json_encode($json_array);
        break;

// ac team pending

case 'ac_pending':

 $json_array     = "";
   $acc_year= $_POST['acc_year'];
   $table_ac_team = "view_ac_team_pending";
   $columns_7 = [
       "count(po_unique_id) As po_count",
       "sum(invoice_count) AS invoice_count",
    //    "FORMAT(ROUND((SUM(invoice_value)), 2), 2) AS invoice_value",
       "SUM(invoice_value) AS invoice_value",

   ];
   $table_details_7 = [
       $table_ac_team,
       $columns_7
   ];
   $where_7        = "acc_year = '$acc_year'";
                       
   $result_values_7 = $pdo->select($table_details_7, $where_7);
                     
         $res_array      = $result_values_7 ->data;
    // print_r($res_array);
    foreach ($res_array as $value) {

        $po_count     = $value['po_count'];
        // $invoice_value         = $value['invoice_value'];
        // $invoice_count     = $value['invoice_count'];
        if($value['invoice_count']==''){
            $invoice_count          = 0;
           }
           else{
            $invoice_count          = $value['invoice_count'];
           }
          
           
           if($value['invoice_value']==''){
            $invoice_value     = 0;
           }
           else{
            $invoice_value        = moneyFormatIndia($value['invoice_value']);
            // $invoice_value     = $value['invoice_value'];
           }
        // $pending_complaints     = abs($completed_complaints  - ($opening_complaints + $new_complaints));
    }

    $json_array = [
        "po_count"           => $po_count,
        "invoice_value"               => $invoice_value,
        "invoice_count"        => $invoice_count,
        // "pending_complaints"           => $pending_complaints,


    ];


    echo json_encode($json_array);
    break;



// install  pending

case 'install_pending':

    $json_array     = "";
      $acc_year= $_POST['acc_year'];
      $table_install = "view_installation_pending_count";
						$columns_8 = [
							"count(form_main_unique_id) As po_count",
							"sum(install_count) AS invoice_count",
                            // "FORMAT(ROUND((SUM(invoice_value)), 2), 2) AS invoice_value",
							"SUM(invoice_value) AS invoice_value",

						];
						$table_details_8 = [
							$table_install,
							$columns_8
						];
                        $where_8        = "acc_year = '$acc_year'";
                          
						$result_values_8 = $pdo->select($table_details_8, $where_8);
    //  print_r($result_values_8);
           
            $res_array      = $result_values_8 ->data;
    //    print_r($res_array);
       foreach ($res_array as $value) {
   
           $po_count     = $value['po_count'];
        //    $invoice_value         = $value['invoice_value'];
        //    $invoice_count     = $value['invoice_count'];
        if($value['invoice_count']==''){
            $invoice_count          = 0;
           }
           else{
            $invoice_count          = $value['invoice_count'];
           }
          
           
           if($value['invoice_value']==''){
            $invoice_value     = 0;
           }
           else{
            $invoice_value        = moneyFormatIndia($value['invoice_value']);
            // $invoice_value     = $value['invoice_value'];
           }
           // $pending_complaints     = abs($completed_complaints  - ($opening_complaints + $new_complaints));
       }
   
       $json_array = [
           "po_count"           => $po_count,
           "invoice_value"               => $invoice_value,
           "invoice_count"        => $invoice_count,
            
           // "pending_complaints"           => $pending_complaints,
   
   
       ];
   
   
       echo json_encode($json_array);
       break;

// doc pending


case 'document_pending':

    $json_array     = "";
      $acc_year= $_POST['acc_year'];
      $table_document = "view_document_pending_count";
      $columns_9 = [
          "count(po_form_unique_id) As po_count",
          "sum(invoice_count) AS invoice_count",
        //   "FORMAT(ROUND((SUM(invoice_value)), 2), 2) AS invoice_value",
          "SUM(invoice_value) AS invoice_value",

      ];
      $table_details_9 = [
          $table_document,
          $columns_9
      ];
      $where_9        = "acc_year = '$acc_year'";
                          
      $result_values_9 = $pdo->select($table_details_9, $where_9);
                        
						
            $res_array      = $result_values_9 ->data;
       // print_r($res_array);
       foreach ($res_array as $value) {
   
           $po_count     = $value['po_count'];
        //    $invoice_value         = $value['invoice_value'];
        //    $invoice_count     = $value['invoice_count'];
           if($value['invoice_count']==''){
            $invoice_count          = 0;
           }
           else{
            $invoice_count          = $value['invoice_count'];
           }
          
           
           if($value['invoice_value']==''){
            $invoice_value     = 0;
           }
           else{
            $invoice_value        = moneyFormatIndia($value['invoice_value']);
            // $invoice_value     = $value['invoice_value'];
           }
           // $pending_complaints     = abs($completed_complaints  - ($opening_complaints + $new_complaints));
       }
   
       $json_array = [
           "po_count"           => $po_count,
           "invoice_value"               => $invoice_value,
           "invoice_count"        => $invoice_count,
           // "pending_complaints"           => $pending_complaints,
   
   
       ];
   
   
       echo json_encode($json_array);
       break;

    //     doc eng pending

       case 'document_eng_pending':
       
           $json_array     = "";
             $acc_year= $_POST['acc_year'];
            //  $table_eng = "view_document_engineer_count";
             $table_eng = "view_document_engineer_count_1";
             
						$columns_10 = [
							"count(form_main_unique_id) As po_count",
							"sum(invoice_count) AS invoice_count",
                            // "FORMAT(ROUND((SUM(invoice_value)), 2), 2) AS invoice_value",
							"SUM(invoice_value) AS invoice_value",

						];
						$table_details_10 = [
							$table_eng,
							$columns_10
						];
                        $where_10        = "acc_year = '$acc_year'";
                   
						$result_values_10 = $pdo->select($table_details_10, $where_10);
                          
                       
                   $res_array      = $result_values_10 ->data;
              // print_r($res_array);
              foreach ($res_array as $value) {
          
                  $po_count     = $value['po_count'];
                //   $invoice_value         = $value['invoice_value'];
                //   $invoice_count     = $value['invoice_count'];
                  if($value['invoice_count']==''){
                    $invoice_count          = 0;
                   }
                   else{
                    $invoice_count          = $value['invoice_count'];
                   }
                  
                   
                   if($value['invoice_value']==''){
                    $invoice_value     = 0;
                   }
                   else{
                    $invoice_value        = moneyFormatIndia($value['invoice_value']);
                    // $invoice_value     = $value['invoice_value'];
                   }
                  // $pending_complaints     = abs($completed_complaints  - ($opening_complaints + $new_complaints));
              }
          
              $json_array = [
                  "po_count"           => $po_count,
                  "invoice_value"               => $invoice_value,
                  "invoice_count"        => $invoice_count,
                  // "pending_complaints"           => $pending_complaints,
          
          
              ];
          
          
              echo json_encode($json_array);
              break;

//     doc eng pending

case 'snr_pending':
       
    $json_array     = "";
      $acc_year= $_POST['acc_year'];

     $table_snr = "view_snr_pending_count";
						$columns_11 = [
							"count(po_form_unique_id) As po_count",
							"sum(install_count) AS install_count",
                            // "FORMAT(ROUND((SUM(invoice_qty_value)), 2), 2) AS invoice_value",
							"SUM(invoice_qty_value) AS invoice_value",

						];
						$table_details_11 = [
							$table_snr,
							$columns_11
						];
                        $where_11        = "acc_year = '$acc_year'";
                   
						$result_values_11 = $pdo->select($table_details_11, $where_11);
                
            $res_array      = $result_values_11 ->data;
    //    print_r($result_values_11);
       foreach ($res_array as $value) {
   
           $po_count     = $value['po_count'];
        //    $install_count         = $value['install_count'];
        //    $invoice_value     = $value['invoice_value'];
        if($value['install_count']==''){
            $install_count          = 0;
           }
           else{
            $install_count          = $value['install_count'];
           }
          
           
           if($value['invoice_value']==''){
            $invoice_value     = 0;
           }
           else{
            $invoice_value        = moneyFormatIndia($value['invoice_value']);
            // $invoice_value     = $value['invoice_value'];
           }
           // $pending_complaints     = abs($completed_complaints  - ($opening_complaints + $new_complaints));
       }
   
       $json_array = [
           "po_count"           => $po_count,
           "invoice_value"               => $invoice_value,
           "install_count"        => $install_count,
           // "pending_complaints"           => $pending_complaints,
   
   
       ];
   
   
       echo json_encode($json_array);
       break;

//     doc eng pending

case 'elcot_pending':
       
    $json_array     = "";
      $acc_year= $_POST['acc_year'];

      $table_elcot = "view_elcot_pending";
       $columns_12 = [
           "count(po_unique_id) As po_count",
           "sum(invoice_count) AS invoice_count",
        //    "FORMAT(ROUND((SUM(invoice_value)), 2), 2) AS invoice_value",
           "SUM(invoice_value) AS invoice_value",

       ];
       $table_details_12 = [
           $table_elcot,
           $columns_12
       ];
       $where_12        = "acc_year = '$acc_year'";
                   
       $result_values_12 = $pdo->select($table_details_12, $where_12);
                 
            $res_array      = $result_values_12 ->data;
    //    print_r($result_values_12);
       foreach ($res_array as $value) {
   
           $po_count     = $value['po_count'];
        //    $invoice_count         = $value['invoice_count'];
        //    $invoice_value     = $value['invoice_value'];
           if($value['invoice_count']==''){
            $invoice_count         = 0;
           }
           else{
            $invoice_count         = $value['invoice_count'];
           }
          
           
           if($value['invoice_value']==''){
            $invoice_value     = 0;
           }
           else{
            $invoice_value        = moneyFormatIndia($value['invoice_value']);
            // $invoice_value     = $value['invoice_value'];
           }
           // $pending_complaints     = abs($completed_complaints  - ($opening_complaints + $new_complaints));
       }
   
       $json_array = [
           "po_count"           => $po_count,
           "invoice_value"               => $invoice_value,
           "invoice_count"        => $invoice_count,
           // "pending_complaints"           => $pending_complaints,
   
   
       ];
   
   
       echo json_encode($json_array);
       break;

       case 'sign_pending':
       
        $json_array     = "";
          $acc_year= $_POST['acc_year'];
    
          $table_sign_doc = "view_sign_doc_pending_count";
          $columns_13 = [
              "count(form_main_unique_id) As po_count",
              "sum(invoice_count) AS invoice_count",
            //   "FORMAT(ROUND((SUM(invoice_value)), 2), 2) AS invoice_value",
              "SUM(invoice_value) AS invoice_value",

          ];
          $table_details_13 = [
              $table_sign_doc,
              $columns_13
          ];
          $where_13        = "acc_year = '$acc_year'";
               
          $result_values_13 = $pdo->select($table_details_13, $where_13);
                  
                 
                $res_array      = $result_values_13 ->data;
        //    print_r($result_values_13);
           foreach ($res_array as $value) {
       
               $po_count     = $value['po_count'];
            //    $invoice_count         = $value['invoice_count'];
            //    $invoice_value     = $value['invoice_value'];
               if($value['invoice_count']==''){
                $invoice_count         = 0;
               }
               else{
                $invoice_count         = $value['invoice_count'];
               }
              
               
               if($value['invoice_value']==''){
                $invoice_value     = 0;
               }
               else{
                $invoice_value        = moneyFormatIndia($value['invoice_value']);
                // $invoice_value     = $value['invoice_value'];
               }
               // $pending_complaints     = abs($completed_complaints  - ($opening_complaints + $new_complaints));
           }
       
           $json_array = [
               "po_count"           => $po_count,
               "invoice_value"               => $invoice_value,
               "invoice_count"        => $invoice_count,
               // "pending_complaints"           => $pending_complaints,
       
       
           ];
       
       
           echo json_encode($json_array);
           break;
       
     
           case 'bg_pending':
       
            $json_array     = "";
              $acc_year= $_POST['acc_year'];
        
              $table_sign_doc = "view_sign_doc_pending_count";
              $table_bg = "view_bg_pending_count";
						$columns_14 = [
							"count(form_main_unique_id) As po_count",
							"sum(invoice_count) AS invoice_count",
							"SUM(invoice_value) AS invoice_value",

						];
						$table_details_14 = [
							$table_bg,
							$columns_14
						];
                        $where_14        = "acc_year = '$acc_year'";
                
						$result_values_14 = $pdo->select($table_details_14, $where_14);
                
                 
                     
                    $res_array      = $result_values_14 ->data;
            //    print_r($result_values_11);
               foreach ($res_array as $value) {
           
                //    $po_count     = $value['po_count'];
                   if($value['po_count'] ==''){
                    $po_count         = 0;
                   }
                   else
                        {
                            $po_count     = $value['po_count'];
                        }                //    $invoice_count         = $value['invoice_count'];
                //    $invoice_value     = $value['invoice_value'];
                   if($value['invoice_count'] ==''){
                    $invoice_count         = 0;
                   }

                   else{
                    $invoice_count         = $value['invoice_count'];
                   }
                  
                   
                   if($value['invoice_value']==''){
                    $invoice_value     = 0;
                   }
                   else{
                    $invoice_value        = moneyFormatIndia($value['invoice_value']);
                    // $invoice_value     = $value['invoice_value'];
                   }

                   // $pending_complaints     = abs($completed_complaints  - ($opening_complaints + $new_complaints));
               }
           
               $json_array = [
                   "po_count"           => $po_count,
                   "invoice_value"               => $invoice_value,
                   "invoice_count"        => $invoice_count,
                   // "pending_complaints"           => $pending_complaints,
           
           
               ];
           
           
               echo json_encode($json_array);
               break;
                    
            
               case 'entry_pending':
       
                $json_array     = "";
                $acc_year= $_POST['acc_year'];
          
                $table_bill_pending = "view_bill_pending_count";
                $columns_16 = [
                    "count(form_main_unique_id) As po_count",
                    "sum(invoice_count) AS invoice_count",
                    // "FORMAT(ROUND((SUM(invoice_value)), 2), 2) AS invoice_value",
                    "SUM(invoice_value) AS invoice_value",

                ];
                $table_details_16 = [
                    $table_bill_pending,
                    $columns_16
                ];
                $where_16        = "acc_year = '$acc_year'";
                  
                $result_values_16 = $pdo->select($table_details_16, $where_16);
                    
                    
                $res_array      = $result_values_16 ->data;
                //  print_r($result_values_16);
                 foreach($res_array as $value) {
             
                     $po_count     = $value['po_count'];
                    //  $invoice_count         = $value['invoice_count'];
                    //  $invoice_value     = $value['invoice_value'];
                     if($value['invoice_count']==''){
                        $invoice_count         = 0;
                       }
                       else{
                        $invoice_count         = $value['invoice_count'];
                       }
                      
                       
                       if($value['invoice_value']==''){
                        $invoice_value     = 0;
                       }
                       else{
                        $invoice_value        = moneyFormatIndia($value['invoice_value']);
                        // $invoice_value     = $value['invoice_value'];
                       }
                     // $pending_complaints     = abs($completed_complaints  - ($opening_complaints + $new_complaints));
                 }
             
                 $json_array = [
                     "po_count"           => $po_count,
                     "invoice_value"               => $invoice_value,
                     "invoice_count"        => $invoice_count,
                     // "pending_complaints"           => $pending_complaints,
             
             
                 ];
             
             
                 echo json_encode($json_array);
                 break;
               
             
                   case 'bill_sub_pending':
                    $json_array     = "";
                    $acc_year= $_POST['acc_year'];
              
                    $table_bill_submission_pending = "view_bill_sub_pending";
                      $columns_25 = [
                          "count(bill_form_unique_id) As po_count",
                          "sum(invoice_count) AS invoice_count",
                        //   "FORMAT(ROUND((SUM(invoice_value)), 2), 2) AS invoice_value",
                          "SUM(invoice_value) AS invoice_value",

                      ];
                      $table_details_25 = [
                          $table_bill_submission_pending,
                          $columns_25
                      ];
                      $where_25       = "acc_year = '$acc_year'";
                      
                      $result_values_25 = $pdo->select($table_details_25, $where_25);
                  
                   
                          $res_array      = $result_values_25 ->data;
                  //    print_r($result_values_11);
                     foreach ($res_array as $value) {
                 
                         $po_count     = $value['po_count'];
                        //  $invoice_count         = $value['invoice_count'];
                        //  $invoice_value     = $value['invoice_value'];
                        if($value['invoice_count']==''){
                            $invoice_count         = 0;
                           }
                           else{
                            $invoice_count         = $value['invoice_count'];
                           }
                          
                           
                           if($value['invoice_value']==''){
                            $invoice_value     = 0;
                           }
                           else{
                            $invoice_value        = moneyFormatIndia($value['invoice_value']);
                            // $invoice_value     = $value['invoice_value'];
                           }
                         // $pending_complaints     = abs($completed_complaints  - ($opening_complaints + $new_complaints));
                     }
                 
                     $json_array = [
                         "po_count"           => $po_count,
                         "invoice_value"               => $invoice_value,
                         "invoice_count"        => $invoice_count,
                         // "pending_complaints"           => $pending_complaints,
                 
                 
                     ];
                 
                 
                     echo json_encode($json_array);
                     break;
                 
                  
                 
        
                       
                       
                   case 'payment_pending':
       
                    $json_array     = "";
                      $acc_year= $_POST['acc_year'];
                
                      $table_payment_pending = "bill_submitted_payment_pending";
						$columns_17 = [
							"count(bill_form_unique_id) As po_count",
							"sum(invoice_count) AS invoice_count",
                            // "FORMAT(ROUND((SUM(invoice_value)), 2), 2) AS invoice_value",
							"SUM(invoice_value) AS invoice_value",

						];
						$table_details_17 = [
							$table_payment_pending,
							$columns_17
						];
                        $where_17        = "acc_year = '$acc_year'";
                        
						$result_values_17 = $pdo->select($table_details_17, $where_17);
                    
                     
                            $res_array      = $result_values_17 ->data;
                    //    print_r($result_values_11);
                       foreach ($res_array as $value) {
                   
                           $po_count     = $value['po_count'];
                        //    $invoice_count         = $value['invoice_count'];
                        //    $invoice_value     = $value['invoice_value'];
                        if($value['invoice_count']==''){
                            $invoice_count         = 0;
                           }
                           else{
                            $invoice_count         = $value['invoice_count'];
                           }
                          
                           
                           if($value['invoice_value']==''){
                            $invoice_value     = 0;
                           }
                           else{
                            $invoice_value        = moneyFormatIndia($value['invoice_value']);
                            // $invoice_value     = $value['invoice_value'];
                           }
                           // $pending_complaints     = abs($completed_complaints  - ($opening_complaints + $new_complaints));
                       }
                   
                       $json_array = [
                           "po_count"           => $po_count,
                           "invoice_value"               => $invoice_value,
                           "invoice_count"        => $invoice_count,
                            
                           // "pending_complaints"           => $pending_complaints,
                   
                   
                       ];
                   
                   
                       echo json_encode($json_array);
                       break;
                   
                       case 'payment_receive':
       
                        $json_array     = "";
                          $acc_year = $_POST['acc_year'];
                    
                          $table_payment_rec = "view_payment_received_count";
                          $columns_18 = [
                              "count(bill_form_unique_id) As po_count",
                              "sum(invoice_count) AS invoice_count",
                            //   "FORMAT(ROUND((SUM(invoice_value)), 2), 2) AS invoice_value",
                              "SUM(invoice_value) AS invoice_value",
  
                          ];
                          $table_details_18 = [
                              $table_payment_rec,
                              $columns_18
                          ];
                          $where_18        = "acc_year = '$acc_year'";
                            
                          $result_values_18 = $pdo->select($table_details_18, $where_18);
                            
                          
                         
                                $res_array      = $result_values_18 ->data;
                        //    print_r($result_values_11);
                           foreach ($res_array as $value) {
                       
                               $po_count     = $value['po_count'];
                               if($value['invoice_count']==''){
                                $invoice_count         = 0;
                               }
                               else{
                                $invoice_count         = $value['invoice_count'];
                               }
                              
                               
                               if($value['invoice_value']==''){
                                $invoice_value     = 0;
                               }
                               else{
                                $invoice_value        = moneyFormatIndia($value['invoice_value']);
                                // $invoice_value     = $value['invoice_value'];
                               }
                              
                               // $pending_complaints     = abs($completed_complaints  - ($opening_complaints + $new_complaints));
                           }
                       
                           $json_array = [
                               "po_count"           => $po_count,
                               "invoice_value"               => $invoice_value,
                               "invoice_count"        => $invoice_count,
                               // "pending_complaints"           => $pending_complaints,
                       
                       
                           ];
                           echo json_encode($json_array);
                           break;
                      
                     
                           
                           // ld value
                           case 'ld_detail':
       
                            $json_array     = "";
                              $acc_year = $_POST['acc_year'];

                              $table_ld='view_ld_value_count';
                              $columns_19 = [
                                "count(bill_form_unique_id) As po_count",
                                "sum(ld_value) AS ld_value",
                                // "FORMAT(ROUND((SUM(ld_value)), 2), 2) AS ld_value",
                                "SUM(invoice_count) AS invoice_count",
    
                            ];
                            $table_details_19 = [
                                $table_ld,
                                $columns_19
                            ];
                            $where_19        = "acc_year = '".$acc_year."'";
                            $result_values_19 = $pdo->select($table_details_19, $where_19);
                            //   $result_values_20 = $pdo->select($table_details_20, $where_20);
                            // print_r($result_values_19);
                        
                             $res_array      = $result_values_19 ->data;
                            //    print_r($result_values_11);
                               foreach ($res_array as $value) {
                           
                                   $po_count     = $value['po_count'];

                                   if($value['invoice_count'] ==''){
                                    $invoice_count     = 0;
                                   }
                                   else{
                                    $invoice_count         = $value['invoice_count'];
                                   }

                                   if($value['ld_value'] ==''){
                                    $ld_value      = 0;
                                   }

                                   else{
                                    $ld_value        = moneyFormatIndia($value['ld_value']);
                                    // $ld_value     = $value['ld_value'];
                                   }
                                   
                                  
                                   // $pending_complaints     = abs($completed_complaints  - ($opening_complaints + $new_complaints));
                               }

                               $table_total_ld='view_total_ld_invoice_count';
                               $columns_21 = [
                                //  "count(bill_form_unique_id) As po_count",
                                //  "sum(ld_value) AS ld_value",
                                 "SUM(total_invoice_count) AS total_invoice_count",
                                 "acc_year",
     
                             ];
                             $table_details_21 = [
                                 $table_total_ld,
                                 $columns_21
                             ];
                             $where_21       = "acc_year = '".$acc_year."'";
                             $result_values_21 = $pdo->select($table_details_21, $where_21);
                             $res_array_21      = $result_values_21 ->data;
                             //    print_r($result_values_11);
                                foreach ($res_array_21 as $value_21) {
                            
                                    // $po_count     = $value['po_count'];
                                    // $invoice_count         = $value['invoice_count'];
                                    $total_invoice_count     = $value_21['total_invoice_count'];
                                    // $pending_complaints     = abs($completed_complaints  - ($opening_complaints + $new_complaints));
                                }

                               $json_array = [
                                   "po_count"           => $po_count,
                                   "ld_value"               => $ld_value,
                                   "invoice_count"        => $invoice_count,
                                   "total_invoice_count"           => $total_invoice_count,
                               ];
                               echo json_encode($json_array);
                               break;
                          
                                case 'sd_claim':
       
                                    $json_array     = "";
                                      $acc_year = $_POST['acc_year'];
                                
                                      $table_sd = "view_sd_claim_pending";
                                      $columns_20 = [
                                          "count(bill_form_unique_id) As po_count",
                                          "sum(invoice_count) AS invoice_count",
                                        //   "FORMAT(ROUND((SUM(invoice_value)), 2), 2) AS invoice_value",
                                          "SUM(invoice_value) AS invoice_value",
              
                                      ];
                                      $table_details_20 = [
                                          $table_sd,
                                          $columns_20
                                      ];
                                      $where_20        = "acc_year = '$acc_year'";
                                        
                                      $result_values_20 = $pdo->select($table_details_20, $where_20);
                                    
                                
                                            $res_array      = $result_values_20 ->data;
                                    //    print_r($result_values_11);
                                       foreach ($res_array as $value) {
                                   
                                           $po_count     = $value['po_count'];
                                           
                                           $invoice_count         = $value['invoice_count'];
                                           if($value['invoice_count'] ==''){
                                            $invoice_count         = 0;
                                           }
                                           else{
                                            $invoice_count         = $value['invoice_count'];
                                           }
                                           if($value['invoice_value'] ==''){
                                            $invoice_value     = 0;
                                           }
                                           else{
                                            $invoice_value        = moneyFormatIndia($value['invoice_value']);
                                            // $invoice_value     = $value['invoice_value'];
                                           }

                                           
                                           // $pending_complaints     = abs($completed_complaints  - ($opening_complaints + $new_complaints));
                                       }
                                   
                                       $json_array = [
                                           "po_count"           => $po_count,
                                           "invoice_value"               => $invoice_value,
                                           "invoice_count"        => $invoice_count,
                                           // "pending_complaints"           => $pending_complaints,
                                   
                                   
                                       ];
                                       echo json_encode($json_array);
                                       break;
                                  
                                default;
                                break;
    }

// end


?>
