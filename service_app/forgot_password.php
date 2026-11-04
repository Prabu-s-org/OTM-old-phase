<?php include 'header.php'?>
<style>
body {
    overflow: hidden;
}
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- Include SweetAlert CSS and JavaScript -->
<link rel="stylesheet" href="https://unpkg.com/sweetalert/dist/sweetalert.css">
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Include SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Include jQuery if not already included -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Your custom styles and scripts -->
</head>



<!-- $warning_msg           = "";
$old_readonly          = "";
$old_password          = "";
$new_password          = "";
$confirm_password       = "";
$is_active             = 1; -->


<?php
// include('session.php');
// include '../../config/dbconfig.php';
include '../config/dbconfig.php';
session_start();

error_reporting(0);
session_start();
include('session.php');


$usertype= $_SESSION["user_type_unique_id"];
// print_r($usertype);die();
$eng_name= $_SESSION["eng_unique_id"];

$table = "view_eng_data";
$where = "user_type_unique_id='" . $usertype . "' AND engineer_name='".$eng_name ."'";
$columns = [
    "(select staff_name from user  where unique_id=$table.engineer_name) AS engineer_name",
    "designation_id",
    "(select staff_id from user  where unique_id=$table.emp_id) AS emp_id",
    "user_type_unique_id",
	"password",
    "eng_unique_id",
	"unique_id",
];

$table_details = [$table, $columns];
$user_values = $pdo->select($table_details, $where);
// PRINT_R($user_values);

if ($user_values->status) {
    $user_values = $user_values->data;
    $user_type = $user_values[0]["user_type_unique_id"];
    $employee_name = $user_values[0]["engineer_name"];
    $emp_id = $user_values[0]["emp_id"];
    $eng_unique_id = $user_values[0]["eng_unique_id"];
	$unique_id = $user_values[0]["unique_id"];
	$password = $user_values[0]["password"];
	
} else {
    echo "No data found.";
    die();
}
?>
<?php 
if (isset($_GET["default"])) {
    $old_readonly   = "readonly";
    $old_password   = "password";
    // $warning_msg    = "Please Change Your Default password";
}
?>
<div class="over-page">
	<div class="login-bg">
	<img src="assets/img/login-img.png">
	<h3>Welcome to ELCOT</h3>
	<p>Reset your password</p>
	<div class="row">
	<div class="col-12">
	<ul class="bg-bubbles">
	
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		
	</ul>
	</div>
	</div>
	</div>
	<div class="container-fluid">
	<div class="login-form">
	 
	  <div class="row">
	  <div class="col-12 img-text">
		<input type="hidden" id="unique_id" name="unique_id" value="<?php echo $unique_id ?>">
		<label> <?php echo $employee_name ?></label>
	   <!-- <input type="text" name="" placeholder="Employee Name " class="input-group">  -->
	 <!-- <img src="assets/img/user.png"> -->
	  </div>
	  <div class="col-12 img-text">
		<label><?php echo $emp_id ?></label>
	   <!-- <input type="text" name="" placeholder="Emp Id" class="input-group">  -->
	 <!-- <img src="assets/img/user.png"> -->
	  </div>
	  <div class="col-12 img-text">
	   <input type="text" name="new_password" id="new_password" placeholder="New password " class="input-group"> 
	 <img src="assets/img/padlock.png">
	  </div>
	   <div class="col-12 img-text">
	   <input type="hidden" id="old_password" name="old_password" class="form-control" <?php echo $old_readonly; ?> value="<?php echo $password; ?>" maxlength="30" size="50">
	 <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm new password" class="input-group no-mar" >
<img src="assets/img/padlock.png">
	  </div>
	    <div class="col-12 sing-btn">
		<button  onclick="password_change();">Change Password</button>
	  </div>
	</div>
	</div>
</div>

<script>
	

</script>
<script>
  // Login only Sweeet Alert Functions
  function log_sweetalert(msg='',url='',callback ='') {
	// alert();
  
  switch (msg) {
	case "create":
	  Swal.fire({
		  icon: 'success',
		  title: 'Successfully Saved',
		  showConfirmButton: true,
		  timer: 2000,
		  timerProgressBar: true,
		  onClose: () => {
			window.location = url;
		  }
	  });
	break;

	case "success_login":
	  Swal.fire({
		  type: "success",
		  icon: 'success',
		  title: 'Successfully Login',
		  showConfirmButton: true,
		  timer: 2000,
		  onClose: () => {
			window.location = url;
		  }
	  });
	break;

	case "update":
	  Swal.fire({
		  icon: 'success',
		  title: 'Successfully Updated',
		  showConfirmButton: true,
		  timer: 2000,
		  timerProgressBar: true,
		  // onClose: () => {
		  //   window.location = url;
		  // }
	  });
	break;

	case "error":
	  Swal.fire({
		  icon: 'error',
		  title: 'Error Occured',
		  showConfirmButton: true,
		  timer: 2000,
		  timerProgressBar: true,
		  onClose: () => {
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
		  onClose: () => {
			// alert("Hi");
		  }
	  });
	break;

	

	case "already":
	  Swal.fire({
		  icon: 'warning',
		  title: 'Already Exist',
		  showConfirmButton: true,
		  timer: 2000,
		  timerProgressBar: true,
		  onClose: () => {
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
		  onClose: () => {
			// alert("Hi");
		  }
	  });
	break;

	case "delete":
	  return Swal.fire({
		title: 'Are you sure to Delete?',
		text: "You won't be able to revert this!",
		icon: 'warning',
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
		  showConfirmButton: true,
		  timer: 1500,
		  timerProgressBar: true
	  });
	break;

	case "form_alert":
	  Swal.fire({
		icon: 'info',
		title: 'Fill Out All Mantantory Fields',
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
		  onClose: () => {
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
		  onClose: () => {
			window.location = url;
		  }
	  });
  break;    

  case "incorrect":
	  Swal.fire({
		  icon: 'error',
		  title: 'Incorrect <br /> UserName Or Password',
		  // imageUrl:'img/emoji/invalid.webp',
		  showConfirmButton: true,
		  timer: 2000,
		  timerProgressBar: true,
		  onClose: () => {
			// alert("Hi");
		  }
	  });
  break;
  
  case "empty":
	  Swal.fire({
		icon: 'info',
		title: 'Enter Username and Password!',
		showConfirmButton: true,
		timer: 2000,
		timerProgressBar: true
	  })
	break;
  }
}

function password_change() {
    var new_password = $("#new_password").val();
    var con_password = $("#confirm_password").val();
    var old_password = $("#old_password").val();
    var unique_id = $("#unique_id").val();

   
    // Check if new password and confirm password fields are filled
    if (!new_password || !con_password) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: "New Password and Confirm Password are required",
        });
        return false;
    }

    // Check if new password and confirm password match
    if (new_password != con_password) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: "Confirm Password doesn't match",
        });
        return false;
    }

    // Check if old password field is filled
    if (!old_password) {
        Swal.fire({
            icon: 'warning',
            title: 'Warning',
            text: 'Old password is required.'
        });
        return false;
    }
  
    var data = {
        "new_password": new_password,
        "con_password": con_password,
        "old_password": old_password,
        "unique_id": unique_id,
        "action": "createupdate"
    };

    var ajax_url = "crud.php";

    $.ajax({
        type: "POST",
        url: ajax_url,
        data: data,
        success: function(response) {
            var obj = JSON.parse(response);
            var msg = obj.msg;
            var status = obj.status;
            var error = obj.error;

            if (!status) {
                console.log(error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Incorrect'
                });
                log_sweetalert(msg, url);
            } else {
                if (msg == "update") {
                    var url = 'list.php';
                    window.location.href = url;
                    log_sweetalert(msg, url);
                }
            }
        },
        error: function() {
            Swal.fire({
                icon: 'error',
                title: 'Network Error',
                text: 'An error occurred. Please try again later.'
            });
        }
    });
}

// Attach event listener to your button
document.querySelector('.go_btn').addEventListener('click', password_change);

</script>

<?php include 'footer.php'?>
