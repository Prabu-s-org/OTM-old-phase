  <!-- start page title -->

  <!-- <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script> -->
  <?php 
//   $screen_id = isset($_GET['screen_id']) ? htmlspecialchars($_GET['screen_id']) : '';
$screen_id_val ='62b55dce1478a35967';
   session_start();
  $user_type_unique_id = $_SESSION['user_type_unique_id'];
  ?>
  <div class="row">
      <div class="col-12">
         <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">List User Creations</h4>
            <input type="hidden" id="screen_id_val" name="screen_id_val" class="form-control" value="<?php echo $screen_id_val;?>">
            <input type="hidden" id="user_type_unique_id" name="user_type_unique_id" class="form-control" value="<?php echo $user_type_unique_id;?>">

            <div class="page-title-right">
                  <ol class="breadcrumb m-0">
                     <li class="breadcrumb-item"><a href="javascript: void(0);">Admin</a></li>
                     <li class="breadcrumb-item active">User Creations</li>
                  </ol>
            </div>

         </div>
      </div>   
  </div>    
    <!-- end page title --> 
    <div class="row">
            <!-- <div class="col-1"> -->
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
          
         </div>
         <!----content start---------->
         <div class="row" id="list">
            <div class="col-12">
               <div class="card">
                  <div class="card-body">
                      <div class="table-responsive"><div class="text-end pb-3 "><?php echo btn_add($btn_add); ?></div>
                     <table id="user_datatable" class="table table-bordered nowrap table-striped align-middle">
                        <thead>
                           <tr>
                           <th>#</th>
                            <th>Staff Name</th>
                            <th>Phone No.</th>
                            <th>User Name</th>
                            <th>User Type</th>
                            <!-- <th>Password</th> -->
                            <th>Active/In active</th>
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
         </div>
         <!----content start---------->
