<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include_once 'include/connDB.php';
include_once 'include/elementMod.php';

$param_pid = isset($_GET['cond_pid']) && $_GET['cond_pid'] !== '' ? $_GET['cond_pid'] : '';

$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
$pageSize = 8;
$offset = ($page - 1) * $pageSize;

$countSql = "SELECT COUNT(*) FROM tb_employees WHERE 1=1";
$countParams = [];
if ($param_pid !== '') {
    $countSql .= " AND i_EmployeeID = :param_pid";
    $countParams[':param_pid'] = $param_pid;
}
$countStmt = $pdo->prepare($countSql);
$countStmt->execute($countParams);
$totalRows = (int) $countStmt->fetchColumn();
$totalPages = $totalRows ? (int) ceil($totalRows / $pageSize) : 1;

$sql = "SELECT i_EmployeeID as eid, c_LastName as lastname, c_FirstName as firstname, c_BirthDate as birthdate, c_Photo as photo, c_Notes as notes
        FROM tb_employees WHERE 1=1";
$params = [];
if ($param_pid !== '') {
    $sql .= " AND i_EmployeeID = :param_pid";
    $params[':param_pid'] = $param_pid;
}
$sql .= " ORDER BY i_EmployeeID ASC LIMIT :limit OFFSET :offset";

$stmt = $pdo->prepare($sql);
foreach ($params as $k => $v)
    $stmt->bindValue($k, $v, PDO::PARAM_INT);
$stmt->bindValue(':limit', $pageSize, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$employees = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ค้นหาพนักงาน</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <style>
        body {
            background: linear-gradient(90deg, rgba(42, 123, 155, 1) 7%, rgb(3, 72, 193) 50%, rgb(2, 151, 192) 100%);
            font-family: 'Kanit', sans-serif;
        }

        h1 {
            color: white;
        }

        .card-footer {
            background-color: #f8f9fa;
        }
    </style>
</head>

<body>

    <?php require_once 'include/navbar.php'; ?>

    <div class="container p-4">
        <h1>หน้าจอค้นหาพนักงาน</h1>

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
                                    dropdown_db($pdo, "cond_pid", "tb_employees", "i_EmployeeID", "c_LastName", $param_pid);
                                    ?>
                                </div>
                                <div class="col-2 d-grid">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-search"></i> ค้นหาข้อมูล
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
            <div class="card-header">รายชื่อพนักงาน</div>
            <div class="card-body">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>รหัสพนักงาน</th>
                            <th>นามสกุล</th>
                            <th>ชื่อ</th>
                            <th>วันเกิด</th>
                            <th>แก้ไข</th>
                            <th>ลบ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($employees)): ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted">ไม่พบข้อมูล</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($employees as $emp): ?>
                                <tr>
                                    <td><?= $emp['eid']; ?></td>
                                    <td><?= htmlspecialchars($emp['lastname']); ?></td>
                                    <td><?= htmlspecialchars($emp['firstname']); ?></td>
                                    <td><?= htmlspecialchars($emp['birthdate']); ?></td>
                                    <td>
                                        <form action="./crud/db_employees_edit.php" method="POST">
                                            <input type="hidden" name="eid" value="<?= $emp['eid']; ?>">
                                            <button type="submit" class="btn btn-warning text-white bi bi-pen fs-6"></button>
                                        </form>
                                    </td>
                                    <td>
                                        <form action="./crud/db_employees_delete.php" method="POST">
                                            <input type="hidden" name="eid" value="<?= $emp['eid']; ?>">
                                            <button type="submit" class="btn btn-danger bi bi-trash fs-6"></button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <?php if ($totalPages > 1): ?>
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-end">
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
                                echo '<li class="page-item' . $active . '"><a class="page-link text-primary" href="' . $href . '">' . $p . '</a></li>';
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