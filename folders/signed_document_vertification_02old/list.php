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
</style>
<?php 

// echo 'test';
?>


<?php
//  $screen_id = isset($_GET['screen_id']) ? htmlspecialchars($_GET['screen_id']) : '';
$screen_id_val='641ad9f04e6b343034';
// print_r($screen_id);
   session_start();
  $user_type_unique_id = $_SESSION['user_type_unique_id'];
  ?>
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Signed Document Verificaion</h4>
            <input type="hidden" id="screen_id_val" name="screen_id_val" class="form-control" value="<?php echo $screen_id_val;?>">
            <input type="hidden" id="user_type_unique_id" name="user_type_unique_id" class="form-control" value="<?php echo $user_type_unique_id;?>">

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Form</a></li>
                    <li class="breadcrumb-item active">Signed Document Verificaion</li>
                </ol>
            </div>

        </div>
        <div>
            <button type="button" id="export" name="export"
                class="btn btn-primary  waves-effect waves-light wavw  mb-2 mt-2">
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
                <li class="nav-item">
                    <!--onclick="dispatch_pending()"-->
                    <a class="nav-link active" data-bs-toggle="tab" href="#arrow-overview" role="tab">
                        <span class="d-block d-sm-none"><i class="mdi mdi-home-variant"></i></span>
                        <span class="d-none d-sm-block">Pending</span>
                    </a>
                </li>
                <li class="nav-item">
                    <!--onclick="dispatch_transist()"-->
                    <a class="nav-link" data-bs-toggle="tab" href="#arrow-profile" role="tab">
                        <span class="d-block d-sm-none"><i class="mdi mdi-account"></i></span>
                        <span class="d-none d-sm-block">Mismatch</span>
                    </a>
                </li>
                <li class="nav-item">
                    <!--onclick="dispatch_delivery()"-->
                    <a class="nav-link" data-bs-toggle="tab" href="#arrow-contact" role="tab">
                        <span class="d-block d-sm-none"><i class="mdi mdi-email"></i></span>
                        <span class="d-none d-sm-block">Verified</span>
                    </a>
                </li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
            <button type="button" id="export1" name="export1"
                class="btn btn-primary  waves-effect waves-light wavw  mb-2 mt-2" >
                <i class="ri-file-excel-2-fill"></i>
            </button>
                   
                <div class="tab-pane active" id="arrow-overview" role="tabpanel">
                    <ul class="nav nav-pills arrow-navtabs  bg-light mb-3" role="tablist">
                    <li class="nav-item">
                            <!--onclick="dispatch_transist()"-->
                            <a class="nav-link active" data-bs-toggle="tab" href="#arrow-ir_with" role="tab">
                                <span class="d-block d-sm-none"><i class="mdi mdi-account"></i></span>
                                <span class="d-none d-sm-block">With IR</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <!--onclick="dispatch_pending()"-->
                            <a class="nav-link " data-bs-toggle="tab" href="#arrow-ir_without" role="tab">
                                <span class="d-block d-sm-none"><i class="mdi mdi-home-variant"></i></span>
                                <span class="d-none d-sm-block">With SNR</span>
                            </a>
                        </li>
                        
                    </ul>
                    <div class="tab-content">
                    <div class="tab-pane active" id="arrow-ir_with" role="tabpanel">
                        <div class="row">
                            <div class="col-12">
                                <div class="">
                                    <div class="card-body">
                                    <div class="row align-items-end">
                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <label class="form-label from-date-label">From Date</label>
                                                    <input type="date" class="form-control" id="from_date"
                                                        name="from_date" >
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <label class="form-label from-date-label">To Date</label>
                                                    <input type="date" class="form-control" id="to_date" name="to_date"
                                                      >
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <select class="form-select mb-3" id="opt" name="opt">
                                                        <option value=""></option>
                                                        <option value="4">PO Date</option>
                                                        <option value="5">Invoice Date</option>
                                                        <!-- <option value="6">Due Date</option> -->
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <div class="mb-3">

                                                    <button type="button" class="btn btn-primary btn-lg"
                                                        onclick="get_data()">Go</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="list">
                                        <div class="table-responsive">
                                            <table id="signed_document_verification_datatable_with_ir"
                                                class="table table-bordered table-striped align-middle">
                                                <thead>
                                                    <tr>
                                                        <th>S.No</th>
                                                        <th>Po No</th>
                                                        <th>Po Date</th>
                                                        <!-- <th>Consignee</th> -->
                                                        <th>Ledger Name</th>
                                                         <!-- <th>Department</th> -->
                                                        <th>Location</th>
                                                        <th>Invoice No</th>
                                                        <th>Invoice Date</th>
                                                        <th>DC Rec. Status</th>
                                                        <th>DC Sign. Att.</th>
                                                        <th>IR. Rec. Status</th>
                                                        <th>IR. Sign. Att.</th>
                                                        <th>IR POD Date</th>
                                                        <!-- <th>SNR. Rec. Status</th>
                                                        <th>SNR. Sign. Att.</th> -->
                                                        <th>Status</th>
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
                        </div>


                        <!----content start---------->
                        <!--  Extra Large modal example -->
                        <div class="modal fade bs-example-modal-xl" tabindex="-1" role="dialog"
                            aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title w-100 text-center" id="myExtraLargeModalLabel">Signed
                                            Document Verificaion</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>

                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-12">

                                                <form class="was-validated" autocomplete="off">
                                                    <div class="col-12">
                                                        <div class="row">
                                                            <div class="col-5">
                                                                <div class="row">
                                                                    <div class="col-xl-4 head_po"> <label
                                                                            class="form-label">PO Number</label></div>
                                                                    <div class="col-xl-1">:</div>
                                                                    <div class="col-xl-7"></div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-xl-4 head_po"> <label
                                                                            class="form-label">PO Date</label></div>
                                                                    <div class="col-xl-1">:</div>
                                                                    <div class="col-xl-7"></div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-xl-4 head_po"> <label
                                                                            class="form-label">Consignee</label></div>
                                                                    <div class="col-xl-1">:</div>
                                                                    <div class="col-xl-7"></div>
                                                                </div>


                                                            </div>

                                                            <div class="col-5">
                                                                <div class="row">
                                                                    <div class="col-xl-4 head_po"> <label
                                                                            class="form-label">Location</label></div>
                                                                    <div class="col-xl-1">:</div>
                                                                    <div class="col-xl-7"></div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-xl-4 head_po"> <label
                                                                            class="form-label">Invoice No</label></div>
                                                                    <div class="col-xl-1">:</div>
                                                                    <div class="col-xl-7"></div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-xl-4 head_po"> <label
                                                                            class="form-label">Invoice Date</label></div>
                                                                    <div class="col-xl-1">:</div>
                                                                    <div class="col-xl-7"></div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr />

                                                    <div class="row">
                                                        <div class="col-12 mt-2">
                                                            <form class="was-validated" autocomplete="off">
                                                                <div class="row">

                                                                    <div class="col-xl-3">

                                                                        <label class="form-label">Dispatch
                                                                            Date</label>

                                                                        <input type="date" class="form-control"
                                                                            id="dispatch_date">
                                                                    </div>
                                                                    <div class="col-xl-3">

                                                                        <label class="form-label">Mode of
                                                                            Delivery</label>

                                                                        <select class="form-select mb-3"
                                                                            aria-label="Default select example">
                                                                            <option selected="">Select MOD </option>
                                                                            <option value="1">Hand</option>
                                                                            <option value="2">Courier</option>
                                                                        </select>
                                                                    </div>

                                                                    <div class="col-xl-3">
                                                                        <div>
                                                                            <label class="form-label">Name of Courier /
                                                                                Person
                                                                                Name</label>
                                                                            <input type="text" id="state_name"
                                                                                name="state_name" class="form-control"
                                                                                value="">
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-xl-3">

                                                                        <label class="form-label">POD
                                                                            NO.</label>

                                                                        <input type="text" id="state_name" name="state_name"
                                                                            class="form-control" value="">
                                                                    </div>
                                                                    <!-- <div class="col-xl-3">

                                                                        <button type="button"
                                                                            class="btn btn-primary btn-label rounded-pill"><i
                                                                                class="lab la as la-plus-circle label-icon align-middle rounded-pill fs-16 me-2"></i>
                                                                            Add </button>

                                                                    </div> -->




                                                                    <!-- <div class="table-responsive mt-4">
                                                                        <table
                                                                            class="table table-hover table-bordered align-middle table-nowrap mb-0">
                                                                            <thead class="table-light">
                                                                                <tr>
                                                                                    <th>ID </th>
                                                                                    <th scope="col">Dispatch Date</th>
                                                                                    <th scope="col">Mode of Delivery</th>
                                                                                    <th scope="col">Name of Courier / Person
                                                                                        Name</th>
                                                                                    <th scope="col">POD NO.</th>
                                                                                    <th scope="col">Action </th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <tr>

                                                                                    <td>1 </td>
                                                                                    <td>06-11-2023</td>
                                                                                    <td>Hand</td>
                                                                                    <td>ABC Parcel / Mr.Santhosh</td>
                                                                                    <td> 101</td>
                                                                                    <td>
                                                                                        <i
                                                                                            class="mdi mdi-delete  mdi-24px waves-effect waves-light mt-n2 mb-n2 text-danger"></i>
                                                                                    </td>
                                                                                </tr>


                                                                            </tbody>
                                                                        </table>
                                                                    </div> -->


                                                                </div> <!-- end card -->

                                                            </form>

                                                        </div>
                                                    </div>
                                                </form> <!-- end card-body -->

                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <a href="javascript:void(0);" class="btn btn-link link-success fw-medium"
                                            data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i>
                                            Close</a>
                                        <button type="button" class="btn btn-primary ">Save changes</button>
                                    </div>
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                        </div><!-- /.modal -->

                    </div>

                    <!-- with SNR-->
                    
                    <div class="tab-pane" id="arrow-ir_without" role="tabpanel">
                        <div class="row">
                            <div class="col-12">
                                <div class="">
                                    <div class="card-body">
                                    <div id="list_1">
                                        <div class="table-responsive">
                                            <table id="signed_document_verification_datatable"
                                                class="table table-bordered table-striped align-middle">
                                                <thead>
                                                    <tr>
                                                        <th>S.No</th>
                                                        <th>Po No</th>
                                                        <th>Po Date</th>
                                                        <!-- <th>Consignee</th> -->
                                                        <th>Ledger Name</th>
                                                        <th>Location</th>
                                                        <th>Invoice No</th>
                                                        <th>Invoice Date</th>
                                                        <th>DC Rec. Status</th>
                                                        <th>DC Sign. Att.</th>
                                                        <!-- <th>IR. Rec. Status</th>
                                                        <th>IR. Sign. Att.</th> -->
                                                        <th>SNR. Rec. Status</th>
                                                        <th>SNR. Sign. Att.</th>
                                                        <th>SNR POD Date</th>
                                                        <th>Status</th>
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
                        </div>


                   

                        <!----content start---------->
                        <!--  Extra Large modal example -->
                        <div class="modal fade bs-example-modal-xl" tabindex="-1" role="dialog"
                            aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title w-100 text-center" id="myExtraLargeModalLabel">Signed
                                            Document Verificaion</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>

                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-12">

                                                <form class="was-validated" autocomplete="off">
                                                    <div class="col-12">
                                                        <div class="row">
                                                            <div class="col-5">
                                                                <div class="row">
                                                                    <div class="col-xl-4 head_po"> <label
                                                                            class="form-label">PO Number</label></div>
                                                                    <div class="col-xl-1">:</div>
                                                                    <div class="col-xl-7"></div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-xl-4 head_po"> <label
                                                                            class="form-label">PO Date</label></div>
                                                                    <div class="col-xl-1">:</div>
                                                                    <div class="col-xl-7"></div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-xl-4 head_po"> <label
                                                                            class="form-label">Consignee</label></div>
                                                                    <div class="col-xl-1">:</div>
                                                                    <div class="col-xl-7"></div>
                                                                </div>


                                                            </div>

                                                            <div class="col-5">
                                                                <div class="row">
                                                                    <div class="col-xl-4 head_po"> <label
                                                                            class="form-label">Location</label></div>
                                                                    <div class="col-xl-1">:</div>
                                                                    <div class="col-xl-7"></div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-xl-4 head_po"> <label
                                                                            class="form-label">Invoice No</label></div>
                                                                    <div class="col-xl-1">:</div>
                                                                    <div class="col-xl-7"></div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-xl-4 head_po"> <label
                                                                            class="form-label">Invoice Date</label></div>
                                                                    <div class="col-xl-1">:</div>
                                                                    <div class="col-xl-7"></div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr />

                                                    <div class="row">
                                                        <div class="col-12 mt-2">
                                                            <form class="was-validated" autocomplete="off">
                                                                <div class="row">

                                                                    <div class="col-xl-3">

                                                                        <label class="form-label">Dispatch
                                                                            Date</label>

                                                                        <input type="date" class="form-control"
                                                                            id="dispatch_date">
                                                                    </div>
                                                                    <div class="col-xl-3">

                                                                        <label class="form-label">Mode of
                                                                            Delivery</label>

                                                                        <select class="form-select mb-3"
                                                                            aria-label="Default select example">
                                                                            <option selected="">Select MOD </option>
                                                                            <option value="1">Hand</option>
                                                                            <option value="2">Courier</option>
                                                                        </select>
                                                                    </div>

                                                                    <div class="col-xl-3">
                                                                        <div>
                                                                            <label class="form-label">Name of Courier /
                                                                                Person
                                                                                Name</label>
                                                                            <input type="text" id="state_name"
                                                                                name="state_name" class="form-control"
                                                                                value="">
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-xl-3">

                                                                        <label class="form-label">POD
                                                                            NO.</label>

                                                                        <input type="text" id="state_name" name="state_name"
                                                                            class="form-control" value="">
                                                                    </div>
                                                                    <!-- <div class="col-xl-3">

                                                                        <button type="button"
                                                                            class="btn btn-primary btn-label rounded-pill"><i
                                                                                class="lab la as la-plus-circle label-icon align-middle rounded-pill fs-16 me-2"></i>
                                                                            Add </button>

                                                                    </div> -->




                                                                    <!-- <div class="table-responsive mt-4">
                                                                        <table
                                                                            class="table table-hover table-bordered align-middle table-nowrap mb-0">
                                                                            <thead class="table-light">
                                                                                <tr>
                                                                                    <th>ID </th>
                                                                                    <th scope="col">Dispatch Date</th>
                                                                                    <th scope="col">Mode of Delivery</th>
                                                                                    <th scope="col">Name of Courier / Person
                                                                                        Name</th>
                                                                                    <th scope="col">POD NO.</th>
                                                                                    <th scope="col">Action </th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <tr>

                                                                                    <td>1 </td>
                                                                                    <td>06-11-2023</td>
                                                                                    <td>Hand</td>
                                                                                    <td>ABC Parcel / Mr.Santhosh</td>
                                                                                    <td> 101</td>
                                                                                    <td>
                                                                                        <i
                                                                                            class="mdi mdi-delete  mdi-24px waves-effect waves-light mt-n2 mb-n2 text-danger"></i>
                                                                                    </td>
                                                                                </tr>


                                                                            </tbody>
                                                                        </table>
                                                                    </div> -->


                                                                </div> <!-- end card -->

                                                            </form>

                                                        </div>
                                                    </div>
                                                </form> <!-- end card-body -->

                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <a href="javascript:void(0);" class="btn btn-link link-success fw-medium"
                                            data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i>
                                            Close</a>
                                        <button type="button" class="btn btn-primary ">Save changes</button>
                                    </div>
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                        </div><!-- /.modal -->

                    </div>
                </div>
                </div>
                <!-- fixed-header  -->
                <div class="tab-pane" id="arrow-profile" role="tabpanel">
                    <div class="row">
                        <div class="col-12">
                            <div class="">
                                <div class="card-body">
                                <div class="row align-items-end">
                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <label class="form-label from-date-label">From Date</label>
                                                    <input type="date" class="form-control" id="from_date_mis"
                                                        name="from_date_mis" >
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <label class="form-label from-date-label">To Date</label>
                                                    <input type="date" class="form-control" id="to_date_mis" name="to_date_mis"
                                                      >
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <select class="form-select mb-3" id="opt1" name="opt1">
                                                        <option value=""></option>
                                                        <option value="40">PO Date</option>
                                                        <option value="50">Invoice Date</option>
                                                        <!-- <option value="6">Due Date</option> -->
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <div class="mb-3">

                                                    <button type="button" class="btn btn-primary btn-lg"
                                                        onclick="get_data_mis()">Go</button>
                                                </div>
                                            </div>
                                        </div>
                                    <div class="table-responsive">
                                        <table id="mismatch_datatable"
                                            class="table table-bordered table-striped align-middle">
                                            <thead>
                                                <tr>
                                                    <!-- <th>S.No</th>
                                                    <th>Po Number</th>
                                                    <th>Po Date</th>
                                                    <th>Consignee</th>
                                                    <th>Location</th>
                                                    <th>Invoice No</th>
                                                    <th>Invoice Date</th>
                                                    <th scope="col">Dispatch Date</th>
                                                    <th scope="col">Mode of Delivery</th>
                                                    <th scope="col">Name of Courier / Person Name</th>
                                                    <th scope="col">POD NO.</th>
                                                    <th scope="col">Delivery Status</th> -->
                                                    <!-- <th scope="col">Delivery Proof Attachment</th> -->
                                                    <!-- <th scope="col">Action </th> -->
                                                    <th>S.No</th>
                                                    <th>Po No</th>
                                                    <th>Po Date</th>
                                                    <!-- <th>Department</th> -->
                                                    <th>Ledger Name</th>
                                                    <th>Location</th>
                                                    <th>Invoice No</th>
                                                    <th>Invoice Date</th>
                                                    <th>DC Signed Document</th>
                                                    <th>Installation Signed Report</th>
                                                    <th>Status</th>
                                                    <!-- <th>Action</th> -->


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


                    <!--  Extra Large modal example -->
                    <div class="modal fade bs-example-modal-xl1" tabindex="-1" role="dialog"
                        aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title w-100 text-center" id="myExtraLargeModalLabel">Dispatch</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">

                                    <div class="row">
                                        <div class="col-12">

                                            <form class="was-validated" autocomplete="off">
                                                <div class="col-12">
                                                    <div class="row">
                                                        <div class="col-5">
                                                            <div class="row">

                                                                <div class="col-xl-4 head_po"> <label
                                                                        class="form-label">PO Number</label></div>
                                                                <div class="col-xl-1">:</div>
                                                                <div class="col-xl-7">
                                                                    <?php echo $po_num ?>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-xl-4 head_po"> <label
                                                                        class="form-label">PO Date</label></div>
                                                                <div class="col-xl-1">:</div>
                                                                <div class="col-xl-7">
                                                                    <?php echo $po_date ?>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-xl-4 head_po"> <label
                                                                        class="form-label">Consignee</label></div>
                                                                <div class="col-xl-1">:</div>
                                                                <div class="col-xl-7">
                                                                    <?php echo $consignee ?>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-xl-4 head_po"> <label
                                                                        class="form-label">Location</label></div>
                                                                <div class="col-xl-1">:</div>
                                                                <div class="col-xl-7">
                                                                    <?php echo $con_address ?>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-xl-4 head_po"> <label
                                                                        class="form-label">Invoice No</label></div>
                                                                <div class="col-xl-1">:</div>
                                                                <div class="col-xl-7">
                                                                    <?php echo $invoice_no ?>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-xl-4 head_po"> <label
                                                                        class="form-label">Invoice Date</label></div>
                                                                <div class="col-xl-1">:</div>
                                                                <div class="col-xl-7">
                                                                    <?php echo $invoice_date ?>
                                                                </div>
                                                            </div>


                                                        </div>

                                                        <div class="col-7">
                                                            <div class="row">
                                                                <div class="col-xl-4 head_po"> <label
                                                                        class="form-label">Dispatch Date</label></div>
                                                                <div class="col-xl-1">:</div>
                                                                <div class="col-xl-7">
                                                                    <?php echo $invoice_date ?>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-xl-4 head_po"> <label
                                                                        class="form-label">Mode of Delivery</label>
                                                                </div>
                                                                <div class="col-xl-1">:</div>
                                                                <div class="col-xl-7">
                                                                    <?php echo $invoice_date ?>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-xl-4 head_po"> <label
                                                                        class="form-label">Name of Courier / Person
                                                                        Name</label></div>
                                                                <div class="col-xl-1">:</div>
                                                                <div class="col-xl-7">
                                                                    <?php echo $invoice_date ?>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-xl-4 head_po"> <label
                                                                        class="form-label">POD NO.</label></div>
                                                                <div class="col-xl-1">:</div>
                                                                <div class="col-xl-7">
                                                                    <?php echo $invoice_date ?>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                                <hr>

                                                <div class="row">
                                                    <div class="col-12 mt-2">
                                                        <div class="row">
                                                            <div class="col-xl-3">
                                                                <label class="form-label">Delivery
                                                                    Status</label>
                                                                <select class="form-select mb-3"
                                                                    aria-label="Default select example">
                                                                    <option selected="">Select Status </option>
                                                                    <option value="1">Yes</option>
                                                                    <option value="2">No</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-xl-3">

                                                                <label class="form-label">Delivery
                                                                    Date</label>

                                                                <input type="date" class="form-control"
                                                                    id="delivery_date">
                                                            </div>
                                                            <!-- <div class="col-xl-3"> -->

                                                            <!-- </div> -->
                                                            <!-- <div class="col-xl-3">
                                                                <label class="form-label">Delivery Proof Attachment</label>
                                                                <input type="text" class="form-control" id="delivery_proff">
                                                            </div> -->
                                                            <!-- <div class="form-group row ">
                                                                    <div class="col-md-12 mt-4" align="">
                                                                        Cancel,save and update Buttons
                                                                        <a href="index.php?file=invoice/list"><button
                                                                                type="button"
                                                                                class="btn btn-danger waves-effect waves-light">Cancel</button></a>
                                                                        <button type="button"
                                                                            class="btn btn-success waves-effect waves-light createupdate_btn  "
                                                                            onclick="invoice_cu('')">Save</button>
                                                                    </div>
                                                                </div> -->
                                                            <!-- </div> -->
                                                        </div> <!-- end card -->

                                                    </div>
                                                </div>
                                            </form>
                                            <!-- end card-body -->

                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <a href="javascript:void(0);" class="btn btn-link link-success fw-medium"
                                        data-bs-dismiss="modal()" onclick="modal()"><i
                                            class="ri-close-line me-1 align-middle"></i>
                                        Close</a>
                                    <button type="button" class="btn btn-primary ">Save changes</button>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->

                </div>
                <!----content start---------->

                <div class="tab-pane" id="arrow-contact" role="tabpanel">
                    <div class="row">
                        <div class="col-12">
                            <div class="">
                                <div class="card-body">
                                <div class="row align-items-end">
                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <label class="form-label from-date-label">From Date</label>
                                                    <input type="date" class="form-control" id="from_date_ver"
                                                        name="from_date_ver" >
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <label class="form-label from-date-label">To Date</label>
                                                    <input type="date" class="form-control" id="from_date_ver" name="from_date_ver"
                                                      >
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <select class="form-select mb-3" id="opt2" name="opt2">
                                                        <option value=""></option>
                                                        <option value="100">PO Date</option>
                                                        <option value="102">Invoice Date</option>
                                                        <!-- <option value="6">Due Date</option> -->
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <div class="mb-3">

                                                    <button type="button" class="btn btn-primary btn-lg"
                                                        onclick="get_data_del()">Go</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="list_2">
                                    <div class="table-responsive">
                                        <table id="verify_datatable"
                                            class="table table-bordered table-striped align-middle">
                                            <thead>
                                                <tr>
                                                    <!-- <th>S.No</th>
                                                    <th>Po Number</th>
                                                    <th>Po Date</th>
                                                    <th>Consignee</th>
                                                    <th>Location</th>
                                                    <th>Invoice No</th>
                                                    <th>Invoice Date</th>

                                                    <th scope="col">POD NO.</th> -->
                                                    <!-- <th scope="col">Delivery Proof</th> -->
                                                    <!-- <th scope="col">Delivery Status </th>
                                                    <th scope="col">Delivery Date</th>
                                                   <th>Delivery Proof Attachment</th>  -->
                                                    <!-- <th>Action</th>
-->
                                                    <th>S.No</th>
                                                    <th>Po No</th>
                                                    <th>Po Date</th>
                                                    <th>Legder Name</th>
                                                    <th>Location</th>
                                                    <th>Invoice No</th>
                                                    <th>Invoice Date</th>
                                                    <th>DC Signed Document</th>
                                                    <th>Installation Signed Report</th>
                                                    <th>Status</th>
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
                                                    <td>101</td>


                                                    <td>Yes</td>
                                                    <td>-</td> -->



                                                </tr>

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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>




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

<script>
    $(document).ready(function(){
       
    //   
    //   alert('test'); 
    });
</script>

<script>
      $("#export").click(function(){
    // alert("hi");
    window.location="folders/signed_document_vertification/excel.php";
    });
  </script>
  <script>
      $("#export1").click(function(){
    // alert("hi");
    window.location="folders/signed_document_vertification/excel1.php";
    });
    $(document).ready(function () {
	// var table_id 	= "user_type_datatable";
	get_user_permission();
	get_user_permission_1();
	get_user_permission_2();
	// get_date_filter();
});

function get_user_permission() {
	var screen_id_val = $('#screen_id_val').val();
// alert(screen_id_val);
	var user_type_unique_id = $('#user_type_unique_id').val();

	var data = {
		"screen_id_val": screen_id_val,
		"user_type_unique_id": user_type_unique_id,
		"action": 'user_permission',
	};

	var ajax_url = sessionStorage.getItem("folder_crud_link");
	var url = sessionStorage.getItem("list_link");
// 
	console.log(data);
	$.ajax({
		type: "POST",
		url: ajax_url,
		data: data,
		success: function (data) {

			var obj = JSON.parse(data);

			var dataString = obj.data;

			// console.log(dataString);

			// var addButton = document.getElementById('add_btn');
			// if (dataString.includes('5f8807ff00bf726601')) {
			// 	addButton.style.visibility = 'visible';  // Show the button
			// } else {
			// 	addButton.style.visibility = 'hidden';   // Hide the button but keep its space
			// }
			var listpage = document.getElementById('list');
			if (dataString.includes('5f88083fd50a344823')) {
				listpage.style.visibility = 'visible';  // Show the button
			} else {
				listpage.style.visibility = 'hidden';   // Hide the button but keep its space
			}


		},
		error: function (data) {
			alert("Network Error");
		}
	});
}

function get_user_permission_1() {
	var screen_id_val = $('#screen_id_val').val();
// alert(screen_id_val);
	var user_type_unique_id = $('#user_type_unique_id').val();

	var data = {
		"screen_id_val": screen_id_val,
		"user_type_unique_id": user_type_unique_id,
		"action": 'user_permission_1',
	};

	var ajax_url = sessionStorage.getItem("folder_crud_link");
	var url = sessionStorage.getItem("list_link");
// 
	console.log(data);
	$.ajax({
		type: "POST",
		url: ajax_url,
		data: data,
		success: function (data) {

			var obj = JSON.parse(data);

			var dataString = obj.data;

			// console.log(dataString);

			// var addButton = document.getElementById('add_btn');
			// if (dataString.includes('5f8807ff00bf726601')) {
			// 	addButton.style.visibility = 'visible';  // Show the button
			// } else {
			// 	addButton.style.visibility = 'hidden';   // Hide the button but keep its space
			// }
			var listpage = document.getElementById('list_1');
			if (dataString.includes('5f88083fd50a344823')) {
				listpage.style.visibility = 'visible';  // Show the button
			} else {
				listpage.style.visibility = 'hidden';   // Hide the button but keep its space
			}


		},
		error: function (data) {
			alert("Network Error");
		}
	});
}


function get_user_permission_2() {
	var screen_id_val = $('#screen_id_val').val();
// alert(screen_id_val);
	var user_type_unique_id = $('#user_type_unique_id').val();

	var data = {
		"screen_id_val": screen_id_val,
		"user_type_unique_id": user_type_unique_id,
		"action": 'user_permission_2',
	};

	var ajax_url = sessionStorage.getItem("folder_crud_link");
	var url = sessionStorage.getItem("list_link");
// 
	console.log(data);
	$.ajax({
		type: "POST",
		url: ajax_url,
		data: data,
		success: function (data) {

			var obj = JSON.parse(data);

			var dataString = obj.data;

			// console.log(dataString);

			// var addButton = document.getElementById('add_btn');
			// if (dataString.includes('5f8807ff00bf726601')) {
			// 	addButton.style.visibility = 'visible';  // Show the button
			// } else {
			// 	addButton.style.visibility = 'hidden';   // Hide the button but keep its space
			// }
			var listpage = document.getElementById('list_2');
			if (dataString.includes('5f88083fd50a344823')) {
				listpage.style.visibility = 'visible';  // Show the button
			} else {
				listpage.style.visibility = 'hidden';   // Hide the button but keep its space
			}


		},
		error: function (data) {
			alert("Network Error");
		}
	});
}

  </script>
