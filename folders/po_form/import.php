<!-- <div id="consignee_msg"><p style="color:red;font_size:20px;"> <span id="no_of_po_con"></span></p></div> -->
        </div>

 <?php
 $session_id = $_SESSION['user_type_unique_id'];

 ?>
<div id="consignee_excel_import" style="position: absolute;" class="modal nobackdrop" tabindex="-1" role="dialog" aria-labelledby="fullWidthModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-full-width">
        <div class="modal-content" style="width: 135%;height: 290px;margin-left: -156px;">
            <div class="modal-header">
                <h4 class="modal-title" id="fullWidthModalLabel">Consignee Creation Import</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group row ">
                                <div class="col-6">
                                    <label class="">Choose Excel File To Import</label>
                                     <input type="file" name="file" id="file" class='form-control' accept=".xls,.xlsx"><br/>

                                </div>
                                
                                 <div class="col-md-4">
                                    <label class="">Verfication Status</label>
                                    <select class="form-control" name="cons_verfiy_sts" id="cons_verfiy_sts">
                                        <!--<option value="">Select Status</option>-->

                                       <!-- <option value="">Select </option> -->
                                                            <?php if($session_id =='65deef78ba17d65741') {?>
                                                                <option value="1">Verified</option>
                                                                    <option value="2">Not Verified</option>
                                                            <?php }else{ ?>
                                                                     <option value="2">Not Verified</option>
                                                                <?php }?>
                                                                </select>
                                </div>

                                <div class="col-md-4 align-self-center">
                                    <button type="submit" id="con_import_data" name="con_import_data" class="btn btn-icon icon-left btn-primary" style="width:100px"><i class="fas fa-file-import"></i>IMPORT </button>
                                </div>
                            </div>
                        </div>
                    </div>
              
            </div>
            <div class="modal-footer">
                <a href="javascript:modal_close()"><button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button></a>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
    <style>
    #uploadErrorBox {
        margin-top: 15px;
    text-align: left;
    /* max-width: 100%; */
    margin-left: 153px;
    width: 124%;
    position: relative;
}

    </style>
    <!-- Bootstrap CSS -->
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->
<!-- jQuery -->
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
<!-- Bootstrap JS -->
<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->
 <!-- jQuery -->
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->

 <!-- <script src="assets/datatable_new/jquery-3.7.0.min.js"></script>  -->

<!-- Bootstrap CSS and JS (for modal) -->
<!-- <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->
<!-- Bootstrap 5.3.3 CSS -->
<!-- Bootstrap 5.3.3 (Verified SRI hashes as of June 2025) -->
<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> -->
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script> -->
        <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>



<!-- new changes 10-06-25 -->

<!-- XLSX.js (for exporting to Excel) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.3/xlsx.full.min.js"></script>
   <!-- Invalid Districts Modal -->
<div class="modal fade" id="districtModal" tabindex="-1" role="dialog" aria-labelledby="districtModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title" id="districtModalLabel">Invalid Districts Found</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered table-sm" style="background-color: #fff0f0;">
          <thead class="table-danger">
            <tr>
              <th>#</th>
              <th>Row</th>
              <th>Invalid District</th>
              <th>State</th>
              <th>Remarks</th>
            </tr>
          </thead>
          <tbody id="districtModalTableBody">
            <!-- Rows will be inserted here by JS -->
          </tbody>
        </table>
        <button type="button" class="btn btn-primary" id="exportExcelBtn">Export to Excel</button>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

    
    
    
   
