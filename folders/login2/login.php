<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">
<head>
    <meta charset="utf-8" />
    <title>Ascent | Operation Team - Login </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">
    <!-- jsvectormap css -->
    <link href="assets/libs/jsvectormap/css/jsvectormap.min.css" rel="stylesheet" type="text/css" />

    <!--Swiper slider css-->
    <link href="assets/libs/swiper/swiper-bundle.min.css" rel="stylesheet" type="text/css" />

    <!-- Layout config Js -->
    <script src="assets/js/layout.js"></script>
    <!-- Bootstrap Css -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="assets/css/custom.min.css" rel="stylesheet" type="text/css" />

</head>

<style>

    .circle{  position: absolute;  border-radius: 50%;  background: white;  animation: ripple 15s infinite;  box-shadow: 0px 0px 1px 0px #508fb9;}
    
    .small  {  width: 200px;  height: 200px;  left: -100px;  bottom: -100px;}
    
    .medium {  width: 400px;  height: 400px;  left: -200px;  bottom: -200px;}
    
    .large  {  width: 600px;  height: 600px;  left: -300px;  bottom: -300px;}
    
    .xlarge {  width: 800px;  height: 800px;  left: -400px;  bottom: -400px;}
    
    .xxlarge{  width: 1000px;  height: 1000px;  left: -500px;  bottom: -500px;}
    
    .shade1{  opacity: 0.2;}
    .shade2{  opacity: 0.5;}
    .shade3{  opacity: 0.7;}
    .shade4{  opacity: 0.8;}
    .shade5{  opacity: 0.9;}
    
    @keyframes ripple{  0%{    transform: scale(0.8);  }  50%{    transform: scale(1.2);  }  100%{    transform: scale(0.8);  }}
    .form-control{line-height: 2.5;border-radius: 30px;}
    .btn {  padding: 15px 10px;    border-radius: 30px;}
    .logo_stl a img{ width: 100%;}
    .card {    box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;}
    .bg_styles{background-color: #dddee3;  background-image: url('assets/images/bg-OM.png');background-repeat: no-repeat;    background-blend-mode: color-dodge;    background-position: bottom;background-size: 59%; }
    @supports (-webkit-touch-callout: none) {
  .logo {
    width: 150px;
  }
}
</style>

<body style="background-color: #dddee3;">
    <div class="auth-page-wrapper pt-5 bg_styles" style="">
    <!-- auth page content -->
        <div class="auth-page-content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="" style="background: #3399ff;">
                            <div class='ripple-background'>
                                <div class='circle xxlarge shade1'></div>
                                <div class='circle xlarge shade2'></div>
                                <div class='circle large shade3'></div>
                                <div class='circle mediun shade4'></div>
                                <div class='circle small shade5'></div>
                            </div>
                        </div>
                    <!-- end row -->
                    </div>
                </div>
    
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card mt-4">
                             <div class="row">
                                 <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4"></div>
                                <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 text-center logo_stl mb-2 mt-4 text-white-50">
                                    <a href="index.php" class="d-inline-block auth-logo">
                                        <img src="assets/images/logo-OM.png" alt="" >
                                    </a>
                                </div>
                                <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4"></div>
                            </div>
                            <div class="card-body p-4">
                                <div class="text-center mt-2">
                                
                                    <h3 class="text-primary">Sign in</h3>
                                    <p class="text-muted">Operation Team Admin</p>
                                </div>
                                <div class="p-2 mt-4">
                                    <form action="">
                                    
                                        <div class="mb-3">
                                            <label  class="form-label">Username</label>
                                            <input type="text" class="form-control" id="user_name" placeholder="Enter username">
                                        </div>
                                    
                                        <div class="mb-3">
                                        
                                            <label class="form-label" >Password</label>
                                            <div class="position-relative">
                                                <input type="password" class="form-control pe-5 password-input" placeholder="Enter password" id="password">
                                                <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" id="password-addon" onclick="togglePasswordVisibility()">
                                                    <i class="ri-eye-fill align-middle"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="mt-4">
                                            <button class="btn btn-primary w-100" type="button" onclick="login()" >Sign In</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->
                    </div>
                </div>
    
    
                <!-- end row -->
            </div>
            <!-- end container -->
    
        </div>
    <!-- end auth page content -->

    </div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>


function login() { 
    var internet_status = is_online();
    if (!internet_status) {
        log_sweetalert("no_internet");
        return false;
    }

    var acc_year = $("#acc_year").val();
    var user_name = $("#user_name").val();
    var password = $("#password").val();

    if (acc_year !== "" && user_name !== "" && password !== "") {
        var data = {
            "acc_year": acc_year,
            "user_name": user_name,
            "password": password,
            "action": "login"
        };

        $.ajax({
            type: "POST",
            url: "folders/login/crud.php",
            data: data,
            success: function(data) {
                // try {
                //     var obj = JSON.parse(response);
                //     var status = obj.status;
                //     var msg = obj.msg;

                //     if (status) {
                //         var redirect_url = "index.php";
                //         if (password === "password") {
                //             redirect_url = "index.php";
                //         }
                //         log_sweetalert("success_login", redirect_url);
                //     } else {
                //         log_sweetalert("incorrect");
                //     }
                // } catch (e) {
                //     console.error("JSON Parsing Error: ", e);
                //     log_sweetalert("error");
                // }
                      var obj     = JSON.parse(data);
      var msg     = obj.msg;
      var status  = obj.status;
      var error   = obj.error;
    //   alert(status);
                      if (!status) 
      {
        url 	= '';
        
      } else {

        if (password == "password") {
          window.location = "index.php?file=password/update&default=true";
        //   alert();
        } else {
         url = "index.php";
// alert('index');
        //   log_sweetalert("success_login");
        //   window.location.reload();
        }

      }
      log_sweetalert(msg,url);
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error: ", error);
                log_sweetalert("error");
            }
        });
    } else {
        log_sweetalert("empty");
    }
}


// function login() { 
//   //  alert("hi");
//   //  // Get username and password values (replace these with your actual logic)
//   //     var enteredUsername = document.getElementById("username").value;
//   //     var enteredPassword = document.getElementById("password").value;

//   //     // Replace these with your actual username and password for comparison
//   //     var correctUsername = "admin";
//   //     var correctPassword = "123";

//   //     if (enteredUsername === correctUsername && enteredPassword === correctPassword) {
//   //         // Correct credentials
//   //         alert("Login successful!");
//   //     } else {
//   //         // Incorrect credentials
//   //         alert("Incorrect username or password. Please try again.");
//   //     }
//   // }
// //   alert();
// var internet_status  = is_online();

//   if (!internet_status) {
//       sweetalert("no_internet");
//       return false;
//   }

// // var is_form = form_validity_check("was-validated");
// var acc_year 	= $("#acc_year").val();
// var user_name 	= $("#user_name").val();
// var password 	= $("#password").val();



//   if ((acc_year !="") && (user_name !="") && (password !="")) {

//   // var data 	= $(".was-validated").serialize();
  
//   // data  		+= "&action=login";

//   var data 	 = {
//     "acc_year" : acc_year,
//     "user_name": user_name,
//     "password" : password,
//     "action"  : "login"
//   }; 

//   var ajax_url = "folders/login/crud.php";

//   var url 	 = "index.php";

//   $.ajax({
//     type 	: "POST",
//     url 	: ajax_url,
//     data 	: data,
//     success : function(data) {

//       var obj     = JSON.parse(data);
//       var msg     = obj.msg;
//       var status  = obj.status;
//       var error   = obj.error;
      

//       if (!status) 
//       {
//         url 	= '';
        
//       } else {

//         if (password == "password") {
//           window.location = "index.php?file=password/update&default=true";
//         } else {
//          url = "index.php";

//           log_sweetalert("success_login");
//         //   window.location.reload();
//         }

//       }
//       log_sweetalert(msg,url);
    
//     }
//   });
// } else {
//   log_sweetalert("empty");
// }
// // if((user_name.toLowerCase() === "tcmcwb")&&(password.toLowerCase() === 'tcmc@123')){
//   $.ajax({
//     type 	: "POST",
//     url 	: ajax_url,
//     data 	: data,
//     success : function(data) 
//     {
//       var obj     	= JSON.parse(data);
//       var msg     	= obj.msg;
//       var status  	= obj.status;
//             var error   	= obj.error;
//             var profile   		= obj.profile;
//     // var street_light   	= obj.street_light;
//     // var dashboard   	= obj.dashboard;
//             if(status)
//             {
                
//                 alert('login');
           
//               // url = "index.php?file=foEhS4jMGPoCYt8qaJk7UgA2TQ/CopLf3yaDSs2ehpw=";    
//               url = "index.php?";      
              
              

//           log_sweetalert('success_login',url);
          
//         //   window.location.reload();
//         }
//         else
//         {
//           log_sweetalert('incorrect');
//         }
//         }
//     });
// // }
// }
function is_online() {
  return true;
  // return(navigator.onLine);
  return false;
}
function log_sweetalert(msg='',url='',callback ='') {

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
         willClose: () => {  // "willClose" is better than "onClose"
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

function is_online() {
  return true;
  // return(navigator.onLine);
  return false;
}


// $("#username").keyup(function(event) {
//   if (event.keyCode === 13) {
//       login();
//   }
// });

// $("#password").keyup(function(event) {
//   if (event.keyCode === 13) {
//       login();
//   }
// });

$('body').on('keyup', function (evt) {
if (evt.keyCode == 13) {
  // Simulate clicking on the submit button.
  login();
}
}); 

function validate(){



var mobile_no = $("#mobile_no").val();
// var email_id = $("#email_id").val();

  if((mobile_no != "") || (email_id != "")){

    var data   = {
    "mobile_no" : mobile_no,
   // "email_id": email_id,
    "action"  : "validate"
  };

  var ajax_url = "folders/login/crud.php";

  var url    = "password_change.php";

  $.ajax({
    type  : "POST",
    url   : ajax_url,
    data  : data,

    success : function(data) {

      var obj     = JSON.parse(data);
        var msg     = obj.msg;
        var unique_id_enc     = obj.unique_id_enc;
        var mobile_no_enc     = obj.mobile_no_enc;
        var msg     = obj.msg;
        var status  = obj.status;
        var error   = obj.error;

      if (!status) { 
     
        url   = '';
        alert("Invalid Details");
        $("#con-close-modal").display = none();
        
      } else {     
          // log_sweetalert("validate");
          // $file_name = base64_encode(openssl_encrypt($menu_screen, $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv)); ?>
          window.location = "password_change.php?mobile_no="+mobile_no_enc+"&unique_id="+unique_id_enc;

        }

      }
       // log_sweetalert(url);
    
    
  });
}
}

    function togglePasswordVisibility() {
        var passwordInput = document.getElementById("password");

        // Toggle the type attribute of the password input
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
        } else {
            passwordInput.type = "password";
        }
    }
</script>



<!-- particles js -->
<script src="assets/libs/particles.js/particles.js"></script>
<!-- particles app js -->
<script src="assets/js/pages/particles.app.js"></script>




    
