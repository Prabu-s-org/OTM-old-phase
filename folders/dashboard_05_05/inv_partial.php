<!-- !-- This file Only PHP Functions  -->
<?php
// Get folder Name From Currnent Url 
$folder_name        = explode("/", $_SERVER['PHP_SELF']);
$folder_name        = $folder_name[count($folder_name) - 2];


// Include DB file and Common Functions
include '../../config/dbconfig.php';
include 'function.php';

?>
<style>
    table {
        border-collapse: collapse; /* Ensures borders don't have spacing between cells */
        width: 100%;
    }

    th, td {
        border: 1px solid black; /* Adds border around table cells */
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: #f2f2f2; /* Light background for table headers */
    }
    .text_po {
        text-align-last: center;
    }
</style>
<!-- datatable start -->
<link rel="stylesheet" type="text/css" href="../../assets/datatable_new/jquery.dataTables.css"  />
    <link rel="stylesheet" type="text/css" href="../../assets/datatable_new/buttons.dataTables.css"  />

    <script src="../../assets/datatable_new/jquery-3.7.0.min.js"></script>
    <script src="../../assets/datatable_new/jquery.dataTables.js"></script>
    <script src="../../assets/datatable_new/dataTables.buttons.js"></script>
    <script src="../../assets/datatable_new/jszip.min.js"></script>
    <script src="../../assets/datatable_new/buttons.html5.min.js"></script>
    <script src="../../assets/datatable_new/buttons.print.min.js"></script>
    <script src="../../assets/datatable_new/pdfmake.min.js"></script>


<h2 class="text_po">Invoice Assign Quantity Partial Pending</h2>
                            <form class="was-validated" autocomplete="off">
                                 <div class="row">
									<div class="col-12 mt-2">
										<div class="table-responsive mb-4">
											<table
												class="table table-striped table-bordered align-middle table-nowrap mb-0 small_table" id="ins_pen">
												<thead class="table-light">
													<tr>
                                                   
                                                    <th>S.No</th>
                                                    <th>PO Number </th>
                                                    <th>PO Date </th>
                                                    
                                                    <th>Department</th>
                                                    <th>Executive Name
                                                    </th>
                                                    <th>No of Consignee
                                                    </th>
                                                    <th>No of Items in PO
                                                    </th>
                                                    <th>Qty
                                                    </th>
                                                    <th>Total Value
                                                    </th>
                                                    <th>PO Attachment
                                                    </th>
                                                    <!-- <th> Delivery Due Date</th> -->
                                                    <th>Status
                                                    </th>
													</tr>
												</thead>
												<tbody>
													<?php
                                                  
                                                    //  `po`.`file_name` <> ''
													$table = 'stock_position_main';
													$columns_1 = [
                                                        "'' as  s_no",
                
                                                        "(SELECT po_unique_id FROM po_form WHERE po_form.unique_id = $table.form_main_unique_id AND po_form.is_delete=0 group by form_main_unique_id) AS po_unique_id",
                                                        "po_date",
                                                        "department",
                                                        "executive_name",
                                                        "no_of_con",
                                                        "no_of_item",
                                                        "stock_qty",
                                                        "stock_value",
                                                        // "(ROUND((stock_value), 2)) AS stock_value",
                                                        "(SELECT SUM(invoice_qty) FROM invoice_creation_main WHERE invoice_creation_main.form_main_unique_id  = $table.form_main_unique_id AND invoice_creation_main.is_delete=0 group by form_main_unique_id) AS invoice_qty",
                                                        "(SELECT file_name FROM po_form WHERE po_form.unique_id  = $table.form_main_unique_id AND po_form.is_delete=0 group by form_main_unique_id) AS po_file",
                                            
                                                        "form_main_unique_id",
                                                        "po_num",
                                                        // "(select count(*) from invoice_creation_main where form_main_unique_id = $table.form_main_unique_id AND invoice_creation_main.is_delete=0) AS count",
                                            
                                                        // remaining_qty 
                                                        "(SELECT sum(item_qty) FROM stock_position WHERE stock_position.form_main_unique_id  = $table.form_main_unique_id AND stock_position.is_delete=0) AS item_qty",
                                                        "(SELECT sum(billed_qty) FROM stock_position_main WHERE stock_position_main.form_main_unique_id  = $table.form_main_unique_id AND stock_position_main.is_delete=0) AS billed_qty",
                                                        // "(select con_inv_status from consignee_details_sub where unique_id = $table_invoice_main.consignee_unique_id group by invoice_auto_id ) AS con_address",
                                    
                                                     ];
													
													$table_details1 = [
														$table,
														$columns_1
													];
                                                    // `stock`.`is_delete` = '0' AND `stock`.`billed_qty` IS NULL
                                                    $where1 = "
                                                    is_delete='0' 
                                                    AND stock_qty != (
                                                        SELECT SUM(invoice_qty) 
                                                        FROM invoice_creation_main 
                                                        WHERE invoice_creation_main.form_main_unique_id = $table.form_main_unique_id 
                                                        AND invoice_creation_main.is_delete=0 
                                                        GROUP BY form_main_unique_id
                                                    )
                                                ";
                                                
												// print_r(  $where1);
													$result1 = $pdo->select($table_details1, $where1);
													// print_r($result1);die();
													if ($result1->status) {
														$res_array1 = $result1->data;
														// print_r($result1->data);
														foreach ($res_array1 as $key => $value) {
                                                            
															$value['s_no'] = $sno + 1;
                                        // $stock_value         = $value['stock_value'];
                                        // $value['stock_value']  = moneyFormatIndia(($stock_value));
                                        $value['po_file'] = image_view_3("po_form", $value['form_main_unique_id'], $value['po_file']);
                                        // $value['po_date'] = '<span class="po_date">' . $value['po_date'] . '</span>';

                                        $stock_value       = moneyFormatIndia1($value['stock_value']);
                                        $value['stock_value']=$stock_value;
                                        // print_r($value['unit_price']);
                                            $invoice_qty1= $value['invoice_qty'];
                                            $stock_qty1= $value['stock_qty'];
                                        // status
                                        // if($value['stock_qty']==$value['invoice_qty']){
                                        //     $value['invoice_qty']='Completed';
                                        
                                        // }
                                    //    else{
                                    //     $value['invoice_qty']='Pending';
                                    //    }
                                    if($value['stock_qty']!=$value['invoice_qty']){
                                            $value['invoice_qty']='Pending';
                                        
                                    }
                                    
                                    //    else if($value['item_qty']!=$value['stock_qty']){
                                    //         $value['invoice_qty']='partial stock Pending';
                                    //     }
                                        else{
                                            $value['invoice_qty']='Completed';
                                        }
                                    
                        // Define colors
                        $completed_color = "green";
                        $pending_color = "red";

                        // Format string with placeholders
                        if ($value['invoice_qty'] == 'Completed') {
                            $value['invoice_qty'] = sprintf('<span style="color: %s;">%s</span>', $completed_color, $value['invoice_qty']);
                        } else {
                            $value['invoice_qty'] = sprintf('<span style="color: %s;">%s</span>', $pending_color, $value['invoice_qty']);
                        }


                                        $orgDate = $value['po_date'];  
                                        // $value['po_date'] = date("d-m-Y", strtotime($orgDate));
                                        $value['po_date'] = '<span class="po_date">' . date("d-m-Y", strtotime($value['po_date'])) . '</span>';

                                        $value['po_unique_id'] = $value['po_num'];
                                                                                    
                                                             ?>
															<tr>
																
																<td id="table_td"><?php echo $value['s_no']; ?></td>
                                                                <td id="table_td"><?php echo $value['po_num']; ?></td>
																<td id="table_td"><?php echo $value['po_date']; ?></td>
                                                                <td id="table_td"><?php echo $value['department']; ?></td>
                                                                <td id="table_td"><?php echo $value['executive_name']; ?></td>
                                                                <td id="table_td"><?php echo $value['no_of_con']; ?></td>
                                                                 <td id="table_td"><?php echo $value['no_of_item']; ?></td>
																<td id="table_td"><?php echo $value['stock_qty'];  ?></td>

                                                                <td id="table_td"><?php echo $value['stock_value']; ?></td>
                                                                <td id="table_td"><?php echo  $value['po_file']; ?></td>
																<!-- <td id="table_td"><?php echo  $value['invoice_qty'];  ?></td> -->

                                                                <td id="table_td"><?php echo  $value['invoice_qty'];  ?></td> 


																
                                                               
												
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
