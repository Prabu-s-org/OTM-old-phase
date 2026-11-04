  
  <style>
   i.fa.fa-edit{
      font-size: 20px;
    color: green;
   }
   i.fa-sharp.fa-solid.fa-trash {
   font-size: 20px;
    color: green;
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
     <div class="col-12">
        <div class="card">
           <div class="card-body">
              <table id="state_creation_datatable" class="table table-bordered nowrap table-striped align-middle">
                 <thead>
                    <tr>
                       <th>#</th>
                       <th>PO No</th>
                       <th>PO Date</th>
                       <th>Consignee</th>
                       <th>Location</th>
                       <th>Invoice No</th>
                       <th>PO Attachment</th>
                       <th>DC/IR Attachment</th>
                       <th>Comparision Attachment</th>
                       <th>Approval</th>
                       <th>Active Status</th>
                       <th>Action</th>
                    </tr>
                 </thead>
                 <tbody>
               <tr>
                     <td>1</td>
                     <td>100</td>
                     <td>25-10-23</td>
                     <td>Ocean Clothes</td>
                     <td>chennai</td>
                     <td>1002</td>
                     <td>.</td>
                     <td>.</td>
                     <td>.</td>
                     <td>Approval</td>
                     <td>active</td>
                     <td><a href="http://localhost/elcot/index.php?file=doc_apporval/create"><i class="mdi mdi-square-edit-outline mdi-24px waves-effect waves-light mt-n2 mb-n2 text-green"></i>
                     <i class="mdi mdi-delete  mdi-24px waves-effect waves-light mt-n2 mb-n2 text-danger"></i></td>
                  </tr> 
                 </tbody>
              </table>
           </div>
        </div>
     </div>
  </div>
  <!----content start---------->
