
$(document).ready(function () {
  get_data();
  get_comdata();
  var team_mems = document.getElementById('team_mem').value;


  if (team_mems != '') {

    get_list();
    get_list1();
  }


});



var company_name = sessionStorage.getItem("company_name");
var company_address = sessionStorage.getItem("company_name");
var company_phone = sessionStorage.getItem("company_name");
var company_email = sessionStorage.getItem("company_name");
var company_logo = sessionStorage.getItem("company_name");

var form_name = 'Installation Creation';
var form_header = '';
var form_footer = '';
var table_name = '';

var table_id = 'installation_datatable';
var comtable_id = 'installation_completeddatatable';
var comaction = "comdatatable";
var dc_ir_dispatch_comdatatable = 'dc_ir_dispatch_comdatatable';
var action = "datatable";



function get_list() {
  var team_mems = document.getElementById('team_mem').value;
  if (team_mems != '') {

    var team_mem = '';
  } else {
    var team_mem = team_mems;
  }

  init_datatable(table_id, form_name, action);


}
function get_list1() {

  var team_mem = document.getElementById('team_mem1').value;
  var team_mems = document.getElementById('team_mem').value;

  //alert(team_mem);
  if (team_mems != '') {

    var team_mem = '';
  } else {
    var team_mem = team_mems;
  }

  sub_list_datatable(dc_ir_dispatch_datatable, form_name, dc_ir_dispatch_datatable);
  sub_list_comdatatable(dc_ir_dispatch_comdatatable, form_name, dc_ir_dispatch_comdatatable);


}

function get_data() {
  init_datatable(table_id, form_name, action);

}
function get_comdata() {

  init_comdatatable(comtable_id, form_name, comaction);
}

function get_data_dc() {

  sub_list_datatable(dc_ir_dispatch_datatable, form_name, dc_ir_dispatch_datatable);

}
function get_data_comdc() {

  sub_list_comdatatable(dc_ir_dispatch_comdatatable, form_name, dc_ir_dispatch_comdatatable);

}
// get_data_install



function installation_cu(unique_id = "") {


  // alert('cu');
  var internet_status = is_online();

  if (!internet_status) {

    sweetalert("no_internet");
    return false;
  }


  var doc_required_status = $("#doc_required_status").val();
  // alert(doc_required_status);

  // alert(doc_required_status);
  var dc_number = document.getElementById('dc_number').value;
  // alert(dc_number);
  var sess_id = document.getElementById('sess_id').value;
  // alert(sess_id);

  if ((sess_id === '5ff562ed542d625323') || (sess_id === '65deef78ba17d65741')) {

    // alert('admin');
    var in_charge = document.getElementById('rate').value;
    var gst = document.getElementById('gst').value;
    var ttl_amount = document.getElementById('ttl_amnt').value;

    var engg_type = document.getElementById('engg_type').value;


    //   alert(engg_type);
    //   if(engg_type == 'outsource-vendor'){
    //     // alert('if');
    //       document.getElementById('engg_type').value = '2';
    //   }
    //   else if(engg_type == 'own-engineer'){
    //                 document.getElementById('engg_type').value = '1';

    //   }

    // alert(engg_type);

    // engg_type = document.getElementById('engg_type').value;

    // alert(engg_type);
    var engineer_name = document.getElementById('engineer_name').value;
    var ins_com_date = document.getElementById('date').value;

  }


  else {

    var in_charge = document.getElementById('rate_vendor').value;
    var gst = document.getElementById('gst_vendor').value;
    var ttl_amount = document.getElementById('ttl_amnt_vendor').value;

    var engg_type = document.getElementById('vendor_engg_type').value;

    //          if(engg_type == 'outsource-vendor'){
    //     // alert('if');
    //       document.getElementById('engg_type').value = '2';
    //   }
    //   else if(engg_type == 'own-engineer'){
    //                 document.getElementById('engg_type').value = '1';

    //   }

    // // alert(engg_type);

    // engg_type = document.getElementById('engg_type').value;


    var engineer_name = document.getElementById('vendor_eng_name').value;
    var ins_com_date = document.getElementById('date1').value;




  }


  if (doc_required_status === '2') {


    // alert('2');

    var po_num = document.getElementById('po_num').value;
    var po_unique_id = document.getElementById('po_unique_id').value;
    var po_form_unique_id = document.getElementById('po_form_unique_id').value;
    var po_date = document.getElementById('po_date').value;
    var invoice_auto_id = document.getElementById('invoice_auto_id').value;

    // alert(invoice_auto_id);
    var invoice_no = document.getElementById('invoice_no').value;

    var invoice_date = document.getElementById('invoice_date').value;
    var consignee_unique_id = document.getElementById('consignee_unique_id').value;

    // alert(consignee_unique_id);


    var dc_received_sts = document.getElementById('dc_received_sts').value;

    // alert(dc_received_sts);

    var dc_cus_signed_date = document.getElementById('dc_cus_signed_date').value;
    var ir_rec_status = document.getElementById('ir_rec_status').value;
    var ir_cus_signed_date = document.getElementById('ir_cus_signed_date').value;


    var snr_rec_status = document.getElementById('snr_rec_status').value;
    var snr_cus_signed_date = document.getElementById('snr_cus_signed_date').value;


    var unique_id = document.getElementById('unique_id').value;


    var documents_type = document.getElementById('documents_type');
    if (documents_type.checked) {
      var dc_checkbox = 'DC';
    } else {
      var dc_checkbox = '0';
    }

    var documents_type1 = document.getElementById('documents_type1');
    if (documents_type1.checked) {
      var ir_checkbox = 'IR';
    } else {
      var ir_checkbox = '0';
    }



    var documents_type2 = document.getElementById('documents_type2');
    if (documents_type2.checked) {
      var snr_checkbox = 'SNR';
    } else {
      var snr_checkbox = '0';
    }


    var dc = document.getElementById("documents_type");
    var ir = document.getElementById("documents_type1");
    var snr = document.getElementById("documents_type2");


    if ((ir.checked || snr.checked) && !dc.checked) {
      Swal.fire({
        icon: 'info',
        title: 'DC is required along with IR or SNR',
        confirmButtonText: 'OK',
      });
      return;
    }

    // if (dc.checked && !ir.checked && !snr.checked) {
    //     Swal.fire({
    //         icon: 'info',
    //         title: 'IR or SNR is required along with DC',
    //         confirmButtonText: 'OK',
    //     });
    //     return;
    // }

    var test_doc = document.getElementById('dc_file').value;
    var test_doc1 = document.getElementById('ir_file').value;
    var test_doc2 = document.getElementById('snr_file').value;


    var image_s = document.getElementById("dc_file");

    var image_ir = document.getElementById("ir_file");
    var image_in = document.getElementById("snr_file");


    var data = new FormData();
    if (image_s != '') {
      if (image_s.files) {
        for (var i = 0; i < image_s.files.length; i++) {
          data.append("test_file[]", document.getElementById('dc_file').files[i]);
        }
      }
    } else {

      data.append("test_doc", '');

    }

    if (image_ir != '') {
      if (image_ir.files) {
        for (var i = 0; i < image_ir.files.length; i++) {
          data.append("test_file1[]", document.getElementById('ir_file').files[i]);
        }
      }
    } else {

      data.append("test_doc1", '');

    }



    if (image_in != '') {
      if (image_in.files) {
        for (var i = 0; i < image_in.files.length; i++) {
          data.append("test_file2[]", document.getElementById('snr_file').files[i]);
        }
      }
    } else {

      data.append("test_doc2", '');

    }



    if (!dc_received_sts && ir_rec_status && snr_rec_status) {
      Swal.fire({
        icon: 'info',
        title: 'DC is required with IR or SNR',
        confirmButtonText: 'OK',
      });
      return;
    }


    if (!dc_received_sts && ir_rec_status) {
      Swal.fire({
        icon: 'info',
        title: 'DC is required with IR',
        confirmButtonText: 'OK',
      });
      return;
    }

    if (dc.checked && ir.checked) {

      if (!dc_received_sts || !ir_rec_status) {
        Swal.fire({
          icon: 'info',
          title: 'Fill out Required Fields',
          confirmButtonText: 'OK',
        });
        return;
      }
    }

    if (dc.checked && snr.checked) {

      if (!dc_received_sts || !snr_rec_status) {
        Swal.fire({
          icon: 'info',
          title: 'Fill out Required Fields',
          confirmButtonText: 'OK',
        });
        return;
      }


      if (dc_received_sts && !snr_rec_status) {
        Swal.fire({
          icon: 'info',
          title: 'DC is required with IR',
          confirmButtonText: 'OK',
        });
        return;
      }


      if (!dc_received_sts && snr_rec_status) {


        Swal.fire({
          icon: 'info',
          title: 'DC is required with SNR',
          confirmButtonText: 'OK',
        });
        return;
      }
    }






    if (dc_received_sts && (ir_rec_status || snr_rec_status)) {
      // submit the form or continue
    }




    data.append("po_num", po_num);
    data.append("po_form_unique_id", po_form_unique_id);
    data.append("po_unique_id", po_unique_id);
    data.append("po_date", po_date);
    data.append("invoice_auto_id", invoice_auto_id);
    data.append("invoice_no", invoice_no);
    data.append("invoice_date", invoice_date);
    data.append("consignee_unique_id", consignee_unique_id);
    data.append("engineer_name", engineer_name);
    data.append("ins_com_date", ins_com_date);
    data.append("in_charge", in_charge);
    data.append("gst", gst);
    data.append("ttl_amount", ttl_amount);
    data.append("engg_type", engg_type);
    data.append("dc_number", dc_number);
    data.append("documents_type", dc_checkbox);


    data.append("documents_type1", ir_checkbox);
    data.append("documents_type2", snr_checkbox);


    data.append("dc_received_sts", dc_received_sts);
    data.append("dc_cus_signed_date", dc_cus_signed_date);
    data.append("ir_rec_status", ir_rec_status);
    data.append("ir_cus_signed_date", ir_cus_signed_date);
    data.append("snr_rec_status", snr_rec_status);
    data.append("snr_cus_signed_date", snr_cus_signed_date);


    data.append("unique_id", unique_id);

    data.append("action", "createupdate");

    var ajax_url = sessionStorage.getItem("folder_crud_link");
    var url = sessionStorage.getItem("list_link");
    
    // console.log(data);
    $.ajax({
      type: "POST",
      url: ajax_url,
      data: data,
      cache: false,
      contentType: false,
      processData: false,
      method: 'POST',
      beforeSend: function () {

      },

      success: function (data) {

        var obj = JSON.parse(data);
        var msg = obj.msg;
        var status = obj.status;
        var error = obj.error;

        // if (obj.status) {
        // var form_unique_id = document.getElementById('form_unique_id').value;
          var form_unique_id = obj.form_unique_id;
        installation_creation_sub(form_unique_id);
    // }

        if (!status) {
          url = '';
          $(".createupdate_btn").text("Error");

        } else {


          if (msg == "already") {

            url = '';

            $(".createupdate_btn").removeAttr("disabled", "disabled");
            if (unique_id) {
              $(".createupdate_btn").text("Update");
            } else {
              $(".createupdate_btn").text("Save");
            }
          }
        }


        // installation_creation_sub();
        // sweetalert(msg, url);




      },
      error: function (data) {
        alert("Network Error");
      }

    });



  }

  else if (doc_required_status === '1') {

    // alert('dc');

    var po_num = document.getElementById('po_num').value;
    var po_unique_id = document.getElementById('po_unique_id').value;
    var po_form_unique_id = document.getElementById('po_form_unique_id').value;
    var po_date = document.getElementById('po_date').value;
    var invoice_auto_id = document.getElementById('invoice_auto_id').value;
    // alert(invoice_auto_id);
    var invoice_no = document.getElementById('invoice_no').value;

    var invoice_date = document.getElementById('invoice_date').value;
    var consignee_unique_id = document.getElementById('consignee_unique_id').value;

    var admin = document.getElementById('admin').value;
    // alert(admin);
    if (admin) {
      var ins_com_date = document.getElementById('date').value;

    }
    else {
      var ins_com_date = document.getElementById('date1').value;

    }

    var dc_received_sts = document.getElementById('dc_received_sts').value;
    var dc_cus_signed_date = document.getElementById('dc_cus_signed_date').value;


    var documents_type = document.getElementById('documents_type');

    var dc_required = '1';
    // alert(documents_type);
    if (documents_type.checked) {

      var dc_checkbox = 'DC';
    } else {
      var dc_checkbox = '0';
    }



    var test_doc = document.getElementById('dc_file').value;

    var image_s = document.getElementById("dc_file");


    var data = new FormData();
    if (image_s != '') {
      if (image_s.files) {
        for (var i = 0; i < image_s.files.length; i++) {
          data.append("test_file[]", document.getElementById('dc_file').files[i]);
        }
      }
    } else {

      data.append("test_doc", '');

    }




    if (!dc_received_sts) {
      // alert('dc');
      Swal.fire({
        icon: 'info',
        title: 'Fill out the Required Fields',
        confirmButtonText: 'OK',
      });
      return;
    }



    data.append("po_num", po_num);

    data.append("dc_required", dc_required);
    data.append("po_form_unique_id", po_form_unique_id);
    data.append("po_unique_id", po_unique_id);
    data.append("po_date", po_date);
    data.append("invoice_auto_id", invoice_auto_id);
    data.append("invoice_no", invoice_no);
    data.append("invoice_date", invoice_date);
    data.append("consignee_unique_id", consignee_unique_id);
    data.append("engineer_name", engineer_name);
    data.append("ins_com_date", ins_com_date);
    data.append("in_charge", in_charge);
    data.append("gst", gst);
    data.append("ttl_amount", ttl_amount);
    data.append("engg_type", engg_type);
    data.append("dc_number", dc_number);
    data.append("documents_type", dc_checkbox);


    // data.append("documents_type1", ir_checkbox);
    // data.append("documents_type2", snr_checkbox);


    data.append("dc_received_sts", dc_received_sts);
    data.append("dc_cus_signed_date", dc_cus_signed_date);
    // data.append("ir_rec_status", ir_rec_status);
    // data.append("ir_cus_signed_date", ir_cus_signed_date);
    // data.append("snr_rec_status", snr_rec_status);
    //  data.append("snr_cus_signed_date", snr_cus_signed_date);


    data.append("unique_id", unique_id);

    data.append("action", "createupdate");

    var ajax_url = sessionStorage.getItem("folder_crud_link");
    var url = sessionStorage.getItem("list_link");
    // console.log(data);
    $.ajax({
      type: "POST",
      url: ajax_url,
      data: data,
      cache: false,
      contentType: false,
      processData: false,
      method: 'POST',
      beforeSend: function () {

      },

      success: function (data) {

        var obj = JSON.parse(data);
        var msg = obj.msg;
        var status = obj.status;
        var error = obj.error;
 
        // var form_unique_id = document.getElementById('form_unique_id').value;
          var form_unique_id = obj.form_unique_id;
        installation_creation_sub(form_unique_id);

        if (!status) {
          url = '';
          $(".createupdate_btn").text("Error");

        } else {


          if (msg == "already") {

            url = '';

            $(".createupdate_btn").removeAttr("disabled", "disabled");
            if (unique_id) {
              $(".createupdate_btn").text("Update");
            } else {
              $(".createupdate_btn").text("Save");
            }
          }
        }


        // installation_creation_sub();
        // sweetalert(msg, url);





      },
      error: function (data) {
        alert("Network Error");
      }

    });



  }




}



function installation_delete(dc_number = "") {

  var ajax_url = sessionStorage.getItem("folder_crud_link");

  confirm_delete('delete')
    .then((result) => {
      if (result.isConfirmed) {

        var data = {
          "dc_number": dc_number,
          "action": "installation_delete"
        };

        $.ajax({
          type: "POST",
          url: ajax_url,
          data: data,
          success: function (data) {

            var obj = JSON.parse(data);

            var msg = obj.msg;
            var status = obj.status;

            if (status) {
              init_datatable(table_id, form_name, action);
            }

            sweetalert(msg);
          }
        });

      }
    });
}


function init_datatable(table_id = '', form_name = '', action = '') {
  // alert();

  var table = $("#" + table_id);

  var installation_status = $("#installation_status").val();
  //   alert(installation_status);
  var from_date = $("#from_date").val();
  //   alert(from_date);
  var to_date = $("#to_date").val();
  var con_district = $('#con_district').val();
  //   alert(con_district);

  // alert(department);
  var team_mem = $('#team_mem').val();

  var engg_type = $('#engineer_type').val();
  //   alert();
  var screen_id_val = $('#screen_id_val').val();

  // 	alert(screen_id_val);
  var user_type_unique_id = $('#user_type_unique_id').val();
  // 	alert(user_type_unique_id);

  var opt = $("#opt").val();
  //   alert(opt);
  var data = {
    "installation_status": installation_status,
    "action": action,
    "from_date": from_date,
    "to_date": to_date,
    "team_mem": team_mem,
    "con_district": con_district,
    "engg_type" : engg_type,


    "opt": opt,
    "screen_id_val": screen_id_val,
    "user_type_unique_id": user_type_unique_id,
  };
  var ajax_url = sessionStorage.getItem("folder_crud_link");

  var datatable = table.DataTable({
    destroy: true, //new line
    ordering: true,
    searching: true,
    stateSave:true,
    "ajax": {
      url: ajax_url,
      type: "POST",
      data: data
    },
    columnDefs: [
      {
        targets: 6,
        createdCell: function (td, cellData, rowData, row, col) {
          $(td).css('text-align', 'right');
        }
      }
    ],
    dom: '<"dt-top-container"<l><"dt-center-in-div"B><f>r>t<ip>',
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
  $('#columnVisibilityForm').on('change', 'input[type="checkbox"]', function () {
    var columnIdx = $(this).data('column');
    var isVisible = $(this).is(':checked');
    datatable.column(columnIdx).visible(isVisible); // Use datatable instead of table
  });
}





function init_comdatatable(table_id = '', form_name = '', action = '') {

  // alert('test');
  var table = $("#" + table_id);

  var installation_status = $("#com_installation_status").val();
  var from_date = $("#com_from_date").val();
  var to_date = $("#com_to_date").val();
  var con_district = $('#com_con_district').val();
  var team_mem = $('#com_team_mem').val();
  var screen_id_val = $('#screen_id_val').val();

  var user_type_unique_id = $('#user_type_unique_id').val();

  var opt = $("#com_opt").val();

   var engg_type = $("#engineer_type2").val();
  //  alert(engg_type);
  var data = {
    "installation_status": installation_status,
    "action": action,
    "from_date": from_date,
    "to_date": to_date,
    "team_mem": team_mem,
    "con_district": con_district,
    "engg_type": engg_type,


    "opt": opt,
    "screen_id_val": screen_id_val,
    "user_type_unique_id": user_type_unique_id,
  };
  var ajax_url = sessionStorage.getItem("folder_crud_link");

  var datatable = table.DataTable({
    destroy: true, //new line
    ordering: true,
    searching: true,
    stateSave:true,
    "ajax": {
      url: ajax_url,
      type: "POST",
      data: data
    },
    columnDefs: [
      {
        targets: 6,
        createdCell: function (td, cellData, rowData, row, col) {
          $(td).css('text-align', 'right');
        }
      }
    ],
    dom: '<"dt-top-container"<l><"dt-center-in-div"B><f>r>t<ip>',
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
  $('#columnVisibilityForm').on('change', 'input[type="checkbox"]', function () {
    var columnIdx = $(this).data('column');
    var isVisible = $(this).is(':checked');
    datatable.column(columnIdx).visible(isVisible); // Use datatable instead of table
  });
}





function sub_list_datatable(table_id = "", form_name = "", action = "") {
  //   alert('hii');
  // var form_main_unique_id = $("#demo").val();
  var table_id = 'dc_ir_dispatch_datatable';
  // alert(table_id);
  var table = $("#" + table_id);
  var from_date = $("#from_date_dc").val();
  var to_date = $("#to_date_dc").val();
  var opt1 = $("#dc_ir_opt1").val();
  var dc_delivery_status = $("#dc_delivery_status").val();
  var con_district = $('#con_district_dc').val();
  var screen_id_val = $('#screen_id_val').val();
  var team_mem = $('#team_mem1').val();
  // alert(screen_id_val);
  var user_type_unique_id = $('#user_type_unique_id').val();

  var engg_type = $('#engineer_type3').val();


  var data = {
    "dc_delivery_status": dc_delivery_status,
    "con_district": con_district,
    "action": 'dc_ir_dispatch_datatable',
    "from_date": from_date,
    "to_date": to_date,
    "opt1": opt1,
    "engg_type":engg_type,
    "team_mem": team_mem,
    "screen_id_val": screen_id_val,
    "user_type_unique_id": user_type_unique_id,
  };

  var ajax_url = sessionStorage.getItem("folder_crud_link");

  var datatable = table.DataTable({
    destroy: true, //new line
    ordering: true,
    searching: true,
    stateSave:true,
    "ajax": {
      url: ajax_url,
      type: "POST",
      data: data
    },
    columnDefs: [
      {
        targets: 6,
        createdCell: function (td, cellData, rowData, row, col) {
          $(td).css('text-align', 'right');
        }
      }
    ],
    dom: 'Bfrtip',
    // buttons: [
    //     'copy', 'csv', 'excel', 'pdf', 'print'
    // ]
    dom: '<"dt-top-container"<l><"dt-center-in-div"B><f>r>t<ip>',
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
  $('#columnVisibilityForm').on('change', 'input[type="checkbox"]', function () {
    var columnIdx = $(this).data('column');
    var isVisible = $(this).is(':checked');
    datatable.column(columnIdx).visible(isVisible); // Use datatable instead of table
  });
}



function sub_list_comdatatable(table_id = "", form_name = "", action = "") {
  //   alert('hii');
  // var form_main_unique_id = $("#demo").val();
  var table_id = 'dc_ir_dispatch_comdatatable';
  // alert(table_id);
  var table = $("#" + table_id);
  var from_date = $("#com_from_date_dc").val();
  var to_date = $("#com_to_date_dc").val();
  var opt1 = $("#com_opt1").val();
  var dc_delivery_status = $("#com_dc_delivery_status").val();
  var con_district = $('#com_con_district_dc').val();
  var screen_id_val = $('#screen_id_val').val();
  var team_mem = $('#com_team_mem1').val();
  // alert(screen_id_val);
  var user_type_unique_id = $('#user_type_unique_id').val();

  var engg_type = $('#engineer_type4').val();


  var data = {
    "dc_delivery_status": dc_delivery_status,
    "con_district": con_district,
    "action": 'dc_ir_dispatch_comdatatable',
    "from_date": from_date,
    "to_date": to_date,
    "opt1": opt1,
    "engg_type":engg_type,
    "team_mem": team_mem,
    "screen_id_val": screen_id_val,
    "user_type_unique_id": user_type_unique_id,
  };

  var ajax_url = sessionStorage.getItem("folder_crud_link");

  var datatable = table.DataTable({
    destroy: true, //new line
    ordering: true,
    searching: true,
    stateSave:true,
    "ajax": {
      url: ajax_url,
      type: "POST",
      data: data
    },
    columnDefs: [
      {
        targets: 6,
        createdCell: function (td, cellData, rowData, row, col) {
          $(td).css('text-align', 'right');
        }
      }
    ],
    dom: 'Bfrtip',
    // buttons: [
    //     'copy', 'csv', 'excel', 'pdf', 'print'
    // ]
    dom: '<"dt-top-container"<l><"dt-center-in-div"B><f>r>t<ip>',
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
  $('#columnVisibilityForm').on('change', 'input[type="checkbox"]', function () {
    var columnIdx = $(this).data('column');
    var isVisible = $(this).is(':checked');
    datatable.column(columnIdx).visible(isVisible); // Use datatable instead of table
  });
}


function state_creation_delete(unique_id = "") {

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

function get_under_user_type_ids() {
  var under_user_type = $('#under_user_type_name').val();
  $('#under_user_type').val(under_user_type);
}

function get_under_user_type(user_type = "") {

  $("#under_user_type_name").html('');
  var ajax_url = sessionStorage.getItem("folder_crud_link");

  if (staff_id) {
    var data = {
      "user_type": user_type,
      "action": "user_type_options"
    }

    $.ajax({
      type: "POST",
      url: ajax_url,
      data: data,
      success: function (data) {

        if (data) {
          $("#under_user_type_name").html(data);
        }

      }
    });
  }
}


function print(file_name) {
  // 
  window.location = 'uploads/invoice/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no';
}
function print_pdf(file_name) {

  onmouseover = window.open('uploads/invoice/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
}

function ins_print_pdf(file_name) {

  onmouseover = window.open('uploads/installation/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
}


// function print(file_name) {
//     onmouseover = window.open('uploads/kra_kpi_form/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
// }
function print_view(file_name) {
  // window.location
  window.open('uploads/invoice/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
}


function print_1(file_name) {
  window.location = 'uploads/po_form/po_attach/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no';
}


function print_pdf_1(file_name) {

  onmouseover = window.open('uploads/po_form/po_attach/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
}
// function print(file_name) {
//     onmouseover = window.open('uploads/kra_kpi_form/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
// }
function print_view_1(file_name) {

  window.open('uploads/po_form/po_attach/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
}



function print_dc(file_name) {
  // 
  window.location = 'uploads/installation/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no';
}

function print_pdf_dc(file_name) {

  onmouseover = window.open('uploads/installation/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
}


function print_view_dc(file_name) {
  // window.location
  window.open('uploads/installation/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
}


function filterAlphabetInput(input) {
  input.value = input.value.replace(/[^a-zA-Z0-9,\-\s]/g, '');
}