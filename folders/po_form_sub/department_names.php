
<?php
//  $page =$_SERVER['PHP_SELF'];
//  $sec="50";
 
$department_options = department_creation_table($department);
$department_options = select_option($department_options, "Select Department",  $department);
?>
<!-- <meta http-equiv="refresh" content="<?php echo $sec ?>;URL='<?php  echo $page ?>'">; -->
<label 
                                                                class="form-label">Department</label>
                                                            <!--<input type="text" id="department" name="department"-->
                                                            <!--    class="form-control" value="<?php echo $department; ?>"-->
                                                            <!--    required>-->
                                                             <select class="select2 form-control" id="department"  name="department" required> 
                                                             <?php echo $department_options;?>
                                                             </select>
