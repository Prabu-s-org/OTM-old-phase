<?php include 'header.php' ?>
<style>
	body {
		overflow: hidden;
	}
	
	.img_str{ width:90%;}
	.mycapt{
		width: 100%;
    height: 42px;
    margin-top:0;
    margin-left: 0;
	}
	.captcha_stl{height: 42px;
    border: none;
    background-color: #c7c7c7;}
	 .mycapt {
    width: 100%;
    height: 68px;
    margin-top: 0;
    margin-left: 0;
}
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- Include SweetAlert CSS and JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Include SweetAlert2 -->

	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<!-- Include jQuery if not already included -->

	<!-- Your custom styles and scripts -->
</head>
<script>
	// Login only Sweeet Alert Functions
	function log_sweetalert(msg = '', url = '', callback = '') {
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
					showConfirmButton: true,
					timer: 2000,
					timerProgressBar: true,
					onClose: () => {
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
				case "captcha":
      Swal.fire({
        icon: 'info',
        title: 'Please Enter Captcha',
        // imageUrl:'img/emoji/form_fill.webp',
        showConfirmButton: true,
        timer: 2000,
        timerProgressBar: true
      })
    break;
    
      case "invalidcaptcha":
       
      Swal.fire({
          icon: 'warning',
          title: 'Captcha does not match',
          // imageUrl:'img/emoji/already.webp',
          showConfirmButton: true,
          timer: 2000,

		  
          timerProgressBar: true,
          willClose: () => {
            // alert("Hi");
          }
      });
    break;
		}
	}
</script>

<body>
	<div class="over-page bg_stl_one" style=" background-image: url('assets/img/login-bg.png');">
		<div class="login-bg">


		</div>
		<div class="container">
			<div class="login-form">

				<div class="row mb-3">
					<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4"></div>
					<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
						<img src="assets/img/logo-OM.png" class="img_str" style="width:30%">

					</div>
					<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4"></div>
				</div>

				<div class="row ">
					<div class="col-12 col-md-12 col-sm-12 col-lg-12 mt-2">
						<h3 class="p-0 m-0">Login Here </h3>

					</div>
				</div>
				<div class="row ">

					<div class="col-12 m-3">
						<img src="assets/img/login-center.png" class="img_str">

					</div>
				</div>
				<div class="row ">
					<div class="col-12  col-md-12 col-sm-12 col-lg-12 img-text ">
						<input type="text" name="user_name" id="user_name" placeholder="Enter your username"
							class="input-group">
						<img src="assets/img/user.png">
					</div>
					<div class="col-12  col-md-12 col-sm-12 col-lg-12 img-text">
						<input type="password" name="password" id="password" placeholder="Enter your password"
							class="input-group no-mar" onclick="togglePasswordVisibility()">
						<img src="assets/img/padlock.png">
					</div>
					
					<div class="col-12  col-md-12 col-sm-12 col-lg-12 img-text input-group input-group-merge mt-3">
							
							<input type="text" class="form-control" placeholder="Enter Captcha" name="captcha" id="captcha" required>
							<button type="button" id="change-captcha" onclick="captch()" class="captcha_stl	"><i class="mdi mdi-reload"></i>⟳</button>
                	</div>
					<div class="col-12  col-md-12 col-sm-12 col-lg-12">
						<img id="captcha-image" class="mycapt" src="" alt="CAPTCHA Image">
					</div>
					<div class="col-12 col-md-12 col-sm-12 col-lg-12 sing-btn">
						<button class="btn btn-primary w-100" type="button" onclick="login()">Login</button>
					</div>
					
				</div>

			</div>


		</div>
<!-- <script src="assets/js/common.js"></script>
		<script>
			$(document).ready(function() {
        captch();
    });

    function captch(){
        $('#captcha-image').attr('src', 'captcha.php?' + Date.now());
    }
			function login() {
				if (!is_online()) {
					sweetalert("no_internet");
					return false;
				}

				let user_name = document.getElementById("user_name").value.trim();
				let password = document.getElementById("password").value.trim();
				  var captcha = $("#captcha").val();
				
				
				// alert(captcha);

				if (user_name && password) {
					fetch("crud.php", {
						method: "POST",
						headers: {
							"Content-Type": "application/x-www-form-urlencoded",
						},
						body: `user_name=${encodeURIComponent(user_name)}&password=${encodeURIComponent(password)}&captcha=${(captcha)}&action=loginUser`
					})
						.then(response => response.text()) // First, get response as text
						.then(text => {
							try {
								let data = JSON.parse(text.trim()); // Ensure proper JSON parsing
								// console.log("Server Response:", data);

								if (data.status) {
									let url = (password === "password") ? "password/update&default=true" : "list.php";
									sweetalert(data.msg, url);
									setTimeout(() => {
										window.location.href = url;
									}, 1000);
								} else {
									sweetalert(data.msg, "");
								}
							} catch (error) {
								console.error("Invalid JSON response:", text); // Log raw response
								sweetalert("error", "Unexpected response from the server.");
							}
						});
				} else {
					log_sweetalert("Please fill in all fields.");
				}


			} -->




			<script src="assets/js/common.js"></script>
<script>
  $(document).ready(function() {
    captch();
	 
  });

  function captch() {
    $('#captcha-image').attr('src', 'captcha.php?' + Date.now());
	 document.getElementById("captcha").value = "";
  }

  function login() {
    if (!is_online()) {
      sweetalert("no_internet");
      return false;
    }

    let user_name = document.getElementById("user_name").value.trim();
    let password = document.getElementById("password").value.trim();
    let captcha = $("#captcha").val().trim();

    // Validate all fields first
    if (!user_name || !password) {
      sweetalert("login_name");  // Calls your common.js alert for username/password missing
	  // Clear username and password fields
//   document.getElementById("user_name").value = "";
//   document.getElementById("password").value = "";
  
      return false;
    }
    if (!captcha) {
      sweetalert("captcha");  
	     // Calls your common.js alert for captcha missing
		 // Clear captcha field
//   document.getElementById("captcha").value = "";
  
      return false;
    }

    fetch("crud.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
      body: `user_name=${encodeURIComponent(user_name)}&password=${encodeURIComponent(password)}&captcha=${encodeURIComponent(captcha)}&action=loginUser`
    })
    .then(response => response.text())
    .then(text => {
      try {
        let data = JSON.parse(text.trim());

        if (data.status) {
          let url = (password === "password") ? "password/update&default=true" : "list.php";
          sweetalert(data.msg, url);
          setTimeout(() => {
            window.location.href = url;
          }, 1000);
        } else {
			 captch();
			//  alert();
          sweetalert(data.msg);
          if (data.msg === "invalidcaptcha" || data.msg === "incorrect") {
            $("#captcha").val("");
           
          }
        }
      } catch (error) {
        console.error("Invalid JSON response:", text);
        sweetalert("error", "Unexpected response from the server.");
      }
    })
    .catch(err => {
      console.error("Fetch error:", err);
      sweetalert("error", "Network or server error.");
    });
  }


		
				
//   $(document).ready(function () {
//     captch(); // Load initial captcha
//   });

//   function captch() {
//     $('#captcha-image').attr('src', 'captcha.php?' + Date.now()); // Prevent cached image
//   }

//   function login() {
// 	alert();
//     if (!is_online()) {
//       sweetalert("no_internet");
//       return false;
//     }

//     let user_name = document.getElementById("user_name").value.trim();
//     let password = document.getElementById("password").value.trim();
//     let captcha = document.getElementById("captcha").value.trim();

//     if (!user_name || !password) {
//     //   form_alert("Please fill in all fields.");
// 	// sweetalert("form_alert");
// 	// sweetalert(form_alert);
// 	sweetalert("login_name"); // ✅ CORRECT - pass the case name as a string

//       return false;
//     }
// 	 if ( !captcha) {
//     //   form_alert("Please fill in all fields.");
// 	// sweetalert("form_alert");
// 	// sweetalert(form_alert);
// 	sweetalert("captcha"); // ✅ CORRECT - pass the case name as a string

//       return false;
//     }

//     fetch("crud.php", {
//       method: "POST",
//       headers: {
//         "Content-Type": "application/x-www-form-urlencoded",
//       },
//       body: `user_name=${encodeURIComponent(user_name)}&password=${encodeURIComponent(password)}&captcha=${encodeURIComponent(captcha)}&action=loginUser`
//     })
//       .then(response => response.text())
//       .then(text => {
//         try {
//           let data = JSON.parse(text.trim());

//           switch (data.msg) {
//             case "success_login":
//               let url = (password === "password") ? "password/update&default=true" : "list.php";
//               sweetalert(data.msg, url);
//               setTimeout(() => {
//                 window.location.href = url;
//               }, 1000);
//               break;

//             case "invalid_captcha":
//               sweetalert("invalidcaptcha");
//               $("#captcha").val("");  // Clear captcha input
//               captch();               // Refresh captcha image
//               break;

//             case "incorrect":
//               sweetalert("invaliduserpass.");
//               $("#captcha").val("");
//               captch();
//               break;

//             case "already_logged_in":
//               log_sweetalert("User already logged in from another device.");
//               break;

//             default:
//               sweetalert(data.msg || "Login failed.");
//           }
//         } catch (error) {
//           console.error("Invalid JSON response:", text);
//           log_sweetalert("Unexpected response from the server.");
//         }
//       })
//       .catch(err => {
//         console.error("Network error:", err);
//         log_sweetalert("error");
//       });
//   }


			function is_online() {
				return true;
				return false;
			}


			$('body').on('keyup', function (evt) {
				if (evt.keyCode == 13) {
					// Simulate clicking on the submit button.
					login();
				}
			});

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


		<?php include 'footer.php' ?>
