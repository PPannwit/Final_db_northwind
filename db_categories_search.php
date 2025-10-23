<?php
include_once 'include/connDB.php';
include_once 'include/elementMod.php';
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category Document</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@400;500;600&display=swap" rel="stylesheet">

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
        function EditData(cid) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = './crud/db_categories_edit.php';
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'cid';
            input.value = cid;
            form.appendChild(input);
            document.body.appendChild(form);
            form.submit();
        }
    </script>
</head>

<body>
    <?php require_once 'include/navbar.php'; ?>

    <?php
    $param_catid = isset($_GET['cond_catid']) && $_GET['cond_catid'] !== '' ? $_GET['cond_catid'] : '';

    $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
    $pageSize = 8;
    $offset = ($page - 1) * $pageSize;

    $countSql = "SELECT COUNT(*) FROM tb_categories WHERE 1=1";
    $countParams = [];
    if ($param_catid !== '') {
        $countSql .= " AND i_CategoryID = :param_catid";
        $countParams[':param_catid'] = $param_catid;
    }
    $countStmt = $pdo->prepare($countSql);
    $countStmt->execute($countParams);
    $totalRows = (int) $countStmt->fetchColumn();
    $totalPages = $totalRows ? (int) ceil($totalRows / $pageSize) : 1;
    $sql = "SELECT i_CategoryID as cid, c_CategoryName as cname, c_Description as cdesc
            FROM tb_categories WHERE 1=1";
    $params = [];
    if ($param_catid !== '') {
        $sql .= " AND i_CategoryID = :param_catid";
        $params[':param_catid'] = $param_catid;
    }
    $sql .= " ORDER BY i_CategoryID ASC LIMIT :limit OFFSET :offset";

    $stmt = $pdo->prepare($sql);
    foreach ($params as $k => $v)
        $stmt->bindValue($k, $v, PDO::PARAM_INT);
    $stmt->bindValue(':limit', $pageSize, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();

    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <div class="container p-4">
        <h1>หน้าจอค้นหาหมวดหมู่สินค้า</h1>

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
                                    dropdown_db($pdo, "cond_catid", "tb_categories", "i_CategoryID", "c_CategoryName", $param_catid);
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
        </div>

        <p></p>

        <div class="card">
            <div class="card-header">รายการหมวดหมู่สินค้าทั้งหมด</div>
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>รหัสหมวดหมู่</th>
                            <th>ชื่อหมวดหมู่</th>
                            <th>คำอธิบาย</th>
                            <th>แก้ไข</th>
                            <th>ลบ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($categories as $category): ?>
                            <tr>
                                <td><?= $category['cid']; ?></td>
                                <td><?= htmlspecialchars($category['cname']); ?></td>
                                <td><?= htmlspecialchars($category['cdesc']); ?></td>
                                <td>
                                    <button onclick="EditData(<?= $category['cid']; ?>)" type="button"
                                        class="btn btn-warning text-white bi bi-pen fs-6"></button>
                                </td>
                                <td>
                                    <form action="./crud/db_categories_delete.php" method="POST"
                                        onsubmit="return confirm('ยืนยันการลบหมวดหมู่นี้หรือไม่?');">
                                        <input type="hidden" name="cid" value="<?= $category['cid']; ?>">
                                        <button type="submit" class="btn btn-danger bi bi-trash fs-6"></button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <?php if ($totalPages > 1): ?>
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center justify-content-md-end">
                            <li class="page-item <?= ($page <= 1) ? 'disabled' : ''; ?>">
                                <a class="page-link text-primary"
                                    href="?<?= http_build_query(array_merge($_GET, ['page' => max(1, $page - 1)])); ?>">ย้อนกลับ</a>
                            </li>

                            <?php
                            $adjacents = 1; 
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