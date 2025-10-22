<?php
include_once 'include/connDB.php';
include_once 'include/elementMod.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category Document</title>

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
        function EditData(cid) {
            console.log("Edit Category ID : " + cid);
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

    <?php require_once 'include/navbar.php';

    $param_catid = isset($_GET['cond_catid']) && $_GET['cond_catid'] !== '' ? $_GET['cond_catid'] : '';

    $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
    $pageSize = 10;
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

    $sql = "SELECT tb_categories.i_CategoryID as cid, tb_categories.c_CategoryName as cname, tb_categories.c_Description as cdesc FROM tb_categories WHERE 1=1";
    $params = [];
    if ($param_catid !== '') {
        $sql .= " AND tb_categories.i_CategoryID = :param_catid";
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
                    <a class="btn" data-bs-toggle="collapse" href="#collapseOne">
                        ตัวกรองการค้นหา
                    </a>
                </div>
                <div id="collapseOne" class="collapse show" data-bs-parent="#accordion">
                    <div class="card-body">
                        <form action="" method="POST">
                            <div class="row ">
                                <div class="col-10">
                                    <?php
                                    dropdown_db($pdo, "cond_catid", "tb_categories", "i_CategoryID", "c_CategoryName", $param_catid);
                                    ?>
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

            <p></p>
        </div>
        <div class="card">
            <div class="card-header">รายการหมวดหมู่สินค้าทั้งหมด</div>
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Category ID</th>
                            <th>Category Name</th>
                            <th>Description</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($categories as $category) { ?>
                            <tr>
                                <td><?php echo $category['cid']; ?></td>
                                <td><?php echo $category['cname']; ?></td>
                                <td><?php echo $category['cdesc']; ?></td>
                                <td>
                                    <form action="./crud/db_categories_edit.php" method="POST">
                                        <input type="hidden" name="cid" value="<?php echo $category['cid']; ?>">
                                        <button onclick="EditData(<?php echo $category['cid']; ?>)" type="button"
                                            class="btn btn-warning text-white bi bi-pen fs-6"></button>
                                    </form>
                                </td>
                                <td>
                                    <form action="./crud/db_categories_delete.php" method="POST">
                                        <input type="hidden" name="cid" value="<?php echo $category['cid']; ?>">
                                        <button type="submit" class="btn btn-danger bi bi-trash fs-6"></button>
                                    </form>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <ul class="pagination justify-content-end">

                    <!-- ปุ่ม Previous -->
                    <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
                        <a class="page-link text-black"
                            href="?<?php echo http_build_query(array_merge($_GET, ['page' => max(1, $page - 1)])); ?>">
                            Previous
                        </a>
                    </li>

                    <!-- หมายเลขหน้า -->
                    <?php
                    $queryBase = $_GET;
                    for ($p = 1; $p <= $totalPages; $p++) {
                        $queryBase['page'] = $p;
                        $href = '?' . http_build_query($queryBase);
                        $active = ($p == $page) ? ' active' : '';
                        echo "<li class=\"page-item$active\"><a class=\"page-link text-black$active\" href=\"$href\">$p</a></li>";
                    }
                    ?>

                    <!-- ปุ่ม Next -->
                    <li class="page-item <?php echo ($page >= $totalPages) ? 'disabled' : ''; ?>">
                        <a class="page-link text-black"
                            href="?<?php echo http_build_query(array_merge($_GET, ['page' => min($totalPages, $page + 1)])); ?>">
                            Next
                        </a>
                    </li>

                </ul>
            </div>
        </div>
    </div>

</body>

</html>