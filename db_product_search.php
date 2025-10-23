<?php
include_once 'include/connDB.php';
include_once 'include/elementMod.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>หน้าจอค้นหาสินค้า</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Kanit:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
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

    <script>
        function EditData(pid) {
            console.log("Edit Product ID : " + pid);
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = './crud/db_product_edit.php';

            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'pid';
            input.value = pid;

            form.appendChild(input);
            document.body.appendChild(form);
            form.submit();
        }
    </script>
</head>

<body>

    <?php require_once 'include/navbar.php'; ?>

    <?php
    // รับค่าตัวกรองจาก GET
    $param_pid = isset($_GET['cond_pid']) && $_GET['cond_pid'] !== '' ? $_GET['cond_pid'] : '';
    $param_price = isset($_GET['cond_price']) && $_GET['cond_price'] !== '' ? $_GET['cond_price'] : '';

    $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
    $pageSize = 8; // จำนวนรายการต่อหน้า
    $offset = ($page - 1) * $pageSize;

    // นับจำนวนทั้งหมด
    $countSql = "SELECT COUNT(*) FROM tb_products WHERE 1=1";
    $countParams = [];
    if ($param_pid !== '') {
        $countSql .= " AND i_ProductID = :param_pid";
        $countParams[':param_pid'] = $param_pid;
    }
    if ($param_price !== '') {
        $countSql .= " AND i_Price >= :param_price";
        $countParams[':param_price'] = $param_price;
    }
    $countStmt = $pdo->prepare($countSql);
    $countStmt->execute($countParams);
    $totalRows = (int)$countStmt->fetchColumn();
    $totalPages = $totalRows ? (int)ceil($totalRows / $pageSize) : 1;

    // ดึงข้อมูลสินค้า
    $sql = "SELECT i_ProductID as pid, c_ProductName as pname, i_Price as pprice 
            FROM tb_products WHERE 1=1";
    $params = [];
    if ($param_pid !== '') {
        $sql .= " AND i_ProductID = :param_pid";
        $params[':param_pid'] = $param_pid;
    }
    if ($param_price !== '') {
        $sql .= " AND i_Price >= :param_price";
        $params[':param_price'] = $param_price;
    }
    $sql .= " ORDER BY i_ProductID ASC LIMIT :limit OFFSET :offset";

    $stmt = $pdo->prepare($sql);
    foreach ($params as $k => $v)
        $stmt->bindValue($k, $v, PDO::PARAM_INT);
    $stmt->bindValue(':limit', $pageSize, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <div class="container p-4">
        <h1>หน้าจอค้นหาสินค้า</h1>

        <!-- ฟิลเตอร์ค้นหา -->
        <div class="card mb-3">
            <div class="card-header">
                <a class="btn" data-bs-toggle="collapse" href="#collapseFilter">ตัวกรองการค้นหา</a>
            </div>
            <div id="collapseFilter" class="collapse show">
                <div class="card-body">
                    <form action="db_product_search.php" method="GET">
                        <div class="row">
                            <div class="col-5">
                                <?php
                                dropdown_db($pdo, "cond_pid", "tb_products", "i_ProductID", "c_ProductName", $param_pid);
                                ?>
                            </div>
                            <div class="col-5">
                                <input type="number" class="form-control" placeholder="ราคาสินค้าที่ค้นหา"
                                    name="cond_price" value="<?= $param_price; ?>">
                            </div>
                            <div class="col-2 d-grid">
                                <button type="submit" class="btn btn-primary"><i
                                        class="bi bi-search"></i>&nbsp;&nbsp;ค้นหาข้อมูล</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- ตารางสินค้า -->
        <div class="card">
            <div class="card-header">รายการสินค้าทั้งหมด</div>
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>รหัสสินค้า</th>
                            <th>ชื่อสินค้า</th>
                            <th>ราคาสินค้า</th>
                            <th>แก้ไข</th>
                            <th>ลบ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $product) : ?>
                            <tr>
                                <td><?= $product['pid']; ?></td>
                                <td><?= $product['pname']; ?></td>
                                <td><?= $product['pprice']; ?></td>
                                <td>
                                    <button onclick="EditData(<?= $product['pid']; ?>)" type="button"
                                        class="btn btn-warning text-white bi bi-pen fs-6"></button>
                                </td>
                                <td>
                                    <form action="./crud/db_product_delete.php" method="POST">
                                        <input type="hidden" name="pid" value="<?= $product['pid']; ?>">
                                        <button type="submit" class="btn btn-danger bi bi-trash fs-6"></button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="card-footer">
                <?php if ($totalPages > 1) : ?>
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center justify-content-md-end">
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
                            if ($page < $totalPages - 3 && $totalPages > 2) $show_pages[] = $totalPages - 1;
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
                                if ($last && $p - $last > 1 && $last !== '...') {
                                    echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                                }
                                $queryBase['page'] = $p;
                                $href = '?' . http_build_query($queryBase);
                                $active = ($p == $page) ? ' active' : '';
                                echo '<li class="page-item' . $active . '"><a class="page-link" href="' . $href . '">' . $p . '</a></li>';
                                $last = $p;
                            }
                            ?>

                            <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : ''; ?>">
                                <a class="page-link text-primary"
                                    href="?<?= http_build_query(array_merge($_GET, ['page' => min($totalPages, $page + 1)])); ?>">ถัดไป</a>
                            </li>
                        </ul>
                    </nav>
                <?php else : ?>
                    <div class="text-end text-muted small">ไม่มีข้อมูลมากพอสำหรับการแบ่งหน้า</div>
                <?php endif; ?>
            </div>
        </div>
    </div>

</body>
</html>
