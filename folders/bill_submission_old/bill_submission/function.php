<?php
function get_stock_position($unique_id){
    // print_r($unique_id);
    global $pdo;

    $table_name    = "stock_position";
    $where         = [];
    $table_columns = [
        "unique_id",
        "COUNT(product_unique_id) AS product_count",
        "form_main_unique_id",
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    // $where     = [
    //     "is_active" => 1,
    //     "is_delete" => 0,
        
    // ];
    $where       = ' is_active = 1 AND is_delete = 0 AND form_main_unique_id ="'.$unique_id .'"';
    $assign_qty_form = $pdo->select($table_details, $where);
    // print_r($assign_qty_form);
    if ($assign_qty_form->status) {
        return $assign_qty_form->data;
    } else {
        print_r($assign_qty_form);
        return 0;
    }
}

function get_invoice($unique_id){
    // print_r($unique_id);
    global $pdo;

    $table_name    = "invoice_creation";
    $where         = [];
    $table_columns = [
        "unique_id",
        "COUNT(item_code) AS item_code",
        "po_unique_id",
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    // $where     = [
    //     "is_active" => 1,
    //     "is_delete" => 0,
        
    // ];
    $where       = ' is_active = 1 AND is_delete = 0 AND po_unique_id="'.$unique_id .'"';
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
