
$(document).ready(function() {
   
    // insurence();
    // ld_cal_validation();
    get_po_no();
    get_my_num();
    valueChangedamc();
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
            <div class="table-responsive">
                <table id="exportableTable" class="table table-bordered table-sm table-hover mb-0">
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

        html += `</tbody></table></div>`;

        $('#itemDetailsModalLabel').text(`Item Details for ${consigneeaddress}`);
        $('#item-details-body').html(html);

        // Initialize DataTable with export buttons
       $('#exportableTable').DataTable({
    paging: false,          // Disable pagination
    searching: false,       // Disable search box
    info: false,            // Disable table info text
    ordering: false,        // Optional: disable column sorting
    dom: 'Bfrtip',          // Positioning of buttons
    buttons: [
        {
            extend: 'excelHtml5',
            title: 'Item Details',
            text: 'Excel'
        },
        {
            extend: 'pdfHtml5',
            title: 'Item Details',
            orientation: 'landscape',
            pageSize: 'A4',
            text: 'PDF'
        }
    ]
});

        const modal = new bootstrap.Modal(document.getElementById('itemDetailsModal'));
        modal.show();
    } else {
        $('#item-details-body').html(`<p class="text-danger text-center">No item data found for ${consigneeaddress}</p>`);
        const modal = new bootstrap.Modal(document.getElementById('itemDetailsModal'));
        modal.show();
    }
},
        error: function () {
            Swal.fire("Error", "Unable to load item-wise details.", "error");
        }
    });
});



// $(document).on('click', '.order-qty-click', function () {
    
//     const consigneeName = $(this).data('consignee-name');
   
//     const batchId = $(this).data('batch-id');

//     // AJAX to fetch item-wise data
//     $.ajax({
//         url: 'folders/po_form/get_itemwise_consignee_details.php',
//         type: 'POST',
//         dataType: 'json',
//         data: {
//             batch_id: batchId,
//             con_name: consigneeName
//         },
//         success: function (res) {
//             if (res.status === 'success' && Array.isArray(res.data) && res.data.length > 0) {
//                 let html = `
//                     <table class="table table-bordered table-sm table-hover mb-0">
//                         <thead style="background-color:#6610f2; color:white;">
//                             <tr>
//                                 <th>S.No</th>
//                                 <th>Item Code</th>
//                                 <th>Product</th>
//                                 <th>Order Qty</th>
//                                 <th>Assign Qty</th>
//                             </tr>
//                         </thead>
//                         <tbody>`;

//                 res.data.forEach((item, idx) => {
//                     html += `
//                         <tr>
//                             <td>${idx + 1}</td>
//                             <td>${item.item_code}</td>
//                             <td>${item.product}</td>
//                             <td>${item.qty}</td>
//                             <td>${item.assign_qty}</td>
//                         </tr>`;
//                 });

//                 html += `</tbody></table>`;

//                 $('#itemDetailsModalLabel').text(`Item Details for ${consigneeName}`);
//                 $('#item-details-body').html(html);
//                 const modal = new bootstrap.Modal(document.getElementById('itemDetailsModal'));
//                 modal.show();
//             } else {
//                 $('#item-details-body').html(`<p class="text-danger text-center">No item data found for ${consigneeName}</p>`);
//                 const modal = new bootstrap.Modal(document.getElementById('itemDetailsModal'));
//                 modal.show();
//             }
//         },
//         error: function () {
//             Swal.fire("Error", "Unable to load item-wise details.", "error");
//         }
//     });
// });

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

function editConsignee(btn) {
    // alert(btn);
    const $btn = $(btn);

    $('#five-ops').show();

    $('#con_address').val($btn.data('address'));
    $('#con_district').val($btn.data('district'));
    $('#zone').val($btn.data('zone'));
    $('#con_pincode').val($btn.data('pincode'));
    $('#con_contact_name').val($btn.data('contact-name'));
    $('#con_contact_number').val($btn.data('contact-number'));
    $('#con_lan_num').val($btn.data('landline'));
    $('#consignee_gst').val($btn.data('gst'));
    $('#verify_sts').val($btn.data('status'));
    $('#stored_consignee').val($btn.data('unique-id'));

    $('#mybtns').text('Update').show();
}
 
$(document).on('click', '.count-badge', function () {
    var batchId = $(this).data('batch-id');
    $('#batch_id_holder').val(batchId);
    $.ajax({
        type: 'POST',
        url: 'folders/po_form/crud.php', // Replace with your actual PHP endpoint
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

function change_verify_address(){
    // alert("hii");

    const formData = {
        action: 'update_consignee',
        unique_id: $('#up_stored_consignee').val(),
        con_address: $('#up_con_address').val(),
        con_district: $('#up_con_district').val(),
        con_state_name: $('#up_con_state_name').val(),
        zone: $('#up_zone').val(),
        con_pincode: $('#up_con_pincode').val(),
        con_contact_name: $('#up_con_contact_name').val(),
        con_contact_number: $('#up_con_contact_number').val(),
        con_lan_num: $('#up_con_lan_num').val(),
        consignee_gst: $('#up_consignee_gst').val(),
        up_assign_team_member : $('#up_assign_team_member').val(),
        verify_sts: $('#up_verify_sts').val(),
        form_main_unique_id: $('#form_main_unique_id').val()
    };
    $.ajax({
        url: 'folders/po_form/crud.php',
        type: 'POST',
        data: formData,
        dataType: 'json',
        success: function (res) {
            if (res.msg === 'already') {
                sweetalert(res.msg);
                return;
            }
    
            if (res.status && res.msg === 'success_update') {
                alert('Updated Successfully');
    
                // Hide the edit modal
                $('#editConsigneeModal').modal('hide');
                // $('#batch_id_holder').val(batchId);
                // Get the batch ID from formData or store it beforehand
                // var batchId = formData.batch_id_holder; // <-- Ensure this is part of `formData`
                var batchId = document.getElementById('batch_id_holder').value;
    // alert(batchId);
                // Fetch updated consignee data and show the modal
                $.ajax({
                    url: 'folders/po_form/crud.php',
                    type: 'POST',
                    data: {
                        action: 'get_consignee_by_batch',
                        batch_id: batchId
                    },
                    success: function (response) {
                        $('#consigneeModalBody').html(response);
                        $('#consigneeModal').modal('show');
    
                        // Reinitialize DataTable if needed
                        sub_list_datatable_consignee("consignee_details_datatable");
                    },
                    error: function () {
                        $('#consigneeModalBody').html('<div class="text-danger">Failed to fetch consignee details.</div>');
                        $('#consigneeModal').modal('show');
                    }
                });
    
            } else if (res.msg === 'error') {
                alert('Update failed: ' + res.error);
            } else {
                alert('Unexpected response: ' + JSON.stringify(res));
            }
        },
        error: function (xhr, status, error) {
            alert('AJAX request failed: ' + error);
        }
    });
    
    // $.ajax({
    //     url: 'folders/po_form/crud.php',
    //     type: 'POST',
    //     data: formData,
    //     dataType: 'json',
    //     success: function (res) {

            
    //         if(res.msg == 'already'){
    //             sweetalert(res.msg);
    //         }else{
    //         // if (res.status && res.msg === 'success_update') {
    //         //     alert('Updated Successfully');
    //         //     // window.location.reload();
    //         //     $('#editConsigneeModal').modal('hide');
    //         //      $('#consigneeModal').modal('show');

    //         //     sub_list_datatable_consignee("consignee_details_datatable");
    //         //     // location.reload(); // Refresh to show updated data
    //         // } else if (res.msg === 'error') {
    //         //     alert('Update failed: ' + res.error);
    //         // } else {
    //         //     alert('Unexpected response: ' + JSON.stringify(res));
    //         // }
    //         if (res.status && res.msg === 'success_update') {
    //             alert('Updated Successfully');
            
    //             $('#editConsigneeModal').modal('hide');
            



    //             var batchId = $(this).data('batch-id');

    //             // $.ajax({
    //             //     type: 'POST',
    //             //     url: 'folders/po_form/crud.php', // Replace with your actual PHP endpoint
    //             //     data: {
    //             //         action: 'get_consignee_by_batch',
    //             //         batch_id: batchId
    //             //     },
    //             //     success: function (response) {
    //             //         $('#consigneeModalBody').html(response);
    //             //         $('#consigneeModal').modal('show');
    //             //     },
    //             //     error: function () {
    //             //         $('#consigneeModalBody').html('<div class="text-danger">Failed to fetch consignee details.</div>');
    //             //         $('#consigneeModal').modal('show');
    //             //     }
    //             // });
    //             // Reload modal content before showing
    //             $.ajax({
    //                 url: 'folders/po_form/crud.php',

    //                 type: 'POST',
    //                 data: {
    //                     action: 'get_consignee_by_batch',
    //                     batch_id: batchId
    //                 },
    //                 success: function (html) {
    //                     $('#consigneeModal .modal-content').html(html); // replace modal content
    //                     $('#consigneeModal').modal('show');
            
    //                     // Optionally, reinitialize anything (like DataTables)
    //                     sub_list_datatable_consignee("consignee_details_datatable");
    //                 },
    //                 error: function () {
    //                     alert('Failed to load updated modal content.');
    //                 }
    //             });
            
    //         } else if (res.msg === 'error') {
    //             alert('Update failed: ' + res.error);
    //         } else {
    //             alert('Unexpected response: ' + JSON.stringify(res));
    //         }
            
    //     }
    //     },
    //     error: function (xhr, status, error) {
    //         alert('AJAX error: ' + error);
    //     }
    // });
// });
}
  // slight delay if needed after injecting HTML

  
// function editConsignee_over(button) {

//     //  alert('r');
//     // Retrieve data attributes using button.dataset
//     const data = button.dataset;

//     // Log the data to verify it's correctly populated
//     // console.log(data);  // This should show the dataset (e.g., uniqueid, address, etc.)

//     // Pass the unique ID and other data to form fields or use as needed
//     document.getElementById('up_stored_consignee').value = data.uniqueid;
//     document.getElementById('up_con_address').value = data.address;
//     document.getElementById('up_con_district').value = data.district;
// var district_id = data.district_id;
//     document.getElementById('up_zone').value = data.zone;

//     // var assign_team_member_id = document.getElementById('assign_team_member_id').value = data.assign_team_member_id;
//     document.getElementById('up_con_state_name').value = data.con_state_name;
//     var con_state_id = data.con_state_id;
//     document.getElementById('up_con_state_id').value = data.con_state_id;
//     document.getElementById('up_con_district_id').value = data.district_id;
//     // alert(con_state_id);
//     var assign_team_member_id = data.team_member_id;
//     document.getElementById('up_assign_team_member').value = data.team_member;
    
//     document.getElementById('up_con_pincode').value = data.pincode;
//     document.getElementById('up_con_contact_name').value = data.contactname;
//     document.getElementById('up_con_contact_number').value = data.contactnumber;
//     document.getElementById('up_con_lan_num').value = data.landline;
//     document.getElementById('up_consignee_gst').value = data.gst;
//     //  document.getElementById('up_verify_sts').value = data.status;
   
//     get_state_options(con_state_id);
//      get_district_options(district_id);
//      get_assign_team_member(assign_team_member_id);

//     // Compare correctly using ===
//     let status1 = '';
//     const selectBox = document.getElementById("up_verify_sts");
// selectBox.innerHTML = ""; // Clear existing options

// if (data.status === "1") {
//     // Only show "Verified"
//     const option = document.createElement("option");
//     option.value = "1";
//     option.text = "Verified";
//     option.selected = true;
//     selectBox.appendChild(option);
// } else if (data.status === "2") {
//     // Show both options, with "Not Verified" selected
//     const option1 = document.createElement("option");
//     option1.value = "1";
//     option1.text = "Verified";
    
//     const option2 = document.createElement("option");
//     option2.value = "2";
//     option2.text = "Not Verified";
//     option2.selected = true;
    
//     selectBox.appendChild(option1);
//     selectBox.appendChild(option2);
// }

//     // document.getElementById('up_verify_sts').value = data.status1;

//     // Optionally, you can log the unique ID specifically
//     // console.log("Unique ID: " + data.uniqueid);

//     // Show Bootstrap 5 modal
//     const modal = new bootstrap.Modal(document.getElementById('editConsigneeModal'));
//     modal.show();
//     update_val();
// }


function get_state_options(con_state_id){
    


	
	var data = "state_name=" + con_state_id + "&action=con_state_name_option";
	
	var ajax_url = sessionStorage.getItem("folder_crud_link");
	
	$.ajax({
		type: "POST",
		url: ajax_url,
		data: data,
		success: function (data) {
			if (data) {
				$("#up_con_state_name").html(data);
			}
		}
	});
	
	}

function get_district_options(district_id){
    


	
	var data = "district_name=" + district_id + "&action=district_name_option";
	
	var ajax_url = sessionStorage.getItem("folder_crud_link");
	
	$.ajax({
		type: "POST",
		url: ajax_url,
		data: data,
		success: function (data) {
			if (data) {
				$("#up_con_district").html(data);
			}
		}
	});
	
	}

    function get_assign_team_member(assign_team_member_id){
    


	
        var data = "assign_team_member_id=" + assign_team_member_id + "&action=assign_team_member_id_option";
        
        var ajax_url = sessionStorage.getItem("folder_crud_link");
        
        $.ajax({
            type: "POST",
            url: ajax_url,
            data: data,
            success: function (data) {
                if (data) {
                    $("#up_assign_team_member").html(data);
                }
            }
        });
        
        }




   

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
    // alert(types);
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


// new changes 12-04-2025
$("#import_con").click(function (e) {
    // alert('ji');
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
                    // alert(batch_id);
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
        url: 'folders/po_form/crud.php',
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
function get_loading(){
    // alert("hiii");
    $('#loader13').show();
    $('#myloaders').show();
}

    function get_details(batch_id) {
        // alert(batch_id);
        var unique_id = document.getElementById('demo').value;
       
       
        data = "unique_id=" + unique_id + "&batch_ids="+ batch_id +"&action=get_assign_qty_record";
       
        $.ajax({
            type: "POST",
            url: 'folders/po_form/crud.php',
            data: data,

            success: function (data) {
                 $('#loader13').hide();
                 $('#myloaders').hide();
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
    var ajax_url = 'folders/po_form/crud.php';

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
        url: 'folders/po_form/crud.php',
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
            url: 'folders/po_form/crud.php',
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
// $("#con_import_data").click(function () {
//     let form_main_unique_id = $("#demo").val();
//     let no_of_consignee = $("#no_of_consignee").val();
//     let cons_verfiy_sts = $("#cons_verfiy_sts").val();
//     let batch_id = $("#batch_id").val();
//     let consignee_received_date = $("#consignee_received_date").val();
//     let po_number = $("#po_numbers").val();
//     let fileInput = $("#file")[0];

//     if (!fileInput.files.length) {
//         alert("Please select an Excel file to upload.");
//         return;
//     }

//     let data = new FormData();
//     data.append("file", fileInput.files[0]);
//     data.append("form_main_unique_id", form_main_unique_id);
//     data.append("no_of_consignee", no_of_consignee);
//     data.append("cons_verfiy_sts", cons_verfiy_sts);
//     data.append("batch_id", batch_id);
//     data.append("consignee_received_date", consignee_received_date);
//     data.append("po_number", po_number);

//     $.ajax({
//         type: "POST",
//         url: 'folders/po_form/con_import_test.php',
//         data: data,
//         cache: false,
//         contentType: false,
//         processData: false,
//         success: function (res) {
//             try {
//                 let response = JSON.parse(res);

//                 if (response.status === "error") {
//                     // Check if missing staff IDs exist in the response
//                     if (response.message.includes("Missing Staff IDs")) {
//                         let missingStaffIds = response.message.match(/Missing Staff IDs: ([\d, ]+)/);
//                         if (missingStaffIds && missingStaffIds[1]) {
//                             // Display missing staff IDs in a user-friendly way
//                             alert("The following Staff IDs were not found: " + missingStaffIds[1]);
//                         }
//                     }
//                     alert(response.message);
//                 } else if (response.status === "success") {
//                     alert(response.message);
//                     modal_close();
//                     sub_list_datatable_consignee("consignee_details_datatable");
//                 } else {
//                     alert("Unexpected response.");
//                 }
//             } catch (e) {
//                 console.error("Invalid JSON response", e);
//                 alert("Error processing response from server.");
//             }
//         },
//         error: function (xhr, status, error) {
//             console.error("AJAX Error:", error);
//             alert("An error occurred while uploading the file.");
//         }
//     });
// });

$("#con_import_data29-04-2025").click(function () {
    var form_main_unique_id = $("#demo").val();
    var file = document.getElementById('file').files.length;
    var no_of_consignee = document.getElementById('no_of_consignee').value;
    var cons_verfiy_sts = document.getElementById('cons_verfiy_sts').value;
    var batch_id = $("#batch_id").val();
    var consignee_received_date = $("#consignee_received_date").val();
    var po_number = $("#po_numbers").val();

    if (file === 0) {
        alert("Please select a file to upload.");
        return;
    }

    var data = new FormData();
    var image_s = document.getElementById("file");
    if (image_s.files.length > 0) {
        data.append("file", image_s.files[0]); // single file
    }

    data.append("form_main_unique_id", form_main_unique_id);
    data.append("no_of_consignee", no_of_consignee);
    data.append("cons_verfiy_sts", cons_verfiy_sts);
    data.append("batch_id", batch_id);
    data.append("consignee_received_date", consignee_received_date);
    data.append("po_number", po_number);

    $.ajax({
        type: "POST",
        url: 'folders/po_form/con_import_test2.php',
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        success: function (res) {
            console.log("Server response:", res);
            let response;
            try {
                response = JSON.parse(res);
            } catch (e) {
                console.error("JSON Parse Error:", e);
                alert("Unexpected server response. Please contact support.");
                return;
            }

            if (response.status === "error") {
                let errorMessage = "❌ Error:\n" + response.message;
                if (response.missing_ids && response.missing_ids.length > 0) {
                    errorMessage += "\n\nMissing/Invalid Staff IDs:\n" + response.missing_ids.join(", ");
                }

                alert(errorMessage); // Replace with SweetAlert if needed
                // Example SweetAlert:
                // Swal.fire({ icon: 'error', title: 'Upload Failed', text: errorMessage });
            } else {
                alert("✅ Upload successful!");
                // Swal.fire({ icon: 'success', title: 'Success', text: 'Upload successful!' });
                modal_close();
                sub_list_datatable_consignee("consignee_details_datatable");
            }
            document.getElementById('file').value = '';
        },
        error: function (xhr, status, error) {
            console.error("Upload failed:", error);
            alert("An error occurred while uploading the file.");
        }
    });
});

$("#con_import_data_23_old1").click(function () {
    var form_main_unique_id = $("#demo").val(); // Assuming this is the form's unique ID
    var file = document.getElementById('file').files.length; // Check if a file is selected
    var no_of_consignee = document.getElementById('no_of_consignee').value;
    var cons_verfiy_sts = document.getElementById('cons_verfiy_sts').value;
    var batch_id = $("#batch_id").val(); // Batch ID input
    var consignee_received_date = $("#consignee_received_date").val();
    var po_number = $("#po_numbers").val(); // PO Number input

    // // Validate that all fields are populated
    // if (!form_main_unique_id || !no_of_consignee || !cons_verfiy_sts || !batch_id || !consignee_received_date || !po_number) {
    //     alert("Please fill all the required fields.");
    //     return;
    // }

    // Check if file is selected
    if (file === 0) {
        alert("Please select a file to upload.");
        return;
    }

    // Create FormData object to append form data
    var data = new FormData();

    // Append files to FormData (if a file is selected)
    var image_s = document.getElementById("file");
    if (image_s.files.length > 0) {
        for (var i = 0; i < image_s.files.length; i++) {
            data.append("file", image_s.files[i]);
        }
    }

    // Append all other data fields
    data.append("form_main_unique_id", form_main_unique_id);
    data.append("no_of_consignee", no_of_consignee);
    data.append("cons_verfiy_sts", cons_verfiy_sts);
    data.append("batch_id", batch_id);
    data.append("consignee_received_date", consignee_received_date);
    data.append("po_number", po_number);

    console.log("Sending Data: ", data); // Log FormData to console for debugging

    // Perform the AJAX request
    $.ajax({
        type: "POST",
        url: 'folders/po_form/con_import_test.php',
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        success: function (res) {
            console.log(res); // Log the response from the server

            // Parse the JSON response
            var response = JSON.parse(res);

            if (response.status === "error") {
                // Show the error message and missing staff IDs
                var errorMessage = "Error: " + response.message;
                if (response.missing_staff_ids.length > 0) {
                    errorMessage += "\nMissing/Invalid Staff IDs: " + response.missing_staff_ids.join(", ");
                }

                // Display the error message in a more user-friendly way
                alert(errorMessage); // You can replace this with any custom UI alert system like modal or popup
            } else {
                // Successful upload
                modal_close();
                sub_list_datatable_consignee("consignee_details_datatable");
            }
        },
        error: function (xhr, status, error) {
            console.error("Error during file upload:", error); // Log error details for debugging
            alert("An error occurred while uploading the file. Please try again.");
        }
    });
});

$("#con_import_data123").click(function () {
    var form_main_unique_id = $("#demo").val();
    var file = document.getElementById('file').files.length;
    var no_of_consignee = $("#no_of_consignee").val();
    var cons_verfiy_sts = $("#cons_verfiy_sts").val();
    var batch_id = $("#batch_id").val();
    var consignee_received_date = $("#consignee_received_date").val();
    var po_number = $("#po_numbers").val();

    if (file === 0) {
        alert("Please select a file to upload.");
        return;
    }

    var data = new FormData();
    var image_s = document.getElementById("file");

    for (var i = 0; i < image_s.files.length; i++) {
        data.append("file", image_s.files[i]);
    }

    data.append("form_main_unique_id", form_main_unique_id);
    data.append("no_of_consignee", no_of_consignee);
    data.append("cons_verfiy_sts", cons_verfiy_sts);
    data.append("batch_id", batch_id);
    data.append("consignee_received_date", consignee_received_date);
    data.append("po_number", po_number);

    $.ajax({
        type: "POST",
        url: 'folders/po_form/con_import_test.php',
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        success: function (res) {
            console.log("Raw Response:", res);

            let response;
            try {
                response = JSON.parse(res);
            } catch (e) {
                console.error("Invalid JSON:", res);
                alert("Unexpected response from server:\n" + res);
                return;
            }

            if (response.status === "error") {
                let errorMessage = "Upload failed:\n" + response.message;
                if (response.missing_staff_ids && response.missing_staff_ids.length > 0) {
                    errorMessage += "\nMissing Staff IDs: " + response.missing_staff_ids.join(", ");
                }
                alert(errorMessage);
            } else {
                alert("Upload successful!");
                modal_close();
                sub_list_datatable_consignee("consignee_details_datatable");
            }
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error:", error);
            alert("An error occurred while uploading. Please try again.");
        }
    });
});


$("#con_import_data_tested").click(function () {
    var form_main_unique_id = $("#demo").val(); // Assuming this is the form's unique ID
    var file = document.getElementById('file').files.length; // Check if a file is selected
    var no_of_consignee = document.getElementById('no_of_consignee').value;
    var cons_verfiy_sts = document.getElementById('cons_verfiy_sts').value;
    var batch_id = $("#batch_id").val(); // Batch ID input
    var consignee_received_date = $("#consignee_received_date").val();
    var po_number = $("#po_numbers").val(); // PO Number input

    // Validate that all fields are populated
    // if (!form_main_unique_id || !no_of_consignee || !cons_verfiy_sts || !batch_id || !consignee_received_date || !po_number) {
    //     alert("Please fill all the required fields.");
    //     return;
    // }

    // Check if file is selected
    if (file === 0) {
        alert("Please select a file to upload.");
        return;
    }

    // Create FormData object to append form data
    var data = new FormData();

    // Append files to FormData (if a file is selected)
    var image_s = document.getElementById("file");
    if (image_s.files.length > 0) {
        for (var i = 0; i < image_s.files.length; i++) {
            data.append("file", image_s.files[i]);
        }
    }

    // Append all other data fields
    data.append("form_main_unique_id", form_main_unique_id);
    data.append("no_of_consignee", no_of_consignee);
    data.append("cons_verfiy_sts", cons_verfiy_sts);
    data.append("batch_id", batch_id);
    data.append("consignee_received_date", consignee_received_date);
    data.append("po_number", po_number);

    console.log("Sending Data: ", data); // Log FormData to console for debugging

    // Perform the AJAX request
    $.ajax({
        type: "POST",
        url: 'folders/po_form/con_import_test.php',
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        success: function (res) {
            console.log(res); // Log the response from the server

            // Parse the JSON response
            var response = JSON.parse(res);

            if (response.status === "error") {
                // Show the error message and missing staff IDs
                var errorMessage = "Error: " + response.message;
                if (response.missing_staff_ids.length > 0) {
                    errorMessage += "\nMissing/Invalid Staff IDs: " + response.missing_staff_ids.join(", ");
                }

                // Display the error message in a more user-friendly way
                alert(errorMessage); // You can replace this with any custom UI alert system like modal or popup
            } else {
                // Successful upload
                modal_close();
                sub_list_datatable_consignee("consignee_details_datatable");
            }
        },
        error: function (xhr, status, error) {
            console.error("Error during file upload:", error); // Log error details for debugging
            alert("An error occurred while uploading the file. Please try again.");
        }
    });
});

$("#con_import_data_to_test").click(function () {
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
alert(batch_id);
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
        url: 'folders/po_form/con_import_test.php',
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
// con_import_data_22-pavi
$("#con_import_data_24").click(function () {
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

function consignee_details_add_update(unique_id = "") { // au = add,update


    // alert('test');
        var internet_status = is_online();

        var is_form = form_validity_check("consignee_details_form");
       
        var no_of_consignee = document.getElementById('no_of_consignee').value;
        
        var batch_id = document.getElementById('batch_id').value;
        var consignee_received_date = document.getElementById('consignee_received_date').value;
       
        var billing_address = document.getElementById('billing_address').value;

        // alert(billing_address);
        var con_address = document.getElementById('con_address').value;

        var con_branch = document.getElementById('con_branch').value;


        var con_state_name = document.getElementById('con_state_name').value;
        var con_district = document.getElementById('con_district').value;
        
          var po_numbers = document.getElementById('po_numbers').value;


          var assign_team_member = document.getElementById('assign_team_member').value;

        // alert(assign_team_member);

        var con_pincode = document.getElementById('con_pincode').value;
        var con_contact_name = document.getElementById('con_contact_name').value;
        var con_contact_number = document.getElementById('con_contact_number').value;
        var con_lan_num = document.getElementById('con_lan_num').value;
        var consignee_gst = document.getElementById('consignee_gst').value;
        var form_main_unique_id = document.getElementById('demo').value;
        var zone = document.getElementById('zone').value;


        var cons_branch_code = document.getElementById('con_branch_code').value;
        var zone_code = document.getElementById('zone_code').value;
        var con_email = document.getElementById('con_email').value;
        var alter_contact_name = document.getElementById('alter_contact_name').value;
        var alter_contact_no = document.getElementById('alter_contact_number').value;

        var con_bill_gst_no = document.getElementById("con_bill_gst").value;
        var con_region      = document.getElementById("con_region").value;

        
        var cons_verify_sts = document.getElementById('verify_sts').value;

       
        var data = "no_of_consignee=" + no_of_consignee + "&consignee_gst=" + consignee_gst +"&billing_address=" + billing_address +"&con_branch=" + con_branch +"&con_address=" + con_address +
            "&con_district=" + con_district + "&con_state_name="+ con_state_name + "&batch_id="+batch_id+"&consignee_received_date="+ consignee_received_date +"            &con_pincode=" + con_pincode + "&con_contact_name=" + con_contact_name + "&con_contact_number=" +
            con_contact_number + "&con_lan_num=" + con_lan_num + "&form_main_unique_id=" +
            form_main_unique_id + "&zone=" + zone +"&cons_verify_sts=" + cons_verify_sts +"&po_numbers="+ po_numbers;

        data += "&unique_id=" + unique_id + "&assign_team_member="+ assign_team_member + "&cons_branch_code="+cons_branch_code +"&zone_code="+zone_code +"&con_email="+ con_email +"&alter_contact_name="+alter_contact_name+ "&alter_contact_no="+ alter_contact_no +"&con_region="+ con_region + "&con_bill_gst_no="+ con_bill_gst_no +"&action=consignee_details_add_update";

        var ajax_url = 'folders/po_form/crud.php';
        // var url      = sessionStorage.getItem("list_link");
        var url = "";
        //  var valid_order_qty = document.getElementById('valid_order_qty').value;
        // var valid_assign_qty = document.getElementById('valid_assign_qty').value;
        // var valid_bactch_cnt = document.getElementById('valid_bactch_cnt').value;
        
        
        
//         if(valid_order_qty <= valid_assign_qty){
// if(con_address && con_district !== ''){
//         // console.log(data);
//         $.ajax({
//             type: "POST",
//             url: ajax_url,
//             data: data,
//             beforeSend: function () {
//                 $(".consignee_details_add_update_btn").attr("disabled", "disabled");
//                 $(".consignee_details_add_update_btn").text("Loading...");
//             },
//             success: function (data) {

//                 var obj = JSON.parse(data);
//                 var msg = obj.msg;
//                 var status = obj.status;
//                 var error = obj.error;

//                 if (!status) {
//                     $(".consignee_details_add_update_btn").text("Error");
//                     // console.log(error);
//                 } else {
//                     if (msg == "e_already") {
//                         // sweetalert(msg, url);
//                         form_reset("consignee_details_form");
//                     }
//                     // if (msg == "e_already") {
//                         sweetalert(msg);
//                         //  window.location.reload();
                         
//                     sub_list_datatable_consignee("consignee_details_datatable");
//                     get_stored_sublist_count();
//                     // }
//                     $(".consignee_details_add_update_btn").removeAttr("disabled", "disabled");
//                     if (unique_id && msg == "already") {
//                         $(".consignee_details_add_update_btn").text("Update");
//                     } else {
//                         $(".consignee_details_add_update_btn").text("Add");
//                         $(".consignee_details_add_update_btn").attr("onclick",
//                             "consignee_details_add_update('')");
//                     }
//                     // Init Datatable
                   
                    
//                     document.getElementById('con_district').value = 'your_district_value';
//                     document.getElementById('con_district').value = '';

//                     // document.getElementById('con_district').selectedIndex = -1;

//                     document.getElementById('con_address').value = '';
//                     // document.getElementById('con_district').value = '';
//                     document.getElementById('con_pincode').value = '';
//                     document.getElementById('con_contact_name').value = '';
//                     document.getElementById('con_contact_number').value = '';
//                     document.getElementById('con_lan_num').value = '';
//                     document.getElementById('consignee_gst').value = '';
                    
                    
//                 }
//                 sweetalert(msg, url);
//             },
//             error: function (data) {
//                 alert("Network Error");
//             }
//         });
// }else{
//     alert("To Fill Consignee Address Details first");
// }
//         }else if(valid_order_qty === valid_assign_qty){
            
//             alert("Don't Create an Batch Because Your Order Quantity and Assign Quantity is Completed");
//         }
// if (valid_order_qty > valid_assign_qty) {

// if (valid_assign_qty < valid_order_qty && valid_bactch_cnt != 0) {
    if (con_address !== '' && con_district !== '') {
        $.ajax({
            type: "POST",
            url: ajax_url,
            data: data,
            beforeSend: function () {
                $(".consignee_details_add_update_btn").attr("disabled", "disabled").text("Loading...");
            },
            success: function (response) {
                var obj = JSON.parse(response);
                var msg = obj.msg;
                var status = obj.status;
                $(".consignee_details_add_update_btn").removeAttr("disabled").text("Add");
                if (!status) {
                    // $(".consignee_details_add_update_btn").text("Add");
                    // $(".consignee_details_add_update_btn").text("Add");
                    //     $(".consignee_details_add_update_btn").attr("onclick",
                    //         "consignee_details_add_update('')");
                    if (msg === "already") {
                        //form_reset("consignee_details_form");
                        alert("Duplicate address for this form already exists");
                    }
                    // $(".consignee_details_add_update_btn").removeAttr("disabled");
                    sweetalert(msg);
                } else {
                    if (msg === "already") {
                        
                        // $(".consignee_details_add_update_btn").text("Add");
                        // $(".consignee_details_add_update_btn").attr("onclick",
                        //     "consignee_details_add_update('')");
                        //form_reset("consignee_details_form");
                        $(".consignee_details_add_update_btn").text("Add");
                        $(".consignee_details_add_update_btn").removeAttr("disabled");
                        alert("Duplicate address for this form already exists");
                       
                    }
                    
                    
                    sweetalert(msg);
                    sub_list_datatable_consignee("consignee_details_datatable");
                    get_stored_sublist_count();

                    
                    // if (unique_id && msg === "already") {
                        if (unique_id) {
                        $(".consignee_details_add_update_btn").text("Update");
                    } else {
                        $(".consignee_details_add_update_btn").text("Add");
                        $(".consignee_details_add_update_btn").attr("onclick", "consignee_details_add_update('')");
                    }

                    // Clear form fields
                    document.getElementById('con_address').value = '';
                    document.getElementById('billing_address').value = '';
                    document.getElementById('con_state_name').value = '';
                    document.getElementById('con_district').value = '';
                    document.getElementById('con_pincode').value = '';
                    document.getElementById('con_contact_name').value = '';
                    document.getElementById('con_contact_number').value = '';
                    document.getElementById('con_lan_num').value = '';
                    document.getElementById('consignee_gst').value = '';
                    document.getElementById('zone').value = '';
                    document.getElementById('assign_team_member').value = '';
                }
            },
            error: function () {
                alert("Network Error");
            }
        });
    } else {
        alert("Please fill in both Consignee Address and District.");
    }
//     }
// } else if (valid_assign_qty < valid_order_qty && valid_bactch_cnt == 0) {
//     alert("Please import the previously created batch data before creating the next batch.");
// }


// else{
//     alert("Don't Create a Batch Because Your Order Quantity and Assigned Quantity is Completed");
// }
// else if (valid_order_qty > valid_assign_qty) {
//     alert("Don't Create a Batch Because Your Order Quantity and Assigned Quantity is Completed");
// }

    }
    
    
    
    // amc Datatable--old js (17-06-2025)
//     function amcsub_list_datatable_add_update(unique_id = "") {
//         // Optional alert for debugging
//         // alert("Function triggered");


//         alert('m');
    
//         var internet_status = is_online(); // Assuming you have this function already
    
//         // Get form values
//         var start_date = document.getElementById('start_date').value;
//         var end_date = document.getElementById('end_date').value;
//         var amc_percentae = document.getElementById('amc_percentae').value;
//         var amcvalue = document.getElementById('amcvalue').value;
//         var amc_required = document.getElementById('amc_required').value;
    
//         // var po_form_unique_id = document.getElementById('po_form_unique_id').value;

//         var po_form_unique_id = document.getElementById('form_main_unique_id').value;
//         // alert(po_form_unique_id);

//         // alert(po_form_unique_id);   
        
//         // if(start_date ==''||end_date==''||amc_percentae==''||amcvalue==''||po_form_unique_id==''){
//         //     Swal.fire({
//         //         icon: 'error',
//         //         title: 'Required',
//         //         text: 'Please Fill All Amc Field.',
//         //     });
//         //     // return false;
//         // }
//            var po_no = document.getElementById('mypo').value;
//         //   alert(po_no);
       
           
//         // var batch_id = document.getElementById('batch_id').value;
//          var batch_id = '';
//     // alert(batch_id);
//         // For debugging
//         // alert("Batch ID: " + batch_id);
        
//         // Create FormData object
//         var data = new FormData();
    
    
//           var amcpofile = document.getElementById("amcpofile");

//             var image_s = document.getElementById("po_file");

//             //  alert(image_s);

//              if (image_s.files.length > 0) {
//     for (var i = 0; i < image_s.files.length; i++) {
//         data.append("po_file", image_s.files[i]);
//     }
// } else {
//     let existingPoFile = document.getElementById("po_attach_files").value;
//     let existingPoOrgFile = document.getElementById("po_attach_org_files").value;

//     data.append("po_file_existing", existingPoFile);
//     data.append("po_file_org_existing", existingPoOrgFile);
// }

//             // return;
             
          
//     //          if (amcpofile != '') {
//     //             for (var i = 0; i < amcpofile.files.length; i++) {
//     //                 data.append("amcpofile", document.getElementById('amcpofile').files[i]);
                   
    
//     //             }
//     //         } else {
//     //             data.append("amcpofile", '');
//     //         }
            
    
//     // //   var data = new FormData();
//     //           if (image_s != '') {
//     //             for (var i = 0; i < image_s.files.length; i++) {

//     //                 data.append("po_file", document.getElementById('po_file').files[i]);
    
//     //             }
//     //         } else {
//     //             data.append("po_file", '');
//     //         }



//     if (amcpofile.files.length > 0) {
//     for (var i = 0; i < amcpofile.files.length; i++) {
//         data.append("amcpofile[]", amcpofile.files[i]); // Add [] to handle multiple files
//     }
// } else {
//     data.append("amcpofile", '');
// }

// // if (image_s.files.length > 0) {
// //     for (var i = 0; i < image_s.files.length; i++) {
// //         data.append("po_file[]", image_s.files[i]); // Add [] to handle multiple files
// //     }
// // } else {
// //     data.append("po_file", '');
// // }

// console.log(amcpofile.files); // To see file list
// console.log(image_s.files); 
    
//         data.append("start_date", start_date);
//         data.append("po_no", po_no);
//         data.append("end_date", end_date);
//         data.append("amc_percentae", amc_percentae);
//         data.append("amcvalue", amcvalue);
//         data.append("po_form_unique_id", po_form_unique_id);
//         data.append("batch_id", batch_id);
//         data.append("action", "amc_add_update");
    
//         var ajax_url = 'folders/po_form/crud.php';
    
//         $.ajax({
//             type: "POST",
//             url: ajax_url,
//             data: data,
//             cache: false,
//             contentType: false,
//             processData: false,
//             beforeSend: function () {
//                 $(".amcsub_list_datatable_add_update_btn").attr("disabled", true).text("Saving...");
//             },
//             success: function (response) {
//                 var obj = JSON.parse(response);
//                 var msg = obj.msg;
//                 var status = obj.status;
//                 var error = obj.error;
//                 var url = "";
    
//                 if (!status) {
//                     console.error("Error:", error);
//                     $(".amcsub_list_datatable_add_update_btn").text("Error").removeAttr("disabled");
//                 } else {
//                     if (msg === "already") {
//                         $(".amcsub_list_datatable_add_update_btn").text("Save").removeAttr("disabled");
//                     } else {
//                         $(".amcsub_list_datatable_add_update_btn").text("Saved").removeAttr("disabled");
//                     }
//                 }
    
//                 sweetalert(msg, url); // Show success or error alert
//                 //  $('#amc_datatable').DataTable().ajax.reload(null, false); 
//                 amcsub_list_datatable("amc_table_datatable");
                
//                 $('#start_date').val('');
//     $('#po_file').val('');
//     $('#end_date').val('');
//     $('#amc_percentae').val('');
//     $('#amcvalue').val('');
//     $('#amcpofile').val('');
                         
                
                
//             },
//             error: function () {
//                 alert("Network Error");
//                 $(".amcsub_list_datatable_add_update_btn").text("Save").removeAttr("disabled");
//             }
//         });
//     }



//-------------------updated this function on 17-06-25---

function amcsub_list_datatable_add_update_mainsas(unique_id = "") {

     // Get form values
    var start_date = document.getElementById('start_date').value.trim();
    var end_date = document.getElementById('end_date').value.trim();
    var amc_percentae = document.getElementById('amc_percentae').value.trim();
    var amcvalue = document.getElementById('amcvalue').value.trim();
    var amc_tax = document.getElementById('amc_tax').value.trim();
    var amc_unit_price = document.getElementById('amc_unit_price').value.trim();
    var amc_remarks = document.getElementById('amc_remarks').value.trim();

    // var amcpofile = document.getElementById("amcpofile");

    // Validate that at least one field is filled
    

    // Validate file input if a file is selected
   

    var po_form_unique_id = document.getElementById('form_main_unique_id').value;
    var po_no = document.getElementById('mypo').value;
    var amcpofile = document.getElementById("amcpofile");
 if (start_date === '' || end_date === '' || amc_percentae === '' || amcvalue === '' || amc_tax === '' || amc_unit_price === '' || amc_remarks === '' || amcpofile.files.length === 0) {
        alert("Please fill at least one field or select a file.");
        // sweetalert("form-alert");
         sweetalert("form_alert");
        return;
    }
    //   var amcpofile = document.getElementById("amcpofile");
   
    var batch_id = '';

    var data = new FormData();

    // AMC file upload
   // AMC file upload
    
    if (amcpofile.files.length > 0) {
        data.append("amcpofile", amcpofile.files[0]); // single file
    } else {
        data.append("amcpofile", '');
    }

//    alert(amcpofile.files[0]);

    // if (amcpofile.files.length > 0) {
    //     data.append("amcpofile", amcpofile.files[0]); // single file
    // } else {
    //     data.append("amcpofile", '');
    // }

    
var file_name = document.getElementById("po_attach_files").value;
var file_org_name = document.getElementById("po_attach_org_files").value;
    // PO file upload
    var po_file = document.getElementById("po_file");
    if (po_file.files.length > 0) {
        data.append("po_file", po_file.files[0]); // single file
    } else {
        data.append("po_file_existing", file_name);
        data.append("po_file_org_existing", file_org_name);
    }

//  if (amcpofile.files.length > 0) {
//         var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.pdf)$/i;
//         var fileName = amcpofile.files[0].name;
//         var maxSize = 2 * 1024 * 1024; // 2 MB in bytes

//         if (!allowedExtensions.exec(fileName)) {
//             alert("Invalid file type. Please upload JPG, JPEG, PNG, or PDF.");
//             return;
//         }

//         if (amcpofile.files[0].size > maxSize) {
//             alert("File size exceeds 2 MB.");
//             return;
//         }
//     }


           // Prepare form data
    // var form = document.getElementById("amc_form");
    // var data = new FormData(form); 
      var data = new FormData();
    // Other data
    data.append("start_date", start_date);
    data.append("end_date", end_date);
    data.append("amc_percentae", amc_percentae);
    data.append("amcvalue", amcvalue);
    data.append("po_form_unique_id", po_form_unique_id);
    data.append("po_no", po_no);
    data.append("batch_id", batch_id);
     data.append("amc_tax", amc_tax);
           data.append("amc_unit_price", amc_unit_price);
             data.append("amc_remarks", amc_remarks);
    data.append("action", "amc_add_update");



    $.ajax({
        type: "POST",
        url: 'folders/po_form/crud.php',
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function () {
            $(".amcsub_list_datatable_add_update_btn").attr("disabled", true).text("Saving...");
        },
        success: function (response) {
            console.log(response);
            try {
                var obj = JSON.parse(response);
                alert(obj.msg || "Saved successfully.");
                  amcsub_list_datatable("amc_table_datatable");

            // Clear fields
            $('#start_date').val('');
            $('#end_date').val('');
            $('#amc_percentae').val('');
            $('#amcvalue').val('');
            $('#amcpofile').val('');
             $('#amc_tax').val('');
              $('#amc_unit_price').val('');
               $('#amc_remarks').val('');
                // $('#amcpofile').val('');
            $('#po_file').val('');
            } catch (e) {
                alert("Unexpected server response.");
            }
            $(".amcsub_list_datatable_add_update_btn").text("Save").removeAttr("disabled");
            amcsub_list_datatable("amc_table_datatable");

            // Clear form fields
            form.reset();
        },
        error: function () {
            alert("Network Error");
            $(".amcsub_list_datatable_add_update_btn").text("Save").removeAttr("disabled");
        }
    });
}
function amcsub_list_datatable_add_update(unique_id = "") {
    var start_date = document.getElementById('start_date').value;
    var end_date = document.getElementById('end_date').value;
    var amc_percentae = document.getElementById('amc_percentae').value;
    var amcvalue = document.getElementById('amcvalue').value;
    var po_form_unique_id = document.getElementById('form_main_unique_id').value;
    var po_no = document.getElementById('mypo').value;
     var amc_tax = document.getElementById('amc_tax').value;
      var amc_unit_price = document.getElementById('amc_unit_price').value;
       var amc_remarks = document.getElementById('amc_remarks').value;
    var batch_id = '';

    var data = new FormData();

    // AMC file upload
    var amcpofile = document.getElementById("amcpofile");
    if (amcpofile.files.length > 0) {
        data.append("amcpofile", amcpofile.files[0]); // single file
    } else {
        data.append("amcpofile", '');
    }
var file_name = document.getElementById("po_attach_files").value;
var file_org_name = document.getElementById("po_attach_org_files").value;
    // PO file upload
    var po_file = document.getElementById("po_file");
    if (po_file.files.length > 0) {
        data.append("po_file", po_file.files[0]); // single file
    } else {
        data.append("po_file_existing", file_name);
        data.append("po_file_org_existing", file_org_name);
    }


if (start_date === '' || end_date === '' || amc_percentae === '' || amcvalue === '' || amc_tax === '' || amc_unit_price === '' || amc_remarks === '' || amcpofile.files.length === 0) {
        alert("Please fill at least one field or select a file.");
        // sweetalert("form-alert");
         sweetalert("form_alert");
        return;
    }

        
    // Other data
    data.append("start_date", start_date);
    data.append("end_date", end_date);
    data.append("amc_percentae", amc_percentae);
    data.append("amcvalue", amcvalue);
    data.append("po_form_unique_id", po_form_unique_id);
    data.append("po_no", po_no);
    data.append("batch_id", batch_id);
     data.append("amc_tax", amc_tax);
           data.append("amc_unit_price", amc_unit_price);
             data.append("amc_remarks", amc_remarks);
    data.append("action", "amc_add_update");


// if(start_date != '' ||end_date != '' || amc_percentae != '' || amcvalue != '' || amc_tax != '' || amc_unit_price != '' || amc_remarks != ''){
    $.ajax({
        type: "POST",
        url: 'folders/po_form/crud.php',
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function () {
            $(".amcsub_list_datatable_add_update_btn").attr("disabled", true).text("Saving...");
        },
        success: function (response) {
            console.log(response); // For debugging
            var obj = JSON.parse(response);
            sweetalert(obj.msg, '');

            $(".amcsub_list_datatable_add_update_btn").text("Save").removeAttr("disabled");
            amcsub_list_datatable("amc_table_datatable");

            // Clear fields
            $('#start_date').val('');
            $('#end_date').val('');
            $('#amc_percentae').val('');
            $('#amcvalue').val('');
            $('#amcpofile').val('');
             $('#amc_tax').val('');
              $('#amc_unit_price').val('');
               $('#amc_remarks').val('');
            $('#po_file').val('');
        },
        error: function () {
            alert("Network Error");
            $(".amcsub_list_datatable_add_update_btn").text("Save").removeAttr("disabled");
        }
    });
    // }else{
    //     sweetalert("form_alert");
    // }
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