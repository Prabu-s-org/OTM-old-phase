<?php
require_once __DIR__ . '/../../config/env.php';
// Get folder Name From Current URL
$folder_name = explode("/", $_SERVER['PHP_SELF']);
$folder_name = $folder_name[count($folder_name) - 2];

// Include common functions
include 'function.php';

// PDO connection
try {
    $pdo = new PDO("mysql:host=localhost;dbname=operation_team_beta;charset=utf8", project_env('APP_DB_USERNAME', 'root'), project_env('APP_DB_PASSWORD'));
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "connected succesfully";
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Total Purchase Order</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="../../assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="../../assets/datatable_new/jquery.dataTables.css" />
    <link rel="stylesheet" type="text/css" href="../../assets/datatable_new/buttons.dataTables.css" />
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: white;
        }
        .text_po {
            color: #506018;
            text-align: center;
            font-size: x-large;
            padding-top: 7px;
            font-weight: 700;
        }
        table {
            font-family: 'Poppins', sans-serif;
            border-collapse: collapse;
            width: 100%;
        }
        .table>thead {
            background: #eeece0;
            color: #506018;
        }
        th, td {
            font-size: 13px;
            padding: 8px;
            text-align: left;
            border: 1px solid #ddd;
            vertical-align: top;
        }
        th {
            background-color: #eeece0 !important;
            color: #506018 !important;
        }
        table tbody tr:nth-child(even) {
            background-color: #fbfbfb;
        }
        .table td {
            word-wrap: break-word;
        }
        .nested-table {
            width: 100%;
            border-collapse: collapse;
        }
        .nested-table th, .nested-table td {
            border: 1px solid #ddd;
            padding: 4px 6px;
            font-size: 12px;
        }
        #imgd{
            margin-top: 22px;
    width: 63px;
    height: 10%;
        }
    </style>
</head>
<body class="mt-4">
    <div>
        <h2 class="text_po">Total Purchase Order</h2>
    </div>
    <form class="was-validated" autocomplete="off">
        <div class="container">
            <div class="row">
                <div class="col-12 mt-2">
                    <div class="table-responsive mb-4">
                        <table class="table table-striped table-bordered align-middle table-nowrap mb-0" id="ins_pen">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>PO Date</th>
                                    <th>PO Number</th>
                                    <th>Customer</th>
                                    <th>PO Attach</th>
                                    <th style="text-align: center;">AMC Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
$acc_year = $_GET['acc_year'] ?? '';

                                // Get distinct PO numbers
                                $query = "SELECT po_num, MAX(DATE_FORMAT(po_date, '%d-%m-%Y')) AS po_date, 
                                                 department, gst_value, bill_address, unique_id,file_name
                                          FROM view_po_form_list
                                          WHERE is_delete = 0 AND file_name != '' AND amc_required = 'on'";

                                if (!empty($acc_year)) {
                                    $query .= " AND acc_year = :acc_year";
                                }

                                $query .= " GROUP BY po_num ORDER BY unique_id DESC";

                                $stmt = $pdo->prepare($query);

                                if (!empty($acc_year)) {
                                    $stmt->bindParam(':acc_year', $acc_year);
                                }

                                $stmt->execute();
                                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                $sno = 1;

                                if ($rows) {
                                    foreach ($rows as $value) {
                                         $po_num = $value['po_num'] ?? '-';
                                        $po_date = $value['po_date'] ?? '-';
                                        $department = $value['department'] ?? '-';
                                        $gst_value = $value['gst_value'] ?? '';
                                        $bill_address = $value['bill_address'] ?? '';
                                        $po_unique_id = $value['unique_id'];

                                        // Fetch AMC details for this PO
                                        $amcStmt = $pdo->prepare("
    SELECT start_date, end_date, amc_percentae, amcvalue, amcfile_names
    FROM amcrequired
    WHERE is_delete = 0 AND po_unique_id = ?
");
                                        $amcStmt->execute([$po_unique_id]);
                                        $amcRows = $amcStmt->fetchAll(PDO::FETCH_ASSOC);

                                        ?>
                                        <tr>
                                            <td><?php
echo $sno++; ?></td>
                                            <td><?php
echo htmlspecialchars($po_date); ?></td>
                                            <td><?php
echo htmlspecialchars($po_num); ?></td>
                                            <td>
                                                <b><?php
echo htmlspecialchars($department); ?></b><br>
                                                <small><?php
echo htmlspecialchars($bill_address); ?></small>
                                                <?php
if (!empty($gst_value)): ?>
                                                    <br><small>(<?php
echo htmlspecialchars($gst_value); ?>)</small>
                                                <?php
endif; ?>
                                            </td>
                                        <td style='text-align:center;'><?php
if (!empty($value['file_name'])) {
        echo "<a href='../../uploads/po_form/po_attach/" . htmlspecialchars($value['file_name']) . "' target='_blank'><img src='../../uploads/po_form/po_attach/pdf.png' height='30px' width='30px' id='imgd'></a>";
    } else {
        echo "-";
    }
    ;?></td>
                                            <td style="text-align: center;">
                                                <table class="nested-table">
                                                    <thead>
                                                        <tr style="background-color: #f2f2f2;">
                                                            <th>Start Date</th>
                                                            <th>End Date</th>
                                                            <th style="text-align:right;">Percent</th>
                                                            <th style="text-align:right;">Value</th>
                                                            <th style="text-align:center;">AMC File</th>
                                                            <!-- <th style="text-align:center;">PO File</th> -->
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
if ($amcRows) {

                                                            $total_amc_value = 0; // Initialize total
                                                            // $total_value = $amc['amcvalue'] ?? 0;
                                      
                                                            

foreach ($amcRows as $amc) {
    echo "<tr>";
    echo "<td>" . date('d-m-Y', strtotime($amc['start_date'])) . "</td>";
    echo "<td>" . date('d-m-Y', strtotime($amc['end_date'])) . "</td>";
    echo "<td style='text-align:right;'>" . htmlspecialchars($amc['amc_percentae']) . "%</td>";
    echo "<td style='text-align:right;'>" . moneyFormatIndia1($amc['amcvalue']) . "</td>";
    echo "<td style='text-align:center;'>";
    if (!empty($amc['amcfile_names'])) {
        echo "<a href='../../uploads/amc/" . htmlspecialchars($amc['amcfile_names']) . "' target='_blank'><img src='../../uploads/po_form/po_attach/pdf.png' height='30px' width='30px'></a>";
    } else {
        echo "-";
    }
    echo "</td>";
   
    echo "</tr>";

    // Add the AMC value to total
    $total_amc_value += $amc['amcvalue'];
    $total += $amc['amcvalue'];
}

// Display the total after the loop
echo "<tr>";
echo "<td colspan='3' style='text-align:right; font-weight:bold;'>Total AMC Value</td>";
echo "<td style='text-align:right; font-weight:bold;'>" . moneyFormatIndia1($total_amc_value) . "</td>";
echo "<td colspan='2'></td>";
echo "</tr>";

                                                        } else {
                                                            echo "<tr><td colspan='6' style='text-align: center;'>No AMC details</td></tr>";
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        <?php
}
                                } else {
                                    echo '<tr><td colspan="5" class="text-center text-muted">No records found</td></tr>';
                                }
                                ?>
                            </tbody>
                            
                            <tr style="border-top: 2px solid #506018;background-color: #506018;font-size: 20px;">
                                        <td colspan="5" style="text-align: right; color:white; font-size: 20px;">
                                            <strong>Total</strong></td>
                                        <td style="text-align: right; color:white; font-size: 20px;">
                                            <strong><?php
echo moneyFormatIndia1($total); ?></strong></td>
                                    </tr>
                        </table>
                    </div>
                </div>
            </div>
    </form>
    </div>

    <script src="../../assets/datatable_new/jquery-3.7.0.min.js"></script>
    <script src="../../assets/datatable_new/jszip.min.js"></script>
    <script src="../../assets/datatable_new/buttons.html5.min.js"></script>
    <script src="../../assets/datatable_new/buttons.print.min.js"></script>
    <script src="../../assets/datatable_new/pdfmake.min.js"></script>
    <script>
        new DataTable('#ins_pen', {
            layout: {
                top1: 'searchBuilder'
            }
        });
    </script>
</body>
</html>
<?php
function moneyFormatIndia1($num, $withSymbol = false, $withDecimals = true) {
    // Convert to float first
    $num = (float)$num;

    // Handle negative numbers
    $sign = ($num < 0) ? '-' : '';
    $num  = abs($num);

    // Ensure always 2 decimals or none
    $num = $withDecimals ? sprintf("%.2f", $num) : sprintf("%.0f", $num);

    // Split into integer and decimal parts
    $parts = explode('.', $num);
    $int   = $parts[0];
    $dec   = $parts[1] ?? '';

    // Apply Indian number system formatting
    if (strlen($int) > 3) {
        $last3 = substr($int, -3);
        $rest  = substr($int, 0, -3);
        $rest  = preg_replace('/\B(?=(\d{2})+(?!\d))/', ',', $rest);
        $int   = $rest . ',' . $last3;
    }

    // Build final string
    $formatted = $sign . $int;
    if ($withDecimals && $dec !== '') {
        $formatted .= '.' . $dec;
    }

    // Add rupee symbol if requested
    if ($withSymbol) {
        $formatted = '₹ ' . $formatted;
    }

    return $formatted;
}

?>


