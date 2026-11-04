<style>
    i.fa.fa-edit {
        font-size: 20px;
        color: green;
    }
    i.fa-sharp.fa-solid.fa-trash {
        font-size: 20px;
        color: green;
    }
button#export {
    float: right;
    padding: 5px 10px;
}
table.dataTable.nowrap td {
    white-space: unset;
}
span.po_date {
    white-space: nowrap;
}
span.invoice_date {
    white-space: nowrap;
}
#lbs{
    font-size: 16px;
    font-weight: bold;
}
.spans{
    color: #1a7db7;
    font-size: 13px;
    font-weight: unset;
}
#po_no_datatable {
        border: 1px solid black; /* Bold black border for the table */
    }
    
    #po_no_datatable th,
    #po_no_datatable td {
        border: 1px solid black; /* Bold black border for table cells */
    }

    #po_no_datatable thead th {
        background-color: #f8f9fa; /* Optional: Light background for header */
    }

  
    /* Ensure the table's borders collapse properly */
    #po_no_datatable {
        border-collapse: collapse; 
    }
    #invoice_datatable {
        border: 1px solid black; /* Bold black border for the table */
    }
    #invoice_datatable th,
    #invoice_datatable td {
        border: 1px solid black; /* Bold black border for table cells */
    }

    #invoice_datatable thead th {
        background-color: #f8f9fa; /* Optional: Light background for header */
    }



    .spinner {
    border: 6px solid #f3f3f3;
    border-top: 6px solid #3498db;
    border-radius: 50%;
    width: 50px;
    height: 50px;
    margin: auto;
    animation: spin 1s linear infinite;
}
@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

  

</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.3.0/exceljs.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<!-- <script src="https://cdn.jsdelivr.net/npm/exceljs/dist/exceljs.min.js"></script> -->

<?php
//  $screen_id = isset($_GET['screen_id']) ? htmlspecialchars($_GET['screen_id']) : '';
$screen_id_val='641ad5b47d02a30030';
// print_r($screen_id);
   session_start();
  $user_type_unique_id = $_SESSION['user_type_unique_id'];


$customer_name_options = department_creation_table();
$customer_name_options = select_option($customer_name_options,"Select Customer");


$po_no_options = list_of_po();
$po_no_options = select_option($po_no_options,"Select Po");


  ?>
<!-- start page title -->
<div class="row">
     <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
           <h4 class="mb-sm-0"> PO Report</h4>


           <input type="hidden" id="screen_id_val" name="screen_id_val" class="form-control" value="<?php echo $screen_id_val;?>">
            <input type="hidden" id="user_type_unique_id" name="user_type_unique_id" class="form-control" value="<?php echo $user_type_unique_id;?>">

           <div class="page-title-right">
              <ol class="breadcrumb m-0">
                 <li class="breadcrumb-item"><a href="javascript: void(0);">Reports</a></li>
                 <li class="breadcrumb-item active"> PO Report</li>
              </ol>
           </div>

        </div>
     </div>
  </div>


<!----content start---------->
<div class="col-xxl-12">
    <div class="card">
        <div class="card-body">

        <div class="row">

        <div class="col-3">

        <label class="form-label">Customer Name</label>
        <select class="select2 form-control" id="customer_name" name="customer_name" onchange="get_po(this.value)">
    <!-- <option value="">Select Customer Name</option> -->
    <?php echo $customer_name_options;?>
</select>
</div>

<div class="col-3">

        <label class="form-label">Po NO</label>
        <select class="select2 form-control" id="po_num" name="po_num">
<?php echo $po_no_options;?>    
</select>
</div>
<div class="col-2 mt-4">
<button type="button"  name="go_filter" id="go_filter" onclick="filterdata()" class="btn btn-primary">GO</button>
</div>
</div>


<div class="row" id="loader" style="display:none; text-align:center; margin:20px;">
     <i class="fa fa-spinner fa-spin fa-3x"></i>
    <h4>Please wait, fetching data...</h4>
</div>

<!-- <div id="loader" style="display:none; text-align:center; margin:20px;">
    <div class="spinner"></div>
    <h4>Please wait, fetching data...</h4>
</div> -->

<div class="row" id="excel" style="display:none;">

        <img src="uploads/excel.png" id="export_excel" name="export_excel" style="width:300px; margin-left: 450px;"><br><br><br>
          <h2 style="width:300px; margin-left: 450px;">Excel Download Here</h2>

</div>


            
          
               
        </div><!-- end card-body -->
    </div><!-- end card -->
</div>
<!--end col-->
</div>
<!--end row-->
<!-- Page content Ends Here -->
</div>
</div>
</div>

<!-- Include the XLSX library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>

<script>



function filterdata() {
    var customer_name = $('#customer_name').val();
    var po_no = $('#po_num').val();

    if (!customer_name && !po_no) {
    Swal.fire({
        icon: 'info',
        text: 'Please select Customer Name or PO No.'
    });
    return;
}



//     if (!customer_name && !po_no) {
//     Swal.fire({
//         icon: 'info',
//         text: 'Select Customer Name AND PO No.'
//     });
//     return;
// } else if (!customer_name) {
//     Swal.fire({
//         icon: 'info',
//         text: 'Select Customer Name.'
//     });
//     return;
// } else if (!po_no) {
//     Swal.fire({
//         icon: 'info',
//         text: 'Select PO No.'
//     });
//     return;
// }



    if (customer_name || po_no) {
         $('#loader').show();
        $('#excel').hide();

        // Click handler for Excel export
        setTimeout(function () {
            $('#loader').hide();
            $('#excel').show();

            $('#export_excel').off('click').on('click', function () {
                excel_export(customer_name, po_no);
            });
        }, 1000);
    }
}


function excel_export(customer_name, po_no) {
  
    var ajax_url = sessionStorage.getItem("folder_crud_link");

    // Assuming batch_id is required here, make sure it's defined or passed properly
    // var batch_id = "some_batch_id"; // Replace with actual batch_id or logic to get it

    if (customer_name || po_no) {
        $.ajax({
            type: "POST",
            url: 'folders/po_wise_report/crud.php',
            data: {
                customer_name: customer_name,
                po_no: po_no,
                action: "get_po_details"
            },
            success: function (res) {
                var details = JSON.parse(res);

                if (details.data && details.data.length > 0) {
                    let exportData = details.data.map((item, index) => {
                        return {
                            "PO NUMBER": item.po_num,
                            "PO DATE": item.po_date,
                            "CONSIGNEE BATCH DATE": item.batch_date,
                            "DEPARTMENT NAME": item.department_name,
                            "BILLING GST NUMBER": item.billing_gst_no,
                             "REGION" : item.region,

                            "ZONE CODE": item.zone_code,
                            "ZONE NAME": item.zone,
                            "BRANCH CODE"             :item.con_branch_code,

                            "BRANCH NAME"              : item.con_branch,
                            "BILLING ADDRESS"          : item.cons_billing_address,  
                            "CONSIGNEE GST NO" : item.consignee_gst,
                            "CONSIGNEE ADDRESS"        : item.con_address,
                            "DISTRICT"                 : item.con_district,
                            "PINCODE"                  : item.con_pincode,
                            "STATE"                    : item.con_state,
                            "CONTACT PERSON NAME"      :item.contact_name,
                             "ALTER PERSON NAME"       : item.alter_contact_name,
                             "CONTACT NUMBER"          : item.con_contact_number,
                            "ALTERNATE CONTACT NUMBER" : item.alter_number,
                            "CONS EMAIL ID"            : item.cons_email_id,
                            "ITEM  CODE"               : item.item_code,
                            "ITEM DETAILS"             : item.product_name,
                             "QTY"                     : item.assign_qty,
                              "WARRANTY"                : item.warranty_duration,
                             "INVOICE NO"              : item.invoice_no,
                            "INVOICE DATE"             : item.invoice_date,
                            "DC NO"                    : item.dc_num,
                            "DC DATE"                  : item.dc_date,
                            "SERIAL NUMBER"            : item.serial_no,
                            "COURIER NAME"             : item.courier_name,
                            "POD NUMBER"               : item.pod_no,
                            "DISPATCH DATE"            : item.dispatch_date,
                            "DELIVERY STATUS"          : item.delivery_status,
                            "DELIVERY DATE"            : item.delivery_date,
                            "DC STATUS"                : item.dc_status,
                            "DC RECEIVED DATE"          : item.dc_sign_date,
                            "INSTALLED QTY"             : item.installed_qty,
                            "SNR STATUS"                : item.snr_status,

                            "SNR Qty"                       : item.snr_qty,

                            "INSTALLATION STATUS"           : item.ir_status,
                            "INSTALLATION DATE"             : item.ir_date,
                            "Installation Status Remarks"     : item.ins_remarks,
                            "VENDOR"                          : item.eng_name,
                            "VENDOR NUMBER"                   : item.vendor_no,
                            "VENDOR PRICE"                    : item.vendor_rate,
                            "GST %"                           : item.vendor_gst,
                            "GST Per Unit"                    : item.tax_amount,
                            "TOTAL per unit"                  : item.ttl_amount_per,
                            "Total PriceWithout Gst(Qty)"     : item.total_price_without_gst,
                            "Total PriceWith Gst(Qty)"        :  item.total_price_with_gst,
                            "VENDOR PAYMENT STATUS"           : item.vendor_pay_sts,
                            "BILL SUBMISSION STATUS"          : item.bill_sts,
                            "BILL SUBMISSION DATE"            : item.bill_submission_date,
                            "EXECUTIVE"                       : item.executive_name,
                            "FOLLOWED BY"                     : item.cons_followed_by                               

                            
                            // Uncomment and adjust according to your needs
                            // "Item Code": item.item_code,
                            // "Item Name": item.product_name,
                            // "Qty": item.qty,
                            // "Consignee Landline": item.con_lan_num,
                            // "Consignee Address": item.con_address,
                            // "Zone": item.zone,
                        };
                    });

                    // Export to Excel
                    const workbook = new ExcelJS.Workbook();
                    const worksheet = workbook.addWorksheet("Consignee Details");

                    // Add header row
                    const headers = Object.keys(exportData[0]);
                    worksheet.addRow(headers);

                    // Style header row
                    worksheet.getRow(1).eachCell(cell => {
                        cell.font = { bold: true, color: { argb: "FFFFFFFF" } };
                        cell.fill = {
                            type: 'pattern',
                            pattern: 'solid',
                            fgColor: { argb: "4472C4" } // Blue header
                        };
                        cell.alignment = { horizontal: "center", vertical: "middle" };
                        cell.border = {
                            top: { style: 'thin' },
                            left: { style: 'thin' },
                            bottom: { style: 'thin' },
                            right: { style: 'thin' }
                        };
                    });

                    // Add data rows
                    exportData.forEach(row => {
                        worksheet.addRow(Object.values(row));
                    });

                    // Auto-fit column widths
                    worksheet.columns.forEach(col => {
                        let maxLength = 0;
                        col.eachCell({ includeEmpty: true }, cell => {
                            maxLength = Math.max(maxLength, cell.value ? cell.value.toString().length : 0);
                        });
                        col.width = maxLength < 15 ? 15 : maxLength;
                    });

                    // Download file
                    workbook.xlsx.writeBuffer().then(buffer => {
                        const blob = new Blob([buffer], { type: "application/octet-stream" });
                        const url = window.URL.createObjectURL(blob);
                        const a = document.createElement("a");
                        a.href = url;
                         const poNum = details.data[0].po_num;
                        a.download = "PO WISE REPORT"  +"-" +   poNum +".xlsx";
                        a.click();
                        window.URL.revokeObjectURL(url);
                    });
                } else {
                    alert("No data found to export.");
                }
            }
        });
    } else {
        alert("Batch ID is missing!");
    }
}





function get_po(value){


    // alert(value);

    var customer  = value;
    var po_num = $('#po_num').val();


    var ajax_url = sessionStorage.getItem("folder_crud_link");


    $.ajax({

        type :'POST',
        url  : ajax_url,
        data:{
            'customer':customer,
            'action'  : 'get_po_num'
        },

        success:function(data){

            // var data = 
            $('#po_num').html(data);
        }

    });


}


//    function get_user_permission() {
// 	var screen_id_val = $('#screen_id_val').val();
// // alert(screen_id_val);
// 	var user_type_unique_id = $('#user_type_unique_id').val();
// // alert(user_type_unique_id);
// 	var data = {
// 		"screen_id_val": screen_id_val,
// 		"user_type_unique_id": user_type_unique_id,
// 		"action": 'user_permission',
// 	};

// 	var ajax_url = sessionStorage.getItem("folder_crud_link");
// 	var url = sessionStorage.getItem("list_link");

// 	// console.log(data);
// 	$.ajax({
// 		type: "POST",
// 		url: ajax_url,
// 		data: data,
// 		success: function (data) {

// 			var obj = JSON.parse(data);

// 			var dataString = obj.data;

// 			// console.log(dataString);

// 			var addButton = document.getElementById('add_btn');
// 			if (dataString.includes('5f8807ff00bf726601')) {
// 				addButton.style.visibility = 'visible';  // Show the button
// 			} else {
// 				addButton.style.visibility = 'hidden';   // Hide the button but keep its space
// 			}
// 			var listpage = document.getElementById('list');
// 			if (dataString.includes('5f88083fd50a344823')) {
// 				listpage.style.visibility = 'visible';  // Show the button
// 			} else {
// 				listpage.style.visibility = 'hidden';   // Hide the button but keep its space
// 			}


// 		},
// 		error: function (data) {
// 			alert("Network Error");
// 		}
// 	});
// }

// function get_user_permission_1() {
// 	var screen_id_val = $('#screen_id_val').val();

// 	var user_type_unique_id = $('#user_type_unique_id').val();

// 	var data = {
// 		"screen_id_val": screen_id_val,
// 		"user_type_unique_id": user_type_unique_id,
// 		"action": 'user_permission_1',
// 	};

// 	var ajax_url = sessionStorage.getItem("folder_crud_link");
// 	var url = sessionStorage.getItem("list_link");

// 	// console.log(data);
// 	$.ajax({
// 		type: "POST",
// 		url: ajax_url,
// 		data: data,
// 		success: function (data) {

// 			var obj = JSON.parse(data);

// 			var dataString = obj.data;

// 			// console.log(dataString);

// 			// var addButton = document.getElementById('add_btn');
// 			// if (dataString.includes('5f8807ff00bf726601')) {
// 			// 	addButton.style.visibility = 'visible';  // Show the button
// 			// } else {
// 			// 	addButton.style.visibility = 'hidden';   // Hide the button but keep its space
// 			// }
// 			var listpage = document.getElementById('list_1');
// 			if (dataString.includes('5f88083fd50a344823')) {
// 				listpage.style.visibility = 'visible';  // Show the button
// 			} else {
// 				listpage.style.visibility = 'hidden';   // Hide the button but keep its space
// 			}


// 		},
// 		error: function (data) {
// 			alert("Network Error");
// 		}
// 	});
// }


  </script>
