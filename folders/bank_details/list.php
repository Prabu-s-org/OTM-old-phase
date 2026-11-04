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

    #lbs {
        font-size: 16px;
        font-weight: bold;
    }

    .spans {
        color: #1a7db7;
        font-size: 13px;
        font-weight: unset;
    }

    #po_no_datatable {
        border: 1px solid black;
        /* Bold black border for the table */
    }

    #po_no_datatable th,
    #po_no_datatable td {
        border: 1px solid black;
        /* Bold black border for table cells */
    }

    #po_no_datatable thead th {
        background-color: #f8f9fa;
        /* Optional: Light background for header */
    }


    /* Ensure the table's borders collapse properly */
    #po_no_datatable {
        border-collapse: collapse;
    }

    #invoice_datatable {
        border: 1px solid black;
        /* Bold black border for the table */
    }

    #invoice_datatable th,
    #invoice_datatable td {
        border: 1px solid black;
        /* Bold black border for table cells */
    }

    #invoice_datatable thead th {
        background-color: #f8f9fa;
        /* Optional: Light background for header */
    }



    .spinner {
        border: 6px solid #f3f3f3;
        border-top: 6px solid #3498db;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        margin: auto;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.3.0/exceljs.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<div class="container-fluid mt-4">
    <div class="card">
        <div class="card-header">
            <h4>Vendor Account Details</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="vendor_payment_report" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Vendor Name</th>
                            <th>Name As Per Bank Account</th>
                            <th>Bank Name</th>
                            <th>Branch Name</th>
                            <th>Account No</th>
                            <th>IFSC Code</th>
                            <th>Entered By</th>
                            <th>Operation Approval</th>
                            <th>Management Approval</th>
                            <th>Finance Approval</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
