<style>
.btns{
   float: right;
    margin-top: -10px;
}
</style>

<!--<div class="content-page">-->
    <!--<div class="content">-->

        <!-- Start Content-->
        <!--<div class="container-fluid">-->

            <!-- start page title -->
              <?php
//  $screen_id = isset($_GET['screen_id']) ? htmlspecialchars($_GET['screen_id']) : '';
$screen_id_val='62b55dfaa7dd768918';
   session_start();
  $user_type_unique_id = $_SESSION['user_type_unique_id'];
  ?>
           <div class="row">
      <div class="col-12">
         <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">List User Type Permission</h4>
            <input type="hidden" id="screen_id_val" name="screen_id_val" class="form-control" value="<?php echo $screen_id_val;?>">
            <input type="hidden" id="user_type_unique_id" name="user_type_unique_id" class="form-control" value="<?php echo $user_type_unique_id;?>">

            <div class="page-title-right">
                  <ol class="breadcrumb m-0">
                     <li class="breadcrumb-item"><a href="javascript: void(0);">Admin</a></li>
                     <li class="breadcrumb-item active">User Type Permission</li>
                  </ol>
            </div>

         </div>
      </div>   
  </div>
            <!-- end page title -->

            <div class="row" id="list">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive"><div class="text-end pb-3 "><?php echo btn_add($btn_add); ?></div>
                            <table id="user_permission_datatable" class="table table-bordered nowrap table-striped align-middle">
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
            </div>


        </div>
    </div>
</div>
