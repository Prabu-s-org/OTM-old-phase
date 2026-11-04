<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Dashboard</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<!-- end page title -->

<div class="row mt-2 po-class">
      <div class="col-md-9"></div>
      
     <div class="col-md-3 mb-1 d-grid gap-2 d-md-flex justify-content-md-end btn-green ">
       
        <div class="">
        <!-- <button type="button" id="export" name="export" class="btn btn-primary  waves-effect waves-light wavw  mb-1">
         <i class="ri-file-excel-2-fill"></i>
        </button> -->
     </div>
     </div>
     
  </div>
  <script>
    
  $("#export").click(function(){
    //     alert();
    // alert("hi");
    window.location="folders/dashboard/excel.php";
    });
  </script>
