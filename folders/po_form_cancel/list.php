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
table.dataTable.nowrap td {
    white-space: unset;
}
span.po_date {
    white-space: nowrap;
}
span.invoice_date {
    white-space: nowrap;
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
<div class="row mt-2 po-class">
  <div class="col-md-4">

<div class="input-group">
   <!-- value="<?php echo date('Y-m'); ?>" -->
<input type="month" id="month_fill" name="month_fill" class="form-control">
                                    <!-- <input class="form-control" id="month_fill" type="month" name="month" value="2024-05"> -->
                                    <!-- <input type="date" value="03" class="form-control form-control-light" > -->
                                    <!-- <input type="text" class="form-control form-control-light" id="dash-daterange">  -->
                                    <!-- <span class="input-group-text thme-colo  border-primary text-white"> -->
                                    <!-- <i class="mdi mdi-calendar-range font-13"></i> -->
                                    <!-- <button type="button" id="date_filter" name="date_filter" class="input-group-text thme-colo  border-primary text-white">GO</button> -->
                                    <button type="button" id="date_filter" name="date_filter" class="input-group-text thme-colo btn btn-primary border-primary text-white" 
                                     onclick="get_data_month()"
                                    >GO</button>
                                </div>
</div>

<div class="col-md-5"></div>
      
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
<div class="col-xxl-12">
    <div class="card">
        <div class="card-body">
            <ul class="nav nav-pills arrow-navtabs  bg-light mb-3" role="tablist">
                <li class="nav-item" >
                    <!--onclick="dispatch_pending()"-->
                    <a class="nav-link active" data-bs-toggle="tab" href="#arrow-overview" role="tab">
                        <span class="d-block d-sm-none"><i class="mdi mdi-home-variant"></i></span>
                        <span class="d-none d-sm-block">Po List</span>
                    </a>
                </li>
                <li class="nav-item" >
                   
                    <a class="nav-link" data-bs-toggle="tab" href="#arrow-profile" role="tab">
                        <span class="d-block d-sm-none"><i class="mdi mdi-account"></i></span>
                        <span class="d-none d-sm-block">Po Cancel List</span>
                    </a>
                </li>
               
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane active" id="arrow-overview" role="tabpanel">
                    <div class="row">
                        <div class="col-12">
                            <div class="">
                                <div class="card-body">
                                <div class="row align-items-end">
               <div class="col-md-3">
                  <div class="mb-3">
                     <label class="form-label from-date-label">From Date</label>
                     <input type="date" class="form-control" id="from_date" name="from_date">
                   
                  </div>
               </div>
               <div class="col-md-3">
                  <div class="mb-3">
                     <label class="form-label from-date-label">To Date</label>
                     <input type="date" class="form-control" id="to_date" name="to_date">
                  </div>
               </div>

               <div class="col-md-1">
                  <div class="mb-3">

                     <button type="button" class="btn btn-primary btn-lg" onclick="get_data()">Go</button>
                  </div>
               </div>
            </div>
                                    <div class="table-responsive">
                                    <table id="po_form_datatable" class="table table-bordered table-striped align-middle">
                                        <thead>
                                        <tr>
                                       <th>S.No</th>
                                       <th>PO Number </th>
                                       <th>PO Date </th>
                                       <th>Department </th>
                                       <th>Customer GST Number </th>
                                       <th>Executive Name</th>
                                       <th>PO Total Value</th>
                                       <th>PO Attachment</th>
                                       <th>PO Cancel</th>
                                       <th>Action</th>
                                       
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
                    <!----content start---------->
                    <!--  Extra Large modal example -->
                 </div>
                <!-- fixed-header  -->
                <div class="tab-pane" id="arrow-profile" role="tabpanel">
                    <div class="row">
                        <div class="col-12">
                            <div class="">
                                <div class="card-body">
                                <!-- <button type="button" id="export2" name="export2" class="btn btn-primary  waves-effect waves-light wavw  mb-2 mt-2">
         <i class="ri-file-excel-2-fill"></i>
        </button> -->
                                    <div class="table-responsive">
                                        <table id="po_cancel_datatable" class="table table-bordered table-striped align-middle">
                                            <thead>
                                            <tr>
                                       <th>S.No</th>
                                       <th>PO Number </th>
                                       <th>PO Date </th>
                                       <th>Department </th>
                                       <th>Customer GST Number </th>
                                       <th>Executive Name</th>
                                       <th>PO Total Value</th>
                                       <th>PO Cancel Attachment</th>
                                       <!-- <th>Action</th> -->
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
                    
                <!----content start---------->
                




                
            </div>
        </div><!-- end card-body -->
    </div><!-- end card -->
</div>
<!--end col-->
</div>
<!--end row-->
<!-- Page content Ends Here -->
</div>
</div>
</div>
<script>
      $("#export").click(function(){
    // alert("hi");
    window.location="folders/po_form/excel.php";
    });

    function print_pdf_1(file_name)
{
    
 onmouseover=window.open('uploads/po_form/po_attach/' + file_name,'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
}


$(document).ready(function () {
      // var table_id 	= "user_type_datatable";
      // init_datatable(table_id,form_name,action);
      get_data();
      get_data_month();
   });

   function get_data() {
      document.getElementById('month_fill').value = '';

      init_datatable(table_id, form_name, action);
   }
   function get_data_month() {

      document.getElementById('from_date').value = '';
      document.getElementById('to_date').value = '';

      init_datatable(table_id, form_name, action);
   }


   function init_datatable(table_id = '', form_name = '', action = '') {

      var table = $("#" + table_id);
      var month_fill = $('#month_fill').val();
      var from_date = $("#from_date").val();
      var to_date = $("#to_date").val();

      if (month_fill != '') {
         var data = {
            "month_fill": month_fill,
            "action": action
         };
         var ajax_url = sessionStorage.getItem("folder_crud_link");

         var datatable = table.DataTable({
            ordering: true,
            searching: true,
            "ajax": {
               url: ajax_url,
               type: "POST",
               data: data
            }
         });

      } else {
         var data = {
            "action": action,
            "from_date": from_date,
            "to_date": to_date,
         };
         var ajax_url = sessionStorage.getItem("folder_crud_link");

         var datatable = table.DataTable({
            ordering: true,
            searching: true,
            "ajax": {
               url: ajax_url,
               type: "POST",
               data: data
            }
         });
      }


   }

  </script>
