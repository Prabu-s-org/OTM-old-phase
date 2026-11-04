<style>
   i.fa.fa-edit {
      font-size: 20px;
      color: green;
   }
   i.fa-sharp.fa-solid.fa-trash {
      font-size: 20px;
      color: green;
   }
   /* button#export {
      float: right;
      padding: 5px 10px;
   } */
   table.dataTable.nowrap td {
      white-space: unset;
   }
   button#export {
    float: right;
    padding: 5px 10px;
}
</style>
<?php
  date_default_timezone_set('Your/Timezone');

 // Get the current day, date, and time
$currentDateTime = date('l - d.m.Y h:i:A');
?>
<!-- start page title -->
<div class="row">
   <div class="col-12">
      <div class="page-title-box d-sm-flex align-items-center justify-content-between">
         <h4 class="mb-sm-0">Overall Excel</h4>
         <div class="page-title-right">
            <ol class="breadcrumb m-0">
               <li class="breadcrumb-item"><a href="javascript: void(0);">Reports</a></li>
               <li class="breadcrumb-item active">Overall Excel</li>
            </ol>
         </div>
      </div>
      <div>
         <div class="mb-4 mt-4">
         </div>
         <!-- <button type="button" id="export" name="export" class="btn btn-primary  waves-effect waves-light wavw  mb-2 mt-2">
         <i class="ri-file-excel-2-fill"></i>
        </button> -->
      </div>
   </div>
</div>
<div class="card">
   <div class="card-body">
      <div class="row">
         <div class="col-6">
            <label>
               <h3>   Overall Excel Download           </h3>
            </label>   
           
         </div>
         <!--end row-->
      </div>
      <br>
      <br>
      <div class="row">
         <div class="col-12" style="text-align:center;">
            <label>
          <h2><?php echo $currentDateTime; ?><h2>
            </label>   
           
         </div>
         <!--end row-->
      </div>
      <br>
      <br>
       <!-- <i id="export" name="export" class="mdi mdi-download-circle-outlixne"></i> Download -->
       <img src="uploads/excel.png" id="export" name="export" style="width:300px; margin-left: 450px;"><br><br><br>
       <h2 style="width:300px; margin-left: 450px;">Excel Download Here</h2>
            <!-- <button type="button" id="export" name="export" class="btn btn-primary  waves-effect waves-light wavw  mb-2 mt-2"> </button>-->
            <!--end col-->
      
         <!--end row-->
      
   </div>
</div>
<script>
   $("#export").click(function() {
      // alert("hi");
      window.location = "folders/reports/excel.php";
   });
</script>
