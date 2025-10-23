<?php
include_once 'include/connDB.php';
include_once 'include/elementMod.php';

// $products = dropdown_db($pdo);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- BS5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- GG Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <style>
        body {
            background: #2A7B9B;
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
            form.m
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

    <?php require_once 'include/navbar.php';

    // Use GET so pagination links keep filters
    $param_pid = isset($_GET['cond_pid']) && $_GET['cond_pid'] !== '' ? $_GET['cond_pid'] : '';
    $param_price = isset($_GET['cond_price']) && $_GET['cond_price'] !== '' ? $_GET['cond_price'] : '';

    $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
    $pageSize = 10;
    $offset = ($page - 1) * $pageSize;

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
    $totalRows = (int) $countStmt->fetchColumn();
    $totalPages = $totalRows ? (int) ceil($totalRows / $pageSize) : 1;

    $sql = "SELECT i_ProductID as pid, c_ProductName as pname, i_Price as pprice FROM tb_products WHERE 1=1";
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


        <div id="accordion">

            <div class="card">
                <div class="card-header">
                    <a class="btn" data-bs-toggle="collapse" href="#collapseOne">
                        ตัวกรองการค้นหา
                    </a>
                </div>
                <div id="collapseOne" class="collapse show" data-bs-parent="#accordion">
                    <div class="card-body">
                        <!-- FORM FILTER -->
                        <form action="db_product_search.php" method="GET">
                            <div class="row ">
                                <div class="col-5">
                                    <!-- <input type="text" class="form-control" placeholder="หมวดหมู่สินค้าที่ค้นหา" name="cond_catid"> -->
                                    <?php
                                    // show products by name in dropdown (cond_pid)
                                    dropdown_db($pdo, "cond_pid", "tb_products", "i_ProductID", "c_ProductName", $param_pid);
                                    ?>

                                </div>
                                <div class="col-5">
                                    <input type="number" class="form-control" placeholder="ราคาสินค้าที่ค้นหา"
                                        name="cond_price" value="<?php echo $param_price; ?>">
                                </div>
                                <div class="col-2 d-grid">
                                    <button type="submit" class="btn btn-primary"><i
                                            class="bi bi-search"></i>&nbsp;&nbsp;ค้นหาข้อมูล</button>
                                </div>
                            </div>
                        </form>
                        <!-- END FORM FILTER -->
                    </div>
                </div>
            </div>

            <p></p>
        </div>
        <div class="card">
            <div class="card-header">รายการสินค้าทั้งหมด</div>
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Product ID</th>
                            <th>Product Name</th>
                            <th>Product Price</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $product) { ?>
                            <tr>
                                <td><?php echo $product['pid']; ?></td>
                                <td><?php echo $product['pname']; ?></td>
                                <td><?php echo $product['pprice']; ?></td>

                                <td>
                                    <!-- Form Method POST -->
                                    <form action="./crud/db_product_edit.php" method="POST">
                                        <input type="hidden" name="pid" value="<?php echo $product['pid']; ?>">
                                        <button onclick="EditData(<?php echo $product['pid']; ?>)" type="button"
                                            class="btn btn-warning text-white bi bi-pen fs-6"></button>
                                    </form>
                                </td>
                                <td>
                                    <!-- Form Method POST -->
                                    <form action="./crud/db_product_delete.php" method="POST">
                                        <input type="hidden" name="pid" value="<?php echo $product['pid']; ?>">
                                        <button type="submit" class="btn btn-danger bi bi-trash fs-6"></button>
                                    </form>
                                </td>

                                <!-- Call Function -->
                                <!-- <td>
                                    <button onclick="EditData(<?= $product['pid']; ?>)" type="button" class="btn btn-warning text-white bi bi-pen fs-6"></button>
                                </td> -->

                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
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
                            $adjacents = 1; // จำนวนหน้าข้างเคียง
                            $show_pages = [1];

                            if ($totalPages >= 2)
                                $show_pages[] = 2;
                            if ($page > 4)
                                $show_pages[] = '...';

                            for ($i = $page - $adjacents; $i <= $page + $adjacents; $i++) {
                                if ($i > 2 && $i < $totalPages - 1)
                                    $show_pages[] = $i;
                            }

                            if ($page < $totalPages - 3)
                                $show_pages[] = '...';
                            if ($totalPages > 2)
                                $show_pages[] = $totalPages - 1;
                            if ($totalPages > 1)
                                $show_pages[] = $totalPages;

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