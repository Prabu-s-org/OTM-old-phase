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


<div>
    <h2 class="text_po">Total Purchase Order</h2>
</div>
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
                            <th>Department </th>
                            <th>Customer GST Number </th>
                            <th>Executive Name</th>
                            <th>PO Total Value</th>
                            <th>PO Attachment</th>
                            <!-- <th>PO Cancel</th> -->
                            <!-- <th>Action</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        //  `po`.`file_name` <> ''
                        $table_1 = 'view_po_dashboard_count';
                        $columns_1 = [
                            "'' as  s_no",
                            'po_num',
                            "DATE_FORMAT(po_date, '%d-%m-%Y') AS po_date",
                            // '',
                            '(SELECT department FROM department_creation AS dis WHERE dis.unique_id =' . $table_1 . '.department ) AS department',
                            'gst_value',
                            '(SELECT executive_name FROM executive_name AS dis WHERE dis.unique_id =' . $table_1 . '.executive_name ) AS executive_name',
                            // '(SELECT sum(total_value) FROM product_details_sub AS dis WHERE dis.form_main_unique_id = ' . $table . '.unique_id ) AS total_value ',
                            '(SELECT SUM(total_value) FROM product_details_sub AS dis WHERE 
                            dis.form_main_unique_id = ' . $table_1 . '.unique_id  and dis.is_delete=0) AS total_value',
                            
                            'file_name',
                            
                            
                        ];
                        
                        $table_details1 = [
                            $table_1,
                            $columns_1
                        ];
                        $where1 = 'file_name!=""';
                        // print_r(  $where1);
                        $result1 = $pdo->select($table_details1, $where1);
                        // print_r($result1);die();
                        if ($result1->status) {
                            $res_array1 = $result1->data;                            // print_r($result1->data);
                            foreach ($res_array1 as $key => $value) {
                                // $dc_required = $value['dc_required']; 
                                // - $value['product_count'];
                                $value['s_no'] = $sno + 1;
                                $file_name = $value['file_name'];
                                $value['file_name'] = image_view_3("po_form", $value['invoice_unique_id'], $value['file_name']);

                                ?>
                                <tr>

                                    <td id="table_td"><?php echo $value['s_no']; ?></td>
                                    <td id="table_td"><?php echo $value['po_num']; ?></td>
                                    <td id="table_td"><?php echo $value['po_date']; ?></td>
                                    <td id="table_td"><?php echo $value['department']; ?></td>
                                    <td id="table_td"><?php echo $value['gst_value']; ?></td>
                                    <td id="table_td"><?php echo $value['executive_name']; ?></td>
                                    <td id="table_td"><?php echo $value['total_value']; ?></td>
                                    <td id="table_td"><?php echo $value['file_name']; ?></td>

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
