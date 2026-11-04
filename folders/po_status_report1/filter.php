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
            ?>
            <div class="filter-container">
        
                <div class="row">
                    <div class="col-4">
                        <div class="mb-3">
                            <label class="form-label from-date-label">Report On</label>
                            <select class="select2 form-control" id="search"  name="search" required> 
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
var po_numbers = $("#po_numbers").val();
var po_numbers = $("#po_date").val();
var from_date = $("#po_from_date").val();
var to_date = $("#po_to_date").val();
var department_name = $("#department").val();

var executive_name = $("#executive_name").val();
// var brand_name = $("#brand_name").val();

var search = $("#search").val();
// alert(search);

$('#val1').empty();
    $('#val2').empty();
    $('#val3').empty();
    $('#val4').empty();
    // $('#val5').empty();
    // $('#val6').empty();
    // $('#val7').empty();
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
      destroy: true,
      paging: true,
   

      "ajax": {
         url: ajax_url,
         type: "POST",
         data: data,


         dataSrc: function (json) {
                // Initialize totals
                var visibleWithoutTax = 0;
                var visibleWithTax = 0;
              

                // Loop over the data received from the server
                $.each(json.data, function (index, row) {
                    // Assuming row[7] is 'with_tax_amount' and row[6] is 'without_tax_amount'
                    var withoutTax = parseFloat(row[6].replace(/,/g, '')) || 0;
                    var withTax = parseFloat(row[7].replace(/,/g, '')) || 0; // Removing commas and converting to float
                  
                    visibleWithoutTax += withoutTax;
                    visibleWithTax += withTax;
                    
                });

                // Update the footer totals
               
                // $('#without_tax_amount').text(moneyFormatIndia(visibleWithoutTax));
                // $('#with_tax_amount').text(moneyFormatIndia(visibleWithTax));
                $('#total_no_of_con').text(json.total_no_of_consignee);
                $('#total_no_of_item').text(json.total_no_of_items);
                $('#total_no_of_qty').text(json.total_no_of_qty);
          

                $('#without_tax_amount').text(json.page_without_tax_total);
                $('#with_tax_amount').text(json.page_with_tax_total);
                // Return the data for the table
                return json.data;
            }
        },
    //   dom: 'Bfrtip',
    dom: 'lBfrtip',
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
      destroy: true,
      paging: true,
   

      "ajax": {
         url: ajax_url,
         type: "POST",
         data: data,
         
         dataSrc: function (json) {
                // Initialize totals
                var visibleWithoutTax = 0;
                var visibleWithTax = 0;
                var totalPercentage = 0;
              

                // Loop over the data received from the server
                $.each(json.data, function (index, row) {
                    // Assuming row[7] is 'with_tax_amount' and row[6] is 'without_tax_amount'
                    var withoutTax = parseFloat(row[5].replace(/,/g, '')) || 0;
                    var withTax = parseFloat(row[6].replace(/,/g, '')) || 0; // Removing commas and converting to float
                    var percentage = parseFloat(row[7]) || 0;

                    visibleWithoutTax += withoutTax;
                 
                    visibleWithTax += withTax;

                });

                    // totalPercentage += percentage;

                    // new changes
                            
            // Calculate individual percentages dynamically to ensure total is 100%
            let individualPercentages = json.data.map(row => {
                let withTax = row[6] ? parseFloat(row[6].replace(/,/g, '')) : 0;
                return visibleWithTax > 0 ? (withTax / visibleWithTax) * 100 : 0; // Avoid division by zero
            });

            // Sum of dynamically calculated percentages
            totalPercentage = individualPercentages.reduce((sum, percentage) => sum + percentage, 0);

            // Adjust totalPercentage to be exactly 100% by distributing any rounding errors
            if (totalPercentage !== 100) {
                let roundingAdjustment = 100 - totalPercentage;
                individualPercentages[individualPercentages.length - 1] += roundingAdjustment; // Apply adjustment to the last item
                totalPercentage = 100; // Force total to be 100%
            }


                    // end
                
  // Update the footer totals
               
                // $('#without_tax_amount').text(moneyFormatIndia(visibleWithoutTax));
                // $('#with_tax_amount').text(moneyFormatIndia(visibleWithTax));

                $('#total_no_of_cus_po').text(json.total_po_num);
                $('#total_no_of_cus_con').text(json.total_no_of_con);
                $('#total_no_of_cus_qty').text(json.total_no_of_qty);
          

                $('#without_tax_amount_customer').text(json.page_without_tax_total);
                $('#with_tax_amount_customer').text(json.page_with_tax_total);
                $('#percentage_customer').text(totalPercentage.toFixed(2) + '%');
                // $('#without_tax_amount_customer').text(json.without_tax_amount);
                // $('#with_tax_amount_customer').text(json.with_tax_amount);
                // Return the data for the table
                return json.data;
            }
        },
      dom: 'lBfrtip',
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
      destroy: true,
      paging: true,
   

      "ajax": {
         url: ajax_url,
         type: "POST",
         data: data,
         
         dataSrc: function (json) {
                // Initialize totals
                var visibleWithTax = 0;
                var visibleWithoutTax = 0;
           
                var totalPercentage = 0;
 
                // Loop over the data received from the server
                $.each(json.data, function (index, row) {
                    // Assuming row[7] is 'with_tax_amount' and row[6] is 'without_tax_amount'
                    var withTax = parseFloat(row[5].replace(/,/g, '')) || 0; // Removing commas and converting to float

                    var withoutTax = parseFloat(row[6].replace(/,/g, '')) || 0;
                    // var withTax = parseFloat(row[6].replace(/,/g, '')) || 0; // Removing commas and converting to float
                    var percentage = parseFloat(row[7]) || 0;
                    visibleWithTax += withTax;
                    visibleWithoutTax += withoutTax;


                    // totalPercentage += percentage;
                });
                        // new changes
                            
            // Calculate individual percentages dynamically to ensure total is 100%
            let individualPercentages = json.data.map(row => {
                let withTax = row[5] ? parseFloat(row[5].replace(/,/g, '')) : 0;
                return visibleWithTax > 0 ? (withTax / visibleWithTax) * 100 : 0; // Avoid division by zero
            });

            // Sum of dynamically calculated percentages
            totalPercentage = individualPercentages.reduce((sum, percentage) => sum + percentage, 0);

            // Adjust totalPercentage to be exactly 100% by distributing any rounding errors
            if (totalPercentage !== 100) {
                let roundingAdjustment = 100 - totalPercentage;
                individualPercentages[individualPercentages.length - 1] += roundingAdjustment; // Apply adjustment to the last item
                totalPercentage = 100; // Force total to be 100%
            }


                    // end

    // Update the footer totals
               
                // $('#without_tax_amount').text(moneyFormatIndia(visibleWithoutTax));
                // $('#with_tax_amount').text(moneyFormatIndia(visibleWithTax));

                $('#total_no_of_exc_po').text(json.total_po_num);
                $('#total_no_of_exc_con').text(json.total_no_of_con);
                $('#total_no_of_exc_qty').text(json.total_no_of_qty);
          
                $('#without_tax_amount_exc').text(json.page_without_tax_total);

                $('#with_tax_amount_exc').text(json.page_with_tax_total);
              
                $('#percentage_exc').text(totalPercentage.toFixed(2) + '%');

                // $('#grand_total_percentage').text(json.grand_total_percentage);
            //   $('#net_percentage_exc').text(netPercentage + "%");            // Display net percentage

                // Return the data for the table
                return json.data;
            }
      },
      dom: 'lBfrtip',
      buttons: [
          'copy', 'csv', 'excel', 'pdf', 'print'
      ]
   });

} 
else if(search == '4') {
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
      destroy: true,
      paging: true,
   
      "ajax": {
         url: ajax_url,
         type: "POST",
         data: data,
         
         dataSrc: function (json) {
    // Initialize totals
    // var visibleWithoutTax = 0;
    // var visibleWithTax = 0;
    // var totalPercentage = 0;


    // // Loop over the data received from the server
    // $.each(json.data, function (index, row) {
    //     // Assuming row[6] is 'without_tax_amount' and row[7] is 'with_tax_amount'
    //     var withoutTax = row[5] ? parseFloat(row[5].replace(/,/g, '')) : 0;
    //     var withTax = row[6] ? parseFloat(row[6].replace(/,/g, '')) : 0; // Removing commas and converting to float
    //     var percentage = parseFloat(row[7]) || 0;


        
    //     visibleWithoutTax += withoutTax;
    //     visibleWithTax += withTax;
    //     totalPercentage += percentage;

    // });

    
    // // Update the footer totals
    // $('#without_tax_amount_icode').text(json.page_without_tax_total);
    // $('#with_tax_amount_icode').text(json.page_with_tax_total);
    // $('#percentage_icode').text(totalPercentage.toFixed(2) + '%');


// new changes 
// Variables to track totals
let visibleWithoutTax = 0;
let visibleWithTax = 0;
let totalPercentage = 0;

// Loop over the data received from the server
$.each(json.data, function (index, row) {
    // Assuming row[5] is 'without_tax_amount', row[6] is 'with_tax_amount', and row[7] is the percentage
    var withoutTax = row[5] ? parseFloat(row[5].replace(/,/g, '')) : 0;
    var withTax = row[6] ? parseFloat(row[6].replace(/,/g, '')) : 0;

    visibleWithoutTax += withoutTax;
    visibleWithTax += withTax;
});

// Calculate individual percentages dynamically to ensure total is 100%
let individualPercentages = json.data.map(row => {
    let withTax = row[6] ? parseFloat(row[6].replace(/,/g, '')) : 0;
    return visibleWithTax > 0 ? (withTax / visibleWithTax) * 100 : 0; // Avoid division by zero
});

// Sum of dynamically calculated percentages
totalPercentage = individualPercentages.reduce((sum, percentage) => sum + percentage, 0);

// Adjust totalPercentage to be exactly 100% by distributing any rounding errors
if (totalPercentage !== 100) {
    let roundingAdjustment = 100 - totalPercentage;
    individualPercentages[individualPercentages.length - 1] += roundingAdjustment; // Apply adjustment to the last item
    totalPercentage = 100; // Force total to be 100%
}

// Update the footer totals

$('#total_qty_item').text(json.total_no_of_qty);
             
$('#without_tax_amount_icode').text(json.page_without_tax_total);
$('#with_tax_amount_icode').text(json.page_with_tax_total);
$('#percentage_icode').text(totalPercentage.toFixed(2) + '%');

    // Return the data for the table
    return json.data;
}

       
      },
      dom: 'lBfrtip',
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
      destroy: true,
      paging: true,
   
      "ajax": {
         url: ajax_url,
         type: "POST",
         data: data,
         
         dataSrc: function (json) {
    // Initialize totals
    var visibleWithoutTax = 0;
    var visibleWithTax = 0;
    var totalPercentage = 0;

    // Loop over the data received from the server
    $.each(json.data, function (index, row) {
        // Assuming row[6] is 'without_tax_amount' and row[7] is 'with_tax_amount'
        var withoutTax = row[5] ? parseFloat(row[5].replace(/,/g, '')) : 0;
        var withTax = row[6] ? parseFloat(row[6].replace(/,/g, '')) : 0; // Removing commas and converting to float
        var percentage = parseFloat(row[7]) || 0;

        
        visibleWithoutTax += withoutTax;
        visibleWithTax += withTax;
        // totalPercentage += percentage;

    });
      
            // Calculate individual percentages dynamically to ensure total is 100%
            let individualPercentages = json.data.map(row => {
                let withTax = row[6] ? parseFloat(row[6].replace(/,/g, '')) : 0;
                return visibleWithTax > 0 ? (withTax / visibleWithTax) * 100 : 0; // Avoid division by zero
            });

            // Sum of dynamically calculated percentages
            totalPercentage = individualPercentages.reduce((sum, percentage) => sum + percentage, 0);

            // Adjust totalPercentage to be exactly 100% by distributing any rounding errors
            if (totalPercentage !== 100) {
                let roundingAdjustment = 100 - totalPercentage;
                individualPercentages[individualPercentages.length - 1] += roundingAdjustment; // Apply adjustment to the last item
                totalPercentage = 100; // Force total to be 100%
            }

    // Update the footer totals

    $('#total_no_of_mon_po').text(json.total_no_of_po);
    $('#total_no_of_mon_con').text(json.total_no_of_con);
    $('#total_no_of_mon_qty').text(json.total_no_of_qty);
          

    $('#without_tax_amount_month').text(json.page_without_tax_total);
    $('#with_tax_amount_month').text(json.page_with_tax_total);
    $('#percentage_month').text(totalPercentage.toFixed(2) + '%');

    
    // Return the data for the table
    return json.data;
}
      },
      dom: 'lBfrtip',
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
      destroy: true,
      paging: true,
   

      "ajax": {
         url: ajax_url,
         type: "POST",
         data: data,
         
         dataSrc: function (json) {
    // Initialize totals
    var visibleWithoutTax = 0;
    var visibleWithTax = 0;
    var totalPercentage = 0;


    // Loop over the data received from the server
    $.each(json.data, function (index, row) {
        // Assuming row[6] is 'without_tax_amount' and row[7] is 'with_tax_amount'
        var withoutTax = row[5] ? parseFloat(row[5].replace(/,/g, '')) : 0;
        var withTax = row[6] ? parseFloat(row[6].replace(/,/g, '')) : 0; // Removing commas and converting to float
        var percentage = parseFloat(row[7]) || 0;

        
        visibleWithoutTax += withoutTax;
        visibleWithTax += withTax;
        // totalPercentage += percentage;

    });
      // Calculate individual percentages dynamically to ensure total is 100%
      let individualPercentages = json.data.map(row => {
                let withTax = row[6] ? parseFloat(row[6].replace(/,/g, '')) : 0;
                return visibleWithTax > 0 ? (withTax / visibleWithTax) * 100 : 0; // Avoid division by zero
            });

            // Sum of dynamically calculated percentages
            totalPercentage = individualPercentages.reduce((sum, percentage) => sum + percentage, 0);

            // Adjust totalPercentage to be exactly 100% by distributing any rounding errors
            if (totalPercentage !== 100) {
                let roundingAdjustment = 100 - totalPercentage;
                individualPercentages[individualPercentages.length - 1] += roundingAdjustment; // Apply adjustment to the last item
                totalPercentage = 100; // Force total to be 100%
            }

    // Update the footer totals

    $('#total_no_of_year_po').text(json.total_no_of_po);
    $('#total_no_of_year_con').text(json.total_no_of_con);
    $('#total_no_of_year_qty').text(json.total_no_of_qty);
          
    $('#without_tax_amount_year').text(json.page_without_tax_total);
    $('#with_tax_amount_year').text(json.page_with_tax_total);
    $('#percentage_year').text(totalPercentage.toFixed(2) + '%');

    // Return the data for the table
    return json.data;
}
      },
      dom: 'lBfrtip',
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
      destroy: true,
      paging: true,
   

  "ajax": {
     url: ajax_url,
     type: "POST",
     data: data,
         
         dataSrc: function (json) {
    // Initialize totals
    // var visibleWithoutTax = 0;
    // var visibleWithTax = 0;
    // var totalPercentage = 0;


    // // Loop over the data received from the server
    // $.each(json.data, function (index, row) {
    //     // Assuming row[6] is 'without_tax_amount' and row[7] is 'with_tax_amount'
    //     var withoutTax = row[5] ? parseFloat(row[5].replace(/,/g, '')) : 0;
    //     var withTax = row[6] ? parseFloat(row[6].replace(/,/g, '')) : 0; // Removing commas and converting to float
    //     var percentage = parseFloat(row[7]) || 0;

        
    //     visibleWithoutTax += withoutTax;
    //     visibleWithTax += withTax;
    //     // totalPercentage += percentage;

    // });
    //  // Calculate individual percentages dynamically to ensure total is 100%
    //  let individualPercentages = json.data.map(row => {
    //             let withTax = row[6] ? parseFloat(row[6].replace(/,/g, '')) : 0;
    //             return visibleWithTax > 0 ? (withTax / visibleWithTax) * 100 : 0; // Avoid division by zero
    //         });

    //         // Sum of dynamically calculated percentages
    //         totalPercentage = individualPercentages.reduce((sum, percentage) => sum + percentage, 0);

    //         // Adjust totalPercentage to be exactly 100% by distributing any rounding errors
    //         if (totalPercentage !== 100) {
    //             let roundingAdjustment = 100 - totalPercentage;
    //             individualPercentages[individualPercentages.length - 1] += roundingAdjustment; // Apply adjustment to the last item
    //             totalPercentage = 100; // Force total to be 100%
    //         }


    // // Update the footer totals
    // $('#without_tax_amount_po_date').text(json.page_without_tax_total);
    // $('#with_tax_amount_po_date').text(json.page_with_tax_total);
   // $('#percentage_po_date').text(totalPercentage.toFixed(2) + '%');


   var visibleWithoutTax = 0;
var visibleWithTax = 0;
var totalPercentage = 0;

// Loop over the data received from the server
$.each(json.data, function (index, row) {
    // Ensure the value exists and is a string, then process it
    var withoutTax = row[5] ? parseFloat(String(row[5]).replace(/,/g, '')) : 0;
    var withTax = row[6] ? parseFloat(String(row[6]).replace(/,/g, '')) : 0; // Removing commas and converting to float
    var percentage = row[7] ? parseFloat(row[7]) : 0;

    visibleWithoutTax += withoutTax;
    visibleWithTax += withTax;
    // totalPercentage += percentage;
});

// Calculate individual percentages dynamically to ensure total is 100%
let individualPercentages = json.data.map(row => {
    let withTax = row[6] ? parseFloat(String(row[6]).replace(/,/g, '')) : 0;
    return visibleWithTax > 0 ? (withTax / visibleWithTax) * 100 : 0; // Avoid division by zero
});

// Sum of dynamically calculated percentages
totalPercentage = individualPercentages.reduce((sum, percentage) => sum + percentage, 0);

// Adjust totalPercentage to be exactly 100% by distributing any rounding errors
if (totalPercentage !== 100) {
    let roundingAdjustment = 100 - totalPercentage;
    individualPercentages[individualPercentages.length - 1] += roundingAdjustment; // Apply adjustment to the last item
    totalPercentage = 100; // Force total to be 100%
}

// Update the footer totals
// $('#without_tax_amount_po_date').text(json.page_without_tax_total);
// $('#with_tax_amount_po_date').text(json.page_with_tax_total);
// $('#percentage_po_date').text(totalPercentage.toFixed(2) + '%');
 
$('#total_no_of_date_po').text(json.total_no_of_po);
    $('#total_no_of_date_con').text(json.total_no_of_con);
    $('#total_no_of_date_qty').text(json.total_no_of_qty);
          

$('#without_tax_amount_po_date').text(json.page_without_tax_total);
    $('#with_tax_amount_po_date').text(json.page_with_tax_total);
   $('#percentage_po_date').text(totalPercentage.toFixed(2) + '%');

    
    // Return the data for the table
    return json.data;
}
  },
  dom: 'lBfrtip',
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
      destroy: true,
      paging: true,
   
  "ajax": {
     url: ajax_url,
     type: "POST",
     data: data,
         
         dataSrc: function (json) {
    // Initialize totals
    var visibleWithoutTax = 0;
    var visibleWithTax = 0;
    var totalPercentage = 0;


    // Loop over the data received from the server
    $.each(json.data, function (index, row) {
        // Assuming row[6] is 'without_tax_amount' and row[7] is 'with_tax_amount'
        var withoutTax = row[2] ? parseFloat(row[2].replace(/,/g, '')) : 0;
        var withTax = row[3] ? parseFloat(row[3].replace(/,/g, '')) : 0; // Removing commas and converting to float
        var percentage = parseFloat(row[7]) || 0;

        
        visibleWithoutTax += withoutTax;
        visibleWithTax += withTax;
        // totalPercentage += percentage;

    });
     // Calculate individual percentages dynamically to ensure total is 100%
     let individualPercentages = json.data.map(row => {
                let withTax = row[3] ? parseFloat(row[3].replace(/,/g, '')) : 0;
                return visibleWithTax > 0 ? (withTax / visibleWithTax) * 100 : 0; // Avoid division by zero
            });

            // Sum of dynamically calculated percentages
            totalPercentage = individualPercentages.reduce((sum, percentage) => sum + percentage, 0);

            // Adjust totalPercentage to be exactly 100% by distributing any rounding errors
            if (totalPercentage !== 100) {
                let roundingAdjustment = 100 - totalPercentage;
                individualPercentages[individualPercentages.length - 1] += roundingAdjustment; // Apply adjustment to the last item
                totalPercentage = 100; // Force total to be 100%
            }


    // Update the footer totals
    $('#total_no_of_brand_qty').text(json.total_no_of_qty);
    $('#with_tax_amount_brand').text(json.page_with_tax_total);
    $('#without_tax_amount_brand').text(json.page_without_tax_total);
    $('#percentage_brand').text(totalPercentage.toFixed(2) + '%');

    
    // Return the data for the table
    return json.data;
}
  },
  dom: 'lBfrtip',
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
      destroy: true,
      paging: true,
   


  "ajax": {
     url: ajax_url,
     type: "POST",
     data: data,
         dataSrc: function (json) {
    // Initialize totals
    var visibleWithoutTax = 0;
    var visibleWithTax = 0;
    // Loop over the data received from the server
    $.each(json.data, function (index, row) {
        // Assuming row[6] is 'without_tax_amount' and row[7] is 'with_tax_amount'
        var withoutTax = row[17] ? parseFloat(row[17].replace(/,/g, '')) : 0;
        var withTax = row[18] ? parseFloat(row[18].replace(/,/g, '')) : 0; // Removing commas and converting to float
        
        visibleWithoutTax += withoutTax;
        visibleWithTax += withTax;
    });
    // Update the footer totals
    $('#without_tax_amount_po_no').text(json.page_without_tax_total);
    $('#with_tax_amount_po_no').text(json.page_with_tax_total);
    
    // Return the data for the table
    return json.data;
}
  },
  dom: 'lBfrtip',
// dom: '<"dt-top-container"<l><"dt-center-in-div"B><f>r>t<ip>',

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

