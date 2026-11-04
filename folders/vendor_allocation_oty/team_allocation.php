<?php include 'function.php'; ?>

<?php

include '../../config/dbconfig.php';
include '../../inc/header.php';
include '../../inc/footer.php';





?>
<div class="row">
<div class="card">
<div class="card-body">
    <center>
<h3>TEAM ALLOCATION LIST</h3>
</center>
</div>
</div>

<?php 





$state_type_options = state_option();
$state_type_options = select_option($state_type_options, "Select State", $state_name);

$district_type_options = district_option();
$district_type_options = select_option($district_type_options, "Select District", $district_name);

// 
$eng_name_options = engineer_name_options();
// pri/nt_r($eng_name_options);die();
// 
$eng_name_options = select_option($eng_name_options, "Select Engineer Name", $eng_name);





$vendor_name = vendor_names();

$vendor_option = select_option($vendor_name,"Select Vendor");





$engineer_name_optionss = engineer_name();
    $engineer_name_options1 = select_option($engineer_name_optionss, "Select Engineer Name");


        //vendor name
        $engineer_type_options = engineer_type();
        $engineer_type_options1 = select_option($engineer_type_options, "Select Eng Name");

?>




<div class="card">
    <div class="card-body">
              <div class="row g-3">
                  
                  
                  <div class="col-md-2">
                <label class="form-label">Region</label>
                <select name="region" id="region" class="select2 form-control" required>
    <option value="">Select Region</option>
    <option value="north" <?php echo ($region == 'north') ? 'selected' : ''; ?>>North</option>
    <option value="east" <?php echo ($region == 'east') ? 'selected' : ''; ?>>East</option>
    <option value="west" <?php echo ($region == 'west') ? 'selected' : ''; ?>>West</option>
    <option value="south" <?php echo ($region == 'south') ? 'selected' : ''; ?>>South</option>
</select>
            </div>
                  
                   <!-- Added gap between columns -->
        
            <div class="col-md-2">
                <label class="form-label">State Name</label>
                <select class="form-control" name="state_name" id="state_name"  onchange="get_district()">
                    <?php echo $state_type_options;?>
                    <!--<option value="">Select Engineer Name</option>-->
                   
                   
                   <input type="hidden" id="user_role_id" name="user_role_id">
                   
                </select>
            </div>

            <div class="col-md-2">
                 <label  class="form-label">District Name</label>
                 
                                        <select name="district_name" id="district_name" class="select2 form-control" 
                                            required>
                                            
                                            <?php echo $district_type_options; ?>
                                        </select>
            </div>
            
            <input type="hidden" name="team_status" id="team_status" value="1">

            <div class="col-md-2">
              <label class="form-label">Operation T.Members</label>
              
                                        <select class="selectpicker form-control" id="eng_name" name="eng_name[]"  multiple data-live-search="true">
                                            <?php echo $eng_name_options; ?>
                                        </select> 

            </div>
            
            
            
            <div class="col-md-2">
              <label class="form-label">User Role</label>
                                        <input name="user_role" readonly id="user_role" class="select2 form-control" value="<?php echo $user_role; ?>" required >
            </div>

           
            

        </div>
    </div>
</div>


</div>
<div class="row">       
        <div class="card">
           <div class="card-body">
              <div class="table-responsive">
                 <table id="team_list_datatable" class="table table-bordered table-striped align-middle">
                    <thead>
                       <tr>
                        <th>Selection<br>(Select All)
                    <?php echo '<input type="checkbox"  id="select_all">' ?></th>
                    
                          <th>S.No</th>
                          <th>PO No</th>
                          <th>PO Date</th>
                          <!-- <th>Consignee</th> -->
                          <th>Department</th>
                          <th>Location</th>
                          <th>Invoice No</th>
                          <th>Invoice Date</th>
                          <th>PO</th>
                          <th>DC</th>
                          <th>IR</th>
                          <th>Invoice</th>
                          <th>Comparision</th>
                          <th>A/C Team Verify Status</th>
                          <th>Approved by</th>
                        
                       </tr>
                    </thead>
                    <tbody>
                       <tr>
                          
                       </tr>
                    </tbody>
                 </table>
              </div>
              <div class="col-12 mt-3">
                                <div class="form-group row ">
                                   <div class="col-md-12" align="right">
                                      <?php echo btn_cancel($btn_cancel); ?>
                                      <button type="button" class="btn btn-primary waves-effect waves-light" id="approve_btn"  onclick="team_allocation_update()">Submit</button>
                                      <!-- <button type="button" class="btn btn-primary waves-effect waves-light" onclick="po_invoice_create()">Save</button> -->
                                   </div>
                                </div>
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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  
  <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
   
  <script>
  
  document.addEventListener("DOMContentLoaded", function () {
    const selectAll = document.getElementById("select_all");
    
    // Event listener for "Select All" checkbox
    selectAll.addEventListener("change", function () {
        const checkboxes = document.querySelectorAll(".myCheck");
        checkboxes.forEach(checkbox => {
            checkbox.checked = selectAll.checked;
        });
    });

    // Event listener for individual checkboxes
    document.addEventListener("change", function (event) {
        if (event.target.classList.contains("myCheck")) {
            const checkboxes = document.querySelectorAll(".myCheck");
            const checkedBoxes = document.querySelectorAll(".myCheck:checked");

            // Uncheck "Select All" if any checkbox is unchecked
            if (checkedBoxes.length !== checkboxes.length) {
                selectAll.checked = false;
            } else {
                selectAll.checked = true;
            }
        }
    });
});




function get_eng_name() {
    var engType = document.getElementById("eng_type").value;
    var engNameDropdown = document.getElementById("eng_name");

    // Clear existing options
    engNameDropdown.innerHTML = "";

    if (engType === "own-engineer") {
        engNameDropdown.innerHTML = `<?php echo $engineer_name_options1; ?>`;
    } else if (engType === "outsource-vendor") {
        engNameDropdown.innerHTML = `<?php echo $vendor_option; ?>`;
    }
}

$(document).ready(function() {
    $('#eng_name').select2({
        placeholder: "Select Service Engineer(s)",
        allowClear: true
    });
});


// function get_district(){
    
    
//     var state_name = $('#state_name').val();
    
//     alert(state_name);
    
//     var district_name = $('#district_name').val();
    
//     var data = {
        
//         state_name : state_name,
//         action :'get_district'
        
//     }
    
    
    
       
//     var ajax_url = sessionStorage.getItem("folder_crud_link");
    
//     $.ajax({
        
//         type:"POST",
//         url:ajax_url,
//         data:data,
        
        
//         success:function(response){
            
            
//               var districts = JSON.parse(response);
            
//              $('#district_name').empty();

//             // Add a default option
//             $('#district_name').append('<option value="">Select District</option>');

//             // Loop through the district data and populate the dropdown
//             districts.forEach(function(district) {
//                 $('#district_name').append('<option value="' + district.unique_id + '">' + district.district_name + '</option>');
//             });
            
//              $('#district_name').select2();
            
//         }
        
//     });
    
// }


function get_district() {
    var state_name = $('#state_name').val();  // Get the selected state unique_id

    var data = {
        state_name: state_name,
        action: 'get_district'
    };

    var ajax_url = sessionStorage.getItem("folder_crud_link");

    $.ajax({
        type: "POST",
        url: ajax_url,
        data: data,
        success: function(response) {
            try {
                // Parse the JSON response
                var responseData = JSON.parse(response);

                // Check the status of the response
                if (responseData.status === 'success' && Array.isArray(responseData.districts) && responseData.districts.length > 0) {
                    // Clear the district dropdown before adding new options
                    $('#district_name').empty();
                    $('#district_name').append('<option value="">Select District</option>');

                    // Loop through the districts and populate the dropdown
                    responseData.districts.forEach(function(district) {
                        $('#district_name').append('<option value="' + district.unique_id + '">' + district.district_name + '</option>');
                    });

                    // Reinitialize select2 (if used)
                    $('#district_name').select2();
                } else {
                    // If no districts found, show a message
                    $('#district_name').empty();
                    $('#district_name').append('<option value="">No districts found</option>');
                    alert("No districts found for the selected state");
                }
            } catch (e) {
                console.error('Error parsing JSON response:', e);
                // alert('An error occurred while processing the response.');
            }
        },
        error: function(xhr, status, error) {
            console.error("Error in AJAX request:", error);
        }
    });
}


document.getElementById("eng_name").addEventListener("change", function () {
    // Get selected engineer values
    let selectedValues = Array.from(this.selectedOptions).map(option => option.value);
    console.log("Selected Engineers:", selectedValues);

    // Get AJAX URL from sessionStorage
    var ajax_url = sessionStorage.getItem("folder_crud_link");

    // Send AJAX request
    $.ajax({
        type: "POST",
        url: ajax_url,
        data: { action: "engineer_role_option", eng_name: JSON.stringify(selectedValues) }, // Send selected values as JSON
        dataType: "json",
        success: function (response) {
            console.log("AJAX Response:", response); // Debugging log

            if (response.success) {
                // Extract the user roles and unique IDs from the response
                let userRoles = response.user_roles; // Comma-separated string of user roles (e.g., "Admin, User")
                let userRoleIds = response.user_role_ids; // Array of unique IDs (e.g., [1, 2, 3])

                // Display user roles (roles as a string) in the input field
                $("#user_role").val(userRoles);

                // Store the user role unique IDs in the hidden field
                $("#user_role_id").val(userRoleIds.join(",")); // Join IDs with commas
            } else {
                alert(response.message); // Show error message if no data is found
            }
        },
        error: function () {
            alert("Error fetching engineer role."); // Show error message if AJAX request fails
        }
    });
});



  function print_pdf_1(file_name) {

	onmouseover = window.open('uploads/po_form/po_attach/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
}

  function print_pdf(file_name) {

	onmouseover = window.open('uploads/invoice/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
}


//      document.getElementById('select_all').addEventListener('change', function() {
//     const checkboxes = document.querySelectorAll('.myCheck');
//     checkboxes.forEach(function(checkbox) {
//         checkbox.checked = this.checked;
//     }.bind(this));
// });
  </script>
