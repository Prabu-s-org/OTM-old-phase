<!-- !-- This file Only PHP Functions  -->
<?php
// Get folder Name From Currnent Url 
$folder_name = explode("/", $_SERVER['PHP_SELF']);
$folder_name = $folder_name[count($folder_name) - 2];


// Include DB file and Common Functions
include '../../config/dbconfig.php';
include 'function.php';

?>
<!-- datatable start -->
<link rel="stylesheet" type="text/css" href="../../assets/datatable_new/jquery.dataTables.css" />
<link rel="stylesheet" type="text/css" href="../../assets/datatable_new/buttons.dataTables.css" />

<script src="../../assets/datatable_new/jquery-3.7.0.min.js"></script>
<script src="../../assets/datatable_new/jquery.dataTables.js"></script>
<script src="../../assets/datatable_new/dataTables.buttons.js"></script>
<script src="../../assets/datatable_new/jszip.min.js"></script>
<script src="../../assets/datatable_new/buttons.html5.min.js"></script>
<script src="../../assets/datatable_new/buttons.print.min.js"></script>
<script src="../../assets/datatable_new/pdfmake.min.js"></script>

<style>
    table {
        border-collapse: collapse;
        /* Ensures borders don't have spacing between cells */
        width: 100%;
    }

    th,
    td {
        border: 1px solid black;
        /* Adds border around table cells */
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
        /* Light background for table headers */
    }

    .text_po {
        text-align-last: center;
    }
</style>

<h2 class="text_po">Invoice po count Pending</h2>
<form class="was-validated" autocomplete="off">
    <div class="row">
        <div class="col-12 mt-2">
            <div class="table-responsive mb-4">
                <table class="table table-striped table-bordered align-middle table-nowrap mb-0 small_table"
                    id="ins_pen">
                    <thead class="table-light">
                        <tr>
                        <tr>
                            <th>S.No</th>
                            <!-- <th>Invoice No </th> -->
                            <!-- <th>Invoice Date </th> -->

                            <th>Po Number</th>
                            <th>Executive Name
                            </th>
                            <th>Department
                            </th>
                            <!-- <th>Ledger Name -->
                            </th>
                            <th>Con Address
                            </th>
                            <th>Invoice Qty
                            </th>
                            <th>Total Value
                            </th>
                            <!-- <th>Status -->
                            </th>

                            <!-- <th>Reason -->
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        //  `po`.`file_name` <> ''
                        $table = 'view_pending_invoice_count_value';
                        $columns = [
                            "'' AS s_no",
                            // "invoice_no",
                            // "invoice_auto_id",
                            // "DATE_FORMAT(invoice_date, '%d-%m-%Y') AS invoice_date",
                            "po_num",
                            "executive_name",
                            "(SELECT department FROM stock_position_main WHERE form_main_unique_id = view_pending_invoice_count_value.po_count ) AS department",
                            "ledger_name",
                            "(SELECT con_address FROM consignee_details_sub WHERE unique_id = view_pending_invoice_count_value.consignee_unique_id AND consignee_details_sub.is_delete='0' ) AS con_address",
                            "invoice_qty",
                            "invoice_value",
                            "invoice_doc_status",
                            "reject_reason_elcot",
                            // "unique_id",
                        

                            "po_count",
                            // "(SELECT COUNT(*) FROM invoice_creation_main WHERE invoice_creation_main.invoice_no = $table.invoice_no AND invoice_creation_main.is_delete='0') AS count",
                            "approved_by",
                            "ac_team_approved_by",
                        ];

                        $table_details1 = [
                            $table,
                            $columns
                        ];
                        // `stock`.`is_delete` = '0' AND `stock`.`billed_qty` IS NULL
                        // $where1 = "group by form_main_unique_id";
                        
                        // print_r(  $where1);
                        $result1 = $pdo->select($table_details1, $where1);
                        // print_r($result1);die();
                        if ($result1->status) {
                            $res_array1 = $result1->data;
                            // print_r($result1->data);
                            foreach ($res_array1 as $key => $value) {
                                $value['s_no'] = $sno + 1;
                                $orgDate = $value['invoice_date'];
                                // if($orgDate==''){
                                //     $value['invoice_date']='';
                                // }
                                // else{
                                // $value['invoice_date'] = date("d-m-Y", strtotime($orgDate));
                                // }
                                $invoice_value = $value['invoice_value'];

                                $value['invoice_value'] = moneyFormatIndia1(($invoice_value));

                                // $value['invoice_auto_id'] = $value['invoice_no'];
                                // $value['po_unique_id'] = $value['po_num'];
                        
                                $value['po_date'] = '<span class="po_date">' . $value['po_date'] . '</span>';
                                // $value['po_date'] = $value['po_date'];
                                //   const net_value = qty * unit_price;
                                //     $unit_price= $value['unit_price'];.' / '.$value['po_unique_id']
                                //   $invoice_qty= $value['invoice_qty'];.' / '.$value['invoice_auto_id']
                                //  $value['unit_price'] =(($unit_price )*($invoice_qty));
                                $val = $value['reject_reason_elcot'];
                                if ($val == '') {
                                    $value['reject_reason_elcot'] = '-';
                                } else {
                                    $value['reject_reason_elcot'] = $val;

                                }
                                // if ($value['invoice_doc_status'] == 1) {
                                //     $value['invoice_doc_status'] = "Approval";
                                // } 
                                if ($value['invoice_doc_status'] == 4) {
                                    // $value['invoice_doc_status'] = "A/c Team Approval";
                                    $value['invoice_doc_status'] = "Completed";
                                } else if ($value['invoice_doc_status'] == 1) {
                                    $value['invoice_doc_status'] = "Accounts Team Pending";
                                }
                                // if($value['invoice_doc_status'] == 1 && $value['approved_by']!='' && $value['ac_team_approved_by']!='') {
                                //     $value['invoice_doc_status'] = "A/c Team Approval";
                                // } 
                                //  else if($value['invoice_doc_status'] == 1 && $value['approved_by']!='') {
                                //     $value['invoice_doc_status'] = "Elcot Team Approval";
                                // } 
                                else if ($value['invoice_doc_status'] == 2) {
                                    $value['invoice_doc_status'] = "<span style='color: red;'>Rejected</span>";
                                    //  = "";
                                } else if ($value['invoice_doc_status'] == 3) {
                                    $value['invoice_doc_status'] = "Elcot Team Pending";
                                } else if ($value['invoice_doc_status'] == 0) {
                                    $value['invoice_doc_status'] = "Pending";
                                }

                                ?>
                                <tr>

                                    <td id="table_td"><?php echo $value['s_no']; ?></td>
                                    <!-- <td id="table_td"><?php echo $value['invoice_no']; ?></td> -->
                                    <!-- <td id="table_td"><?php echo $value['invoice_date']; ?></td> -->
                                    <td id="table_td"><?php echo $value['po_num']; ?></td>
                                    <td id="table_td"><?php echo $value['executive_name']; ?></td>

                                    <td id="table_td"><?php echo $value['department']; ?></td>
                                    <!-- <td id="table_td"><?php echo $value['ledger_name']; ?></td> -->

                                    <td id="table_td"><?php echo $value['con_address']; ?></td>
                                    <td id="table_td"><?php echo $value['invoice_qty']; ?></td>

                                    <td id="table_td"><?php echo $value['invoice_value']; ?></td>
                                    <!-- <td id="table_td"><?php echo $value['invoice_doc_status']; ?></td>  -->
                                    <!-- <td id="table_td"><?php echo $value['reject_reason_elcot']; ?></td>  -->
                                </tr>
                                <?php
                                $sno++;
                            }
                        }
                        // 
                        
                        ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</form>


</div>
</div>
</div>
</div>

<?php

function image_view_3($folder_name = "", $unique_id = "", $file_name = "")
{
    // echo $file_name;
    $file_names = explode(',', $file_name);
    $image_view_3 = '';

    if ($file_name) {
        foreach ($file_names as $file_key => $file_name) {
            if ($file_key != 0) {
                if ($file_key % 4 != 0) {
                    $image_view_3 .= "&nbsp";
                } else {
                    $image_view_3 .= "<br><br>";
                }
            }

            $cfile_name = explode('.', $file_name);

            if ($file_name) {

                if (($cfile_name[1] == 'jpg') || ($cfile_name[1] == 'png') || ($cfile_name[1] == 'jpeg')) {
                    $image_view_3 .= '<a href="javascript:print_view_1(\'/' . $file_name . '\')"><img src="../../uploads/po_form/po_attach/' . $file_name . '"  height="30px" width="30px" ></a>';
                    // $image_view .= '<img src="uploads/'.$folder_name.'/'.$doc_name.'"  height="50px" width="50px" >';
                } else if ($cfile_name[1] == 'pdf') {
                    $image_view_3 .= '<a href="javascript:print_pdf_2(\'/' . $file_name . '\')"><img src="../../uploads/po_form/po_attach/pdf.png"  height="30px" width="30px" ></a>';
                } else if (($cfile_name[1] == 'pdf') || ($cfile_name[1] == 'xls') || ($cfile_name[1] == 'xlsx')) {
                    $image_view_3 .= '<a href="javascript:print_1(\'/' . $file_name . '\')"><img src="../../uploads/po_form/po_attach/excel.png"  height="30px" width="30px" ></a>';
                } else if (($cfile_name[1] == 'txt') || ($cfile_name[1] == 'docx') || ($cfile_name[1] == 'doc')) {
                    $image_view_3 .= '<a href="javascript:print_1(\'/' . $file_name . '\')"><img src="../../uploads/po_form/po_attach/word.png"  height="30px" width="30px" ></a>';
                }
            }
        }
    }

    return $image_view_3;
}
?>
<script>
    new DataTable('#ins_pen', {
        layout: {
            top1: 'searchBuilder'
        }
    });
</script>
<script>
    $(document).ready(function () {


    });
    function print_pdf_1(file_name) {

        onmouseover = window.open('../../uploads/po_form/po_attach/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
    }
    function print_pdf_2(file_name) {

        onmouseover = window.open('../../uploads/po_form/po_attach/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
    }
</script>
