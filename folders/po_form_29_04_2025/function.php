<?php
function assign_qty($unique_id = '',$con_unique_id){
    // print_r($con_unique_id);
    global $pdo;

    $table_name    = "po_product_assign_details";
    $where         = [];
    $table_columns = [
        "unique_id",
        "COUNT(con_unique_id) AS con_count",
        "con_unique_id",
        // ""
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    // $where     = [
    //     "is_active" => 1,
    //     "is_delete" => 0,
        
    // ];
    $where       = ' is_active = 1 AND is_delete = 0 AND form_main_unique_id ="'.$unique_id .'" AND con_unique_id ="'.$con_unique_id.'" ';

    // $where = "main_unique_id = $unique_id AND con_unique_id = $con_unique_id";
    // if ($unique_id) {

    //     $where              = [];
    //     $where["main_unique_id"] = $unique_id;
    // }

    $assign_qty_form = $pdo->select($table_details, $where);
    // print_r($assign_qty_form);
    if ($assign_qty_form->status) {
        return $assign_qty_form->data;
    } else {
        // print_r($assign_qty_form);
        return 0;
    }
}

function get_bal_qty($product_unique_id = '',$form_main_unique_id="",$batch_id=""){
    // print_r($con_unique_id);
    global $pdo;

    $table_name    = "po_product_assign_details";
    $where         = [];
    $table_columns = [
        "unique_id",
        "qty",
        "sum(assign_qty) as assign_qty",
        "(qty - sum(assign_qty)) as bal_qty"
        // ""
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    // $where     = [
    //     "is_active" => 1,
    //     "is_delete" => 0,
        
    // ];
    $where       = ' is_active = 1 AND is_delete = 0 AND form_main_unique_id ="'.$form_main_unique_id .'" AND product_unique_id ="'.$product_unique_id.'" and batch_id != "'.$batch_id.'" group by form_main_unique_id, product_unique_id';

    // $where = "main_unique_id = $unique_id AND con_unique_id = $con_unique_id";
    // if ($unique_id) {

    //     $where              = [];
    //     $where["main_unique_id"] = $unique_id;
    // }

    $assign_qty_form = $pdo->select($table_details, $where);
    // print_r($assign_qty_form);
    if ($assign_qty_form->status) {
        return $assign_qty_form->data;
    } else {
        print_r($assign_qty_form);
        return 0;
    }
}
?>
