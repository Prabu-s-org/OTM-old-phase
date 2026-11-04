$(document).ready(function () {


  // alert('test');
  // pending_list();

  // var table_id 	= "user_type_datatable";
  init_datatable(table_id, form_name, action);
  sub_list_datatable('fixed_datatable', form_name, 'fixed_datatable');
  // sub_list_datatable_delivery('deleivery_datatable',form_name,'deleivery_datatable');
  get_data();
  get_data1();
  completed_datatable();

  // get_data_delivery();
});
function get_data() {
  // alert();
  init_datatable(table_id, form_name, action);

}

function get_completed_data() {

  // pending_list()
  completed_datatable();

}


$(document).ready(function () {

  // alert('test');

  team_list();

  //  get_productdetails();
});
function get_data1() {
  // alert();
  sub_list_datatable('fixed_datatable', form_name, 'fixed_datatable');
}



function get_dc_detail(inv_no) {

  pending_list(inv_no);

}
// function get_data_delivery(){
// 	sub_list_datatable_delivery('deleivery_datatable',form_name,'deleivery_datatable');
// }
var company_name = sessionStorage.getItem("company_name");
var company_address = sessionStorage.getItem("company_name");
var company_phone = sessionStorage.getItem("company_name");
var company_email = sessionStorage.getItem("company_name");
var company_logo = sessionStorage.getItem("company_name");
var form_name = 'Dispatch Form';
var form_header = '';
var form_footer = '';
var table_name = '';
var table_id = 'dispatch_pending_datatable';
var table_id_1 = 'fixed_datatable';
var table_id_2 = 'deleivery_datatable';
var action = "datatable";




function init_datatable(table_id = '', form_name = '', action = '') {

  var table_id = 'dispatch_pending_datatable';
  var from_date = $("#from_date").val();
  var to_date = $("#to_date").val();
  // alert(to_date);
  var opt1 = $("#opt1").val();
  var screen_id_val = $('#screen_id_val').val();
  // alert(screen_id_val);
  var team_mem = $('#team_mem').val();
  var user_type_unique_id = $('#user_type_unique_id').val();
  var table = $("#" + table_id);
  var data = {
    "action": action,
    "from_date": from_date,
    "to_date": to_date,
    "opt1": opt1,
    "screen_id_val": screen_id_val,
    "team_mem": team_mem,
    "user_type_unique_id": user_type_unique_id,
  };

  //con

  var ajax_url = sessionStorage.getItem("folder_crud_link");
  var datatable = table.DataTable({
    destroy: true, //new line
    ordering: true,
    searching: true,
    // autoWidth: false, // Allow custom widths
    // columnDefs: [
    //  { width: "5%", targets: 0 },  // S.No column (keep it compact)
    // { width: "10%", targets: 1 }, // PO Number
    // { width: "10%", targets: 2 },
    //  { width: "5%", targets: 3 }, // Invoice No
    // { width: "20%", targets: 4 },

    //  { targets: '_all', className: 'text-start' } // Customer Name column (increase)
    // ],
    "ajax": {
      url: ajax_url,
      type: "POST",
      data: data
    },
    // dom: 'Bfrtip',
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
    ]
  });
  $('#columnVisibilityForm').on('change', 'input[type="checkbox"]', function () {
    var columnIdx = $(this).data('column');
    var isVisible = $(this).is(':checked');
    datatable.column(columnIdx).visible(isVisible); // Use datatable instead of table
  });

}





function completed_datatable(table_id = '', form_name = '', action = '') {

  var table_id = 'completed_datatable';


  var from_date = $("#from_date_de").val();
  var to_date = $("#to_date_de").val();
  // alert(to_date);
  // var opt1 = $("#opt1").val();
  var screen_id_val = $('#screen_id_val').val();
  // alert(screen_id_val);
  var team_mem = $('#cm_team_mem').val();

  // alert(team_mem);
  var user_type_unique_id = $('#user_type_unique_id').val();
  var table = $("#" + table_id);
  var data = {
    "action": "completed_datatable",
    "from_date": from_date,
    "to_date": to_date,
    // "opt1": opt1,
    "screen_id_val": screen_id_val,
    "team_mem": team_mem,
    "user_type_unique_id": user_type_unique_id,
  };

  var ajax_url = sessionStorage.getItem("folder_crud_link");
  var datatable = table.DataTable({
    destroy: true, //new line
    ordering: true,
    searching: true,
    autoWidth: false, // Allow custom widths
    columnDefs: [
      { width: "1%", targets: 0 },  // S.No column (keep it compact)
      { width: "10%", targets: 1 }, // PO Number
      { width: "9%", targets: 2 },
      { width: "9%", targets: 3 }, // Invoice No
      { width: "8%", targets: 4 },
      { width: "9%", targets: 5 },
      { width: "6%", targets: 6 },
      { width: "7%", targets: 7 },
      { width: "1%", targets: 8 },
      { width: "15%", targets: 11 },
      { width: "1%", targets: 12 },
      //  sss  // Override for column 11
      { targets: 11, className: 'text-start' },
      { targets: '_all', className: 'text-start' } // Customer Name column (increase)
    ],
    "ajax": {
      url: ajax_url,
      type: "POST",
      data: data
    },
    // dom: 'Bfrtip',
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
    ]
  });


  $('#columnVisibilityForm').on('change', 'input[type="checkbox"]', function () {
    var columnIdx = $(this).data('column');
    var isVisible = $(this).is(':checked');
    datatable.column(columnIdx).visible(isVisible); // Use datatable instead of table
  });
}



function sub_list_datatable(table_id = "", form_name = "", action = "") {
  // alert('hii');
  // var form_main_unique_id = $("#demo").val();
  var table_id = 'fixed_datatable';
  var from_date = $("#from_date_dis").val();
  // alert(from_date);
  var to_date = $("#to_date_dis").val();
  var opt = $("#opt").val();
  var screen_id_val = $('#screen_id_val').val();
  // alert(screen_id_val);
  var user_type_unique_id = $('#user_type_unique_id').val();
  // alert(table_id);
  var table = $("#" + table_id_1);
  var data = {

    "action": 'fixed_datatable',
    "from_date": from_date,
    "to_date": to_date,
    "opt": opt,
    "screen_id_val": screen_id_val,
    "user_type_unique_id": user_type_unique_id,
  };
  var ajax_url = sessionStorage.getItem("folder_crud_link");
  var datatable = table.DataTable({
    destroy: true, //new line
    ordering: true,
    searching: true,
    "ajax": {
      url: ajax_url,
      type: "POST",
      data: data
    },
    // dom: 'Bfrtip',
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
    ]
  });



  $('#columnVisibilityForm').on('change', 'input[type="checkbox"]', function () {
    var columnIdx = $(this).data('column');
    var isVisible = $(this).is(':checked');
    datatable.column(columnIdx).visible(isVisible); // Use datatable instead of table
  });
}


// function sub_list_datatable_delivery(table_id = "", form_name = "", action = "") {
//     // alert('hii');
//     // var form_main_unique_id = $("#demo").val();
//     var table_id = 'deleivery_datatable';

//     var table = $("#" + table_id_2);
// 	var from_date = $("#from_date_de").val();
//     alert(from_date);
// 	var to_date = $("#to_date_de").val();
// 	alert(to_date);
// 	var opt3 = $("#opt3").val();
// 	alert(opt3);
//     var data = {

//         "action": 'deleivery_datatable',
// 		"from_date"	: from_date,
// 		"to_date"   : to_date,
// 		"opt3": opt3,
//     };
//     var ajax_url = sessionStorage.getItem("folder_crud_link");
//     var datatable = table.DataTable({
// 		ordering    : true,
// 		searching   : true,
// 		"ajax"		: {
// 			url 	: ajax_url,
// 			type 	: "POST",
// 			data 	: data
// 		}
// 	});
// }


// old function
// function pending_list(){



//   // alert('pending');

//   var table  = 'doc_pending_list_datatable';

//   var table = $("#" + table);


//   var data ={

//       "action" :"pending_list_datatable"
//   };

//    var ajax_url = sessionStorage.getItem("folder_crud_link");


//       var datatable = table.DataTable({
//   ordering: true,
//   searching: true,
//   "ajax": {
//     url: ajax_url,
//     type: "POST",
//     data: data
//   },
//   dom: '<"dt-top-container"<l><"dt-center-in-div"B><f>r>t<ip>',
//   buttons: [
//     {
//       extend: 'copyHtml5',
//       text: 'Copy',
//       exportOptions: { columns: ':visible' }
//     },
//     {
//       extend: 'csvHtml5',
//       text: 'CSV',
//       exportOptions: { columns: ':visible' }
//     },
//     {
//       extend: 'excelHtml5',
//       text: 'Excel',
//       exportOptions: { columns: ':visible' }
//     },
//     {
//       extend: 'pdfHtml5',
//       text: 'PDF',
//       exportOptions: { columns: ':visible' }
//     },
//     {
//       extend: 'print',
//       text: 'Print',
//       exportOptions: { columns: ':visible' }
//     },
//     {
//       extend: 'colvis', // Column visibility button
//       text: 'Column Visibility',
//       action: function (e, dt, node, config) {
//         // Open the column visibility modal when the button is clicked
//         $('#columnVisibilityModal').modal('show');

//         // Populate the modal with checkboxes for each column
//         var columns = dt.columns().header();
//         var form = $('#columnVisibilityForm');
//         form.empty(); // Clear any existing checkboxes

//         // Append checkboxes one by one for each column
//         columns.each(function (header, index) {
//           var isChecked = dt.column(index).visible();
//           var colMarkup = `
//             <div class="form-check">
//               <input type="checkbox" class="form-check-input" data-column="${index}" ${isChecked ? 'checked' : ''}>
//               <label class="form-check-label">${$(header).text()}</label>
//             </div>
//           `;
//           form.append(colMarkup); // Append each checkbox in a vertical list
//         });
//       }

//     }
//   ]
// });



// $('#columnVisibilityForm').on('change', 'input[type="checkbox"]', function() {
//   var columnIdx = $(this).data('column');
//   var isVisible = $(this).is(':checked');
//   datatable.column(columnIdx).visible(isVisible); // Use datatable instead of table
// });
// }





// function pending_list() {
//   var tableId = 'doc_pending_list_datatable';
//   var table = $("#" + tableId);

//   var data = {
//     "action": "pending_list_datatable"
//   };

//   var ajax_url = sessionStorage.getItem("folder_crud_link");

//   // ✅ Destroy the existing DataTable instance first if already initialized
//   if ($.fn.DataTable.isDataTable('#' + tableId)) {
//     table.DataTable().clear().destroy();
//   }

//   // ✅ Now reinitialize the DataTable
//   table.DataTable({
//     ordering: true,
//     searching: true,
//     ajax: {
//       url: ajax_url,
//       type: "POST",
//       data: data
//     },
//     dom: '<"dt-top-container"<l><"dt-center-in-div"B><f>r>t<ip>',
//     buttons: [
//       {
//         extend: 'copyHtml5',
//         text: 'Copy',
//         exportOptions: { columns: ':visible' }
//       },
//       {
//         extend: 'csvHtml5',
//         text: 'CSV',
//         exportOptions: { columns: ':visible' }
//       },
//       {
//         extend: 'excelHtml5',
//         text: 'Excel',
//         exportOptions: { columns: ':visible' }
//       },
//       {
//         extend: 'pdfHtml5',
//         text: 'PDF',
//         exportOptions: { columns: ':visible' }
//       },
//       {
//         extend: 'print',
//         text: 'Print',
//         exportOptions: { columns: ':visible' }
//       },
//       {
//         extend: 'colvis',
//         text: 'Column Visibility',
//         action: function (e, dt, node, config) {
//           $('#columnVisibilityModal').modal('show');
//           var columns = dt.columns().header();
//           var form = $('#columnVisibilityForm');
//           form.empty();

//           columns.each(function (header, index) {
//             var isChecked = dt.column(index).visible();
//             var colMarkup = `
//               <div class="form-check">
//                 <input type="checkbox" class="form-check-input" data-column="${index}" ${isChecked ? 'checked' : ''}>
//                 <label class="form-check-label">${$(header).text()}</label>
//               </div>
//             `;
//             form.append(colMarkup);
//           });
//         }
//       }
//     ]
//   });

//   $('#columnVisibilityForm').on('change', 'input[type="checkbox"]', function() {
//     var columnIdx = $(this).data('column');
//     var isVisible = $(this).is(':checked');
//     datatable.column(columnIdx).visible(isVisible); // Fixed line
//   });
// }





function pending_list(inv_no) {

  var tableId = 'doc_pending_list_datatable';
  var table = $("#" + tableId);

  // var invoice_no
var po_id = document.getElementById('po_num').value;
  var data = {
    "invoice_no": inv_no,
    "po_id": po_id,
    "action": "pending_list_datatable"
  };

  var ajax_url = sessionStorage.getItem("folder_crud_link");

  // Destroy if already initialized
  if ($.fn.DataTable.isDataTable('#' + tableId)) {
    table.DataTable().clear().destroy();
  }

  // Initialize the DataTable
  var datatable = table.DataTable({
    ordering: true,
    searching: true,
    ajax: {
      url: ajax_url,
      type: "POST",
      data: data
    },
    // dom: '<"dt-top-container"<l><"dt-center-in-div"B><f>r>t<ip>',
    // buttons: [
    //   {
    //     extend: 'copyHtml5',
    //     text: 'Copy',
    //     exportOptions: { columns: ':visible' }
    //   },
    //   {
    //     extend: 'csvHtml5',
    //     text: 'CSV',
    //     exportOptions: { columns: ':visible' }
    //   },
    //   {
    //     extend: 'excelHtml5',
    //     text: 'Excel',
    //     exportOptions: { columns: ':visible' }
    //   },
    //   {
    //     extend: 'pdfHtml5',
    //     text: 'PDF',
    //     exportOptions: { columns: ':visible' }
    //   },
    //   {
    //     extend: 'print',
    //     text: 'Print',
    //     exportOptions: { columns: ':visible' }
    //   },
    //   {
    //     extend: 'colvis',
    //     text: 'Column Visibility',
    //     action: function (e, dt, node, config) {
    //       $('#columnVisibilityModal').modal('show');
    //       var columns = dt.columns().header();
    //       var form = $('#columnVisibilityForm');
    //       form.empty();

    //       columns.each(function (header, index) {
    //         var isChecked = dt.column(index).visible();
    //         var colMarkup = `
    //           <div class="form-check">
    //             <input type="checkbox" class="form-check-input" data-column="${index}" ${isChecked ? 'checked' : ''}>
    //             <label class="form-check-label">${$(header).text()}</label>
    //           </div>
    //         `;
    //         form.append(colMarkup);
    //       });

    //       // ✅ Attach handler inside the modal open callback (where dt is available)
    //       form.off('change').on('change', 'input[type="checkbox"]', function () {
    //         var columnIdx = $(this).data('column');
    //         var isVisible = $(this).is(':checked');
    //         dt.column(columnIdx).visible(isVisible); // ✅ Works fine
    //       });
    //     }
    //   }
    // ]
  });
}


function team_list() {



  // alert('pending');

  var table = 'team_list_datatable';

  var table = $("#" + table);


  var data = {

    "action": "team_list_datatable"
  };

  var ajax_url = sessionStorage.getItem("folder_crud_link");


  var datatable = table.DataTable({
    ordering: true,
    searching: true,
    "ajax": {
      url: ajax_url,
      type: "POST",
      data: data
    },
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
    ]
  });
  $('#columnVisibilityForm').on('change', 'input[type="checkbox"]', function () {
    var columnIdx = $(this).data('column');
    var isVisible = $(this).is(':checked');
    datatable.column(columnIdx).visible(isVisible); // Use datatable instead of table
  });
}





function bulk_vendor_update() {
  // debugger;
  // alert('update');

  // var  vendor = $("#vendor_name").val();
  var rate = $("#rate").val();
  var gst = $("#gst").val();


  var ttl_amnt = $('#ttl_amnt').val();

  // alert(ttl_amnt);
  var per_ttl_amnt = $('#per_ttl_amnt').val();



  // alert(per_ttl_amnt);

  var time_line = $("#timeline").val();
  var bulk_status = $("#bulk_status").val();
  var eng_type = $("#eng_type").val();
  var eng_name = $("#eng_name").val();
  var date = $("#date").val();



  if (eng_type === 'own-engineer') {


    if (!bulk_status || !eng_type || !eng_name || !time_line) {

      sweetalert("form_alert");
      return;

    }
  }

  else {

    if (!rate || !gst || !time_line || !bulk_status || !eng_type || !eng_name || !ttl_amnt) {

      sweetalert("form_alert");
      return;

    }

  }


  var ajax_url = sessionStorage.getItem("folder_crud_link");



  var isChecked = false;

  $("#doc_pending_list_datatable tbody tr").each(function () {
    var checkbox = $(this).find('.myCheck');
    if (checkbox.is(':checked')) {
      isChecked = true;
      return false; // Break the loop once a checked box is found
    }
  });

  if (!isChecked) {
    alert("Please select at least one checkbox.");
    return;
  }

  var url = sessionStorage.getItem("list_link");

  var ajax_url = sessionStorage.getItem("folder_crud_link");


  $("#doc_pending_list_datatable tbody tr").each(function () {

    //  alert('test');
    var checkbox = $(this).find('.myCheck');

    if (checkbox.is(':checked')) {
      // alert('checked');
      // Fetching values based on column index since the table is dynamically created
      var approved_by = $(this).find("td:eq(13)").text().trim();

      //  alert(approved_by);
      var invoice_no = $(this).find("td:eq(6)").text().trim();
      var dc_nos = $(this).find("td:eq(4)").text().trim();
      // const dc_no = "DCO000022025-06-16";

      const [, dc_no, datePart] = dc_nos.match(/^(.*?)(\d{4}-\d{2}-\d{2})$/);

      // console.log(dc_no); // ➜ "DCO00002"
      // console.log(datePart);   // ➜ "2025-06-16"
      // var dc_no1 = document.getElementById('my_dc_num').value; 

      //  alert(dc_no);

      var po_num = $(this).find("td:eq(2)").text().trim();

      var invoice_qty = parseFloat(checkbox.attr("data-invoice-qty")) || 0;

      var dc_base_amount = invoice_qty * rate;

      var dc_gst_amount = (dc_base_amount * gst) / 100;

      var dc_ttl_amount = dc_base_amount + dc_gst_amount;

      // alert(dc_ttl_amount);

      var dc_amount = $("#dc_total_" + dc_no).val() || 0;

      //  alert(dc_amount);



      //  return;





      var data = {

        "rate": rate,
        "gst": gst,
        // "ttl_amnt":ttl_amnt,
        "ttl_amnt": dc_amount,
        "per_ttl_amnt": per_ttl_amnt,

        "time_line": time_line,

        "po_num": po_num,
        "invoice_no": invoice_no,
        "dc_no": dc_no,
        "bulk_status": bulk_status,
        "eng_name": eng_name,
        "eng_type": eng_type,
        "date": date,
        "action": "bulk_vendor_update"
      };

      $.ajax({

        type: "POST",
        url: ajax_url,
        data: data,

        success: function (response) {
          sweetalert('create');
          // sweetalert('create',url);
          // window.location.reload();

        },
        error: function (xhr) {

          // console.log(xhr.responseText);
          alert("Network Error");
        }




      });

    }
  });

}




function main_vendor_update() {


  var time_line = $("#timeline").val();
  var bulk_status = $("#bulk_status").val();
  var eng_type = $("#eng_type").val();
  var eng_name = $("#eng_name").val();
  var date = $("#date").val();

  var ins_date = $("#ins_date").val();


  var assign_no = $('#assign_no').val();

  var assign_date = $('#assign_date').val();


  var ajax_url = sessionStorage.getItem("folder_crud_link");

  var url = sessionStorage.getItem("list_link");


  if (eng_type === 'own-engineer') {

    // alert('own');

    var isChecked = false;

    $("#doc_pending_list_datatable tbody tr").each(function () {
      var checkbox = $(this).find('.myCheck');
      if (checkbox.is(':checked')) {
        isChecked = true;
        return false; // Break the loop once a checked box is found
      }
    });

    if (!isChecked) {
      alert("Please select at least one checkbox.");
      return;
    }

    var url = sessionStorage.getItem("list_link");

    var ajax_url = sessionStorage.getItem("folder_crud_link");


    $("#doc_pending_list_datatable tbody tr").each(function () {

      //  alert('test');
      var checkbox = $(this).find('.myCheck');

      if (checkbox.is(':checked')) {
        // alert('checked');
        // Fetching values based on column index since the table is dynamically created
        var approved_by = $(this).find("td:eq(13)").text().trim();

        //  alert(approved_by);
        var invoice_no = $(this).find("td:eq(6)").text().trim();
        var dc_nos = $(this).find("td:eq(4)").text().trim();

        // alert(dc_nos);
        // const dc_no = "DCO000022025-06-16";

        const [, dc_no, datePart] = dc_nos.match(/^(.*?)(\d{4}-\d{2}-\d{2})$/);

        // console.log(dc_no); // ➜ "DCO00002"
        // console.log(datePart);   // ➜ "2025-06-16"
        // var dc_no1 = document.getElementById('my_dc_num').value; 

        //  alert(dc_no);

        var po_num = $(this).find("td:eq(2)").text().trim();

        var invoice_qty = parseFloat(checkbox.attr("data-invoice-qty")) || 0;


        var data = {

          // "rate": rate,
          // "gst": gst,
          "assign_no": assign_no,
          "assign_date": assign_date,
          "ins_date": ins_date,
          "time_line": time_line,
          "po_num": po_num,
          "invoice_no": invoice_no,
          "dc_no": dc_no,
          "bulk_status": bulk_status,
          "eng_name": eng_name,
          "eng_type": eng_type,
          "date": date,
          "action": "bulk_vendor_update"
        };

        $.ajax({
          type: "POST",
          url: ajax_url,
          data: data,

          success: function (response) {

            // return;
            sweetalert('create', url);
            // sweetalert('create',url);
            // window.location.reload();

          },
          error: function (xhr) {

            // console.log(xhr.responseText);
            alert("Network Error");
          }
        });

      }
    });

  }

  else if (eng_type === 'outsource-vendor') {
    let dcGroup = {};

    document.querySelectorAll("#product_details_datatable tbody tr").forEach(function (row) {
      const qty = parseFloat(row.querySelector(".qty")?.textContent.trim()) || 0;
      // const gst = "18"; // fixed
      // var gstType = $('#gst_type').val();
      // var gst;

      // if (gstType === "1") {
      //   gst = 18;
      // } else if (gstType === "2") {
      //   gst = 0;
      // }
      const tax_amount = parseFloat(row.querySelector(".tax_amount")?.textContent) || 0;
      const total_amount = parseFloat(row.querySelector(".total_amount")?.textContent) || 0;
      const rate = parseFloat(row.querySelector("input[name='rate[]']")?.value) || 0;

      const po_unique_id = row.querySelector(".ven_po_unique_id")?.value || '';
      const dc_no_str = row.querySelector(".ven_dc_no")?.value || '';
      const dc_list = dc_no_str.split(",").map(dc => dc.trim()).filter(dc => dc.length > 0);

      const dc_share = dc_list.length;

      if (dc_share === 0) return;

      const split_qty = qty / dc_share;
      const split_tax = tax_amount / dc_share;
      const split_total = total_amount / dc_share;
      const split_rate = rate; // rate remains same per unit

      dc_list.forEach(dc => {
        if (!dcGroup[dc]) {
          dcGroup[dc] = {
            qty: 0,
            rate: 0,
            tax_amount: 0,
            total_amount: 0,
            dc_no: dc,
            po_num: po_unique_id,
          };
        }

        dcGroup[dc].qty += split_qty;
        dcGroup[dc].rate += split_rate; // accumulate per product, not split
        dcGroup[dc].tax_amount += split_tax;
        dcGroup[dc].total_amount += split_total;
      });
    });

    var gstType = $('#gst_type').val();
    var gst;

    if (gstType === "1") {
      gst = 18;
    } else if (gstType === "2") {
      gst = 0;
    }

    // Save grouped DC values
    Object.values(dcGroup).forEach(dcData => {
      const data = {
        "assign_no": assign_no,
        "assign_date": assign_date,
        "ins_date": ins_date,
        "rate": dcData.rate, // sum of per-product rates per DC
        "gst": gst,
        "total_amount": dcData.total_amount.toFixed(2),
        "time_line": time_line,
        "po_num": dcData.po_num,
        "dc_no": dcData.dc_no,
        "bulk_status": bulk_status,
        "eng_name": eng_name,
        "eng_type": eng_type,
        "date": date,
        "action": "bulk_vendor_update"
      };

      $.ajax({
        type: "POST",
        url: ajax_url,
        data: data,
        success: function (response) {
          console.log("Saved main record for DC:", dcData.dc_no);
          // Optional: sweetalert or callback here
        },
        error: function () {
          alert("Error saving main record for DC: " + dcData.dc_no);
        }
      });
    });
  }

}


function submitvendor_update() {
  const url = sessionStorage.getItem("list_link");
  const ajax_url = sessionStorage.getItem("folder_crud_link");

  const assign_no = $('#assign_no').val();
  const assign_date = $('#assign_date').val();


  var time_line = $("#timeline").val();
  var bulk_status = $("#bulk_status").val();
  var eng_type = $("#eng_type").val();
  var eng_name = $("#eng_name").val();
  var date = $("#date").val();

  var ins_date = $("#ins_date").val();

  var po_num = $("#po_num").val();

  var inv_no = $("#inv_num").val();

  // var rate = 



  var isChecked = false;


  if (eng_type === 'own-engineer') {


    // var ins_date = $("#ins_date").val();
    if (!bulk_status || !eng_type || !eng_name || !ins_date || !time_line || !po_num || !inv_no) {

      sweetalert("form_alert");
      return;

    }
  }

  else {

    if (!time_line || !bulk_status || !eng_type || !eng_name || !ins_date || !po_num || !inv_no) {

      sweetalert("form_alert");
      return;

    }

  }


  $("#doc_pending_list_datatable tbody tr").each(function () {
    var checkbox = $(this).find('.myCheck');
    if (checkbox.is(':checked')) {
      isChecked = true;
      return false; // Break the loop once a checked box is found
    }
  });

  if (!isChecked) {
    alert("Select checkbox.");
    return;
  }


  // var eng_type = 


  document.querySelectorAll("#product_details_datatable tbody tr").forEach(function (row) {
    let qty = parseFloat(row.querySelector(".qty")?.textContent.trim()) || 0;
    // let gst = "18";
    var gstType = $('#gst_type').val();
    var gst;
    if (gstType === "1") {
      gst = 18;
    } else if (gstType === "2") {
      gst = 0;
    }
    let tax_amount = parseFloat(row.querySelector(".tax_amount")?.textContent) || 0;
    let total_amount = parseFloat(row.querySelector(".total_amount")?.textContent) || 0;

    let po_unique_id = row.querySelector(".ven_po_unique_id")?.value || '';
    let product_unique_id = row.querySelector(".ven_product_unique_id")?.value || '';
    let item_code = row.querySelector(".ven_item_code")?.value || '';
    let product = row.querySelector(".ven_product")?.value || '';
    let dc_no_str = row.querySelector(".ven_dc_no")?.value || '';
    let rate = parseFloat(row.querySelector("input[name='rate[]']")?.value) || 0;

    let dc_numbers = dc_no_str.split(",").map(dc => dc.trim()).filter(dc => dc.length > 0);
    let dc_count = dc_numbers.length;

    // Split values per DC
    let split_qty = parseFloat((qty / dc_count).toFixed(2));
    let split_tax = parseFloat((tax_amount / dc_count).toFixed(2));
    let split_total = parseFloat((total_amount / dc_count).toFixed(2));

    // Loop through each DC
    dc_numbers.forEach(function (dc_no) {
      let data = {
        "rate": rate,
        "gst": gst,
        "qty": split_qty,
        "tax_amount": split_tax,
        "total_amount": split_total,
        "po_unique_id": po_unique_id,
        "product_unique_id": product_unique_id,
        "item_code": item_code,
        "product": product,
        "dc_no": dc_no,
        "assign_no": assign_no,
        "assign_date": assign_date,
        "action": "vendor_bill"
      };

      $.ajax({
        type: "POST",
        url: ajax_url,
        data: data,
        success: function (response) {
          console.log("Stored:", dc_no);
        },
        error: function (err) {
          console.error("Failed:", dc_no, err);
        }
      });
    });
  });

  // After loop
  sweetalert("create", url);

  main_vendor_update();
}

// function submitvendor_update() {
//     alert('test');
//     alert('Submitting vendor update...');

//     const url = sessionStorage.getItem("list_link");
//     const ajax_url = sessionStorage.getItem("folder_crud_link");

//     document.querySelectorAll("#product_details_datatable tbody tr").forEach(function (row, index) {
//         const gst = "18";
//         const tax_amount = row.querySelector(".tax_amount")?.textContent || 0;
//         const total_amount = row.querySelector(".total_amount")?.textContent || 0;

//         const po_unique_id = row.querySelector(".ven_po_unique_id")?.value || '';
//         const product_unique_id = row.querySelector(".ven_product_unique_id")?.value || '';
//         const item_code = row.querySelector(".ven_item_code")?.value || '';
//         const product = row.querySelector(".ven_product")?.value || '';
//         const rate = row.querySelector("input[name='rate[]']")?.value || 0;

//         // ✅ Check for DC QTY MAP input
//         const hiddenInput = row.querySelector(".dc_qty_map");
//         if (!hiddenInput) {
//             console.warn(`⚠️ Row ${index + 1}: Missing .dc_qty_map input`);
//             return; // Skip this row
//         }

//         let dc_qty_map;
//         try {
//             dc_qty_map = JSON.parse(hiddenInput.value || '{}');
//         } catch (e) {
//             console.error(`❌ Row ${index + 1}: Invalid JSON in .dc_qty_map`, e);
//             return;
//         }

//         if (Object.keys(dc_qty_map).length === 0) {
//             console.warn(`⚠️ Row ${index + 1}: Empty DC quantity map`);
//             return;
//         }

//         Object.entries(dc_qty_map).forEach(([dc_no, qty]) => {
//             const data = {
//                 rate,
//                 gst,
//                 qty,
//                 tax_amount,
//                 total_amount,
//                 po_unique_id,
//                 product_unique_id,
//                 item_code,
//                 product,
//                 dc_no,
//                 action: "vendor_bill"
//             };

//             console.log("📤 Submitting:", data);

//             $.ajax({
//                 url: ajax_url,
//                 type: "POST",
//                 data: data,
//                 success: function (response) {
//                     console.log(`✅ Saved: DC ${dc_no}, Product ${item_code}, Qty ${qty}`);
//                 },
//                 error: function (err) {
//                     console.error(`❌ Error saving DC ${dc_no}, Product ${item_code}`, err);
//                 }
//             });
//         });
//     });

//     // setTimeout(() => {
//     //     alert("All product entries submitted individually per DC.");
//     //     sweetalert("create", url);
//     // }, 1000);
// }


function team_allocation_update() {

  // alert('update');

  // var  vendor = $("#vendor_name").val();
  var region = $("#region").val();

  // alert(region);

  var state = $("#state_name").val();

  // alert(state);

  var district = $("#district_name").val();

  // alert(district);

  var user_role = $('#user_role_id').val();
  //  alert(user_role);

  var eng_name = $("#eng_name").val();

  var eng_name_string = eng_name.join(",");

  // alert(eng_name);

  var team_status = $("#team_status").val();




  if (!region || !state || !district || !user_role || !eng_name_string || !team_status) {


    sweetalert("form_alert");
    return;

  }

  var isChecked = false;

  $("#team_list_datatable tbody tr").each(function () {
    var checkbox = $(this).find('.myCheck');
    if (checkbox.is(':checked')) {
      isChecked = true;
      return false; // Break the loop once a checked box is found
    }
  });

  if (!isChecked) {
    alert("Please select at least one checkbox.");
    return;
  }

  var ajax_url = sessionStorage.getItem("folder_crud_link");


  $("#team_list_datatable tbody tr").each(function () {

    //   alert('test');
    var checkbox = $(this).find('.myCheck');

    if (checkbox.is(':checked')) {
      // alert('checked');
      // Fetching values based on column index since the table is dynamically created
      var approved_by = $(this).find("td:eq(13)").text().trim();

      //  alert(approved_by);
      var invoice_no = $(this).find("td:eq(6)").text().trim();

      alert(invoice_no);
      var po_num = $(this).find("td:eq(2)").text().trim();


      var data = {

        "region": region,
        "state": state,
        "district": district,
        "user_role": user_role,
        "eng_name": eng_name_string,
        "team_status": team_status,
        "invoice_no": invoice_no,
        "action": "team_update"
      };

      $.ajax({

        type: "POST",
        url: ajax_url,
        data: data,

        success: function (response) {

          // return;
          sweetalert('create');
          window.location.reload();

        },
        error: function (xhr) {

          // console.log(xhr.responseText);
          alert("Network Error");
        }




      });

    }
  });

}







function individual_vendor_update() {
  // debugger;

  // var  vendor = $("#vendor_name").val();
  var rate = $("#s_rate").val();
  var gst = $("#s_gst").val();

  var ttl_amnt = $('#s_ttl_amnt').val();

  var per_ttl_amnt = $('#per_ttl_amnt').val();

  var time_line = $("#s_timeline").val();
  var bulk_status = $("#s_bulk_status").val();
  var eng_type = $("#s_eng_type").val();

  // alert(eng_type);

  // return;
  var eng_name = $("#s_eng_name").val();

  var dc_no = $('#dc_no').val();
  var date = $('#s_date').val();


  if (eng_type === 'own-engineer') {

    if (!bulk_status || !eng_type || !eng_name || !time_line || !date) {

      sweetalert("form_alert");
      return;

    }
  }

  else if (eng_type === 'outsource-vendor') {

    if (!rate || !gst || !time_line || !bulk_status || !eng_type || !eng_name || !date) {

      sweetalert("form_alert");
      return;

    }


  }

  var url = sessionStorage.getItem("list_link");

  var ajax_url = sessionStorage.getItem("folder_crud_link");

  var data = {
    "rate": rate,
    "gst": gst,
    "ttl_amnt": ttl_amnt,
    "time_line": time_line,
    "per_ttl_amnt": per_ttl_amnt,
    "dc_no": dc_no,
    "date": date,
    "bulk_status": bulk_status,
    "eng_name": eng_name,
    "eng_type": eng_type,
    "action": "bulk_vendor_update"
  };

  $.ajax({

    type: "POST",
    url: ajax_url,
    data: data,

    success: function (response) {

      sweetalert('create', url);
      // window.location.reload();

    },
    error: function (xhr) {

      // console.log(xhr.responseText);
      alert("Network Error");
    }




  });



}





function check(my_obj, sno) {

  // alert('test');


  var chk = my_obj.checked;
  if (chk === true) {
    $('#po_att' + sno).show();
    // document.getElementById('po_att'+sno).style.display="block";
  }
  else {
    $('#po_att' + sno).hide();
    // document.getElementById('po_att'+sno).style.display="none";
  }
}

function check_dc(my_obj, sno) {
  var chk = my_obj.checked;
  if (chk === true) {
    $('#dc_att' + sno).show();
    // document.getElementById('dc_att').style.display="block";
  }
  else {
    $('#dc_att' + sno).hide();
    // document.getElementById('dc_att').style.display="none";
  }
}

function check_ir(my_obj, sno) {
  var chk = my_obj.checked;
  if (chk === true) {
    $('#ir_att' + sno).show();
    // document.getElementById('ir_att').style.display="block";
  }
  else {
    $('#ir_att' + sno).hide();
    // document.getElementById('ir_att').style.display="none";
  }
}

function check_inv(my_obj, sno) {
  var chk = my_obj.checked;
  if (chk === true) {
    $('#invoice' + sno).show();
    // document.getElementById('invoice').style.display="block";
  }
  else {
    $('#invoice' + sno).hide();
    // document.getElementById('invoice').style.display="none";
  }
}

function get_list() {
  var team_mem = document.getElementById('team_mem').value;
  init_datatable(table_id, form_name, action);
}

































function print(file_name) {
  // 	onmouseover= window.open('uploads/dispatch/' + file_name,'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
  // }
  onmouseover = window.open('uploads/dispatch/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
}
// function print(file_name) {
//     onmouseover = window.open('uploads/kra_kpi_form/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
// }
function print_view(file_name) {
  // window.location = 'uploads/dispatch/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no';
  window.open('uploads/dispatch/' + file_name, 'onmouseover', 'height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
}
// function invoice_details(unique_id = "") { // au = add,update

function toggleGstDiv() {
  const engType = document.getElementById("eng_type").value;
  const gstDiv = document.getElementById("gst-div");

  if (engType === "outsource-vendor") {
    gstDiv.style.display = "flex"; // or "block", depending on your layout
  } else {
    gstDiv.style.display = "none";
  }
}