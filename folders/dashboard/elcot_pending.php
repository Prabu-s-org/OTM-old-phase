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
        width: 100%;
    }

    th,
    td {
        border: 1px solid black;
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
    }

    .text_po {
        text-align-last: center;
    }
</style>

<h2 class="text_po">Invoice Pending</h2>
<form class="was-validated" autocomplete="off">
    <div class="row">
        <div class="col-12 mt-2">
            <div class="table-responsive mb-4">
                <table class="table table-striped table-bordered align-middle table-nowrap mb-0 small_table">
                    <thead class="table-light">
                        <tr>

                            <th>S.No</th>
                            <th>PO No</th>
                            <th>PO Date</th>

                            <th>Ledger Name</th>
                            <th>Location</th>
                            <th>Invoice No</th>
                            <th>Invoice Date</th>
                            <th>Invoice Value</th>
                            <th>PO</th>
                            <th>DC</th>
                            <th>IR</th>
                            <th>Invoice</th>

                            <th>A/C Team Verify Status</th>
                            <th>Approved by</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php


                        $table = 'view_doc_approval_list_final';
                        $columns = [
                            "'' as  sno",
                            "po_num",
                            "po_date",
                            // "(SELECT department FROM department_creation WHERE department_creation.unique_id = ".$table.".department ) AS department",
                            "ledger_name",
                            "(SELECT con_address FROM consignee_details_sub WHERE consignee_details_sub.unique_id = " . $table . ".consignee_unique_id AND consignee_details_sub.is_delete='0') AS con_address",
                            // "con_address",
                            "invoice_no",
                            "DATE_FORMAT(invoice_date, '%d-%m-%Y') AS invoice_date",
                            "invoice_value",
                            // "invoice_date",
                            "file_name",
                            "dc_file_name",
                            "ir_file_name",
                            "file_invoice",
                            "invoice_file_org_name",
                            "doc_approval_sts",
                            "approved_by",
                            "invoice_unique_id",
                        ];

                        $table_details1 = [
                            $table,
                            $columns
                        ];
                        //  `invoice_main`.`doc_approval_sts` = '0' AND `invoice_main`.`invoice_no` <> '' AND `invoice_main`.`is_delete` = '0' AND `sub`.`is_delete` = '0'
                        $where1 = "
                                                     doc_approval_sts = 0 AND invoice_no != ''";

                        $result1 = $pdo->select($table_details1, $where1);

                        $sno = 1;
                        if ($result1->status) {
                            $res_array1 = $result1->data;

                            foreach ($res_array1 as $key => $value) {
                                // $value['s_no'] = $sno + 1;
                                $value['s_no'] = $sno++;
                                $file_name = $value['file_name'];
                                $dc_file_name = $value['dc_file_name'];
                                $ir_file_name = $value['ir_file_name'];
                                $inv_file_name = $value['file_invoice'];

                                $value['file_name'] = image_view_3("po_form", $value['invoice_unique_id'], $value['file_name']);

                                $value['dc_file_name'] = image_view("invoice", $value['invoice_unique_id'], $value['dc_file_name']);

                                $value['ir_file_name'] = image_view_1("invoice", $value['invoice_unique_id'], $value['ir_file_name']);
                                $value['file_invoice'] = image_view_2("invoice", $value['invoice_unique_id'], $value['file_invoice']);

                                $orgDate = $value['po_date'];

                                $value['po_date'] = '<span class="po_date">' . date("d-m-Y", strtotime($value['po_date'])) . '</span>';


                                if ($value['invoice_date'] == '') {
                                    $value['invoice_date'] = '';
                                } else {

                                    $value['invoice_date'] = '<span class="invoice_date">' . $value['invoice_date'] . '</span>';

                                }

                                $invoice_value = $value['invoice_value'];
                                $value['invoice_value'] = moneyFormatIndia1(($invoice_value));

                                $value['invoice_file_org_name'] = '<img src="../../uploads/compare-icon.png"  height="30px" width="30px" data-bs-toggle="modal" data-bs-target=".bs-example-modal-xl' . $sno . '" type="button">
                                                                        <div class="modal fade bs-example-modal-xl' . $sno . '" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                                                                        <div class="modal-dialog modal-fullscreen">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h5 class="modal-title w-100 text-center" id="myExtraLargeModalLabel">PO & DC 
                                                                    Comparison Attachment </h5>
                                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    <div class="row mt-2">
                                                                                        <div class="col-md-6">
                                                                                            <input type="checkbox" value="po" id="po' . $sno . '" onclick="check(this,' . $sno . ');"/> PO
                                                                                            <input type="checkbox" value="dc" id="dc' . $sno . '" onclick="check_dc(this,' . $sno . ');"/> DC
                                                                                            <input type="checkbox" value="ir" id="ir' . $sno . '" onclick="check_ir(this, ' . $sno . ');"/> IR
                                                                                            <input type="checkbox" value="snr" id="snr' . $sno . '" onclick="check_inv(this,' . $sno . ');"/> Invoice
                                                                                        </div>
                                                                                    </div>
                                                                                  
                                                                                    <div class="row mt-2">
                                                                                       <div class="col-md-6" class="po_att" id="po_att' . $sno . '" style="display:none">
                                                                                           <h4 class="text-center">PO Attachment</h4>
                                                                                                <object data="../../uploads/po_form/po_attach/' . $file_name . '" type="application/pdf" width="100%" height="900">
                                                                                                    <iframe src="../../uploads/po_form/po_attach/' . $file_name . '"  width="100%" height="900">
                                                                                                    </iframe>
                                                                                                </object>
                                                                                        </div>
                                                                                        <div class="col-md-6" class="dc_att" id="dc_att' . $sno . '" style="display:none">
                                                                                            <h4 class="text-center">DC Attachment</h4>
                                                                                            <object data="../../uploads/invoice/' . $dc_file_name . '"  type="application/pdf" width="100%" height="900">
                                                                                                <iframe src="../../uploads/invoice/' . $dc_file_name . '"  width="100%" height="900">
                                                                                                </iframe>             
                                                                                            </object>
                                                                                       </div>
                                                                                       <div class="col-md-6" class="ir_att" id="ir_att' . $sno . '" style="display:none">
                                                                                            <h4 class="text-center">IR Attachment</h4>
                                                                                            <object data="../../uploads/invoice/' . $ir_file_name . '"  type="application/pdf" width="100%" height="900">
                                                                                                <iframe src="../../uploads/invoice/' . $ir_file_name . '"  width="100%" height="900">
                                                                                                </iframe>             
                                                                                            </object>
                                                                                       </div>
                                                                                       <div class="col-md-6" class="invoice" id="invoice' . $sno . '" style="display:none">
                                                                                            <h4 class="text-center">Invoice Attachment</h4>
                                                                                            <object data="../../uploads/invoice/' . $inv_file_name . '"  type="application/pdf" width="100%" height="900">
                                                                                                <iframe src="../../uploads/invoice/' . $inv_file_name . '"  width="100%" height="900">
                                                                                                </iframe>             
                                                                                            </object>
                                                                                       </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <a href="javascript:void(0);" class="btn btn-link link-success fw-medium" data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i> Close</a>
                                                                                    
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>';

                                // $value['invoice_file_org_name'] = '<img src="uploads/compare-icon.png"  height="30px" width="30px" data-toggle="modal" data-target="#myModal$po_file" type="button">';
                                if ($value['doc_approval_sts'] == "1") {
                                    $value['doc_approval_sts'] = "Approved";
                                } else if ($value['doc_approval_sts'] == "2") {
                                    $value['doc_approval_sts'] = "Not Approval";
                                } else {
                                    $value['doc_approval_sts'] = "Pending";
                                }

                                if ($value['approved_by']) {
                                    $value['approved_by'] = disname($value['approved_by']);
                                } else {
                                    $value['approved_by'] = '--';
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

                                    <td id="table_td"><?php echo $value['invoice_value']; ?></td>
                                    <td id="table_td"><?php echo $value['file_name']; ?></td>

                                    <td id="table_td"><?php echo $value['dc_file_name']; ?></td>
                                    <td id="table_td"><?php echo $value['ir_file_name']; ?></td>
                                    <td id="table_td"><?php echo $value['file_invoice']; ?></td>
                                    <!-- <td id="table_td"><?php echo $value['invoice_file_org_name']; ?></td>  -->
                                    <td id="table_td"><?php echo $value['ac_team_verifiy_status']; ?></td>
                                    <td id="table_td"><?php echo $value['ac_team_approved_by']; ?></td>
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



?>
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
<!-- <script src="path/to/your/script.js"></script> -->
<!-- <script src="../../assets/jquery.min.js"></script> -->
<!-- <script src="../../assets/js/scripts.js"></script> -->

<script>
    $(document).ready(function () {


    });
    // <head>

    // </head>

    function print_pdf_1(file_name) {

        onmouseover = window.open('../../uploads/po_form/po_attach/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
    }
    function print_pdf_2(file_name) {

        onmouseover = window.open('../../uploads/po_form/po_attach/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
    }


    // NEW

    function print(file_name) {
        // 
        window.location = '../uploads/invoice/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no';
    }
    // function print_pdf(file_name) {

    // 	onmouseover = window.open('uploads/invoice/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
    // }

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

    function check(my_obj, sno) {
        var chk = my_obj.checked;
        if (chk === true) {
            $('#po_att' + sno).show();
            // document.getElementById('po_att'+sno).style.display="block";
        }
        else {
            $('#po_att' + sno).hide();
            // document.getElementById('po_att'+sno).style.display="none";
        }
    }

    function check_dc(my_obj, sno) {
        var chk = my_obj.checked;
        if (chk === true) {
            $('#dc_att' + sno).show();
            // document.getElementById('dc_att').style.display="block";
        }
        else {
            $('#dc_att' + sno).hide();
            // document.getElementById('dc_att').style.display="none";
        }
    }

    function check_ir(my_obj, sno) {
        var chk = my_obj.checked;
        if (chk === true) {
            $('#ir_att' + sno).show();
            // document.getElementById('ir_att').style.display="block";
        }
        else {
            $('#ir_att' + sno).hide();
            // document.getElementById('ir_att').style.display="none";
        }
    }

    function check_inv(my_obj, sno) {
        var chk = my_obj.checked;
        if (chk === true) {
            $('#invoice' + sno).show();
            // document.getElementById('invoice').style.display="block";
        }
        else {
            $('#invoice' + sno).hide();
            // document.getElementById('invoice').style.display="none";
        }
    }

</script>
