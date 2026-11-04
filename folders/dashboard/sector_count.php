<?php
require_once __DIR__ . '/../../config/env.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json; charset=utf-8');

// DB connection setup
$driver   = 'mysql';
$host     = 'localhost';
$username = project_env('APP_DB_USERNAME', 'root');
$password = project_env('APP_DB_PASSWORD');
$dbname   = 'operation_team_beta';

try {
    $conn = new PDO(
        "$driver:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES   => false,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Connection failed: ' . $e->getMessage()]);
    exit;
}

$acc_year      = $_POST['acc_year'] ?? '';
$acc_verticals = $_POST['acc_verticals'] ?? 'All';

/**
 * Build SQL based on dropdown
 */
if ($acc_verticals === 'All') {
    // ✅ Show both verticals
    $sql = "
    SELECT
    s.unique_id as unique_id,
      IFNULL(s.sector_name, 'Total (All Sectors)') AS sector_name,
      COUNT(pf.acc_sector) AS po_count,
      COALESCE(SUM(pf.total_amount), 0) AS invoice_value,
      COALESCE(SUM(pf.total_qty), 0) AS po_qty,

      -- End Computing vertical
      SUM(CASE WHEN pf.acc_vertical = '6806199e57fc644558' THEN 1 ELSE 0 END) AS end_comp_count,
      SUM(CASE WHEN pf.acc_vertical = '6806199e57fc644558' THEN pf.total_amount ELSE 0 END) AS end_comp_value,

      -- Cyber Security vertical
      SUM(CASE WHEN pf.acc_vertical = '680619aae08f045496' THEN 1 ELSE 0 END) AS cyber_sec_count,
      SUM(CASE WHEN pf.acc_vertical = '680619aae08f045496' THEN pf.total_amount ELSE 0 END) AS cyber_sec_value

    FROM account_sector s
    LEFT JOIN po_form pf
      ON pf.acc_sector = s.unique_id
      AND pf.is_delete = 0
    ";
} else {
    // ✅ Show only the chosen vertical
    $sql = "
    SELECT
    s.unique_id as unique_id,
      IFNULL(s.sector_name, 'Total (All Sectors)') AS sector_name,
      COUNT(pf.acc_sector) AS po_count,
      COALESCE(SUM(pf.total_amount), 0) AS invoice_value,
      COALESCE(SUM(pf.total_qty), 0) AS po_qty
    FROM account_sector s
    LEFT JOIN po_form pf
      ON pf.acc_sector = s.unique_id
      AND pf.is_delete = 0
    ";
}

// Filters
if (!empty($acc_year)) {
    $sql .= " AND pf.acc_year = :acc_year";
}
if ($acc_verticals !== 'All' && !empty($acc_verticals)) {
    $sql .= " AND pf.acc_vertical = :verticals";
}

$sql .= "
WHERE s.is_delete = 0
GROUP BY s.sector_name WITH ROLLUP
";

try {
    $stmt = $conn->prepare($sql);

    if (!empty($acc_year)) {
        $stmt->bindValue(':acc_year', $acc_year, PDO::PARAM_STR);
    }
    if ($acc_verticals !== 'All' && !empty($acc_verticals)) {
        $stmt->bindValue(':verticals', $acc_verticals, PDO::PARAM_STR);
    }

    $stmt->execute();
    $rows = $stmt->fetchAll();

    $output = [
        'data' => [],
        'horizontal_totals' => [
            'po_count'      => 0,
            'invoice_value' => 0,
            'po_qty'        => 0
        ]
    ];

    foreach ($rows as $row) {
        $rowData = [
            'unique_id'   => $row['unique_id'],
            'sector_name'   => $row['sector_name'],
            'po_count'      => (int)$row['po_count'],
            'invoice_value' => number_format($row['invoice_value']),
            'po_qty'        => (int)$row['po_qty']
        ];

        // Include vertical breakdown only if "All" selected
        if ($acc_verticals === 'All') {
            $rowData['end_comp_count']  = (int)$row['end_comp_count'];
            $rowData['end_comp_value']  = number_format($row['end_comp_value']);
            $rowData['cyber_sec_count'] = (int)$row['cyber_sec_count'];
            $rowData['cyber_sec_value'] = number_format($row['cyber_sec_value']);
        }

        $output['data'][] = $rowData;

        // Accumulate totals except rollup row
        if ($row['sector_name'] !== 'Total (All Sectors)') {
            $output['horizontal_totals']['po_count']      += $row['po_count'];
            $output['horizontal_totals']['invoice_value'] += $row['invoice_value'];
            $output['horizontal_totals']['po_qty']        += $row['po_qty'];

            if ($acc_verticals === 'All') {
                $output['horizontal_totals']['end_comp_count']  = ($output['horizontal_totals']['end_comp_count'] ?? 0) + $row['end_comp_count'];
                $output['horizontal_totals']['end_comp_value']  = ($output['horizontal_totals']['end_comp_value'] ?? 0) + $row['end_comp_value'];
                $output['horizontal_totals']['cyber_sec_count'] = ($output['horizontal_totals']['cyber_sec_count'] ?? 0) + $row['cyber_sec_count'];
                $output['horizontal_totals']['cyber_sec_value'] = ($output['horizontal_totals']['cyber_sec_value'] ?? 0) + $row['cyber_sec_value'];
            }
        }
    }

    // Format totals
    $output['horizontal_totals']['invoice_value'] = number_format($output['horizontal_totals']['invoice_value']);
    if ($acc_verticals === 'All') {
        $output['horizontal_totals']['end_comp_value']  = number_format($output['horizontal_totals']['end_comp_value']);
        $output['horizontal_totals']['cyber_sec_value'] = number_format($output['horizontal_totals']['cyber_sec_value']);
    }

    echo json_encode($output);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Query error: ' . $e->getMessage()]);
}
?>


