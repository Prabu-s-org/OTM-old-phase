

var company_name 	= sessionStorage.getItem("company_name");  
var company_address	= sessionStorage.getItem("company_name");
var company_phone 	= sessionStorage.getItem("company_name");
var company_email 	= sessionStorage.getItem("company_name");
var company_logo 	= sessionStorage.getItem("company_name");

var form_name 		= 'user';
var form_header		= '';
var form_footer 	= '';
var table_name 		= '';
var table_id 		= 'user_datatable';
var action 			= "datatable";


$(document).ready(function () { 
	// var table_id 	= "user_datatable";
	init_datatable(table_id,form_name,action);
    get_user_permission();

});


function user_cu(unique_id = "") {

    var internet_status  = is_online();

    if (!internet_status) {
        sweetalert("no_internet");
        return false;
	}
	
	var password 		= $("#password").val();
	var con_password 	= $("#confirm_password").val();

	if (password !== con_password) {
		sweetalert("custom","","","Password Dosen't Match");
		return false;
	}

    var is_form = form_validity_check("was-validated");
    // alert(is_form);

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
				var user_unique_id   = obj.unique_id;
				// file_upload(user_unique_id);
				if (!status) {
					url 	= '';
                    $(".createupdate_btn").text("Error");
                    // console.log(error);
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


function file_upload(unique_id = "") { 
    // alert(unique_id);
    var internet_status = is_online();

    if (!internet_status) {
        sweetalert("no_internet");
        return false;
    }

    var is_form = form_validity_check("was-validated");

    if (is_form) {

        var file_data = $('#doc_upload').prop('files')[0];
        var data = new FormData();
        console.log(data);

        data.append("action", "image_upload");
        data.append("unique_id", unique_id);
        data.append("test_file", file_data);

        console.log(typeof data);

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
            beforeSend: function() {
                // $(".createupdate_btn").attr("disabled","disabled");
                $(".createupdate_btn").text("Loading...");
            },
            success: function(data) {

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
                        } else {
                            $(".createupdate_btn").text("Save");
                        }
                    }
                }
                // sweetalert(msg,url);
            },
            error: function(data) {
                alert("Network Error");
            }
        });


    } else {
        sweetalert("form_alert");
    }
}

function init_datatable(table_id='',form_name='',action='') {

if ($.fn.DataTable.isDataTable('#' + table_id)) {
        $('#' + table_id).DataTable().destroy(); // Destroy previous instance
    }
	var table = $("#"+table_id);
    var screen_id_val = $('#screen_id_val').val();
	// alert(screen_id_val);
	var user_type_unique_id = $('#user_type_unique_id').val();
	var data 	  = {
		"action"	: action, 
        "screen_id_val": screen_id_val,
		"usertype": user_type_unique_id,
	};
	var ajax_url = sessionStorage.getItem("folder_crud_link");

	var datatable = table.DataTable({
		ordering    : true,
		searching   : true,
		destroy: true,
      	        responsive: true,
		"ajax"		: {
			url 	: ajax_url,
			type 	: "POST",
			data 	: data
		}
	});
}



function get_user_permission() {
	var screen_id_val = $('#screen_id_val').val();

	var user_type_unique_id = $('#user_type_unique_id').val();

	var data = {
		"screen_id_val": screen_id_val,
		"user_type_unique_id": user_type_unique_id,
		"action": 'user_permission',
	};

	var ajax_url = sessionStorage.getItem("folder_crud_link");
	var url = sessionStorage.getItem("list_link");

	// console.log(data);
	$.ajax({
		type: "POST",
		url: ajax_url,
		data: data,
		success: function (data) {

			var obj = JSON.parse(data);

			var dataString = obj.data;

			console.log(dataString);

			var addButton = document.getElementById('add_btn');
			if (dataString.includes('5f8807ff00bf726601')) {
				addButton.style.visibility = 'visible';  // Show the button
			} else {
				addButton.style.visibility = 'hidden';   // Hide the button but keep its space
			}
			var listpage = document.getElementById('list');
			if (dataString.includes('5f88083fd50a344823')) {
				listpage.style.visibility = 'visible';  // Show the button
			} else {
				listpage.style.visibility = 'hidden';   // Hide the button but keep its space
			}


		},
		error: function (data) {
			alert("Network Error");
		}
	});
}

function user_delete(unique_id = "") {

	var ajax_url = sessionStorage.getItem("folder_crud_link");
	var url      = sessionStorage.getItem("list_link");
	
	confirm_delete('delete')
	.then((result) => {
		if (result.isConfirmed) {

			var data = {
				"unique_id" 	: unique_id,
				"action"		: "delete"
			}

			$.ajax({
				type 	: "POST",
				url 	: ajax_url,
				data 	: data,
				success : function(data) {

					var obj     = JSON.parse(data);
					var msg     = obj.msg;
					var status  = obj.status;
					var error   = obj.error;

					if (!status) {
						url 	= '';
						
					} else {
						init_datatable(table_id,form_name,action);
					}
					sweetalert(msg,url);
				}
			});

		} else {
			// alert("cancel");
		}
	});
}

// function get_under_users (under_user = "") {

// $("#under_user_name").html('');
// 	var ajax_url = sessionStorage.getItem("folder_crud_link");

// 	if (under_user) {
// 		var data = {
// 			"under_user" 	: under_user,
// 			"action"	: "user_options"
// 		}

// 		$.ajax({
// 			type 	: "POST",
// 			url 	: ajax_url,
// 			data 	: data,
// 			success : function(data) {

// 				if (data) { 
// 					$("#under_user_name").html(data);
// 				}

// 			}
// 		});
// 	}
// }


  
function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}

// function get_under_user_ids()
// {
// 	var under_user= $('#under_user_name').val();
// 	$('#under_user').val(under_user);
// }

// function get_team_users_ids()
// {
// 	var under_user= $('#team_users_name').val();
// 	$('#team_users').val(under_user);
// }

// $(document).ready(function () {
// 	$("#confirm_password").change(function() { 
//    var password = $("#password").val();
//    var confirmPassword = $("#confirm_password").val();

// 	    if (password !== confirmPassword)
// 	    {
// 	       alert("Confirm Password Doesn't match with Password");
// 	       $("#confirm_password").focus();
// 	    }
//     });
// });



// Get Group Names Based On Category Selection
function get_mobile_no(staff_id = "") {


	var ajax_url = sessionStorage.getItem("folder_crud_link");


	if (staff_id) {
		var data = {
			"staff_id": staff_id,
			"action": "mobile"
		}

		$.ajax({
			type: "POST",
			url: ajax_url,
			data: data,
			success: function (data) {

				if (data) {
					// $("#phone_no").html(data);
				document.getElementById('phone_no').value = data;

				}

				
			}
		});
	}
}




$(document).on('click', '#upload-aphoto', function () {
    document.getElementById('selectedFile').click();
});

$('#selectedFile').change(function () {
    if (this.files[0] == undefined)
      return;
    $('#imageModalContainer').modal('show');
    let reader = new FileReader();
    reader.addEventListener("load", function () {
      window.src = reader.result;
      $('#selectedFile').val('');
    }, false);
    if (this.files[0]) {
      reader.readAsDataURL(this.files[0]);
    }
});

let croppi;
$('#imageModalContainer').on('shown.bs.modal', function () {
  let width = document.getElementById('crop-image-container').offsetWidth - 20;
  $('#crop-image-container').height((width - 80) + 'px');
    croppi = $('#crop-image-container').croppie({
      viewport: {
        width: width,
        height: width 
      },
    });
  $('.modal-body1').height(document.getElementById('crop-image-container').offsetHeight + 50 + 'px');
  croppi.croppie('bind', {
    url: window.src,
  }).then(function () {
    croppi.croppie('setZoom', 0);
  });
});
$('#imageModalContainer').on('hidden.bs.modal', function () {
  croppi.croppie('destroy');
});

$(document).on('click', '.save-modal', function (ev) {
  croppi.croppie('result', {
    type: 'base64',
    format: 'jpeg',
    size: 'original'
  }).then(function (resp) {
      $('#confirm-img').attr('src', resp);
      $('.modal').modal('hide');
  });
});



$(document).ready(function(){

    var $modal = $('#modal');

    var image = document.getElementById('sample_image');

    var cropper;

    $('#upload_image').change(function(event){
        var files = event.target.files;

        var done = function(url){
            image.src = url;
            $modal.modal('show');
        };

        if(files && files.length > 0)
        {
            reader = new FileReader();
            reader.onload = function(event)
            {
                done(reader.result);
            };
            reader.readAsDataURL(files[0]);
        }
    });

    $modal.on('shown.bs.modal', function() {
        cropper = new Cropper(image, {
            aspectRatio: 1,
            viewMode: 3,
            preview:'.preview'
        });
    }).on('hidden.bs.modal', function(){
        cropper.destroy();
        cropper = null;
    });

    $('#crop').click(function(){
        canvas = cropper.getCroppedCanvas({
            width:400,
            height:400
        });

        canvas.toBlob(function(blob){
            url = URL.createObjectURL(blob);
            var reader = new FileReader();
            reader.readAsDataURL(blob);
            reader.onloadend = function(){
                var base64data = reader.result;
                $.ajax({
                    url:'upload.php',
                    method:'POST',
                    data:{image:base64data},
                    success:function(data)
                    {
                        $modal.modal('hide');
                        $('#uploaded_image').attr('src', data);
                        const myArray = data.split("/");
                        $("#profile_image").val(myArray[2]);
                    }
                });
            };
        });
    });
    
});




