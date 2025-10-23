<?php
include_once 'include/connDB.php';
include_once 'include/elementMod.php';
require_once 'include/navbar.php';

// ==================== Filter ====================
$param_catid = isset($_POST['cond_catid']) && $_POST['cond_catid'] !== '' ? $_POST['cond_catid'] : 1;
$param_price = isset($_POST['cond_price']) && $_POST['cond_price'] !== '' ? $_POST['cond_price'] : 10;

// ==================== Query ข้อมูล ====================
$sql = "SELECT 
    o.i_OrderID,
    o.c_OrderDate,
    CONCAT(e.c_LastName, ' ', e.c_FirstName) AS employee_name,
    c.c_CustomerName AS customer_name,
    SUM(d.i_Quantity) AS total_quantity,
    SUM(d.i_Quantity * p.i_Price) AS total_price
    FROM tb_orders o
    INNER JOIN tb_orderdetails d ON o.i_OrderID = d.i_OrderID
    INNER JOIN tb_employees e ON o.i_EmployeeID = e.i_EmployeeID
    INNER JOIN tb_customers c ON o.i_CustomerID = c.i_CustomerID
    INNER JOIN tb_products p ON d.i_ProductID = p.i_ProductID
    GROUP BY o.i_OrderID, o.c_OrderDate, employee_name, customer_name
    ORDER BY o.i_OrderID ASC";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

// ==================== รวมผลรวมทั้งหมด ====================
$total_quantity_all = 0;
$total_price_all = 0;
foreach ($orders as $order) {
    $total_quantity_all += $order['total_quantity'];
    $total_price_all += $order['total_price'];
}

// ==================== Pagination ====================
$records_per_page = 5;
$total_records = count($orders);
$total_pages = ceil($total_records / $records_per_page);
$current_page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
if ($current_page < 1)
    $current_page = 1;
elseif ($current_page > $total_pages && $total_pages > 0)
    $current_page = $total_pages;

$start_index = ($current_page - 1) * $records_per_page;
$results = array_slice($orders, $start_index, $records_per_page);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Dashboard</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Kanit&display=swap" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <style>
        body {
            background: #2A7B9B;
            background: linear-gradient(90deg, rgba(42, 123, 155, 1) 7%, rgb(3, 72, 193) 50%, rgb(2, 151, 192) 100%);
            font-family: 'Kanit', sans-serif;
        }

        h1,
        h2 {
            color: #fff;
            /* เปลี่ยนเป็นสีขาว */
            text-align: center;
            margin-bottom: 20px;
        }

        .card {
            background-color: rgba(255, 255, 255, 0.95);
            color: #000;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            margin-bottom: 20px;
        }

        .table thead {
            background-color: #007bff;
            color: #fff;
            text-align: center;
        }

        .table th,
        .table td {
            text-align: center !important;
            vertical-align: middle !important;
        }

        .table tbody tr:nth-child(even) {
            background-color: #e9ecef;
        }

        .table tbody tr:hover {
            background-color: #d1ecf1;
            cursor: pointer;
        }

        .btn-warning {
            padding: 0.25rem 0.5rem;
            font-size: 0.85rem;
        }

        .pagination .page-link {
            color: #007bff;
            font-weight: 500;
            border-radius: 5px;
        }

        .pagination .page-item.active .page-link {
            background-color: #007bff;
            color: #fff !important;
            font-weight: bold;
            border-color: #007bff;
        }

        .pagination .page-link:hover {
            background-color: #0056b3;
            color: #fff;
        }

        .form-control {
            border-radius: 8px;
        }
    </style>
</head>

<body>

    <div class="container p-4">
        <h1>ตรวจสอบยอดขายสินค้า</h1>

        <!-- Table Card -->
        <div class="card">
            <div class="card-header">ยอดขายสินค้าทั้งหมด</div>
            <div class="card-body table-responsive">
                <table class="table table-bordered table-sm">
                    <thead>
                        <tr>
                            <th>เลขที่การขาย</th>
                            <th>วันที่ขาย</th>
                            <th>ชื่อ-สกุลพนักงานขาย</th>
                            <th>ชื่อ-สกุลลูกค้า</th>
                            <th>จำนวนสินค้ารวมทั้งหมด</th>
                            <th>จำนวนราคารวมทั้งหมด</th>
                            <th>รายละเอียดสินค้า</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($results as $order): ?>
                            <tr>
                                <td><?= $order['i_OrderID']; ?></td>
                                <td><?= $order['c_OrderDate']; ?></td>
                                <td><?= $order['employee_name']; ?></td>
                                <td><?= $order['customer_name']; ?></td>
                                <td><?= $order['total_quantity']; ?></td>
                                <td><?= number_format($order['total_price'], 2); ?></td>
                                <td>
                                    <form action="./db_details.php" method="POST">
                                        <input type="hidden" name="i_OrderID" value="<?= $order['i_OrderID']; ?>">
                                        <button type="submit" class="btn btn-info btn-sm">
                                            <i class="bi bi-search"></i> รายละเอียดสินค้า
                                        </button>
                                    </form>

                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="card-footer">
                    <?php if ($total_pages > 1): ?>
                        <nav aria-label="Page navigation">
                            <ul class="pagination justify-content-end">
                                <li class="page-item <?= ($current_page <= 1) ? 'disabled' : ''; ?>">
                                    <a class="page-link" href="?page=<?= $current_page - 1; ?>">ย้อนกลับ</a>
                                </li>

                                <?php
                                $adjacents = 1;
                                $show_pages = [];
                                $show_pages[] = 1;
                                if ($total_pages >= 2)
                                    $show_pages[] = 2;
                                if ($current_page > 4)
                                    $show_pages[] = '...';
                                for ($i = $current_page - $adjacents; $i <= $current_page + $adjacents; $i++) {
                                    if ($i > 2 && $i < $total_pages - 1)
                                        $show_pages[] = $i;
                                }
                                if ($current_page < $total_pages - 3)
                                    $show_pages[] = '...';
                                if ($total_pages > 2)
                                    $show_pages[] = $total_pages - 1;
                                if ($total_pages > 1)
                                    $show_pages[] = $total_pages;
                                $show_pages = array_unique($show_pages);
                                sort($show_pages);
                                $last = 0;
                                foreach ($show_pages as $p) {
                                    if ($last && $p != '...' && $p - $last > 1) {
                                        echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                                    }
                                    if ($p === '...')
                                        continue;
                                    echo '<li class="page-item ' . ($p == $current_page ? 'active' : '') . '">
                                    <a class="page-link" href="?page=' . $p . '">' . $p . '</a>
                                  </li>';
                                    $last = $p;
                                }
                                ?>

                                <li class="page-item <?= ($current_page >= $total_pages) ? 'disabled' : ''; ?>">
                                    <a class="page-link" href="?page=<?= $current_page + 1; ?>">ถัดไป</a>
                                </li>
                            </ul>
                        </nav>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- สรุปยอดรวมทั้งหมด -->
    <div class="container mt-3">
        <h2>ตารางสรุปรายการขาย</h2>
        <div class="d-flex flex-row justify-content-evenly gap-2">
            <div class="card w-50">
                <div class="card-header">
                    <h5 class="card-title text-center fw-bold py-2">ผลรวมจำนวนสินค้ารวมทั้งหมด</h5>
                </div>
                <div class="card-body">
                    <h3 class="card-text text-center fw-bold"><?= $total_quantity_all . ' ชิ้น'; ?></h3>
                </div>
            </div>
            <div class="card w-50">
                <div class="card-header">
                    <h5 class="card-title text-center fw-bold py-2">ผลรวมจำนวนราคารวมทั้งหมด</h5>
                </div>
                <div class="card-body">
                    <h3 class="card-text text-center fw-bold"><?= number_format($total_price_all, 2) . ' บาท'; ?></h3>
                </div>
            </div>
        </div>
    </div>

</body>

</html>