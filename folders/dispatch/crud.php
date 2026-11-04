<?php
// Get folder Name From Currnent Url 
$folder_name = explode("/", $_SERVER['PHP_SELF']);
$folder_name = $folder_name[count($folder_name) - 2];
// Database Country Table Name
$table = "invoice_creation_main";
// $table             = "view_dispatch_list_final";
$table_dispatch = "dispatch_list";
// Include DB file and Common Functions
include '../../config/dbconfig.php';
$fileUpload = new Alirdn\SecureUPload\SecureUPload($fileUploadConfig);
$fileUploadPath = $fileUploadConfig->get("upload_folder");
// Create Folder in root->uploads->(this_folder_name) Before using this file upload
$fileUploadConfig->set("upload_folder", $fileUploadPath . $folder_name . DIRECTORY_SEPARATOR);
// Variables Declaration
$action = $_POST['action'];
$action_obj = (object) [
    "status" => 0,
    "data" => "",
    "error" => "Action Not Performed"
];
$json_array = "";
$sql = "";
$user_type = "";
$is_active = "";
$unique_id = "";
$prefix = "";
$data = "";
$msg = "";
$error = "";
$status = "";
$test = ""; // For Developer Testing Purpose
switch ($action) {



    case 'createupdate':

        /* =========================================================
           GET POST VALUES
           ========================================================= */

        $po_num = $_POST["po_num"] ?? '';

        $po_date_input = $_POST["po_date"] ?? '';

        $date = DateTime::createFromFormat(
            'd-m-Y',
            $po_date_input
        );

        $po_date = $date
            ? $date->format('Y-m-d')
            : $po_date_input;


        $con_contact_name =
            $_POST["con_contact_name"] ?? '';

        $con_address =
            $_POST["con_address"] ?? '';

        $con_contact_number =
            $_POST["con_contact_number"] ?? '';


        $invoice_date_input =
            $_POST["invoice_date"] ?? '';

        $dateinvo = DateTime::createFromFormat(
            'd-m-Y',
            $invoice_date_input
        );

        $invoice_date = $dateinvo
            ? $dateinvo->format('Y-m-d')
            : $invoice_date_input;


        $invoice_no =
            trim($_POST["invoice_no"] ?? '');


        /*
         * Normalize DC Number
         *
         * Example:
         * CHN/DC/2525
         */
        $dc_no =
            preg_replace(
                '/\s+/',
                ' ',
                trim($_POST["dc_no"] ?? '')
            );


        $dc_date =
            $_POST["dc_date"] ?? '';

        $invoice_auto_id =
            $_POST["invoice_auto_id"] ?? '';

        $dispatch_status =
            $_POST["dispatch_status"] ?? '';

        $stock_id =
            $_POST["stock_id"] ?? '';

        $dispatch_date =
            $_POST["dispatch_date"] ?? '';

        $mode_of_delivery =
            $_POST["mode_of_delivery"] ?? '';

        $name_of_courier =
            $_POST["name_of_courier"] ?? '';

        $pod_no =
            $_POST["pod_no"] ?? '';

        $po_unique_id =
            $_POST["po_unique_id"] ?? '';

        $po_form_unique_id =
            $_POST["po_form_unique_id"] ?? '';

        $consignee_unique_id =
            $_POST["consignee_unique_id"] ?? '';

        $unique_id =
            $_POST["unique_id"] ?? '';

        $my_no =
            $_POST["my_no"] ?? '';


        /* =========================================================
           BASIC VALIDATION
           ========================================================= */

        if ($dc_no === '') {

            echo json_encode([
                "status" => false,
                "data" => "",
                "error" => "DC Number is required.",
                "msg" => "error",
                "sql" => ""
            ]);

            exit;
        }


        /* =========================================================
           AUTO-RESOLVE INVOICE NUMBER IF MISSING
           ========================================================= */

        if ($invoice_no === '') {

            // 1. Try finding invoice_no from invoice_creation_main by DC number
            if (!empty($dc_no)) {
                $clean_dc = str_replace(['/', '-', ' '], '', $dc_no);
                $stmt_inv = $conn->prepare("SELECT invoice_no, invoice_date, dc_date FROM invoice_creation_main WHERE (dc_number = :dc OR REPLACE(REPLACE(REPLACE(dc_number, '/', ''), '-', ''), ' ', '') = :clean_dc) AND is_delete = 0 ORDER BY unique_id DESC LIMIT 1");
                $stmt_inv->execute([':dc' => $dc_no, ':clean_dc' => $clean_dc]);
                $inv_row = $stmt_inv->fetch(PDO::FETCH_ASSOC);
                if (!empty($inv_row['invoice_no'])) {
                    $invoice_no = trim($inv_row['invoice_no']);
                    if (empty($invoice_date) && !empty($inv_row['invoice_date'])) {
                        $invoice_date = $inv_row['invoice_date'];
                    }
                    if (empty($dc_date) && !empty($inv_row['dc_date'])) {
                        $dc_date = $inv_row['dc_date'];
                    }
                }
            }

            // 2. Try finding invoice_no from dispatch_list by DC number
            if ($invoice_no === '' && !empty($dc_no)) {
                $clean_dc = str_replace(['/', '-', ' '], '', $dc_no);
                $stmt_inv2 = $conn->prepare("SELECT invoice_no, invoice_date, dc_date FROM dispatch_list WHERE (dc_number = :dc OR REPLACE(REPLACE(REPLACE(dc_number, '/', ''), '-', ''), ' ', '') = :clean_dc) AND is_delete = 0 ORDER BY unique_id DESC LIMIT 1");
                $stmt_inv2->execute([':dc' => $dc_no, ':clean_dc' => $clean_dc]);
                $inv_row2 = $stmt_inv2->fetch(PDO::FETCH_ASSOC);
                if (!empty($inv_row2['invoice_no'])) {
                    $invoice_no = trim($inv_row2['invoice_no']);
                    if (empty($invoice_date) && !empty($inv_row2['invoice_date'])) {
                        $invoice_date = $inv_row2['invoice_date'];
                    }
                    if (empty($dc_date) && !empty($inv_row2['dc_date'])) {
                        $dc_date = $inv_row2['dc_date'];
                    }
                }
            }

            // 3. Try finding invoice_no from invoice_creation_main by PO form and consignee
            if ($invoice_no === '' && !empty($po_form_unique_id) && !empty($consignee_unique_id)) {
                $stmt_inv3 = $conn->prepare("SELECT invoice_no, invoice_date, dc_date FROM invoice_creation_main WHERE form_main_unique_id = :form_id AND consignee_unique_id = :con_id AND is_delete = 0 ORDER BY unique_id DESC LIMIT 1");
                $stmt_inv3->execute([':form_id' => $po_form_unique_id, ':con_id' => $consignee_unique_id]);
                $inv_row3 = $stmt_inv3->fetch(PDO::FETCH_ASSOC);
                if (!empty($inv_row3['invoice_no'])) {
                    $invoice_no = trim($inv_row3['invoice_no']);
                    if (empty($invoice_date) && !empty($inv_row3['invoice_date'])) {
                        $invoice_date = $inv_row3['invoice_date'];
                    }
                    if (empty($dc_date) && !empty($inv_row3['dc_date'])) {
                        $dc_date = $inv_row3['dc_date'];
                    }
                }
            }
        }

        if ($invoice_no === '') {

            echo json_encode([
                "status" => false,
                "data" => "",
                "error" => "Invoice Number is required.",
                "msg" => "error",
                "sql" => ""
            ]);

            exit;
        }


        /* =========================================================
           CHECK DUPLICATE DC BEFORE FILE UPLOAD

           IMPORTANT BUSINESS RULE:

           CHN/DC/2525
           cannot repeat when is_delete = 0.

           But:

           CHN/DC/2525
           CHN/26-27/2525

           are different full DC numbers.
           ========================================================= */

        $table_details = [
            $table_dispatch,
            [
                'COUNT(dc_number) AS count'
            ]
        ];


        $select_where =
            'is_delete = 0
         AND dc_number = "'
            . $dc_no
            . '"';


        /*
         * During update,
         * exclude current dispatch_list record.
         */
        if (!empty($unique_id)) {

            $select_where .=
                ' AND unique_id != "'
                . $unique_id
                . '"';
        }


        $duplicate_result =
            $pdo->select(
                $table_details,
                $select_where
            );


        /*
         * Duplicate query itself failed
         */
        if (!$duplicate_result->status) {

            echo json_encode([
                "status" => false,
                "data" => $duplicate_result->data,
                "error" => $duplicate_result->error,
                "msg" => "error",
                "sql" => $duplicate_result->sql
            ]);

            exit;
        }


        $duplicate_count =
            (int) (
                $duplicate_result->data[0]['count']
                ?? 0
            );


        /*
         * Active DC already exists
         */
        if ($duplicate_count > 0) {

            echo json_encode([
                "status" => true,
                "data" => $duplicate_result->data,
                "error" => "",
                "msg" => "already",
                "sql" => $duplicate_result->sql
            ]);

            exit;
        }


        /* =========================================================
           DISPATCH E-INVOICE FILE UPLOAD

           This runs ONLY AFTER duplicate validation.
           ========================================================= */

        $file_names = '';
        $file_org_names = '';


        if (
            isset($_FILES['file'])
            &&
            isset($_FILES['file']['error'])
            &&
            $_FILES['file']['error'] === UPLOAD_ERR_OK
            &&
            !empty($_FILES['file']['name'])
        ) {

            try {

                /* -------------------------------------------------
                   GET EXTENSION
                   ------------------------------------------------- */

                $extension =
                    strtolower(
                        pathinfo(
                            $_FILES['file']['name'],
                            PATHINFO_EXTENSION
                        )
                    );


                $allowedExts = [
                    'pdf'
                ];


                /* -------------------------------------------------
                   VALIDATE FILE TYPE
                   ------------------------------------------------- */

                if (
                    !in_array(
                        $extension,
                        $allowedExts,
                        true
                    )
                ) {

                    throw new Exception(
                        'Only PDF file is allowed for E-Invoice.'
                    );
                }


                /* -------------------------------------------------
                   FIND ACADEMIC YEAR

                   Example:

                   Invoice:
                   CHN/26-27/3312

                   Folder:
                   2026-2027
                   ------------------------------------------------- */

                $uploadInfo =
                    prepareAcademicUploadFolder(
                        'dispatch',
                        $invoice_no,
                        $invoice_date,
                        $po_date,
                        $dc_no
                    );


                $academic_year =
                    $uploadInfo['academic_year'];


                $targetDir =
                    $uploadInfo['directory'];


                /* -------------------------------------------------
                   GENERATE SAFE DC FILE NAME

                   CHN/DC/2525

                   becomes

                   CHN-DC-2525
                   ------------------------------------------------- */

                $safe_dc_no =
                    getSafeDispatchNumber(
                        $dc_no
                    );


                if ($safe_dc_no === '') {

                    throw new Exception(
                        'Unable to generate Dispatch file name.'
                    );
                }


                /* -------------------------------------------------
                   FINAL FILE NAME

                   CHN-DC-2525-Dispatch.pdf
                   ------------------------------------------------- */

                $tem_name =
                    $safe_dc_no
                    . '-Dispatch.'
                    . $extension;


                /* -------------------------------------------------
                   FINAL PHYSICAL LOCATION

                   uploads/dispatch/
                   2026-2027/
                   CHN-DC-2525-Dispatch.pdf
                   ------------------------------------------------- */

                $destination =
                    $targetDir
                    . $tem_name;


                /* -------------------------------------------------
                   MOVE FILE
                   ------------------------------------------------- */

                if (
                    !move_uploaded_file(
                        $_FILES['file']['tmp_name'],
                        $destination
                    )
                ) {

                    throw new Exception(
                        'Unable to move Dispatch file to: '
                        . $destination
                    );
                }


                /*
                 * IMPORTANT:
                 *
                 * Store only file name in DB.
                 *
                 * DB:
                 *
                 * CHN-DC-2525-Dispatch.pdf
                 *
                 * Physical:
                 *
                 * uploads/dispatch/
                 * 2026-2027/
                 * CHN-DC-2525-Dispatch.pdf
                 */

                $file_names =
                    $tem_name;


                /*
                 * Original uploaded filename
                 */
                $file_org_names =
                    $_FILES['file']['name'];


            } catch (Throwable $e) {

                echo json_encode([
                    "status" => false,
                    "data" => "",
                    "error" => $e->getMessage(),
                    "msg" => "error",
                    "sql" => ""
                ]);

                exit;
            }
        }


        /* =========================================================
           SAFEGUARD COLUMN SIZES FOR dispatch_list
           Prevents Error 1406: Data too long for column 'con_address'
           ========================================================= */

        try {
            $conn->query("ALTER TABLE dispatch_list MODIFY con_address TEXT");
        } catch (Exception $e) {
            if (mb_strlen($con_address, 'UTF-8') > 255) {
                $con_address = mb_substr($con_address, 0, 255, 'UTF-8');
            }
        }

        /* =========================================================
           PREPARE DISPATCH_LIST COLUMNS
           ========================================================= */

        $columns = [

            "po_num" =>
                $po_num,

            "po_date" =>
                $po_date,

            "consignee" =>
                $con_contact_name,

            "con_address" =>
                $con_address,

            "con_contact_number" =>
                $con_contact_number,

            "invoice_date" =>
                $invoice_date,

            "invoice_no" =>
                $invoice_no,

            "dc_number" =>
                $dc_no,

            "dc_date" =>
                $dc_date,

            "invoice_auto_id" =>
                $invoice_auto_id,

            "stock_id" =>
                $stock_id,

            "dispatch_date" =>
                $dispatch_date,

            "mode_of_delivery" =>
                $mode_of_delivery,

            "name_of_courier" =>
                $name_of_courier,

            "pod_no" =>
                $pod_no,

            "status" =>
                1,

            "po_unique_id" =>
                $po_unique_id,

            "po_form_unique_id" =>
                $po_form_unique_id,

            "consignee_unique_id" =>
                $consignee_unique_id
        ];


        /*
         * Only replace existing file when
         * user actually uploaded a new file.
         *
         * This protects existing E-Invoice
         * during edit.
         */
        if (
            $file_names !== ''
            &&
            $file_org_names !== ''
        ) {

            $columns['einvoice_file'] =
                $file_names;

            $columns['einvoice_file_org'] =
                $file_org_names;
        }


        /* =========================================================
           FOR NEW RECORD ONLY CREATE UNIQUE ID
           ========================================================= */

        if (empty($unique_id)) {

            $columns['unique_id'] =
                unique_id($prefix);
        }


        /* =========================================================
           UPDATE invoice_creation_main

           Set Dispatch Status = 1
           ========================================================= */

        $columns_1 = [
            "dispatch_status" => 1
        ];


        $update_where_1 =
            'form_main_unique_id="'
            . $po_form_unique_id
            . '"
         AND consignee_unique_id="'
            . $consignee_unique_id
            . '"
         AND dc_number="'
            . $dc_no
            . '"';


        $action_obj_1 =
            $pdo->update(
                $table,
                $columns_1,
                $update_where_1
            );


        /* =========================================================
           CALL INVOICE VERIFICATION PROCEDURE
           ========================================================= */

        if (
            $action_obj_1
            &&
            $action_obj_1->status
        ) {

            try {

                $pdo->query(
                    "CALL update_invoice_verification_by_dcnumber()"
                );

            } catch (Exception $e) {

                /*
                 * Existing behavior:
                 * procedure failure should not
                 * stop Dispatch save.
                 */
            }
        }


        /* =========================================================
           UPDATE PAYMENT DATA
           ========================================================= */

        $table_new =
            "invoice_creation_main_payment_data";


        $columns_new = [

            "mode_of_delivery" =>
                $mode_of_delivery,

            "name_of_courier" =>
                $name_of_courier,

            "pod_no" =>
                $pod_no,

            "status" =>
                1
        ];


        /*
         * IMPORTANT:
         *
         * Don't set einvoice_file = ''
         * during edit when no new file uploaded.
         */
        if ($file_names !== '') {

            $columns_new['einvoice_file'] =
                $file_names;
        }


        $update_where_new =
            'form_main_unique_id="'
            . $po_form_unique_id
            . '"
         AND consignee_unique_id="'
            . $consignee_unique_id
            . '"
         AND dc_number="'
            . $dc_no
            . '"';


        $action_obj_new =
            $pdo->update(
                $table_new,
                $columns_new,
                $update_where_new
            );


        /* =========================================================
           INSERT / UPDATE DISPATCH_LIST
           ========================================================= */

        if (!empty($unique_id)) {

            /*
             * UPDATE EXISTING DISPATCH
             *
             * Use unique_id, not dc_number.
             */

            $update_where = [
                "unique_id" =>
                    $unique_id
            ];


            $action_obj =
                $pdo->update(
                    $table_dispatch,
                    $columns,
                    $update_where
                );


        } else {

            /*
             * INSERT NEW DISPATCH
             */

            $action_obj =
                $pdo->insert(
                    $table_dispatch,
                    $columns
                );
        }


        /* =========================================================
           RESPONSE
           ========================================================= */

        if ($action_obj->status) {

            $status =
                $action_obj->status;

            $data =
                $action_obj->data;

            $error = "";

            $sql =
                $action_obj->sql;


            if (!empty($unique_id)) {

                $msg =
                    "update";

            } else {

                $msg =
                    "create";
            }


        } else {

            $status =
                $action_obj->status;

            $data =
                $action_obj->data;

            $error =
                $action_obj->error;

            $sql =
                $action_obj->sql;

            $msg =
                "error";
        }


        $json_array = [

            "status" =>
                $status,

            "data" =>
                $data,

            "error" =>
                $error,

            "msg" =>
                $msg,

            "sql" =>
                $sql
        ];


        echo json_encode(
            $json_array
        );

        break;
    // case 'createupdate':
    //     $po_num = $_POST["po_num"];
    //     $po_date = $_POST['po_date'];

    //     $date = DateTime::createFromFormat('d-m-Y', $po_date);
    //     $po_date = $date->format('Y-m-d');
    //     $con_contact_name = $_POST["con_contact_name"];
    //     $con_address = $_POST["con_address"];
    //     $con_contact_number = $_POST["con_contact_number"];
    //     $invoice_date = $_POST["invoice_date"];
    //     $dateinvo = DateTime::createFromFormat('d-m-Y', $invoice_date);
    //     $invoice_date = $dateinvo->format('Y-m-d');
    //     $invoice_no = $_POST["invoice_no"];
    //     // $dc_no = $_POST["dc_no"];
    //     $dc_no = preg_replace('/\s+/', ' ', trim($_POST["dc_no"] ?? ''));
    //     $dc_date = $_POST["dc_date"];
    //     $invoice_auto_id = $_POST["invoice_auto_id"];
    //     $dispatch_status = $_POST["dispatch_status"];
    //     $stock_id = $_POST["stock_id"];
    //     $dispatch_date = $_POST["dispatch_date"];
    //     $mode_of_delivery = $_POST["mode_of_delivery"];
    //     $name_of_courier = $_POST["name_of_courier"];
    //     $pod_no = $_POST["pod_no"];
    //     $po_unique_id = $_POST["po_unique_id"];
    //     $po_form_unique_id = $_POST["po_form_unique_id"];
    //     $consignee_unique_id = $_POST["consignee_unique_id"];
    //     $unique_id = $_POST["unique_id"];
    //     $update_where = "";
    //     $my_no = $_POST["my_no"];
    //     // $parts = explode('/', $dc_no);
    //     // // Get the last value from the array
    //     // $po_num_value = end($parts);

    //     // $allowedExts = array('pdf');
    //     // $extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);

    //     // if ($_FILES['file']['type'] == 'application/pdf' && in_array(strtolower($extension), $allowedExts)) {
    //     //     $tem_name = $po_num_value . "-Dispatch" . '.pdf';

    //     //     move_uploaded_file($_FILES['file']['tmp_name'], '../../uploads/dispatch/' . $tem_name);

    //     //     // Set $file_names to the stored filename with .pdf extension
    //     //     $file_names = $tem_name;
    //     //     $file_org_names = $_FILES['file']['name'];
    //     // }


    //     /* =========================================================
    //        CHECK ACTIVE DC DUPLICATE BEFORE FILE UPLOAD
    //        ========================================================= */

    //     $table_details = [
    //         $table_dispatch,
    //         [
    //             'COUNT(dc_number) AS count'
    //         ]
    //     ];

    //     $select_where =
    //         'is_delete = 0
    //  AND dc_number = "' . $dc_no . '"';

    //     /*
    //      * For edit/update:
    //      * Don't treat current row as duplicate.
    //      */
    //     if (!empty($unique_id)) {

    //         $select_where .=
    //             ' AND unique_id != "' . $unique_id . '"';
    //     }

    //     $duplicate_result =
    //         $pdo->select(
    //             $table_details,
    //             $select_where
    //         );


    //     if (!$duplicate_result->status) {

    //         echo json_encode([
    //             "status" => false,
    //             "data" => "",
    //             "error" => $duplicate_result->error,
    //             "msg" => "error",
    //             "sql" => $duplicate_result->sql
    //         ]);

    //         exit;
    //     }


    //     $duplicate_count =
    //         (int) (
    //             $duplicate_result->data[0]['count']
    //             ?? 0
    //         );


    //     if ($duplicate_count > 0) {

    //         echo json_encode([
    //             "status" => true,
    //             "data" => "",
    //             "error" => "",
    //             "msg" => "already",
    //             "sql" => $duplicate_result->sql
    //         ]);

    //         exit;
    //     }

    //     /* =========================================================
    //        DISPATCH E-INVOICE UPLOAD
    //        ========================================================= */

    //     $file_names = '';
    //     $file_org_names = '';


    //     if (
    //         isset($_FILES['file'])
    //         &&
    //         isset($_FILES['file']['error'])
    //         &&
    //         $_FILES['file']['error'] === UPLOAD_ERR_OK
    //         &&
    //         !empty($_FILES['file']['name'])
    //     ) {

    //         try {

    //             /* ---------------------------------------------
    //                Validate extension
    //                --------------------------------------------- */

    //             $extension =
    //                 strtolower(
    //                     pathinfo(
    //                         $_FILES['file']['name'],
    //                         PATHINFO_EXTENSION
    //                     )
    //                 );


    //             $allowedExts = [
    //                 'pdf'
    //             ];


    //             if (
    //                 !in_array(
    //                     $extension,
    //                     $allowedExts,
    //                     true
    //                 )
    //             ) {

    //                 throw new Exception(
    //                     'Only PDF file is allowed for E-Invoice.'
    //                 );
    //             }


    //             /* ---------------------------------------------
    //                Get / create academic year folder

    //                Uses invoice_no first.
    //                --------------------------------------------- */

    //             $uploadInfo =
    //                 prepareAcademicUploadFolder(
    //                     'dispatch',
    //                     $invoice_no,
    //                     $invoice_date,
    //                     $po_date
    //                 );


    //             $academic_year =
    //                 $uploadInfo[
    //                     'academic_year'
    //                 ];


    //             $targetDir =
    //                 $uploadInfo[
    //                     'directory'
    //                 ];


    //             /* ---------------------------------------------
    //                Safe DC filename

    //                CHN/DC/2525

    //                =>

    //                CHN-DC-2525
    //                --------------------------------------------- */

    //             $safe_dc_no =
    //                 getSafeDispatchNumber(
    //                     $dc_no
    //                 );


    //             /* ---------------------------------------------
    //                Final filename

    //                CHN-DC-2525-Dispatch.pdf
    //                --------------------------------------------- */

    //             $tem_name =
    //                 $safe_dc_no
    //                 . '-Dispatch.'
    //                 . $extension;


    //             $destination =
    //                 $targetDir
    //                 . $tem_name;


    //             /* ---------------------------------------------
    //                Move uploaded file
    //                --------------------------------------------- */

    //             if (
    //                 !move_uploaded_file(
    //                     $_FILES['file']['tmp_name'],
    //                     $destination
    //                 )
    //             ) {

    //                 throw new Exception(
    //                     'Unable to move Dispatch file to: '
    //                     . $destination
    //                 );
    //             }


    //             /*
    //              * IMPORTANT:
    //              *
    //              * Keep ONLY filename in database.
    //              *
    //              * Database:
    //              * CHN-DC-2525-Dispatch.pdf
    //              *
    //              * Actual physical path:
    //              * 2026-2027/CHN-DC-2525-Dispatch.pdf
    //              */

    //             $file_names =
    //                 $tem_name;


    //             $file_org_names =
    //                 $_FILES['file']['name'];


    //         } catch (Throwable $e) {

    //             echo json_encode([
    //                 'status' => false,
    //                 'msg' => 'error',
    //                 'error' =>
    //                     $e->getMessage()
    //             ]);

    //             exit;
    //         }
    //     }

    //     if (($file_names) && ($file_org_names)) {
    //         $columns = [
    //             "po_num" => $po_num,
    //             "po_date" => $po_date,
    //             "consignee" => $con_contact_name,
    //             "con_address" => $con_address,
    //             "con_contact_number" => $con_contact_number,
    //             "invoice_date" => $invoice_date,
    //             "invoice_no" => $invoice_no,
    //             "dc_number" => $dc_no,
    //             "dc_date" => $dc_date,
    //             "invoice_auto_id" => $invoice_auto_id,
    //             "stock_id" => $stock_id,
    //             "dispatch_date" => $dispatch_date,
    //             "mode_of_delivery" => $mode_of_delivery,
    //             "name_of_courier" => $name_of_courier,
    //             "pod_no" => $pod_no,
    //             "status" => 1,
    //             "po_unique_id" => $po_unique_id,
    //             "po_form_unique_id" => $po_form_unique_id,
    //             "consignee_unique_id" => $consignee_unique_id,
    //             'einvoice_file' => $file_names,
    //             'einvoice_file_org' => $file_org_names,
    //             "unique_id" => unique_id($prefix)
    //         ];
    //     } else {
    //         $columns = [
    //             "po_num" => $po_num,
    //             "po_date" => $po_date,
    //             "consignee" => $con_contact_name,
    //             "con_address" => $con_address,
    //             "con_contact_number" => $con_contact_number,
    //             "invoice_date" => $invoice_date,
    //             "invoice_no" => $invoice_no,
    //             "dc_number" => $dc_no,
    //             "dc_date" => $dc_date,
    //             "invoice_auto_id" => $invoice_auto_id,
    //             "stock_id" => $stock_id,
    //             "dispatch_date" => $dispatch_date,
    //             "mode_of_delivery" => $mode_of_delivery,
    //             "name_of_courier" => $name_of_courier,
    //             "pod_no" => $pod_no,
    //             "status" => 1,
    //             "po_unique_id" => $po_unique_id,
    //             "po_form_unique_id" => $po_form_unique_id,
    //             "consignee_unique_id" => $consignee_unique_id,
    //             "unique_id" => unique_id($prefix)
    //         ];
    //     }

    //     // $table_details = [
    //     //     $table_dispatch,
    //     //     [
    //     //         'COUNT(dc_number) AS count'
    //     //     ]
    //     // ];
    //     // $select_where = 'is_delete = 0 AND dc_number ="' . $dc_no . '"';
    //     // $action_obj = $pdo->select($table_details, $select_where);


    // //     $table_details = [
    // //         $table_dispatch,
    // //         [
    // //             'COUNT(dc_number) AS count'
    // //         ]
    // //     ];


    // //     $select_where =
    // //         'is_delete = 0
    // //  AND dc_number = "'
    // //         . $dc_no
    // //         . '"';


    // //     if (!empty($unique_id)) {

    // //         $select_where .=
    // //             ' AND unique_id != "'
    // //             . $unique_id
    // //             . '"';
    // //     }


    // //     $action_obj =
    // //         $pdo->select(
    // //             $table_details,
    // //             $select_where
    // //         );



    //     if ($action_obj->status) {
    //         $status = $action_obj->status;
    //         $data = $action_obj->data;
    //         $error = '';
    //         $sql = $action_obj->sql;
    //     } else {
    //         $status = $action_obj->status;
    //         $data = $action_obj->data;
    //         $error = $action_obj->error;
    //         $sql = $action_obj->sql;
    //         $msg = 'error';
    //     }
    //     // print_r($action_obj );die();
    //     if ($data[0]['count']) {
    //         $msg = 'already';
    //     } else if (($data[0]['count'] == 0)) {


    //         $columns_1 = [
    //             "dispatch_status" => 1,
    //         ];

    //         // consignee_unique_id
    //         // $update_where_1   = [
    //         //         "form_main_unique_id"     => $po_form_unique_id
    //         //     ];
    //         $update_where_1 = 'form_main_unique_id="' . $po_form_unique_id . '" and consignee_unique_id="' . $consignee_unique_id . '" and dc_number="' . $dc_no . '"';

    //         // $action_obj_1 = $pdo->update($table, $columns_1, $update_where_1);

    //         // if ($action_obj1) {

    //         //     try {
    //         //         $pdo->query("CALL update_invoice_verification_by_dcnumber()");
    //         //     } catch (Exception $e) {

    //         //     }
    //         // }

    //         $action_obj_1 =
    //             $pdo->update(
    //                 $table,
    //                 $columns_1,
    //                 $update_where_1
    //             );


    //         if (
    //             $action_obj_1
    //             &&
    //             $action_obj_1->status
    //         ) {

    //             try {

    //                 $pdo->query(
    //                     "CALL update_invoice_verification_by_dcnumber()"
    //                 );

    //             } catch (Exception $e) {

    //             }
    //         }



    //         // new changes
    //         $table_new = "invoice_creation_main_payment_data";
    //         // $columns_new = [

    //         //     "mode_of_delivery" => $mode_of_delivery,
    //         //     "name_of_courier" => $name_of_courier,
    //         //     "pod_no" => $pod_no,
    //         //     "status" => 1,
    //         //     'einvoice_file' => $file_names,

    //         // ];

    //         $columns_new = [

    //             "mode_of_delivery" =>
    //                 $mode_of_delivery,

    //             "name_of_courier" =>
    //                 $name_of_courier,

    //             "pod_no" =>
    //                 $pod_no,

    //             "status" =>
    //                 1
    //         ];


    //         if ($file_names !== '') {

    //             $columns_new[
    //                 'einvoice_file'
    //             ] = $file_names;
    //         }
    //         $update_where_new = 'form_main_unique_id="' . $po_form_unique_id . '" and consignee_unique_id="' . $consignee_unique_id . '" and dc_number="' . $dc_no . '"';
    //         $action_obj_new = $pdo->update($table_new, $columns_new, $update_where_new);

    //         // print_r($action_obj_1);die();
    //         // Update Begins
    //         // if ($unique_id) {
    //         //     // echo "ff";die();
    //         //     unset($columns['unique_id']);
    //         //     $update_where = [
    //         //         "dc_number" => $dc_no
    //         //     ];
    //         //     $action_obj = $pdo->update($table_dispatch, $columns, $update_where);
    //         //     // Update Ends
    //         // } else {
    //         //     // echo "tt";die();
    //         //     // Insert Begins
    //         //     $action_obj = $pdo->insert($table_dispatch, $columns);
    //         //     // Insert Ends
    //         // }

    //         if ($unique_id) {

    //             unset($columns['unique_id']);

    //             $update_where = [
    //                 "unique_id" => $unique_id
    //             ];

    //             $action_obj =
    //                 $pdo->update(
    //                     $table_dispatch,
    //                     $columns,
    //                     $update_where
    //                 );

    //         } else {

    //             $action_obj =
    //                 $pdo->insert(
    //                     $table_dispatch,
    //                     $columns
    //                 );
    //         }
    //         // print_r($action_obj);
    //         if ($action_obj->status) {
    //             $status = $action_obj->status;
    //             $data = $action_obj->data;
    //             $error = "";
    //             $sql = $action_obj->sql;
    //             if ($unique_id) {
    //                 $msg = "update";
    //             } else {
    //                 $msg = "create";
    //             }
    //         } else {
    //             $status = $action_obj->status;
    //             $data = $action_obj->data;
    //             $error = $action_obj->error;
    //             $sql = $action_obj->sql;
    //             $msg = "error";
    //         }
    //     }
    //     $json_array = [
    //         "status" => $status,
    //         "data" => $data,
    //         "error" => $error,
    //         "msg" => $msg,
    //         "sql" => $sql
    //     ];
    //     echo json_encode($json_array);
    //     break;



    case 'datatable':
        // DataTable Variables
        $search = $_POST['search']['value'];
        $length = $_POST['length'];
        $start = $_POST['start'];
        $draw = $_POST['draw'];
        $from_date = $_POST['from_date'];
        $to_date = $_POST['to_date'];
        $opt1 = $_POST['opt1'];
        $limit = $length;
        $data = [];
        if ($length == '-1') {
            $limit = "";
        }
        $table_pending = "invoice_creation_main";
        // Query Variables
        $team_mem1 = $_POST['team_mem1'];

        $json_array = "";
        $columns = [
            "'' AS s_no",

            "(SELECT po_num 
      FROM po_form 
      WHERE unique_id = invoice_creation_main.form_main_unique_id 
        AND is_delete = 0 
      LIMIT 1) AS po_num",

            "(SELECT con_address 
      FROM consignee_details_sub 
      WHERE unique_id = invoice_creation_main.consignee_unique_id 
        AND is_delete = 0 
      LIMIT 1) AS con_address",

            "(SELECT staff_name 
      FROM user 
      WHERE staff_id = invoice_creation_main.team_mem 
        AND is_delete = 0 
      LIMIT 1) AS team_member",

            "invoice_auto_id",
            "DATE_FORMAT(dc_date, '%d-%m-%Y') AS dc_date",
            "invoice_qty",
            "invoice_value",
            "doc_approval_sts",
            "ac_team_verifiy_status",
            "material_qc",
            "unique_id",
            "invoice_no",
            "form_main_unique_id",
            "ac_team_approved_by",
            "approved_by",
            "team_mem",
            "material_qc_approved",
            "consignee_unique_id",
            "dc_number",
            "DATE_FORMAT(po_date, '%d-%m-%Y') AS po_date",

            "(SELECT ledger_name 
      FROM department_creation_sublist 
      WHERE unique_id = invoice_creation_main.ledger_name 
        AND is_delete = 0 
      LIMIT 1) AS ledger_name",

            "DATE_FORMAT(invoice_date, '%d-%m-%Y') AS invoice_date",
        ];

        $table_details = [

            $table_pending,
            $columns
        ];

        $where = "
    dispatch_status = 0
    AND material_qc = '1'
    AND ac_team_verifiy_status = '1'
    AND is_delete = '0'  AND NOT EXISTS (
        SELECT 1
        FROM dispatch_list d
        WHERE d.dc_number = invoice_creation_main.dc_number
          AND d.is_delete = '0'
    )
";






        $from_date = $_POST['from_date'] ?? '';
        $to_date = $_POST['to_date'] ?? '';

        if (!empty($from_date) && !empty($to_date)) {

            if ($opt1 === '101') {
                // po_date
                $where .= " AND po_date BETWEEN '$from_date' AND '$to_date'";
            } elseif ($opt1 === '100') {
                // invoice_date
                $where .= " AND invoice_date BETWEEN '$from_date' AND '$to_date'";
            }
        }





        if ($_SESSION['user_type_unique_id'] === '5f97fc3257f2525529' || $_SESSION['user_type_unique_id'] === '65deef78ba17d65741') {
            if ($team_mem1 == '') {
                $where .= " ";
            } else {
                $where .= " and team_mem = '$team_mem1' ";
            }
        } else {
            if ($team_mem1 == '') {
                $where .= " ";
            } else {
                $where .= " and team_mem = '$team_mem1' ";
            }
        }

        $order_column = $_POST["order"][0]["column"];
        $order_dir = $_POST["order"][0]["dir"];
        // Datatable Ordering 
        $order_by = datatable_sorting($order_column, $order_dir, $columns);
        // Datatable Searching
        $search = datatable_searching($search, $columns);

        if ($search) {
            if ($where) {
                $where .= " AND ";
            }
            $where .= $search;
        }

        // $sql_function = "SQL_CALC_FOUND_ROWS";

        $result = $pdo->select($table_details, $where, $limit, $start, $order_by);
        // print_r( $result);
        // $total_records = total_records();
        $screen_id_val = $_POST['screen_id_val'];
        $user_type = $_POST['user_type_unique_id'];

        $table_user = "user_screen_permission";
        $columns = [
            "action_unique_id",
            "user_type"
        ];
        $select_where = "screen_unique_id='" . $screen_id_val . "' AND user_type='" . $user_type . "'";
        $table_details = [
            $table_user,
            $columns
        ];

        $table_users = $pdo->select($table_details, $select_where);

        $table_users = $table_users->data;


        $action_ids = [];
        foreach ($table_users as $item) {
            if (isset($item['action_unique_id'])) {
                $action_ids[] = $item['action_unique_id'];
            }
        }
        if ($result->status) {
            $res_array = $result->data;
            foreach ($res_array as $key => $value) {
                $value['s_no'] = $sno + 1;
                $value['dc_date'] = '<span style="font-weight:bold;text-transform: uppercase;">' . $value['dc_number'] . '</span><br><span style="text-transform: uppercase;">' . $value['dc_date'] . '</span>';

                $value['po_num'] = '<span style="font-weight:bold;text-transform: uppercase;">' . $value['po_num'] . '</span><br><span style="text-transform: uppercase;">' . $value['po_date'] . '</span>';


                $value['con_address'] = '<span style="font-weight:bold;text-transform: uppercase;">' . $value['ledger_name'] . '</span><br><span style="text-transform: uppercase;">' . $value['con_address'] . '</span>';

                $value['invoice_auto_id'] = '<span style="font-weight:bold;text-transform: uppercase;">' . $value['invoice_no'] . '</span><br><span style="text-transform: uppercase;">' . $value['invoice_date'] . '</span>';



                $value['invoice_qty'] = '<div style="text-align:right;"><span>' . $value['invoice_qty'] . '</span></div>';

                $invoice_value = $value['invoice_value'];


                $value['invoice_value'] = '<div style="text-align:right;"><span>' . moneyFormatIndia1(($invoice_value)) . '</span></div>';


                $invoice_qtSy = $value['invoice_qty'];
                $unit_price = $value['unit_price'];
                $value['unit_price'] = (($unit_price) * ($invoice_qty));


                if ($value['doc_approval_sts'] == 0) {
                    $value['doc_approval_sts'] = 'pending' . ' / ' . $value['approved_by'];
                } else if ($value['doc_approval_sts'] == 1) {
                    $value['doc_approval_sts'] = 'Approved' . ' / ' . $value['approved_by'];
                } else {
                    $value['doc_approval_sts'] = 'Rejected' . ' / ' . $value['approved_by'];
                }


                if ($value['ac_team_verifiy_status'] == 0) {
                    $value['ac_team_verifiy_status'] = 'Pending' . ' / ' . $value['ac_team_approved_by'];
                } else if ($value['ac_team_verifiy_status'] == 1) {
                    $value['ac_team_verifiy_status'] = 'Approved' . ' / ' . $value['ac_team_approved_by'];
                } else {
                    $value['ac_team_verifiy_status'] = 'Rejected' . ' / ' . $value['ac_team_approved_by'];
                }
                $value['po_date'] = '<span class="po_date">' . $value['po_date'] . '</span>';


                if ($value['material_qc'] == 0) {
                    $value['material_qc'] = 'Pending' . ' / ' . $value['material_qc_approved'];
                } else if ($value['material_qc'] == 1) {
                    $value['material_qc'] = 'Approved' . ' / ' . $value['material_qc_approved'];
                } else {
                    $value['material_qc'] = 'Not Approved' . ' / ' . $value['material_qc_approved'];
                }




                $btn_update = update_dispatch_pending_btn($folder_name, $value['form_main_unique_id'], $value['consignee_unique_id'], $value['dc_number']);


                if (in_array('5f88082b25ec031952', $action_ids)) {
                    $value['unique_id'] = $btn_update;
                } else {

                    $value['unique_id'] = '';
                }
                $data[] = array_values($value);
                $sno++;
            }
            $json_array = [
                "draw" => intval($draw),
                "recordsTotal" => intval($total_records),
                "recordsFiltered" => intval($total_records),
                "data" => $data,
                "testing" => $result->sql
            ];
        } else {
            print_r($result);
        }
        echo json_encode($json_array);
        break;

    case 'fixed_datatable':
        // DataTable Variables
        $search = $_POST['search']['value'];
        $length = $_POST['length'];
        $start = $_POST['start'];
        $draw = $_POST['draw'];
        $from_date = $_POST['from_date'];
        $to_date = $_POST['to_date'];
        $opt = $_POST['opt'];
        $limit = $length;
        $data = [];
        if ($length == '-1') {
            $limit = "";
        }
        $table_transit = "dispatch_list";
        $team_mem2 = $_POST['team_mem2'];

        // Query Variables
        $json_array = "";
        $columns = [
            "'' AS s_no",
            "po_num",

            "(SELECT con_address
      FROM consignee_details_sub
      WHERE unique_id = dispatch_list.consignee_unique_id
        AND is_delete = 0
      LIMIT 1) AS con_address",

            "(SELECT staff_name
      FROM user
      WHERE staff_id = (
          SELECT team_mem
          FROM invoice_creation_main
          WHERE invoice_no = dispatch_list.invoice_no and dispatch_list.dc_number = invoice_creation_main.dc_number
            AND is_delete = 0
          LIMIT 1
      )
      AND is_delete = 0
      LIMIT 1) AS team_member",

            "invoice_date",
            "DATE_FORMAT(dc_date, '%d-%m-%Y') AS dc_date",
            "DATE_FORMAT(dispatch_date, '%d-%m-%Y') AS dispatch_date",
            "mode_of_delivery",
            "name_of_courier",
            "pod_no",
            "status",
            "einvoice_file as einvoice",
            "unique_id",
            "invoice_auto_id",
            "po_form_unique_id",
            "consignee_unique_id",
            "invoice_no",
            "po_date",

            "(SELECT ledger_name
      FROM department_creation_sublist
      WHERE unique_id = (
          SELECT ledger_name
          FROM invoice_creation_main
          WHERE invoice_no = dispatch_list.invoice_no
            AND is_delete = 0
          LIMIT 1
      )
      AND is_delete = 0
      LIMIT 1) AS ledger_name",

            "dc_number"
        ];

        $table_details = [
            $table_transit,
            $columns
        ];

        $where = "dispatch_list.is_delete = 0 AND dispatch_list.status = 1 ";

        if (!empty($from_date) && !empty($to_date)) {

            if ($opt == '4') {
                $where .= " AND po_date BETWEEN '$from_date' AND '$to_date'";
            } else if ($opt == '5') {
                $where .= " AND invoice_date BETWEEN '$from_date' AND '$to_date'";
            }
        }



        if ($_SESSION['user_type_unique_id'] === '5f97fc3257f2525529' || $_SESSION['user_type_unique_id'] === '65deef78ba17d65741') {
            if (!empty($team_mem2)) {
                $where .= " AND team_mem = '$team_mem2'";
            }

        }


        // else if($opt == '6') {

        //     $where .= "AND dispatch_date >= '" . $from_date . "' AND dispatch_date <= '" . $to_date . "' ";
        // } 
        $order_column = $_POST["order"][0]["column"];
        $order_dir = $_POST["order"][0]["dir"];
        // Datatable Ordering 
        $order_by = datatable_sorting($order_column, $order_dir, $columns);
        // $order_by = "DATE_FORMAT(po_date, '%Y-%m-%d') $order_dir";
        // $order_by = "DATE_FORMAT(invoice_date, '%Y-%m-%d') $order_dir";



        // Datatable Searching
        $search = datatable_searching($search, $columns);
        if ($search) {
            if ($where) {
                $where .= " AND ";
            }
            $where .= $search;
        }
        // $sql_function = "SQL_CALC_FOUND_ROWS";
        $result = $pdo->select($table_details, $where, $limit, $start, $order_by, $sql_function);
        // print_r($result);
        // $total_records = total_records();
        $screen_id_val = $_POST['screen_id_val'];
        $user_type = $_POST['user_type_unique_id'];

        $table_user = "user_screen_permission";
        $columns = [
            // "screen_unique_id",
            "action_unique_id",
            "user_type"
        ];
        $select_where = "screen_unique_id='" . $screen_id_val . "' AND user_type='" . $user_type . "'";
        $table_details = [
            $table_user,
            $columns
        ];

        $table_users = $pdo->select($table_details, $select_where);

        $table_users = $table_users->data;


        $action_ids = [];
        foreach ($table_users as $item) {
            if (isset($item['action_unique_id'])) {
                $action_ids[] = $item['action_unique_id'];
            }
        }

        if ($result->status) {
            $res_array = $result->data;
            foreach (
                $res_array
                as $key => $value
            ) {

                $raw_invoice_no =
                    $value['invoice_no']
                    ?? '';

                $raw_invoice_date =
                    $value['invoice_date']
                    ?? '';

                $raw_po_date =
                    $value['po_date']
                    ?? '';

                $raw_dc_number =
                    $value['dc_number']
                    ?? '';


                $value['s_no'] =
                    $sno + 1;

                //   $value['po_num'] = $value['po_num'] . '<br><span style="font-weight:bold;text-transform: uppercase;">' .  $value['po_date'] . '</span>';

                // $value['con_address'] = $value['con_address'] . '<br><span style="font-weight:bold;text-transform: uppercase;">' .  $value['ledger_name'] . '</span>';

                // $value['invoice_date'] = $value['invoice_no'] . '<br><span style="font-weight:bold;text-transform: uppercase;">' .  $value['invoice_date'] . '</span>';

                // $value['dc_date'] = $value['dc_number'] . '<br><span style="font-weight:bold;text-transform: uppercase;">' .  $value['dc_date'] . '</span>';
                $value['dc_date'] = '<span style="font-weight:bold;text-transform: uppercase;">' . $value['dc_number'] . '</span><br><span style="text-transform: uppercase;">' . $value['dc_date'] . '</span>';

                // $orgDate = $value['po_date'];
                // $value['po_date'] = '<span class="po_date">' . date("d-m-Y", strtotime($value['po_date'])) . '</span>';

                // $value['po_num'] = '<span style="font-weight:bold;text-transform: uppercase;">' . $value['po_num'] . '</span><br>' . $value['po_date'] ;
                $value['po_num'] = '<span style="font-weight:bold;text-transform: uppercase;">' . $value['po_num'] . '</span><br><span style="text-transform: uppercase;">' . $value['po_date'] . '</span>';

                // $value['con_address'] = '<span style="font-weight:bold;text-transform: uppercase;">' . $value['con_address'] . '</span><br>' . $value['ledger_name'] ;

                $value['con_address'] = '<span style="font-weight:bold;text-transform: uppercase;">' . $value['ledger_name'] . '</span><br><span style="text-transform: uppercase;">' . $value['con_address'] . '</span>';

                // $value['invoice_no'] = '<span style="font-weight:bold;text-transform: uppercase;">' . $value['invoice_no'] . '</span><br>' . $value['invoice_date'] ;
                $value['invoice_date'] = '<span style="font-weight:bold;text-transform: uppercase;">' . $value['invoice_no'] . '</span><br><span style="text-transform: uppercase;">' . $value['invoice_date'] . '</span>';



                // $value['invoice_date'] = '<span class="invoice_date">' . $value['invoice_date'] . '</span>';
                $value['dispatch_date'] = '<span class="invoice_date">' . $value['dispatch_date'] . '</span>';

                $value['pod_no'] = '<div style="text-align:right;"><span>' . $value['pod_no'] . '</span></div>';
                // $value['einvoice'] = image_view("dispatch", $value['unique_id'], $value['einvoice']);
                $value['einvoice'] =
                    image_view(
                        "dispatch",
                        $value['unique_id'],
                        $value['einvoice'],
                        $raw_invoice_no,
                        $raw_invoice_date,
                        $raw_po_date
                    );
                if ($value['status'] == "1") {
                    $value['status'] = "Pending";
                }
                if ($value['mode_of_delivery'] == "1") {
                    $value['mode_of_delivery'] = "Hand";
                } else {
                    $value['mode_of_delivery'] = "Courier";
                }
                $value['po_date'] = '<span class="po_date">' . $value['po_date'] . '</span>';


                $btn_update = dispatch_transit_update_btn($folder_name, $value['po_form_unique_id'], $value['consignee_unique_id'], $value['dc_number']);

                if (in_array('5f88082b25ec031952', $action_ids)) {
                    $value['unique_id'] = $btn_update;


                } else {
                    //  if(in_array('5f8808504271036738', $action_ids)){
                    //     $value['unique_id'] = $btn_delete;
                    // }
                    // else{
                    $value['unique_id'] = '';
                }

                $data[] = array_values($value);
                $sno++;
            }
            $json_array = [
                "draw" => intval($draw),
                "recordsTotal" => intval($total_records),
                "recordsFiltered" => intval($total_records),
                "data" => $data,
                "testing" => $result->sql
            ];
        } else {
            print_r($result);
        }
        echo json_encode($json_array);
        break;

    case 'deleivery_datatable':
        // DataTable Variables
        $search = $_POST['search']['value'];
        $length = $_POST['length'];
        $start = $_POST['start'];
        $draw = $_POST['draw'];
        $from_date = $_POST['from_date'];
        $to_date = $_POST['to_date'];
        $opt3 = $_POST['opt3'];
        $limit = $length;
        $data = [];

        if ($length == '-1') {
            $limit = "";
        }
        $table_delivery = "dispatch_list";
        $team_mem3 = $_POST['team_mem3'];
        // Query Variables

        $json_array = "";
        $columns = [
            "'' AS s_no",
            "po_num",
            "get_address(consignee_unique_id) AS con_address",

            "(SELECT staff_name
      FROM user
      WHERE staff_id = (
          SELECT team_mem
          FROM invoice_creation_main
          WHERE invoice_no = dispatch_list.invoice_no
            AND is_delete = 0
          LIMIT 1
      )
      AND is_delete = 0
      LIMIT 1) AS team_member",

            "invoice_no",
            "DATE_FORMAT(dc_date, '%d-%m-%Y') AS dc_date",
            "pod_no",

            "(SELECT dc_file_name
      FROM invoice_sublist
      WHERE dc_number = dispatch_list.dc_number
        AND is_delete = 0
      LIMIT 1) AS dc_file",

            "(SELECT ir_file_name
      FROM invoice_sublist
      WHERE dc_number = dispatch_list.dc_number
        AND is_delete = 0
      LIMIT 1) AS ir_file_org_name",

            "(SELECT file_invoice
      FROM invoice_sublist
      WHERE dc_number = dispatch_list.dc_number
        AND is_delete = 0
      LIMIT 1) AS invoice_file_org_name",

            "einvoice_file as einvoice",
            "delivery_status",
            "delivery_date",
            "delivery_proof",
            "pod_proof",
            "po_form_unique_id",
            "unique_id",
            "(SELECT staff_name
      FROM user
      WHERE staff_id = (
          SELECT team_mem
          FROM invoice_creation_main
          WHERE invoice_no = dispatch_list.invoice_no
            AND is_delete = 0
          LIMIT 1
      )
      AND is_delete = 0
      LIMIT 1) AS team_mem",
            "invoice_auto_id",
            "po_date",
            "invoice_date",

            "(SELECT ledger_name
      FROM department_creation_sublist
      WHERE unique_id = (
          SELECT ledger_name
          FROM invoice_creation_main
          WHERE invoice_no = dispatch_list.invoice_no
            AND is_delete = 0
          LIMIT 1
      )
      AND is_delete = 0
      LIMIT 1) AS ledger_name",

            "dc_number",
            "consignee_unique_id"
        ];

        $table_details = [
            $table_delivery,
            $columns
        ];
        $where = "
    dispatch_list.is_delete = 0
    AND (dispatch_list.status = '2' OR dispatch_list.status = '3')
";


        if (!empty($from_date) && !empty($to_date)) {

            if ($opt3 == '40') {
                $where .= " AND po_date BETWEEN '$from_date' AND '$to_date'";
            } else if ($opt3 == '50') {
                $where .= " AND invoice_date BETWEEN '$from_date' AND '$to_date'";
            } else if ($opt3 == '60') {
                $where .= " AND delivery_date BETWEEN '$from_date' AND '$to_date'";
            }
        }


        if ($_SESSION['user_type_unique_id'] === '5f97fc3257f2525529' || $_SESSION['user_type_unique_id'] === '65deef78ba17d65741') {

            if (!empty($team_mem3)) {
                $where .= " AND team_mem = '$team_mem3'";
            }

        }

        $order_column = $_POST["order"][0]["column"];
        $order_dir = $_POST["order"][0]["dir"];
        // Datatable Ordering 
        $order_by = datatable_sorting($order_column, $order_dir, $columns);

        // Datatable Searching
        $search = datatable_searching($search, $columns);
        if ($search) {
            if ($where) {
                $where .= " AND ";
            }
            $where .= $search;
        }

        $result = $pdo->select($table_details, $where, $limit, $start, $order_by, $sql_function);

        if ($result->status) {

            $res_array =
                $result->data;


            foreach (
                $res_array
                as $key => $value
            ) {

                /*
                 * MUST be inside foreach
                 * before changing values to HTML
                 */

                $raw_invoice_no =
                    $value['invoice_no']
                    ?? '';

                $raw_invoice_date =
                    $value['invoice_date']
                    ?? '';

                $raw_po_date =
                    $value['po_date']
                    ?? '';

                $raw_dc_number =
                    $value['dc_number']
                    ?? '';


                $value['s_no'] =
                    $sno + 1;
                $orgDate = $value['po_date'];

                $value['po_num'] = '<span style="font-weight:bold;text-transform: uppercase;">' . $value['po_num'] . '</span><br>' . date("d-m-Y", strtotime($orgDate));

                $value['con_address'] = '<span style="font-weight:bold;text-transform: uppercase;">' . $value['ledger_name'] . '</span><br>' . $value['con_address'];

                $value['invoice_no'] = '<span style="font-weight:bold;text-transform: uppercase;">' . $value['invoice_no'] . '</span><br>' . $value['invoice_date'];

                $value['dc_date'] = '<span style="font-weight:bold;text-transform: uppercase;">' . $value['dc_number'] . '</span><br>' . $value['dc_date'];

                $value['pod_no'] = '<div style="text-align:right;"><span>' . $value['pod_no'] . '</span></div>';

                $value['invoice_date'] = '<span class="invoice_date">' . $value['invoice_date'] . '</span>';

                $orgDate2 = $value['delivery_date'];
                $value['delivery_date'] = date("d-m-Y", strtotime($orgDate2));
                $value['delivery_proof'] =
                    image_view(
                        "dispatch",
                        $value['unique_id'],
                        $value['delivery_proof'],
                        $raw_invoice_no,
                        $raw_invoice_date,
                        $raw_po_date
                    );

                $value['pod_proof'] =
                    image_view(
                        "dispatch",
                        $value['unique_id'],
                        $value['pod_proof'],
                        $raw_invoice_no,
                        $raw_invoice_date,
                        $raw_po_date
                    );
                $value['einvoice'] =
                    image_view(
                        "dispatch",
                        $value['unique_id'],
                        $value['einvoice'],
                        $raw_invoice_no,
                        $raw_invoice_date,
                        $raw_po_date
                    );
                $value['dc_file'] =
                    image_view1(
                        "invoice",
                        $value['unique_id'],
                        $value['dc_file'],
                        $raw_invoice_no,
                        $raw_invoice_date,
                        $raw_po_date
                    );
                $value['ir_file_org_name'] =
                    image_view1(
                        "invoice",
                        $value['unique_id'],
                        $value['ir_file_org_name'],
                        $raw_invoice_no,
                        $raw_invoice_date,
                        $raw_po_date
                    );
                $value['invoice_file_org_name'] =
                    image_view1(
                        "invoice",
                        $value['unique_id'],
                        $value['invoice_file_org_name'],
                        $raw_invoice_no,
                        $raw_invoice_date,
                        $raw_po_date
                    );
                // $value['delivery_proof'] = image_view("dispatch", $value['unique_id'], $value['delivery_proof']);
                // $value['pod_proof'] = image_view("dispatch", $value['unique_id'], $value['pod_proof']);
                // $value['dc_file'] = image_view1("invoice", $value['dc_number'], $value['dc_file']);
                // $value['ir_file_org_name'] = image_view1("invoice", $value['dc_number'], $value['ir_file_org_name']);
                // $value['invoice_file_org_name'] = image_view1("invoice", $value['dc_number'], $value['invoice_file_org_name']);
                // $value['einvoice'] = image_view("dispatch", $value['dc_number'], $value['einvoice']);

                if ($value['delivery_status'] == "1") {
                    $value['delivery_status'] = "yes";
                } else if ($value['delivery_status'] == "2") {
                    $value['delivery_status'] = "NO";
                }
                $value['po_date'] = '<span class="po_date">' . $value['po_date'] . '</span>';

                $btn_update = dispatch_delivery_update_btn($folder_name, $value['po_form_unique_id'], $value['consignee_unique_id'], $value['dc_number']);

                $value['po_form_unique_id'] = $btn_update;
                $data[] = array_values($value);
                $sno++;
            }
            $json_array = [
                "draw" => intval($draw),
                "recordsTotal" => intval($total_records),
                "recordsFiltered" => intval($total_records),
                "data" => $data,
                "testing" => $result->sql
            ];
        } else {
            print_r($result);
        }
        echo json_encode($json_array);
        break;



    case 'deleivery_status':

        $delivery_status = $_POST["delivery_status"];
        $delivery_date = $_POST["delivery_date"];
        $invoice_no = $_POST["invoice_no"];
        // $dc_no = $_POST["dc_no"];
        $dc_no = preg_replace('/\s+/', ' ', trim($_POST["dc_no"] ?? ''));
        $dc_date = $_POST["dc_date"];
        $status = $_POST["status"];
        $po_form_unique_id = $_POST["po_form_unique_id"];
        $consignee_unique_id = $_POST["consignee_unique_id"];
        $my_no = $_POST["my_no"];
        $mode_of_delivery = $_POST["mode_of_delivery"];
        $name_of_courier = $_POST["name_of_courier"];
        $pod_no = $_POST["pod_no"];
        $dispatch_date = $_POST["dispatch_date"];
        // $parts = explode('/', $my_no);
        // $parts = explode('/', $dc_no);
        // Get the last value from the array
        // $po_num_value = end($parts);

        // $allowedExts = array('pdf', 'jpg', 'jpeg', 'png', 'xls', 'xlsx'); // Add more as needed
        // $allowedMimeTypes = array(
        //     'application/pdf' => 'pdf',
        //     'image/jpeg' => 'jpg',
        //     'image/png' => 'png',
        //     'application/vnd.ms-excel' => 'xls',
        //     'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'xlsx'
        // );

        // $file = $_FILES['file']['name'];
        // $podfile = $_FILES['podfile']['name'];
        // $extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
        // $podextension = pathinfo($_FILES['podfile']['name'], PATHINFO_EXTENSION);
        // $tem_name = $po_num_value . "-Transit." . $extension;
        // $podtem_name = $po_num_value . "-POD." . $podextension;
        // $targetDir = '../../uploads/dispatch/';



        // if (move_uploaded_file($_FILES['file']['tmp_name'], '../../uploads/dispatch/' . $tem_name)) {
        //     // Set filenames
        //     $file_names = $tem_name;
        //     $file_org_names = $_FILES['file']['name'];
        //     //     echo "File uploaded successfully.";
        // }
        // if (move_uploaded_file($_FILES['podfile']['tmp_name'], '../../uploads/dispatch/' . $podtem_name)) {
        //     // Set filenames
        //     $podfile_names = $podtem_name;
        //     $podfile_org_names = $_FILES['podfile']['name'];
        //     //     echo "File uploaded successfully.";
        // }

        /* =========================================================
   DEFAULT FILE VARIABLES
   ========================================================= */

        $file_names = '';
        $file_org_names = '';

        $podfile_names = '';
        $podfile_org_names = '';


        /* =========================================================
           FETCH DISPATCH META

           This makes the backend safe even if invoice_no
           is not posted from the Delivery JS.
           ========================================================= */

        $dispatchMetaResult =
            $pdo->select(
                [
                    'dispatch_list',
                    [
                        'invoice_no',
                        'invoice_date',
                        'po_date'
                    ]
                ],
                "po_form_unique_id = '"
                . $po_form_unique_id
                . "'
         AND consignee_unique_id = '"
                . $consignee_unique_id
                . "'
         AND dc_number = '"
                . $dc_no
                . "'
         AND is_delete = 0"
            );


        $meta_invoice_no =
            $invoice_no ?? '';

        $meta_invoice_date = '';

        $meta_po_date = '';


        if (
            $dispatchMetaResult->status
            &&
            !empty(
            $dispatchMetaResult->data
        )
        ) {

            if (empty($meta_invoice_no)) {

                $meta_invoice_no =
                    $dispatchMetaResult
                        ->data[0]['invoice_no']
                    ?? '';
            }


            $meta_invoice_date =
                $dispatchMetaResult
                    ->data[0]['invoice_date']
                ?? '';


            $meta_po_date =
                $dispatchMetaResult
                    ->data[0]['po_date']
                ?? '';
        }


        /* =========================================================
           PREPARE YEAR DIRECTORY
           ========================================================= */

        try {

            $uploadInfo =
                prepareAcademicUploadFolder(
                    'dispatch',
                    $meta_invoice_no,
                    $meta_invoice_date,
                    $meta_po_date,
                    $dc_no
                );


            $targetDir =
                $uploadInfo[
                    'directory'
                ];


            $safe_dc_no =
                getSafeDispatchNumber(
                    $dc_no
                );


            $allowedExts = [
                'pdf',
                'jpg',
                'jpeg',
                'png',
                'xls',
                'xlsx'
            ];


            /* =====================================================
               TRANSIT FILE
               ===================================================== */

            if (
                isset($_FILES['file'])
                &&
                isset($_FILES['file']['error'])
                &&
                $_FILES['file']['error'] === UPLOAD_ERR_OK
                &&
                !empty($_FILES['file']['name'])
            ) {

                $extension =
                    strtolower(
                        pathinfo(
                            $_FILES['file']['name'],
                            PATHINFO_EXTENSION
                        )
                    );


                if (
                    !in_array(
                        $extension,
                        $allowedExts,
                        true
                    )
                ) {

                    throw new Exception(
                        'Invalid Transit file type.'
                    );
                }


                $tem_name =
                    $safe_dc_no
                    . '-Transit.'
                    . $extension;


                $destination =
                    $targetDir
                    . $tem_name;


                if (
                    !move_uploaded_file(
                        $_FILES['file']['tmp_name'],
                        $destination
                    )
                ) {

                    throw new Exception(
                        'Transit file upload failed.'
                    );
                }


                $file_names =
                    $tem_name;


                $file_org_names =
                    $_FILES['file']['name'];
            }


            /* =====================================================
               POD FILE
               ===================================================== */

            if (
                isset($_FILES['podfile'])
                &&
                isset($_FILES['podfile']['error'])
                &&
                $_FILES['podfile']['error'] === UPLOAD_ERR_OK
                &&
                !empty($_FILES['podfile']['name'])
            ) {

                $podextension =
                    strtolower(
                        pathinfo(
                            $_FILES['podfile']['name'],
                            PATHINFO_EXTENSION
                        )
                    );


                if (
                    !in_array(
                        $podextension,
                        $allowedExts,
                        true
                    )
                ) {

                    throw new Exception(
                        'Invalid POD file type.'
                    );
                }


                $podtem_name =
                    $safe_dc_no
                    . '-POD.'
                    . $podextension;


                $podDestination =
                    $targetDir
                    . $podtem_name;


                if (
                    !move_uploaded_file(
                        $_FILES['podfile']['tmp_name'],
                        $podDestination
                    )
                ) {

                    throw new Exception(
                        'POD file upload failed.'
                    );
                }


                $podfile_names =
                    $podtem_name;


                $podfile_org_names =
                    $_FILES['podfile']['name'];
            }


        } catch (Throwable $e) {

            echo json_encode([
                'status' => false,
                'msg' => 'error',
                'error' =>
                    $e->getMessage()
            ]);

            exit;
        }

        $update_where = "";
        // $columns = [
        //     "delivery_status" => $delivery_status,
        //     "delivery_date" => $delivery_date,
        //     'delivery_proof' => $file_names,
        //     'file_name' => $file_names,
        //     'file_org_name' => $file_org_names,
        //     'pod_proof' => $podfile_names,
        //     'podfile_org_name' => $podfile_org_names,
        //     "status" => 2,
        //     "mode_of_delivery" => $mode_of_delivery,
        //     "name_of_courier" => $name_of_courier,
        //     "pod_no" => $pod_no,
        //     "dispatch_date" => $dispatch_date,
        // ];

        $columns = [

            "delivery_status" =>
                $delivery_status,

            "delivery_date" =>
                $delivery_date,

            "status" =>
                2,

            "mode_of_delivery" =>
                $mode_of_delivery,

            "name_of_courier" =>
                $name_of_courier,

            "pod_no" =>
                $pod_no,

            "dispatch_date" =>
                $dispatch_date
        ];


        /*
         * Add Transit fields only
         * when a new Transit file was uploaded
         */
        if ($file_names !== '') {

            $columns['delivery_proof'] =
                $file_names;

            $columns['file_name'] =
                $file_names;

            $columns['file_org_name'] =
                $file_org_names;
        }


        /*
         * Add POD fields only
         * when POD was uploaded
         */
        if ($podfile_names !== '') {

            $columns['pod_proof'] =
                $podfile_names;

            $columns['podfile_org_name'] =
                $podfile_org_names;
        }

        $table_stock_po = 'invoice_creation_main';

        $table_inv_verify = 'invoice_verfication_table';

        $columns1 = [
            "delivery_status" => 1,
        ];

        $update_where1 = 'form_main_unique_id ="' . $po_form_unique_id . '" and consignee_unique_id="' . $consignee_unique_id . '"  and dc_number="' . $dc_no . '"';

        $action_obj1 = $pdo->update($table_stock_po, $columns1, $update_where1);

        // $invoice_verify = $pdo->update($table_inv_verify,)

        try {

            $pdo->query("CALL update_dc_num_dispatch_sts()");

            $pdo->query("CALL update_inv_verfiy_update_dispatch_sts()");

        } catch (PDOException $e) {
            // echo json_encode(["status" => false, "error" => $e->getMessage()]);
        }



        // new changes

        // new changes


        $table_new = "invoice_creation_main_payment_data";
        // $columns_new = [

        //     "dispatch_delivery_status" => $delivery_status,
        //     "delivery_date" => $delivery_date,
        //     'delivery_proof' => $file_names,
        //     "mode_of_delivery" => $mode_of_delivery,
        //     "name_of_courier" => $name_of_courier,
        //     "pod_no" => $pod_no,
        //     // 'file_name' => $file_names,
        //     // 'file_org_name' => $file_org_names,
        //     'pod_proof' => $podfile_names,
        //     // 'podfile_org_name' => $podfile_org_names,
        //     "status" => 2,

        // ];

        $columns_new = [

            "dispatch_delivery_status" =>
                $delivery_status,

            "delivery_date" =>
                $delivery_date,

            "mode_of_delivery" =>
                $mode_of_delivery,

            "name_of_courier" =>
                $name_of_courier,

            "pod_no" =>
                $pod_no,

            "status" =>
                2
        ];


        if ($file_names !== '') {

            $columns_new[
                'delivery_proof'
            ] = $file_names;
        }


        if ($podfile_names !== '') {

            $columns_new[
                'pod_proof'
            ] = $podfile_names;
        }
        $update_where_new = 'form_main_unique_id="' . $po_form_unique_id . '" and consignee_unique_id="' . $consignee_unique_id . '" and dc_number="' . $dc_no . '"';
        $action_obj_new = $pdo->update($table_new, $columns_new, $update_where_new);

        if ($consignee_unique_id) {
            $update_where = 'po_form_unique_id ="' . $po_form_unique_id . '" and consignee_unique_id="' . $consignee_unique_id . '"  and dc_number="' . $dc_no . '"';
            $action_obj = $pdo->update($table_dispatch, $columns, $update_where);
        }
        if ($action_obj->status) {
            $status = $action_obj->status;
            $data = $action_obj->data;
            $error = '';
            $sql = $action_obj->sql;
            if ($consignee_unique_id) {
                $msg = 'update';
            } else {
                $msg = 'create';
            }
        } else {
            $status = $action_obj->status;
            $data = $action_obj->data;
            $error = $action_obj->error;
            $sql = $action_obj->sql;
            $msg = 'error';
        }
        $json_array = [
            'status' => $status,
            'data' => $data,
            'error' => $error,
            'msg' => $msg,
            'sql' => $sql
        ];
        echo json_encode($json_array);
        break;

    case 'deleivery_pod':
        $delivery_date = $_POST["delivery_date"];
        // $dc_no = $_POST["dc_no"];
        $dc_no = preg_replace('/\s+/', ' ', trim($_POST["dc_no"] ?? ''));
        $po_form_unique_id = $_POST["po_form_unique_id"];
        $consignee_unique_id = $_POST["consignee_unique_id"];
        $my_no = $_POST["my_no"];
        // $parts = explode('/', $my_no);
        // $parts = explode('/', $dc_no);
        // // Get the last value from the array
        // $po_num_value = end($parts);

        // $allowedExts = array('pdf', 'jpg', 'jpeg', 'png', 'xls', 'xlsx'); // Add more as needed
        // $allowedMimeTypes = array(
        //     'application/pdf' => 'pdf',
        //     'image/jpeg' => 'jpg',
        //     'image/png' => 'png',
        //     'application/vnd.ms-excel' => 'xls',
        //     'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'xlsx'
        // );
        // $podfile = $_FILES['podfile']['name'];
        // $podextension = pathinfo($_FILES['podfile']['name'], PATHINFO_EXTENSION);
        // $podtem_name = $po_num_value . "-POD." . $podextension;
        // $targetDir = '../../uploads/dispatch/';



        // if (move_uploaded_file($_FILES['podfile']['tmp_name'], '../../uploads/dispatch/' . $podtem_name)) {
        //     $podfile_names = $podtem_name;
        //     $podfile_org_names = $_FILES['podfile']['name'];
        // }
        $podfile_names = '';
        $podfile_org_names = '';


        /* =========================================================
           GET INVOICE DETAILS FROM CURRENT DISPATCH
           ========================================================= */

        $dispatchMetaResult =
            $pdo->select(
                [
                    'dispatch_list',
                    [
                        'invoice_no',
                        'invoice_date',
                        'po_date'
                    ]
                ],
                "po_form_unique_id = '"
                . $po_form_unique_id
                . "'
         AND consignee_unique_id = '"
                . $consignee_unique_id
                . "'
         AND dc_number = '"
                . $dc_no
                . "'
         AND is_delete = 0"
            );


        $meta_invoice_no = '';
        $meta_invoice_date = '';
        $meta_po_date = '';


        if (
            $dispatchMetaResult->status
            &&
            !empty(
            $dispatchMetaResult->data
        )
        ) {

            $meta_invoice_no =
                $dispatchMetaResult
                    ->data[0]['invoice_no']
                ?? '';


            $meta_invoice_date =
                $dispatchMetaResult
                    ->data[0]['invoice_date']
                ?? '';


            $meta_po_date =
                $dispatchMetaResult
                    ->data[0]['po_date']
                ?? '';
        }


        /* =========================================================
           POD UPLOAD
           ========================================================= */

        if (
            isset($_FILES['podfile'])
            &&
            isset($_FILES['podfile']['error'])
            &&
            $_FILES['podfile']['error'] === UPLOAD_ERR_OK
            &&
            !empty($_FILES['podfile']['name'])
        ) {

            try {

                $uploadInfo =
                    prepareAcademicUploadFolder(
                        'dispatch',
                        $meta_invoice_no,
                        $meta_invoice_date,
                        $meta_po_date,
                        $dc_no
                    );


                $targetDir =
                    $uploadInfo[
                        'directory'
                    ];


                $safe_dc_no =
                    getSafeDispatchNumber(
                        $dc_no
                    );


                $podextension =
                    strtolower(
                        pathinfo(
                            $_FILES['podfile']['name'],
                            PATHINFO_EXTENSION
                        )
                    );


                $allowedExts = [
                    'pdf',
                    'jpg',
                    'jpeg',
                    'png',
                    'xls',
                    'xlsx'
                ];


                if (
                    !in_array(
                        $podextension,
                        $allowedExts,
                        true
                    )
                ) {

                    throw new Exception(
                        'Invalid POD file type.'
                    );
                }


                $podtem_name =
                    $safe_dc_no
                    . '-POD.'
                    . $podextension;


                $destination =
                    $targetDir
                    . $podtem_name;


                if (
                    !move_uploaded_file(
                        $_FILES['podfile']['tmp_name'],
                        $destination
                    )
                ) {

                    throw new Exception(
                        'POD file upload failed.'
                    );
                }


                $podfile_names =
                    $podtem_name;


                $podfile_org_names =
                    $_FILES['podfile']['name'];


            } catch (Throwable $e) {

                echo json_encode([
                    'status' => false,
                    'msg' => 'error',
                    'error' =>
                        $e->getMessage()
                ]);

                exit;
            }
        }
        $update_where = "";
        $columns = [
            "delivery_date" => $delivery_date
        ];

        // Only add pod fields if file was uploaded
        if (!empty($podfile_names) && !empty($podfile_org_names)) {
            $columns['pod_proof'] = $podfile_names;
            $columns['podfile_org_name'] = $podfile_org_names;
        }


        // Update Begins
        if ($consignee_unique_id) {
            $update_where = 'po_form_unique_id ="' . $po_form_unique_id . '" and consignee_unique_id="' . $consignee_unique_id . '"  and dc_number="' . $dc_no . '"';
            $action_obj = $pdo->update($table_dispatch, $columns, $update_where);
        }
        if ($action_obj->status) {
            $status = $action_obj->status;
            $data = $action_obj->data;
            $error = '';
            $sql = $action_obj->sql;
            if ($consignee_unique_id) {
                $msg = 'update';
            } else {
                $msg = 'create';
            }
        } else {
            $status = $action_obj->status;
            $data = $action_obj->data;
            $error = $action_obj->error;
            $sql = $action_obj->sql;
            $msg = 'error';
        }
        $json_array = [
            'status' => $status,
            'data' => $data,
            'error' => $error,
            'msg' => $msg,
            'sql' => $sql
        ];
        echo json_encode($json_array);
        break;

    case 'user_permission':
        $screen_id_val = $_POST['screen_id_val'];
        $user_type_unique_id = $_POST['user_type_unique_id'];
        // print_r( $user_type_unique_id);die();

        $table_user = "user_screen_permission";
        $columns = [
            // "screen_unique_id",
            "action_unique_id",
            "user_type"
        ];
        $select_where = "screen_unique_id='" . $screen_id_val . "' AND user_type='" . $user_type_unique_id . "'";
        // print_r($select_where);die();
        $table_details = [
            $table_user,
            $columns
        ];

        $table_users = $pdo->select($table_details, $select_where);

        if ($table_users->status) {

            $table_users = $table_users->data;
            // print_r($table_users);die();
            $action_unique_ids = [];

            foreach ($table_users as $item) {
                if (isset($item['action_unique_id'])) {
                    $action_unique_ids[] = $item['action_unique_id'];
                }
            }

            // Now $action_unique_ids contains all the action_unique_id values
            // print_r($action_unique_ids);die();



            // $data = array($table_users);
        }
        $json_array = [
            "draw" => intval($draw),
            "recordsTotal" => intval($total_records),
            "recordsFiltered" => intval($total_records),
            "data" => $action_unique_ids,
            "testing" => $result->sql
        ];

        echo json_encode($json_array);

        break;
    case 'user_permission_2':
        $screen_id_val = $_POST['screen_id_val'];
        $user_type_unique_id = $_POST['user_type_unique_id'];
        // print_r( $user_type_unique_id);die();

        $table_user = "user_screen_permission";
        $columns = [
            // "screen_unique_id",
            "action_unique_id",
            "user_type"
        ];
        $select_where = "screen_unique_id='" . $screen_id_val . "' AND user_type='" . $user_type_unique_id . "'";
        // print_r($select_where);die();
        $table_details = [
            $table_user,
            $columns
        ];

        $table_users = $pdo->select($table_details, $select_where);

        if ($table_users->status) {

            $table_users = $table_users->data;
            // print_r($table_users);die();
            $action_unique_ids = [];

            foreach ($table_users as $item) {
                if (isset($item['action_unique_id'])) {
                    $action_unique_ids[] = $item['action_unique_id'];
                }
            }

            // Now $action_unique_ids contains all the action_unique_id values
            // print_r($action_unique_ids);die();



            // $data = array($table_users);
        }
        $json_array = [
            "draw" => intval($draw),
            "recordsTotal" => intval($total_records),
            "recordsFiltered" => intval($total_records),
            "data" => $action_unique_ids,
            "testing" => $result->sql
        ];

        echo json_encode($json_array);

        break;

    case 'user_permission_1':
        $screen_id_val = $_POST['screen_id_val'];
        $user_type_unique_id = $_POST['user_type_unique_id'];
        // print_r( $user_type_unique_id);die();

        $table_user = "user_screen_permission";
        $columns = [
            // "screen_unique_id",
            "action_unique_id",
            "user_type"
        ];
        $select_where = "screen_unique_id='" . $screen_id_val . "' AND user_type='" . $user_type_unique_id . "'";
        // print_r($select_where);die();
        $table_details = [
            $table_user,
            $columns
        ];

        $table_users = $pdo->select($table_details, $select_where);

        if ($table_users->status) {

            $table_users = $table_users->data;
            // print_r($table_users);die();
            $action_unique_ids = [];

            foreach ($table_users as $item) {
                if (isset($item['action_unique_id'])) {
                    $action_unique_ids[] = $item['action_unique_id'];
                }
            }

            // Now $action_unique_ids contains all the action_unique_id values
            // print_r($action_unique_ids);die();



            // $data = array($table_users);
        }
        $json_array = [
            "draw" => intval($draw),
            "recordsTotal" => intval($total_records),
            "recordsFiltered" => intval($total_records),
            "data" => $action_unique_ids,
            "testing" => $result->sql
        ];

        echo json_encode($json_array);

        break;

    case 'delete':
        $unique_id = $_POST['unique_id'];
        $columns = [
            "is_delete" => 1
        ];
        $update_where = [
            "unique_id" => $unique_id
        ];
        $action_obj = $pdo->update($table, $columns, $update_where);


        //    $table_new = "invoice_creation_main_payment_data";



        if ($action_obj->status) {
            $status = $action_obj->status;
            $data = $action_obj->data;
            $error = "";
            $sql = $action_obj->sql;
            $msg = "success_delete";
        } else {
            $status = $action_obj->status;
            $data = $action_obj->data;
            $error = $action_obj->error;
            $sql = $action_obj->sql;
            $msg = "error";
        }
        $json_array = [
            "status" => $status,
            "data" => $data,
            "error" => $error,
            "msg" => $msg,
            "sql" => $sql
        ];
        echo json_encode($json_array);
        break;
    default:
        break;
}







/* =========================================================
   GET ACADEMIC YEAR FROM INVOICE NUMBER

   CHN/26-27/3312
   =>
   2026-2027
   ========================================================= */

function getAcademicYearFromInvoiceNo($invoice_no)
{
    $invoice_no = trim((string) $invoice_no);

    if ($invoice_no === '') {
        return '';
    }


    /*
     * Full format:
     *
     * CHN/2026-2027/3312
     */
    if (
        preg_match(
            '~(?:^|/)(20\d{2})-(20\d{2})(?:/|$)~',
            $invoice_no,
            $matches
        )
    ) {

        return
            $matches[1]
            . '-'
            . $matches[2];
    }


    /*
     * Short format:
     *
     * CHN/26-27/3312
     */
    if (
        preg_match(
            '~(?:^|/)(\d{2})-(\d{2})(?:/|$)~',
            $invoice_no,
            $matches
        )
    ) {

        $startShort =
            (int) $matches[1];

        $endShort =
            (int) $matches[2];


        $startYear =
            2000 + $startShort;

        $endYear =
            2000 + $endShort;


        /*
         * Handles:
         * 99-00 etc.
         */
        if ($endYear < $startYear) {

            $endYear =
                $startYear + 1;
        }


        return
            $startYear
            . '-'
            . $endYear;
    }


    return '';
}


/* =========================================================
   DATE FALLBACK

   If some old invoice number does not contain year,
   calculate financial year using date.

   April - March
   ========================================================= */

function getFinancialYearFromDate($date_value)
{
    $date_value =
        trim((string) $date_value);


    if ($date_value === '') {
        return '';
    }


    $timestamp =
        strtotime($date_value);


    if (!$timestamp) {
        return '';
    }


    $year =
        (int) date(
            'Y',
            $timestamp
        );


    $month =
        (int) date(
            'n',
            $timestamp
        );


    if ($month >= 4) {

        $startYear =
            $year;

        $endYear =
            $year + 1;

    } else {

        $startYear =
            $year - 1;

        $endYear =
            $year;
    }


    return
        $startYear
        . '-'
        . $endYear;
}


/* =========================================================
   DISPATCH ACADEMIC YEAR

   Priority:
   1. Invoice Number
   2. Invoice Date
   3. PO Date
   4. DC Number (e.g. CHNDC/25-26/795 => 2025-2026)
   5. Active Session Academic Year
   6. Global System acc_year()
   7. Current Calendar Financial Year
   ========================================================= */

function getDispatchAcademicYear(
    $invoice_no = '',
    $invoice_date = '',
    $po_date = '',
    $dc_no = ''
) {

    /*
     * Priority 1: Invoice Number
     */
    $academic_year =
        getAcademicYearFromInvoiceNo(
            $invoice_no
        );

    if ($academic_year !== '') {
        return $academic_year;
    }

    /*
     * Priority 2: Invoice Date
     */
    $academic_year =
        getFinancialYearFromDate(
            $invoice_date
        );

    if ($academic_year !== '') {
        return $academic_year;
    }

    /*
     * Priority 3: PO Date
     */
    $academic_year =
        getFinancialYearFromDate(
            $po_date
        );

    if ($academic_year !== '') {
        return $academic_year;
    }

    /*
     * Priority 4: Fallback to DC Number (e.g. CHNDC/25-26/795)
     */
    if (!empty($dc_no)) {
        $academic_year =
            getAcademicYearFromInvoiceNo(
                $dc_no
            );

        if ($academic_year !== '') {
            return $academic_year;
        }
    }

    /*
     * Priority 5: Fallback to Session Academic Year
     */
    if (!empty($_SESSION['acc_year'])) {
        return $_SESSION['acc_year'];
    }

    /*
     * Priority 6: Fallback to System acc_year() function
     */
    if (function_exists('acc_year')) {
        $academic_year = acc_year();
        if ($academic_year !== '') {
            return $academic_year;
        }
    }

    /*
     * Priority 7: Fallback based on Current Date (April - March)
     */
    $curr_year = (int) date('Y');
    $curr_month = (int) date('n');
    $startYear = ($curr_month >= 4) ? $curr_year : ($curr_year - 1);
    return $startYear . '-' . ($startYear + 1);
}


/* =========================================================
   SAFE DC NUMBER FOR FILE NAME

   CHN/DC/2525

   becomes

   CHN-DC-2525
   ========================================================= */

function getSafeDispatchNumber($dc_no)
{
    $safe =
        preg_replace(
            '/[^A-Za-z0-9_-]+/',
            '-',
            trim((string) $dc_no)
        );


    return
        trim(
            $safe,
            '-'
        );
}


/* =========================================================
   CREATE ACADEMIC YEAR DIRECTORY

   Example:

   uploads/dispatch/2026-2027/
   ========================================================= */

function prepareAcademicUploadFolder(
    $folder_name,
    $invoice_no = '',
    $invoice_date = '',
    $po_date = '',
    $dc_no = ''
) {

    $academic_year =
        getDispatchAcademicYear(
            $invoice_no,
            $invoice_date,
            $po_date,
            $dc_no
        );


    if ($academic_year === '') {

        throw new Exception(
            'Unable to identify Academic Year from Invoice Number: '
            . $invoice_no
        );
    }


    /*
     * Current CRUD relative location:
     *
     * ../../uploads/
     */
    $base_directory =
        __DIR__
        . '/../../uploads/'
        . trim(
            $folder_name,
            '/'
        )
        . '/';


    /*
     * Create base folder if required
     */
    if (!is_dir($base_directory)) {

        if (
            !mkdir(
                $base_directory,
                0775,
                true
            )
            &&
            !is_dir($base_directory)
        ) {

            throw new Exception(
                'Unable to create base upload folder: '
                . $base_directory
            );
        }
    }


    /*
     * Academic year folder
     */
    $year_directory =
        $base_directory
        . $academic_year
        . DIRECTORY_SEPARATOR;


    /*
     * Automatically create if not exists
     */
    if (!is_dir($year_directory)) {

        if (
            !mkdir(
                $year_directory,
                0775,
                true
            )
            &&
            !is_dir($year_directory)
        ) {

            throw new Exception(
                'Unable to create academic year folder: '
                . $year_directory
            );
        }
    }


    return [
        'academic_year' =>
            $academic_year,

        'directory' =>
            $year_directory
    ];
}


/* =========================================================
   RESOLVE OLD + NEW FILES

   Supports:

   OLD:
   uploads/dispatch/2525-Dispatch.pdf

   MANUALLY RESTORED:
   uploads/dispatch/2025-2026/2525-Dispatch.pdf

   NEW:
   uploads/dispatch/2026-2027/CHN-DC-2525-Dispatch.pdf
   ========================================================= */

function resolveAcademicFilePath(
    $folder_name,
    $file_name,
    $invoice_no = '',
    $invoice_date = '',
    $po_date = '',
    $dc_no = ''
) {

    $file_name =
        trim((string) $file_name);


    if ($file_name === '') {

        return '';
    }


    /*
     * Normalize Windows/Linux slash
     */
    $normalized_file =
        str_replace(
            '\\',
            '/',
            $file_name
        );


    /*
     * If DB already contains:
     *
     * 2026-2027/file.pdf
     *
     * use as it is.
     */
    if (
        strpos(
            $normalized_file,
            '/'
        ) !== false
    ) {

        return
            ltrim(
                $normalized_file,
                '/'
            );
    }


    $academic_year =
        getDispatchAcademicYear(
            $invoice_no,
            $invoice_date,
            $po_date,
            $dc_no
        );


    $base_directory =
        __DIR__
        . '/../../uploads/'
        . trim(
            $folder_name,
            '/'
        )
        . '/';


    /*
     * First check academic year folder
     */
    if ($academic_year !== '') {

        $year_file =
            $base_directory
            . $academic_year
            . DIRECTORY_SEPARATOR
            . $file_name;


        if (is_file($year_file)) {

            return
                $academic_year
                . '/'
                . $file_name;
        }
    }


    /*
     * Old flat folder fallback
     *
     * uploads/dispatch/file.pdf
     */
    $old_file =
        $base_directory
        . $file_name;


    if (is_file($old_file)) {

        return
            $file_name;
    }


    /*
     * Default expected location
     */
    if ($academic_year !== '') {

        return
            $academic_year
            . '/'
            . $file_name;
    }


    return
        $file_name;
}





// function image_view($folder_name = "", $unique_id = "", $delivery_proof = "")
// {
//     // alert('hi');
//     // echo $dc_file_name;
//     $file_names = explode(',', $delivery_proof);
//     $image_view = '';
//     if ($delivery_proof) {
//         foreach ($file_names as $file_key => $delivery_proof) {
//             if ($file_key != 0) {
//                 if ($file_key % 4 != 0) {
//                     $image_view .= "&nbsp";
//                 } else {
//                     $image_view .= "<br><br>";
//                 }
//             }
//             $cfile_name = explode('.', $delivery_proof);
//             if ($delivery_proof) {
//                 $image_view = '<div class="text-center">';
//                 if (($cfile_name[1] == 'jpg') || ($cfile_name[1] == 'png') || ($cfile_name[1] == 'jpeg')) {
//                     $image_view .= '<a href="javascript:print_view(\'/' . $delivery_proof . '\')"><img src="uploads/' . $folder_name . '/' . $delivery_proof . '"  height="20px" width="20px" ></a>';
//                     // $image_view .= '<img src="uploads/'.$folder_name.'/'.$doc_name.'"  height="50px" width="50px" >';
//                 } else if ($cfile_name[1] == 'pdf') {
//                     $image_view .= '<a href="javascript:print(\'/' . $delivery_proof . '\')"><img src="uploads/invoice/pdf.png"  height="20px" width="20px" ></a>';
//                 } else if (($cfile_name[1] == 'pdf') || ($cfile_name[1] == 'xls') || ($cfile_name[1] == 'xlsx')) {
//                     $image_view .= '<a href="javascript:print(\'/' . $delivery_proof . '\')"><img src="uploads/invoice/excel.png"  height="20px" width="20px" ></a>';
//                 } else if (($cfile_name[1] == 'txt') || ($cfile_name[1] == 'docx') || ($cfile_name[1] == 'doc')) {
//                     $image_view .= '<a href="javascript:print(\'/' . $delivery_proof . '\')"><img src="uploads/invoice/word.png"  height="20px" width="20px" ></a>';
//                 }
//                 $image_view .= '</div>'; // End centered
//             }
//         }
//     }
//     return $image_view;
// }


// function image_view1($folder_name = "", $unique_id = "", $delivery_proof = "")
// {
//     // alert('hi');
//     // echo $dc_file_name;
//     $file_names = explode(',', $delivery_proof);
//     $image_view = '';
//     if ($delivery_proof) {
//         foreach ($file_names as $file_key => $delivery_proof) {
//             if ($file_key != 0) {
//                 if ($file_key % 4 != 0) {
//                     $image_view .= "&nbsp";
//                 } else {
//                     $image_view .= "<br><br>";
//                 }
//             }
//             $cfile_name = explode('.', $delivery_proof);
//             if ($delivery_proof) {

//                 if (($cfile_name[1] == 'jpg') || ($cfile_name[1] == 'png') || ($cfile_name[1] == 'jpeg')) {
//                     $image_view .= '<a href="javascript:print_view1(\'/' . $delivery_proof . '\')"><img src="uploads/invoice/' . $delivery_proof . '"  height="20px" width="20px" ></a>';
//                     // $image_view .= '<img src="uploads/'.$folder_name.'/'.$doc_name.'"  height="20px" width="20px" >';
//                 } else if ($cfile_name[1] == 'pdf') {
//                     $image_view .= '<a href="javascript:print1(\'/' . $delivery_proof . '\')"><img src="uploads/invoice/pdf.png"  height="20px" width="20px" ></a>';
//                 } else if (($cfile_name[1] == 'pdf') || ($cfile_name[1] == 'xls') || ($cfile_name[1] == 'xlsx')) {
//                     $image_view .= '<a href="javascript:print1(\'/' . $delivery_proof . '\')"><img src="uploads/invoice/excel.png"  height="20px" width="20px" ></a>';
//                 } else if (($cfile_name[1] == 'txt') || ($cfile_name[1] == 'docx') || ($cfile_name[1] == 'doc')) {
//                     $image_view .= '<a href="javascript:print1(\'/' . $delivery_proof . '\')"><img src="uploads/invoice/word.png"  height="20px" width="20px" ></a>';
//                 }
//             }
//         }
//     }
//     return $image_view;
// }


function image_view(
    $folder_name = "",
    $unique_id = "",
    $delivery_proof = "",
    $invoice_no = "",
    $invoice_date = "",
    $po_date = ""
) {

    if (empty($delivery_proof)) {
        return '';
    }


    $file_names =
        explode(
            ',',
            $delivery_proof
        );


    $image_view = '';


    foreach (
        $file_names
        as $file_key => $file_name
    ) {

        $file_name =
            trim($file_name);


        if ($file_name === '') {
            continue;
        }


        /*
         * IMPORTANT
         *
         * Handles BOTH:
         *
         * OLD:
         * uploads/dispatch/file.pdf
         *
         * NEW:
         * uploads/dispatch/2026-2027/file.pdf
         */

        $relative_file =
            resolveAcademicFilePath(
                $folder_name,
                $file_name,
                $invoice_no,
                $invoice_date,
                $po_date
            );


        $extension =
            strtolower(
                pathinfo(
                    $relative_file,
                    PATHINFO_EXTENSION
                )
            );


        if ($file_key != 0) {

            if ($file_key % 4 != 0) {

                $image_view .=
                    '&nbsp;';

            } else {

                $image_view .=
                    '<br><br>';
            }
        }


        $image_view .=
            '<div class="text-center">';


        /* IMAGE */

        if (
            in_array(
                $extension,
                [
                    'jpg',
                    'jpeg',
                    'png'
                ],
                true
            )
        ) {

            $image_view .=
                '<a href="javascript:print_view(\''
                . $relative_file
                . '\')">

                    <img
                        src="uploads/'
                . $folder_name
                . '/'
                . $relative_file
                . '"
                        height="20px"
                        width="20px"
                    >

                </a>';


            /* PDF */

        } elseif (
            $extension === 'pdf'
        ) {

            $image_view .=
                '<a href="javascript:print(\''
                . $relative_file
                . '\')">

                    <img
                        src="uploads/invoice/pdf.png"
                        height="20px"
                        width="20px"
                    >

                </a>';


            /* EXCEL */

        } elseif (
            in_array(
                $extension,
                [
                    'xls',
                    'xlsx'
                ],
                true
            )
        ) {

            $image_view .=
                '<a href="javascript:print(\''
                . $relative_file
                . '\')">

                    <img
                        src="uploads/invoice/excel.png"
                        height="20px"
                        width="20px"
                    >

                </a>';


            /* WORD */

        } elseif (
            in_array(
                $extension,
                [
                    'txt',
                    'doc',
                    'docx'
                ],
                true
            )
        ) {

            $image_view .=
                '<a href="javascript:print(\''
                . $relative_file
                . '\')">

                    <img
                        src="uploads/invoice/word.png"
                        height="20px"
                        width="20px"
                    >

                </a>';
        }


        $image_view .=
            '</div>';
    }


    return $image_view;
}
function image_view1(
    $folder_name = "",
    $unique_id = "",
    $delivery_proof = "",
    $invoice_no = "",
    $invoice_date = "",
    $po_date = ""
) {

    if (empty($delivery_proof)) {
        return '';
    }


    $relative_file =
        resolveAcademicFilePath(
            'invoice',
            $delivery_proof,
            $invoice_no,
            $invoice_date,
            $po_date
        );


    $extension =
        strtolower(
            pathinfo(
                $relative_file,
                PATHINFO_EXTENSION
            )
        );


    if (
        in_array(
            $extension,
            [
                'jpg',
                'jpeg',
                'png'
            ],
            true
        )
    ) {

        return
            '<a href="javascript:print_view1(\''
            . $relative_file
            . '\')">

                <img
                    src="uploads/invoice/'
            . $relative_file
            . '"
                    height="20px"
                    width="20px"
                >

            </a>';
    }


    if ($extension === 'pdf') {

        return
            '<a href="javascript:print1(\''
            . $relative_file
            . '\')">

                <img
                    src="uploads/invoice/pdf.png"
                    height="20px"
                    width="20px"
                >

            </a>';
    }


    if (
        in_array(
            $extension,
            [
                'xls',
                'xlsx'
            ],
            true
        )
    ) {

        return
            '<a href="javascript:print1(\''
            . $relative_file
            . '\')">

                <img
                    src="uploads/invoice/excel.png"
                    height="20px"
                    width="20px"
                >

            </a>';
    }


    if (
        in_array(
            $extension,
            [
                'txt',
                'doc',
                'docx'
            ],
            true
        )
    ) {

        return
            '<a href="javascript:print1(\''
            . $relative_file
            . '\')">

                <img
                    src="uploads/invoice/word.png"
                    height="20px"
                    width="20px"
                >

            </a>';
    }


    return '';
}

