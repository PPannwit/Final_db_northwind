<?php
include_once 'include/connDB.php';
include_once 'include/elementMod.php';
require_once 'include/navbar.php';

// ==================== รับค่า Order ID ====================
$order_id = isset($_POST['i_OrderID']) && is_numeric($_POST['i_OrderID']) ? $_POST['i_OrderID'] : 0;

// ถ้าไม่มีค่า order_id ให้กลับไปหน้าเดิม
if ($order_id == 0) {
    header("Location: db_sales_search.php");
    exit();
}

// ==================== Query ข้อมูลรายละเอียดสินค้า ====================
$sql = "SELECT 
            o.i_OrderID,
            o.c_OrderDate,
            c.c_CustomerName AS customer_name,
            CONCAT(e.c_LastName, ' ', e.c_FirstName) AS employee_name,
            p.c_ProductName,
            p.i_Price,
            d.i_Quantity,
            (p.i_Price * d.i_Quantity) AS total_price
        FROM 
            tb_orderdetails d
        INNER JOIN tb_orders o ON d.i_OrderID = o.i_OrderID
        INNER JOIN tb_products p ON d.i_ProductID = p.i_ProductID
        INNER JOIN tb_customers c ON o.i_CustomerID = c.i_CustomerID
        INNER JOIN tb_employees e ON o.i_EmployeeID = e.i_EmployeeID
        WHERE 
            o.i_OrderID = :order_id";

$stmt = $pdo->prepare($sql);
$stmt->execute(['order_id' => $order_id]);
$details = $stmt->fetchAll(PDO::FETCH_ASSOC);

// ==================== สรุปยอดรวม ====================
$total_qty = 0;
$total_price = 0;
foreach ($details as $row) {
    $total_qty += $row['i_Quantity'];
    $total_price += $row['total_price'];
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>ใบเสร็จคำสั่งซื้อ #<?= htmlspecialchars($order_id) ?></title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<link href="https://fonts.googleapis.com/css2?family=Kanit&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

<style>
body {
    background: #2A7B9B;
    background: linear-gradient(90deg, rgba(42,123,155,1) 7%, rgb(3,72,193) 50%, rgb(2,151,192) 100%);
    font-family: 'Kanit', sans-serif;
}
h1, h2, h3, h4 {
    color: #fff;
    text-align: center;
}
.receipt {
    background: #fff;
    border-radius: 10px;
    padding: 30px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    margin-top: 30px;
}
.table thead {
    background-color: #007bff;
    color: #fff;
    text-align: center;
}
.table th, .table td {
    text-align: center;
    vertical-align: middle;
}
.table tbody tr:nth-child(even) {
    background-color: #f8f9fa;
}

/* ปุ่มพิมพ์สีเขียว */
.btn-print {
    background-color: #28a745;
    color: #fff;
    border: none;
}
.btn-print:hover {
    background-color: #218838;
    color: #fff;
}

/* สีไอคอนเครื่องพิมพ์ */
.btn-print i {
    color: #fff;
}

@media print {
    body * {
        visibility: hidden;
    }
    #receipt, #receipt * {
        visibility: visible;
    }
    #receipt {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
    }
    .btn, .navbar {
        display: none !important;
    }
}
</style>
</head>

<body>
<div class="container">
    <div id="receipt" class="receipt">
        <h2 class="text-dark">รายละเอียดคำสั่งซื้อ</h2>
        <hr>
        <?php if (count($details) > 0): ?>
        <div class="mb-3">
            <p><strong>หมายเลขคำสั่งซื้อ:</strong> <?= htmlspecialchars($order_id); ?></p>
            <p><strong>วันที่สั่งซื้อ:</strong> <?= htmlspecialchars($details[0]['c_OrderDate']); ?></p>
            <p><strong>ลูกค้า:</strong> <?= htmlspecialchars($details[0]['customer_name']); ?></p>
            <p><strong>พนักงานขาย:</strong> <?= htmlspecialchars($details[0]['employee_name']); ?></p>
        </div>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ชื่อสินค้า</th>
                    <th>ราคาต่อหน่วย (บาท)</th>
                    <th>จำนวน (ชิ้น)</th>
                    <th>ราคารวม (บาท)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($details as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['c_ProductName']); ?></td>
                    <td><?= number_format($row['i_Price'], 2); ?></td>
                    <td><?= $row['i_Quantity']; ?></td>
                    <td><?= number_format($row['total_price'], 2); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="text-end mt-3">
            <h5>รวมจำนวนสินค้า: <strong><?= $total_qty ?> ชิ้น</strong></h5>
            <h4 class="text-dark">รวมเป็นเงินทั้งสิ้น: <strong><?= number_format($total_price, 2) ?> บาท</strong></h4>
        </div>
        <hr>
        <?php else: ?>
        <div class="alert alert-danger text-center mt-4">
            ไม่พบข้อมูลสำหรับใบสั่งซื้อหมายเลขนี้
        </div>
        <?php endif; ?>
    </div>

    <div class="text-center mt-4">
        <button class="btn btn-print" onclick="window.print()">
            <i class="bi bi-printer"></i> พิมพ์ใบเสร็จ
        </button>
        <a href="db_sales_search.php" class="btn btn-outline-light ms-2">
            <i class="bi bi-arrow-left-circle"></i> กลับไปยังหน้ารวมยอดขาย
        </a>
    </div>
</div>
</body>
</html>
