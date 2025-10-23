<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include_once 'include/connDB.php';
include_once 'include/elementMod.php';

// Filters via GET so pagination links keep parameters
$param_sid = isset($_GET['cond_sid']) && $_GET['cond_sid'] !== '' ? $_GET['cond_sid'] : '';

// Pagination
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
$pageSize = 10;
$offset = ($page - 1) * $pageSize;

// count total
$countSql = "SELECT COUNT(*) FROM tb_shippers WHERE 1=1";
$countParams = [];
if ($param_sid !== '') {
    $countSql .= " AND i_ShipperID = :param_sid";
    $countParams[':param_sid'] = $param_sid;
}
$countStmt = $pdo->prepare($countSql);
$countStmt->execute($countParams);
$totalRows = (int) $countStmt->fetchColumn();
$totalPages = $totalRows ? (int) ceil($totalRows / $pageSize) : 1;

// fetch page
$sql = "SELECT i_ShipperID as sid, c_ShipperName as sname, c_Phone as phone FROM tb_shippers WHERE 1=1";
$params = [];
if ($param_sid !== '') {
    $sql .= " AND i_ShipperID = :param_sid";
    $params[':param_sid'] = $param_sid;
}
$sql .= " ORDER BY i_ShipperID ASC LIMIT :limit OFFSET :offset";

$stmt = $pdo->prepare($sql);
foreach ($params as $k => $v)
    $stmt->bindValue($k, $v, PDO::PARAM_INT);
$stmt->bindValue(':limit', $pageSize, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$shippers = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ค้นหาผู้จัดส่ง</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

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
        function EditShipper(sid) {
            console.log("Edit Shipper ID : " + sid);
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = './crud/db_shippers_edit.php';
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'sid';
            input.value = sid;
            form.appendChild(input);
            document.body.appendChild(form);
            form.submit();
        }
    </script>
</head>

<body>

    <?php require_once 'include/navbar.php'; ?>

    <div class="container p-4">
        <h1>หน้าจอค้นหาผู้จัดส่ง</h1>

        <div id="accordion">
            <div class="card">
                <div class="card-header">
                    <a class="btn" data-bs-toggle="collapse" href="#collapseOne">
                        ตัวกรองการค้นหา
                    </a>
                </div>
                <div id="collapseOne" class="collapse show" data-bs-parent="#accordion">
                    <div class="card-body">
                        <form action="" method="GET">
                            <div class="row">
                                <div class="col-10">
                                    <?php
                                    dropdown_db($pdo, "cond_sid", "tb_shippers", "i_ShipperID", "c_ShipperName", $param_sid);
                                    ?>
                                </div>
                                <div class="col-2 d-grid">
                                    <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i>
                                        ค้นหาข้อมูล</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <p></p>
        </div>
        <div class="card">
            <div class="card-header">รายชื่อผู้จัดส่ง</div>
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Shipper ID</th>
                            <th>Shipper Name</th>
                            <th>Phone</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($shippers as $shipper) { ?>
                            <tr>
                                <td><?php echo $shipper['sid']; ?></td>
                                <td><?php echo htmlspecialchars($shipper['sname']); ?></td>
                                <td><?php echo htmlspecialchars($shipper['phone']); ?></td>
                                <td>
                                    <form action="./crud/db_shippers_edit.php" method="POST">
                                        <input type="hidden" name="sid" value="<?php echo $shipper['sid']; ?>">
                                        <button onclick="EditShipper(<?php echo $shipper['sid']; ?>)" type="button"
                                            class="btn btn-warning text-white bi bi-pen fs-6"></button>
                                    </form>
                                </td>
                                <td>
                                    <form action="./crud/db_shippers_delete.php" method="POST">
                                        <input type="hidden" name="sid" value="<?php echo $shipper['sid']; ?>">
                                        <button type="submit" class="btn btn-danger bi bi-trash fs-6"></button>
                                    </form>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <!-- ✅ Pagination แบบ ... -->
            <div class="card-footer">
                <?php if ($totalPages > 1): ?>
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-end">

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
                                echo '<li class="page-item' . $active . '"><a class="page-link text-primary" href="' . $href . '">' . $p . '</a></li>';
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