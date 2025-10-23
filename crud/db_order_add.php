<?php
include_once '../include/connDB.php';

$i_OrderID      = isset($_POST['i_OrderID']) && $_POST['i_OrderID'] !== '' ? $_POST['i_OrderID'] : null;
$c_OrderDate    = $_POST['c_OrderDate'] ?? null;
$i_EmployeeID   = isset($_POST['i_EmployeeID']) ? intval($_POST['i_EmployeeID']) : null;
$i_CustomerID   = isset($_POST['i_CustomerID']) ? intval($_POST['i_CustomerID']) : null;
$i_ShipperID    = isset($_POST['i_ShipperID']) ? intval($_POST['i_ShipperID']) : null;
$i_ProductID    = isset($_POST['i_ProductID']) && is_array($_POST['i_ProductID']) ? $_POST['i_ProductID'] : [];
$i_Quantity     = isset($_POST['i_Quantity']) && is_array($_POST['i_Quantity']) ? $_POST['i_Quantity'] : [];

try {
    if (!$c_OrderDate || !$i_EmployeeID || !$i_CustomerID || !$i_ShipperID) {
        throw new Exception("กรุณากรอกข้อมูลให้ครบทุกช่อง");
    }
    if (!is_array($i_ProductID) || !is_array($i_Quantity) || count($i_ProductID) !== count($i_Quantity)) {
        throw new Exception("ข้อมูลสินค้าไม่ถูกต้อง");
    }

    $pdo->beginTransaction();
    $stmt = $pdo->prepare("INSERT INTO tb_orders (c_OrderDate, i_EmployeeID, i_CustomerID, i_ShipperID) 
                           VALUES (?, ?, ?, ?)");
    $stmt->execute([$c_OrderDate, $i_EmployeeID, $i_CustomerID, $i_ShipperID]);
    $lastOrderID = $pdo->lastInsertId();

    if (empty($lastOrderID) || $lastOrderID == '0') {
        $lastOrderID = $pdo->query('SELECT MAX(i_OrderID) FROM tb_orders')->fetchColumn();
        $lastOrderID = $lastOrderID ? intval($lastOrderID) : null;
    }

    if (!$lastOrderID) {
        throw new Exception('ไม่สามารถได้หมายเลข Order ใหม่ (i_OrderID)');
    }

    $stmtDetail = $pdo->prepare("INSERT INTO tb_orderdetails (i_OrderID, i_ProductID, i_Quantity) VALUES (?, ?, ?)");
    for ($i = 0; $i < count($i_ProductID); $i++) {
        $prod = isset($i_ProductID[$i]) ? intval($i_ProductID[$i]) : 0;
        $qty  = isset($i_Quantity[$i]) ? intval($i_Quantity[$i]) : 0;
        if ($prod > 0 && $qty > 0) { 
            $stmtDetail->execute([$lastOrderID, $prod, $qty]);
        }
    }

    $pdo->commit();

    header("Location: ../db_sales_search.php");
    exit();

} catch (Exception $e) {
    $pdo->rollBack();
    echo "เกิดข้อผิดพลาด: " . $e->getMessage();
}
?>
