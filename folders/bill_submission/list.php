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

   .field-group {
      display: flex;
      align-items: center;
      margin-bottom: 10px;
   }

   .label-col {
      width: 150px;
      font-weight: 500;
      font-size: 15px;
   }

   .colon-col {
      width: 10px;
   }

   .value-col {
      flex: 1;
   }

   span.text-right {
      text-align: right;
   }
</style>
<?php
//   $screen_id = isset($_GET['screen_id']) ? htmlspecialchars($_GET['screen_id']) : '';
$screen_id_val = '67e241701c60864962';
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
            <!-- <button type="button" id="export" name="export"
               class="btn btn-primary  waves-effect waves-light wavw  mb-2 mt-2">
               <i class="ri-file-excel-2-fill"></i>
            </button> -->
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
                        <table id="bill_submission_datatable" class="table table-bordered table-striped align-middle">
                           <thead>
                              <tr>
                                 <th rowspan="2">S.No</th>
                                 <th rowspan="2">Po No</th>
                                 <th rowspan="2">Bill Id</th>
                                 <th rowspan="2">Invoice Count</th>
                                 <th rowspan="2">Claim Percent(%)</th>
                                 <th rowspan="2">Claim Value</th>

                                 <th rowspan="2">Bill Value</th>
                                 <th colspan="2" class="text-center">FrontPage Download</th>
                                 <th rowspan="2">Status</th>
                                 <th rowspan="2">Bill Submission Date</th>
                                 <th rowspan="2">E No</th>
                                 <th rowspan="2">Action</th>
                              </tr>
                              <tr>
                                 <th>Without INST</th>
                                 <th>With INST</th>
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


<!-- Column Visibility Modal -->
<div id="columnVisibilityModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg"> <!-- Center the modal and make it large -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Select Columns to Display</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="columnVisibilityForm">
                    <!-- Dynamically populated checkboxes will go here -->
                    <div class="row">
                        <!-- Each column will have a checkbox -->
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveColumnVisibility">Save Changes</button>
            </div>
        </div>
    </div>
</div>

<!----content start---------->

<script> $("#export").click(function () {
      // alert("hi");
      window.location = "folders/bill_submission/excel.php";
   });



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
