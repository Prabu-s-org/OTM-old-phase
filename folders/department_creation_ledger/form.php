<!-- This file Only PHP Functions -->
<?php include 'function.php'; ?>

<?php
// Form variables
$btn_text = "Save";
$btn_action = "create";
$is_btn_disable = "";

$unique_id = "";

$user_type = "";
$under_user_type = "";
$exp_under_user_type = "";

$is_active = 1;

if (isset($_GET["unique_id"])) {
    if (!empty($_GET["unique_id"])) {

        // $uni_dec = str_replace(" ", "+", $_GET['unique_id']);
        // $get_uni_id           = openssl_decrypt(base64_decode($uni_dec), $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv);

        $unique_id = $_GET["unique_id"];
        $where = [
            "unique_id" => $unique_id
        ];


        $table = "department_creation";

        $columns = [

            "department",
            "description",
            "ledger_name",
            "ledger_no",
            "empty",
            "is_active"
        ];

        $table_details = [
            $table,
            $columns
        ];

        $result_values = $pdo->select($table_details, $where);

        if ($result_values->status) {

            $result_values = $result_values->data;


            $department = $result_values[0]["department"];
            $description = $result_values[0]["description"];
            $ledger_name = $result_values[0]["ledger_name"];
            $ledger_no = $result_values[0]["ledger_no"];
            $empty = $result_values[0]["empty"];

            $is_active = $result_values[0]["is_active"];

            // $exp_under_user_type  = explode(",", $under_user_type);

            $btn_text = "Update";
            $btn_action = "update";
        } else {
            $btn_text = "Error";
            $btn_action = "error";
            $is_btn_disable = "disabled='disabled'";
        }
    }
}

if($_GET["unique_id"] != ''){
    $unique_id =$_GET["unique_id"];
}else{
    $prefix    = "";
    $unique_id = unique_id($prefix);
    
}


$active_status_options = active_status($is_active);

?>




<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Department Creation</h4>
            </div>
            <div class="card-body">
                <form class="was-validated" autocomplete="off">
                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label class="form-label">Department </label>
                                        <input type="text" id="department" name="department" class="form-control"
                                            value="<?php echo $department; ?>" required>

                                    </div>
                                </div><!-- end col -->

                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label class="form-label">Description</label>

                                        <textarea name="description" id="description"
                                            value="<?php echo $description; ?>"
                                            class="form-control"><?php echo $description; ?></textarea>
                                    </div>
                                </div><!-- end col -->
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label class="form-label">Ledger Name</label>
                                        <input type="text" id="ledger_name" name="ledger_name" class="form-control"
                                            value="<?php echo $ledger_name; ?>" required >

                                    </div>
                                </div><!-- end col -->
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label class="form-label">Ledger No</label>
                                        <input type="text" id="ledger_no" name="ledger_no" class="form-control"
                                            value="<?php echo $ledger_no; ?>" >
                                            <input type="hidden" id="sub_unique_id" name="sub_unique_id" class="form-control"
                                          required   >
                                    </div>
                                </div><!-- end col -->
                                
                                    
                                        <!-- <label class="form-label">Ledger No</label> -->
                                        <input type="hidden" id="empty" name="empty" class="form-control"
                                            value="<?php echo $empty; ?>" >

                              
                                

                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label class="form-label">Active Status</label>
                                        <select name="is_active" id="is_active" class="select2 form-control" required>
                                            <?php echo $active_status_options; ?>
                                        </select>
                                    </div>
                                </div><!-- end col -->
                                <input type="hidden" id="form_main_unique_id" name="form_main_unique_id" value="<?php echo $unique_id; ?>">
                                <input type="hidden" id="demo" name="demo"
                            value="<?php if($update_unique_id !=''){ echo  $update_unique_id;}else{ echo $unique_id;} ?>">


                                <div class="col-xl-3 ">
                                                        <div class="mb-3">
                                                            <!--<input type='text' name="no_of_po" id="no_of_po" value="<?php echo $no_of_po; ?>">-->
                                                            <button type="button" id="pro_details"
                                                                class="btn btn-success btn-label department_details_add_update_btn"  
                                                                onclick="department_details_add_update(),get_department()"><i
                                                                    class="lab la as la-plus-circle label-icon align-middle fs-16 me-2"></i>
                                                                Add New</button>

                                                        </div>
                                                    </div><!-- end col -->
                                                    <input type="hidden" name="stored_item" id="stored_item">
                                                        <input type="hidden" name="count_item" id="count_item">
                                                    

                                                    <div class="table-responsive mb-4">
                                                        <div id="department_details_datatable_wrapper"
                                                            class="dataTables_wrapper dt-bootstrap5 no-footer">
                                                            <div class="row">
                                                                <div class="col-sm-12 col-md-6"></div>
                                                                <div class="col-sm-12 col-md-6"></div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-lg-6">
                                                                    <table id="department_details_datatable"
                                                                        class="table table-hover table-bordered align-middle mb-0 dataTable no-footer"
                                                                        width="50%" style="width: 50%;">
                                                                        <thead class="table-light">
                                                                            <tr>
                                                                                <th class="sorting_disabled text-center"
                                                                                    rowspan="1" colspan="1"
                                                                                    style="width: 0px;">
                                                                                    ID </th>
                                                                                    <!-- <th class="sorting_disabled text-center"
                                                                                    rowspan="1" colspan="1"
                                                                                    style="width: 0px;">
                                                                                    Department</th>
                                                                                <th scope="col" class="sorting_disabled"
                                                                                    rowspan="1" colspan="1"
                                                                                    style="width: 0px;">
                                                                                    Description</th> -->
                                                                                <th scope="col" class="sorting_disabled"
                                                                                    
                                                                                    style="width:  0px;">
                                                                                    Ledger Name</th>
                                                                                <th scope="col" class="sorting_disabled"
                                                                                    rowspan="1" colspan="1"
                                                                                    style="width: 0px;">
                                                                                    Ledger No</th>
                                                                                
                                                                          
                                                                                
                                                                                <th scope="col"
                                                                                    class="sorting_disabled text-center"
                                                                                    rowspan="1" colspan="1"
                                                                                    style="width: 0px;">
                                                                                    Action </th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        </tbody>
                                                                    </table>
                                                          
                                                                    <!-- <div id="department_details_datatable_processing"
                                                                        class="dataTables_processing card"
                                                                        style="display: none;">
                                                                        
                                                                    </div> -->
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-sm-12 col-md-5"></div>
                                                                <div class="col-sm-12 col-md-7"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                               
                            </div>
                            <div class="form-group row ">
                                <div class="col-md-12" align="right">
                                    <!-- Cancel,save and update Buttons -->
                                    <?php echo btn_cancel($btn_cancel); ?>
                                    <?php echo btn_createupdate($folder_name_org, $unique_id, $btn_text); ?>
                                </div>
                            </div>
                        </div>
                </form>

            </div> <!-- end card-body -->
        </div> <!-- end card -->
    </div><!-- end col -->
</div>

 
<script>

$(document).ready(function () {
    sub_list_datatable("department_details_datatable");
               
});

function department_details_add_update(unique_id = "") { // au = add,update
    // alert();
    var internet_status = is_online();
   
                var form_class = "department_creation_sublist";
                var is_form = form_validity_check(form_class);
    // var is_form = form_validity_check("product_details_form");

    // console.log(is_form);
    var department = document.getElementById('department').value;
    var description = document.getElementById('description').value;
    var ledger_name = document.getElementById('ledger_name').value;
    var ledger_no = document.getElementById('ledger_no').value;
// alert(po_name);
    var form_main_unique_id = document.getElementById('form_main_unique_id').value;
    var sub_unique_id = document.getElementById('sub_unique_id').value;
        // data.append("unique_id", unique_id);
// alert(form_main_unique_id);
    // if (is_form) {

    // var data = $(".product_details_form").serialize();
    var data = "department=" + department + "&description=" + description + "&ledger_name=" + ledger_name + "&ledger_no=" + ledger_no + 
    "&form_main_unique_id=" + form_main_unique_id;
    data += "&sub_unique_id=" + sub_unique_id + "&action=department_details_add_update";
// alert(unique_id);
    var ajax_url = sessionStorage.getItem("folder_crud_link");
    // var url      = sessionStorage.getItem("list_link");
    var url = "";

    // console.log(data);
    $.ajax({
        type: "POST",
        url: ajax_url,
        data: data,
        beforeSend: function() {
            $(".department_details_add_update").attr("disabled", "disabled");
            $(".department_details_add_update").text("Loading...");
        },
        success: function(data) {

            var obj = JSON.parse(data);
            var msg = obj.msg;
            var status = obj.status;
            var error = obj.error;

            if (!status) {
                $(".department_details_add_update").text("Error");
                // console.log(error);
            } else {
                if (msg !== "department") {
                    form_reset("department_creation_sublist_form");
                }
                if (msg == "department") {
                    sweetalert(msg);
                }
                $(".department_details_add_update").removeAttr("disabled", "disabled");
                if (unique_id && msg == "already") {
                    $(".department_details_add_update").text("Update");
                } else {
                    form_reset("department_creation_sublist_form");
                    $(".department_details_add_update").text("Add");
                    $(".department_details_add_update").attr("onclick",
                        "department_creation_sublist_add_update('')");
                }
                // get_department_sublist_count();
                // Init Datatable
                sub_list_datatable("department_details_datatable");
            }
       

                
            document.getElementById('department').value = '';
            document.getElementById('description').value = '';
            document.getElementById('ledger_name').value = '';
            document.getElementById('ledger_no').value = '';

           
            
            //   var div_contents =document.getElementById("div1");
            //     var elements = div_contents.getElementsByTagName("select");
            // var elements = getElementById("tax");
            //   for (i=0; i<elements.length; i++) {
            //     elements[i].selectedIndex = -1; 
            //   }
         sweetalert(msg, url);
           
        },
        error: function(data) {
            alert("Network Error");
        }
    });

    // } else {
    //     sweetalert("form_alert");
    // }
}

// get invoice update
function get_department(unique_id = "") {
		// alert('hi');
		var internet_status = is_online();
		if (!internet_status) {
			sweetalert("no_internet");
			return false;
		}
		// var consignee_unique_id = document.getElementById('consignee_unique_id').value;
		//	alert(consignee_unique_id);
		var form_main_unique_id = document.getElementById('form_main_unique_id').value;
	    var department =document.getElementById('department').value;
        // alert(department);
        var description = document.getElementById('description').value;
        // alert(description);
        var ledger_name = document.getElementById('ledger_name').value;
        // alert(ledger_name)
		var ledger_no = document.getElementById('ledger_no').value;
        
			// alert(ledger_no);
		var data = new FormData();
		data.append("form_main_unique_id", form_main_unique_id);
		
		data.append("department", department);
        data.append("description", description);
		data.append("ledger_name", ledger_name);
		data.append("ledger_no", ledger_no);
        
	
		data.append("action", "editupdate");
		var is_form = form_validity_check("was-validated");
		if (is_form) {
			// var data 	 = $(".was-validated").serialize();
			// data 		+= "&unique_id="+unique_id+"&action=demo";
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
				// beforeSend 	: function() {
				// 	$(".createupdate_btn").attr("disabled","disabled");
				// 	$(".createupdate_btn").text("Loading...");
				// },
				success: function (data) {
					var obj = JSON.parse(data);
					var msg = obj.msg;
					var status = obj.status;
					var error = obj.error;
					if (!status) {
						url = '';
						$(".createupdate_btn").text("Error");
						console.log(error);
					} else {
						if (msg == "already") {
							// Button Change Attribute
							url = '';
							$(".createupdate_btn").removeAttr("disabled", "disabled");
							if (unique_id) {
								$(".createupdate_btn").text("Update");
							}
						}
					}
					sweetalert(msg, url);
				},
				error: function (data) {
					alert("Network Error");
				}
			});
		}
		// else {
		//     sweetalert("form_alert");
		// }
	}

    function department_details_edit(unique_id = "") {
    if (unique_id) {
        // alert(unique_id);
        var data = "unique_id=" + unique_id + "&action=department_details_edit";
        // alert(data);

        var ajax_url = sessionStorage.getItem("folder_crud_link");
        // var url      = sessionStorage.getItem("list_link");
        var url = "";

        // console.log(data);
        $.ajax({
            type: "POST",
            url: ajax_url,
            data: data,
            beforeSend: function() {
                $(".department_details_add_update").attr("disabled", "disabled");
                $(".department_details_add_update").text("Loading...");
            },
            success: function(data) {
                // alert(data);

                var obj = JSON.parse(data);
                var data = obj.data;
                var msg = obj.msg;
                var status = obj.status;
                var error = obj.error;

                if (!status) {
                    $(".department_details_add_update").text("Error");
                    console.log(error);
                } else {
                    // console.log(obj);
         
                    // var department = data.department;
                    // var con_district = data.district_name;
                    var ledger_name = data.ledger_name;
                   
                    var ledger_no = data.ledger_no;
                    var unique_id = data.unique_id;
            //         var ledger_name = document.getElementById('ledger_name').value;
			// var ledger_no = document.getElementById('ledger_no').value;
                    // alert(ledger_no);
                    // if ($("#unique_id option[value='" + con_district + "']").length === 0) {
                    //     $("#con_district").append($('<option>', {
                    //         value: district_unique_id,
                    //         text: con_district
                    //     }));
                    // }
                    // $("#department").val(department);
              
                    $("#ledger_name").val(ledger_name);
                   
                    $("#ledger_no").val(ledger_no);
                    $("#sub_unique_id").val(unique_id);
                   
                    
                    // Button Change 
                    $(".department_details_add_update").removeAttr("disabled", "disabled");
                    $(".department_details_add_update").text("Update");
                    $(".department_details_add_update").attr("onclick", "department_details_add_update('" + unique_id + "')");
                }
            },
            error: function(data) {
                alert("Network Error");
            }
        });
    }
}
function department_details_delete(unique_id = "") {
    if (unique_id) {

        var ajax_url = sessionStorage.getItem("folder_crud_link");
        var url = sessionStorage.getItem("list_link");

        confirm_delete('delete')
            .then((result) => {
                if (result.isConfirmed) {

                    var data = {
                        "unique_id": unique_id,
                        "action": "department_details_delete"
                    }

                    $.ajax({
                        type: "POST",
                        url: ajax_url,
                        data: data,
                        success: function(data) {

                            var obj = JSON.parse(data);
                            var msg = obj.msg;
                            var status = obj.status;
                            var error = obj.error;

                            if (!status) {
                                url = '';
                            } else {
                                sub_list_datatable("department_details_datatable");
                            }
                            sweetalert(msg, url);
                        }
                    });

                } 
                
            });
    }
}

// function get_department_sublist_count(){

// var uni_id=document.getElementById('form_main_unique_id').value;
//     var data = "uni_id=" + uni_id + "&action=check_department";
//     var ajax_url = sessionStorage.getItem("folder_crud_link");

//     $.ajax({
//                 type: "POST",
//                 url: ajax_url,
//                 data: data,
//                 success: function(data) {
            
//                     var obj = JSON.parse(data);
                    
//                      document.getElementById('stored_item').value = obj.data[0];
//                      get_po_item();
//                 }
//             });
// }
// function get_department(){

// var uni_id=document.getElementById('form_main_unique_id').value;

//     var data = "uni_id=" + uni_id + "&action=department_cre";
//     var ajax_url = sessionStorage.getItem("folder_crud_link");

//     $.ajax({
//                 type: "POST",
//                 url: ajax_url,
//                 data: data,
//                 success: function(data) {
            
//                     var obj = JSON.parse(data);
                    
//                      document.getElementById('count_item').value = obj.data[0];

//                      get_department_checking();
//                 },
//             });
            
// }
// function get_department_checking(){

// var x = document.getElementById('stored_item').value;
// var y = document.getElementById('count_item').value;
// }



</script>
