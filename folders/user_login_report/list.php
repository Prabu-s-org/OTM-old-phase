<?php
$con =  mysqli_connect("localhost", "root", "1KSaldplU_]YsTho", "soft_admin");
if (!$con) {
   die('not connected');
}
$con =  mysqli_query($con, "select MAX(entry_date) AS entry_date from user_login_details where is_delete = 0");
while ($row =  mysqli_fetch_array($con)) {
   $entry_date =  $row['entry_date'];
}
?>
<?php
if (($_SESSION['user_type_unique_id'] == '62c80e9f0914e68331')) { ?>

   <div class="row list-pad">
      <div class="row">
         <div class="col-12">
            <div class="row">
               <div class="col-7">
               </div>
               <div class="col-5 new-add-btn">
                  <a href="index.php"><button type="button" class="btn btn-success waves-effect waves-light flaot-btn"><i class="mdi mdi-step-backward-2"></i>&nbsp;Back</button></a>
               </div>
            </div>
         </div>
      </div>
   </div>
<?php } ?>

<!-- start page title -->
<div class="row">
   <div class="col-12">
      <div class="page-title-box">
         <h4 class="page-title">User Login Report</h4>
         <div>
            <ol class="breadcrumb m-0">
               <li class="breadcrumb-item"><a href="javascript: void(0);">Report</a></li>
               <li class="breadcrumb-item active">User Login Report List</li>
            </ol>
         </div>
      </div>
   </div>
</div>
<!-- end page title -->

<div class="row">
   <div class="col-12">
      <p>
         <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseWidthExample" aria-expanded="false" aria-controls="collapseWidthExample">
            Filter With Date Wise
         </button>
      </p>
      <div>
         <div class="collapse collapse-horizontal" id="collapseWidthExample">
            <div class="card card-body mb-0" style="width: 100%;">
               <div class="row">
                  <div class="col-3">
                     <div class="mb-3">
                        <label for="example-date" class="form-label">From Date</label>
                        <input type="date" class="form-control" id="from_date" name="from_date" value="<?php echo $entry_date; ?>">
                     </div>
                  </div>
                  <div class="col-3">
                     <div class="mb-3">
                        <label for="example-date" class="form-label">To Date</label>
                        <input type="date" class="form-control" id="to_date" name="to_date" value="<?php echo $today; ?>">
                     </div>
                  </div>
                  <div class="col-2 align-self-center">
                     <button type="button" class="btn btn-primary rounded-pill waves-effect waves-light" onclick="user_login_filter();">Go</button>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="col-5 new-add-btn">
   </div>
</div>

<!----content start---------->
<div class="row">
   <div class="col-12">
      <div class="card">
         <div class="card-body">
            <table id="user_login_report_datatable" class="table table-striped dt-responsive nowrap w-100">
               <thead>
                  <tr>
                     <th>S.No</th>
                     <th>User Name</th>
                     <th>Login Date</th>
                     <th>Login Time</th>
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
