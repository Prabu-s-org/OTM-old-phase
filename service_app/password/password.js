
var company_name 	= sessionStorage.getItem("company_name");
var company_address	= sessionStorage.getItem("company_name");
var company_phone 	= sessionStorage.getItem("company_name");
var company_email 	= sessionStorage.getItem("company_name");
var company_logo 	= sessionStorage.getItem("company_name");

var form_name 		= 'User Type'; 
var form_header		= '';
var form_footer 	= '';
var table_name 		= '';

function password_cu(unique_id = "") {

    var internet_status  = is_online();

    if (!internet_status) {
        sweetalert("no_internet");
        return false;
    }
 
	var new_password 		= $("#new_password").val();
	var con_password 	    = $("#confirm_password").val(); 
	var old_password 	    = $("#old_password").val(); 
	// var image_name 	        = $("#image_name").val();

	if (new_password != con_password) {
		sweetalert("custom","","","Confirm Password Dosen't Match");
		return false;
	}
	//alert(old_password); alert(image_name);

    //var is_form = form_validity_check("was-validated");

    if ((old_password)||(image_name)) {

        var data 	 = $(".was-validated").serialize();
        data 		+= "&unique_id="+unique_id+"&action=createupdate";

        var ajax_url = sessionStorage.getItem("folder_crud_link");
        var url      = "";

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
				} else{
						sweetalert("custom","","","Old Password Was Not Correct");
						$(".createupdate_btn").removeAttr("disabled","disabled");
						$(".createupdate_btn").text("Save");
						
				}
				if(msg == "update") {
				sweetalert(msg,"","","Successfully Saved");
				window.location.href = "logout.php";
				}	
				
			},
			error 		: function(data) {
				alert("Network Error");
			}
		});


    } else {
        sweetalert("password_alert");
    }
}

