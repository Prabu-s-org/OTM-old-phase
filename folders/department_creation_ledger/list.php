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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <?php
//  $screen_id = isset($_GET['screen_id']) ? htmlspecialchars($_GET['screen_id']) : '';
$screen_id_val='62b589f107c8270227';
// print_r($screen_id);
   session_start();
  $user_type_unique_id = $_SESSION['user_type_unique_id'];
  ?>
  
  <!-- start page title -->
  <div class="row">
      <div class="col-12">
         <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">List Department Creation</h4>
            <input type="hidden" id="screen_id_val" name="screen_id_val" class="form-control" value="<?php echo $screen_id_val;?>">
            <input type="hidden" id="user_type_unique_id" name="user_type_unique_id" class="form-control" value="<?php echo $user_type_unique_id;?>">

            <div class="page-title-right">
                  <ol class="breadcrumb m-0">
                     <li class="breadcrumb-item"><a href="javascript: void(0);">Admin</a></li>
                     <li class="breadcrumb-item active">Department Creation</li>
                  </ol>
            </div>

         </div>
      </div>   
  </div>
  <!-- end page title -->
  <div class="row">
     <div class="col-7">
       
     </div>
     <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-3">
          <?php echo btn_add($btn_add); ?>
      </div>
  </div>
  <!----content start---------->
  <div class="row" id="list">
     <div class="col-12">
        <div class="card">
           <div class="card-body">
               <div class="table-responsive">
              <table id="department_creation_datatable" class="table table-bordered nowrap table-striped align-middle">
                 <thead>
                    <tr>
                       <th>#</th>
                       <th>Department</th>
                       <th>Description</th>
                       <!-- <th>Ledger Name</th>
                       <th>Ledger No</th> -->
                       <th>Active Status</th>
                       <th>Action</th>
                    </tr>
                 </thead>
                 <tbody>
                  <!-- <tr>
                     <td>1</td>
                     <td>tamilnadu</td>
                     <td>erode</td>
                     <td>active</td>
                     <td><i class="fa fa-edit"></i><i class="fa-sharp fa-solid fa-trash"></i></td>
                  </tr> -->
                 </tbody>
              </table>
              </div>
           </div>
        </div>
     </div>
  </div>
  <!----content start---------->
