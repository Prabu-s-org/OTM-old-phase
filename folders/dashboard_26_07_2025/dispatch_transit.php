<!-- !-- This file Only PHP Functions  -->
<?php
// Get folder Name From Currnent Url 
$folder_name = explode("/", $_SERVER['PHP_SELF']);
$folder_name = $folder_name[count($folder_name) - 2];


// Include DB file and Common Functions
include '../../config/dbconfig.php';
include 'function.php';

?>
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


<h2 class="text_po">Delivery Status - Material In Transit</h2>
<form class="was-validated" autocomplete="off">
    <div class="row">
        <div class="col-12 mt-2">
            <div class="table-responsive mb-4">
                <table class="table table-striped table-bordered align-middle table-nowrap mb-0 small_table"
                    id="ins_pen">
                    <thead class="table-light">
                        <tr>

                            <th>S.No</th>
                            <th>Po Number</th>
                            <th>Po Date</th>
                            <!-- <th>Department</th> -->
                            <th>Ledger Name</th>
                            <th>Location</th>
                            <th>Invoice No</th>
                            <th>Invoice Date</th>
                            <th scope="col">Dispatch Date</th>
                            <th scope="col">Mode of Delivery</th>
                            <th scope="col">Name of Courier / Person Name</th>
                            <th scope="col">POD NO.</th>
                            <th scope="col">Delivery Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        //  `po`.`file_name` <> ''
                        $table = 'view_dispatch_transit_list';
                        $columns = [
                            "'' as s_no",
                            "po_num",
                            // "DATE_FORMAT(po_date, '%d-%m-%Y') AS po_date",
                            "po_date",
                            // "consignee",
                        
                            // "department",
                            "ledger_name",

                            "(select con_address from consignee_details_sub where unique_id = $table.consignee_unique_id) AS con_address",
                            // "con_address",
                            "invoice_no",
                            // "DATE_FORMAT(invoice_date, '%d-%m-%Y') AS invoice_date",
                            "invoice_date",
                            "DATE_FORMAT(dispatch_date, '%d-%m-%Y') AS dispatch_date",
                            // "dispatch_date",
                            "mode_of_delivery",
                            "name_of_courier",
                            "pod_no",
                            "status",
                            "unique_id",
                            // "(select po_unique_id from po_form where unique_id = $table_dispatch.po_form_unique_id) AS po_unique_id",
                            "invoice_auto_id",
                            "po_form_unique_id",
                            "consignee_unique_id",
                            "invoice_no"



                        ];

                        $table_details1 = [
                            $table,
                            $columns
                        ];
                        //  `invoice_main`.`dispatch_status` = '0' AND `invoice_main`.`ac_team_verifiy_status` = 1 AND `invoice_main`.`is_delete` = '0'
                        $where1 = "
             status = 1";



                        // print_r(  $where1);
                        $result1 = $pdo->select($table_details1, $where1);
                        // print_r($result1);die();
                        if ($result1->status) {
                            $res_array1 = $result1->data;
                            // print_r($result1->data);
                            foreach ($res_array1 as $key => $value) {
                                $value['s_no'] = $sno + 1;

                                if ($value['status'] == "1") {
                                    $value['status'] = "Pending";
                                }
                                if ($value['mode_of_delivery'] == "1") {
                                    $value['mode_of_delivery'] = "Hand";
                                } else {
                                    $value['mode_of_delivery'] = "Courier";
                                }

                                ?>
                                <tr>

                                    <td id="table_td"><?php echo $value['s_no']; ?></td>
                                    <td id="table_td"><?php echo $value['po_num']; ?></td>
                                    <td id="table_td"><?php echo $value['po_date']; ?></td>
                                    <td id="table_td"><?php echo $value['ledger_name']; ?></td>

                                    <td id="table_td"><?php echo $value['con_address']; ?></td>
                                    <td id="table_td"><?php echo $value['invoice_no']; ?></td>
                                    <td id="table_td"><?php echo $value['invoice_date']; ?></td>

                                    <td id="table_td"><?php echo $value['dispatch_date']; ?></td>
                                    <td id="table_td"><?php echo $value['mode_of_delivery']; ?></td>
                                    <td id="table_td"><?php echo $value['name_of_courier']; ?></td>
                                    <td id="table_td"><?php echo $value['pod_no']; ?></td>


                                    <td id="table_td"><?php echo $value['status']; ?></td>

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
    $(document).ready(function () {


    });
    function print_pdf_1(file_name) {

        onmouseover = window.open('../../uploads/po_form/po_attach/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
    }
    function print_pdf_2(file_name) {

        onmouseover = window.open('../../uploads/po_form/po_attach/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
    }
</script>
<script>
    new DataTable('#ins_pen', {
        layout: {
            top1: 'searchBuilder'
        }
    });
</script>
