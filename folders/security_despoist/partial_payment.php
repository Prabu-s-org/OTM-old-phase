<?php

$po_num_options = partial_paypo();
$po_num_options = select_option($po_num_options, "Select Po No");
?>


<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Security Deposit</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Forms</a></li>
                    <li class="breadcrumb-item active">Security Deposit</li>
                </ol>
            </div>

        </div>
    </div>
</div>


<div class="row">



    <div class="card">
        <div class="card-body">




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
                                                onchange="get_partial_po(this.value); get_cus_po_details(this.value);">
                                                <?php echo $po_num_options; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-1 head_po"></div>

                              <div class="col-12 col-md-4">
    <h6 class="text-uppercase text-body-primary" style="font-size: large; color: #9aa965; margin-bottom: 5px;">
        Customer Details
    </h6>

    <h6 class="text-body-primary" style="font-size: 20px; color: #506018 !important; margin-bottom: 4px;" id="cus_dept">
        <strong></strong>
    </h6>

    <p class="text-body-primary mb-1" id="cus_address" style="margin-bottom: 4px; line-height: 1.4;"></p>
    <p class="text-body-primary mb-1" id="cus_dist" style="margin-bottom: 4px; line-height: 1.4;"></p>
    <p class="text-body-primary mb-1" id="cus_state" style="margin-bottom: 4px; line-height: 1.4;"></p>

    <p id="cus_landline" style="margin-bottom: 4px; line-height: 1.4;">
        <i data-feather="phone" style="width: 15px; height: 15px; color: #506018; margin-right: 5px;"></i>
    </p>

    <p id="cus_email" style="margin-bottom: 0px; line-height: 1.4;">
        <i data-feather="mail" style="width: 15px; height: 15px; color: #506018; margin-right: 5px;"></i>
    </p>
</div>





                                <div class="col-12 col-md-4">
                                    <h6 class="text-uppercase text-body-primary"
                                        style="font-size:large; color:#9aa965;">
                                        PO Details 
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
                                    



                                </div>

                            </div> <!-- / .row -->

                        </div>
                    </div>
                </div>


            </div>


            <div class="row">
                <div class="col-12">

                    <div class="card-body">

                        <div class="table-responsive">
                            <table id="partial_payment_datatable"
                                class="table table-bordered nowrap table-striped align-middle">
                                <thead>
                                    <tr>
                                        <th>
                                            <input type="checkbox" id="select_all_checkbox"> Selection
                                        </th>

                                        <th>S NO</th>
                                        <th>BG No / Date </th>
                                        <th>Bill No / Date </th>
                                        <th>PO No / Date </th>
                                        <th>Invoice No / Date</th>
                                        <th>Customer Name</th>
                                        <th>Invoice Value</th>
                                        <th>Claim (%)</th>
                                        <th>Claim Value</th>

                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>

                <div class="col-12 mt-6">
                    <div class="form-group row ">
                        <div class="col-md-12" align="right">
                            <!-- Cancel,save and update Buttons -->
                            <?php echo btn_cancel($btn_cancel); ?>



                            <button type="button" class="btn btn-primary waves-effect waves-light"
                                onclick="partial_bill_create()">Save</button>

                        </div>
                    </div>
                </div>
            </div>

            <script>







            </script>
