<?php include 'function.php';
$po_num_options = inv_verify_po();
$po_num_options = select_option($po_num_options, "Select Po No");


?>

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

    button#export1 {
        float: right;
        padding: 4px 9px;
    }

    #btn {
        margin-left: 88%;
    }

    span.po_date {
        white-space: nowrap;
    }

    span.text-right {
        text-align: right;
    }

    span.text-center {
        text-align: center;
    }

    span.d-block {
        display: block;
    }
</style>
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0"> Bill Creation Form</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Forms</a></li>
                    <li class="breadcrumb-item active"> Bill Creation</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<style>
    .head_po {
        font-size: 14px;
        margin-bottom: 5px;
    }

    table.dataTable thead tr th {
        text-align: center !important;
    }
</style>

<div class="row cf">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form class="was-validated" autocomplete="off">
                    <div class="row">

                        <div class="row pt-2">
                            <div class="col-12">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="row">
                                            <!-- Heading -->
                                            <div class="col-12 col-md-3 head_po">


                                                <div class="row">
                                                    <div class="col-xl-12 head_po">
                                                        <label class="form-label">PO NO</label>
                                                        <select name="po_num" id="po_num" class="select2 form-select"
                                                            onchange="get_po_data(this.value); get_cus_po_details(this.value);">
                                                            <?php echo $po_num_options; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-1 head_po"></div>
                                            <div class="col-12 col-md-4">
                                                <h6 class="text-uppercase text-body-primary"
                                                    style="font-size:large; color:#9aa965;">
                                                    Customer Details
                                                </h6>


                                                <!-- Text -->
                                                <h6 class=" text-body-primary"
                                                    style="font-size: 20px; color:#506018 !important;" id="cus_dept">
                                                    <strong></strong>
                                                </h6>
                                                <p class="text-body-primary mb-3" id="cus_address"></p>


                                                <!-- Text -->
                                                <p class="" id="cus_landline"><span><i data-feather="phone"
                                                            style="width:15px; height:15px; color:#506018 "></i></span>

                                                </p>
                                                <!-- Text -->
                                                <p class="mb-4" id="cus_email"><span><i data-feather="mail"
                                                            style="width:15px; height:15px;color:#506018"></i></span>

                                                </p>

                                            </div>
                                            <div class="col-12 col-md-4">
                                                <h6 class="text-uppercase text-body-primary"
                                                    style="font-size:large; color:#9aa965;">
                                                    PO & Invoice Details
                                                </h6>
                                                <div class="row">
                                                    <div class="col-xl-4 text-body-secondary"> <label for="main_screen"
                                                            class="form-label">PO Number</label></div>
                                                    <div class="col-xl-1">:</div>
                                                    <div class="col-xl-7 text_style" id="po_no"></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xl-4 text-body-secondary"> <label for="main_screen"
                                                            class="form-label">PO Date</label></div>
                                                    <div class="col-xl-1">:</div>
                                                    <div class="col-xl-7 text_style" id="po_date"></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xl-4 text-body-secondary"> <label for="main_screen"
                                                            class="form-label">Executive</label></div>
                                                    <div class="col-xl-1">:</div>
                                                    <div class="col-xl-7 text_style" id="executive_name"></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xl-4 text-body-secondary"> <label for="main_screen"
                                                            class="form-label">Warranty</label></div>
                                                    <div class="col-xl-1">:</div>
                                                    <div class="col-xl-7 text_style" id="warranty"></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xl-4 text-body-secondary"> <label for="main_screen"
                                                            class="form-label">BG %</label></div>
                                                    <div class="col-xl-1">:</div>
                                                    <div class="col-xl-7 text_style" id="bg_percen"></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xl-4 text-body-secondary"> <label for="main_screen"
                                                            class="form-label">BG Month</label></div>
                                                    <div class="col-xl-1">:</div>
                                                    <div class="col-xl-7 text_style" id="bg_month"></div>
                                                </div>



                                            </div>

                                        </div> <!-- / .row -->

                                    </div>
                                </div>
                            </div>


                        </div>
                        <div class="table-responsive">
                            <table id="bill_datatable" class="table table-bordered nowrap table-striped align-middle">
                                <thead>
                                    <tr>
                                        <th>All<br>
                                        <input type="checkbox" id="checkAll"></th>
                                        <th>S.No</th>
                                        <th>PO Number</th>
                                        <th>Ledger Name</th>
                                        <th>Ledger No</th>
                                        <th>Invoice No</th>
                                        <th>invoice Qty</th>
                                        <th>Invoice Value</th>
                                        <th>Claim (%)</th>

                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div><br>


                    <div class="row" id="bg_div" style="display:none">
                        <div class="col-12 col-md-4">
                            <label class="form-label">BG Number</label>
                            <input type="text" name="bg_num" id="bg_num" onkeypress="number_only(event)" class="form-control" required>
                        </div>
                        <div class="col-12 col-md-4">
                            <label class="form-label">BG Value</label>
                            <input type="text" name="bg_value" id="bg_value" onkeypress="number_only(event)" class="form-control" required>
                            <input type="hidden" name="bg" id="bg" class="form-control">
                        </div>
                        <div class="col-12 col-md-4">
                            <label class="form-label">BG Date</label>
                            <input type="date" name="bg_date" id="bg_date" class="form-control" required> 
                        </div><br>
                        <div class="col-12 col-md-4">
                             <label class="form-label">BG Document Upload</label>
                            <input type="file" name="bg_doc" id="bg_doc" class="form-control" required>
                               
                        </div>
                    </div>

                    <div class="col-12 mt-3">
                        <div class="form-group row ">
                            <div class="col-md-12" align="right">
                                <!-- Cancel,save and update Buttons -->
                                <?php echo btn_cancel($btn_cancel); ?>
                                <button type="button" class="btn btn-primary waves-effect waves-light"
                                    onclick="po_invoice_create()">Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div><!-- end col -->
        </div>
    </div>
</div>


<script>
    // When any row checkbox is changed
$('#checkAll').on('click', function (e) {
    e.stopPropagation(); // prevent DataTables from triggering sort or redraw
    let isChecked = $(this).prop('checked');
    $('.myCheck').prop('checked', isChecked);
});


</script>
