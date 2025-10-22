<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include_once 'include/connDB.php';
include_once 'include/elementMod.php'; 


$param_pid = isset($_POST['cond_pid']) && $_POST['cond_pid'] !== '' ? $_POST['cond_pid'] : '';

$sql = "SELECT i_EmployeeID as eid, c_LastName as lastname, c_FirstName as firstname, c_BirthDate as birthdate, c_Photo as photo, c_Notes as notes
        FROM tb_employees";

$params = [];

if (!empty($param_pid)) {
    $sql .= " WHERE i_EmployeeID = :param_pid";
    $params[':param_pid'] = $param_pid;
}

$sql .= " ORDER BY i_EmployeeID ASC";


$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$employees = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ค้นหาพนักงาน</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
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
                        <form action="" method="POST">
                            <div class="row">
                                <div class="col-10">
                                    <?php
                                    // use cond_pid so the edit page expecting 'pid' matches
                                    dropdown_db($pdo, "cond_pid", "tb_employees", "i_EmployeeID", "c_LastName", $param_pid);
                                    ?>
                                </div>
                                <div class="col-2 d-grid"> <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i> ค้นหาข้อมูล</button>
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
                    <thead>
                        <tr>
                            <th>Employee ID</th>
                            <th>Last Name</th>
                            <th>First Name</th>
                            <th>Birth Date</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($employees as $emp) { ?>
                            <tr>
                                <td><?php echo $emp['eid']; ?></td>
                                <td><?php echo htmlspecialchars($emp['lastname']); ?></td>
                                <td><?php echo htmlspecialchars($emp['firstname']); ?></td>
                                <td><?php echo htmlspecialchars($emp['birthdate']); ?></td>
                                <td>
                                    <form action="./crud/db_employees_edit.php" method="POST">
                                        <input type="hidden" name="eid" value="<?php echo $emp['eid']; ?>">
                                        <button type="submit" class="btn btn-warning text-white bi bi-pen fs-6"></button>
                                    </form>
                                </td>
                                <td>
                                    <form action="./crud/db_employees_delete.php" method="POST">
                                        <input type="hidden" name="eid" value="<?php echo $emp['eid']; ?>">
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
                    <li class="page-item"><a class="page-link text-black " href="#">Previous</a></li>
                    <li class="page-item"><a class="page-link text-black active" href="#">1</a></li>
                    <li class="page-item"><a class="page-link text-black" href="#">2</a></li>
                    <li class="page-item"><a class="page-link text-black" href="#">3</a></li>
                    <li class="page-item"><a class="page-link text-black" href="#">Next</a></li>
                </ul>
            </div>
        </div>
    </div>

</body>

</html>