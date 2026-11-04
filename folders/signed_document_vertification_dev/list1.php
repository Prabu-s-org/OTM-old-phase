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
</style>
<!-- Layout config Js -->
<script src="assets/js/layout.js"></script>
<!-- Bootstrap Css -->
<link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<!-- Icons Css -->
<link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
<!-- App Css-->
<link href="assets/css/app.min.css" rel="stylesheet" type="text/css" />
<!-- custom Css-->
<link href="assets/css/custom.min.css" rel="stylesheet" type="text/css" />

<?php
// $status_name_option          = status_option();
// $status_name_option        = select_option($status_name_option,"Select",$unique_id);

            $status_options      = [
                                    [
                                        "id"    => '0',
                                        "value"  => "Pending"
                                    ],
                                    [
                                        "id"    =>'1',
                                        "value"  => "Mismatch"
                                    ],
                                    [
                                        "id"    => '2',
                                        "value"  => "Verified"
                                    ],
                                    
                                ];
                                
                                $status_options    = select_option($status_options,"Select");
    
$today=date('y-m-d');
?>
<!-- start page title -->
<div class="row">
   <div class="col-12">
      <div class="page-title-box d-sm-flex align-items-center justify-content-between">
         <h4 class="mb-sm-0">Signed Document Verification</h4>

         <div class="page-title-right">
            <ol class="breadcrumb m-0">
               <li class="breadcrumb-item"><a href="javascript: void(0);">Admin</a></li>
               <li class="breadcrumb-item active">Signed Document Verification</li>
            </ol>
         </div>

      </div>
        <div>
         <button type="button" id="export" name="export" class="btn btn-primary  waves-effect waves-light wavw  mb-2 mt-2">
         <i class="ri-file-excel-2-fill"></i>
        </button>
     </div>
   </div>
</div>


<!-- end page title -->
<div class="row">
   <div class="col-xxl-12">
       <!-- <p>
                  <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseWidthExample"
                     aria-expanded="false" aria-controls="collapseWidthExample">
                  Filter With Date Wise
                  </button>
               </p> -->
               <div >
                  <div class="collapse collapse-horizontal" id="collapseWidthExample">
                     <div class="card card-body mb-0" style="width: 100%;">
                        <div class="row">
                           <div class="col-3">
                              <div class="mb-3">
                                 <label class="form-label">From Date</label>
                                 <input class="form-control"  type="date" name="from_date" id="from_date" max = "<?php echo $today; ?>"  value="<?php echo date('Y-m-d'); ?>">
                              </div>
                           </div>
                           <div class="col-3">
                              <div class="mb-3">
                                 <label  class="form-label">To Date</label>
                                 <input class="form-control"  type="date" name="to_date" id="to_date" max = "<?php echo $today; ?>"  value="<?php echo date('Y-m-d'); ?>" >
                              </div>
                           </div>
                           <div class="col-6">
                              <div class="col-md-6">
                                  <label  class="form-label">Status</label>

                                    <select name="status" id="status" class="select2 form-control">
                                    <?php echo $status_options; ?>   
                                        
                                    </select>
                                </div>
                           </div>
                           
                           <div class="col-3 align-self-center">
                              <button type="button" class="btn btn-primary rounded-pill waves-effect waves-light" onclick="get_date_filter()">GO</button>
                           </div>
                        </div>
                     </div>
                  </div>
               </div> 
   </div>
</div>

<!----content start---------->

<div class="col-xxl-12">

   <div class="card">
      <div class="card-body">

        <!-- <ul class="nav nav-pills arrow-navtabs  bg-light mb-3" role="tablist">
            <li class="nav-item" >
               <a class="nav-link active" data-bs-toggle="tab" href="#arrow-overview" role="tab">
                  <span class="d-block d-sm-none"><i class="mdi mdi-home-variant"></i></span>
                  <span class="d-none d-sm-block">Tab 1</span>
               </a>
            </li>
           
         </ul>-->
         <!-- Tab panes -->
         <div class="row">
                  <div class="col-12">
                     <div class="">
                        <div class="card-body">
                        <div class="table-responsive">
                           <table id="signed_document_vertification_datatable" class="table table-bordered nowrap table-striped align-middle">
                              <thead>
                                 <tr>

                                    <th>S.No</th>
                                    <th>Po No</th>
                                    <th>Po Date</th>
                                    <th>Consignee</th>
                                    <th>Location</th>
                                    <th>Invoice No</th>
                                    <th>Invoice Date</th>
                                    <th>DC Signed Document</th>
                                    <th>Installation Signed Report</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                   
                                 </tr>
                              </thead>
                              <tbody>
                                 <tr>
                                    <!--<td>01</td>-->
                                    <!--<td>001</td>-->
                                    <!--<td>2023-10-02</td>-->
                                    <!--<td>Ocean Clothes</td>-->
                                    <!--<td>Chennai</td>-->
                                    <!--<td>1000</td>-->
                                    <!--<td>2023-10-02</td>-->
                                    <!--<td><a href="#"><i class="mdi mdi-download-circle-outline"></i> Download</a></td>-->
                                    <!--<td><a href="#"><i class="mdi mdi-download-circle-outline"></i> Download</a></td>-->
                                
                                    <!--<td>-</td>-->

                                    <!--<td>-->
                                    <!--   <a href="index.php?file=signed_document_vertification/create"><i class="mdi mdi-square-edit-outline mdi-24px waves-effect waves-light mt-n2 mb-n2 text-green"></i></a>-->


                                    <!--</td>-->

                                 </tr>

                              </tbody>
                           </table>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <!----content start---------->


          
            <!-- <div class="tab-pane" id="arrow-profile" role="tabpanel">
               <div class="row">
                  <div class="col-12">
                     <div class="">
                        <div class="card-body">
                           <div class="table-responsive" >                       
                              <table id="example" class="table table-bordered nowrap table-striped align-middle">
                              <thead>
                                 <tr>
                                    <th>S.No</th>
                                    <th>Po No</th>
                                    <th>Po Date</th>
                                    <th>Consignee</th>
                                    <th>Location</th>
                                    <th>Invoice No</th>
                                    <th>Invoice Date</th>
                                    <th>PO Attachment</th>
                                    <th>DC Signed Document</th>
                                    <th>Installation Signed Report</th>
                                    <th>PO DC Comparision</th>
                                    <th>PO IR Comparision</th> -->
            <!-- <th>Action</th> -->
            <!-- 
                                 </tr>
                              </thead>
                              <tbody>
                                 <tr>

                                    <td>1</td>
                                    <td>001</td>
                                    <td>2023-10-02</td>
                                    <td>Ocean Clothes</td>
                                    <td>Chennai</td>
                                    <td>1000</td>
                                    <td>2023-10-02</td>
                                    <td><a href="#"><i class="mdi mdi-download-circle-outline"></i> Download</a></td>
                                    <td><a href="#"><i class="mdi mdi-download-circle-outline"></i> Download</a></td>
                                    <td><a href="#"><i class="mdi mdi-download-circle-outline"></i> Download</a></td>
                                    <td>-</td> -->
            <!-- <td><a href="#"><i class="mdi mdi-download-circle-outline"></i> Download</a></td> -->

            <!-- <td>-</td> -->
            <!-- <td>
                                       <a href="http://localhost/elcot/index.php?file=signed_document_vertification/create1"><i class="mdi mdi-square-edit-outline mdi-24px waves-effect waves-light mt-n2 mb-n2 text-green"></i></a>

                                       <i class="mdi mdi-delete  mdi-24px waves-effect waves-light mt-n2 mb-n2 text-danger"></i>
                                    </td> -->
            <!-- 
                                 </tr>

                              </tbody>
                           </table></div>  
                        </div>
                     </div>
                  </div>
               </div>


            </div> -->

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
