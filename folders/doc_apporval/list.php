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

  <!-- start page title -->
  <div class="row">
     <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
           <h4 class="mb-sm-0"> DOCs Approval </h4>

           <div class="page-title-right">
              <ol class="breadcrumb m-0">
                 <li class="breadcrumb-item"><a href="javascript: void(0);">Admin</a></li>
                 <li class="breadcrumb-item active">DOCs Approval</li>
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
     <div class="col-7">
        <!-- <p>
                  <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseWidthExample"
                     aria-expanded="false" aria-controls="collapseWidthExample">
                  Filter With Date Wise
                  </button>
               </p>
               <div >
                  <div class="collapse collapse-horizontal" id="collapseWidthExample">
                     <div class="card card-body mb-0" style="width: 100%;">
                        <div class="row">
                           <div class="col-5">
                              <div class="mb-3">
                                 <label for="example-date" class="form-label">From Date</label>
                                 <input class="form-control" id="example-date" type="date" name="date">
                              </div>
                           </div>
                           <div class="col-5">
                              <div class="mb-3">
                                 <label for="example-date" class="form-label">To Date</label>
                                 <input class="form-control" id="example-date" type="date" name="date">
                              </div>
                           </div>
                           <div class="col-2 align-self-center">
                              <button type="button" class="btn btn-primary rounded-pill waves-effect waves-light">Primary</button>
                           </div>
                        </div>
                     </div>
                  </div>
               </div> -->
     </div>
     <!-- <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-3">
          <?php echo btn_add($btn_add); ?>
      </div> -->
  </div>

  <!----content start---------->



  <div class="row">
     <div class="col-xl-12">
        <div class="card">
           <div class="card-body">
              <div class="table-responsive">
                 <table id="docs_approval_list_datatable" class="table table-bordered nowrap table-striped align-middle">
                    <thead>
                       <tr>
                          <th>ID</th>
                          <th>PO No</th>
                          <th>PO Date</th>
                          <th>Consignee</th>
                          <th>Location</th>
                          <th>Invoice No</th>
                          <th>Invoice Date</th>
                          <th>PO Attachment</th>
                          <th>DC Attachment</th>
                          <th>IR Attachment</th>
                          <th>Invoice Attachment</th>
                          <th>Comparision Attachment</th>
                          <th>Status</th>
                          <th>Approved by</th>
                          <th>Action</th>
                       </tr>
                    </thead>
                    <tbody>
                       <tr>
                          <!--<td>1</td>-->
                          <!--<td>100</td>-->
                          <!--<td>25-10-23</td>-->
                          <!--<td>Ocean Clothes</td>-->
                          <!--<td>chennai</td>-->
                          <!--<td>1002</td>-->
                          <!--<td><a href="uploads/pdf1.pdf"><img src="uploads/pdf-img.png"  height="50px" width="50px" ></a></td>-->
                          <!--<td><a href="uploads/pdf1.pdf"><img src="uploads/pdf-img.png"  height="50px" width="50px" ></a></td>-->
                          <!--<td><a href="uploads/pdf1.pdf"><img src="uploads/pdf-img.png"  height="50px" width="50px" ></a></td>-->
                          <!--<td><a href="uploads/pdf1.pdf"><img src="uploads/pdf-img.png"  height="50px" width="50px" ></a></td>-->
                          <!--<td><img id="myImg1" src="assets\images\images.png" style="width:50%;max-width:60px">-->
                          <!--   <div id="myModal1" class="modal">-->
                          <!--      <span class="close">X</span>-->
                          <!--      <img class="modal-content" id="img02">-->

                          <!--   </div>-->
                          <!--</td>-->
                          <!--<td>Approved</td>-->
                          <!--<td>Name</td>-->
                          <!--<td>-->
                          <!--   <a href="index.php?file=doc_apporval/create"><i class="mdi mdi-square-edit-outline mdi-24px waves-effect waves-light mt-n2 mb-n2 text-green"></i></a>-->
                             <!-- <i class="mdi mdi-square-edit-outline mdi-24px waves-effect waves-light mt-n2 mb-n2 text-green" ><?php echo btn_add($btn_add); ?></i> -->
                          <!--   <i class="mdi mdi-delete  mdi-24px waves-effect waves-light mt-n2 mb-n2 text-danger"></i>-->
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
  

<div class="modal fade bs-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title w-100 text-center" id="myExtraLargeModalLabel">PO & DC 
Comparison Attachment </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                
                <div class="row mt-2">
                   <div class="col-md-6">
                       <h4 class="text-center">PO Attachment</h4>
<object
        data='https://pdfjs-express.s3-us-west-2.amazonaws.com/docs/choosing-a-pdf-viewer.pdf'
        type="application/pdf"
        width="100%"
        height="400"
      >

        <iframe
          src='https://pdfjs-express.s3-us-west-2.amazonaws.com/docs/choosing-a-pdf-viewer.pdf'
          width="100%"
          height="400"
        >
        
        </iframe>
      </object>

                   </div>
                                       <div class="col-md-6">
                                            <h4 class="text-center">DC Attachment</h4>
<object
        data='https://pdfjs-express.s3-us-west-2.amazonaws.com/docs/choosing-a-pdf-viewer.pdf'
        type="application/pdf"
        width="100%"
        height="400"
      >

        <iframe
          src='https://pdfjs-express.s3-us-west-2.amazonaws.com/docs/choosing-a-pdf-viewer.pdf'
          width="100%"
          height="400"
        >
        
        </iframe>
      </object>

                   </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="javascript:void(0);" class="btn btn-link link-success fw-medium" data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i> Close</a>
                <button type="button" class="btn btn-primary ">Save changes</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
