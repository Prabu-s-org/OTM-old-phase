  
  
   <?php 
//   $screen_id = isset($_GET['screen_id']) ? htmlspecialchars($_GET['screen_id']) : '';

$screen_id='62b55d5420df251894';

// print_r($screen_id);DIE();
   session_start();
  $user_type_unique_id = $_SESSION['user_type_unique_id'];
//   print_r( $user_type_unique_id);die();
  ?>
  <!-- start page title -->
  <div class="row">
      <div class="col-12">
         <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">List User Screen</h4>
            <input type="hidden" id="screen_id" name="screen_id" class="form-control" value="<?php echo $screen_id;?>">
            <input type="hidden" id="user_type_unique_id" name="user_type_unique_id" class="form-control" value="<?php echo $user_type_unique_id;?>">

            <div class="page-title-right">
                  <ol class="breadcrumb m-0">
                     <li class="breadcrumb-item"><a href="javascript: void(0);">Admin</a></li>
                     <li class="breadcrumb-item active">User Screen</li>
                  </ol>
            </div>

         </div>
      </div>   
  </div>
  <!-- end page title -->
  

  </div>
  <style>.btn_stl2{ background-color: #506018;}</style>
  <!----content start---------->
  <div class="row" id="list">
     <div class="col-12">
        <div class="card">
           <div class="card-body">
               <div class="table-responsive">
                  <div class="text-end pb-3 "><?php echo btn_add($btn_add); ?></div>
              <table id="user_screen_datatable" class="table table-bordered nowrap table-striped align-middle">
                 <thead>
                    <tr>
                       <th>#</th>
                       <th>Screen Name</th>
                       <th>Screen Section</th>
                       <th>Main Screen</th>
                       <th>Order</th>
                       <th>Status</th>
                       <th>Action</th>
                    </tr>
                 </thead>
              
              </table>
              </div>
           </div>
        </div>
     </div>
  </div>
  <!----content start---------->

  <script>
   
function get_user_permission() {
   // alert();
	var screen_id = $('#screen_id').val();
	var user_type_unique_id = $('#user_type_unique_id').val();

	var data = {
		"screen_id": screen_id,
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
   </script>
