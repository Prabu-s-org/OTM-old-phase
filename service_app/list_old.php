<?php
include 'header.php';
include '../config/dbconfig.php';
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Get username from session
$user_name = $_SESSION['user_name'] ?? 'N/A';
if ($user_name === 'N/A') {
    die("User name is missing in session.");
}

// Prepare and execute query using PDO
$query = "SELECT staff_id, mobile_no, email_id FROM user WHERE staff_name = :staff_name";
$stmt = $conn->prepare($query);
$stmt->bindParam(':staff_name', $user_name, PDO::PARAM_STR);
$stmt->execute();
$userData = $stmt->fetch(PDO::FETCH_ASSOC);
// print_r($userData);
$emp_id = isset($userData['staff_id']) ? trim($userData['staff_id']) : 'N/A';
$mobile_no = $userData['mobile_no'] ?? 'N/A';
$email_id = $userData['email_id'] ?? 'N/A';
$stmt = null;
$conn = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accordion Example</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
     .btn-custom {
            margin: 10px;
            width: 50%;
            display: flex;
            align-items: center;
            justify-content: space-between;
        } 
        .accordion-item { display: none; }
        .accordion-item.show { display: block; }
        .get{
            padding: 0px 14px;
}
 </style>
</head>
<body>
<?php
error_reporting(0);
session_start();
include('session.php');
$usertype= $_SESSION["user_type_unique_id"];
// print_r($usertype);die();
$eng_name= $_SESSION["eng_unique_id"];
$folder_name        = explode("/", $_SERVER['PHP_SELF']);
$folder_name        = $folder_name[count($folder_name) - 2];
$fileUpload         = new Alirdn\SecureUPload\SecureUPload($fileUploadConfig);
$fileUploadPath = $fileUploadConfig->get("upload_folder");
$fileUploadConfig->set("upload_folder", $fileUploadPath . $folder_name . DIRECTORY_SEPARATOR);
$curr_date = date("Y-m-d");
$table = "view_eng_data";
$where = "user_type_unique_id='".$usertype."' AND engineer_name='".$eng_name ."'";
// print_r($where);
$columns = [
    // "engineer_name",
    "(select staff_name from user  where unique_id=$table.engineer_name) AS engineer_name",
    "designation_id",
    "(select staff_id from user  where unique_id=$table.emp_id) AS emp_id",
    // "emp_id",
    "user_type_unique_id",
    "eng_unique_id",
];

$table_details = [
    $table,
 $columns];
$user_values = $pdo->select($table_details, $where);
// print_r($user_values);

if ($user_values->status) {
    $user_values = $user_values->data;
    $user_type = $user_values[0]["user_type_unique_id"];
    $employee_name = $user_values[0]["engineer_name"];
    $emp_id = $user_values[0]["emp_id"];
    $eng_unique_id = $user_values[0]["eng_unique_id"];
} else {
    echo "No data found.";
    die();
}
// }
$table_install = "view_eng_calls";
$where_1 = "engineer_name='" . $eng_unique_id . "' AND user_type_unique_id='" . $usertype . "'";
// PRINT_R($where_1 );
$columns_1 = [
    "'' as s_no",
    "engineer_name",
    "po_num",
    "po_date",
    "(SELECT department FROM department_creation WHERE department_creation.unique_id = view_eng_calls.department) AS department",
    "(SELECT district_name FROM district_creation WHERE district_creation.unique_id = view_eng_calls.con_district) AS con_district",
    "con_address",
    "po_file_name",
    "dc_file_name",
    "ir_file_name",
    "file_invoice",
    "installation_status",
    "delivery_due_dates",
    "consignee_unique_id",
    "form_main_unique_id",
    "con_pincode",
    "DATE_FORMAT(installation_com_date, '%d-%m-%Y') AS installation_com_date",
    "DATE_FORMAT(invoice_date, '%d-%m-%Y') AS invoice_date",
    "invoice_no",
    "(SELECT delivery_date FROM dispatch_list WHERE dispatch_list.invoice_no = view_eng_calls.invoice_no ) AS delivery_date",
    "(SELECT delivery_proof FROM dispatch_list WHERE dispatch_list.invoice_no = view_eng_calls.invoice_no AND is_delete='0') AS delivery_proof",
    
    
];

$table_details_1 = [$table_install, $columns_1];
$result_values_data = $pdo->select($table_details_1, $where_1);
$eng_count = 0;
if ($result_values_data->status) {
    $result_values_data = $result_values_data->data;
    $eng_count = count($result_values_data);
}

?>
<div class="sub-hed">
    <div class="row">
        <div class="col-3 log-out">
            <a href="index.php"><i class="fa fa-sign-out"></i></a>
        </div>
        <div class="col-9">
        <div class="chnage-pass">
              
                <p><a href="forgot_password.php"><i class="fa fa-unlock-alt" aria-hidden="true"></i> Change Password</a></p>
                <!-- <p><a href="install_list.php"><i class="fa fa-unlock-alt" aria-hidden="true"></i> installation</a></p> -->
            </div>
            <div class="chnage-pass">
               
            </div>
        </div>
    </div>
</div>

<div class="botm-box">
    <div class="row">
        <div class="col-12">
            <table class="list-tab">
                <tr>
                    <th>Eng Name</th>
                    <td><?php echo htmlspecialchars($_SESSION['user_name']); ?></td>
                    </tr>
                    <tr>
                    <th>Employee ID</th>
                    <td><?php echo htmlspecialchars($_SESSION['staff_id'] ); ?></td>
                </tr>
                <tr>
                    <th>Mobile No</th>
                    <td><?php echo htmlspecialchars($mobile_no); ?></td>
                </tr>
                <tr>
                    <th>Email Id</th>
                    <td><?php echo htmlspecialchars($email_id); ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>

<div class="accordion accordion-flush botm-box ox-2" id="accordionFlushExample">
<div class="row">
   <div class="col-10">
   <!-- <input class="search__input" type="text" placeholder="Search"> -->
   </div>
    <div class="col-2 align-self-center">
	<!-- <p class="go_btn" onclick="go_btn()"></p> -->
	</div>
	</div>
    <div class="count-bg">
        <div class="row">
            <div class="col-6">
            <p><a href="install_list.php" style="color:white"><i class="fa fa-unlock-alt" aria-hidden="true"></i> installation</a></p>
            </div>
            <div class="col-6">
                <!-- <p style="text-align: end;"><?php echo $eng_count; ?></p> -->
            </div>
        </div>
    </div>

    <?php if ($result_values_data) {
        $s_no = 1;
        foreach ($result_values_data as $data) {
            $po_num_1 = htmlspecialchars($data['po_num']);
            $po_date = htmlspecialchars($data['po_date']);
            $department = htmlspecialchars($data['department']);
            $con_district = htmlspecialchars($data['con_district']);
            $con_address = htmlspecialchars($data['con_address']);
            $installation_com_date = $data['installation_com_date'];
            $invoice_no = $data['invoice_no'];
            $po_file_name = $data['po_file_name'];
            $invoice_date = $data['invoice_date'];
            $file_invoice = $data['file_invoice'];
            $dc_file_name = $data['dc_file_name'];
            $ir_file_name = $data['ir_file_name'];

            $delivery_proof = $data['delivery_proof'];
            $delivery_date = $data['delivery_date'];
            $orgDate = $data['delivery_date']; 
            $installation_status = $data['installation_status'];
            $dc_delivery_status = $data['dc_delivery_status'];
            // if($data['installation_status'] == 0){
            //     $data['installation_status'] = 'Pending';
            // }
             if($data['installation_status'] == 5){
                $data['installation_status'] = 'Partial completed';
            }
            else if($data['installation_status'] == 2){
              $data['installation_status'] = 'Completed';
            }
              else if($data['installation_status'] == 4){
                $data['installation_status'] = "Eng Assigned";
              }
              else if($data['installation_status'] == 1){
                $data['installation_status'] = "SNR";
              }

        //  if($data['installation_status'] == 2){
            if($data['dc_delivery_status'] == 0){
                 $data['dc_delivery_status'] = 'Dispatch Pending';
            }
            else if( $data['dc_delivery_status'] == 5){
                 $data['dc_delivery_status'] = 'partial Completed';
            }
            else if( $data['dc_delivery_status'] == 1){
                 $data['dc_delivery_status'] = 'SNR';
            }
            if($orgDate==''){
               $data['delivery_date']='';
            }
            else{
           $data['delivery_date'] = date("d-m-Y", strtotime($orgDate));
            }

            $accordion_id = 'flush-collapse' . $s_no;
            $btn_id = 'btn-toggle' . $s_no;
            $icon_id = 'btn-icon' . $s_no;
            ?>
            <div class="accordion-item rounded-3 mb-2">
                <h2 class="accordion-header">
                    <button id="<?php echo $btn_id; ?>" class="border-bottom collapsed fw-semibold acc-defalut" type="button" data-bs-toggle="collapse" data-bs-target="#<?php echo $accordion_id; ?>" aria-expanded="false" aria-controls="<?php echo $accordion_id; ?>" style="
    width: 100%;
 ">
                        <?php echo $s_no++; ?> <?php echo $department; ?> <br><span><?php echo $con_district . " | " . $con_address . " | " . $invoice_no; ?></span>
                        <!-- <i id="<?php echo $icon_id; ?>" class="fa fa-chevron-down"></i> -->
                    </button>
                </h2>
                <div id="<?php echo $accordion_id; ?>" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                    <div class="">
                        <div class="row">
                            <div class="col-12">
                                <table class="list-tab">
                                    <tbody>
                                    <input type="hidden" name="invoice_no" id="invoice_no" value="<?php echo $invoice_no; ?>">
                                    <input type="hidden" name="po_num" id="po_num" value="<?php echo $po_num_1; ?>">
                                        <tr>
                                            <th>PO NO</th>
                                            <td class="get">:</td>
                                            <td><?php echo $po_num_1; ?></td>
                                        </tr>       
                                        <tr>
                                            <th>PO Date</th>
                                            <td class="get">:</td>
                                            <td><?php echo $po_date; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Department</th>
                                            <td class="get">:</td>
                                            <td><?php echo $department; ?></td>
                                        </tr>
                                        <tr>
                                            <th>District</th>
                                            <td class="get">:</td>
                                            <td><?php echo $con_district; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Location</th>
                                            <td class="get">:</td>
                                            <td><?php echo $con_address; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Invoice No</th>
                                            <td class="get">:</td>
                                            <td><?php echo $invoice_no; ?></td>
                                        </tr>
                                        <tr class="last-child">
                                            
                                            <th>Invoice Date</th>
                                            <td class="get">:</td>
                                            <td><?php echo $invoice_date; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Call Assign Date</th>
                                            <td class="get">:</td>
                                            <td><?php echo $installation_com_date; ?></td>
                                        </tr>
                                        <tr class="last-child">
                                       
                                            <th>Delivery Date</th>
                                            <td class="get">:</td>
                                            <td><?php echo $data['delivery_date']; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Delivery Proof</th>
                                            <td class="get">:</td>
                                            <td><a href="javascript:print_pdf_dispatch('<?php echo $delivery_proof; ?>')" download>
                                                <!-- <img src="http://122.165.127.123/aed_elcot/uploads/dispatch/pdf.png" height="30px" width="30px"> -->
                                    <img src="http://122.165.127.123/aed_elcot/uploads/dispatch/pdf.png" height="30px" width="30px">
                                            </a>
                                        </td>
                                        </tr>
                                        <tr>
                                            <th>Document Status </th>
                                            <td class="get">:</td>
                                            <!-- <td>:</td> -->
                                            <td><?php echo  $data['installation_status'] ?></td>
                                        </tr>
                                        <tr>
                                            <th>Document Dispatch Status</th>
                                            <td class="get">:</td>
                                            <td><?php echo $data['dc_delivery_status']; ?></td>
                                        </tr>
                                        
                                       
                                    </tbody>
                                </table>
                                <div class="row">
                                    <div class="col-3">
                                        <div class="img-box">
                                            <h4>PO. Att.</h4>
                                            <a href="javascript:print_pdf('<?php echo $po_file_name; ?>')" download>
                                                <img src="http://122.165.127.123/aed_elcot/uploads/po_form/po_attach/pdf.png" height="30px" width="30px">
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="img-box">
                                            <h4>DC. Att.</h4>
                                            <a href="javascript:print_pdf_1('<?php echo $dc_file_name; ?>')" download>
                                                <img src="http://122.165.127.123/aed_elcot/uploads/invoice/pdf.png" height="30px" width="30px">
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="img-box">
                                            <h4>IR. Att.</h4>
                                            <a href="javascript:print_pdf_2('<?php echo $ir_file_name; ?>')" download>
                                                <img src="http://122.165.127.123/aed_elcot/uploads/invoice/pdf.png" height="30px" width="30px">
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="img-box">
                                            <h4>Inv.Att.</h4>
                                            <a href="javascript:print_pdf_3('<?php echo $file_invoice; ?>')" download>
                                                <img src="http://122.165.127.123/aed_elcot/uploads/invoice/pdf.png" height="30px" width="30px">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php }
    } ?>
</div>

<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.querySelectorAll('.accordion-button').forEach(button => {
        button.addEventListener('click', function() {
            const icon = document.getElementById(this.dataset.target.replace('flush-collapse', 'btn-icon'));
            if (this.getAttribute('aria-expanded') === 'true') {
                icon.classList.remove('fa-chevron-up');
                icon.classList.add('fa-chevron-down');
            } else {
                icon.classList.remove('fa-chevron-down');
                icon.classList.add('fa-chevron-up');
            }
        });
    });
    
function print_pdf(pdfFileName) {
    const url = 'http://122.165.127.123/aed_elcot/uploads/po_form/po_attach/' + pdfFileName;
    var poNum = document.getElementById('po_num').value;
    const last5Digits = 'PO'+ "-" +poNum.slice(-5);
// alert(last5Digits);

    fetch(url, { method: 'HEAD' }) // Make a HEAD request to check file existence
        .then(response => {
            if (response.ok) {
                // File exists, trigger the download
                const link = document.createElement('a');
                link.href = url;
                link.download = last5Digits;
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            } else {
                // File does not exist, show an alert
                alert('File Not Attached');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while checking for the file');
        });
}

function print_pdf_1(pdfFileName) {
    const url = 'http://122.165.127.123/aed_elcot/uploads/invoice/' + pdfFileName;
    var invoice_no = document.getElementById('invoice_no').value;
    const last5Digits = 'DC'+ "-" +invoice_no.slice(-5);

    fetch(url, { method: 'HEAD' }) // Make a HEAD request to check file existence
        .then(response => {
            if (response.ok) {
                // File exists, trigger the download
                const link = document.createElement('a');
                link.href = url;
                link.download = last5Digits;
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            } else {
                // File does not exist, show an alert
                alert('File Not Attached');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while checking for the file');
        });
}

function print_pdf_2(pdfFileName) {
    const url = 'http://122.165.127.123/aed_elcot/uploads/invoice/' + pdfFileName;
    var invoice_no = document.getElementById('invoice_no').value;
    const last5Digits = 'IR'+ "-" +invoice_no.slice(-5);

    fetch(url, { method: 'HEAD' }) // Make a HEAD request to check file existence
        .then(response => {
            if (response.ok) {
                // File exists, trigger the download
                const link = document.createElement('a');
                link.href = url;
                link.download = last5Digits;
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            } else {
                // File does not exist, show an alert
                alert('File Not Attached');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while checking for the file');
        });
}
function print_pdf_3(pdfFileName) {
    // alert();
    const url = 'http://122.165.127.123/aed_elcot/uploads/invoice/' + pdfFileName;
    var invoice_no = document.getElementById('invoice_no').value;
    const last5Digits = 'INV'+ "-" +invoice_no.slice(-5);

    fetch(url, { method: 'HEAD' }) // Make a HEAD request to check file existence
        .then(response => {
            if (response.ok) {
                // File exists, trigger the download
                const link = document.createElement('a');
                link.href = url;
                link.download = last5Digits;
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            } else {
                // File does not exist, show an alert
                alert('File Not Attached');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while checking for the file');
        });
}

function print_pdf_dispatch(pdfFileName) {
    // alert();
    const url = 'http://122.165.127.123/aed_elcot/uploads/dispatch/' + pdfFileName;

    // var invoice_no = document.getElementById('invoice_no').value;
    // const last5Digits = 'INV'+ "-" +invoice_no.slice(-5);

    var invoice_no = document.getElementById('invoice_no').value;
    // alert(invoice_no);
    const last5Digits = 'Dispatch_proof'+ "-" +invoice_no.slice(-5);
    // alert(last5Digits);

    fetch(url, { method: 'HEAD' }) // Make a HEAD request to check file existence
        .then(response => {
            if (response.ok) {
                // File exists, trigger the download
                const link = document.createElement('a');
                link.href = url;
                link.download = last5Digits;
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            } else {
                // File does not exist, show an alert
                alert('File Not Attached');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while checking for the file');
        });
}
function go_btn() {
    // alert();
            const searchValue = document.querySelector('.search__input').value.toLowerCase();
            document.querySelectorAll('.accordion-item').forEach(item => {
                const invoiceNo = item.querySelector('#invoice_no').value.toLowerCase();
                if (searchValue === "" || invoiceNo.includes(searchValue)) {
                    item.classList.add('show');
                } else {
                    item.classList.remove('show');
                }
            });
        }

        // Attach event listener to the "Go" button
        document.querySelector('.go_btn').addEventListener('click', go_btn);

        // Attach event listener to the search input for real-time filtering
        document.querySelector('.search__input').addEventListener('input', go_btn);

        // Initially show all items
        document.querySelectorAll('.accordion-item').forEach(item => item.classList.add('show'));

</script>
</body>
</html>

