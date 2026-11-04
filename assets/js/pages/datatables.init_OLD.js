$(document).ready(function() {
    $('#example').DataTable();
    $('#scroll-vertical').DataTable({
        scrollY: "210px",
        scrollCollapse: true,
        paging: false
    });
    $('#scroll-horizontal').DataTable({
        scrollX: true
    });
    $('#alternative-pagination').DataTable({
        pagingType: "full_numbers"
    });
    $('#fixed-header').DataTable({
        fixedHeader: true
    });
    $('#buttons-datatables').DataTable({
        dom: "Bfrtip",
        buttons: ["copy", "csv", "excel", "print", "pdf"]
    });
    $('#ajax-datatables').DataTable({
        ajax: "assets/json/datatable.json"
    });
});
