<!-- This file Only PHP Functions -->
<?php include 'function.php'; ?>
<?php
include '../../config/dbconfig.php';
include '../../inc/header.php';
include '../../inc/footer.php';

$btn_text           = "Save";
$btn_action         = "create";
$is_btn_disable     = "";

$unique_id          = "";

$user_type               = "";
$under_user_type        = "";
$exp_under_user_type     = "";

$is_active          = 1;

$session_approved_by = $_SESSION["staff_name"];


?>
<style>
    label {
        /* font-weight: bold;
  color: black; */
        margin-right: 20px;
        /* You can add more styles as needed */
    }
    #pos{
        width: 129.8px;
    }

</style>

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Pending List</h4>
            <input type="hidden" id="screen_id_val" name="screen_id_val" class="form-control"
                value="<?php echo $screen_id_val; ?>">
            <input type="hidden" id="user_type_unique_id" name="user_type_unique_id" class="form-control"
                value="<?php echo $user_type_unique_id; ?>">

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Form</a></li>
                    <li class="breadcrumb-item active">Delivery Confrimation</li>
                 
                </ol>
            </div>
        </div>

      
    </div>
</div>

<div class="row">
    <div class="card">
        <div class="col-12">
            <div class="card-body">
                <div class="table-responsive">
                   <table id="deleivery_datatable1" class="table table-bordered table-striped align-middle">
                            <thead>
                                <tr>
                                     <th>Selection<br>(Select All)
                                <?php echo '<input type="checkbox" id="select_all">' ?></th>
                                    <th style="text-align: center;">S.No</th>
                                    <th style="text-align: center;">Po No</th>
                                    <th style="width: 150px; text-align: center;">Location</th>

                                    <th style="text-align: center;">Followed By</th>
                                    <th style="text-align: center;">Invoice</th>
                                    <th style="text-align: center;">DC</th>
                                    <th style="text-align: center;">Delivery Mode</th>
                                    <th style="text-align: center;">Delivery Date</th>
                                    <th style="text-align: center;">Attachment</th>
                                </tr>
                            </thead>
                        </table>
                </div>
            </div>
        </div>
 <div class="row">
            <h6 class="text-uppercase fw-semibold mb-3">Contact Person Details</h6>
               <?php if($view !=''){?>
 <div class="col-md-3">
              <div class="mb-3">
                <label class="form-label">Delivery Confirmed Person</label>
                <br>
                <label class="form-label"><strong><?php echo $delv_conf_person;?></strong></label>
                 </div>
            </div>
                <?php }?>

            <div class="col-md-3">
              <div class="mb-3">
                <label class="form-label">Person Name</label>
               <?php if($view !=''){?>
                <br>
                <label class="form-label"><strong><?php echo $rec_person_name;?></strong></label>
                <?php }else{?>
                <input type="text" id="person_name" name="person_name" onkeypress="allowOnlyAlphabets(event)" class="form-control" value="">
                <?php }?>

                 </div>
            </div>

            <div class="col-md-3">
              <div class="mb-3">
                <label class="form-label">Contact No</label>
                <!-- <input type="text" id="contact_no" name="contact_no" class="form-control" required pattern="^\d{10}$" maxlength="10" title="Enter exactly 10 digits (0-9)" /> -->
               <?php if($view !=''){?>
                <br>
                <label class="form-label"><strong><?php echo $rec_contact_no;?></strong></label>
                <?php }else{?>
            <input type="text" id="contact_no" name="contact_no" class="form-control" required pattern="^\d{10}$" maxlength="10" title="Enter exactly 10 digits (0-9)" oninput="this.value = this.value.replace(/[^0-9]/g, '')" />
                <?php }?>

            </div>
            </div>

            <div class="col-md-3">
              <div class="mb-3">
                <label class="form-label">Product Received Date</label>
                  <?php if($view !=''){?>
                <br>
                <label class="form-label"><strong><?php echo date("d-m-Y", strtotime($pro_rec_date));?></strong></label>
                <?php }else{?>
                <input type="date" id="pro_rec_date" name="pro_rec_date" class="form-control" required value="">
                <?php }?>
              
            </div>
            </div>

            <div class="col-md-3">
              <div class="mb-3">
                <label class="form-label">Remarks</label>
                  <?php if($view !=''){?>
                <br>
                <label class="form-label"><strong><?php echo $deliv_remarks;?></strong></label>
                <?php }else{?>
                <textarea id="remarks" name="remarks"  onkeypress="allowAlphanumSymbol(event)" class="form-control"></textarea>
                <?php }?>
              </div>
            </div>


          </div>
        <div class="col-12 mt-3 mb-3">
            <div class="form-group row ">
                <div class="col-md-12" align="right">
                
                    <?php echo btn_cancel($btn_cancel); ?>
                    <button type="button" class="btn btn-primary waves-effect waves-light" id="approve_btn"  onclick="deliveryapproval()">Approve</button>
                </div>
            </div>
        </div>
    </div>
</div>
 

                             

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
    document.getElementById('select_all').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.myCheck');
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = this.checked;
        }.bind(this));
    });
    
    $(document).ready(function() {
       var table_id = 'deleivery_datatable1';

        var screen_id_val = $('#screen_id_val').val();
        var user_type_unique_id = $('#user_type_unique_id').val();
        var team_mem3 = $('#team_mem3').val();
        var table = $("#" + table_id);
        var from_date = $("#from_date_de").val();
        var to_date = $("#to_date_de").val();
        var opt3 = $("#opt3").val();
        var action = "deleivery_datatable1";
        var data = {
            "action": action,
            "from_date": from_date,
            "to_date": to_date,
            "opt3": opt3,
            "screen_id_val": screen_id_val,
            "team_mem3": team_mem3,
            "user_type_unique_id": user_type_unique_id,
        };

        var ajax_url = sessionStorage.getItem("folder_crud_link");

        var datatable = table.DataTable({
            destroy: true,
            ordering: true,
            searching: true,
            ajax: {
                url: ajax_url,
                type: "POST",
                data: data
            },
             columnDefs: [
    {
        targets: [8,9], // columns 1 to 8 (0-indexed)
        className: 'text-center'    // Applies Bootstrap's center alignment
    }
],
            dom: '<"dt-top-container"<l><"dt-center-in-div"B><f>r>t<ip>',
            buttons: [{
                    extend: 'copyHtml5',
                    text: 'Copy',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'csvHtml5',
                    text: 'CSV',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'excelHtml5',
                    text: 'Excel',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'pdfHtml5',
                    text: 'PDF',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'print',
                    text: 'Print',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'colvis',
                    text: 'Column Visibility',
                   action: function (e, dt, node, config) {
					// Open the column visibility modal when the button is clicked
					$('#columnVisibilityModal').modal('show');

					// Populate the modal with checkboxes for each column
					var columns = dt.columns().header();
					var form = $('#columnVisibilityForm');
					form.empty(); // Clear any existing checkboxes

					// Append checkboxes one by one for each column
					columns.each(function (header, index) {
						var isChecked = dt.column(index).visible();
						var colMarkup = `
							<div class="form-check">
								<input type="checkbox" class="form-check-input" data-column="${index}" ${isChecked ? 'checked' : ''}>
								<label class="form-check-label">${$(header).text()}</label>
							</div>
						`;
						form.append(colMarkup); // Append each checkbox in a vertical list
					});
				}
                }
            ],
            lengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
            pageLength: 10
        });

        $('#columnVisibilityForm').on('change', 'input[type="checkbox"]', function() {
            var columnIdx = $(this).data('column');
            var isVisible = $(this).is(':checked');
            datatable.column(columnIdx).visible(isVisible);
        });
    });


    function deliveryapproval() {
    var person_name = document.getElementById('person_name').value;
    var contact_no = document.getElementById('contact_no').value;
    var pro_rec_date = document.getElementById('pro_rec_date').value;
    var remarks = document.getElementById('remarks').value;

    // if (contact_no === '' || pro_rec_date === '') {
    //     sweetalert("form_alert");
    //     return;
    // }

    // Collect all selected checkboxes
    var selectedCheckboxes = document.querySelectorAll('.myCheck:checked');

    if (selectedCheckboxes.length === 0) {
        alert("Please select at least one record to approve.");
        return;
    }

    var ajax_url = sessionStorage.getItem("folder_crud_link");
    var url = sessionStorage.getItem("list_link");

    // Iterate through all selected rows and send separate AJAX calls
    selectedCheckboxes.forEach(function (checkbox, index) {
        var dc_number = checkbox.getAttribute("data-dc-number");
        var consignee_unique_id = checkbox.getAttribute("data-consignee-id");
        var unique_id = checkbox.getAttribute("data-unique-id");

        var data = new FormData();
        data.append("person_name", person_name);
        data.append("contact_no", contact_no);
        data.append("pro_rec_date", pro_rec_date);
        data.append("remarks", remarks);
        data.append("dc_number", dc_number);
        data.append("consignee_unique_id", consignee_unique_id);
        data.append("unique_id", unique_id);
        data.append("delv_con", "3");
        data.append("action", "deleivery_confirmation1");

        $.ajax({
            type: "POST",
            url: ajax_url,
            data: data,
            contentType: false,
            processData: false,
            success: function (data) {

               if (index === selectedCheckboxes.length - 1) {
    if (index === selectedCheckboxes.length - 1) {
    Swal.fire({
        title: "Approved successfully",
        icon: "success"
    }).then(() => {
        window.location.href = url; // redirect to your list page
    });
}
}

            },
            error: function () {
                alert("Network Error");
            }
        });
    });
}


    
</script>
