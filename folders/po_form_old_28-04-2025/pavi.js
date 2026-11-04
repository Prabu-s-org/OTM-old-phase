// $(document).on('click', '.show-consignee', function () {
//     const batchId = $(this).data('batch-id');
//     const row = $(this).closest('tr');
//     const nextRow = row.next('.detail-row');

//     // If details already shown, toggle it
//     if (nextRow.length) {
//         nextRow.toggle();
//         return;
//     }

//     // AJAX call to fetch consignee assignment details
//     $.ajax({
//         url: 'folders/po_form/get_consignee_assign_details.php',
//         type: 'POST',
//         data: { batch_id: batchId },
//         success: function (res) {
//             // Check if response is valid and contains data
//             if (res.status === 'success' && Array.isArray(res.data) && res.data.length > 0) {
//                 let html = `
//                 <tr class="detail-row">
//                     <td colspan="100%">
//                         <table class="table table-bordered table-sm mb-0 table-hover">
//                             <thead style="background-color: #004085; color: white;">
//                                 <tr>
//                                  <th>S.No</th>
//                                     <th>Consignee</th>
//                                     <th>Contact</th>
//                                     <th>Item Code</th>
//                                     <th>Product</th>
//                                     <th>Qty</th>
//                                     <th>Assign Qty</th>
//                                 </tr>
//                             </thead>
//                             <tbody>`;

//                 // Loop through each record and alternate row color
//                 res.data.forEach((item, index) => {
//                     const rowClass = index % 2 === 0 ? 'table-primary' : 'table-secondary';

//                     html += `
//                         <tr class="${rowClass}">
//                         <td>${index + 1}</td>
//                             <td>${item.con_name}</td>
//                             <td>${item.con_contact_number}</td>
//                             <td>${item.item_code}</td>
//                             <td>${item.product}</td>
//                             <td>${item.qty}</td>
//                             <td>${item.assign_qty}</td>
//                         </tr>`;
//                 });

//                 html += `
//                             </tbody>
//                         </table>
//                     </td>
//                 </tr>`;

//                 row.after(html);
//             } else {
//                 // No data found
//                 let html = `
//                     <tr class="detail-row">
//                         <td colspan="100%" class="text-center text-danger">
//                             <strong>No data imported against this batch number.</strong>
//                         </td>
//                     </tr>`;
//                 row.after(html);
//             }
//         },
//         error: function () {
//             Swal.fire("Error", "AJAX request failed. Please try again.", "error");
//         }
//     });
// });// <!----pavi script>
$(document).ready(function() {
   
    // insurence();
    // ld_cal_validation();
    get_po_no();
    get_my_num();
    //   get_check_po_batchs(val);
        get_check_po_batchs();
        amcsub_list_datatable("amc_table_datatable");
});
function get_check_po_batchs(){
    // alert("hii");
    var select_batch_numbers = document.getElementById('batch_numbers').value;
    // alert(select_batch_numbers);
    // get_assign_qty_record();
    
    get_details(select_batch_numbers);
}
    function excel_import(batch_id) {
    console.log("Batch ID:", batch_id); // Debug
    document.getElementById('modal_batch_id').value = batch_id;
    // document.getElementById('batch_record').value = batch_id;
//  $('#demossss').modal('show');
    // Show modal using Bootstrap 5
    var myModal = new bootstrap.Modal(document.getElementById('demossss'));
    myModal.show();
}

function import_close() {
    var myModalEl = document.getElementById('demossss');
    var modal = bootstrap.Modal.getInstance(myModalEl);
    modal.hide();
}

// FIRST CLICK: Show consignee summary
$(document).on('click', '.show-consignee', function () {
    const batchId = $(this).data('batch-id');
    const row = $(this).closest('tr');
    const nextRow = row.next('.detail-row');

    if (nextRow.length) {
        nextRow.toggle();
        return;
    }

    $.ajax({
        url: 'folders/po_form/get_consignee_assign_details.php',
        type: 'POST',
        dataType: 'json',
        data: { batch_id: batchId },
        success: function (res) {
            let html = '';

            if (res.status === 'success' && Array.isArray(res.data) && res.data.length > 0) {
                html = `
                <tr class="detail-row">
                    <td colspan="100%">
                        <table class="table table-bordered table-sm mb-0 table-hover">
                            <thead style="background-color: #004085; color: white;">
                                <tr>
                                    <th>S.No</th>
                                    <th>Consignee Address</th>
                                    <th>Order Qty</th>
                                    <th>Assign Qty</th>
                                </tr>
                            </thead>
                            <tbody>`;

                res.data.forEach((item, index) => {
                    html += `
                        <tr class="${index % 2 === 0 ? 'table-primary' : 'table-secondary'}">
                            <td>${index + 1}</td>
                            <td>${item.con_address}</td>
                            <td class="order-qty-click" style="cursor:pointer; color:blue;" 
                                data-batch-id="${batchId}" 
                                data-consignee-name="${item.con_address}">
                                ${item.order_qty}
                            </td>
                            <td>${item.assign_qty}</td>
                        </tr>
                        <tr class="item-detail-row" style="display:none;"></tr>`; // Empty row for item details
                });

                html += `
                            </tbody>
                        </table>
                    </td>
                </tr>`;
            } else {
                html = `
                    <tr class="detail-row">
                        <td colspan="100%" class="text-center text-danger">
                            <strong>No data found for this batch.</strong>
                        </td>
                    </tr>`;
            }

            row.after(html);
        },
        error: function () {
            Swal.fire("Error", "AJAX request failed. Please try again.", "error");
        }
    });
});


$(document).on('click', '.order-qty-click', function () {
    const consigneeaddress = $(this).data('consignee-name');
    const batchId = $(this).data('batch-id');

    // AJAX to fetch item-wise data
    $.ajax({
        url: 'folders/po_form/get_itemwise_consignee_details.php',
        type: 'POST',
        dataType: 'json',
        data: {
            batch_id: batchId,
            con_address: consigneeaddress
        },
        success: function (res) {
            if (res.status === 'success' && Array.isArray(res.data) && res.data.length > 0) {
                let html = `
                    <table class="table table-bordered table-sm table-hover mb-0">
                        <thead style="background-color:#6610f2; color:white;">
                            <tr>
                                <th>S.No</th>
                                <th>Item Code</th>
                                <th>Product</th>
                                <th>Order Qty</th>
                                <th>Assign Qty</th>
                            </tr>
                        </thead>
                        <tbody>`;

                res.data.forEach((item, idx) => {
                    html += `
                        <tr>
                            <td>${idx + 1}</td>
                            <td>${item.item_code}</td>
                            <td>${item.product}</td>
                            <td>${item.qty}</td>
                            <td>${item.assign_qty}</td>
                        </tr>`;
                });

                html += `</tbody></table>`;

                $('#itemDetailsModalLabel').text(`Item Details for ${consigneeaddress}`);
                $('#item-details-body').html(html);
                const modal = new bootstrap.Modal(document.getElementById('itemDetailsModal'));
                modal.show();
            } else {
                $('#item-details-body').html(`<p class="text-danger text-center">No item data found for ${consigneeName}</p>`);
                const modal = new bootstrap.Modal(document.getElementById('itemDetailsModal'));
                modal.show();
            }
        },
        error: function () {
            Swal.fire("Error", "Unable to load item-wise details.", "error");
        }
    });
});








$(document).on('click', '.show-consignee_old', function () {
    const batchId = $(this).data('batch-id');
    const row = $(this).closest('tr');
    const nextRow = row.next('.detail-row');

    // If details already shown, toggle it
    if (nextRow.length) {
        nextRow.toggle();
        return;
    }

    // AJAX call to fetch consignee assignment details
    $.ajax({
        url: 'folders/po_form/get_consignee_assign_details.php',
        type: 'POST',
        data: { batch_id: batchId },
        success: function (res) {
            // Check if response is valid and contains data
            if (res.status === 'success' && Array.isArray(res.data) && res.data.length > 0) {
                let html = `
                <tr class="detail-row">
                    <td colspan="100%">
                        <table class="table table-bordered table-sm mb-0 table-hover">
                            <thead style="background-color: #004085; color: white;">
                                <tr>
                                 <th>S.No</th>
                                    <th>Consignee</th>
                                    <th>Contact</th>
                                    <th>Item Code</th>
                                    <th>Product</th>
                                    <th>Qty</th>
                                    <th>Assign Qty</th>
                                </tr>
                            </thead>
                            <tbody>`;

                // Loop through each record and alternate row color
                res.data.forEach((item, index) => {
                    const rowClass = index % 2 === 0 ? 'table-primary' : 'table-secondary';

                    html += `
                        <tr class="${rowClass}">
                        <td>${index + 1}</td>
                            <td>${item.con_name}</td>
                            <td>${item.con_contact_number}</td>
                            <td>${item.item_code}</td>
                            <td>${item.product}</td>
                            <td>${item.qty}</td>
                            <td>${item.assign_qty}</td>
                        </tr>`;
                });

                html += `
                            </tbody>
                        </table>
                    </td>
                </tr>`;

                row.after(html);
            } else {
                // No data found
                let html = `
                    <tr class="detail-row">
                        <td colspan="100%" class="text-center text-danger">
                            <strong>No data imported against this batch number.</strong>
                        </td>
                    </tr>`;
                row.after(html);
            }
        },
        error: function () {
            Swal.fire("Error", "AJAX request failed. Please try again.", "error");
        }
    });
});

// function editConsignee(btn) {
//     alert("hii");
//     const $btn = $(btn);
// alert(btn);
// // alert(val($btn.data('unique-id')));
//     $('#stored_consignee').val($btn.data('unique-id'));
//     $('#up_con_address').val($btn.data('address'));
//     $('#up_con_district').val($btn.data('district'));
//     $('#up_zone').val($btn.data('zone'));
//     $('#up_con_pincode').val($btn.data('pincode'));
//     $('#up_con_contact_name').val($btn.data('contact-name'));
//     $('#up_con_contact_number').val($btn.data('contact-number'));
//     $('#up_con_lan_num').val($btn.data('landline'));
//     $('#up_consignee_gst').val($btn.data('gst'));
//     $('#up_verify_sts').val($btn.data('status'));

//     // Show the modal
//     const myModal = new bootstrap.Modal(document.getElementById('editConsigneeModal'));
//     myModal.show();
// }


function editConsignee_overs(button) {
    alert(button);
    
    alert("hii");
    // const data = button.dataset;
const data = button.dataset;
    console.log(data);
    document.getElementById('stored_consignee').value = data.uniqueid;
    document.getElementById('up_con_address').value = data.address;
    document.getElementById('up_con_district').value = data.district;
    document.getElementById('up_zone').value = data.zone;
    document.getElementById('up_con_pincode').value = data.pincode;
    document.getElementById('up_con_contact_name').value = data.contactname;
    document.getElementById('up_con_contact_number').value = data.contactnumber;
    document.getElementById('up_con_lan_num').value = data.landline;
    document.getElementById('up_consignee_gst').value = data.gst;
    document.getElementById('up_verify_sts').value = data.status;

    // Show Bootstrap 5 modal
    const modal = new bootstrap.Modal(document.getElementById('editConsigneeModal'));
    modal.show();
}
function editConsignee_test(button) {
    alert(button);
    const data = button.dataset;
    console.log(data);
    alert("hii");

    // Use bracket notation for hyphenated keys
    document.getElementById('stored_consignee').value = data['uniqueid'];
    document.getElementById('up_con_address').value = data['address'];
    document.getElementById('up_con_district').value = data['district'];
    document.getElementById('up_zone').value = data['zone'];
    document.getElementById('up_con_pincode').value = data['pincode'];
    document.getElementById('up_con_contact_name').value = data['contactName'];
    document.getElementById('up_con_contact_number').value = data['contactNumber'];
    document.getElementById('up_con_lan_num').value = data['landline'];
    document.getElementById('up_consignee_gst').value = data['gst'];
    document.getElementById('up_verify_sts').value = data['status'];

    // Show the modal
    const modal = new bootstrap.Modal(document.getElementById('editConsigneeModal'));
    modal.show();
}

function editConsigneesss(button) {
    
    const data = button.dataset;
        console.log(data);
        alert("hii");
    document.getElementById('stored_consignee').value = data.unique-id;
    document.getElementById('up_con_address').value = data.address;
    document.getElementById('up_con_district').value = data.district;
    document.getElementById('up_zone').value = data.zone;
    document.getElementById('up_con_pincode').value = data.pincode;
    document.getElementById('up_con_contact_name').value = data.contactName;
    document.getElementById('up_con_contact_number').value = data.contactNumber;
    document.getElementById('up_con_lan_num').value = data.landline;
    document.getElementById('up_consignee_gst').value = data.gst;
    document.getElementById('up_verify_sts').value = data.status;

    const modal = new bootstrap.Modal(document.getElementById('editConsigneeModal'));
    modal.show();
}

function editConsignee009(button) {
    alert("hii");
    alert(button);
    // console.log(data-unique-id);
    // Read data attributes from the clicked button
    const uniqueId = button.getAttribute('data-unique-id');
    const address = button.getAttribute('data-address');
    const district = button.getAttribute('data-district');
    const zone = button.getAttribute('data-zone');
    const pincode = button.getAttribute('data-pincode');
    const contactName = button.getAttribute('data-contact-name');
    const contactNumber = button.getAttribute('data-contact-number');
    const landline = button.getAttribute('data-landline');
    const gst = button.getAttribute('data-gst');
    const status = button.getAttribute('data-status');

    // Assign values to form fields inside the modal
    document.getElementById('stored_consignee').value = uniqueId;
    document.getElementById('up_con_address').value = address;
    document.getElementById('up_con_district').value = district;
    document.getElementById('up_zone').value = zone;
    document.getElementById('up_con_pincode').value = pincode;
    document.getElementById('up_con_contact_name').value = contactName;
    document.getElementById('up_con_contact_number').value = contactNumber;
    document.getElementById('up_con_lan_num').value = landline;
    document.getElementById('up_consignee_gst').value = gst;
    document.getElementById('up_verify_sts').value = status;

    // Show the modal (Bootstrap 5)
    const modal = new bootstrap.Modal(document.getElementById('editConsigneeModal'));
    modal.show();
}


function editConsignee123(btn) {
    alert(btn);
    const $btn = $(btn);
    console.log('Data:', {
        id: $btn.data('unique-id'),
        address: $btn.data('address'),
        district: $btn.data('district'),
        zone: $btn.data('zone'),
        pincode: $btn.data('pincode'),
        contactName: $btn.data('contact-name'),
        contactNumber: $btn.data('contact-number'),
        landline: $btn.data('landline'),
        gst: $btn.data('gst'),
        status: $btn.data('status')
    });
alert($btn);
alert($btn.data('unique-id'));

    $('#stored_consignee').val($btn.data('unique-id'));
    $('#up_con_address').val($btn.data('address'));
    $('#up_con_district').val($btn.data('district'));
    $('#up_zone').val($btn.data('zone'));
    $('#up_con_pincode').val($btn.data('pincode'));
    $('#up_con_contact_name').val($btn.data('contact-name'));
    $('#up_con_contact_number').val($btn.data('contact-number'));
    $('#up_con_lan_num').val($btn.data('landline'));
    $('#up_consignee_gst').val($btn.data('gst'));
    $('#up_verify_sts').val($btn.data('status'));

    const myModal = new bootstrap.Modal(document.getElementById('editConsigneeModal'));
    myModal.show();
}

 
$(document).on('click', '.count-badge', function () {
    var batchId = $(this).data('batch-id');

    $.ajax({
        type: 'POST',
        url: 'folders/po_form/pavicrud.php', // Replace with your actual PHP endpoint
        data: {
            action: 'get_consignee_by_batch',
            batch_id: batchId
        },
        success: function (response) {
            $('#consigneeModalBody').html(response);
            $('#consigneeModal').modal('show');
        },
        error: function () {
            $('#consigneeModalBody').html('<div class="text-danger">Failed to fetch consignee details.</div>');
            $('#consigneeModal').modal('show');
        }
    });
});


   

// function insurence() {
//     // alert("Function called");
//     var checkbox = document.querySelector('#insurence_required');
//     var insuTypes = document.querySelector('#insu_types');

//     if (checkbox.checked) {
//         insuTypes.style.display = 'block';
//     } else {
//         insuTypes.style.display = 'none';
//          $('#others_insu_types').hide();
        
//     }
// }

// function ld_cal_validation() {
//     // alert("Function called");
//     var checkbox = document.querySelector('#ld_required');
//     var lds = document.querySelector('#ld_calculate');
//      var lds_1 = document.querySelector('#ld_calculate_1');
//       var lds_2 = document.querySelector('#ld_calculate_2');
    
    
// // ld_calculate

//     if (checkbox.checked) {
//         lds.style.display = 'block';
//         lds_1.style.display = 'block';
//         lds_2.style.display = 'block';
//     } else {
//         lds.style.display = 'none';
//         lds_1.style.display = 'none';
//         lds_2.style.display = 'none';
//     }
// }
// function get_check_po_batchs(val){
//     // get_assign_qty_record();
//     get_details(batch_id);
// }


function tax_type_chnge(){
    // alert("hii");
    var types = document.getElementById('tax_type').value;
    alert(types);
    if(types == 1){
        
        $('#price_1').show();
        $('#price_1_taxs').show();
        $('#price_1_tots').show();
         $('#price_2').hide();
          $('#price_2_tot_2').hide();
        
    }else if(types == 2){
        $('#price_1').hide();
        $('#price_1_taxs').hide();
        $('#price_1_tots').hide();
         $('#price_2').show();
         $('#price_2_tot_2').show();
        
    }else{
         $('#price_1').hide();
         $('#price_2').hide();
          $('#price_1_taxs').hide();
        $('#price_1_tots').hide();
        //  $('#price_2').show();
         $('#price_2_tot_2').hide();
    }
}
    $(document).ready(function () {
        // BGrequired();

        // $('#ld_type').on('change', function () {
        //     var selected = $(this).val();

        //     if (selected === 'day') {
        //         $('#ld_label_day').show();
        //          $('#ld_per_day').show();
        //         $('#ld_label_week').hide();
        //     } else if (selected === 'week') {
        //         $('#ld_label_day').hide();
        //         $('#ld_label_week').show();
        //         $('#ld_per_day').show();
        //     } else {
        //         $('#ld_label_day').hide();
        //         $('#ld_label_week').hide();
        //         $('#ld_per_day').hide();
        //     }
        // });

        // Optional: trigger change on page load if value is preset
        // $('#ld_type').trigger('change');
    });
    function branch_date_change(){
    
    var date_type = document.getElementById('branch_date_type').value;
    // alert(date_type);
    if(date_type == '1'){
        
        $('#dates').show();
    }else if(date_type == '2'){
         $('#dates').show();
    }else{
         $('#dates').hide();
    }
}
function branch_date_change_2(){
    
    var date_type = document.getElementById('branch_date_type_1').value;
    // alert(date_type);
    if(date_type == '1'){
        
        $('#dates_1').show();
    }else if(date_type == '2'){
         $('#dates_1').show();
    }else{
         $('#dates_1').hide();
    }
}
// function get_po_no(){
//     //   alert('hii');
//      document.getElementById('mypo').value = '';
//         var po_num = document.getElementById('po_num').value;
//         // alert(po_num);
//         document.getElementById('po_numbers').value = po_num;
        
        
//         // alert(po_num);
//         document.getElementById('mypo').value = po_num;
//         document.getElementById('po_code').value = po_num;
        
//     }
    
    function get_my_num(){
    
        var po_num = document.getElementById('po_num').value;
        // alert(po_num);
        document.getElementById('po_numbers').value = po_num;
        
      
        
    }
function handleEntryModeChange(selectedMode) {
    if (selectedMode === "entry") {
        $('#myrows').hide();
      $('#frst_ops').show();
      $('#frst_1_ops').show();
      $('#sec_ops').show();
      
    } else if (selectedMode === "import") {
       $('#myrows').show();
      $('#frst_ops').show();
      $('#frst_1_ops').show();
      $('#sec_ops').hide();
    }
  }

  $(document).ready(function () {
      
    // On load: check which radio is selected and show/hide sections
    const selectedMode = $('input[name="entry_mode"]:checked').val();
    handleEntryModeChange(selectedMode);

    // On radio change: listen and update UI accordingly
    $('input[name="entry_mode"]').on('change', function () {
      const mode = $(this).val();
    //   alert(mode);
      console.log("Selected Mode:", mode);
      handleEntryModeChange(mode);
    });
  });
$(document).ready(function() {
  
    sub_list_datatable_consignee("consignee_details_datatable");
        // sub_list_datatable("po_delivery_datatable");
   
});




//  $("#import_con").click(function (e) {
//       e.preventDefault();
//     var form_main_unique_id = $("#demo").val();
//     var fileInput = document.getElementById('files');
//     var batch_id = $("#modal_batch_id").val();
//     var po_number = $("#po_numbers").val();


//     var data = new FormData();

//     // if (fileInput.files.length > 0) {
//     //      var image_s = document.getElementById("files");
//     //     //  alert(image_s);
//     // if (image_s != '') {
//     //     for (var i = 0; i < image_s.files.length; i++) {
//     //         data.append("file", document.getElementById('files').files[i]);
//     //     }
//     // } else {
//     //     data.append("file", '');
//     // }
//     if (fileInput.files.length > 0) {
//         data.append("file", fileInput.files[0]); // append only one file
//     } else {
//         alert("Please select an Excel file to upload.");
//         return;
//     }
//   document.getElementById('batch_record').value = '';

//     data.append("form_main_unique_id", form_main_unique_id);
//     data.append("batch_id", batch_id);
//     data.append("po_number", po_number);

//     $.ajax({
//         type: "POST",
//         url: 'folders/po_form/con_assign_import.php',
//         data: data,
//         cache: false,
//         contentType: false,
//         processData: false,
//         success: function (res) {
//             // Try to extract only the first valid JSON object
//             var data = JSON.parse(res);
//             // alert(data.status);
//         if (data.status === "success") {
//             alert("Imported Successfully");
//             window.location.reload();
//             document.getElementById('batch_record').value = batch_id;
//             import_close();
//             get_details(batch_id);

//             var element = document.getElementById("finals");
//             element.classList.remove("js-btn-next");
//         }
            

           
//         },
       
//     });
// });


// // new chnges 12-04-2025
// $("#import_con").click(function (e) {
//     e.preventDefault();

//     var form_main_unique_id = $("#demo").val();
//     var fileInput = document.getElementById('files');
//     var batch_id = $("#modal_batch_id").val();
//     var po_number = $("#po_numbers").val();

//     // Validate that a file is selected
//     if (fileInput.files.length === 0) {
//         alert("Please select an Excel file to upload.");
//         return;
//     }

//     // Prepare FormData for sending
//     var data = new FormData();
//     data.append("file", fileInput.files[0]);
//     data.append("form_main_unique_id", form_main_unique_id);
//     data.append("batch_id", batch_id);
//     data.append("po_number", po_number);

//     $.ajax({
//         type: "POST",
//         url: 'folders/po_form/con_assign_import.php',  // Path to your PHP script
//         data: data,
//         cache: false,
//         contentType: false,
//         processData: false,
//         success: function (res) {
//             try {
//                 // Parse the response from PHP
//                 var data = JSON.parse(res);
                
//                 // Check if the status is error
//                 if (data.status === "error") {
//                     // Display the error message from PHP
//                     alert(data.message);  // Show the message in an alert
//                 } else if (data.status === "success") {
//                     // If import is successful
//                     alert("Imported Successfully");
//                     window.location.reload();  // Reload the page after success
//                     document.getElementById('batch_record').value = batch_id;
//                     import_close();
//                     get_details(batch_id);

//                     var element = document.getElementById("finals");
//                     element.classList.remove("js-btn-next");
//                 }
//             } catch (e) {
//                 console.error("Failed to parse JSON:", e);
//                 alert("Something went wrong while processing the data.");
//             }
//         },
//         error: function (xhr, status, error) {
//             // Handle AJAX error
//             console.error("AJAX error:", error);
//             alert("An error occurred during the import. Please try again.");
//         }
//     });
// });
// new changes 12-04-2025
$("#import_con").click(function (e) {
    e.preventDefault(); // Prevent default form submission behavior

    // Get the values from the form fields
    var form_main_unique_id = $("#demo").val(); // Get the form main unique ID
    var fileInput = document.getElementById('files'); // Get the file input element
    var batch_id = $("#modal_batch_id").val(); // Get the batch ID
    var po_number = $("#po_numbers").val(); // Get the PO number

    // Validate that a file is selected
    if (fileInput.files.length === 0) {
        alert("Please select an Excel file to upload.");
        return; // Exit the function if no file is selected
    }

    // Prepare FormData to send the data along with the file
    var data = new FormData();
    data.append("file", fileInput.files[0]); // Append the selected file
    data.append("form_main_unique_id", form_main_unique_id); // Append form unique ID
    data.append("batch_id", batch_id); // Append batch ID
    data.append("po_number", po_number); // Append PO number

    // Perform the AJAX request
    $.ajax({
        type: "POST",  // Set the request type to POST
        url: 'folders/po_form/con_assign_import.php',  // PHP script URL to handle the file upload
        data: data,  // Data to send in the request
        cache: false,  // Disable caching
        contentType: false,  // Prevent jQuery from setting content type
        processData: false,  // Prevent jQuery from processing the data
        success: function (res) {
            try {
                // Parse the JSON response from the PHP script
                var response = JSON.parse(res);

                // Check if the response indicates an error
                if (response.status === "error") {
                    alert(response.message);  // Show the error message in an alert
                } else if (response.status === "success") {
                    // If import is successful
                    alert("Import Successful");
                    // window.location.reload();  // Reload the page after success
                    document.getElementById('batch_record').value = batch_id; // Update the batch record field
                    import_close(); // Close the import modal or dialog
                    get_details(batch_id); // Call another function to fetch details for the batch
                    sub_list_datatable_consignee("consignee_details_datatable");
                    

                    // Update the UI, remove "js-btn-next" class from the "finals" element
                    // var element = document.getElementById("finals");
                    // element.classList.remove("js-btn-next");
                }
            } 
            catch (e) {
                // Handle any parsing errors or unexpected issues
                console.error("Failed to parse JSON:", e);
                alert("Something went wrong while processing the data.");
            }
        },
        error: function (xhr, status, error) {
            // Handle AJAX error if the request fails
            console.error("AJAX error:", error);
            alert("An error occurred during the import. Please try again.");
        }
    });
});




 $("#import_con_test").click(function (e) {
    e.preventDefault();

    var form_main_unique_id = $("#demo").val();
    var fileInput = document.getElementById('files');
    var batch_id = $("#modal_batch_id").val();
    var po_number = $("#po_numbers").val();

    var data = new FormData();

    // Validate if a file is selected
    if (fileInput.files.length > 0) {
        data.append("file", fileInput.files[0]); // append only one file
    } else {
        alert("Please select an Excel file to upload.");
        return;
    }

    // Clear batch_record field
    $("#batch_record").val('');

    // Append form fields
    data.append("form_main_unique_id", form_main_unique_id);
    data.append("batch_id", batch_id);
    data.append("po_number", po_number);

    $.ajax({
        type: "POST",
        url: 'folders/po_form/con_assign_import.php',
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        success: function (res) {
            // try {
            // alert("hello");
            // alert(res);
                var data = JSON.parse(res);
// alert(data.message);
                if (data.status === "success") {
                    alert("Imported Successfully");
                    alert(batch_id);
                    $("#batch_record").val(batch_id);
                    
                    import_close();
                    get_details(batch_id);

                    // Remove next button blocker class if needed
                    $("#finals").removeClass("js-btn-next");

                } else {
                    alert(data.message); // show error from PHP
                }
            // } catch (err) {
            //     alert("Unexpected error: " + res);
            //     console.error(res);
            // }
        },
        error: function (xhr, status, error) {
            alert("Upload failed: " + error);
            console.error(xhr.responseText);
        }
    });
});
function get_details_pavi(batch_id) {
    var unique_id = document.getElementById('demo').value;
    $('#loader').show();

    var data = "unique_id=" + unique_id + "&batch_ids=" + batch_id + "&action=get_assign_qty_record";

    $.ajax({
        type: "POST",
        url: 'folders/po_form/pavicrud.php',
        data: data,
        success: function (response) {
            $('#loader').hide();
            var obj = JSON.parse(response);

            if (obj.status) {
                $('#mytable').html(obj.html);  // Load returned HTML
            } else {
                $('#mytable').html('<div class="text-danger">' + obj.message + '</div>');
            }
        },
        error: function () {
            $('#loader').hide();
            $('#mytable').html('<div class="text-danger">Something went wrong while fetching data.</div>');
        }
    });
}

    function get_details(batch_id) {
        // alert("working");
// alert(batch_id);
        var unique_id = document.getElementById('demo').value;
        // var batch_ids = document.getElementById('batch_code').value;
        // var batch_ids = '';
        // alert(batch_ids);
        $('#loader').show();
        data = "unique_id=" + unique_id + "&batch_ids="+ batch_id +"&action=get_assign_qty_record";
        // var ajax_url = sessionStorage.getItem("folder_crud_link");
        $.ajax({
            type: "POST",
            url: 'folders/po_form/pavicrud.php',
            data: data,

            success: function (data) {
                $('#loader').hide();
                var obj = JSON.parse(data);
                var msg = obj.msg;
                var data = obj.data;
                $('#mytable').html(data);

            }
        });
    }
 // import function start
    function excel_popup() {
        // alert();
        $("#consignee_excel_import").modal("show");
        // event.preventDefault();
    }

    function modal_close() {
        $("#consignee_excel_import").modal("hide");
    }
    function sub_list_datatable_consignee(table_id = "", form_name = "", action = "") {
    var form_main_unique_id = $("#demo").val();
    var table = $("#" + table_id);
    var ajax_url = 'folders/po_form/pavicrud.php';

    if (table_id === 'consignee_details_datatable') {
        var datatable = table.DataTable({
            destroy: true,
            ordering: true,
            searching: true,
            paging: true,
            pageLength: 10,
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
            info: true,
            ajax: {
                url: ajax_url,
                type: "POST",
                data: {
                    action: table_id,
                    form_main_unique_id: form_main_unique_id
                }
            },
            
        });
    }
}
$(document).on('click', '.delete-consignee', function () {
    if (!confirm('Are you sure you want to delete this consignee?')) return;

    const $btn = $(this);
    const uniqueId = $btn.data('unique-id');

    $.ajax({
        type: 'POST',
        url: 'folders/po_form/pavicrud.php',
        data: {
            action: 'delete_consignee',
            unique_id: uniqueId
        },
        success: function (res) {
            if (res === 'success') {
                $btn.closest('tr').remove(); // remove row from UI
            } else {
                alert('Delete failed!');
            }
        },
        error: function () {
            alert('Error deleting record.');
        }
    });
});

    function excel_export(batch_id) {
        // alert(batch_id);
    var ajax_url = sessionStorage.getItem("folder_crud_link");

    if (batch_id) {
        $.ajax({
            type: "POST",
            url: 'folders/po_form/pavicrud.php',
            data: {
                batch_id: batch_id,
                action:"get_consignee_product_details"
            },
            success: function (res) {
                var details = JSON.parse(res);

                if (details.data && details.data.length > 0) {
                    let exportData = details.data.map((item, index) => {
                        return {
                            "Consignee Name": item.con_contact_name,
                            "Consignee Contact": item.con_contact_number,
                            "Consignee Address": item.con_address,
                            "Batch No":item.batch_no,
                            "Po Number":item.po_number,
                             "Item Code": item.item_code,
                            "Item Name": item.product_name,
                            "Qty": item.qty,
                            "con_unique_id":item.con_unique_id,
                            "product_unique_id":item.product_unique_id,
                             "unit_price":item.unit_price,
                         };
                        // "Consignee Landline": item.con_lan_num,
                            // "Consignee Address": item.con_address,
                            // "Zone": item.zone,
                    });

                    var worksheet = XLSX.utils.json_to_sheet(exportData);
                    var workbook = XLSX.utils.book_new();
                    XLSX.utils.book_append_sheet(workbook, worksheet, "Consignee Details");
                    XLSX.writeFile(workbook, "consignee_product_details_" + batch_id + ".xlsx");
                } else {
                    alert("No data found to export.");
                }
            }
        });
    } else {
        alert("Batch ID is missing!");
    }
}
$("#con_import_data").click(function () {
    var form_main_unique_id = $("#demo").val();
    var file = document.getElementById('file').value;
    var no_of_consignee = document.getElementById('no_of_consignee').value;
    var cons_verfiy_sts = document.getElementById('cons_verfiy_sts').value;
    var batch_id = $("#batch_id").val(); // ✅ Batch ID input
    var consignee_received_date = $("#consignee_received_date").val();
    var po_number = $("#po_numbers").val();// ✅ Date input

    var data = new FormData();

    var image_s = document.getElementById("file");
    if (image_s != '') {
        for (var i = 0; i < image_s.files.length; i++) {
            data.append("file", image_s.files[i]);
        }
    } else {
        data.append("file", '');
    }

    // Append all required data
    data.append("form_main_unique_id", form_main_unique_id);
    data.append("no_of_consignee", no_of_consignee);
    data.append("cons_verfiy_sts", cons_verfiy_sts);
    data.append("batch_id", batch_id); // ✅ Added
    data.append("consignee_received_date", consignee_received_date);
    data.append("po_number", po_number);// ✅ Added

    console.log([...data]); 

    $.ajax({
        type: "POST",
        url: 'folders/po_form/con_import.php',
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        success: function (res) {
            console.log(res);
            modal_close();
            sub_list_datatable_consignee("consignee_details_datatable");
        },
        error: function (xhr, status, error) {
            console.error(error); // Fixed typo from "consloe"
        }
    });
});

function consigneevalidateGST(input) {
   
    let congstError = document.getElementById("con_gst_error");
    

    // Convert input to uppercase
    input.value = input.value.toUpperCase();

    // Allow only numbers and uppercase letters
    input.value = input.value.replace(/[^0-9A-Z]/g, '');

    // GST number regex pattern
    let gstRegex = /^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}[Z]{1}[0-9A-Z]{1}$/;

    if (input.value.length === 15 && gstRegex.test(input.value)) {
        congstError.style.display = "none"; // Hide error if valid
        $('#mybtns').show();
        
    } else {
        congstError.style.display = "block"; // Show error if invalid
         
    }
}

function consignee_details_add_update_16_04_2025(unique_id = "") { // au = add,update

        var internet_status = is_online();

        var is_form = form_validity_check("consignee_details_form");
       
        var no_of_consignee = document.getElementById('no_of_consignee').value;
        
        var batch_id = document.getElementById('batch_id').value;
        var consignee_received_date = document.getElementById('consignee_received_date').value;
       
        var con_address = document.getElementById('con_address').value;
        var con_district = document.getElementById('con_district').value;
        
          var po_numbers = document.getElementById('po_numbers').value;

        // alert(con_district);

        var con_pincode = document.getElementById('con_pincode').value;
        var con_contact_name = document.getElementById('con_contact_name').value;
        var con_contact_number = document.getElementById('con_contact_number').value;
        var con_lan_num = document.getElementById('con_lan_num').value;
        var consignee_gst = document.getElementById('consignee_gst').value;
        var form_main_unique_id = document.getElementById('demo').value;
        var zone = document.getElementById('zone').value;
        
        var cons_verify_sts = document.getElementById('verify_sts').value;

       
        var data = "no_of_consignee=" + no_of_consignee + "&consignee_gst=" + consignee_gst +"&con_address=" + con_address +
            "&con_district=" + con_district + "&batch_id="+batch_id+"&consignee_received_date="+ consignee_received_date +"            &con_pincode=" + con_pincode + "&con_contact_name=" + con_contact_name + "&con_contact_number=" +
            con_contact_number + "&con_lan_num=" + con_lan_num + "&form_main_unique_id=" +
            form_main_unique_id + "&zone=" + zone +"&cons_verify_sts=" + cons_verify_sts +"&po_numbers="+ po_numbers;
        data += "&unique_id=" + unique_id + "&action=consignee_details_add_update";

        var ajax_url = 'folders/po_form/pavicrud.php';
        // var url      = sessionStorage.getItem("list_link");
        var url = "";
if(con_address && con_district !== ''){
        // console.log(data);
        $.ajax({
            type: "POST",
            url: ajax_url,
            data: data,
            beforeSend: function () {
                $(".consignee_details_add_update_btn").attr("disabled", "disabled");
                $(".consignee_details_add_update_btn").text("Loading...");
            },
            success: function (data) {

                var obj = JSON.parse(data);
                var msg = obj.msg;
                var status = obj.status;
                var error = obj.error;

                if (!status) {
                    $(".consignee_details_add_update_btn").text("Error");
                    // console.log(error);
                } else {
                    if (msg == "e_already") {
                        // sweetalert(msg, url);
                        form_reset("consignee_details_form");
                    }
                    // if (msg == "e_already") {
                        sweetalert(msg);
                        //  window.location.reload();
                         
                    sub_list_datatable_consignee("consignee_details_datatable");
                    get_stored_sublist_count();
                    // }
                    $(".consignee_details_add_update_btn").removeAttr("disabled", "disabled");
                    if (unique_id && msg == "already") {
                        $(".consignee_details_add_update_btn").text("Update");
                    } else {
                        $(".consignee_details_add_update_btn").text("Add");
                        $(".consignee_details_add_update_btn").attr("onclick",
                            "consignee_details_add_update('')");
                    }
                    // Init Datatable
                   
                    
                    document.getElementById('con_district').value = 'your_district_value';
                    document.getElementById('con_district').value = '';

                    // document.getElementById('con_district').selectedIndex = -1;

                    document.getElementById('con_address').value = '';
                    // document.getElementById('con_district').value = '';
                    document.getElementById('con_pincode').value = '';
                    document.getElementById('con_contact_name').value = '';
                    document.getElementById('con_contact_number').value = '';
                    document.getElementById('con_lan_num').value = '';
                    document.getElementById('consignee_gst').value = '';
                    
                    
                }
                sweetalert(msg, url);
            },
            error: function (data) {
                alert("Network Error");
            }
        });
}else{
    alert("To Fill Consignee Address Details first");
}
       
    }
    
    
    
    // amc Datatable
   function amcsub_list_datatable_add_update(unique_id = "") {
    // Optional alert for debugging
    // alert("Function triggered");

    var internet_status = is_online(); // Assuming you have this function already

    // Get form values
    var start_date = document.getElementById('start_date').value;
    var end_date = document.getElementById('end_date').value;
    var amc_percentae = document.getElementById('amc_percentae').value;
    var amcvalue = document.getElementById('amcvalue').value;
    var amc_required = document.getElementById('amc_required').value;
    var po_form_unique_id = document.getElementById('po_form_unique_id').value;
    
    
       var po_no = document.getElementById('mypo').value;
    //   alert(po_no);
   
       
    // var batch_id = document.getElementById('batch_id').value;
     var batch_id = '';
// alert(batch_id);
    // For debugging
    // alert("Batch ID: " + batch_id);
    
    // Create FormData object
    var data = new FormData();


      var amcpofile = document.getElementById("amcpofile");
        var image_s = document.getElementById("po_file");
         
      
         if (amcpofile != '') {
            for (var i = 0; i < amcpofile.files.length; i++) {
                data.append("amcpofile", document.getElementById('amcpofile').files[i]);
               

            }
        } else {
            data.append("amcpofile", '');
        }
        

//   var data = new FormData();
          if (image_s != '') {
            for (var i = 0; i < image_s.files.length; i++) {
                data.append("po_file", document.getElementById('po_file').files[i]);

            }
        } else {
            data.append("po_file", '');
        }

    data.append("start_date", start_date);
      data.append("po_no", po_no);
    data.append("end_date", end_date);
    data.append("amc_percentae", amc_percentae);
    data.append("amcvalue", amcvalue);
    data.append("po_form_unique_id", po_form_unique_id);
    data.append("batch_id", batch_id);
    data.append("action", "amc_add_update");

    var ajax_url = 'folders/po_form/pavicrud.php';

    $.ajax({
        type: "POST",
        url: ajax_url,
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function () {
            $(".amcsub_list_datatable_add_update_btn").attr("disabled", true).text("Saving...");
        },
        success: function (response) {
            var obj = JSON.parse(response);
            var msg = obj.msg;
            var status = obj.status;
            var error = obj.error;
            var url = "";

            if (!status) {
                console.error("Error:", error);
                $(".amcsub_list_datatable_add_update_btn").text("Error").removeAttr("disabled");
            } else {
                if (msg === "already") {
                    $(".amcsub_list_datatable_add_update_btn").text("Save").removeAttr("disabled");
                } else {
                    $(".amcsub_list_datatable_add_update_btn").text("Saved").removeAttr("disabled");
                }
            }

            sweetalert(msg, url); // Show success or error alert
            //  $('#amc_datatable').DataTable().ajax.reload(null, false); 
            amcsub_list_datatable("amc_table_datatable");
        },
        error: function () {
            alert("Network Error");
            $(".amcsub_list_datatable_add_update_btn").text("Save").removeAttr("disabled");
        }
    });
}

    function amcsub_list_datatable(table_id = "", form_name = "", action = "") {
        // alert();
    var form_main_unique_id = $("#demo").val();
    var table = $("#" + table_id);
// alert(table_id);
    var data = {
        "form_main_unique_id": form_main_unique_id,
        "action": table_id,
    };
    var ajax_url = sessionStorage.getItem("folder_crud_link");

    if ($.fn.DataTable.isDataTable(table)) {
        // ✅ Destroy existing DataTable before reinitializing
        table.DataTable().destroy();
    }

    // ✅ Reinitialize DataTable without pagination and ordering
    table.DataTable({
        processing: true,
        serverSide: true,
        paging: false,   
        ordering: false,
        searching: false,
        info: false,     
        ajax: {
            url: ajax_url,
            type: "POST",
            data: data
        }
    });
}