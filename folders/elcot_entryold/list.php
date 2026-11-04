  
  <style>
   i.fa.fa-edit{
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
            <h4 class="mb-sm-0">Elcot Entry</h4>

            <div class="page-title-right">
                  <ol class="breadcrumb m-0">
                     <li class="breadcrumb-item"><a href="javascript: void(0);">Admin</a></li>
                     <li class="breadcrumb-item active">Elcot Entry</li>
                  </ol>
            </div>

         </div>
         <div>
             <div>
         <button type="button" id="export" name="export" class="btn btn-primary  waves-effect waves-light wavw  mb-2 mt-2">
         <i class="ri-file-excel-2-fill"></i>
        </button>
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
      </div>
  </div>  -->

  <!----content start---------->


  
  <div class="row">
     <div class="col-12">
        <div class="card">
           <div class="card-body">
                        <div class="table-responsive">
              <table id="elcot_entry_datatable" class="table table-bordered nowrap table-striped align-middle">
                 <thead>
                    <tr>
                       <th>S.no</th>
                       <th>Po No</th>
                       <th>Po Date</th>
                       <th>Bill Id</th>
                       <th>Invoice Count</th>
                       <th>Bill Value</th>
                       <th>Front Page Download</th>
                       <th>Status</th>
                       <th>Action</th>

                    </tr>
                 </thead>
                 <tbody>
                  <!-- <tr>
                     <td>1</td>
                     <td>1000</td>
                     <td>23-11-2023</td>
                     <td>101</td>
                     <td>4</td>
                     <td>3</td>
                     <td><a href="#"><i class="mdi mdi-download-circle-outline"></i> Download</a></td>
                     <td>Pending</td>
                     <td> <a href="index.php?file=elcot_entry/create"><i class="mdi mdi-square-edit-outline mdi-24px waves-effect waves-light mt-n2 mb-n2 text-green"></i></a>
                                       <i class="mdi mdi-delete  mdi-24px waves-effect waves-light mt-n2 mb-n2 text-danger"></i></td>
                  </tr> -->
                 </tbody>
              </table>
              </div>
           </div>
        </div>
     </div>
  </div>
  <!----content start---------->
 

