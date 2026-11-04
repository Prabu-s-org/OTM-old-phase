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

    .custom-wide-modal {
        max-width: 85vw;
        width: 80vw;
    }
</style>
<!-- Include Bootstrap Icons (for the credit card icon) -->

<?php
$action_type = "Update";
//   $screen_id = isset($_GET['screen_id']) ? htmlspecialchars($_GET['screen_id']) : '';
$screen_id_val = '641adb14666c465380';
session_start();
$user_type_unique_id = $_SESSION['user_type_unique_id'];

$unique_id = isset($_GET['unique_id']) ? $_GET['unique_id'] : null;
$vendor_id = isset($_GET['vendor_id']) ? $_GET['vendor_id'] : null;
$bill_no = isset($_GET['bill_no']) ? $_GET['bill_no'] : null;
$bill_date = isset($_GET['bill_date']) ? $_GET['bill_date'] : null;
$accounts_approval = isset($_GET['accounts_approval']) ? $_GET['accounts_approval'] : null;


if (isset($_GET["vendor_id"])) {
    if (!empty($_GET["vendor_id"])) {

        $vendor_id = $_GET["vendor_id"];
        $where = [
            "unique_id" => $vendor_id
        ];

        $table = "vendor_creation";

        $columns = [
            "name",
            "contact_no",
            "mail_id",
            "address",
            "account_no",
            "ifsc_code",
            "bank_name",
            "branch_name",
            "(SELECT d.district_name from district_creation d LEFT JOIN vendor_creation v ON d.unique_id = v.district_name LIMIT 1) AS district_name",
            "pincode"
        ];

        $table_details = [
            $table,
            $columns
        ];
        $result_values = $pdo->select($table_details, $where);
        if ($result_values->status) {

            $result_values = $result_values->data;

            $name = $result_values[0]["name"];
            $contact_no = $result_values[0]["contact_no"];
            $mail_id = $result_values[0]["mail_id"];
            $address = $result_values[0]["address"];
            $account_no = $result_values[0]["account_no"];
            $ifsc_code = $result_values[0]["ifsc_code"];
            $bank_name = $result_values[0]["bank_name"];
            $branch_name = $result_values[0]["branch_name"];
            $district_name = $result_values[0]["district_name"];
            $pincode = $result_values[0]["pincode"];
        } else {
            $btn_text = "Error";
            $btn_action = "error";
            $is_btn_disable = "disabled='disabled'";
        }
    }
}
?>

<!----content start---------->
<div class="col-xxl-12">
    <div class="card">
        <input type="hidden" name="unique_id" id="unique_id" value="<?= $unique_id ?>">
        <input type="hidden" name="bill_no" id="bill_no" value="<?= $bill_no ?>">
        <input type="hidden" name="vendor_id" id="vendor_id" value="<?= $vendor_id ?>">
        <input type="hidden" name="vendor_name" id="vendor_name" value="<?= $name ?>">
        <div class="card-body">
            <div class="card-header" style="margin:0px !important">
                <h5 class="modal-title fw-bold w-100" style="color: #506018;">Account Team Approval</h5>
            </div>
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h6 class="mb-3 fw-semibold ">Payment Summary</h6>
                    <div class="row g-4">
                        <div class="col-md-5">
                            <div class="d-flex">
                                <strong class="label-col text-body-secondary">Bill No.</strong>
                                <span>:</span>
                                <span class="ms-2"><?= $bill_no ?></span>
                            </div>
                            <div class="d-flex">
                                <strong class="label-col text-body-secondary">Bill Date</strong>
                                <span>:</span>
                                <span class="ms-2"><?= date('d-m-Y', strtotime($bill_date)) ?></span>
                            </div>
                            <div class="d-flex">
                                <strong class="label-col text-body-secondary">Mail Id</strong>
                                <span>:</span>
                                <span class="ms-2"><?= $mail_id ?></span>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="d-flex">
                                <strong class="label-col text-body-secondary">Vendor Name</strong>
                                <span>:</span>
                                <span class="ms-2"><?= $name ?></span>
                            </div>
                            <div class="d-flex">
                                <strong class="label-col text-body-secondary">Address</strong>
                                <span>:</span>
                                <span class="ms-2"><?= $address ?>, <?= $district_name ?>, <?= $pincode ?></span>
                            </div>
                            <div class="d-flex">
                                <strong class="label-col text-body-secondary">Contact No</strong>
                                <span>:</span>
                                <span class="ms-2"><?= $contact_no ?></span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div id="list">
                <div class="table-responsive">
                    <table id="vendor_datatable" class="table table-bordered table-striped table-hover align-middle">
                        <thead>
                            <tr>
                                <!-- <th>Selection<br>(Select All)
                                    <?php echo '<input type="checkbox" id="select_all">' ?>
                                </th> -->
                                <th style="text-align:center;">S.No</th>
                                <th style="text-align:center;">PO No. / Date</th>
                                <th style="text-align:center;">Invoice No / Date</th>
                                <th style="text-align:center;">Invoice Qty</th>
                                <th style="text-align:center;">DC No / Date</th>
                                <th style="text-align:center;">Rate</th>
                                <th style="text-align:center;">GST</th>
                                <th style="text-align:center;">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-12 d-flex justify-content-end align-items-center">
                    <label class="fw-bold me-2 mb-0">Total Amount:
                        <span id="ttl_span_amnt" class="fw-bold text-success"
                            style="display: inline-block;color: #506018 !important;font-size:15px !important;"></span>
                    </label>
                </div>
            </div>
            <div class="row mt-2 mb-3">
                <div class="col-md-12 d-flex justify-content-end align-items-center">
                    <label class="fw-bold me-2 mb-0">Total Amount In Words: &nbsp;
                        <span id="ttl_span_amnt_words" class="fw-bold text-success"
                            style="display: inline-block;color: #506018 !important;font-size:15px !important;"></span>
                    </label>
                </div>
            </div>

            <div class="row mt-3 align-items-end" style="margin:50px 0 0 0;">
                <!-- Transaction Type -->
                <div class="col-md-3">
                    <label for="transaction_type" class="form-label fw-bold">Transaction Type</label>
                    <select class="form-select" id="transaction_type">
                        <option value="" selected>Select transaction type</option>
                        <option value="1">Cash</option>
                        <option value="2">Bank</option>
                        <option value="3">UPI</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="transaction_date" class="form-label fw-bold">Transaction Date</label>
                    <input type="date" class="form-control" id="transaction_date">
                </div>

                <!-- Cash Section -->
                <div class="col-md-3" id="cash_section" style="display: none;">
                    <label for="cash_receipt" class="form-label">Upload Cash Receipt</label>
                    <input type="file" class="form-control" id="cash_receipt" accept=".jpg,.png,.pdf">
                </div>

                <!-- Online Section -->
                <div class="col-md-3" id="online_section" style="display: none;">
                    <label for="online_type" class="form-label">Select Online Method</label>
                    <select class="form-select" id="online_type">
                        <option value="" selected disabled>Select method</option>
                        <option value="1">Google Pay</option>
                        <option value="2">PhonePe</option>
                        <option value="3">Paytm</option>
                    </select>
                </div>
                <!-- UPI ID Field (hidden by default) -->
                <div class="col-md-3" id="upi_id_section" style="display: none;">
                    <label for="upi_id" class="form-label">UPI ID</label>
                    <input type="text" class="form-control" id="upi_id" placeholder="Enter UPI ID">
                </div>

                <!-- Mobile Number Field (hidden by default) -->
                <div class="col-md-3" id="upi_mobile_section" style="display: none;">
                    <label for="upi_mobile" class="form-label">Mobile Number</label>
                    <input type="text" class="form-control" id="upi_mobile" placeholder="Enter mobile number">
                </div>

                <!-- Transaction ID Field (hidden by default) -->
                <div class="col-md-3 mt-3" id="upi_transaction_section_2" style="display: none;">
                    <label for="transaction_id" class="form-label">Transaction ID</label>
                    <input type="text" class="form-control" id="transaction_id_2" placeholder="Enter transaction id">
                </div>
            </div>
            <div class="row mt-3 align-items-end" style="margin:50px 0 0 0;">

                <!-- Bank Section -->
                <div class="col-md-12" id="bank_section" style="display: none;">
                    <div class="row g-4">
                        <div class="col-md-3">
                            <div class="d-flex">
                                <strong class="label-col text-body-secondary">Bank Name</strong>
                                <span>:</span>
                                <span class="ms-2"><?= $bank_name ?></span>
                                <input type="hidden" name="bank_name" id="bank_name" value="<?= $bank_name ?>">
                            </div>
                            <div class="d-flex">
                                <strong class="label-col text-body-secondary">IFSC Code</strong>
                                <span>:</span>
                                <span class="ms-2"><?= $ifsc_code ?></span>
                                <input type="hidden" name="ifsc_code" id="ifsc_code" value="<?= $ifsc_code ?>">
                            </div>
                            <div class="d-flex">
                                <strong class="label-col text-body-secondary">Pincode</strong>
                                <span>:</span>
                                <span class="ms-2"><?= $pincode ?></span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="d-flex">
                                <strong class="label-col text-body-secondary">Account No</strong>
                                <span>:</span>
                                <span class="ms-2"><?= $account_no ?></span>
                                <input type="hidden" name="account_no" id="account_no" value="<?= $account_no ?>">
                            </div>
                            <div class="d-flex">
                                <strong class="label-col text-body-secondary">Branch Name</strong>
                                <span>:</span>
                                <span class="ms-2"><?= $branch_name ?></span>
                                <input type="hidden" name="branch_name" id="branch_name" value="<?= $branch_name ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="d-flex">
                                <strong class="label-col text-body-secondary"><label for="transaction_id"
                                        class="form-label">Transaction ID</label></strong>
                                <span>:</span>
                                <span class="ms-2"><input type="text" class="form-control" id="transaction_id_1"></span>
                            </div>
                        </div>
                        <!-- <div class="col-md-2">
                            <div class="col-md-3 mt-3" id="upi_transaction_section_1">
                                <label for="transaction_id" class="form-label">Transaction ID</label>
                                <input type="text" class="form-control" id="transaction_id_1"
                                    placeholder="Enter transaction id">
                            </div>
                        </div> -->
                    </div>
                </div>

            </div>

            <div class="row mt-2">
                <div class="form-group row">
                    <div class="col-md-12 text-end">
                        <?= btn_cancel($btn_cancel); ?>
                        <?php if ($accounts_approval != '1'): ?>
                            <button type="button" class="btn btn-success" onclick="vendor_payment()">Submit</button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {

            const today = new Date();
            const formattedDate = today.getFullYear() + '-' +
                String(today.getMonth() + 1).padStart(2, '0') + '-' +
                String(today.getDate()).padStart(2, '0');

            document.getElementById("transaction_date").value = formattedDate;

            // var po_num = $(this).data('ponum');
            var vendor = document.getElementById("vendor_id").value;
            var bill_no = document.getElementById("bill_no").value;

            // document.getElementById("po_num").value = po_num;
            // document.getElementById("vendor_name").value = vendor;

            var ajax_url = sessionStorage.getItem("folder_crud_link");

            $.ajax({
                url: ajax_url,
                method: 'POST',
                data: {
                    // po_num: po_num,
                    vendor: vendor,
                    bill_no: bill_no,
                    action: 'vendor_payment_details'
                },
                success: function (response) {
                    var res = JSON.parse(response);

                    if (res.data && res.data.length > 0) {
                        const firstRow = res.data[0];
                        $('#invoice_val').text(firstRow.invoice_no);

                        let total_amount = 0;
                        let tableHtml = '';

                        res.data.forEach((row, index) => {
                            let rawAmount = row.sum_amount || '0';

                            // Remove ₹ symbol and commas if present, then parse
                            let cleanAmount = parseFloat(
                                rawAmount.toString().replace(/₹/g, '').replace(/,/g, '')
                            ) || 0;

                            total_amount += cleanAmount;

                            tableHtml += `
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${row.po_num}</td>
                                    <td>${row.invoice_no}</td>
                                    <td>${row.invoice_qty}</td>
                                    <td>${row.dc_num}</td>
                                    <td>${row.rate}</td>
                                    <td>${row.gst}</td>
                                    <td>${row.amount}</td>
                                </tr>
                            `;
                        });

                        $('#vendor_datatable tbody').html(tableHtml);

                        // Format total amount with 2 decimal places in Indian format
                        const formattedTotal = total_amount.toLocaleString('en-IN', {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });

                        $('#ttl_span_amnt').text('₹ ' + formattedTotal);

                        // Convert to words using your own decimal-aware function
                        $('#ttl_span_amnt_words').text(numberToWords(total_amount));
                    } else {
                        $('#vendor_datatable tbody').html('<tr><td colspan="8" class="text-center">No data found</td></tr>');
                    }
                },
                error: function () {
                    alert('Failed to fetch details');
                }

            });
        });

        // function vendor_payment() {
        //     var ajax_url = sessionStorage.getItem("folder_crud_link");

        //     var vendor_name = $('#vendor_name').val();
        //     var bill_no = $('#bill_no').val();
        //     var transaction_type = $('#transaction_type').val();

        //     var data = new FormData();
        //     data.append("vendor_name", vendor_name);
        //     data.append("bill_no", bill_no);
        //     data.append("transaction_type", transaction_type);

        //     // Transaction Type: 1 - Cash
        //     if (transaction_type == 1) {
        //         var cashReceipt = document.getElementById("cash_receipt");
        //         if (cashReceipt && cashReceipt.files.length > 0) {
        //             data.append("cash_receipt", cashReceipt.files[0]);
        //         } else {
        //             data.append("cash_receipt", '');
        //         }

        //         data.append("bank_name", "");
        //         data.append("ifsc_code", "");
        //         data.append("account_no", "");
        //         data.append("branch_name", "");
        //         data.append("online_type", "");
        //         data.append("upi_id", "");
        //         data.append("upi_mobile", "");
        //     }

        //     // Transaction Type: 2 - Bank
        //     else if (transaction_type == 2) {
        //         var bank_name = $('#bank_name').val();
        //         var ifsc_code = $('#ifsc_code').val();
        //         var account_no = $('#account_no').val();
        //         var branch_name = $('#branch_name').val();

        //         data.append("bank_name", bank_name);
        //         data.append("ifsc_code", ifsc_code);
        //         data.append("account_no", account_no);
        //         data.append("branch_name", branch_name);

        //         data.append("online_type", "");
        //         data.append("upi_id", "");
        //         data.append("upi_mobile", "");
        //         data.append("cash_receipt", '');
        //     }

        //     // Transaction Type: 3 - UPI
        //     else if (transaction_type == 3) {
        //         var online_type = $('#online_type').val();
        //         var upi_id = $('#upi_id').val();
        //         var upi_mobile = $('#upi_mobile').val();

        //         data.append("online_type", online_type);
        //         data.append("upi_id", upi_id);
        //         data.append("upi_mobile", upi_mobile);

        //         data.append("bank_name", "");
        //         data.append("ifsc_code", "");
        //         data.append("account_no", "");
        //         data.append("branch_name", "");
        //         data.append("cash_receipt", '');
        //     }

        //     // If no transaction type matched
        //     else {
        //         data.append("bank_name", "");
        //         data.append("ifsc_code", "");
        //         data.append("account_no", "");
        //         data.append("branch_name", "");
        //         data.append("online_type", "");
        //         data.append("upi_id", "");
        //         data.append("upi_mobile", "");
        //         data.append("cash_receipt", '');
        //     }

        //     data.append("action", "payment_store_detail");

        //     $.ajax({
        //         type: "POST",
        //         url: ajax_url,
        //         data: data,
        //         processData: false,
        //         contentType: false,
        //         success: function (response) {
        //             sweetalert('create');
        //             window.location = "index.php?file=accounts_vendor_approval/list";
        //         },
        //         error: function () {
        //             alert("Network Error");
        //         }
        //     });
        // }

        function vendor_payment() {
            var ajax_url = sessionStorage.getItem("folder_crud_link");

            var vendor_name = $('#vendor_name').val();
            var bill_no = $('#bill_no').val();
            var transaction_type = $('#transaction_type').val();
            var transaction_date = $('#transaction_date').val();

            if (!transaction_type && !transaction_date) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Missing Fields',
                    text: 'Please Select Transaction Details.'
                });
                return;
            }

            var data = new FormData();
            data.append("vendor_name", vendor_name);
            data.append("bill_no", bill_no);
            data.append("transaction_type", transaction_type);
            data.append("transaction_date", transaction_date);

            // Transaction Type: 1 - Cash
            if (transaction_type == "1") {
                var cashReceipt = document.getElementById("cash_receipt");
                if (!cashReceipt || cashReceipt.files.length === 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Cash Receipt Required',
                        text: 'Please upload the Cash Receipt.'
                    });
                    return;
                }

                data.append("cash_receipt", cashReceipt.files[0]);

                data.append("bank_name", "");
                data.append("ifsc_code", "");
                data.append("account_no", "");
                data.append("branch_name", "");
                data.append("online_type", "");
                data.append("upi_id", "");
                data.append("upi_mobile", "");
                data.append("transaction_id", "");
            }

            // Transaction Type: 2 - Bank
            else if (transaction_type == "2") {
                var bank_name = $('#bank_name').val();
                var ifsc_code = $('#ifsc_code').val();
                var account_no = $('#account_no').val();
                var branch_name = $('#branch_name').val();
                var transaction_id_1 = $('#transaction_id_1').val();

                if (!bank_name || !ifsc_code || !account_no || !branch_name || !transaction_id_1) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Missing Bank Details',
                        text: 'Please fill out all Bank details.'
                    });
                    return;
                }

                data.append("bank_name", bank_name);
                data.append("ifsc_code", ifsc_code);
                data.append("account_no", account_no);
                data.append("branch_name", branch_name);
                data.append("transaction_id_1", transaction_id_1);

                data.append("online_type", "");
                data.append("upi_id", "");
                data.append("upi_mobile", "");
                data.append("transaction_id_2", "");
                data.append("cash_receipt", '');
            }

            // Transaction Type: 3 - UPI
            else if (transaction_type == "3") {
                var online_type = $('#online_type').val();
                var upi_id = $('#upi_id').val();
                var upi_mobile = $('#upi_mobile').val();
                var transaction_id_2 = $('#transaction_id_2').val();

                if (!online_type || !upi_id || !upi_mobile || !transaction_id_2) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Missing UPI Details',
                        text: 'Please fill out all UPI payment details.'
                    });
                    return;
                }

                data.append("online_type", online_type);
                data.append("upi_id", upi_id);
                data.append("upi_mobile", upi_mobile);
                data.append("transaction_id_2", transaction_id_2);

                data.append("bank_name", "");
                data.append("ifsc_code", "");
                data.append("account_no", "");
                data.append("branch_name", "");
                data.append("cash_receipt", "");
                data.append("transaction_id_1", "");
            }

            // Invalid transaction type
            else {
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid Transaction Type',
                    text: 'Please select a valid payment method.'
                });
                return;
            }

            data.append("action", "payment_store_detail");

            $.ajax({
                type: "POST",
                url: ajax_url,
                data: data,
                processData: false,
                contentType: false,
                success: function (response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Payment details saved successfully.'
                    }).then(() => {
                        window.location = "index.php?file=accounts_vendor_approval/list";
                    });
                },
                error: function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'Network Error',
                        text: 'Something went wrong. Please try again.'
                    });
                }
            });
        }



        $("#export").click(function () {
            // alert("hi");
            window.location = "folders/payment/excel.php";
        });
        $(document).ready(function () {
            get_user_permission();

        });

        function get_user_permission() {
            var screen_id_val = $('#screen_id_val').val();

            var user_type_unique_id = $('#user_type_unique_id').val();

            var data = {
                "screen_id_val": screen_id_val,
                "user_type_unique_id": user_type_unique_id,
                "action": 'user_permission',
            };

            var ajax_url = sessionStorage.getItem("folder_crud_link");
            var url = sessionStorage.getItem("list_link");

            // console.log(data);
            $.ajax({
                type: "POST",
                url: ajax_url,
                data: data,
                success: function (data) {

                    var obj = JSON.parse(data);

                    var dataString = obj.data;

                    var listpage = document.getElementById('list');

                },
                error: function (data) {
                    alert("Network Error");
                }
            });
        }


        $(document).on('change', '#select_all', function () {
            $('.myCheck').prop('checked', this.checked);
        });

        $(document).ready(function () {
            $('#transaction_type').on('change', function () {
                var value = $(this).val();

                // Hide all sections initially
                $('#cash_section').hide();
                $('#bank_section').hide();
                $('#online_section').hide();
                $('#upi_id_section').hide();
                $('#upi_mobile_section').hide();
                $('#upi_transaction_section_2').hide();

                // Show selected section
                if (value === '1') {
                    $('#cash_section').show();
                } else if (value === '2') {
                    $('#bank_section').show();
                } else if (value === '3') {
                    $('#online_section').show();
                }
            });
        });

        function fetchBankDetails(transaction_type) {
            const vendor = $('#vendor_name').val();

            var ajax_url = sessionStorage.getItem("folder_crud_link");

            if (!vendor || !transaction_type) return;

            $.ajax({
                url: ajax_url,
                type: 'POST',
                data: {
                    action: 'getbankdeails',
                    vendor_name: vendor,
                    transaction_type: transaction_type
                },
                success: function (response) {
                    console.log('Bank Details:', response); // handle your logic here
                },
                error: function () {
                    alert('Failed to fetch bank details');
                }
            });
        }

        function numberToWords(num) {
            const ones = [
                '', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine',
                'Ten', 'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen',
                'Seventeen', 'Eighteen', 'Nineteen'
            ];

            const tens = [
                '', '', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy',
                'Eighty', 'Ninety'
            ];

            // Scales for Indian numbering system (Thousand, Lakh, Crore)
            const scales = ['', 'Thousand', 'Lakh', 'Crore'];

            // Helper function to convert a two or three-digit number to words
            function convertLessThanOneThousand(n) {
                let words = '';
                if (n >= 100) {
                    words += ones[Math.floor(n / 100)] + ' Hundred ';
                    n %= 100;
                }
                if (n < 20) {
                    words += ones[n];
                } else {
                    words += tens[Math.floor(n / 10)];
                    if (n % 10 > 0) {
                        words += ' ' + ones[n % 10];
                    }
                }
                return words.trim();
            }

            // Convert number to string and split into rupees and paise
            // Use Math.round for better precision with floating-point numbers
            const numStr = (Math.round(parseFloat(num) * 100) / 100).toFixed(2).toString();
            const [rupeesStr, paiseStr] = numStr.split('.');
            let rupees = parseInt(rupeesStr);
            const paise = parseInt(paiseStr);

            let result = '';

            // Convert rupees part
            if (rupees === 0) {
                result = 'Zero Rupees';
            } else {
                let rupeesWords = [];
                let scaleIndex = 0; // Represents the index for scales array

                // Handle negative numbers (optional, but good practice)
                if (rupees < 0) {
                    result += 'Minus ';
                    rupees = Math.abs(rupees);
                }

                // Process number in groups of 2 for Lakhs/Crores, and 3 for Thousands
                // Indian numbering system: last three digits (hundreds, tens, ones), then groups of two
                // e.g., 1,23,45,678 -> 1 Crore, 23 Lakh, 45 Thousand, 678

                // Handle the first three digits (0-999)
                if (rupees % 1000 !== 0) {
                    rupeesWords.unshift(convertLessThanOneThousand(rupees % 1000));
                }
                rupees = Math.floor(rupees / 1000);
                scaleIndex++; // Now we are at 'Thousand' scale

                while (rupees > 0) {
                    let chunk;
                    if (scaleIndex === 1) { // For Thousands, it's a group of 2 (tens and ones of thousands)
                        chunk = rupees % 100;
                        rupees = Math.floor(rupees / 100);
                    } else { // For Lakhs and Crores, it's a group of 2
                        chunk = rupees % 100;
                        rupees = Math.floor(rupees / 100);
                    }

                    if (chunk > 0) {
                        let chunkWords = convertLessThanOneThousand(chunk);
                        if (scales[scaleIndex]) { // Add scale only if it exists
                            chunkWords += ' ' + scales[scaleIndex];
                        }
                        rupeesWords.unshift(chunkWords);
                    }
                    scaleIndex++;
                }

                result = rupeesWords.join(' ').trim() + ' Rupees';
            }

            // Convert paise part
            if (paise > 0) {
                let paiseWords = convertLessThanOneThousand(paise);
                if (paiseWords) { // Only add if paiseWords is not empty
                    result += ' and ' + paiseWords + ' Paise';
                }
            } else if (paise === 0 && numStr.includes('.')) {
                // If there's a decimal part but paise is 0, add "Zero Paise"
                // This handles cases like 100.00 where we still want "Zero Paise"
                result += ' and Zero Paise';
            }

            return result.trim();
        }

        // function numberToWords(num) {
        //     const ones = [
        //         '', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine',
        //         'Ten', 'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen',
        //         'Seventeen', 'Eighteen', 'Nineteen'
        //     ];

        //     const tens = [
        //         '', '', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy',
        //         'Eighty', 'Ninety'
        //     ];

        //     const scales = ['', 'Thousand', 'Lakh', 'Crore'];

        //     function convertLessThanOneThousand(n) {
        //         let words = '';
        //         if (n >= 100) {
        //             words += ones[Math.floor(n / 100)] + ' Hundred ';
        //             n %= 100;
        //         }
        //         if (n < 20) {
        //             words += ones[n];
        //         } else {
        //             words += tens[Math.floor(n / 10)];
        //             if (n % 10 > 0) {
        //                 words += ' ' + ones[n % 10];
        //             }
        //         }
        //         return words.trim();
        //     }

        //     let rupees = Math.floor(Number(num)); // Only take integer part
        //     let result = '';

        //     if (rupees === 0) {
        //         result = 'Zero Rupees';
        //     } else {
        //         let rupeesWords = [];
        //         let scaleIndex = 0;

        //         if (rupees < 0) {
        //             result += 'Minus ';
        //             rupees = Math.abs(rupees);
        //         }

        //         if (rupees % 1000 !== 0) {
        //             rupeesWords.unshift(convertLessThanOneThousand(rupees % 1000));
        //         }
        //         rupees = Math.floor(rupees / 1000);
        //         scaleIndex++;

        //         while (rupees > 0) {
        //             let chunk = rupees % 100;
        //             rupees = Math.floor(rupees / 100);
        //             if (chunk > 0) {
        //                 let chunkWords = convertLessThanOneThousand(chunk);
        //                 if (scales[scaleIndex]) {
        //                     chunkWords += ' ' + scales[scaleIndex];
        //                 }
        //                 rupeesWords.unshift(chunkWords);
        //             }
        //             scaleIndex++;
        //         }

        //         result += rupeesWords.join(' ').trim() + ' Rupees';
        //     }

        //     return result.trim();
        // }


        document.getElementById('online_type').addEventListener('change', function () {
            const selectedMethod = this.value;
            const upiIdSection = document.getElementById('upi_id_section');
            const upiMobileSection = document.getElementById('upi_mobile_section');
            const upiTransactionSection = document.getElementById('upi_transaction_section_2');

            // Hide both sections first
            upiIdSection.style.display = 'none';
            upiMobileSection.style.display = 'none';
            upiTransactionSection.style.display = 'none';

            // Show relevant sections based on selection
            if (selectedMethod === '1' || selectedMethod === '2' || selectedMethod === '3') {
                upiIdSection.style.display = 'block';
                upiMobileSection.style.display = 'block';
                upiTransactionSection.style.display = 'block';
            }

            // If you want to show only one field for specific methods:
            /*
            if (selectedMethod === '1') { // Google Pay
                upiIdSection.style.display = 'block';
            } else if (selectedMethod === '2') { // PhonePe
                upiMobileSection.style.display = 'block';
            } else if (selectedMethod === '3') { // Paytm
                upiIdSection.style.display = 'block';
                upiMobileSection.style.display = 'block';
            }
            */
        });

    </script>
