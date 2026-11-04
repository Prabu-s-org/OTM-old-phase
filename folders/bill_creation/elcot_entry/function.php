<?php
function get_po($unique_id = "") {

    global $pdo;

    $table_name    = "view_elcot_entry_final ";
    $where         = [];
    $table_columns = [
        // "unique_id",
        "unique_id",
        "po_num",
        // "bill_status",
        
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $where       = "bill_status = '1'";
    $group_by    = 'po_num';
    $po_num = $pdo->select($table_details,$where,"","","","",$group_by);
   
    if ($po_num->status) {
        return $po_num->data;
    } else {
        print_r($po_num);
        return 0;
    }
}



?>
