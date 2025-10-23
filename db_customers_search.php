<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include_once 'include/connDB.php';
include_once 'include/elementMod.php';
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Document</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <style>
        body {
            background: linear-gradient(90deg, rgba(42, 123, 155, 1) 7%, rgb(3, 72, 193) 50%, rgb(2, 151, 192) 100%);
            font-family: 'Kanit', sans-serif;
        }

        h1 {
            color: white;
        }
    </style>
</head>

<body>

    <?php require_once 'include/navbar.php'; ?>

    <?php
    // --------------------------
    // ตัวกรองข้อมูล
    // --------------------------
    $param_custid = isset($_GET['cond_custid']) && $_GET['cond_custid'] !== '' ? $_GET['cond_custid'] : '';

    // --------------------------
    // Pagination
    // --------------------------
    $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
    $pageSize = 10;
    $offset = ($page - 1) * $pageSize;

    // --------------------------
    // นับจำนวนข้อมูลทั้งหมด
    // --------------------------
    $countSql = "SELECT COUNT(*) FROM tb_customers WHERE 1=1";
    $countParams = [];

    if ($param_custid !== '') {
        $countSql .= " AND i_customerid = :param_custid";
        $countParams[':param_custid'] = $param_custid;
    }

    $countStmt = $pdo->prepare($countSql);
    $countStmt->execute($countParams);
    $totalRows = (int)$countStmt->fetchColumn();
    $totalPages = max(1, (int)ceil($totalRows / $pageSize));

    // --------------------------
    // ดึงข้อมูลลูกค้า
    // --------------------------
    $sql = "SELECT 
                i_customerid AS custid, 
                c_customername AS custname, 
                c_contactname AS contact, 
                c_city AS city, 
                c_country AS country
            FROM tb_customers 
            WHERE 1=1";
    $params = [];

    if ($param_custid !== '') {
        $sql .= " AND i_customerid = :param_custid";
        $params[':param_custid'] = $param_custid;
    }

    $sql .= " ORDER BY i_customerid ASC LIMIT :limit OFFSET :offset";
    $stmt = $pdo->prepare($sql);

    foreach ($params as $k => $v) $stmt->bindValue($k, $v, PDO::PARAM_INT);
    $stmt->bindValue(':limit', $pageSize, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $customers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <div class="container p-4">
        <h1>หน้าจอค้นหาลูกค้า</h1>

        <div id="accordion">
            <div class="card">
                <div class="card-header">
                    <a class="btn" data-bs-toggle="collapse" href="#collapseOne">ตัวกรองการค้นหา</a>
                </div>

                <div id="collapseOne" class="collapse show" data-bs-parent="#accordion">
                    <div class="card-body">
                        <form action="" method="GET">
                            <div class="row">
                                <div class="col-10">
                                    <?php
                                    dropdown_db($pdo, "cond_custid", "tb_customers", "i_customerid", "c_customername", $param_custid);
                                    ?>
                                </div>
                                <div class="col-2 d-grid">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-search"></i>&nbsp;&nbsp;ค้นหาข้อมูล
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <p></p>
        </div>

        <div class="card">
            <div class="card-header">รายการลูกค้าทั้งหมด</div>

            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Customer ID</th>
                            <th>Customer Name</th>
                            <th>Contact Name</th>
                            <th>City</th>
                            <th>Country</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($customers)) { ?>
                            <?php foreach ($customers as $customer) { ?>
                                <tr>
                                    <td><?= htmlspecialchars($customer['custid']); ?></td>
                                    <td><?= htmlspecialchars($customer['custname']); ?></td>
                                    <td><?= htmlspecialchars($customer['contact']); ?></td>
                                    <td><?= htmlspecialchars($customer['city']); ?></td>
                                    <td><?= htmlspecialchars($customer['country']); ?></td>
                                    <td>
                                        <form action="./crud/db_customers_edit.php" method="POST">
                                            <input type="hidden" name="custid" value="<?= $customer['custid']; ?>">
                                            <button type="submit" class="btn btn-warning text-white bi bi-pen fs-6"></button>
                                        </form>
                                    </td>
                                    <td>
                                        <form action="./crud/db_customers_delete.php" method="POST">
                                            <input type="hidden" name="custid" value="<?= $customer['custid']; ?>">
                                            <button type="submit" class="btn btn-danger bi bi-trash fs-6"></button>
                                        </form>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php } else { ?>
                            <tr>
                                <td colspan="7" class="text-center text-muted">ไม่มีข้อมูลลูกค้า</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <!-- ✅ Pagination -->
            <div class="card-footer">
                <?php if ($totalPages > 1): ?>
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center justify-content-md-end">

                            <!-- ปุ่มย้อนกลับ -->
                            <li class="page-item <?= ($page <= 1) ? 'disabled' : ''; ?>">
                                <a class="page-link text-primary"
                                    href="?<?= http_build_query(array_merge($_GET, ['page' => max(1, $page - 1)])); ?>">ย้อนกลับ</a>
                            </li>

                            <?php
                            $adjacents = 1;
                            $show_pages = [1];
                            if ($totalPages >= 2) $show_pages[] = 2;
                            if ($page > 4) $show_pages[] = '...';

                            for ($i = $page - $adjacents; $i <= $page + $adjacents; $i++) {
                                if ($i > 2 && $i < $totalPages - 1) $show_pages[] = $i;
                            }

                            if ($page < $totalPages - 3) $show_pages[] = '...';
                            if ($totalPages > 2) $show_pages[] = $totalPages - 1;
                            if ($totalPages > 1) $show_pages[] = $totalPages;

                            $show_pages = array_unique($show_pages);
                            sort($show_pages);

                            $queryBase = $_GET;
                            $last = 0;

                            foreach ($show_pages as $p) {
                                if ($p === '...') {
                                    echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                                    continue;
                                }
                                $queryBase['page'] = $p;
                                $href = '?' . http_build_query($queryBase);
                                $active = ($p == $page) ? ' active' : '';
                                echo '<li class="page-item' . $active . '"><a class="page-link" href="' . $href . '">' . $p . '</a></li>';
                            }
                            ?>

                            <!-- ปุ่มถัดไป -->
                            <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : ''; ?>">
                                <a class="page-link text-primary"
                                    href="?<?= http_build_query(array_merge($_GET, ['page' => min($totalPages, $page + 1)])); ?>">ถัดไป</a>
                            </li>
                        </ul>
                    </nav>
                <?php else: ?>
                    <div class="text-end text-muted small">ไม่มีข้อมูลมากพอสำหรับการแบ่งหน้า</div>
                <?php endif; ?>
            </div>
        </div>
    </div>

</body>
</html>
