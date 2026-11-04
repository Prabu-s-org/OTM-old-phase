
$(document).ready(function () {
	// var table_id 	= "user_type_datatable";
	init_datatable(table_id,form_name,action);
	// allocation_list_datatable('stock_processing_datatable',form_name,'stock_processing_datatable');

	get_data();
   
});
function get_data(){
	
	init_datatable(table_id,form_name,action);
}



var company_name 	= sessionStorage.getItem("company_name");
var company_address	= sessionStorage.getItem("company_name");
var company_phone 	= sessionStorage.getItem("company_name");
var company_email 	= sessionStorage.getItem("company_name");
var company_logo 	= sessionStorage.getItem("company_name");

var form_name 		= 'invoice';
var form_header		= '';
var form_footer 	= '';
var table_name 		= '';
var table_id 		= 'invoice_datatable';
var action 			= "datatable";

var invoice_details_tableid = 'invoice_details_datatable';
// var invoice_stock_tableid = 'invoice_stock_datatable';

function get_list(){
alert("hii");
    var team_mem = document.getElementById('team_mem').value;

    alert(team_mem);
    init_datatable(table_id,form_name,action);


}

function sub_list_datatable(table_id = "", form_name = "", action = "") {

    var invoice_unique_id = $("#invoice_unique_id").val();

    var table = $("#" + table_id);

    var data = {
        "invoice_id": invoice_unique_id,
        "action": table_id,
    };
    var ajax_url = sessionStorage.getItem("folder_crud_link");

    var datatable = table.DataTable({
		destroy: true, 
        ordering: true,
        searching: true,
        "searching": false,
        "paging": false,
        "ordering": false,
        "info": false,
        "ajax": {
            url: ajax_url,
            type: "POST",
            data: data
        }
    });
}

function init_datatable(table_id='',form_name='',action='') {
	
	
	// alert(invoice_doc_status);
	var table = $("#"+table_id);
	var invoice_doc_status = $("#invoice_doc_status").val();
	var screen_id_val = $('#screen_id_val').val();

    var team_mem = $('#team_mem').val();

	// alert(screen_id_val);
	var user_type_unique_id = $('#user_type_unique_id').val();
	var data 	  = {
			"invoice_doc_status" : invoice_doc_status,
			"screen_id_val": screen_id_val,
			"user_type_unique_id": user_type_unique_id,
            "team_mem" : team_mem,
			"action"	: action, 
		};
	// var data 	  = {
	// 		"invoice_doc_status" : invoice_doc_status,
	// 		"action"	: action, 
	// 	};
		var ajax_url = sessionStorage.getItem("folder_crud_link");
	
		var datatable = table.DataTable({
			destroy: true, //new line
			ordering    : true,
			searching   : true,
			"ajax"		: {
				url 	: ajax_url,
				type 	: "POST",
				data 	: data
			},
            // dom: 'Bfrtip',
            // buttons: [
            //     'copy', 'csv', 'excel', 'pdf', 'print'
            // ]
			dom: 'Bfrtip',
			buttons: [
				{
					extend: 'copyHtml5',
					text: 'Copy',
					exportOptions: { columns: ':visible' }
				},
				{
					extend: 'csvHtml5',
					text: 'CSV',
					exportOptions: { columns: ':visible' }
				},
				{
					extend: 'excelHtml5',
					text: 'Excel',
					exportOptions: { columns: ':visible' }
				},
				{
					extend: 'pdfHtml5',
					text: 'PDF',
					exportOptions: { columns: ':visible' }
				},
				{
					extend: 'print',
					text: 'Print',
					exportOptions: { columns: ':visible' }
				},
				{
					extend: 'colvis', // Column visibility button
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
			lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
			pageLength: 10 // Default selected value
		});
		$('#columnVisibilityForm').on('change', 'input[type="checkbox"]', function() {
			var columnIdx = $(this).data('column');
			var isVisible = $(this).is(':checked');
			datatable.column(columnIdx).visible(isVisible); // Use datatable instead of table
		});
	}
	
function invoice_cu(unique_id = "") {

    var internet_status  = is_online();

    if (!internet_status) {
        sweetalert("no_internet");
        return false;
    }

    var is_form = form_validity_check("was-validated");

    if (is_form) {

        var data 	 = $(".was-validated").serialize();
        data 		+= "&unique_id="+unique_id+"&action=createupdate";

        var ajax_url = sessionStorage.getItem("folder_crud_link");
        var url      = sessionStorage.getItem("list_link");

        // console.log(data);
        $.ajax({
			type 	: "POST",
			url 	: ajax_url,
			data 	: data,
			beforeSend 	: function() {
				$(".createupdate_btn").attr("disabled","disabled");
				$(".createupdate_btn").text("Loading...");
			},
			success		: function(data) {

				var obj     = JSON.parse(data);
				var msg     = obj.msg;
				var status  = obj.status;
				var error   = obj.error;

				if (!status) {
					url 	= '';
                    $(".createupdate_btn").text("Error");
                    console.log(error);
				} else {
					if (msg=="already") {
						// Button Change Attribute
						url 		= '';

						$(".createupdate_btn").removeAttr("disabled","disabled");
						if (unique_id) {
							$(".createupdate_btn").text("Update");
						} else {
							$(".createupdate_btn").text("Save");
						}
					}
				}

				sweetalert(msg,url);
			},
			error 		: function(data) {
				alert("Network Error");
			}
		});


    } else {
        sweetalert("form_alert");
    }
}



function get_under_user_type_ids()
{ 
	var under_user_type= $('#under_user_type_name').val();
	$('#under_user_type').val(under_user_type);
}

function get_under_user_type (user_type = "") {

$("#under_user_type_name").html('');
	var ajax_url = sessionStorage.getItem("folder_crud_link");

	if (staff_id) {
		var data = {
			"user_type" : user_type,
			"action"	: "user_type_options"
		}

		$.ajax({
			type 	: "POST",
			url 	: ajax_url,
			data 	: data,
			success : function(data) {

				if (data) { 
					$("#under_user_type_name").html(data);
				}

			}
		});
	}
}


function print(file_name)
{
	window.location='uploads/invoice/' + file_name,'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no';
}

function print_view(file_name) {

    window.location = 'uploads/invoice/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no';
}

function print_view_1(file_name) {

    window.location = 'uploadspo_form/po_attach/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no';
}
function print_pdf_1(file_name)
{
    
 onmouseover=window.open('uploads/po_form/po_attach/' + file_name,'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
}
function print_view_2(file_name) {

    window.location = 'uploadspo_form/po_attach/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no';
}

function print_pdf_2(file_name)
{
    
 onmouseover=window.open('uploads/po_form/po_attach/' + file_name,'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
}



function processInput1() {
    let option1    = document.getElementById("optionInput1").value.trim();
    let option2    = document.getElementById("optionInput2").value.trim();
    let container = document.getElementById("inputContainer");
    let table     = document.getElementById("dynamicTable");

    container.innerHTML = ""; // Clear input container
    table.innerHTML = ""; // Clear previous table

    // Validate input
    if (option === "" || isNaN(option) || option <= 0 || option > 10) {
        alert("Invalid input! Please enter a valid number (1 to 10).");
        document.getElementById("optionInput").value = "";
        return;
    }

    // Convert option to an integer
    let count = parseInt(option);

    // Create a table element
    let tbl = document.createElement("table");
    tbl.classList.add("table", "table-bordered");

    // Create table rows based on the entered number
   for (let i = 1; i <= count; i++) {
    let row = document.createElement("tr");
    row.classList.add("table-row", "Stvx"); // Adding class for CSS styling

    // Create table cell for label
    let cellLabel = document.createElement("td");
    cellLabel.textContent = `Value ${i}:`;
    row.appendChild(cellLabel);

    // Create table cell for input field
    let cellInput = document.createElement("td");
    let inputBox = document.createElement("input");
    inputBox.type = "text";
    inputBox.placeholder = `Enter value ${i}`;
    inputBox.classList.add("form-control", "serial-input"); // Add class to identify inputs
    inputBox.setAttribute("data-index", i);
    inputBox.oninput = function (event) { 
        let value = inputBox.value.replace(/[^0-9]/g, ''); // Remove anything that is not a digit
        inputBox.value = value; // Set the value back to the input field
        validateDuplicateValues(); 
        updateOutput(); // Update collected values on input change
    };
    cellInput.appendChild(inputBox);
    row.appendChild(cellInput);

    // Create a div element to wrap the row
    let divWrapper = document.createElement("div");
    divWrapper.classList.add("mt-2");  // You can add a custom class to style the div

    // Append the row to the div
    divWrapper.appendChild(row);

    // Append the div to the table
    tbl.appendChild(divWrapper);
}


    table.appendChild(tbl);
    updateOutput();
}





function processInput() {
    let option1 = document.getElementById("optionInput1").value.trim(); // rows
    let option2 = document.getElementById("optioninput2").value.trim(); // columns
    let table = document.getElementById("dynamicTable");

    table.innerHTML = ""; // Clear previous table

    // Validate input
    if (option1 === "" || option2 === "" || isNaN(option1) || isNaN(option2) ||
        option1 <= 0) {
        alert("Invalid input! Please enter valid numbers.");
        return;
    }

    let rows = parseInt(option1);
    let cols = parseInt(option2);

    // Generate rows and columns
    for (let i = 0; i < rows; i++) {
        let tr = document.createElement("tr");

        for (let j = 0; j < cols; j++) {
            let td = document.createElement("td");
            let input = document.createElement("input");
            input.type = "text";
            input.classList.add("form-control", "serial-input");
            input.setAttribute("data-row", i);
            input.setAttribute("data-col", j);
            input.oninput = function () {
                input.value = input.value.replace(/[^a-zA-Z0-9]/g, ''); // only numbers
                validateDuplicateValues();
                updateOutput(option2);
            };
            td.appendChild(input);
            tr.appendChild(td);
        }

        table.appendChild(tr);
    }

    updateOutput(option2);
}


function updateOutput(option2) {
    let inputs = document.querySelectorAll(".serial-input");
    let values = Array.from(inputs).map(i => i.value.trim()).filter(v => v !== ""); // Get all non-empty values
    let collectedValues = values.join(","); // Join values with a comma

    document.getElementById("serial_no").value = collectedValues; // Update modal input

    // Append values to the correct `ser_qty` input based on selected `item_code`
 
    if (selectedItemCode) {
        let targetInput = document.getElementById(`ser_qty_${selectedItemCode}`);
        let serial_no_lbl = document.getElementById(`serial_no_lbl_${selectedItemCode}`);
        document.getElementById(`spec_srl_no${selectedItemCode}`).value = option2;
        if (targetInput) {
            targetInput.value = collectedValues;
            // const values = collectedValues.split(','); // will return array even for single value
	        serial_no_lbl.innerHTML = collectedValues; // safely display one per line
        }
    }
}


// Function to validate duplicate values
function validateDuplicateValues() {
    let inputs = document.querySelectorAll(".serial-input");
    let values = new Set();
    let hasDuplicate = false;

    inputs.forEach(input => {
        let value = input.value.trim();
        if (value !== "") {
            if (values.has(value)) {
                hasDuplicate = true;
                // input.style.border = "2px solid red"; // Highlight duplicate
                input.value = ""; 
            } else {
                
                values.add(value);
                input.style.border = "1px solid #ced4da"; // Reset border
            }
        }
    });

    if (hasDuplicate) {
        alert("Duplicate values are not allowed!");
    }
}


//for serial no updateOutput

function update_processInput(serial_no) {
   
    let option1 = document.getElementById("optionInput1New").value.trim(); // rows
    let option2 = document.getElementById("optionInput2New").value.trim(); // columns
    let table = document.getElementById("update_dynamicTable"); // updated table ID
    document.getElementById("update_collected_values_new").value = serial_no;


    table.innerHTML = ""; // Clear previous table

    // Validate input
    if (option1 === "" || option2 === "" || isNaN(option1) || isNaN(option2) || option1 <= 0) {
        alert("Invalid input! Please enter valid numbers.");
        return;
    }

    let rows = parseInt(option1);
    let cols = parseInt(option2);

    // Get and split pre-filled values
    let valuesStr = serial_no;
    let valuesArray = valuesStr !== "" ? valuesStr.split(",") : [];

    let valueIndex = 0;

    // Generate rows and columns
    for (let i = 0; i < rows; i++) {
        let tr = document.createElement("tr");

        for (let j = 0; j < cols; j++) {
            let td = document.createElement("td");
            let input = document.createElement("input");
            input.type = "text";
            input.classList.add("form-control", "serial-input-update");
            input.setAttribute("data-row", i);
            input.setAttribute("data-col", j);

            // Fill value from array if exists
            if (valueIndex < valuesArray.length) {
                input.value = valuesArray[valueIndex].trim();
                valueIndex++;
            }

            input.oninput = function () {
                input.value = input.value.replace(/[^a-zA-Z0-9]/g, ''); // only numbers
                update_validateDuplicateValues();
                updatesrl_output();
            };

            td.appendChild(input);
            tr.appendChild(td);
        }

        table.appendChild(tr);
    }
    // updatesrl_output();
}

function updatesrl_output() {
    let inputs = document.querySelectorAll(".serial-input-update");
    let values = Array.from(inputs).map(i => i.value.trim()).filter(v => v !== ""); // Get all non-empty values
    let collectedValues = values.join(","); // Join values with a comma

    document.getElementById("update_collected_values_new").value = collectedValues; // Update modal input

    // Append values to the correct `ser_qty` input based on selected `item_code`
 
    if (selectedItemCode) {
        let targetInput = document.getElementById(`ser_qty_${selectedItemCode}`);
        let serial_no_lbl = document.getElementById(`serial_no_lbl_${selectedItemCode}`);
       
        if (targetInput) {
            
            targetInput.value = collectedValues;
            serial_no_lbl.innerHTML = collectedValues; // clear first
           
        }
    }
}

function update_validateDuplicateValues() {
    let inputs = document.querySelectorAll(".serial-input-update");
    let values = new Set();
    let hasDuplicate = false;

    inputs.forEach(input => {
        let value = input.value.trim();
        if (value !== "") {
            if (values.has(value)) {
                hasDuplicate = true;
                // input.style.border = "2px solid red"; // Highlight duplicate
                input.value = ""; 
            } else {
                
                values.add(value);
                input.style.border = "1px solid #ced4da"; // Reset border
            }
        }
    });

    if (hasDuplicate) {
        alert("Duplicate values are not allowed!");
    }
}



function generateTable(rows, cols) {
	let table = document.getElementById("dynamicTable");

	for (let i = 0; i < rows; i++) {
		let row = table.insertRow();
		for (let j = 0; j < cols; j++) {
			let cell = row.insertCell();
			let inputBox = document.createElement("input");
			inputBox.type = "text";
			inputBox.classList.add("table-input");
			inputBox.oninput = function () { validateInput(this) };
			inputBox.addEventListener("input", updateOutput);
			cell.appendChild(inputBox);
		}
	}
}

function validateInput(input) {
	input.value = input.value.replace(/[^0-9]/g, ''); // Allow only numbers

	// Prevent input consisting only of zeros (e.g., "0", "00", "0000")
	if (/^0+$/.test(input.value)) {
		alert("Invalid input! Only positive numbers are allowed.");
		input.value = "";
		return;
	}

	// Check for duplicate values
	let inputs = document.querySelectorAll(".table-input");
	let values = Array.from(inputs).map(i => i.value).filter(v => v !== ""); // Get all entered values, excluding empty ones

	if (values.filter(v => v === input.value).length > 1) {
		alert("Duplicate values are not allowed!");
		input.value = "";
	}

	updateOutput();
}

// function updateOutput() {
// 	let inputs = document.querySelectorAll(".table-input");
// 	let values = Array.from(inputs).map(i => i.value).filter(v => v !== ""); // Get all valid values
// 	document.getElementById("serial_no").value = values.join(",");
// }

function filterMainInput(input) {
	input.value = input.value.replace(/[^0-9]/g, ''); // Allow only numbers

	// Allow leading zeros (e.g., "01", "001") but not only zeros ("0", "00", "000")
	if (/^0+$/.test(input.value)) {
		alert("Invalid input! Only positive numbers are allowed.");
		input.value = "";
	}
}



document.getElementById('fileInput').addEventListener('change', handleFileUpload);

function handleFileUpload(event) {
    let file = event.target.files[0];
    if (!file) return;

    let reader = new FileReader();
    reader.onload = function (e) {
        let data = new Uint8Array(e.target.result);
        let workbook = XLSX.read(data, { type: 'array' });

        let sheetName = workbook.SheetNames[0]; // Read first sheet
        let sheet = workbook.Sheets[sheetName];
        let jsonData = XLSX.utils.sheet_to_json(sheet, { header: 1 });

        // alert(jsonData);

        processExcelData(jsonData);
    };
    reader.readAsArrayBuffer(file);
}

function processExcelData(data) {
    if (data.length < 2) {
        alert("The Excel file must have at least 2 rows!");
        return;
    }

    // Get values from user input
    let rowCount = parseInt(document.getElementById('optionInput1').value);
    let colCount = parseInt(document.getElementById('optioninput2').value);

    if (isNaN(rowCount) || isNaN(colCount)) {
        alert("Please enter valid numbers for Invoice Qty and Select fields.");
        return;
    }

    let extractedValues = [];

    // Loop through selected range
    for (let row = 1; row < 1 + rowCount && row < data.length; row++) {
        for (let col = 0; col < colCount && col < data[row].length; col++) {
            let cellValue = data[row][col];
            if (cellValue !== undefined && cellValue !== null && cellValue !== '') {
                extractedValues.push(cellValue);
            }
        }
    }

    let combinedString = extractedValues.join(",");

    // Set to output fields
    document.getElementById('upload_collected_values').value = combinedString; // ✅ Your new field

    if (typeof selectedItemCode !== 'undefined' && selectedItemCode) {
        let serQtyInput = document.getElementById(`ser_qty_${selectedItemCode}`);
        let serial_no_lbl = document.getElementById(`serial_no_lbl_${selectedItemCode}`);
        

        if (serQtyInput){ 
            serQtyInput.value = combinedString;
            // const values = combinedString.split(','); // will return array even for single value
	        serial_no_lbl.innerHTML = combinedString; // safely display one per line
        }
      
    }
}



function processExcelData_bkp(data) {
    if (data.length < 2) {
        alert("The Excel file must have at least 2 rows!");
        return;
    }

    let firstColumnValues = new Map();
    let secondColumnValues = new Map();
    let duplicateAlerts = [];

    for (let row = 1; row < data.length; row++) { // Start from row 1 to skip headers
        let col1Value = data[row][0]; // First column (desktop_no)
        let col2Value = data[row][1]; // Second column (monitor_no)

        // Skip empty or invalid values
        if (!col1Value || !col2Value) continue;

        // Check if the same value exists in both columns of the same row
        if (col1Value == col2Value) {
            duplicateAlerts.push(`Error: Same value '${col1Value}' found in both columns at row ${row + 1}.`);
        }

        // Check for duplicate values in the first column
        if (firstColumnValues.has(col1Value)) {
            duplicateAlerts.push(`Duplicate: Serial number '${col1Value}' appears in column 1 (Row ${firstColumnValues.get(col1Value) + 1} and Row ${row + 1}).`);
        } else {
            firstColumnValues.set(col1Value, row);
        }

        // Check for duplicate values in the second column
        if (secondColumnValues.has(col2Value)) {
            duplicateAlerts.push(`Duplicate: Serial number '${col2Value}' appears in column 2 (Row ${secondColumnValues.get(col2Value) + 1} and Row ${row + 1}).`);
        } else {
            secondColumnValues.set(col2Value, row);
        }

        // Check if value from the first column exists in the second column
        if (secondColumnValues.has(col1Value)) {
            duplicateAlerts.push(`Duplicate: Serial number '${col1Value}' appears in column 1 (Row ${row + 1}) and column 2 (Row ${secondColumnValues.get(col1Value) + 1}).`);
        }

        // Check if value from the second column exists in the first column
        if (firstColumnValues.has(col2Value)) {
            duplicateAlerts.push(`Duplicate: Serial number '${col2Value}' appears in column 2 (Row ${row + 1}) and column 1 (Row ${firstColumnValues.get(col2Value) + 1}).`);
        }

        firstColumnValues.set(col1Value, row);
        secondColumnValues.set(col2Value, row);
    }

    if (duplicateAlerts.length > 0) {
        alert(duplicateAlerts.join("\n"));
        return;
    }

    // Convert maps to comma-separated values
    let firstColumnValuesString = [...firstColumnValues.keys()].join(",");
    let secondColumnValuesString = [...secondColumnValues.keys()].join(",");

    // Assign values to the output fields
    document.getElementById('outputValues1').value = firstColumnValuesString;
    document.getElementById('outputValues2').value = secondColumnValuesString;

    // Append values to their respective input fields based on selected item code
    if (selectedItemCode) {
        let serQtyInput = document.getElementById(`ser_qty_${selectedItemCode}`);
        let monSerQtyInput = document.getElementById(`mon_ser_qty_${selectedItemCode}`);

        if (serQtyInput) {
            serQtyInput.value = firstColumnValuesString;
        }

        if (monSerQtyInput) {
            monSerQtyInput.value = secondColumnValuesString;
            monSerQtyInput.style.display = "block"; // Ensure it's visible
        }
    }
}


function toggleInput(option, itemCode) {
    selectedItemCode = itemCode; // Update the selected item code

    document.getElementById('enterSection').style.display = option === 'enter' ? 'block' : 'none';
    document.getElementById('uploadSection').style.display = option === 'upload' ? 'block' : 'none';

    document.getElementById('serial_no').value = ""; 
    document.getElementById('outputValues1').value = ""; 
    document.getElementById('outputValues2').value = ""; 
    document.getElementById('optionInput').value = ""; 
    document.getElementById('dynamicTable').innerHTML = "";
    document.getElementById('upload_collected_values').value = ""; 
    document.getElementById(`ser_qty_${itemCode}`).value = "";

    // Reset only the mon_ser_qty field for the selected item code
    let monSerQtyInput = document.getElementById(`mon_ser_qty_${itemCode}`);
    let SerQtyInput = document.getElementById(`ser_qty_${itemCode}`);



    if (monSerQtyInput) {
        monSerQtyInput.style.display = option === 'upload' ? 'block' : 'none';
        SerQtyInput.style.display =  'block';
		

    }


	

   
}
// function processExcelData(data) {
//     if (data.length < 2) {
//         alert("The Excel file must have at least 2 rows!");
//         return;
//     }

//     let firstColumnValues = new Map();
//     let secondColumnValues = new Map();
//     let duplicateAlerts = [];

//     for (let row = 1; row < data.length; row++) { // Start from row 1 to skip headers
//         let col1Value = data[row][0]; // First column (desktop_no)
//         let col2Value = data[row][1]; // Second column (monitor_no)

//         // Skip empty or invalid values
//         if (!col1Value || !col2Value) continue;

//         // Check if the same value exists in both columns of the same row
//         if (col1Value == col2Value) {
//             duplicateAlerts.push(`Error: Same value '${col1Value}' found in both columns at row ${row + 1}.`);
//         }

//         // Check for duplicate values in the first column
//         if (firstColumnValues.has(col1Value)) {
//             duplicateAlerts.push(`Duplicate: Serial number '${col1Value}' appears in column 1 (Row ${firstColumnValues.get(col1Value) + 1} and Row ${row + 1}).`);
//         } else {
//             firstColumnValues.set(col1Value, row);
//         }

//         // Check for duplicate values in the second column
//         if (secondColumnValues.has(col2Value)) {
//             duplicateAlerts.push(`Duplicate: Serial number '${col2Value}' appears in column 2 (Row ${secondColumnValues.get(col2Value) + 1} and Row ${row + 1}).`);
//         } else {
//             secondColumnValues.set(col2Value, row);
//         }

//         // Check if value from the first column exists in the second column
//         if (secondColumnValues.has(col1Value)) {
//             duplicateAlerts.push(`Duplicate: Serial number '${col1Value}' appears in column 1 (Row ${row + 1}) and column 2 (Row ${secondColumnValues.get(col1Value) + 1}).`);
//         }

//         // Check if value from the second column exists in the first column
//         if (firstColumnValues.has(col2Value)) {
//             duplicateAlerts.push(`Duplicate: Serial number '${col2Value}' appears in column 2 (Row ${row + 1}) and column 1 (Row ${firstColumnValues.get(col2Value) + 1}).`);
//         }

//         firstColumnValues.set(col1Value, row);
//         secondColumnValues.set(col2Value, row);
//     }

//     if (duplicateAlerts.length > 0) {
//         alert(duplicateAlerts.join("\n"));
//         return;
//     }

//     // Display values
//     document.getElementById('outputValues1').value = [...firstColumnValues.keys()].join(",");
//     document.getElementById('outputValues2').value = [...secondColumnValues.keys()].join(",");

// }

