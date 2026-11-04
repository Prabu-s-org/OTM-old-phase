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
    stateSave:true,
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
    autoWidth: false,
    stateSave:true, // Allow custom widths
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
var po_id = document.getElementById('po_num').value;
  // var invoice_no

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

    table.on('draw.dt', function () {
        applyPartialCheckboxRules(tableId);
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
// alert("main vendor");

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


  
  else if(eng_type == 'inhouse') {

  // alert('inhouse');

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
      // alert(tax_amount);
      const total_amount = parseFloat(row.querySelector(".total_amount")?.textContent) || 0;

      // alert(total_amount);
      const rate = parseFloat(row.querySelector("input[name='rate[]']")?.value) || 0;

      const po_unique_id = row.querySelector(".ven_po_unique_id")?.value || '';
      const dc_no_str = row.querySelector(".ven_dc_no")?.value || '';
      const dc_list = dc_no_str.split(",").map(dc => dc.trim()).filter(dc => dc.length > 0);

      const dc_share = dc_list.length;

      // alert(dc_share);

      if (dc_share === 0) return;

      const split_qty = qty / dc_share;
      const split_tax = tax_amount / dc_share;
      const split_total = total_amount / dc_share;
      const split_rate = rate; // rate remains same per unit

      var gstType = $('#gst_type').val();
    var gst = (gstType === "1") ? 18 : 0;

    // let tax_amount = parseFloat(row.querySelector(".tax_amount")?.textContent.trim()) || 0;
    // let total_amount = parseFloat(row.querySelector(".total_amount")?.textContent.trim()) || 0;

    // let po_unique_id = row.querySelector(".ven_po_unique_id")?.value || '';
    let product_unique_id = row.querySelector(".ven_product_unique_id")?.value || '';
    let item_code = row.querySelector(".ven_item_code")?.value || '';
    let product = row.querySelector(".ven_product")?.value || '';
    // let dc_no_str = row.querySelector(".ven_dc_no")?.value || '';
    // let rate = parseFloat(row.querySelector("input[name='rate[]']")?.value) || 0;
    let partial_qtys = parseFloat(row.querySelector("input[name='partial_qty[]']")?.value) || 0;
    let remaining_qtys = parseFloat(row.querySelector("input[name='remaining_qty[]']")?.value) || 0;

    // Validate partial and remaining quantities
    var partial_qty = !isNaN(partial_qtys) ? partial_qtys : '';
    let remaining_qty = !isNaN(remaining_qtys) ? remaining_qtys : '';

    // Split dc numbers
    let dc_numbers = dc_no_str.split(",").map(dc => dc.trim()).filter(dc => dc.length > 0);
    let dc_count = dc_numbers.length;

   
    // // Collect values from inputs outside the table rows
    // const assign_no = $('#assign_no').val();
    // const assign_date = $('#assign_date').val();
    // const time_line = $("#timeline").val();
    // const bulk_status = $("#bulk_status").val();
    // const eng_type = $("#eng_type").val();
    // const eng_name = $("#eng_name").val();
    // const date = $("#date").val();
    // const ins_date = $("#ins_date").val();
    // const po_num = $("#po_num").val();
    // const inv_no = $("#inv_num").val();
    // const gst_type = $("#gst_type").val();

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

    var gstTypes = $('#gst_type').val();
    var gstno;

    if (gstTypes === "1") {
      gstno = 18;
    } else if (gstTypes === "2") {
      gstno = 0;
    }



    Object.values(dcGroup).forEach(dcData => {
  var data = {
    "assign_no": assign_no,
    "assign_date": assign_date,
    "ins_date": ins_date,
    "rate": dcData.rate.toFixed(2), // ✅ now passing
    "gst": gstno,                   // ✅ now passing
    "total_amount": dcData.total_amount.toFixed(2),
    "tax_amount": dcData.tax_amount.toFixed(2), // ✅ fixed, not split_tax
    "time_line": time_line,
    "po_num": dcData.po_num,
    "invoice_no": $("#inv_num").val() || '', // ✅ added invoice_no
    "dc_no": dcData.dc_no,
    "bulk_status": bulk_status,
    "eng_name": eng_name,
    "eng_type": eng_type,
    "date": date, // ✅ uncommented
    "gst_type": gstno,

    "action": "bulk_vendor_update"
  };

  $.ajax({
    type: "POST",
    url: ajax_url,
    data: data,
    success: function (response) {
      console.log("Saved main record for DC:", dcData.dc_no, response);
    },
    error: function () {
      alert("Error saving main record for DC: " + dcData.dc_no);
    }
  });
});

    // Save grouped DC values
    // Object.values(dcGroup).forEach(dcData => {
    //   const data = {
    //     "assign_no": assign_no,
    //     "assign_date": assign_date,
    //     // "ins_date": ins_date,
    //     // "rate": dcData.rate, // sum of per-product rates per DC
    //     // "gst": gst,
    //     // "partial_qty": partial_qty,
    //         // "remaining_qty": remaining_qty,
    //    "total_amount": dcData.total_amount.toFixed(2),
    //     "tax_amount": split_tax,
    //     "time_line": time_line,
    //     "po_num": dcData.po_num,
    //     "dc_no": dcData.dc_no,
    //     // "po_unique_id": po_unique_id,
    //         // "product_unique_id": product_unique_id,
    //         // "item_code": item_code,
    //         // "product": product,
    //     "bulk_status": bulk_status,
    //     "eng_name": eng_name,
    //     "eng_type": eng_type,
    //   //  "date": date,
    //         "ins_date": ins_date,
    //         // "inv_no": inv_no,
    //     "gst_type": gstno,
    //     "action": "bulk_vendor_update"
    //   };

    //   $.ajax({
    //     type: "POST",
    //     url: ajax_url,
    //     data: data,
    //     success: function (response) {
    //       console.log("Saved main record for DC:", dcData.dc_no);
    //       // Optional: sweetalert or callback here
    //     },
    //     error: function () {
    //       alert("Error saving main record for DC: " + dcData.dc_no);
    //     }
    //   });
    // });
  }

}





// function submitvendor_update() {
//     var url = sessionStorage.getItem("list_link");
//     var ajax_url = sessionStorage.getItem("folder_crud_link");

//     const assign_no = $('#assign_no').val();
//     const assign_date = $('#assign_date').val();
//     const time_line = $("#timeline").val();
//     const bulk_status = $("#bulk_status").val();
//     const eng_type = $("#eng_type").val();
//     const eng_name = $("#eng_name").val();
//     const date = $("#date").val();
//     const ins_date = $("#ins_date").val();
//     const po_num = $("#po_num").val();
//     const inv_no = $("#inv_num").val();

//     var ven_partial_no  = $('#ven_partial_no').val();


//     // 

//     var isChecked = false;

//     // Form validation based on engineer type
//     if ((eng_type === 'own-engineer') || (eng_type == 'inhouse')) {
//         if (!bulk_status || !eng_type || !eng_name || !ins_date || !time_line || !po_num) {
//             sweetalert("form_alert");
//             return;
//         }
//     } else {
//         if (!time_line || !bulk_status || !eng_type || !eng_name || !ins_date || !po_num) {
//             sweetalert("form_alert");
//             return;
//         }
//     }

//     // Check if at least one checkbox is selected
//     $("#doc_pending_list_datatable tbody tr").each(function () {
//         var checkbox = $(this).find('.myCheck');
//         if (checkbox.is(':checked')) {
//             isChecked = true;
//             return false; // Break the loop once a checked box is found
//         }
//     });


//     if(eng_type == 'own-engineer'){


//        $("#doc_pending_list_datatable tbody tr").each(function () {

//       //  alert('test');
//       var checkbox = $(this).find('.myCheck');

//       if (checkbox.is(':checked')) {
//         // alert('checked');
//         // Fetching values based on column index since the table is dynamically created
//         // var approved_by = $(this).find("td:eq(13)").text().trim();

//         //  alert(approved_by);
//         var invoice_no = $(this).find("td:eq(6)").text().trim();
//         var dc_nos = $(this).find("td:eq(4)").text().trim();

//         // alert(dc_nos);
//         // const dc_no = "DCO000022025-06-16";

//         const [, dc_no, datePart] = dc_nos.match(/^(.*?)(\d{4}-\d{2}-\d{2})$/);

//         // console.log(dc_no); // ➜ "DCO00002"
//         // console.log(datePart);   // ➜ "2025-06-16"
//         // var dc_no1 = document.getElementById('my_dc_num').value; 

//         //  alert(dc_no);

//         // var po_num = $(this).find("td:eq(2)").text().trim();

//         var invoice_qty = parseFloat(checkbox.attr("data-invoice-qty")) || 0;



//         var data  = {

//            "assign_no": assign_no,
//           "assign_date": assign_date,
//           "ins_date": ins_date,
//           "time_line": time_line,
//           "po_num": po_num,
//           "invoice_no": invoice_no,
//           "dc_no": dc_no,
//           "bulk_status": bulk_status,
//           "eng_name": eng_name,
//           "eng_type": eng_type,
//           "date": date,
//           "action" :"bulk_vendor_update"

//         };

//         $.ajax({
//           type:"POST",
//           url:ajax_url,
//           data:data,

//           success:function(response){

//             sweetalert('create',url);
//             main_vendor_update();
//           },
//           error:function(xhr){

//              console.log(xhr.responseText);
//             alert("Network Error");
//           }
//         });
//       }

//       });


//     }

//     else if(eng_type == 'inhouse'){
//       $("#doc_pending_list_datatable tbody tr").each(function () {

//       //  alert('test');
//       var checkbox = $(this).find('.myCheck');

//       if (checkbox.is(':checked')) {
//         // alert('checked');
//         // Fetching values based on column index since the table is dynamically created
//         // var approved_by = $(this).find("td:eq(13)").text().trim();

//         //  alert(approved_by);
//         var invoice_no = $(this).find("td:eq(6)").text().trim();
//         var dc_nos = $(this).find("td:eq(4)").text().trim();

//         // alert(dc_nos);
//         // const dc_no = "DCO000022025-06-16";

//         const [, dc_no, datePart] = dc_nos.match(/^(.*?)(\d{4}-\d{2}-\d{2})$/);

//         // console.log(dc_no); // ➜ "DCO00002"
//         // console.log(datePart);   // ➜ "2025-06-16"
//         // var dc_no1 = document.getElementById('my_dc_num').value; 

//         //  alert(dc_no);

//         // var po_num = $(this).find("td:eq(2)").text().trim();

//         var invoice_qty = parseFloat(checkbox.attr("data-invoice-qty")) || 0;



//         var data  = {

//            "assign_no": assign_no,
//           "assign_date": assign_date,
//           "ins_date": ins_date,
//           "time_line": time_line,
//           "po_num": po_num,
//           "invoice_no": invoice_no,
//           "dc_no": dc_no,
//           "bulk_status": bulk_status,
//           "eng_name": eng_name,
//           "eng_type": eng_type,
//           "date": date,
//           "action" :"bulk_vendor_update"

//         };

//         $.ajax({
//           type:"POST",
//           url:ajax_url,
//           data:data,

//           success:function(response){

//             sweetalert('create',url);
//             alert('fully');
//             main_vendor_update();
//           },
//           error:function(xhr){

//              console.log(xhr.responseText);
//             alert("Network Error");
//           }
//         });
//       }

//       });
//     }


//     else{

//        let selected_dc_numbers = [];
//     document.querySelectorAll('.myCheck:checked').forEach(function (checkbox) {
//         selected_dc_numbers.push(checkbox.getAttribute("data-id"));
//     });

//     if (selected_dc_numbers.length > 1) {
//         var partial_sts = '0';
//     } else {
//         var partial_sts = '1';
//     }

//     // alert(partial_sts);

//     if (!isChecked) {
//         alert("Select checkbox.");
//         return;
//     }

// //     let qty = parseFloat(row.querySelector(".qty")?.textContent.trim()) || 0;
// //      let tax_amount = parseFloat(row.querySelector(".tax_amount")?.textContent.trim()) || 0;
// //         let total_amount = parseFloat(row.querySelector(".total_amount")?.textContent.trim()) || 0;

// //         let po_unique_id = row.querySelector(".ven_po_unique_id")?.value || '';

// //          let dc_no_str = row.querySelector(".ven_dc_no")?.value || '';
// //         let rate = parseFloat(row.querySelector("input[name='rate[]']")?.value) || 0;

       
// //           let dc_numbers = dc_no_str.split(",").map(dc => dc.trim()).filter(dc => dc.length > 0);


// //  var partial_qty = qty;
// //         var   remaining_qty = '0';

// //        if (partial_sts === '0') {
// //         selected_dc_numbers.forEach(function (dc_no) {
// //             let data = {
// //                "rate": rate,
// //                 "gst": gst,
// //                 "partial_qty": partial_qty,
// //                 "assign_no": assign_no,
// //                 "assign_date": assign_date,
// //                 "assigned_qty":partial_qty,
// //                 "remaining_qty":remaining_qty,
// //                 "time_line": time_line,
// //                 "ins_date": ins_date,
// //                 "eng_type": eng_type,
// //                 "eng_name": eng_name,
// //                 "po_num": po_num,
// //                 "inv_no": inv_no,
// //                 "date": date,
// //                 "dc_no": dc_no,
// //                 "partial_sts": partial_sts,
// //                 "ven_partial_no": ven_partial_no,
// //                  "tax_amount": tax_amount,
// //                 "total_amount": total_amount,
// //                 "po_unique_id": po_unique_id,
// //                 "action": "vendor_bill"
// //             };

// //             $.ajax({
// //                 type: "POST",
// //                 url: ajax_url,
// //                 data: data,
// //                 success: function (response) {
// //                     sweetalert('create', url);
// //                     console.log("Stored for DC (not partial):", dc_no);
// //                 },
// //                 error: function (err) {
// //                     console.error("Failed for DC:", dc_no, err);
// //                 }
// //             });
// //         });
// //     }

// //     else{

// //     }



//     document.querySelectorAll("#product_details_datatable tbody tr").forEach(function (row) {
//         let qty = parseFloat(row.querySelector(".qty")?.textContent.trim()) || 0;
//         var gstType = $('#gst_type').val();
//         var gst = (gstType === "1") ? 18 : 0;
//         let tax_amount = parseFloat(row.querySelector(".tax_amount")?.textContent.trim()) || 0;
//         let total_amount = parseFloat(row.querySelector(".total_amount")?.textContent.trim()) || 0;

//         let po_unique_id = row.querySelector(".ven_po_unique_id")?.value || '';
//         let product_unique_id = row.querySelector(".ven_product_unique_id")?.value || '';
//         let item_code = row.querySelector(".ven_item_code")?.value || '';
//         let product = row.querySelector(".ven_product")?.value || '';
//         let dc_no_str = row.querySelector(".ven_dc_no")?.value || '';
//         let rate = parseFloat(row.querySelector("input[name='rate[]']")?.value) || 0;

//         let partial_qty = 0;
//         let remaining_qty = 0;
//         let remaining_qtys_olds = 0;
//         let already_assign_qty = 0;

//         if (partial_sts === '0') {
           

//           var assigned_qty = qty;
//           partial_qty = qty;
//           remaining_qty = '0';
//               // var assigned_qty = parseFloat(row.querySelector("input[name='assigned_qty[]']")?.value) || 0;

//         } else {


//           // alert('ss');
//            partial_qty = parseFloat(row.querySelector("input[name='partial_qty[]']")?.value) || 0;
//             // alert(partial_qty);
//             remaining_qty = parseFloat(row.querySelector("input[name='remaining_qty[]']")?.value) || 0;
//             //  alert(remaining_qty);
//             remaining_qtys_olds = parseFloat(row.querySelector("input[name='remaining_qty_old[]']")?.value) || 0;

//             // alert(remaining_qtys_olds);
//             already_assign_qty = parseFloat(row.querySelector("input[name='already_assign_qty[]']")?.value) || 0;
          
//         }

//         // Split dc numbers
//         let dc_numbers = dc_no_str.split(",").map(dc => dc.trim()).filter(dc => dc.length > 0);
//         let dc_count = dc_numbers.length;

//         // Avoid division by zero
//         if (dc_count === 0) return;

//         let split_qty = parseFloat((qty / dc_count).toFixed(2));
//         let split_tax = parseFloat((tax_amount / dc_count).toFixed(2));
//         let split_total = parseFloat((total_amount / dc_count).toFixed(2));

//         // Loop through each DC and send AJAX request
//         dc_numbers.forEach(function (dc_no) {
//             let data = {
//                 "rate": rate,
//                 "gst": gst,
//                 "qty": split_qty,
//                 "partial_qty": partial_qty,
//                 "remaining_qty": remaining_qty,
//                 "remaining_qtys_olds": remaining_qtys_olds,
//                 "already_assign_qty": already_assign_qty,
//                 "tax_amount": split_tax,
//                 "total_amount": split_total,
//                 "po_unique_id": po_unique_id,
//                 "product_unique_id": product_unique_id,
//                 "item_code": item_code,
//                 "product": product,
//                 "dc_no": dc_no,
//                 "assign_no": assign_no,
//                 "assigned_qty":assigned_qty,
//                 "assign_date": assign_date,
//                 "time_line": time_line,
//                 "eng_type": eng_type,
//                 "eng_name": eng_name,
//                 "date": date,
//                 "ins_date": ins_date,
//                 "po_num": po_num,
//                 "inv_no": inv_no,
//                 "gst_type": gstType,
//                 "partial_sts":partial_sts,
//                 "ven_partial_no" :ven_partial_no,
//                 "action": "vendor_bill"
//             };

//             $.ajax({
//                 type: "POST",
//                 url: ajax_url,
//                 data: data,
//                 success: function (response) {
                  
//                   // var if()
//                   if(partial_sts == '0'){

//                     sweetalert('create', url);
//                     main_vendor_update();

//                   }
//                   else if(partial_sts == '1'){
//                     main_vendor_update();

//                     Swal.fire({
//                   icon: 'success',
//                   text: 'Partially Allocated',
//                   confirmButtonText: 'OK',
//                   timer: 2000,
//               }).then((result) => {
//                   if (result.isConfirmed) {
//                       window.location.href = url; // redirect to list page
//                   }
//               });
//                   }



//                   // return;
//                     console.log("Stored for DC:", dc_no);
//                 },
//                 error: function (err) {
//                     console.error("Failed for DC:", dc_no, err);
//                 }
//             });
//         });
//     });

//     }

   


   
// }
function submitvendor_update() {
    const url = sessionStorage.getItem("list_link");
    const ajax_url = sessionStorage.getItem("folder_crud_link");

    const assign_no = $("#assign_no").val();
    const assign_date = $("#assign_date").val();
    const time_line = $("#timeline").val();
    const eng_type = $("#eng_type").val();
    const eng_name = $("#eng_name").val();
    const ins_date = $("#ins_date").val();
    const po_num = $("#po_num option:selected").text().trim();
    const inv_no = $("#inv_num").val();
    const bulk_status = $("#bulk_status").val() || 1;
    const gstType = $("#gst_type").val();
    const ven_partial_no = $("#ven_partial_no").val();
    const date = assign_date;

    if (!eng_type) {
        Swal.fire({
            icon: "warning",
            text: "Please select Engineer Type"
        });
        return;
    }

    if (!eng_name) {
        Swal.fire({
            icon: "warning",
            text: "Please select Engineer Name"
        });
        return;
    }

    if (!po_num || po_num === "Select PO Number") {
        Swal.fire({
            icon: "warning",
            text: "Please select PO Number"
        });
        return;
    }

    if (!inv_no) {
        Swal.fire({
            icon: "warning",
            text: "Please select Invoice Number"
        });
        return;
    }

    const checkedBoxes = document.querySelectorAll(".myCheck:checked");
    if (checkedBoxes.length === 0) {
        Swal.fire({
            icon: "warning",
            text: "Please select at least one DC"
        });
        return;
    }

    let partial_sts = "0";
    if (checkedBoxes.length > 0) {
        partial_sts = checkedBoxes[0].dataset.partialSts || checkedBoxes[0].getAttribute("data-partial-sts") || "0";
    }

    const rows = document.querySelectorAll("#product_details_datatable tbody tr");

    if (rows.length === 0) {
        Swal.fire({
            icon: "warning",
            text: "No product details found"
        });
        return;
    }

    let requests = [];
    let hasError = false;

    rows.forEach(function (row, index) {
        if (hasError) return;

        let qty = parseFloat(row.querySelector(".qty")?.textContent.trim()) || 0;
        let gst = (gstType === "1") ? 18 : 0;

        let tax_amount = parseFloat(row.querySelector(".tax_amount")?.textContent.trim()) || 0;
        let total_amount = parseFloat(row.querySelector(".total_amount")?.textContent.trim()) || 0;

        let po_unique_id = row.querySelector(".ven_po_unique_id")?.value || '';
        let product_unique_id = row.querySelector(".ven_product_unique_id")?.value || '';
        let item_code = row.querySelector(".ven_item_code")?.value || '';
        let product = row.querySelector(".ven_product")?.value || '';
        let dc_no_str = row.querySelector(".ven_dc_no")?.value || '';
        let rate = parseFloat(row.querySelector("input[name='rate[]']")?.value) || 0;

        let partial_qty = 0;
        let remaining_qty = 0;
        let remaining_qtys_olds = 0;
        let already_assign_qty = 0;
        let assigned_qty = 0;

        if (!product_unique_id || !item_code || !dc_no_str) {
            console.warn("Missing product/DC data in row:", index + 1);
            return;
        }

        if (partial_sts === '0') {
            assigned_qty = qty;
            partial_qty = qty;
            remaining_qty = 0;
        } else {
            partial_qty = parseFloat(row.querySelector("input[name='partial_qty[]']")?.value) || 0;
            remaining_qty = parseFloat(row.querySelector("input[name='remaining_qty[]']")?.value) || 0;
            remaining_qtys_olds = parseFloat(row.querySelector("input[name='remaining_qty_old[]']")?.value) || 0;
            already_assign_qty = parseFloat(row.querySelector("input[name='already_assign_qty[]']")?.value) || 0;

            assigned_qty = partial_qty;

            if (partial_qty <= 0) {
                hasError = true;
                Swal.fire({
                    icon: "warning",
                    text: "Please enter Assign Qty for all selected partial rows"
                });
                return;
            }

            if (assigned_qty > qty && remaining_qtys_olds <= 0) {
                hasError = true;
                Swal.fire({
                    icon: "error",
                    text: "Assign Qty cannot be greater than Qty"
                });
                return;
            }
        }

        if (rate <= 0) {
            hasError = true;
            Swal.fire({
                icon: "warning",
                text: "Please enter Rate for all products"
            });
            return;
        }

        let dc_numbers = dc_no_str.split(",").map(dc => dc.trim()).filter(dc => dc.length > 0);
        let dc_count = dc_numbers.length;

        if (dc_count === 0) {
            console.warn("No DC numbers found for row:", index + 1);
            return;
        }

        let split_qty = parseFloat((qty / dc_count).toFixed(2));
        let split_tax = parseFloat((tax_amount / dc_count).toFixed(2));
        let split_total = parseFloat((total_amount / dc_count).toFixed(2));

        let split_assigned_qty = partial_sts === '0'
            ? parseFloat((assigned_qty / dc_count).toFixed(2))
            : parseFloat((assigned_qty / dc_count).toFixed(2));

        let split_partial_qty = partial_sts === '0'
            ? parseFloat((partial_qty / dc_count).toFixed(2))
            : parseFloat((partial_qty / dc_count).toFixed(2));

        let split_remaining_qty = partial_sts === '0'
            ? 0
            : parseFloat((remaining_qty / dc_count).toFixed(2));

        let split_old_remaining_qty = partial_sts === '0'
            ? 0
            : parseFloat((remaining_qtys_olds / dc_count).toFixed(2));

        let split_already_assign_qty = partial_sts === '0'
            ? 0
            : parseFloat((already_assign_qty / dc_count).toFixed(2));

        dc_numbers.forEach(function (dc_no) {
            let data = {
                action: "vendor_bill",
                rate: rate,
                gst: gst,
                gst_type: gstType,
                qty: split_qty,
                partial_qty: split_partial_qty,
                remaining_qty: split_remaining_qty,
                remaining_qtys_olds: split_old_remaining_qty,
                already_assign_qty: split_already_assign_qty,
                tax_amount: split_tax,
                total_amount: split_total,
                po_unique_id: po_unique_id,
                product_unique_id: product_unique_id,
                item_code: item_code,
                product: product,
                dc_no: dc_no,
                assign_no: assign_no,
                assigned_qty: split_assigned_qty,
                assign_date: assign_date,
                time_line: time_line,
                eng_type: eng_type,
                eng_name: eng_name,
                date: date,
                ins_date: ins_date,
                po_num: po_num,
                inv_no: inv_no,
                partial_sts: partial_sts,
                ven_partial_no: ven_partial_no,
                bulk_status: bulk_status
            };

            requests.push(
                $.ajax({
                    type: "POST",
                    url: ajax_url,
                    data: data
                })
            );
        });
    });

    if (hasError) return;
    if (requests.length === 0) {
        Swal.fire({
            icon: "warning",
            text: "No valid rows found to submit"
        });
        return;
    }

    $.when.apply($, requests)
        .done(function () {
            try {
                main_vendor_update();
            } catch (e) {
                console.warn("main_vendor_update() not found or failed", e);
            }

            if (partial_sts === '0') {
                sweetalert('create', url);
            } else {
                Swal.fire({
                    icon: 'success',
                    text: 'Partially Allocated',
                    confirmButtonText: 'OK',
                    timer: 2000
                }).then((result) => {
                    if (result.isConfirmed || result.dismiss === Swal.DismissReason.timer) {
                        window.location.href = url;
                    }
                });
            }
        })
        .fail(function (xhr, status, error) {
            console.error("Submit failed:", error, xhr.responseText);
            Swal.fire({
                icon: "error",
                text: "Failed to store vendor allocation"
            });
        });
}

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