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
    #customer_name_datatable {
        border: 1px solid black; /* Bold black border for the table */
    }
    #customer_name_datatable th,
    #customer_name_datatable td {
        border: 1px solid black; /* Bold black border for table cells */
    }

    #customer_name_datatable thead th {
        background-color: #f8f9fa; /* Optional: Light background for header */
    }

  
    #excutive_name_table th,
    #excutive_name_table td {
        border: 1px solid black; /* Bold black border for table cells */
    }

    #excutive_name_table thead th {
        background-color: #f8f9fa; /* Optional: Light background for header */
    }

    #item_code_table th,
    {
        border: 1px solid black; /* Bold black border for the table */
    }
    #item_code_table th,
    #item_code_table td {
        border: 1px solid black; /* Bold black border for table cells */
    }

    #item_code_table thead th {
        background-color: #f8f9fa; /* Optional: Light background for header */
    }
    /* #month_wise_table {
        border: 1px solid black; 
    } */
    #month_wise_table th,
    #month_wise_table td {
        border: 1px solid black; /* Bold black border for table cells */
    }
#month_wise_table thead th {
        background-color: #f8f9fa; /* Optional: Light background for header */
    }
 
    #year_wise_table th,
    #year_wise_table td {
        border: 1px solid black; /* Bold black border for table cells */
    }
    #year_wise_table thead th {
        background-color: #f8f9fa; /* Optional: Light background for header */
    }
  
  
    #po_date_wise_table th,
    #po_date_wise_table td {
        border: 1px solid black; /* Bold black border for table cells */
    }
    #po_date_wise_table thead th {
        background-color: #f8f9fa; /* Optional: Light background for header */
    }
 #brand_name_table th,
    #brand_name_table td {
        border: 1px solid black; /* Bold black border for table cells */
    }
    #brand_name_table thead th {
        background-color: #f8f9fa; /* Optional: Light background for header */
    }

</style>
<?php
//  $screen_id = isset($_GET['screen_id']) ? htmlspecialchars($_GET['screen_id']) : '';
$screen_id_val='641ad5b47d02a30030';
// print_r($screen_id);
   session_start();
  $user_type_unique_id = $_SESSION['user_type_unique_id'];
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
<div class="row mt-2 po-class">

   <?php include 'filter.php';?>
     
  </div>

<!----content start---------->
<div class="col-xxl-12">
    <div class="card">
        <div class="card-body">
            <ul class="nav nav-pills arrow-navtabs  bg-light mb-3" role="tablist">
                <li class="nav-item" >
                    <!--onclick="dispatch_pending()"-->
                    <a class="nav-link active" data-bs-toggle="tab" href="#arrow-overview" role="tab">
                        <span class="d-block d-sm-none"><i class="mdi mdi-home-variant"></i></span>
                        <span class="d-none d-sm-block">Po Report</span>
                    </a>
                </li>
               
               
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane active" id="arrow-overview" role="tabpanel">
                <div class="row" id="list">
                        <div class="col-12">
                            <div class="">
                                <div class="card-body">
                                <div class="row align-items-end">
               <div class="col-4">
                  <div class="mb-3">
                     <label class="form-label from-date-label" id="lbs">From Date : <span id="val1" class="spans"></span></label>
                     
                  </div>
               </div>
               <div class="col-4">
                  <div class="mb-3">
                     <label class="form-label from-date-label" id="lbs">To Date : <span id="val2" class="spans"></span></label>
                     
                  </div>
               </div>
  </div>
  <div class="row align-items-end">
               <div class="col-4">
                  <div class="mb-3">
                     <label class="form-label from-date-label" id="lbs">Department Name : <span id="val3" class="spans"></span></label>
                     
                  </div>
               </div>
               <div class="col-4">
                  <div class="mb-3">
                     <label class="form-label from-date-label" id="lbs">Po Numbers : <span id="val4" class="spans"></span></label>
                     
                  </div>
               </div>
  </div>
  <div class="row align-items-end">
               <div class="col-4">
                  <div class="mb-3">
                     <label class="form-label from-date-label" id="lbs">Executive Name : <span id="val5" class="spans"></span></label>
                     
                  </div>
               </div>
               
               <div class="col-4">
                  <div class="mb-3">
                     <label class="form-label from-date-label" id="lbs"> Brand Name : <span id="val6" class="spans"></span></label>
                     
                  </div>
               </div>
               <div class="col-4">
                  <div class="mb-3">
                     <label class="form-label from-date-label" id="lbs"> Report On : <span id="val7" class="spans"></span></label>
                     
                  </div>
               </div>
  </div>
  <div class="table-responsive" id="po_no_table">
    <h4>Report On PO NO</h4>
    <table id="po_no_datatable" class="table table-bordered table-striped align-middle">
        <thead>
            <tr>
                <th>S.No</th>
                <th>PO Number</th>
                <th>PO Date</th>
                <th>Department</th>
                <th>Billing Address</th>
                <th>Executive Name</th>
                <th>No Of Consignee</th>
                <th>No Of Item</th>
                <th>Product Based Qty</th>
                <th>With Tax Amount</th>
                <th>Without Tax Amount</th>
            </tr>
        </thead>
        <tbody id="no_data">
            <tr>
                <td colspan="11" style="text-align: center;">No Data Found!</td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="6" style="text-align: center;"><b>Total</b></td>
                <td style="text-align: right;">
                    <b class="header font-weight-bold d-inline" id="total_no_of_con" style="font-size: 13px;"></b>
                </td>
                <td style="text-align: right;">
                    <b class="header font-weight-bold d-inline" id="total_no_of_item" style="font-size: 13px;"></b>
                </td>
                <td style="text-align: right;">
                    <b class="header font-weight-bold d-inline" id="total_no_of_qty" style="font-size: 13px;"></b>
                </td>
                <td style="text-align: right;">
                    <b class="header font-weight-bold d-inline" id="with_tax_amount" style="font-size: 13px;"></b>
                </td>
                <td style="text-align: right;">
                    <b class="header font-weight-bold d-inline" id="without_tax_amount" style="font-size: 13px;"></b>
                </td>
            </tr>
                                    </tfoot>
                                   
                                    </table>
                                </div>
                        
<div class="table-responsive" id="customer_name_table" style="display: none;">
    <h4>Report On Customer Name</h4>
    <table id="customer_name_datatable" class="table table-bordered table-striped align-middle">
        <thead>
            <tr>
                <th>S.No</th>
                <th>Department Name</th>
                <th>Total Number Of PO</th>
                <th>Total No Of Consignee</th>
                <th>Total Qty</th>
                <th>With Tax Amount</th>
                <th>Without Tax Amount</th>
                <!-- <th>With Tax Amount</th> -->
                <th>% Net Amount With Tax</th>
            </tr>
        </thead>
        <tbody>
            <!-- Dynamic content goes here -->
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2" style="text-align: center;"><b>Total</b></td>
                <td style="text-align: right;">
                    <b class="header font-weight-bold d-inline" id="total_no_of_cus_po" style="font-size: 13px;"></b>
                </td>
                <td style="text-align: right;">
                    <b class="header font-weight-bold d-inline" id="total_no_of_cus_con" style="font-size: 13px;"></b>
                </td>
                <td style="text-align: right;">
                    <b class="header font-weight-bold d-inline" id="total_no_of_cus_qty" style="font-size: 13px;"></b>
                </td>
                <td style="text-align: right;">
                    <b class="header font-weight-bold d-inline" id="with_tax_amount_customer" style="font-size: 13px;"></b>
                </td>
                <td style="text-align: right;">
                    <b class="header font-weight-bold d-inline" id="without_tax_amount_customer" style="font-size: 13px;"></b>
                </td>
              
                <td style="text-align: right;">
                    <b class="header font-weight-bold d-inline" id="percentage_customer" style="font-size: 13px;"></b>
                </td>
            </tr>


                        </tfoot>
                                    </table>
                                </div>
                                <!-- excutive_name_table -->
                                <div class="table-responsive" id="excutive_name_table" style="display: none;">
    <h4>Report On Executive Name</h4>
    <table id="excutive_name_datatable" class="table table-bordered table-striped align-middle">
        <thead>
            <tr>
                <th>S.No</th>
                <th>Executive Name</th>
                <th>Total Number Of PO</th>
                <th>Total No Of Consignee</th>
                <th>Total Qty</th>
                <th>With Tax Amount</th>
                <th>Without Tax Amount</th>
                <th>% Net Amount With Tax</th>
            </tr>
        </thead>
        <tbody>
            <!-- Dynamic content goes here -->
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2" style="text-align: center;"><b>Total</b></td>
                <td style="text-align: right;">
                    <b class="header font-weight-bold d-inline" id="total_no_of_exc_po" style="font-size: 13px;"></b>
                </td>
                <td style="text-align: right;">
                    <b class="header font-weight-bold d-inline" id="total_no_of_exc_con" style="font-size: 13px;"></b>
                </td>
                <td style="text-align: right;">
                    <b class="header font-weight-bold d-inline" id="total_no_of_exc_qty" style="font-size: 13px;"></b>
                </td>
                <td style="text-align: right;">
                    <b class="header font-weight-bold d-inline" id="with_tax_amount_exc" style="font-size: 13px;"></b>
                </td>
                <td style="text-align: right;">
                    <b class="header font-weight-bold d-inline" id="without_tax_amount_exc" style="font-size: 13px;"></b>
                </td>
                <td style="text-align: right;">
                    <b class="header font-weight-bold d-inline" id="percentage_exc" style="font-size: 13px;"></b>
                </td>
            </tr>
      
                      </tfoot>
                     
                                        </tbody>
                                    </table>
                                </div>
                                <!-- end -->
                                <!-- item code -->
                                <div class="table-responsive" id="item_code_table" style="display: none;">
    <h4>Report On Item Code</h4>
    <table id="item_wise_datatable" class="table table-bordered table-striped align-middle">
        <thead>
            <tr>
                <th>S.No</th>
                <th>Item Code</th>
                <th>Item Description</th>
                <th>Brand Name</th>
                <th>Qty</th>
                <th>With Tax Amount</th>
                <th>Without Tax Amount</th>
              
                <th>% Net Amount With Tax</th>
            </tr>
        </thead>
        <tbody>
            <!-- Dynamic content goes here -->
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" style="text-align: center;"><b>Total</b></td>
                <td style="text-align: right;">
                    <b class="header font-weight-bold d-inline" id="total_qty_item" style="font-size: 13px;"></b>
                </td>
                <td style="text-align: right;">
                    <b class="header font-weight-bold d-inline" id="with_tax_amount_icode" style="font-size: 13px;"></b>
                </td>
                <td style="text-align: right;">
                    <b class="header font-weight-bold d-inline" id="without_tax_amount_icode" style="font-size: 13px;"></b>
                </td>
              
                <td style="text-align: right;">
                    <b class="header font-weight-bold d-inline" id="percentage_icode" style="font-size: 13px;"></b>
                </td>
            </tr>
      

                      </tfoot>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- end -->
                                <!-- report month -->
                                <div class="table-responsive" id="month_wise_table" style="display:none">
                                        <h4>Report On Month</h4>
                                    <table id="month_datatable" class="table table-bordered table-striped align-middle">
                                        <thead>
                                        <tr>
                                       <th>S.No</th>
                                       <th>Month</th>
                                       <th>Total No Of Po</th>
                                       <th>Total No Of Consignee</th>
                                       <th>Total Qty</th>
                                       <th>With Tax Amount</th>
                                       <th>With Out Tax Amount</th>
                                    
                                       <th>% Net Amount With Tax</th>
                                       
                                    </tr>
                                        </thead>
                                        <tbody>
                                        <tfoot>
                          <tr>
                  <td colspan="2" style="text-align: center;"><b>Total</b></td>
                  <td style="text-align: right;">
                    <b class="header font-weight-bold d-inline" id="total_no_of_mon_po" style="font-size: 13px;"></b>
                </td>
                <td style="text-align: right;">
                    <b class="header font-weight-bold d-inline" id="total_no_of_mon_con" style="font-size: 13px;"></b>
                </td>
                <td style="text-align: right;">
                    <b class="header font-weight-bold d-inline" id="total_no_of_mon_qty" style="font-size: 13px;"></b>
                </td>
                <td colspan="1" style="text-align: right;">
                      <b class="header font-weight-bold d-inline" id="with_tax_amount_month" style="font-size:13px; "></b>
                  </td>
                  <td style="text-align: right;">
                      <b class="header font-weight-bold d-inline" id="without_tax_amount_month" style="font-size:13px; "></b> <!-- Corrected font-weight -->
                  </td>
                 
                  <td colspan="1" style="text-align: right;">
        <b class="header font-weight-bold d-inline" id="percentage_month" style="font-size:13px; "></b>
    </td>
                  
                  </tr>
                      </tfoot> 
                                        </tbody>
                                    </table>
                                </div>
                                 <!-- end
                                   -->
                                 <!-- report year-->
                                <div class="table-responsive" id="year_wise_table" style="display:none">
                                        <h4>Report On Year</h4>
                                    <table id="year_wise_datatable" class="table table-bordered table-striped align-middle">
                                        <thead>
                                        <tr>
                                       <th>S.No</th>
                                       <th>Year</th>
                                       <th>Total No Of Po</th>
                                       <th>Total No Of Consignee</th>
                                       <th>Total Qty</th>
                                       <th>With Tax Amount</th>
                                       <th>With Out Tax Amount</th>
                                      
                                       <th>% Net Amount With Tax</th>
                                       
                                    </tr>
                                        </thead>
                                        <tbody>
                                           
                                        </tbody>
                                        <tfoot>
                          <tr>
                  <td colspan="2" style="text-align: center;"><b>Total</b></td>
                  <td style="text-align: right;">
                    <b class="header font-weight-bold d-inline" id="total_no_of_year_po" style="font-size: 13px;"></b>
                </td>
                <td style="text-align: right;">
                    <b class="header font-weight-bold d-inline" id="total_no_of_year_con" style="font-size: 13px;"></b>
                </td>
                <td style="text-align: right;">
                    <b class="header font-weight-bold d-inline" id="total_no_of_year_qty" style="font-size: 13px;"></b>
                </td>
                <td colspan="1" style="text-align: right;">
                      <b class="header font-weight-bold d-inline" id="with_tax_amount_year" style="font-size:13px; "></b>
                  </td>
                  <td style="text-align: right;">
                      <b class="header font-weight-bold d-inline" id="without_tax_amount_year" style="font-size:13px; "></b> <!-- Corrected font-weight -->
                  </td>
                 
                  <td colspan="1" style="text-align: right;">
        <b class="header font-weight-bold d-inline" id="percentage_year" style="font-size:13px; "></b>
    </td>
                  
                  </tr>
                      </tfoot> 
                                    </table>
                                </div>
                                 <!-- end
                                   -->
                                   <!-- report po_date-->
                                <div class="table-responsive" id="po_date_wise_table" style="display:none">
                                        <h4>Report On PO date</h4>
                                    <table id="po_date_wise_datatable" class="table table-bordered table-striped align-middle">
                                        <thead>
                                    <tr>
                                       <th>S.No</th>
                                       <th>Po Date</th>
                                       <th>Total No Of Po</th>
                                       <th>Total No Of Consignee</th>
                                       <th>Total Qty</th>
                                       <th>With Tax Amount</th>
                                       <th>With Out Tax Amount</th>
                                      
                                       <th>% Net Amount With Tax</th>
                                       
                                    </tr>
                                        </thead>
                                        <tbody>
                                 
                                        </tbody>
                                        <tfoot>
                          <tr>
                  <td colspan="2" style="text-align: center;"><b>Total</b></td>
                  <td style="text-align: right;">
                    <b class="header font-weight-bold d-inline" id="total_no_of_date_po" style="font-size: 13px;"></b>
                </td>
                <td style="text-align: right;">
                    <b class="header font-weight-bold d-inline" id="total_no_of_date_con" style="font-size: 13px;"></b>
                </td>
                <td style="text-align: right;">
                    <b class="header font-weight-bold d-inline" id="total_no_of_date_qty" style="font-size: 13px;"></b>
                </td>
                <td colspan="1" style="text-align: right;">
                      <b class="header font-weight-bold d-inline" id="with_tax_amount_po_date" style="font-size:13px; "></b>
                  </td>
                  <td style="text-align: right;">
                      <b class="header font-weight-bold d-inline" id="without_tax_amount_po_date" style="font-size:13px; "></b> <!-- Corrected font-weight -->
                  </td>
                 
                  <td colspan="1" style="text-align: right;">
        <b class="header font-weight-bold d-inline" id="percentage_po_date" style="font-size:13px; "></b>
    </td>
                  
                  </tr>
                      </tfoot> 
                                    </table>
                                </div>
                                 <!-- end
                                   -->


                                   <!-- report po_date-->
                                <div class="table-responsive" id="brand_name_table" style="display:none">
                                        <h4>Report On Brand Name</h4>
                                    <table id="brand_name_datatable" class="table table-bordered table-striped align-middle">
                                        <thead>
                                        <tr>
                                       <th>S.No</th>
                                       <!-- <th>PO Date </th> -->
                                       <th>Brand Name</th>
                                       <th>Qty</th>
                            
                                       <th>With Tax Amount</th>
                                       <th>With Out Tax Amount</th>
                                       <th>% Net Amount With Tax</th>
                                       
                                    </tr>
                                        </thead>
                                        <tbody>
                                           
                                        </tbody>
                                        <tfoot>
                          <tr>
                  <td colspan="2" style="text-align: center;"><b>Total</b></td>
                  <td style="text-align: right;">
                    <b class="header font-weight-bold d-inline" id="total_no_of_brand_qty" style="font-size: 13px;"></b>
                </td>
                  <td colspan="1" style="text-align: right;">
                      <b class="header font-weight-bold d-inline" id="with_tax_amount_brand" style="font-size:13px; "></b>
                  </td>
                  <td style="text-align: right;">
                      <b class="header font-weight-bold d-inline" id="without_tax_amount_brand" style="font-size:13px; "></b> <!-- Corrected font-weight -->
                  </td>
                  <td colspan="1" style="text-align: right;">
        <b class="header font-weight-bold d-inline" id="percentage_brand" style="font-size:13px; "></b>
    </td>
                 
                  
                  </tr>
                      </tfoot> 
                                    </table>
                                </div>
                                <div class="table-responsive"  id="po_no_details_table" style="display:none">
                                        <table id="po_no_detail_datatable" class="table table-bordered table-striped align-middle">
                                            <thead>
                                            <tr>
                                       <th>S.No</th>
                                       <th>PO Number </th>
                                       <th>PO Date </th>
                                       <th>Department </th>
                                       
                                       <th>Executive Name</th>
                                       <th>Bill Address </th>

                                       <th>Pincode</th>
                                       <th>Consignee Address </th>
                                       
                                       <th>Consignee Pincode</th>
                                       <th>Contact Person </th>
                                       <th>Consignee Number</th>
                                       <th>Po Prepared By </th>

                                       <th>Item Code</th>
                                       <th>Product</th>
                                       <th>Qty</th>
                                       <th>Unit Price</th>
                                       <th>Tax</th>
                                       <th>Net Value</th>
                                       <th>Total Value</th>
                                       <th>Delivery Due Days</th>
                                       <th>Delivery Due Date</th>
                                       <!-- <th>Action</th> -->
                                    </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                   
                                                </tr>
                                            </tbody>
                                            <tfoot>
                          <tr>
                  <td colspan="17" style="text-align: center;"><b>Total</b></td>
                  <td  style="text-align: right;">
                    <b class="header font-weight-bold d-inline" id="total_no_of_detail_qty" style="font-size: 13px;"></b>
                </td>
                  <td style="text-align: right;">
                      <b class="header font-weight-bold d-inline" id="without_tax_amount_po_no" style="font-size:13px; "></b> <!-- Corrected font-weight -->
                  </td>
                  <td  style="text-align: right;">
                      <b class="header font-weight-bold d-inline" id="with_tax_amount_po_no" style="font-size:13px; "></b>
                  </td>
                 
                  
                  </tr>
                      </tfoot> 
                                        </table>
                                    </div>
                                 <!-- end
                                   -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!----content start---------->
                    <!--  Extra Large modal example -->
                 </div>
                <!-- fixed-header  -->
                <div class="tab-pane" id="arrow-profile" role="tabpanel">
                    <div class="row">
                        <div class="col-12">
                            <div class="">
                                <div class="card-body">
                                <!-- <button type="button" id="export2" name="export2" class="btn btn-primary  waves-effect waves-light wavw  mb-2 mt-2">
         <i class="ri-file-excel-2-fill"></i>
        </button> -->
                             <div id="list_1">
                                   
                                </div>
                                </div>
                            </div>
                        </div>
                    </div> 
                <!----content start---------->
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
<script>
      $("#export").click(function(){
    // alert("hi");
    window.location="folders/po_form/excel.php";
    });
    $("#export1").click(function(){
        
        var from_date = $('#from_date').val();
        // alert(from_date);
        var to_date = $('#to_date').val();
        // alert(to_date);
        // var month_fill = $('#month_fill').val();
   window.location="folders/po_form/excel1.php?from_date="+from_date+"&to_date="+to_date;
});

    function print_pdf_1(file_name)
{
    
 onmouseover=window.open('uploads/po_form/po_attach/' + file_name,'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
}

// function print_pdf_1(file_name)
// {
    
//  onmouseover=window.open('uploads/po_form/po_attach/' + file_name,'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
// }

// $(document).ready(function () {
//       // var table_id 	= "user_type_datatable";
//       // init_datatable(table_id,form_name,action);
//       get_data();
//       get_data_month();
//       sub_list_datatable('po_cancel_datatable', form_name, 'po_cancel_datatable');
// 	sub_list_datatable('po_cancel_datatable', form_name, 'po_cancel_datatable');
//     get_user_permission();
//     get_user_permission_1();

//    });

   function get_data() {
      document.getElementById('month_fill').value = '';

      init_datatable(table_id, form_name, action);
   }
   function get_data_month() {

      document.getElementById('from_date').value = '';
      document.getElementById('to_date').value = '';

      init_datatable(table_id, form_name, action);
   }


   function init_datatable(table_id = '', form_name = '', action = '') {

      var table = $("#" + table_id);
      var month_fill = $('#month_fill').val();
      var from_date = $("#from_date").val();
      var to_date = $("#to_date").val();
      var screen_id_val = $('#screen_id_val').val();

	// alert(screen_id_val);
	var user_type_unique_id = $('#user_type_unique_id').val();
    // alert(user_type_unique_id);

      if (month_fill != '') {
         var data = {
            "month_fill": month_fill,
            "action": action,
            "screen_id_val": screen_id_val,
		    "user_type_unique_id": user_type_unique_id,
         };
         var ajax_url = sessionStorage.getItem("folder_crud_link");

         var datatable = table.DataTable({
        destroy: true,
            ordering: true,
            searching: true,
            paging: true,
            "ajax": {
               url: ajax_url,
               type: "POST",
               data: data
            },
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
         });

      } 
      else if(from_date!='' && to_date!='') {
         var data = {
            "action": action,
            "from_date": from_date,
            "to_date": to_date,
            "screen_id_val": screen_id_val,
		    "user_type_unique_id": user_type_unique_id,
         };
         var ajax_url = sessionStorage.getItem("folder_crud_link");

         var datatable = table.DataTable({
        destroy: true,
            ordering: true,
            searching: true,
            paging: true,
            // lengthMenu: [[10, 50, 100, -1], [10, 50, 100, "All"]],

            "ajax": {
               url: ajax_url,
               type: "POST",
               data: data
            },
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
         });
      }
      else {
         var data = {
            "action": action,
            "from_date": from_date,
            "to_date": to_date,
            "screen_id_val": screen_id_val,
		    "user_type_unique_id": user_type_unique_id,
         };
         var ajax_url = sessionStorage.getItem("folder_crud_link");

         var datatable = table.DataTable({
        destroy: true,
            ordering: true,
            searching: true,
            paging: true,
            // lengthMenu: [[10, 50, 100, -1], [10, 50, 100, "All"]],

            "ajax": {
               url: ajax_url,
               type: "POST",
               data: data
            },
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
         });
      }


   }
   
   function get_user_permission() {
	var screen_id_val = $('#screen_id_val').val();
// alert(screen_id_val);
	var user_type_unique_id = $('#user_type_unique_id').val();
// alert(user_type_unique_id);
	var data = {
		"screen_id_val": screen_id_val,
		"user_type_unique_id": user_type_unique_id,
		"action": 'user_permission',
	};

	var ajax_url = sessionStorage.getItem("folder_crud_link");
	var url = sessionStorage.getItem("list_link");

	// console.log(data);
	$.ajax({
		type: "POST",
		url: ajax_url,
		data: data,
		success: function (data) {

			var obj = JSON.parse(data);

			var dataString = obj.data;

			// console.log(dataString);

			var addButton = document.getElementById('add_btn');
			if (dataString.includes('5f8807ff00bf726601')) {
				addButton.style.visibility = 'visible';  // Show the button
			} else {
				addButton.style.visibility = 'hidden';   // Hide the button but keep its space
			}
			var listpage = document.getElementById('list');
			if (dataString.includes('5f88083fd50a344823')) {
				listpage.style.visibility = 'visible';  // Show the button
			} else {
				listpage.style.visibility = 'hidden';   // Hide the button but keep its space
			}


		},
		error: function (data) {
			alert("Network Error");
		}
	});
}
function get_user_permission_1() {
	var screen_id_val = $('#screen_id_val').val();

	var user_type_unique_id = $('#user_type_unique_id').val();

	var data = {
		"screen_id_val": screen_id_val,
		"user_type_unique_id": user_type_unique_id,
		"action": 'user_permission_1',
	};

	var ajax_url = sessionStorage.getItem("folder_crud_link");
	var url = sessionStorage.getItem("list_link");

	// console.log(data);
	$.ajax({
		type: "POST",
		url: ajax_url,
		data: data,
		success: function (data) {

			var obj = JSON.parse(data);

			var dataString = obj.data;

			// console.log(dataString);

			// var addButton = document.getElementById('add_btn');
			// if (dataString.includes('5f8807ff00bf726601')) {
			// 	addButton.style.visibility = 'visible';  // Show the button
			// } else {
			// 	addButton.style.visibility = 'hidden';   // Hide the button but keep its space
			// }
			var listpage = document.getElementById('list_1');
			if (dataString.includes('5f88083fd50a344823')) {
				listpage.style.visibility = 'visible';  // Show the button
			} else {
				listpage.style.visibility = 'hidden';   // Hide the button but keep its space
			}


		},
		error: function (data) {
			alert("Network Error");
		}
	});
}

   function sub_list_datatable(table_id = "", form_name = "", action = "") {
	// alert();
	// alert('hii');
	// var po_cancel_datatable = $("#demo").val();
	var table_id = 'po_cancel_datatable';
	// alert(table_id);
	var table = $("#" + table_id);
	var data = {

		"action": 'po_cancel_datatable',
	};
	var ajax_url = sessionStorage.getItem("folder_crud_link");
	var datatable = table.DataTable({
        destroy: true,
		ordering: true,
		searching: true,
        // paging: true,
		"ajax": {
			url: ajax_url,
			type: "POST",
			data: data
		},
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
	});
}

  </script>
