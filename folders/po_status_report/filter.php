      
       <style>
       
      /* General Styles for the Form */
.form-label {
    font-weight: bold;
    margin-bottom: 5px;
}

.form-control-sm, .select2.form-control-sm {
    font-size: 14px;
    padding: 5px 10px;
}

/* Custom Spacing for Inputs */
.mb-3 {
    margin-bottom: 15px;
}


/* Align all labels and fields properly */
.row {
    display: flex;
    align-items: center;
}

/* Adjust width for small inputs */
input, select.form-control-sm {
    width: 100%;
}

.filter-container {
    background-color: white;  
    padding: 20px;  
    border-radius: 8px;  
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);  
    margin-bottom: 20px;  /* Add some spacing below the form */
}

/* Ensure the buttons remain small and aligned */
.btn-sm {
    padding: 5px 10px;  /* Smaller padding for a compact button size */
    font-size: 12px;    /* Smaller font size */
}

select.form-control {
    width: 100%;                 
    padding: 8px 12px;           
    border: 1px solid #ccc;      
    border-radius: 4px;         
    background-color: #fff;      
    font-size: 14px;             
    color: #333;                 
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);  
    transition: border-color 0.3s ease-in-out; 
}
select.form-control:hover {
    border-color: #007bff; 
}

select.form-control:focus {
    border-color: #007bff;  
    outline: none;          
    box-shadow: 0 0 4px rgba(0, 123, 255, 0.5); 
}
.select2-container--default .select2-results__option--highlighted[aria-selected] {
    background-color: #1A7DB7;
    color: white;
}





       </style>   
     
 
   
   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
 <script src="assets/js/page/form-wizard.js"></script>
  <script src="assets/bundles/jquery-validation/dist/jquery.validate.min.js"></script>

  <script src="assets/libs/sweetalert2/sweetalert2.all.min.js"></script>  
  <script src="assets/libs/dropify/dist/js/dropify.min.js<?php echo $js_css_file_comment; ?>"></script>
  
   <script src="assets/libs/select2/js/select2.min.js<?php echo $js_css_file_comment; ?>"></script>
   <link href="assets/css/select2.min.css" rel="stylesheet" /> 


           <?php
$department_options = department_creation_table();
$department_options = select_option($department_options, "Select Department",  $department);

$po_numbers = po_numers();
$po_numbers = select_option($po_numbers, "Select PO Numbers");
// $executive_names = executive_names();
// $executive_names = select_option($executive_names, "Select Executive Name");
// $brand_names = brand_names();
// $brand_names = select_option_3($brand_names, "Select Brand Names");
            ?>
            <div class="filter-container">
        
                <div class="row">
                    <div class="col-4">
                        <div class="mb-3">
                            
                            <label class="form-label">Report On</label>
                           
                            <select class="select2 form-control" id="po_num_search"  name="po_num_search" required> 
                                    <?php echo $po_numbers; ?>                            
                            </select>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="mb-3">
                            <button type="button" id="date_filter" name="date_filter" style="margin-top: 22px;" class="input-group-text thme-colo btn btn-primary border-primary text-white" 
                            onclick="get_filter_data()">Search</button>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="mb-3">
                            <button type="button" id="refreshButton" class="input-group-text thme-colo btn btn-primary border-primary text-white" 
                            onclick="location.reload();">Refresh</button>
                        </div>
                    </div>                   
                </div>
            </div>
        </div>
<script>



    $(document).ready(function () {
      
     
        
   });


function get_value() {
    // Clear previous data
    $('#val1').empty();
    $('#val2').empty();
    $('#val3').empty();
    $('#val4').empty();
    $('#no_data').empty();

    // Get search value
    var po_num_search = $("#po_num_search").val();

    if (po_num_search) {
        var data = "po_num_search=" + encodeURIComponent(po_num_search) + "&action=rename_data";
        var ajax_url = sessionStorage.getItem("folder_crud_link");

        $.ajax({
            type: "POST",
            url: ajax_url,
            data: data,
            success: function (response) {
                try {
                    var obj = JSON.parse(response);

                    // Append values to respective elements
                    if (obj.val1) {
                        $('#val1').append(obj.val1);
                    } else {
                        $('#val1').append("No data found");
                    }

                    if (obj.val2) {
                        $('#val2').append(obj.val2);
                    } else {
                        $('#val2').append("No data found");
                    }
                    if (obj.val3) {
                        $('#val3').append(obj.val3);
                    } else {
                        $('#val3').append("No data found");
                    }
                    if (obj.val4) {
                        $('#val4').append(obj.val4);
                    } else {
                        $('#val4').append("No data found");
                    }

                } catch (e) {
                    console.error("Error parsing response:", e);
                    $('#no_data').append("Invalid response from server.");
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error:", status, error);
                $('#no_data').append("An error occurred while fetching data.");
            }
        });
    } else {
        $('#no_data').append("Please enter a valid PO number.");
    }
}


function get_filter_data() {
    get_value();
    init_datatable_1();
    sub_list_datatable();
}

function init_datatable_1() {
    var table_id = "po_no_datatable";
    var po_num_search = $("#po_num_search").val();

    if (po_num_search) {
        var table = $("#" + table_id);
        var data = {
            "po_num_search": po_num_search,
            "action": 'search1',
        };
        var ajax_url = sessionStorage.getItem("folder_crud_link");

        table.DataTable({
            destroy: true,
            ordering: true,
            searching: true,
            paging: true,
            ajax: {
                url: ajax_url,
                type: "POST",
                data: data,
                dataSrc: function (json) {
                    // Update footer totals for PO table
                    $('#total_no_of_qty').text(json.total_no_of_qty);
                    $('#with_tax_amount').text(json.page_with_tax_total);
                    $('#without_tax_amount').text(json.page_without_tax_total);
                    $('#total_due_days').text(json.total_po_delivery_due_days);
                    return json.data;
                }
            },
            dom: 'lBfrtip',
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
        });
    }
}
function sub_list_datatable() {
    // alert();
    var table_id = "invoice_datatable"; // Use the ID of the table element
    var po_num_search = $("#po_num_search").val();

    if (po_num_search) {
        var table = $("#" + table_id); // Ensure this targets the <table> element, not the <div>
        var data = {
            "po_num_search": po_num_search,
            "action": 'search2',
        };
        var ajax_url = sessionStorage.getItem("folder_crud_link");

        table.DataTable({
            destroy: true,
            ordering: true,
            searching: true,
            paging: true,
            ajax: {
                url: ajax_url,
                type: "POST",
                data: data,
                dataSrc: function (json) {

                    // Update footer totals for Invoice table
                    $('#total_no_of_cus_qty').text(json.total_no_of_cus_qty);
                    $('#without_tax_amount_customer').text(json.page_without_tax_total);
                    return json.data;
                }
            },
            dom: 'lBfrtip',
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
        });
    }
}


function get_user_permission() {
var screen_id_val = $('#screen_id_val').val();
// alert(screen_id_val);
var user_type_unique_id = $('#user_type_unique_id').val();
// alert(user_type_unique_id);
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

      // console.log(dataString);

      var addButton = document.getElementById('add_btn');
      if (dataString.includes('5f8807ff00bf726601')) {
          addButton.style.visibility = 'visible';  // Show the button
      } else {
          addButton.style.visibility = 'hidden';   // Hide the button but keep its space
      }
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
</script>
<script>
        // $(document).ready(function() {
        //     $('.select2').select2({
        //         placeholder: "Select departments",
        //         allowClear: true
        //     });
        // });
//         jQuery.noConflict();
// jQuery(document).ready(function($) {
//     $('select').select2();
//});


    </script>

