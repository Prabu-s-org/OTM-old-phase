<!-- <div id="consignee_msg"><p style="color:red;font_size:20px;"> <span id="no_of_po_con"></span></p></div> -->
        </div>
<div id="consignee_excel_import" style="position: absolute;" class="modal nobackdrop" tabindex="-1" role="dialog" aria-labelledby="fullWidthModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-full-width">
        <div class="modal-content" style="width: 135%;height: 290px;margin-left: -156px;">
            <div class="modal-header">
                <h4 class="modal-title" id="fullWidthModalLabel">Ticket Creation Import</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group row ">
                                <!-- <div class="col-md-3">
                                    <label class="">Date</label>
                                    <input type="date" class='form-control' name="entry_date" id="entry_date" accept=".xls,.xlsx" value='<?php echo date('Y-m-d'); ?>'>
                                </div> -->

                                <div class="col-md-6">
                                    <label class="">Choose Excel File To Import</label> <input type="file" name="file" id="file" class='form-control' accept=".xls,.xlsx"><br />

                                </div>
                                <div class="col-md-6 align-self-center">
                                    <button type="submit" id="import" name="import" class="btn btn-icon icon-left btn-primary" style="width:100px"><i class="fas fa-file-import"></i>IMPORT </button>
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
   
