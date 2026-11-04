// ! function (i) {
// 	"use strict";
// 	console.log(i);
// 	function e() {} 
// 	e.prototype.init = function () {
// 		i("#basic-datepicker").flatpickr(), i("#datetime-datepicker").flatpickr({
// 			enableTime: !0,
// 			dateFormat: "Y-m-d H:i"
// 		}), i("#humanfd-datepicker").flatpickr({  
// 			altInput: !0,
// 			altFormat: "F j, Y",
// 			dateFormat: "Y-m-d"
// 		}), i("#minmax-datepicker").flatpickr({
// 			minDate: "2020-01",
// 			maxDate: "2020-03"
// 		}), i("#disable-datepicker").flatpickr({
// 			onReady: function () {
// 				this.jumpToDate("2025-01")
// 			},
// 			disable: ["2025-01-10", "2025-01-21", "2025-01-30", new Date(2025, 4, 9)],
// 			dateFormat: "Y-m-d"
// 		}), i("#multiple-datepicker").flatpickr({
// 			mode: "multiple",
// 			dateFormat: "Y-m-d"
// 		}), i("#conjunction-datepicker").flatpickr({
// 			mode: "multiple",
// 			dateFormat: "Y-m-d",
// 			conjunction: " :: "
// 		}), i("#acc_year").flatpickr({
// 			mode: "range",
// 			dateFormat: "Y-m-d",
// 			defaultDate: [
// 				"2020-04-01",
// 				"2021-03-31"
// 			]			
// 		}), i("#inline-datepicker").flatpickr({
// 			inline: !0
// 		}), i("#basic-timepicker").flatpickr({
// 			enableTime: !0,
// 			noCalendar: !0,
// 			dateFormat: "H:i"
// 		}), i("#24hours-timepicker").flatpickr({
// 			enableTime: !0,
// 			noCalendar: !0,
// 			dateFormat: "H:i",
// 			time_24hr: !0
// 		}), i("#minmax-timepicker").flatpickr({
// 			enableTime: !0,
// 			noCalendar: !0,
// 			dateFormat: "H:i",
// 			minDate: "16:00",
// 			maxDate: "22:30"
// 		}), i("#preloading-timepicker").flatpickr({
// 			enableTime: !0,
// 			noCalendar: !0,
// 			dateFormat: "H:i",
// 			defaultDate: "01:45"
// 		})
// 	}, i.FormPickers = new e, i.FormPickers.Constructor = e
// }(window.jQuery),
// function () {
// 	"use strict";
// 	window.jQuery.FormPickers.init()
// }();

// // Particle JS init
// /* particlesJS.load(@dom-id, @path-json, @callback (optional)); */
// particlesJS.load('particles-js', 'folders/login/particlesjs-config.json', function() {
// 	console.log('callback - particles.js config loaded');
//   });


function login2() { 
    // alert("hi");
  //  // Get username and password values (replace these with your actual logic)
  //     var enteredUsername = document.getElementById("username").value;
  //     var enteredPassword = document.getElementById("password").value;

  //     // Replace these with your actual username and password for comparison
  //     var correctUsername = "admin";
  //     var correctPassword = "123";

  //     if (enteredUsername === correctUsername && enteredPassword === correctPassword) {
  //         // Correct credentials
  //         alert("Login successful!");
  //     } else {
  //         // Incorrect credentials
  //         alert("Incorrect username or password. Please try again.");
  //     }
  // }
var internet_status  = is_online();

  if (!internet_status) {
      sweetalert("no_internet");
      return false;
  }

// var is_form = form_validity_check("was-validated");
var acc_year 	= $("#acc_year").val();
var user_name 	= $("#user_name").val();
var password 	= $("#password").val();



  if ((acc_year !="") && (user_name !="") && (password !="")) {

  // var data 	= $(".was-validated").serialize();
  
  // data  		+= "&action=login";

  var data 	 = {
    "acc_year" : acc_year,
    "user_name": user_name,
    "password" : password,
    "action"  : "login"
  }; 

  var ajax_url = "folders/login/crud.php";

  var url 	 = "index.php";

  $.ajax({
    type 	: "POST",
    url 	: ajax_url,
    data 	: data,
    success : function(data) {

      var obj     = JSON.parse(data);
      var msg     = obj.msg;
      var status  = obj.status;
      var error   = obj.error;
      

      if (!status) 
      {
        url 	= '';
        
      } else {

        if (password == "password") {
          window.location = "index.php?file=password/update&default=true";
        } else {
          log_sweetalert("success_login");
          url = "index.php";
        }

      }
      log_sweetalert(msg,url);
    
    }
  });
} else {
  log_sweetalert("empty");
}
// if((user_name.toLowerCase() === "tcmcwb")&&(password.toLowerCase() === 'tcmc@123')){
  $.ajax({
    type 	: "POST",
    url 	: ajax_url,
    data 	: data,
    success : function(data) 
    {
      var obj     	= JSON.parse(data);
      var msg     	= obj.msg;
      var status  	= obj.status;
            var error   	= obj.error;
            var profile   		= obj.profile;
    // var street_light   	= obj.street_light;
    // var dashboard   	= obj.dashboard;
            if(status)
            {
           
              // url = "index.php?file=foEhS4jMGPoCYt8qaJk7UgA2TQ/CopLf3yaDSs2ehpw=";    
              url = "index.php?";                

          log_sweetalert('success_login',url);
        }
        else
        {
          log_sweetalert('incorrect');
        }
        }
    });
// }
}

// Login only Sweeet Alert Functions
function log_sweetalert2(msg='',url='',callback ='') {

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

function is_online2() {
  return true;
  // return(navigator.onLine);
  return false;
}





function validate2(){



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
