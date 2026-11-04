<?php
require_once __DIR__ . '/../../config/env.php';
// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/php-error.log');

$host = "localhost";
$dbname = "operation_team_beta";
$username = project_env('APP_DB_USERNAME', 'root');
$password = project_env('APP_DB_PASSWORD');

// DB Connection
try {
    $pdo = new PDO("mysql:host={$host};dbname={$dbname};charset=utf8mb4", $username, $password, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]);
} catch (PDOException $e) {
    exit("DB Connection failed: " . $e->getMessage());
}

// Handle JSON input
$req = json_decode(file_get_contents('php://input'), true);
if (!($req['action'] === 'create_stock' && !empty($req['data']))) {
    http_response_code(400);
    echo json_encode(['status' => false, 'error' => 'Bad request']);
    exit;
}

$payload = $req['data'];
// print_r($payload);die();
$result  = createStockPositionFull($payload);

// Respond as JSON
header('Content-Type: application/json');
echo json_encode($result);

// Utility functions

function unique_id($prefix = "") {
    $unique_id = uniqid() . rand(10000, 99999);
    return $prefix ? $prefix . $unique_id : $unique_id;
}

function convertDate($date) {
    $parts = explode('-', $date);
    if (count($parts) === 3) {
        return $parts[2] . '-' . $parts[1] . '-' . $parts[0];
    }
    return null;
}

function stock_no_get()
{
    $date = date("Y");
    $st_date = substr($date, 2);
    $month = date("m");
    $datee = $st_date . $month;

    $servername = 'localhost';
    $username   = project_env('APP_DB_USERNAME', 'root');
    $password   = project_env('APP_DB_PASSWORD');
    $dbname     = "operation_team_beta";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        error_log("stock_no_get DB Error: " . $e->getMessage());
        return 'STK-' . $datee . '-0001';
    }

    $stmt = $conn->query("SELECT stock_id FROM stock_position_main WHERE stock_id LIKE 'STK%' ORDER BY id DESC LIMIT 1");
    $res1 = $stmt->fetch();

    // print_r($res1);die();
    if ($res1) {
        $pur_array = explode('-', $res1['stock_id']);
        $year1 = $pur_array[1] ?? '';
        $year2 = substr($year1, 0, 2);
        $year = '20' . $year2;
        $booking_no = $pur_array[2] ?? '';
    }

    if (empty($booking_no) || $year != date("Y")) {
        return 'STK-' . $datee . '-0001';
    } else {
        $booking_no += 1;
        return 'STK-' . $datee . '-' . str_pad($booking_no, 4, '0', STR_PAD_LEFT);
    }
}

function createStockPositionFull(array $payload) {
    global $pdo;


    try {
        $pdo->beginTransaction();

        // Generate stock ID
        $booking_nos = stock_no_get();

        // print_r($booking_nos);die();
        if (empty($booking_nos)) {
            throw new Exception("Stock ID generation failed.");
        }

$sql = "
  SELECT SUM(stock_qty) AS grand_total_qty
  FROM stock_position
  WHERE form_main_unique_id = :main_unique_id
";
$stmt = $pdo->prepare($sql);
$stmt->execute([':main_unique_id' => $payload['main_unique_id']]);
$overall = $stmt->fetch(PDO::FETCH_ASSOC);

$grandQty = (int) $overall['grand_total_qty'];
$incomingQty = (int) $payload['totals']['total_stock_qty'];
$tots = $grandQty + $incomingQty;

// echo "Computed total: $tots\n";
// echo "Incoming total: $incomingQty\n";
$item_qty = $payload['total_qty'];
if ($tots == $item_qty) {
    // echo "✔️ Condition met: equivalent!\n";
    $status = 2;
$ids = $payload['main_unique_id'];
    // Update PO status
   $sqlUpdate = "
  UPDATE po_form
  SET status = :status
  WHERE unique_id = :main_unique_id
";

$us = $pdo->prepare($sqlUpdate);
$success = $us->execute([
    ':status' => 2,
    ':main_unique_id' => $ids
]);
// print_r($sqlUpdate);
if ($success) {
    $affected = $us->rowCount();  // Number of rows actually updated :contentReference[oaicite:1]{index=1}

    if ($affected > 0) {
        // echo "✅ PO status updated successfully. Rows updated: $affected.";
    } else {
        // echo "ℹ️ No update performed: record might not exist, or the status was already set to this value.";
    }
} else {
    $errorInfo = $u->errorInfo();
    // echo "❌ Update failed: {$errorInfo[2]}";
}
} 

        // 🔄 UPDATE the PO status based on total comparison
    
            $sqlUpdatePO = "
      UPDATE po_form
      SET status = :status
      WHERE unique_id = :main_unique_id
    ";
    $u = $pdo->prepare($sqlUpdatePO);
    $u->execute([
        ':status'           => 1,
        ':main_unique_id'   => $payload['main_unique_id']
    ]);

        // Insert into stock_position_main
        $sqlMain = "
            INSERT INTO stock_position_main
              (unique_id, form_main_unique_id, po_unique_id, po_num,
               stock_id, no_of_con, no_of_item, executive_name,
               department, stock_qty, stock_value, billed_qty,
               stock_date, po_date)
            VALUES
              (:u1, :u2, :pouid, :ponum,
               :stokid, :conc, :items, :exe,
               :dept, :stoqty, :stoval, :billqty,
               :stodate, :podate)
        ";
        $stmt = $pdo->prepare($sqlMain);
        $stmt->execute([
            ':u1'     => unique_id(),
            ':u2'     => $payload['main_unique_id'],
            ':pouid'  => $payload['po_unique_id'],
            ':ponum'  => $payload['po_num'],
            ':stokid' => $booking_nos,
            ':conc'   => $payload['no_of_con'],
            ':items'  => $payload['no_of_items'],
            ':exe'    => $payload['exe_name'],
            ':dept'   => $payload['department'],
            ':stoqty' => $payload['totals']['total_stock_qty'],
            ':stoval' => $payload['totals']['total_stock_value'],
            ':billqty'=> $payload['totals']['total_stock_qty'],
            ':stodate'=> convertDate($payload['stock_date']),
            ':podate' => convertDate($payload['po_date'])
        ]);


        $mainId = $pdo->lastInsertId();



        // Insert into stock_position
        $sqlPos = "
            INSERT INTO stock_position
              (unique_id, form_main_unique_id, product_unique_id,
               item_code, product, unit_price, net_price, product_tax,
               billed_qty, item_qty, stock_qty,
               remaining_qty, update_stock_qty, part_no,
               stock_value, update_stock_value, po_unique_id, total_qty, net_value, stock_id, stock_date, po_date, remqty)
            VALUES
              (:u, :fmu, :puid, :icode, :pname,
               :uprice, :nprice, :ptax, :bq, :iq, :sq,
               :rq, :usq, :pn, :sv, :usv, :pouid, :total_qty, :net_value, :stock_id, :stock_date, :po_date, :remqty)
        ";
        $stmtPos = $pdo->prepare($sqlPos);

        // Insert into sublist
        $sqlSub = "
            INSERT INTO stock_position_sublist
              (unique_id, form_main_unique_id,
               stock_qty, remaining_qty, product_unique_id, item_code, product, item_qty, billed_qty, product_tax, part_no, total_qty, net_value, unit_price, net_price, stock_date, stock_id, remqty)
            VALUES
              (:su, :fmu, :sq, :rq, :puid, :itemcode, :product, :item_qty, :billed_qty, :product_tax, :part_no, :total_qty, :net_value, :unit_price, :net_price, :stock_date, :stock_id, :remqty)
        ";
        $stmtSub = $pdo->prepare($sqlSub);

        foreach ($payload['products'] as $prod) {
            if (!isset($prod['product'])) {
                error_log("Missing 'product' key in: " . json_encode($prod));
            }
            $remaining_qty = $prod['remaining_qty'];

            if($prod['remqtyVal'] == 0){
                $remQty = $prod['item_qty'];
            }else{
                $remQty = $prod['remqtyVal'];
            }



            $posUniqueId = uniqid('pos_', true);

            $stmtPos->execute([
                ':u'     => $posUniqueId,
                ':fmu'   => $payload['main_unique_id'],
                ':puid'  => $prod['product_unique_id'] ?? '',
                ':icode' => $prod['item_code'] ?? '',
                ':pname' => $prod['product'] ?? '',
                ':uprice'=> $prod['unit_price'] ?? 0,
                ':nprice'=> $prod['net_price'] ?? 0,
                ':ptax'  => $prod['product_tax'] ?? 0,
                ':bq'    => $prod['billed_qty'] ?? 0,
                ':iq'    => $prod['item_qty'] ?? 0,
                ':sq'    => $prod['stock_qty'] ?? 0,
                ':rq'    => $remaining_qty,
                ':usq'   => $prod['update_stock_qty'] ?? 0,
                ':pn'    => $prod['part_no'] ?? '',
                ':sv'    => $prod['stock_value'] ?? 0,
                ':usv'   => $prod['update_stock_value'] ?? 0,
                ':pouid' => $payload['po_unique_id'] ?? 0,
                ':total_qty' => $payload['total_qty'],
                ':net_value' => $payload['net_value'],
                ':stock_id' => $booking_nos,
                ':stock_date' => convertDate($payload['stock_date']),
                ':po_date' => convertDate($payload['po_date']),
                ':remqty' => $remQty,

            ]);

            $stmtSub->execute([
                ':su'  => uniqid(),
                ':fmu' => $payload['main_unique_id'],
                ':sq'  => $prod['stock_qty'] ?? 0,
                ':rq'  => $remaining_qty,
                ':puid'  => $prod['product_unique_id'] ?? '',
                ':itemcode'  => $prod['item_code'] ?? '',
                ':product'  => $prod['product'] ?? '',
                ':item_qty'  => $prod['item_qty'] ?? 0,
                ':billed_qty'  => $prod['billed_qty'] ?? 0,
                ':product_tax'  => $prod['product_tax'] ?? 0,
                ':part_no'  => $prod['part_no'] ?? '',
                ':total_qty' => $payload['total_qty'],
                ':net_value' => $payload['net_value'],
                ':unit_price'  => $prod['unit_price'] ?? 0,
                ':net_price'  => $prod['net_price'] ?? 0,
                ':stock_date'  => convertDate($payload['stock_date']),
                ':stock_id'  => $booking_nos,
                ':remqty' => $remQty,
            ]);
        }

        
        $pdo->commit();
        $pdo->query("CALL update_po_form_stock_status()");

        return ['status' => true, 'msg' => 'Stock data saved successfully'];
    } catch (Exception $e) {
        $pdo->rollBack();
        error_log("createStockPositionFull Error: " . $e->getMessage());
        return ['status' => false, 'error' => $e->getMessage()];
    }
}



