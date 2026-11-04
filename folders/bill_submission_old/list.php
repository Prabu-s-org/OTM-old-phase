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

   label {
      font-size: 13px;
   }

   th,
   td {
      font-size: 12px;
   }

   a {
      color: darkblue;
   }

   table.dataTable.nowrap td {
      white-space: unset;
   }

   span.po_date {
      white-space: nowrap;
   }

   #downloadContainer {
      display: inline-block;
      margin-top: 10px;
   }
</style>

</style>
<?php
//   $screen_id = isset($_GET['screen_id']) ? htmlspecialchars($_GET['screen_id']) : '';
$screen_id_val = '641ad9f04e6b343034';
session_start();
$user_type_unique_id = $_SESSION['user_type_unique_id'];
?>
<!-- start page title -->
<div class="row">
   <div class="col-12">
      <div class="page-title-box d-sm-flex align-items-center justify-content-between">
         <h4 class="mb-sm-0">Bill Submission</h4>
         <input type="hidden" id="screen_id_val" name="screen_id_val" class="form-control"
            value="<?php echo $screen_id_val; ?>">
         <input type="hidden" id="user_type_unique_id" name="user_type_unique_id" class="form-control"
            value="<?php echo $user_type_unique_id; ?>">

         <div class="page-title-right">
            <ol class="breadcrumb m-0">
               <li class="breadcrumb-item"><a href="javascript: void(0);">Admin</a></li>
               <li class="breadcrumb-item active">Bill Submission</li>
            </ol>
         </div>

      </div>
      <div>
         <div>
            <button type="button" id="export" name="export"
               class="btn btn-primary  waves-effect waves-light wavw  mb-2 mt-2">
               <i class="ri-file-excel-2-fill"></i>
            </button>
         </div>
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
      </div>
  </div>  -->

   <!----content start---------->



   <div class="row">
      <div class="col-12">

         <div class="card">
            <div class="card">
               <div class="card-body">
                  <div id="list">
                     <div class="table-responsive">
                        <table id="elcot_entry_datatable" class="table table-bordered table-striped align-middle">
                           <thead>
                              <tr>
                                 <th>S.No</th>
                                 <th>Po No</th>
                                 <th>Po Date</th>
                                 <!-- <th>Ledger Name</th> -->
                                 <th>Bill Id</th>
                                 <th>Invoice Count</th>
                                 <th>Invoice No</th>
                                 <th>Bill Value</th>
                                 <th>FrontPage Download Without INST</th>
                                 <th>FrontPage Download With INST</th>
                                 <th>Status</th>
                                 <th>View</th>
                                 <th>Action</th>

                                 <!-- <th>Checkbox</th> -->

                              </tr>
                           </thead>
                           <tbody>
                              <!-- <tr>
                     <td>1</td>
                     <td>1000</td>
                     <td>23-11-2023</td>
                     <td>101</td>
                     <td>4</td>
                     <td>3</td>
                     <td><a href="#"><i class="mdi mdi-download-circle-outline"></i> Download</a></td>
                     <td>Pending</td>
                     <td> <a href="index.php?file=elcot_entry/create"><i class="mdi mdi-square-edit-outline mdi-24px waves-effect waves-light mt-n2 mb-n2 text-green"></i></a>
                                       <i class="mdi mdi-delete  mdi-24px waves-effect waves-light mt-n2 mb-n2 text-danger"></i></td>
                  </tr> -->
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
<!----content start---------->

<script> $("#export").click(function () {
      // alert("hi");
      window.location = "folders/bill_submission/excel.php";
   });



   //       function toggleElcotValue(unique_id) {
   //      var checkbox = document.getElementById('elcot_checkbox_' + unique_id);
   //      var input = document.getElementById('elcot_value_' + unique_id);

   //      // If the checkbox is checked, set the value to 1, else set it to 0
   //      if (checkbox.checked) {
   //          input.value = 1;
   //      } else {
   //          input.value = 0;
   //      }
   //  }
   //    function toggleCheckbox(checkbox) {
   //     const input = document.getElementById('myInput');
   //     const downloadContainer = document.getElementById('downloadContainer');

   //     if (checkbox.checked) {
   //         input.value = '1';
   //         downloadContainer.innerHTML = `<?php echo addslashes($download); ?>`; // Use $download button
   //     } else {
   //         input.value = '0';
   //         downloadContainer.innerHTML = `<?php echo addslashes($download1); ?>`; // Use $download1 button
   //     }
   // }

   function toggleCheckbox(checkbox) {
      const input = document.getElementById('myInput');
      const elcotButton = document.getElementById('downloadElcot');
      const elcot1Button = document.getElementById('downloadElcot1');

      if (checkbox.checked) {
         input.value = '0'; // Update input valuevvi
         elcotButton.style.display = 'inline'; // Show elcot button
         elcot1Button.style.display = 'none'; // Hide elcot1 button
      } else {
         input.value = '1'; // Update input value
         elcotButton.style.display = 'none'; // Hide elcot button
         elcot1Button.style.display = 'inline'; // Show elcot1 button
      }
   }

</script>
