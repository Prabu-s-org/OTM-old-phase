  <!-- start page title -->   
    <div class="row">
      <div class="col-12">
         <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">List User Type Permissions</h4>

            <div class="page-title-right">
                  <ol class="breadcrumb m-0">
                     <li class="breadcrumb-item"><a href="javascript: void(0);">Admin</a></li>
                     <li class="breadcrumb-item active">User Type Permissions</li>
                  </ol>
            </div>

         </div>
      </div>   
  </div> 
    <!-- end page title --> 
    <div class="row">
            <!-- <div class="col-7"> -->
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
            <!-- </div> -->
            <div class="col-12 new-add-btn" style="margin-left: 88%;padding: 6px;">
               <?php echo btn_add($btn_add); ?>
            </div>
         </div>
         <!----content start---------->
         <div class="row">
            <div class="col-12">
               <div class="card">
                  <div class="card-body">
                     <table id="user_permission_datatable" class="table table-striped dt-responsive nowrap w-100">
                        <thead>
                           <tr>
                           <th>#</th>
                            <th>User Type</th>
                            <th>Action</th>
                           </tr>
                        </thead>
                        <tbody>
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>
         <!----content start---------->
