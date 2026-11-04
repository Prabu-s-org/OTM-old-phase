
$(document).ready(function() {
    alert('hi prabu');
       other_insurence_types();
        insurence();
        ld_cal_validation();
        get_my_batchnos();
        sub_list_datatable("product_details_datatable");
      
    });
    
    
    
    function get_my_batchnos(){
             var form_main_unique_id = $("#demo").val();
             
                var ajax_url = sessionStorage.getItem("folder_crud_link");
                var url = sessionStorage.getItem("list_link");
    
              
    
                            // var data = {
                            //     "form_main_unique_id": form_main_unique_id,
                            //     "action": "get_my_batchids"
                            // }
                            
    
                            $.ajax({
                                type: "POST",
                                url: ajax_url,
                                 data: { action: 'get_my_batchids', form_main_unique_id: form_main_unique_id },
        success: function(response) {
            $("#batch_numbers").html(response);
        }
        //                         data: data,
        //                         success: function (response) {
        //         //                      if (response && response.length > 0) {
        //         //     var options = '<option value="">Select Batch</option>';
        //         //     response.forEach(function(item) {
        //         //         options += `<option value="${item.batch_id}">${item.batch_id}</option>`;
        //         //     });
    
        //         //     $("#batch_numbers").html(options);
        //         // } else {
        //         //     $("#batch_numbers").html('<option value="">No Batch Found</option>');
        //         // }
        //                             alert(data);
        //                             // console.log(data);
                                    
        // //                             	if (data) { 
            // 	$("#batch_numbers").html(data);
            // // }
        //                             // $('#batch_numbers').html(data);
        //                         }
                            });
             
             
    }
    
    // document.getElementById("tab31").addEventListener("click", function () {
    //     alert();
    //     // Remove active class from current panel
    //     document.querySelector(".multisteps-form__panel.js-active")?.classList.remove("js-active");
    
    //     // Add active class to the next panel
    //     document.getElementById("tab51").classList.add("js-active");
    // });
    // document.getElementById("tab31").addEventListener("click", function () {
    //     // Find the currently active panel and deactivate it
    //     const activePanel = document.querySelector(".multisteps-form__panel.js-active");
    //     if (activePanel) {
    //         activePanel.classList.remove("js-active");
    //     }
    
    //     // Activate the target panel
    //     const nextPanel = document.getElementById("tab51");
    //     if (nextPanel) {
    //         nextPanel.classList.add("js-active");
    //     } else {
    //         console.error("Next panel with ID 'tab51' not found.");
    //     }
    // });
    
    
    
    document.getElementById("back").addEventListener("click", function () {
        // alert();
         document.getElementById("mytabs").classList.remove("js-active");
            document.getElementById("tab31").classList.remove("js-active");
            document.getElementById("third_tab").classList.add("js-active");
    });
    
    
    
    function insurence() {
        // alert("Function called");
        var checkbox = document.querySelector('#insurence_required');
        var insuTypes = document.querySelector('#insu_types');
    
        if (checkbox.checked) {
            insuTypes.style.display = 'block';
        } else {
            insuTypes.style.display = 'none';
             $('#others_insu_types').hide();
            
        }
    }
    
    
    
    
    
    
    function ld_cal_validation() {
        // alert("Function called");
        var checkbox = document.querySelector('#ld_required');
        var lds = document.querySelector('#ld_calculate');
         var lds_1 = document.querySelector('#ld_calculate_1');
          var lds_2 = document.querySelector('#ld_calculate_2');
        
        
    // ld_calculate
    
        if (checkbox.checked) {
            lds.style.display = 'block';
            lds_1.style.display = 'block';
            lds_2.style.display = 'block';
        } else {
            lds.style.display = 'none';
            lds_1.style.display = 'none';
            lds_2.style.display = 'none';
        }
    }
    
    
    
    
    function toggleDateInput(checkbox) {
      const type = checkbox.value;
      const inputDiv = document.getElementById('input_' + type);
    //   alert();
      if (checkbox.checked) {
        inputDiv.style.display = 'block';
      } else {
        inputDiv.style.display = 'none';
      }
    }
    
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
            BGrequired();
    
            $('#ld_type').on('change', function () {
                var selected = $(this).val();
    
                if (selected === 'day') {
                    $('#ld_label_day').show();
                     $('#ld_per_day').show();
                    $('#ld_label_week').hide();
                } else if (selected === 'week') {
                    $('#ld_label_day').hide();
                    $('#ld_label_week').show();
                    $('#ld_per_day').show();
                } else {
                    $('#ld_label_day').hide();
                    $('#ld_label_week').hide();
                    $('#ld_per_day').hide();
                }
            });
    
            // Optional: trigger change on page load if value is preset
            $('#ld_type').trigger('change');
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
        alert(date_type);
        if(date_type == '1'){
            
            $('#dates_1').show();
        }else if(date_type == '2'){
             $('#dates_1').show();
        }else{
             $('#dates_1').hide();
        }
    }
    function handleEntryModeChange_old(selectedMode) {
        if (selectedMode === "entry") {
          $('#frst_ops').show();
          $('#frst_1_ops').show();
          $('#sec_ops').hide();
        } else if (selectedMode === "import") {
          $('#frst_ops').hide();
          $('#frst_1_ops').hide();
          $('#sec_ops').show();
        }
      }
    
    
    $(document).ready(function() {
        
        valueChanged();
    //   amcsub_list_datatable("#amc_datatable");
    //   alert();
        // alert();
        // amcsub_list_datatable("amc_datatable");
        sub_list_datatable("product_details_datatable");
       
            sub_list_datatable("po_delivery_datatable");
    });
    
    
    
        
      function BGrequired() {
        var bg_required = $('#bg_required').val();
    
        if (bg_required === "yes") {
            $('#bgrequireddivs').show();
            $('#bgrequireddiv').show();
        } else {
            $('#bgrequireddivs').hide();
            $('#bgrequireddiv').hide();
    
            // Optionally clear values when hidden
            $('#bg_percen').val('');
            $('#Month').val('');
        }
    }
    
    $(document).ready(function () {
       
           let timeout = null; // Variable to track typing delay
    
        document.getElementById("vendor_zone").addEventListener("input", function () {
            clearTimeout(timeout); // Clear previous timeout
            let searchKey = this.value.trim();
            let suggestionsBox = document.getElementById("suggestions");
    
            if (searchKey.length > 0) {
                timeout = setTimeout(() => { // Delay AJAX request
                    fetch("fetch_zone.php", {
                        method: "POST",
                        headers: { "Content-Type": "application/x-www-form-urlencoded" },
                        body: "search_key=" + encodeURIComponent(searchKey)
                    })
                    .then(response => response.json())
                    .then(data => {
                        suggestionsBox.innerHTML = "";
                        suggestionsBox.style.display = "none";
    
                        if (data.status && Array.isArray(data.zones) && data.zones.length > 0) {
                            let index = 0;
    
                            function showNextSuggestion() {
                                if (index < data.zones.length) {
                                    let zoneName = data.zones[index]; // Ensure valid data
                                    
                                    if (zoneName) { // Check if zoneName is not undefined
                                        let div = document.createElement("div");
                                        div.textContent = zoneName;
                                        div.onclick = function () {
                                            document.getElementById("vendor_zone").value = zoneName;
                                            suggestionsBox.style.display = "none";
                                        };
                                        suggestionsBox.appendChild(div);
                                        suggestionsBox.style.display = "block";
                                    }
                                    index++;
                                    setTimeout(showNextSuggestion, 200); // Delay next suggestion
                                }
                            }
    
                            showNextSuggestion(); // Start showing suggestions one by one
                        }
                    })
                    .catch(error => console.error("Error fetching data:", error)); // Handle fetch errors
                }, 300); // Typing delay (300ms)
            } else {
                suggestionsBox.style.display = "none";
            }
        });
    
        document.addEventListener("click", function (e) {
            if (!document.getElementById("vendor_zone").contains(e.target)) {
                document.getElementById("suggestions").style.display = "none";
            }
        });
    });
    $(document).ready(function() {
        $('#state_name').change(function() {
            let selectedStates = $(this).val();
            if (selectedStates.length > 0) {
                get_district(selectedStates);
            } else { }
        });
    });
    $(document).ready(function () {
       
       gst_check();
       get_po_no();
    });
    
    
    
    
     function get_po_no() {
            // document.getElementById('mypo').value = '';
            var po_num = document.getElementById('po_num').value;
            // alert(po_num);
            document.getElementById('mypo').value = po_num;
            document.getElementById('po_numbers').value = po_num;
            // document.getElementById('po_code').value = po_num;
            
        }
    
    function gst_check(){
        // alert();
    var val1 = document.getElementById('gst_option').value;
            // alert(val1);
            
            
            
            var unregistered_message = document.getElementById('unregistered_message');
      $("#unregistered_message").hide();
            if (val1 === 'no') {
                // alert("hoo");
                $("#checkit").show();
                $("#gst_num").hide();
                $("#unregistered_message").show();
                document.getElementById('gst_value').value = '';
               document.getElementById('testin').value = 1;
    
            } else if (val1 === 'yes') {
                // $("#checkit").show();
                $("#gst_num").show();
                $("#unregistered_message").hide();
    
    
    
            }
    }
    
    
    
        
            confirm_delete = function (msg) {
      return sweetalert(msg); // <--- return the swal call which returns a promise
    };
    
    
        function consignee_details_delete(unique_id = "") {
            if (unique_id) {
    
                var ajax_url = sessionStorage.getItem("folder_crud_link");
                var url = sessionStorage.getItem("list_link");
    
                confirm_delete('delete')
                    .then((result) => {
                        if (result.isConfirmed) {
    
                            var data = {
                                "unique_id": unique_id,
                                "action": "consignee_details_delete"
                            }
    
                            $.ajax({
                                type: "POST",
                                url: ajax_url,
                                data: data,
                                success: function (data) {
    
                                    var obj = JSON.parse(data);
                                    var msg = obj.msg;
                                    var status = obj.status;
                                    var error = obj.error;
    
                                    if (!status) {
                                        url = '';
                                    } else {
                                        sub_list_datatable_consignee("consignee_details_datatable");
                                    }
                                    sweetalert(msg, url);
                                }
                            });
    
                        }
    
                    });
            }
        }
    
    function tender_codes(){
    // 	alert('hi');
      var tender_code = $('#tender_code').val();
      
      
    // 	 alert(tender_code);
      var data = "&tender_code=" + tender_code + "&action=item_code_option";
    
    
      var ajax_url = sessionStorage.getItem("folder_crud_link");
      $.ajax({
        type: "POST",
        url: ajax_url,
        data: data,
        success: function (data) {
          // alert(data);
          if (data) {
            $("#item_code").html(data);
          }
        }
      });
    
    }
    
    function isNumberss(evt) {
        let charCode = evt.which ? evt.which : evt.keyCode;
        // Allow numbers (48-57), dot (46), and backspace (8)
        if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }
    
    function validateNumber(input) {
        
        // Remove any non-numeric characters except a single decimal point
        input.value = input.value.replace(/[^0-9.]/g, '');
        
        // Ensure only one decimal point exists
        if ((input.value.match(/\./g) || []).length > 1) {
            input.value = input.value.slice(0, -1);
        }
    }
    
     function quantity_number(input) {
    
      const allowedChars = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
      
      // Filter out characters that are not in the allowedChars array
      input.value = input.value.split('').filter(char => allowedChars.includes(char)).join('');
      }
      
      
    function validagst1(input) {
        let gstError = document.getElementById("gst_error");
        
    
        // Convert input to uppercase
        input.value = input.value.toUpperCase();
    
        // Allow only numbers and uppercase letters
        input.value = input.value.replace(/[^0-9A-Z]/g, '');
    
        // GST number regex pattern
        let gstRegex = /^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}[Z]{1}[0-9A-Z]{1}$/;
        
        if (input.value.length === 15 && gstRegex.test(input.value)) {
        gstError.style.display = "none"; // Hide error if valid
    
        // Append '1' to existing value
        let currentValue = document.getElementById('testin').value;
        // document.getElementById('testin').value = currentValue + '1';
        document.getElementById('testin').value = 1;
    
        $('#checkit').show();
    } else {
        gstError.style.display = "block"; // Show error if invalid
        document.getElementById('testin').value = '0'; // reset on error
    }
    
    }
    
    
    function validateGST(input) {
       
        let gstError = document.getElementById("gst_error");
        
    
        // Convert input to uppercase
        input.value = input.value.toUpperCase();
    
        // Allow only numbers and uppercase letters
        input.value = input.value.replace(/[^0-9A-Z]/g, '');
    
        // GST number regex pattern
        let gstRegex = /^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}[Z]{1}[0-9A-Z]{1}$/;
    
        if (input.value.length === 15 && gstRegex.test(input.value)) {
        gstError.style.display = "none"; // Hide error if valid
    
        // Append '1' to existing value
        let currentValue = document.getElementById('testin').value;
        document.getElementById('testin').value = currentValue + '1';
    
        $('#checkit').show();
    } else {
        gstError.style.display = "block"; // Show error if invalid
        document.getElementById('testin').value = '0'; // reset on error
    }
    
    }
    
    
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
    
    
    
    
    function get_account_sector() {
        var ajax_url = sessionStorage.getItem("folder_crud_link");
        var department = $("#department").val();
        
    
        if (department) {
            var data = {
                "department": department,
                "action": "get_account_sector"
            };
    
            $.ajax({
                type: "POST",
                url: ajax_url,
                data: data,
                success: function (response) {
                    
                
                    var details = JSON.parse(response);
                    console.log(details); // parsed object
                
                    if (details && details.status == 1 && details.data.length > 0) {
                        var acc_sector = details.data[0].acc_sector || '';
                        var acc_sector_name = details.data[0].acc_sector_name || '';
                
                        $("#acc_sector").val(acc_sector);
                        $("#acc_sector_name").val(acc_sector_name);
                    } else {
                        console.warn("Data not found or status is not 1");
                    }
                },
                error: function (xhr, status, error) {
                    console.error("AJAX Error:", status, error);
                }
            });
        }
    }
    
    function verify_consignee_address(batchId) {
        // alert(batchId);
        // For now, just show the batch ID to confirm it's working
        // alert("Verifying consignee address for Batch ID: " + batchId);
    
        var ajax_url = sessionStorage.getItem("folder_crud_link");
    
        if (batchId) {
            $.ajax({
                type: "POST",
                url: ajax_url,
                data: {
                    batchId: batchId,
                    action: "get_verify_status"
                },
                success: function (res) {
                    // var details = JSON.parse(res);
                     var obj = JSON.parse(data);
                    var msg = obj.msg;
                    var status = obj.status;
                    var error = obj.error;
    
     sweetalert(msg);
     $('#consigneeModal').modal('hide');
     
                    
                    
    },
    });
    }
        // // Example: You could also make an AJAX call here if needed
        // fetch('folders/po_form/crud.php?batch_id=' + batchId +'&action=')
        //     .then(response => response.json())
        //     .then(data => {
        //         console.log('Verification result:', data);
        //     })
        //     .catch(error => console.error('Error:', error));
    }
    $('#warranty').on('change', function () {
            if (this.value == '1') {
                $("#select_warranty").show();
                document.getElementById('old_warranty').value = '1';
            } else {
                $("#select_warranty").hide();
                document.getElementById('old_warranty').value = '0';
            }
        });
    
    
    
    $('#qty').on('input', function () {
    
    // alert('test');
       var qty = document.getElementById('qty').value;
       // var qty = parseFloat($(this).val());
       var unit_price = document.getElementById('unit_price').value;
       // alert(qty);
       var tax = document.getElementById('tax').value;
       // alert(tax);
    
       if (tax == '18') {
           const net_value = qty * unit_price;
           const percentage_value = net_value * (18 / 100);
           const total_value = net_value + percentage_value;
    
           document.getElementById('net_value').value = net_value;
           document.getElementById('total_value').value = total_value;
       } else if (tax == '28') {
           const net_value = qty * unit_price;
           const percentage_value = net_value * (28 / 100);
           const total_value = net_value + percentage_value;
    
           document.getElementById('net_value').value = net_value;
    
           document.getElementById('total_value').value = total_value;
       } else {
    
           const net_value = qty * unit_price;
           // percentage_value = net_value * (28 / 100);
           const total_value = net_value;
    
           document.getElementById('net_value').value = net_value;
    
           document.getElementById('total_value').value = total_value;
       }
    
    });
    
        document.addEventListener("DOMContentLoaded", function () {
            // Get today's date in YYYY-MM-DD format
            let today = new Date().toISOString().split('T')[0];
    
            // Set the max attribute of the PO Date input field
            document.getElementById("po_date").setAttribute("max", today);
        });
    
    
        $(document).ready(function () {
            sub_list_datatable("product_details_datatable");
            
            sub_list_datatable_consignee("consignee_details_datatable");
            sub_list_datatable("po_delivery_datatable");
        });
       
       
        
        
        
        function excel_export_old() {
        var main_unique_id = $('#m_unique_id').val();
        var ajax_url = sessionStorage.getItem("folder_crud_link");
    
        if (main_unique_id) {
            $.ajax({
                type: "POST",
                url: ajax_url,
                data: {
                    main_unique_id: main_unique_id,
                    action: "get_consignee_product_details"
                },
                success: function (res) {
                    var details = JSON.parse(res);
    
                    if (details.data && details.data.length > 0) {
                        // Format the data with headers
                        let exportData = details.data.map((item, index) => {
                            return {
                                "S.No": item.s_no,
                                "Consignee Name": item.con_contact_name,
                                "Consignee Contact": item.con_contact_number,
                                "Consignee Landline": item.con_lan_num,
                                "Consignee Address": item.con_address,
                                "Zone": item.zone,
                                "Item Code": item.item_code,
                                "Item Name": item.product_name,
                                "Qty": item.qty
                            };
                        });
    
                        // Create a worksheet
                        var worksheet = XLSX.utils.json_to_sheet(exportData);
    
                        // Create a workbook and add the worksheet
                        var workbook = XLSX.utils.book_new();
                        XLSX.utils.book_append_sheet(workbook, worksheet, "Consignee Details");
    
                        // Export the workbook to Excel file
                        XLSX.writeFile(workbook, "consignee_product_details.xlsx");
                    } else {
                        alert("No data found to export.");
                    }
                }
            });
        } else {
            alert("Main unique ID not found!");
        }
    }
    
    
    
            $("#import").click(function () {
                // alert('hi');
                var form_main_unique_id = $("#demo").val();
    
                // alert(form_main_unique_id);
                var file = document.getElementById('file').value;
                var no_of_consignee = document.getElementById('no_of_consignee').value;
                
                var cons_verfiy_sts = document.getElementById('cons_verfiy_sts').value;
    
                var data = new FormData();
                
                var image_s = document.getElementById("file");
                if (image_s != '') {
                    for (var i = 0; i < image_s.files.length; i++) {
                        data.append("file", document.getElementById('file').files[i]);
    
                    }
                } else {
                    data.append("file", '');
                }
    
                //    if(no_of_consignee){
                data.append("form_main_unique_id", form_main_unique_id);
                data.append("no_of_consignee", no_of_consignee);
                data.append("cons_verfiy_sts",cons_verfiy_sts);
    
    
                console.log([...data]); 
    
                $.ajax({
                    type: "POST",
                    url: 'folders/po_form/con_import.php',
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    method: 'POST',
                    success: function (res) {
                        console.log(res);
                        //  alert('Upload Successfully');
                        modal_close();
                        sub_list_datatable("consignee_details_datatable");
                        // window.location.reload();
    
    
                    },
    
                    error:function(xhr,status,error){
                        consloe.error(error);
                    }
    
                });
                // }
    
            });
        var phone_input = document.getElementById("con_lan_num");
    
        phone_input.addEventListener('input', () => {
            phone_input.setCustomValidity('');
            phone_input.checkValidity();
        });
    
        phone_input.addEventListener('invalid', () => {
            if (phone_input.value === '') {
                phone_input.setCustomValidity('Enter phone number!');
            } else {
                phone_input.setCustomValidity('Enter phone number in this format: 123-4567890');
            }
        });
    
    
        function get_district(state_id = "") {
            // alert();
    
            var ajax_url = sessionStorage.getItem("folder_crud_link");
    
            if (state_id) {
                var data = {
                    "state_id": state_id,
                    "action": "get_state_name"
                }
    
                $.ajax({
                    type: "POST",
                    url: ajax_url,
                    data: data,
                    success: function (data) {
    
                        if (data) {
                            // alert(data);
                            $("#district").html(data);
    
                           
                        }
                    }
                });
            }
        }
    
        
    
        
    
        $("#files").change(function () {
            filename = this.files[0].name
            console.log(filename);
        });
    
    
    
    
    
    
    
    
    function item_detail() {
        // Clear existing values
        $("#po_name").val('');
        $("#unit_price").val('');
        $("#tax").val('');
        $("#net_price").val('');
    
        var item_code = $('#item_code').val();
        var ajax_url = sessionStorage.getItem("folder_crud_link");
    
        if (item_code) {
            $.ajax({
                type: "POST",
                url: ajax_url,
                data: {
                    item_code: item_code,
                    action: "get_item_name"
                },
                success: function (res) {
                    console.log(res);
    
                    var details = JSON.parse(res);
                    var itemDescription = details['item_description'] || '';
                    var netPrice = parseFloat(details['rc_net_price']) || 0;
                    var gst = parseFloat(details['gst']) || 0;
    
                    // Reverse-calculate unit price (excluding GST)
                    var unitPrice = netPrice / (gst / 100);
    
                    // Set values in form
                    $("#po_name").val(itemDescription);
                    $("#net_price").val(netPrice.toFixed(2));
                    $("#tax").val(gst);
                    $("#unit_price").val(unitPrice.toFixed(2)); // set the calculated unit price
    
                    CalculateTotal(); // call total calculation
                },
                error: function () {
                    alert("Failed to fetch item details.");
                }
            });
        }
    }
    
    
    //     $("#wizard").steps({
           
    //         onStepChanging: function (event, currentIndex, newIndex) {
    //            alert();
    //             if (!po_form_cu()) {
    //                 return false; // Stay on the same step if validation fails
    //             }
    //             return true; // Allow navigation to the next step if validation passes
    //         }
    //     });
    
    //          function isNumber(evt) {
    //         evt = (evt) ? evt : window.event;
    //         var charCode = (evt.which) ? evt.which : evt.keyCode;
    //         if (charCode > 31 && (charCode < 48 || charCode > 57)) {
    //             return false;
    //         }
    //         return true;
    //     }
        
        
       
    
    //     function po_form_cu() {
           
    //         var internet_status = is_online();
    
    //         if (!internet_status) {
    //             sweetalert("no_internet");
    //             return false;
    //         }
    //          $('#no_of_pro_item').empty();
    //           $('#no_of_po_con').empty();
              
    //           var testin = document.getElementById('testin').value;
    // // if(testin == 1){
        
        
        
            
    //         var gst_values = document.getElementById('gst_value').value;
    
    // // alert(gst_values);
    // if(gst_values != ''){
    //     let gstRegex = /^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}[Z]{1}[0-9A-Z]{1}$/;
    //         if (!gstRegex.test(gst_values)) {
    //             sweetalert("gst_alert"); // Correct message for invalid GST
    //             return false;
                 
                 
    //         }
    //         var gst_value = gst_values;
            
    // }else{
        
    //     var gst_value = '';
    // }
    
    
    //         // Show the loader
    // // document.getElementById("loader").style.display = "block";
    
    //         var po_num = document.getElementById('po_num').value;
    //         var po_date = document.getElementById('po_date').value;
    //         var department = document.getElementById('department').value;
    //         var gst_option = document.getElementById('gst_option').value;
    //         var executive_name = document.getElementById('executive_name').value;
    //         var bill_address = document.getElementById('bill_address').value;
    //         var contact_name = document.getElementById('contact_name').value;
    //         var contact_number = document.getElementById('contact_number').value;
    //         var contact_landline_num = document.getElementById('contact_landline_num').value;
    
    //         var email = document.getElementById('email').value;
    //         var district = document.getElementById('district').value;
    //         var pin = document.getElementById('pin').value;
           
    //         var po_type = document.getElementById('po_type').value;
    //         var no_of_po = document.getElementById('no_of_po').value;
    //         var state_name = document.getElementById('state_name').value;
    //         var acc_vertical = document.getElementById('acc_vertical').value;
    //         var acc_sector = document.getElementById('acc_sector').value;
           
    //         var unique_id = document.getElementById('unique_id').value;
    //         var form_unique_id = document.getElementById('m_unique_id').value;
    //         var no_of_consignee = document.getElementById('no_of_consignee').value;
    //         var po_unique_id = document.getElementById('po_unique_id').value;
    //         //   var gst_value = document.getElementById('gst_value').value;
    //         // $gst_value
    
    //         var data = new FormData();
    //         data.append("po_num", po_num);
    //         data.append("m_unique_id", form_unique_id);
    //         data.append("po_date", po_date);
    //         data.append("department", department);
    //         data.append("gst_option", gst_option);
    //         data.append("gst_value", gst_value);
    //         data.append("executive_name", executive_name);
    //         data.append("bill_address", bill_address);
    //         data.append("unique_id", unique_id);
    //         data.append("contact_name", contact_name);
    //         data.append("contact_number", contact_number);
    //         data.append("contact_landline_num", contact_landline_num);
    //          data.append("acc_vertical", acc_vertical);
    //         data.append("acc_sector", acc_sector);
    
    //         data.append("email", email);
    //         data.append("district", district);
    //         data.append("pin", pin);
           
    //         data.append("po_type", po_type);
    //         data.append("no_of_po", no_of_po);
    //         data.append("state_name", state_name);
           
    //         data.append("no_of_consignee", no_of_consignee);
    //         data.append("po_unique_id", po_unique_id);
    //         //   data.append("gst_value", gst_value);
    
    //         data.append("action", "createupdate");
    
    //         var ajax_url = sessionStorage.getItem("folder_crud_link");
    //         var url = sessionStorage.getItem("list_link");
    
    //                 $('#no_of_pro_item').append(no_of_po);
    //                 $('#no_of_po_con').append(no_of_consignee);
    //         $.ajax({
    //             type: "POST",
    //             url: 'folders/po_form/crud.php',
    //             data: data,
    //             cache: false,
    //             contentType: false,
    //             processData: false,
    //             method: 'POST',
    //             beforeSend: function () {
    //                 $(".createupdate_btn").attr("disabled", "disabled");
    //                 $(".createupdate_btn").text("Loading...");
    //             },
    //             success: function (data) {
    //                 // console.log(data);
    //                 var obj = JSON.parse(data);
    //                 var msg = obj.msg;
    //                 var status = obj.status;
    //                 var error = obj.error;
    
    
    //                 if (!status) {
    //                     url = '';
    //                     $(".createupdate_btn").text("Error");
    //                     console.log(error);
    //                 } else {
    //                     if (msg == "already") {
    //                         // Button Change Attribute
    //                         url = '';
    
    //                         $(".createupdate_btn").removeAttr("disabled", "disabled");
    //                         if (unique_id) {
    //                             $(".createupdate_btn").text("Update");
    //                         } else {
    //                             $(".createupdate_btn").text("Save");
    //                         }
    //                     }
    //                 }
    
    
                        
    
    //                 get_product_sublist_count();
    //                 get_stored_sublist_count();
               
    //                 sweetalert(msg);
    //                 // department_create();
    
    
    //             },
    //             error: function (data) {
    //                 alert("Network Error");
                   
    //             }
    //         });
    
    //     }
    
        var product_details_tableid = 'product_details_datatable';
        var consignee_details_tableid = 'consignee_details_datatable';
    
        $(".bgdiv").hide();
        $(".bgdiv1").hide();
    
    function valueChanged() {
            if ($('.bgcheckbox').is(":checked")) {
                $(".bgdiv").show();
                $(".bgdiv1").show();
            } else {
                $(".bgdiv1").hide();
                $(".bgdiv").hide();
    
            }
        }
      
        //  function valueChangedamc() {
           
        //     if ($('.amccheckbox').is(":checked")) {
        //         $(".start_datediv").show();
        //           $(".amcpercendiv").show();
        //             $(".end_datediv").show();
        //         $(".amcvaluediv").show();
        //         $(".amcpofilediv").show();
        //          $(".amc_datatable").show();
        //           $(".po_filediv").show();
        //           $("#amc_table").show();
                  
                  
                
        //     } else {
        //           $(".start_datediv").hide();
        //           $(".amcpercendiv").hide();
        //             $(".end_datediv").hide();
        //         $(".amcvaluediv").hide();
        //         $(".amc_datatable").hide();
        //         $(".amcpofilediv").hide();
        //          $(".po_filediv").hide();
        //           $("#amc_table").hide();
               
    
        //     }
        // }
        function valueChangedamc() {
        if ($('.amccheckbox').is(":checked")) {
            $(".start_datediv").show();
            $(".amcpercendiv").show();
            $(".end_datediv").show();
            $(".amcvaluediv").show();
            $(".amcpofilediv").show();
            $(".amc_datatable").show();
            // $(".po_filediv").show();
            $("#amc_table").show();
            $(".addbtn").show(); // show the add button
        } else {
            $(".start_datediv").hide();
            $(".amcpercendiv").hide();
            $(".end_datediv").hide();
            $(".amcvaluediv").hide();
            $(".amc_datatable").hide();
            $(".amcpofilediv").hide();
            // $(".po_filediv").hide();
            $("#amc_table").hide();
            $(".addbtn").hide(); // hide the add button
        }
    }
    
        
         
    
        
        
    
     
        function print_pdf_1(file_name) {
    
      onmouseover = window.open('uploads/po_form/po_attach/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
    }
    
        $(document).ready(function () {
            if ($(".bgcheckbox").is(":checked")) {
                $(".bgdiv").show();
                $(".bgdiv1").show();
            } else {
                $(".bgdiv1").hide();
                $(".bgdiv").hide();
            }
    
            $('.select2_op').select2();
    
            $('#pro_details').click(function () {
                $('.select2_op').val(null).trigger('change');
            });
    
          
            // warranty option
            var warranty = document.getElementById('old_warranty').value;
            if (warranty == 'no') {
                $("#select_warranty").hide();
            } else {
                $("#select_warranty").show();
            }
    
    
    
            var unique_id = $('#unique_id').val();
            // alert(unique_id);
            if (unique_id) {
                document.getElementById('m_unique_id').value = '';
            }
            sub_list_datatable(product_details_tableid);
            sub_list_datatable(consignee_details_tableid);
    
        });
    
    
       
    
        $('#gst_option').on('change', function () {
            if (this.value == 'yes') {
                $("#gst_num").show();
                $("#unregistered_message").hide();
                document.getElementById('old_gst_option').value = 'yes';
    
    
            } else {
                $("#gst_num").hide();
                $("#unregistered_message").show();
                document.getElementById('old_gst_option').value = 'no';
    
            }
        });
    
        var current = 0;
        var tabs = $(".tab");
        var tabs_pill = $(".tab-pills");
    
        loadFormData(current);
    
        function loadFormData(n) {
            $(tabs_pill[n]).addClass("active");
            $(tabs[n]).removeClass("d-none");
            $("#back_button").attr("disabled", n == 0 ? true : false);
            n == tabs.length - 1 ?
                $("#next_button").text("Next").prop("disabled", true).removeAttr("onclick") :
                $("#next_button")
                    .attr("type", "button")
                    .text("Next").prop("disabled", false)
                    .attr("onclick", "next()");
        }
    
        function next() {
            var unique_id = document.getElementById('unique_id').value;
            if (unique_id == '') {
                if (validateCurrentTab()) {
                    $(tabs[current]).addClass("d-none");
                    $(tabs_pill[current]).removeClass("active");
                    current++;
                    loadFormData(current);
                }
            } else {
                $(tabs[current]).addClass("d-none");
                $(tabs_pill[current]).removeClass("active");
                current++;
                loadFormData(current);
            }
        }
    
        function validateCurrentTab() {
            const currentTabFields = $(tabs[current]).find('[required]');
    
            for (let i = 0; i < currentTabFields.length; i++) {
                if (!currentTabFields[i].value.trim()) {
                    // Replace the default alert with SweetAlert
                    Swal.fire({
                        icon: 'error',
                        // title: 'Validation Error',
                        text: 'Please fill out all required fields.',
                    });
                    return false;
                }
            }
            return true;
        }
    
     function get_details_olds() {
    
            var unique_id = document.getElementById('demo').value;
            var batch_ids = document.getElementById('batch_numbers').value;
            // alert(batch_ids);
            data = "unique_id=" + unique_id + "&batch_ids="+ batch_ids +"&action=get_assign_qty_record";
            var ajax_url = sessionStorage.getItem("folder_crud_link");
            // var ajax_url = sessionStorage.getItem("folder_crud_link");
            $.ajax({
                type: "POST",
                url: ajax_url,
                data: data,
    
                success: function (data) {
                    var obj = JSON.parse(data);
                    var msg = obj.msg;
                    var data = obj.data;
                    $('#mytable').html(data);
    
                }
            });
        }
    
        function get_details_1() {
    
            var unique_id = document.getElementById('demo').value;
    
            data = "unique_id=" + unique_id + "&action=get_assign_qty_record";
            var ajax_url = sessionStorage.getItem("folder_crud_link");
            $.ajax({
                type: "POST",
                url: ajax_url,
                data: data,
    
                success: function (data) {
                    var obj = JSON.parse(data);
                    var msg = obj.msg;
                    var data = obj.data;
                    $('#mytable').html(data);
    
                }
            });
        }
    
        function back() {
            $(tabs[current]).addClass("d-none");
            $(tabs_pill[current]).removeClass("active");
            current--;
            loadFormData(current);
        }
    
        function product_details_add_update(unique_id = "") { // au = add,update
            var internet_status = is_online();
           
            var form_class = "product_detail";
            var is_form = form_validity_check(form_class);
            // var is_form = form_validity_check("product_details_form");
    
            // console.log(is_form);
            var no_of_po = document.getElementById('no_of_po').value;
            var tender_code = document.getElementById('tender_code').value;
    
    
    
            var item_code = document.getElementById('item_code').value;
            var po_name = document.getElementById('po_name').value;
            // alert(po_name);
            var qty = document.getElementById('qty').value;
            var unit_price = document.getElementById('unit_price').value;
            var tax = document.getElementById('tax').value;
            var total_value = document.getElementById('total_value').value;
            // var net_value = document.getElementById('net_value').value;
    
            var form_main_unique_id = document.getElementById('form_main_unique_id').value;
    
            //    new change
            var delivery_due_dates = document.getElementById('delivery_due_dates').value;
            var ld_per_day = document.getElementById('ld_per_day').value;
            var ld_maximum_val = document.getElementById('ld_maximum_val').value;
            var warranty = document.getElementById('warranty').value;
            // alert(warranty);
            var warranty_duration = document.getElementById('warranty_duration').value;
             var warranty_starts = document.getElementById('warranty_starts').value;
           
               var document_required = document.getElementById('document_required').value;
               
                var net_value = document.getElementById('net_value').value;
               var net_price = document.getElementById('net_price').value;
               var insta_due_days = document.getElementById('insta_due_days').value;
               
                var ld_type = document.getElementById('ld_type').value;
                  var bg_required = document.getElementById('bg_required').value;
                  
                  if(bg_required === 'yes'){
                      
                       var bg_percen = document.getElementById('bg_percen').value;
               
                  var bg_month = document.getElementById('bg_month').value;
                  }else{
                      
                       var bg_percen = ''
               
                  var bg_month = '';
                  }
    
    
            // end
    
            // var data = $(".product_details_form").serialize();
            var data = "no_of_po=" + no_of_po + 
        "&tender_code=" + tender_code + 
        "&item_code=" + item_code + 
        "&po_name=" + po_name + 
        "&qty=" + qty + 
        "&unit_price=" + unit_price +
        "&tax=" + tax + 
        "&total_value=" + total_value + 
        "&net_value=" + net_value + 
        "&net_price=" + net_price + 
        "&delivery_due_dates=" + delivery_due_dates +
        "&ld_per_day=" + ld_per_day + 
        "&ld_maximum_val=" + ld_maximum_val + 
        "&warranty=" + warranty +
        "&warranty_duration=" + warranty_duration + 
        "&form_main_unique_id=" + form_main_unique_id + 
        "&unique_id=" + unique_id + 
        "&insta_due_days=" + insta_due_days +
        "&bg_required=" + bg_required + 
        "&bg_percen=" + bg_percen + 
        "&document_required=" + document_required + 
        "&warranty_starts=" + warranty_starts + 
        "&ld_type=" + ld_type + 
        "&bg_month=" + bg_month + 
        "&action=product_details_add_update";
    
            // alert(unique_id);
            var ajax_url = sessionStorage.getItem("folder_crud_link");
            // var url      = sessionStorage.getItem("list_link");
            var url = "";
    
            // console.log(data);
            $.ajax({
                type: "POST",
                url: ajax_url,
                data: data,
                beforeSend: function () {
                    $(".product_details_add_update_btn").attr("disabled", "disabled");
                    $(".product_details_add_update_btn").text("Loading...");
                },
                success: function (data) {
    
                    var obj = JSON.parse(data);
                    var msg = obj.msg;
                    var status = obj.status;
                    var error = obj.error;
                    
                   
    
                    if (!status) {
                        $(".product_details_add_update_btn").text("Error");
                        // console.log(error);
                    } else {
                        if (msg !== "product") {
                            form_reset("product_details_form");
                        }
                        if (msg == "product") {
                            sweetalert(msg);
                        }
                        if(msg == 'invalid_quantity'){
                           
                            alert('Quantity Should be greater than Existing quantity');
    
                        }
                        $(".product_details_add_update_btn").removeAttr("disabled", "disabled");
                        if (unique_id && msg == "already") {
                            $(".product_details_add_update_btn").text("Update");
                        } else {
                            form_reset("product_details_form");
                            $(".product_details_add_update_btn").text("Add");
                            $(".product_details_add_update_btn").attr("onclick",
                                "product_details_add_update('')");
                        }
                        get_product_sublist_count();
                        // Init Datatable
                        sub_list_datatable("product_details_datatable");
                    }
    
    
                   
                    document.getElementById('po_name').value = '';
                    document.getElementById('qty').value = '';
                    document.getElementById('unit_price').value = '';
                    document.getElementById('total_value').value = '';
                    document.getElementById('tax').value = '';
                    document.getElementById('net_value').value = '';
                    document.getElementById('net_price').value = '';
                    document.getElementById('delivery_due_dates').value = '';
                    document.getElementById('ld_per_day').value = '';
                    document.getElementById('ld_maximum_val').value = '';
                    document.getElementById('warranty').value = '';
                    document.getElementById('warranty_duration').value = '';
                    
                    document.getElementById('insta_due_days').value = '';
                    document.getElementById('bg_required').value = '';
                    document.getElementById('bg_percen').value = '';
                    document.getElementById('bg_month').value = '';
                    
                    document.getElementById('document_required').value = '';
                    document.getElementById('warranty_starts').value = '';
                    
                    
                     document.getElementById('tender_code').value = '';
                    document.getElementById('item_code').value = '';
    
    
                    var div_contents = document.getElementById("div1");
                    var elements = div_contents.getElementsByTagName("select");
                    var elements = getElementById("tax");
                    for (i = 0; i < elements.length; i++) {
                        elements[i].selectedIndex = -1;
                    }
                    sweetalert(msg, url);
    
                },
                error: function (data) {
                    alert("Network Error");
                }
            });
    
           
        }
    
       
    
    
        function product_details_edit(unique_id = "") {
            if (unique_id) {
               
                var data = "unique_id=" + unique_id + "&action=product_details_edit";
                var ajax_url = sessionStorage.getItem("folder_crud_link");
    
                $.ajax({
                    type: "POST",
                    url: ajax_url,
                    data: data,
                    beforeSend: function () {
                        $(".product_details_add_update_btn").attr("disabled", "disabled");
                        $(".product_details_add_update_btn").text("Loading...");
                    },
                    success: function (data) {
                        var obj = JSON.parse(data);
                        var data = obj.data;
                        var status = obj.status;
    
                        if (!status) {
                            $(".product_details_add_update_btn").text("Error");
                            console.log(obj.error);
                        } else {
                            // Clear existing options before appending new ones
    
    
                            var product = data.product;
                            var item_code = data.item_code;
                            var qty = data.qty;
                            var unit_price = data.unit_price;
                             var net_price = data.net_price;
                            var tax = data.tax;
                            var total_value = data.total_value;
                            var net_value = data.net_value;
                            var tender_code = data.tender_code;
    
                            var delivery_due_dates = data.delivery_due_dates;
                            var ld_per_day = data.ld_per_day;
                            var ld_maximum_val = data.ld_maximum_val;
                            var warranty = data.warranty;
                            var warranty_duration = data.warranty_duration;
                             var insta_due_days = data.insta_due_days;
                              var document_required = data.document_required;
                               var ld_type = data.ld_type; 
                               var bg_required = data.bg_required;
                                var bg_percen = data.bg_percen; 
                                var bg_month = data.bg_month;
                                 var warranty_starts = data.warranty_starts;
    
    
                          
                            $("#tender_code").val(tender_code);
                      
                            var item_code = data.item_code;
    var item_code_name = data.item_code_name;
    
    if ($("#item_code option[value='" + item_code + "']").length === 0) {
        $('#item_code').append(`<option value="${item_code}">${item_code_name}</option>`);
    }
    $("#item_code").val(item_code).trigger('change');
    
    $("#po_name").val(product);
    
                            $("#qty").val(qty);
                            $("#unit_price").val(unit_price);
                            $("#tax").val(tax);
                            $("#total_value").val(total_value);
                            $("#net_value").val(net_value);
                             $("#net_price").val(net_price);
    
                             $("#warranty_starts").val(warranty_starts);
                            $("#delivery_due_dates").val(delivery_due_dates);
                            $("#document_required").val(document_required);
                             $("#insta_due_days").val(insta_due_days);
                             $("#ld_type").val(ld_type);
                             $("#ld_per_day").val(ld_per_day);
                             $("#bg_required").val(bg_required);
                             $("#bg_percen").val(bg_percen);
                             $("#bg_month").val(bg_month);
                            $("#ld_maximum_val").val(ld_maximum_val);
                            $("#warranty").val(warranty);
                            $("#warranty_duration").val(warranty_duration);
    
    
                            // Enable update button
                            $(".product_details_add_update_btn").removeAttr("disabled").text("Update");
                            $(".product_details_add_update_btn").attr("onclick", "product_details_add_update('" + unique_id + "')");
                        }
                    },
                    error: function () {
                        alert("Network Error");
                    }
                });
            }
        }
    
    
    
        // consignee sub crud
        function consignee_details_add_update_olds(unique_id = "") { // au = add,update
    
            var internet_status = is_online();
    
            var is_form = form_validity_check("consignee_details_form");
           
            var no_of_consignee = document.getElementById('no_of_consignee').value;
            // var con_qty = document.getElementById('con_qty').value;
    
            var con_address = document.getElementById('con_address').value;
            var con_district = document.getElementById('con_district').value;
    
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
                "&con_district=" + con_district +
                "&con_pincode=" + con_pincode + "&con_contact_name=" + con_contact_name + "&con_contact_number=" +
                con_contact_number + "&con_lan_num=" + con_lan_num + "&form_main_unique_id=" +
                form_main_unique_id + "&zone=" + zone +"&cons_verify_sts=" + cons_verify_sts ;
            data += "&unique_id=" + unique_id + "&action=consignee_details_add_update";
    
            var ajax_url = sessionStorage.getItem("folder_crud_link");
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
                        if (msg == "e_already") {
                            sweetalert(msg);
                        }
                        $(".consignee_details_add_update_btn").removeAttr("disabled", "disabled");
                        if (unique_id && msg == "already") {
                            $(".consignee_details_add_update_btn").text("Update");
                        } else {
                            $(".consignee_details_add_update_btn").text("Add");
                            $(".consignee_details_add_update_btn").attr("onclick",
                                "consignee_details_add_update('')");
                        }
                        // Init Datatable
                        get_stored_sublist_count();
                        sub_list_datatable("consignee_details_datatable");
                        
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
    
        // consignee edit
        function consignee_details_edit(unique_id = "") {
            if (unique_id) {
                var data = "unique_id=" + unique_id + "&action=consignee_details_edit";
                // alert(data);
    
                var ajax_url = sessionStorage.getItem("folder_crud_link");
                // var url      = sessionStorage.getItem("list_link");
                var url = "";
    
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
                        // alert(data);
    
                        var obj = JSON.parse(data);
                        var data = obj.data;
                        var msg = obj.msg;
                        var status = obj.status;
                        var error = obj.error;
    
                        if (!status) {
                            $(".consignee_details_add_update_btn").text("Error");
                            console.log(error);
                        } else {
                            // console.log(obj);
    
                            var con_address = data.con_address;
                            var con_district = data.district_name;
                            var district_unique_id = data.con_district;
                            var con_pincode = data.con_pincode;
                            var con_contact_name = data.con_contact_name;
                            var con_contact_number = data.con_contact_number;
                            var con_lan_num = data.con_lan_num;
                            var zone= data.zone;
                            
                            var cons_verify_sts  = data.cons_verify_sts;
    
    
                            // $("#qty").empty();
                            // $("#tender_code").empty();
                            // Append tender code if it doesn't exist in options
                            if ($("#con_district option[value='" + con_district + "']").length === 0) {
                                $("#con_district").append($('<option>', {
                                    value: district_unique_id,
                                    text: con_district
                                }));
                            }
                            
                            $('#verify_sts').val(cons_verify_sts);
                            $("#con_address").val(con_address);
                            $("#con_district").val(district_unique_id);
                            // $("#rel_gender").val(gender).trigger("change");
                            $("#con_pincode").val(con_pincode);
    
                            $("#con_contact_name").val(con_contact_name);
                            $("#con_contact_number").val(con_contact_number);
                            $("#con_lan_num").val(con_lan_num);
    
                            $("#zone").val(zone);
                            // $("#con_district").empty();
                            // Button Change 
                            $(".consignee_details_add_update_btn").removeAttr("disabled", "disabled");
                            $(".consignee_details_add_update_btn").text("Update");
                            $(".consignee_details_add_update_btn").attr("onclick", "consignee_details_add_update('" + unique_id + "')");
                        }
                    },
                    error: function (data) {
                        alert("Network Error");
                    }
                });
            }
        }
        
        
    
    
        
        
        function sub_list_datatable(table_id = "", form_name = "", action = "") {
        var form_main_unique_id = $("#demo").val();
        var table = $("#" + table_id);
    
        var data = {
            "form_main_unique_id": form_main_unique_id,
            "action": table_id,
        };
        var ajax_url = sessionStorage.getItem("folder_crud_link");
    
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
                    data: data
                }
            });
        } else if (table_id === 'product_details_datatable') {
            var datatable = table.DataTable({
                destroy: true,
                ordering: false,
                searching: false,
                paging: false,
                info: false,
                ajax: {
                    url: ajax_url,
                    type: "POST",
                    data: data,
                    dataSrc: function (json) {
                        // Update footer totals
                        $("#sum_net_value").text(json.sum_net_value);
                        $("#sum_total_value").text(json.sum_total_value);
                        return json.data;
                    }
                }
            });
        } else {
            var datatable = table.DataTable({
                destroy: true,
                ordering: false,
                searching: false,
                paging: false,
                info: false,
                ajax: {
                    url: ajax_url,
                    type: "POST",
                    data: data
                }
            });
        }
    }
    
    
    
        function product_details_delete(unique_id = "") {
            if (unique_id) {
    
                var ajax_url = sessionStorage.getItem("folder_crud_link");
                var url = sessionStorage.getItem("list_link");
    
                confirm_delete('delete')
                    .then((result) => {
                        if (result.isConfirmed) {
    
                            var data = {
                                "unique_id": unique_id,
                                "action": "product_details_delete"
                            }
    
                            $.ajax({
                                type: "POST",
                                url: ajax_url,
                                data: data,
                                success: function (data) {
    
                                    var obj = JSON.parse(data);
                                    var msg = obj.msg;
                                    var status = obj.status;
                                    var error = obj.error;
    
                                    if (!status) {
                                        url = '';
                                    } else {
                                        sub_list_datatable("product_details_datatable");
                                    }
                                    sweetalert(msg, url);
                                }
                            });
    
                        }
    
                    });
            }
        }
    
    
      function check1(){
        //   var element = document.getElementById("finals");
        //         element.classList.remove("js-btn-next");
         var current = document.getElementById("finals");
        var next = current.nextElementSibling;
    
        if (next && next.classList.contains("multisteps-form__panel")) {
            current.classList.remove("is-active");
            next.classList.add("is-active");
        }
      }
    
        function validateEmail(event) {
            // Get the input value
            const emailInput = event.target.value;
    
            // Regular expression for a simple email format validation
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    
            // Test the input value against the regex
            const isValidEmail = emailRegex.test(emailInput);
    
            // Get the validation message element
            const validationMessage = document.getElementById('emailValidationMessage');
    
    
            // Display the validation message based on the result
            if (isValidEmail) {
                validationMessage.textContent = 'Valid email format';
                validationMessage.style.color = 'green';
            }
            else {
                validationMessage.textContent = 'Invalid email format';
                validationMessage.style.color = 'red';
            }
            if (isValidEmail) {
                validationMessage.textContent = '';
            }
            // Clear the validation message if the email format is valid
    
        }
    
    
    
    
    
        function check_qty_pavi() {
        // alert();
            var bill_qty = document.getElementsByName('bill_qty[]');
            var con_sno = document.getElementsByName('con_sno[]');
    
            var con_unique_id = document.getElementsByName('con_unique_id[]');
            // alert(product_name);
            var main_unique_id = document.getElementById('main_unique_id').value;
    
            var product_unique_id = document.getElementsByName('product_unique_id[]');
            var product_qty = document.getElementsByName('qty[]');
            var return_qty = document.getElementById('return_qty').value;
            var product_name = document.getElementsByName('item_name[]');
    
    
            var item_qty_total = [];
            var assign_qty_total = [];
            var item_name = [];
            let result_qty = [];
            let result_name = [];
            let item_names = [];
            var single = [];
            var qty_value_check = [];
            // var valueToPush = { };
            var bill_qty_total = [];
    
    
            for (var i = 0; i < bill_qty.length; i++) {
    
                var bill_qty_val = bill_qty[i].value;
                var qty_val = product_qty[i].value;
                var product_id = product_unique_id[i].value;
                var con_id_val = con_unique_id[i].value;
                var con_s_no = con_sno[i].value;
                var product_name_val = product_name[i].value;
    
    
                var number = parseFloat(bill_qty_val);
    
                if (!isNaN(number)) {
                    assign_qty_total.push(number);
                }
    
                var item_qty = product_qty[i].value;
    
                // var item_qty = parseFloat(qty_val);
    
                if (!isNaN(item_qty)) {
                    item_name.push({ product_name_val, item_qty });
                    item_qty_total.push(item_qty);
                }
    
                if (!isNaN(number)) {
                    var sum_of_assign_qty1 = assign_qty_total.reduce(function (total, current) {
                        return total + current;
                    }, 0);
                }
                // console.log(sum_of_assign_qty1);
            }
            for (var j = 0; j < product_name.length; j++) {
                var product_name_data = product_name[j].value;
                var item_data = bill_qty[j].value;
                // console.log(item_data);
                // console.log(product_name_data);
                item_names.push({ item_name: product_name_data, qty: item_data });
    
            }
            // console.log(item_names);
            const productQuantities = [];
            item_names.forEach(function (item) {
                // console.log(item['item_name']);
                var productName = item['item_name'];
                var quantity = item['qty'];
                if (productQuantities[productName]) {
                    productQuantities[productName] += ',' + quantity;
                } else {
                    // Otherwise, initialize the quantity for the product
                    productQuantities[productName] = quantity;
                }
            });
    
            var sums = {};
    
            // Iterate over each key-value pair in the data object
            for (var key in productQuantities) {
                if (productQuantities.hasOwnProperty(key)) {
                    // Split the string of values into an array
                    var valuesArray = productQuantities[key].split(',');
    
                    // Initialize a variable to store the sum of values for the current key
                    var sum = 0;
    
                    // Iterate over the array of values and sum them up
                    valuesArray.forEach(function (value) {
                        sum += parseInt(value, 10);
                    });
    
                    // Store the sum for the current key in the sums object
                    sums[key] = sum;
                    // sums[key] = sum;
    
                }
            }
            console.log('Sum of values:', sums);
    
            // item qty total value
            // item_qty_total.forEach((item, index) => { if (item_qty_total.indexOf(item) == index) result_qty.push(item) });
            item_name.forEach((item, index) => { if (item_name.indexOf(item) == index) result_name.push(item) });
            // console.log(result_qty);
            var uniqueProducts = {};
    
            result_name.forEach(function (entry) {
                var productName = entry.product_name_val;
                var itemQty = parseInt(entry.item_qty, 10);
    
                // If the product name does not exist in the uniqueProducts object, add it
                if (!uniqueProducts[productName]) {
                    uniqueProducts[productName] = itemQty;
                }
            });
    
            // Convert the uniqueProducts object back into an array of objects
            var filteredData = Object.keys(uniqueProducts).map(function (productName) {
                return { product_name_val: productName, item_qty: uniqueProducts[productName].toString() };
            });
    
            console.log('Filtered data:', filteredData);
    
            var conditionMet = true;
    
    
            for (var productName in sums) {
                // Check if the product name exists in the sums object
                if (sums.hasOwnProperty(productName)) {
                    // Find the corresponding object in the filteredData
                    var productObject = filteredData.find(function (obj) {
                        return obj.product_name_val === productName;
                    });
    
                    // If the corresponding object is found, compare the quantities
                    if (productObject) {
                        var expectedQty = sums[productName];
                        var actualQty = parseInt(productObject.item_qty);
    
                        // Check if the actual quantity matches the expected quantity
                        if (actualQty !== expectedQty) {
                            conditionMet = false;
                            break; // Break out of the loop if condition is not met
                        }
                    } else {
                        conditionMet = false;
                        break; // Break out of the loop if product not found
                    }
                }
            }
    
            // Check the conditionMet flag to determine the result
            // Product actual Qty miss matched Assign Qty
            if (conditionMet) {
                // po_assign_add_update();
                // alert("true");
                // myfetchrecord();
                po_delivery_submit_all();
    
                console.log("Condition is true");
                // var element = document.getElementById("mynxt");
                // element.classList.remove("js-btn-next");
    
            } else {
                // alert("false");
                var element = document.getElementById("mynxt");
                element.classList.remove("js-btn-next");
                console.log("Condition is false");
               
                Swal.fire({
                    title: 'Error!',
                    text: 'Verify the assigned quantity for the mismatch count!..',
                    icon: 'error',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    swal.close();
                });
                 
            }
    
    
        }
        
        
       function check_qty_old() {
            
            var isValid = true;
            var errorMessages = [];
            var total_billed = 0;
            var total_available = 0;
        
            var bill_qty = document.getElementsByName('bill_qty[]');
            var product_qty = document.getElementsByName('qty[]');
            // var pr_qty = document.getElementsByName('qty[]').value;
            var product_name = document.getElementsByName('item_name[]'); // for user-friendly errors
    // alert(pr_qty);
        
            for (var i = 0; i < bill_qty.length; i++) {
                var billed = parseFloat(bill_qty[i].value) || 0;
                var available = parseFloat(product_qty[i].value) || 0;
              
                var name = product_name[i].value || 'Unknown';
                
                total_billed += billed;
                total_available += available;
                
        
                // if (billed > available) {
                //     isValid = false;
                //     errorMessages.push(`Row ${i + 1} (${name}): Billed qty (${billed}) exceeds available qty (${available})`);
                // }
            }
            if(total_billed > total_available){
                  Swal.fire({
                    title: 'Assigned Quantity is Greater than Product Quantity',
                    html: errorMessages.join('<br>'),
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                return false;
            }else{
                 po_delivery_submit_all();
            // If validation passed, switch to next tab
            document.getElementById("mytabs").classList.remove("js-active");
            document.getElementById("tab51").classList.add("js-active");
            }
           
        
            // if (!isValid) {
              
            // }
        }
        
        
      function check_qty() {
        let isValid = true;
        let errorMessages = [];
    
        let bill_qty = document.getElementsByName('bill_qty[]');
        
        let product_qty = document.getElementsByName('qty[]');
        let rem_qty = document.getElementsByName('rem_qty[]');
        let product_name = document.getElementsByName('item_name[]');
        let stored_qty = document.getElementsByName('stored_qty[]');
    
        // Grouped totals by product name
        let groupedData = {};
    
        for (let i = 0; i < bill_qty.length; i++) {
            let billed = parseFloat(bill_qty[i].value) || 0;
            // let available = parseFloat(product_qty[i].value) || 0;
            let available = parseFloat(product_qty[i].value) || 0;
            let str_qty = parseFloat(stored_qty[i].value) || 0;
            let product = product_name[i].value.trim();
    
            if (!groupedData[product]) {
                groupedData[product] = {
                    assigned: 0,
                    available: available // assumed to be same across rows for the same product
                };
            }
    
            groupedData[product].assigned += billed;
        }
    
        // Validate totals for each product
        for (let product in groupedData) {
            let assigned = groupedData[product].assigned;
            let available = groupedData[product].available;
        //   alert(available);
        //   alert(assigned);
           
        //   if(remaining_qty == 0){
            if (assigned > available) {
                isValid = false;
                errorMessages.push(
                    `<b>${product}</b>: Total assigned quantity (${assigned}) exceeds available quantity (${available})`
                );
            }
          }
        // }
    
        if (!isValid) {
            Swal.fire({
                title: 'Validation Error',
                html: errorMessages.join('<br>'),
                icon: 'error',
                confirmButtonText: 'OK'
            });
            return false;
        } else {
            po_delivery_submit_all();
    
           
        }
    }
    
    
        
        
        function po_delivery_submit_all() {
            // alert();
        const po_batch_id = document.getElementById("batch_numbers")?.value || '';
        const mybatch_no = document.getElementById("mybatch_no")?.value || '';
            const myponumber = document.getElementById("myponumber")?.value || '';
            const con_address = document.getElementById("con_addr")?.value || '';
           
        // alert(po_batch_id);
        
        // alert(mybatch_no);
        if(po_batch_id == ''){
            batch_id = mybatch_no;
        }else{
             batch_id = po_batch_id;
        }
        // alert(batch_id);
        const form_main_unique_id = document.getElementById("main_unique_id")?.value || '';
        // const po_unique_id = document.getElementById("po_unique_id")?.value || '';
    
        let payload = [];
    
        // Loop through each assign row and prepare data
        document.querySelectorAll(".assign-row").forEach((row, index) => {
            let record = {};
    
            const fields = [
                // "batch_id",
                "product_unique_id",
                "item_code",
                "item_name",
                "qty",
                "unit_price",
                "tax",
                "bill_qty",
                "con_unique_id",
                "con_name",
                "con_contact_no",
                // "con_address",
                "con_main_address",
                "con_sno"
            ];
    
            fields.forEach(field => {
                const input = row.querySelector(`input[name="${field}[]"]`);
                if (input) {
                    record[field] = input.value;
                } else {
                    console.warn(`Row ${index + 1}: Missing field "${field}"`);
                    record[field] = "";
                }
            });
    
            // Attach shared values
            record["form_main_unique_id"] = form_main_unique_id;
            // record["po_unique_id"] = po_unique_id;
            record["batch_id"] = batch_id;
             record["po_number"] = myponumber;
            //   record["con_address"] = con_address;
              
        
            payload.push(record);
        });
    
        // console.log("Final JSON Payload:", payload);
    //     const po_batch_id = document.getElementById("batch_numbers")?.value || '';
    //     const mybatch_no = document.getElementById("mybatch_no")?.value || '';
    //     // alert(po_batch_id);
    //     // alert(mybatch_no);
    //     if(po_batch_id == ''){
    //         batch_id = mybatch_no;
    //     }else{
    //          batch_id = po_batch_id;
    //     }
    //     // alert(batch_id);
    // const form_main_unique_id = document.getElementById("main_unique_id")?.value || '';
    // // const po_unique_id = document.getElementById("po_unique_id")?.value || '';
    
    // let payload = [];
    
    // document.querySelectorAll(".assign-row").forEach((row, index) => {
    //     let record = {};
    
    //     // Static fields to be included in every record
    //     record.form_main_unique_id = form_main_unique_id;
    //     record.batch_id = batch_id; // or use 'batch_id' if your backend expects that key
    //     // record.po_unique_id = po_unique_id;
    
    //     // Dynamic fields from each row
    //     const fields = [
    //         "product_unique_id",
    //         "item_code",
    //         "item_name",
    //         "qty",
    //         "unit_price",
    //         "tax",
    //         "bill_qty",
    //         "con_unique_id",
    //         "con_name",
    //         "con_contact_no",
    //         "con_sno"
    //     ];
    
    //     fields.forEach(field => {
    //         const input = row.querySelector(`[name="${field}"]`);
    //         record[field] = input?.value || '';
    //     });
    
    //     payload.push(record);
    // });
    
    // // Now you can send `payload` via fetch/AJAX to the server
    // console.log(payload);
    
        // Submit to the API
        fetch("http://122.165.127.123/otm/folders/po_form/po_assign_update.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(payload)
        })
        .then(res => res.json())
        .then(response => {
            console.log("API Response:", response);
    
            if (response.status === true) {
                Swal.fire({
                    icon: "success",
                    title: "Success",
                    text: "All PO assignment records submitted!",
                    timer: 1500,
                    showConfirmButton: false
                });
     // Optional tab switch
            document.getElementById("mytabs").classList.remove("js-active");
            document.getElementById("tab51").classList.add("js-active");
                // Optional: Reload the datatable
                sub_list_datatable("po_delivery_datatable");
    
                // Enable next step button
                // document.getElementById("mynxt")?.classList.add("js-btn-next");
    
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: response.msg || "Something went wrong during submission."
                });
            }
        })
        .catch(error => {
            console.error("API Error:", error);
            Swal.fire({
                icon: "error",
                title: "Network Error",
                text: "Failed to submit PO assignments due to network issues."
            });
        });
    }
    
        function po_delivery_submit_all1() {
        const batch_id = document.getElementById("batch_id").value; // Assuming you have a hidden input or some way to get batch_id
        // const form_main_unique_id = document.getElementById("main_unique_id").value;
        // const po_unique_id = document.getElementById("po_unique_id").value;
        
        
        //  var internet_status = is_online();
        var demo = document.getElementById('demo').value;
    
        
        
    
        let payload = [];
    
        document.querySelectorAll(".assign-row").forEach((row, index) => {
            let record = {};
    
            const fields = [
                "product_unique_id",
                "item_code",
                "item_name",
                "qty",
                "unit_price",
                "tax",
                "bill_qty",
                "con_unique_id",
                "con_name",
                "con_contact_no",
                "con_sno"
            ];
    
            fields.forEach(field => {
                const input = row.querySelector(`input[name="${field}[]"]`);
                if (input) {
                    record[field] = input.value;
                } else {
                    console.warn(`Row ${index + 1}: Missing field "${field}"`);
                    record[field] = "";
                }
            });
    
            // Attach common fields
            record["form_main_unique_id"] = form_main_unique_id;
            record["po_unique_id"] = po_unique_id;
            record["batch_id"] = batch_id;
    
            payload.push(record);
        });
    
        console.log("Final JSON Payload:", payload);
    
        // 🔥 Send the entire payload as JSON to the API
        fetch("http://122.165.127.123/otm/folders/po_form/po_assign_create.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(payload)
        })
        .then(res => res.json())
        .then(response => {
            console.log("API Response:", response);
            if (response.status === true) {
                Swal.fire({
                    icon: "success",
                    title: "Success",
                    text: "All PO assignment records submitted!",
                    timer: 1500,
                    showConfirmButton: false
                });
    
                // Refresh datatable or page part if needed
                sub_list_datatable("po_delivery_datatable");
    
                // Allow moving to next step
                document.getElementById("mynxt").classList.add("js-btn-next");
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: response.msg || "Something went wrong during submission."
                });
            }
        })
        .catch(error => {
            console.error("API Error:", error);
            Swal.fire({
                icon: "error",
                title: "Network Error",
                text: "Failed to submit PO assignments due to network issues."
            });
        });
    }
    
        function myfetchrecord() {
            // alert("hii");
        let data = [];
    
        // Adjust this selector based on your real HTML
        document.querySelectorAll(".assign-row").forEach((row, index) => {
            let record = {};
    
            const fields = [
                "form_main_unique_id",
                "product_unique_id",
                "item_code",
                "item_name",
                "qty",
                "con_unique_id",
                "con_name",
                "con_contact_no",
                "bill_qty",
                "unit_price"
            ];
    
            fields.forEach(className => {
                const input = row.querySelector(`.${className}`);
                if (!input) {
                    console.warn(`Row ${index + 1}: Missing .${className}`);
                    record[className] = "";
                } else {
                    record[className] = input.value;
                }
            });
    
            data.push(record);
        });
    
        console.log("Payload:", JSON.stringify(data));
        
        fetch("http://122.165.127.123/otm/folders/po_form/po_assign_create.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: jsonPayload
    })
    .then(res => res.json())
    .then(response => {
        console.log("API Response:", response);
        document.getElementById("loader").style.display = "none";
        if (response.status === true) {
            alert(`✅ PO assignment submitted successfully!\n\nTotal Success: ${response.success_count}`);
            // sub_list_datatable("po_delivery_datatable");
                      sweetalert(msg);
                        var element = document.getElementById("mynxt");
                        element.classList.add("js-btn-next");
        }
    })
    .catch(error => {
        console.error("Error:", error);
    });
    }
        
    //   // Show the loader
    // document.getElementById("loader").style.display = "block";
    //     fetch("http://localhost/otm_beta/folders/po_form/po_assign_create.php", {
    //     method: "POST",
    //     headers: {
    //         "Content-Type": "application/json"
    //     },
    //     body: jsonPayload
    // })
    // .then(res => res.json())
    // .then(response => {
    //     console.log("API Response:", response);
    //  // Hide loader
    //     document.getElementById("loader").style.display = "none";
    //     if (response.status === true) {
    //         alert(`✅ PO assignment submitted successfully!\n\nTotal Success: ${response.success_count}`);
    //         // sub_list_datatable("po_delivery_datatable");
    //                   sweetalert(msg);
    //                     var element = document.getElementById("mynxt");
    //                     element.classList.add("js-btn-next");
    //     } else {
    //         let errorMsg = `❌ Failed to submit PO assignment.\n\nSuccess: ${response.success_count}\nFailed: ${response.failed_count}`;
            
    //         if (response.errors && response.errors.length > 0) {
    //             // Limit to first 5 errors for readability
    //             const sampleErrors = response.errors.slice(0, 5).join("\n- ");
    //             errorMsg += `\n\nSome errors:\n- ${sampleErrors}`;
    //         }
    
    //         alert(errorMsg);
    //     }
    // })
    // .catch(error => {
    //     console.error("Error:", error);
    //     alert("Something went wrong while submitting PO assignment.");
    // });
    
    
        
        function po_assign_add_update(unique_id = "") {
        // alert();
        var internet_status = is_online();
        var demo = document.getElementById('demo').value;
        var bill_qty = document.getElementsByName('bill_qty[]');
    
        for (var i = 0; i < bill_qty.length; i++) {
            var bill_qty_val = document.getElementsByName('bill_qty[]')[i].value;
            var item_code = document.getElementsByName('item_code[]')[i].value;
            var item_name = document.getElementsByName('item_name[]')[i].value;
            var unit_price = document.getElementsByName('unit_price[]')[i].value;
            var tax = document.getElementsByName('tax[]')[i].value;
            var qty = document.getElementsByName('qty[]')[i].value;
            var con_unique_id = document.getElementsByName('con_unique_id[]')[i].value;
            var con_name = document.getElementsByName('con_name[]')[i].value;
            var con_contact_no = document.getElementsByName('con_contact_no[]')[i].value;
            var product_unique_id = document.getElementsByName('product_unique_id[]')[i].value;
            var form_main_unique_id = document.getElementById('main_unique_id').value;
            var po_unique_id = document.getElementById('po_unique_id').value;
            // var unique_id_value = document.getElementById('unique_id').value;
    
            var data = {
                "form_main_unique_id": form_main_unique_id,
                "con_unique_id": con_unique_id,
                "con_name": con_name,
                "con_contact_no": con_contact_no,
                "item_code": item_code,
                "item_name": item_name,
                "bill_qty": bill_qty_val,
                "unit_price": unit_price,
                "item_tax": tax,
                "po_unique_id": po_unique_id,
                "product_unique_id": product_unique_id,
                "qty": qty,
                "unique_id": unique_id
            };
    
            var external_api_url = "http://122.165.127.123/otm/folders/po_form/po_assign_create.php"; // Replace with actual external API URL
     var external_api_url = "http://122.165.127.123/otm/folders/po_form/po_assign_create.php"; // Replace with actual external API URL
    
            $.ajax({
                type: "POST",
                url: external_api_url,
                data: JSON.stringify(data), // Convert data to JSON string
                contentType: "application/json", // Set content type to JSON
                beforeSend: function() {
                    $(".po_delivery_add_update_btn").attr("disabled", "disabled");
                    $(".po_delivery_add_update_btn").text("Loading...");
                },
                success: function(response) {
                    var obj = JSON.parse(response);
                    var msg = obj.msg;
                    var status = obj.status;
                    if (!status) {
                        $(".po_delivery_add_update_btn").text("Error");
                    } else {
                        if (msg == "e_already") {
                            form_reset("po_delivery_form");
                        }
                        $(".po_delivery_add_update_btn").removeAttr("disabled");
                        if (unique_id) {
                            $(".po_delivery_add_update_btn").text("Update");
                        } else {
                            $(".po_delivery_add_update_btn").text("Add");
                            $(".po_delivery_add_update_btn").attr("onclick", "po_delivery_add_update('')");
                        }
                        sub_list_datatable("po_delivery_datatable");
                       
                    }
                    // sweetalert(msg);
                    // var element = document.getElementById("mynxt");
                    // element.classList.add("js-btn-next");
                    sweetalert(msg);
                        var element = document.getElementById("mynxt");
                        element.classList.add("js-btn-next");
                },
                 error: function(response) {
               
                    Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'successfully Saved!',
                            timer: 1000, // Alert will close after 2 seconds
                            showConfirmButton: false // Hides the confirm button
                        });
                    }
                //     Swal.fire({
                //         icon: 'error',
                //         title: 'Network Error',
                //         text: 'There was a network error while saving.'
                //     });
                // }
            });
        }
    }
     
        // get consignee count  -->
    
        function get_stored_sublist_count() {
    
            var uni_id = document.getElementById('form_main_unique_id').value;
            var data = "uni_id=" + uni_id + "&action=check_consignee";
            var ajax_url = sessionStorage.getItem("folder_crud_link");
    
            $.ajax({
                type: "POST",
                url: ajax_url,
                data: data,
                success: function (data) {
    
                    var obj = JSON.parse(data);
    
                    document.getElementById('stored_consignee').value = obj.data[0];
                    get_consignee();
                }
            });
        }
    
        function get_consignee() {
    
            var uni_id = document.getElementById('form_main_unique_id').value;
    
            var data = "uni_id=" + uni_id + "&action=no_of_consignee";
            var ajax_url = sessionStorage.getItem("folder_crud_link");
    
            $.ajax({
                type: "POST",
                url: ajax_url,
                data: data,
                success: function (data) {
    
                    var obj = JSON.parse(data);
    
                    document.getElementById('count_consignee').value = obj.data[0];
                    //  get_stored_sublist_count();
                    get_tab_checking();
    
                }
            });
    
        }
    
        function get_tab_checking() {
            var x = document.getElementById('stored_consignee').value;
            var y = document.getElementById('count_consignee').value;
            if (x != y) {
                $('#consignee_btn').hide();
                $('#consignee_msg').show();
            }
            else {
                $('#consignee_btn').show();
                $('#consignee_msg').hide();
            }
        }
    
    
    
        function get_product_sublist_count() {
    
            var uni_id = document.getElementById('form_main_unique_id').value;
            var data = "uni_id=" + uni_id + "&action=check_product";
            var ajax_url = sessionStorage.getItem("folder_crud_link");
    
            $.ajax({
                type: "POST",
                url: ajax_url,
                data: data,
                success: function (data) {
    
                    var obj = JSON.parse(data);
    
                    document.getElementById('stored_item').value = obj.data[0];
                    get_po_item();
                }
            });
        }
    
        function get_po_item() {
    
            var uni_id = document.getElementById('form_main_unique_id').value;
    
            var data = "uni_id=" + uni_id + "&action=no_of_item";
            var ajax_url = sessionStorage.getItem("folder_crud_link");
    
            $.ajax({
                type: "POST",
                url: ajax_url,
                data: data,
                success: function (data) {
    
                    var obj = JSON.parse(data);
    
                    document.getElementById('count_item').value = obj.data[0];
    
                    get_producttab_checking();
                },
            });
    
        }
    
        function get_producttab_checking() {
    
            var x = document.getElementById('stored_item').value;
            var y = document.getElementById('count_item').value;
    
    
            if (x != y) {
                $('#product_data').hide();
                $('#product_msg').show();
    
            } else {
                $('#product_data').show();
                $('#product_msg').hide();
    
            }
        }
        //product end-->
        //department creation start-->
    
        function generateRandomString(length) {
            var result = '';
            var characters = '1234567890abcdefghijklmnopqrstuvwxyz';
            var charactersLength = characters.length;
            for (var i = 0; i < length; i++) {
                result += characters.charAt(Math.floor(Math.random() * charactersLength));
            }
            return result;
        }
    
        function department_create(unique_id = "") {
    
            var internet_status = is_online();
    
            if (!internet_status) {
                sweetalert("no_internet");
                return false;
            }
    
            var department = document.getElementById('department_txt').value;
            var acc_sector = document.getElementById('acc_sector_1').value;
           
            var randomString = generateRandomString(18); // Generate a random string of length 16
            // console.log(randomString);
            var is_active1 = document.getElementById('is_active1').value;
            // var unique_id = document.getElementById('unique_id').value;
    
    
            if (department.trim() !== "") {
                // Create a new option element
                var option = document.createElement('option');
    
                // Set the value and text of the option to the entered value
                option.value = randomString;
                option.text = department;
    
                // Append the new option to the select dropdown
                document.getElementById('department').appendChild(option);
    
                // Optionally, clear the input field after saving
                // document.getElementById('department_txt').value = '';
            } else {
                alert('Please enter a value before saving.');
            }
    
            if (department && is_active1) {
    
                // var data = "department=" +department + "&is_active1=" + is_active1;
                // data 		+= "&unique_id="+unique_id+"&action=department_cu";
    
                var data = {
                    unique_id: randomString,
                    department: department,
                    acc_sector: acc_sector,
                    is_active1: is_active1,
    
                    action: "department_cu"
                };
                var data_1 = {
                   
                    action: "get_customer"
                };
                // alert(data);
    
    
                var ajax_url = sessionStorage.getItem("folder_crud_link");
                var url = sessionStorage.getItem("list_link");
                $.ajax({
                    type: "POST",
                    url: ajax_url,
                    data: data,
                    // success: function (data) {
                    //     var obj = JSON.parse(data);
                    //     var msg = obj.msg;
                    //     var status = obj.status;
                    //     var error = obj.error;
                    //     // alert(msg);
                    //     if (data == "") {
                    //         alert('enter the value');
                    //     }
                    //     else {
                    //         // alert('saved successfully');
                    //         sweetalert(msg);
                    //         $.ajax({
                    //             type: "POST",
                    //             url: ajax_url,
                    //             data: data_1,
                    //             success: function (data) {
                    //                 var obj = JSON.parse(data);
                    //                 var msg = obj.msg;
                    //                 var status = obj.status;
                    //                 var error = obj.error;
                    //                 console.log(data);
                    //             },
                    //             error: function (data) {
                    //                 alert("Network Error");
                
                    //             }
                    //         });
                    //         $('#demos').modal('hide');
                    //         // $('').close()
                    //     }
                    // },
                    
                    
                    success: function (data) {
                        var obj = JSON.parse(data);
                        var msg = obj.msg;
                        var status = obj.status;
                        var error = obj.error;
                    
                        if (data == "") {
                            alert('enter the value');
                        } else {    
                           sweetalert(msg);
                            
                            $('#demos').modal('hide');
                    customer_name();        
    
                        }
                        
                    },
                    
                    
                    
                    error: function (data) {
                        alert("Network Error");
    
                    }
                });
            } else {
                sweetalert("form_alert");
            }
        }
    
        function customer_name(){
    
            var ajax_url = sessionStorage.getItem("folder_crud_link");
            var data = {
                   
                action: "get_customer"
            };
    
            $.ajax({
                type: "POST",
                url: ajax_url,
                data: data,
                success: function (response) {
                   
                    // var res = JSON.parse(response);
                    // console.log(response);       
                    $('#department').html(response);
    // $('#department').selectpicker('refresh');
    
                }
            });
        }
    
       
       
       
    function ldcalculate() {
        var m_unique_id = document.getElementById('m_unique_id').value;
     var ld_date_type = document.getElementById('ld_date_type').value;
    
     if(!ld_date_type){
        $('#ld_delivery_due_date').val('');
        $('#ld_installation_due_date').val('');
        return;
    
     }
     
        if (!m_unique_id) {
            sweetalert("Please select a valid entry.");
            return;
        }
    
        var data = {
            m_unique_id: m_unique_id,
            action: "get_lddates"
        };
    
        var ajax_url = sessionStorage.getItem("folder_crud_link");
    
        $.ajax({
            type: "POST",
            url: ajax_url,
            data: data,
            success: function (response) {
        try {
            var obj = JSON.parse(response);
    
            if (obj.data && obj.data.length > 0) {
                var firstRow = obj.data[0];
    
                var po_date = firstRow[0];
                var insta_due_days = firstRow[1];
                var delivery_due_dates = firstRow[2];
                var consignee_received_date = firstRow[3];
    
                // Use function to calculate date
                function addDays(dateStr, days) {
                    var date = new Date(dateStr);
                    date.setDate(date.getDate() + parseInt(days));
                    return date.toISOString().split('T')[0];
                }
    
                let valdeliverydate = '';
                let valinstadates = '';
    
                if (ld_date_type == '1') {
                    valdeliverydate = addDays(po_date, delivery_due_dates);
                    valinstadates = addDays(po_date, insta_due_days);
                } else {
                    valdeliverydate = addDays(consignee_received_date, delivery_due_dates);
                    valinstadates = addDays(consignee_received_date, insta_due_days);
                }
    
                $('#ld_delivery_due_date').val(valdeliverydate);
                $('#ld_installation_due_date').val(valinstadates);
    
               
                
                sweetalert("LD data loaded successfully.");
                $('#demos').modal('hide');
            } else {
                sweetalert("No data found.");
            }
        } catch (err) {
            console.error("Invalid JSON or unexpected format", err);
            console.log("Raw response:", response);
            sweetalert("Something went wrong while parsing data.");
        }
    },
    
            error: function () {
                alert("Network Error");
            }
        });
    }
    
    
    
    
    
    
    
    function addDays(dateStr, days) {
        var date = new Date(dateStr);
        date.setDate(date.getDate() + parseInt(days));
        return date.toISOString().split('T')[0]; // gives "YYYY-MM-DD"
    }
    
    
    function other_insurence_types() {
        const selected = $('#insurence_types').val() || [];
        // For debugging
        console.log('Selected:', selected);
    
        if (selected.includes('5')) {
            $('#others_insu_types').show();
        } else {
            $('#others_insu_types').hide();
            $('#other_insurance_type').val('');
        }
    }
    
    
    
        function term_condition() {
           
            var internet_status = is_online();
    
            if (!internet_status) {
                sweetalert("no_internet");
                return false;
            }
           
            var po_no = document.getElementById('mypo').value;
       
    var amc_required = document.getElementById('amc_required').checked ? 'on' : '';
    var insurence_required = document.getElementById('insurence_required').checked ? 'on' : '';
    
    var ld_required = document.getElementById('ld_required').checked ? 'on' : '';
    
    var ld_checked = document.getElementById('ld_required').checked;
    var ld_date_type = document.getElementById('ld_date_type').value;
    var ld_delivery_due_date = document.getElementById('ld_delivery_due_date').value;
           
    var ld_installation_due_date = document.getElementById('ld_installation_due_date').value; 
       
    if (!po_no) {
        Swal.fire({
            icon: 'error',
            title: 'Required',
            text: 'Please fill PO Details',
        });
        return false;
    }
    if(!ld_checked){
        Swal.fire({
            icon: 'error',
            title: 'Required',
            text: 'Please Check LD calculation.',
        });
        return false;
    }
    if (ld_checked) {
        if (!ld_date_type || !ld_delivery_due_date || !ld_installation_due_date) {
            Swal.fire({
                icon: 'error',
                title: 'Required',
                text: 'Please fill all LD fields when LD is required.',
            });
            return false;
        }
    }
    
    
    
    
    
    
       
               var image_s = document.getElementById("po_file");
               var data = new FormData();
              if (image_s != '') {
                for (var i = 0; i < image_s.files.length; i++) {
                    data.append("po_file", document.getElementById('po_file').files[i]);
    
                }
            } else {
                data.append("po_file", '');
            }
              var start_date = document.getElementById('start_date').value;
           
              var end_date = document.getElementById('end_date').value;
           
              var amc_percentae = document.getElementById('amc_percentae').value; 
            
              var amcvalue = document.getElementById('amcvalue').value;
             
    
              var amcpofile = document.getElementById("amcpofile");
               var other_insurance_type = document.getElementById("other_insurance_type").value;
              
            
            
             if (amcpofile != '') {
                for (var i = 0; i < amcpofile.files.length; i++) {
                    data.append("amcpofile", document.getElementById('amcpofile').files[i]);
                   
    
                }
            } else {
                data.append("amcpofile", '');
            }
    
           
            var unique_id = document.getElementById('unique_id').value;
            var demo = document.getElementById('demo').value;
            // var insurence_types = document.getElementById('insurence_types').value;
            // alert(insurence_types);
            var po_unique_id = document.getElementById('po_unique_id').value;
            
        var insurence_types = $('#insurence_types').val(); // array
        var insurence_typesStr = insurence_types ? insurence_types.join(',') : '';
    
        const otherType = $('#other_insurance_type').val();
    
    
    
    
    
    
    
            data.append("insurence_types", insurence_typesStr);
            data.append("po_no", po_no);
             data.append("ld_required", ld_required);
             data.append("ld_delivery_due_date", ld_delivery_due_date);
              data.append("ld_installation_due_date", ld_installation_due_date);
            data.append("other_insurance_type", otherType);
            data.append("insurence_required", insurence_required);
           
             data.append("amc_required", amc_required);
            
            data.append("start_date", start_date);
              data.append("end_date", end_date);
              data.append("amc_percentae", amc_percentae);
                data.append("amcvalue", amcvalue);
    
        data.append("ld_date_type",ld_date_type);
            data.append("demo", demo);
            data.append("po_unique_id", po_unique_id);
            data.append("action", "terms_condition");
    
           
            
            var ajax_url = sessionStorage.getItem("folder_crud_link");
            var url = sessionStorage.getItem("list_link");
            // console.log(data);
            $.ajax({
                type: "POST",
                url: 'folders/po_form/crud.php',
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
               
                success: function (data) {
                    //alert(data);
                    var obj = JSON.parse(data);
                    var msg = obj.msg;
                    var status = obj.status;
                    var error = obj.error;
                    if (!status) {
                        url = '';
                        $(".createupdate_btn").text("Error");
                        console.log(error);
                    }
                    else {
                        if (msg == "already") {
                            // Button Change Attribute
                            url = '';
    
                            $(".createupdate_btn").removeAttr("disabled", "disabled");
                            if (unique_id) {
                                $(".createupdate_btn").text("Update");
                            }
                        }
                    }
                  var url = sessionStorage.getItem("list_link");
                      sweetalert(msg,url);
                    //  $('#amc_datatable').DataTable().ajax.reload(null, false); 
                      $("#start_date").val('');
                    $("#end_date").val('');
                    $("#amc_percentage").val('');
                    $("#amcvalue").val('');
                    $("#amcpofile").val('');
                //   amcsub_list_datatable("#amc_datatable");
                  
                },
                error: function (data) {
                    alert("Network Error");
                }
            });
           
        }
       
       
       
    
    function CalculateTotal() {
        // Get input values
        var qty = parseFloat(document.getElementById('qty').value) || 0;
        var net_price = parseFloat(document.getElementById('net_price').value) || 0; // Price *with* tax
        var tax = parseFloat(document.getElementById('tax').value) || 0;
    
        // Calculate unit price (excluding tax)
        var unit_price = net_price / (1 + tax / 100);
    
        // Calculate total value (gross) = qty * net_price (includes tax)
        var total_value = qty * net_price;
    
        // Calculate tax amount = total_value - value without tax
        var tax_amount = total_value - (qty * unit_price);
    
        // Net value = total - tax (value without tax)
        var net_value = total_value - tax_amount;
    
        // Set results with 2 decimal precision
        document.getElementById('unit_price').value = unit_price.toFixed(2);
        document.getElementById('total_value').value = total_value.toFixed(2);
        document.getElementById('net_value').value = net_value.toFixed(2);
    }
    
    
        $('#qty').on('change', function () {
            // alert("hii");
            CalculateTotal();
    
        });
    
        $('#tax').on('change', function () {
            // alert("hello");
            CalculateTotal();
        });
    
    
    
        function toggleInsRequired() {
            var dcRequired = document.getElementById('dc_required');
            var insRequired = document.getElementById('ins_reqired');
    
            // Enable both if both are checked, else apply usual disable logic
            if (dcRequired.checked && insRequired.checked) {
                dcRequired.disabled = false;
                insRequired.disabled = false;
            } else {
                insRequired.disabled = dcRequired.checked;
            }
        }
    
        function toggleDcRequired() {
            var dcRequired = document.getElementById('dc_required');
            var insRequired = document.getElementById('ins_reqired');
    
            // Enable both if both are checked, else apply usual disable logic
            if (dcRequired.checked && insRequired.checked) {
                dcRequired.disabled = false;
                insRequired.disabled = false;
            } else {
                dcRequired.disabled = insRequired.checked;
            }
        }
    
        // Call these functions on page load to ensure the correct initial state
        window.onload = function () {
            toggleInsRequired();
            toggleDcRequired();
        };
    
        // Add event listeners to handle real-time checking
        document.getElementById('dc_required').addEventListener('change', toggleInsRequired);
        document.getElementById('ins_reqired').addEventListener('change', toggleDcRequired);
    
    
        function validateLandline(input) {
            // Allow only numbers and hyphen (-)
            input.value = input.value.replace(/[^0-9-]/g, '');
    
            // Landline number regex pattern (Format: XXXX-XXXXXXX or XXX-XXXXXXX)
            let landlineRegex = /^[0-9]{3,4}-[0-9]{6,8}$/;
            let errorSpan = document.getElementById("landline_error");
    
            if (!landlineRegex.test(input.value)) {
                errorSpan.innerText = "Enter a valid landline number (e.g., 044-12345678)";
            } else {
                errorSpan.innerText = ""; // Clear error message when valid
            }
        }
    
    var company_name = sessionStorage.getItem("company_name");
    var company_address = sessionStorage.getItem("company_name");
    var company_phone = sessionStorage.getItem("company_name");
    var company_email = sessionStorage.getItem("company_name");
    var company_logo = sessionStorage.getItem("company_name");
    
    var form_name = 'State Creation';
    var form_header = '';
    var form_footer = '';
    var table_name = '';
    var table_id = 'po_form_datatable';
    var action = "datatable";
    
    
    
    function po_form_delete(unique_id = "") {
    
      var ajax_url = sessionStorage.getItem("folder_crud_link");
      var url = sessionStorage.getItem("list_link");
    
      confirm_delete('delete')
        .then((result) => {
          if (result.isConfirmed) {
    
            var data = {
              "unique_id": unique_id,
              "action": "delete"
            }
    
            $.ajax({
              type: "POST",
              url: ajax_url,
              data: data,
              success: function (data) {
    
                var obj = JSON.parse(data);
                var msg = obj.msg;
                var status = obj.status;
                var error = obj.error;
    
                if (!status) {
                  url = '';
    
                } else {
                  init_datatable(table_id, form_name, action);
                }
                sweetalert(msg, url);
              }
            });
    
          } else {
            // alert("cancel");
          }
        });
    }
    
    function print_pdf_2(file_name) {
    
      onmouseover = window.open('uploads/po_form/po_attach/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
    }
    
    
    $(document).ready(function () {
    
    
      $('.dropify').dropify({
        allowedFileExtensions: "pdf xlsx doc docx txt xls ",
        maxFileSize: "5M",
        errorsPosition: "outside",
        error: {
          'fileSize': 'The file size is too big ({{ value }} max).',
          'minWidth': 'The image width is too small ({{ value }}}px min).',
          'maxWidth': 'The image width is too big ({{ value }}}px max).',
          'minHeight': 'The image height is too small ({{ value }}}px min).',
          'maxHeight': 'The image height is too big ({{ value }}px max).',
          'imageFormat': 'The image format is not allowed ({{ value }} only).'
        }
      });
      $('.dropify_img').dropify({
        allowedFileExtensions: "png jpeg jpg",
        maxFileSize: "5M",
        errorsPosition: "outside",
        error: {
          'fileSize': 'The file size is too big ({{ value }} max).',
          'minWidth': 'The image width is too small ({{ value }}}px min).',
          'maxWidth': 'The image width is too big ({{ value }}}px max).',
          'minHeight': 'The image height is too small ({{ value }}}px min).',
          'maxHeight': 'The image height is too big ({{ value }}px max).',
          'imageFormat': 'The image format is not allowed ({{ value }} only).'
        }
      });
    
      // Datatables Bottom Button init
      var a = $("#datatable-buttons").DataTable({
        serverSide: false,
        lengthChange: !1,
        buttons: [{
          extend: "copy",
          className: "btn-light"
        }, {
          extend: "print",
          className: "btn-light"
        }, {
          extend: "pdf",
          className: "btn-light"
        }],
        language: {
          paginate: {
            previous: "<i class='mdi mdi-chevron-left'>",
            next: "<i class='mdi mdi-chevron-right'>"
          }
        },
        drawCallback: function () {
          $(".dataTables_paginate > .pagination").addClass("pagination-rounded")
        }
      });
    });
    
    $.extend($.fn.dataTable.defaults, {
      // searching: false,
      destroy: true,
      stateSave: true,
      ordering: false,
      responsive: true,
      paging: true,
      processing: true,
      serverSide: true,
      searching: false,
      "columnDefs": [
        { "className": "text-center", "targets": [0, -1] }
      ],
      lengthMenu: [
        [10, 25, 50, -1],
        [10, 25, 50, "All"]
      ],
      language: {
        paginate: {
          previous: "<i class='mdi mdi-chevron-left'>",
          next: "<i class='mdi mdi-chevron-right'>"
        },
        processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>',
      },
      
      drawCallback: function () {
        $(".dataTables_paginate > .pagination").addClass("pagination-rounded")
      }
    });
    
    // Form Validity Checking Function
    function form_validity_check(class_name = '', form_name = '') {
    
      var forms = document.getElementsByClassName(class_name);
    
      // If ID based Form validation Needs Not Working
      if (form_name) {
        var forms = document.getElementsByName(form_name);
      }
    
      var formValidity = false;
      var validation = Array.prototype.filter.call(forms, function (form) {
    
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
          formValidity = false;
        } else {
          formValidity = true;
        }
      });
      if (formValidity) {
        return true;
      } else {
        return false;
      }
    }
    
    // Form Validity Checking Function Ends
    
    // Sweet Alert Function Starts
    
    function sweetalert(msg = '', url = '', callback = '', title = '') {
        
    
      switch (msg) {
         
        case "create":
          Swal.fire({
            icon: 'success',
            title: 'Successfully Saved',
            // text: 'Modal with a custom image.',  
            // imageUrl:'img/emoji/success.webp',
            // imageWidth: 250,
            // imageHeight: 200,
            imageAlt: 'Custom image',
            showConfirmButton: true,
            timer: 2500,
            timerProgressBar: true,
            willClose: () => {
              if (url) {
                window.location = url;
              }
            }
          });
          break;
    
        case "update":
          Swal.fire({
            icon: 'success',
            title: 'Successfully Updated',
            // imageUrl:'img/emoji/clapping.webp',
            showConfirmButton: true,
            timer: 2000,
            timerProgressBar: true,
            willClose: () => {
              if (url) {
                window.location = url;
              }
            }
          });
          break;
    
        case "error":
          Swal.fire({
            icon: 'error',
            title: 'Error Occured',
            showConfirmButton: true,
            timer: 2000,
            timerProgressBar: true,
            willClose: () => {
              // alert("Hi");
            }
          });
          break;
    
        case "network_err":
          Swal.fire({
            icon: 'error',
            title: 'Network Error Occured',
            showConfirmButton: true,
            timer: 2000,
            timerProgressBar: true,
            willClose: () => {
              // alert("Hi");
            }
          });
          break;
          case "ld_required":
          Swal.fire({
            icon: 'error',
            title: 'Ld calculation Required',
            showConfirmButton: true,
            timer: 2000,
            timerProgressBar: true,
            willClose: () => {
              // alert("Hi");
            }
          });
          break;
    
        case "e_already":
          Swal.fire({
            icon: 'warning',
            title: 'No of consignee count exceed',
            // imageUrl:'img/emoji/already.webp',
            showConfirmButton: true,
            timer: 2000,
            timerProgressBar: true,
            willClose: () => {
              // alert("Hi");
            }
          });
          break;
    
        case "already":
          Swal.fire({
            icon: 'error',
            title: 'Already Exist',
            // imageUrl:'img/emoji/already.webp',
            showConfirmButton: true,
            timer: 2000,
            timerProgressBar: true,
            willClose: () => {
              // alert("Hi");
            }
          });
          break;
          
          
    
        case "stock":
    
          Swal.fire({
            icon: 'warning',
            title: 'Stock Already Entered',
            // imageUrl:'img/emoji/already.webp',
            showConfirmButton: true,
            timer: 2000,
            timerProgressBar: true,
            willClose: () => {
              // alert("Hi");
            }
          });
          break;
    
        case "exceed":
    
          Swal.fire({
            icon: 'warning',
            title: 'Please Enter Valid Product Qty!..',
            // imageUrl:'img/emoji/already.webp',
            showConfirmButton: true,
            timer: 2000,
            timerProgressBar: true,
            willClose: () => {
    
            }
          });
          break;
    
        case "leave_already":
          Swal.fire({
            icon: 'warning',
            title: 'Cancel the Previous leave request',
            // imageUrl:'img/emoji/already.webp',
            showConfirmButton: true,
            timer: 2000,
            timerProgressBar: true,
            willClose: () => {
              // alert("Hi");
            }
          });
          break;
    
        case "no_internet":
          Swal.fire({
            icon: 'warning',
            title: 'Please Check Your Internet Connection!',
            showConfirmButton: true,
            timer: 2000,
            timerProgressBar: true,
            willClose: () => {
              // alert("Hi");
            }
          });
          break;
    
        case "no_location":
          Swal.fire({
            icon: 'warning',
            title: 'Please Check Your Geo Location!',
            showConfirmButton: true,
            timer: 2000,
            timerProgressBar: true,
            willClose: () => {
              // alert("Hi");
            }
          });
          break;
    
        case "delete":
          return Swal.fire({
            title: 'Are you sure to Delete?',
            text: "You won't be able to revert this!",
            // icon: 'warning',
            // imageUrl:'img/emoji/delete.webp',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            preConfirm: () => {
              return true;
            }
          });
          break;
    
        case "success_delete":
          Swal.fire({
            icon: 'success',
            title: 'Deleted!',
            // imageUrl:'img/emoji/success_delete.webp',
            showConfirmButton: true,
            timer: 1500,
            timerProgressBar: true
          });
          break;
    
        case "form_alert":
          Swal.fire({
            icon: 'info',
            title: 'Fill Out All Mantantory Fields',
            // imageUrl:'img/emoji/form_fill.webp',
            showConfirmButton: true,
            timer: 2000,
            timerProgressBar: true
          })
          break;
    
        case "approve":
          Swal.fire({
            icon: 'success',
            title: 'Successfully Approved',
            showConfirmButton: true,
            timer: 2000,
            willClose: () => {
              window.location = url;
            }
          });
          break;
    
        case "convert":
          Swal.fire({
            icon: 'success',
            title: 'Successfully Converted',
            showConfirmButton: true,
            timer: 2000,
            willClose: () => {
              window.location = url;
            }
          });
          break;
    
        case "add":
          Swal.fire({
            icon: 'success',
            title: 'Successfully Added',
            // imageUrl:'img/emoji/success_delete.webp',
            showConfirmButton: true,
            timer: 2000,
            willClose: () => {
              //   window.location = url;
            }
          });
          break;
    
        case "custom":
          Swal.fire({
            icon: 'info',
            title: title,
            willClose: () => {
    
              if (url != "") {
                window.location = url;
              }
            }
          });
          break;
        case "custom_attendance":
          Swal.fire({
            icon: 'success',
            title: title,
            willClose: () => {
    
              if (url != "") {
                window.location = url;
              }
            }
          });
          break;
        case "custom_mail":
          Swal.fire({
            icon: 'success',
            title: title,
            willClose: () => {
    
              if (url != "") {
                window.location = url;
              }
            }
          });
          break;
        case "password_alert":
          Swal.fire({
            icon: 'info',
            title: 'Please Update either Password Or Profile Image',
            // imageUrl:'img/emoji/form_fill.webp',
            showConfirmButton: true,
            timer: 2000,
            timerProgressBar: true
          })
          break;
        case "gst_alert":
          Swal.fire({
            icon: 'info',
            title: 'Please enter a valid GST Number',
            showConfirmButton: true,
            timer: 4000,
            timerProgressBar: true
          });
          break;
      }
    }
    
    //   Sweet Alert Delete Confirmation Function
    confirm_delete = function (msg) {
      return sweetalert(msg); // <--- return the swal call which returns a promise
    };
    
    //   Sweet Alert Function Ends
    
    // Online Offline Check Function
    
    function is_online() {
      return true;
      // return(navigator.onLine);
      return false;
    }
    
    // GEO Location Check Function
    
    function geo_location() {
      if (!navigator.geolocation) {
        sweetalert("no_location");
        return false;
      }
      return true;
    
    }
    
    function is_online1() {
      if (!navigator.onLine) {
        sweetalert("no_internet");
        return false;
      }
    }
    
    function form_reset(form_class = "", form_name = "", form_id = "") {
    
      if (form_class) {
        $('.' + form_class).find('input').val('');
        $('.' + form_class).find('select').val('');
        $('.' + form_class).find('.select2').val(null).trigger('change');
        $('.' + form_class).find('textarea').val('');
      } else if (form_id) {
        $('#' + form_id).find('input').val('');
        $('#' + form_id).find('select').val('');
        $('#' + form_id).find('.select2').val(null).trigger('change');
        $('#' + form_id).find('textarea').val('');
      }
      // $("#mySelect option[value='']").attr('selected', true)
    }
    
    // From date must be lower than to date
    function fromToDateValidity(fromDate = "", toDate = "") {
      fromDate = new Date(fromDate);
      toDate = new Date(toDate);
    
      // To calculate the time difference of two dates 
      var Difference_In_Time = fromDate.getTime() - toDate.getTime();
    
      // To calculate the no. of days between two dates 
      var Difference_In_Days = Math.ceil(Difference_In_Time / (1000 * 3600 * 24));
    
      // alert(Difference_In_Days);
      if (Difference_In_Days > 0) {
        sweetalert("custom", "", "", "From Date Must be Equal or Lower than To Date");
        return false;
      }
    
      return true;
    }
    
    
    // function Indian Money Format
    
    function indianMoneyFormat(value = "") {
    
      value = Number(value);
    
      if (isNaN(value)) {
        value = 0;
      }
    
      return (value).toFixed(2).replace(/(\d)(?=(\d{2})+\d\.)/g, '$1,');
    
    }
    
    function number_only(event) {
    
      if ((event.keyCode < 46) || (event.keyCode > 57)) event.returnValue = false;
    
    }
    
    function same_item_repeat_validation(input_name = "", input_id = "", input_value = "") {
    
      var input_name = document.getElementsByName(input_name);
    
      input_name.forEach(insert_arr);
    
      function insert_arr(data) {
    
        if ((data.value == input_value) && (data.id != input_id)) {
    
          sweetalert("custom", "", "", "Already  Exist in List");
          $("#" + input_id).val(null).trigger("change");
          return false;
        }
      }
    }
    
    // Geolocation Enable check
    function getLocation() {
      if (navigator.geolocation) {
    
        navigator.geolocation.getCurrentPosition(showPosition, showError);
    
      } else {
    
        alert("This form Needs Location Permission! Please allow to continue");
        // document.getElementById('show_locaiton').innerHTML = "Geolocation is not supported by this browser.";
    
      }
    }
    
    function showPosition(position) {
    
      document.getElementById('latitude').value = position.coords.latitude;
      document.getElementById('longitude').value = position.coords.longitude;
    
    }
    
    function showError(error) {
      switch (error.code) {
        case error.PERMISSION_DENIED:
          x.innerHTML = "User denied the request for Geolocation."
          break;
        case error.POSITION_UNAVAILABLE:
          x.innerHTML = "Location information is unavailable."
          break;
        case error.TIMEOUT:
          x.innerHTML = "The request to get user location timed out."
          break;
        case error.UNKNOWN_ERROR:
          x.innerHTML = "An unknown error occurred."
          break;
      }
    }
    
    function print_image(file_name, folder_name = "bids_management") {
      var url = 'uploads/' + folder_name + '/' + file_name;
      onmouseover = window.open(url, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
    }
    
    
    
    function minute_to_time(min = 0) {
      let time = "00:00";
      if (min) {
        hour = parseInt(min / 60);
        min = min - (hour * 60);
        min = pad(min, 2);
        hour = pad(hour, 2);
        time = hour + ":" + min;
      }
      return time;
    }
    
    function pad(num, size) {
      num = num.toString();
      while (num.length < size) num = "0" + num;
      return num;
    }
    
    
    
    
    function number_only(input) {
    
      const allowedChars = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9','.',','
       ];
      
      // Filter out characters that are not in the allowedChars array
      input.value = input.value.split('').filter(char => allowedChars.includes(char)).join('');
      }
      
      function dec_number(input) {
      
      const allowedChars = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9','.'];
      
      // Filter out characters that are not in the allowedChars array
      input.value = input.value.split('').filter(char => allowedChars.includes(char)).join('');
      }
      
      function password(input) {
      
      const allowedChars = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9','.'];
      
      // Filter out characters that are not in the allowedChars array
      input.value = input.value.split('').filter(char => allowedChars.includes(char)).join('');
      }
      
      function valid_aadhar_number(input) {
      
      const allowedChars = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9',
       ];
      
      // Filter out characters that are not in the allowedChars array
      input.value = input.value.split('').filter(char => allowedChars.includes(char)).join('');
      }
      
      function valid_mobile_number(input) {
      const allowedChars = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
      const validStartingChars = ['6', '7', '8', '9'];
      
      // Check if the first character is valid
      if (input.value.length > 0 && !validStartingChars.includes(input.value.charAt(0))) {
        var msg = "number_alert"
        sweetalert(msg);
        // Clear the input if the first character is invalid
        input.value = '';
        return;
      }
      
      // Filter out characters that are not in the allowedChars array
      input.value = input.value.split('').filter(char => allowedChars.includes(char)).join('');
      }
      
      function off_id(input) {
      
      const allowedChars = [' ', 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
        'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z','-','_',
        '0', '1', '2', '3', '4', '5', '6', '7', '8', '9',
      ];
      
      // Filter out characters that are not in the allowedChars array
      input.value = input.value.split('').filter(char => allowedChars.includes(char)).join('');
      }
      
      function description_val(input) {
      
      const allowedChars = [
       'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
       'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
        ' ', ',', '.'];
      
      // Filter out characters that are not in the allowedChars array
      input.value = input.value.split('').filter(char => allowedChars.includes(char)).join('');
      }
      
      function mail_valid(input) {
      
      const allowedChars = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9',
       'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
       'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
        ' ', '_', '.','@'];
      
      // Filter out characters that are not in the allowedChars array
      input.value = input.value.split('').filter(char => allowedChars.includes(char)).join('');
      }
      
      function validateCharInput(input) {
      
      const allowedChars = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9',
       'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
       'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
        ' ', ',', '.', '!', '-', '/', '_', '@'];
      
      // Filter out characters that are not in the allowedChars array
      input.value = input.value.split('').filter(char => allowedChars.includes(char)).join('');
      }
      
      function valid_address(input) {
      
      const allowedChars = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9',
       'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
       'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
        ' ', ',', '.','-', '/'];
      
      // Filter out characters that are not in the allowedChars array
      input.value = input.value.split('').filter(char => allowedChars.includes(char)).join('');
      }
      
      function valid_user_name(input) {
      
      const allowedChars = [' ', 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
        'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',' '
      ];
      
      // Filter out characters that are not in the allowedChars array
      input.value = input.value.split('').filter(char => allowedChars.includes(char)).join('');
      }
    
      function valid_landline_number(input) {
        const allowedChars = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '-'];
    
        // Filter out characters that are not in the allowedChars array
        input.value = input.value.split('').filter(char => allowedChars.includes(char)).join('');
    }
    
      
      function valid_password(input) {
      
      const allowedChars = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9',
       'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
       'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
        ' ', ',', '.','-','@','#','$','&','*', '/'];
      
      // Filter out characters that are not in the allowedChars array
      input.value = input.value.split('').filter(char => allowedChars.includes(char)).join('');
      }
    
    function print_pdf_1(file_name) {
        
      onmouseover = window.open('uploads/po_form/po_attach/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
    }
    
    function print_pdf_2(file_name) {
    
      onmouseover = window.open('uploads/po_form/po_attach/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
    }
    
    
     
    
  
  $(document).ready(function() {
      alert('hi');
          
         var po_attach_file = $('#po_attach_file').val(); // Correct selector
  
  if (po_attach_file !== '') {
      $('#po_attach_view').show(); // Correct jQuery usage
  }
          
      $('#test_demos').DataTable({
          scrollX: true,
          scrollY: '400px',
          scrollCollapse: true,
          paging: true,
          dom: 'Bfrtip',
          buttons: [
              {
                  extend: 'excelHtml5',
                  title: 'Consignee List'
              },
              {
                  extend: 'csvHtml5',
                  title: 'Consignee List'
              },
              {
                  extend: 'pdfHtml5',
                  title: 'Consignee List'
              },
              {
                  extend: 'print',
                  title: 'Consignee List'
              }
          ]
      });
  });
  
   function print_pdf_po(file_name)
  {
      
   onmouseover=window.open('uploads/amc/' + file_name,'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
  }
  
  
   function print_pdf_amc(file_name)
  {
      
   onmouseover=window.open('uploads/amc/' + file_name,'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
  }
  
  
  
  function number_only(input) {
  
  const allowedChars = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9','.',','
   ];
  
  // Filter out characters that are not in the allowedChars array
  input.value = input.value.split('').filter(char => allowedChars.includes(char)).join('');
  }
  
  function dec_number(input) {
  
  const allowedChars = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9','.'];
  
  // Filter out characters that are not in the allowedChars array
  input.value = input.value.split('').filter(char => allowedChars.includes(char)).join('');
  }
  
  function password(input) {
  
  const allowedChars = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9','.'];
  
  // Filter out characters that are not in the allowedChars array
  input.value = input.value.split('').filter(char => allowedChars.includes(char)).join('');
  }
  
  function valid_aadhar_number(input) {
  
  const allowedChars = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9',
   ];
  
  // Filter out characters that are not in the allowedChars array
  input.value = input.value.split('').filter(char => allowedChars.includes(char)).join('');
  }
  
  function valid_mobile_number(input) {
  const allowedChars = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
  const validStartingChars = ['6', '7', '8', '9'];
  
  // Check if the first character is valid
  if (input.value.length > 0 && !validStartingChars.includes(input.value.charAt(0))) {
    var msg = "number_alert"
    sweetalert(msg);
    // Clear the input if the first character is invalid
    input.value = '';
    return;
  }
  
  // Filter out characters that are not in the allowedChars array
  input.value = input.value.split('').filter(char => allowedChars.includes(char)).join('');
  }
  
  function off_id(input) {
  
  const allowedChars = [' ', 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
    'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z','-','_',
    '0', '1', '2', '3', '4', '5', '6', '7', '8', '9',
  ];
  
  // Filter out characters that are not in the allowedChars array
  input.value = input.value.split('').filter(char => allowedChars.includes(char)).join('');
  }
  
  function description_val(input) {
  
  const allowedChars = [
   'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
   'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
    ' ', ',', '.'];
  
  // Filter out characters that are not in the allowedChars array
  input.value = input.value.split('').filter(char => allowedChars.includes(char)).join('');
  }
  
  function mail_valid(input) {
  
  const allowedChars = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9',
   'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
   'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
    ' ', '_', '.','@'];
  
  // Filter out characters that are not in the allowedChars array
  input.value = input.value.split('').filter(char => allowedChars.includes(char)).join('');
  }
  
  function validateCharInput(input) {
  
      alert();
  const allowedChars = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9',
   'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
   'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
    ' ', ',', '.', '!', '-', '/', '_', '@'];
  
  // Filter out characters that are not in the allowedChars array
  input.value = input.value.split('').filter(char => allowedChars.includes(char)).join('');
  }
  
  function valid_address(input) {
  
  const allowedChars = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9',
   'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
   'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
    ' ', ',', '.','-', '/'];
  
  // Filter out characters that are not in the allowedChars array
  input.value = input.value.split('').filter(char => allowedChars.includes(char)).join('');
  }
  
  function valid_user_name(input) {
  
  const allowedChars = [' ', 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
    'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',' '
  ];
  
  // Filter out characters that are not in the allowedChars array
  input.value = input.value.split('').filter(char => allowedChars.includes(char)).join('');
  }
  
  function valid_landline_number(input) {
  const allowedChars = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '-'];
  
  // Filter out characters that are not in the allowedChars array
  input.value = input.value.split('').filter(char => allowedChars.includes(char)).join('');
  }
  
  
  function valid_password(input) {
  
  const allowedChars = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9',
   'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
   'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
    ' ', ',', '.','-','@','#','$','&','*', '/'];
  
  // Filter out characters that are not in the allowedChars array
  input.value = input.value.split('').filter(char => allowedChars.includes(char)).join('');
  }
  
  function print_pdf_1(file_name) {
  
  onmouseover = window.open('uploads/po_form/po_attach/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
  }
  
  function print_pdf_2(file_name) {
  
  onmouseover = window.open('uploads/po_form/po_attach/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
  }