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
</style>
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Partial Payment</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Form</a></li>
                    <li class="breadcrumb-item active">Partial Payment</li>
                </ol>
            </div>
        </div>
        <div>
         <button type="button" id="export" name="export" class="btn btn-primary  waves-effect waves-light wavw  mb-2 mt-2">
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
                <!-- <li class="nav-item" > -->
                    <!--onclick="dispatch_pending()"-->
                    <!-- <a class="nav-link active" data-bs-toggle="tab" href="#arrow-overview" role="tab">
                        <span class="d-block d-sm-none"><i class="mdi mdi-home-variant"></i></span>
                        <span class="d-none d-sm-block">Pending</span>
                    </a>
                </li> -->
                
                <li class="nav-item" >
                    <!--onclick="dispatch_transist()"-->
                    <a class="nav-link" data-bs-toggle="tab" href="#arrow-profile" role="tab">
                        <span class="d-block d-sm-none"><i class="mdi mdi-account"></i></span>
                        <span class="d-none d-sm-block">Partially Payment</span>
                    </a>
                </li>
                
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane active" id="arrow-overview" role="tabpanel">
                <!-- <div class="tab-pane" id="arrow-profile" role="tabpanel"> -->
                    <div class="row">
                        <div class="col-12">
                            <div class="">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="security_despoist_datatable" class="table table-bordered table-striped align-middle">
                                            <thead>
                                            <tr>
                                                   <th>S.No</th>
                                                   <th>PO Number/PO Date</th>
                                                   <!-- <th>PO Date </th> -->
                                                   <!-- <th>Consignee </th> -->
                                                   <!-- <th>Location</th> -->
                                                   <th>Invoice No/Invoice Date</th>
                                                   <!-- <th>Invoice Date</th> -->
                                                   <th>Invoice Value</th>
                                                   <th>Bill Submission Date</th>
                                                   <th>Claim/Claim Remaining</th>
                                                  <th>Dc Signed Date</th>
                                                  <th>Snr Signed Date</th>
                                                  <th>Ir Signed Date</th>
                                                  <th>BG</th>
                                                  <th>Bank Required</th>
                                
                                                   <th>E No</th>
                                                   <!-- <th>LD Days </th>
                                                   <th>LD Value </th> -->
                                                   <!-- <th>DC signed Date</th> -->
                                                   <th>Warrenty</th>
                                                   <th> warrenty End Date</th>
                                                   <th>Delivery Due Day</th>
                                                   <!-- <th>Payment Receivable</th> -->
                                                   <!-- <th>Payment Receipt</th> -->
                                                   <!-- <th>Status</th> -->
                                                   <th>Action</th>
                                             </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <!-- <td>1</td>
                                                    <td>001</td>
                                                    <td>06-11-2023</td>
                                                    <td>Ocean Clothes</td>
                                                    <td>Chennai</td>
                                                    <td>1000</td>
                                                    <td>04-11-2023</td>
                                                    <td> 06-11-2023</td>
                                                    <td>Hand</td>
                                                    <td>ABC Parcel / Mr.Santhosh</td>
                                                    <td>101</td>
                                                    <td>-</td> -->
                                                    <!-- <td>
                                                        <a data-bs-toggle="modal"
                                                            data-bs-target=".bs-example-modal-xl1"><i
                                                                class="mdi mdi-square-edit-outline mdi-24px waves-effect waves-light mt-n2 mb-n2 text-green"></i></a>
                                                    </td> -->
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                
                <!-- fixed-header  -->
                
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
    window.location="folders/payment/excel.php";
    });
  </script>
