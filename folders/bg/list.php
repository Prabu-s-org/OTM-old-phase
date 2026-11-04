<style>
   i.fa.fa-edit {
      font-size: 20px;
      color: green;
   }

   i.fa-sharp.fa-solid.fa-trash {
      font-size: 20px;
      color: green;
   }
   table.dataTable thead tr th{
        text-align:center !important;
    }

   button#export {
      float: right;
      padding: 5px 10px;
   }

   #btn {
      margin-left: 89%;

   }

   table.dataTable.nowrap td {
      white-space: unset;
   }
     span.text-right {
    text-align: right;
}
span.d-block {
    display: block;
}

table th{
   text-align: center !important;
}

   <?php
   //  $screen_id = isset($_GET['screen_id']) ? htmlspecialchars($_GET['screen_id']) : '';
   $screen_id_val = '6826cf53085ed59701';

   // print_r($screen_id);
   session_start();
   $user_type_unique_id = $_SESSION['user_type_unique_id'];
   ?>
</style>
<!-- Layout config Js -->
<script src="assets/js/layout.js"></script>
<!-- Bootstrap Css -->
<link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<!-- Icons Css -->
<link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
<!-- App Css-->
<link href="assets/css/app.min.css" rel="stylesheet" type="text/css" />
<!-- custom Css-->
<link href="assets/css/custom.min.css" rel="stylesheet" type="text/css" />


<!-- start page title -->
<div class="row">
   <div class="col-12">
      <div class="page-title-box d-sm-flex align-items-center justify-content-between">
         <h4 class="mb-sm-0">BG</h4>
         <input type="hidden" id="screen_id_val" name="screen_id_val" class="form-control"
            value="<?php echo $screen_id_val; ?>">
         <input type="hidden" id="user_type_unique_id" name="user_type_unique_id" class="form-control"
            value="<?php echo $user_type_unique_id; ?>">

         <div class="page-title-right">
            <ol class="breadcrumb m-0">
               <li class="breadcrumb-item"><a href="javascript: void(0);">Admin</a></li>
               <li class="breadcrumb-item active">BG</li>
            </ol>
         </div>

      </div>
      <div>
         <!-- <button type="button" id="export" name="export"
            class="btn btn-primary  waves-effect waves-light wavw  mb-2 mt-2">
            <i class="ri-file-excel-2-fill"></i>
         </button> -->
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
      </div> -->
</div>

<!----content start---------->

<?php
$status_options = [
   [
      "id" => '0',
      "value" => "Pending"
   ],
   [
      "id" => '1',
      "value" => "Complete"
   ]
];

$status_options = select_option($status_options);

?>

<div class="col-xxl-12">

   <div class="card">
      <div class="card-body">

         <ul class="nav nav-pills arrow-navtabs  bg-light mb-3" role="tablist">
            <li class="nav-item">
               <a class="nav-link active" data-bs-toggle="tab" href="#arrow-overview" role="tab">
                  <span class="d-block d-sm-none"><i class="mdi mdi-home-variant"></i></span>
                  <span class="d-none d-sm-block">BG Select</span>
               </a>
            </li>
            <li class="nav-item">
               <a class="nav-link" data-bs-toggle="tab" href="#arrow-profile" role="tab">
                  <span class="d-block d-sm-none"><i class="mdi mdi-account"></i></span>
                  <span class="d-none d-sm-block">BG Update</span>
               </a>
            </li>

         </ul>
         <!-- Tab panes -->
         <div class="tab-content">
            <div class="tab-pane active" id="arrow-overview" role="tabpanel">
               <div class="row">
                  <!-- <p>
                  <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseWidthExample"
                     aria-expanded="false" aria-controls="collapseWidthExample">
                  Filter
                  </button>
               </p> -->
                  <!-- <div >
                  <div class="collapse collapse-horizontal" id="collapseWidthExample">
                     <div class="card card-body mb-0" style="width: 100%;">
                        <div class="row">
                           <div class="col-5">
                              <div class="mb-3">
                                 <label for="example-date" class="form-label">Status</label>
                                    <select name="status" id="status" class="select2 form-control">
                                        <option value="0" selected>Pending</option>
                                        <option value="1">Complete</option>
                                    </select>
                              </div>
                           </div>
                           <div class="col-2 align-self-center">
                              <button type="button" class="btn btn-primary rounded-pill waves-effect waves-light" onclick="get_filter()">GO</button>
                           </div>
                        </div>
                     </div>
                  </div>
               </div> -->
                  <div class="col-12">
                     <div id="add_btn">
                        <a href="index.php?file=bg/create">
                           <button type="button" id="btn" class="btn btn-info waves-effect waves-light">Create
                              BG</button></a>
                     </div>
                     <div class="">
                        <div class="card-body">
                           <div id="list">
                              <div class="table-responsive">
                                 <table id="bg_datatable" class="table table-bordered  table-striped align-middle">
                                    <thead>
                                       <tr>

                                          <th style="text-align: center;">S.No</th>
                                          <th>Po No </th>
                                         <th>Invoice No </th>
                                          <th>Customer Name</th>
                                          <th>DC Count</th>
                                          <th>Product Count</th>
                                          <!-- <th>Consignee</th> -->
                                          <!-- <th>Location</th> -->
                                          <!-- <th>Invoice No</th> -->
                                          <!-- <th>Invoice Date</th> -->
                                          <!-- <th>Primary Product as per BG</th> -->
                                          <th>Invoice Qty</th>
                                          <th>Invoice Value</th>
                                          <!-- <th>DC Number</th> -->
                                          <!-- <th>DC Date</th> -->
                                          <th>Bg Month</th>
                                          <th>BG %</th>
                                          <th>Status</th>
                                          <th>Action</th>
                                          <!--<th>Tick</th>-->
                                       </tr>
                                    </thead>
                                    <tbody>
                                       <tr>
                                       </tr>

                                    </tbody>

                                 </table>

                              </div>
                           </div>


                        </div>
                     </div>


                  </div>


               </div>
               <!----content start---------->

            </div>



            <div class="tab-pane" id="arrow-profile" role="tabpanel">
               <div class="row">
                  <div class="col-12">
                     <div class="">
                        <div class="card-body">
                           <div id="list_1">
                              <div class="table-responsive">
                                 <table id="bg_update_datatable"
                                    class="table table-bordered table-striped align-middle">
                                    <thead>
                                       <tr>
                                          <th style="text-align: center;">S.No</th>
                                          <th style="text-align: center;">Po No </th>
                                          <th style="text-align: center;">BG Id</th>
                                          <th style="text-align: center;">Customer Name</th>
                                          <th style="text-align: center;">Dc Count</th>
                                          <th style="text-align: center;">Invoice Count</th>
                                          <th style="text-align: center;">Total Invoice Value Againt BG</th>
                                           <th style="text-align: center;">BG Month</th>
                                          <th style="text-align: center;">BG %</th>
                                          <th style="text-align: center;">BG Value</th>
                                          <th style="text-align: center;">Status</th>
                                          <th style="text-align: center;">Action</th>
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
               <!----content start---------->


            </div>

         </div>
      </div><!-- end card-body -->
   </div><!-- end card -->
</div>
<!--end col-->
<!--end row-->


<!-- Page content Ends Here -->

</div>
</div>
</div>
<script>
   $("#export").click(function () {
      window.location = "folders/bg/excel.php";
   });

</script>
