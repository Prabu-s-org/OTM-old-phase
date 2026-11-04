

<head>
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


</head>

<style>
  .circle {
    position: absolute;
    border-radius: 50%;
    background: white;
    animation: ripple 15s infinite;
    box-shadow: 0px 0px 1px 0px #508fb9;
  }

  .small {
    width: 200px;
    height: 200px;
    left: -100px;
    bottom: -100px;
  }

  .medium {
    width: 400px;
    height: 400px;
    left: -200px;
    bottom: -200px;
  }

  .large {
    width: 600px;
    height: 600px;
    left: -300px;
    bottom: -300px;
  }

  .xlarge {
    width: 800px;
    height: 800px;
    left: -400px;
    bottom: -400px;
  }

  .xxlarge {
    width: 1000px;
    height: 1000px;
    left: -500px;
    bottom: -500px;
  }

  .shade1 {
    opacity: 0.2;
  }

  .shade2 {
    opacity: 0.5;
  }

  .shade3 {
    opacity: 0.7;
  }

  .shade4 {
    opacity: 0.8;
  }

  .shade5 {
    opacity: 0.9;
  }

  @keyframes ripple {
    0% {
      transform: scale(0.8);
    }

    50% {
      transform: scale(1.2);
    }

    100% {
      transform: scale(0.8);
    }
  }

  .form-control {
    line-height: 2.5;
    border-radius: 30px;
  }

  .btn {
    padding: 15px 10px;
    border-radius: 30px;
  }

  .logo_stl a img {
    width: 100%;
  }

  .card {
    box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
  }

  .bg_styles {
    background-color: #dddee3 !important;
    background-image: url('assets/images/bg-OM.png');
    background-repeat: no-repeat;
    background-blend-mode: color-dodge;
    background-position: bottom;
    background-size: 59%;
  }
@media (min-width: 1440px) {
  body {
    background-color: #f5f5f5 !important;
    background-size: auto;
    background-repeat: repeat;
    background-position: top center;
  }}
  @supports (-webkit-touch-callout: none) {
    .logo {   width: 150px;  }
  }

  .mycapt {
    width: 50%;
    height: 57px;
    border-radius: 24px;
    /* font-size: 31px; */
    object-fit: cover;
    object-position: center;
    object-position: center;
    margin-left: 7px;
  }
  @media (max-width: 767px) {.logo_stl a img {
    width: 53%;
}}
.display_device{ display: flex;
  align-items: center;
  height: 100vh; /* Full screen height */
 }
  .form-label {    margin-bottom: .1rem;}
</style>

<body style="background-color: #dddee3 !important;">
  <div class="auth-page-wrapper bg_styles" style="">
    <!-- auth page content -->
    <div class="auth-page-content">
      <div class="container display_device">
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
          <div class="col-md-6 col-lg-6 col-xl-5">
            <div class="card">
              <div class="row">
                <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2"></div>
                <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 text-center logo_stl mb-2 mt-4 p-3 text-white-50">
                  <a href="index.php" class="d-inline-block auth-logo">
                    <img src="assets/images/logo-OM.png" alt="">
                  </a>
                </div>
                <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2"></div>
              </div>
              <div class="card-body ">
                <div class="text-center ">

                  <h3 class="text-primary">Sign in</h3>
                  <!-- <p class="text-muted">Admin Panel</p> -->
                </div>
                <div class="p-2 ">
                  <form action="">

                    <div class="mb-3">
                      <label class="form-label">Username</label>
                      <input type="text" class="form-control" id="user_name" placeholder="Enter username">
                    </div>

                    <div class="mb-3">

                      <label class="form-label">Password</label>
                      <div class="position-relative">
                        <input type="password" class="form-control pe-5 password-input" placeholder="Enter password"
                          id="password">
                        <button
                          class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon"
                          type="button" id="password-addon" onclick="togglePasswordVisibility()">
                          <i class="ri-eye-fill align-middle"></i>
                        </button>
                      </div>
                    </div>


                    <div class="mb-3">
                      <label class="form-label">Captcha</label>
                      <div class="input-group input-group-merge">

                        <img id="captcha-image" class="mycapt" src="" alt="CAPTCHA Image">
                        <input type="text" style="margin-left: -67px; font-size:15px;     font-weight: 600;" class="form-control" placeholder="Enter Captcha"
                          name="captcha" id="captcha" required>
                        <button type="button" id="change-captcha" onclick="captch()"><i
                            class="mdi mdi-reload"></i></button>
                      </div>
                    </div>

                    <div class="mt-4">
                      <button type="button" onclick="login()" class="btn btn-primary w-100">Sign In</button>
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
  <!-- <script src="https://www.google.com/recaptcha/api.js" async defer></script> -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
    $(document).ready(function () {
      captch();
    });

    function captch() {
      $('#captcha-image').attr('src', 'captcha.php?' + Date.now());
    }

    function login() {
      var internet_status = is_online();
      if (!internet_status) {
        log_sweetalert("no_internet");
        return false;
      }

      // var acc_year = $("#acc_year").val();
      var user_name = $("#user_name").val();
      var password = $("#password").val();
      var captcha = $("#captcha").val();

      if (user_name !== "" && password !== "") {
        var data = {

          "user_name": user_name,
          "password": password,
          "captcha": captcha,
          "action": "login"
        };
        if (captcha != '') {
          $.ajax({
            type: "POST",
            url: "folders/login/crud.php",
            data: data,
            success: function (data) {

              var obj = JSON.parse(data);
              var msg = obj.msg;
              var status = obj.status;
              var error = obj.error;
              //   var url = "index.php";
              //   alert(status);
              //   alert(url);
              // url = "index.php?file=dashboard/form";
              //  url = "index.php?file=dashboard/form";
              var url = "dashboard/form";
              // log_sweetalert(msg,url);
              if (msg == 'incorrect') {
                url = '';
                document.getElementById('captcha').value = '';
                captch();
                log_sweetalert(msg);
                // resetSessionCookie();

              } else if (msg == 'success_login') {


                log_sweetalert(msg, url);

                // window.location = "index.php?file=" + url;
                window.location = "index.php?file=" + url;

              } else if (msg == 'invalid_captcha') {
                url = '';
                document.getElementById('captcha').value = '';
                log_sweetalert(msg);
              }

              else if (msg == 'already_logged_in') {

                url = '';
                log_sweetalert(msg);
              }

            },
            error: function (xhr, status, error) {
              console.error("AJAX Error: ", error);
              log_sweetalert("error");
            }
          });
        } else {
          document.getElementById('captcha').value = '';
          log_sweetalert("captchas");
        }
      } else {
        log_sweetalert("empty");
      }

    }



    function is_online() {
      return true;
      // return(navigator.onLine);
      return false;
    }
    function log_sweetalert(msg = '', url = '', callback = '') {
      // alert("hii");
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
        case "captchas":
          Swal.fire({
            type: "error",
            icon: 'error',
            title: 'Please Enter Captcha',
            showConfirmButton: true,
            //   timer: 2000,
            //  willClose: () => {  // "willClose" is better than "onClose"
            //     window.location = url;
            // }
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
        // case "invalid_captcha":
        //       Swal.fire({
        //         icon: 'error',
        //         title: 'Invalid Captcha',
        //         showConfirmButton: true,
        //         timer: 2000,
        //         timerProgressBar: true,
        //         onClose: () => {
        //           // alert("Hi");
        //         }
        //       });
        //       break;

        //       case "already_logged_in":
        //       Swal.fire({
        //         icon: 'error',
        //         title: 'User Is Already Logged In On Another Device',
        //         showConfirmButton: true,
        //         timer: 5000,
        //         timerProgressBar: true,
        //         onClose: () => {
        //           // alert("Hi");
        //         }
        //       });
        case "invalid_captcha":
          Swal.fire({
            icon: 'error',
            title: 'Invalid Captcha',
            showConfirmButton: true,
            timer: 2000,
            timerProgressBar: true,
            onClose: () => {
              // alert("Hi");
            }
          });
          break;

        case "already_logged_in":
          Swal.fire({
            icon: 'error',
            title: 'User Is Already Logged In On Another Device',
            showConfirmButton: true,
            timer: 5000,
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

    // $('body').on('keyup', function (evt) {
    // if (evt.keyCode == 13) {
    //   // Simulate clicking on the submit button.
    //   login();
    // }
    // }); 

    function validate() {



      var mobile_no = $("#mobile_no").val();
      // var email_id = $("#email_id").val();

      if ((mobile_no != "") || (email_id != "")) {

        var data = {
          "mobile_no": mobile_no,
          // "email_id": email_id,
          "action": "validate"
        };

        var ajax_url = "folders/login/crud.php";

        var url = "password_change.php";

        $.ajax({
          type: "POST",
          url: ajax_url,
          data: data,

          success: function (data) {

            var obj = JSON.parse(data);
            var msg = obj.msg;
            var unique_id_enc = obj.unique_id_enc;
            var mobile_no_enc = obj.mobile_no_enc;
            var msg = obj.msg;
            var status = obj.status;
            var error = obj.error;

            if (!status) {

              url = '';
              alert("Invalid Details");
              $("#con-close-modal").display = none();

            } else {
              // log_sweetalert("validate");
              // $file_name = base64_encode(openssl_encrypt($menu_screen, $enc_method, $enc_password, OPENSSL_RAW_DATA, $enc_iv)); ?>
              window.location = "password_change.php?mobile_no=" + mobile_no_enc + "&unique_id=" + unique_id_enc;

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
