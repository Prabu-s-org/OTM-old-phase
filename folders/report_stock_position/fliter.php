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
$executive_names = executive_names();
$executive_names = select_option($executive_names, "Select Executive Name");
$brand_names = brand_names();
$brand_names = select_option_3($brand_names, "Select Brand Names");

$status = status();
$status = select_option_4($status, "Select Status")

            ?>
            <div class="filter-container">
            <div class="row">
            <div class="col-4">
                  <div class="mb-3">
                     <label class="form-label from-date-label" >Po From Date</label>
                     <input type="date" class="form-control" id="po_from_date" name="po_from_date" value="<?php echo date('01-m-Y');?>">
                   
                  </div>
               </div>
               <div class="col-4">
                  <div class="mb-3">
                     <label class="form-label from-date-label">Po To Date</label>
                     <input type="date" class="form-control" id="po_to_date" name="po_to_date" value="<?php echo date('d-m-Y');?>">
                  </div>
                  </div>
                  </div>
                  <div class="row">
            <div class="col-4">
                  <div class="mb-3">
                     <label class="form-label from-date-label">Department Name</label>

                     <select class="select2 form-control" id="department"  name="department" required> 
                                                             <?php echo $department_options;?>
                                                             </select>
                   
                  </div>
               </div>
               <div class="col-4">
                  <div class="mb-3">
                     <label class="form-label from-date-label">Po Numbers</label>
                     <select class="select2 form-control" id="po_numbers"  name="po_numbers" required> 
                                                             <?php echo $po_numbers;?>
                                                             </select>
                  </div>
                  </div>
                  </div>
                  <div class="row">
            <div class="col-4">
                  <div class="mb-3">
                     <label class="form-label from-date-label">Executive Name</label>

                     <select class="select2 form-control" id="executive_name"  name="executive_name" required> 
                                                             <?php echo $executive_names;?>
                                                             </select>
                   
                  </div>
               </div>
               <div class="col-4">
                  <div class="mb-3">
                     <label class="form-label from-date-label">Brand Name</label>
                     <select class="select2 form-control" id="brand_name"  name="brand_name" required> 
                                                             <?php echo $brand_names;?>
                                                             </select>
                  </div>
                  </div>
                  </div>
                  <div class="row">
            <div class="col-4">
                  <div class="mb-3">
                  <label class="form-label from-date-label">Report On</label>
                  <select class="select2 form-control" id="search"  name="search" required> 
                                                             <option value="1">PO NO</option>
                                                             <option value="2">Customer Name</option>
                                                             <option value="3">Executive Name</option>
                                                             <option value="4">Item Code</option>
                                                             <option value="5">Month</option>
                                                             <option value="6">Year</option>
                                                             <option value="7">Po Date</option>
                                                             <option value="8">Brand Name</option>
                                                             <option value="9">Detailed Report</option>
                                                             </select>
                       </div></div>
                       <div class="col-4">
                  <div class="mb-3">
                     <label class="form-label from-date-label">Status</label>
                     <select class="select2 form-control" id="status"  name="status" required> 
                     <?php echo $status;?>
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
    // reset function
    // function resetFields() {
    //     alert(resetFields);
        
    //     // Reset the date fields
    //     // document.getElementById('po_from_date').value = "";
    //     // document.getElementById('po_to_date').value = "";

    //     // Reset the dropdown fields
    //     document.getElementById('department').value = "";
    //     // document.getElementById('department').reset();
    //     alert(department);
    //     // document.getElementById('po_numbers').value = "";
    //     // document.getElementById('executive_name').value = "";
    //     // document.getElementById('brand_name').value = "";
    //     // document.getElementById('search').value = "1"; // Reset to default option

    //     // // If using select2, reset the plugin's UI
    //     // $('.select2').val(null).trigger('change');
    // }

  


    $(document).ready(function () {
      
        // get_filter_data();
        // init_datatable_1(table_id, form_name, action);

        
   });
    function get_filter_data() {

        

get_value();

init_datatable_1(table_id, form_name, action);
}

function get_value() {
    // alert("hii");
        $('#val1').empty();
        $('#val2').empty();
        $('#val3').empty();
        $('#val4').empty();
        $('#val5').empty();
        $('#val6').empty();
        
        $('#val7').empty();
        $('#no_data').empty();
        
    
    // var month_fill = $('#month_fill').val();
    var from_date = $("#po_from_date").val();
    var to_date = $("#po_to_date").val();
    var department_name = $("#department").val();
    var po_numbers = $("#po_numbers").val();
    // alert(po_numbers);
    var executive_name = $("#executive_name").val();
    
    var brand_name = $("#brand_name").val();
        // alert(brand_name);
    // $('#val6').append(brand_name);
    var search = $("#search").val();
    
    if(department_name || po_numbers || executive_name != ''  || brand_name!='' ){
        // || brand_name!=''
        // +"&brand_name="+brand_name


        var data = "department_name=" + department_name + "&po_numbers="+ po_numbers+"&executive_name="
        +executive_name+"&brand_name="+brand_name+"&action=rename_data";

	var ajax_url = sessionStorage.getItem("folder_crud_link");
	$.ajax({
		type: "POST",
		url: ajax_url,
		data: data,
		success: function (data) {
			// alert(data);
            var obj = JSON.parse(data);
            // if (search == '1') {

            // $('#val1').append(from_date);
            // $('#val2').append(to_date);
            
$('#val3').append(obj.val1);
$('#val4').append(obj.val2);
$('#val5').append(obj.val3);
$('#val6').append(obj.val6);

// $('#val7').append(search);

// }
		}
	});
// }
}
    
}

function init_datatable_1(table_id = '', form_name = '', action = '') {
    // $('#val1').empty();
    //     $('#val2').empty();
// var month_fill = $('#month_fill').val();
var from_date = $("#po_from_date").val();
var to_date = $("#po_to_date").val();
var department_name = $("#department").val();
var po_numbers = $("#po_numbers").val();
var executive_name = $("#executive_name").val();
var brand_name = $("#brand_name").val();

var search = $("#search").val();
// alert(search);

$('#val1').empty();
    $('#val2').empty();
    $('#val3').empty();
    $('#val4').empty();
    $('#val5').empty();
    $('#val6').empty();
    $('#val7').empty();
if (search == '1') {
    $('#val1').append(from_date);
$('#val2').append(to_date);
    // $('#val1').append(from_date);
    // $('#val2').append(to_date);
    // $('#val3').append(department_name);
    // $('#val4').append(po_numbers);
    // $('#val5').append(executive_name);
    // $('#val6').append(brand_name);
    $('#val7').append("PO NO");

    $('#po_no_table').show();

     $('#customer_name_table').hide();
    // $('#po_no_table').hide();
    $('#excutive_name_table').hide();
    $('#item_code_table').hide();
   
   $('#customer_name_table').hide();
    $('#excutive_name_table').hide();
$('#po_no_details_table').hide();
$('#brand_name_table').hide();
$('#po_date_wise_table').hide();
    $('#year_wise_table').hide();
    $('#month_wise_table').hide();
    table_id = "po_no_datatable";
    // alert("hii");
var table = $("#" + table_id);
   var data = {
      "from_date": from_date,
      "to_date": to_date,
      "department_name": department_name,
      "po_numbers": po_numbers,
      "executive_name": executive_name,
      "brand_name": brand_name,
      "search": search,
      "action":'search1',

   };
   var ajax_url = sessionStorage.getItem("folder_crud_link");

   var datatable = table.DataTable({
  destroy: true,
      ordering: true,
      searching: true,
      "ajax": {
         url: ajax_url,
         type: "POST",
         data: data
      },
      dom: 'Bfrtip',
      buttons: [
          'copy', 'csv', 'excel', 'pdf', 'print'
      ]
   });

} else if (search == '2') {
    $('#val1').append(from_date);
    $('#val2').append(to_date);
    $('#val7').append("Customer Name");
    $('#customer_name_table').show();
    $('#po_no_table').hide();
    $('#excutive_name_table').hide();
    $('#item_code_table').hide();
    $('#po_no_table').hide();
//    $('#customer_name_table').hide();
    $('#excutive_name_table').hide();
$('#po_no_details_table').hide();
$('#brand_name_table').hide();
$('#po_date_wise_table').hide();
    $('#year_wise_table').hide();
    $('#month_wise_table').hide();
  
  
    table_id = "customer_name_datatable";
    // alert("hii");
var table = $("#" + table_id);
   var data = {
      "from_date": from_date,
      "to_date": to_date,
      "department_name": department_name,
      "po_numbers": po_numbers,
      "executive_name": executive_name,
      "brand_name": brand_name,
      "search": search,
      "action":'search2',

   };
   var ajax_url = sessionStorage.getItem("folder_crud_link");

   var datatable = table.DataTable({
  destroy: true,
      ordering: true,
      searching: true,
      "ajax": {
         url: ajax_url,
         type: "POST",
         data: data
      },
      dom: 'Bfrtip',
      buttons: [
          'copy', 'csv', 'excel', 'pdf', 'print'
      ]
   });

} 
else if (search == '3') {
    $('#val1').append(from_date);
    $('#val2').append(to_date);
    $('#val7').append("Excutive Name");
    $('#excutive_name_table').show();
    $('#item_code_table').hide();
    $('#po_no_table').hide();
   $('#customer_name_table').hide();
    // $('#excutive_name_table').hide();
$('#po_no_details_table').hide();
$('#brand_name_table').hide();
$('#po_date_wise_table').hide();
    $('#year_wise_table').hide();
    $('#month_wise_table').hide();
  
    

    table_id = "excutive_name_datatable";
    // alert("hii");
var table = $("#" + table_id);
   var data = {
      "from_date": from_date,
      "to_date": to_date,
      "department_name": department_name,
      "po_numbers": po_numbers,
      "executive_name": executive_name,
      "brand_name": brand_name,
      "search": search,
      "action":'search3',

   };
   var ajax_url = sessionStorage.getItem("folder_crud_link");

   var datatable = table.DataTable({
  destroy: true,
      ordering: true,
      searching: true,
      "ajax": {
         url: ajax_url,
         type: "POST",
         data: data
      },
      dom: 'Bfrtip',
      buttons: [
          'copy', 'csv', 'excel', 'pdf', 'print'
      ]
   });

} 
else if (search == '4') {
    $('#val1').append(from_date);
    $('#val2').append(to_date);
    $('#val7').append("Item Code");
    $('#item_code_table').show();

    $('#po_no_table').hide();
   $('#customer_name_table').hide();
    $('#excutive_name_table').hide();
$('#po_no_details_table').hide();
$('#brand_name_table').hide();
$('#po_date_wise_table').hide();
    $('#year_wise_table').hide();
    $('#month_wise_table').hide();
  
    table_id = "item_wise_datatable";
    // alert("hii");
var table = $("#" + table_id);
   var data = {
      "from_date": from_date,
      "to_date": to_date,
      "department_name": department_name,
      "po_numbers": po_numbers,
      "executive_name": executive_name,
      "brand_name": brand_name,
      "search": search,
      "action":'search4',

   };
   var ajax_url = sessionStorage.getItem("folder_crud_link");

   var datatable = table.DataTable({
  destroy: true,
      ordering: true,
      searching: true,
      "ajax": {
         url: ajax_url,
         type: "POST",
         data: data
      },
      dom: 'Bfrtip',
      buttons: [
          'copy', 'csv', 'excel', 'pdf', 'print'
      ]
   });

} else if (search == '5') {
    $('#val1').append(from_date);
$('#val2').append(to_date);
    // $('#val1').append(from_date);
    // $('#val2').append(to_date);
    // $('#val3').append(department_name);
    // $('#val4').append(po_numbers);
    // $('#val5').append(executive_name);
    // $('#val6').append(brand_name);
    $('#val7').append("Month");
    $('#month_wise_table').show();
    $('#po_no_table').hide();
   $('#customer_name_table').hide();
    $('#excutive_name_table').hide();
    $('#item_code_table').hide();
    // $('#month_wise_table').hide();
    // $('#year_wise_table').hide();
// $('#po_date_wise_table').hide();
// $('#brand_name_table').hide();
$('#po_no_details_table').hide();
$('#brand_name_table').hide();
$('#po_date_wise_table').hide();
    $('#year_wise_table').hide();
   
    table_id = "month_datatable";
    // alert("hii");
var table = $("#" + table_id);
   var data = {
      "from_date": from_date,
      "to_date": to_date,
      "department_name": department_name,
      "po_numbers": po_numbers,
      "executive_name": executive_name,
      "brand_name": brand_name,
      "search": search,
      "action":'search5',

   };
   var ajax_url = sessionStorage.getItem("folder_crud_link");

   var datatable = table.DataTable({
  destroy: true,
      ordering: true,
      searching: true,
      "ajax": {
         url: ajax_url,
         type: "POST",
         data: data
      },
      dom: 'Bfrtip',
      buttons: [
          'copy', 'csv', 'excel', 'pdf', 'print'
      ]
   });

} else if (search == '6') {

    $('#val1').append(from_date);
$('#val2').append(to_date);
    // $('#val1').append(from_date);
    // $('#val2').append(to_date);
    // $('#val3').append(department_name);
    // $('#val4').append(po_numbers);
    // $('#val5').append(executive_name);
    // $('#val6').append(brand_name);
    $('#val7').append("Year");
    $('#year_wise_table').show();
    $('#po_no_table').hide();
   $('#customer_name_table').hide();
    $('#excutive_name_table').hide();
    $('#item_code_table').hide();
    $('#month_wise_table').hide();
   
$('#po_no_details_table').hide();
$('#brand_name_table').hide();
$('#po_date_wise_table').hide();
   
    table_id = "year_wise_datatable";
    // alert("hii");
var table = $("#" + table_id);
   var data = {
      "from_date": from_date,
      "to_date": to_date,
      "department_name": department_name,
      "po_numbers": po_numbers,
      "executive_name": executive_name,
      "brand_name": brand_name,
      "search": search,
      "action":'search6',

   };
   var ajax_url = sessionStorage.getItem("folder_crud_link");

   var datatable = table.DataTable({
  destroy: true,
      ordering: true,
      searching: true,
      "ajax": {
         url: ajax_url,
         type: "POST",
         data: data
      },
      dom: 'Bfrtip',
      buttons: [
          'copy', 'csv', 'excel', 'pdf', 'print'
      ]
   });



} else if (search == '7') {

$('#val1').append(from_date);
$('#val2').append(to_date);
// $('#val1').append(from_date);
// $('#val2').append(to_date);
// $('#val3').append(department_name);
// $('#val4').append(po_numbers);
// $('#val5').append(executive_name);
// $('#val6').append(brand_name);
$('#val7').append("PO Date");
$('#po_date_wise_table').show();
$('#po_no_table').hide();
$('#customer_name_table').hide();
    $('#excutive_name_table').hide();
    $('#item_code_table').hide();
    $('#month_wise_table').hide();
    $('#year_wise_table').hide();
// $('#po_date_wise_table').hide();
// $('#brand_name_table').hide();
$('#po_no_details_table').hide();
$('#brand_name_table').hide();

table_id = "po_date_wise_datatable";
// alert("hii");
var table = $("#" + table_id);
var data = {
  "from_date": from_date,
  "to_date": to_date,
  "department_name": department_name,
  "po_numbers": po_numbers,
  "executive_name": executive_name,
  "brand_name": brand_name,
  "search": search,
  "action":'search7',

};
var ajax_url = sessionStorage.getItem("folder_crud_link");

var datatable = table.DataTable({
destroy: true,
  ordering: true,
  searching: true,
  "ajax": {
     url: ajax_url,
     type: "POST",
     data: data
  },
  dom: 'Bfrtip',
  buttons: [
      'copy', 'csv', 'excel', 'pdf', 'print'
  ]
});



}

else if (search == '8') {

$('#val1').append(from_date);
$('#val2').append(to_date);
// $('#val1').append(from_date);
// $('#val2').append(to_date);
// $('#val3').append(department_name);
// $('#val4').append(po_numbers);
// $('#val5').append(executive_name);
// $('#val6').append(brand_name);
$('#val7').append("Brad Name");
$('#brand_name_table').show();
$('#po_no_table').hide();
$('#customer_name_table').hide();
    $('#excutive_name_table').hide();
    $('#item_code_table').hide();
    $('#month_wise_table').hide();
    $('#year_wise_table').hide();
$('#po_date_wise_table').hide();
// $('#brand_name_table').hide();
$('#po_no_details_table').hide();

table_id = "brand_name_datatable";
// alert("hii");
var table = $("#" + table_id);
var data = {
  "from_date": from_date,
  "to_date": to_date,
  "department_name": department_name,
  "po_numbers": po_numbers,
  "executive_name": executive_name,
  "brand_name": brand_name,
  "search": search,
  "action":'search8',

};
var ajax_url = sessionStorage.getItem("folder_crud_link");

var datatable = table.DataTable({
destroy: true,
  ordering: true,
  searching: true,
  "ajax": {
     url: ajax_url,
     type: "POST",
     data: data
  },
  dom: 'Bfrtip',
  buttons: [
      'copy', 'csv', 'excel', 'pdf', 'print'
  ]
});



}
else if (search == '9') {

$('#val1').append(from_date);
$('#val2').append(to_date);
// $('#val1').append(from_date);
// $('#val2').append(to_date);
// $('#val3').append(department_name);
// $('#val4').append(po_numbers);
// $('#val5').append(executive_name);
// $('#val6').append(brand_name);
$('#val7').append("Po No Details");
$('#po_no_details_table').show();
$('#po_no_table').hide();
$('#customer_name_table').hide();
    $('#excutive_name_table').hide();
    $('#item_code_table').hide();
    $('#month_wise_table').hide();
    $('#year_wise_table').hide();
$('#po_date_wise_table').hide();
$('#brand_name_table').hide();

table_id = "po_no_detail_datatable";
// alert("hii");
var table = $("#" + table_id);
var data = {
  "from_date": from_date,
  "to_date": to_date,
  "department_name": department_name,
  "po_numbers": po_numbers,
  "executive_name": executive_name,
  "brand_name": brand_name,
  "search": search,
  "action":'search9',

};
var ajax_url = sessionStorage.getItem("folder_crud_link");

var datatable = table.DataTable({
destroy: true,
  ordering: true,
  searching: true,
  "ajax": {
     url: ajax_url,
     type: "POST",
     data: data
  },
  dom: 'Bfrtip',
  buttons: [
      'copy', 'csv', 'excel', 'pdf', 'print'
  ]
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
        jQuery.noConflict();
jQuery(document).ready(function($) {
    $('select').select2();
});


    </script>

