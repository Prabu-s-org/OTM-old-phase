<!-- <div id="consignee_msg"><p style="color:red;font_size:20px;"> <span id="no_of_po_con"></span></p></div> -->
        </div>
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
                                        <option value="1">Verified</option>
                                        <option value="2">Not Verified</option>

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
    
    
    
    
   
