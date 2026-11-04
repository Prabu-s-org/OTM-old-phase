  <style>
     i.fa.fa-edit {
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
           <h4 class="mb-sm-0">List Product Category</h4>

           <div class="page-title-right">
              <ol class="breadcrumb m-0">
                 <li class="breadcrumb-item"><a href="javascript: void(0);">Admin</a></li>
                 <li class="breadcrumb-item active">Product Category</li>
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



  <div class="row">
     <div class="col-12">
        <div class="card">
           <div class="card-body">
              <div class="table-responsive">
                 <table id="state_creation_datatable" class="table table-bordered nowrap table-striped align-middle">
                    <thead>
                       <tr>
                          <th>#</th>
                          <th>Main Category </th>
                          <th>Product Category </th>
                          <th>Description</th>
                          <th>Active Status</th>
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
