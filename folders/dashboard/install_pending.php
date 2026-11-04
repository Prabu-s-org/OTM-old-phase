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

<h2 class="text_po">Installation Pending</h2>
<form class="was-validated" autocomplete="off">
    <div class="row">
        <div class="col-12 mt-2">
            <div class="table-responsive mb-4">

                <table class="table table-striped table-bordered align-middle table-nowrap mb-0 small_table"
                    id="ins_pen">
                    <thead class="table-light">
                        <tr>

                            <th>S.No</th>
                            <th>PO Number </th>
                            <th>PO Date </th>
                            <!-- <th>Department</th> -->
                            <th>Ledger Name</th>
                            <th>Consignee District</th>
                            <th>Location </th>
                            <th>Invoice No </th>
                            <th>Invoice Date</th>
                            <th>Invoice Value</th>
                            <th>PO.Att.</th>
                            <th>DC.Att.</th>
                            <th>IR.Att.</th>
                            <th>INV.Att.</th>
                            <th>Engineer Name</th>
                            <th>Status</th>
                            <th>Due date</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php

                        //  `po`.`file_name` <> ''
                        $table = 'view_installation_followups';
                        $columns = [
                            "'' as  s_no",
                            "po_num",

                            "po_date",


                            // "(SELECT department FROM department_creation WHERE department_creation.unique_id = view_installation_followups.department) AS department",
                            // "(SELECT ledger_name FROM invoice_creation_main WHERE invoice_creation_main.form_main_unique_id = view_installation_followups.ledger_name) AS ledger_name",
                        
                            "ledger_name",
                            "(SELECT district_name FROM district_creation WHERE district_creation.unique_id = view_installation_followups.con_district) AS con_district",
                            "con_address",
                            "invoice_no",
                            // "invoice_date",
                            "DATE_FORMAT(invoice_date, '%d-%m-%Y') AS invoice_date",
                            "invoice_value",
                            "po_file_name",
                            "dc_file_name",
                            "ir_file_name",
                            "file_invoice",
                            // "(SELECT engineer_name FROM view_eng_data WHERE engineer_name_creation.unique_id = view_installation_followups.engineer_name) AS engineer_name",
                            "(select staff_name from view_eng_data WHERE view_eng_data.eng_unique_id=$table.engineer_name) AS engineer_name",

                            "installation_status",
                            "delivery_due_dates",

                            "consignee_unique_id",
                            "form_main_unique_id",
                            "con_pincode",
                            "dc_required",

                            "invoice_auto_id",
                            "(SELECT sum(delivery_due_days) FROM invoice_creation WHERE invoice_creation.invoice_no = view_installation_followups.invoice_no group by invoice_no) AS delivery_due_days",



                        ];

                        $table_details1 = [
                            $table,
                            $columns
                        ];
                        //  `invoice_main`.`dispatch_status` = '0' AND `invoice_main`.`ac_team_verifiy_status` = 1 AND `invoice_main`.`is_delete` = '0'
                        // $where1 = "status = 1";
                        
                        // `install_pending`.`installation_status` = '0' OR `install_pending`.`installation_status` = '3' OR `install_pending`.`installation_status` = '4'
                        $where1 = "installation_status = 0 or installation_status = 3  OR installation_status = 4 ";
                        // print_r(  $where1);
                        $result1 = $pdo->select($table_details1, $where1);
                        // print_r($result1);die();
                        if ($result1->status) {
                            $res_array1 = $result1->data;
                            // print_r($result1->data);
                            foreach ($res_array1 as $key => $value) {
                                $value['s_no'] = $sno + 1;

                                $value['s_no'] = $sno + 1;
                                // $value['po_unique_id'] = $value['po_num'];
                                $value['con_address'] = $value['con_address'] . ',' . $value['con_pincode'];
                                // $value['invoice_auto_id'] = $value['invoice_no'];
                                // if($value['installation_status'] == 0){
                                //     $value['installation_status'] = 'Pending';
                                // }else if($value['installation_status'] == 1){
                                //     $value['installation_status'] = 'Partial Completed';
                                // }else if($value['installation_status'] == 2){
                                //   $value['installation_status'] = 'Completed';
                                // }
                                // else if($value['installation_status'] == 3){
                                //     $value['installation_status'] = "<span style='color: red;'>Rejected</span>";
                        
                                //   }
                        
                                if ($value['installation_status'] == 0) {
                                    $value['installation_status'] = 'Pending';
                                } else if ($value['installation_status'] == 5) {
                                    $value['installation_status'] = 'Partial completed';
                                } else if ($value['installation_status'] == 2) {
                                    $value['installation_status'] = 'Completed';
                                } else if ($value['installation_status'] == 3) {
                                    $value['installation_status'] = "<span style='color: red;'>Rejected</span>";

                                } else if ($value['installation_status'] == 4) {
                                    $value['installation_status'] = "Eng Assigned";
                                } else if ($value['installation_status'] == 1) {
                                    $value['installation_status'] = "SNR";
                                }
                                // $value['file_invoice']     =  image_view_2("invoice", $value['unique_id'], $value['file_invoice']);
                                // $orgDate = $value['po_date'];
                                // $value['po_date'] = date("d-m-Y", strtotime($orgDate));
                                $value['invoice_date'] = '<span class="po_date">' . $value['invoice_date'] . '</span>';

                                // new changes
                        
                                $delivery_due_dates = $value['delivery_due_dates'];
                                if ($delivery_due_dates != "") {
                                    $delivery_due_dates = $value['delivery_due_dates'];
                                } else {
                                    $delivery_due_dates = $value['delivery_due_days'];
                                }

                                $value['po_date'] = '<span class="po_date">' . $value['po_date'] . '</span>';


                                $po_date = $value['po_date'];
                                $poDate = DateTime::createFromFormat('d-m-Y', strip_tags($po_date));
                                $poDate->modify('+' . $delivery_due_dates . ' days');

                                $resultDate = $poDate->format('d-m-Y');

                                $value['delivery_due_dates'] = "<span class='po_date'>$resultDate</span>";

                                // end
                        
                                // $value['invoice_date'] = date("d-m-Y", strtotime($orgDate1));
                                $value['po_file_name'] = image_view_3("po_form", $value['invoice_unique_id'], $value['po_file_name']);

                                $value['dc_file_name'] = image_view("invoice", $value['invoice_unique_id'], $value['dc_file_name']);

                                $po_file = $value['file_name'];
                                $file2 = $value['dc_file_name'];

                                $value['ir_file_name'] = image_view_1("invoice", $value['invoice_unique_id'], $value['ir_file_name']);
                                $value['file_invoice'] = image_view_2("invoice", $value['invoice_unique_id'], $value['file_invoice']);


                                ?>
                                <tr>

                                    <td id="table_td"><?php echo $value['s_no']; ?></td>
                                    <td id="table_td"><?php echo $value['po_num']; ?></td>
                                    <td id="table_td"><?php echo $value['po_date']; ?></td>
                                    <td id="table_td"><?php echo $value['ledger_name']; ?></td>
                                    <td id="table_td"><?php echo $value['con_district']; ?></td>

                                    <td id="table_td"><?php echo $value['con_address']; ?></td>
                                    <td id="table_td"><?php echo $value['invoice_no']; ?></td>
                                    <td id="table_td"><?php echo $value['invoice_date']; ?></td>
                                    <td id="table_td"><?php echo $value['invoice_value']; ?></td>

                                    <td id="table_td"><?php echo $value['po_file_name']; ?></td>
                                    <td id="table_td"><?php echo $value['dc_file_name']; ?></td>
                                    <td id="table_td"><?php echo $value['ir_file_name']; ?></td>
                                    <td id="table_td"><?php echo $value['file_invoice']; ?></td>


                                    <td id="table_td"><?php echo $value['engineer_name']; ?></td>
                                    <td id="table_td"><?php echo $value['installation_status']; ?></td>
                                    <td id="table_td"><?php echo $value['delivery_due_dates']; ?></td>

                                </tr>
                                <?php
                                $sno++;
                            }
                        }


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
<script>
    new DataTable('#ins_pen', {
        layout: {
            top1: 'searchBuilder'
        }
    });
</script>
<?php



function image_view($folder_name = "", $unique_id = "", $dc_file_name = "")
{
    // echo $dc_file_name;
    $file_names = explode(',', $dc_file_name);
    $image_view = '';

    if ($dc_file_name) {
        foreach ($file_names as $file_key => $dc_file_name) {
            if ($file_key != 0) {
                if ($file_key % 4 != 0) {
                    $image_view .= "&nbsp";
                } else {
                    $image_view .= "<br><br>";
                }
            }

            $cfile_name = explode('.', $dc_file_name);

            if ($dc_file_name) {

                if (($cfile_name[1] == 'jpg') || ($cfile_name[1] == 'png') || ($cfile_name[1] == 'jpeg')) {
                    $image_view .= '<a href="javascript:print_view(\'/' . $dc_file_name . '\')"><img src="../../uploads/invoice/' . $folder_name . '/' . $dc_file_name . '"  height="30px" width="30px" ></a>';
                    // $image_view .= '<img src="uploads/'.$folder_name.'/'.$doc_name.'"  height="50px" width="50px" >';
                } else if ($cfile_name[1] == 'pdf') {
                    $image_view .= '<a href="javascript:print_pdf(\'/' . $dc_file_name . '\')"><img src="../../uploads/invoice/pdf.png"  height="30px" width="30px" ></a>';
                } else if (($cfile_name[1] == 'pdf') || ($cfile_name[1] == 'xls') || ($cfile_name[1] == 'xlsx')) {
                    $image_view .= '<a href="javascript:print(\'/' . $dc_file_name . '\')"><img src="../../uploads/invoice/excel.png"  height="30px" width="30px" ></a>';
                } else if (($cfile_name[1] == 'txt') || ($cfile_name[1] == 'docx') || ($cfile_name[1] == 'doc')) {
                    $image_view .= '<a href="javascript:print(\'/' . $dc_file_name . '\')"><img src="../../uploads/invoice/word.png"  height="30px" width="30px" ></a>';
                }
            }
        }
    }

    return $image_view;
}



// doc 2

function image_view_1($folder_name = "", $unique_id = "", $ir_file_name = "")
{
    // echo $dc_file_name;
    $file_names = explode(',', $ir_file_name);
    $image_view1 = '';

    if ($ir_file_name) {
        foreach ($file_names as $file_key => $ir_file_name) {
            if ($file_key != 0) {
                if ($file_key % 4 != 0) {
                    $image_view1 .= "&nbsp";
                } else {
                    $image_view1 .= "<br><br>";
                }
            }

            $cfile_name = explode('.', $ir_file_name);

            if ($ir_file_name) {

                if (($cfile_name[1] == 'jpg') || ($cfile_name[1] == 'png') || ($cfile_name[1] == 'jpeg')) {
                    $image_view1 .= '<a href="javascript:print_view(\'/' . $ir_file_name . '\')"><img src="../../uploads/invoice/' . $folder_name . '/' . $ir_file_name . '"  height="30px" width="30px" ></a>';
                    // $image_view .= '<img src="uploads/'.$folder_name.'/'.$doc_name.'"  height="50px" width="50px" >';
                } else if ($cfile_name[1] == 'pdf') {
                    $image_view1 .= '<a href="javascript:print_pdf(\'/' . $ir_file_name . '\')"><img src="../../uploads/invoice/pdf.png"  height="30px" width="30px" ></a>';
                } else if (($cfile_name[1] == 'pdf') || ($cfile_name[1] == 'xls') || ($cfile_name[1] == 'xlsx')) {
                    $image_view1 .= '<a href="javascript:print(\'/' . $ir_file_name . '\')"><img src="../../uploads/invoice/excel.png"  height="30px" width="30px" ></a>';
                } else if (($cfile_name[1] == 'txt') || ($cfile_name[1] == 'docx') || ($cfile_name[1] == 'doc')) {
                    $image_view1 .= '<a href="javascript:print(\'/' . $ir_file_name . '\')"><img src="../../uploads/invoice/word.png"  height="30px" width="30px" ></a>';
                }
            }
        }
    }

    return $image_view1;
}


// doc3
function image_view_2($folder_name = "", $unique_id = "", $file_invoice = "")
{
    // echo $dc_file_name;
    $file_names = explode(',', $file_invoice);
    $image_view2 = '';

    if ($file_invoice) {
        foreach ($file_names as $file_key => $file_invoice) {
            if ($file_key != 0) {
                if ($file_key % 4 != 0) {
                    $image_view2 .= "&nbsp";
                } else {
                    $image_view2 .= "<br><br>";
                }
            }

            $cfile_name = explode('.', $file_invoice);

            if ($file_invoice) {

                if (($cfile_name[1] == 'jpg') || ($cfile_name[1] == 'png') || ($cfile_name[1] == 'jpeg')) {
                    $image_view2 .= '<a href="javascript:print_view(\'/' . $file_invoice . '\')"><img src="../../uploads/invoice/' . $folder_name . '/' . $file_invoice . '"  height="30px" width="30px" ></a>';
                    // $image_view .= '<img src="uploads/'.$folder_name.'/'.$doc_name.'"  height="50px" width="50px" >';
                } else if ($cfile_name[1] == 'pdf') {
                    $image_view2 .= '<a href="javascript:print_pdf(\'/' . $file_invoice . '\')"><img src="../../uploads/invoice/pdf.png"  height="30px" width="30px" ></a>';
                } else if (($cfile_name[1] == 'pdf') || ($cfile_name[1] == 'xls') || ($cfile_name[1] == 'xlsx')) {
                    $image_view2 .= '<a href="javascript:print(\'/' . $file_invoice . '\')"><img src="../../uploads/invoice/excel.png"  height="30px" width="30px" ></a>';
                } else if (($cfile_name[1] == 'txt') || ($cfile_name[1] == 'docx') || ($cfile_name[1] == 'doc')) {
                    $image_view2 .= '<a href="javascript:print(\'/' . $file_invoice . '\')"><img src="../../uploads/invoice/word.png"  height="30px" width="30px" ></a>';
                }
            }
        }
    }

    return $image_view2;
}


// doc3


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
                    $image_view_3 .= '<a href="javascript:print_view_1(\'/' . $file_name . '\')"><img src="../../uploads/po_form/po_attach/' . $folder_name . '/' . $file_name . '"  height="30px" width="30px" ></a>';
                    // $image_view .= '<img src="uploads/'.$folder_name.'/'.$doc_name.'"  height="50px" width="50px" >';
                } else if ($cfile_name[1] == 'pdf') {
                    $image_view_3 .= '<a href="javascript:print_pdf_1(\'/' . $file_name . '\')"><img src="../../uploads/po_form/po_attach/pdf.png"  height="30px" width="30px" ></a>';
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

    function print(file_name) {
        // 
        window.location = '../../uploads/invoice/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no';
    }
    function print_pdf(file_name) {

        onmouseover = window.open('../../uploads/invoice/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
    }

    // function print(file_name) {
    //     onmouseover = window.open('uploads/kra_kpi_form/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
    // }
    function print_view(file_name) {
        // window.location
        window.open('../../uploads/invoice/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
    }


    function print_1(file_name) {
        window.location = '../../uploads/po_form/po_attach/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no';
    }


    function print_pdf_1(file_name) {

        onmouseover = window.open('../../uploads/po_form/po_attach/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
    }
    // function print(file_name) {
    //     onmouseover = window.open('uploads/kra_kpi_form/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
    // }
    function print_view_1(file_name) {

        window.open('../../uploads/po_form/po_attach/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
    }


</script>
