<?php 

function get_po_bg(){
    global $pdo;

    $table_name    = "view_bg_list_final";
    $table_columns = [
        "form_main_unique_id",
        "po_num"
    ];

    $table_details = [
        $table_name,
        $table_columns
    ];

    $where       = ' bg_status = 0';
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
