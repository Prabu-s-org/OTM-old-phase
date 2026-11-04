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
           <h4 class="mb-sm-0"> PO List</h4>


           <div class="page-title-right">
              <ol class="breadcrumb m-0">
                 <li class="breadcrumb-item"><a href="javascript: void(0);">Settings</a></li>
                 <li class="breadcrumb-item active"> PO List</li>
              </ol>
           </div>

        </div>
     </div>
  </div>


  <!-- end page title -->
  <div class="row mt-2 po-class">
      <div class="col-md-9"></div>
      
     <div class="col-md-3 mb-1 d-grid gap-2 d-md-flex justify-content-md-end btn-green ">
        <?php echo btn_add($btn_add); ?>
        <div class="">
        <button type="button" id="export" name="export" class="btn btn-primary  waves-effect waves-light wavw  mb-1">
         <i class="ri-file-excel-2-fill"></i>
        </button>
     </div>
     </div>
     
  </div>

  <!----content start---------->
  <div class="row">
     <div class="col-12">
        <div class="card">
           <div class="card-body">
          <div class="table-responsive" > 
              <table id="po_form_datatable" class="table table-bordered nowrap table-striped align-middle">
                 <thead>
                    <tr>
                       <th>ID</th>
                       <th>PO Number </th>
                       <th>PO Date </th>
                       <th>Department </th>
                       <th>Customer GST Number </th>
                       <th>Executive Name</th>
                       <th>Action</th>
                    </tr>
                 </thead>
                 <tbody>
                    <!-- <tr>
                       <td>01</td>
                       <td>ELT-001 </td>
                       <td>30-10-2023</td>
                       <td>IT</td>
                       <td>24AAACV1559Q1ZW </td>
                       <td>Mr.RameshKumar</td>
                       <td>
                          <a href="#"><i class="mdi mdi-square-edit-outline mdi-24px waves-effect waves-light mt-n2 mb-n2 text-green"></i>
                             <i class="mdi mdi-delete  mdi-24px waves-effect waves-light mt-n2 mb-n2 text-danger"></i></a>
                       </td>



                    </tr> -->

                 </tbody>
              </table>
            </div>
           </div>
        </div>
     </div>
  </div>
  <!----content start---------->
  
  <script>
      $("#export").click(function(){
    // alert("hi");
    window.location="folders/po_form/excel.php";
    });
  </script>
