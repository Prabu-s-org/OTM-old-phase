 
    $view= $value['view'];
 
    if($_SESSION['user_type_unique_id'] != "65deef78ba17d65741" && (in_array('5f88085e1fcea66282', $action_ids))){

                        
                            if($bill_submission_date!=""){
    
                           // print_r($value['stock_qty']==$value['invoice_qty']);die();
                           $value['view']     =   $view;
                      } 
                       else{
                       
                    if(in_array('5f88085e1fcea66282', $action_ids)){
                        $value['view'] =   $view;
                        }
                        <!-- else if (in_array('5f88082b25ec031952', $action_ids)) {
                            $value['view'] = $view;
                        }  -->
                        <!-- else if (in_array('5f8808504271036738', $action_ids)) {
                            $value['unique_id'] = $btn_delete;
                        } -->
                           
                           else{
                            $value['view'] = '';
                           }
                         }
                       
                     }
                     
                     if($_SESSION['user_type_unique_id'] == "65deef78ba17d65741"){
                       
                      
                        if(in_array('5f88085e1fcea66282', $action_ids)){
                            $value['view']= $view;
                    }
                    <!-- else if (in_array('5f88082b25ec031952', $action_ids)) {
                        $value['unique_id'] = $btn_update;
                    } else if (in_array('5f8808504271036738', $action_ids)) {
                        $value['unique_id'] = $btn_delete;
                    } -->
                       
                     
                       else{
                        $value['view'] = '';
                       }
                     }

